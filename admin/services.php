<?php
session_start();
include '../components/connect.php';

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
  header('location:admin_login.php');
};

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  $delete_service = $conn->prepare("DELETE FROM `services` WHERE id = ?");
  $delete_service->execute([$delete_id]);
  header('location:services.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Services</title>
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="../css/admin_style.css">
  <link rel="stylesheet" href="../css/global.css">

</head>

<body>

  <?php include '../components/admin_header.php'; ?>

  <section class="contacts">

    <h1 class="heading">Services</h1>

    <div class="box-container">

      <?php
      $select_services = $conn->prepare("SELECT * FROM `services` ORDER BY `placed_on` DESC");
      $select_services->execute();
      if ($select_services->rowCount() > 0) {
        while ($fetch_service = $select_services->fetch(PDO::FETCH_ASSOC)) {
      ?>
          <div class="box">
            <p>Placed on : <span><?= $fetch_service['placed_on']; ?></span></p>
            <p> User ID : <span><?= $fetch_service['user_id']; ?></span></p>
            <p> Name : <span><?= $fetch_service['name']; ?></span></p>
            <p> E-mail : <span><?= $fetch_service['email']; ?></span></p>
            <p> Phone Number : <span><?= $fetch_service['number']; ?></span></p>
            <p> Phone Brand : <span><?= $fetch_service['brand']; ?></span></p>
            <p> Problem : <span><?= $fetch_service['description']; ?></span></p>
            <a href="services.php?delete=<?= $fetch_service['id']; ?>" onclick="return confirm('Delete this service?');" class="delete-btn">Delete</a>
          </div>
      <?php
        }
      } else {
        echo '<p class="empty">At present, no services are available</p>';
      }
      ?>

    </div>

  </section>

  <script src="../js/admin_script.js"></script>
  <?php include '../components/scroll_up.php'; ?>
  <script src="../js/scrollUp.js"></script>
</body>

</html>
