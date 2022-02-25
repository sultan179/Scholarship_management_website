<?php
session_start();
include 'filesLogic.php';
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

    $scholarship = $conn->prepare("SELECT * FROM `scholarship`");

		$scholarship->execute(array());
    $scholarship= $scholarship->fetchAll(PDO::FETCH_ASSOC);

    if(empty($_SESSION)||$_SESSION['status']!='student')
		{
      $Message = urlencode("Invalid Credentials");

			header("Location: studentlogin.php?Message=$Message");
		}
    $id=$_SESSION['id'];
    //var_dump($_SESSION);die;
	   

?>

<!DOCTYPE html>
<html lang="en">
<head>

<style>
    button{
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
  padding: 7px;
}
</style>

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
            <li><a href="scholarship.php"><h3>Scholarships</h3></a></li>
            <li><a href="document.php">Documents</a></li>
            <li><a href="donor.php">Donors</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul> 
    </div>
    <div class="main_content">
    <div class="header"><h2>Student Dashboard</h2>
        <h2>Student Name: <?php echo $_SESSION['name'] ?> </h2>
        Student ID: <?php echo $_SESSION['id'] ?> 
        <h2><button onclick='upload()'>Upload Transcript</button></h2>
        <?php if(isset($_GET['Message'])){
	?>
	<h1 style='color:black;text-align:center;font-size:30px'><?php echo $_GET['Message'];?></h1>
	<?php
   
} ?>
        <a href='logout.php' style="float: right;
    margin-left: 14em;">Logout</a><br> 
    </div> 
        <div class="header"><h2>Undergraduate Student Scholarships</h2></div> 
        <div class="row">
          <?php foreach($scholarship as $sch){
            if($sch['type']=='Undergraduate')
            {
            // var_dump($id);
          ?>
            <div class="column">
            <a href="application.php?scholarship_id=<?php echo $sch['id'] ?>&amp;student_id=<?php echo $id ?>">
                    <div class="card" style="width:100%;">
                        <div class="container">
                            <img src="img/<?php echo $sch['image']?>" width="270px" height="200px">
                            <!-- number pulled from back end -->
                            
                          <h3><b>Faculty of <?php echo $sch['faculty']?> Scholarship</b></h3>
                          <p>Academic year <?php echo $sch['year']?></p>
                          <h4>Scholarship Value:</h4>
                          <p>$<?php echo $sch['value']?></p>
                
                          <h4>Requirements:</h4>
                          <ul>
                            <li>Student type: <?php echo $sch['type']?></li>
                            <li>Citizenship: <?php echo $sch['citizen']?></li>
                            <li>Faculty: <?php echo $sch['faculty']?></li>
                            <li>Minimum GPA required: <?php echo $sch['min_cgpa']?></li>
                          </ul>
                          <h2><button>Apply</button></h2>
                        </div>
                      </div>
                      </a>

            </div>
            <?php   }
          }?>
            
        </div> 
        
        <div class="header"><h2>Graduate Student Scholarships</h2></div> 
        <div class="row">
        <div class="row">
          <?php foreach($scholarship as $sch){
            if($sch['type']=='Graduate')
            {
            // var_dump($sch);
          ?>
            <div class="column">
            <a href="application.php?scholarship_id=<?php echo $sch['id'] ?>&amp;student_id=<?php echo $id ?>">
                    <div class="card" style="width:100%;">
                        <div class="container">
                            <img src="img/<?php echo $sch['image']?>" width="270px" height="200px">
                            <!-- number pulled from back end -->
                            
                          <h3><b>Faculty of <?php echo $sch['faculty']?> Scholarship</b></h3>
                          <p>Academic year <?php echo $sch['year']?></p>
                          <h4>Scholarship Value:</h4>
                          <p>$<?php echo $sch['value']?></p>
                
                          <h4>Requirements:</h4>
                          <ul>
                            <li>Student type: <?php echo $sch['type']?></li>
                            <li>Citizenship: <?php echo $sch['citizen']?></li>
                            <li>Faculty: <?php echo $sch['faculty']?></li>
                            <li>Minimum GPA required: <?php echo $sch['min_cgpa']?></li>
                          </ul>
                          <h2><button>Apply</button></h2>
                        </div>
                      </div>
                      </a>

            </div>
            <?php   }
          }?>
            
        </div> 
       
          

        </div>  
        
    </div>
</div>



<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    
<h3>Upload Transcript</h3>

<div class="container">

  
  <!-- Form to Review Details and make Decision -->
  <form action="scholarship.php" method=post enctype="multipart/form-data" >
  
          <h3>Upload File</h3>
          <input type="file" name="myfile"> <br>
          <button type="submit" name="save">upload</button>
        
        </form>
</div>

  </div>

</div>




<script>
function upload(){
// Function to Open form and Show data and update it 

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