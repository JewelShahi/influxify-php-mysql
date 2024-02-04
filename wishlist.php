<?php

include 'components/connect.php';
session_name('user_session');
session_start();

if (isset($_SESSION['user']['user_id'])) {
	$user_id = $_SESSION['user']['user_id'];
} else {
	$user_id = '';
	header('location:user_login.php');
};

include 'components/wishlist_cart.php';

if (isset($_POST['delete'])) {
	$pid = $_POST['pid'];
	$delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ? AND pid = ?");
	$delete_wishlist_item->execute([$user_id, $pid]);
}

if (isset($_GET['delete_all'])) {
	$delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
	$delete_wishlist_item->execute([$user_id]);
	header('location:wishlist.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Wishlist</title>
	<link rel="shortcut icon" href="images/influxify-logo.ico" type="image/x-icon">
	<!-- font awesome cdn link  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<!-- custom css file link  -->
	<link rel="stylesheet" href="css/global.css">

	<link rel="stylesheet" href="css/user_style.css">
</head>

<body>

	<?php include 'components/user_header.php'; ?>

	<section class="products">

		<h3 class="heading">Wishlist</h3>

		<div class="box-container">

			<?php
			$grand_total = 0;
			$select_wishlist = $conn->prepare("
				SELECT w.user_id, w.pid, w.name, w.price, p.qty as product_quantity, p.image_01 as image 
				FROM wishlist w
				JOIN products p ON w.pid = p.id 
				WHERE user_id = ?
			");
			$select_wishlist->execute([$user_id]);
			if ($select_wishlist->rowCount() > 0) {
				while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
					$grand_total += $fetch_wishlist['price'];
			?>
					<form action="" method="post" class="box">
						<input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
						<input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
						<input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
						<input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
						<input type="hidden" name="qty" value="1">
						<a href="quick_view.php?pid=<?= $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
						<img src="uploaded_img/products/<?= $fetch_wishlist['image']; ?>" alt="">
						<div class="name"><?= $fetch_wishlist['name']; ?></div>
						<div class="price">$<?= $fetch_wishlist['price']; ?></div>
						<button type="submit" name="add_to_cart" class="btn <?php if ($fetch_wishlist['product_quantity'] == 0) echo 'disabled'; ?>" <?php if ($fetch_wishlist['product_quantity'] == 0) echo 'disabled'; ?>>
							<i class="fas fa-plus"></i> Add to cart
						</button>
						<button type="submit" onclick="return confirm('Remove this from wishlist?');" class="delete-btn" name="delete">
							<i class="fas fa-minus"></i> Remove item
						</button>
					</form>
			<?php
				}
			} else {
				echo '<p class="empty">Your wishlist is empty.</p>';
			}
			?>
		</div>
	</section>
	<div class="wishlist-total">
		<p>Grand total : <span>$<?= $grand_total; ?></span></p>
		<a href="shop.php" class="option-btn">
			<i class="fas fa-arrow-left"></i> Continue shopping
		</a>
		<a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('Delete all from wishlist?');">
			<i class="fas fa-trash-alt"></i> Remove all items
		</a>
	</div>
	<?php include 'components/footer.php'; ?>

	<script src="js/user_script.js"></script>
	<?php include 'components/scroll_up.php'; ?>
	<script src="js/scrollUp.js"></script>
</body>

</html>