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

// Update service
if (isset($_POST['update_service'])) {

  $service_id = $_POST['service_id'];
  $estimated_price = $_POST['estimated_price'];

  // Check if payment_status is set in the form
  if (isset($_POST['payment_status'])) {
    $payment_status = $_POST['payment_status'];

    $update_service = $conn->prepare("UPDATE `services` SET price = ?, payment_status = ? WHERE id = ?");
    $update_service->execute([$estimated_price, $payment_status, $service_id]);
  }

  // Check if is_resolved is set in the form
  if (isset($_POST['is_resolved'])) {
    $is_resolved = $_POST['is_resolved'];

    $update_service = $conn->prepare("UPDATE `services` SET price = ?, is_resolved = ? WHERE id = ?");
    $update_service->execute([$estimated_price, $is_resolved, $service_id]);
  }
  header('Location: services.php');
}

// Delete service
if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  $delete_service = $conn->prepare("DELETE FROM `services` WHERE id = ?");
  $delete_service->execute([$delete_id]);
  header('Location: services.php');
}
?>

<!DOCTYPE html>
<html lang="bg">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Сервизи</title>
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

    <section class="services">

      <h1 class="heading">Сервизи</h1>

      <div class="box-container">

        <?php
        $select_services = $conn->prepare("SELECT * FROM `services` ORDER BY `is_resolved` ASC, `placed_on` DESC");
        $select_services->execute();
        if ($select_services->rowCount() > 0) {
          while ($fetch_service = $select_services->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <form action="" method="post" class="box">
              <div class="blur">
                <input type="hidden" name="service_id" value="<?= $fetch_service['id']; ?>">
                <p> Сервиз № : <span><?= $fetch_service['id']; ?></span></p>
                <p> Заявена на : <span><?= date('d/m/Y H:i:s', strtotime($fetch_service['placed_on'])); ?></span></p>
                <p> Потребител № : <span><?= $fetch_service['user_id']; ?></span></p>
                <p> Име : <span><?= $fetch_service['name']; ?></span></p>
                <p> Имейл : <span><?= $fetch_service['email']; ?></span></p>
                <p> Тел. : <span><?= $fetch_service['number']; ?></span></p>
                <p> Марка на телефона : <span><?= $fetch_service['brand']; ?></span></p>
                <p> Описание на проблема : <span class="long-text"><?= $fetch_service['description']; ?></span></p>
                <p> Обща цена (<em>с доставка, ако е включена</em>) : <input type="number" name="estimated_price" class="price" min="0" max="999999" step="0.01" value="<?= $fetch_service['price']; ?>" <?= ($fetch_service['payment_method'] !== null) ? 'readonly' : ''; ?> style="<?= ($fetch_service['payment_method'] !== null) ? 'color: black;' : ''; ?>"> лв.</p>
                <p> Доставка: <?= $fetch_service['delivery']; ?></p>
                <?php
                if ($fetch_service['delivery'] == 'yes') {
                ?>
                  <p> Адрес: <?= $fetch_service['address']; ?></p>
                <?php
                }
                ?>
                <p> Вид на платеж : <span><?= $fetch_service['payment_method']; ?></span></p>
                <p id="paymentStatusLabel">Статус на плащане :</p>
                <select name="payment_status" class="select" aria-labelledby="paymentStatusLabel">
                  <option selected disabled><?= $fetch_service['payment_status']; ?></option>
                  <option value="pending">Неплатен</option>
                  <option value="completed">Платен</option>
                </select>
                <p id="isResolvedLabel">Решен ли е проблема :</p>
                <select name="is_resolved" class="select" aria-labelledby="isResolvedLabel">
                  <option value="1" <?php echo $fetch_service['is_resolved'] == 1 ? 'selected' : ''; ?>>Да</option>
                  <option value="0" <?php echo $fetch_service['is_resolved'] == 0 ? 'selected' : ''; ?>>Не</option>
                </select>
                <div class="flex-btn">
                  <button type="submit" name="update_service" class="option-btn">Обнови</button>
                  <a href="services.php?delete=<?= $fetch_service['id']; ?>" onclick="return confirm('Съгласен ли си да изтриеш заявката?');" class="delete-btn" style="<?= ($fetch_services['payment_method'] == null) ? '' : 'display: none;'; ?>">Delete</a>
                </div>
              </div>
            </form>
        <?php
          }
        } else {
          echo '<p class="empty">До момента няма заявки за сервиз.</p>';
        }
        ?>

      </div>

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