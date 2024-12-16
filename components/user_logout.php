<?php

include 'connect.php';

session_start();

unset($_SESSION['user_id']);
session_destroy();
// session_regenerate_id(true);

header('location:../home.php');
?>