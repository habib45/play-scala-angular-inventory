package security

import play.api.mvc._
import play.api.libs.json.Json
import utils.{JWTUtil, JWTPayload}
import models.UserRole.UserRole
import javax.inject.{Inject, Singleton}
import scala.concurrent.{ExecutionContext, Future}
import scala.util.{Success, Failure}

case class AuthenticatedRequest[A](payload: JWTPayload, request: Request[A]) extends WrappedRequest[A](request)

@Singleton
class AuthAction @Inject()(
  parser: BodyParsers.Default
)(implicit ec: ExecutionContext) extends ActionBuilder[AuthenticatedRequest, AnyContent] {

  override def executionContext: ExecutionContext = ec
  override def parser: BodyParser[AnyContent] = parser

  override def invokeBlock[A](request: Request[A], block: AuthenticatedRequest[A] => Future[Result]): Future[Result] = {
    request.headers.get("Authorization") match {
      case Some(authHeader) =>
        JWTUtil.extractToken(authHeader) match {
          case Some(token) =>
            JWTUtil.validateToken(token) match {
              case Success(payload) =>
                block(AuthenticatedRequest(payload, request))
              case Failure(_) =>
                Future.successful(Results.Unauthorized(Json.obj("error" -> "Invalid token")))
            }
          case None =>
            Future.successful(Results.Unauthorized(Json.obj("error" -> "Invalid authorization header format")))
        }
      case None =>
        Future.successful(Results.Unauthorized(Json.obj("error" -> "Authorization header required")))
    }
  }
}

@Singleton
class RoleAction @Inject()(
  authAction: AuthAction
)(implicit ec: ExecutionContext) {

  def apply(allowedRoles: UserRole*): ActionBuilder[AuthenticatedRequest, AnyContent] = {
    new ActionBuilder[AuthenticatedRequest, AnyContent] {
      override def executionContext: ExecutionContext = ec
      override def parser: BodyParser[AnyContent] = authAction.parser

      override def invokeBlock[A](request: Request[A], block: AuthenticatedRequest[A] => Future[Result]): Future[Result] = {
        authAction.invokeBlock(request, { authRequest: AuthenticatedRequest[A] =>
          if (allowedRoles.contains(authRequest.payload.role)) {
            block(authRequest)
          } else {
            Future.successful(Results.Forbidden(Json.obj("error" -> "Insufficient permissions")))
          }
        })
      }
    }
  }
}