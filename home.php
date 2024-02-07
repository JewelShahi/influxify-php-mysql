<?php

include 'components/connect.php';
session_name('user_session');
session_start();

if (isset($_SESSION['user_session']['user_id'])) {
	$user_id = $_SESSION['user_session']['user_id'];
} else {
	$user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en" style="height: auto;">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	<link rel="shortcut icon" href="images/influxify-logo.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
	<!-- font awesome cdn link  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<!-- custom css file link -->
	<link rel="stylesheet" href="css/global.css">

	<link rel="stylesheet" href="css/user_style.css">
</head>

<body style="height: auto;">

	<?php include 'components/user_header.php'; ?>
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
								<img src="uploaded_img/products/<?php echo $image_01; ?>" alt="<?php echo $image_01; ?>">
							</div>
							<div class="content">
								<h3><?php echo $name; ?></h3>
								<p style="padding: 0 5px;"><?php echo $details; ?></p>
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

	<section class="brand">

		<h1 class="heading">Shop by brand</h1>

		<div class="swiper brand-slider">

			<div class="swiper-wrapper">

				<a href="brand.php?brand=Samsung" class="swiper-slide slide">
					<img src="images/brands/samsung.png" alt="samsung brand">
					<h3>Samsung</h3>
				</a>

				<a href="brand.php?brand=Apple" class="swiper-slide slide">
					<img src="images/brands/apple.png" alt="apple brand">
					<h3>Apple</h3>
				</a>

				<a href="brand.php?brand=Google" class="swiper-slide slide">
					<img src="images/brands/google.png" alt="google brand">
					<h3>Google</h3>
				</a>

				<a href="brand.php?brand=Xiaomi" class="swiper-slide slide">
					<img src="images/brands/xiaomi.png" alt="xiaomi brand">
					<h3>Xiaomi</h3>
				</a>

				<a href="brand.php?brand=OnePlus" class="swiper-slide slide">
					<img src="images/brands/oneplus.png" alt="one-plus brand">
					<h3>OnePlus</h3>
				</a>

				<a href="brand.php?brand=Motorola" class="swiper-slide slide">
					<img src="images/brands/motorola.png" alt="motorola brand">
					<h3>Motorola</h3>
				</a>

				<a href="brand.php?brand=Oppo" class="swiper-slide slide">
					<img src="images/brands/oppo.png" alt="oppo brand">
					<h3>Oppo</h3>
				</a>

				<a href="brand.php?brand=Realme" class="swiper-slide slide">
					<img src="images/brands/realme.png" alt="realme brand">
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
							<img src="uploaded_img/products/<?= $fetch_product['image_01']; ?>" alt="">
							<div class="name"><?= $fetch_product['name']; ?></div>
							<div class="flex">
								<div class="price"><span>$</span><?= $fetch_product['price']; ?></div>
								<input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" <?php echo ($fetch_product['qty'] == 0) ? 'disabled value="0"' : 'value="1"'; ?>>
							</div>
							<button type="submit" name="add_to_cart" class="btn <?php if ($fetch_product['qty'] == 0) echo 'disabled'; ?>" <?php if ($fetch_product['qty'] == 0) echo 'disabled'; ?>>
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

	<?php include 'components/scroll_up.php'; ?>
	<script src="js/scrollUp.js"></script>

	<?php include 'components/footer.php'; ?>
	<script src="js/user_script.js"></script>

	<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
	<script src="js/swiper.js"></script>

</body>

</html>