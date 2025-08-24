Perfect 👍 You want a **clear, structured checklist** that you can 
### Project Overview
The Inventory Management System (IMS) is a web-based application designed to help businesses manage products, suppliers, categories, stock levels, and users efficiently. It provides a secure, scalable, and user-friendly interface built with AngularJS frontend and a Play Framework 3 (Scala) backend, supported by a MySQL database.

The system ensures real-time stock management, role-based access control, and clean API design, making it suitable for small to medium-sized businesses aiming for structured inventory tracking.

### First step 
* analize the template folder also html file
* impliment all feture and html file work able 
* develop every feture with test case 

### 1. **Project Setup**

* Use **Play Framework 3 (Scala)** for backend.
* Use **AngularJS** for frontend (integrate with provided HTML design).
* Use **MySQL** for database.
* Organize code with **clean architecture**:

  * `controllers/` → handle API requests.
  * `services/` → business logic.
  * `repositories/` → database queries.
  * `models/` → entities/DTOs.
  * `public/` → AngularJS app (controllers, services, views).

### 2. **Database Design (MySQL)**

* Create these tables:

  * `categories` → (id, name).
  * `suppliers` → (id, name, contact, email).
  * `products` → (id, name, category\_id, supplier\_id, price).
  * `stock` → (id, product\_id, quantity, updated\_at).
  * `users` → (id, username, password\_hash, role).
* Add **foreign keys** between related tables.
* Use **indexes** on `product.name`, `category_id`, `supplier_id`.
* Ensure **referential integrity** with constraints.


### 3. **Backend (Play Framework 3 with Scala)**

* Implement **RESTful APIs**:

  * `/api/products` → CRUD for products.
  * `/api/categories` → CRUD for categories.
  * `/api/suppliers` → CRUD for suppliers.
  * `/api/stock` → stock updates, stock reports.
  * `/api/users` → authentication & role management.
* Follow **best practices**:

  * Return proper **HTTP status codes** (`200`, `201`, `400`, `404`, `500`).
  * Use **DTOs** for input/output (don’t expose DB entities directly).
  * Implement **validation** for requests (e.g., product price > 0).
  * Implement **exception handling middleware** for errors.

### 4. **Frontend (AngularJS + Provided HTML)**

* Convert HTML design into AngularJS **views/components**.
* Organize AngularJS code:

  * `app.js` → main app module & routes.
  * `controllers/` → connect UI with services.
  * `services/` → call backend APIs (`$http`).
  * `directives/` → reusable UI elements.
* Features:

  * Product management (CRUD).
  * Category & supplier management.
  * Stock updates with live refresh.
  * User login/logout, role-based access.

### 5. **Security**

* Use **JWT authentication** for users.
* Protect APIs with **role-based access control**:

  * Admin → full access.
  * Manager → products, stock.
  * Staff → read-only.
* Enable **CSRF protection** in Play + AngularJS.
* Escape all user inputs (prevent SQL injection & XSS).


### 6. **SQL Query Guidelines**

* Always use **parameterized queries** (`?` placeholders).
* Support **search, filtering, and pagination**:

  * Example: `SELECT * FROM products WHERE name LIKE ? LIMIT ? OFFSET ?`.
* Use **JOINs** for related data:

  * Example: products with categories & suppliers.
* Use **transactions** when updating stock (atomic operations).
* Optimize queries with **indexes** on frequently used columns.


### 7. **Testing**

**Backend (Scala – ScalaTest/JUnit):**

* Unit test services & repositories (mock DB).
* Integration test APIs (simulate requests with test client).
* Security tests (ensure only authorized roles access certain APIs).

**Frontend (AngularJS – Jasmine/Karma):**

* Unit test controllers & services (mock `$http`).
* Validate form inputs & error handling.
* Test routes & navigation flows.

**Database Tests:**

* Verify constraints & foreign keys.
* Test rollback in transactions.
* Ensure pagination & filtering queries return correct results.


### Best Practices**

* Maintain **layered architecture**.
* Document APIs (preferably with **Swagger/OpenAPI**).
* Write **Flyway/Liquibase migrations** for DB updates.
* Use **logging** for backend & frontend errors.
* Plan for **scalability** (pagination, caching, modular design).
* Follow **code style guidelines** (Scala style, AngularJS conventions).
