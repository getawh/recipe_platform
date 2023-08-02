<?php

session_start();

if(isset($_SESSION['email'])){

   unset($_SESSION['email']);	
   unset($_SESSION['password']);	
   unset($_SESSION['fullname']);	
   unset($_SESSION['admin']);	

}

header('location: login.php')

?>