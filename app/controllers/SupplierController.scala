package controllers

import play.api.mvc._
import play.api.libs.json._
import services.SupplierService
import models.dto.{SupplierCreateRequest, SupplierUpdateRequest}
import models.UserRole
import security.{AuthenticatedRequest, AuthAction, RoleAction}
import javax.inject.{Inject, Singleton}
import scala.concurrent.{ExecutionContext, Future}

@Singleton
class SupplierController @Inject()(
  cc: ControllerComponents,
  supplierService: SupplierService,
  authAction: AuthAction,
  roleAction: RoleAction
)(implicit ec: ExecutionContext) extends AbstractController(cc) {

  def findAll(limit: Option[Int], offset: Option[Int]): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    val safeLimit = limit.getOrElse(100).min(1000).max(1)
    val safeOffset = offset.getOrElse(0).max(0)
    
    supplierService.findAll(safeLimit, safeOffset).map { suppliers =>
      Ok(Json.toJson(suppliers))
    }
  }

  def findById(id: Long): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    supplierService.findById(id).map {
      case Some(supplier) => Ok(Json.toJson(supplier))
      case None => NotFound(Json.obj("error" -> "Supplier not found"))
    }
  }

  def search(q: String, limit: Option[Int], offset: Option[Int]): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    val safeLimit = limit.getOrElse(100).min(1000).max(1)
    val safeOffset = offset.getOrElse(0).max(0)
    
    supplierService.search(q, safeLimit, safeOffset).map { suppliers =>
      Ok(Json.toJson(suppliers))
    }
  }

  def count(): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    supplierService.count().map { count =>
      Ok(Json.obj("count" -> count))
    }
  }

  def create(): Action[JsValue] = roleAction(UserRole.ADMIN, UserRole.MANAGER).async(parse.json) { request: AuthenticatedRequest[JsValue] =>
    request.body.validate[SupplierCreateRequest] match {
      case JsSuccess(createRequest, _) =>
        supplierService.create(createRequest).map {
          case Right(supplier) => Created(Json.toJson(supplier))
          case Left(error) => BadRequest(Json.obj("error" -> error))
        }
      case JsError(errors) =>
        Future.successful(BadRequest(Json.obj("error" -> "Invalid request format", "details" -> JsError.toJson(errors))))
    }
  }

  def update(id: Long): Action[JsValue] = roleAction(UserRole.ADMIN, UserRole.MANAGER).async(parse.json) { request: AuthenticatedRequest[JsValue] =>
    request.body.validate[SupplierUpdateRequest] match {
      case JsSuccess(updateRequest, _) =>
        supplierService.update(id, updateRequest).map {
          case Right(supplier) => Ok(Json.toJson(supplier))
          case Left(error) => 
            if (error == "Supplier not found") NotFound(Json.obj("error" -> error))
            else BadRequest(Json.obj("error" -> error))
        }
      case JsError(errors) =>
        Future.successful(BadRequest(Json.obj("error" -> "Invalid request format", "details" -> JsError.toJson(errors))))
    }
  }

  def delete(id: Long): Action[AnyContent] = roleAction(UserRole.ADMIN).async { _: AuthenticatedRequest[AnyContent] =>
    supplierService.delete(id).map {
      case Right(message) => Ok(Json.obj("message" -> message))
      case Left(error) => 
        if (error == "Supplier not found") NotFound(Json.obj("error" -> error))
        else BadRequest(Json.obj("error" -> error))
    }
  }
}