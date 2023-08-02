<!---required meta tags--->
<?php 
    include 'auth_chek.php';

	$con = mysqli_connect('localhost', 'root', '', 'recipe_db');
	if ($_SESSION['admin'] == 1) {
		header("Location: backend/admin_panel.php");
	}
 
	if(isset($_POST['submit']))
	{
	   $ID=$_SESSION['id'];
	   $recipe_id= 
       $title=mysqli_real_escape_string($con, $_POST['title']);
       $ingredients=mysqli_real_escape_string($con, $_POST['ingredients']);
       $description=mysqli_real_escape_string($con, $_POST['description']);
	   $instructions=mysqli_real_escape_string($con, $_POST['instructions']);
    //    $Method=$_POST['Method'];
	   $food_photo=$_FILES['image'];
       $recipe_video=$_FILES['video'];
	   $serving = $_POST['serving'];
       $timing = $_POST['timing'];
	   $category = $_POST['category'];
	   $image_url = 'd';
	   $video_url = 'd';

//-----------------------------
		$filename = $_FILES["image"]["name"];
		$tempname = $_FILES["image"]["tmp_name"];  
		$folder = "assets/images/".$filename;
		move_uploaded_file($tempname, $folder);
		
		$image_url=$filename;

		$filename1 = $_FILES["video"]["name"];
		$tempname1 = $_FILES["video"]["tmp_name"];  
		$folder1 = "assets/videos/".$filename1;
		move_uploaded_file($tempname1, $folder1);

		$video_url=$filename1;

//-----------------------
	   

       $sql="insert into recipe (title,prepare_time, cook_time, Ingredient,category_id, description, instructions, image, video, user_id)
       values('$title','$serving','$timing','$ingredients','$category','$description','$instructions','$image_url','$video_url','$ID')";

       $result=mysqli_query($con,$sql);

       if($result){
	   echo '<script> alert("Recipe added successfully!"); window.location.href = "index.php"; </script>';

       }
       else{
        die(mysqli_error($con));
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
	<title>recipe upload page</title>
	<link rel="stylesheet" type="text/css" href="admin.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<nav class="flex  py-3 z-20 justify-between rounded-md bg-opacity-80 backdrop-blur-md sticky top-2 bg-white px-7">
        <h1 class="font-bold text-xl">Recipe</h1>
        <ul class="flex justify-between space-x-6   items-center">
          <a href="index.php" class="text-gray-700 ">Home</a>
          <a href="#recipe" class="text-gray-700 ">Recipes</a>
            <a
            href="userpage.php"
            class="bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500"
            >Profile</a>
            
            <a
            href="logout.php"
            class="bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500"
            >Logout</a>
           <!--<a href="#" class="text-gray-700 ">Menu</a> -->
          <!-- <a  href="login.php" class=" bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500 ">Login</a> -->
          <!-- <a href="signup" class="text-gray-700 ">Signup</li> -->
        </ul>
      </nav>

	<header class=" center-div ">
		<div class="container center-div shadow">
			<div class="heading text-center text-upper-case text-white">Upload To Recipe</div>
        <div class="container row d-flex flex-row justify-content mb-5 " style="justify-content:center; margin-top:3em;">
          <div class="admin-form" >
			<form action="" method="POST" enctype="multipart/form-data">
              <div class="form-grop">
			  <label>Title</label>
				<input type="text" name="title" value="" class="form-control" autocomplete="off" required>
			  </div>
			  <div class="form-grop">
				<label>Description</label>
				<textarea  rows="5" cols="40"  name="description" value="" class="form-control" autocomplete="off" required></textarea>
			  </div>
			  <div class="form-grop">
				<label>Ingredients</label>
				<textarea  rows="5" cols="40" name="ingredients" value="" class="form-control" autocomplete="off" required></textarea>
			  </div>
			  <div class="form-grop">
				<label>Instructions</label>
				<textarea  rows="5" cols="40" name="instructions" value="" class="form-control" autocomplete="off" required></textarea>
			  </div>
			<div class="form-grop">
			  <label>Serving</label>
				<input type="number" name="serving" value="" class="form-control" autocomplete="off" required>
			  </div>
			  <div class="form-grop">
			  <label for='timing'>Timing</label>
				<input type="number" name="timing" value="" class="form-control" autocomplete="off" required>
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
			  <!-- <div>
			  <label for='category'>Category</label>
				<input type="text" name="category" value="" class="form-control" autocomplete="off">
			  </div> -->
			  <div class="form-grop">
				<label>Food Image</label>
				<input type="file" name="image" value="" class="form-control" plaseholder="upload image" autocomplete="off" required>
			  </div>
              <div class="form-grop">
				<label>Recipe Video</label>
				<input type="file" name="video" value="" class="form-control" plaseholder="upload video" autocomplete="off" required>
			  </div>
			  <button type="submit" class="bg-green-500 w-full mt-3 my-2 hover:bg-green-600 text-white font-medium p-3 px-4 rounded-md" name="submit">Save</button>
			</form>
          </div>
		</div>
		</div>
	</header>
	
</body>
</body>
</html>