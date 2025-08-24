package repositories

import models.{Stock, Stocks, Products}
import models.dto.LowStockAlert
import slick.jdbc.MySQLProfile.api._
import scala.concurrent.{ExecutionContext, Future}
import javax.inject.{Inject, Singleton}
import play.api.db.slick.DatabaseConfigProvider

@Singleton
class StockRepository @Inject()(dbConfigProvider: DatabaseConfigProvider)(implicit ec: ExecutionContext) {
  private val dbConfig = dbConfigProvider.get[slick.jdbc.JdbcProfile]
  private val db = dbConfig.db
  private val stocks = TableQuery[Stocks]
  private val products = TableQuery[Products]

  def findAll(limit: Int = 100, offset: Int = 0): Future[Seq[Stock]] = {
    db.run(stocks.drop(offset).take(limit).result)
  }

  def findById(id: Long): Future[Option[Stock]] = {
    db.run(stocks.filter(_.id === id).result.headOption)
  }

  def findByProductId(productId: Long): Future[Option[Stock]] = {
    db.run(stocks.filter(_.productId === productId).result.headOption)
  }

  def findLowStock(): Future[Seq[LowStockAlert]] = {
    val query = for {
      (stock, product) <- stocks
        .filter(s => s.quantity <= s.minimumStock)
        .join(products).on(_.productId === _.id)
    } yield (stock, product)

    db.run(query.result).map { results =>
      results.map { case (stock, product) =>
        LowStockAlert(
          productId = product.id.get,
          productName = product.name,
          currentStock = stock.quantity,
          minimumStock = stock.minimumStock
        )
      }
    }
  }

  def getTotalStockValue(): Future[BigDecimal] = {
    val query = for {
      (stock, product) <- stocks.join(products).on(_.productId === _.id)
    } yield (stock.quantity, product.price)

    db.run(query.result).map { results =>
      results.map { case (quantity, price) => quantity * price }.sum
    }
  }

  def count(): Future[Int] = {
    db.run(stocks.length.result)
  }

  def create(stock: Stock): Future[Stock] = {
    val insertQuery = (stocks returning stocks.map(_.id) into ((stock, id) => stock.copy(id = Some(id))))
    db.run(insertQuery += stock)
  }

  def update(stock: Stock): Future[Int] = {
    db.run(stocks.filter(_.id === stock.id).update(stock))
  }

  def updateByProductId(productId: Long, quantity: Int, minimumStock: Int): Future[Int] = {
    db.run(stocks.filter(_.productId === productId)
      .map(s => (s.quantity, s.minimumStock, s.updatedAt))
      .update((quantity, minimumStock, java.time.LocalDateTime.now())))
  }

  def adjustStock(productId: Long, adjustment: Int): Future[Boolean] = {
    val action = for {
      stockOpt <- stocks.filter(_.productId === productId).result.headOption
      result <- stockOpt match {
        case Some(stock) =>
          val newQuantity = stock.quantity + adjustment
          if (newQuantity >= 0) {
            stocks.filter(_.productId === productId)
              .map(s => (s.quantity, s.updatedAt))
              .update((newQuantity, java.time.LocalDateTime.now()))
              .map(_ => true)
          } else {
            DBIO.successful(false) // Cannot have negative stock
          }
        case None => DBIO.successful(false) // Stock record not found
      }
    } yield result

    db.run(action.transactionally)
  }

  def transferStock(fromProductId: Long, toProductId: Long, quantity: Int): Future[Boolean] = {
    val action = for {
      fromStockOpt <- stocks.filter(_.productId === fromProductId).result.headOption
      toStockOpt <- stocks.filter(_.productId === toProductId).result.headOption
      result <- (fromStockOpt, toStockOpt) match {
        case (Some(fromStock), Some(toStock)) =>
          if (fromStock.quantity >= quantity) {
            val now = java.time.LocalDateTime.now()
            val updateFrom = stocks.filter(_.productId === fromProductId)
              .map(s => (s.quantity, s.updatedAt))
              .update((fromStock.quantity - quantity, now))
            val updateTo = stocks.filter(_.productId === toProductId)
              .map(s => (s.quantity, s.updatedAt))
              .update((toStock.quantity + quantity, now))
            
            for {
              _ <- updateFrom
              _ <- updateTo
            } yield true
          } else {
            DBIO.successful(false) // Insufficient stock
          }
        case _ => DBIO.successful(false) // One or both stock records not found
      }
    } yield result

    db.run(action.transactionally)
  }

  def delete(id: Long): Future[Int] = {
    db.run(stocks.filter(_.id === id).delete)
  }

  def deleteByProductId(productId: Long): Future[Int] = {
    db.run(stocks.filter(_.productId === productId).delete)
  }

  def exists(id: Long): Future[Boolean] = {
    db.run(stocks.filter(_.id === id).exists.result)
  }

  def productHasStock(productId: Long): Future[Boolean] = {
    db.run(stocks.filter(_.productId === productId).exists.result)
  }
}