<?php

// Trying to connect to the db
include '../components/connect.php';

// Start the session
session_start();

// Check if the user has a session
if (isset($_SESSION['admin_id'])) {
  $admin_id = $_SESSION['admin_id'];
} else {
  $admin_id = '';
  header('Location: admin_login.php');
};

// Update payment status
if (isset($_POST['update_payment'])) {
  $order_id = $_POST['order_id'];

  if (isset($_POST['payment_status'])) {
    $payment_status = $_POST['payment_status'];
    $payment_status = filter_var($payment_status, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $update_payment_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_payment_status->execute([$payment_status, $order_id]);

    $message[] = 'Статусът на плащане е актуализиран!';
  }

  if (isset($_POST['order_status'])) {
    $order_status = $_POST['order_status'];
    $order_status = filter_var($order_status, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $update_order_status = $conn->prepare("UPDATE `orders` SET order_status = ? WHERE id = ?");
    $update_order_status->execute([$order_status, $order_id]);

    $message[] = 'Статусът на поръчката е актуализиран!';
  }
}

// Delete placed order
if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];

  // Fetch order details to return product quantities
  $get_order_items = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
  $get_order_items->execute([$delete_id]);

  while ($order_item = $get_order_items->fetch()) {
    $pid = $order_item['pid'];
    $qty = $order_item['qty'];
    $order_status = $order_item['order_status'];

    // Check if order is not delivered
    if ($order_status !== 'delivered') {
      // Update product quantity
      $update_product_qty = $conn->prepare("UPDATE `products` SET qty = qty + ? WHERE id = ?");
      $update_product_qty->execute([$qty, $pid]);
    }
  }

  // Delete the order
  $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
  $delete_order->execute([$delete_id]);

  header('Location: placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="bg">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Поръчки</title>
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <!-- Custom css -->
  <link rel="stylesheet" href="../css/admin_style.css">
  <link rel="stylesheet" href="../css/global.css">

  <style>

  </style>

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
    <section class="orders">

      <h1 class="heading">Поръчки</h1>

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
          o.delivery,
          o.delivery_cost,
          o.address,
          o.payment_status,
          o.order_status,
          o.placed_on,
          SUM(o.price * o.qty) AS total_product_price,
          GROUP_CONCAT(CONCAT(p.name, ' (x', o.qty, ')') ORDER BY o.pid SEPARATOR ', ') AS ordered_products,
          GROUP_CONCAT(p.image_01 ORDER BY o.pid SEPARATOR ', ') AS ordered_product_images
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
            // Split the ordered products and their images into arrays
            $ordered_products = explode(", ", $fetch_orders['ordered_products']);
            $ordered_product_images = explode(", ", $fetch_orders['ordered_product_images']);
        ?>
            <div class="box">
              <div class="blur">
                <p> Поръчка № : <span><?= $fetch_orders['id']; ?></span> </p>
                <p> Заявена на : <span><?= date('d/m/Y H:i:s', strtotime($fetch_orders['placed_on'])); ?></span> </p>
                <p> Клиент № : <span><?= $fetch_orders['user_id']; ?></span> </p>
                <p> Име : <span><?= $fetch_orders['name']; ?></span> </p>
                <p> Имейл : <span><?= $fetch_orders['email']; ?></span> </p>
                <p> Тел. : <span><?= $fetch_orders['number']; ?></span> </p>
                <p style="<?= ($fetch_orders['delivery'] == 'yes') ? '' : 'display: none;'; ?>">Доставка : <span><?= $fetch_orders['delivery']; ?></span></p>
                <p style="<?= ($fetch_orders['delivery'] == 'yes') ? '' : 'display: none;'; ?>">Цена за доставка : <span><?= $fetch_orders['delivery_cost']; ?></span></p>
                <p> Адрес : <span><?= $fetch_orders['address']; ?></span> </p>
                <p> Поръчани продукти : <span><?= $fetch_orders['ordered_products']; ?></span> </p>
                <div class="ordered-img">
                  <?php
                  for ($i = 0; $i < count($ordered_products); $i++) {
                    echo '<img class="ordered-img-item" src="../uploaded_img/products/' . $ordered_product_images[$i] . '" alt="' . $ordered_product_images[$i] . '">';  // Modified: Added image display
                  }
                  ?>
                </div>
                <p> Обща цена : <span>$<?= $fetch_orders['total_product_price'] + $fetch_orders['delivery_cost']; ?></span> </p>
                <p> Вид на платежа : <span><?= $fetch_orders['method']; ?></span> </p>

                <form action="" method="post">

                  <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                  <p id="paymentStatusLabel">Статус на плащане :</p>
                  <select name="payment_status" class="select" aria-labelledby="paymentStatusLabel">
                    <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
                    <option value="pending">Неплатен</option>
                    <option value="completed">Платен</option>
                  </select>

                  <p id="orderStatusLabel">Статус на поръчката :</p>
                  <select name="order_status" class="select" aria-labelledby="orderStatusLabel">
                    <option selected disabled><?= $fetch_orders['order_status']; ?></option>
                    <option value="processing">Обработва се</option>
                    <option value="shipping">Доставя се</option>
                    <option value="delivered">Доставен</option>
                  </select>

                  <div class="flex-btn">
                    <input type="submit" value="Обнови" class="option-btn" name="update_payment">
                    <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Съгласен ли си да изтриеш поръчката?');">Изтрий</a>
                  </div>
                </form>
              </div>
            </div>
        <?php
          }
        } else {
          echo '<p class="empty">Няма заявени поръчки.</p>';
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