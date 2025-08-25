package models

import slick.jdbc.MySQLProfile.api._
import java.time.LocalDateTime

case class User(
  id: Option[Long] = None,
  username: String,
  passwordHash: String,
  role: UserRole.UserRole = UserRole.STAFF,
  createdAt: LocalDateTime = LocalDateTime.now(),
  updatedAt: LocalDateTime = LocalDateTime.now()
)

class Users(tag: Tag) extends Table[User](tag, "users") {
  import UserRoleMapper._

  def id = column[Long]("id", O.PrimaryKey, O.AutoInc)
  def username = column[String]("username", O.Unique)
  def passwordHash = column[String]("password_hash")
  def role = column[UserRole.UserRole]("role")
  def createdAt = column[LocalDateTime]("created_at")
  def updatedAt = column[LocalDateTime]("updated_at")

  def * = (id.?, username, passwordHash, role, createdAt, updatedAt) <> ((User.apply _).tupled, User.unapply)
}