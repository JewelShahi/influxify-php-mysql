<?php

// include 'connect.php';

// session_start();
// session_unset();
// session_destroy();

// header('location:../home.php');

include 'connect.php';

session_start();

// Unset the specific user session variable
unset($_SESSION['user_id']);

// Destroy the entire session
session_destroy();

header('location:../home.php');

?>