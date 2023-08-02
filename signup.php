<?php
// db connection
include 'backend/db_connection.php';

$fullname = "";
$email = "";
$err = array();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $password = $_POST['password'];

  // Check if user already exists
  $user_check_query = "SELECT * FROM `user` WHERE email='$email' LIMIT 1";
  $result = mysqli_query($con, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) {
    // User already exists

    echo '<script> alert("User with this email already exists! Please login!"); window.location.href = "login.php"; </script>';
    // header('location:login.php');
  } else if (strlen($password) < 6) {

    echo '<script> alert("Password should not be less than 6 digit!"); window.location.href = "signup.php"; </script>';
  } else {
    // Hash the password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO `user` (name, email, password) VALUES ('$fullname', '$email', '$hash')";
    mysqli_query($con, $query);

    echo '<script> alert("You are successfully registered! Please login!"); window.location.href = "login.php"; </script>';
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
    <nav class="flex py-3 z-20 justify-between rounded-md bg-opacity-80 backdrop-blur-md sticky top-2 bg-white px-7">
      <h1 class="font-bold text-xl">Recipe</h1>
      <ul class="flex justify-between space-x-6 items-center">
        <a href="login.php" class="bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500">Login</a>
      </ul>
    </nav>
    <div class="w-full">
      <div class="bg-white flex flex-col max-w-sm mx-auto mt-20 p-3 rounded-md">
        <h1 class="text-center pt-3 pb-4 text-xl font-bold tracking-wide">
          Create your account
        </h1>
        <form class="flex flex-col pb-6" action="" method="POST">
          <input name="fullname" class="bg-gray-100 my-2 p-3 px-4 rounded-md placeholder:text-gray-600 placeholder:text-sm outline-none" type="text" placeholder="Full name" />

          <input name="email" class="bg-gray-100 my-2 p-3 px-4 rounded-md placeholder:text-gray-600 placeholder:text-sm outline-none" type="email" placeholder="Email" />
          <input name="password" class="bg-gray-100 my-2 p-3 px-4 rounded-md placeholder:text-gray-600 placeholder:text-sm outline-none" type="password" placeholder="Password" />
          <button name="signup" class="bg-green-500 my-2 tracking-wide hover:bg-green-600 text-white font-medium p-3 px-4 rounded-md">
            Create
          </button>
        </form>
      </div>
    </div>
  </div>
</body>

</html>