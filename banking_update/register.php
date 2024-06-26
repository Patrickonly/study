<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $opening_balance = $_POST['opening_balance'];

    $stmt = $pdo->prepare('INSERT INTO users (username, password, balance) VALUES (:username, :password, :balance)');
    $stmt->execute(['username' => $username, 'password' => $password, 'balance' => $opening_balance]);

    echo 'Registration successful! You can now <a href="login.php">login</a>.';
}
?>

<form method="POST">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    Opening Balance: <input type="number" name="opening_balance" required><br>
    <button type="submit">Register</button>
</form>
