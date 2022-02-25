<?php
session_start();
session_destroy();
echo "Error : Invalid Login Credentials";
		$Message = urlencode("Logout Successfully");
		header("Location: index.php?Message=".$Message);