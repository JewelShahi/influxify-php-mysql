<?php

include '../components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
  header("Location: user_login.php");
}

if (isset($_POST['send'])) {

  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $number = $_POST['number'];
  $number = filter_var($number, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $brand = $_POST['brand'];
  $brand = filter_var($brand, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $description = $_POST['description'];
  $description = filter_var($description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  if (!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $email)) {
    $message[] = 'Невалиден формат на имейл!';
  } else {
    try {
      $insert_service = $conn->prepare("INSERT INTO `services` (user_id, name, email, number, brand, description) VALUES(?,?,?,?,?,?)");
      $insert_service->execute([$user_id, $name, $email, $number, $brand, $description]);

      $message[] = 'Заявен е успошно сервиза!';

      // Redirect to a different page to prevent form resubmission
      header('Location: service.php');
    } catch (PDOException $e) {
      // Handle the exception - display an error message or log the error
      $message[] = 'Грешка: ' . $e->getMessage();
    }
  }
}

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  $delete_service = $conn->prepare("DELETE FROM `services` WHERE id = ?");
  $delete_service->execute([$delete_id]);

  header('Location: service.php');
}

?>

<!DOCTYPE html>
<html lang="bg">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Сервиз</title>
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <!-- custom css file link  -->
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/user_style.css">
</head>

<body style="height: auto;">

  <?php include '../components/user_header.php'; ?>

  <?php
  $select_user_exists = $conn->prepare("SELECT id FROM `users` WHERE id = ?");
  $select_user_exists->execute([$user_id]);
  if ($select_user_exists->rowCount() == 0) {
    header("Location: user_login.php");
  } else {
  ?>

    <section class="service" style="min-height: 100%;">

      <h1 class="heading">Сервизи</h1>

      <?php
      if ($user_id == '') {
        echo '<p class="empty">Please Log In add or see service(s).</p>';
      } else {
      ?>
        <div class="add-ticket">
          <form action="" method="post">
            <h3>Заявка за сервиз</h3>
            <input type="text" name="name" placeholder="Пълно име" maxlength="100" class="box" required>
            <input type="email" name="email" placeholder="Имейл" maxlength="50" class="box" required>
            <input type="number" name="number" min="0" max="999999999999999" placeholder="Тел. номер" onkeypress="if(this.value.length > 15) return false;" class="box" required>
            <select name="brand" class="box" aria-labelledby="brandLabel" required>
              <option selected default disabled>Изберете марка</option>
              <?php

              $selectedBrand = $fetch_products['brand'];
              $brands = array("Samsung", "Apple", "Google", "Xiaomi", "OnePlus", "Lenovo", "Motorola", "Oppo");

              foreach ($brands as $brandOption) {
                echo '<option value="' . $brandOption . '" ' . ($brandOption == $selectedBrand ? 'selected' : '') . '>' . $brandOption . '</option>';
              }

              ?>
            </select>
            <textarea name="description" class="box" placeholder="Описание на проблема" cols="30" rows="10" required></textarea>
            <button type="submit" name="send" class="btn">Заяви за сервиз</button>
          </form>
        </div>

        <?php

        $select_services = $conn->prepare("SELECT * FROM `services` WHERE user_id = ? ORDER BY is_resolved ASC, placed_on DESC");
        $select_services->execute([$user_id]);

        if ($select_services->rowCount() > 0) {
        ?>
          <h3 class="heading-2">Заявени сервизни заявки</h3>
          <div class="service-box-container">
            <?php
            while ($fetch_services = $select_services->fetch(PDO::FETCH_ASSOC)) {
            ?>
              <form action="service_checkout.php" method="POST" id="serviceForm<?= $fetch_services['id']; ?>" class="service-box" style="<?= $fetch_services['is_resolved'] > 0 ? 'background-image: url(../images/resolved-service-bg.png);' : ''; ?>">
                <div>
                  <input type="hidden" name="service_id" value="<?= $fetch_services["id"]; ?>">
                  <input type="hidden" name="service_price" value="<?= $fetch_services["price"]; ?>">
                  <input type="hidden" name="service_name" value="<?= $fetch_services['name']; ?>">
                  <input type="hidden" name="service_email" value="<?= $fetch_services['email']; ?>">
                  <input type="hidden" name="service_number" value="<?= $fetch_services['number']; ?>">

                  <p>Решен ли е проблема : <span><?= $fetch_services['is_resolved'] ? 'Yes' : 'No'; ?></span></p>
                  <p>Заявена на : <span><?= date('d/m/Y H:i:s', strtotime($fetch_services['placed_on'])); ?></span></p>
                  <p>Име : <span><?= $fetch_services['name']; ?></span></p>
                  <p>Имейл : <span><?= $fetch_services['email']; ?></span></p>
                  <p>Тел. номер : <span><?= $fetch_services['number']; ?></span></p>
                  <p>Марка : <span><?= $fetch_services['brand']; ?></span></p>
                  <p>Описание на проблема : <br><span class="description-text"><?= $fetch_services['description']; ?></span></p>
                  <p style="<?= ($fetch_services['payment_method'] != null) ? '' : 'display: none;'; ?>">Доставка : <span><?= $fetch_services['delivery']; ?></span></p>
                  <?php
                  if ($fetch_services['delivery'] == 'yes') {
                  ?>
                    <p> Адрес: <span><?= $fetch_services['address']; ?></span></p>
                  <?php
                  }
                  ?>
                  <p style="<?= ($fetch_services['payment_method'] != null) ? '' : 'display: none;'; ?>">Вид на платеж : <span><?= $fetch_services['payment_method']; ?></span></p>
                  <p style="<?= ($fetch_services['price'] > 0) ? '' : 'display: none;'; ?>">Цена <?= (($fetch_services['delivery'] == 'yes') && ($fetch_services['payment_method'] != null)) ? '(с доставка) ' : '' ?>: <br><span><?= $fetch_services['price']; ?> лв.</span></p>
                  <button type="submit" name="service_checkout" class="option-btn" style="<?= ($fetch_services['price'] > 0 && $fetch_services['payment_method'] == null) ? '' : 'display: none;'; ?>">Плати за сервиза</button>
                  <a href="service.php?delete=' . $fetch_services['id'] . '" class="delete-btn" onclick="return confirm('Съгласени ли сте да се откажете от заявката?');" style="<?= ($fetch_services['price'] > 0 && $fetch_services['payment_method'] == null) ? '' : 'display: none;'; ?>">Откажи заявката</a>
                </div>
              </form>
          <?php
            }
          } else {
            echo '<p class="empty">Все още няма заяки за сервиз.</p>';
          }
          ?>
          </div>
        <?php
      }
        ?>
    </section>
  <?php
  }
  ?>

  <!-- Footer -->
  <?php include '../components/footer.php'; ?>

  <!-- User script -->
  <script src="../js/user_script.js"></script>

  <!-- Scroll up button -->
  <?php include '../components/scroll_up.php'; ?>
  <script src="../js/scrollUp.js"></script>

</body>

</html>