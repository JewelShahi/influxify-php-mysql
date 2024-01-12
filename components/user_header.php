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
      <img src="images/influxify-logo.ico" alt="logo" style="width: 30px;">
      <a href="/influxify/home.php">Influfxi<span>fy</span></a>
    </div>

    <nav class="navbar">
      <a href="home.php">Home</a>
      <a href="about.php">About</a>
      <a href="orders.php">Orders</a>
      <a href="shop.php">Shop</a>
      <a href="contact.php">Contact</a>
    </nav>

    <div class="icons">
      <?php
      $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
      $count_wishlist_items->execute([$user_id]);
      $total_wishlist_counts = $count_wishlist_items->rowCount();

      $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $count_cart_items->execute([$user_id]);
      $total_cart_counts = $count_cart_items->rowCount();

      $user_avatar = $conn->prepare("SELECT `avatar` FROM `users` WHERE id = ?");
      $user_avatar->execute([$user_id]);
      $avatar_result = $user_avatar->fetchColumn();

      // Check if there is a logged-in user
      if ($user_id && !empty($avatar_result)) {
        // If logged in and avatar is not empty, set background image
        $user_image = $avatar_result;
      } else {
        // If not logged in or avatar is empty, no background image
        $user_image = "default.png";
      }
      ?>
      <a href="search_page.php"><i class="fas fa-search"></i></a>
      <a href="wishlist.php" class="icon-link">
        <i class="fas fa-heart"></i>
        <sup class="sup"><?= $total_wishlist_counts; ?></sup>
      </a>
      <a href="cart.php" class="icon-link">
        <i class="fas fa-shopping-cart"></i>
        <sup class="sup"><?= $total_cart_counts; ?></sup>
      </a>
      <div id="user-btn" style="border: 3px solid #3b8a59; margin: 0; display: inline-block; width: 30px; height: 30px; border-radius: 50%; background-image: url('uploaded_img/user_avatar/<?= $user_image ?>'); background-size: cover; "></div>

      <div id="menu-btn" class="fas fa-bars"></div>
    </div>

    <div class="profile">
      <?php
      $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
      $select_profile->execute([$user_id]);

      if ($select_profile->rowCount() > 0) {
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
      ?>
        <p><?= $fetch_profile["name"]; ?></p>
        <a href="update_user.php" class="btn">Update Profile</a>
        <a href="components/user_logout.php" class="delete-btn" onclick="return confirm('Logout from the website?');">logout</a>
      <?php
      } else {
      ?>
        <p>Please LogIn or Register first!</p>
        <div class="flex-btn">
          <a href="user_register.php" class="option-btn">Register</a>
          <a href="user_login.php" class="option-btn">LogIn</a>
        </div>
      <?php
      }
      ?>
    </div>
  </section>
</header>