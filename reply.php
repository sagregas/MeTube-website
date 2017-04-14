<?php
session_start();
$ID = $_SESSION['id'];
require_once('config.php');
$sender=$_POST['userName']; //sender self
//check for user id to be written here
if(isset($_POST['Messageto'])){
	$Messageto=$_POST['Messageto'];
	echo "To-	".$_POST['receiver'];
}
if(isset($_POST['reply'])){
	$receiver=$_POST['receiver'];
	echo "To-	".$_POST['receiver'];?>
<br>
	<form action="reply.php" method="post">
	<textarea name="msg" rows='20' cols='50'></textarea><br />
	<input type="hidden" name="sender" value=<?php echo $sender; ?>>
	<input type="hidden" name="messageTo" value=<?php echo $receiver; ?>>
	<input type="submit" name="Send" value="send">
	</form>
<?php } 

elseif (isset($_POST['newMessage'])){ echo "To -	"?>
	<form action="reply.php" method="post">
        <select name="messageTo">
        <?php 
          $sql = "SELECT UserName from User WHERE ID<>'$ID' AND ID NOT IN (SELECT UserID FROM Blockedlist WHERE BlockID='$ID') AND ID<>1";
          $result = $conn -> query($sql);
          while($row=mysqli_fetch_assoc($result))
          { ?>
             <option value="<?php echo $row['UserName'];?>"><?php echo $row['UserName'];?></option>
          <?php } ?>
	<!--<input type="search" placeholder="username" name="messageTo" style="width:150px; border:3px solid; height:30px; padding:0px 3px; position:relative;"><br>	-->
	<textarea name="msg" rows='20' cols='50'></textarea><br />
	<input type="hidden" name="sender" value=<?php echo $sender; ?>>
	<input type="submit" name="Send" value="send">
	</form>
<?php
 }?>


<?php
if(isset($_POST['Send'])){
	$sender=$_POST['sender'];
	$receiver=$_POST['messageTo'];	
	$msg=$_POST['msg'];
	$Q1="insert into Messages values('','$msg','$receiver','$sender',now())";
	$Q1prep=$dbconn->prepare($Q1);
	$Q1prep->execute();
	echo "your message has been sent";
	echo $sender;
 }?>
