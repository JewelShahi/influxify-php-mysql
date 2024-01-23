<?php
include 'components/connect.php';
session_start();
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
  header('location:user_login.php');
};
if (isset($_POST['delete'])) {
  $cart_id = $_POST['cart_id'];
  $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
  $delete_cart_item->execute([$cart_id]);
}

if (isset($_GET['delete_all'])) {
  $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
  $delete_cart_item->execute([$user_id]);
  header('location:cart.php');
}

if (isset($_POST['update_qty'])) {
  $cart_id = $_POST['cart_id'];
  $qty = $_POST['qty'];
  $qty = filter_var($qty, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
  $update_qty->execute([$qty, $cart_id]);
  $message[] = 'Cart quantity updated';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopping Cart</title>
  <link rel="shortcut icon" href="images/influxify-logo.ico" type="image/x-icon">
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- custom css file link  -->
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/user_style.css">
</head>

<body>

  <?php include 'components/user_header.php'; ?>

  <section class="products shopping-cart">

    <h3 class="heading">Shopping cart</h3>

    <div class="box-container">

      <?php
      $grand_total = 0;
      $select_cart = $conn->prepare("
        SELECT c.id, c.user_id, c.pid, c.name, c.price, c.quantity, p.image_01 as image 
        FROM cart c
        JOIN products p ON c.pid = p.id 
        WHERE user_id = ?
       ");
      $select_cart->execute([$user_id]);

      if ($select_cart->rowCount() > 0) {
        while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
      ?>
          <form action="" method="post" class="box">
            <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
            <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
            <img src="uploaded_img/products/<?= $fetch_cart['image']; ?>" alt="">
            <div class="name"><?= $fetch_cart['name']; ?></div>
            <div class="flex">
              <div class="price">$<?= $fetch_cart['price']; ?>/-</div>
              <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>">
              <button type="submit" class="fas fa-edit fa-plus fa-2x" name="update_qty"></button>
            </div>
            <div class="sub-total"> Sub total : <span>$<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
            <button type="submit" class="delete-btn" name="delete" onclick="return confirm('Remove this product from cart?');">
              <i class="fas fa-minus-circle"></i> Remove
            </button>
          </form>
      <?php
          $grand_total += $sub_total;
        }
      } else {
        echo '<p class="empty">Your cart is empty</p>';
      }
      ?>
    </div>



    <div class="cart-total">
      <p>Grand total : <span>$<?= $grand_total; ?>/-</span></p>
      <a href="shop.php" class="option-btn">
        <i class="fas fa-arrow-left"></i> Continue shopping
      </a>
      <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('Remove all products from cart?');">
        <i class="fas fa-trash-alt"></i> Remove all products
      </a>
      <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">
        <i class="fa-solid fa-wallet"></i> Proceed to checkout
      </a>
    </div>

  </section>
  <?php include 'components/footer.php'; ?>

  <script src="js/user_script.js"></script>

  <?php include 'components/scroll_up.php'; ?>
  <script src="js/scrollUp.js"></script>
</body>

</html>