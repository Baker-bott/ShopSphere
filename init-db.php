<?php
// init-db.php - Database initialization script

// Database credentials
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is empty
$dbname = "ecommerce_db";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS `$dbname`";
if ($conn->query($sql)) {
    echo "Database created successfully<br>";
} else {
    die("Error creating database: " . $conn->error);
}

// Select database
$conn->select_db($dbname);

// SQL to create tables
$sql = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','manager','support','moderator','analyst','customer') DEFAULT 'customer',
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category_id INT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE IF NOT EXISTS reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    role_required VARCHAR(50) NOT NULL,
    sql_query TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
";

// Execute multi query to create tables
if ($conn->multi_query($sql)) {
    echo "Tables created successfully<br>";
    while ($conn->next_result()) { /* flush results */ }
} else {
    die("Error creating tables: " . $conn->error);
}

// Hash password once for reuse
$hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);

// SQL to insert initial data
$sql = "
-- Insert categories
INSERT INTO categories (name) VALUES 
('Electronics'), 
('Fashion'), 
('Home & Kitchen'), 
('Books'), 
('Toys');

-- Insert users
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@shopsphere.com', '$hashedPassword', 'admin'),
('Manager User', 'manager@shopsphere.com', '$hashedPassword', 'manager'),
('Support Staff', 'support@shopsphere.com', '$hashedPassword', 'support'),
('Content Moderator', 'moderator@shopsphere.com', '$hashedPassword', 'moderator'),
('Data Analyst', 'analyst@shopsphere.com', '$hashedPassword', 'analyst'),
('John Customer', 'john@example.com', '$hashedPassword', 'customer'),
('Sarah Shopper', 'sarah@example.com', '$hashedPassword', 'customer');

-- Insert products
INSERT INTO products (name, description, price, category_id, image_url) VALUES
('Smart Watch Pro', 'Fitness tracker with heart monitor', 129.99, 1, 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?auto=format&fit=crop&w=500&q=80'),
('Wireless Headphones', 'Noise cancelling Bluetooth', 89.99, 1, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=500&q=80'),
('Smart Home Camera', '1080p HD with night vision', 64.99, 1, 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=500&q=80'),
('Bluetooth Speaker', '360° Surround Sound Portable Speaker', 45.99, 1, 'https://images.unsplash.com/photo-1585155770447-2f66e2a397b5?auto=format&fit=crop&w=500&q=80'),
('Novel: The Great Adventure', 'Bestselling fiction novel', 14.99, 4, 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=500&q=80');

-- Insert orders
INSERT INTO orders (user_id, amount, status) VALUES
(6, 129.99, 'processing'),
(7, 89.99, 'delivered'),
(6, 245.50, 'pending'),
(7, 64.99, 'cancelled'),
(6, 320.75, 'shipped');

-- Insert order items
INSERT INTO order_items (order_id, product_id, quantity, price) VALUES
(1, 1, 1, 129.99),
(2, 2, 1, 89.99),
(3, 1, 1, 129.99),
(3, 4, 1, 45.99),
(3, 5, 2, 29.98),
(4, 3, 1, 64.99),
(5, 1, 1, 129.99),
(5, 2, 1, 89.99),
(5, 4, 1, 45.99),
(5, 5, 1, 14.99);

-- Insert reports
INSERT INTO reports (name, description, role_required, sql_query) VALUES
('Sales Report', 'Monthly sales summary', 'admin', 'SELECT MONTH(created_at) AS month, SUM(amount) AS total_sales FROM orders GROUP BY MONTH(created_at)'),
('Customer Report', 'Active customer list', 'manager', 'SELECT id, name, email, created_at FROM users WHERE role = \'customer\' AND status = \'active\''),
('Product Report', 'Top selling products', 'analyst', 'SELECT p.name, SUM(oi.quantity) AS total_sold FROM products p JOIN order_items oi ON p.id = oi.product_id GROUP BY p.id ORDER BY total_sold DESC'),
('Order Status', 'Orders by status', 'support', 'SELECT status, COUNT(*) AS count FROM orders GROUP BY status'),
('Revenue by Category', 'Revenue breakdown by category', 'analyst', 'SELECT c.name, SUM(oi.quantity * oi.price) AS revenue FROM categories c JOIN products p ON c.id = p.category_id JOIN order_items oi ON p.id = oi.product_id GROUP BY c.id');
";

// Execute multi query to insert data
if ($conn->multi_query($sql)) {
    echo "Dummy data inserted successfully<br>";
    while ($conn->next_result()) { /* flush results */ }
} else {
    die("Error inserting data: " . $conn->error);
}

$conn->close();
echo "Database setup completed successfully!";
?>
