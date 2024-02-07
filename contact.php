<?php
include 'components/connect.php';
session_name('user_session');
session_start();

if (isset($_SESSION['user_session']['user_id'])) {
  $user_id = $_SESSION['user_session']['user_id'];
} else {
  $user_id = '';
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us</title>
  <link rel="shortcut icon" href="images/influxify-logo.ico" type="image/x-icon">
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- custom css file link  -->
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/user_style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
      color: #333;
    }

    .container {
      max-width: 600px;
      margin: 50px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      color: #333;
    }

    p {
      margin-bottom: 15px;
    }

    .contact-info {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .contact-info i {
      margin-right: 10px;
    }
  </style>
</head>

<body>

  <?php include 'components/user_header.php'; ?>

  <div class="container">
    <h1>Contact Us</h1>

    <div class="contact-info">
      <p><i class="fas fa-map-marker-alt"></i> Our Shop Location: 123 Main Street, Cityville</p>
      <p><i class="fas fa-phone"></i> Phone: +1 555-1234</p>
      <p><i class="fas fa-envelope"></i> Email: info@example.com</p>
    </div>

    <h2>Owner Details</h2>
    <p><strong>Owner Name:</strong> John Doe</p>
    <p><strong>Email:</strong> john.doe@example.com</p>
    <p><strong>Phone:</strong> +1 555-5678</p>
  </div>

  <?php include 'components/scroll_up.php'; ?>
  <script src="js/scrollUp.js"></script>

  <?php include 'components/footer.php'; ?>
  <script src="js/user_script.js"></script>
</body>

</html>