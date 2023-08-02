<?php
session_start();
if(!isset($_SESSION['email'])){
  header('location: ../login.php' );
  echo "you have to login first";
}

if ($_SESSION['admin'] == 0){
  header("Location: ../index.php");
}
$con = mysqli_connect('localhost','root','','recipe_db');

?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="alpine.js"></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<title>Manage Category</title>
	<link rel="stylesheet" type="text/css" href="sss/style.css">

</head>
<body>
<nav>
    <div class="container">
        <!-- <button class="btn btn-primary m-5"><a href="upload_recipes.php" class="text-light">Upload recipe</a></button> -->
    </nav>
          <!-- Navbar-->
          <nav class="flex  py-3 z-20 justify-between rounded-md bg-opacity-80 backdrop-blur-md sticky top-2 bg-white px-7">
        <h1 class="font-bold text-xl">Recipe</h1>
        <ul class="flex justify-between space-x-6   items-center">
          <!-- <a href="admin_panel.php" class="text-gray-700 ">Home</a> -->
          <!-- <a href="#recipe" class="text-gray-700 ">Recipes</a> -->

            <a
              href='admin_panel.php'
              class='bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500'
              >Manage User</a>
              <a
            href="recipes_view.php"
            class="bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500"
            >Manage Recipe</a>
            <a>
            
            <a
            href="../logout.php"
            class="bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500"
            >Logout</a>
           <!--<a href="#" class="text-gray-700 ">Menu</a> -->
          <!-- <a  href="login.php" class=" bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500 ">Login</a> -->
          <!-- <a href="signup" class="text-gray-700 ">Signup</li> -->
        </ul>
      </nav>
    <div class="container">
    <!-- <button class="btn btn-primary my-5"><a href="sigup.php" class="text-light">Add user</a></button> -->
    <table class="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">category</th>
                <th scope="col">Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php

$sql="select * from `category`";
$result=mysqli_query($con,$sql);
if($result){
    while($row=mysqli_fetch_assoc($result)){
        $Id=$row['id'];
        $Category=$row['name'];
        echo'
            <tr>
                <th scope="row">'.$Id.'</th>
                <td>'. $Category.'</td>

                <td>
                <button class="btn btn-primary"><a href="manage_category.php?updateid='.$Id.'" class="text-light">Edit</button>
                <button class="btn btn-danger"><a href="manage_category.php?deleteid='.$Id.'" class="text-light">Delete</button>
            </td>
            </tr>



        ';
    }
}     ?>

        </tbody>

    </table>
    
            <button class="btn btn-primary"><a href="add_category.php" class="text-light">Add</button>
            
    </div> 
</body>
</html>