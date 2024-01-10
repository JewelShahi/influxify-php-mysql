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

  $avatar = $_FILES['avatar']['name'];
  $avatar = filter_var($avatar, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $avatar_size = $_FILES['avatar']['size'];
  $avatar_tmp_name = $_FILES['avatar']['tmp_name'];
  $image_folder = 'uploaded_img/user_avatar/' . $avatar;

  if (!empty($avatar)) {
    if ($avatar_size > 2000000) {
      $message[] = 'Image size is too large!';
    } else {
      // Prepare and execute the update query to save the avatar filename in the database
      $update_avatar = $conn->prepare("UPDATE `users` SET avatar = ? WHERE id = ?");
      $update_avatar->execute([$avatar, $user_id]);

      // Create the directory if it doesn't exist
      if (!file_exists('../uploaded_img/user_avatar/')) {
        // mkdir('uploaded_img/user_avatar/', 0777, true);
      }

      // Move the uploaded file to the destination directory
      move_uploaded_file($avatar_tmp_name, $image_folder);

      // Check if $old_avatar is defined before unlinking
      if (isset($old_avatar) && !empty($old_avatar)) {
        // Unlink the old avatar file
        unlink('uploaded_img/user_avatar/' . $old_avatar);
        $message[] = 'Old avatar has been deleted.';
      }

      $message[] = 'Avatar has been updated successfully!';
    }
  }


  if ($old_pass == $empty_pass) {
    $message[] = 'please enter old password!';
  } elseif ($old_pass != $prev_pass) {
    $message[] = 'old password not matched!';
  } elseif ($new_pass != $cpass) {
    $message[] = 'confirm password not matched!';
  } else {
    if ($new_pass != $empty_pass) {
      $update_admin_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
      $update_admin_pass->execute([$cpass, $user_id]);
      $message[] = 'password updated successfully!';
    } else {
      $message[] = 'please enter a new password!';
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

  <section class="form-container">

    <form action="" method="post" enctype="multipart/form-data">
      <h3>Update now</h3>
      <input type="hidden" name="prev_pass" value="<?= $fetch_profile["password"]; ?>">
      <input type="text" name="name" required placeholder="enter your username" maxlength="20" class="box" value="<?= $fetch_profile["name"]; ?>">
      <input type="email" name="email" required placeholder="enter your email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["email"]; ?>">
      <input type="password" name="old_pass" placeholder="enter your old password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="enter your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" placeholder="confirm your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="file" name="avatar">
      <input type="submit" value="update now" class="btn" name="submit">
    </form>

  </section>
  <?php include 'components/footer.php'; ?>

  <script src="js/script.js"></script>
  <?php include 'components/scroll_up.php'; ?>
  <script src="js/scrollUp.js"></script>
</body>

</html>