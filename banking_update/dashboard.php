<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<h1>Welcome, <?php echo htmlspecialchars($user['username']); ?></h1>
<p>Balance: $<?php echo number_format($user['balance'], 2); ?></p>

<form method="POST" action="deposit.php">
    Deposit Amount: <input type="number" name="amount" required><br>
    <button type="submit">Deposit</button>
</form>

<form method="POST" action="withdraw.php">
    Withdraw Amount: <input type="number" name="amount" required><br>
    <button type="submit">Withdraw</button>
</form>

<a href="logout.php">Logout</a>
