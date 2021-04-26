<?php

session_start();

// Include functions and connects to database using PDO MySQL
include 'functions.php';
$pdo = pdo_connect_mysql();

// Page is set to products.php by default
$page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'products';


include $page . '.php';
