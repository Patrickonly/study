<?php
// Include your database configuration file
require 'config.php';

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Adding an export
    if (isset($_POST['add_export'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        // Fetch available quantity from import table
        $stmt = $db->prepare("SELECT SUM(quantity) AS total_quantity FROM import WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $import_quantity = $stmt->fetchColumn();

        // Check if quantity to export is greater than available quantity in import
        if ($import_quantity >= $quantity) {
            // Proceed with export
            $stmt = $db->prepare("INSERT INTO export (product_id, quantity, price) VALUES (?, ?, ?)");
            $stmt->execute([$product_id, $quantity, $price]);

            // Update import table to reduce quantity
            $stmt = $db->prepare("UPDATE import SET quantity = quantity - ? WHERE product_id = ? ORDER BY import_id ASC LIMIT 1");
            $stmt->execute([$quantity, $product_id]);

            // Optionally, you may want to handle success message or redirection
            // header('Location: export.php');
            // exit;
        } else {
            // Handle error: Quantity to export exceeds available quantity in import records.
            echo "Error: Quantity to export exceeds available quantity in import records.";
        }
    }

    // Deleting an export
    if (isset($_POST['delete_export'])) {
        $export_id = $_POST['export_id'];

        // Fetch export details to adjust import quantities
        $stmt = $db->prepare("SELECT * FROM export WHERE export_id = ?");
        $stmt->execute([$export_id]);
        $export = $stmt->fetch(PDO::FETCH_ASSOC);

        // Update import table to increase quantity
        $stmt = $db->prepare("UPDATE import SET quantity = quantity + ? WHERE product_id = ?");
        $stmt->execute([$export['quantity'], $export['product_id']]);

        // Delete export record
        $stmt = $db->prepare("DELETE FROM export WHERE export_id = ?");
        $stmt->execute([$export_id]);

        // Optionally, you may want to handle success message or redirection
        // header('Location: export.php');
        // exit;
    }

    // Updating an export
    if (isset($_POST['update_export'])) {
        $export_id = $_POST['update_export_id'];
        $product_id = $_POST['update_product_id'];
        $quantity = $_POST['update_quantity'];
        $price = $_POST['update_price'];

        // Fetch current export details
        $stmt = $db->prepare("SELECT * FROM export WHERE export_id = ?");
        $stmt->execute([$export_id]);
        $current_export = $stmt->fetch(PDO::FETCH_ASSOC);

        // Calculate difference in quantity
        $quantity_diff = $quantity - $current_export['quantity'];

        // Check if there's enough quantity in import to cover the difference
        $stmt = $db->prepare("SELECT SUM(quantity) AS total_quantity FROM import WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $import_quantity = $stmt->fetchColumn();

        if ($import_quantity >= $quantity_diff) {
            // Update export record
            $stmt = $db->prepare("UPDATE export SET product_id = ?, quantity = ?, price = ? WHERE export_id = ?");
            $stmt->execute([$product_id, $quantity, $price, $export_id]);

            // Update import table to adjust quantity
            $stmt = $db->prepare("UPDATE import SET quantity = quantity - ? WHERE product_id = ? ORDER BY import_id ASC LIMIT 1");
            $stmt->execute([$quantity_diff, $product_id]);

            // Optionally, you may want to handle success message or redirection
            // header('Location: export.php');
            // exit;
        } else {
            // Handle error: Quantity to update exceeds available quantity in import records.
            echo "Error: Quantity to update exceeds available quantity in import records.";
        }
    }
}

// Fetch all exports with product names
$exports = $db->query("SELECT export.*, products.name FROM export JOIN products ON export.product_id = products.product_id")->fetchAll(PDO::FETCH_ASSOC);

// Fetch all products for dropdown lists
$products = $db->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Exports</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Manage Exports</h2>
        
        <!-- Dashboard and Export Links -->
        <div class="mt-4 mb-4">
            <a href="dashboard.php" class="btn btn-primary mr-2">Dashboard</a>
            <a href="import.php" class="btn btn-success">Import Data</a>
            <a href="report.php" class="btn btn-primary">Report</a>
        </div>

        <h3 class="mt-4">Add Export</h3>
        <form method="POST" action="export.php">
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
                <label for="price">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_export">Add Export</button>
        </form>

        <h3 class="mt-4">Export List</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exports as $export): ?>
                    <tr>
                        <td><?= $export['export_id'] ?></td>
                        <td><?= $export['name'] ?></td>
                        <td><?= $export['quantity'] ?></td>
                        <td><?= $export['price'] ?></td>
                        <td>
                            <!-- Update form (hidden by default) -->
                            <form method="POST" action="export.php" class="d-inline" id="form-update-<?= $export['export_id'] ?>" style="display: none;">
                                <input type="hidden" name="update_export_id" value="<?= $export['export_id'] ?>">
                                <div class="form-group">
                                    <label for="update_product_id">Product</label>
                                    <select class="form-control" id="update_product_id" name="update_product_id" required>
                                        <?php foreach ($products as $product): ?>
                                            <option value="<?= $product['product_id'] ?>" <?= ($product['product_id'] == $export['product_id']) ? 'selected' : '' ?>><?= $product['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="update_quantity">Quantity</label>
                                    <input type="number" class="form-control" id="update_quantity" name="update_quantity" value="<?= $export['quantity'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="update_price">Price</label>
                                    <input type="number" step="0.01" class="form-control" id="update_price" name="update_price" value="<?= $export['price'] ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary" name="update_export">Update</button>
                               
                            </form>

                            <!-- Edit button -->
                          

                            <!-- Delete form -->
                            <form method="POST" action="export.php" class="d-inline">
                                <input type="hidden" name="export_id" value="<?= $export['export_id'] ?>">
                                <button type="submit" class="btn btn-danger" name="delete_export">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function showUpdateForm(export_id) {
            // Hide all update forms first
            var forms = document.querySelectorAll('form[id^="form-update-"]');
            forms.forEach(function(form) {
                form.style.display = 'none';
            });

            // Show the selected update form
            var form = document.getElementById('form-update-' + export_id);
            form.style.display = 'block';
        }

        function cancelUpdate(export_id) {
            // Hide the update form
            var form = document.getElementById('form-update-' + export_id);
            form.style.display = 'none';
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
