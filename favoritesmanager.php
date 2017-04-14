<?php
session_start();

include 'config.php';
define('VALUE', 'on');
$ID = $_SESSION['id'];
if(isset($_POST['submit']))
{

foreach ($_POST as $key => $value) {
        $key=preg_replace( '/_[^_]*$/', '', $key );
        
        if($value==VALUE){
        
       if(strpos($key,'Add')!==FALSE){ 
          $a=substr($key,3);
           echo $a;
		   echo $ID;
          $sql = "INSERT INTO Playlist VALUES ('','$ID','$a',now())";
          $conn -> query($sql);
		   
       }
       if(strpos($key,'Remove')!==FALSE){ 
          $a=substr($key,6);
      
          $sql = "DELETE FROM Playlist WHERE MediaID='$a' AND UserID='$ID'";
          $conn -> query($sql);
		   
       }
       }
	   

}
//header("location: home.php");
}