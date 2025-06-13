<?php
session_start();
require_once "config.php";

$session_id = session_id();
$stmt = $conn->prepare("SELECT * FROM cart WHERE session_id = ?");
$stmt->bind_param("s", $session_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
?>

<!DOCTYPE html>
<html lang="lv">
<head>
  <meta charset="UTF-8">
  <title>Grozs</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
    }
    .cart-container {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      max-width: 600px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .back-button {
      display: inline-block;
      margin-bottom: 20px;
      text-decoration: none;
      color: #555;
    }
    h2 {
      margin-top: 0;
    }
    ul {
      list-style: none;
      padding: 0;
    }
    li {
      border-bottom: 1px solid #ccc;
      padding: 10px 0;
    }
    .total {
      font-weight: bold;
      margin-top: 10px;
    }
    .checkout-link {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 15px;
      background-color: #28a745;
      color: #fff;
      text-decoration: none;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <div class="cart-container">
    <a href="shop.php" class="back-button">← Atpakaļ</a>
    <h2>Jūsu grozs</h2>
    <ul>
      <?php while ($row = $result->fetch_assoc()): ?>
        <li><?= htmlspecialchars($row["product_name"]) ?> - <?= number_format($row["price"], 2) ?>€</li>
        <?php $total += $row["price"]; ?>
      <?php endwhile; ?>
    </ul>
    <p class="total">Kopā: <?= number_format($total, 2) ?>€</p>
    <a href="order.php" class="checkout-link">Izpildīt pasūtījumu</a>
  </div>
</body>
</html>
