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
 $id= $_SESSION['id']  ;
    $users = $conn->prepare("SELECT * FROM `users` WHERE `id`=$id");

		$users->execute(array());
		$users= $users->fetchAll(PDO::FETCH_ASSOC);
		
	   
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
    <link rel="stylesheet" href="awardstyle.css">

</head>
<body>

<div class="navigation">
    <div class="sidebar">
        <img src="img/avatar.png" class="avatar" width="200">
        <ul>
            <li><a href="studentdashboard.php">Home</a></li>
            <li><a href="application.php">Applications</a></li>
            <!-- <li><a href="award.html">Awards</a></li> -->
            <li><a href="scholarship.php">Scholarships</a></li>
            <li><a href="document.php">Documents</a></li>
            <li><a href="donor.php"><h3>Donors</h3></a></li>
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
        <div class="row">
            <div class="column">
                
                    <div class="card" style="width:100%;">
                        <div class="container">
                            <img src="img/avatar.png" width="250px" height="230px">
                            <!-- number pulled from back end -->
                            <h2>University of Calgary</h2>
                        </div>
                      </div>

            </div>
            <div class="column">
                <div class="card" style="width:100%;">
                    <div class="container">
                        <img src="img/jt.jpg" width="250px" height="200px">
                        <!-- number pulled from back end -->
                        <h2>Justin Trudeau</h2>
                    </div>
                  </div>

            </div>
            <div class="column">
                <div class="card" style="width:100%;">
                    <div class="container">
                        <img src="img/dt.jpg" width="250px" height="200px">
                        <!-- number pulled from back end -->
                        <h2>Donald Trump</h2>
                    </div>
                  </div>

            </div>
            <div class="column">
                <div class="card" style="width:100%;">
                    <div class="container">
                        <img src="img/lebron.jpg" width="250px" height="200px">
                        <!-- number pulled from back end -->
                        <h2>Lebron James</h2>
                    </div>
                  </div>

            </div>

        </div>   
        
    </div>
</div>

</body>
</html>