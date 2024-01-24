<?php
include '../components/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
  header('location:admin_login.php');
}
if (isset($_GET['delete'])) {

  $delete_id = $_GET['delete'];

  if ($_SESSION['admin_id'] == $delete_id) {
    $_SESSION['admin_id'] = "";
  }

  $delete_admins = $conn->prepare("DELETE FROM `users` WHERE id = ? AND isAdmin = 1");
  $delete_admins->execute([$delete_id]);

  header('location:admin_accounts.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin accounts</title>
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="../css/admin_style.css">
  <link rel="stylesheet" href="../css/global.css">
</head>

<body>

  <?php include '../components/admin_header.php'; ?>

  <section class="accounts">

    <h1 class="heading">Admin accounts</h1>

    <div class="box-container">

      <div class="box">
        <p>Add a new admin</p>
        <a href="register_admin.php" class="option-btn">Register an admin</a>
      </div>

      <div class="info">
        <?php
        $select_accounts = $conn->prepare("SELECT * FROM `users` WHERE isAdmin = 1");
        $select_accounts->execute();
        if ($select_accounts->rowCount() > 0) {
          while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="box">
              <p> Admin ID : <span><?= $fetch_accounts['id']; ?></span> </p>
              <p> Admin name : <span><?= $fetch_accounts['name']; ?></span> </p>
              <div class="flex-btn">
                <?php
                if ($fetch_accounts['id'] == $admin_id) {
                  echo '<a href="update_profile.php" class="option-btn">Update</a>';
                }
                ?>
                <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Delete this account?')" class="delete-btn">Delete</a>
              </div>
            </div>
        <?php
          }
        } else {
          echo '<p class="empty">There are currently no available admin accounts</p>';
        }
        ?>
      </div>

    </div>

  </section>
  <script src="../js/admin_script.js"></script>
  <?php include '../components/scroll_up.php'; ?>
  <script src="../js/scrollUp.js"></script>
</body>

</html>