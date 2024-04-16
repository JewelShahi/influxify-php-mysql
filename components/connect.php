<?php

// db configuration (name, password)
$db_name = 'mysql:host=localhost;dbname=shop-bg';
$user_name = 'root';
$user_password = '';

// trying to connect to the db
try {
  $conn = new PDO($db_name, $user_name, $user_password);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

?>