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
		// var_dump($users);die;
		// $menus = $conn->prepare("SELECT * FROM `menus`");

		// $menus->execute(array());
		// $menus= $menus->fetchAll(PDO::FETCH_ASSOC);
		
		// $products = $conn->prepare("SELECT * FROM `products`");

		// $products->execute(array());
		// $products= $products->fetchAll(PDO::FETCH_ASSOC);
		
		// $sliders = $conn->prepare("SELECT * FROM `sliders`");

		// $sliders->execute(array());
		// $sliders= $sliders->fetchAll(PDO::FETCH_ASSOC);
		
		// $socialaccounts = $conn->prepare("SELECT * FROM `socialaccounts`");

		// $socialaccounts->execute(array());
    //     $socialaccounts= $socialaccounts->fetchAll(PDO::FETCH_ASSOC);
	   
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

	<title>Dashboard | Home</title>
	<link rel="stylesheet" href="dashstyle.css">
</head>
<body>

<div class="navigation">
    <div class="sidebar">
        <img src="img/avatar.png" class="avatar" width="200">
        <ul>
            <li><a href="studentdashboard.php"><h3>Home</h3></a></li>
            <li><a href="application.php">Applications</a></li>
            <!-- <li><a href="award.html">Awards</a></li> -->
            <li><a href="scholarship.php">Scholarships</a></li>
            <li><a href="document.php">Documents</a></li>
            <li><a href="donor.php">Donors</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul> 
    </div>
    <div class="main_content">
        <!-- student id taken from back end -->
        <div class="header"><h2>Student Dashboard</h2>
        <h2>Student Name: <?php echo $_SESSION['name'] ?> </h2>
        Student ID: <?php echo $_SESSION['id'] ?> 
        
        <a href='logout.php' style="float: right;
    margin-left: 14em;">Logout</a><br> 
    </div> 
        <div class="row"> 
            <div class="column"> 
                <a href="scholarship.php"> 
        <div class="card" style="width:100%;">
            <div class="container">
                <img src="img/award.jpg" width="100%">
              <h2><b>Awards and Scholarships</b></h2>
              <p>Click here for more details</p>
            </div>
          </div>
          </a>
        </div>
        <div class="column">  
            <div class="card" style="width:80%;">

                <div class="container">
                  <h1><b>Important deadlines</b></h1>
                  <p>All deadlines are subject to change</p>
                  <ul>
                      <li><b>March 31st 2020 -</b><br>Application deadline for Spring 2020 Award</li>
                      <li><b>March 31st 2020 -</b><br>Application deadline for Spring 2020 Scholarships</li>
                      <li><b>May 31st 2020 -</b><br>Application deadline for Summer 2020 Award</li>
                      <li><b>May 31st 2020 -</b><br>Application deadline for Summer 2020 Scholarships</li>
                      <li><b>July 31st 2020 -</b><br>Application deadline for Fall 2020 Award</li>
                      <li><b>July 31st 2020 -</b><br>Application deadline for Fall 2020 Scholarships</li>
                      <li><b>November 30th 2020 -</b><br>Application deadline for Winter 2021 Award</li>
                      <li><b>November 30th 2020 -</b><br>Application deadline for Winter 2021 Scholarships</li>
                      <li><b>February 27th 2021 -</b><br>Application deadline for Fall 2021 Award</li>
                      <li><b>February 27th 2021 -</b><br>Application deadline for Fall 2021 Scholarships</li>
                  </ul>
                </div>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="column">
                <a href="application.php"> 
                    <div class="card" style="width:100%;">
                        <div class="container">
                            <img src="img/up.jpg" width="400px">
                            <!-- number pulled from back end -->
                            
                          <h2><b>Applications Submitted</b></h2>
                          <p>Click to view</p>
                        </div>
                      </div>
                      </a>

            </div>
            <div class="column">
                <a href="application.php"> 
                    <div class="card" style="width:80%;">
                        <div class="container">
                            <img src="img/up1.jpg" width="350px">
                            <!-- number pulled from back end -->
                             
                          <h2><b>Decision received</b></h2>
                          <p>Click to view</p>
                        </div>
                      </div>
                      </a>

            </div>
            <div class="column">
                <a href="application.php"> 
                    <div class="card" style="width:100%;">
                        <div class="container">
                            <img src="img/award.jpg" width="100%">
                          <h2><b>New Updates</b></h2>
                          <p>Coming up...</p>
                        </div>
                      </div>
                      </a>

            </div>

        </div>
    </div>
</div>

</body>
</html>