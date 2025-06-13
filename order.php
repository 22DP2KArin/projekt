<?php
session_start();
require_once "config.php";

$session_id = session_id();
$message = "";

// Если форма отправлена
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_order"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    // Получить корзину
    $stmt = $conn->prepare("SELECT * FROM cart WHERE session_id = ?");
    $stmt->bind_param("s", $session_id);
    $stmt->execute();
    $cartItems = $stmt->get_result();

    $total = 0;
    $orderDetails = "";

    while ($item = $cartItems->fetch_assoc()) {
        $total += $item['price'] * $item['quantity'];
        $orderDetails .= $item['product_name'] . " (" . $item['price'] . "€), ";
    }

    // Сохранить заказ
    $stmt = $conn->prepare("INSERT INTO orders (session_id, customer_name, email, address, total, order_details) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssds", $session_id, $name, $email, $address, $total, $orderDetails);
    if ($stmt->execute()) {
        $message = "Paldies par pasūtījumu!";
        // Очистить корзину
        $conn->query("DELETE FROM cart WHERE session_id = '$session_id'");
    } else {
        $message = "Kļūda saglabājot pasūtījumu.";
    }
}
?>
<!DOCTYPE html>
<html lang="lv">
<head>
  <meta charset="UTF-8">
  <title>Pasūtījums</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="navbar">
    <img src="photo_5908834535334857354_x.jpg" class="logo" alt="Logo">
    <div><a href="shop.php" class="back-button">⬅ Atpakaļ uz veikalu</a></div>
  </div>

  <div class="form-container">
    <h2>Pasūtījuma forma</h2>
    <form method="POST">
      <label>Vārds:</label><br>
      <input type="text" name="name" required><br>
      <label>E-pasts:</label><br>
      <input type="email" name="email" required><br>
      <label>Adrese:</label><br>
      <textarea name="address" required></textarea><br>
      <button type="submit" name="submit_order">Veikt pasūtījumu</button>
    </form>
    <p><?= $message ?></p>
  </div>
</body>
</html>
