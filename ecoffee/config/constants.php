<?php
    //start session
    session_start();


    //create constants
    define('SITEURL', 'http://localhost/Koding/ecoffee/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'ecoffee');

    
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());//db connection
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());//selecting db

?>