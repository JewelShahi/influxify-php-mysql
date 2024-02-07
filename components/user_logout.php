<?php

include 'connect.php';


session_start();

// Unset the specific user session variable
unset($_SESSION['user_session']['user_id']);

session_destroy();

header('location:../home.php');
?>