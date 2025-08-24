// @GENERATOR:play-routes-compiler
// @SOURCE:conf/routes

import play.api.mvc.Call


import _root_.controllers.Assets.Asset

// @LINE:7
package controllers {

  // @LINE:66
  class ReverseAssets(_prefix: => String) {
    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:66
    def at(file:String): Call = {
    
      (file: @unchecked) match {
      
        // @LINE:66
        case (file) if file == "index.html" =>
          implicit lazy val _rrc = new play.core.routing.ReverseRouteContext(Map(("path", "/public"), ("file", "index.html"))); _rrc
          Call("GET", _prefix)
      
        // @LINE:70
        case (file)  =>
          implicit lazy val _rrc = new play.core.routing.ReverseRouteContext(Map(("path", "/public"))); _rrc
          Call("GET", _prefix + { _defaultPrefix } + "public/" + implicitly[play.api.mvc.PathBindable[String]].unbind("file", file))
      
      }
    
    }
  
    // @LINE:67
    def versioned(file:Asset): Call = {
      implicit lazy val _rrc = new play.core.routing.ReverseRouteContext(Map(("path", "/public"))); _rrc
      Call("GET", _prefix + { _defaultPrefix } + "assets/" + implicitly[play.api.mvc.PathBindable[Asset]].unbind("file", file))
    }
  
  }

  // @LINE:33
  class ReverseSupplierController(_prefix: => String) {
    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:39
    def delete(id:Long): Call = {
      
      Call("DELETE", _prefix + { _defaultPrefix } + "api/suppliers/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:37
    def create(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/suppliers")
    }
  
    // @LINE:35
    def search(q:String, limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/suppliers/search" + play.core.routing.queryString(List(Some(implicitly[play.api.mvc.QueryStringBindable[String]].unbind("q", q)), if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
    // @LINE:36
    def findById(id:Long): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/suppliers/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:34
    def count(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/suppliers/count")
    }
  
    // @LINE:38
    def update(id:Long): Call = {
      
      Call("PUT", _prefix + { _defaultPrefix } + "api/suppliers/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:33
    def findAll(limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/suppliers" + play.core.routing.queryString(List(if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
  }

  // @LINE:54
  class ReverseStockController(_prefix: => String) {
    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:59
    def findByProductId(productId:Long): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/stock/product/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("productId", productId)))
    }
  
    // @LINE:56
    def findLowStock(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/stock/low-stock")
    }
  
    // @LINE:60
    def findById(id:Long): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/stock/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:55
    def count(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/stock/count")
    }
  
    // @LINE:61
    def updateStock(productId:Long): Call = {
      
      Call("PUT", _prefix + { _defaultPrefix } + "api/stock/product/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("productId", productId)))
    }
  
    // @LINE:54
    def findAll(limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/stock" + play.core.routing.queryString(List(if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
    // @LINE:62
    def adjustStock(productId:Long): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/stock/adjust/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("productId", productId)))
    }
  
    // @LINE:63
    def transferStock(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/stock/transfer")
    }
  
    // @LINE:57
    def getTotalStockValue(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/stock/total-value")
    }
  
    // @LINE:58
    def getStockReport(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/stock/report")
    }
  
  }

  // @LINE:24
  class ReverseCategoryController(_prefix: => String) {
    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:30
    def delete(id:Long): Call = {
      
      Call("DELETE", _prefix + { _defaultPrefix } + "api/categories/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:28
    def create(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/categories")
    }
  
    // @LINE:26
    def search(q:String, limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/categories/search" + play.core.routing.queryString(List(Some(implicitly[play.api.mvc.QueryStringBindable[String]].unbind("q", q)), if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
    // @LINE:27
    def findById(id:Long): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/categories/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:25
    def count(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/categories/count")
    }
  
    // @LINE:29
    def update(id:Long): Call = {
      
      Call("PUT", _prefix + { _defaultPrefix } + "api/categories/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:24
    def findAll(limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/categories" + play.core.routing.queryString(List(if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
  }

  // @LINE:42
  class ReverseProductController(_prefix: => String) {
    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:51
    def delete(id:Long): Call = {
      
      Call("DELETE", _prefix + { _defaultPrefix } + "api/products/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:45
    def findByCategory(categoryId:Long, limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/products/category/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("categoryId", categoryId)) + play.core.routing.queryString(List(if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
    // @LINE:49
    def create(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/products")
    }
  
    // @LINE:47
    def filterByPriceRange(minPrice:BigDecimal, maxPrice:BigDecimal, limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/products/price-range" + play.core.routing.queryString(List(Some(implicitly[play.api.mvc.QueryStringBindable[BigDecimal]].unbind("minPrice", minPrice)), Some(implicitly[play.api.mvc.QueryStringBindable[BigDecimal]].unbind("maxPrice", maxPrice)), if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
    // @LINE:44
    def search(q:String, limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/products/search" + play.core.routing.queryString(List(Some(implicitly[play.api.mvc.QueryStringBindable[String]].unbind("q", q)), if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
    // @LINE:46
    def findBySupplier(supplierId:Long, limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/products/supplier/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("supplierId", supplierId)) + play.core.routing.queryString(List(if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
    // @LINE:43
    def count(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/products/count")
    }
  
    // @LINE:48
    def findById(id:Long, withDetails:Option[Boolean] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/products/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)) + play.core.routing.queryString(List(if(withDetails == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Boolean]]].unbind("withDetails", withDetails)))))
    }
  
    // @LINE:50
    def update(id:Long): Call = {
      
      Call("PUT", _prefix + { _defaultPrefix } + "api/products/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:42
    def findAll(limit:Option[Int] = None, offset:Option[Int] = None, withDetails:Option[Boolean] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/products" + play.core.routing.queryString(List(if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)), if(withDetails == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Boolean]]].unbind("withDetails", withDetails)))))
    }
  
  }

  // @LINE:13
  class ReverseUserController(_prefix: => String) {
    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:14
    def getCurrentUser(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/users/current")
    }
  
    // @LINE:21
    def delete(id:Long): Call = {
      
      Call("DELETE", _prefix + { _defaultPrefix } + "api/users/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:19
    def create(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/users")
    }
  
    // @LINE:16
    def search(q:String, limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/users/search" + play.core.routing.queryString(List(Some(implicitly[play.api.mvc.QueryStringBindable[String]].unbind("q", q)), if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
    // @LINE:18
    def findById(id:Long): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/users/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:15
    def count(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/users/count")
    }
  
    // @LINE:20
    def update(id:Long): Call = {
      
      Call("PUT", _prefix + { _defaultPrefix } + "api/users/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:13
    def findAll(limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/users" + play.core.routing.queryString(List(if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
    // @LINE:17
    def findByRole(role:String): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/users/role/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[String]].unbind("role", role)))
    }
  
  }

  // @LINE:7
  class ReverseAuthController(_prefix: => String) {
    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:7
    def login(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/auth/login")
    }
  
    // @LINE:8
    def changePassword(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/auth/change-password")
    }
  
    // @LINE:9
    def validateToken(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/auth/validate")
    }
  
    // @LINE:10
    def logout(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/auth/logout")
    }
  
  }


}
