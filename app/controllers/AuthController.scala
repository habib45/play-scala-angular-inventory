package controllers

import play.api.mvc._
import play.api.libs.json._
import services.UserService
import models.dto.{LoginRequest, LoginResponse, UserDTO}
import utils.{JWTUtil, PasswordUtil}
import utils.GlobalJsonFormats._
import javax.inject.{Inject, Singleton}
import scala.concurrent.{ExecutionContext, Future}

@Singleton
class AuthController @Inject()(
  cc: ControllerComponents,
  userService: UserService
)(implicit ec: ExecutionContext) extends AbstractController(cc) {

  def login(): Action[JsValue] = Action.async(parse.json) { request =>
    request.body.validate[LoginRequest] match {
      case JsSuccess(loginRequest, _) =>
        userService.authenticate(loginRequest.username, loginRequest.password).map {
          case Some(user) =>
            val token = JWTUtil.generateToken(user.id.get, user.username, user.role)
            val response = LoginResponse(token = token, user = UserDTO.fromModel(user))
            Ok(Json.toJson(response))
          case None =>
            Unauthorized(Json.obj("error" -> "Invalid credentials"))
        }
      case JsError(errors) =>
        Future.successful(BadRequest(Json.obj("error" -> "Invalid request format", "details" -> JsError.toJson(errors))))
    }
  }

  def changePassword(): Action[JsValue] = Action.async(parse.json) { request =>
    // TODO: Implement change password functionality
    Future.successful(NotImplemented(Json.obj("error" -> "Not implemented yet")))
  }

  def validateToken(): Action[AnyContent] = Action.async { request =>
    // TODO: Implement token validation
    Future.successful(NotImplemented(Json.obj("error" -> "Not implemented yet")))
  }

  def logout(): Action[AnyContent] = Action.async { request =>
    // TODO: Implement logout functionality
    Future.successful(NotImplemented(Json.obj("error" -> "Not implemented yet")))
  }
}