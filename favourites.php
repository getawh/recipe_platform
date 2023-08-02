<?php
 session_start();
$con = mysqli_connect('localhost','root','','recipe_db');

 if(isset($_GET['delete_id'])){
  $delete_id= $_GET['delete_id'];
  $sql = "DELETE FROM user_favorite WHERE id=".$delete_id;
  $result = mysqli_query($con, $sql);
  if($result){
    echo '<script> alert("Recipe removed from favourites!"); window.location.href = "favourites.php?id='.$_SESSION['id'].'"; </script>';
  }else{
    die(mysqli_error($con));
  }
 }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />

    <!-- <link rel="stylesheet" href="style.css" /> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="alpine.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vite App</title>
  </head>

  <body class="bg-white w-screen h-screen p-2">
    <div class="max-w-6xl mx-auto">
      <!-- Navbar-->
      <nav
        class="flex py-3 z-20 justify-between rounded-md bg-opacity-80 backdrop-blur-md sticky top-2 bg-white px-7"
      >
        <h1 class="font-bold text-xl">Recipe</h1>
        <ul class="flex justify-between space-x-6 items-center">
          <li><a href="index.php" class="text-gray-700">Home</a></li>
          <!-- <li><a href="recipes.php" class="text-gray-700">Recipes</a></li> -->
          <li>
            <!-- <a
              href="login.html"
              class="bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500"
              >Login</a> -->
          </li>
        </ul>
      </nav>
      <div>
        <h1 class="text-lg text-right mr-10 mt-4 font-bold text-gray-900">
          Saved Recipes
        </h1>
        <div class="mx-auto mt-6">
          <ul class="flex flex-col space-y-4">

          <?php
            $user_id = $_GET['id'];
            $sql = "SELECT * FROM user_favorite WHERE user_id=".$user_id;
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  $recipe_id = $row['recipe_id'];
                  $fav_id=$row['id'];
                  $recipe = "SELECT * FROM recipe  WHERE id=".$recipe_id;
                  $recipe_result = mysqli_query($con, $recipe);
                  $recipe_result_list = mysqli_fetch_assoc($recipe_result);
                  $title = $recipe_result_list['title'];
                  $description = $recipe_result_list['description'];
                  $image = $recipe_result_list['image'];

                  echo '<li class="max-w-3xl border h-40 p-3 rounded-md mx-auto">
                  <div class="flex">
                      <div>
                          <h1 class="font-bold text-xl">'.$title.'</h1>
                          <p>'.$description.'</p>
  
                          <a href="favourites.php?delete_id='.$fav_id.'"name = "remove" class="mt-3 bg-red-200 hover:bg-red-300 p-2 px-4 rounded-md text-sm text-red-900 font-bold">Remove</a>
  
                      </div>
                      <div class="h-36 w-full p-2">
                          <img class="w-full h-full rounded-md object-cover" src="assets/images/'.$image.'" alt="'.$image.'" />
                      </div>
                  </div>
                  </li>';
                  }
                }
              ?>


            

          </ul>
        </div>
      </div>
    </div>
  </body>
</html>
