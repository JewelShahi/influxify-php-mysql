<?php

include 'components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
  header("location:user_login.php");
};

$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$user_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['update_password'])) {

  // Validate and sanitize input
  $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';

  $old_pass = filter_var($_POST['old_pass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $hash_old_pass = sha1($old_pass);

  $new_pass = filter_var($_POST['new_pass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $hash_new_pass = sha1($new_pass);

  $cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $hash_cpass = sha1($cpass);

  // Fetch the user's current password
  $select_password = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
  $select_password->execute([$user_id]);
  $current_password = $select_password->fetchColumn();

  if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/', $new_pass)) {
    $message[] = 'Password must be at least 8 characters and contain at least one uppercase letter, lowercase letter and a digit!';
  } elseif ($hash_old_pass == $empty_pass) {
    $message[] = 'Please enter old password!';
  } elseif ($hash_old_pass != $current_password) {
    $message[] = 'Old password not matched!';
  } elseif ($hash_new_pass == $hash_old_pass) {
    $message[] = 'New password must be different from the old password!';
  } elseif ($hash_new_pass !== $hash_cpass) {
    $message[] = 'Confirm password not matched!';
  } else {
    // Update user profile
    $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
    $update_profile->execute([$name, $email, $user_id]);

    // Check if a new password is provided
    if ($new_pass !== '') {
      // Update password
      $update_password = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
      $update_password->execute([sha1($new_pass), $user_id]);
      $message[] = 'Password updated successfully';
    }
  }
}

if (isset($_POST['update_avatar'])) {
  $avatar = $_POST['avatar'];

  // Update user avatar
  $update_avatar = $conn->prepare("UPDATE `users` SET avatar = ? WHERE id = ?");
  $update_avatar->execute([$avatar, $user_id]);

  $message[] = "User avatar updated!";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update user</title>
  <link rel="shortcut icon" href="images/influxify-logo.ico" type="image/x-icon">
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- custom css file link  -->
  <link rel="stylesheet" href="css/global.css">

  <link rel="stylesheet" href="css/user_style.css">
</head>

<body>

  <?php include 'components/user_header.php'; ?>
  <?php
  $select_user_exists = $conn->prepare("SELECT id FROM `users` WHERE id = ?");
  $select_user_exists->execute([$user_id]);
  if ($select_user_exists->rowCount() == 0) {
    header("location: user_login.php");
  } else {
  ?>
    <section class="user-update">
      <form action="" class="user-form" method="post" enctype="multipart/form-data">
        <h3>Update profile</h3>

        <input type="hidden" name="prev_pass" value="<?= $fetch_profile["password"]; ?>">
        <input type="text" name="name" placeholder="Enter your username" maxlength="100" class="box" value="<?= $fetch_profile["name"]; ?>" required>
        <input type="email" name="email" placeholder="Enter your email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["email"]; ?>" readonly>

        <div class="password-container">
          <input type="password" name="old_pass" placeholder="Enter your old password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
          <span id="toggle" class="toggle-pass fas fa-eye" onclick="togglePassword(this)"></span>
        </div>

        <div class="password-container">
          <input type="password" name="new_pass" placeholder="Enter your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
          <span id="toggle" class="toggle-pass fas fa-eye" onclick="togglePassword(this)"></span>
        </div>

        <div class="password-container">
          <input type="password" name="cpass" placeholder="Confirm your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
          <span id="toggle" class="toggle-pass fas fa-eye" onclick="togglePassword(this)"></span>
        </div>

        <button type="submit" class="btn submit-btn" name="update_password">
          <i class="fas fa-save"></i> Save Changes
        </button>

      </form>

      <form action="" class="avatar-form" method="post">

        <h3>Update avatar</h3>

        <div class="user-image-avatar">
          <img src="<?= 'uploaded_img/user_avatar/' . $fetch_profile['avatar']; ?>" alt="<?= $fetch_profile['avatar']; ?>" id="main-avatar" width="200">
        </div>
        <div class="image-container">
          <?php
          $avatarDirectory = 'uploaded_img/user_avatar/';
          $avatarImages = scandir($avatarDirectory);

          foreach ($avatarImages as $image) {
            if ($image !== '.' && $image !== '..' && $image !== 'default.png' && $image !== 'logedin.png') {
              $imageName = $image;
              $imagePath = $avatarDirectory . $imageName;
          ?>
              <input type="radio" name="avatar" id="<?= pathinfo($imageName, PATHINFO_FILENAME); ?>" class="input-hidden" value="<?= $imageName ?>" />
              <label for="<?= pathinfo($imageName, PATHINFO_FILENAME); ?>" onclick="handleRadioButtonClick('<?= pathinfo($imageName, PATHINFO_FILENAME); ?>')">
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

  <?php include 'components/footer.php'; ?>
  <script src="js/update_avatar_admin_user.js"></script>
  <script src="js/user_script.js"></script>
  <?php include 'components/scroll_up.php'; ?>
  <script src="js/scrollUp.js"></script>
  <script src="js/toggle_password.js"></script>
</body>

</html>