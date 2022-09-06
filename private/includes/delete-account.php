<?php
    session_start();
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: ../index.php");
        exit;
    }
    include 'connection.php';
    mysqli_select_db($conn, $db_name);
    
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        $delete_data = mysqli_query($conn, "DELETE FROM tbl_accounts WHERE `username` = '$username'");

        if ($delete_data) {
            $_SESSION = array();
            session_destroy();
            header('location: ../../index.php');
            exit;
        }
        else{
            echo "Failed to Delete Account" .mysqli_connect_errno();
        }
    }
?>