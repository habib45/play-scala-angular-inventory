package models.dto

import play.api.libs.json._
import models.Category
import java.time.LocalDateTime

case class CategoryCreateRequest(name: String)

case class CategoryUpdateRequest(name: String)

case class CategoryResponse(
  id: Long,
  name: String,
  createdAt: LocalDateTime,
  updatedAt: LocalDateTime
)

object CategoryDTO {
  implicit val categoryCreateRequestFormat: Format[CategoryCreateRequest] = Json.format[CategoryCreateRequest]
  implicit val categoryUpdateRequestFormat: Format[CategoryUpdateRequest] = Json.format[CategoryUpdateRequest]
  implicit val categoryResponseFormat: Format[CategoryResponse] = Json.format[CategoryResponse]

  def fromModel(category: Category): CategoryResponse = {
    CategoryResponse(
      id = category.id.get,
      name = category.name,
      createdAt = category.createdAt,
      updatedAt = category.updatedAt
    )
  }

  def toModel(request: CategoryCreateRequest): Category = {
    Category(name = request.name)
  }

  def updateModel(category: Category, request: CategoryUpdateRequest): Category = {
    category.copy(
      name = request.name,
      updatedAt = LocalDateTime.now()
    )
  }
}