<?php
session_start();
include 'filesLogic.php';
if(isset($_GET['Message'])){
	?>
	<h1 style='color:white;text-align:center;font-size:30px'><?php echo $_GET['Message'];?></h1>
	<?php
   
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


// Query to fetch scholarships and students data
    $app = $conn->prepare("select scholarship.*,users.* ,application.*, users.id as student_id from application Join scholarship On scholarship.id=application.scholarship_id 
    Join users On users.id=application.student_id");

		$app->execute(array());
		$app= $app->fetchAll(PDO::FETCH_ASSOC);
       
        if(empty($_SESSION)||$_SESSION['status']!='admin')
		{
      $Message = urlencode("Invalid Credentials");

			header("Location: adminlogin.php?Message=$Message");
		}
	   

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <style>
    .button{
      border: none;
    outline: none;
    height: 40px;
    background: #fb2525;
    color: #fff;
    font-size: 18px;
    border-radius: 20px;
    width: 15%;
    margin-top: 8px;

    }
    .modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
    margin: auto;
    margin-top: -86px;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}


input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
    </style>
    <link rel="shortcut icon" href="img/icons.png" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<title>Admin Applications</title>
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
                    <div class="card" style="width:200%;">
                        <div class="container">
                            <!-- <img src="img/up.jpg" width="400px"> -->
                            <!-- number pulled from back end -->
                            <!-- <h1><b>0</b></h1>   -->
                          <h2><b>Applications Submitted</b></h2>
                          <h2><b>Student Name:<?php echo $ap['name']?></b></h2>
                          <h2><b><?php echo $ap['year']?> - Scholarship</b></h2>
                          <h2><b>Status: <?php echo $ap['app_status']?></b></h2>
                          <p>submition date: <?php echo $ap['created_at']?></p>
                          <button class="button" onclick='viewMore(<?php echo json_encode($ap,true); ?>)'>Review</button>
                        </div>
                      </div>

            </div>

        </div>
        <?php 
          }?>
       
    </div>
</div>

<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    
<h3>Decision</h3>

<div class="container">

  <div style="width:50%">
<h3>Student Details</h3>
  <p id="student_name" ></p>
  <p id="student_email" ></p>
  <p id="student_grade" ></p>
  <p id="student_degree" ></p>
  <p id="student_institute" ></p>
  <p id="student_citizen" ></p><br>
  <a href="" id="yourlinkId" style="background-color:red;color:white">Download Transcript</a>
        </div>
<br>
<div style="width:50%">
  <h3>Scholorship Details (Student Applied For)</h3>
  <p id="faculty" ></p>
  <p id="year" ></p>
  <p id="value" ></p>
  <p id="type" ></p>
  <p id="citizen" ></p>
  <p id="min_cgpa" ></p>
  
  <br>
        </div>
  <!-- Form to Review Details and make Decision -->
  <form action="result.php" method=post>
   
  <h3>Decision</h3>
  <input type="hidden" id="student_id" name="student_id" value="">
  <input type="hidden" id="scholarship_id" name="scholarship_id" value="">
    <select id="result" name="result">
      <option value="Under Review">Under Review</option>
      <option value="Accepted">Accepted</option>
      <option value="Decline">Decline</option>
    </select>

    
    <input type="submit" name="submit" value="submit">
  </form>
</div>

  </div>

</div>

<script>
  function viewMore(i){
// Function to Open form and Show data and update it 

document.getElementById("student_name").innerHTML = "Name:"+i.name;
document.getElementById("student_email").innerHTML = "Email:"+i.email;
document.getElementById("student_grade").innerHTML = "Grade:"+i.grade;
document.getElementById("student_degree").innerHTML = "Degree:"+i.degree;
document.getElementById("student_institute").innerHTML = "Institute Name:"+i.institute_name;
document.getElementById("student_citizen").innerHTML = "Citizen:"+i.institute_country;
document.getElementById("faculty").innerHTML = i.faculty;
document.getElementById("year").innerHTML = i.year;
document.getElementById("value").innerHTML = i.value;
document.getElementById("type").innerHTML = i.type;
document.getElementById("citizen").innerHTML = i.citizen;
document.getElementById("min_cgpa").innerHTML = i.min_cgpa;

document.getElementById("student_id").value = i.student_id;
document.getElementById("scholarship_id").value = i.scholarship_id;
var a = document.getElementById('yourlinkId'); //or grab it by tagname etc
a.href = "admindashboard.php?file_id="+i.student_id;
var modal = document.getElementById("myModal");
modal.style.display = "block";


var span = document.getElementsByClassName("close")[0];

span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
  }
        </script>
</body>
</html>