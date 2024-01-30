<?php
include 'components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
  header('location:user_login.php');
};

// if (isset($_POST['delete'])) {
//   $pid = $_POST['pid'];

//   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ? AND pid = ?");
//   $delete_cart_item->execute([$user_id, $pid]);
// }

// if (isset($_GET['delete_all'])) {
//   $delete_all_cart_items = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
//   $delete_all_cart_items->execute([$user_id]);
//   header('location: cart.php');
//   exit();
// }

if (isset($_POST['delete'])) {
  $pid = $_POST['pid'];

  // Retrieve the quantity from the cart before deleting
  $get_cart_quantity = $conn->prepare("SELECT quantity FROM `cart` WHERE user_id = ? AND pid = ?");
  $get_cart_quantity->execute([$user_id, $pid]);
  $cart_quantity = $get_cart_quantity->fetchColumn();

  // Delete the item from the cart
  $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ? AND pid = ?");
  $delete_cart_item->execute([$user_id, $pid]);

  // Add the quantity back to the products table
  $update_product_quantity = $conn->prepare("UPDATE `products` SET qty = qty + ? WHERE id = ?");
  $update_product_quantity->execute([$cart_quantity, $pid]);
}

if (isset($_GET['delete_all'])) {
  // Retrieve all quantities from the cart
  $get_cart_quantities = $conn->prepare("SELECT pid, quantity FROM `cart` WHERE user_id = ?");
  $get_cart_quantities->execute([$user_id]);
  $cart_quantities = $get_cart_quantities->fetchAll(PDO::FETCH_ASSOC);

  // Delete all items from the cart
  $delete_all_cart_items = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
  $delete_all_cart_items->execute([$user_id]);

  // Add quantities back to the products table
  foreach ($cart_quantities as $cart_item) {
    $update_product_quantity = $conn->prepare("UPDATE `products` SET qty = qty + ? WHERE id = ?");
    $update_product_quantity->execute([$cart_item['quantity'], $cart_item['pid']]);
  }

  header('location: cart.php');
  exit();
}

if (isset($_POST['update_qty'])) {
  $pid = $_POST['pid'];

  $newQty = $_POST['qty'];
  $newQty = filter_var($newQty, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  // Retrieve the current quantity in the cart
  $getCurrentQty = $conn->prepare("SELECT quantity FROM `cart` WHERE user_id = ? AND pid = ?");
  $getCurrentQty->execute([$user_id, $pid]);
  $currentQty = $getCurrentQty->fetchColumn();

  // Calculate the difference in quantity
  $qtyDifference = $newQty - $currentQty;

  // Update the cart with the new quantity
  $updateQty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE user_id = ? AND pid = ?");
  $updateQty->execute([$newQty, $user_id, $pid]);

  if ($qtyDifference > 0) {
    // Update the products table with the adjusted quantity
    $updateProductQty = $conn->prepare("UPDATE `products` SET qty = qty - ? WHERE id = ?");
    $updateProductQty->execute([$qtyDifference, $pid]);
  } else {
    // Update the products table with the adjusted quantity
    $updateProductQty = $conn->prepare("UPDATE `products` SET qty = qty + ? WHERE id = ?");
    $updateProductQty->execute([abs($qtyDifference), $pid]);
  }

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
      $counter = 1;

      $grand_total = 0;
      $select_cart = $conn->prepare("
        SELECT c.user_id, c.pid, c.name, c.price, c.quantity, p.qty as qty, p.image_01 as image 
        FROM cart c
        JOIN products p ON c.pid = p.id 
        WHERE user_id = ?
       ");
      $select_cart->execute([$user_id]);

      if ($select_cart->rowCount() > 0) {
        while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
      ?>
          <form action="" method="post" class="box">
            <input type="hidden" name="pid" value="<?= $fetch_cart['pid']; ?>">
            <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
            <img src="uploaded_img/products/<?= $fetch_cart['image']; ?>" alt="">
            <div class="name"><?= $fetch_cart['name']; ?></div>
            <div class="flex">
              <div class="price">$<?= $fetch_cart['price']; ?></div>
              <input type="number" id="q<?= $counter; ?>" name="qty" class="qty" min="1" max="<?php echo max($fetch_cart['qty'], $fetch_cart['quantity']) + 1 ?>" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>">
              <button type="submit" id="u<?= $counter; ?>" class="fas fa-edit fa-plus fa-2x" name="update_qty"></button>
            </div>
            <div class="sub-total"> Sub total : <span>$<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></span></div>
            <button type="submit" class="delete-btn" name="delete" onclick="return confirm('Remove this product from cart?');">
              <i class="fas fa-minus-circle"></i> Remove
            </button>
          </form>
      <?php
          $grand_total += $sub_total;
          $counter++;
        }
      } else {
        echo '<p class="empty">Your cart is empty</p>';
      }
      ?>
    </div>
  </section>

  <div class="cart-total">
    <p>Grand total : <span>$<?= $grand_total; ?></span></p>
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

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      <?php
      $counter = 1;
      $cart_product_quantity = $conn->prepare("
          SELECT c.user_id, c.pid, c.quantity
          FROM cart c
          JOIN products p ON c.pid = p.id 
          WHERE user_id = ?
        ");
      $cart_product_quantity->execute([$user_id]);
      while ($fetch_cart = $cart_product_quantity->fetch(PDO::FETCH_ASSOC)) {
      ?>
        let qInp<?= $counter; ?> = document.getElementById('q<?= $counter; ?>');
        let uBtn<?= $counter; ?> = document.getElementById('u<?= $counter; ?>');

        qInp<?= $counter; ?>.addEventListener('input', () => {
          updateButtonState<?= $counter; ?>();
        });

        updateButtonState<?= $counter; ?>();

        function updateButtonState<?= $counter; ?>() {
          if (qInp<?= $counter; ?>.value == <?= $fetch_cart['quantity'] ?>) {
            uBtn<?= $counter; ?>.classList.add('disabled');
          } else {
            uBtn<?= $counter; ?>.classList.remove('disabled');
          }
        }
      <?php
        $counter++;
      }
      ?>
    });
  </script>

  <?php include 'components/footer.php'; ?>

  <script src="js/user_script.js"></script>

  <?php include 'components/scroll_up.php'; ?>
  <script src="js/scrollUp.js"></script>
</body>

</html>