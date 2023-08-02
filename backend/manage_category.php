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

if(isset($_GET['deleteid'])){
    $id=$_GET['deleteid'];

	$sql2 = "delete from `recipe_category` where category_id=$id";
    $sql="delete from `category` where id=$id";
    $result=mysqli_query($con,$sql2);
    $result=mysqli_query($con,$sql);

    if($result){
		echo '<script> alert("Category deleted successfully!"); window.location.href = "view_category.php"; </script>';

    }
    else{
        die(mysqli_error($con));
    }
}

//update recipe
if(isset($_GET['updateid'])){
    $id=$_GET['updateid'];
    $sql="select * from category where id=".$id;
    $result=mysqli_query($con,$sql);
    $row=mysqli_fetch_assoc($result);
    $Category=$row['name'];

    if(isset($_POST['submit'])){
        $category=$_POST['title'];
        $sql="update category set name = '$category' where id=".$id;

       $result=mysqli_query($con,$sql);
       if($result){
		echo '<script> alert("Category updated successfully!"); window.location.href = "view_category.php"; </script>';

       }else{
        die(mysqli_error($con));
       }
    }

}

?>

<!DOCTYPE html>
<html>
<head>
	<script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="alpine.js"></script>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>recipe admin page</title>
	<link rel="stylesheet" type="text/css" href="admin.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<nav class="flex  py-3 z-20 justify-between rounded-md bg-opacity-80 backdrop-blur-md sticky top-2 bg-white px-7">
        <h1 class="font-bold text-xl">Recipe</h1>
        <ul class="flex justify-between space-x-6   items-center">

            <a
            href="admin_panel.php"
            class="bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500"
            >Manage User</a>
            <a
            href="recipes_view.php"
            class="bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500"
            >Manage Recipe</a>
            <a
            href="../logout.php"
            class="bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500"
            >Logout</a>

        </ul>
      </nav>

        <div class="container row d-flex flex-row justify-content mb-5 " style="justify-content:center; margin-top:3em;">
          <div class="admin-form ">
		  <form action="" method="POST">
              <div class="form-grop">
			  <label>Category Name</label>
				<input type="text" name="title" value="<?php echo $Category ?>" class="form-control" autocomplete="off" required>
			  </div>
			  <button type="submit" class="bg-green-500 my-2 hover:bg-green-600 text-white font-medium p-3 px-4 rounded-md" name="submit">Save</button>
			</form>
          </div>
		</div>
		</div>
	
</body>
</body>
</html>
