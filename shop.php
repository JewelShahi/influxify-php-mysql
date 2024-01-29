<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
}

include 'components/wishlist_cart.php';

// Handle filter submissions
$filter_price = isset($_GET['price']) ? $_GET['price'] : '';
$filter_brand = isset($_GET['brand']) ? strtoupper($_GET['brand']) : '';
$filter_ram = isset($_GET['ram']) ? strtoupper($_GET['ram']) : '';
$filter_storage = isset($_GET['storage']) ? strtoupper($_GET['storage']) : '';
$search_query = isset($_POST['search']) ? $_POST['search'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link rel="shortcut icon" href="images/influxify-logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/user_style.css">
</head>

<body>

  <?php include 'components/user_header.php'; ?>

  <section class="products">

    <h1 class="heading">Products we offer</h1>

    <!-- Search bar -->
    <form method="post" class="search-bar">
      <div>
        <input class="input" type="text" id="search" name="search" placeholder="Enter product name" value="<?= $search_query ?>">
        <button type="submit">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </form>

    <!-- Filter options -->
    <form method="get" class="filter-options">
      <label for="price">Filter by price:</label>
      <select id="price" name="price">
        <option value="asc" <?= ($filter_price == 'asc') ? 'selected' : '' ?>>ASC</option>
        <option value="desc" <?= ($filter_price == 'desc') ? 'selected' : '' ?>>DESC</option>
      </select>

      <label for="brand">Filter by brand:</label>
      <select id="brand" name="brand">
        <option value="" <?= ($filter_brand == '') ? 'selected' : '' ?>>-- All Brands --</option>
        <option value="Samsung" <?= ($filter_brand == 'Samsung') ? 'selected' : '' ?>>Samsung</option>
        <option value="Apple" <?= ($filter_brand == 'Apple') ? 'selected' : '' ?>>Apple</option>
        <option value="Google" <?= ($filter_brand == 'Google') ? 'selected' : '' ?>>Google</option>
        <option value="OnePlus" <?= ($filter_brand == 'OnePlus') ? 'selected' : '' ?>>OnePlus</option>
        <option value="Xiaomi" <?= ($filter_brand == 'Xiaomi') ? 'selected' : '' ?>>Xiaomi</option>
        <option value="Motorola" <?= ($filter_brand == 'Motorola') ? 'selected' : '' ?>>Motorola</option>
        <option value="Oppo" <?= ($filter_brand == 'Oppo') ? 'selected' : '' ?>>Oppo</option>
        <option value="Realme" <?= ($filter_brand == 'Realme') ? 'selected' : '' ?>>Realme</option>
      </select>

      <label for="ram">Filter by RAM:</label>
      <select id="ram" name="ram">
        <option value="" <?= ($filter_ram == '') ? 'selected' : '' ?>>-- All RAM --</option>
        <option value="2GB" <?= ($filter_ram == '2GB') ? 'selected' : '' ?>>2GB</option>
        <option value="4GB" <?= ($filter_ram == '4GB') ? 'selected' : '' ?>>4GB</option>
        <option value="6GB" <?= ($filter_ram == '6GB') ? 'selected' : '' ?>>6GB</option>
        <option value="8GB" <?= ($filter_ram == '8GB') ? 'selected' : '' ?>>8GB</option>
        <option value="12GB" <?= ($filter_ram == '12GB') ? 'selected' : '' ?>>12GB</option>
        <option value="16GB" <?= ($filter_ram == '16GB') ? 'selected' : '' ?>>16GB</option>
      </select>

      <label for="storage">Filter by storage:</label>
      <select id="storage" name="storage">
        <option value="" <?= ($filter_storage == '') ? 'selected' : '' ?>>-- All Storage --</option>
        <option value="32GB" <?= ($filter_storage == '32GB') ? 'selected' : '' ?>>32GB</option>
        <option value="64GB" <?= ($filter_storage == '64GB') ? 'selected' : '' ?>>64GB</option>
        <option value="128GB" <?= ($filter_storage == '128GB') ? 'selected' : '' ?>>128GB</option>
        <option value="256GB" <?= ($filter_storage == '256GB') ? 'selected' : '' ?>>256GB</option>
        <option value="512GB" <?= ($filter_storage == '512GB') ? 'selected' : '' ?>>512GB</option>
        <option value="1TB" <?= ($filter_storage == '1TB') ? 'selected' : '' ?>>1TB</option>
      </select>

      <button type="submit">
        <i class="fas fa-filter"></i> Apply Filters
      </button>
    </form>

    <div class="box-container">
      <?php
      // Adjust your SQL query based on filter values and search query
      $sql = "SELECT * FROM `products` WHERE 1 ";
      if (!empty($filter_brand)) {
        $sql .= " AND `brand` = :brand";
      }
      if (!empty($filter_ram)) {
        $sql .= " AND `ram` = :ram";
      }
      if (!empty($filter_storage)) {
        $sql .= " AND `storage` = :storage";
      }
      if (!empty($search_query)) {
        $sql .= " AND `name` LIKE :search_query";
      }
      $sql .= " ORDER BY `price` " . $filter_price;
      $select_products = $conn->prepare($sql);

      if (!empty($filter_brand)) {
        $select_products->bindParam(':brand', $filter_brand, PDO::PARAM_STR);
      }
      if (!empty($filter_ram)) {
        $select_products->bindParam(':ram', $filter_ram, PDO::PARAM_STR);
      }
      if (!empty($filter_storage)) {
        $select_products->bindParam(':storage', $filter_storage, PDO::PARAM_STR);
      }
      if (!empty($search_query)) {
        $search_query = '%' . $search_query . '%';
        $select_products->bindParam(':search_query', $search_query, PDO::PARAM_STR);
      }

      $select_products->execute();

      if ($select_products->rowCount() > 0) {
        while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
      ?>
          <form action="" method="post" class="box">
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
              <!-- <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1"> -->
              <input type="number" name="qty" class="qty" min="1" max="<?php echo $fetch_product['qty']; ?>" onkeypress="if(this.value.length == 2) return false;" <?php echo ($fetch_product['qty'] == 0) ? 'disabled value="0"' : 'value="1"'; ?>>
            </div>
            <!-- <button type="submit" class="btn" name="add_to_cart">
              <i class="fas fa-plus"></i> Add to cart
            </button> -->
            <button type="submit" name="add_to_cart" class="btn <?php if ($fetch_product['qty'] == 0) echo 'disabled'; ?>" <?php if ($fetch_product['qty'] == 0) echo 'disabled'; ?>>
              <i class="fas fa-plus"></i> Add to cart
            </button>
          </form>
      <?php
        }
      } else {
        echo '<div class="Empty">No products found!</div>';
      }
      ?>
    </div>
  </section>

  <?php include 'components/footer.php'; ?>

  <script src="js/user_script.js"></script>
  <?php include 'components/scroll_up.php'; ?>
  <script src="js/scrollUp.js"></script>

  <script src="js/user_search.js"></script>
</body>

</html>