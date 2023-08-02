<?php
include 'auth_chek.php';

$con = mysqli_connect('localhost', 'root', '', 'recipe_db');
if ($_SESSION['admin'] == 1) {
    header("Location: backend/admin_panel.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "delete from `meal_plan` where id=$id";

    $result = mysqli_query($con, $sql);

    if ($result) {
		echo '<script> alert("Meal Plan deleted successfully!"); window.location.href = "Mealplan.php?id='. $_SESSION['id'].'"; </script>';

    } else {
        die(mysqli_error($con));
    }
}

//update plan
if (isset($_GET['update'])) {
    $Id = $_GET['update'];
    $sql = "select * from meal_plan where id=" . $Id;
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $plan_name = $row['plan_name'];
    $breakfast = $row['breakfast'];
    $lunch = $row['lunch'];
    $dinner = $row['dinner'];
    $Start = $row['start_date'];
    $End = $row['end_date'];

    if (isset($_POST['saveMealPlan'])) {
        $id = $_SESSION['id'];
        $name = $_POST['plan_name'];
        $start = $_POST['start_date'];
        $end = $_POST['end_date'];
        $break = $_POST['breakfast'];
        $lunch = $_POST['lunch'];
        $dinner = $_POST['dinner'];



        $sql = "DELETE FROM meal_plan WHERE id=" . $Id;
        $result = mysqli_query($con, $sql);

        $sql1 = "INSERT into meal_plan (plan_name,start_date, end_date, creator_id, breakfast, lunch, dinner)
                values ('$name','$start','$end',$id,'$break','$lunch','$dinner')";


        $result1 = mysqli_query($con, $sql1);
        if ($result1) {
		    echo '<script> alert("Meal Plan updated successfully!"); window.location.href = "Mealplan.php?id='. $id.'"; </script>';

        } else {
            die(mysqli_error($con));
        }
    }
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
            <?php
            // error_reporting(E_ALL ^ E_WARNING);
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
        </ul>
    </nav>
    <div class="container row d-flex flex-row justify-content mb-5 " style="justify-content:center; margin-top:3em;">
        <div class="">
            <h1 class="text-lg font-bold text-grayy-800 mb-3">My Meal Plan</h1>
            <form action="" method="POST">
                <input type="text" name="plan_name" class="border  p-2 rounded-md mb-2" type="text" value="<?php echo $plan_name ?>" style="border:solid; border-width:1px; border-radius:5px" required><br>
                <label>Start date:</label>
                <input type="date" name="start_date" value="<?php echo $Start ?>" required><br>
                <label>End date:</label>
                <input type="date" name="end_date"  value="<?php echo $End ?>" required><br>



                <div class="flex flex-col ">
                    <td>Breakfast</td>
                    <td><input type="text" name="breakfast" class="border  p-2 rounded-md mb-2" type="text" value="<?php echo $breakfast ?>" style="border:solid; border-width:1px; border-radius:5px" required></td>
                </div>

                <div class="flex flex-col ">
                    <td>Lunch</td>
                    <td><input type="text" name="lunch" class="border  p-2 rounded-md mb-2" type="text" value="<?php echo $lunch ?>" style="border:solid; border-width:1px; border-radius:5px" required></td>
                </div>

                <div class="flex flex-col ">
                    <td>Dinner</td>
                    <td><input type="text" name="dinner" class="border  p-2 rounded-md mb-2" type="text" value="<?php echo $dinner ?>" style="border:solid; border-width:1px; border-radius:5px" required></td><br>
                </div>


                <button class="bg-green-600 w-full px-4 p-2 text-sm font-bold text-white rounded hover:bg-green-500" type="submit" name="saveMealPlan">Save</button>
            </form>

        </div>
    </div>

</body>

</html>