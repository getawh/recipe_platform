<?php
session_start();

if(!isset($_SESSION['email'])){
    header('location: login.php' );
    echo "you have to login first";
}


?>