<?php
if (isset($message)) {
  foreach ($message as $message) {
    echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
  }
}
?>

<header class="header">
  <section class="flex">
    <div class="logo">
      <img src="../images/influxify-logo.ico" alt="logo" style="width: 30px;">
      <a href="../admin/dashboard.php">Admin<span>Panel</span></a>
    </div>

    <nav class="navbar">
      <a href="../admin/dashboard.php">Dashboard</a>
      <a href="../admin/products.php">Products</a>
      <a href="../admin/placed_orders.php">Orders</a>
      <a href="../admin/admin_accounts.php">Admins</a>
      <a href="../admin/users_accounts.php">Users</a>
      <a href="../admin/messages.php">Services</a>
    </nav>

    <div class="icons">
      <?php
      $admin_avatar = $conn->prepare("SELECT `avatar` FROM `users` WHERE id = ?");
      $admin_avatar->execute([$admin_id]);
      $avatar_result = $admin_avatar->fetchColumn();

      // Check if there is a logged-in user
      if ($admin_id && !empty($avatar_result)) {
        // If logged in and avatar is not empty, set background image
        $user_image = $avatar_result;
      } else {
        // If not logged in or avatar is empty, no background image
        $user_image = "default.png";
      }
      ?>
      <div id="menu-btn" class="fas fa-bars"></div>
      <div id="user-btn" style="border: 3px solid #3b8a59; margin: 0; display: inline-block; width: 35px; height: 35px; border-radius: 50%; background-image: url('../uploaded_img/user_avatar/<?= $user_image ?>'); background-size: cover; "></div>
    </div>

    <div class="profile">
      <?php
      $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ? AND isAdmin = 1");
      $select_profile->execute([$admin_id]);
      $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
      ?>
      <p><?= $fetch_profile['name']; ?></p>
      <a href="../admin/update_profile.php" class="btn">
        Update Profile</a>
      <a href="../components/admin_logout.php" class="delete-btn" onclick="return confirm('Logout from the website?');">Logout</a>
    </div>

  </section>

</header>