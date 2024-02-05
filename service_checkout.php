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

if (isset($_POST['service_checkout'])) {
  $service_id = $_POST['service_id'];
  $service_name = $_POST['service_name'];
  $service_email = $_POST['service_email'];
  $service_price = $_POST['service_price'];
}

$deliveryOption = 'no';

if (isset($_POST['service_checkout_data'])) {
  $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $number = filter_var($_POST['number'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $method = filter_var($_POST['method'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $address = 'Flat no. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code'];
  $address = filter_var($address, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $deliveryOption = $_POST['delivery'];
  $deliveryPrice = ($deliveryOption === 'yes') ? 15.99 : 0.00;

  $service_price += $deliveryPrice;
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

      <h3>Service payment</h3>

      <div class="display-orders">

        <div class="grand-total">Grand total : <span>$<?= $service_price; ?></span></div>

      </div>

      <h3>Place your info</h3>

      <div class="flex">
        <div class="inputBox">
          <span>Your name :</span>
          <input type="text" name="name" placeholder="Enter your name" class="box" maxlength="100" value="<?= $service_name; ?>" required>
        </div>
        <div class="inputBox">
          <span>Your phone number :</span>
          <input type="number" name="number" placeholder="Enter your phone number" class="box" min="0" max="999999999999999" onkeypress="if(this.value.length < 10 || this.value.length > 15) return false;" required>
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
          <span>Include delivery : ($15.99)</span>
          <select name="delivery" id="deliveryOption" class="box" required onchange="toggleAddressFields()">
            <option value="no" selected <?= ($deliveryOption === 'no') ? 'selected' : ''; ?>>No</option>
            <option value="yes" <?= ($deliveryOption === 'yes') ? 'selected' : ''; ?>>Yes</option>
          </select>
        </div>
        <div id="addressFields" style="display: <?= ($deliveryOption === 'yes') ? 'block' : 'none'; ?>">
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

      <input type="submit" name="service_checkout_data" class="btn <?= ($service_price > 0.00) ? '' : 'disabled'; ?>" value="Place order">

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

      if (deliveryOption.value === 'yes') {
        addressFields.style.display = 'block';
      } else {
        addressFields.style.display = 'none';
      }
    }

    // Call the function on page load to set the initial state
    window.onload = toggleAddressFields;
  </script>

</body>

</html>