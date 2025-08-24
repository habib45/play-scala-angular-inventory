package services

import models.{Product, Stock}
import models.dto.{ProductDTO, ProductCreateRequest, ProductUpdateRequest, ProductResponse, ProductWithDetailsResponse}
import repositories.{ProductRepository, StockRepository}
import javax.inject.{Inject, Singleton}
import scala.concurrent.{ExecutionContext, Future}

@Singleton
class ProductService @Inject()(
  productRepository: ProductRepository,
  stockRepository: StockRepository
)(implicit ec: ExecutionContext) {

  def findAll(limit: Int = 100, offset: Int = 0): Future[Seq[ProductResponse]] = {
    productRepository.findAll(limit, offset).map(_.map(ProductDTO.fromModel))
  }

  def findAllWithDetails(limit: Int = 100, offset: Int = 0): Future[Seq[ProductWithDetailsResponse]] = {
    productRepository.findAllWithDetails(limit, offset).map(_.map(ProductDTO.fromModelWithDetails))
  }

  def findById(id: Long): Future[Option[ProductResponse]] = {
    productRepository.findById(id).map(_.map(ProductDTO.fromModel))
  }

  def findByIdWithDetails(id: Long): Future[Option[ProductWithDetailsResponse]] = {
    productRepository.findByIdWithDetails(id).map(_.map(ProductDTO.fromModelWithDetails))
  }

  def findByCategory(categoryId: Long, limit: Int = 100, offset: Int = 0): Future[Seq[ProductResponse]] = {
    productRepository.findByCategory(categoryId, limit, offset).map(_.map(ProductDTO.fromModel))
  }

  def findBySupplier(supplierId: Long, limit: Int = 100, offset: Int = 0): Future[Seq[ProductResponse]] = {
    productRepository.findBySupplier(supplierId, limit, offset).map(_.map(ProductDTO.fromModel))
  }

  def search(query: String, limit: Int = 100, offset: Int = 0): Future[Seq[ProductWithDetailsResponse]] = {
    productRepository.search(query, limit, offset).map(_.map(ProductDTO.fromModelWithDetails))
  }

  def filterByPriceRange(minPrice: BigDecimal, maxPrice: BigDecimal, limit: Int = 100, offset: Int = 0): Future[Seq[ProductResponse]] = {
    productRepository.filterByPriceRange(minPrice, maxPrice, limit, offset).map(_.map(ProductDTO.fromModel))
  }

  def count(): Future[Int] = {
    productRepository.count()
  }

  def create(request: ProductCreateRequest): Future[Either[String, ProductResponse]] = {
    validateProduct(request.name, request.price, request.description).flatMap {
      case Some(error) => Future.successful(Left(error))
      case None =>
        productRepository.validateReferences(request.categoryId, request.supplierId).flatMap { validRefs =>
          if (!validRefs) {
            Future.successful(Left("Invalid category or supplier ID"))
          } else {
            val product = ProductDTO.toModel(request)
            for {
              created <- productRepository.create(product)
              // Create initial stock record
              _ <- stockRepository.create(Stock(productId = created.id.get, quantity = 0, minimumStock = 0))
            } yield Right(ProductDTO.fromModel(created))
          }
        }
    }
  }

  def update(id: Long, request: ProductUpdateRequest): Future[Either[String, ProductResponse]] = {
    validateProduct(request.name, request.price, request.description).flatMap {
      case Some(error) => Future.successful(Left(error))
      case None =>
        productRepository.findById(id).flatMap {
          case Some(product) =>
            productRepository.validateReferences(request.categoryId, request.supplierId).flatMap { validRefs =>
              if (!validRefs) {
                Future.successful(Left("Invalid category or supplier ID"))
              } else {
                val updatedProduct = ProductDTO.updateModel(product, request)
                productRepository.update(updatedProduct).map { _ =>
                  Right(ProductDTO.fromModel(updatedProduct))
                }
              }
            }
          case None =>
            Future.successful(Left("Product not found"))
        }
    }
  }

  def delete(id: Long): Future[Either[String, String]] = {
    productRepository.exists(id).flatMap { exists =>
      if (exists) {
        // Note: Stock will be deleted automatically due to CASCADE constraint
        productRepository.delete(id).map { _ =>
          Right("Product deleted successfully")
        }
      } else {
        Future.successful(Left("Product not found"))
      }
    }
  }

  private def validateProduct(name: String, price: BigDecimal, description: Option[String]): Future[Option[String]] = {
    Future.successful {
      if (name.trim.isEmpty) {
        Some("Product name cannot be empty")
      } else if (name.length > 255) {
        Some("Product name cannot exceed 255 characters")
      } else if (price <= 0) {
        Some("Product price must be greater than 0")
      } else if (price > 999999.99) {
        Some("Product price cannot exceed 999,999.99")
      } else if (description.exists(_.length > 1000)) {
        Some("Product description cannot exceed 1000 characters")
      } else {
        None
      }
    }
  }
}