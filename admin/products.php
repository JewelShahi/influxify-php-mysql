<?php
include '../components/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
  header('location:admin_login.php');
};
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
    $insert_products = $conn->prepare("INSERT INTO `products` (name, details, brand, released, qty, cpu, storage, ram, camera_count, camera_resolution, size, battery, color, price, image_01, image_02, image_03) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_products->execute([$name, $details, $brand, $released, $qty, $cpu, $storage, $ram, $camera_count, $camera_resolution, $size, $battery, $color, $price, $image_01, $image_02, $image_03]);

    if ($insert_products) {
      if ($image_size_01 > 2000000 or $image_size_02 > 2000000 or $image_size_03 > 2000000) {
        throw new Exception('Image size is too large!');
      }

      move_uploaded_file($image_tmp_name_01, $image_folder_01);
      move_uploaded_file($image_tmp_name_02, $image_folder_02);
      move_uploaded_file($image_tmp_name_03, $image_folder_03);

      $message[] = 'New product added successfully!';
    }
  } catch (PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
      $message[] = 'Product with '. $name .' already exists!';
    } else {
      $message[] = 'Error: ' . $e->getMessage();
    }
  } catch (Exception $e) {
    $message[] = $e->getMessage();
  }
};

if (isset($_GET['delete'])) {

  $delete_id = $_GET['delete'];

  $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
  $delete_product_image->execute([$delete_id]);
  $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
  $baseImagePath = '../uploaded_img/products/';
  // unlink($baseImagePath . $fetch_delete_image['image_01']);
  // unlink($baseImagePath . $fetch_delete_image['image_02']);
  // unlink($baseImagePath . $fetch_delete_image['image_03']);
  if (file_exists($baseImagePath . $fetch_delete_image['image_01'])) {
    unlink($baseImagePath . $fetch_delete_image['image_01']);
  } else {
    $message[] = 'Image ' . $fetch_delete_image['image_01'] . ' wasn\'t found in folder ' . $baseImagePath;
  }

  if (file_exists($baseImagePath . $fetch_delete_image['image_02'])) {
    unlink($baseImagePath . $fetch_delete_image['image_02']);
  } else {
    $message[] = 'Image ' . $fetch_delete_image['image_02'] . ' wasn\'t found in folder ' . $baseImagePath;
  }

  if (file_exists($baseImagePath . $fetch_delete_image['image_03'])) {
    unlink($baseImagePath . $fetch_delete_image['image_03']);
  } else {
    $message[] = 'Image ' . $fetch_delete_image['image_03'] . ' wasn\'t found in folder ' . $baseImagePath;
  }

  $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
  $delete_product->execute([$delete_id]);

  $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
  $delete_cart->execute([$delete_id]);

  $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
  $delete_wishlist->execute([$delete_id]);
  $message[] = 'Product is deleted successfully!';
  header('location:products.php');
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="../css/admin_style.css">
  <link rel="stylesheet" href="../css/global.css">

</head>

<body>

  <?php include '../components/admin_header.php'; ?>
  <section class="add-products">
    <h1 class="heading">Add a product</h1>
    <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">

        <div class="inputBox">
          <span>Product name <span style="color: red;">*<span></span>
              <input type="text" name="name" placeholder="Product name" class="box" required>
        </div>

        <div class="inputBox">
          <span>Product details <span style="color: red;">*<span></span>
              <textarea name="details" placeholder="Product details" class="box" maxlength="500" cols="30" rows="10" required></textarea>
        </div>

        <div class="inputBox">
          <span id="brandLabel">Product brand <span style="color: red;">*</span></span>
          <select name="brand" class="box" aria-labelledby="brandLabel" required>
            <option value="Samsung">Samsung</option>
            <option value="Apple">Apple</option>
            <option value="Google">Google</option>
            <option value="Xiaomi">Xiaomi</option>
            <option value="OnePlus">OnePlus</option>
            <option value="Lenovo">Lenovo</option>
          </select>
        </div>

        <div class="inputBox">
          <span>Released date <span style="color: red;">*<span></span>
              <input type="text" name="released" placeholder="Released date (00/00/0000)" pattern="^(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])\/\d{4}$" class="box" required>
        </div>

        <div class="inputBox">
          <span>Product quantity <span style="color: red;">*<span></span>
              <input type="number" name="qty" placeholder="Product quantity" class="box" min="0" step="1">
        </div>

        <div class="inputBox">
          <span>CPU <span style="color: red;">*<span></span>
              <input type="text" name="cpu" placeholder="CPU" class="box" required>
        </div>

        <div class="inputBox">
          <span>Storage <span style="color: red;">*<span></span>
              <input type="text" name="storage" placeholder="Storage" class="box" required>
        </div>

        <div class="inputBox">
          <span>RAM <span style="color: red;">*<span></span>
              <input type="text" name="ram" placeholder="RAM" class="box" required>
        </div>

        <div class="inputBox">
          <span>Camera count <span style="color: red;">*<span></span>
              <input type="number" name="camera_count" placeholder="Camera count" class="box" min="0" step="1">
        </div>

        <div class="inputBox">
          <span>Camera resolution <span style="color: red;">*<span></span>
              <input type="text" name="camera_resolution" placeholder="Camera resolution" class="box" required>
        </div>

        <div class="inputBox">
          <span>Size <span style="color: red;">*<span></span>
              <input type="text" name="size" placeholder="Size" class="box" required>
        </div>

        <div class="inputBox">
          <span>Battery <span style="color: red;">*<span></span>
              <input type="text" name="battery" placeholder="Battery" class="box" required>
        </div>

        <div class="inputBox">
          <span>Color <span style="color: red;">*<span></span>
              <input type="text" name="color" placeholder="Color" class="box" required>
        </div>

        <div class="inputBox">
          <span>Product price <span style="color: red;">*<span></span>
              <input type="number" name="price" min="0.00" step="0.01" class="box" required placeholder="Product price" onkeypress="if(this.value.length == 8) return false;">
        </div>

        <div class="inputBox">
          <span>Image-1 <span style="color: red;">*<span></span>
              <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>

        <div class="inputBox">
          <span>Image-2 <span style="color: red;">*<span></span>
              <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>

        <div class="inputBox">
          <span>Image-3 <span style="color: red;">*<span></span>
              <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>

      </div>

      <input type="submit" value="Add product" class="btn" name="add_product">
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
            <img src="../uploaded_img/products/<?= $fetch_products['image_01']; ?>" alt="">
            <div class="name"><?= $fetch_products['name']; ?></div>
            <div class="price">$<span><?= $fetch_products['price']; ?></span>/-</div>
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
  <script src="../js/admin_script.js"></script>
  <?php include '../components/scroll_up.php'; ?>
  <script src="../js/scrollUp.js"></script>
</body>

</html>