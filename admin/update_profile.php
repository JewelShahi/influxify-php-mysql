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
    $message[] = "Password must be at least 8 characters and contain at least one uppercase letter, lowercase letter and a digit!";
  } elseif ($hash_old_pass == $empty_pass) {
    $message[] = "Please enter old password!";
  } elseif ($hash_old_pass != $prev_pass) {
    $message[] = "Old password not matched!";
  } elseif ($hash_old_pass == $hash_new_pass) {
    $message[] = "New password must be different from the old password!";
  } elseif ($hash_new_pass != $hash_confirm_pass) {
    $message[] = "Confirm password not matched!";
  } else {
    if ($hash_new_pass != $empty_pass) {
      $update_admin_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ? AND isAdmin = 1");
      $update_admin_pass->execute([$hash_confirm_pass, $admin_id]);
      $message[] = "Password updated successfully!";
    } else {
      $message[] = "Please enter a new password!";
    }
  }
}

// Update avatar
if (isset($_POST['update_avatar'])) {
  $avatar = $_POST['avatar'];

  // Update user avatar
  $update_avatar = $conn->prepare("UPDATE `users` SET avatar = ? WHERE id = ? and isAdmin = 1");
  $update_avatar->execute([$avatar, $admin_id]);

  $message[] = "Admin avatar updated!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Admin Profile</title>
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

        <h3>Update Profile</h3>

        <input type="hidden" name="prev_pass" value="<?= $fetch_profile["password"]; ?>">
        
        <input title="Username" type="text" name="name" placeholder="Enter your username" maxlength="100" class="box" value="<?= $fetch_profile["name"]; ?>" readonly>
        <input title="E-mail" type="email" name="email" placeholder="Enter your email" maxlength="50" class="box" value="<?= $fetch_profile["email"]; ?>" readonly>

        <div class="password-container">
          <input type="password" name="old_pass" placeholder="Enter your old password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
          <span id="toggle" class="toggle-pass fas fa-eye" onclick="togglePassword(this)"></span>
        </div>

        <div class="password-container">
          <input type="password" name="new_pass" placeholder="Enter your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
          <span id="toggle" class="toggle-pass fas fa-eye" onclick="togglePassword(this)"></span>
        </div>

        <div class="password-container">
          <input type="password" name="confirm_pass" placeholder="Confirm your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
          <span id="toggle" class="toggle-pass fas fa-eye" onclick="togglePassword(this)"></span>
        </div>

        <input title="Registry date" type="date" maxlength="100" class="box" value="<?= $fetch_profile["reg_date"]; ?>" readonly>

        <button type="submit" class="btn submit-btn" name="update_password">
          <i class="fas fa-save"></i> Save Changes
        </button>

      </form>

      <form action="" class="avatar-form" method="post">

        <h3>Update avatar</h3>

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
          <i class="fa-solid fa-image"></i> Update avatar
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