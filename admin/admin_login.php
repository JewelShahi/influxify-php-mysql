<?php

// Trying to connect to the db
include '../components/connect.php';

// Start the session
session_start();

if (isset($_SESSION['admin_id'])) {
  $admin_id = $_SESSION['admin_id'];

  header("Location: dashboard.php");
}else {
  $admin_id = '';
};

if (isset($_POST['submit'])) {
  
  $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $pass = filter_var($_POST['pass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $hash_pass = sha1($pass);

  $select_admin = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? AND isAdmin = 1");
  $select_admin->execute([$email, $hash_pass]);
  $row = $select_admin->fetch(PDO::FETCH_ASSOC);

  if ($select_admin->rowCount() > 0) {

    $_SESSION['admin_id'] = $row['id'];

    header('Location: dashboard.php');
  } else {
    $message[] = 'Неправилно потребителско име или парола!';
  }
}
?>

<!DOCTYPE html>
<html lang="bg">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Админски вход</title>
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">
  
  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  
  <!-- Custom css -->
  <link rel="stylesheet" href="../css/admin_style.css">
  <link rel="stylesheet" href="../css/global.css">

</head>

<body>

<!-- Action message -->
  <?php
  if (isset($message)) {
    foreach ($message as $message) {
      echo '
        <div class="message">
          <span>' . $message . '</span>
          <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
      ';
    }
  }
  ?>

  <section class="admin-login">
    <div class="admin-login-bg">
      <form action="" method="post" class="admin-login-form">
        <h3>Админски вход</h3>
        <p>Имейл = <span>admin@admin.com</span> и Парола = <span>admin</span></p>
        <input type="email" name="email" required placeholder="Въведете имейл" maxlength="50" class="input box" oninput="this.value = this.value.replace(/\s/g, '')">
        <div class="password-container">
          <input type="password" name="pass" placeholder="Въведете парола" maxlength="20" class="input box" oninput="this.value = this.value.replace(/\s/g, '')" required>
          <span id="toggle" class="toggle-pass fas fa-eye" onclick="togglePassword(this)"></span>
        </div>
        <input type="submit" value="Вход" class="btn" name="submit">
      </form>
    </div>
  </section>

</body>

<!-- Toggle visibility of the password -->
<script src="../js/toggle_password.js"></script>

</html>