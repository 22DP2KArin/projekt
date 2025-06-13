<?php
@include 'config.php';
session_start();

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $pass = $_POST['password'];

    $select = mysqli_query($conn, "SELECT * FROM admins WHERE username = '$name'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        
        if (password_verify($pass, $row['password'])) {
            $_SESSION['admin_name'] = $row['username'];
            header('location:admin.php');
            exit();
        } else {
            $error = 'Nepareiza parole.';
        }
    } else {
        $error = 'Lietotājs nav atrasts.';
    }
}
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Admina Pieslēgšanās</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .form-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f8f8f8;
        }
        h3 {
            text-align: center;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        .form-btn {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
        }
        .error-msg {
            color: red;
            display: block;
            text-align: center;
            margin-bottom: 10px;
        }
        .top-nav {
            background-color:#2c2c2c; 
            padding:10px; 
            color:white; 
            text-align: left;
        }
        .top-nav a {
            color: white; 
            margin-right: 15px;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="top-nav">
  <a href="shop.php">Veikals</a>
  <a href="cart.php">🛒 Grozs</a>
  <a href="guest.php">👤 Viesis</a>
  <a href="admin_login.php">🔐 Admins</a>
</div>

<div class="form-container">
    <form action="" method="post">
        <h3>Admina Pieslēgšanās</h3>
        <?php if(isset($error)) echo '<span class="error-msg">'.$error.'</span>'; ?>
        <input type="text" name="name" required placeholder="Lietotājvārds">
        <input type="password" name="password" required placeholder="Parole">
        <input type="submit" name="submit" value="Pieslēgties" class="form-btn">
    </form>
</div>
</body>
</html>
