<?php
if(isset($_GET['Message'])){
	?>
	<h1 style='color:white;text-align:center;font-size:30px'><?php echo $_GET['Message'];?></h1>
	<?php
   
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Student or Admin</title>
        <!-- Favicon -->
	<link rel="shortcut icon" href="img/icons.png" />
        <link href="startstyle.css" rel="stylesheet">


    </head>
    <style>
        body {
            background-image: url('img/startbg.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            color: black;
            text-decoration-color: black;
        }
        .split {
            height: 100%;
            width: 50%;
            position: fixed;
            z-index: 1;
            top: 0;
            overflow-x: hidden;
            padding-top: 20 px;
        }
        .left{
            left: 0;
        }

        .right{
            right: 0;
        }
        .centered{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        </style>
    <body>

            <a href="studentlogin.php">
                <div class="split left">
                    <div class="centered">
                        <img src="img/student-icon.png" alt="Student icon" width="400">
                        <h1>Student</h1>
                        <p></p>
                    </div>
                </div>
        </a>
        <a href="adminlogin.php">
            <div class="split right">
                <div class="centered">
                    <img src="img/admin-icon.png" alt="admin icon" width="400">
                    <h1>Admin</h1>
                    <p></p>
                </div>
            </div>
            </a>
        </div>
    </body>
</html>