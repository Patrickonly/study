<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_product'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        $stmt = $db->prepare("INSERT INTO products (name, description, price) VALUES (?, ?, ?)");
        $stmt->execute([$name, $description, $price]);
    }

    if (isset($_POST['update_product'])) {
        $product_id = $_POST['product_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        $stmt = $db->prepare("UPDATE products SET name = ?, description = ?, price = ? WHERE product_id = ?");
        $stmt->execute([$name, $description, $price, $product_id]);
    }

    if (isset($_POST['delete_product'])) {
        $product_id = $_POST['product_id'];

        $stmt = $db->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->execute([$product_id]);
    }
}

$products = $db->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Dashboard</h2>
        
        <h3 class="mt-4">Add Product</h3>
        <form method="POST" action="dashboard.php">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_product">Add Product</button>
        </form>

        <h3 class="mt-4">Product List</h3>
        <div class="mb-3">
            <a href="export.php" class="btn btn-success">Export Products</a>
            <a href="import.php" class="btn btn-primary">Import Products</a>
              <a href="report.php" class="btn btn-primary">Report </a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['product_id'] ?></td>
                        <td><?= $product['name'] ?></td>
                        <td><?= $product['description'] ?></td>
                        <td><?= $product['price'] ?></td>
                        <td>
                            <button class="btn btn-info" onclick="editProduct(<?= $product['product_id'] ?>, '<?= $product['name'] ?>', '<?= $product['description'] ?>', <?= $product['price'] ?>)">Edit</button>
                            <form method="POST" action="dashboard.php" class="d-inline">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                <button type="submit" class="btn btn-danger" name="delete_product">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3 class="mt-4" id="update-product-title" style="display: none;">Update Product</h3>
        <form method="POST" action="dashboard.php" id="update-product-form" style="display: none;">
            <input type="hidden" name="product_id" id="update-product-id">
            <div class="form-group">
                <label for="update-name">Name</label>
                <input type="text" class="form-control" id="update-name" name="name" required>
            </div>
            <div class="form-group">
                <label for="update-description">Description</label>
                <textarea class="form-control" id="update-description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="update-price">Price</label>
                <input type="number" step="0.01" class="form-control" id="update-price" name="price" required>
            </div>
            <button type="submit" class="btn btn-primary" name="update_product">Update Product</button>
        </form>
    </div>
    <script>
        function editProduct(id, name, description, price) {
            document.getElementById('update-product-id').value = id;
            document.getElementById('update-name').value = name;
            document.getElementById('update-description').value = description;
            document.getElementById('update-price').value = price;
            document.getElementById('update-product-title').style.display = 'block';
            document.getElementById('update-product-form').style.display = 'block';
            window.scrollTo(0, document.getElementById('update-product-title').offsetTop);
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
