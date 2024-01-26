<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
}

if (isset($_POST['send'])) {

  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $number = $_POST['number'];
  $number = filter_var($number, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $brand = $_POST['brand'];
  $brand = filter_var($brand, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $description = $_POST['description'];
  $description = filter_var($description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $insert_service = $conn->prepare("INSERT INTO `services` (user_id, name, email, number, brand, description) VALUES(?,?,?,?,?,?)");
  $insert_service->execute([$user_id, $name, $email, $number, $brand, $description]);

  $message[] = 'Service ticket sent successfully!';

  // Redirect to a different page to prevent form resubmission
  header('location:service.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Services</title>
  <link rel="shortcut icon" href="images/influxify-logo.ico" type="image/x-icon">
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- custom css file link  -->
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/user_style.css">
</head>

<body style="height: 100%;">

  <?php include 'components/user_header.php'; ?>

  <section class="service" style="min-height: 100%;">

    <h1 class="heading">Services</h1>

    <?php
    if ($user_id == '') {
      echo '<p class="empty">Please Log In add or see service(s).</p>';
    } else {
    ?>
      <div class="add-ticket">
        <form action="" method="post">
          <h3>Add a service ticket</h3>
          <input type="text" name="name" placeholder="Enter your name" required class="box">
          <input type="email" name="email" placeholder="Enter your email" required class="box">
          <input type="number" name="number" min="0" max="9999999999" placeholder="Enter your phone number" required onkeypress="if(this.value.length == 10) return false;" class="box">
          <input type="text" name="brand" placeholder="Enter phone brand" required class="box">
          <textarea name="description" class="box" placeholder="Enter description" cols="30" rows="10"></textarea>
          <button type="submit" name="send" class="btn">Add service ticket</button>
        </form>
        <div class="map">
          <h3>Our location</h3>
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2933.568532981854!2d23.361773000000003!3d42.6704979!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40aa8587e5b96129%3A0xbbf46b29a556f55d!2z0KHQn9CT0JUg4oCe0JTQttC-0L0g0JDRgtCw0L3QsNGB0L7QsuKAnA!5e0!3m2!1sbg!2sbg!4v1706308694525!5m2!1sbg!2sbg" width="600" height="550" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>

      <?php
      $select_services = $conn->prepare("SELECT * FROM `services` WHERE user_id = ?");
      $select_services->execute([$user_id]);
      if ($select_services->rowCount() > 0) {
      ?>
        <h3 class="heading-2">Placed services</h3>
        <div class="service-box-container">
          <?php
          while ($fetch_orders = $select_services->fetch(PDO::FETCH_ASSOC)) {
          ?>
            <div class="service-box">
              <div>
                <p>Placed on: <span><?= $fetch_orders['placed_on']; ?></span></p>
                <p>Name: <span><?= $fetch_orders['name']; ?></span></p>
                <p>E-mail: <span><?= $fetch_orders['email']; ?></span></p>
                <p>Phone number: <span><?= $fetch_orders['number']; ?></span></p>
                <p>Phone brand: <span><?= $fetch_orders['brand']; ?></span></p>
                <p>Problem: <span><?= $fetch_orders['description']; ?></span></p>
              </div>
            </div>
        <?php
          }
        } else {
          echo '<p class="empty">No placed service(s) yet.</p>';
        }
        ?>
        </div>
      <?php
    }
      ?>
  </section>


  <?php include 'components/footer.php'; ?>

  <script src="js/user_script.js"></script>
  <?php include 'components/scroll_up.php'; ?>
  <script src="js/scrollUp.js"></script>
</body>

</html>