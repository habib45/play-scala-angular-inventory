// @GENERATOR:play-routes-compiler
// @SOURCE:conf/routes

import play.api.mvc.Call


import _root_.controllers.Assets.Asset
import _root_.binders._

// @LINE:9
package controllers {

  // @LINE:68
  class ReverseAssets(_prefix: => String) {
    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:68
    def at(file:String): Call = {
    
      (file: @unchecked) match {
      
        // @LINE:68
        case (file) if file == "index.html" =>
          implicit lazy val _rrc = new play.core.routing.ReverseRouteContext(Map(("path", "/public"), ("file", "index.html"))); _rrc
          Call("GET", _prefix)
      
        // @LINE:72
        case (file)  =>
          implicit lazy val _rrc = new play.core.routing.ReverseRouteContext(Map(("path", "/public"))); _rrc
          Call("GET", _prefix + { _defaultPrefix } + "public/" + implicitly[play.api.mvc.PathBindable[String]].unbind("file", file))
      
      }
    
    }
  
    // @LINE:69
    def versioned(file:Asset): Call = {
      implicit lazy val _rrc = new play.core.routing.ReverseRouteContext(Map(("path", "/public"))); _rrc
      Call("GET", _prefix + { _defaultPrefix } + "assets/" + implicitly[play.api.mvc.PathBindable[Asset]].unbind("file", file))
    }
  
  }

  // @LINE:35
  class ReverseSupplierController(_prefix: => String) {
    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:41
    def delete(id:Long): Call = {
      
      Call("DELETE", _prefix + { _defaultPrefix } + "api/suppliers/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:39
    def create(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/suppliers")
    }
  
    // @LINE:37
    def search(q:String, limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/suppliers/search" + play.core.routing.queryString(List(Some(implicitly[play.api.mvc.QueryStringBindable[String]].unbind("q", q)), if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
    // @LINE:38
    def findById(id:Long): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/suppliers/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:36
    def count(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/suppliers/count")
    }
  
    // @LINE:40
    def update(id:Long): Call = {
      
      Call("PUT", _prefix + { _defaultPrefix } + "api/suppliers/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:35
    def findAll(limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/suppliers" + play.core.routing.queryString(List(if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
  }

  // @LINE:56
  class ReverseStockController(_prefix: => String) {
    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:61
    def findByProductId(productId:Long): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/stock/product/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("productId", productId)))
    }
  
    // @LINE:58
    def findLowStock(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/stock/low-stock")
    }
  
    // @LINE:62
    def findById(id:Long): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/stock/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:57
    def count(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/stock/count")
    }
  
    // @LINE:63
    def updateStock(productId:Long): Call = {
      
      Call("PUT", _prefix + { _defaultPrefix } + "api/stock/product/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("productId", productId)))
    }
  
    // @LINE:56
    def findAll(limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/stock" + play.core.routing.queryString(List(if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
    // @LINE:64
    def adjustStock(productId:Long): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/stock/adjust/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("productId", productId)))
    }
  
    // @LINE:65
    def transferStock(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/stock/transfer")
    }
  
    // @LINE:59
    def getTotalStockValue(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/stock/total-value")
    }
  
    // @LINE:60
    def getStockReport(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/stock/report")
    }
  
  }

  // @LINE:26
  class ReverseCategoryController(_prefix: => String) {
    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:32
    def delete(id:Long): Call = {
      
      Call("DELETE", _prefix + { _defaultPrefix } + "api/categories/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:30
    def create(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/categories")
    }
  
    // @LINE:28
    def search(q:String, limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/categories/search" + play.core.routing.queryString(List(Some(implicitly[play.api.mvc.QueryStringBindable[String]].unbind("q", q)), if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
    // @LINE:29
    def findById(id:Long): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/categories/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:27
    def count(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/categories/count")
    }
  
    // @LINE:31
    def update(id:Long): Call = {
      
      Call("PUT", _prefix + { _defaultPrefix } + "api/categories/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:26
    def findAll(limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/categories" + play.core.routing.queryString(List(if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
  }

  // @LINE:44
  class ReverseProductController(_prefix: => String) {
    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:53
    def delete(id:Long): Call = {
      
      Call("DELETE", _prefix + { _defaultPrefix } + "api/products/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:47
    def findByCategory(categoryId:Long, limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/products/category/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("categoryId", categoryId)) + play.core.routing.queryString(List(if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
    // @LINE:51
    def create(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/products")
    }
  
    // @LINE:46
    def search(q:String, limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/products/search" + play.core.routing.queryString(List(Some(implicitly[play.api.mvc.QueryStringBindable[String]].unbind("q", q)), if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
    // @LINE:48
    def findBySupplier(supplierId:Long, limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/products/supplier/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("supplierId", supplierId)) + play.core.routing.queryString(List(if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
    // @LINE:45
    def count(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/products/count")
    }
  
    // @LINE:50
    def findById(id:Long, withDetails:Option[Boolean] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/products/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)) + play.core.routing.queryString(List(if(withDetails == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Boolean]]].unbind("withDetails", withDetails)))))
    }
  
    // @LINE:52
    def update(id:Long): Call = {
      
      Call("PUT", _prefix + { _defaultPrefix } + "api/products/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:44
    def findAll(limit:Option[Int] = None, offset:Option[Int] = None, withDetails:Option[Boolean] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/products" + play.core.routing.queryString(List(if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)), if(withDetails == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Boolean]]].unbind("withDetails", withDetails)))))
    }
  
  }

  // @LINE:15
  class ReverseUserController(_prefix: => String) {
    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:16
    def getCurrentUser(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/users/current")
    }
  
    // @LINE:23
    def delete(id:Long): Call = {
      
      Call("DELETE", _prefix + { _defaultPrefix } + "api/users/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:21
    def create(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/users")
    }
  
    // @LINE:18
    def search(q:String, limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/users/search" + play.core.routing.queryString(List(Some(implicitly[play.api.mvc.QueryStringBindable[String]].unbind("q", q)), if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
    // @LINE:20
    def findById(id:Long): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/users/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:17
    def count(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/users/count")
    }
  
    // @LINE:22
    def update(id:Long): Call = {
      
      Call("PUT", _prefix + { _defaultPrefix } + "api/users/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[Long]].unbind("id", id)))
    }
  
    // @LINE:15
    def findAll(limit:Option[Int] = None, offset:Option[Int] = None): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/users" + play.core.routing.queryString(List(if(limit == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("limit", limit)), if(offset == None) None else Some(implicitly[play.api.mvc.QueryStringBindable[Option[Int]]].unbind("offset", offset)))))
    }
  
    // @LINE:19
    def findByRole(role:String): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/users/role/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[String]].unbind("role", role)))
    }
  
  }

  // @LINE:9
  class ReverseAuthController(_prefix: => String) {
    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:9
    def login(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/auth/login")
    }
  
    // @LINE:10
    def changePassword(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/auth/change-password")
    }
  
    // @LINE:11
    def validateToken(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "api/auth/validate")
    }
  
    // @LINE:12
    def logout(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "api/auth/logout")
    }
  
  }


}
