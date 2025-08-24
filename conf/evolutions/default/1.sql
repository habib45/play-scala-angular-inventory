# --- !Ups

CREATE TABLE categories (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE suppliers (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact VARCHAR(255),
    email VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('ADMIN', 'MANAGER', 'STAFF') NOT NULL DEFAULT 'STAFF',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category_id BIGINT NOT NULL,
    supplier_id BIGINT NOT NULL,
    price DECIMAL(10,2) NOT NULL CHECK (price > 0),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE CASCADE
);

CREATE TABLE stock (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    product_id BIGINT NOT NULL,
    quantity INT NOT NULL DEFAULT 0 CHECK (quantity >= 0),
    minimum_stock INT NOT NULL DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_product_stock (product_id)
);

-- Create indexes for performance
CREATE INDEX idx_products_name ON products(name);
CREATE INDEX idx_products_category ON products(category_id);
CREATE INDEX idx_products_supplier ON products(supplier_id);
CREATE INDEX idx_stock_product ON stock(product_id);
CREATE INDEX idx_users_username ON users(username);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, password_hash, role) VALUES 
('admin', '$2a$10$N9qo8uLOickgx2ZMRZoMye1VdLIFkUBOjMEjL4Cp6dNuKqbQD.W1C', 'ADMIN');

-- Insert sample data
INSERT INTO categories (name) VALUES 
('Electronics'), 
('Clothing'), 
('Books'), 
('Home & Garden');

INSERT INTO suppliers (name, contact, email) VALUES 
('Tech Supply Co', '+1-555-0101', 'contact@techsupply.com'),
('Fashion World', '+1-555-0102', 'orders@fashionworld.com'),
('Book Distributors', '+1-555-0103', 'sales@bookdist.com'),
('Garden Plus', '+1-555-0104', 'info@gardenplus.com');

INSERT INTO products (name, category_id, supplier_id, price, description) VALUES 
('Laptop Computer', 1, 1, 999.99, 'High-performance laptop for business use'),
('Smartphone', 1, 1, 599.99, 'Latest smartphone with advanced features'),
('T-Shirt', 2, 2, 19.99, 'Comfortable cotton t-shirt'),
('Jeans', 2, 2, 49.99, 'Classic blue jeans'),
('Programming Book', 3, 3, 39.99, 'Learn programming fundamentals'),
('Garden Tools Set', 4, 4, 89.99, 'Complete set of garden tools');

INSERT INTO stock (product_id, quantity, minimum_stock) VALUES 
(1, 25, 5),
(2, 50, 10),
(3, 100, 20),
(4, 75, 15),
(5, 30, 5),
(6, 15, 3);

# --- !Downs

DROP TABLE IF EXISTS stock;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS suppliers;
DROP TABLE IF EXISTS categories;