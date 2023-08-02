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
                <th scope="col">Operation</th>
            </tr>
        </thead>
        <tbody>
    <?php

$sql="select * from `user_comments`";
$result=mysqli_query($con,$sql);
if($result){
    while($row=mysqli_fetch_assoc($result)){
        $id=$row['id'];
        $date=$row['date'];
        $message=$row['message'];
        echo'
            <tr>
                <th scope="row">'.$id.'</th>
                <td>'.$date.'</td>
                <td>'.$message.'</td>
                <td>
                <button class="btn btn-danger"><a href="manage_comment.php?deleteid='.$id.'" class="text-light">Delete</button>
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