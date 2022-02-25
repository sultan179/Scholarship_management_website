<?php
if(!empty($_GET))
{
$scholarship_id=$_GET['scholarship_id'];
//$student_id=$_GET['student_id'];
}
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
$student_id=$_SESSION['id'];
if(!empty($_GET))
{


$statement = $conn->prepare("INSERT INTO `application` (scholarship_id, student_id, app_status,created_at) VALUES (?, ?, ?,?)");
$statement->execute(array($scholarship_id, $student_id, 'submitted', date("Y/m/d")));
echo '<h1 style="color:white;text-align:center">Application Submitted Successfully</h1>';
}
    $app = $conn->prepare("select scholarship.*,users.* ,application.* from application Join scholarship On scholarship.id=application.scholarship_id 
    Join users On users.id=application.student_id Where users.id= $student_id");

		$app->execute(array());
		$app= $app->fetchAll(PDO::FETCH_ASSOC);
       
        if(empty($_SESSION)||$_SESSION['status']!='student')
		{
      $Message = urlencode("Invalid Credentials");

			header("Location: studentlogin.php?Message=$Message");
		}
	   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="img/icons.png" />

	<title>Student Applications</title>
	<link rel="stylesheet" href="applicationstyle.css">
</head>
<body>

<div class="navigation">
    <div class="sidebar">
        <img src="img/avatar.png" class="avatar" width="200">
        <ul>
            <li><a href="studentdashboard.php">Home</a></li>
            <li><a href="application.php"><h3>Applications</h3></a></li>
            <!-- <li><a href="award.html">Awards</a></li> -->
            <li><a href="scholarship.php">Scholarships</a></li>
            <li><a href="document.php">Documents</a></li>
            <li><a href="donor.php">Donors</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul> 
    </div>
    <div class="main_content">
    <div class="header"><h2>Student Dashboard</h2>
        <h2>Student Name: <?php echo $_SESSION['name'] ?> </h2>
        Student ID: <?php echo $_SESSION['id'] ?> 
        
        <a href='logout.php' style="float: right;
    margin-left: 14em;">Logout</a><br> 
    </div> 
    <?php
    if(empty($app))
            {
           
          ?>
        <div class="row">
            <div class="column">
                <a href="application.php"> 
                    <div class="card" style="width:200%;">
                        <div class="container">
                            <!-- <img src="img/up.jpg" width="400px"> -->
                            <!-- number pulled from back end -->
                            <!-- <h1><b>0</b></h1>   -->
                          <h2><b>No Applications Submitted</b></h2>
                          <p>Click to view</p>
                        </div>
                      </div>
                      </a>

            </div>

        </div>
            <?php } ?>
    <?php foreach($app as $ap){
            ?>
       

            
        <div class="row">
            <div class="column">
                <a href="application.php"> 
                    <div class="card" style="width:200%;">
                        <div class="container">
                            <!-- <img src="img/up.jpg" width="400px"> -->
                            <!-- number pulled from back end -->
                            <!-- <h1><b>0</b></h1>   -->
                          <h2><b>Applications Submitted</b></h2>
                          <h2><b><?php echo $ap['year']?> - Scholarship</b></h2>
                          <h2><b>Status: <?php echo $ap['app_status']?></b></h2>
                          <p>submition date: <?php echo $ap['created_at']?></p>
                        </div>
                      </div>
                      </a>

            </div>

        </div>
        <?php 
          }?>
       
    </div>
</div>

</body>
</html>