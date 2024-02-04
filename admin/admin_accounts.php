<?php

// Include the database connection file
include '../components/connect.php';

// Start the admin session
session_name('admin_session');
session_start();

// Retrieve the admin ID from the session
$admin_id = $_SESSION['admin']['admin_id'];

// If admin ID is not set, redirect to admin login page
if (!isset($admin_id)) {
  header('location:admin_login.php');
}

// If 'delete' parameter is set in the URL
if (isset($_GET['delete'])) {

  // Retrieve the 'delete' parameter value
  $delete_id = $_GET['delete'];

  // Check if the current admin is trying to delete their own account
  if ($_SESSION['admin']['admin_id'] == $delete_id) {
    $_SESSION['admin']['admin_id'] = "";
  }

  // Prepare and execute SQL query to delete an admin by ID
  $delete_admins = $conn->prepare("DELETE FROM `users` WHERE id = ? AND isAdmin = 1");
  $delete_admins->execute([$delete_id]);

  // Redirect to admin accounts page after deletion
  header('location:admin_accounts.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Title and favicon -->
  <title>Admin accounts</title>
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">

  <!-- External CSS stylesheets -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="../css/admin_style.css">
  <link rel="stylesheet" href="../css/global.css">
</head>

<body>

  <!-- Include the admin header component -->
  <?php include '../components/admin_header.php'; ?>

  <section class="accounts">

    <!-- Heading for admin accounts -->
    <h1 class="heading">Admin accounts</h1>

    <!-- Container for adding a new admin -->
    <div class="new-admin-container">
      <div id="add-new-admin">
        <p>Add a new admin</p>
        <a href="register_admin.php" class="option-btn">Register an admin</a>
      </div>
    </div>

    <!-- Container for displaying admin accounts -->
    <div class="box-container">
      <div class="info">
        <?php

        // Select all admin accounts from the database
        $select_accounts = $conn->prepare("SELECT * FROM `users` WHERE isAdmin = 1");
        $select_accounts->execute();

        // Check if there are admin accounts available
        if ($select_accounts->rowCount() > 0) {
          // Loop through each admin account
          while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <!-- Box displaying admin details -->
            <div class="box">
              <p> Admin ID : <span><?= $fetch_accounts['id']; ?></span> </p>
              <p> Admin name : <span><?= $fetch_accounts['name']; ?></span> </p>
              <!-- Buttons for updating and deleting admin accounts -->
              <div class="flex-btn">
                <?php
                // Check if the admin is viewing their own account
                if ($fetch_accounts['id'] == $admin_id) {
                  // Display update button
                  echo '<a href="update_profile.php" class="option-btn">Update</a>';
                }
                ?>
                <?php
                // Check if the admin is not viewing their own account and it's not the super admin (ID = 2)
                if ($fetch_accounts['id'] != $admin_id && $fetch_accounts['id'] != 2) {
                  // Display delete button
                  echo '<a href="admin_accounts.php?delete=' . $fetch_accounts['id'] . '" onclick="return confirm(\'Delete this account?\')" class="delete-btn">Delete</a>';
                }
                ?>
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

  <!-- Include the admin script and scroll-up components -->
  <script src="../js/admin_script.js"></script>
  <?php include '../components/scroll_up.php'; ?>
  <script src="../js/scrollUp.js"></script>
</body>

</html>