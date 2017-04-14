<?php
session_start();
$UserId = $_SESSION['id'];
$MediaID = $_GET['id'];
include 'config.php';
$sql = "SELECT Channel FROM Media WHERE MediaID='$MediaID'";
$result = $conn -> query($sql);
$row = mysqli_fetch_assoc($result);

$cName = $row['Channel'];

$sql = "SELECT OwnerID FROM ChannelCreator WHERE Name='$cName'";
$result = $conn -> query($sql);
$row = mysqli_fetch_assoc($result);
$ownerID = $row['OwnerID'];


$sql1 = "select * from Media Where Channel='$cName' and Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID=$UserId) union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID=$UserId) or UploaderID=$UserId and UploaderID not in (select UserID from Blockedlist where BlockID=$UserId) union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID=$UserId) and UploaderID not in (select UserID from Blockedlist where BlockID=$UserId))";
$result = $conn -> query($sql1);


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
video-list-thumbs{}
.video-list-thumbs > li{
    margin-bottom:12px;
    width:360px;
    
}
.video-list-thumbs > li:last-child{}
.video-list-thumbs > li > a{
	display:block;
	position:relative;
	background-color: #111;
	color: #fff;
	padding: 8px;
	border-radius:3px
    transition:all 500ms ease-in-out;
    border-radius:4px
}
.video-list-thumbs > li > a:hover{
	box-shadow:0 2px 5px rgba(0,0,0,.3);
	text-decoration:none
}
.video-list-thumbs h2{
	bottom: 0;
	font-size: 14px;
	height: 33px;
	margin: 8px 0 0;
}
.video-list-thumbs .glyphicon-play-circle{
    font-size: 60px;
    opacity: 0.6;
    position: absolute;
    right: 39%;
    top: 31%;
    text-shadow: 0 1px 3px rgba(0,0,0,.5);
    transition:all 500ms ease-in-out;
}
.video-list-thumbs > li > a:hover .glyphicon-play-circle{
	color:#fff;
	opacity:1;
	text-shadow:0 1px 3px rgba(0,0,0,.8);
}
.video-list-thumbs .duration{
	background-color: rgba(0, 0, 0, 0.4);
	border-radius: 2px;
	color: #fff;
	font-size: 11px;
	font-weight: bold;
	left: 12px;
	line-height: 13px;
	padding: 2px 3px 1px;
	position: absolute;
	top: 12px;
    transition:all 500ms ease;
}
.video-list-thumbs > li > a:hover .duration{
	background-color:#000;
}
@media (min-width:320px) and (max-width: 360px) { 
	.video-list-thumbs .glyphicon-play-circle{
    font-size: 35px;
    right: 36%;
    top: 27%;
	}
	.video-list-thumbs h2{
		bottom: 0;
		font-size: 12px;
		height: 22px;
		margin: 8px 0 0;
	}


.row{
	margin-left:5%;
	padding:50px;
	
}

</style>
</head>

<body>
<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
  
     <a class="navbar-brand" href="home.php" style="color:white; padding-top:0px; padding-bottom:0px; font-size: 40px !important;">
MeTube
</a>
    </nav>
	
	<div class="container" style="text-align:center">
	<br><br>
	<h3>Media List in the Channel</h3>
	<br><br><br>
	
	<?php
	  if(!mysqli_num_rows($result))
	  {
		?>
		<h3>No Media in the Channel or You may not have the privileges to view the Media</h3>
		<?php
	  }
	  else{
		  
		  
		 	
	 while($row = mysqli_fetch_array($result))
	 {


			$MID = $row['MediaID'];
			
		 $sql5 = "SELECT * FROM Media WHERE MediaID='$MID'";
		 $result5 = $conn -> query($sql5);
		 $row5 = mysqli_fetch_assoc($result5);
		 $MID5 = $row5['MediaID'];
		 if($row5['Type']=='Video')
	  { 		  
		  ?>
		  <div class="row">
	<div class="col-md-6">
		  
		  
	 
				
				<video id="video" src="<?php echo $row5['URL']; ?>" type="video/mp4" width="360" height="176">
			</video>
			
			
		
       </div>
	   <div class="col-md-4">
		<a href="playvideo.php?id=<?php echo $row5['MediaID']; ?>">	<?php echo $row5['Name'];?></a>
		
		        <br>Views: <?php echo $row5['Views'];?>
			
			 </div></div><br>
	<?php 
	  }
      elseif($row5['Type']=='Audio')
	  {
		  ?>
		  <div class="row">
	<div class="col-md-6">
		<span class="glyphicon glyphicon-music" aria-hidden="true" style="font-size: 75px;"></span>
		</div>
	   <div class="col-md-4">
                <a href="playaudio.php?id=<?php echo $row5['MediaID']; ?>">	<?php echo $row5['Name'];?></a>
		        <br>Views: <?php echo $row5['Views'];?>
			
			</div></div><br>
		<?php  
	  }	
      else{
		  ?>
		  <div class="row">
	<div class="col-md-6">
				
				<img src="<?php echo $row5['URL']; ?>" alt="Image not displayed" width="360" height="176">
			</div>	
			<div class="col-md-4">
	  <?php if ($row5['Type']=='Image') { ?>
			<a href="showimage.php?id=<?php echo $row5['MediaID']; ?>">	<?php echo $row5['Name'];?></a>
	  <?php } ?>
	   <?php if ($row5['Type']=='Animation') { ?>
			<a href="showanimation.php?id=<?php echo $row5['MediaID']; ?>">	<?php echo $row5['Name'];?></a>
	  <?php } ?>
		        <br>Views: <?php echo $row5['Views'];?>
			</div></div><br>
		 <?php 
	  }?>
		 <br>
		 
	<?php }

		 
	}		
	  
	  
	 ?>
     
	 </div>
	
</body>
</html>