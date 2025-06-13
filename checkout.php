<div style="background-color:#2c2c2c; padding:10px; color:white;">
  <a href="shop.php" style="color:white; margin-right:15px;">Veikals</a>
  <form method="GET" action="shop.php" style="display:inline;">
    <input type="text" name="search" placeholder="Meklēt preces...">
    <button type="submit">Meklēt</button>
  </form>
  <a href="cart.php" style="color:white; margin-left:15px;">🛒 Grozs</a>
  <a href="checkout.php" style="color:white; margin-left:15px;">💳 Pasūtīt</a>
  <a href="guest.php" style="color:white; margin-left:15px;">👤 Viesis</a>
  <a href="admin_login.php" style="color:white; margin-left:15px;">🔐 Admins</a>
</div>


<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["cart"]) || count($_SESSION["cart"]) == 0) {
    echo "Jūsu grozs ir tukšs.";
    exit;
}

$total = 0;
?>
<!DOCTYPE html>
<html lang="lv">
<head>
  <meta charset="UTF-8">
  <title>Pasūtījuma noformēšana</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Pasūtījuma noformēšana</h2>
<form method="POST" action="payment.php">
  Vārds: <input type="text" name="name" required><br>
  Adrese: <input type="text" name="address" required><br>
  E-pasts: <input type="email" name="email" required><br>
  <h3>Preces:</h3>
  <ul>
<?php
foreach ($_SESSION["cart"] as $product) {
    echo "<li>{$product['name']} - {$product['price']}€</li>";
    $total += $product['price'];
}
?>
  </ul>
  <p>Kopā: <strong><?= number_format($total, 2) ?>€</strong></p>
  <button type="submit">Apmaksāt</button>
</form>
</body>
</html>
