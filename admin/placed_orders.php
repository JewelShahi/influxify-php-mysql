<?php

include '../components/connect.php';

session_name('admin_session');
session_start();

$admin_id = $_SESSION['admin_session']['admin_id'];

if (!isset($admin_id)) {
  header('location:admin_login.php');
}

if (isset($_POST['update_payment'])) {
  $order_id = $_POST['order_id'];

  if (isset($_POST['payment_status'])) {
    $payment_status = $_POST['payment_status'];
    $payment_status = filter_var($payment_status, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $update_payment_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_payment_status->execute([$payment_status, $order_id]);

    $message[] = 'Payment status updated!';
  }

  if (isset($_POST['order_status'])) {
    $order_status = $_POST['order_status'];
    $order_status = filter_var($order_status, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $update_order_status = $conn->prepare("UPDATE `orders` SET order_status = ? WHERE id = ?");
    $update_order_status->execute([$order_status, $order_id]);
    
    $message[] = 'Order status updated!';
  }
}

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
  $delete_order->execute([$delete_id]);

  header('location: placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Placed Orders</title>
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="../css/admin_style.css">
  <link rel="stylesheet" href="../css/global.css">

</head>

<body>

  <?php include '../components/admin_header.php'; ?>

  <section class="orders">

    <h1 class="heading">Placed Orders</h1>

    <div class="box-container">

      <?php
      $select_orders = $conn->prepare("
        SELECT
          o.id,
          o.user_id,
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
        GROUP BY
          o.id
        ORDER BY
          o.placed_on DESC;
      ");

      $select_orders->execute();

      if ($select_orders->rowCount() > 0) {
        while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
      ?>
          <div class="box">
            <div class="blur">
              <p> Order ID : <span><?= $fetch_orders['id']; ?></span> </p>
              <p> Placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
              <p> User ID : <span><?= $fetch_orders['user_id']; ?></span> </p>
              <p> Name : <span><?= $fetch_orders['name']; ?></span> </p>
              <p> E-mail : <span><?= $fetch_orders['email']; ?></span> </p>
              <p> Phone number : <span><?= $fetch_orders['number']; ?></span> </p>
              <p> Address : <span><?= $fetch_orders['address']; ?></span> </p>
              <p> Total products : <span><?= $fetch_orders['ordered_products']; ?></span> </p>
              <p> Total price : <span>$<?= $fetch_orders['total_product_price']; ?>/-</span> </p>
              <p> Payment method : <span><?= $fetch_orders['method']; ?></span> </p>

              <form action="" method="post">

                <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                <p id="paymentStatusLabel">Payment status :</p>
                <select name="payment_status" class="select" aria-labelledby="paymentStatusLabel">
                  <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
                  <option value="pending">Pending</option>
                  <option value="completed">Completed</option>
                </select>

                <p id="orderStatusLabel">Order status :</p>
                <select name="order_status" class="select" aria-labelledby="orderStatusLabel">
                  <option selected disabled><?= $fetch_orders['order_status']; ?></option>
                  <option value="processing">Processing</option>
                  <option value="shipping">Shipping</option>
                  <option value="delivered">Delivered</option>
                </select>

                <div class="flex-btn">
                  <input type="submit" value="Update" class="option-btn" name="update_payment">
                  <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a>
                </div>
              </form>
            </div>
          </div>
      <?php
        }
      } else {
        echo '<p class="empty">No orders placed yet</p>';
      }
      ?>

    </div>

  </section>

  </section>
  <script src="../js/admin_script.js"></script>
  <?php include '../components/scroll_up.php'; ?>
  <script src="../js/scrollUp.js"></script>
</body>

</html>