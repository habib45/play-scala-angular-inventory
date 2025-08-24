package models

import slick.jdbc.MySQLProfile.api._
import java.time.LocalDateTime

case class Stock(
  id: Option[Long] = None,
  productId: Long,
  quantity: Int = 0,
  minimumStock: Int = 0,
  updatedAt: LocalDateTime = LocalDateTime.now()
)

class Stocks(tag: Tag) extends Table[Stock](tag, "stock") {
  def id = column[Long]("id", O.PrimaryKey, O.AutoInc)
  def productId = column[Long]("product_id")
  def quantity = column[Int]("quantity")
  def minimumStock = column[Int]("minimum_stock")
  def updatedAt = column[LocalDateTime]("updated_at")

  def * = (id.?, productId, quantity, minimumStock, updatedAt) <> ((Stock.apply _).tupled, Stock.unapply)

  def product = foreignKey("fk_stock_product", productId, TableQuery[Products])(_.id, onDelete = ForeignKeyAction.Cascade)
  def uniqueProduct = index("unique_product_stock", productId, unique = true)
}