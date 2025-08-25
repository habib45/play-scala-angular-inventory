// @GENERATOR:play-routes-compiler
// @SOURCE:conf/routes

import play.api.routing.JavaScriptReverseRoute


import _root_.controllers.Assets.Asset
import _root_.binders._

// @LINE:9
package controllers.javascript {

  // @LINE:68
  class ReverseAssets(_prefix: => String) {

    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:68
    def at: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.Assets.at",
      """
        function(file1) {
        
          if (file1 == """ + implicitly[play.api.mvc.JavascriptLiteral[String]].to("index.html") + """) {
            return _wA({method:"GET", url:"""" + _prefix + """"})
          }
        
          if (true) {
            return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "public/" + (""" + implicitly[play.api.mvc.PathBindable[String]].javascriptUnbind + """)("file", file1)})
          }
        
        }
      """
    )
  
    // @LINE:69
    def versioned: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.Assets.versioned",
      """
        function(file1) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "assets/" + (""" + implicitly[play.api.mvc.PathBindable[Asset]].javascriptUnbind + """)("file", file1)})
        }
      """
    )
  
  }

  // @LINE:35
  class ReverseSupplierController(_prefix: => String) {

    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:41
    def delete: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.SupplierController.delete",
      """
        function(id0) {
          return _wA({method:"DELETE", url:"""" + _prefix + { _defaultPrefix } + """" + "api/suppliers/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("id", id0))})
        }
      """
    )
  
    // @LINE:39
    def create: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.SupplierController.create",
      """
        function() {
          return _wA({method:"POST", url:"""" + _prefix + { _defaultPrefix } + """" + "api/suppliers"})
        }
      """
    )
  
    // @LINE:37
    def search: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.SupplierController.search",
      """
        function(q0,limit1,offset2) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/suppliers/search" + _qS([(""" + implicitly[play.api.mvc.QueryStringBindable[String]].javascriptUnbind + """)("q", q0), (limit1 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("limit", limit1)), (offset2 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("offset", offset2))])})
        }
      """
    )
  
    // @LINE:38
    def findById: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.SupplierController.findById",
      """
        function(id0) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/suppliers/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("id", id0))})
        }
      """
    )
  
    // @LINE:36
    def count: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.SupplierController.count",
      """
        function() {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/suppliers/count"})
        }
      """
    )
  
    // @LINE:40
    def update: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.SupplierController.update",
      """
        function(id0) {
          return _wA({method:"PUT", url:"""" + _prefix + { _defaultPrefix } + """" + "api/suppliers/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("id", id0))})
        }
      """
    )
  
    // @LINE:35
    def findAll: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.SupplierController.findAll",
      """
        function(limit0,offset1) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/suppliers" + _qS([(limit0 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("limit", limit0)), (offset1 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("offset", offset1))])})
        }
      """
    )
  
  }

  // @LINE:56
  class ReverseStockController(_prefix: => String) {

    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:61
    def findByProductId: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.StockController.findByProductId",
      """
        function(productId0) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/stock/product/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("productId", productId0))})
        }
      """
    )
  
    // @LINE:58
    def findLowStock: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.StockController.findLowStock",
      """
        function() {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/stock/low-stock"})
        }
      """
    )
  
    // @LINE:62
    def findById: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.StockController.findById",
      """
        function(id0) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/stock/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("id", id0))})
        }
      """
    )
  
    // @LINE:57
    def count: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.StockController.count",
      """
        function() {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/stock/count"})
        }
      """
    )
  
    // @LINE:63
    def updateStock: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.StockController.updateStock",
      """
        function(productId0) {
          return _wA({method:"PUT", url:"""" + _prefix + { _defaultPrefix } + """" + "api/stock/product/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("productId", productId0))})
        }
      """
    )
  
    // @LINE:56
    def findAll: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.StockController.findAll",
      """
        function(limit0,offset1) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/stock" + _qS([(limit0 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("limit", limit0)), (offset1 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("offset", offset1))])})
        }
      """
    )
  
    // @LINE:64
    def adjustStock: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.StockController.adjustStock",
      """
        function(productId0) {
          return _wA({method:"POST", url:"""" + _prefix + { _defaultPrefix } + """" + "api/stock/adjust/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("productId", productId0))})
        }
      """
    )
  
    // @LINE:65
    def transferStock: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.StockController.transferStock",
      """
        function() {
          return _wA({method:"POST", url:"""" + _prefix + { _defaultPrefix } + """" + "api/stock/transfer"})
        }
      """
    )
  
    // @LINE:59
    def getTotalStockValue: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.StockController.getTotalStockValue",
      """
        function() {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/stock/total-value"})
        }
      """
    )
  
    // @LINE:60
    def getStockReport: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.StockController.getStockReport",
      """
        function() {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/stock/report"})
        }
      """
    )
  
  }

  // @LINE:26
  class ReverseCategoryController(_prefix: => String) {

    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:32
    def delete: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.CategoryController.delete",
      """
        function(id0) {
          return _wA({method:"DELETE", url:"""" + _prefix + { _defaultPrefix } + """" + "api/categories/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("id", id0))})
        }
      """
    )
  
    // @LINE:30
    def create: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.CategoryController.create",
      """
        function() {
          return _wA({method:"POST", url:"""" + _prefix + { _defaultPrefix } + """" + "api/categories"})
        }
      """
    )
  
    // @LINE:28
    def search: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.CategoryController.search",
      """
        function(q0,limit1,offset2) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/categories/search" + _qS([(""" + implicitly[play.api.mvc.QueryStringBindable[String]].javascriptUnbind + """)("q", q0), (limit1 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("limit", limit1)), (offset2 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("offset", offset2))])})
        }
      """
    )
  
    // @LINE:29
    def findById: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.CategoryController.findById",
      """
        function(id0) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/categories/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("id", id0))})
        }
      """
    )
  
    // @LINE:27
    def count: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.CategoryController.count",
      """
        function() {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/categories/count"})
        }
      """
    )
  
    // @LINE:31
    def update: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.CategoryController.update",
      """
        function(id0) {
          return _wA({method:"PUT", url:"""" + _prefix + { _defaultPrefix } + """" + "api/categories/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("id", id0))})
        }
      """
    )
  
    // @LINE:26
    def findAll: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.CategoryController.findAll",
      """
        function(limit0,offset1) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/categories" + _qS([(limit0 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("limit", limit0)), (offset1 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("offset", offset1))])})
        }
      """
    )
  
  }

  // @LINE:44
  class ReverseProductController(_prefix: => String) {

    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:53
    def delete: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.ProductController.delete",
      """
        function(id0) {
          return _wA({method:"DELETE", url:"""" + _prefix + { _defaultPrefix } + """" + "api/products/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("id", id0))})
        }
      """
    )
  
    // @LINE:47
    def findByCategory: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.ProductController.findByCategory",
      """
        function(categoryId0,limit1,offset2) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/products/category/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("categoryId", categoryId0)) + _qS([(limit1 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("limit", limit1)), (offset2 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("offset", offset2))])})
        }
      """
    )
  
    // @LINE:51
    def create: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.ProductController.create",
      """
        function() {
          return _wA({method:"POST", url:"""" + _prefix + { _defaultPrefix } + """" + "api/products"})
        }
      """
    )
  
    // @LINE:46
    def search: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.ProductController.search",
      """
        function(q0,limit1,offset2) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/products/search" + _qS([(""" + implicitly[play.api.mvc.QueryStringBindable[String]].javascriptUnbind + """)("q", q0), (limit1 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("limit", limit1)), (offset2 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("offset", offset2))])})
        }
      """
    )
  
    // @LINE:48
    def findBySupplier: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.ProductController.findBySupplier",
      """
        function(supplierId0,limit1,offset2) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/products/supplier/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("supplierId", supplierId0)) + _qS([(limit1 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("limit", limit1)), (offset2 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("offset", offset2))])})
        }
      """
    )
  
    // @LINE:45
    def count: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.ProductController.count",
      """
        function() {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/products/count"})
        }
      """
    )
  
    // @LINE:50
    def findById: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.ProductController.findById",
      """
        function(id0,withDetails1) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/products/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("id", id0)) + _qS([(withDetails1 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Boolean]]].javascriptUnbind + """)("withDetails", withDetails1))])})
        }
      """
    )
  
    // @LINE:52
    def update: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.ProductController.update",
      """
        function(id0) {
          return _wA({method:"PUT", url:"""" + _prefix + { _defaultPrefix } + """" + "api/products/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("id", id0))})
        }
      """
    )
  
    // @LINE:44
    def findAll: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.ProductController.findAll",
      """
        function(limit0,offset1,withDetails2) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/products" + _qS([(limit0 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("limit", limit0)), (offset1 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("offset", offset1)), (withDetails2 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Boolean]]].javascriptUnbind + """)("withDetails", withDetails2))])})
        }
      """
    )
  
  }

  // @LINE:15
  class ReverseUserController(_prefix: => String) {

    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:16
    def getCurrentUser: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.UserController.getCurrentUser",
      """
        function() {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/users/current"})
        }
      """
    )
  
    // @LINE:23
    def delete: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.UserController.delete",
      """
        function(id0) {
          return _wA({method:"DELETE", url:"""" + _prefix + { _defaultPrefix } + """" + "api/users/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("id", id0))})
        }
      """
    )
  
    // @LINE:21
    def create: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.UserController.create",
      """
        function() {
          return _wA({method:"POST", url:"""" + _prefix + { _defaultPrefix } + """" + "api/users"})
        }
      """
    )
  
    // @LINE:18
    def search: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.UserController.search",
      """
        function(q0,limit1,offset2) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/users/search" + _qS([(""" + implicitly[play.api.mvc.QueryStringBindable[String]].javascriptUnbind + """)("q", q0), (limit1 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("limit", limit1)), (offset2 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("offset", offset2))])})
        }
      """
    )
  
    // @LINE:20
    def findById: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.UserController.findById",
      """
        function(id0) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/users/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("id", id0))})
        }
      """
    )
  
    // @LINE:17
    def count: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.UserController.count",
      """
        function() {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/users/count"})
        }
      """
    )
  
    // @LINE:22
    def update: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.UserController.update",
      """
        function(id0) {
          return _wA({method:"PUT", url:"""" + _prefix + { _defaultPrefix } + """" + "api/users/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[Long]].javascriptUnbind + """)("id", id0))})
        }
      """
    )
  
    // @LINE:15
    def findAll: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.UserController.findAll",
      """
        function(limit0,offset1) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/users" + _qS([(limit0 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("limit", limit0)), (offset1 == null ? null : (""" + implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].javascriptUnbind + """)("offset", offset1))])})
        }
      """
    )
  
    // @LINE:19
    def findByRole: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.UserController.findByRole",
      """
        function(role0) {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/users/role/" + encodeURIComponent((""" + implicitly[play.api.mvc.PathBindable[String]].javascriptUnbind + """)("role", role0))})
        }
      """
    )
  
  }

  // @LINE:9
  class ReverseAuthController(_prefix: => String) {

    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:9
    def login: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.AuthController.login",
      """
        function() {
          return _wA({method:"POST", url:"""" + _prefix + { _defaultPrefix } + """" + "api/auth/login"})
        }
      """
    )
  
    // @LINE:10
    def changePassword: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.AuthController.changePassword",
      """
        function() {
          return _wA({method:"POST", url:"""" + _prefix + { _defaultPrefix } + """" + "api/auth/change-password"})
        }
      """
    )
  
    // @LINE:11
    def validateToken: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.AuthController.validateToken",
      """
        function() {
          return _wA({method:"GET", url:"""" + _prefix + { _defaultPrefix } + """" + "api/auth/validate"})
        }
      """
    )
  
    // @LINE:12
    def logout: JavaScriptReverseRoute = JavaScriptReverseRoute(
      "controllers.AuthController.logout",
      """
        function() {
          return _wA({method:"POST", url:"""" + _prefix + { _defaultPrefix } + """" + "api/auth/logout"})
        }
      """
    )
  
  }


}
