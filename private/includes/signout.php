<?php 
    session_start();
    $_SESSION = array(); //empties all session variables
    session_destroy();
    header('location: ../../index.php');
    exit;  
?>