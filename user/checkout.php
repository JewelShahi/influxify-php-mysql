<?php
include '../components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
  header('Location: user_login.php');
}

if (isset($_POST['order'])) {

  $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $number = filter_var($_POST['number'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $method = filter_var($_POST['method'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $delivery_option = filter_var($_POST['delivery'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  // Check if delivery option is set to "yes" and handle address fields accordingly
  if ($delivery_option === 'yes') {
    $flat = filter_var($_POST['flat'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $street = filter_var($_POST['street'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $city = filter_var($_POST['city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $state = filter_var($_POST['state'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $country = filter_var($_POST['country'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $postal_code = filter_var($_POST['postal_code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $address = "Flat №: $flat, Street: $street, City: $city, State: $state, Country: $country, Post code: $postal_code";
    $delivery_cost = 9.99; // Assuming delivery cost is fixed at $9.99
  } else {
    // If delivery option is "no", set address to empty string and delivery cost to 0
    $address = '-';
    $delivery_cost = 0;
  }

  $total_products = $_POST['total_products'];
  $total_price = $_POST['total_price'];

  // Add delivery cost to the total price if delivery option is set to "yes"
  $total_price += $delivery_cost;

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

        $pid = $cart_item['pid'];
        $qty = $cart_item['quantity'];
        $products_price = $cart_item['price'];

        // Insert each product along with overall order details into the orders table
        $insert_order_item = $conn->prepare("
          INSERT INTO `orders`(id, user_id, pid, qty, name, number, email, method, address, price, delivery, delivery_cost, payment_status, order_status)
          VALUES(?,?,?,?,?,?,?,?,?,?,?,?, 'pending', 'processing')
        ");
        $insert_order_item->execute([$order_id, $user_id, $pid, $qty, $name, $number, $email, $method, $address, $products_price, $delivery_option, $delivery_cost]);
      }

      // Delete items from the cart
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'Order placed successfully!';
    } catch (Exception $e) {
      $message[] = 'Error placing order. Please try again.';
    }
  } else {
    $message[] = 'Your cart is empty!';
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
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- custom css file link  -->
  <link rel="stylesheet" href="../css/global.css">

  <link rel="stylesheet" href="../css/user_style.css">
</head>

<body style="height: auto;">

  <?php include '../components/user_header.php'; ?>

  <?php
  $select_user_exists = $conn->prepare("SELECT id FROM `users` WHERE id = ?");
  $select_user_exists->execute([$user_id]);
  if ($select_user_exists->rowCount() == 0) {
    header("Location: user_login.php");
  } else {
  ?>

    <section class="checkout-orders">

      <form action="" method="POST">

        <h3>Your orders</h3>

        <div class="display-orders">
          <?php
          $grand_total = 0;
          $cart_items[] = '';
          $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
          $select_cart->execute([$user_id]);

          // Check if there are any rows returned by the SELECT query
          if ($select_cart->rowCount() > 0) {

            // Fetches the next row from the result set returned by the SELECT query as an associative array
            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
              
              // Accessing the value of the 'name', 'price' and 'quantity' columns from the fetched row
              $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
              $total_products = implode($cart_items);
              $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
          ?>
              <p> <?= $fetch_cart['name']; ?> <span>(<?= '$' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity']; ?>)</span> </p>
          <?php
            }
          } else {
            echo '<p class="empty">Your cart is empty!</p>';
          }
          ?>
          <input type="hidden" name="total_products" value="<?= $total_products; ?>">
          <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
          <div class="delivery-cost" style="display: none;">Delivery cost: <span>$9.99</span></div>
          <div class="grand-total">Grand total : <span>$<?= $grand_total; ?></span></div>
        </div>

        <h3>Place your payment/shipping info</h3>

        <div class="flex">
          <div class="inputBox">
            <span>Your name :</span>
            <input type="text" name="name" placeholder="Enter your name" class="box" maxlength="100" required>
          </div>
          <div class="inputBox">
            <span>Your phone number :</span>
            <input type="number" name="number" placeholder="Enter your phone number" class="box" min="0" max="999999999999999" onkeypress="if(this.value.length > 15) return false;" required>
          </div>
          <div class="inputBox">
            <span>Your email :</span>
            <input type="email" name="email" placeholder="Enter your email" class="box" maxlength="50" required>
          </div>
          <div class="inputBox">
            <span>Payment method :</span>
            <select name="method" class="box" required>
              <option value="cash on delivery">cash on delivery</option>
              <option value="credit-debit card">credit card</option>
              <option value="paypal">PayPal</option>
            </select>
          </div>
          <div class="inputBox">
            <span>Include delivery : ($9.99) :</span>
            <select name="delivery" class="box" required onchange="updateTotalPrice(this.value)">
              <option value="no">No</option>
              <option value="yes">Yes</option>
            </select>
          </div>
          <div class="inputBox" id="addressFields" style="display: none;">
            <span>Flat № :</span>
            <input type="text" name="flat" placeholder="E.g. Flat number" class="box" maxlength="50" required>
          </div>
          <div class="inputBox" id="addressFields" style="display: none;">
            <span>Street :</span>
            <input type="text" name="street" placeholder="E.g. Street name" class="box" maxlength="50" required>
          </div>
          <div class="inputBox" id="addressFields" style="display: none;">
            <span>City :</span>
            <input type="text" name="city" placeholder="E.g. New York City" class="box" maxlength="50" required>
          </div>
          <div class="inputBox" id="addressFields" style="display: none;">
            <span>State :</span>
            <input type="text" name="state" placeholder="E.g. New York" class="box" maxlength="50" required>
          </div>
          <div class="inputBox" id="addressFields" style="display: none;">
            <span>Country :</span>
            <input type="text" name="country" placeholder="E.g. USA" class="box" maxlength="50" required>
          </div>
          <div class="inputBox" id="addressFields" style="display: none;">
            <span>Postal code :</span>
            <input type="number" min="0" name="postal_code" placeholder="E.g. 123456" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
          </div>
        </div>

        <input type="submit" name="order" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" value="Place order">

      </form>
    </section>
  <?php
  }
  ?>

  <!-- Footer -->
  <?php include '../components/footer.php'; ?>

  <!-- User script -->
	<script src="../js/user_script.js"></script>

  <!-- Update the total price when user wants delivery -->
  <script>
    const updateTotalPrice = (deliveryOption) => {
      const grandTotalSpan = document.querySelector('.grand-total span');
      const deliveryCostDiv = document.querySelector('.delivery-cost');
      const totalPriceInput = document.querySelector('input[name="total_price"]');
      const totalPrice = parseFloat(totalPriceInput.value);
      const deliveryCost = deliveryOption === 'yes' ? 9.99 : 0;
      const totalWithDelivery = totalPrice + deliveryCost;

      deliveryCostDiv.style.display = deliveryOption === 'yes' ? 'block' : 'none';
      grandTotalSpan.textContent = '$' + totalWithDelivery.toFixed(2);

      const addressFields = document.querySelectorAll('.inputBox[id="addressFields"] input');
      addressFields.forEach(input => {
        input.required = deliveryOption === 'yes';
        const display = deliveryOption === 'yes' ? 'block' : 'none';
        input.closest('.inputBox').style.display = display;
      });
    }
  </script>

  <!-- Scroll up button -->
  <?php include '../components/scroll_up.php'; ?>
  <script src="../js/scrollUp.js"></script>
</body>

</html>
