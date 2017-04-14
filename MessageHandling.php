<?php
//Do not use session else when it will go to reply page then it will not come back as session of the page there is lost
session_start();
require_once('config.php');  
   $AccID=$_SESSION['id'];
  //echo $AccID;
//To populate the messages received by this user
$ID = $_SESSION['id'];
//require_once('config.php');
$sql = "SELECT UserName FROM User WHERE ID='$ID'";
$result = $conn-> query($sql);
$row = mysqli_fetch_assoc($result);
$sender=$row['UserName']; //sender self
//check for user id to be written here
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
       <!-- <link rel="stylesheet" href="css/bootstrap-theme.min.css">-->
        <link rel="stylesheet" href="css/main.css">
		

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<style>
.navbar {
  padding-top: 20px;
  
}

body{

padding-top: 50px;}
.navbar-fixed-top {
    border: 0px none;
    background-color:#F66733;
   
   
}
.center-block {  
  display: block;  
  margin-right: auto;  
  margin-left: auto;  
} 
</style>
</head>

<body>
<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
  
     <a class="navbar-brand" href="home.php" style="color:white; padding-top:0px; padding-bottom:0px; font-size: 40px !important;">
MeTube
</a>
    </nav>
	<div class="container" style="padding:100px">	
	<div class="row">
	<form action="MessageHandling.php" method="post">
	<input type="hidden" name="userName" value=<?php echo $Q7res[0]['UserName']; ?>>  <!-- -->
	<input type="submit" class="btn btn-default" name="newMessage" value="New Message">
  </form><br><br>	
<?php
if(isset($_POST['delete'])){
	$mid = $_POST['messageid'];
	$sql = "DELETE FROM Messages WHERE MessageID='$mid'";
	$conn -> query($sql);
}

if(isset($_POST['Messageto'])){
	$Messageto=$_POST['Messageto'];
	echo "To-	".$_POST['receiver'];
}
if(isset($_POST['reply'])){
	$receiver=$_POST['receiver'];
	echo "To-	".$_POST['receiver'];?>

<br>
	<form action="MessageHandling.php" method="post">
	<textarea class="form-control" name="msg" rows='10' cols='50' required=''></textarea><br />
	<input type="hidden" name="sender" value=<?php echo $sender; ?>>
	<input type="hidden" name="messageTo" value=<?php echo $receiver; ?>>
	<input type="submit" class="btn btn-default"  name="Send" value="Send">
	</form>
<?php } 

elseif (isset($_POST['newMessage'])){ echo "<b>To -	</b>"?>
	<form class="form-horizontal" name="groups" action="MessageHandling.php" method="post"><br>
        <select class="form-control"  name="messageTo">
        <?php 
          $sql = "SELECT UserName from User WHERE ID<>'$ID' AND ID NOT IN (SELECT UserID FROM Blockedlist WHERE BlockID='$ID') AND ID<>1";
          $result = $conn -> query($sql);
          while($row=mysqli_fetch_assoc($result))
          { ?>
             <option value="<?php echo $row['UserName'];?>"><?php echo $row['UserName'];?></option>
          <?php } ?>
		  </select><br>
	<!--<input type="search" placeholder="username" name="messageTo" style="width:150px; border:3px solid; height:30px; padding:0px 3px; position:relative;"><br>	-->
	<textarea class="form-control" name="msg" rows='10' cols='50' required=''></textarea><br />
	<input type="hidden" name="sender" value=<?php echo $sender; ?>>
	<input type="submit" class="btn btn-default" name="Send" value="Send">
	</form>
	
<?php
 }?>
</div>

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
 }    
$Q1="select * from Messages inner join User on Receiver=UserName where ID='$AccID' order by Time";
$Q1prep=$dbconn->prepare($Q1);
$Q1prep->execute();
$Q1res=$Q1prep->fetchAll(PDO::FETCH_ASSOC);
$Q2="select * from Messages inner join User on Sender=UserName where ID='$AccID' order by Time";
$Q2prep=$dbconn->prepare($Q2);
$Q2prep->execute();
$Q2res=$Q2prep->fetchAll(PDO::FETCH_ASSOC);
$Q7="select * from User WHERE ID='$AccID'";
$Q7prep=$dbconn->prepare($Q7);
$Q7prep->execute();
$Q7res=$Q7prep->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['userName']=$Q7res[0]['UserName'];
?>
<br><br>
<div class="row">
<div class ="col-md-6">
<table>	
  <h4>Received Messages</h4><br><br>
<?php 
foreach($Q1res as $value){ ?>
<tr>
    <?php 
    echo "<i>From -  ".$value['Sender']."  Time -  ".$value['Time']."</i><br>".$value['Message']."<br><br>"; ?>
    <form action="MessageHandling.php" method="post">
    <input type="hidden" name="receiver" value=<?php echo $value['Sender']; ?>>	<!-- -->
    <input type="hidden" name="userName" value=<?php echo $Q1res[0]['UserName']; ?>>    <!--Remove this sender field as this can be collected in the reply throught the logged in user Id -->
    <input type="submit" class="btn btn-default" name="reply" value="Reply">
	<input type="hidden" name="messageid" value=<?php echo $value['MessageID']; ?>>
	<input type="submit" class="btn btn-default" name="delete" value="Delete">
  </form>
</tr>
<hr> <br><br>
<?php } ?>
</table>
</div>
<div class ="col-md-6">
<table>	
<h4>Sent Messages</h4><br><br>
<?php 
foreach($Q2res as $value){ ?>
<tr>
    <?php 
    echo "<i>To -  ".$value['Receiver']."  Time - ".$value['Time']."</i><br>".$value['Message']."<br><br>"; ?>
    <form action="MessageHandling.php" method="post">
    <input type="hidden" name="receiver" value=<?php echo $value['Receiver']; ?>>
	<!-- -->
	<input type="hidden" name="messageid" value=<?php echo $value['MessageID']; ?>>
    <input type="hidden" name="userName" value=<?php echo $Q2res[0]['UserName']; ?>>    <!--Remove this sender field as this can be collected in the reply throught the logged in user Id -->
    <input type="submit" class="btn btn-default" name="reply" value="Send Message">
	<input type="submit" class="btn btn-default" name="delete" value="Delete">
  </form>
</tr>
<hr> <br><br>
<?php } ?>
</table>
</div>
</div>
</div>
</body>
</html>
