package repositories

import models.{Supplier, Suppliers}
import slick.jdbc.MySQLProfile.api._
import scala.concurrent.{ExecutionContext, Future}
import javax.inject.{Inject, Singleton}
import play.api.db.slick.DatabaseConfigProvider

@Singleton
class SupplierRepository @Inject()(dbConfigProvider: DatabaseConfigProvider)(implicit ec: ExecutionContext) {
  private val dbConfig = dbConfigProvider.get[slick.jdbc.JdbcProfile]
  private val db = dbConfig.db
  private val suppliers = TableQuery[Suppliers]

  def findAll(limit: Int = 100, offset: Int = 0): Future[Seq[Supplier]] = {
    db.run(suppliers.drop(offset).take(limit).result)
  }

  def findById(id: Long): Future[Option[Supplier]] = {
    db.run(suppliers.filter(_.id === id).result.headOption)
  }

  def search(query: String, limit: Int = 100, offset: Int = 0): Future[Seq[Supplier]] = {
    val searchPattern = s"%$query%"
    db.run(suppliers.filter(s => 
      s.name.like(searchPattern) || 
      s.contact.like(searchPattern) || 
      s.email.like(searchPattern)
    ).drop(offset).take(limit).result)
  }

  def count(): Future[Int] = {
    db.run(suppliers.length.result)
  }

  def create(supplier: Supplier): Future[Supplier] = {
    val insertQuery = (suppliers returning suppliers.map(_.id) into ((supplier, id) => supplier.copy(id = Some(id))))
    db.run(insertQuery += supplier)
  }

  def update(supplier: Supplier): Future[Int] = {
    db.run(suppliers.filter(_.id === supplier.id).update(supplier))
  }

  def delete(id: Long): Future[Int] = {
    db.run(suppliers.filter(_.id === id).delete)
  }

  def exists(id: Long): Future[Boolean] = {
    db.run(suppliers.filter(_.id === id).exists.result)
  }
}