<?php
include 'components/connect.php';
session_start();
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
};

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

<body>

  <?php include 'components/user_header.php'; ?>

  <section class="contact" style="min-height: 100%;">

    <h1 class="heading">Placed Services</h1>

    <?php
    if ($user_id == '') {
      echo '<p class="empty">Please Log In add or see service(s).</p>';
    } else {
    ?>
      <form action="" method="post">
        <h3>Add a service ticket</h3>
        <input type="text" name="name" placeholder="Enter your name" required class="box">
        <input type="email" name="email" placeholder="Enter your email" required class="box">
        <input type="number" name="number" min="0" max="9999999999" placeholder="Enter your phone number" required onkeypress="if(this.value.length == 10) return false;" class="box">
        <input type="text" name="brand" placeholder="Enter phone brand" required class="box">
        <textarea name="description" class="box" placeholder="Enter description" cols="30" rows="10"></textarea>
        <input type="submit" value="Add service ticket" name="send" class="btn">
      </form>

      <div class="box-container">
        <?php
        $select_services = $conn->prepare("SELECT * FROM `services` WHERE user_id = ?");
        $select_services->execute([$user_id]);
        if ($select_services->rowCount() > 0) {
          while ($fetch_orders = $select_services->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="box">
              <p>Placed on: <span><?= $fetch_orders['placed_on']; ?></span></p>
              <p>Name: <span><?= $fetch_orders['name']; ?></span></p>
              <p>E-mail: <span><?= $fetch_orders['email']; ?></span></p>
              <p>Phone number: <span><?= $fetch_orders['number']; ?></span></p>
              <p>Phone brand: <span><?= $fetch_orders['brand']; ?></span></p>
              <p>Problem: <span><?= $fetch_orders['description']; ?></span></p>
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