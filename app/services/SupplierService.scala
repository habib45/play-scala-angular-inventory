package services

import models.Supplier
import models.dto.{SupplierDTO, SupplierCreateRequest, SupplierUpdateRequest, SupplierResponse}
import repositories.SupplierRepository
import javax.inject.{Inject, Singleton}
import scala.concurrent.{ExecutionContext, Future}
import scala.util.matching.Regex

@Singleton
class SupplierService @Inject()(
  supplierRepository: SupplierRepository
)(implicit ec: ExecutionContext) {

  private val emailRegex: Regex = """^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$""".r

  def findAll(limit: Int = 100, offset: Int = 0): Future[Seq[SupplierResponse]] = {
    supplierRepository.findAll(limit, offset).map(_.map(SupplierDTO.fromModel))
  }

  def findById(id: Long): Future[Option[SupplierResponse]] = {
    supplierRepository.findById(id).map(_.map(SupplierDTO.fromModel))
  }

  def search(query: String, limit: Int = 100, offset: Int = 0): Future[Seq[SupplierResponse]] = {
    supplierRepository.search(query, limit, offset).map(_.map(SupplierDTO.fromModel))
  }

  def count(): Future[Int] = {
    supplierRepository.count()
  }

  def create(request: SupplierCreateRequest): Future[Either[String, SupplierResponse]] = {
    validateSupplier(request.name, request.contact, request.email).flatMap {
      case Some(error) => Future.successful(Left(error))
      case None =>
        val supplier = SupplierDTO.toModel(request)
        supplierRepository.create(supplier).map { created =>
          Right(SupplierDTO.fromModel(created))
        }
    }
  }

  def update(id: Long, request: SupplierUpdateRequest): Future[Either[String, SupplierResponse]] = {
    validateSupplier(request.name, request.contact, request.email).flatMap {
      case Some(error) => Future.successful(Left(error))
      case None =>
        supplierRepository.findById(id).flatMap {
          case Some(supplier) =>
            val updatedSupplier = SupplierDTO.updateModel(supplier, request)
            supplierRepository.update(updatedSupplier).map { _ =>
              Right(SupplierDTO.fromModel(updatedSupplier))
            }
          case None =>
            Future.successful(Left("Supplier not found"))
        }
    }
  }

  def delete(id: Long): Future[Either[String, String]] = {
    supplierRepository.exists(id).flatMap { exists =>
      if (exists) {
        supplierRepository.delete(id).map { _ =>
          Right("Supplier deleted successfully")
        }
      } else {
        Future.successful(Left("Supplier not found"))
      }
    }
  }

  private def validateSupplier(name: String, contact: Option[String], email: Option[String]): Future[Option[String]] = {
    Future.successful {
      if (name.trim.isEmpty) {
        Some("Supplier name cannot be empty")
      } else if (name.length > 255) {
        Some("Supplier name cannot exceed 255 characters")
      } else if (contact.exists(_.length > 255)) {
        Some("Contact information cannot exceed 255 characters")
      } else if (email.exists(e => e.nonEmpty && !emailRegex.matches(e))) {
        Some("Invalid email format")
      } else if (email.exists(_.length > 255)) {
        Some("Email cannot exceed 255 characters")
      } else {
        None
      }
    }
  }
}