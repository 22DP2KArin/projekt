<?php
$host = "127.0.0.1";
$db = "projekt";
$user = "root";
$pass = "";
$port = 3307;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Savienojuma kļūda: " . $conn->connect_error);
}
?>
