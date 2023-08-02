<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<title>Admin Login System</title>
	<link rel="stylesheet" type="text/css" href="admin.css">
	<?php 
    include 'db_connection.php';
    ?>
</head>
<body>
    <div class="nav-bar">
    <nav>
    <div class="container">
        <button class="btn btn-primary m-5"><a href="upload_recipes.php" class="text-light">Upload recipe</a></button>
        <a href="user.php" class="btn">User</a>
        <a href="recipes_view.php" class="btn">Manage Recipe</a>
        <a href="admin panel.php" class="btn"></a>
    </nav>
    <div>
        <table class="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Id</th>
                <th scope="col">Date</th>
                <th scope="col">Message</th>
            </tr>
        </thead>
        <tbody>
    <?php

$sql="select * from `comment`";
$result=mysqli_query($con,$sql);
if($result){
    while($row=mysqli_fetch_assoc($result)){
        $id=$row['id'];
        $date_Video=$row['date'];
        $message=$row['message'];
        echo'
            <tr>
                <th scope="row">'.$id.'</th>
                <td>'.$date.'</td>
                <td>'.$message.'</td>
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