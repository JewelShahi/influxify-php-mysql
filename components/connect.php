<?php

$db_name = 'mysql:host=localhost;dbname=shop_db';
$user_name = 'root';
$user_password = '';

try {
  $conn = new PDO($db_name, $user_name, $user_password);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

?>