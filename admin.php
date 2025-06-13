<div style="background-color:#2c2c2c; padding:10px; color:white;">
  <a href="shop.php" style="color:white; margin-right:15px;">Veikals</a>
  <form method="GET" action="shop.php" style="display:inline;">
    <input type="text" name="search" placeholder="Meklēt preces...">
    <button type="submit">Meklēt</button>
  </form>
  <a href="cart.php" style="color:white; margin-left:15px;">🛒 Grozs</a>
  <a href="guest.php" style="color:white; margin-left:15px;">👤 Gosti</a>
  <a href="admin_login.php" style="color:white; margin-left:15px;">🔐 Admins</a>
</div>


<?php
session_start();
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
    header("Location: admin_login.php");
    exit;
}



// Dzēst lietotāju
if (isset($_GET["delete_user"])) {
    $id = $_GET["delete_user"];
    $conn->query("DELETE FROM users WHERE id = $id");
}

// Dzēst preci
if (isset($_GET["delete_product"])) {
    $id = $_GET["delete_product"];
    $conn->query("DELETE FROM products WHERE id = $id");
}

// Atjaunināt cenu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_price"])) {
    $id = $_POST["product_id"];
    $price = $_POST["new_price"];
    $stmt = $conn->prepare("UPDATE products SET price = ? WHERE id = ?");
    $stmt->bind_param("di", $price, $id);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="lv">
<head>
  <meta charset="UTF-8">
  <title>Admina Panelis</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Lietotāji</h2>
<table border="1">
<tr><th>ID</th><th>Lietotājvārds</th><th>Darbība</th></tr>
<?php
$result = $conn->query("SELECT * FROM users");
while ($user = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$user['id']}</td>
        <td>{$user['username']}</td>
        <td><a href='admin.php?delete_user={$user['id']}'>Dzēst</a></td>
    </tr>";
}
?>
</table>
<a href="logout.php" style="color:white; margin-left:15px;">🚪 Iziet</a>

<h2>Preces</h2>
<table border="1">
<tr><th>ID</th><th>Nosaukums</th><th>Cena</th><th>Darbība</th></tr>
<?php
$result = $conn->query("SELECT * FROM products");
while ($product = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$product['id']}</td>
        <td>{$product['name']}</td>
        <td>
          <form method='POST' style='display:inline;'>
            <input type='hidden' name='product_id' value='{$product['id']}'>
            <input type='text' name='new_price' value='{$product['price']}'>
            <button type='submit' name='update_price'>Saglabāt</button>
          </form>
        </td>
        <td><a href='admin.php?delete_product={$product['id']}'>Dzēst</a></td>
    </tr>";
}
if (isset($_GET["delete_user"])) {
    $id = intval($_GET["delete_user"]);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

if (isset($_GET["delete_product"])) {
    $id = intval($_GET["delete_product"]);
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

?>
</table>
</body>
</html>
