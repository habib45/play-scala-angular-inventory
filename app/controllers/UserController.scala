package controllers

import play.api.mvc._
import play.api.libs.json._
import services.UserService
import models.dto.{UserCreateRequest, UserUpdateRequest}
import models.UserRole
import security.{AuthenticatedRequest, AuthAction, RoleAction}
import javax.inject.{Inject, Singleton}
import scala.concurrent.{ExecutionContext, Future}

@Singleton
class UserController @Inject()(
  cc: ControllerComponents,
  userService: UserService,
  authAction: AuthAction,
  roleAction: RoleAction
)(implicit ec: ExecutionContext) extends AbstractController(cc) {

  def findAll(limit: Option[Int], offset: Option[Int]): Action[AnyContent] = roleAction(UserRole.ADMIN).async { _: AuthenticatedRequest[AnyContent] =>
    val safeLimit = limit.getOrElse(100).min(1000).max(1)
    val safeOffset = offset.getOrElse(0).max(0)
    
    userService.findAll(safeLimit, safeOffset).map { users =>
      Ok(Json.toJson(users))
    }
  }

  def findById(id: Long): Action[AnyContent] = roleAction(UserRole.ADMIN).async { _: AuthenticatedRequest[AnyContent] =>
    userService.findById(id).map {
      case Some(user) => Ok(Json.toJson(user))
      case None => NotFound(Json.obj("error" -> "User not found"))
    }
  }

  def findByRole(role: String): Action[AnyContent] = roleAction(UserRole.ADMIN).async { _: AuthenticatedRequest[AnyContent] =>
    userService.findByRole(role).map { users =>
      Ok(Json.toJson(users))
    }
  }

  def search(q: String, limit: Option[Int], offset: Option[Int]): Action[AnyContent] = roleAction(UserRole.ADMIN).async { _: AuthenticatedRequest[AnyContent] =>
    val safeLimit = limit.getOrElse(100).min(1000).max(1)
    val safeOffset = offset.getOrElse(0).max(0)
    
    userService.search(q, safeLimit, safeOffset).map { users =>
      Ok(Json.toJson(users))
    }
  }

  def count(): Action[AnyContent] = roleAction(UserRole.ADMIN).async { _: AuthenticatedRequest[AnyContent] =>
    userService.count().map { count =>
      Ok(Json.obj("count" -> count))
    }
  }

  def getCurrentUser(): Action[AnyContent] = authAction.async { request: AuthenticatedRequest[AnyContent] =>
    userService.findById(request.payload.userId).map {
      case Some(user) => Ok(Json.toJson(user))
      case None => NotFound(Json.obj("error" -> "User not found"))
    }
  }

  def create(): Action[JsValue] = roleAction(UserRole.ADMIN).async(parse.json) { request: AuthenticatedRequest[JsValue] =>
    request.body.validate[UserCreateRequest] match {
      case JsSuccess(createRequest, _) =>
        userService.create(createRequest).map {
          case Right(user) => Created(Json.toJson(user))
          case Left(error) => BadRequest(Json.obj("error" -> error))
        }
      case JsError(errors) =>
        Future.successful(BadRequest(Json.obj("error" -> "Invalid request format", "details" -> JsError.toJson(errors))))
    }
  }

  def update(id: Long): Action[JsValue] = roleAction(UserRole.ADMIN).async(parse.json) { request: AuthenticatedRequest[JsValue] =>
    request.body.validate[UserUpdateRequest] match {
      case JsSuccess(updateRequest, _) =>
        userService.update(id, updateRequest).map {
          case Right(user) => Ok(Json.toJson(user))
          case Left(error) => 
            if (error == "User not found") NotFound(Json.obj("error" -> error))
            else BadRequest(Json.obj("error" -> error))
        }
      case JsError(errors) =>
        Future.successful(BadRequest(Json.obj("error" -> "Invalid request format", "details" -> JsError.toJson(errors))))
    }
  }

  def delete(id: Long): Action[AnyContent] = roleAction(UserRole.ADMIN).async { _: AuthenticatedRequest[AnyContent] =>
    userService.delete(id).map {
      case Right(message) => Ok(Json.obj("message" -> message))
      case Left(error) => 
        if (error == "User not found") NotFound(Json.obj("error" -> error))
        else BadRequest(Json.obj("error" -> error))
    }
  }
}