<?php
include '../components/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
  header('location:admin_login.php');
}
if (isset($_GET['delete'])) {

  $delete_id = $_GET['delete'];

  if ($_SESSION['user_id'] == $delete_id) {
    $_SESSION['user_id'] = "";
  }

  // $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
  // $delete_orders->execute([$delete_id]);

  // $delete_services = $conn->prepare("DELETE FROM `services` WHERE user_id = ?");
  // $delete_services->execute([$delete_id]);

  // $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
  // $delete_cart->execute([$delete_id]);

  // $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
  // $delete_wishlist->execute([$delete_id]);

  // $delete_services = $conn->prepare("DELETE FROM `services` WHERE user_id = ?");
  // $delete_services->execute([$delete_id]);

  $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
  $delete_user->execute([$delete_id]);

  header('location:users_accounts.php');
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="../css/admin_style.css">
  <link rel="stylesheet" href="../css/global.css">

</head>

<body>
  <?php include '../components/admin_header.php'; ?>
  <section class="accounts">
    <h1 class="heading">User accounts</h1>
    <div class="box-container">
      <?php
      $select_accounts = $conn->prepare("SELECT * FROM `users` WHERE isAdmin = 0");
      $select_accounts->execute();
      if ($select_accounts->rowCount() > 0) {
        while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
      ?>
          <div class="box">
            <p> User ID : <span><?= $fetch_accounts['id']; ?></span> </p>
            <p> Name : <span><?= $fetch_accounts['name']; ?></span> </p>
            <p> E-mail : <span><?= $fetch_accounts['email']; ?></span> </p>
            <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Delete this account? User related information will also be deleted!')" class="delete-btn">Delete</a>
          </div>
      <?php
        }
      } else {
        echo '<p class="empty">There are currently no available user accounts</p>';
      }
      ?>
    </div>
  </section>
  <script src="../js/admin_script.js"></script>
  <?php include '../components/scroll_up.php'; ?>
  <script src="../js/scrollUp.js"></script>
</body>

</html>