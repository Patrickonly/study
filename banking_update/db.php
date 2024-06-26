<?php
$dsn = 'mysql:host=localhost;dbname=banking_update';
$username = 'root';
$password = ''; // Use your database password

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
