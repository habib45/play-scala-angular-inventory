package controllers

import play.api.mvc._
import play.api.libs.json._
import services.CategoryService
import models.dto.{CategoryCreateRequest, CategoryUpdateRequest}
import models.UserRole
import security.{AuthenticatedRequest, AuthAction, RoleAction}
import utils.GlobalJsonFormats._
import javax.inject.{Inject, Singleton}
import scala.concurrent.{ExecutionContext, Future}
import scala.util.{Try, Success, Failure}

@Singleton
class CategoryController @Inject()(
  cc: ControllerComponents,
  categoryService: CategoryService,
  authAction: AuthAction,
  roleAction: RoleAction
)(implicit ec: ExecutionContext) extends AbstractController(cc) {

  def findAll(limit: Option[Int], offset: Option[Int]): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    val safeLimit = limit.getOrElse(100).min(1000).max(1)
    val safeOffset = offset.getOrElse(0).max(0)
    
    categoryService.findAll(safeLimit, safeOffset).map { categories =>
      Ok(Json.toJson(categories))
    }
  }

  def findById(id: Long): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    categoryService.findById(id).map {
      case Some(category) => Ok(Json.toJson(category))
      case None => NotFound(Json.obj("error" -> "Category not found"))
    }
  }

  def search(q: String, limit: Option[Int], offset: Option[Int]): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    val safeLimit = limit.getOrElse(100).min(1000).max(1)
    val safeOffset = offset.getOrElse(0).max(0)
    
    categoryService.search(q, safeLimit, safeOffset).map { categories =>
      Ok(Json.toJson(categories))
    }
  }

  def count(): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    categoryService.count().map { count =>
      Ok(Json.obj("count" -> count))
    }
  }

  def create(): Action[JsValue] = roleAction(models.UserRole.ADMIN, models.UserRole.MANAGER).async(parse.json) { request: AuthenticatedRequest[JsValue] =>
    request.body.validate[CategoryCreateRequest] match {
      case JsSuccess(createRequest, _) =>
        categoryService.create(createRequest).map {
          case Right(category) => Created(Json.toJson(category))
          case Left(error) => BadRequest(Json.obj("error" -> error))
        }
      case JsError(errors) =>
        Future.successful(BadRequest(Json.obj("error" -> "Invalid request format", "details" -> JsError.toJson(errors))))
    }
  }

  def update(id: Long): Action[JsValue] = roleAction(models.UserRole.ADMIN, models.UserRole.MANAGER).async(parse.json) { request: AuthenticatedRequest[JsValue] =>
    request.body.validate[CategoryUpdateRequest] match {
      case JsSuccess(updateRequest, _) =>
        categoryService.update(id, updateRequest).map {
          case Right(category) => Ok(Json.toJson(category))
          case Left(error) => 
            if (error == "Category not found") NotFound(Json.obj("error" -> error))
            else BadRequest(Json.obj("error" -> error))
        }
      case JsError(errors) =>
        Future.successful(BadRequest(Json.obj("error" -> "Invalid request format", "details" -> JsError.toJson(errors))))
    }
  }

  def delete(id: Long): Action[AnyContent] = roleAction(models.UserRole.ADMIN).async { _: AuthenticatedRequest[AnyContent] =>
    categoryService.delete(id).map {
      case Right(message) => Ok(Json.obj("message" -> message))
      case Left(error) => 
        if (error == "Category not found") NotFound(Json.obj("error" -> error))
        else BadRequest(Json.obj("error" -> error))
    }
  }
}