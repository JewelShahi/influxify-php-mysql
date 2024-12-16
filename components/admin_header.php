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
      <!-- Dashboard -->
      <a href="../admin/dashboard.php">
        <i class="fa-solid fa-chart-simple"></i> Табло
      </a>
      <!-- Products -->
      <a href="../admin/products.php">
        <i class="fas fa-shopping-bag"></i> Продукти
      </a>
      <!-- Orders -->
      <a href="../admin/placed_orders.php">
        <i class="fa-solid fa-clipboard-list"></i> Поръчки
      </a>
      <!-- Services -->
      <a href="../admin/services.php">
        <i class="fa-solid fa-wrench"></i> Сервиз
      </a>
      <!-- Admins -->
      <a href="../admin/admin_accounts.php">
        <i class="fas fa-user-cog"></i> Админи
      </a>
      <!-- Users -->
      <a href="../admin/users_accounts.php">
        <i class="fas fa-users"></i> Потребители
      </a>
    </nav>

    <div class="icons">
      <?php

      $admin_avatar = $conn->prepare("SELECT `avatar` FROM `users` WHERE id = ?");
      $admin_avatar->execute([$admin_id]);
      $avatar_result = $admin_avatar->fetchColumn();

      $admin_name = $conn->prepare("SELECT `name` FROM `users` WHERE id = ?");
      $admin_name->execute([$admin_id]);
      $name_result = $admin_name->fetchColumn();

      // Check if there is a logged-in user
      if ($admin_id && !empty($avatar_result)) {
        // If logged in and avatar is not empty, set background image
        $user_image = $avatar_result;
      } else {
        // If not logged in or avatar is empty, no background image
        $user_image = "default.png";
      }
      ?>

      <div id="admin-btn" style="border: 3px solid #3b8a59; margin: 0; display: inline-block; width: 35px; height: 35px; border-radius: 50%; background-image: url('../uploaded_img/user_avatar/<?= $user_image ?>'); background-size: cover; " title="<?= $name_result; ?>"></div>

      <div id="menu-btn-admin" class="fas fa-bars"></div>

    </div>

    <div class="profile">
      <div class="profile-background">
        <?php
        $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ? AND isAdmin = 1");
        $select_profile->execute([$admin_id]);
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <p><?= $fetch_profile['name']; ?></p>
        <a href="../admin/update_profile.php" class="btn">
          <i class="fas fa-user-edit"></i> Обнови профила
        </a>
        <a href="../components/admin_logout.php" class="delete-btn" onclick="return confirm('Съгласен ли си да излезеш от профила?');">
          <i class="fas fa-sign-out-alt"></i> Изход
        </a>
      </div>
    </div>
  </section>
</header>