<?php

include '../components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
};

include '../components/wishlist_cart.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quick View</title>
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <!-- custom css file link  -->
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/user_style.css">
</head>

<body style="height: auto;">

  <?php include '../components/user_header.php'; ?>

  <section class="quick-view">


    <?php
    $pid = $_GET['pid'];
    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $select_products->execute([$pid]);
    if ($select_products->rowCount() > 0) {
      while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <h1 class="heading"><?= $fetch_product['name']; ?></h1>

        <form action="" method="post" class="box">
          <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
          <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
          <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
          <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
          <div class="row">
            <div class="image-container">
              <div class="main-image">
                <img src="../uploaded_img/products/<?= $fetch_product['image_01']; ?>" alt="<?= $fetch_product['image_01']; ?>">
              </div>
              <div class="sub-image">
                <img src="../uploaded_img/products/<?= $fetch_product['image_01']; ?>" alt="<?= $fetch_product['image_01']; ?>">
                <img src="../uploaded_img/products/<?= $fetch_product['image_02']; ?>" alt="<?= $fetch_product['image_02']; ?>">
                <img src="../uploaded_img/products/<?= $fetch_product['image_03']; ?>" alt="<?= $fetch_product['image_03']; ?>">
              </div>
            </div>
            <div class="content">
              <div class="details"><?= $fetch_product['details']; ?></div>
              <div class="info"><span>Brand: </span><?= $fetch_product['brand']; ?></div>
              <div class="info"><span>Release date: </span><?= date('d/m/Y', strtotime($fetch_product['released'])); ?></div>
              <div class="info"><span>CPU: </span><?= $fetch_product['cpu']; ?></div>
              <div class="info"><span>Storage: </span><?= $fetch_product['storage']; ?></div>
              <div class="info"><span>RAM: </span><?= $fetch_product['ram']; ?></div>
              <div class="info"><span>Camera count: </span><?= $fetch_product['camera_count']; ?></div>
              <div class="info"><span>Camera resolution: </span><?= $fetch_product['camera_resolution']; ?></div>
              <div class="info"><span>Display size: </span><?= $fetch_product['size']; ?></div>
              <div class="info"><span>Battery capacity: </span><?= $fetch_product['battery']; ?></div>
              <div class="info"><span>Color: </span><?= $fetch_product['color']; ?></div>
              <?php
              if ($fetch_product["qty"] != 0 && $fetch_product["qty"] <= 5) {
              ?>
                <div class="info" style="color: #9c1313; !important"><span>Remaining quantity: </span><?= $fetch_product['qty']; ?></div>
              <?php
              }
              ?>
              <div class="flex">
                <div class="price"><span>$</span><?= $fetch_product['price']; ?></div>
                <?php
                if ($fetch_product["qty"] > 0) {
                ?>
                  <input type="number" name="qty" class="qty input" min="1" max="<?php echo $fetch_product['qty']; ?>" onkeypress="if(this.value.length == 2) return false;" <?php echo ($fetch_product['qty'] == 0) ? 'disabled value="0"' : 'value="1"'; ?>>
                <?php
                } else {
                ?>
                  <div class="info out-of-stock" style="font-size: 2.5rem;"><span>Out of stock</span></div>
                <?php
                }
                ?>
              </div>
              <div class="flex-btn">
                <button type="submit" name="add_to_cart" class="btn <?php if ($fetch_product['qty'] == 0) echo 'disabled'; ?>" <?php if ($fetch_product['qty'] == 0) echo 'disabled'; ?>>
                  <i class="fas fa-plus"></i> Add to cart
                </button>
                <button class="option-btn" type="submit" name="add_to_wishlist">
                  <i class="fas fa-heart"></i> Add to wishlist
                </button>
              </div>
            </div>
          </div>
        </form>
    <?php
      }
    } else {
      echo '<p class="empty">Invalid product!</p>';
    }
    ?>

  </section>

  <!-- Footer -->
  <?php include '../components/footer.php'; ?>

  <!-- User script -->
  <script src="../js/user_script.js"></script>

  <!-- Scroll up button -->
  <?php include '../components/scroll_up.php'; ?>
  <script src="../js/scrollUp.js"></script>
</body>

</html>
