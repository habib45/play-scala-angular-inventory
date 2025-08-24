// @GENERATOR:play-routes-compiler
// @SOURCE:conf/routes

package router

import play.core.routing._
import play.core.routing.HandlerInvokerFactory._

import play.api.mvc._

import _root_.controllers.Assets.Asset

class Routes(
  override val errorHandler: play.api.http.HttpErrorHandler, 
  // @LINE:7
  AuthController_2: controllers.AuthController,
  // @LINE:13
  UserController_5: controllers.UserController,
  // @LINE:24
  CategoryController_1: controllers.CategoryController,
  // @LINE:33
  SupplierController_0: controllers.SupplierController,
  // @LINE:42
  ProductController_4: controllers.ProductController,
  // @LINE:54
  StockController_3: controllers.StockController,
  // @LINE:66
  Assets_6: controllers.Assets,
  val prefix: String
) extends GeneratedRouter {

  @javax.inject.Inject()
  def this(errorHandler: play.api.http.HttpErrorHandler,
    // @LINE:7
    AuthController_2: controllers.AuthController,
    // @LINE:13
    UserController_5: controllers.UserController,
    // @LINE:24
    CategoryController_1: controllers.CategoryController,
    // @LINE:33
    SupplierController_0: controllers.SupplierController,
    // @LINE:42
    ProductController_4: controllers.ProductController,
    // @LINE:54
    StockController_3: controllers.StockController,
    // @LINE:66
    Assets_6: controllers.Assets
  ) = this(errorHandler, AuthController_2, UserController_5, CategoryController_1, SupplierController_0, ProductController_4, StockController_3, Assets_6, "/")

  def withPrefix(addPrefix: String): Routes = {
    val prefix = play.api.routing.Router.concatPrefix(addPrefix, this.prefix)
    router.RoutesPrefix.setPrefix(prefix)
    new Routes(errorHandler, AuthController_2, UserController_5, CategoryController_1, SupplierController_0, ProductController_4, StockController_3, Assets_6, prefix)
  }

  private[this] val defaultPrefix: String = {
    if (this.prefix.endsWith("/")) "" else "/"
  }

  def documentation = List(
    ("""POST""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/auth/login""", """controllers.AuthController.login()"""),
    ("""POST""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/auth/change-password""", """controllers.AuthController.changePassword()"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/auth/validate""", """controllers.AuthController.validateToken()"""),
    ("""POST""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/auth/logout""", """controllers.AuthController.logout()"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/users""", """controllers.UserController.findAll(limit:Option[Int] ?= None, offset:Option[Int] ?= None)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/users/current""", """controllers.UserController.getCurrentUser()"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/users/count""", """controllers.UserController.count()"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/users/search""", """controllers.UserController.search(q:String, limit:Option[Int] ?= None, offset:Option[Int] ?= None)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/users/role/""" + "$" + """role<[^/]+>""", """controllers.UserController.findByRole(role:String)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/users/""" + "$" + """id<[^/]+>""", """controllers.UserController.findById(id:Long)"""),
    ("""POST""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/users""", """controllers.UserController.create()"""),
    ("""PUT""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/users/""" + "$" + """id<[^/]+>""", """controllers.UserController.update(id:Long)"""),
    ("""DELETE""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/users/""" + "$" + """id<[^/]+>""", """controllers.UserController.delete(id:Long)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/categories""", """controllers.CategoryController.findAll(limit:Option[Int] ?= None, offset:Option[Int] ?= None)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/categories/count""", """controllers.CategoryController.count()"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/categories/search""", """controllers.CategoryController.search(q:String, limit:Option[Int] ?= None, offset:Option[Int] ?= None)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/categories/""" + "$" + """id<[^/]+>""", """controllers.CategoryController.findById(id:Long)"""),
    ("""POST""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/categories""", """controllers.CategoryController.create()"""),
    ("""PUT""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/categories/""" + "$" + """id<[^/]+>""", """controllers.CategoryController.update(id:Long)"""),
    ("""DELETE""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/categories/""" + "$" + """id<[^/]+>""", """controllers.CategoryController.delete(id:Long)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/suppliers""", """controllers.SupplierController.findAll(limit:Option[Int] ?= None, offset:Option[Int] ?= None)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/suppliers/count""", """controllers.SupplierController.count()"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/suppliers/search""", """controllers.SupplierController.search(q:String, limit:Option[Int] ?= None, offset:Option[Int] ?= None)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/suppliers/""" + "$" + """id<[^/]+>""", """controllers.SupplierController.findById(id:Long)"""),
    ("""POST""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/suppliers""", """controllers.SupplierController.create()"""),
    ("""PUT""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/suppliers/""" + "$" + """id<[^/]+>""", """controllers.SupplierController.update(id:Long)"""),
    ("""DELETE""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/suppliers/""" + "$" + """id<[^/]+>""", """controllers.SupplierController.delete(id:Long)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/products""", """controllers.ProductController.findAll(limit:Option[Int] ?= None, offset:Option[Int] ?= None, withDetails:Option[Boolean] ?= None)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/products/count""", """controllers.ProductController.count()"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/products/search""", """controllers.ProductController.search(q:String, limit:Option[Int] ?= None, offset:Option[Int] ?= None)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/products/category/""" + "$" + """categoryId<[^/]+>""", """controllers.ProductController.findByCategory(categoryId:Long, limit:Option[Int] ?= None, offset:Option[Int] ?= None)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/products/supplier/""" + "$" + """supplierId<[^/]+>""", """controllers.ProductController.findBySupplier(supplierId:Long, limit:Option[Int] ?= None, offset:Option[Int] ?= None)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/products/price-range""", """controllers.ProductController.filterByPriceRange(minPrice:BigDecimal, maxPrice:BigDecimal, limit:Option[Int] ?= None, offset:Option[Int] ?= None)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/products/""" + "$" + """id<[^/]+>""", """controllers.ProductController.findById(id:Long, withDetails:Option[Boolean] ?= None)"""),
    ("""POST""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/products""", """controllers.ProductController.create()"""),
    ("""PUT""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/products/""" + "$" + """id<[^/]+>""", """controllers.ProductController.update(id:Long)"""),
    ("""DELETE""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/products/""" + "$" + """id<[^/]+>""", """controllers.ProductController.delete(id:Long)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/stock""", """controllers.StockController.findAll(limit:Option[Int] ?= None, offset:Option[Int] ?= None)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/stock/count""", """controllers.StockController.count()"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/stock/low-stock""", """controllers.StockController.findLowStock()"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/stock/total-value""", """controllers.StockController.getTotalStockValue()"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/stock/report""", """controllers.StockController.getStockReport()"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/stock/product/""" + "$" + """productId<[^/]+>""", """controllers.StockController.findByProductId(productId:Long)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/stock/""" + "$" + """id<[^/]+>""", """controllers.StockController.findById(id:Long)"""),
    ("""PUT""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/stock/product/""" + "$" + """productId<[^/]+>""", """controllers.StockController.updateStock(productId:Long)"""),
    ("""POST""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/stock/adjust/""" + "$" + """productId<[^/]+>""", """controllers.StockController.adjustStock(productId:Long)"""),
    ("""POST""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """api/stock/transfer""", """controllers.StockController.transferStock()"""),
    ("""GET""", this.prefix, """controllers.Assets.at(path:String = "/public", file:String = "index.html")"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """assets/""" + "$" + """file<.+>""", """controllers.Assets.versioned(path:String = "/public", file:Asset)"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """public/""" + "$" + """file<.+>""", """controllers.Assets.at(path:String = "/public", file:String)"""),
    Nil
  ).foldLeft(Seq.empty[(String, String, String)]) { (s,e) => e.asInstanceOf[Any] match {
    case r @ (_,_,_) => s :+ r.asInstanceOf[(String, String, String)]
    case l => s ++ l.asInstanceOf[List[(String, String, String)]]
  }}


  // @LINE:7
  private[this] lazy val controllers_AuthController_login0_route = Route("POST",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/auth/login")))
  )
  private[this] lazy val controllers_AuthController_login0_invoker = createInvoker(
    AuthController_2.login(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.AuthController",
      "login",
      Nil,
      "POST",
      this.prefix + """api/auth/login""",
      """ Authentication routes""",
      Seq()
    )
  )

  // @LINE:8
  private[this] lazy val controllers_AuthController_changePassword1_route = Route("POST",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/auth/change-password")))
  )
  private[this] lazy val controllers_AuthController_changePassword1_invoker = createInvoker(
    AuthController_2.changePassword(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.AuthController",
      "changePassword",
      Nil,
      "POST",
      this.prefix + """api/auth/change-password""",
      """""",
      Seq()
    )
  )

  // @LINE:9
  private[this] lazy val controllers_AuthController_validateToken2_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/auth/validate")))
  )
  private[this] lazy val controllers_AuthController_validateToken2_invoker = createInvoker(
    AuthController_2.validateToken(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.AuthController",
      "validateToken",
      Nil,
      "GET",
      this.prefix + """api/auth/validate""",
      """""",
      Seq()
    )
  )

  // @LINE:10
  private[this] lazy val controllers_AuthController_logout3_route = Route("POST",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/auth/logout")))
  )
  private[this] lazy val controllers_AuthController_logout3_invoker = createInvoker(
    AuthController_2.logout(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.AuthController",
      "logout",
      Nil,
      "POST",
      this.prefix + """api/auth/logout""",
      """""",
      Seq()
    )
  )

  // @LINE:13
  private[this] lazy val controllers_UserController_findAll4_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/users")))
  )
  private[this] lazy val controllers_UserController_findAll4_invoker = createInvoker(
    UserController_5.findAll(fakeValue[Option[Int]], fakeValue[Option[Int]]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.UserController",
      "findAll",
      Seq(classOf[Option[Int]], classOf[Option[Int]]),
      "GET",
      this.prefix + """api/users""",
      """ User management routes (Admin only)""",
      Seq()
    )
  )

  // @LINE:14
  private[this] lazy val controllers_UserController_getCurrentUser5_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/users/current")))
  )
  private[this] lazy val controllers_UserController_getCurrentUser5_invoker = createInvoker(
    UserController_5.getCurrentUser(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.UserController",
      "getCurrentUser",
      Nil,
      "GET",
      this.prefix + """api/users/current""",
      """""",
      Seq()
    )
  )

  // @LINE:15
  private[this] lazy val controllers_UserController_count6_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/users/count")))
  )
  private[this] lazy val controllers_UserController_count6_invoker = createInvoker(
    UserController_5.count(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.UserController",
      "count",
      Nil,
      "GET",
      this.prefix + """api/users/count""",
      """""",
      Seq()
    )
  )

  // @LINE:16
  private[this] lazy val controllers_UserController_search7_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/users/search")))
  )
  private[this] lazy val controllers_UserController_search7_invoker = createInvoker(
    UserController_5.search(fakeValue[String], fakeValue[Option[Int]], fakeValue[Option[Int]]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.UserController",
      "search",
      Seq(classOf[String], classOf[Option[Int]], classOf[Option[Int]]),
      "GET",
      this.prefix + """api/users/search""",
      """""",
      Seq()
    )
  )

  // @LINE:17
  private[this] lazy val controllers_UserController_findByRole8_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/users/role/"), DynamicPart("role", """[^/]+""",true)))
  )
  private[this] lazy val controllers_UserController_findByRole8_invoker = createInvoker(
    UserController_5.findByRole(fakeValue[String]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.UserController",
      "findByRole",
      Seq(classOf[String]),
      "GET",
      this.prefix + """api/users/role/""" + "$" + """role<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:18
  private[this] lazy val controllers_UserController_findById9_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/users/"), DynamicPart("id", """[^/]+""",true)))
  )
  private[this] lazy val controllers_UserController_findById9_invoker = createInvoker(
    UserController_5.findById(fakeValue[Long]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.UserController",
      "findById",
      Seq(classOf[Long]),
      "GET",
      this.prefix + """api/users/""" + "$" + """id<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:19
  private[this] lazy val controllers_UserController_create10_route = Route("POST",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/users")))
  )
  private[this] lazy val controllers_UserController_create10_invoker = createInvoker(
    UserController_5.create(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.UserController",
      "create",
      Nil,
      "POST",
      this.prefix + """api/users""",
      """""",
      Seq()
    )
  )

  // @LINE:20
  private[this] lazy val controllers_UserController_update11_route = Route("PUT",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/users/"), DynamicPart("id", """[^/]+""",true)))
  )
  private[this] lazy val controllers_UserController_update11_invoker = createInvoker(
    UserController_5.update(fakeValue[Long]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.UserController",
      "update",
      Seq(classOf[Long]),
      "PUT",
      this.prefix + """api/users/""" + "$" + """id<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:21
  private[this] lazy val controllers_UserController_delete12_route = Route("DELETE",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/users/"), DynamicPart("id", """[^/]+""",true)))
  )
  private[this] lazy val controllers_UserController_delete12_invoker = createInvoker(
    UserController_5.delete(fakeValue[Long]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.UserController",
      "delete",
      Seq(classOf[Long]),
      "DELETE",
      this.prefix + """api/users/""" + "$" + """id<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:24
  private[this] lazy val controllers_CategoryController_findAll13_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/categories")))
  )
  private[this] lazy val controllers_CategoryController_findAll13_invoker = createInvoker(
    CategoryController_1.findAll(fakeValue[Option[Int]], fakeValue[Option[Int]]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.CategoryController",
      "findAll",
      Seq(classOf[Option[Int]], classOf[Option[Int]]),
      "GET",
      this.prefix + """api/categories""",
      """ Category routes""",
      Seq()
    )
  )

  // @LINE:25
  private[this] lazy val controllers_CategoryController_count14_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/categories/count")))
  )
  private[this] lazy val controllers_CategoryController_count14_invoker = createInvoker(
    CategoryController_1.count(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.CategoryController",
      "count",
      Nil,
      "GET",
      this.prefix + """api/categories/count""",
      """""",
      Seq()
    )
  )

  // @LINE:26
  private[this] lazy val controllers_CategoryController_search15_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/categories/search")))
  )
  private[this] lazy val controllers_CategoryController_search15_invoker = createInvoker(
    CategoryController_1.search(fakeValue[String], fakeValue[Option[Int]], fakeValue[Option[Int]]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.CategoryController",
      "search",
      Seq(classOf[String], classOf[Option[Int]], classOf[Option[Int]]),
      "GET",
      this.prefix + """api/categories/search""",
      """""",
      Seq()
    )
  )

  // @LINE:27
  private[this] lazy val controllers_CategoryController_findById16_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/categories/"), DynamicPart("id", """[^/]+""",true)))
  )
  private[this] lazy val controllers_CategoryController_findById16_invoker = createInvoker(
    CategoryController_1.findById(fakeValue[Long]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.CategoryController",
      "findById",
      Seq(classOf[Long]),
      "GET",
      this.prefix + """api/categories/""" + "$" + """id<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:28
  private[this] lazy val controllers_CategoryController_create17_route = Route("POST",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/categories")))
  )
  private[this] lazy val controllers_CategoryController_create17_invoker = createInvoker(
    CategoryController_1.create(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.CategoryController",
      "create",
      Nil,
      "POST",
      this.prefix + """api/categories""",
      """""",
      Seq()
    )
  )

  // @LINE:29
  private[this] lazy val controllers_CategoryController_update18_route = Route("PUT",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/categories/"), DynamicPart("id", """[^/]+""",true)))
  )
  private[this] lazy val controllers_CategoryController_update18_invoker = createInvoker(
    CategoryController_1.update(fakeValue[Long]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.CategoryController",
      "update",
      Seq(classOf[Long]),
      "PUT",
      this.prefix + """api/categories/""" + "$" + """id<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:30
  private[this] lazy val controllers_CategoryController_delete19_route = Route("DELETE",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/categories/"), DynamicPart("id", """[^/]+""",true)))
  )
  private[this] lazy val controllers_CategoryController_delete19_invoker = createInvoker(
    CategoryController_1.delete(fakeValue[Long]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.CategoryController",
      "delete",
      Seq(classOf[Long]),
      "DELETE",
      this.prefix + """api/categories/""" + "$" + """id<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:33
  private[this] lazy val controllers_SupplierController_findAll20_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/suppliers")))
  )
  private[this] lazy val controllers_SupplierController_findAll20_invoker = createInvoker(
    SupplierController_0.findAll(fakeValue[Option[Int]], fakeValue[Option[Int]]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.SupplierController",
      "findAll",
      Seq(classOf[Option[Int]], classOf[Option[Int]]),
      "GET",
      this.prefix + """api/suppliers""",
      """ Supplier routes""",
      Seq()
    )
  )

  // @LINE:34
  private[this] lazy val controllers_SupplierController_count21_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/suppliers/count")))
  )
  private[this] lazy val controllers_SupplierController_count21_invoker = createInvoker(
    SupplierController_0.count(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.SupplierController",
      "count",
      Nil,
      "GET",
      this.prefix + """api/suppliers/count""",
      """""",
      Seq()
    )
  )

  // @LINE:35
  private[this] lazy val controllers_SupplierController_search22_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/suppliers/search")))
  )
  private[this] lazy val controllers_SupplierController_search22_invoker = createInvoker(
    SupplierController_0.search(fakeValue[String], fakeValue[Option[Int]], fakeValue[Option[Int]]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.SupplierController",
      "search",
      Seq(classOf[String], classOf[Option[Int]], classOf[Option[Int]]),
      "GET",
      this.prefix + """api/suppliers/search""",
      """""",
      Seq()
    )
  )

  // @LINE:36
  private[this] lazy val controllers_SupplierController_findById23_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/suppliers/"), DynamicPart("id", """[^/]+""",true)))
  )
  private[this] lazy val controllers_SupplierController_findById23_invoker = createInvoker(
    SupplierController_0.findById(fakeValue[Long]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.SupplierController",
      "findById",
      Seq(classOf[Long]),
      "GET",
      this.prefix + """api/suppliers/""" + "$" + """id<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:37
  private[this] lazy val controllers_SupplierController_create24_route = Route("POST",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/suppliers")))
  )
  private[this] lazy val controllers_SupplierController_create24_invoker = createInvoker(
    SupplierController_0.create(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.SupplierController",
      "create",
      Nil,
      "POST",
      this.prefix + """api/suppliers""",
      """""",
      Seq()
    )
  )

  // @LINE:38
  private[this] lazy val controllers_SupplierController_update25_route = Route("PUT",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/suppliers/"), DynamicPart("id", """[^/]+""",true)))
  )
  private[this] lazy val controllers_SupplierController_update25_invoker = createInvoker(
    SupplierController_0.update(fakeValue[Long]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.SupplierController",
      "update",
      Seq(classOf[Long]),
      "PUT",
      this.prefix + """api/suppliers/""" + "$" + """id<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:39
  private[this] lazy val controllers_SupplierController_delete26_route = Route("DELETE",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/suppliers/"), DynamicPart("id", """[^/]+""",true)))
  )
  private[this] lazy val controllers_SupplierController_delete26_invoker = createInvoker(
    SupplierController_0.delete(fakeValue[Long]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.SupplierController",
      "delete",
      Seq(classOf[Long]),
      "DELETE",
      this.prefix + """api/suppliers/""" + "$" + """id<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:42
  private[this] lazy val controllers_ProductController_findAll27_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/products")))
  )
  private[this] lazy val controllers_ProductController_findAll27_invoker = createInvoker(
    ProductController_4.findAll(fakeValue[Option[Int]], fakeValue[Option[Int]], fakeValue[Option[Boolean]]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.ProductController",
      "findAll",
      Seq(classOf[Option[Int]], classOf[Option[Int]], classOf[Option[Boolean]]),
      "GET",
      this.prefix + """api/products""",
      """ Product routes""",
      Seq()
    )
  )

  // @LINE:43
  private[this] lazy val controllers_ProductController_count28_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/products/count")))
  )
  private[this] lazy val controllers_ProductController_count28_invoker = createInvoker(
    ProductController_4.count(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.ProductController",
      "count",
      Nil,
      "GET",
      this.prefix + """api/products/count""",
      """""",
      Seq()
    )
  )

  // @LINE:44
  private[this] lazy val controllers_ProductController_search29_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/products/search")))
  )
  private[this] lazy val controllers_ProductController_search29_invoker = createInvoker(
    ProductController_4.search(fakeValue[String], fakeValue[Option[Int]], fakeValue[Option[Int]]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.ProductController",
      "search",
      Seq(classOf[String], classOf[Option[Int]], classOf[Option[Int]]),
      "GET",
      this.prefix + """api/products/search""",
      """""",
      Seq()
    )
  )

  // @LINE:45
  private[this] lazy val controllers_ProductController_findByCategory30_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/products/category/"), DynamicPart("categoryId", """[^/]+""",true)))
  )
  private[this] lazy val controllers_ProductController_findByCategory30_invoker = createInvoker(
    ProductController_4.findByCategory(fakeValue[Long], fakeValue[Option[Int]], fakeValue[Option[Int]]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.ProductController",
      "findByCategory",
      Seq(classOf[Long], classOf[Option[Int]], classOf[Option[Int]]),
      "GET",
      this.prefix + """api/products/category/""" + "$" + """categoryId<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:46
  private[this] lazy val controllers_ProductController_findBySupplier31_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/products/supplier/"), DynamicPart("supplierId", """[^/]+""",true)))
  )
  private[this] lazy val controllers_ProductController_findBySupplier31_invoker = createInvoker(
    ProductController_4.findBySupplier(fakeValue[Long], fakeValue[Option[Int]], fakeValue[Option[Int]]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.ProductController",
      "findBySupplier",
      Seq(classOf[Long], classOf[Option[Int]], classOf[Option[Int]]),
      "GET",
      this.prefix + """api/products/supplier/""" + "$" + """supplierId<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:47
  private[this] lazy val controllers_ProductController_filterByPriceRange32_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/products/price-range")))
  )
  private[this] lazy val controllers_ProductController_filterByPriceRange32_invoker = createInvoker(
    ProductController_4.filterByPriceRange(fakeValue[BigDecimal], fakeValue[BigDecimal], fakeValue[Option[Int]], fakeValue[Option[Int]]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.ProductController",
      "filterByPriceRange",
      Seq(classOf[BigDecimal], classOf[BigDecimal], classOf[Option[Int]], classOf[Option[Int]]),
      "GET",
      this.prefix + """api/products/price-range""",
      """""",
      Seq()
    )
  )

  // @LINE:48
  private[this] lazy val controllers_ProductController_findById33_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/products/"), DynamicPart("id", """[^/]+""",true)))
  )
  private[this] lazy val controllers_ProductController_findById33_invoker = createInvoker(
    ProductController_4.findById(fakeValue[Long], fakeValue[Option[Boolean]]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.ProductController",
      "findById",
      Seq(classOf[Long], classOf[Option[Boolean]]),
      "GET",
      this.prefix + """api/products/""" + "$" + """id<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:49
  private[this] lazy val controllers_ProductController_create34_route = Route("POST",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/products")))
  )
  private[this] lazy val controllers_ProductController_create34_invoker = createInvoker(
    ProductController_4.create(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.ProductController",
      "create",
      Nil,
      "POST",
      this.prefix + """api/products""",
      """""",
      Seq()
    )
  )

  // @LINE:50
  private[this] lazy val controllers_ProductController_update35_route = Route("PUT",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/products/"), DynamicPart("id", """[^/]+""",true)))
  )
  private[this] lazy val controllers_ProductController_update35_invoker = createInvoker(
    ProductController_4.update(fakeValue[Long]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.ProductController",
      "update",
      Seq(classOf[Long]),
      "PUT",
      this.prefix + """api/products/""" + "$" + """id<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:51
  private[this] lazy val controllers_ProductController_delete36_route = Route("DELETE",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/products/"), DynamicPart("id", """[^/]+""",true)))
  )
  private[this] lazy val controllers_ProductController_delete36_invoker = createInvoker(
    ProductController_4.delete(fakeValue[Long]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.ProductController",
      "delete",
      Seq(classOf[Long]),
      "DELETE",
      this.prefix + """api/products/""" + "$" + """id<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:54
  private[this] lazy val controllers_StockController_findAll37_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/stock")))
  )
  private[this] lazy val controllers_StockController_findAll37_invoker = createInvoker(
    StockController_3.findAll(fakeValue[Option[Int]], fakeValue[Option[Int]]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.StockController",
      "findAll",
      Seq(classOf[Option[Int]], classOf[Option[Int]]),
      "GET",
      this.prefix + """api/stock""",
      """ Stock routes""",
      Seq()
    )
  )

  // @LINE:55
  private[this] lazy val controllers_StockController_count38_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/stock/count")))
  )
  private[this] lazy val controllers_StockController_count38_invoker = createInvoker(
    StockController_3.count(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.StockController",
      "count",
      Nil,
      "GET",
      this.prefix + """api/stock/count""",
      """""",
      Seq()
    )
  )

  // @LINE:56
  private[this] lazy val controllers_StockController_findLowStock39_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/stock/low-stock")))
  )
  private[this] lazy val controllers_StockController_findLowStock39_invoker = createInvoker(
    StockController_3.findLowStock(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.StockController",
      "findLowStock",
      Nil,
      "GET",
      this.prefix + """api/stock/low-stock""",
      """""",
      Seq()
    )
  )

  // @LINE:57
  private[this] lazy val controllers_StockController_getTotalStockValue40_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/stock/total-value")))
  )
  private[this] lazy val controllers_StockController_getTotalStockValue40_invoker = createInvoker(
    StockController_3.getTotalStockValue(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.StockController",
      "getTotalStockValue",
      Nil,
      "GET",
      this.prefix + """api/stock/total-value""",
      """""",
      Seq()
    )
  )

  // @LINE:58
  private[this] lazy val controllers_StockController_getStockReport41_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/stock/report")))
  )
  private[this] lazy val controllers_StockController_getStockReport41_invoker = createInvoker(
    StockController_3.getStockReport(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.StockController",
      "getStockReport",
      Nil,
      "GET",
      this.prefix + """api/stock/report""",
      """""",
      Seq()
    )
  )

  // @LINE:59
  private[this] lazy val controllers_StockController_findByProductId42_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/stock/product/"), DynamicPart("productId", """[^/]+""",true)))
  )
  private[this] lazy val controllers_StockController_findByProductId42_invoker = createInvoker(
    StockController_3.findByProductId(fakeValue[Long]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.StockController",
      "findByProductId",
      Seq(classOf[Long]),
      "GET",
      this.prefix + """api/stock/product/""" + "$" + """productId<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:60
  private[this] lazy val controllers_StockController_findById43_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/stock/"), DynamicPart("id", """[^/]+""",true)))
  )
  private[this] lazy val controllers_StockController_findById43_invoker = createInvoker(
    StockController_3.findById(fakeValue[Long]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.StockController",
      "findById",
      Seq(classOf[Long]),
      "GET",
      this.prefix + """api/stock/""" + "$" + """id<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:61
  private[this] lazy val controllers_StockController_updateStock44_route = Route("PUT",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/stock/product/"), DynamicPart("productId", """[^/]+""",true)))
  )
  private[this] lazy val controllers_StockController_updateStock44_invoker = createInvoker(
    StockController_3.updateStock(fakeValue[Long]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.StockController",
      "updateStock",
      Seq(classOf[Long]),
      "PUT",
      this.prefix + """api/stock/product/""" + "$" + """productId<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:62
  private[this] lazy val controllers_StockController_adjustStock45_route = Route("POST",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/stock/adjust/"), DynamicPart("productId", """[^/]+""",true)))
  )
  private[this] lazy val controllers_StockController_adjustStock45_invoker = createInvoker(
    StockController_3.adjustStock(fakeValue[Long]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.StockController",
      "adjustStock",
      Seq(classOf[Long]),
      "POST",
      this.prefix + """api/stock/adjust/""" + "$" + """productId<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:63
  private[this] lazy val controllers_StockController_transferStock46_route = Route("POST",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("api/stock/transfer")))
  )
  private[this] lazy val controllers_StockController_transferStock46_invoker = createInvoker(
    StockController_3.transferStock(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.StockController",
      "transferStock",
      Nil,
      "POST",
      this.prefix + """api/stock/transfer""",
      """""",
      Seq()
    )
  )

  // @LINE:66
  private[this] lazy val controllers_Assets_at47_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix)))
  )
  private[this] lazy val controllers_Assets_at47_invoker = createInvoker(
    Assets_6.at(fakeValue[String], fakeValue[String]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.Assets",
      "at",
      Seq(classOf[String], classOf[String]),
      "GET",
      this.prefix + """""",
      """ Frontend routes (serve AngularJS app)""",
      Seq()
    )
  )

  // @LINE:67
  private[this] lazy val controllers_Assets_versioned48_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("assets/"), DynamicPart("file", """.+""",false)))
  )
  private[this] lazy val controllers_Assets_versioned48_invoker = createInvoker(
    Assets_6.versioned(fakeValue[String], fakeValue[Asset]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.Assets",
      "versioned",
      Seq(classOf[String], classOf[Asset]),
      "GET",
      this.prefix + """assets/""" + "$" + """file<.+>""",
      """""",
      Seq()
    )
  )

  // @LINE:70
  private[this] lazy val controllers_Assets_at49_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("public/"), DynamicPart("file", """.+""",false)))
  )
  private[this] lazy val controllers_Assets_at49_invoker = createInvoker(
    Assets_6.at(fakeValue[String], fakeValue[String]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.Assets",
      "at",
      Seq(classOf[String], classOf[String]),
      "GET",
      this.prefix + """public/""" + "$" + """file<.+>""",
      """ Map static resources from the /public folder to the /assets URL path""",
      Seq()
    )
  )


  def routes: PartialFunction[RequestHeader, Handler] = {
  
    // @LINE:7
    case controllers_AuthController_login0_route(params@_) =>
      call { 
        controllers_AuthController_login0_invoker.call(AuthController_2.login())
      }
  
    // @LINE:8
    case controllers_AuthController_changePassword1_route(params@_) =>
      call { 
        controllers_AuthController_changePassword1_invoker.call(AuthController_2.changePassword())
      }
  
    // @LINE:9
    case controllers_AuthController_validateToken2_route(params@_) =>
      call { 
        controllers_AuthController_validateToken2_invoker.call(AuthController_2.validateToken())
      }
  
    // @LINE:10
    case controllers_AuthController_logout3_route(params@_) =>
      call { 
        controllers_AuthController_logout3_invoker.call(AuthController_2.logout())
      }
  
    // @LINE:13
    case controllers_UserController_findAll4_route(params@_) =>
      call(params.fromQuery[Option[Int]]("limit", Some(None)), params.fromQuery[Option[Int]]("offset", Some(None))) { (limit, offset) =>
        controllers_UserController_findAll4_invoker.call(UserController_5.findAll(limit, offset))
      }
  
    // @LINE:14
    case controllers_UserController_getCurrentUser5_route(params@_) =>
      call { 
        controllers_UserController_getCurrentUser5_invoker.call(UserController_5.getCurrentUser())
      }
  
    // @LINE:15
    case controllers_UserController_count6_route(params@_) =>
      call { 
        controllers_UserController_count6_invoker.call(UserController_5.count())
      }
  
    // @LINE:16
    case controllers_UserController_search7_route(params@_) =>
      call(params.fromQuery[String]("q", None), params.fromQuery[Option[Int]]("limit", Some(None)), params.fromQuery[Option[Int]]("offset", Some(None))) { (q, limit, offset) =>
        controllers_UserController_search7_invoker.call(UserController_5.search(q, limit, offset))
      }
  
    // @LINE:17
    case controllers_UserController_findByRole8_route(params@_) =>
      call(params.fromPath[String]("role", None)) { (role) =>
        controllers_UserController_findByRole8_invoker.call(UserController_5.findByRole(role))
      }
  
    // @LINE:18
    case controllers_UserController_findById9_route(params@_) =>
      call(params.fromPath[Long]("id", None)) { (id) =>
        controllers_UserController_findById9_invoker.call(UserController_5.findById(id))
      }
  
    // @LINE:19
    case controllers_UserController_create10_route(params@_) =>
      call { 
        controllers_UserController_create10_invoker.call(UserController_5.create())
      }
  
    // @LINE:20
    case controllers_UserController_update11_route(params@_) =>
      call(params.fromPath[Long]("id", None)) { (id) =>
        controllers_UserController_update11_invoker.call(UserController_5.update(id))
      }
  
    // @LINE:21
    case controllers_UserController_delete12_route(params@_) =>
      call(params.fromPath[Long]("id", None)) { (id) =>
        controllers_UserController_delete12_invoker.call(UserController_5.delete(id))
      }
  
    // @LINE:24
    case controllers_CategoryController_findAll13_route(params@_) =>
      call(params.fromQuery[Option[Int]]("limit", Some(None)), params.fromQuery[Option[Int]]("offset", Some(None))) { (limit, offset) =>
        controllers_CategoryController_findAll13_invoker.call(CategoryController_1.findAll(limit, offset))
      }
  
    // @LINE:25
    case controllers_CategoryController_count14_route(params@_) =>
      call { 
        controllers_CategoryController_count14_invoker.call(CategoryController_1.count())
      }
  
    // @LINE:26
    case controllers_CategoryController_search15_route(params@_) =>
      call(params.fromQuery[String]("q", None), params.fromQuery[Option[Int]]("limit", Some(None)), params.fromQuery[Option[Int]]("offset", Some(None))) { (q, limit, offset) =>
        controllers_CategoryController_search15_invoker.call(CategoryController_1.search(q, limit, offset))
      }
  
    // @LINE:27
    case controllers_CategoryController_findById16_route(params@_) =>
      call(params.fromPath[Long]("id", None)) { (id) =>
        controllers_CategoryController_findById16_invoker.call(CategoryController_1.findById(id))
      }
  
    // @LINE:28
    case controllers_CategoryController_create17_route(params@_) =>
      call { 
        controllers_CategoryController_create17_invoker.call(CategoryController_1.create())
      }
  
    // @LINE:29
    case controllers_CategoryController_update18_route(params@_) =>
      call(params.fromPath[Long]("id", None)) { (id) =>
        controllers_CategoryController_update18_invoker.call(CategoryController_1.update(id))
      }
  
    // @LINE:30
    case controllers_CategoryController_delete19_route(params@_) =>
      call(params.fromPath[Long]("id", None)) { (id) =>
        controllers_CategoryController_delete19_invoker.call(CategoryController_1.delete(id))
      }
  
    // @LINE:33
    case controllers_SupplierController_findAll20_route(params@_) =>
      call(params.fromQuery[Option[Int]]("limit", Some(None)), params.fromQuery[Option[Int]]("offset", Some(None))) { (limit, offset) =>
        controllers_SupplierController_findAll20_invoker.call(SupplierController_0.findAll(limit, offset))
      }
  
    // @LINE:34
    case controllers_SupplierController_count21_route(params@_) =>
      call { 
        controllers_SupplierController_count21_invoker.call(SupplierController_0.count())
      }
  
    // @LINE:35
    case controllers_SupplierController_search22_route(params@_) =>
      call(params.fromQuery[String]("q", None), params.fromQuery[Option[Int]]("limit", Some(None)), params.fromQuery[Option[Int]]("offset", Some(None))) { (q, limit, offset) =>
        controllers_SupplierController_search22_invoker.call(SupplierController_0.search(q, limit, offset))
      }
  
    // @LINE:36
    case controllers_SupplierController_findById23_route(params@_) =>
      call(params.fromPath[Long]("id", None)) { (id) =>
        controllers_SupplierController_findById23_invoker.call(SupplierController_0.findById(id))
      }
  
    // @LINE:37
    case controllers_SupplierController_create24_route(params@_) =>
      call { 
        controllers_SupplierController_create24_invoker.call(SupplierController_0.create())
      }
  
    // @LINE:38
    case controllers_SupplierController_update25_route(params@_) =>
      call(params.fromPath[Long]("id", None)) { (id) =>
        controllers_SupplierController_update25_invoker.call(SupplierController_0.update(id))
      }
  
    // @LINE:39
    case controllers_SupplierController_delete26_route(params@_) =>
      call(params.fromPath[Long]("id", None)) { (id) =>
        controllers_SupplierController_delete26_invoker.call(SupplierController_0.delete(id))
      }
  
    // @LINE:42
    case controllers_ProductController_findAll27_route(params@_) =>
      call(params.fromQuery[Option[Int]]("limit", Some(None)), params.fromQuery[Option[Int]]("offset", Some(None)), params.fromQuery[Option[Boolean]]("withDetails", Some(None))) { (limit, offset, withDetails) =>
        controllers_ProductController_findAll27_invoker.call(ProductController_4.findAll(limit, offset, withDetails))
      }
  
    // @LINE:43
    case controllers_ProductController_count28_route(params@_) =>
      call { 
        controllers_ProductController_count28_invoker.call(ProductController_4.count())
      }
  
    // @LINE:44
    case controllers_ProductController_search29_route(params@_) =>
      call(params.fromQuery[String]("q", None), params.fromQuery[Option[Int]]("limit", Some(None)), params.fromQuery[Option[Int]]("offset", Some(None))) { (q, limit, offset) =>
        controllers_ProductController_search29_invoker.call(ProductController_4.search(q, limit, offset))
      }
  
    // @LINE:45
    case controllers_ProductController_findByCategory30_route(params@_) =>
      call(params.fromPath[Long]("categoryId", None), params.fromQuery[Option[Int]]("limit", Some(None)), params.fromQuery[Option[Int]]("offset", Some(None))) { (categoryId, limit, offset) =>
        controllers_ProductController_findByCategory30_invoker.call(ProductController_4.findByCategory(categoryId, limit, offset))
      }
  
    // @LINE:46
    case controllers_ProductController_findBySupplier31_route(params@_) =>
      call(params.fromPath[Long]("supplierId", None), params.fromQuery[Option[Int]]("limit", Some(None)), params.fromQuery[Option[Int]]("offset", Some(None))) { (supplierId, limit, offset) =>
        controllers_ProductController_findBySupplier31_invoker.call(ProductController_4.findBySupplier(supplierId, limit, offset))
      }
  
    // @LINE:47
    case controllers_ProductController_filterByPriceRange32_route(params@_) =>
      call(params.fromQuery[BigDecimal]("minPrice", None), params.fromQuery[BigDecimal]("maxPrice", None), params.fromQuery[Option[Int]]("limit", Some(None)), params.fromQuery[Option[Int]]("offset", Some(None))) { (minPrice, maxPrice, limit, offset) =>
        controllers_ProductController_filterByPriceRange32_invoker.call(ProductController_4.filterByPriceRange(minPrice, maxPrice, limit, offset))
      }
  
    // @LINE:48
    case controllers_ProductController_findById33_route(params@_) =>
      call(params.fromPath[Long]("id", None), params.fromQuery[Option[Boolean]]("withDetails", Some(None))) { (id, withDetails) =>
        controllers_ProductController_findById33_invoker.call(ProductController_4.findById(id, withDetails))
      }
  
    // @LINE:49
    case controllers_ProductController_create34_route(params@_) =>
      call { 
        controllers_ProductController_create34_invoker.call(ProductController_4.create())
      }
  
    // @LINE:50
    case controllers_ProductController_update35_route(params@_) =>
      call(params.fromPath[Long]("id", None)) { (id) =>
        controllers_ProductController_update35_invoker.call(ProductController_4.update(id))
      }
  
    // @LINE:51
    case controllers_ProductController_delete36_route(params@_) =>
      call(params.fromPath[Long]("id", None)) { (id) =>
        controllers_ProductController_delete36_invoker.call(ProductController_4.delete(id))
      }
  
    // @LINE:54
    case controllers_StockController_findAll37_route(params@_) =>
      call(params.fromQuery[Option[Int]]("limit", Some(None)), params.fromQuery[Option[Int]]("offset", Some(None))) { (limit, offset) =>
        controllers_StockController_findAll37_invoker.call(StockController_3.findAll(limit, offset))
      }
  
    // @LINE:55
    case controllers_StockController_count38_route(params@_) =>
      call { 
        controllers_StockController_count38_invoker.call(StockController_3.count())
      }
  
    // @LINE:56
    case controllers_StockController_findLowStock39_route(params@_) =>
      call { 
        controllers_StockController_findLowStock39_invoker.call(StockController_3.findLowStock())
      }
  
    // @LINE:57
    case controllers_StockController_getTotalStockValue40_route(params@_) =>
      call { 
        controllers_StockController_getTotalStockValue40_invoker.call(StockController_3.getTotalStockValue())
      }
  
    // @LINE:58
    case controllers_StockController_getStockReport41_route(params@_) =>
      call { 
        controllers_StockController_getStockReport41_invoker.call(StockController_3.getStockReport())
      }
  
    // @LINE:59
    case controllers_StockController_findByProductId42_route(params@_) =>
      call(params.fromPath[Long]("productId", None)) { (productId) =>
        controllers_StockController_findByProductId42_invoker.call(StockController_3.findByProductId(productId))
      }
  
    // @LINE:60
    case controllers_StockController_findById43_route(params@_) =>
      call(params.fromPath[Long]("id", None)) { (id) =>
        controllers_StockController_findById43_invoker.call(StockController_3.findById(id))
      }
  
    // @LINE:61
    case controllers_StockController_updateStock44_route(params@_) =>
      call(params.fromPath[Long]("productId", None)) { (productId) =>
        controllers_StockController_updateStock44_invoker.call(StockController_3.updateStock(productId))
      }
  
    // @LINE:62
    case controllers_StockController_adjustStock45_route(params@_) =>
      call(params.fromPath[Long]("productId", None)) { (productId) =>
        controllers_StockController_adjustStock45_invoker.call(StockController_3.adjustStock(productId))
      }
  
    // @LINE:63
    case controllers_StockController_transferStock46_route(params@_) =>
      call { 
        controllers_StockController_transferStock46_invoker.call(StockController_3.transferStock())
      }
  
    // @LINE:66
    case controllers_Assets_at47_route(params@_) =>
      call(Param[String]("path", Right("/public")), Param[String]("file", Right("index.html"))) { (path, file) =>
        controllers_Assets_at47_invoker.call(Assets_6.at(path, file))
      }
  
    // @LINE:67
    case controllers_Assets_versioned48_route(params@_) =>
      call(Param[String]("path", Right("/public")), params.fromPath[Asset]("file", None)) { (path, file) =>
        controllers_Assets_versioned48_invoker.call(Assets_6.versioned(path, file))
      }
  
    // @LINE:70
    case controllers_Assets_at49_route(params@_) =>
      call(Param[String]("path", Right("/public")), params.fromPath[String]("file", None)) { (path, file) =>
        controllers_Assets_at49_invoker.call(Assets_6.at(path, file))
      }
  }
}
