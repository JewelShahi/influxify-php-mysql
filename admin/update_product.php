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
  // Check if there's a space between the number and alphabets and lowercase the alphabets
  if (preg_match('/^(\d+(\.\d+)?)(\s*)(\D+)/', $size, $size_matches)) {
    $size_numeric_part = $size_matches[1];
    $size_whitespace = $size_matches[3]; // Matched whitespace
    $size_alphabetic_part = strtolower($size_matches[4]);

    // Ensure there's exactly one space between the numeric and alphabetic parts
    if ($size_whitespace === '') {
      // If there's no whitespace, add one space
      $size = $size_numeric_part . ' ' . $size_alphabetic_part;
    } else {
      // If there's whitespace, ensure it's just one space
      $size = $size_numeric_part . ' ' . preg_replace('/\s+/', '', $size_whitespace) . $size_alphabetic_part;
    }
  }

  $battery = $_POST['battery'];
  $battery = filter_var($battery, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  // Check if the input contains a string
  if (preg_match('/[a-zA-Z]/', $battery)) {
    // Check if it ends with 'mah' (case insensitive)
    if (preg_match('/mah$/i', $battery)) {
      // Check if there's a space before 'mah', if not, add it
      if (!preg_match('/\s*mah$/i', $battery)) {
        $battery = preg_replace('/(\d+)\s*(mah)$/i', '$1 mAh', $battery);
      }
    } 
  } else {
    // If it contains only numbers, append ' mAh'
    $battery .= " mAh";
  }
  // Add space between number and 'mAh' if missing
  $battery = preg_replace('/(\d+)(mah)/i', '$1 mAh', $battery);
  // Adjust 'mah' to uppercase if ' mah'
  $battery = preg_replace('/ mah/i', ' mA' . 'h', $battery);

  $color = $_POST['color'];
  $color = filter_var($color, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $released) && checkdate((int)substr($released, 5, 2), (int)substr($released, 8, 2), (int)substr($released, 0, 4))) {
    $update_product = $conn->prepare("UPDATE `products` SET name = ?, details = ?, brand = ?, released = ?, qty = ?, cpu = ?, storage = ?, ram = ?, camera_count = ?, camera_resolution = ?, size = ?, battery = ?, color = ?, price = ? WHERE id = ?");
    $update_product->execute([$name, $details, $brand, $released, $qty, $cpu, $storage, $ram, $camera_count, $camera_resolution, $size, $battery, $color, $price, $pid]);

    $message[] = 'Информацията за продуктът е актуализирана успешно!';
  } else {
    $message[] = 'Датата на лансиране не е в правилния формат (ГГГГ-ММ-ДД)!';
  }

  $baseImagePath = '../uploaded_img/products/';

  // Function to sanitize and rename the image file
  function sanitizeAndRenameImage($oldImageName, $newImageName, $imageTmpName, $imageFolder)
  {
    $extension = pathinfo($oldImageName, PATHINFO_EXTENSION);
    $newImageName = strtolower(str_replace(' ', '_', $newImageName)) . '.' . $extension;

    if (move_uploaded_file($imageTmpName, $imageFolder . $newImageName)) {
      return $newImageName;
    } else {
      return false;
    }
  }

  // Image-1
  $old_image_01 = $_POST['old_image_01'];
  $image_01 = $_FILES['image_01']['name'];
  $image_size_01 = $_FILES['image_01']['size'];
  $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
  $image_folder_01 = $baseImagePath;

  if (!empty($image_01) && is_uploaded_file($image_tmp_name_01)) {
    $newImageName_01 = $name . '_01';
    $new_image_01 = sanitizeAndRenameImage($image_01, $newImageName_01, $image_tmp_name_01, $image_folder_01);

    if ($new_image_01) {
      $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
      $update_image_01->execute([$new_image_01, $pid]);

      if (!empty($old_image_01) && file_exists($image_folder_01 . $old_image_01)) {
        unlink($image_folder_01 . $old_image_01);
      }

      $message[] = 'Изображение-1 е актуализирано успешно!';
    } else {
      $message[] = 'Неуспешно качване на Изображение-1 в папката!';
    }
  }

  // Image-2
  $old_image_02 = $_POST['old_image_02'];
  $image_02 = $_FILES['image_02']['name'];
  $image_size_02 = $_FILES['image_02']['size'];
  $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
  $image_folder_02 = $baseImagePath;

  if (!empty($image_02) && is_uploaded_file($image_tmp_name_02)) {
    $newImageName_02 = $name . '_02';
    $new_image_02 = sanitizeAndRenameImage($image_02, $newImageName_02, $image_tmp_name_02, $image_folder_02);

    if ($new_image_02) {
      $update_image_02 = $conn->prepare("UPDATE `products` SET image_02 = ? WHERE id = ?");
      $update_image_02->execute([$new_image_02, $pid]);

      if (!empty($old_image_02) && file_exists($image_folder_02 . $old_image_02)) {
        unlink($image_folder_02 . $old_image_02);
      }

      $message[] = 'Изображение-2 е актуализирано успешно!';
    } else {
      $message[] = 'Неуспешно качване на Изображение-2 в папката!';
    }
  }

  // Image-3
  $old_image_03 = $_POST['old_image_03'];
  $image_03 = $_FILES['image_03']['name'];
  $image_size_03 = $_FILES['image_03']['size'];
  $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
  $image_folder_03 = $baseImagePath;

  if (!empty($image_03) && is_uploaded_file($image_tmp_name_03)) {
    $newImageName_03 = $name . '_03';
    $new_image_03 = sanitizeAndRenameImage($image_03, $newImageName_03, $image_tmp_name_03, $image_folder_03);

    if ($new_image_03) {
      $update_image_03 = $conn->prepare("UPDATE `products` SET image_03 = ? WHERE id = ?");
      $update_image_03->execute([$new_image_03, $pid]);

      if (!empty($old_image_03) && file_exists($image_folder_03 . $old_image_03)) {
        unlink($image_folder_03 . $old_image_03);
      }

      $message[] = 'Изображение-3 е актуализирано успешно!';
    } else {
      $message[] = 'Неуспешно качване на Изображение-3 в папката!';
    }
  }
}


?>

<!DOCTYPE html>
<html lang="bg">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Актуализиране на продукта</title>
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

    <section class="update-product">
      <h1 class="heading">Актуализиране на продукт</h1>
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

            <span>Обнови името</span>
            <input type="text" name="name" class="box" maxlength="100" placeholder="Име" value="<?= $fetch_products['name']; ?>" required>

            <span>Обнови цената</span>
            <input type="number" name="price" class="box" min="0.00" step="0.01" placeholder="Цена" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['price']; ?>" required>

            <span>Обнови описанието</span>
            <textarea name="details" class="box" required><?= $fetch_products['details']; ?></textarea>

            <span id="brandLabel">Обнови марката</span>
            <select name="brand" class="box" aria-labelledby="brandLabel" required>
              <?php
              $selectedBrand = $fetch_products['brand'];
              $brands = array("Samsung", "Apple", "Google", "Xiaomi", "OnePlus", "Lenovo", "Motorola", "Oppo");

              foreach ($brands as $brandOption) {
                echo '<option value="' . $brandOption . '" ' . ($brandOption == $selectedBrand ? 'selected' : '') . '>' . $brandOption . '</option>';
              }
              ?>
            </select>

            <span>Обнови датата на лансиране</span>
            <input type="text" name="released" placeholder="Дата на лансиране" class="box" value="<?= $fetch_products['released']; ?>">

            <span>Обнови количесвото</span>
            <input type="number" name="qty" placeholder="Количесвото" class="box" min="0" step="1" value="<?= $fetch_products['qty']; ?>" required>

            <span>Обнови CPU</span>
            <input type="text" name="cpu" placeholder="CPU" class="box" value="<?= $fetch_products['cpu']; ?>" required>

            <span>Обнови вътрешната памет</span>
            <input type="text" name="storage" placeholder="Вътрешната памет" class="box" value="<?= $fetch_products['storage']; ?>" required>

            <span>Обнови RAM памет</span>
            <input type="text" name="ram" placeholder="RAM памет" class="box" value="<?= $fetch_products['ram']; ?>" required>

            <span>Обнови броя на камерите</span>
            <input type="number" name="camera_count" placeholder="Брой камери" class="box" min="0" step="1" value="<?= $fetch_products['camera_count']; ?>" required>

            <span>Обнови резолюцията на камерата</span>
            <input type="text" name="camera_resolution" placeholder="Резолюция" class="box" value="<?= $fetch_products['camera_resolution']; ?>" required>

            <span>Обнови размера на дисплейя</span>
            <input type="text" name="size" placeholder="Размер на дисплей" class="box" value="<?= $fetch_products['size']; ?>" required>

            <span>Обнови капацитета на батерията</span>
            <input type="text" name="battery" placeholder="Капацитет на батерия" class="box" value="<?= $fetch_products['battery']; ?>" required>

            <span>Обнови цвета</span>
            <input type="text" name="color" placeholder="Цвят" class="box" value="<?= $fetch_products['color']; ?>" required>

            <div class="file-buttons">

              <div class="inputBox">
                <span>Изображение-1</span>
                <div class="custom-file-upload">
                  <label for="image_01" class="btn"><i class="fa-solid fa-cloud-arrow-up"></i> Upload image</label>
                  <input type="file" id="image_01" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box file-input">
                  <span id="filename_01" class="chosen-file-name"></span>
                </div>
              </div>

              <div class="inputBox">
                <span>Изображение-2</span>
                <div class="custom-file-upload">
                  <label for="image_02" class="btn"><i class="fa-solid fa-cloud-arrow-up"></i> Upload image</label>
                  <input type="file" id="image_02" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box file-input">
                  <span id="filename_02" class="chosen-file-name"></span>
                </div>
              </div>

              <div class="inputBox">
                <span>Изображение-3</span>
                <div class="custom-file-upload">
                  <label for="image_03" class="btn"><i class="fa-solid fa-cloud-arrow-up"></i> Upload image</label>
                  <input type="file" id="image_03" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box file-input">
                  <span id="filename_03" class="chosen-file-name"></span>
                </div>
              </div>

            </div>

            <div class="flex-btn">
              <input type="submit" name="update" class="btn" value="Обнови">
              <a href="products.php" class="option-btn">Назад</a>
            </div>
          </form>
      <?php
        }
      } else {
        echo '<p class="empty">В момента няма продукти.</p>';
      }
      ?>
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