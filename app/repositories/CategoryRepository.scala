package repositories

import models.Category
import play.api.db.slick.{DatabaseConfigProvider, HasDatabaseConfigProvider}
import slick.jdbc.MySQLProfile
import slick.jdbc.MySQLProfile.api._
import javax.inject.{Inject, Singleton}
import scala.concurrent.{ExecutionContext, Future}

@Singleton
class CategoryRepository @Inject()(
  protected val dbConfigProvider: DatabaseConfigProvider
)(implicit ec: ExecutionContext) extends HasDatabaseConfigProvider[MySQLProfile] {

  import profile.api._

  private val categories = TableQuery[models.Categories]

  def findAll(limit: Int = 100, offset: Int = 0): Future[Seq[Category]] = {
    db.run(categories.drop(offset).take(limit).result)
  }

  def findById(id: Long): Future[Option[Category]] = {
    db.run(categories.filter(_.id === id).result.headOption)
  }

  def search(query: String, limit: Int = 100, offset: Int = 0): Future[Seq[Category]] = {
    val searchQuery = s"%$query%"
    db.run(
      categories
        .filter(_.name like searchQuery)
        .drop(offset)
        .take(limit)
        .result
    )
  }

  def count(): Future[Int] = {
    db.run(categories.length.result)
  }

  def create(category: Category): Future[Category] = {
    db.run(
      (categories returning categories.map(_.id)) += category
    ).map { id =>
      category.copy(id = Some(id))
    }
  }

  def update(category: Category): Future[Int] = {
    db.run(
      categories
        .filter(_.id === category.id)
        .update(category)
    )
  }

  def delete(id: Long): Future[Int] = {
    db.run(categories.filter(_.id === id).delete)
  }

  def exists(id: Long): Future[Boolean] = {
    db.run(categories.filter(_.id === id).exists.result)
  }

  def nameExists(name: String, excludeId: Option[Long] = None): Future[Boolean] = {
    val query = excludeId match {
      case Some(id) => categories.filter(c => c.name === name && c.id =!= id)
      case None => categories.filter(_.name === name)
    }
    db.run(query.exists.result)
  }
}