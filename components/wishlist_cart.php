<?php
if (isset($_POST['add_to_wishlist'])) {
  if ($user_id == '') {
    header('location: user_login.php');
  } else {

    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE pid = ? AND user_id = ?");
    $check_cart_numbers->execute([$pid, $user_id]);

    if ($check_cart_numbers->rowCount() > 0) {
      $message[] = 'Already added to cart!';
    } else {
      try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $insert_wishlist = $conn->prepare("INSERT INTO wishlist (user_id, pid, name, price) VALUES (?, ?, ?, ?)");
        $insert_wishlist->execute([$user_id, $pid, $name, $price]);

        $conn->commit();
        $message[] = 'Added to wishlist!';
      } catch (PDOException $e) {
        $conn->rollBack();
        $message[] = "Already added to wishlist!";
      }
    }
  }
}

// if (isset($_POST['add_to_cart'])) {
//   if ($user_id == '') {
//     header('location: user_login.php');
//   } else {

//     $pid = $_POST['pid'];
//     $pid = filter_var($pid, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

//     $name = $_POST['name'];
//     $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

//     $price = $_POST['price'];
//     $price = filter_var($price, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

//     $qty = $_POST['qty'];
//     $qty = filter_var($qty, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

//     $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE pid = ? AND user_id = ?");
//     $check_cart_numbers->execute([$pid, $user_id]);

//     try {
//       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//       $conn->beginTransaction();

//       $insert_cart = $conn->prepare("INSERT INTO `cart` (user_id, pid, name, price, quantity) VALUES(?,?,?,?,?)");
//       $insert_cart->execute([$user_id, $pid, $name, $price, $qty]);

//       $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ? AND user_id = ?");
//       $delete_wishlist->execute([$pid, $user_id]);

//       $conn->commit();
//       $message[] = 'Added to cart!';
//     } catch (PDOException $e) {
//       $conn->rollBack();
//       $message[] = 'Already added to cart!';
//     }
//   }
// }
if (isset($_POST['add_to_cart'])) {
  if ($user_id == '') {
    header('location: user_login.php');
  } else {
    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    try {
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $conn->beginTransaction();

      // Check if there's enough quantity in the products table
      $check_quantity = $conn->prepare("SELECT qty FROM products WHERE id = ?");
      $check_quantity->execute([$pid]);
      $product_quantity = $check_quantity->fetchColumn();

      if ($product_quantity >= $qty) {
        // Subtract the quantity from the products table
        $update_quantity = $conn->prepare("UPDATE products SET qty = qty - ? WHERE id = ?");
        $update_quantity->execute([$qty, $pid]);

        // Insert into the cart
        $insert_cart = $conn->prepare("INSERT INTO `cart` (user_id, pid, name, price, quantity) VALUES(?,?,?,?,?)");
        $insert_cart->execute([$user_id, $pid, $name, $price, $qty]);

        // Delete from wishlist
        $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ? AND user_id = ?");
        $delete_wishlist->execute([$pid, $user_id]);

        $conn->commit();
        $message[] = 'Added to cart!';
      } else {
        $message[] = 'Insufficient quantity in stock!';
      }
    } catch (PDOException $e) {
      $conn->rollBack();
      $message[] = 'Already added to cart!';
    }
  }
}
