<?php
include 'auth_chek.php';

$con = mysqli_connect('localhost', 'root', '', 'recipe_db');
if ($_SESSION['admin'] == 1) {
    header("Location: backend/admin_panel.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Meal Planner</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="alpine.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <nav class="flex  py-3 z-20 justify-between rounded-md bg-opacity-80 backdrop-blur-md sticky top-2 bg-white px-7">
        <h1 class="font-bold text-xl">Recipe</h1>
        <ul class="flex justify-between space-x-6   items-center">
            <a href="index.php" class="text-gray-700 ">Home</a>
            <!-- <a href="#recipe" class="text-gray-700 ">Recipes</a> -->
            <?php
            error_reporting(E_ALL ^ E_WARNING);
            $email = $_SESSION['email'];
            $sql = "SELECT * FROM user WHERE email = '" . $email . "'";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            if ($row['status'] == "VERIFIED") {
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
    <div class="container row d-flex flex-row justify-content mb-5 " style="justify-content:center; margin-top:3em;">
        <div class="">
            <h1 class="text-lg font-bold text-grayy-800 mb-3">My Meal Plan</h1>
            <form method="POST" action="">
                <input class="border  p-2 rounded-md mb-2" type="text" name="plan_name" placeholder="Enter meal plan name" required><br>
                <label>Start date:</label>
                <input type="date" name="start_date" required><br>
                <label>End date:</label>
                <input type="date" name="end_date" required><br>



                <div class="flex flex-col ">
                    <td>Breakfast</td>
                    <td><input class="border  p-2 rounded-md mb-2" type="text" name="breakfast" style="border:solid; border-width:1px; border-radius:5px" required></td>
                </div>

                <div class="flex flex-col ">

                    <td>Lunch</td>
                    <td><input class="border  p-2 rounded-md mb-2" type="text" name="lunch" style="border:solid; border-width:1px; border-radius:5px" required></td>
                </div>

                <div class="flex flex-col ">

                    <td>Dinner</td>
                    <td><input class="border  p-2 rounded-md " type="text" name="dinner" style="border:solid; border-width:1px; border-radius:5px" required></td><br>
                </div>


                <input class="bg-green-600 w-full px-4 p-2 text-sm font-bold text-white rounded hover:bg-green-500" type="submit" name="saveMealPlan" value="Save">
            </form>
        </div>
    </div>

    <div class="flex max-w-4xl space-x-10 p-4  border mx-auto">

        <?php
        // connect to the database

        if (isset($_POST['saveMealPlan'])) {
            $id = $_SESSION['id'];
            $name = $_POST['plan_name'];
            $start = $_POST['start_date'];
            $end = $_POST['end_date'];
            $break = $_POST['breakfast'];
            $lunch = $_POST['lunch'];
            $dinner = $_POST['dinner'];




            $sql = "INSERT into meal_plan (plan_name,start_date, end_date, creator_id, breakfast, lunch, dinner)
    values ('$name','$start','$end','$id','$break','$lunch','$dinner')";

            $result = mysqli_query($con, $sql);
            if ($result) {
		        echo '<script> alert("Meal Plan created successfully!"); window.location.href = "Mealplan.php?id=' . $id.'"; </script>';

            } else {
                die(mysqli_error($con));
            }
        }
        // query the meal plan
        if (isset($_GET['id'])) {

            $creator_id = $_GET['id'];
            $sql = "SELECT * FROM meal_plan where creator_id=" . $creator_id;
            $result = mysqli_query($con, $sql);

            // display the meal plan
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $Id = $row['id'];
                    echo "<div class='border rounded-md p-4 '><h2>Meal Plan Name : " . $row["plan_name"] . "</h2>";
                    echo "<p>Start Date: " . $row["start_date"] . "</p>";
                    echo "<p>End Date: " . $row["end_date"] . "</p><br>";
                    // ...display more meal plan details, like breakfast, lunch, dinner, and snacks
                    echo "<h3>Meals</h3>";
                    echo "<ul>";
                    echo "<li>Breakfast: " . $row["breakfast"] . "</li>";
                    echo "<li>Lunch: " . $row["lunch"] . "</li>";
                    echo "<li>Dinner: " . $row["dinner"] . "</li>";
                    echo "</ul>
            <div class='  flex space-x-3'>
            <a href='manage_mealplan.php?update=" . $Id . "'><button class='bg-green-500 p-2 px-1 text-center hover:bg-green-600 rounded-md mt-4 w-24 text-sm font-bold text-white tracking-wide'>Edit</button></a>
            <a href='manage_mealplan.php?delete=" . $Id . "'><button class=' bg-red-200 hover:bg-red-300 p-2 px-1 text-center rounded-md mt-4 w-24 text-sm text-red-900 font-bold  tracking-wide'>Delete</button></a>
            </div>
            </div>";
                }
            } else {
                echo "No meal plans found.";
            }
        }

        ?>

    </div>
    <!-- Optional: Add more HTML to display grocery list, search for recipes, etc. -->
</body>

</html>