<?php
require 'config.php';

// Fetch data
$users = $conn->query("SELECT * FROM users");
$orders = $conn->query("SELECT orders.*, users.name FROM orders JOIN users ON orders.user_id = users.id ORDER BY created_at DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Use the same CSS/JS from index.html -->
    <title>Admin Dashboard</title>
</head>
<body>
    <!-- Admin sidebar and header from prototype -->

    <div class="col-lg-9">
        <!-- Dynamic content -->
        <div class="row mb-4">
            <div class="col-md-3 col-6">
                <div class="dashboard-card text-center p-4 bg-white">
                    <div class="card-icon text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="mb-2">
                        <?= $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0] ?>
                    </h3>
                    <p class="mb-0 text-muted">Total Users</p>
                </div>
            </div>
            <!-- Add other cards similarly -->
        </div>

        <!-- Orders Table -->
        <div class="data-table mb-4">
            <table class="table table-hover mb-0">
                <thead><tr><th>Order ID</th><th>Customer</th><th>Amount</th><th>Status</th></tr></thead>
                <tbody>
                    <?php while($order = $orders->fetch_assoc()): ?>
                    <tr>
                        <td>#ORD-<?= $order['id'] ?></td>
                        <td><?= $order['name'] ?></td>
                        <td>$<?= number_format($order['amount'], 2) ?></td>
                        <td>
                            <span class="status-badge badge-<?= 
                                $order['status'] == 'delivered' ? 'delivered' : 
                                ($order['status'] == 'processing' ? 'processing' : 'pending')
                            ?>">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
