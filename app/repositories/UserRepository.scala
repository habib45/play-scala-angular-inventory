package repositories

import models.{User, Users, UserRole}
import models.UserRoleMapper._
import slick.jdbc.MySQLProfile.api._
import scala.concurrent.{ExecutionContext, Future}
import javax.inject.{Inject, Singleton}
import play.api.db.slick.DatabaseConfigProvider

@Singleton
class UserRepository @Inject()(dbConfigProvider: DatabaseConfigProvider)(implicit ec: ExecutionContext) {
  private val dbConfig = dbConfigProvider.get[slick.jdbc.JdbcProfile]
  private val db = dbConfig.db
  private val users = TableQuery[Users]

  def findAll(limit: Int = 100, offset: Int = 0): Future[Seq[User]] = {
    db.run(users.drop(offset).take(limit).result)
  }

  def findById(id: Long): Future[Option[User]] = {
    db.run(users.filter(_.id === id).result.headOption)
  }

  def findByUsername(username: String): Future[Option[User]] = {
    db.run(users.filter(_.username === username).result.headOption)
  }

  def findByRole(role: models.UserRole.UserRole): Future[Seq[User]] = {
    db.run(users.filter(_.role === role).result)
  }

  def search(query: String, limit: Int = 100, offset: Int = 0): Future[Seq[User]] = {
    val searchPattern = s"%$query%"
    db.run(users.filter(_.username.like(searchPattern)).drop(offset).take(limit).result)
  }

  def count(): Future[Int] = {
    db.run(users.length.result)
  }

  def create(user: User): Future[User] = {
    val insertQuery = (users returning users.map(_.id) into ((user, id) => user.copy(id = Some(id))))
    db.run(insertQuery += user)
  }

  def update(user: User): Future[Int] = {
    db.run(users.filter(_.id === user.id).update(user))
  }

  def updatePassword(userId: Long, newPasswordHash: String): Future[Int] = {
    db.run(users.filter(_.id === userId).map(_.passwordHash).update(newPasswordHash))
  }

  def delete(id: Long): Future[Int] = {
    db.run(users.filter(_.id === id).delete)
  }

  def exists(id: Long): Future[Boolean] = {
    db.run(users.filter(_.id === id).exists.result)
  }

  def usernameExists(username: String, excludeId: Option[Long] = None): Future[Boolean] = {
    val query = excludeId match {
      case Some(id) => users.filter(u => u.username === username && u.id =!= id)
      case None => users.filter(_.username === username)
    }
    db.run(query.exists.result)
  }
}