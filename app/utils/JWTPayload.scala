package utils

import models.UserRole.UserRole

case class JWTPayload(
  userId: Long,
  username: String,
  role: UserRole
)