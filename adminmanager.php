<?php 
        session_start();
include 'config.php';
if(isset($_POST['submit']))
{
    foreach ($_POST as $key => $value) {
        $key=preg_replace( '/_[^_]*$/', '', $key );
        if($key!="submit" && $value=="on"){
            echo $key;
            
	    	$sql = "DELETE FROM Playlist WHERE MediaID=$key";
			$conn->query($sql);
            $sql="DELETE FROM Media WHERE MediaID=$key";
          $conn->query($sql);
            


        }

    }
header("location: adminhome.php");
//header("refresh:1; url=Profile1.php");
}
if(isset($_POST['submit1']))
{
    foreach ($_POST as $key => $value) {
        $key=preg_replace( '/_[^_]*$/', '', $key );
        if($key!="submit" && $value=="on"){
            echo $key;
            
			$sql = "DELETE FROM Playlist WHERE MediaID IN (SELECT MediaID FROM Media WHERE UploaderID=$key)";
			$conn ->query($sql);
	    	
			$sql = "DELETE FROM Media WHERE UploaderID=$key";
			$conn->query($key);
			$sql = "DELETE FROM GroupDis WHERE OwnerID=$key";
			$conn->query($sql);
            $sql="DELETE FROM User WHERE ID=$key";
          $conn->query($sql);
            


        }

    }
header("location: adminhome.php");
//header("refresh:1; url=Profile1.php");
}
