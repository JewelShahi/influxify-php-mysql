<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="shortcut icon" href="images/influxify-logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- custom css file link -->
  <link rel="stylesheet" href="css/global.css">

  <link rel="stylesheet" href="css/user_style.css">
</head>

<body>

  <?php include 'components/user_header.php'; ?>
  <div class="home-bg">
    <section class="home">
      <div class="swiper home-slider">
        <div class="swiper-wrapper">
          <?php
          $displayPhones = array(
            "Samsung Galaxy s23 FE" => "The Samsung Galaxy s23 FE is a flagship smartphone featuring a powerful camera system, high-end performance, and a stunning display.",
            "Google Pixel 6 Pro" => "The Google Pixel 6 Pro is known for its exceptional camera capabilities, seamless integration with Google services, and sleek design.",
            "iPhone 13 Pro Max" => "The iPhone 13 Pro Max is Apple's top-of-the-line smartphone, offering cutting-edge performance, a pro-grade camera system, and a large Super Retina XDR display.",
            "Xiaomi Mi 11 Ultra" => "The Xiaomi Mi 11 Ultra boasts an impressive camera setup, powerful specifications, and a unique secondary display on the back for notifications and customization.",
            "OnePlus 9 Pro" => "The OnePlus 9 Pro is a flagship killer with top-notch performance, a high-refresh-rate display, and a versatile camera system developed in collaboration with Hasselblad."
          );

          $displayPhoneNames = array_keys($displayPhones);
          $numSmartphones = count($displayPhoneNames);
          ?>

          <?php for ($i = 0; $i < 5; $i++) { ?>
            <?php
            $name = $displayPhoneNames[$i];
            $description = $displayPhones[$name];
            ?>
            <div class="swiper-slide slide">
              <div class="image">
                <img src="images/slider/display-img-<?php echo $i + 1; ?>.png" alt="display-img-<?php echo $i; ?>.png">
              </div>
              <div class="content">
                <h3><?php echo $name; ?></h3>
                <p><?php echo $description; ?></p>
                <br>
                <a href="shop.php" class="btn">Shop now</a>
              </div>
            </div>
          <?php } ?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>

    </section>

  </div>

  <section class="category">

    <h1 class="heading">shop by category</h1>

    <div class="swiper category-slider">

      <div class="swiper-wrapper">

        <a href="category.php?category=laptop" class="swiper-slide slide">
          <img src="images/icon-1.png" alt="">
          <h3>laptop</h3>
        </a>

        <a href="category.php?category=tv" class="swiper-slide slide">
          <img src="images/icon-2.png" alt="">
          <h3>tv</h3>
        </a>

        <a href="category.php?category=camera" class="swiper-slide slide">
          <img src="images/icon-3.png" alt="">
          <h3>camera</h3>
        </a>

        <a href="category.php?category=mouse" class="swiper-slide slide">
          <img src="images/icon-4.png" alt="">
          <h3>mouse</h3>
        </a>

        <a href="category.php?category=fridge" class="swiper-slide slide">
          <img src="images/icon-5.png" alt="">
          <h3>fridge</h3>
        </a>

        <a href="category.php?category=washing" class="swiper-slide slide">
          <img src="images/icon-6.png" alt="">
          <h3>washing machine</h3>
        </a>

        <a href="category.php?category=smartphone" class="swiper-slide slide">
          <img src="images/icon-7.png" alt="">
          <h3>smartphone</h3>
        </a>

        <a href="category.php?category=watch" class="swiper-slide slide">
          <img src="images/icon-8.png" alt="">
          <h3>watch</h3>
        </a>

      </div>

      <div class="swiper-pagination"></div>

    </div>

  </section>

  <section class="home-products">

    <h1 class="heading">Latest products</h1>

    <div class="swiper products-slider">

      <div class="swiper-wrapper">

        <?php
        $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
        $select_products->execute();
        if ($select_products->rowCount() > 0) {
          while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <form action="" method="post" class="swiper-slide slide">
              <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
              <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
              <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
              <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
              <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
              <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
              <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
              <div class="name"><?= $fetch_product['name']; ?></div>
              <div class="flex">
                <div class="price"><span>$</span><?= $fetch_product['price']; ?><span>/-</span></div>
                <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
              </div>
              <input type="submit" value="add to cart" class="btn" name="add_to_cart">
            </form>
        <?php
          }
        } else {
          echo '<p class="empty">no products added yet!</p>';
        }
        ?>

      </div>

      <div class="swiper-pagination"></div>

    </div>

  </section>

  <?php include 'components/scroll_up.php'; ?>
  <script src="js/scrollUp.js"></script>

  <?php include 'components/footer.php'; ?>

  <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

  <script src="js/script.js"></script>

  <script src="js/swiper.js"></script>

</body>

</html>