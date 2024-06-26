<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];

    $stmt = $pdo->prepare('UPDATE users SET balance = balance + :amount WHERE id = :id');
    $stmt->execute(['amount' => $amount, 'id' => $_SESSION['user_id']]);

    header('Location: dashboard.php');
}
?>
