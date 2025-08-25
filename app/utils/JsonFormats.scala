package utils

import play.api.libs.json._
import java.time.{LocalDateTime, LocalDate}
import java.time.format.DateTimeFormatter

object JsonFormats {
  // LocalDateTime formatter for JSON serialization
  private val dateTimeFormatter = DateTimeFormatter.ISO_LOCAL_DATE_TIME
  
  // Implicit JSON formats for LocalDateTime
  implicit val localDateTimeFormat: Format[LocalDateTime] = new Format[LocalDateTime] {
    def writes(dt: LocalDateTime): JsValue = JsString(dt.format(dateTimeFormatter))
    def reads(json: JsValue): JsResult[LocalDateTime] = json match {
      case JsString(s) => 
        try {
          JsSuccess(LocalDateTime.parse(s, dateTimeFormatter))
        } catch {
          case _: Exception => JsError("Invalid LocalDateTime format")
        }
      case _ => JsError("LocalDateTime value expected")
    }
  }
  
  // Implicit JSON formats for LocalDate
  implicit val localDateFormat: Format[LocalDate] = new Format[LocalDate] {
    def writes(d: LocalDate): JsValue = JsString(d.toString)
    def reads(json: JsValue): JsResult[LocalDate] = json match {
      case JsString(s) => 
        try {
          JsSuccess(LocalDate.parse(s))
        } catch {
          case _: Exception => JsError("Invalid LocalDate format")
        }
      case _ => JsError("LocalDate value expected")
    }
  }
}