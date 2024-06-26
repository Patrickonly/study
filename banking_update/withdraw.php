<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];

    $stmt = $pdo->prepare('SELECT balance FROM users WHERE id = :id');
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user['balance'] >= $amount) {
        $stmt = $pdo->prepare('UPDATE users SET balance = balance - :amount WHERE id = :id');
        $stmt->execute(['amount' => $amount, 'id' => $_SESSION['user_id']]);
    } else {
        echo 'Insufficient balance';
    }

    header('Location: dashboard.php');
}
?>
