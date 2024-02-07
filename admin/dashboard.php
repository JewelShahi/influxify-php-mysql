<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:admin_login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="../css/admin_style.css">
  <link rel="stylesheet" href="../css/global.css">
</head>

<body>

  <?php include '../components/admin_header.php'; ?>

  <section class="dashboard">

    <h1 class="heading">Dashboard</h1>

    <div class="box-container">

      <div class="box">
        <h3>Welcome!</h3>
        <p><?= $fetch_profile['name']; ?></p>
        <a href="update_profile.php" class="btn">Update Profile</a>
      </div>

      <div class="box">
        <?php
        $select_users = $conn->prepare("SELECT * FROM `users` WHERE isAdmin = 0");
        $select_users->execute();
        $number_of_users = $select_users->rowCount()
        ?>
        <h3><?= $number_of_users; ?></h3>
        <p>Total users</p>
        <a href="users_accounts.php" class="btn">See all users</a>
      </div>

      <div class="box">
        <?php
        $select_admins = $conn->prepare("SELECT * FROM `users` WHERE isAdmin = 1");
        $select_admins->execute();
        $number_of_admins = $select_admins->rowCount()
        ?>
        <h3><?= $number_of_admins; ?></h3>
        <p>Total admins</p>
        <a href="admin_accounts.php" class="btn">See all admins</a>
      </div>

      <div class="box">
        <?php
        // Prepare and execute SQL query to get the total income from completed orders
        $select_orders = $conn->prepare("SELECT SUM(price * qty) AS total_income FROM orders WHERE payment_status = 'completed'");
        $select_orders->execute();
        $orders_income = $select_orders->fetch(PDO::FETCH_ASSOC);

        // Prepare and execute SQL query to get the total income from services
        $select_services = $conn->prepare("SELECT SUM(price) AS total_income FROM services WHERE payment_status = 'completed'");
        $select_services->execute();
        $services_income = $select_services->fetch(PDO::FETCH_ASSOC);

        // Extract the total income from orders and services
        $orders_total_income = isset($orders_income['total_income']) ? $orders_income['total_income'] : 0;
        $services_total_income = isset($services_income['total_income']) ? $services_income['total_income'] : 0;

        // Calculate the total income by summing income from both orders and services
        $income = $orders_total_income + $services_total_income;
        ?>
        <h3 style="z-index: 9999; text-wrap: wrap;">$<?= number_format($income, 2, '.', ','); ?></h3>
        <p>Total income</p>
      </div>

      <div class="box">
        <?php
        $select_orders = $conn->prepare("SELECT SUM(price) AS service_income FROM services WHERE payment_status = 'completed'");
        $select_orders->execute();
        $income = $select_orders->fetch(PDO::FETCH_ASSOC);
        ?>
        <h3 style="z-index: 9999; text-wrap: wrap;">$<?= number_format($income['service_income'], 2, '.', ','); ?></h3>
        <p>Total service income</p>
        <a href="services.php" class="btn">See all services</a>
      </div>

      <div class="box">
        <?php
        $select_orders = $conn->prepare("SELECT id FROM orders GROUP BY id");
        $select_orders->execute();
        $number_of_orders = $select_orders->rowCount();
        ?>
        <h3><?= $number_of_orders; ?></h3>
        <p>Total orders</p>
        <a href="placed_orders.php" class="btn">See all orders</a>
      </div>

      <div class="box">
        <?php
        $select_order_status_processing = $conn->prepare("SELECT id FROM orders WHERE order_status = 'processing' GROUP BY id");
        $select_order_status_processing->execute();
        $number_of_order_status_processing = $select_order_status_processing->rowCount()
        ?>
        <h3><?= $number_of_order_status_processing; ?></h3>
        <p>Total processing order status</p>
        <a href="placed_orders.php" class="btn">See all orders</a>
      </div>

      <div class="box">
        <?php
        $select_order_status_shipping = $conn->prepare("SELECT id FROM orders WHERE order_status = 'shipping' GROUP BY id");
        $select_order_status_shipping->execute();
        $number_of_order_status_shipping = $select_order_status_shipping->rowCount()
        ?>
        <h3><?= $number_of_order_status_shipping; ?></h3>
        <p>Total shipping order status</p>
        <a href="placed_orders.php" class="btn">See all orders</a>
      </div>

      <div class="box">
        <?php
        $select_order_status_delivered = $conn->prepare("SELECT id FROM orders WHERE order_status = 'delivered' GROUP BY id");
        $select_order_status_delivered->execute();
        $number_of_order_status_delivered = $select_order_status_delivered->rowCount()
        ?>
        <h3><?= $number_of_order_status_delivered; ?></h3>
        <p>Total delivered order status</p>
        <a href="placed_orders.php" class="btn">See all orders</a>
      </div>

      <div class="box">
        <?php
        $select_payment_status_pendings = $conn->prepare("SELECT id FROM orders WHERE payment_status = 'pending' GROUP BY id");
        $select_payment_status_pendings->execute();
        $number_of_payment_status_pendings = $select_payment_status_pendings->rowCount()
        ?>
        <h3><?= $number_of_payment_status_pendings; ?></h3>
        <p>Total pending payment status orders</p>
        <a href="placed_orders.php" class="btn">See all orders</a>
      </div>

      <div class="box">
        <?php
        $select_payment_status_completed = $conn->prepare("SELECT id FROM orders WHERE payment_status = 'completed' GROUP BY id");
        $select_payment_status_completed->execute();
        $number_of_payment_status_completed = $select_payment_status_completed->rowCount()
        ?>
        <h3><?= $number_of_payment_status_completed; ?></h3>
        <p>Total completed payment status orders</p>
        <a href="placed_orders.php" class="btn">See all orders</a>
      </div>

      <div class="box">
        <?php
        $select_services = $conn->prepare("SELECT id FROM `services`");
        $select_services->execute();
        $number_of_services = $select_services->rowCount()
        ?>
        <h3><?= $number_of_services; ?></h3>
        <p>Total services</p>
        <a href="services.php" class="btn">See all services</a>
      </div>

      <div class="box">
        <?php
        $select_payment_status_pendings = $conn->prepare("SELECT id FROM services WHERE payment_status = 'pending'");
        $select_payment_status_pendings->execute();
        $number_of_payment_status_pendings = $select_payment_status_pendings->rowCount()
        ?>
        <h3><?= $number_of_payment_status_pendings; ?></h3>
        <p>Total pending payment status services</p>
        <a href="services.php" class="btn">See all services</a>
      </div>

      <div class="box">
        <?php
        $select_payment_status_completed = $conn->prepare("SELECT id FROM services WHERE payment_status = 'completed'");
        $select_payment_status_completed->execute();
        $number_of_payment_status_completed = $select_payment_status_completed->rowCount()
        ?>
        <h3><?= $number_of_payment_status_completed; ?></h3>
        <p>Total completed payment status orders services</p>
        <a href="services.php" class="btn">See all services</a>
      </div>

      <div class="box">
        <?php
        $select_resolved_services = $conn->prepare("SELECT id FROM services WHERE is_resolved = 1");
        $select_resolved_services->execute();
        $number_of_resolved_services= $select_resolved_services->rowCount()
        ?>
        <h3><?= $number_of_resolved_services; ?></h3>
        <p>Total resolved services</p>
        <a href="services.php" class="btn">See all services</a>
      </div>

      <div class="box">
        <?php
        $select_products = $conn->prepare("SELECT * FROM `products`");
        $select_products->execute();
        $number_of_products = $select_products->rowCount()
        ?>
        <h3><?= $number_of_products; ?></h3>
        <p>Total products</p>
        <a href="products.php" class="btn">See all products</a>
      </div>

    </div>

  </section>
  <script src="../js/admin_script.js"></script>
  <?php include '../components/scroll_up.php'; ?>
  <script src="../js/scrollUp.js"></script>
</body>

</html>