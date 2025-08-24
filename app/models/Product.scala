package models

import slick.jdbc.MySQLProfile.api._
import java.time.LocalDateTime

case class Product(
  id: Option[Long] = None,
  name: String,
  categoryId: Long,
  supplierId: Long,
  price: BigDecimal,
  description: Option[String] = None,
  createdAt: LocalDateTime = LocalDateTime.now(),
  updatedAt: LocalDateTime = LocalDateTime.now()
)

case class ProductWithDetails(
  id: Option[Long],
  name: String,
  categoryId: Long,
  categoryName: String,
  supplierId: Long,
  supplierName: String,
  price: BigDecimal,
  description: Option[String],
  stockQuantity: Int,
  minimumStock: Int,
  createdAt: LocalDateTime,
  updatedAt: LocalDateTime
)

class Products(tag: Tag) extends Table[Product](tag, "products") {
  def id = column[Long]("id", O.PrimaryKey, O.AutoInc)
  def name = column[String]("name")
  def categoryId = column[Long]("category_id")
  def supplierId = column[Long]("supplier_id")
  def price = column[BigDecimal]("price")
  def description = column[Option[String]]("description")
  def createdAt = column[LocalDateTime]("created_at")
  def updatedAt = column[LocalDateTime]("updated_at")

  def * = (id.?, name, categoryId, supplierId, price, description, createdAt, updatedAt) <> ((Product.apply _).tupled, Product.unapply)

  def category = foreignKey("fk_product_category", categoryId, TableQuery[Categories])(_.id, onDelete = ForeignKeyAction.Cascade)
  def supplier = foreignKey("fk_product_supplier", supplierId, TableQuery[Suppliers])(_.id, onDelete = ForeignKeyAction.Cascade)
}