<?php
// Include your database configuration file
require 'config.php';

// Fetch products with their import and export data
$stmt = $db->query("
    SELECT 
        p.product_id,
        p.name AS product_name,
        COALESCE(SUM(i.quantity), 0) AS total_import_quantity,
        COALESCE(SUM(i.quantity * i.price), 0) AS total_import_cost,
        COALESCE(SUM(e.quantity), 0) AS total_export_quantity,
        COALESCE(SUM(e.quantity * e.price), 0) AS total_export_revenue
    FROM products p
    LEFT JOIN import i ON p.product_id = i.product_id
    LEFT JOIN export e ON p.product_id = e.product_id
    GROUP BY p.product_id, p.name
");
$products_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate profit or loss for each product
$report_data = [];
foreach ($products_data as $product) {
    $profit_loss = $product['total_export_revenue'] - $product['total_import_cost'];
    $report_data[] = [
        'product_id' => $product['product_id'],
        'product_name' => $product['product_name'],
        'total_import_quantity' => $product['total_import_quantity'],
        'total_import_cost' => $product['total_import_cost'],
        'total_export_quantity' => $product['total_export_quantity'],
        'total_export_revenue' => $product['total_export_revenue'],
        'profit_loss' => $profit_loss,
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Report</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Product Report</h2>

        <!-- Navigation Links -->
        <div class="mt-4 mb-4">
            <a href="dashboard.php" class="btn btn-primary mr-2">Dashboard</a>
            <a href="import.php" class="btn btn-primary mr-2">Import</a>
            <a href="export.php" class="btn btn-success mr-2">Export</a>
            <a href="report.php" class="btn btn-info">Report</a>
        </div>

        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Total Import Quantity</th>
                        <th>Total Import Cost ($)</th>
                        <th>Total Export Quantity</th>
                        <th>Total Export Revenue ($)</th>
                        <th>Profit/Loss ($)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($report_data as $item): ?>
                        <tr>
                            <td><?= $item['product_id'] ?></td>
                            <td><?= $item['product_name'] ?></td>
                            <td><?= $item['total_import_quantity'] ?></td>
                            <td><?= number_format($item['total_import_cost'], 2) ?></td>
                            <td><?= $item['total_export_quantity'] ?></td>
                            <td><?= number_format($item['total_export_revenue'], 2) ?></td>
                            <td><?= number_format($item['profit_loss'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
