<?php

// include 'connect.php';

// session_start();
// session_unset();
// session_destroy();

// header('location:../admin/admin_login.php');

include 'connect.php';

session_start();

// Unset the specific admin session variable
unset($_SESSION['admin_id']);

// Destroy the entire session
session_destroy();

header('location:../admin/admin_login.php');

?>