<!---required meta tags--->
<?php 
    include("db_connection.php");
 
	if(isset($_POST['submit']))
	{
       $Title=$_POST['Title'];
       $Ingredients=$_POST['Ingredients'];
       $Description=$_POST['Description'];
       $Method=$_POST['Method'];
       $Recipe_Video=$_FILES['video'];
	   $video_size=$_FILES['video']['size'];

	   $error=$_FILES['video']['error'];
	   if($error === 0){
		 if($video_size > 125000){
			$em = "sorry, your file is too large.";
			header("Location: recipes_view.ph?error=$em");
		 }
		 else{
            echo "note more than 4mb";
		 }
	   }

       $sql="insert into `recipes`(Title, Ingredients, Description, video)
       values('$Title','$Ingredients','$Description','$Recipe_Video')";

       $result=mysqli_query($con,$sql);

       if($result){
        //echo "Data inserted successfully";
		header('location:recipes_view.php');
       }
       else{
        die(mysqli_error($con));
       }
    }
    ?> 
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>recipe admin page</title>
	<link rel="stylesheet" type="text/css" href="admin.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<header>
		<div class="container center-div shadow">
			<div class="heading text-center text-upper-case text-white">Upload To Recipe List</div>
        <div class="container row d-flex flex-row justify-content mb-5">
          <div class="admin-form">
			<form action="" method="POST">
              <div class="form-grop">
			  <label>Title</label>
				<input type="text" name="Title" value="" class="form-control" autocomplete="off">
			  </div>
			  <div class="form-grop">
				<label>Ingredients</label>
				<input type="text" name="Ingredients" value="" class="form-control" autocomplete="off">
			  </div>
              <div class="form-grop">
				<label>Description</label>
				<input type="text" name="Description" value="" class="form-control" autocomplete="off">
			  </div>
              <div class="form-grop">
				<label>Recipe Video</label>
				<input type="file" name="Video" value="" class="form-control" plaseholder="upload file" autocomplete="off">
			  </div>
			  <button type="submit" class="btn btn-success" name="submit">Save</button>
			</form>
          </div>
		</div>
		</div>
	</header>
	
</body>
</body>
</html>