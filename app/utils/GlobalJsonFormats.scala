package utils

import play.api.libs.json._
import models.dto._
import models.UserRole.UserRole

object GlobalJsonFormats {
  // Import all the DTO formats to make them available globally
  implicit val categoryCreateRequestFormat: Format[CategoryCreateRequest] = Json.format[CategoryCreateRequest]
  implicit val categoryUpdateRequestFormat: Format[CategoryUpdateRequest] = Json.format[CategoryUpdateRequest]
  implicit val categoryResponseFormat: Format[CategoryResponse] = Json.format[CategoryResponse]
  
  implicit val productCreateRequestFormat: Format[ProductCreateRequest] = Json.format[ProductCreateRequest]
  implicit val productUpdateRequestFormat: Format[ProductUpdateRequest] = Json.format[ProductUpdateRequest]
  implicit val productResponseFormat: Format[ProductResponse] = Json.format[ProductResponse]
  implicit val productWithDetailsResponseFormat: Format[ProductWithDetailsResponse] = Json.format[ProductWithDetailsResponse]
  
  implicit val supplierCreateRequestFormat: Format[SupplierCreateRequest] = Json.format[SupplierCreateRequest]
  implicit val supplierUpdateRequestFormat: Format[SupplierUpdateRequest] = Json.format[SupplierUpdateRequest]
  implicit val supplierResponseFormat: Format[SupplierResponse] = Json.format[SupplierResponse]
  
  implicit val stockUpdateRequestFormat: Format[StockUpdateRequest] = Json.format[StockUpdateRequest]
  implicit val stockResponseFormat: Format[StockResponse] = Json.format[StockResponse]
  implicit val lowStockAlertFormat: Format[LowStockAlert] = Json.format[LowStockAlert]
  implicit val stockReportFormat: Format[StockReport] = Json.format[StockReport]
  
  implicit val userCreateRequestFormat: Format[UserCreateRequest] = Json.format[UserCreateRequest]
  implicit val userUpdateRequestFormat: Format[UserUpdateRequest] = Json.format[UserUpdateRequest]
  implicit val userResponseFormat: Format[UserResponse] = Json.format[UserResponse]
  implicit val loginRequestFormat: Format[LoginRequest] = Json.format[LoginRequest]
  implicit val loginResponseFormat: Format[LoginResponse] = Json.format[LoginResponse]
  implicit val changePasswordRequestFormat: Format[ChangePasswordRequest] = Json.format[ChangePasswordRequest]
}