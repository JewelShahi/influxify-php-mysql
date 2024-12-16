<?php

include 'connect.php';

session_start();

unset($_SESSION['admin_id']);
session_destroy();
// session_regenerate_id(true);

header('location:../admin/admin_login.php');
?>