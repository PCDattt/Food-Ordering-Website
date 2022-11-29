<?php
    session_start();
    
    define('SITEURL', 'http://localhost:8080/food_order/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'food_order');
    
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD);
    if(!$conn){
        die("connection failed: " . mysqli_connect_error());
    }

    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));
?>