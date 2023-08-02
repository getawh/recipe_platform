<?php
include 'auth_chek.php';

if ($_SESSION['admin'] == 1) {
  header("Location: backend/admin_panel.php");
}

$con = mysqli_connect('localhost', 'root', '', 'recipe_db');

if (isset($_GET['save'])) {
  $recipe_id = $_GET['save'];
  $user_id = $_SESSION['id'];
  $sql = "INSERT INTO user_favorite (user_id,recipe_id) values ($user_id,$recipe_id)";

  $result = mysqli_query($con, $sql);
  if ($result) {
    echo '<script> alert("Recipe saved to favourite!");  window.location.href = "recipe.php?id=' . $recipe_id . '"; </script>';
  } else {
    die(mysqli_error($con));
  }
}
if (isset($_GET['delete'])) {
  $recipe_id = $_GET['delete'];
  $user_id = $_SESSION['id'];
  $sql = "DELETE FROM recipe WHERE id=" . $recipe_id;
  $result = mysqli_query($con, $sql);
  if ($result) {
    echo '<script> alert("Recipe deleted successfully!"); window.location.href = "index.php"; </script>';
  } else {
    die(mysqli_error($con));
  }
}

if (isset($_POST['cmnt'])) {
  $comment = mysqli_real_escape_string($con, $_POST['comment']);

  $user_id = $_SESSION['id'];
  $recipe_id = $_GET['id'];

  $sql2 = "INSERT INTO comments (user_id,recipe_id,comment) values ($user_id,$recipe_id,'$comment')";
  $result = mysqli_query($con, $sql2);
  if ($result) {
    echo '<script> alert("Comment added!");  window.location.href = "recipe.php?id=' . $recipe_id . '"; </script>';
  } else {
    echo '<script> alert("can not add this comment");  window.location.href = "recipe.php?id=' . $recipe_id . '"; </script>';
    die(mysqli_error($con));
  }
}

$sql = "SELECT * FROM recipe where id = '" . $_GET['id'] . "'";
$result = mysqli_query($con, $sql);
$recipe = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />

  <script src="https://cdn.tailwindcss.com"></script>
  <script type="module" src="alpine.js"></script>

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Vite App</title>
</head>

<body class="bg-white w-screen h-screen p-2">
  <div class="max-w-6xl mx-auto">
    <!-- Navbar-->
    <nav class="flex py-3 z-20 justify-between rounded-md bg-opacity-80 backdrop-blur-md sticky top-2 bg-white px-7">
      <h1 class="font-bold text-xl">Recipe</h1>
      <ul class="flex justify-between space-x-6 items-center">
        <a href="index.php" class="text-gray-700">Home</a>
        <a href="index.php#recipe" class="text-gray-700">Recipes</a>

        <a href="logout.php" class=" bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500 ">Logout</a>

      </ul>
    </nav>

    <section id="recipe1">
      <div class="flex flex-col h-full pb-6">
        <div class="rounded-md h-[25rem] mt-3 relative flex border border-gray-100">
          <div class="flex-1 w-[50%] p-4">
            <h1 class="text-xl font-medium mb-3" name="title"><?php echo  $recipe['title'] ?></h1>
            <p class="break-all text-gray-700" name="Description"><?php echo  $recipe['description'] ?>
            </p>
            <div class="flex flex-col justify-start">
              <div class="flex space-x-4 mt-4">
                <p class="font-bold">
                  Serving: <span class="font-medium"><?php echo  $recipe['prepare_time'] ?></span>
                </p>
                <p class="font-bold">
                  Timing: <span class="font-medium"><?php echo  $recipe['cook_time'] ?></span>
                </p>
                <p class="font-bold">
                  Category: <span class="font-medium"><?php
                                                      $sql = "SELECT * FROM category where id = '" . $recipe['category_id'] . "'";
                                                      $result = mysqli_query($con, $sql);
                                                      $category = mysqli_fetch_assoc($result);
                                                      echo  $category['name'] ?></span>
                </p>
              </div>
              <div>

              </div>
              <a href="recipe.php?save=<?php echo  $recipe['id'] ?>" class="bg-green-500 p-2 px-2 text-center hover:bg-green-600 rounded-md mt-4 w-24 text-sm font-bold text-white tracking-wide">
                Save
              </a>
              <a href="recipe.php?delete=<?php echo  $recipe['id'] ?>" class="mt-3 bg-red-200 hover:bg-red-300 p-2 px-2 text-center rounded-md w-24 text-sm text-red-900 font-bold  tracking-wide">
                Delete

              </a>

            </div>
          </div>
          <div class="w-5/12 p-4">

            <video controls>
              <source src="assets/videos/<?php echo  $recipe['video'] ?>" type="video/mp4">
              Your browser does not support the video tag.
            </video>

          </div>
        </div>
        <div class="mt-6 flex space-x-3">
          <div class="bg-white  border-green-300 w-2/3 p-3 rounded-md">
            <h1 class="font-bold text-lg text-gray-800" name="Ingredients">Ingredients</h1>
            <p><?php echo $recipe['Ingredient'] ?></p>
          </div>
          <div class="border p-3 rounded-md  border-green-200">
            <h1 class="font-bold text-lg text-gray-800 " name="methods">Steps/Methods</h1>

            <p class="my-3"><?php echo $recipe['instructions'] ?> </p>




          </div>
        </div>
        <div class="mt-10 flex-col space-x-3 border p-3 rounded-md  border-green-200">
          <h1 class="mb-4 font-bold text-lg text-gray-800 " name="comment">Comments</h1>
          <?php
          $sql5 = "SELECT * FROM comments where recipe_id = '" . $_GET['id'] . "'";
          $result5 = mysqli_query($con, $sql5);
          while ($row = mysqli_fetch_assoc($result5)) {
            $user_id = $row['user_id'];
            $comment_id = $row['id'];

            $sql6 = "SELECT * FROM user where id = '" . $user_id . "'";
            $result6 = mysqli_query($con, $sql6);
            $row2 = mysqli_fetch_assoc($result6);
            $user_name = $row2['name'];

            $recipe_id = $row['recipe_id'];
            $comment = $row['comment'];
            $date = $row['date'];

            echo '
              <div class="my-3 px-10 flex">
                <div class=" w-4/5 pr-10 space-y-1">

                  <p class="text-green-500"> <b>' . $user_name . '</b> </p>
                  <p>' . $comment . '</p>
                  <p>' . $date . '</p>
                </div>
                ';

            if ($user_id == $_SESSION['id']) {
              echo ' <div class=" min-w-max space-x-2">
                  <a href="comment.php?updateid=' . $comment_id . '&recipeid='.$recipe_id.'"><span class="bg-green-500 text-white px-2 py-1 rounded-md"><b>Edit</b></span></a>
                  <a href="comment.php?deleteid=' . $comment_id . '&recipeid='.$recipe_id.'"><span class="bg-red-500 text-white px-2 py-1 rounded-md"><b>Delete</b></span></a>

                </div>';
            }

            echo ' </div>';
          }
          ?>
          <form action="" method="POST">

            <div class="mt-10 px-10 flex w-2/3 space-x-10 outline-0 items-center">
              <textarea name="comment" id="" cols="60" rows="3" class="border p-3 rounded-md"></textarea>
              <button name="cmnt" class="bg-green-500 text-white px-3 py-1 rounded-md text-center h-fit"><b>comment</b></button>
            </div>

          </form>


        </div>
      </div>
  </div>
  </section>


</body>

</html>