<?php
session_start();
require_once "config.php";

$username = $_POST["username"] ?? "";
$password = $_POST["password"] ?? "";

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["is_admin"] = $user["is_admin"] ?? false;
        header("Location: shop.php");
        exit;
    }
}

$_SESSION["login_error"] = "Nepareizs lietotājvārds vai parole.";
header("Location: login.php");
exit;
?>
