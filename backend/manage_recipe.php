<?php
session_start();
if(!isset($_SESSION['email'])){
	echo '<script> alert("You have to login first!"); window.location.href = "../login.php"; </script>';
}

if ($_SESSION['admin'] == 0){
  header("Location: ../index.php");
}

$con = mysqli_connect('localhost','root','','recipe_db');



if(isset($_GET['deleteid'])){
    $id=$_GET['deleteid'];

	$sql2 = "delete from `recipe_category` where recipe_id=$id";
    $sql="delete from `recipe` where id=$id";
    $result=mysqli_query($con,$sql);
    $result=mysqli_query($con,$sql2);

    if($result){
		echo '<script> alert("Recipe deleted successfully!"); window.location.href = "recipes_view.php"; </script>';
    }
    else{
        die(mysqli_error($con));
    }
}

//update recipe
if(isset($_GET['updateid'])){
$id=$_GET['updateid'];
$sql="select * from `recipe` where id=$id";
$result=mysqli_query($con,$sql);
$row=mysqli_fetch_assoc($result);

$Title=$row['title'];
$Ingredients=$row['Ingredient'];
$Description=$row['description'];
$Instructions=$row['instructions'];
$Recipe_Video=$row['video'];
$Serving = $row['prepare_time'];
$Timing = $row['cook_time'];
$image_url = 'd';
$video_url = 'd';

    if(isset($_POST['submit']))
	{
		$title=mysqli_real_escape_string($con, $_POST['title']);
		$ingredients=mysqli_real_escape_string($con, $_POST['ingredients']);
		$description=mysqli_real_escape_string($con, $_POST['description']);
		$instructions=mysqli_real_escape_string($con, $_POST['instructions']);
		$serving = $_POST['serving'];
		$timing = $_POST['timing'];
		$Image_url = '';
		$Video_url = '';

		// Image Upload
		if (isset($_FILES['image']) && $_FILES['image']['name'] != '')  {
			$image_name = $_FILES['image']['name'];
			$image_tmp_name = $_FILES['image']['tmp_name'];
			$image_folder = '../assets/images';
			
			$image_url = $image_folder . $image_name;

			if (move_uploaded_file($image_tmp_name, $image_url)) {
				// Image uploaded successfully, continue with other data update
				$Image_url = $image_url;
			} else {
				die("Failed to upload the image.");
			}
		}

		// Video Upload
		if (isset($_FILES['video']) && $_FILES['video']['name'] != '')  {
			$video_name = $_FILES['video']['name'];
			$video_tmp_name = $_FILES['video']['tmp_name'];
			$video_folder = 'uploads/videos/';
			$video_url = $video_folder . $video_name;

			if (move_uploaded_file($video_tmp_name, $video_url)) {
				$Video_url = $video_url;
			} else {
				die("Failed to upload the video.");
			}
		}
 
		$sql = "UPDATE recipe SET
		title='$title',
		prepare_time='$serving',
		cook_time='$timing',
		Ingredient='$ingredients',
		description='$description',
		instructions='$instructions',
		image='$Image_url',
		video='$Video_url'
		WHERE id=$id";

       $result=mysqli_query($con,$sql);

       if($result){
		echo '<script> alert("Recipe updated successfully!"); window.location.href = "recipes_view.php"; </script>';
       }
       else{
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
            >Manage user</a>
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

        <div class="container row d-flex flex-row justify-content mb-5 " style="justify-content:center; margin-top:3em;">
          <div class="admin-form ">
		  <form action="" method="POST">
              <div class="form-grop">
			  <label>Title</label>
				<input type="text" name="title" value="<?php echo $Title ?>" class="form-control" autocomplete="off">
			  </div>
			  <div class="form-grop">
				<label>Description</label>
				<textarea  rows="5" cols="40"  name="description"  class="form-control" autocomplete="off" ><?php echo $Description ?></textarea>
			  </div>
			  <div class="form-grop">
				<label>Ingredients</label>
				<textarea  rows="5" cols="40" name="ingredients"  class="form-control" autocomplete="off"><?php echo $Ingredients ?></textarea>
			  </div>
			  <div class="form-grop">
				<label>Instructions</label>
				<textarea  rows="5" cols="40" name="instructions" class="form-control" autocomplete="off"><?php echo $Instructions ?></textarea>
			  </div>
			<div class="form-grop">
			  <label>Serving</label>
				<input type="text" name="serving" value="<?php echo $Serving ?>" class="form-control" autocomplete="off">
			  </div>
			  <div class="form-grop">
			  <label for='timing'>Timing</label>
				<input type="text" name="timing" value="<?php echo $Timing ?>" class="form-control" autocomplete="off">
			  </div>
			  <div class="form-grop" >
			  <label for='category'>Category</label>

				  <select name="category" id="category" required>
				  <?php 
					  $sql = "SELECT * FROM category";
					  $result = mysqli_query($con, $sql);
					  while ($row = mysqli_fetch_assoc($result)) {
					  echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
					}
				  ?>
				  </select>
			  </div>
			  <div class="form-grop">
				<label>Food Image</label>
				<input type="file" name="image" value="<?php echo $image ?>" class="form-control" placeholder="upload image" autocomplete="off" required>
			  </div>
              <div class="form-grop">
				<label>Recipe Video</label>
				<input type="file" name="video" value="<?php echo $video ?>" class="form-control" placeholder="upload video" autocomplete="off" required>
			  </div>
			  <button type="submit" class="bg-green-500 my-2 hover:bg-green-600 text-white font-medium p-3 px-4 rounded-md" name="submit">Save</button>
			</form>
          </div>
		</div>
		</div>
	
</body>
</body>
</html>