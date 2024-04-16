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
    $postal_code = filter_var($_POST['postal_code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $address = "Блок №: $flat, Улица: $street, Град: $city, Квартал: $state, Държава: $country, Пощенски код: $postal_code";
  } else {
    $address = '-';
  }

  $price = $service_price + $deliveryPrice;

  // Update order details in the database
  $updateOrder = $conn->prepare("UPDATE services SET price = ?, delivery = ?, address = ?, payment_method = ? WHERE id = ?");
  $updateOrder->execute([$price, $delivery_option, $address, $method, $service_id]);

  // Redirect to service page after successful payment
  $message[] = 'Успешно заплатен сервиз!';
  header('Location: service.php');
  exit(); // Stop further execution after redirect
}
?>

<!DOCTYPE html>
<html lang="bg">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Плащане за сервиз</title>
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

        <h3>Плащане за сервиз</h3>
        <div class="display-orders">
          <div class="grand-total">Обща сума : <span>$<?= $price; ?></span></div>
        </div>
        <h3>Вашата информация за плащане/доставка</h3>
        <div class="flex">
          <div class="inputBox">
            <span>Име :</span>
            <input type="text" placeholder="Пълно име" class="box" maxlength="100" value="<?= $service_name ?>" readonly>
          </div>
          <div class="inputBox">
            <span>Имейл :</span>
            <input type="email" placeholder="Имейл" class="box" maxlength="50" value="<?= $service_email ?>" readonly>
          </div>
          <div class="inputBox">
            <span>Тел. номер :</span>
            <input type="number" placeholder="Тел. номер" class="box" maxlength="15" value="<?= $service_number ?>" readonly>
          </div>
          <div class="inputBox">
            <span>Вид на платеж :</span>
            <select name="method" class="box" required>
              <option value="cash on delivery">наложен</option>
              <option value="credit-debit card">кредитна/дебитна карта</option>
              <option value="paypal">PayPal</option>
            </select>
          </div>
          <div class="inputBox">
            <span>Включване на доставка (9.99 лв.): </span>
            <select name="delivery" id="deliveryOption" class="box" required onchange="toggleAddressFields()">
              <option value="no" <?= ($delivery_option === 'no') ? 'selected' : ''; ?>>Не</option>
              <option value="yes" <?= ($delivery_option === 'yes') ? 'selected' : ''; ?>>Да</option>
            </select>
          </div>
          <div class="inputBox address-field" id="addressFields" style="display: <?= ($delivery_option === 'yes') ? 'block' : 'none'; ?>">
            <span>Блок № :</span>
            <input type="text" id="flat" name="flat" placeholder="Блок №" class="box" maxlength="50">
          </div>
          <div class="inputBox address-field" id="addressFields" style="display: <?= ($delivery_option === 'yes') ? 'block' : 'none'; ?>">
            <span>Улица :</span>
            <input type="text" id="street" name="street" placeholder="Улица" class="box" maxlength="50">
          </div>
          <div class="inputBox address-field" id="addressFields" style="display: <?= ($delivery_option === 'yes') ? 'block' : 'none'; ?>">
            <span>Град :</span>
            <input type="text" id="city" name="city" placeholder="Град" class="box" maxlength="50">
          </div>
          <div class="inputBox address-field" id="addressFields" style="display: <?= ($delivery_option === 'yes') ? 'block' : 'none'; ?>">
            <span>Квартал :</span>
            <input type="text" id="state" name="state" placeholder="Квартал" class="box" maxlength="50">
          </div>
          <div class="inputBox address-field" id="addressFields" style="display: <?= ($delivery_option === 'yes') ? 'block' : 'none'; ?>">
            <span>Държава :</span>
            <input type="text" id="country" name="country" placeholder="Държава" class="box" maxlength="50">
          </div>
          <div class="inputBox address-field" id="addressFields" style="display: <?= ($delivery_option === 'yes') ? 'block' : 'none'; ?>">
            <span>Пощенски код :</span>
            <input type="number" id="pin_code" min="0" name="postal_code" placeholder="000000" min="0" max="999999" onkeypress="if(this.value.length > 6) return false;" class="box">
          </div>
        </div>
        <input type="submit" name="service_checkout_data" class="btn <?= ($service_price > 0.00) ? '' : 'disabled'; ?>" value="Плати за сервиза">
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