<?php
session_start();
require_once "config.php";

$username = $_POST["username"] ?? "";
$password = $_POST["password"] ?? "";

if (strlen($username) < 3 || strlen($password) < 5) {
    $_SESSION["register_error"] = "Lietotājvārds vai parole ir pārāk īsi.";
    header("Location: register.php");
    exit;
}

$sql = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION["register_error"] = "Šis lietotājvārds jau eksistē.";
    header("Location: register.php");
    exit;
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO users (username, password, is_admin) VALUES (?, ?, 0)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $hashed_password);
$stmt->execute();

$_SESSION["user_id"] = $stmt->insert_id;
$_SESSION["username"] = $username;
$_SESSION["is_admin"] = false;

header("Location: shop.php");
exit;
?>
