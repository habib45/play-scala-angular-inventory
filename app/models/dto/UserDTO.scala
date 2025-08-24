package models.dto

import play.api.libs.json._
import models.{User, UserRole}
import java.time.LocalDateTime

case class UserCreateRequest(
  username: String,
  password: String,
  role: String
)

case class UserUpdateRequest(
  username: String,
  role: String
)

case class UserResponse(
  id: Long,
  username: String,
  role: String,
  createdAt: LocalDateTime,
  updatedAt: LocalDateTime
)

case class LoginRequest(
  username: String,
  password: String
)

case class LoginResponse(
  token: String,
  user: UserResponse
)

case class ChangePasswordRequest(
  currentPassword: String,
  newPassword: String
)

object UserDTO {
  implicit val userCreateRequestFormat: Format[UserCreateRequest] = Json.format[UserCreateRequest]
  implicit val userUpdateRequestFormat: Format[UserUpdateRequest] = Json.format[UserUpdateRequest]
  implicit val userResponseFormat: Format[UserResponse] = Json.format[UserResponse]
  implicit val loginRequestFormat: Format[LoginRequest] = Json.format[LoginRequest]
  implicit val loginResponseFormat: Format[LoginResponse] = Json.format[LoginResponse]
  implicit val changePasswordRequestFormat: Format[ChangePasswordRequest] = Json.format[ChangePasswordRequest]

  def fromModel(user: User): UserResponse = {
    UserResponse(
      id = user.id.get,
      username = user.username,
      role = user.role.toString,
      createdAt = user.createdAt,
      updatedAt = user.updatedAt
    )
  }

  def toModel(request: UserCreateRequest, passwordHash: String): User = {
    User(
      username = request.username,
      passwordHash = passwordHash,
      role = UserRole.withName(request.role.toUpperCase)
    )
  }

  def updateModel(user: User, request: UserUpdateRequest): User = {
    user.copy(
      username = request.username,
      role = UserRole.withName(request.role.toUpperCase),
      updatedAt = LocalDateTime.now()
    )
  }
}