<?php
if(isset($_GET['Message'])){
	?>
	<h1 style='color:white;text-align:center;font-size:30px'><?php echo $_GET['Message'];?></h1>
	<?php
   
}
?>
<html>
<head>
    <!-- Favicon -->
	<link rel="shortcut icon" href="img/icons.png" />
<title>Student login</title>
    <link rel="stylesheet" type="text/css" href="studentstyle.css">
<body>
    <div class="loginbox">
    <img src="img/avatar.png" class="avatar">
        <h1>Student Login</h1>
        <form action="student.php" name="myForm" method="post">
            <p>Username</p>
           <input type="Text" placeholder="Enter Email" name="Email" ><br><br>
            <p>Password</p>
            <input type="Password" placeholder="Enter Password." name="Password"  >
            <!-- <a class="css-button-rounded" href="studentdashboard.html" style="font-size: x-large;">Login</a> -->
            <input type="submit" value="Login">
            <!-- <input type="submit" name="" value="Login"> -->
            <!-- <a  href="studentdashboard.html">Forgot your password?</a><br> -->
            <!-- <a href="#">Don't have an account?</a> -->
        </form>
        
    </div>

</body>
</head>
</html>