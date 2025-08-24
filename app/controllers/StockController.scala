package controllers

import play.api.mvc._
import play.api.libs.json._
import services.StockService
import models.dto.StockUpdateRequest
import models.UserRole
import security.{AuthenticatedRequest, AuthAction, RoleAction}
import javax.inject.{Inject, Singleton}
import scala.concurrent.{ExecutionContext, Future}

@Singleton
class StockController @Inject()(
  cc: ControllerComponents,
  stockService: StockService,
  authAction: AuthAction,
  roleAction: RoleAction
)(implicit ec: ExecutionContext) extends AbstractController(cc) {

  def findAll(limit: Option[Int], offset: Option[Int]): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    val safeLimit = limit.getOrElse(100).min(1000).max(1)
    val safeOffset = offset.getOrElse(0).max(0)
    
    stockService.findAll(safeLimit, safeOffset).map { stocks =>
      Ok(Json.toJson(stocks))
    }
  }

  def findById(id: Long): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    stockService.findById(id).map {
      case Some(stock) => Ok(Json.toJson(stock))
      case None => NotFound(Json.obj("error" -> "Stock not found"))
    }
  }

  def findByProductId(productId: Long): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    stockService.findByProductId(productId).map {
      case Some(stock) => Ok(Json.toJson(stock))
      case None => NotFound(Json.obj("error" -> "Stock not found for this product"))
    }
  }

  def findLowStock(): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    stockService.findLowStock().map { alerts =>
      Ok(Json.toJson(alerts))
    }
  }

  def getTotalStockValue(): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    stockService.getTotalStockValue().map { totalValue =>
      Ok(Json.obj("totalValue" -> totalValue))
    }
  }

  def getStockReport(): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    stockService.getStockReport().map { report =>
      Ok(Json.toJson(report))
    }
  }

  def count(): Action[AnyContent] = authAction.async { _: AuthenticatedRequest[AnyContent] =>
    stockService.count().map { count =>
      Ok(Json.obj("count" -> count))
    }
  }

  def updateStock(productId: Long): Action[JsValue] = roleAction(UserRole.ADMIN, UserRole.MANAGER).async(parse.json) { request: AuthenticatedRequest[JsValue] =>
    request.body.validate[StockUpdateRequest] match {
      case JsSuccess(updateRequest, _) =>
        stockService.updateStock(productId, updateRequest).map {
          case Right(stock) => Ok(Json.toJson(stock))
          case Left(error) => 
            if (error == "Product not found") NotFound(Json.obj("error" -> error))
            else BadRequest(Json.obj("error" -> error))
        }
      case JsError(errors) =>
        Future.successful(BadRequest(Json.obj("error" -> "Invalid request format", "details" -> JsError.toJson(errors))))
    }
  }

  def adjustStock(productId: Long): Action[JsValue] = roleAction(UserRole.ADMIN, UserRole.MANAGER).async(parse.json) { request: AuthenticatedRequest[JsValue] =>
    (request.body \ "adjustment").validate[Int] match {
      case JsSuccess(adjustment, _) =>
        val reason = (request.body \ "reason").asOpt[String].getOrElse("")
        stockService.adjustStock(productId, adjustment, reason).map {
          case Right(message) => Ok(Json.obj("message" -> message))
          case Left(error) => 
            if (error == "Product not found") NotFound(Json.obj("error" -> error))
            else BadRequest(Json.obj("error" -> error))
        }
      case JsError(_) =>
        Future.successful(BadRequest(Json.obj("error" -> "Invalid adjustment value")))
    }
  }

  def transferStock(): Action[JsValue] = roleAction(UserRole.ADMIN, UserRole.MANAGER).async(parse.json) { request: AuthenticatedRequest[JsValue] =>
    val fromProductIdOpt = (request.body \ "fromProductId").validate[Long].asOpt
    val toProductIdOpt = (request.body \ "toProductId").validate[Long].asOpt
    val quantityOpt = (request.body \ "quantity").validate[Int].asOpt

    (fromProductIdOpt, toProductIdOpt, quantityOpt) match {
      case (Some(fromProductId), Some(toProductId), Some(quantity)) =>
        stockService.transferStock(fromProductId, toProductId, quantity).map {
          case Right(message) => Ok(Json.obj("message" -> message))
          case Left(error) => BadRequest(Json.obj("error" -> error))
        }
      case _ =>
        Future.successful(BadRequest(Json.obj("error" -> "Missing required fields: fromProductId, toProductId, quantity")))
    }
  }
}