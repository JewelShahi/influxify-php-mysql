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
<html lang="en" style="height: auto;">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	<link rel="shortcut icon" href="../images/influxify-logo.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
	<!-- font awesome cdn link  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

	<!-- custom css file link -->
	<link rel="stylesheet" href="../css/global.css">
	<link rel="stylesheet" href="../css/user_style.css">
</head>

<body style="height: auto;">

	<?php include '../components/user_header.php'; ?>

	<div class="home-bg">
		<section class="home">
			<div class="swiper home-slider">
				<div class="swiper-wrapper">
					<?php
					$select_products = $conn->prepare("SELECT `name`, `details`, `image_01` FROM `products` ORDER BY RAND()");
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
								<a href="shop.php" class="btn shop-now-btn"><span>Shop now <span><i class="fa-solid fa-arrow-right"></i></a>
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
			<h1 class="heading">About Us</h1>
		</div>
		<div class="about-us">
			<div class="info">
				<div class="inner-info">
					<div>
						<p>
							Influxify is dedicated to revolutionizing the mobile industry with cutting-edge technology and exceptional service, empowering individuals and businesses with reliable, high-quality communication solutions.
						</p>
					</div>
					<div class="missions-and-goals">
						<h2>Our Mission</h2>
						<ul class="bullet">
							<li>
								Our mission at Influxify is to innovate the mobile industry by providing advanced technology and unparalleled service.
							</li>
							<li>
								This enables seamless communication experiences for individuals and businesses alike.
							</li>
						</ul>
						<h2>Our Goal</h2>
						<ul class="bullet">
							<li>
								At Influxify, our goal is to be at the forefront of mobile innovation, continuously surpassing industry standards and customer expectations.
							</li>
							<li>
								We achieve this by delivering customized solutions to meet the diverse needs of our users.
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="images"></div>
		</div>
	</section>

	<section class="services-section">
		<div class="header-blur">
			<h1 class="heading">Services We Offer</h1>
		</div>
		<div class="services-info">
			<div class="images"></div>
			<div class="info">
				<div class="inner-info">
					<div>
						<p>
							At Influxify, our skilled technicians swiftly repair phone issues, from screens to the inner workings, restoring your device's functionality.
						</p>
						<p>
							Trust us for fast, reliable service using genuine parts and advanced techniques.
						</p>
						<p>
							Whether minor or major, Influxify delivers professional care for your phone.
						</p>
					</div>
					<div class="services-and-offers">
						<h2>Our Services</h2>
						<ul class="bullet">
							<li>
								Screen repair: Our technicians can quickly and efficiently replace cracked or damaged screens on your device.
							</li>
							<li>
								Battery replacement: We offer battery replacement services to ensure your device stays powered throughout the day.
							</li>
							<li>
								Software troubleshooting: If you're experiencing software issues, our experts can diagnose and resolve them promptly.
							</li>
						</ul>
						<h2>Our Offers</h2>
						<ul class="bullet">
							<li>
								Free screen protector: Get a complimentary screen protector with any screen repair service.
							</li>
							<li>
								Discounted battery replacement: Enjoy discounted rates on battery replacement services for a limited time.
							</li>
							<li>
								Software diagnosis: Receive a free software diagnosis with any repair service.
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="brand">

		<h1 class="heading">Shop by brand</h1>

		<div class="swiper brand-slider">

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

		<h1 class="heading">Recently added to our collection</h1>

		<div class="swiper products-slider">

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
								<div class="price"><span>$</span><?= $fetch_product['price']; ?></div>
								<input type="number" name="qty" class="qty" min="1" max="<?= $fetch_product['qty']; ?>" onkeypress="if(this.value.length == 2) return false;" <?php echo ($fetch_product['qty'] == 0) ? 'disabled value="0"' : 'value="1"'; ?>>
							</div>
							<button type="submit" name="add_to_cart" class="btn <?php if ($fetch_product['qty'] == 0) echo 'disabled'; ?>">
								<i class="fas fa-plus"></i> Add to cart
							</button>
						</form>
				<?php
					}
				} else {
					echo '<p class="empty">No products added yet!</p>';
				}
				?>

			</div>

			<div class="swiper-pagination"></div>

		</div>

	</section>

	<!-- Footer -->
	<?php include '../components/footer.php'; ?>

	<!-- User script -->
	<script src="../js/user_script.js"></script>

	<!-- Scroll up button -->
	<?php include '../components/scroll_up.php'; ?>
	<script src="../js/scrollUp.js"></script>

	<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
	<script src="../js/swiper.js"></script>

</body>

</html>