<?php

// Trying to connect to the db
include '../components/connect.php';

// Start the session
session_start();

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
    $message[] = 'Incorrect username or password!';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log In Admin</title>
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
        <h3>Admin Log In</h3>
        <p>Email = <span>admin@admin.com</span> and Password = <span>admin</span></p>
        <input type="email" name="email" required placeholder="Enter your email" maxlength="50" class="input box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="pass" required placeholder="Enter your password" maxlength="20" class="input box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="submit" value="Log In" class="btn" name="submit">
      </form>
    </div>
  </section>

</body>

</html>