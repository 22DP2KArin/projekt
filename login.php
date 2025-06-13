<?php
session_start();
$error = $_SESSION["login_error"] ?? "";
unset($_SESSION["login_error"]);
?>
<!DOCTYPE html>
<html lang="lv">
<head>
  <meta charset="UTF-8">
  <title>Pieslēgties</title>
  <style>
    body {
      background-color: #2c2c2c;
      color: white;
      font-family: Arial, sans-serif;
      text-align: center;
      padding-top: 100px;
    }
    form {
      display: inline-block;
      background-color: #3a3a3a;
      padding: 30px;
      border-radius: 10px;
    }
    input {
      display: block;
      width: 250px;
      padding: 10px;
      margin: 10px auto;
      border-radius: 5px;
      border: none;
    }
    button {
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      font-size: 1em;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: #45a049;
    }
    .error {
      color: red;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <h2>Pieslēgties</h2>
  <form method="POST" action="shop.php">
    <input type="text" name="username" placeholder="Lietotājvārds" required>
    <input type="password" name="password" placeholder="Parole" required>
    <button type="submit">Ieiet</button>
  </form>
  <div class="error"><?= htmlspecialchars($error) ?></div>
</body>
</html>
