<?php
require 'config.php';

// Test users table
echo "<h2>Users</h2>";
$result = $conn->query("SELECT * FROM users");
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".$row["email"]."</td><td>".$row["role"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 users found";
}

// Test products table
echo "<h2>Products</h2>";
$result = $conn->query("SELECT * FROM products");
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Price</th><th>Category</th></tr>";
    while($row = $result->fetch_assoc()) {
        // Get category name
        $cat_result = $conn->query("SELECT name FROM categories WHERE id = ".$row["category_id"]);
        $cat_row = $cat_result->fetch_assoc();
        $category = $cat_row ? $cat_row["name"] : "N/A";
        
        echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>$".$row["price"]."</td><td>".$category."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 products found";
}

// Test orders table
echo "<h2>Orders</h2>";
$result = $conn->query("SELECT o.id, u.name AS customer, o.amount, o.status, o.created_at 
                       FROM orders o 
                       JOIN users u ON o.user_id = u.id");
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>Order ID</th><th>Customer</th><th>Amount</th><th>Status</th><th>Date</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["customer"]."</td><td>$".$row["amount"]."</td><td>".$row["status"]."</td><td>".$row["created_at"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 orders found";
}

$conn->close();
?>