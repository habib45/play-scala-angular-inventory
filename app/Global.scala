import play.api.mvc.QueryStringBindable
import scala.util.Try

object Global {
  // BigDecimal binder for routes
  implicit def queryStringBindableBigDecimal(implicit stringBinder: QueryStringBindable[String]): QueryStringBindable[BigDecimal] = new QueryStringBindable[BigDecimal] {
    override def bind(key: String, params: Map[String, Seq[String]]): Option[Either[String, BigDecimal]] = {
      stringBinder.bind(key, params).map {
        case Right(s) => Try(BigDecimal(s)).toOption.toRight(s"Invalid BigDecimal: $s")
        case Left(error) => Left(error)
      }
    }

    override def unbind(key: String, value: BigDecimal): String = {
      stringBinder.unbind(key, value.toString)
    }
  }
}