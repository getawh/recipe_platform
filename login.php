<?php
include 'backend/db_connection.php';
if(isset($_SESSION['email'])){
  if ($_SESSION['admin'] == 0){
    header("Location: index.php");
  }else{
    header("Location: backend/admin_panel.php");
  }
}


$username="";
$password="";
$err="";

if(isset($_POST['LOGIN'])){

    if (isset($_POST['LOGIN'])) {
      $email = mysqli_real_escape_string($con, $_POST['email']);
      $password = mysqli_real_escape_string($con, $_POST['password']);
  
      $sql = "SELECT * FROM user WHERE email = '" . $email . "' LIMIT 1";
      $result = mysqli_query($con, $sql);
  
      if (mysqli_num_rows($result) == 1) {
          $user = mysqli_fetch_assoc($result);
          if (password_verify($password, $user['password'])) {
              // Login successful, set session variables and redirect to dashboard or home page
              $_SESSION['email'] = $user['email'];
              $_SESSION['password'] = $user['password'];
              $_SESSION['fullname'] = $user['name'];
              $_SESSION['id'] = $user['id'];

              if ($user['admin']==0){
                $_SESSION['admin'] = 0;
                header("Location: index.php");

              }else{
                $_SESSION['admin'] = 1;
                header("Location: backend/admin_panel.php");
              }
              exit();
          } else {
              // Login failed, redirect back to login page with an error message
              $_SESSION['login_error'] = "Invalid email or password";
              // $_SESSION['login_error'] = "Invalid email or password";
              header("Location: login.php");
              exit();
          }
      } else {
          // Login failed, redirect back to login page with an error message
          $_SESSION['login_error'] = "Invalid email or password";
          header("Location: login.php");
          exit();
      }



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

  <body class="bg-gray-50 w-screen h-screen p-2">
    <div class="max-w-6xl mx-auto">
      <!-- Navbar-->
      <nav
        class="flex py-3 z-20 justify-between rounded-md bg-opacity-80 backdrop-blur-md sticky top-2 bg-white px-7"
      >
        <h1 class="font-bold text-xl">Recipe</h1>
        <ul class="flex justify-between space-x-6 items-center">
          <!-- <a href="index.php" class="text-gray-700">Home</a> -->
          <!-- <a href="recipe.php" class="text-gray-700">Recipes</a> -->
          <!-- <a href="backend/admin_login.php" class="text-gray-700">Admin</a> -->
          <!-- <a href="#" class="text-gray-700 ">Menu</a> -->
          <a
            href="login.php"
            class="bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500"
            >Login</a
          >
          <!-- <a href="signup" class="text-gray-700 ">Signup</li> -->
        </ul>
      </nav>
      <div class="w-full">
        <div
          class="bg-white flex flex-col max-w-sm mx-auto mt-20 p-3 rounded-md"
        >
          <h1 class="text-center pt-3 pb-4 text-xl font-bold tracking-wide">
            Log in to your account
          </h1>
          <form class="flex flex-col pb-6" action="" method="POST">
            <input name="email" 
              class="bg-gray-100 my-2 p-3 px-4 rounded-md placeholder:text-gray-600 placeholder:text-sm outline-none"
              type="email"
              placeholder="Email" required
            />
            <input name="password" 
              class="bg-gray-100 my-2 p-3 px-4 rounded-md placeholder:text-gray-600 placeholder:text-sm outline-none"
              type="password"
              placeholder="Password" required
            />


            <?php if (isset($_SESSION['login_error'])) : ?>
            <div class="text-center mt-3 text-red-500">
                <?php echo $_SESSION['login_error']; ?>
            </div>
            <?php unset($_SESSION['login_error']); // Clear the error message after displaying it ?>
            <?php endif; ?>

            <button name="LOGIN"
              class="bg-green-500 my-2 hover:bg-green-600 text-white font-medium p-3 px-4 rounded-md"
            >
              Log in
            </button>
          </form>
          <div class="mt-3 flex flex-col">
            <h1 class="text-center mb-2 font-medium text-gray-600">New to Recipe? Create an account.</h1>
            <a href="signup.php"
              class="bg-gray-200 text-center w-full hover:bg-gray-300 text-gray-900 font-medium p-3 px-4 rounded-md"
            >
              Create a new account
          </a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
