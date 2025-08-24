package models.dto

import play.api.libs.json._
import models.Supplier
import java.time.LocalDateTime

case class SupplierCreateRequest(
  name: String,
  contact: Option[String] = None,
  email: Option[String] = None
)

case class SupplierUpdateRequest(
  name: String,
  contact: Option[String] = None,
  email: Option[String] = None
)

case class SupplierResponse(
  id: Long,
  name: String,
  contact: Option[String],
  email: Option[String],
  createdAt: LocalDateTime,
  updatedAt: LocalDateTime
)

object SupplierDTO {
  implicit val supplierCreateRequestFormat: Format[SupplierCreateRequest] = Json.format[SupplierCreateRequest]
  implicit val supplierUpdateRequestFormat: Format[SupplierUpdateRequest] = Json.format[SupplierUpdateRequest]
  implicit val supplierResponseFormat: Format[SupplierResponse] = Json.format[SupplierResponse]

  def fromModel(supplier: Supplier): SupplierResponse = {
    SupplierResponse(
      id = supplier.id.get,
      name = supplier.name,
      contact = supplier.contact,
      email = supplier.email,
      createdAt = supplier.createdAt,
      updatedAt = supplier.updatedAt
    )
  }

  def toModel(request: SupplierCreateRequest): Supplier = {
    Supplier(
      name = request.name,
      contact = request.contact,
      email = request.email
    )
  }

  def updateModel(supplier: Supplier, request: SupplierUpdateRequest): Supplier = {
    supplier.copy(
      name = request.name,
      contact = request.contact,
      email = request.email,
      updatedAt = LocalDateTime.now()
    )
  }
}