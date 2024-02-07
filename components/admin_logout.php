<?php

include 'connect.php';

session_start();

unset($_SESSION['admin_id']);
// session_regenerate_id(true);

session_destroy();

header('location:../admin/admin_login.php');
?>