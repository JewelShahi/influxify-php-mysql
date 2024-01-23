<?php
if (isset($_POST['add_to_wishlist'])) {
  if ($user_id == '') {
    header('location:user_login.php');
  } else {
    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $image = $_POST['image'];
    $image = filter_var($image, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE pid = ? AND user_id = ?");
    $check_wishlist_numbers->execute([$pid, $user_id]);

    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE pid = ? AND user_id = ?");
    $check_cart_numbers->execute([$pid, $user_id]);

    if ($check_wishlist_numbers->rowCount() > 0) {
      $message[] = 'Already added to wishlist!';
    } elseif ($check_cart_numbers->rowCount() > 0) {
      $message[] = 'Already added to cart!';
    } else {
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price) VALUES(?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $name, $price]);
      $message[] = 'Added to wishlist!';
    }
  }
}

if (isset($_POST['add_to_cart'])) {

  if ($user_id == '') {
    header('location:user_login.php');
  } else {

    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE pid = ? AND user_id = ?");
    $check_cart_numbers->execute([$pid, $user_id]);

    if ($check_cart_numbers->rowCount() > 0) {
      $message[] = 'Already added to cart!';
    } else {

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE pid = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$pid, $user_id]);

      if ($check_wishlist_numbers->rowCount() > 0) {
        $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ? AND user_id = ?");
        $delete_wishlist->execute([$pid, $user_id]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity) VALUES(?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $name, $price, $qty]);
      $message[] = 'Added to cart!';
    }
  }
}
