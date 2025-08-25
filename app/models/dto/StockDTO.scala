package models.dto

import play.api.libs.json._
import models.Stock
import utils.JsonFormats._
import java.time.LocalDateTime

case class StockUpdateRequest(
  quantity: Int,
  minimumStock: Int
)

case class StockResponse(
  id: Long,
  productId: Long,
  quantity: Int,
  minimumStock: Int,
  updatedAt: LocalDateTime
)

case class LowStockAlert(
  productId: Long,
  productName: String,
  currentStock: Int,
  minimumStock: Int
)

case class StockReport(
  totalItems: Int,
  totalValue: BigDecimal,
  lowStockCount: Int,
  lowStockAlerts: Seq[LowStockAlert]
)

object StockDTO {
  implicit val stockUpdateRequestFormat: Format[StockUpdateRequest] = Json.format[StockUpdateRequest]
  implicit val stockResponseFormat: Format[StockResponse] = Json.format[StockResponse]
  implicit val lowStockAlertFormat: Format[LowStockAlert] = Json.format[LowStockAlert]
  implicit val stockReportFormat: Format[StockReport] = Json.format[StockReport]

  def fromModel(stock: Stock): StockResponse = {
    StockResponse(
      id = stock.id.get,
      productId = stock.productId,
      quantity = stock.quantity,
      minimumStock = stock.minimumStock,
      updatedAt = stock.updatedAt
    )
  }

  def updateModel(stock: Stock, request: StockUpdateRequest): Stock = {
    stock.copy(
      quantity = request.quantity,
      minimumStock = request.minimumStock,
      updatedAt = LocalDateTime.now()
    )
  }

  def fromReportMap(reportMap: Map[String, Any]): StockReport = {
    StockReport(
      totalItems = reportMap("totalItems").asInstanceOf[Int],
      totalValue = reportMap("totalValue").asInstanceOf[BigDecimal],
      lowStockCount = reportMap("lowStockCount").asInstanceOf[Int],
      lowStockAlerts = reportMap("lowStockAlerts").asInstanceOf[Seq[LowStockAlert]]
    )
  }
}