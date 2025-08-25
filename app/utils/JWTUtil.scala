package utils

import com.auth0.jwt.JWT
import com.auth0.jwt.algorithms.Algorithm
import com.auth0.jwt.exceptions.JWTVerificationException
import com.auth0.jwt.interfaces.DecodedJWT
import models.UserRole.UserRole
import java.time.{LocalDateTime, ZoneOffset}
import java.util.Date

object JWTUtil {
  private val secret = "your-secret-key-here" // In production, use environment variable
  private val algorithm = Algorithm.HMAC256(secret)
  private val issuer = "inventory-management-system"
  private val audience = "inventory-users"

  def generateToken(userId: Long, username: String, role: UserRole): String = {
    val now = LocalDateTime.now()
    val expiresAt = now.plusHours(24) // Token expires in 24 hours
    
    JWT.create()
      .withIssuer(issuer)
      .withAudience(audience)
      .withSubject(userId.toString)
      .withClaim("username", username)
      .withClaim("role", role.toString)
      .withIssuedAt(Date.from(now.toInstant(ZoneOffset.UTC)))
      .withExpiresAt(Date.from(expiresAt.toInstant(ZoneOffset.UTC)))
      .sign(algorithm)
  }

  def verifyToken(token: String): Option[JWTPayload] = {
    try {
      val verifier = JWT.require(algorithm)
        .withIssuer(issuer)
        .withAudience(audience)
        .build()
      
      val jwt: DecodedJWT = verifier.verify(token)
      
      Some(JWTPayload(
        userId = jwt.getSubject.toLong,
        username = jwt.getClaim("username").asString(),
        role = models.UserRole.withName(jwt.getClaim("role").asString())
      ))
    } catch {
      case _: JWTVerificationException => None
      case _: Exception => None
    }
  }

  def isTokenExpired(token: String): Boolean = {
    try {
      val jwt = JWT.decode(token)
      val expiresAt = jwt.getExpiresAt
      expiresAt != null && expiresAt.before(new Date())
    } catch {
      case _: Exception => true
    }
  }

  def extractToken(authHeader: String): Option[String] = {
    if (authHeader.startsWith("Bearer ")) {
      Some(authHeader.substring(7))
    } else {
      None
    }
  }

  def validateToken(token: String): scala.util.Try[JWTPayload] = {
    verifyToken(token) match {
      case Some(payload) => scala.util.Success(payload)
      case None => scala.util.Failure(new Exception("Invalid token"))
    }
  }
}