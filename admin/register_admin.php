<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:admin_login.php');
}

if (isset($_POST['submit'])) {

  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $pass = sha1($_POST['pass']);
  $pass = filter_var($pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $cpass = sha1($_POST['cpass']);
  $cpass = filter_var($cpass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $select_admin = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
  $select_admin->execute([$email]);

  if ($select_admin->rowCount() > 0) {
    $message[] = 'User with '.$email.' already exist!';
  } else {
    if ($pass != $cpass) {
      $message[] = 'Confirm password not matched!';
    } else {
      $insert_admin = $conn->prepare("INSERT INTO `users`(name, email, password, isAdmin) VALUES(?,?,?, 1)");
      $insert_admin->execute([$name, $email, $pass]);
      $message[] = 'New administrator registration was successful. Welcome aboard!';
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register an admin</title>
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="../css/admin_style.css">
  <link rel="stylesheet" href="../css/global.css">

</head>

<body>
  <?php include '../components/admin_header.php'; ?>
  <section class="form-container">
    <form action="" method="post">
      <h3>Register</h3>
      <input type="text" name="name" required placeholder="Enter your name" maxlength="20" class="input box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="email" name="email" required placeholder="Enter your e-mail" maxlength="20" class="input box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Enter your password" maxlength="20" class="input box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="Confirm your password" maxlength="20" class="input box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Register" class="btn" name="submit">
    </form>
  </section>
  <script src="../js/admin_script.js"></script>
</body>

</html>