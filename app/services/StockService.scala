package services

import models.Stock
import models.dto.{StockDTO, StockUpdateRequest, StockResponse, LowStockAlert}
import repositories.{StockRepository, ProductRepository}
import javax.inject.{Inject, Singleton}
import scala.concurrent.{ExecutionContext, Future}

@Singleton
class StockService @Inject()(
  stockRepository: StockRepository,
  productRepository: ProductRepository
)(implicit ec: ExecutionContext) {

  def findAll(limit: Int = 100, offset: Int = 0): Future[Seq[StockResponse]] = {
    stockRepository.findAll(limit, offset).map(_.map(StockDTO.fromModel))
  }

  def findById(id: Long): Future[Option[StockResponse]] = {
    stockRepository.findById(id).map(_.map(StockDTO.fromModel))
  }

  def findByProductId(productId: Long): Future[Option[StockResponse]] = {
    stockRepository.findByProductId(productId).map(_.map(StockDTO.fromModel))
  }

  def findLowStock(): Future[Seq[LowStockAlert]] = {
    stockRepository.findLowStock()
  }

  def getTotalStockValue(): Future[BigDecimal] = {
    stockRepository.getTotalStockValue()
  }

  def count(): Future[Int] = {
    stockRepository.count()
  }

  def updateStock(productId: Long, request: StockUpdateRequest): Future[Either[String, StockResponse]] = {
    validateStockUpdate(request).flatMap {
      case Some(error) => Future.successful(Left(error))
      case None =>
        productRepository.exists(productId).flatMap { productExists =>
          if (!productExists) {
            Future.successful(Left("Product not found"))
          } else {
            stockRepository.findByProductId(productId).flatMap {
              case Some(stock) =>
                val updatedStock = StockDTO.updateModel(stock, request)
                stockRepository.update(updatedStock).map { _ =>
                  Right(StockDTO.fromModel(updatedStock))
                }
              case None =>
                // Create new stock record if it doesn't exist
                val newStock = Stock(
                  productId = productId,
                  quantity = request.quantity,
                  minimumStock = request.minimumStock
                )
                stockRepository.create(newStock).map { created =>
                  Right(StockDTO.fromModel(created))
                }
            }
          }
        }
    }
  }

  def adjustStock(productId: Long, adjustment: Int, reason: String = ""): Future[Either[String, String]] = {
    if (adjustment == 0) {
      Future.successful(Left("Adjustment cannot be zero"))
    } else {
      productRepository.exists(productId).flatMap { productExists =>
        if (!productExists) {
          Future.successful(Left("Product not found"))
        } else {
          stockRepository.adjustStock(productId, adjustment).map { success =>
            if (success) {
              val action = if (adjustment > 0) "increased" else "decreased"
              Right(s"Stock $action by ${math.abs(adjustment)} units")
            } else {
              if (adjustment < 0) {
                Left("Insufficient stock for this operation")
              } else {
                Left("Stock adjustment failed")
              }
            }
          }
        }
      }
    }
  }

  def transferStock(fromProductId: Long, toProductId: Long, quantity: Int): Future[Either[String, String]] = {
    if (quantity <= 0) {
      Future.successful(Left("Transfer quantity must be greater than 0"))
    } else if (fromProductId == toProductId) {
      Future.successful(Left("Cannot transfer stock to the same product"))
    } else {
      for {
        fromExists <- productRepository.exists(fromProductId)
        toExists <- productRepository.exists(toProductId)
        result <- if (!fromExists || !toExists) {
          Future.successful(Left("One or both products not found"))
        } else {
          stockRepository.transferStock(fromProductId, toProductId, quantity).map { success =>
            if (success) {
              Right(s"Successfully transferred $quantity units")
            } else {
              Left("Insufficient stock for transfer or transfer failed")
            }
          }
        }
      } yield result
    }
  }

  def getStockReport(): Future[Map[String, Any]] = {
    for {
      totalItems <- stockRepository.count()
      totalValue <- stockRepository.getTotalStockValue()
      lowStockAlerts <- stockRepository.findLowStock()
    } yield Map(
      "totalItems" -> totalItems,
      "totalValue" -> totalValue,
      "lowStockCount" -> lowStockAlerts.length,
      "lowStockAlerts" -> lowStockAlerts
    )
  }

  private def validateStockUpdate(request: StockUpdateRequest): Future[Option[String]] = {
    Future.successful {
      if (request.quantity < 0) {
        Some("Stock quantity cannot be negative")
      } else if (request.minimumStock < 0) {
        Some("Minimum stock cannot be negative")
      } else if (request.quantity > 1000000) {
        Some("Stock quantity cannot exceed 1,000,000")
      } else if (request.minimumStock > 100000) {
        Some("Minimum stock cannot exceed 100,000")
      } else {
        None
      }
    }
  }
}