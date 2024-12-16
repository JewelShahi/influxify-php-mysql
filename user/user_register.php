<?php

include '../components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];

  header("Location: home.php");
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
    $message[] = 'Невалиден формат на имейла!';
  }
  // Validate password length and format (e.g., at least 8 characters, one upper, one lower character and one digit)
  elseif (strlen($pass) < 8 || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/', $pass)) {
    $message[] = 'Паролата трябва да е поне 8 знака и да съдържа поне една главна буква, малка буква и цифра!';
  }
  // Check if the password match the entered
  elseif ($hash_pass != $hash_cpass) {
    $message[] = 'Потвърдената парола не съвпада!';
  } else {

    try {

      $insert_user = $conn->prepare("INSERT INTO `users` (name, email, password, avatar) VALUES (?, ?, ?, 'logedin.png')");
      $insert_user->execute([$name, $email, $hash_pass]);

      // Check if any rows were affected
      if ($insert_user->rowCount() > 0) {
        $message[] = 'Потребителят е регистриран успешно!';
        header("Location: user_login.php");
      } else {
        $message[] = 'Грешка при регистриране на потребител. Моля, опитайте отново.';
      }
    } catch (PDOException $e) {
      if ($e->errorInfo[1] == 1062) { // 1062 is the MySQL error code for duplicate entry
        $message[] = 'Потребител с ' . $email . ' вече съществува!';
      } else {
        $message[] = 'Error: ' . $e->getMessage();
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="bg">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Регистрация на потребител</title>
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  
  <!-- custom css file link  -->
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/user_style.css">
</head>

<body class="no-overflow">

  <?php include '../components/user_header.php'; ?>

  <section class="user-register">
    <div>
      <form action="" method="post">
        <h3>Регистрация</h3>
        <input type="text" name="name" placeholder="Въведете потребителско име" maxlength="100" class="input box" required>
        <input type="email" name="email" placeholder="Въведете имейл" maxlength="50" class="input box" oninput="this.value = this.value.replace(/\s/g, '')" required>
        <div class="passwords">
          <div class="password-container">
            <input type="password" name="pass" placeholder="Въведете парола" maxlength="20" class="input box" oninput="this.value = this.value.replace(/\s/g, '')" required>
            <span id="toggle" class="toggle-pass fas fa-eye" onclick="togglePassword(this)"></span>
          </div>
          <div class="password-container">
            <input type="password" name="cpass" placeholder="Потвирдете паролата" maxlength="20" class="input box" oninput="this.value = this.value.replace(/\s/g, '')" required>
            <span id="toggle" class="toggle-pass fas fa-eye" onclick="togglePassword(this)"></span>
          </div>
        </div>
        <input type="submit" value="Register" class="btn" name="submit">
        <p>Вече имате профил?<br>След това просто влезте и продължете откъдето сте спрели!</p>
        <a href="user_login.php" class="option-btn">Вход</a>
      </form>
    </div>
  </section>

  <!-- User script -->
  <script src="../js/user_script.js"></script>

  <!-- Toggle visibility of the passwords -->
  <script src="../js/toggle_password.js"></script>

  <!-- Scroll up button -->
  <?php include '../components/scroll_up.php'; ?>
  <script src="../js/scrollUp.js"></script>
</body>

</html>