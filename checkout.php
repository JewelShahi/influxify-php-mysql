<?php
include 'components/connect.php';
session_name('user_session');
session_start();

if (isset($_SESSION['user']['user_id'])) {
  $user_id = $_SESSION['user']['user_id'];
} else {
  $user_id = '';
  header('location:user_login.php');
};

if (isset($_POST['order'])) {

  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $number = $_POST['number'];
  $number = filter_var($number, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $method = $_POST['method'];
  $method = filter_var($method, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $address = 'Flat no. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code'];
  $address = filter_var($address, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $total_products = $_POST['total_products'];
  $total_price = $_POST['total_price'];

  $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
  $check_cart->execute([$user_id]);

  if ($check_cart->rowCount() > 0) {

    // Increment the order
    $get_last_order_id = $conn->query("SELECT MAX(id) AS last_order_id FROM `orders`")->fetch();
    $order_id = ($get_last_order_id['last_order_id'] !== null) ? $get_last_order_id['last_order_id'] + 1 : 1;

    try {

      $get_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $get_cart_items->execute([$user_id]);

      while ($cart_item = $get_cart_items->fetch()) {

        $products_price = $cart_item['price'];

        // Insert each product along with overall order details into the orders table
        $insert_order_item = $conn->prepare("INSERT INTO `orders`(
          id, user_id, pid, qty, name, number, email, method, address, price, payment_status, order_status
        ) VALUES(?,?,?,?,?,?,?,?,?,?,'pending', 'processing')");
        $insert_order_item->execute([$order_id, $user_id, $cart_item['pid'], $cart_item['quantity'], $name, $number, $email, $method, $address, $products_price]);
      }

      // Delete items from the cart
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'Order placed successfully!';
    } catch (Exception $e) {
      $message[] = 'Error placing order. Please try again.';
    }
  } else {
    $message[] = 'Your cart is empty';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link rel="shortcut icon" href="images/influxify-logo.ico" type="image/x-icon">
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- custom css file link  -->
  <link rel="stylesheet" href="css/global.css">

  <link rel="stylesheet" href="css/user_style.css">
</head>

<body>

  <?php include 'components/user_header.php'; ?>

  <section class="checkout-orders">

    <form action="" method="POST">

      <h3>Your orders</h3>

      <div class="display-orders">
        <?php
        $grand_total = 0;
        $cart_items[] = '';
        $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $select_cart->execute([$user_id]);
        if ($select_cart->rowCount() > 0) {
          while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
            $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
            $total_products = implode($cart_items);
            $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
        ?>
            <p> <?= $fetch_cart['name']; ?> <span>(<?= '$' . $fetch_cart['price'] . '/- x ' . $fetch_cart['quantity']; ?>)</span> </p>
        <?php
          }
        } else {
          echo '<p class="empty">Your cart is empty!</p>';
        }
        ?>
        <input type="hidden" name="total_products" value="<?= $total_products; ?>">
        <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
        <div class="grand-total">Grand total : <span>$<?= $grand_total; ?>/-</span></div>
      </div>

      <h3>Place your shipping info</h3>

      <div class="flex">
        <div class="inputBox">
          <span>Your name :</span>
          <input type="text" name="name" placeholder="Enter your name" class="box" maxlength="20" required>
        </div>
        <div class="inputBox">
          <span>Your phonr number :</span>
          <input type="number" name="number" placeholder="Enter your phone number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
        </div>
        <div class="inputBox">
          <span>Your email :</span>
          <input type="email" name="email" placeholder="Enter your email" class="box" maxlength="50" required>
        </div>
        <div class="inputBox">
          <span>Payment method :</span>
          <select name="method" class="box" required>
            <option value="cash on delivery">cash on delivery</option>
            <option value="credit card">credit card</option>
            <option value="paypal">paypal</option>
          </select>
        </div>
        <div class="inputBox">
          <span>Address line 01 :</span>
          <input type="text" name="flat" placeholder="E.g. Flat number" class="box" maxlength="50" required>
        </div>
        <div class="inputBox">
          <span>Address line 02 :</span>
          <input type="text" name="street" placeholder="E.g. Street name" class="box" maxlength="50" required>
        </div>
        <div class="inputBox">
          <span>City :</span>
          <input type="text" name="city" placeholder="E.g. New York City" class="box" maxlength="50" required>
        </div>
        <div class="inputBox">
          <span>State :</span>
          <input type="text" name="state" placeholder="E.g. New York" class="box" maxlength="50" required>
        </div>
        <div class="inputBox">
          <span>Country :</span>
          <input type="text" name="country" placeholder="E.g. USA" class="box" maxlength="50" required>
        </div>
        <div class="inputBox">
          <span>Pin code :</span>
          <input type="number" min="0" name="pin_code" placeholder="E.g. 123456" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
        </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" value="Place order">

    </form>

  </section>
  <?php include 'components/footer.php'; ?>

  <script src="js/user_script.js"></script>
  <?php include 'components/scroll_up.php'; ?>
  <script src="js/scrollUp.js"></script>
</body>

</html>