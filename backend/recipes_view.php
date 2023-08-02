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
	<title>Admin Login System</title>
	<link rel="stylesheet" type="text/css" href="admin.css">
	
</head>
<body>
    <div class="nav-bar">
    <nav>
    <div class="container">
        <!-- <button class="btn btn-primary m-5"><a href="upload_recipes.php" class="text-light">Upload recipe</a></button> -->
    </nav>
          <!-- Navbar-->
          <nav class="flex  py-3 z-20 justify-between rounded-md bg-opacity-80 backdrop-blur-md sticky top-2 bg-white px-7">
        <h1 class="font-bold text-xl">Recipe</h1>
        <ul class="flex justify-between space-x-6   items-center">
          <!-- <a href="index.php" class="text-gray-700 ">Home</a>
          <a href="#recipe" class="text-gray-700 ">Recipes</a> -->

            <!-- <a
              href='admin_panel.php'
              class='bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500'
              >Home</a> -->
            <!-- <a
            href="userpage.php"
            class="bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500"
            >Profile</a> -->
            <a
              href='admin_panel.php'
              class='bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500 disabled'>
              Manage User
            </a>
            <a
            href="view_category.php"
            class="bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500"
            >Manage Categories</a>
            <a
            href="../logout.php"
            class="bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500">
            Logout
            </a>
           <!--<a href="#" class="text-gray-700 ">Menu</a> -->
          <!-- <a  href="login.php" class=" bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500 ">Login</a> -->
          <!-- <a href="signup" class="text-gray-700 ">Signup</li> -->
        </ul>
      </nav>
    <div>
        <table class="table">
        <thead>
            <tr>
                <th scope="col">S1 no</th>
                <!-- <th scope="col">Recipe_Video</th> -->
                <th scope="col">Title</th>
                <th scope="col">Ingredients</th>
                <th scope="col">Description</th>
                <th scope="col">Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php

$sql="select * from `recipe`";
$result=mysqli_query($con,$sql);
if($result){
    while($row=mysqli_fetch_assoc($result)){
        $id=$row['id'];
        $Recipe_Video=$row['video'];
        $Title=$row['title'];
        $Ingredients=$row['Ingredient'];
        $Description=$row['description'];
        // $Method=$row['Method'];

        echo'
            <tr>
                <th scope="row">'.$id.'</th>
                <td>'.$Title.'</td>
                <td>'.$Ingredients.'</td>
                <td>'.$Description.'</td>
                <td>
                <button class="btn btn-primary"><a href="manage_recipe.php?updateid='.$id.'" class="text-light">Edit</button>
                <button class="btn btn-danger"><a href="manage_recipe.php?deleteid='.$id.'" class="text-light">Delete</button>
            </td>
            </tr>
        ';
    }
}
            ?>
          
        </tbody>
    </table>
    </div> 
</body>
</html>