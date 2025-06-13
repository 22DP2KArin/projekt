<div style="background-color:#2c2c2c; padding:10px; color:white;">
  <a href="shop.php" style="color:white; margin-right:15px;">Veikals</a>
  <form method="GET" action="shop.php" style="display:inline;">
    <input type="text" name="search" placeholder="Meklēt preces...">
    <button type="submit">Meklēt</button>
  </form>
  <a href="cart.php" style="color:white; margin-left:15px;">🛒 Grozs</a>
  <a href="checkout.php" style="color:white; margin-left:15px;">💳 Pasūtīt</a>
  <a href="guest.php" style="color:white; margin-left:15px;">👤 Gosti</a>
  <a href="admin_login.php" style="color:white; margin-left:15px;">🔐 Admins</a>
</div>


<?php
session_start();
$_SESSION["guest"] = true;
header("Location: shop.php");
exit;
