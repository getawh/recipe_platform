<?php
include 'auth_chek.php';

$con = mysqli_connect('localhost', 'root', '', 'recipe_db');
if (!isset($_SESSION['email'])) {
    if ($_SESSION['admin'] == 1) {
        header("Location: backend/admin_panel.php");
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="alpine.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <title>My Recipe App - User Page</title>
</head>

<body class="">
    <nav class="flex  py-3 z-20 justify-between rounded-md bg-opacity-80 backdrop-blur-md sticky top-2 bg-white px-7">
        <h1 class="font-bold text-xl">Recipe</h1>
        <ul class="flex justify-between space-x-6   items-center">
            <a href="index.php" class="text-gray-700 ">Home</a>
            <a href="#recipe" class="text-gray-700 ">Recipes</a>
            <?php
            error_reporting(E_ALL ^ E_WARNING);
            $email = $_SESSION['email'];
            $sql = "SELECT * FROM user WHERE email = '" . $email . "'";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            if ($row['status'] == 'VERIFIED') {
                echo "<a
              href='upload.php'
              class='bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500'
              >Upload recipe</a>";
            }


            ?>
            <!-- <a
            href="userpage.php"
            class="bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500"
            >Profile</a> -->
            <!--<a href="#" class="text-gray-700 ">Menu</a> -->
            <!-- <a  href="login.php" class=" bg-green-600 px-4 py-1 text-sm font-bold text-white rounded hover:bg-green-500 ">Login</a> -->
            <!-- <a href="signup" class="text-gray-700 ">Signup</li> -->
        </ul>
    </nav>
    <div class="container row d-flex flex-column justify-content mb-5 " style="justify-content:space-around; align-items:center; margin-top:3em; height:20em; ">
        <div class="container row d-flex flex-column justify-content mb-5  " id="user-profile" style='justify-content:space-around; width:50%; height:100%; align-items:center'>



            <!-- Optional: Add more HTML to display user-specific recipe suggestions, grocery list, etc. -->
            <?php
            // $fullname = ['fullname'];
            $email = $_SESSION['email'];

            $sql = "SELECT * FROM user WHERE email = '" . $email . "'";
            $result = mysqli_query($con, $sql);

            // check if any rows were returned
            if (mysqli_num_rows($result) !== 0) {
                // loop through the rows and display the user information
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<h1><b>Welcome, " . $row["name"] . "!</b></h1>";
                    echo "<div id='user-profile' class='p-4 border rounded-md'>";
                    echo "<h2 class='font-bold text-center mb-4'>Profile</h2>";
                    echo "<p>Name: " . $row["name"] . "</p>";
                    echo "<p>Email: " . $row["email"] . "</p>";
                    echo "<p>Status: <b>" . $row["status"] . "</b></p>";
                }
            }
            ?>
            <div class="mt-4">
            <a href="backend/manage_user.php?updateid=<?php echo $_SESSION['id'] ?>" class="text-light"><button class="bg-green-600 hover:bg-green-500 rounded-md px-4 py-2">Edit Profile</button></a>
            <a href="Mealplan.php?id=<?php echo $_SESSION['id'] ?>" class="text-light"><button class="bg-green-600 hover:bg-green-500 rounded-md px-4 py-2">Create Mealplan</button></a>
            </div>

        </div>
    </div>

</body>

</html>