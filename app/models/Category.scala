package models

import slick.jdbc.MySQLProfile.api._
import java.time.LocalDateTime

case class Category(
  id: Option[Long] = None,
  name: String,
  createdAt: LocalDateTime = LocalDateTime.now(),
  updatedAt: LocalDateTime = LocalDateTime.now()
)

class Categories(tag: Tag) extends Table[Category](tag, "categories") {
  def id = column[Long]("id", O.PrimaryKey, O.AutoInc)
  def name = column[String]("name", O.Unique)
  def createdAt = column[LocalDateTime]("created_at")
  def updatedAt = column[LocalDateTime]("updated_at")

  def * = (id.?, name, createdAt, updatedAt) <> ((Category.apply _).tupled, Category.unapply)
}