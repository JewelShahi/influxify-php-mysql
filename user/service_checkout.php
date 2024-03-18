<?php

include '../components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
  header('Location: user_login.php');
}

// Check if service details are passed from another page
if (isset($_POST['service_checkout_data'])) {
  // Retrieve service details from the form
  $service_id = $_POST['id'];
  $service_price = $_POST['price'];
  $service_name = $_POST['name'];
  $service_email = $_POST['email'];
  $service_number = $_POST['number'];
} elseif (isset($_POST['service_checkout'])) {
  // If service checkout data is not posted, check if service details are posted from another form
  $service_id = $_POST['service_id'];
  $service_price = $_POST['service_price'];
  $service_name = $_POST['service_name'];
  $service_email = $_POST['service_email'];
  $service_number = $_POST['service_number'];
} else {
  // If service details are not received, redirect to the appropriate page
  header('Location: service.php');
  exit(); // Stop further execution
}

// Initialize variables to prevent undefined variable warnings
$price = $service_price;
$delivery_option = 'no';

// If the service checkout data is posted, retrieve the service price from the form
if (isset($_POST['service_checkout_data'])) {
  // Retrieve service details from the form
  $service_id = $_POST['id'];
  $service_price = $_POST['price'];

  // Update delivery option and price accordingly
  $method = filter_var($_POST['method'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $delivery_option = isset($_POST['delivery']) ? $_POST['delivery'] : 'no';
  $deliveryPrice = ($delivery_option === 'yes') ? 9.99 : 0.00;

  // Concatenate address components
  if ($delivery_option === 'yes') {
    $flat = filter_var($_POST['flat'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $street = filter_var($_POST['street'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $city = filter_var($_POST['city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $state = filter_var($_POST['state'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $country = filter_var($_POST['country'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $zip_code = filter_var($_POST['zip_code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $address = "Flat no. $flat, $street, $city, $state, $country - $zip_code";
  } else {
    $address = '-';
  }

  $price = $service_price + $deliveryPrice;

  // Update order details in the database
  $updateOrder = $conn->prepare("UPDATE services SET price = ?, delivery = ?, address = ?, payment_method = ? WHERE id = ?");
  $updateOrder->execute([$price, $delivery_option, $address, $method, $service_id]);

  // Redirect to service page after successful payment
  $message[] = 'Successfully paid for the service!';
  header('Location: service.php');
  exit(); // Stop further execution after redirect
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Service payment</title>
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
        <input type="hidden" name="id" value="<?= $service_id; ?>">
        <input type="hidden" name="price" value="<?= $service_price; ?>">
        <input type="hidden" name="name" value="<?= $service_name; ?>">
        <input type="hidden" name="email" value="<?= $service_email; ?>">
        <input type="hidden" name="number" value="<?= $service_number; ?>">

        <h3>Service payment</h3>
        <div class="display-orders">
          <div class="grand-total">Grand total : <span>$<?= $price; ?></span></div>
        </div>
        <h3>Place your info</h3>
        <div class="flex">
          <div class="inputBox">
            <span>Name</span>
            <input type="text" placeholder="Enter your full name" class="box" maxlength="100" value="<?= $service_name ?>" readonly>
          </div>
          <div class="inputBox">
            <span>E-mail</span>
            <input type="email" placeholder="Enter your email" class="box" maxlength="50" value="<?= $service_email ?>" readonly>
          </div>
          <div class="inputBox">
            <span>Phone number</span>
            <input type="number" placeholder="Enter your phone number" class="box" maxlength="15" value="<?= $service_number ?>" readonly>
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
            <span>Include delivery : ($9.99)</span>
            <select name="delivery" id="deliveryOption" class="box" required onchange="toggleAddressFields()">
              <option value="no" <?= ($delivery_option === 'no') ? 'selected' : ''; ?>>No</option>
              <option value="yes" <?= ($delivery_option === 'yes') ? 'selected' : ''; ?>>Yes</option>
            </select>
          </div>
          <div class="inputBox address-field" id="addressFields" style="display: <?= ($delivery_option === 'yes') ? 'block' : 'none'; ?>">
            <span>Address line 01 :</span>
            <input type="text" id="flat" name="flat" placeholder="E.g. Flat number" class="box" maxlength="50">
          </div>
          <div class="inputBox address-field" id="addressFields" style="display: <?= ($delivery_option === 'yes') ? 'block' : 'none'; ?>">
            <span>Address line 02 :</span>
            <input type="text" id="street" name="street" placeholder="E.g. Street name" class="box" maxlength="50">
          </div>
          <div class="inputBox address-field" id="addressFields" style="display: <?= ($delivery_option === 'yes') ? 'block' : 'none'; ?>">
            <span>City :</span>
            <input type="text" id="city" name="city" placeholder="E.g. New York City" class="box" maxlength="50">
          </div>
          <div class="inputBox address-field" id="addressFields" style="display: <?= ($delivery_option === 'yes') ? 'block' : 'none'; ?>">
            <span>State :</span>
            <input type="text" id="state" name="state" placeholder="E.g. New York" class="box" maxlength="50">
          </div>
          <div class="inputBox address-field" id="addressFields" style="display: <?= ($delivery_option === 'yes') ? 'block' : 'none'; ?>">
            <span>Country :</span>
            <input type="text" id="country" name="country" placeholder="E.g. USA" class="box" maxlength="50">
          </div>
          <div class="inputBox address-field" id="addressFields" style="display: <?= ($delivery_option === 'yes') ? 'block' : 'none'; ?>">
            <span>Zip code :</span>
            <input type="number" id="pin_code" min="0" name="zip_code" placeholder="E.g. 12345" min="0" max="99999" onkeypress="if(this.value.length == 5) return false;" class="box">
          </div>
        </div>
        <input type="submit" name="service_checkout_data" class="btn <?= ($service_price > 0.00) ? '' : 'disabled'; ?>" value="Pay for the service">
      </form>
    </section>
  <?php
  }
  ?>

  <!-- Footer -->
  <?php include '../components/footer.php'; ?>

  <!-- User script -->
  <script src="../js/user_script.js"></script>

  <!-- Toggle address fields when delivery option is chnaged -->
  <script>
    const toggleAddressFields = () => {
      const deliveryOption = document.getElementById('deliveryOption').value;
      const addressFields = document.querySelectorAll('.address-field');
      const grandTotal = document.querySelector('.grand-total span');

      addressFields.forEach(field => {
        if (deliveryOption === 'yes') {
          field.style.display = 'block';
          field.querySelector('input').setAttribute('required', 'required');
          // Update grand total with delivery charge
          grandTotal.textContent = '$<?= number_format($price + 9.99, 2); ?>';
        } else {
          field.style.display = 'none';
          field.querySelector('input').removeAttribute('required');
          // Update grand total without delivery charge
          grandTotal.textContent = '$<?= number_format($price, 2); ?>';
        }
      });
    }
  </script>

  <!-- Scroll up button -->
  <?php include '../components/scroll_up.php'; ?>
  <script src="../js/scrollUp.js"></script>

</body>

</html>