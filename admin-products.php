<?php
require 'config.php';

// Add product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $name, $description, $price, $stock);
    $stmt->execute();
}

// Delete product
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id = $id");
}

// Fetch all products
$products = $conn->query("SELECT * FROM products");
?>

<div class="container">
    <h2 class="mb-4">Manage Products</h2>
    
    <div class="card mb-4">
        <div class="card-header">
            <h4>Add New Product</h4>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="name" class="form-control" placeholder="Product Name" required>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text">R</span>
                            <input type="number" name="price" class="form-control" placeholder="Price (ZAR)" step="0.01" min="0" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="stock" class="form-control" placeholder="Stock" min="0" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" name="add_product" class="btn btn-success w-100">
                            <i class="fas fa-plus-circle me-1"></i> Add Product
                        </button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <textarea name="description" class="form-control" placeholder="Description" rows="2"></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h4>Product List</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price (ZAR)</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($product = $products->fetch_assoc()): 
    $formatted_price = number_format($product['price'], 2, ',', ' ');
    
    // Get stock value or default to 0 if not set
    $stock = $product['stock'] ?? 0;
?>
<tr>
    <td><?= $product['id'] ?></td>
    <td><?= htmlspecialchars($product['name']) ?></td>
    <td><?= htmlspecialchars(substr($product['description'], 0, 50)) ?>...</td>
    <td class="fw-bold">
        <span class="zar-currency">R</span> <?= $formatted_price ?>
    </td>
    <td>
        <span class="badge <?= $stock > 10 ? 'bg-success' : ($stock > 0 ? 'bg-warning' : 'bg-danger') ?>">
            <?= $stock ?>
        </span>
    </td>
    <td>
        <a href="?page=edit-product&id=<?= $product['id'] ?>" class="btn btn-sm btn-primary">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <a href="?page=products&delete=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
            <i class="fas fa-trash-alt me-1"></i> Delete
        </a>
    </td>
</tr>
<?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .zar-currency {
        font-size: 0.85em;
        vertical-align: top;
        margin-right: 2px;
        color: #28a745;
        font-weight: bold;
    }
</style>
