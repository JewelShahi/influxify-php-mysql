<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
};

$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$user_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['update_password'])) {
  // Validate and sanitize input
  $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $old_pass = filter_var($_POST['old_pass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $new_pass = filter_var($_POST['new_pass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  // Fetch the user's current password
  $select_password = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
  $select_password->execute([$user_id]);
  $current_password = $select_password->fetchColumn();

  // Check if the entered old password matches the current password
  if (sha1($old_pass) !== $current_password) {
    $message[] = 'Old password is incorrect';
  } elseif ($new_pass !== $cpass) {
    $message[] = 'New password and confirm password do not match';
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
  <section class="user-update">
    <form action="" class="user-form" method="post" enctype="multipart/form-data">
      <h3>Update Profile</h3>
      <input type="hidden" name="prev_pass" value="<?= $fetch_profile["password"]; ?>">
      <input type="text" name="name" placeholder="Enter your username" maxlength="20" class="box" value="<?= $fetch_profile["name"]; ?>" required>
      <input type="email" name="email" placeholder="Enter your email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["email"]; ?>" readonly>
      <input type="password" name="old_pass" placeholder="Enter your old password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
      <input type="password" name="new_pass" placeholder="Enter your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
      <input type="password" name="cpass" placeholder="Confirm your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
      <button type="submit" class="btn submit-btn" name="update_password">
        <i class="fas fa-save"></i> Save Changes
      </button>
    </form>
    <form action="" class="avatar-form">
      <img src="<?= 'uploaded_img/user_avatar/' . $fetch_profile['avatar']; ?>" alt="<?= $fetch_profile['avatar']; ?>" id="main-avatar" width="200">
      <div>
        <img src="" alt="" class="">
      </div>
      <input type="submit" value="update avatar" class="btn" name="update_avatar">
    </form>
  </section>
  <?php include 'components/footer.php'; ?>

  <script src="js/user_script.js"></script>
  <?php include 'components/scroll_up.php'; ?>
  <script src="js/scrollUp.js"></script>
</body>

</html>