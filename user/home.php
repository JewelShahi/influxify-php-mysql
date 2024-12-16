<?php

include '../components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
} else {
	$user_id = '';
};

include '../components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="bg" style="height: auto;">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	<link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">

	<!-- Swiper.js -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

	<!-- Fontawesome cdn link  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

	<!-- AOS -->
	<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

	<!-- custom css file link -->
	<link rel="stylesheet" href="../css/global.css">
	<link rel="stylesheet" href="../css/testimonial.css">
	<link rel="stylesheet" href="../css/user_style.css">
</head>

<body style="height: auto;">

	<?php include '../components/user_header.php'; ?>

	<div class="home-bg">
		<section class="home">
			<div class="swiper home-slider">
				<div class="swiper-wrapper">
					<?php
					$select_products = $conn->prepare("SELECT `name`, `details`, `image_01` FROM `products` ORDER BY RAND() LIMIT 10");
					$select_products->execute();
					$productData = $select_products->fetchAll(PDO::FETCH_ASSOC);
					?>

					<?php for ($i = 0; $i < count($productData); $i++) { ?>
						<?php
						$name = $productData[$i]['name'];
						$details = $productData[$i]['details'];
						$image_01 = $productData[$i]['image_01'];
						?>
						<div class="swiper-slide slide">
							<div class="image">
								<img src="../uploaded_img/products/<?php echo $image_01; ?>" alt="<?php echo $image_01; ?>">
							</div>
							<div class="content">
								<h3><?php echo $name; ?></h3>
								<p style="padding: 0 5px; width: 90%;"><?php echo $details; ?></p>
								<br>
								<a href="shop.php" class="btn shop-now-btn"><span>Пазарувай сега <span><i class="fa-solid fa-arrow-right"></i></a>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="swiper-pagination"></div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
		</section>
	</div>


	<section class="about-us-section">
		<div class="header-blur">
			<h1 class="heading" data-aos="fade-up" data-aos-duration="1000">За нас</h1>
		</div>
		<div class="about-us">
			<div class="info" data-aos="fade-right" data-aos-duration="1000">
				<div class="inner-info">
					<div>
						<p>
							Influxify е посветен на революционизирането на мобилната индустрия с авангардни технологии и изключително обслужване, овластяване на хората и бизнеса с надеждни, висококачествени комуникационни решения.
						</p>
					</div>
					<div class="missions-and-goals" data-aos="zoom-out" data-aos-duration="1000">
						<h2>Нашата мисия</h2>
						<ul class="bullet-point">
							<li>
								Нашата мисия в Influxify е да иновираме мобилната индустрия, като предоставяме модерна технология и несравнимо обслужване.
							</li>
							<li>
								Това позволява безпроблемно преживяване както за физически лица, така и за фирми.
							</li>
						</ul>
						<h2>Нашaтa цел</h2>
						<ul class="bullet-point">
							<li>
								Нашата цел в Influxify е да бъдем в челните редици на мобилните иновации, непрекъснато надминавайки индустриалните стандарти и очакванията на клиентите.
							</li>
							<li>
								Ние постигаме това, като предоставяме персонализирани решения, за да отговорим на разнообразните нужди на нашите потребители.
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="images" data-aos="fade-left" data-aos-duration="1000"></div>
		</div>
	</section>

	<section class="services-section">
		<div class="header-blur">
			<h1 class="heading" data-aos="fade-down" data-aos-duration="1000">Предлагани услуги</h1>
		</div>
		<div class="services-info">
			<div class="images" data-aos="fade-right" data-aos-duration="1000"></div>
			<div class="info" data-aos="fade-left" data-aos-duration="1000">
				<div class="inner-info">
					<div>
						<p>
							В Influxify нашите квалифицирани техници бързо поправят проблемите с телефона, от екраните до вътрешната работа, като възстановяват функционалността на вашето устройство.
						</p>
						<p>
							Доверете ни се за бързо и надеждно обслужване с помощта на оригинални части и усъвършенствани техники.
						</p>
						<p>
							Независимо от възрастта, Influxify осигурява професионална грижа за вашия телефон.
						</p>
					</div>
					<div class="services-and-offers" data-aos="zoom-out" data-aos-duration="1000">
						<h2>Предлагани сервизи</h2>
						<ul class="bullet-point">
							<li>
								Ремонт на екрани: Нашите техници могат бързо и ефективно да заменят напукани или повредени екрани на вашето устройство.
							</li>
							<li>
								Смяна на батерии: Ние предлагаме услуги за смяна на батерия, за да гарантираме, че вашето устройство остава захранено през целия ден.
							</li>
							<li>
								Отстраняване на проблеми със софтуера: Ако имате проблеми със софтуера, нашите експерти могат да ги диагностицират и разрешат незабавно.</li>
						</ul>
						<h2>Нашите оферти</h2>
						<ul class="bullet-point">
							<li>
								Безплатен протектор за екран: Вземете безплатен протектор за екран с всяка услуга за ремонт на екрани.
							</li>
							<li>
								Смяна на батерия с отстъпка: Възползвайте се от намалени цени за услуги за смяна на батерия за ограничен период от време.
							</li>
							<li>
								Софтуерна диагностика: Получете безплатна софтуерна диагностика с всеки ремонтен сервиз.
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="brand">

		<h1 class="heading" data-aos="fade-up" data-aos-duration="1000">Пазарувайте по марка</h1>

		<div class="swiper brand-slider" data-aos="slide-right" data-aos-duration="1000">

			<div class="swiper-wrapper">

				<a href="brand.php?brand=Samsung" class="swiper-slide slide">
					<img src="../images/brands/samsung.png" alt="samsung brand">
					<h3>Samsung</h3>
				</a>

				<a href="brand.php?brand=Apple" class="swiper-slide slide">
					<img src="../images/brands/apple.png" alt="apple brand">
					<h3>Apple</h3>
				</a>

				<a href="brand.php?brand=Google" class="swiper-slide slide">
					<img src="../images/brands/google.png" alt="google brand">
					<h3>Google</h3>
				</a>

				<a href="brand.php?brand=Xiaomi" class="swiper-slide slide">
					<img src="../images/brands/xiaomi.png" alt="xiaomi brand">
					<h3>Xiaomi</h3>
				</a>

				<a href="brand.php?brand=OnePlus" class="swiper-slide slide">
					<img src="../images/brands/oneplus.png" alt="one-plus brand">
					<h3>OnePlus</h3>
				</a>

				<a href="brand.php?brand=Motorola" class="swiper-slide slide">
					<img src="../images/brands/motorola.png" alt="motorola brand">
					<h3>Motorola</h3>
				</a>

				<a href="brand.php?brand=Oppo" class="swiper-slide slide">
					<img src="../images/brands/oppo.png" alt="oppo brand">
					<h3>Oppo</h3>
				</a>

				<a href="brand.php?brand=Realme" class="swiper-slide slide">
					<img src="../images/brands/realme.png" alt="realme brand">
					<h3>Realme</h3>
				</a>

			</div>
			<div class="swiper-pagination"></div>
			<div class="swiper-button-next" id="brand-next"></div>
			<div class="swiper-button-prev" id="brand-prev"></div>
		</div>

	</section>

	<section class="home-products">

		<h1 class="heading" data-aos="fade" data-aos-duration="1000">Наскоро добавени към нашата колекция продукти</h1>

		<div class="swiper products-slider" data-aos="slide-left" data-aos-duration="1000">

			<div class="swiper-wrapper">
				<?php
				$select_products = $conn->prepare("
					SELECT * FROM `products` ORDER BY id DESC LIMIT 6;
				");
				$select_products->execute();
				if ($select_products->rowCount() > 0) {
					while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
				?>
						<form action="" method="post" class="swiper-slide slide">
							<input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
							<input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
							<input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
							<input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
							<button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
							<a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
							<img src="../uploaded_img/products/<?= $fetch_product['image_01']; ?>" alt="<?= $fetch_product['image_01']; ?>">
							<div class="name"><?= $fetch_product['name']; ?></div>
							<div class="flex">
								<div class="price">
									<?= $fetch_product['price']; ?><span> лв.</span>
								</div>
								<?php
								if ($fetch_product['qty'] == 0) {
								?>
									<div class="out-of-stock">Изчерпан</div>
								<?php
								} else {
								?>
									<input type="number" name="qty" class="qty" min="1" max="<?= $fetch_product['qty']; ?>" onkeypress="if(this.value.length == 2) return false;" <?php echo ($fetch_product['qty'] == 0) ? 'disabled value="0"' : 'value="1"'; ?>>
								<?php
								}
								?>
							</div>
							<button type="submit" name="add_to_cart" class="btn <?php if ($fetch_product['qty'] == 0) echo 'disabled'; ?>">
								<i class="fas fa-plus"></i> Добави в количката
							</button>
						</form>
				<?php
					}
				} else {
					echo '<p class="empty">За момента няма добавени продукти!</p>';
				}
				?>

			</div>

			<div class="swiper-pagination"></div>

		</div>

	</section>

	<?php include 'testamonial.php'; ?>

	<!-- Footer -->
	<?php include '../components/footer.php'; ?>

	<!-- User script -->
	<script src="../js/user_script.js"></script>

	<!-- Scroll up button -->
	<?php include '../components/scroll_up.php'; ?>
	<script src="../js/scrollUp.js"></script>

	<!-- Carosell -->
	<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
	<script src="../js/swiper.js"></script>

	<!-- AOS  -->
	<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
	<script>
		AOS.init({
			duration: 1000,
			delay: 300,
			once: true,
		});
	</script>
</body>

</html>