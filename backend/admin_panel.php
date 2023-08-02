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
<!doctype html>
<html lang="en">
    <head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="alpine.js"></script>
        <title> Admin Panel</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

        <link rel="stylesheet" href="sss/style.css">
    </head>
    <body class="bg-gray-50 w-screen h-screen p-2">
    <div class="max-w-6xl mx-auto">
      
      <!-- Navbar-->
    <nav>
    <div class="container">
        <!-- <button class="btn btn-primary m-5"><a href="upload_recipes.php" class="text-light">Upload recipe</a></button> -->
    </nav>
          <!-- Navbar-->
          <nav class="flex  py-3 z-20 justify-between rounded-md bg-opacity-80 backdrop-blur-md sticky top-2 bg-white px-7">
        <h1 class="font-bold text-xl">Recipe</h1>
        <ul class="flex justify-between space-x-6   items-center">

            <a
            href="recipes_view.php"
            class="bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500"
            >Manage Recipe</a>
            <a
            href="view_category.php"
            class="bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500"
            >Manage Categories</a>
            <a
            href="../logout.php"
            class="bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500"
            >Logout</a>

        </ul>
      </nav>
      <div class="container">
    <!-- <button class="btn btn-primary my-5"><a href="sigup.php" class="text-light">Add user</a></button> -->
    <table class="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Full Name</th>
                <th scope="col">Email</th>
                <th scope="col">Password</th>
                <th scope="col">Status</th>
                <th scope="col">Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php

$sql="select * from `user`";
$result=mysqli_query($con,$sql);
if($result){
    while($row=mysqli_fetch_assoc($result)){
        $Id=$row['id'];
        $fullname=$row['name'];
        $email=$row['email'];
        $password=$row['password'];
        $status=$row['status'];


        echo '
            <tr>
                <th scope="row">'.$Id.'</th>
                <td>'. $fullname.'</td>
                <td>'.$email.'</td>
                <td>'.$password.'</td>
                <td>
                <button class="btn btn-danger"><a href="manage_user.php?status='.$status.'&id='.$Id.'" class="text-light">'.$row['status'].'</button>
                </td>
                <td>
                <button class="btn btn-primary"><a href="manage_user.php?updateid='.$Id.'" class="text-light">Edit</button>
                <button class="btn btn-danger"><a href="manage_user.php?deleteid='.$Id.'" class="text-light">Delete</button>
            </td>
            </tr>
        ';
    }
}     ?>
          
        </tbody>
    </table>
    </div> 
    </div>
    </body>
</html>