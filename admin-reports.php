<?php
require 'config.php';

// Date range filtering
$start_date = $_GET['start_date'] ?? date('Y-m-01');
$end_date = $_GET['end_date'] ?? date('Y-m-t');

// Sales report
$sales_report = $conn->query("
    SELECT DATE(order_date) AS order_day, 
           COUNT(*) AS order_count, 
           SUM(total_amount) AS total_sales 
    FROM orders 
    WHERE order_date BETWEEN '$start_date' AND '$end_date 23:59:59'
    GROUP BY DATE(order_date)
");

// Top products
$top_products = $conn->query("
    SELECT p.name, SUM(oi.quantity) AS total_sold
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    GROUP BY p.id
    ORDER BY total_sold DESC
    LIMIT 5
");
?>

<div class="container">
    <h2 class="mb-4">Sales Reports</h2>
    
    <div class="card mb-4">
        <div class="card-header">
            <h4>Filter Report</h4>
        </div>
        <div class="card-body">
            <form method="GET">
                <input type="hidden" name="page" value="reports">
                <div class="row">
                    <div class="col-md-3">
                        <label>Start Date</label>
                        <input type="date" name="start_date" value="<?= $start_date ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>End Date</label>
                        <input type="date" name="end_date" value="<?= $end_date ?>" class="form-control">
                    </div>
                    <div class="col-md-2 align-self-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                    <div class="col-md-4 align-self-end text-end">
                        <a href="?page=reports&export=1" class="btn btn-success">Export to CSV</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Sales Report (<?= date('M d, Y', strtotime($start_date)) ?> - <?= date('M d, Y', strtotime($end_date)) ?>)</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Orders</th>
                                <th>Total Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $grand_total = 0;
                            while ($row = $sales_report->fetch_assoc()): 
                                $grand_total += $row['total_sales'];
                            ?>
                            <tr>
                                <td><?= date('M d, Y', strtotime($row['order_day'])) ?></td>
                                <td><?= $row['order_count'] ?></td>
                                <td>$<?= number_format($row['total_sales'], 2) ?></td>
                            </tr>
                            <?php endwhile; ?>
                            <tr class="table-primary">
                                <td><strong>Grand Total</strong></td>
                                <td></td>
                                <td><strong>$<?= number_format($grand_total, 2) ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Top Selling Products</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php while ($product = $top_products->fetch_assoc()): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= htmlspecialchars($product['name']) ?>
                            <span class="badge bg-primary rounded-pill"><?= $product['total_sold'] ?> sold</span>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>