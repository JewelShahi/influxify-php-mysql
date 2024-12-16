<?php

include 'connect.php';

session_start();

// Completely destroy the session data
session_unset();
session_destroy();

header('Location: ../admin/admin_login.php');
