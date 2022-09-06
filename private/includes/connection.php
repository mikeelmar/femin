<?php
    $db_host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "femin_db";

    // Create connection
    $conn = mysqli_connect($db_host, $db_username, $db_password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection to Database Failed: ". $conn->connect_error);
    }
?>