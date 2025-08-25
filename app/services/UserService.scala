package services

import models.{User, UserRole}
import models.dto.{UserDTO, UserCreateRequest, UserUpdateRequest, UserResponse}
import repositories.UserRepository
import utils.PasswordUtil
import javax.inject.{Inject, Singleton}
import scala.concurrent.{ExecutionContext, Future}

@Singleton
class UserService @Inject()(
  userRepository: UserRepository,
  passwordUtil: PasswordUtil
)(implicit ec: ExecutionContext) {

  def findAll(limit: Int = 100, offset: Int = 0): Future[Seq[UserResponse]] = {
    userRepository.findAll(limit, offset).map(_.map(UserDTO.fromModel))
  }

  def findById(id: Long): Future[Option[UserResponse]] = {
    userRepository.findById(id).map(_.map(UserDTO.fromModel))
  }

  def findByRole(role: String): Future[Seq[UserResponse]] = {
    try {
      val userRole = models.UserRole.withName(role.toUpperCase)
      userRepository.findByRole(userRole).map(_.map(UserDTO.fromModel))
    } catch {
      case _: NoSuchElementException => Future.successful(Seq.empty)
    }
  }

  def search(query: String, limit: Int = 100, offset: Int = 0): Future[Seq[UserResponse]] = {
    userRepository.search(query, limit, offset).map(_.map(UserDTO.fromModel))
  }

  def count(): Future[Int] = {
    userRepository.count()
  }

  def authenticate(username: String, password: String): Future[Option[User]] = {
    userRepository.findByUsername(username).flatMap {
      case Some(user) =>
        if (passwordUtil.checkPassword(password, user.passwordHash)) {
          Future.successful(Some(user))
        } else {
          Future.successful(None)
        }
      case None =>
        Future.successful(None)
    }
  }

  def create(request: UserCreateRequest): Future[Either[String, UserResponse]] = {
    validateUser(request.username, request.password, request.role).flatMap {
      case Some(error) => Future.successful(Left(error))
      case None =>
        userRepository.usernameExists(request.username).flatMap { exists =>
          if (exists) {
            Future.successful(Left("Username already exists"))
          } else {
            val passwordHash = passwordUtil.hashPassword(request.password)
            val user = UserDTO.toModel(request, passwordHash)
            userRepository.create(user).map { created =>
              Right(UserDTO.fromModel(created))
            }
          }
        }
    }
  }

  def update(id: Long, request: UserUpdateRequest): Future[Either[String, UserResponse]] = {
    validateUserUpdate(request.username, request.role).flatMap {
      case Some(error) => Future.successful(Left(error))
      case None =>
        userRepository.findById(id).flatMap {
          case Some(user) =>
            userRepository.usernameExists(request.username, Some(id)).flatMap { exists =>
              if (exists) {
                Future.successful(Left("Username already exists"))
              } else {
                val updatedUser = UserDTO.updateModel(user, request)
                userRepository.update(updatedUser).map { _ =>
                  Right(UserDTO.fromModel(updatedUser))
                }
              }
            }
          case None =>
            Future.successful(Left("User not found"))
        }
    }
  }

  def delete(id: Long): Future[Either[String, String]] = {
    userRepository.findById(id).flatMap {
      case Some(user) =>
        // Prevent deletion of the last admin user
        if (user.role == models.UserRole.ADMIN) {
          userRepository.findByRole(models.UserRole.ADMIN).flatMap { admins =>
            if (admins.length <= 1) {
              Future.successful(Left("Cannot delete the last admin user"))
            } else {
              userRepository.delete(id).map { _ =>
                Right("User deleted successfully")
              }
            }
          }
        } else {
          userRepository.delete(id).map { _ =>
            Right("User deleted successfully")
          }
        }
      case None =>
        Future.successful(Left("User not found"))
    }
  }

  private def validateUser(username: String, password: String, role: String): Future[Option[String]] = {
    Future.successful {
      if (username.trim.isEmpty) {
        Some("Username cannot be empty")
      } else if (username.length > 255) {
        Some("Username cannot exceed 255 characters")
      } else if (!username.matches("^[a-zA-Z0-9_.-]+$")) {
        Some("Username can only contain letters, numbers, dots, hyphens, and underscores")
      } else {
        val passwordErrors = passwordUtil.validatePasswordStrength(password)
        if (passwordErrors.nonEmpty) {
          Some(passwordErrors.mkString("; "))
        } else {
          try {
            models.UserRole.withName(role.toUpperCase)
            None
          } catch {
            case _: NoSuchElementException => Some("Invalid role. Must be ADMIN, MANAGER, or STAFF")
          }
        }
      }
    }
  }

  private def validateUserUpdate(username: String, role: String): Future[Option[String]] = {
    Future.successful {
      if (username.trim.isEmpty) {
        Some("Username cannot be empty")
      } else if (username.length > 255) {
        Some("Username cannot exceed 255 characters")
      } else if (!username.matches("^[a-zA-Z0-9_.-]+$")) {
        Some("Username can only contain letters, numbers, dots, hyphens, and underscores")
      } else {
        try {
          models.UserRole.withName(role.toUpperCase)
          None
        } catch {
          case _: NoSuchElementException => Some("Invalid role. Must be ADMIN, MANAGER, or STAFF")
        }
      }
    }
  }
}