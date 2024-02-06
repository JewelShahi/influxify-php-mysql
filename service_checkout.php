<?php
include 'components/connect.php';
session_name('user_session');
session_start();

if (isset($_SESSION['user']['user_id'])) {
  $user_id = $_SESSION['user']['user_id'];
} else {
  $user_id = '';
  header('location:user_login.php');
}

// If the service checkout data is posted, retrieve the service price from the form
if (isset($_POST['service_checkout_data'])) {
  // Retrieve service details from the form
  $service_id = $_POST['id'];
  $service_price = $_POST['price'];
} elseif (isset($_POST['service_checkout'])) {
  // If service checkout data is not posted, check if service details are posted from another form
  $service_id = $_POST['service_id'];
  $service_price = $_POST['service_price'];
}

// Default delivery option and price
$delivery_option = 'no';
$deliveryPrice = 0.00;

if (isset($_POST['service_checkout_data'])) {
  // If service checkout data is posted, update delivery option and price accordingly
  $id = $_POST['id'];
  $method = filter_var($_POST['method'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  // Concatenate address components
  $address = trim($_POST['flat']) . ', ' . trim($_POST['street']) . ', ' . trim($_POST['city']) . ', ' . trim($_POST['state']) . ', ' . trim($_POST['country']) . ' - ' . trim($_POST['pin_code']);
  // If the concatenated address contains only commas (',') or is empty, set it to "-"
  $address = (strpos($address, ',') === false || trim($address, ', ') === '') ? "-" : filter_var($address, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  // Check if delivery option is set, otherwise default to 'no'
  $delivery_option = isset($_POST['delivery']) ? $_POST['delivery'] : 'no';
  $deliveryPrice = ($delivery_option === 'yes') ? 9.99 : 0.00;

  // Calculate total price
  $price = $service_price + $deliveryPrice;

  // Update order details in the database
  $updateOrder = $conn->prepare("UPDATE services SET price = ?, delivery = ?, address = ?, payment_method = ? WHERE id = ?");
  $updateOrder->execute([$price, $delivery_option, $address, $method, $id]);

  // Redirect to service page after successful payment
  $message[] = 'Successfully paid for the service!';
  header('location:service.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Service payment</title>
  <link rel="shortcut icon" href="images/influxify-logo.ico" type="image/x-icon">
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- custom css file link  -->
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/user_style.css">
  <!-- JavaScript for dynamic address fields -->
</head>

<body>

  <?php include 'components/user_header.php'; ?>

  <section class="checkout-orders">

    <form action="" method="POST">
      <input type="hidden" name="id" value="<?= $service_id; ?>">
      <input type="hidden" name="price" value="<?= $service_price; ?>">
      <h3>Service payment</h3>
      <div class="display-orders">
        <div class="grand-total">Grand total : <span>$<?= $price; ?></span></div>
      </div>
      <h3>Place your info</h3>
      <div class="flex">
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
        <div id="addressFields" style="display: <?= ($delivery_option === 'yes') ? 'block' : 'none'; ?>">
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
      </div>
      <input type="submit" name="service_checkout_data" class="btn <?= ($service_price > 0.00) ? '' : 'disabled'; ?>" value="Pay for the service">
    </form>

  </section>
  <?php include 'components/footer.php'; ?>

  <script src="js/user_script.js"></script>
  <?php include 'components/scroll_up.php'; ?>
  <script src="js/scrollUp.js"></script>

  <script>
    // Function to toggle address fields based on delivery option
    const toggleAddressFields = () => {
      const deliveryOption = document.getElementById('deliveryOption');
      const addressFields = document.getElementById('addressFields');
      const addressInputs = addressFields.querySelectorAll('input, select');

      if (deliveryOption.value === 'yes') {
        addressFields.style.display = 'block';
        // Update total price with delivery cost
        updateTotalPrice(true);
        // Make address fields required
        addressInputs.forEach(input => input.required = true);
      } else {
        addressFields.style.display = 'none';
        // Update total price without delivery cost
        updateTotalPrice(false);
        // Remove required attribute from address fields
        addressInputs.forEach(input => input.required = false);
      }
    }

    // Function to update total price based on delivery option
    const updateTotalPrice = (hasDelivery) => {
      const grandTotalSpan = document.querySelector('.grand-total span');
      // Retrieve the price from the form
      const priceInput = document.querySelector('input[name="price"]');
      const servicePrice = parseFloat(priceInput.value);
      const deliveryCost = 9.99;

      const totalPrice = hasDelivery ? servicePrice + deliveryCost : servicePrice;
      grandTotalSpan.textContent = '$' + totalPrice.toFixed(2);
    }

    // Call the function on page load to set the initial state
    window.onload = toggleAddressFields;

    // Attach the function to the change event of the delivery option select
    const deliveryOption = document.getElementById('deliveryOption');
    deliveryOption.addEventListener('change', toggleAddressFields);
  </script>

</body>

</html>