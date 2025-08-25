package models.dto

import play.api.libs.json._
import models.{Product, ProductWithDetails}
import utils.JsonFormats._
import java.time.LocalDateTime

case class ProductCreateRequest(
  name: String,
  categoryId: Long,
  supplierId: Long,
  price: BigDecimal,
  description: Option[String] = None
)

case class ProductUpdateRequest(
  name: String,
  categoryId: Long,
  supplierId: Long,
  price: BigDecimal,
  description: Option[String] = None
)

case class ProductResponse(
  id: Long,
  name: String,
  categoryId: Long,
  supplierId: Long,
  price: BigDecimal,
  description: Option[String],
  createdAt: LocalDateTime,
  updatedAt: LocalDateTime
)

case class ProductWithDetailsResponse(
  id: Long,
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

object ProductDTO {
  implicit val productCreateRequestFormat: Format[ProductCreateRequest] = Json.format[ProductCreateRequest]
  implicit val productUpdateRequestFormat: Format[ProductUpdateRequest] = Json.format[ProductUpdateRequest]
  implicit val productResponseFormat: Format[ProductResponse] = Json.format[ProductResponse]
  implicit val productWithDetailsResponseFormat: Format[ProductWithDetailsResponse] = Json.format[ProductWithDetailsResponse]

  def fromModel(product: Product): ProductResponse = {
    ProductResponse(
      id = product.id.get,
      name = product.name,
      categoryId = product.categoryId,
      supplierId = product.supplierId,
      price = product.price,
      description = product.description,
      createdAt = product.createdAt,
      updatedAt = product.updatedAt
    )
  }

  def fromModelWithDetails(productWithDetails: ProductWithDetails): ProductWithDetailsResponse = {
    ProductWithDetailsResponse(
      id = productWithDetails.id.get,
      name = productWithDetails.name,
      categoryId = productWithDetails.categoryId,
      categoryName = productWithDetails.categoryName,
      supplierId = productWithDetails.supplierId,
      supplierName = productWithDetails.supplierName,
      price = productWithDetails.price,
      description = productWithDetails.description,
      stockQuantity = productWithDetails.stockQuantity,
      minimumStock = productWithDetails.minimumStock,
      createdAt = productWithDetails.createdAt,
      updatedAt = productWithDetails.updatedAt
    )
  }

  def toModel(request: ProductCreateRequest): Product = {
    Product(
      name = request.name,
      categoryId = request.categoryId,
      supplierId = request.supplierId,
      price = request.price,
      description = request.description
    )
  }

  def updateModel(product: Product, request: ProductUpdateRequest): Product = {
    product.copy(
      name = request.name,
      categoryId = request.categoryId,
      supplierId = request.supplierId,
      price = request.price,
      description = request.description,
      updatedAt = LocalDateTime.now()
    )
  }
}