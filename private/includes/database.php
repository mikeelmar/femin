<?php

    // Create database
    $sqlCreateDatabase = "CREATE DATABASE IF NOT EXISTS `$db_name`";
    if($conn->query($sqlCreateDatabase)===TRUE){
        echo '<script>console.log("Database successfully created")</script>';
    } else{
        echo '<script>alert("Error creating database"</script>';
    }

    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    // Create Table
    $sqlCreateTable = "CREATE TABLE IF NOT EXISTS `tbl_accounts` (
        `last_name` varchar(255) not null,
        `first_name` varchar(255) not null,
        `middle_name` varchar(255) not null,
        `birthday` date not null,
        `address` varchar(255) not null,
        `gender` varchar(255) not null,
        `civil_status` varchar(255) not null,
        `phone_number` varchar(255) not null,
        `email` varchar(255) not null,
        `username` varchar(255) not null primary key,
        `password` varchar(255) not null
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    
    if($conn->query($sqlCreateTable)===TRUE){
        echo '<script>console.log("Table successfully created")</script>';
    } else{
        echo '<script>alert("Error creating table"</script>';
    }
