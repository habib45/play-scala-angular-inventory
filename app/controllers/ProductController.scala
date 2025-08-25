package controllers

import play.api.mvc._
import play.api.libs.json._
import services.ProductService
import models.dto.{ProductCreateRequest, ProductUpdateRequest}
import models.UserRole
import security.{AuthenticatedRequest, AuthAction, RoleAction}
import utils.GlobalJsonFormats._
import javax.inject.{Inject, Singleton}
import scala.concurrent.{ExecutionContext, Future}
import scala.util.{Try, Success, Failure}

@Singleton
class ProductController @Inject()(
  cc: ControllerComponents,
  productService: ProductService,
  authAction: AuthAction,
  roleAction: RoleAction
)(implicit ec: ExecutionContext) extends AbstractController(cc) {

  def findAll(limit: Option[Int], offset: Option[Int], withDetails: Option[Boolean]): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    val safeLimit = limit.getOrElse(100).min(1000).max(1)
    val safeOffset = offset.getOrElse(0).max(0)
    val includeDetails = withDetails.getOrElse(false)
    
    if (includeDetails) {
      productService.findAllWithDetails(safeLimit, safeOffset).map { products =>
        Ok(Json.toJson(products))
      }
    } else {
      productService.findAll(safeLimit, safeOffset).map { products =>
        Ok(Json.toJson(products))
      }
    }
  }

  def findById(id: Long, withDetails: Option[Boolean]): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    val includeDetails = withDetails.getOrElse(false)
    
    if (includeDetails) {
      productService.findByIdWithDetails(id).map {
        case Some(product) => Ok(Json.toJson(product))
        case None => NotFound(Json.obj("error" -> "Product not found"))
      }
    } else {
      productService.findById(id).map {
        case Some(product) => Ok(Json.toJson(product))
        case None => NotFound(Json.obj("error" -> "Product not found"))
      }
    }
  }

  def findByCategory(categoryId: Long, limit: Option[Int], offset: Option[Int]): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    val safeLimit = limit.getOrElse(100).min(1000).max(1)
    val safeOffset = offset.getOrElse(0).max(0)
    
    productService.findByCategory(categoryId, safeLimit, safeOffset).map { products =>
      Ok(Json.toJson(products))
    }
  }

  def findBySupplier(supplierId: Long, limit: Option[Int], offset: Option[Int]): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    val safeLimit = limit.getOrElse(100).min(1000).max(1)
    val safeOffset = offset.getOrElse(0).max(0)
    
    productService.findBySupplier(supplierId, safeLimit, safeOffset).map { products =>
      Ok(Json.toJson(products))
    }
  }

  def search(q: String, limit: Option[Int], offset: Option[Int]): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    val safeLimit = limit.getOrElse(100).min(1000).max(1)
    val safeOffset = offset.getOrElse(0).max(0)
    
    productService.search(q, safeLimit, safeOffset).map { products =>
      Ok(Json.toJson(products))
    }
  }

  def filterByPriceRange(minPrice: BigDecimal, maxPrice: BigDecimal, limit: Option[Int], offset: Option[Int]): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    val safeLimit = limit.getOrElse(100).min(1000).max(1)
    val safeOffset = offset.getOrElse(0).max(0)
    
    if (minPrice < 0 || maxPrice < 0 || minPrice > maxPrice) {
      Future.successful(BadRequest(Json.obj("error" -> "Invalid price range")))
    } else {
      productService.filterByPriceRange(minPrice, maxPrice, safeLimit, safeOffset).map { products =>
        Ok(Json.toJson(products))
      }
    }
  }

  def count(): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    productService.count().map { count =>
      Ok(Json.obj("count" -> count))
    }
  }

  def create(): Action[JsValue] = roleAction(models.UserRole.ADMIN, models.UserRole.MANAGER).async(parse.json) { request: AuthenticatedRequest[JsValue] =>
    request.body.validate[ProductCreateRequest] match {
      case JsSuccess(createRequest, _) =>
        productService.create(createRequest).map {
          case Right(product) => Created(Json.toJson(product))
          case Left(error) => BadRequest(Json.obj("error" -> error))
        }
      case JsError(errors) =>
        Future.successful(BadRequest(Json.obj("error" -> "Invalid request format", "details" -> JsError.toJson(errors))))
    }
  }

  def update(id: Long): Action[JsValue] = roleAction(models.UserRole.ADMIN, models.UserRole.MANAGER).async(parse.json) { request: AuthenticatedRequest[JsValue] =>
    request.body.validate[ProductUpdateRequest] match {
      case JsSuccess(updateRequest, _) =>
        productService.update(id, updateRequest).map {
          case Right(product) => Ok(Json.toJson(product))
          case Left(error) => 
            if (error == "Product not found") NotFound(Json.obj("error" -> error))
            else BadRequest(Json.obj("error" -> error))
        }
      case JsError(errors) =>
        Future.successful(BadRequest(Json.obj("error" -> "Invalid request format", "details" -> JsError.toJson(errors))))
    }
  }

  def delete(id: Long): Action[AnyContent] = roleAction(models.UserRole.ADMIN).async { _: AuthenticatedRequest[AnyContent] =>
    productService.delete(id).map {
      case Right(message) => Ok(Json.obj("message" -> message))
      case Left(error) => 
        if (error == "Product not found") NotFound(Json.obj("error" -> error))
        else BadRequest(Json.obj("error" -> error))
    }
  }
}