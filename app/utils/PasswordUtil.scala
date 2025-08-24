package utils

import org.mindrot.jbcrypt.BCrypt
import javax.inject.Singleton

@Singleton
class PasswordUtil {
  
  def hashPassword(password: String): String = {
    BCrypt.hashpw(password, BCrypt.gensalt())
  }

  def checkPassword(password: String, hashedPassword: String): Boolean = {
    BCrypt.checkpw(password, hashedPassword)
  }

  def validatePasswordStrength(password: String): List[String] = {
    val errors = scala.collection.mutable.ListBuffer[String]()
    
    if (password.length < 8) {
      errors += "Password must be at least 8 characters long"
    }
    
    if (!password.matches(".*[A-Z].*")) {
      errors += "Password must contain at least one uppercase letter"
    }
    
    if (!password.matches(".*[a-z].*")) {
      errors += "Password must contain at least one lowercase letter"
    }
    
    if (!password.matches(".*[0-9].*")) {
      errors += "Password must contain at least one digit"
    }
    
    if (!password.matches(".*[!@#$%^&*()_+\\-=\\[\\]{};':\"\\\\|,.<>\\/?].*")) {
      errors += "Password must contain at least one special character"
    }
    
    errors.toList
  }
}