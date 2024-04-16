<?php
include '../components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
};
?>
<!DOCTYPE html>
<html lang="bg">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Информация за контакти</title>
  <link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/user_style.css">
</head>

<body style="height: auto;">

  <?php include '../components/user_header.php'; ?>

  <div class="contact">
    <h1 class="contact-header">Информация за контакти</h1>
    <div class="contact-info">
      <div>
        <span>Собственик :</span>
        <p>Джуел Шахи</p>
      </div>
      <div>
        <span>Емейл :</span>
        <a href="mailto:joeimportant1020@gmail.com">joeimportant1020@gmail.com</a>
      </div>
      <div>
        <span>Тел. номер :</span>
        <a href="#">+359 877564341</a>
      </div>
      <div>
        <span>Адрес :</span>
        <p>София, България - 1000</p>
      </div>
      <div>
        <span>Последвайте ни в :</span>
        <div class="medias">
          <a href="#"><i class="fab fa-facebook"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
      <div>
        <span>Отворени часове :</span>
        <p>
          Понеделник - Петък : <b>9:00</b> - <b>18:00</b><br>
          Събота : <b>10:00</b> - <b>16:00</b><br>
          Неделя : <b>неработен</b>
        </p>
      </div>
    </div>
    <iframe class="contact-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2933.568348182773!2d23.35919807560296!3d42.670501815432935!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40aa8587e5b96129%3A0xbbf46b29a556f55d!2z0KHQn9CT0JUg4oCe0JTQttC-0L0g0JDRgtCw0L3QsNGB0L7QsuKAnA!5e0!3m2!1sbg!2sbg!4v1709937746389!5m2!1sbg!2sbg" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
  </div>

  <?php include '../components/footer.php'; ?>
  <script src="../js/user_script.js"></script>
  <?php include '../components/scroll_up.php'; ?>
  <script src="../js/scrollUp.js"></script>

</body>

</html>