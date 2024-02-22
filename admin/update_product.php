<?php

// Trying to connect to the db
include '../components/connect.php';

// Start the session
session_start();

// Check if the admin has a session
if (isset($_SESSION['admin_id'])) {
  $admin_id = $_SESSION['admin_id'];
} else {
  $admin_id = '';
  header('Location: admin_login.php');
};

// Update product
if (isset($_POST['update'])) {
  $pid = $_POST['pid'];

  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $price = $_POST['price'];
  $price = filter_var($price, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $details = $_POST['details'];
  $details = filter_var($details, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $brand = $_POST['brand'];

  $released = $_POST['released'];
  $released = filter_var($released, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $qty = $_POST['qty'];
  $qty = filter_var($qty, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $cpu = $_POST['cpu'];
  $cpu = filter_var($cpu, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $storage = $_POST['storage'];
  $storage = filter_var($storage, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $ram = $_POST['ram'];
  $ram = filter_var($ram, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $camera_count = $_POST['camera_count'];
  $camera_count = filter_var($camera_count, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $camera_resolution = $_POST['camera_resolution'];
  $camera_resolution = filter_var($camera_resolution, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $size = $_POST['size'];
  $size = filter_var($size, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $battery = $_POST['battery'];
  $battery = filter_var($battery, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $color = $_POST['color'];
  $color = filter_var($color, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $update_product = $conn->prepare("UPDATE `products` SET name = ?, details = ?, brand = ?, released = ?, qty = ?, cpu = ?, storage = ?, ram = ?, camera_count = ?, camera_resolution = ?, size = ?, battery = ?, color = ?, price = ? WHERE id = ?");
  $update_product->execute([$name, $details, $brand, $released, $qty, $cpu, $storage, $ram, $camera_count, $camera_resolution, $size, $battery, $color, $price, $pid]);

  $baseImagePath = '../uploaded_img/products/';

  // Image-1
  $old_image_01 = $_POST['old_image_01'];
  $image_01 = $_FILES['image_01']['name'];
  $image_size_01 = $_FILES['image_01']['size'];
  $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
  $image_folder_01 = '../uploaded_img/products/' . $image_01;

  if (!empty($image_01) && is_uploaded_file($image_tmp_name_01)) {

    // Check for the image size
    if ($image_size_01 > 2000000) {
      $message[] = 'Image-1\'s size is too large!';
    } else {
      $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
      $update_image_01->execute([$image_01, $pid]);

      // Check if the file was moved successfully
      if (move_uploaded_file($image_tmp_name_01, $image_folder_01)) {

        // If the image exists, just remove it
        if (file_exists($baseImagePath . $old_image_01)) {
          unlink('../uploaded_img/products/' . $old_image_01);
        }

        $message[] = 'Image-1 has been updated successfully!';
      } else {
        $message[] = 'Failed to move Image-1 to the destination folder!';
      }
    }
  }

  // Image-2
  $old_image_02 = $_POST['old_image_02'];
  $image_02 = $_FILES['image_02']['name'];
  $image_size_02 = $_FILES['image_02']['size'];
  $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
  $image_folder_02 = '../uploaded_img/products/' . $image_02;

  if (!empty($image_02) && is_uploaded_file($image_tmp_name_02)) {

    // Check for the image size
    if ($image_size_02 > 2000000) {
      $message[] = 'Image-2\'s size is too large!';
    } else {
      $update_image_02 = $conn->prepare("UPDATE `products` SET image_02 = ? WHERE id = ?");
      $update_image_02->execute([$image_02, $pid]);

      // Check if the file was moved successfully
      if (move_uploaded_file($image_tmp_name_02, $image_folder_02)) {

        // if a image exists, just remove it
        if (file_exists($baseImagePath . $old_image_02)) {
          unlink('../uploaded_img/products/' . $old_image_02);
        }

        $message[] = 'Image-2 has been updated successfully!';
      } else {
        $message[] = 'Failed to move Image-2 to the destination folder!';
      }
    }
  }

  // Image-3
  $old_image_03 = $_POST['old_image_03'];
  $image_03 = $_FILES['image_03']['name'];
  $image_size_03 = $_FILES['image_03']['size'];
  $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
  $image_folder_03 = '../uploaded_img/products/' . $image_03;

  if (!empty($image_03) && is_uploaded_file($image_tmp_name_03)) {

    // Check for the image size
    if ($image_size_03 > 2000000) {
      $message[] = 'Image-3\'s size is too large!';
    } else {
      $update_image_03 = $conn->prepare("UPDATE `products` SET image_03 = ? WHERE id = ?");
      $update_image_03->execute([$image_03, $pid]);

      // Check if the file was moved successfully
      if (move_uploaded_file($image_tmp_name_03, $image_folder_03)) {

        // If the file image exists, just remove it
        if (file_exists($baseImagePath . $old_image_03)) {
          unlink('../uploaded_img/products/' . $old_image_03);
        }

        $message[] = 'Image-3 has been updated successfully!';
      } else {
        $message[] = 'Failed to move Image-3 to the destination folder!';
      }
    }
  }

  // header('Location: update_product.php?update=' . $pid);
  $message[] = 'Product updated successfully!';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Products</title>
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <!-- Custom css -->
  <link rel="stylesheet" href="../css/admin_style.css">
  <link rel="stylesheet" href="../css/global.css">

</head>

<body>

  <!-- Navbar -->
  <?php include '../components/admin_header.php'; ?>


  <!-- Checks if the user is in the db -->
  <?php
  $select_admin_exists = $conn->prepare("SELECT id FROM `users` WHERE id = ? AND isAdmin = 1");
  $select_admin_exists->execute([$admin_id]);
  if ($select_admin_exists->rowCount() == 0) {
    header("Location: admin_login.php");
  } else {
  ?>

    <section class="update-product">
      <h1 class="heading">Update Products</h1>
      <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$update_id]);
      if ($select_products->rowCount() > 0) {
        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
      ?>
          <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
            <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>">
            <input type="hidden" name="old_image_02" value="<?= $fetch_products['image_02']; ?>">
            <input type="hidden" name="old_image_03" value="<?= $fetch_products['image_03']; ?>">

            <div class="image-container">
              <div class="main-image">
                <img src="../uploaded_img/products/<?= $fetch_products['image_01']; ?>" alt="img-1">
              </div>

              <div class="sub-image">
                <img src="../uploaded_img/products/<?= $fetch_products['image_01']; ?>" alt="new-img-1">
                <img src="../uploaded_img/products/<?= $fetch_products['image_02']; ?>" alt="new-img-2">
                <img src="../uploaded_img/products/<?= $fetch_products['image_03']; ?>" alt="new-img-3">
              </div>

            </div>

            <span>Update name</span>
            <input type="text" name="name" class="box" maxlength="100" placeholder="Product name" value="<?= $fetch_products['name']; ?>" required>

            <span>Update price</span>
            <input type="number" name="price" class="box" min="0.00" step="0.01" placeholder="Product price" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['price']; ?>" required>

            <span>Update details</span>
            <textarea name="details" class="box" required><?= $fetch_products['details']; ?></textarea>

            <span id="brandLabel">Update brand</span>
            <select name="brand" class="box" aria-labelledby="brandLabel" required>
              <?php
              $selectedBrand = $fetch_products['brand'];
              $brands = array("Samsung", "Apple", "Google", "Xiaomi", "OnePlus", "Lenovo", "Motorola", "Oppo");

              foreach ($brands as $brandOption) {
                echo '<option value="' . $brandOption . '" ' . ($brandOption == $selectedBrand ? 'selected' : '') . '>' . $brandOption . '</option>';
              }
              ?>
            </select>

            <span>Update released date</span>
            <input type="text" name="released" placeholder="Released date (00/00/0000)" pattern="^(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])\/\d{4}$" class="box" value="<?= $fetch_products['released']; ?>">

            <span>Update quantity</span>
            <input type="number" name="qty" placeholder="Product quantity" class="box" min="0" step="1" value="<?= $fetch_products['qty']; ?>" required>

            <span>Update CPU</span>
            <input type="text" name="cpu" placeholder="CPU" class="box" value="<?= $fetch_products['cpu']; ?>" required>

            <span>Update storage</span>
            <input type="text" name="storage" placeholder="Storage" class="box" value="<?= $fetch_products['storage']; ?>" required>

            <span>Update RAM</span>
            <input type="text" name="ram" placeholder="RAM" class="box" value="<?= $fetch_products['ram']; ?>" required>

            <span>Update camera count</span>
            <input type="number" name="camera_count" placeholder="Camera count" class="box" min="0" step="1" value="<?= $fetch_products['camera_count']; ?>" required>

            <span>Camera resolution</span>
            <input type="text" name="camera_resolution" placeholder="Camera resolution" class="box" value="<?= $fetch_products['camera_resolution']; ?>" required>

            <span>Phone Size</span>
            <input type="text" name="size" placeholder="Phone size" class="box" value="<?= $fetch_products['size']; ?>" required>

            <span>Battery</span>
            <input type="text" name="battery" placeholder="Battery" class="box" value="<?= $fetch_products['battery']; ?>" required>

            <span>Phone color</span>
            <input type="text" name="color" placeholder="Color" class="box" value="<?= $fetch_products['color']; ?>" required>

            <span>Update Image-1</span>
            <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">

            <span>Update Image-2</span>
            <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">

            <span>Update Image-3</span>
            <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">

            <div class="flex-btn">
              <input type="submit" name="update" class="btn" value="update">
              <a href="products.php" class="option-btn">Go Back</a>
            </div>
          </form>
      <?php
        }
      } else {
        echo '<p class="empty">No products found!</p>';
      }
      ?>
    </section>

  <?php
  }
  ?>

  <!-- Admin script -->
  <script src="../js/admin_script.js"></script>

  <!-- Scroll up button -->
  <?php include '../components/scroll_up.php'; ?>
  <script src="../js/scrollUp.js"></script>
</body>

</html>