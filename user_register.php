<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
};

if (isset($_POST['submit'])) {

  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $pass = sha1($_POST['pass']);
  $pass = filter_var($pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $cpass = sha1($_POST['cpass']);
  $cpass = filter_var($cpass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  if ($pass != $cpass) {
    $message[] = 'Confirm password not matched!';
  } else {
    try {
      $insert_user = $conn->prepare("INSERT INTO `users` (name, email, password, avatar) VALUES (?, ?, ?, 'logedin.png')");
      $insert_user->execute([$name, $email, $pass]);

      // Check if any rows were affected
      if ($insert_user->rowCount() > 0) {
        $message[] = 'User registered successfully!';
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
        <input type="text" name="name" required placeholder="Enter your username" maxlength="20" class="input box">
        <input type="email" name="email" required placeholder="Enter your email" maxlength="50" class="input box" oninput="this.value = this.value.replace(/\s/g, '')">
        <div class="passwords">
          <input type="password" name="pass" required placeholder="Enter your password" maxlength="20" class="input box" oninput="this.value = this.value.replace(/\s/g, '')">
          <input type="password" name="cpass" required placeholder="Confirm your password" maxlength="20" class="input box" oninput="this.value = this.value.replace(/\s/g, '')">
        </div>
        <input type="submit" value="Register" class="btn" name="submit">
        <p>Already have an account?<br>Then just log in and pick up where you left off!</p>
        <a href="user_login.php" class="option-btn">Log In</a>
      </form>
    </div>
  </section>
  <!-- <?php include 'components/footer.php'; ?> -->

  <script src="js/user_script.js"></script>
  <?php include 'components/scroll_up.php'; ?>
  <script src="js/scrollUp.js"></script>
</body>

</html>