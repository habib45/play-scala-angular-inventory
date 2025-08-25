package models

import slick.jdbc.MySQLProfile.api._

object UserRole extends Enumeration {
  type UserRole = Value
  val ADMIN, MANAGER, STAFF = Value
}

object UserRoleMapper {
  implicit val userRoleMapper: BaseColumnType[UserRole.UserRole] = MappedColumnType.base[UserRole.UserRole, String](
    e => e.toString,
    s => UserRole.withName(s)
  )
}