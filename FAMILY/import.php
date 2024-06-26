<?php
require 'config.php';

// Handle POST requests for adding, updating, and deleting imports
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_import'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $cost = $_POST['cost'];

        $stmt = $db->prepare("INSERT INTO import (product_id, quantity, price) VALUES (?, ?, ?)");
        $stmt->execute([$product_id, $quantity, $cost]);
    }

    if (isset($_POST['update_import'])) {
        $import_id = $_POST['import_id'];
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $cost = $_POST['cost'];

        $stmt = $db->prepare("UPDATE import SET product_id = ?, quantity = ?, price = ? WHERE import_id = ?");
        $stmt->execute([$product_id, $quantity, $cost, $import_id]);
    }

    if (isset($_POST['delete_import'])) {
        $import_id = $_POST['import_id'];

        $stmt = $db->prepare("DELETE FROM import WHERE import_id = ?");
        $stmt->execute([$import_id]);
    }
}

// Fetch all imports with product names
$imports = $db->query("SELECT import.*, products.name FROM import JOIN products ON import.product_id = products.product_id")->fetchAll(PDO::FETCH_ASSOC);

// Fetch all products for dropdown lists
$products = $db->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Imports</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Manage Imports</h2>
        
        <!-- Dashboard and Export Links -->
        <div class="mt-4 mb-4">
            <a href="dashboard.php" class="btn btn-primary mr-2">Dashboard</a>
            <a href="export.php" class="btn btn-success">Export Data</a>
            <a href="report.php" class="btn btn-primary">Report </a>
        </div>

        <h3 class="mt-4">Add Import</h3>
        <form method="POST" action="import.php">
            <div class="form-group">
                <label for="product_id">Product</label>
                <select class="form-control" id="product_id" name="product_id" required>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= $product['product_id'] ?>"><?= $product['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="form-group">
                <label for="cost">Cost</label>
                <input type="number" step="0.01" class="form-control" id="cost" name="cost" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_import">Add Import</button>
        </form>

        <h3 class="mt-4">Import List</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Cost</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($imports as $import): ?>
                    <tr>
                        <td><?= $import['import_id'] ?></td>
                        <td><?= $import['name'] ?></td>
                        <td><?= $import['quantity'] ?></td>
                        <td><?= $import['price'] ?></td>
                        <td>
                            <button class="btn btn-info" onclick="editImport(<?= $import['import_id'] ?>, <?= $import['product_id'] ?>, <?= $import['quantity'] ?>, <?= $import['price'] ?>)">Edit</button>
                            <form method="POST" action="import.php" class="d-inline">
                                <input type="hidden" name="import_id" value="<?= $import['import_id'] ?>">
                                <button type="submit" class="btn btn-danger" name="delete_import">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3 class="mt-4" id="update-import-title" style="display: none;">Update Import</h3>
        <form method="POST" action="import.php" id="update-import-form" style="display: none;">
            <input type="hidden" name="import_id" id="update-import-id">
            <div class="form-group">
                <label for="update-product_id">Product</label>
                <select class="form-control" id="update-product_id" name="product_id" required>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= $product['product_id'] ?>"><?= $product['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="update-quantity">Quantity</label>
                <input type="number" class="form-control" id="update-quantity" name="quantity" required>
            </div>
            <div class="form-group">
                <label for="update-cost">Cost</label>
                <input type="number" step="0.01" class="form-control" id="update-cost" name="cost" required>
            </div>
            <button type="submit" class="btn btn-primary" name="update_import">Update Import</button>
        </form>
    </div>
    <script>
        function editImport(import_id, product_id, quantity, cost) {
            document.getElementById('update-import-id').value = import_id;
            document.getElementById('update-product_id').value = product_id;
            document.getElementById('update-quantity').value = quantity;
            document.getElementById('update-cost').value = cost;
            document.getElementById('update-import-title').style.display = 'block';
            document.getElementById('update-import-form').style.display = 'block';
            window.scrollTo(0, document.getElementById('update-import-title').offsetTop);
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
