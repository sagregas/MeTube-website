<?php
session_start();
$ID = $_SESSION['id'];

include 'config.php';
$sql = "SELECT * FROM Playlist WHERE UserID='$ID' ORDER BY TimeAdded LIMIT 1";
$result = $conn -> query($sql);

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
}

</style>
</head>

<body>
<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
  
     <a class="navbar-brand" href="home.php" style="color:white; padding-top:0px; padding-bottom:0px; font-size: 40px !important;">
MeTube
</a>
    </nav>
	
	<div class="container-fluid">
	<div class="row">
	<div class="col-md-8">
	
	<?php
	  if(!mysqli_num_rows($result))
	  {
		?>
		<h3>You have no media in your playlist</h3>
		<?php
	  }
	  else{
		  $row = mysqli_fetch_array($result);
		  $MID = $row['MediaID'];
		  $sql1 = "SELECT * FROM Media WHERE MediaID='$MID'";
		  $result1= $conn -> query($sql1);
		  $row1 = mysqli_fetch_assoc($result1); 
		  //update the time here
		  $sql2 = "UPDATE Playlist SET TimeAdded = now() WHERE MediaID='$MID' AND UserID='$ID'";
		  $conn -> query($sql2);
		?>
  <div id="Media" style="margin:100px">	
<?php  
	  if($row1['Type']=='Video')
	  { 
		  
		  ?>
		  
	  <h1><?php echo $row1['Name']; ?></h1><br><br>
		<video id="video1" src="<?php echo $row1['URL']; ?>" type="video/mp4" width="700" height="400" controls="controls">
		</video>
	<?php 
	  }
      elseif($row1['Type']=='Audio')
	  {
		  ?>
		  <h1><?php echo $row1['Name']; ?></h1><br><br>
		<audio controls>
  		<source src="<?php echo $row1['URL'];?>" type="audio/mpeg">
		</audio>
		<?php  
	  }	
      else{
		  ?>
		  <h1><?php echo $row1['Name']; ?></h1><br><br>
		<img src="<?php echo $row1['URL']; ?>" alt="Image not displayed" width="700" height="400">
		 <?php 
	  }?>
</div>
</div>
	 <div class="col-md-4" style="margin-top:50px">
	 <br><br>
	 <?php 
	 $sql3 = "SELECT * FROM Playlist WHERE MediaID<>'$MID' AND UserID='$ID' ORDER BY TimeAdded LIMIT 1";
	 $result3 = $conn -> query($sql3);
	 if(mysqli_num_rows($result3))
	 {?>
	 <h4>Click on the media below for next</h4>
	 <?php
	    $row2 = mysqli_fetch_array($result3);
		$MID2 = $row2['MediaID'];
		$sql3 = "SELECT * FROM Media WHERE MediaID='$MID2'";
		  $result3= $conn -> query($sql3);
		  $row2 = mysqli_fetch_assoc($result3); 
		   $sqlsql = "SELECT UserName From User,Media WHERE ID=UploaderID AND MediaID='$MID2'";
			 $reres = $conn -> query($sqlsql);
			 $rowrow = mysqli_fetch_assoc($reres);
			 $upid = $rowrow['UserName'];
	    if($row2['Type']=='Video')
	  { 		  
		  ?>
		  
		  <div>
		  <ul class="list-unstyled video-list-thumbs row" style="margin-left:5px">
		  
	  <li>
				<a href="playlist.php">
				<video id="video" src="<?php echo $row2['URL']; ?>" type="video/mp4" width="360" height="176" class="img-responsive">
			</video>
<span class="glyphicon glyphicon-play-circle"></span></a>
			<?php echo $row2['Name'];?>
			<br>Uploader: <?php echo $upid;?>
		        <br>Views: <?php echo $row2['Views'];?>
				
			
			</li><br>
			</ul> </div>
	<?php 
	  }
      elseif($row2['Type']=='Audio')
	  {
		  ?>
		 <ul style="list-style-type:none; padding:0px">
		<span class="glyphicon glyphicon-music" aria-hidden="true" style="font-size: 75px;"></span>
			<li>
<a href="playlist.php"><?php echo $row2['Name']; ?></a>
<br>Uploader: <?php echo $upid;?>
		        <br>Views: <?php echo $row2['Views'];?>
			
			</li></ul>
		<?php  
	  }	
      else{
		  ?>
		  <ul style="list-style-type:none; padding:0px">
		  <li>
				<a href="playlist.php">
				<img src="<?php echo $row2['URL']; ?>" alt="Image not displayed" width="360" height="176"></a><br>
			<?php echo $row2['Name'];?>
			<br>Uploader: <?php echo $upid;?>
		        <br>Views: <?php echo $row2['Views'];?>
			</li></ul>
		 <?php 
	  }?>
	 
	 
	 <hr>
	
	  
	<?php  
	
	
	
	
	$sql4 = "SELECT MediaID FROM Playlist WHERE MediaID<>'$MID' AND MediaID<>'$MID2' AND UserID='$ID' ORDER BY TimeAdded";
	$result4 = $conn -> query($sql4);
	if(mysqli_num_rows($result4))
	{
	?>	
	<h4>Next Media in Circular Queue</h4>
<?php	
	 while($row4 = mysqli_fetch_array($result4))
	 {
		 $MID3 = $row4['MediaID'];
		 $sql5 = "SELECT * FROM Media WHERE MediaID='$MID3'";
		 $result5 = $conn -> query($sql5);
		 $row5 = mysqli_fetch_assoc($result5);
		  $sqlsql = "SELECT UserName From User,Media WHERE ID=UploaderID AND MediaID='$MID3'";
			 $reres = $conn -> query($sqlsql);
			 $rowrow = mysqli_fetch_assoc($reres);
			 $upid = $rowrow['UserName'];
		 if($row5['Type']=='Video')
	  { 		  
		  ?>
		  <div>
		  <ul style="list-style-type:none ; padding:0px">
		  
	  <li>
				
				<video id="video" src="<?php echo $row5['URL']; ?>" type="video/mp4" width="360" height="176">
			</video>
            <br>
			<?php echo $row5['Name'];?>
			<br>Uploader: <?php echo $upid;?>
		        <br>Views: <?php echo $row5['Views'];?>
				
			
			</li><br>
			</ul> </div>
	<?php 
	  }
      elseif($row5['Type']=='Audio')
	  {
		  ?>
		   <ul style="list-style-type:none; padding:0px">
		<span class="glyphicon glyphicon-music" aria-hidden="true" style="font-size: 75px;"></span>
			<li>
                <?php echo $row5['Name']; ?>
				<br>Uploader: <?php echo $upid;?>
		        <br>Views: <?php echo $row5['Views'];?>
				
			
			</li>
		<?php  
	  }	
      else{
		  ?>
		   <ul style="list-style-type:none;padding:0px">
		  <li>
				
				<img src="<?php echo $row5['URL']; ?>" alt="Image not displayed" width="360" height="176"><br>
			<?php echo $row5['Name'];?>
			<br>Uploader: <?php echo $upid;?>
		        <br>Views: <?php echo $row5['Views'];?>
				
			</li></ul>
		 <?php 
	  }?>
		 <br>
		 
	<?php }

		 
	}		
	  
	 }  }
	 ?>
     
	 </div>
	</div>
	</div>
</body>
</html>