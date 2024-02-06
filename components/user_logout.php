<?php

include 'connect.php';

session_name('user_session');

session_start();

// Unset the specific user session variable
unset($_SESSION['user_session']['user_id']);

session_destroy();

session_regenerate_id(true);

header('location:../home.php');
?>