<?php
require 'config.php';
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

// Fetch counts for dashboard
$user_count = $product_count = $order_count = $total_sales = 0;

$result = $conn->query("SELECT COUNT(*) AS count FROM users");
if ($result) $user_count = $result->fetch_assoc()['count'];

$result = $conn->query("SELECT COUNT(*) AS count FROM products");
if ($result) $product_count = $result->fetch_assoc()['count'];

$result = $conn->query("SELECT COUNT(*) AS count FROM orders");
if ($result) $order_count = $result->fetch_assoc()['count'];

$result = $conn->query("SELECT SUM(total_price) AS total FROM orders WHERE status='completed'");
if ($result && $row = $result->fetch_assoc()) $total_sales = $row['total'] ?? 0;

// Format total sales in South African Rand format
$formatted_total_sales = number_format($total_sales, 2, ',', ' ');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            background-color: #f8f9fa;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .sidebar .nav-link {
            color: #333;
            padding: 10px 15px;
            margin: 5px 10px;
            border-radius: 5px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }
        .card {
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .zar-currency {
            font-size: 0.8em;
            vertical-align: super;
            margin-right: 2px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar d-none d-md-block">
                <h4 class="text-center mb-4">ShopSphere Admin</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="admin.php">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=users">
                            <i class="fas fa-users me-2"></i> Manage Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=products">
                            <i class="fas fa-box me-2"></i> Manage Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=orders">
                            <i class="fas fa-shopping-cart me-2"></i> View Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=reports">
                            <i class="fas fa-chart-bar me-2"></i> Generate Reports
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a class="nav-link text-danger" href="admin-logout.php">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 ms-sm-auto main-content">
                <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
                    <div class="container-fluid">
                        <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <a class="navbar-brand" href="#">Admin Dashboard</a>
                    </div>
                </nav>

                <?php
                // Page content based on selection
                $page = $_GET['page'] ?? 'dashboard';
                
                switch ($page) {
                    case 'users':
                        include 'admin-users.php';
                        break;
                    case 'products':
                        include 'admin-products.php';
                        break;
                    case 'orders':
                        include 'admin-orders.php';
                        break;
                    case 'reports':
                        include 'admin-reports.php';
                        break;
                    default:
                        // Dashboard view
                        ?>
                        <h1 class="mb-4">Dashboard Overview</h1>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5><i class="fas fa-users"></i> Users</h5>
                                        <h2><?= $user_count ?></h2>
                                        <a href="?page=users" class="btn btn-sm btn-outline-primary">Manage Users</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5><i class="fas fa-box"></i> Products</h5>
                                        <h2><?= $product_count ?></h2>
                                        <a href="?page=products" class="btn btn-sm btn-outline-primary">Manage Products</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5><i class="fas fa-shopping-cart"></i> Orders</h5>
                                        <h2><?= $order_count ?></h2>
                                        <a href="?page=orders" class="btn btn-sm btn-outline-primary">View Orders</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <!-- Updated for ZAR currency -->
                                        <h5><i class="fas fa-money-bill-wave"></i> Total Sales (ZAR)</h5>
                                        <h2>
                                            <span class="zar-currency">R</span>
                                            <?= $formatted_total_sales ?>
                                        </h2>
                                        <a href="?page=reports" class="btn btn-sm btn-outline-primary">View Reports</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-5">
                            <a href="init-db.php" class="btn btn-warning">Reinitialize Database</a>
                            <small class="text-muted d-block mt-2">Only use this for development purposes</small>
                        </div>
                        <?php
                        break;
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile sidebar toggle
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('d-none');
        });
    </script>
</body>
</html>