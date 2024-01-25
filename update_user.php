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
  // $select_user =
  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
  $update_profile->execute([$name, $email, $user_id]);

  $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';

  $prev_pass = $_POST['prev_pass'];

  $old_pass = sha1($_POST['old_pass']);
  $old_pass = filter_var($old_pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $new_pass = sha1($_POST['new_pass']);
  $new_pass = filter_var($new_pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $cpass = sha1($_POST['cpass']);
  $cpass = filter_var($cpass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  if ($old_pass == $empty_pass) {
    $message[] = 'please enter old password!';
  } elseif ($old_pass != $prev_pass) {
    $message[] = 'Old password not matched!';
  } elseif ($new_pass != $cpass) {
    $message[] = 'Confirm password not matched!';
  } else {
    if ($new_pass != $empty_pass) {
      $update_admin_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
      $update_admin_pass->execute([$cpass, $user_id]);

      $message[] = 'Password updated successfully!';
    } else {
      $message[] = 'Please enter a new password!';
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

  <section class="user-update form-container">
    <form action="" method="post" enctype="multipart/form-data">
      <h3>Update Profile</h3>
      <input type="hidden" name="prev_pass" value="<?= $fetch_profile["password"]; ?>">
      <input type="text" name="name" placeholder="Enter your username" maxlength="20" class="box" value="<?= $fetch_profile["name"]; ?>" required>
      <input type="email" name="email" placeholder="Enter your email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["email"]; ?>" readonly>
      <input type="password" name="old_pass" placeholder="Enter your old password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
      <input type="password" name="new_pass" placeholder="Enter your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
      <input type="password" name="cpass" placeholder="Confirm your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
      <input type="submit" value="Save changes" class="btn" name="submit">
    </form>
    <form action="">
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