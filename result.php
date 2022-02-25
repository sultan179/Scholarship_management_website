<?php

include 'config.php';
$conn='';
try
{
    $host=$config['DB_HOST'];
    $dbname=$config['DB_DATABASE'];
$conn= new PDO("mysql:host=$host;dbname=$dbname",$config['DB_USERNAME'],$config['DB_PASSWORD']);

}
catch(PDOException $e)
{
    echo "Error:".$e->getMessage();
}
session_start();
//$student_id=$_SESSION['id'];
//var_dump($_POST);die;
if(!empty($_POST) && $_POST['submit']=='submit'){
$result=$_POST['result'];
$student_id=$_POST['student_id'];
$scholarship_id=$_POST['scholarship_id'];
   
		$statement = $conn->prepare("UPDATE `application` SET `app_status` = ? WHERE `student_id` = ? AND `scholarship_id` = ?");
		$statement->execute(array($result, $student_id, $scholarship_id));
    $Message = urlencode("Result Updated Successfully");

    header("Location: admindashboard.php?Message=$Message");
}
if(!empty($_POST) && $_POST['create']=='create'){

  $faculty=$_POST['faculty'];
  $year=$_POST['year'];
  $value=$_POST['value'];
  $type=$_POST['type'];
  $citizen=$_POST['citizen'];
  $cgpa=$_POST['cgpa'];
$statement = $conn->prepare("INSERT INTO `scholarship` (faculty, year, value,type,citizen,min_cgpa,image) VALUES (?, ?, ?,?,?, ?,?)");
$statement->execute(array($faculty,$year,$value,$type,$citizen,$cgpa,'std.jpg'));
$Message = urlencode("Scholarship Added Successfully");

    header("Location: adminscholarship.php?Message=$Message");

}
        if(empty($_SESSION)||$_SESSION['status']!='admin')
		{
      $Message = urlencode("Invalid Credentials");

			header("Location: adminlogin.php?Message=$Message");
		}
	   

?>
