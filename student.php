<?php

include 'config.php';
$con='';
try
{
    $host=$config['DB_HOST'];
    $dbname=$config['DB_DATABASE'];
$con= new PDO("mysql:host=$host;dbname=$dbname",$config['DB_USERNAME'],$config['DB_PASSWORD']);

}
catch(PDOException $e)
{
    echo "Error:".$e->getMessage();
}
// //Code to Connect MySQLi connection
// $con =mysqli_connect('127.0.0.1','root','','webapp');

// //Code to Check Check connection for any errors
// if (mysqli_connect_errno()){
// echo "Failed to connect to MySQL: ".mysqli_connect_error();
// }


//Code For starting our session to preserve our login
session_start();


//Code to check whether data with the name username has been submitted
if (isset($_POST['Email'])) {

	//variables to hold our submitted data with post
	$Email_Address = $_POST['Email'];
        
        //Encrypting our login password
	$Password = ($_POST['Password']);

	//our sql statement that we will execute
	$sql = $con->prepare("SELECT * FROM users WHERE email='$Email_Address' AND password='$Password'");
	$sql->execute(array());
		$sql= $sql->fetchAll(PDO::FETCH_ASSOC);
	//Executing the sql query with the connection
	// $re = mysqli_query($con, $sql);
//var_dump($sql);die;
	//check to see if there is any record or row in the database if there is then the user exists
	$name="";
	$id='';
	
	if (!empty($sql)) 
                
                {
					foreach($sql as $s)
					{
						if($s['name'])
						{
							$name=$s['name'];
							$id=$s['id'];
							$status=$s['status'];
						}
						else{
							exit;
						}
					}
		//creating a session name with username and inserting the submitted username
		$_SESSION['email'] = $Email_Address;
		$_SESSION['name'] = $name;
		$_SESSION['id'] = $id;
		$_SESSION['status'] = $status;
        echo '<a href="../login/index.php">Login Page</a>';
        echo"\n";
    echo '<a href="../login/signup.html">Signup Page</a>';

		//redirecting to homepage
		header("Location: studentdashboard.php");
         	}

                else
                {
		//display error if no record exists
		echo "Error : Invalid Login Credentials";
		$Message = urlencode("Error : Invalid Login Credentials ");
		header("Location: studentlogin.php?Message=".$Message);
	        }
}
?>





