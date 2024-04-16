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
<html lang="bg">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Марка</title>
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <!-- custom css file link  -->
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/user_style.css">

</head>

<body style="height: auto;">

  <?php include '../components/user_header.php'; ?>

  <section class="products">

    <?php
    $brand = $_GET['brand'];
    $select_products = $conn->prepare("SELECT * FROM `products` WHERE brand LIKE ?");
    $select_products->execute(["$brand"]);
    ?>
    <h1 class="heading">Марка</h1>
    <?php
    if ($select_products->rowCount() > 0) {
    ?>
      <h3 class="heading" style="font-size: 3rem;">Продукти от марка - <?= $brand; ?></h3>
    <?php
    }
    ?>

    <div class="box-container">

      <?php
      if ($select_products->rowCount() > 0) {
        while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
      ?>
          <form action="" method="post" class="box">
            <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
            <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
            <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
            <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
            <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
            <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
            <img src="../uploaded_img/products/<?= $fetch_product['image_01']; ?>" alt="<?= $fetch_product['image_01']; ?>">
            <div class="name"><?= $fetch_product['name']; ?></div>
            <div class="flex">
              <div class="price"><span></span><?= $fetch_product['price']; ?> лв.</div>
              <?php
              if ($fetch_product['qty'] == 0) {
              ?>
                <div class="out-of-stock">Изчерпано</div>
              <?php
              } else {
              ?>
                <input type="number" name="qty" class="qty" min="1" max="<?php echo $fetch_product['qty']; ?>" onkeypress="if(this.value.length == 2) return false;" <?php echo ($fetch_product['qty'] == 0) ? 'disabled value="0"' : 'value="1"'; ?>>
              <?php
              }
              ?>
            </div>
            <button type="submit" name="add_to_cart" class="btn <?php if ($fetch_product['qty'] == 0) echo 'disabled'; ?>">
              <i class="fas fa-plus"></i> Добави в количката
            </button>
          </form>
      <?php
        }
      } else {
        echo '<p class="empty" style="grid-column: 1 / -1; width: 100%;">Тази марка все още няма продукти.</p>';
      }
      ?>

    </div>

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