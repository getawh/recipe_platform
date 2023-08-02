<?php

include 'auth_chek.php';
$con = mysqli_connect('localhost','root','','recipe_db');

if ($_SESSION['admin'] == 1){
  header("Location: backend/admin_panel.php");
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

  <body class="bg-gray-50 w-screen h-screen p-2">
    <div class="max-w-6xl mx-auto">
      <!-- Navbar-->
      <nav class="flex  py-3 z-20 justify-between rounded-md bg-opacity-80 backdrop-blur-md sticky top-2 bg-white px-7">
        <h1 class="font-bold text-xl">Recipe</h1>
        <ul class="flex justify-between space-x-6   items-center">
          <a href="index.php" class="text-gray-700 ">Home</a>
          <a href="favourites.php?id=<?php echo $_SESSION['id'] ?>" class="text-gray-700 ">Saved</a>
          <?php
            // error_reporting(E_ALL ^ E_WARNING); 
            $email = $_SESSION['email'];
            $sql = "SELECT * FROM user WHERE email = '".$email."'"; 
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            if ($row['status']=='VERIFIED'){
              echo "<a
              href='upload.php'
              class='bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500'
              >Upload recipe</a>";
            }
            

            ?>
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
      <div class="flex flex-col h-full">
        <!-- Top Container with background image-->
        <div class="rounded-md h-60 mt-3 relative flex justify-center" style="background-image: url('assets/images/cover.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center;">
          <!-- Search Bar in top div-->
          <div class="absolute bottom-3">
            <h1 class="text-center mb-3 text-xl rounded-md bg-black bg-opacity-30 p-2 text-white">What would you like to cook?</h1>
           <form action="" method="POST">
           <input class="p-2 px-6 rounded-l-md" name = "search_key" type="text" placeholder="Search recipe">
            <button name="search" class="p-2 px-6 hover:bg-green-400 bg-green-500 transition-all text-white font-semibold rounded-r-md ml-1">Search</button>
          </form>
          </div>
        </div>
        
        <div class=" h-64 mt-6">
          <!-- Bottom Div with  three row -->

          <section class="recipe" id="recipe">
          <div class="flex justify-center">
            <ul class="flex mx-auto flex-wrap justify-center  ">
              <?php

              $search = isset($_POST['search']) ? mysqli_real_escape_string($con, $_POST['search_key']) : '';
              $sql = "SELECT * FROM recipe";
              if ($search !== '') {
                  $sql .= " WHERE title LIKE '%$search%' OR Ingredient LIKE '%$search%'";
                  
                  $result = mysqli_query($con, $sql);
                  
                  // Generate the options from the fetched data
                  while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                      $name = $row['title'];
                      $imagePath = $row['image'];
              
                      // Generate dynamic HTML for each recipe item
                      echo '<li class="mx-8 flex flex-col space-y-2 bg-white py-4 px-6 rounded-lg">';
                      echo "<h1 class='text-center font-medium tracking-wide'>".$name."</h1>";
                      echo "<img class='h-40 w-60 object-cover rounded-lg' src='/assets/images/".$imagePath."' alt='".$name."'>";
                      echo "<a href='recipe.php?id=$id' class='bg-green-200 text-green-900 hover:bg-green-400 mt-4 p-2 rounded-md text-sm font-bold tracking-wider transition-all hover:text-white'>View Recipe</a>";
                      echo '</li>';
                  }
                }else{

                  //-------------------------------------------------/
                    $sql = "SELECT * FROM recipe";
                    $result = mysqli_query($con, $sql);
    
                    if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                          $id = $row['id'];
                          $name = $row['title'];
                          $imagePath = $row['image'];
                  
                          // Generate dynamic HTML for each recipe item
                          echo '<li class="mx-8 flex flex-col space-y-2 bg-white py-4 px-6 rounded-lg">';
                          echo "<h1 class='text-center font-medium tracking-wide'>".$name."</h1>";
                          echo "<img class='h-40 w-60 object-cover rounded-lg' src='/assets/images/".$imagePath."' alt='".$name."'>";
                          echo "<a href='recipe.php?id=$id' class='bg-green-200 text-center text-green-900 hover:bg-green-400 mt-4 p-2 rounded-md text-sm font-bold tracking-wider transition-all hover:text-white'>View Recipe</a>";
                          echo '</li>';
                      }
                    }
                    //-------------------------------------------------/
                }
              ?>
            </ul>
          </div>
        </div>
      </div>
      </section>
    </div>
  </body>
</html>