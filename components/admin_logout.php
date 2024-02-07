<?php

include 'connect.php';

session_name('admin_session');
session_start();

// Unset the specific admin session variable
unset($_SESSION['admin_session']['admin_id']);
session_regenerate_id(true);

session_destroy();

header('location:../admin/admin_login.php');
?>