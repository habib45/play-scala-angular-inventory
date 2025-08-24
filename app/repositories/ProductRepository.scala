package repositories

import models.{Product, Products, ProductWithDetails, Categories, Suppliers, Stocks}
import slick.jdbc.MySQLProfile.api._
import scala.concurrent.{ExecutionContext, Future}
import javax.inject.{Inject, Singleton}
import play.api.db.slick.DatabaseConfigProvider

@Singleton
class ProductRepository @Inject()(dbConfigProvider: DatabaseConfigProvider)(implicit ec: ExecutionContext) {
  private val dbConfig = dbConfigProvider.get[slick.jdbc.JdbcProfile]
  private val db = dbConfig.db
  private val products = TableQuery[Products]
  private val categories = TableQuery[Categories]
  private val suppliers = TableQuery[Suppliers]
  private val stocks = TableQuery[Stocks]

  def findAll(limit: Int = 100, offset: Int = 0): Future[Seq[Product]] = {
    db.run(products.drop(offset).take(limit).result)
  }

  def findAllWithDetails(limit: Int = 100, offset: Int = 0): Future[Seq[ProductWithDetails]] = {
    val query = for {
      ((product, category), supplier) <- products
        .join(categories).on(_.categoryId === _.id)
        .join(suppliers).on(_._1.supplierId === _.id)
      stock <- stocks.filter(_.productId === product.id)
    } yield (product, category, supplier, stock)

    db.run(query.drop(offset).take(limit).result).map { results =>
      results.map { case (product, category, supplier, stock) =>
        ProductWithDetails(
          id = product.id,
          name = product.name,
          categoryId = product.categoryId,
          categoryName = category.name,
          supplierId = product.supplierId,
          supplierName = supplier.name,
          price = product.price,
          description = product.description,
          stockQuantity = stock.quantity,
          minimumStock = stock.minimumStock,
          createdAt = product.createdAt,
          updatedAt = product.updatedAt
        )
      }
    }
  }

  def findById(id: Long): Future[Option[Product]] = {
    db.run(products.filter(_.id === id).result.headOption)
  }

  def findByIdWithDetails(id: Long): Future[Option[ProductWithDetails]] = {
    val query = for {
      ((product, category), supplier) <- products
        .filter(_.id === id)
        .join(categories).on(_.categoryId === _.id)
        .join(suppliers).on(_._1.supplierId === _.id)
      stock <- stocks.filter(_.productId === product.id)
    } yield (product, category, supplier, stock)

    db.run(query.result.headOption).map {
      case Some((product, category, supplier, stock)) =>
        Some(ProductWithDetails(
          id = product.id,
          name = product.name,
          categoryId = product.categoryId,
          categoryName = category.name,
          supplierId = product.supplierId,
          supplierName = supplier.name,
          price = product.price,
          description = product.description,
          stockQuantity = stock.quantity,
          minimumStock = stock.minimumStock,
          createdAt = product.createdAt,
          updatedAt = product.updatedAt
        ))
      case None => None
    }
  }

  def findByCategory(categoryId: Long, limit: Int = 100, offset: Int = 0): Future[Seq[Product]] = {
    db.run(products.filter(_.categoryId === categoryId).drop(offset).take(limit).result)
  }

  def findBySupplier(supplierId: Long, limit: Int = 100, offset: Int = 0): Future[Seq[Product]] = {
    db.run(products.filter(_.supplierId === supplierId).drop(offset).take(limit).result)
  }

  def search(query: String, limit: Int = 100, offset: Int = 0): Future[Seq[ProductWithDetails]] = {
    val searchPattern = s"%$query%"
    val searchQuery = for {
      ((product, category), supplier) <- products
        .filter(p => p.name.like(searchPattern) || p.description.like(searchPattern))
        .join(categories).on(_.categoryId === _.id)
        .join(suppliers).on(_._1.supplierId === _.id)
      stock <- stocks.filter(_.productId === product.id)
    } yield (product, category, supplier, stock)

    db.run(searchQuery.drop(offset).take(limit).result).map { results =>
      results.map { case (product, category, supplier, stock) =>
        ProductWithDetails(
          id = product.id,
          name = product.name,
          categoryId = product.categoryId,
          categoryName = category.name,
          supplierId = product.supplierId,
          supplierName = supplier.name,
          price = product.price,
          description = product.description,
          stockQuantity = stock.quantity,
          minimumStock = stock.minimumStock,
          createdAt = product.createdAt,
          updatedAt = product.updatedAt
        )
      }
    }
  }

  def filterByPriceRange(minPrice: BigDecimal, maxPrice: BigDecimal, limit: Int = 100, offset: Int = 0): Future[Seq[Product]] = {
    db.run(products.filter(p => p.price >= minPrice && p.price <= maxPrice).drop(offset).take(limit).result)
  }

  def count(): Future[Int] = {
    db.run(products.length.result)
  }

  def create(product: Product): Future[Product] = {
    val insertQuery = (products returning products.map(_.id) into ((product, id) => product.copy(id = Some(id))))
    db.run(insertQuery += product)
  }

  def update(product: Product): Future[Int] = {
    db.run(products.filter(_.id === product.id).update(product))
  }

  def delete(id: Long): Future[Int] = {
    db.run(products.filter(_.id === id).delete)
  }

  def exists(id: Long): Future[Boolean] = {
    db.run(products.filter(_.id === id).exists.result)
  }

  def validateReferences(categoryId: Long, supplierId: Long): Future[Boolean] = {
    val categoryExists = categories.filter(_.id === categoryId).exists
    val supplierExists = suppliers.filter(_.id === supplierId).exists
    db.run((categoryExists && supplierExists).result)
  }
}