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

// Delete admin
if (isset($_GET['delete'])) {

  $delete_id = $_GET['delete'];

  $get_cart_products = $conn->prepare("SELECT pid, quantity FROM `cart` WHERE user_id = ?");
  $get_cart_products->execute([$delete_id]);
  $cart_products = $get_cart_products->fetchAll();

  // Add the quantities back to the products table
  foreach ($cart_products as $product) {
    $pid = $product['pid'];
    $quantity = $product['quantity'];

    $add_back_quantity = $conn->prepare("UPDATE `products` SET qty = qty + ? WHERE id = ?");
    $add_back_quantity->execute([$quantity, $pid]);
  }

  $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
  $delete_user->execute([$delete_id]);

  header('Location: users_accounts.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users Accounts</title>
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

    <section class="accounts">
      <h1 class="heading">User accounts</h1>
      <div class="box-container">
        <?php
        $select_accounts = $conn->prepare("SELECT * FROM `users` WHERE isAdmin = 0");
        $select_accounts->execute();
        if ($select_accounts->rowCount() > 0) {
          while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="user-card">
              <div class="after"></div>
              <div class="user-info">
                <div style="margin-bottom: 0.7rem; border: 3px solid #3b8a59; display: inline-block; width: 80px; height: 80px; border-radius: 50%; background-image: url('../uploaded_img/user_avatar/<?= $fetch_accounts['avatar'] ?>'); background-size: cover; box-shadow: 0 0 10px 5px #2ad45b; "></div>
                <p> User ID :  <span><?= $fetch_accounts['id']; ?></span> </p>
                <p> Name :  <span><?= $fetch_accounts['name']; ?></span> </p>
                <p> E-mail :  <span><?= $fetch_accounts['email']; ?></span> </p>
                <p> Registry date :  <span><?= date('d/m/Y', strtotime($fetch_accounts['reg_date'])); ?></span></p>
                <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Delete this account? User related information will also be deleted!')" class="delete-btn">Delete</a>
              </div>
            </div>
        <?php
          }
        } else {
          echo '<p class="empty">There are currently no available user accounts</p>';
        }
        ?>
      </div>
    </section>

  <?php
  }
  ?>

  <!-- Admin script -->
  <script src="../js/admin_script.js"></script>

  <!-- Scroll up button -->
  <?php include '../components/scroll_up.php'; ?>
  <script src="../js/scrollUp.js"></script>
</body>

</html>