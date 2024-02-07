<?php

include 'components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
  header("location:user_login.php");
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders</title>
  <link rel="shortcut icon" href="images/influxify-logo.ico" type="image/x-icon">
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- custom css file link  -->
  <link rel="stylesheet" href="css/global.css">

  <link rel="stylesheet" href="css/user_style.css">
</head>

<body>

  <?php include 'components/user_header.php'; ?>

  <section class="orders">

    <h1 class="heading">Placed orders</h1>

    <div class="box-container">

      <?php

      if ($user_id == '') {
        echo '<p class="empty">Please LogIn to see your order(s)</p>';
      } else {
        $select_orders = $conn->prepare("
          SELECT
            o.id,
            o.name,
            o.number,
            o.email,
            o.method,
            o.address,
            o.payment_status,
            o.order_status,
            o.placed_on,
            SUM(o.price * o.qty) AS total_product_price,
            GROUP_CONCAT(CONCAT(p.name, ' (x', o.qty, ')') ORDER BY o.pid SEPARATOR ', ') AS ordered_products
          FROM
            orders o
          JOIN
            products p ON o.pid = p.id
          WHERE
            o.user_id = ?
          GROUP BY
            o.id
          ORDER BY
            o.placed_on DESC
        ");
        $select_orders->execute([$user_id]);

        if ($select_orders->rowCount() > 0) {
          while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
      ?>
            <div class="box">
              <div>
                <p>Order ID : <span><?= $fetch_orders['id']; ?></span></p>
                <p>Placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
                <p>Name : <span><?= $fetch_orders['name']; ?></span></p>
                <p>E-mail : <span><?= $fetch_orders['email']; ?></span></p>
                <p>Phone number : <span><?= $fetch_orders['number']; ?></span></p>
                <p>Address : <span><?= $fetch_orders['address']; ?></span></p>
                <p>Payment method : <span><?= $fetch_orders['method']; ?></span></p>
                <p>Ordered product(s) : <span><?= $fetch_orders['ordered_products']; ?></span></p>
                <p>Total price : <span>$<?= $fetch_orders['total_product_price']; ?></span></p>
                <p>Payment status : <span><?= $fetch_orders['payment_status']; ?></span> </p>
                <p>Order status : <span><?= $fetch_orders['order_status']; ?></span> </p>
              </div>
            </div>
      <?php
          }
        } else {
          echo '<p class="empty">No orders placed yet.</p>';
        }
      }
      ?>

    </div>

  </section>
  <?php include 'components/footer.php'; ?>

  <script src="js/user_script.js"></script>
  <?php include 'components/scroll_up.php'; ?>
  <script src="js/scrollUp.js"></script>
</body>

</html>