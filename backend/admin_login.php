<?php 
    require ("db_connection.php");

      
    ?>
		<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <!-- <link rel="stylesheet" href="style.css" /> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="alpine.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>recipe website</title>
  </head>
  <body class="bg-gray-50 w-screen h-screen p-2">
    <div class="max-w-6xl mx-auto">
      <div class="w-full">
        <div
          class="bg-white flex flex-col max-w-sm mx-auto mt-20 p-3 rounded-md">
          <h1 class="text-center pt-3 pb-4 text-xl font-bold tracking-wide">
             Admin Login
          </h1>
          <form class="flex flex-col pb-6" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <input name="Admin_Name"
              class="bg-gray-100 my-2 p-3 px-4 rounded-md placeholder:text-gray-600 placeholder:text-sm outline-none"
              type="text"
              placeholder="Admin name"
            />
            <input name="Admin_Password"
              class="bg-gray-100 my-2 p-3 px-4 rounded-md placeholder:text-gray-600 placeholder:text-sm outline-none"
              type="password"
              placeholder="Password"
            />
            <button name="login"
              class="bg-green-500 my-2 hover:bg-green-600 text-white font-medium p-3 px-4 rounded-md"
            >
              Log in
            </button>
          </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
	</header>
<?php 

function input_filter($data){
	$data=trim($data);
	$data=stripcslashes($data);
	$data=htmlspecialchars($data);
	return $data;
}

if(isset($_POST['login']))
//if($_SERVER['REQUEST_METHOD']=='POST')
  {
	#filtering user input
    $Admin_Name=input_filter($_POST['Admin_Name']);
    $Admin_Password=input_filter($_POST['Admin_Password']);

    $hash = password_hash($Admin_Password, PASSWORD_DEFAULT);

	#escaping special symbol used in SQL stetment
    $Admin_Name=mysqli_real_escape_string($con,$Admin_Name);
	  $Admin_Password=mysqli_real_escape_string($con,$Admin_Password);

	#query templete
    $query = "SELECT * FROM `admin` WHERE  `Admin_Name`=? and `Admin_Password`=?";

	#prepared statment
	if($stmt=mysqli_prepare($con,$query))
	{
     mysqli_stmt_bind_param($stmt,"ss",$Admin_Name,$Admin_Password); //binding value to templete
	 mysqli_stmt_execute($stmt);  //executing prepared statement
	 mysqli_stmt_store_result($stmt); //transformin result of execution in $stmt
	 
	 if(mysqli_stmt_num_rows($stmt)==1)
	 {
      $_SESSION['AdminLoginId']=$Admin_Name;
      header("Location: admin_panel.php");
	 }
	 elseif(empty($Admin_Name)){
		$err="admin name is required...";
	}elseif(empty($Admin_Password)){
        $err="password is required...";
	}
  elseif (password_verify($Admin_Password, $hash)) {
    echo "Password is correct!";
} 
	 else{
      echo"<script>alert('Invalid Admin Name or Password')</script>";
	 }
	 mysqli_stmt_close($stmt);
	}
	 else{
		echo"<script>alert('SQL Query cannot bet prepared');</script>";
	 }
  }
?>		
 </body>
</html>