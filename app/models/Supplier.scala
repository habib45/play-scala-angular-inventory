package models

import slick.jdbc.MySQLProfile.api._
import java.time.LocalDateTime

case class Supplier(
  id: Option[Long] = None,
  name: String,
  contact: Option[String] = None,
  email: Option[String] = None,
  createdAt: LocalDateTime = LocalDateTime.now(),
  updatedAt: LocalDateTime = LocalDateTime.now()
)

class Suppliers(tag: Tag) extends Table[Supplier](tag, "suppliers") {
  def id = column[Long]("id", O.PrimaryKey, O.AutoInc)
  def name = column[String]("name")
  def contact = column[Option[String]]("contact")
  def email = column[Option[String]]("email")
  def createdAt = column[LocalDateTime]("created_at")
  def updatedAt = column[LocalDateTime]("updated_at")

  def * = (id.?, name, contact, email, createdAt, updatedAt) <> ((Supplier.apply _).tupled, Supplier.unapply)
}