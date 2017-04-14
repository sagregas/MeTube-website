<?php 
session_start();
$UserId=$_SESSION['id'];
echo $UserId;		//this will be received from the previous page
?>
	<a href="MessageHandling.php">Message</a>
