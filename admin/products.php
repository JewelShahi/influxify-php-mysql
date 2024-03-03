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

// Add product
if (isset($_POST['add_product'])) {

  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $details = $_POST['details'];
  $details = filter_var($details, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $brand = $_POST['brand'];
  $brand = filter_var($brand, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $released = $_POST['released'];
  $released = filter_var($released, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $qty = $_POST['qty'];
  $qty = filter_var($qty, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $cpu = $_POST['cpu'];
  $cpu = filter_var($cpu, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $storage = $_POST['storage'];
  $storage = filter_var($storage, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  // Remove space between number and alphabetic part
  $storage = preg_replace('/\s+/', '', $storage);
  // Convert alphabetic part to uppercase
  $storage = strtoupper($storage);

  $ram = $_POST['ram'];
  $ram = filter_var($ram, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  // Remove space between number and alphabetic part
  $ram = preg_replace('/\s+/', '', $ram);
  // Convert alphabetic part to uppercase
  $ram = strtoupper($ram);

  $camera_count = $_POST['camera_count'];
  $camera_count = filter_var($camera_count, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $camera_resolution = $_POST['camera_resolution'];
  $camera_resolution = filter_var($camera_resolution, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $size = $_POST['size'];
  $size = filter_var($size, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  // check the size if it has space between the number and alphabets
  // and the alphabets lowercase
  preg_match('/^(\d+)(\D+)/', $size, $size_matches);
  $size_numeric_part = $size_matches[1];
  $size_alphabetic_part = strtolower($size_matches[2]);
  $size = $size_numeric_part . ' ' . $size_alphabetic_part;

  $battery = $_POST['battery'];
  $battery = filter_var($battery, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $color = $_POST['color'];
  $color = filter_var($color, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $price = $_POST['price'];
  $price = filter_var($price, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $image_01 = $_FILES['image_01']['name'];
  $image_01 = filter_var($image_01, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $image_size_01 = $_FILES['image_01']['size'];
  $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
  $image_folder_01 = '../uploaded_img/products/' . $image_01;

  $image_02 = $_FILES['image_02']['name'];
  $image_02 = filter_var($image_02, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $image_size_02 = $_FILES['image_02']['size'];
  $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
  $image_folder_02 = '../uploaded_img/products/' . $image_02;

  $image_03 = $_FILES['image_03']['name'];
  $image_03 = filter_var($image_03, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $image_size_03 = $_FILES['image_03']['size'];
  $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
  $image_folder_03 = '../uploaded_img/products/' . $image_03;

  try {

    // Check for release date format
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $released)) {
      throw new Exception('Released date is not in the correct format (YYYY-MM-DD)!');
    }

    // Image size condition
    if ($image_size_01 > 2000000 or $image_size_02 > 2000000 or $image_size_03 > 2000000) {
      throw new Exception('Image size is too large!');
    }

    // Inserting the data
    $insert_products = $conn->prepare("INSERT INTO `products` (name, details, brand, released, qty, cpu, storage, ram, camera_count, camera_resolution, size, battery, color, price, image_01, image_02, image_03) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_products->execute([$name, $details, $brand, $released, $qty, $cpu, $storage, $ram, $camera_count, $camera_resolution, $size, $battery, $color, $price, $image_01, $image_02, $image_03]);

    // Moving images to the folder - uploaded_img/products
    move_uploaded_file($image_tmp_name_01, $image_folder_01);
    move_uploaded_file($image_tmp_name_02, $image_folder_02);
    move_uploaded_file($image_tmp_name_03, $image_folder_03);

    $message[] = 'New product added successfully!';
  } catch (PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
      $message[] = 'Product with ' . $name . ' already exists!';
    } else {
      $message[] = 'Error: ' . $e->getMessage();
    }
  } catch (Exception $e) {
    $message[] = $e->getMessage();
  }
};

// Delete product
if (isset($_GET['delete'])) {

  $delete_id = $_GET['delete'];

  $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
  $delete_product_image->execute([$delete_id]);
  $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
  $baseImagePath = '../uploaded_img/products/';

  // If the image exist in the folder delete it
  if (file_exists($baseImagePath . $fetch_delete_image['image_01'])) {
    unlink($baseImagePath . $fetch_delete_image['image_01']);
  } else {
    $message[] = 'Image ' . $fetch_delete_image['image_01'] . ' wasn\'t found in folder ' . $baseImagePath;
  }

  // If the image exist in the folder delete it
  if (file_exists($baseImagePath . $fetch_delete_image['image_02'])) {
    unlink($baseImagePath . $fetch_delete_image['image_02']);
  } else {
    $message[] = 'Image ' . $fetch_delete_image['image_02'] . ' wasn\'t found in folder ' . $baseImagePath;
  }

  // If the image exist in the folder delete it
  if (file_exists($baseImagePath . $fetch_delete_image['image_03'])) {
    unlink($baseImagePath . $fetch_delete_image['image_03']);
  } else {
    $message[] = 'Image ' . $fetch_delete_image['image_03'] . ' wasn\'t found in folder ' . $baseImagePath;
  }

  // Deleting the product
  $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
  $delete_product->execute([$delete_id]);

  $message[] = 'Product is deleted successfully!';
  header('Location: products.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <!-- Custom css -->
  <link rel="stylesheet" href="../css/admin_style.css">
  <link rel="stylesheet" href="../css/global.css">
</head>

<body style="height: auto;">

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

    <section class="add-products">
      <h1 class="heading">Add a product</h1>
      <form action="" method="post" enctype="multipart/form-data">
        <div class="flex">

          <div class="inputBox">
            <span>Product name <span style="color: red;">*</span></span>
            <input type="text" name="name" placeholder="Product name" class="box" required>
          </div>

          <div class="inputBox">
            <span>Product details <span style="color: red;">*</span></span>
            <textarea name="details" placeholder="Product details" class="box" required></textarea>
          </div>

          <div class="inputBox">
            <span id="brandLabel">Product brand <span style="color: red;">*</span></span>
            <select name="brand" class="box" aria-labelledby="brandLabel" required>
              <option value="N/A" selected disabled>Add a brand</option>
              <option value="Samsung">Samsung</option>
              <option value="Apple">Apple</option>
              <option value="Google">Google</option>
              <option value="Xiaomi">Xiaomi</option>
              <option value="OnePlus">OnePlus</option>
              <option value="Motorola">Motorola</option>
              <option value="Oppo">Oppo</option>
              <option value="Realme">Realme</option>
            </select>
          </div>

          <div class="inputBox">
            <span>Released date <span style="color: red;">*</span></span>
            <input type="text" name="released" placeholder="Released date (YYYY-MM-DD)" class="box" required>
          </div>

          <div class="inputBox">
            <span>Product quantity <span style="color: red;">*</span></span>
            <input type="number" name="qty" placeholder="Product quantity" class="box" min="0" step="1" required>
          </div>

          <div class="inputBox">
            <span>CPU <span style="color: red;">*</span></span>
            <input type="text" name="cpu" placeholder="CPU" class="box" required>
          </div>

          <div class="inputBox">
            <span>Storage <span style="color: red;">*</span></span>
            <input type="text" name="storage" placeholder="Storage" class="box" required>
          </div>

          <div class="inputBox">
            <span>RAM <span style="color: red;">*</span></span>
            <input type="text" name="ram" placeholder="RAM" class="box" required>
          </div>

          <div class="inputBox">
            <span>Camera count <span style="color: red;">*</span></span>
            <input type="number" name="camera_count" placeholder="Camera count" class="box" min="0" step="1" required>
          </div>

          <div class="inputBox">
            <span>Camera resolution <span style="color: red;">*</span></span>
            <input type="text" name="camera_resolution" placeholder="Camera resolution" class="box" required>
          </div>

          <div class="inputBox">
            <span>Phone Size<span style="color: red;">*</span></span>
            <input type="text" name="size" placeholder="Phone size" class="box" required>
          </div>

          <div class="inputBox">
            <span>Battery <span style="color: red;">*</span></span>
            <input type="text" name="battery" placeholder="Battery" class="box" required>
          </div>

          <div class="inputBox">
            <span>Phone color <span style="color: red;">*</span></span>
            <input type="text" name="color" placeholder="Color" class="box" required>
          </div>

          <div class="inputBox">
            <span>Product price <span style="color: red;">*</span></span>
            <input type="number" name="price" min="0.00" step="0.01" class="box" required placeholder="Product price" onkeypress="if(this.value.length == 8) return false;">
          </div>
        </div>

        <div class="file-buttons">

          <div class="inputBox">
            <span>Image-1 <span style="color: red;">*</span></span>
            <div class="custom-file-upload">
              <label for="image_01" class="btn"><i class="fa-solid fa-cloud-arrow-up"></i> Upload image</label>
              <input type="file" id="image_01" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box file-input" required>
              <span id="filename_01" class="chosen-file-name"></span>
            </div>
          </div>

          <div class="inputBox">
            <span>Image-2 <span style="color: red;">*</span></span>
            <div class="custom-file-upload">
              <label for="image_02" class="btn"><i class="fa-solid fa-cloud-arrow-up"></i> Upload image</label>
              <input type="file" id="image_02" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box file-input" required>
              <span id="filename_02" class="chosen-file-name"></span>
            </div>
          </div>

          <div class="inputBox">
            <span>Image-3 <span style="color: red;">*</span></span>
            <div class="custom-file-upload">
              <label for="image_03" class="btn"><i class="fa-solid fa-cloud-arrow-up"></i> Upload image</label>
              <input type="file" id="image_03" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box file-input" required>
              <span id="filename_03" class="chosen-file-name"></span>
            </div>
          </div>

        </div>
        <button type="submit" class="btn" name="add_product">
          <i class="fa-regular fa-square-plus"></i> Add product
        </button>
      </form>
    </section>

    <section class="show-products">
      <h1 class="heading">Added Products</h1>
      <div class="box-container">
        <?php
        $select_products = $conn->prepare("SELECT * FROM `products`");
        $select_products->execute();
        if ($select_products->rowCount() > 0) {
          while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="box">
              <img src="../uploaded_img/products/<?= $fetch_products['image_01']; ?>" alt="<?= $fetch_products['image_01']; ?>">
              <div class="name"><?= $fetch_products['name']; ?></div>
              <div class="price">$<span><?= $fetch_products['price']; ?></span></div>
              <div class="details"><span><?= $fetch_products['details']; ?></span></div>
              <div class="flex-btn">
                <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn"><i class="far fa-edit"></i></a>
                <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');"><i class="fas fa-trash"></i></a>
              </div>
            </div>
        <?php
          }
        } else {
          echo '<p class="empty">No Products Added Yet!</p>';
        }
        ?>
      </div>
    </section>

  <?php
  }
  ?>

  <!-- Admin script -->
  <script src="../js/admin_script.js"></script>

  <!-- Custom file name show -->
  <script src="../js/custom_choose_file.js"></script>

  <!-- Scroll up button -->
  <?php include '../components/scroll_up.php'; ?>
  <script src="../js/scrollUp.js"></script>
</body>

</html>