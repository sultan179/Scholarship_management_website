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
    $budget=100000;
    $left=0;
    $app = $conn->prepare("select scholarship.*,users.* ,application.* from application Join scholarship On scholarship.id=application.scholarship_id 
    Join users On users.id=application.student_id Where application.app_status=?");

		$app->execute(array('Accepted'));
        $app= $app->fetchAll(PDO::FETCH_ASSOC);

        $sum = $conn->prepare("select scholarship.* ,application.*,sum(scholarship.value) as sum1 from application Join scholarship On scholarship.id=application.scholarship_id Where application.app_status=?");

		$sum->execute(array('Accepted'));
        $sum= $sum->fetchAll(PDO::FETCH_ASSOC);
        foreach($sum as $s)
        {
            $left=($s['sum1']);
        }
        //var_dump($left);die;
        if(empty($_SESSION)||$_SESSION['status']!='admin')
		{
      $Message = urlencode("Invalid Credentials");

			header("Location: studentlogin.php?Message=$Message");
		}
	   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="img/icons.png" />

	<title>Admin </title>
	<link rel="stylesheet" href="applicationstyle.css">
</head>
<body>

<div class="navigation">
    <div class="sidebar">
        <img src="img/avatar.png" class="avatar" width="200">
        <ul>
            <!-- <li><a href="studentdashboard.php">Home</a></li> -->
            <li><a href="admindashboard.php"><h3>Applications</h3></a></li>
            <!-- <li><a href="award.html">Awards</a></li> -->
            <li><a href="adminscholarship.php">Scholarships</a></li>
            <li><a href="adminstat.php">Statistics</a></li>
            <!-- <li><a href="donor.php">Donors</a></li>
            <li><a href="contact.php">Contact</a></li> -->
        </ul> 
    </div>
    <div class="main_content">
    <div class="header"><h2>Admin Dashboard</h2>
        <h2>Admin Name: <?php echo $_SESSION['name'] ?> </h2>
        Admin ID: <?php echo $_SESSION['id'] ?> 
        <h1 style='color:black;text-align:center;font-size:20px'>Total Budget: <?php echo $budget?></h1>
        <h1 style='color:black;text-align:center;font-size:20px'>Budget Left: <?php echo $budget-$left?></h1>
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
                          <h2><b>Scholorship Accepted</b></h2>
                          <h2><b><?php echo $ap['year']?> - Scholarship</b></h2>
                          <h2><b>Student Name: <?php echo $ap['name']?></b></h2>
                          <h2><b>Value: $<?php echo $ap['value']?></b></h2>
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