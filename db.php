<?php
$host = '127.0.0.1';
$port = '3307'; // Указать порт, если не стандартный
$user = 'root';
$password = '';
$database = 'projekt';

// Создание подключения
$conn = new mysqli($host, $user, $password, $database, $port);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
