package services

import models.Category
import models.dto.{CategoryDTO, CategoryCreateRequest, CategoryUpdateRequest, CategoryResponse}
import repositories.CategoryRepository
import javax.inject.{Inject, Singleton}
import scala.concurrent.{ExecutionContext, Future}

@Singleton
class CategoryService @Inject()(
  categoryRepository: CategoryRepository
)(implicit ec: ExecutionContext) {

  def findAll(limit: Int = 100, offset: Int = 0): Future[Seq[CategoryResponse]] = {
    categoryRepository.findAll(limit, offset).map(_.map(CategoryDTO.fromModel))
  }

  def findById(id: Long): Future[Option[CategoryResponse]] = {
    categoryRepository.findById(id).map(_.map(CategoryDTO.fromModel))
  }

  def search(query: String, limit: Int = 100, offset: Int = 0): Future[Seq[CategoryResponse]] = {
    categoryRepository.search(query, limit, offset).map(_.map(CategoryDTO.fromModel))
  }

  def count(): Future[Int] = {
    categoryRepository.count()
  }

  def create(request: CategoryCreateRequest): Future[Either[String, CategoryResponse]] = {
    validateCategoryName(request.name).flatMap {
      case Some(error) => Future.successful(Left(error))
      case None =>
        categoryRepository.nameExists(request.name).flatMap { exists =>
          if (exists) {
            Future.successful(Left("Category name already exists"))
          } else {
            val category = CategoryDTO.toModel(request)
            categoryRepository.create(category).map { created =>
              Right(CategoryDTO.fromModel(created))
            }
          }
        }
    }
  }

  def update(id: Long, request: CategoryUpdateRequest): Future[Either[String, CategoryResponse]] = {
    validateCategoryName(request.name).flatMap {
      case Some(error) => Future.successful(Left(error))
      case None =>
        categoryRepository.findById(id).flatMap {
          case Some(category) =>
            categoryRepository.nameExists(request.name, Some(id)).flatMap { exists =>
              if (exists) {
                Future.successful(Left("Category name already exists"))
              } else {
                val updatedCategory = CategoryDTO.updateModel(category, request)
                categoryRepository.update(updatedCategory).map { _ =>
                  Right(CategoryDTO.fromModel(updatedCategory))
                }
              }
            }
          case None =>
            Future.successful(Left("Category not found"))
        }
    }
  }

  def delete(id: Long): Future[Either[String, String]] = {
    categoryRepository.exists(id).flatMap { exists =>
      if (exists) {
        categoryRepository.delete(id).map { _ =>
          Right("Category deleted successfully")
        }
      } else {
        Future.successful(Left("Category not found"))
      }
    }
  }

  private def validateCategoryName(name: String): Future[Option[String]] = {
    Future.successful {
      if (name.trim.isEmpty) {
        Some("Category name cannot be empty")
      } else if (name.length > 255) {
        Some("Category name cannot exceed 255 characters")
      } else {
        None
      }
    }
  }
}