<?php 
session_start();
include 'config.php';

$GID = $_GET['id'];
$ID = $_SESSION['id'];

$sql = "SELECT Title From GroupDis WHERE GroupID='$GID'";

$result = $conn -> query($sql);

$row = mysqli_fetch_assoc($result);
$commerr='';
if(isset($_POST['submit']))
{
	if(empty($_POST['comment']))
		$commerr = "Please fill the field";
	else{
		$comment = $_POST['comment'];
		$sql1 = "INSERT INTO Discussion VALUES ('','$GID','$ID','$comment',now())";
        $conn -> query($sql1);		
	}
}

if (isset($_POST['delete']))
{
	$CID=$_POST['commentid'];
	$sql2 = "DELETE FROM Discussion WHERE ID='$CID'";
	$conn -> query($sql2);
}

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
	
	<div class="container">
	<div class="center-block">
	<br><br>
	<h2> <?php echo $row['Title']; ?> </h2>
	<br><br>
	<p>Discuss</p>
	<form class="form-horizontal" name="groups" method="post" action="discussions.php?id=<?php echo $GID; ?>">
	<div class="form-group">
      <div class="col-sm-10">        
        <textarea class="form-control" id="title" name="comment" rows="4" cols="500" required=""></textarea>
      </div>
    </div>
	<div class="form-group">        
      <div class="col-sm-offset-8 col-sm-2">
        <input type="submit" class="btn btn-default" id="ChannelButton1" name="submit" value="Comment">
      </div>
    </div>
	</form>
	<br><hr>
	
	<?php
	$sql2 = "SELECT Discussion.ID AS id,UserName, Comment, Time, UserID FROM User,Discussion WHERE User.ID=Discussion.UserID AND GroupID='$GID'";
	$result= $conn -> query($sql2);
	
	
	while($row = mysqli_fetch_assoc($result)){
	?>
	
	<p><?php echo $row['Comment']; ?></p><br><br>
	<p><i><?php echo $row['UserName']."    ".$row['Time']; ?></i></p>
    	<?php
		if($row['UserID']==$ID)
		{ ?>
	<form class="form-horizontal" name="groups1" method="post" action="discussions.php?id=<?php echo $GID; ?>">
	<input type="hidden" name="commentid" value="<?php echo $row['id']; ?>">
	<div class="form-group">        
      <div class="col-sm-offset-8 col-sm-2">
        <input type="submit" class="btn btn-default" id="ChannelButton2" name="delete" value="Delete">
      </div>
    </div>
	</form>
		<?php } ?>
	
	<br>
	<hr>
	<?php } ?>
	</div>
	</div>
</body>
</html>