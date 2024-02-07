<?php

include 'connect.php';

session_name('user_session');
session_start();

unset($_SESSION['user_session']['user_id']);
session_regenerate_id(true);
session_destroy();

header('location:../home.php');
?>