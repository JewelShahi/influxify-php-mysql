<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
};

if (isset($_POST['submit'])) {

  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_STRING);
  $pass = sha1($_POST['pass']);
  $pass = filter_var($pass, FILTER_SANITIZE_STRING);

  $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? AND isAdmin = 0");
  $select_user->execute([$email, $pass]);
  $row = $select_user->fetch(PDO::FETCH_ASSOC);

  if ($select_user->rowCount() > 0) {
    $_SESSION['user_id'] = $row['id'];
    header('location:home.php');
  } else {
    $message[] = "<span style='color: black;'>Incorrect <span style='color:red;'>username</span> or <span style='color:red;'>password</span>!</span>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LogIn User</title>
  <link rel="shortcut icon" href="images/influxify-logo.ico" type="image/x-icon">
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- custom css file link  -->
  <link rel="stylesheet" href="css/global.css">

  <link rel="stylesheet" href="css/user_style.css">
</head>

<body class="no-overflow">

  <?php include 'components/user_header.php'; ?>

  <section class="user-login">
    <div>
      <form action="" method="post">
        <h3>Log In</h3>
        <input type="email" name="email" required placeholder="Enter your email" maxlength="50" class="input box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="pass" required placeholder="Enter your password" maxlength="20" class="input box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="submit" value="Log In" class="btn" name="submit">
        <p>Don't have an account?<br>Go ahead and create one for free!</p>
        <a href="user_register.php" class="option-btn">Register</a>
      </form>
    </div>
  </section>
  <!-- <?php include 'components/footer.php'; ?> -->
  <script src="js/user_script.js"></script>
  <?php include 'components/scroll_up.php'; ?>
  <script src="js/scrollUp.js"></script>
</body>

</html>