<?php
session_start();
if(!isset($_SESSION['email'])){
  header('location: ../login.php' );
  echo "you have to login first";
}

if ($_SESSION['admin'] == 0){
  header("Location: ../index.php");
}
$con = mysqli_connect('localhost','root','','recipe_db');

//update status
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if ($status == 'UNVERIFIED') {
        $status = 'VERIFIED';
    } else {
        $status = 'UNVERIFIED';
    }
    $Id = $_GET['id'];
    $sql = "update user set status='$status' where id=$Id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo "deleted successfully";
        header('location:admin_panel.php');
    } else {
        die(mysqli_error($con));
    }
}


//delete user

if (isset($_GET['deleteid'])) {
    $Id = $_GET['deleteid'];

    $sql = "delete from `user` where id=$Id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo "deleted successfully";
        header('location:admin_panel.php');
    } else {
        die(mysqli_error($con));
    }
}


//ediet user acount

$Id = $_GET['updateid'];

$sql = "select * from `user` where id=$Id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$fullname = $row['name'];
$email = $row['email'];
// $pass1=$row['password'];

if (isset($_POST['submit'])) {
    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    // $password = mysqli_real_escape_string($conn,$_POST['password']);


    //finally register
    $sql = "update user set name='$fullname', email='$email' where id=$Id";

    $result = mysqli_query($con, $sql);
    if ($result) {
        echo '<script> alert("User updated successfuly!"); window.location.href = "../index.php"; </script>';

        // header('location:../index.php');
    } else {
        die(mysqli_error($con));
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup system</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> -->
</head>

<body>
    <div class=" max-w-md mx-auto mt-10 p-4 ">
        <div class=" p-4">
            <div class="text-center text-2xl font-bold mb-4">Edit your profile</div>
            <div class="admin-form">
                <form method="POST" class="border rounded-md w-full p-5">
                    <div class="flex flex-col">
                        <label class="mb-2 ml-2 text-gray-700">Full Name</label>
                        <input class="bg-gray-100 w-full p-4 rounded-md" type="text" name="fullname" id="" placeholder="Enter firstname" value=<?php echo $fullname; ?> required> <br>
                    </div>
                    <div class="flex flex-col">
                        <label class="mb-2 ml-2 text-gray-700">Email</label>
                        <input class="bg-gray-100 w-full p-4 rounded-md" type="email" name="email" id="" placeholder="Enter your email" value=<?php echo $email; ?> required><br>
                    </div>
                    <!-- <div class="form-grop">
			  <label>PASSWORD: </label>
			<input type="password" name="password" id="" placeholder="Enter password" value=<?php echo $password1; ?> required><br> 
             </div> -->

                    <button type="submit" class="bg-green-600 w-full hover:bg-green-500 text-white text-center p-4 rounded-md" name="submit">Save</button>
                </form>
            </div>
        </div>
    </div>
</body>
</body>

</html>