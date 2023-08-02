<?php
include 'auth_chek.php';

if ($_SESSION['admin'] == 1) {
  header("Location: backend/admin_panel.php");
}
$con = mysqli_connect('localhost', 'root', '', 'recipe_db');

if (isset($_GET['deleteid'])) {
  $recipe_id = $_GET['recipeid'];
  $id = $_GET['deleteid'];

  $sql = "delete from `comments` where id=$id";
  $result = mysqli_query($con, $sql);

  if ($result) {
    echo '<script> alert("Comment deleted successfully!");  window.location.href = "recipe.php?id=' . $recipe_id . '"; </script>';
  } else {
    die(mysqli_error($con));
  }
}

//update recipe
if (isset($_GET['updateid'])) {
  $recipe_id = $_GET['recipeid'];
  $id = $_GET['updateid'];
  $sql = "select * from comments where id=" . $id;
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_assoc($result);
  $Comment = $row['comment'];

  if (isset($_POST['submit'])) {
    $comment = $_POST['comment'];
    $sql = "update comments set comment = '$comment' where id=" . $id;

    $result = mysqli_query($con, $sql);
    if ($result) {
      echo '<script> alert("Comment updated successfully!"); window.location.href = "recipe.php?id=' . $recipe_id . '"; </script>';
    } else {
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
  <title>Edit comment</title>
  <link rel="stylesheet" type="text/css" href="admin.css">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
  <nav class="flex py-3 z-20 justify-between rounded-md bg-opacity-80 backdrop-blur-md sticky top-2 bg-white px-7">
    <h1 class="font-bold text-xl">Recipe</h1>
    <ul class="flex justify-between space-x-6 items-center">
      <a href="index.php" class="text-gray-700">Home</a>
      <a href="index.php#recipe" class="text-gray-700">Recipes</a>

      <a href="logout.php" class=" bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500 ">Logout</a>

    </ul>
  </nav>

  <div class="container row d-flex flex-row justify-content mb-5 " style="justify-content:center; margin-top:3em;">
    <div class="admin-form ">
      <h1 class="text-lg font-bold text-grayy-800 mb-3">Edit comment</h1>
      <form action="" method="POST">
        <div class="flex form-grop">

          <textarea name="comment" id="" cols="60" rows="3" class="border p-3 rounded-md"><?php echo $Comment ?></textarea>

        </div>
        <button type="submit" class="bg-green-500 my-2 hover:bg-green-600 text-white font-medium p-3 px-4 rounded-md" name="submit">Edit</button>
      </form>
    </div>
  </div>
  </div>

</body>
</body>

</html>