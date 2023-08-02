<?php

include 'db_connection.php';

if(isset($_GET['deleteid'])){
    $id=$_GET['deleteid'];

    $sql="delete from `recipes` where id=$id";
    $result=mysqli_query($con,$sql);

    if($result){
        echo "deleted successfully";
        header('location:comment_view.php');
    }
    else{
        die(mysqli_error($con));
    }
} 
