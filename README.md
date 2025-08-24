# Inventory Management System

A comprehensive web-based inventory management system built with **Play Framework 3 (Scala)** backend and **AngularJS** frontend, featuring real-time stock management, role-based access control, and modern UI/UX design.

## 🚀 Features

### Core Functionality
- **Product Management**: Complete CRUD operations for products with categories and suppliers
- **Stock Management**: Real-time stock tracking with low-stock alerts and adjustments
- **Category Management**: Organize products into categories
- **Supplier Management**: Manage supplier information and relationships
- **User Management**: Role-based access control (Admin, Manager, Staff)
- **Dashboard**: Overview with statistics, charts, and alerts
- **Search & Filtering**: Advanced search and filtering capabilities
- **Responsive Design**: Modern, mobile-friendly interface

### Security Features
- **JWT Authentication**: Secure token-based authentication
- **Role-Based Access Control**: Different permission levels for different roles
- **Password Validation**: Strong password requirements
- **CSRF Protection**: Cross-site request forgery protection
- **SQL Injection Prevention**: Parameterized queries throughout

### Technical Features
- **RESTful APIs**: Clean, well-documented API endpoints
- **Real-time Updates**: Live stock updates and notifications
- **Transaction Support**: Atomic operations for stock transfers
- **Data Validation**: Comprehensive input validation on frontend and backend
- **Error Handling**: Graceful error handling with user-friendly messages

## 🏗️ Architecture

### Backend (Play Framework 3 + Scala)
```
app/
├── controllers/          # REST API controllers
├── services/            # Business logic layer
├── repositories/        # Data access layer
├── models/             # Domain models and DTOs
├── security/           # Authentication and authorization
└── utils/              # Utility classes (JWT, Password hashing)
```

### Frontend (AngularJS)
```
public/
├── js/
│   ├── controllers/    # AngularJS controllers
│   ├── services/       # API and utility services
│   └── directives/     # Reusable UI components
├── templates/          # HTML templates
├── css/               # Custom styles
└── index.html         # Main application file
```

### Database (MySQL)
- **categories**: Product categories
- **suppliers**: Supplier information
- **products**: Product details with foreign keys
- **stock**: Stock levels and minimum thresholds
- **users**: User accounts with roles

## 🛠️ Setup Instructions

### Prerequisites
- **Java 11** or higher
- **Scala 2.13**
- **sbt 1.9+**
- **MySQL 8.0+**
- **Node.js** (for frontend dependencies, optional)

### Database Setup
1. Create MySQL database:
```sql
CREATE DATABASE inventory_db;
CREATE USER 'inventory_user'@'localhost' IDENTIFIED BY 'inventory_pass';
GRANT ALL PRIVILEGES ON inventory_db.* TO 'inventory_user'@'localhost';
FLUSH PRIVILEGES;
```

2. Update database configuration in `conf/application.conf` if needed.

### Running the Application
1. Clone the repository:
```bash
git clone <repository-url>
cd inventory-management-system
```

2. Start the application:
```bash
sbt run
```

3. Access the application at `http://localhost:9000`

### Default Login Credentials
- **Username**: `admin`
- **Password**: `admin123`
- **Role**: `ADMIN`

## 📚 API Documentation

### Authentication Endpoints
- `POST /api/auth/login` - User login
- `POST /api/auth/logout` - User logout
- `POST /api/auth/change-password` - Change password
- `GET /api/auth/validate` - Validate JWT token

### Product Endpoints
- `GET /api/products` - List products (with pagination and search)
- `GET /api/products/{id}` - Get product by ID
- `POST /api/products` - Create new product (Admin/Manager)
- `PUT /api/products/{id}` - Update product (Admin/Manager)
- `DELETE /api/products/{id}` - Delete product (Admin only)

### Stock Endpoints
- `GET /api/stock` - List stock levels
- `PUT /api/stock/product/{productId}` - Update stock levels
- `POST /api/stock/adjust/{productId}` - Adjust stock quantity
- `POST /api/stock/transfer` - Transfer stock between products
- `GET /api/stock/low-stock` - Get low stock alerts
- `GET /api/stock/report` - Get stock report

### Category & Supplier Endpoints
- Similar CRUD patterns for categories and suppliers
- Role-based access control applied

### User Management Endpoints (Admin only)
- `GET /api/users` - List users
- `POST /api/users` - Create user
- `PUT /api/users/{id}` - Update user
- `DELETE /api/users/{id}` - Delete user

## 🔐 Role-Based Permissions

### Admin
- Full access to all features
- User management
- System configuration
- Delete operations

### Manager
- Product and stock management
- Category and supplier management
- View reports and analytics
- Cannot manage users

### Staff
- Read-only access to products and stock
- View reports
- Cannot modify data

## 🧪 Testing

### Backend Tests
```bash
sbt test
```

### Test Coverage
- Unit tests for services and repositories
- Integration tests for API endpoints
- Security tests for authentication and authorization
- Database constraint tests

## 🚀 Deployment

### Production Configuration
1. Update `conf/application.conf` for production:
   - Change JWT secret
   - Update database credentials
   - Configure CORS settings

2. Create production build:
```bash
sbt stage
```

3. Run production server:
```bash
./target/universal/stage/bin/inventory-management-system -Dplay.http.secret.key="your-production-secret"
```

### Docker Deployment (Optional)
```dockerfile
FROM openjdk:11-jre-slim
COPY target/universal/stage /app
WORKDIR /app
EXPOSE 9000
CMD ["bin/inventory-management-system"]
```

## 📈 Performance Considerations

- **Database Indexing**: Indexes on frequently queried columns
- **Pagination**: All list endpoints support pagination
- **Connection Pooling**: HikariCP for database connections
- **Caching**: Consider adding Redis for session management
- **CDN**: Serve static assets via CDN in production

## 🔧 Configuration

### Application Settings
Key configuration options in `conf/application.conf`:
- Database connection settings
- JWT token expiration
- CORS configuration
- File upload limits

### Environment Variables
- `DATABASE_URL`: Database connection string
- `JWT_SECRET`: JWT signing secret
- `APP_ENV`: Application environment (dev/prod)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🆘 Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Verify MySQL is running
   - Check database credentials in `application.conf`
   - Ensure database and user exist

2. **Port Already in Use**
   - Change port in `application.conf`: `http.port = 9001`
   - Or kill process using port 9000

3. **JWT Token Issues**
   - Clear browser localStorage
   - Check JWT secret configuration
   - Verify token expiration settings

4. **Permission Denied Errors**
   - Check user role assignments
   - Verify authentication headers
   - Review role-based access control rules

## 📞 Support

For support and questions:
- Create an issue in the repository
- Check the troubleshooting section
- Review API documentation

---

**Built with ❤️ using Play Framework 3, Scala, AngularJS, and MySQL**
