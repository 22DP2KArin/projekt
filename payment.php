<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Simulēta maksājuma apstrāde
    unset($_SESSION["cart"]);
    echo "<h2>Paldies par pasūtījumu!</h2>";
    echo "<p>Rēķins nosūtīts uz e-pastu: {$_POST['email']}</p>";
    echo "<a href='shop.php'>Atpakaļ uz veikalu</a>";
} else {
    header("Location: checkout.php");
    exit;
}
