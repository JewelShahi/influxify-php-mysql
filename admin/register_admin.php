<?php

// Trying to connect to the db
include '../components/connect.php';

// Start the session
session_start();

// Check if the admin has a session
if (isset($_SESSION['admin_id'])) {
  $admin_id = $_SESSION['admin_id'];
} else {
  $admin_id = '';
  header('Location: admin_login.php');
};

// Register
if (isset($_POST['submit'])) {

  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $pass = filter_var($_POST['pass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $hash_pass = sha1($pass);

  $cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $hash_cpass = sha1($cpass);

  // Validate email format
  if (!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $email)) {
    $message[] = 'Invalid email format!';
  }

  // Validate password length and format (e.g., at least 8 characters, one upper, one lower character and one digit)
  elseif (strlen($pass) < 8 || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/', $pass)) {
    $message[] = 'Password must be at least 8 characters and contain at least one uppercase letter, lowercase letter and a digit!';
  }

  // Check if the password match the entered
  elseif ($hash_pass != $hash_cpass) {
    $message[] = 'Confirm password not matched!';
  } else {
    try {

      $insert_admin = $conn->prepare("INSERT INTO `users` (name, email, password, isAdmin, avatar) VALUES (?, ?, ?, 1, 'logedin.png')");
      $insert_admin->execute([$name, $email, $hash_pass]);

      // Check if any rows were affected
      if ($insert_admin->rowCount() > 0) {
        $message[] = 'Admin registration was successful. Welcome aboard!';
      } else {
        $message[] = 'Error registering admin. Please try again.';
      }
    } catch (PDOException $e) {
      if ($e->errorInfo[1] == 1062) { // 1062 is the MySQL error code for duplicate entry
        $message[] = 'User with ' . $email . ' already exists!';
      } else {
        $message[] = 'Error: ' . $e->getMessage();
      }
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
  <title>Register An Admin</title>
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <!-- Custom css -->
  <link rel="stylesheet" href="../css/admin_style.css">
  <link rel="stylesheet" href="../css/global.css">

</head>

<body class="no-overflow">

  <!-- Navbar -->
  <?php include '../components/admin_header.php'; ?>

  <!-- Checks if the user is in the db -->
  <?php
  $select_admin_exists = $conn->prepare("SELECT id FROM `users` WHERE id = ? AND isAdmin = 1");
  $select_admin_exists->execute([$admin_id]);
  if ($select_admin_exists->rowCount() == 0) {
    header("Location: admin_login.php");
  } else {
  ?>
    <section class="register-admin">
      <div class="register-admin-blur">
        <form action="" method="post">

          <h3>Register an admin</h3>

          <input type="text" name="name" placeholder="Enter your username" maxlength="100" class="input box" required>
          <input type="email" name="email" placeholder="Enter your email" maxlength="50" class="input box" oninput="this.value = this.value.replace(/\s/g, '')" required>
          <div class="passwords">
            <div class="password-container">
              <input type="password" name="pass" placeholder="Enter your password" maxlength="20" class="input box" oninput="this.value = this.value.replace(/\s/g, '')" required>
              <span id="toggle" class="toggle-pass fas fa-eye" onclick="togglePassword(this)"></span>
            </div>
            <div class="password-container">
              <input type="password" name="cpass" placeholder="Confirm your password" maxlength="20" class="input box" oninput="this.value = this.value.replace(/\s/g, '')" required>
              <span id="toggle" class="toggle-pass fas fa-eye" onclick="togglePassword(this)"></span>
            </div>
          </div>
          <input type="submit" value="Register" class="btn" name="submit">
        </form>
      </div>
    </section>

  <?php
  }
  ?>

  <!-- Admin script -->
  <script src="../js/admin_script.js"></script>

  <!-- Toggle password -->
  <script src="../js/toggle_password.js"></script>
</body>

</html>