<?php

include 'components/connect.php';
session_name('user_session');
session_start();

if (isset($_SESSION['user']['user_id'])) {
  $user_id = $_SESSION['user']['user_id'];
} else {
  $user_id = '';
};

if (isset($_POST['submit'])) {

  $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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

      $insert_user = $conn->prepare("INSERT INTO `users` (name, email, password, avatar) VALUES (?, ?, ?, 'logedin.png')");
      $insert_user->execute([$name, $email, $hash_pass]);

      // Check if any rows were affected
      if ($insert_user->rowCount() > 0) {
        $message[] = 'User registered successfully!';
        header("location:user_login.php");
      } else {
        $message[] = 'Error registering user. Please try again.';
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
  <title>Register User</title>
  <link rel="shortcut icon" href="images/influxify-logo.ico" type="image/x-icon">
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- custom css file link  -->
  <link rel="stylesheet" href="css/global.css">

  <link rel="stylesheet" href="css/user_style.css">
</head>

<body class="no-overflow">

  <?php include 'components/user_header.php'; ?>

  <section class="user-register">
    <div>
      <form action="" method="post">
        <h3>Register</h3>
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
        <p>Already have an account?<br>Then just log in and pick up where you left off!</p>
        <a href="user_login.php" class="option-btn">Log In</a>
      </form>
    </div>
  </section>

  <script src="js/user_script.js"></script>
  <?php include 'components/scroll_up.php'; ?>
  <script src="js/scrollUp.js"></script>
  <script src="js/toggle_password.js"></script>
</body>

</html>