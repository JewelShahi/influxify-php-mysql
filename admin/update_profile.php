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

// Update admin
if (isset($_POST['update_password'])) {

  $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
  $prev_pass = $_POST['prev_pass'];

  $old_pass = filter_var($_POST['old_pass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $hash_old_pass = sha1($old_pass);

  $new_pass = filter_var($_POST['new_pass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $hash_new_pass = sha1($new_pass);

  $confirm_pass = filter_var($_POST['confirm_pass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $hash_confirm_pass = sha1($confirm_pass);

  // Check if the new password meets the criteria
  if (strlen($new_pass) < 8 || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/', $new_pass)) {
    $message[] = "Паролата трябва да е поне 8 знака и да съдържа поне една главна буква, малка буква и цифра!";
  } elseif ($hash_old_pass == $empty_pass) {
    $message[] = "Моля, въведете старата парола!";
  } elseif ($hash_old_pass != $prev_pass) {
    $message[] = "Старата парола не съответства!";
  } elseif ($hash_old_pass == $hash_new_pass) {
    $message[] = "Новата парола трябва да е различна от старата!";
  } elseif ($hash_new_pass != $hash_confirm_pass) {
    $message[] = "Потвърдената парола не съвпада!";
  } else {
    if ($hash_new_pass != $empty_pass) {
      $update_admin_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ? AND isAdmin = 1");
      $update_admin_pass->execute([$hash_confirm_pass, $admin_id]);
      $message[] = "Паролата е актуализирана успешно!";
    } else {
      $message[] = "Моля, въведете нова парола!";
    }
  }
}

// Update avatar
if (isset($_POST['update_avatar'])) {
  $avatar = $_POST['avatar'];

  // Update user avatar
  $update_avatar = $conn->prepare("UPDATE `users` SET avatar = ? WHERE id = ? and isAdmin = 1");
  $update_avatar->execute([$avatar, $admin_id]);

  $message[] = "Профилната снимка на админа е актуализирана!";
}
?>

<!DOCTYPE html>
<html lang="bg">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Актуализиране на администраторски профил</title>
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <!-- Custom css -->
  <link rel="stylesheet" href="../css/admin_style.css">
  <link rel="stylesheet" href="../css/global.css">

</head>

<body style="height: auto;">

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
    <section class="user-update">
      <form action="" class="user-form" method="post" enctype="multipart/form-data">

        <h3>Обновяване на данните</h3>

        <input type="hidden" name="prev_pass" value="<?= $fetch_profile["password"]; ?>">
        
        <input title="Потребителско име" type="text" name="name" placeholder="Въведете потребителско име" maxlength="100" class="box" value="<?= $fetch_profile["name"]; ?>" readonly>
        <input title="Имейл" type="email" name="email" placeholder="Въведете своя имейл" maxlength="50" class="box" value="<?= $fetch_profile["email"]; ?>" readonly>

        <div class="password-container">
          <input type="password" name="old_pass" placeholder="Въведете старата парола" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
          <span id="toggle" class="toggle-pass fas fa-eye" onclick="togglePassword(this)"></span>
        </div>

        <div class="password-container">
          <input type="password" name="new_pass" placeholder="Въведете новата парола" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
          <span id="toggle" class="toggle-pass fas fa-eye" onclick="togglePassword(this)"></span>
        </div>

        <div class="password-container">
          <input type="password" name="confirm_pass" placeholder="Потвърдете новата парола" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
          <span id="toggle" class="toggle-pass fas fa-eye" onclick="togglePassword(this)"></span>
        </div>

        <input title="Дата на вписване" type="text" maxlength="100" class="box" value="<?= date('d/m/Y', strtotime($fetch_profile['reg_date'])); ?>" readonly>

        <button type="submit" class="btn submit-btn" name="update_password">
          <i class="fas fa-save"></i> Запази
        </button>

      </form>

      <form action="" class="avatar-form" method="post">

        <h3>Обнови профилната снимка</h3>

        <div class="user-image-avatar">
          <img src="<?= '../uploaded_img/user_avatar/' . $fetch_profile['avatar']; ?>" alt="<?= $fetch_profile['avatar']; ?>" id="main-avatar" width="200">
        </div>
        <div class="image-container">

          <?php
          $avatarDirectory = '../uploaded_img/user_avatar/';
          $avatarImages = scandir($avatarDirectory);

          foreach ($avatarImages as $image) {
            if ($image !== '.' && $image !== '..' && $image !== 'default.png' && $image !== 'logedin.png') {
              $imageName = $image;
              $imagePath = $avatarDirectory . $imageName;
          ?>
              <input type="radio" name="avatar" id="<?= pathinfo($imageName, PATHINFO_FILENAME); ?>" class="input-hidden" value="<?= $imageName ?>" />
              <label class="user-image-options" for="<?= pathinfo($imageName, PATHINFO_FILENAME); ?>" onclick="handleRadioButtonClick('<?= pathinfo($imageName, PATHINFO_FILENAME); ?>')">
                <div class="avatar-container" style="background-image: url(<?= $imagePath ?>);"></div>
              </label>
          <?php
            }
          }
          ?>

        </div>
        <button type="submit" class="btn" name="update_avatar">
          <i class="fa-solid fa-image"></i> Обнови
        </button>
      </form>

    </section>

  <?php
  }
  ?>

  <!-- Admin script -->
  <script src="../js/admin_script.js"></script>

  <!-- Toggle the visibility of the password -->
  <script src="../js/toggle_password.js"></script>

  <!-- Admin user avatar -->
  <script src="../js/update_avatar_admin_user.js"></script>
</body>

</html>