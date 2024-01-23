<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
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
					$select_products = $conn->prepare("SELECT `name`, `details`, `image_01` FROM `products`");
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
								<p><?php echo $details; ?></p>
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

	<section class="category">

		<h1 class="heading">Shop by category</h1>

		<div class="swiper category-slider">

			<div class="swiper-wrapper">

				<a href="category.php?category=laptop" class="swiper-slide slide">
					<img src="images/icon-1.png" alt="">
					<h3>laptop</h3>
				</a>

				<a href="category.php?category=tv" class="swiper-slide slide">
					<img src="images/icon-2.png" alt="">
					<h3>tv</h3>
				</a>

				<a href="category.php?category=camera" class="swiper-slide slide">
					<img src="images/icon-3.png" alt="">
					<h3>camera</h3>
				</a>

				<a href="category.php?category=mouse" class="swiper-slide slide">
					<img src="images/icon-4.png" alt="">
					<h3>mouse</h3>
				</a>

				<a href="category.php?category=fridge" class="swiper-slide slide">
					<img src="images/icon-5.png" alt="">
					<h3>fridge</h3>
				</a>

				<a href="category.php?category=washing" class="swiper-slide slide">
					<img src="images/icon-6.png" alt="">
					<h3>washing machine</h3>
				</a>

				<a href="category.php?category=smartphone" class="swiper-slide slide">
					<img src="images/icon-7.png" alt="">
					<h3>smartphone</h3>
				</a>

				<a href="category.php?category=watch" class="swiper-slide slide">
					<img src="images/icon-8.png" alt="">
					<h3>watch</h3>
				</a>

			</div>

			<div class="swiper-pagination"></div>

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
								<input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
							</div>
							<!-- <input type="submit" value="Add to cart" class="btn" name="add_to_cart"> -->
							<button type="submit" class="btn" name="add_to_cart">
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