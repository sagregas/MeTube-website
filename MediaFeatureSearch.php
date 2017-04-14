<?php
session_start();
require_once('config.php');
$UserId = $_SESSION['id'];


$Q1row='';
$Q1result='';
$Q2row='';
$Q2result='';
$Q3row='';
$Q3result='';
$Q4row='';
$Q4result='';
$Q5row='';
$Q5result='';
$Q6row='';
$Q6result='';
$count='';
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

.row{
	margin-left:5%;
	padding:50px;
	
}
.navbar-static-top {

background-color:black;
    border: 0px none;
    
    

}
.add-on .input-group-btn > .btn {
  border-left-width:0;left:-2px;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}
/* stop the glowing blue shadow */
.add-on .form-control:focus {
 box-shadow:none;
 -webkit-box-shadow:none; 
 border-color:#cccccc; 
}
#Userlinks{

color:white;
}


body{

padding-top: 50px;}
.navbar-fixed-top {
    border: 0px none;
    background-color:#F66733;
   
   
}
.btn:hover{
 color: #fff;
  background-color: #F66733;
}


.navbar-static-top {

background-color:black;
    border: 0px none;
    
    

}
.sidebar {
    background-color:#EEE;
    position: fixed;
    top: 120px;
    bottom: 0px;
    left: 0px;
    z-index: 1000;
    display: block;
    padding: 20px;
    overflow-x: hidden;
    overflow-y: auto;
    
    border-right: 1px solid #EEE;
    color:#FFF;
}
.nav-sidebar {
    margin-right: -21px;
    margin-bottom: 20px;
    margin-left: -20px;
}
.nav-sidebar li a {
    color:black;
}
.nav-sidebar li a:hover{
background-color:black;
color:white;
}
.nav-sidebar li a.active{
    background-color:#F66733;
    color:white;
}
.nav-sidebar > .active > a, .nav-sidebar > .active > a:hover, .nav-sidebar > .active > a:focus {
    color: #FFF;
    
}
.nav-sidebar > li > a {
    padding-right: 20px;
    padding-left: 20px;
}
.main {
   position: fixed;
    top: 120px;
    bottom: 0px;
    
    z-index: 1000;
    
   
    overflow-x: hidden;
    overflow-y: auto;
    
}
.main {
    padding: 20px;
}
.main .page-header {
    margin-top: 0px;
}
.placeholders {
    margin-bottom: 30px;
    text-align: center;
}
.navbar-center{
position:absolute;
text-align:center;
width:83%;
margin-top: 7px;
}
.navbar {
  padding-top: 20px;
  
}


#searchbar input[type=text]{width:500px;}
a#Userlinks:hover{
color:#F66733;
}
table.data {
    border-collapse: collapse;
    width: 100%;
}

table.data td {
    text-align: left;
    padding: 8px;
}
table.data th {
    text-align: left;
    padding: 8px;
    background-color:black;
    color:white;
}

table.data tr:nth-child(even){background-color: #f2f2f2}
 #tagcloud {
                width: 300px;
                background:#CFE3FF;
                color:#0066FF;
                padding: 10px;
                border: 1px solid #559DFF;
                text-align:center;
                -moz-border-radius: 4px;
                -webkit-border-radius: 4px;
                border-radius: 4px;
            }

             #tagcloud a:visited {
                text-decoration:none;
                color: #333;
            }

            #tagcloud a:hover {
                text-decoration: underline;
            }

            #tagcloud span {
                padding: 4px;
            }

            #tagcloud .smallest a{
                font-size: x-small;
                color:yellow;
            }

            #tagcloud .small a{
                font-size: small;
                color:blue;
            }

            #tagcloud .medium a{
                font-size:medium;
                color:red;
            }

            #tagcloud .large a{
                font-size:large;
                color:black;
            }

            #tagcloud .largest a{
                font-size:larger; 
                color:orange;  
            }
			.row{
				padding:0px;
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
	<div class="center-block" style="text-align:center">
	<h3>Search Results</h3><br><br>
<div class="row">
<?php
if(isset($_POST['dataSearch'])){

//Data format	
if(isset($_POST['mp4'])){
	$format=$_POST['mp4'];
	$format="'%".$format."'";
	
	$Q1="select * from Media where URL like $format and (Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) or UploaderID=$UserId)";
	$Q1result=$conn->query($Q1);
	if(mysqli_num_rows($Q1result)!=0)
	{
		$count=1;
		
	}
	

}
if(isset($_POST['jpeg'])){
	$format=$_POST['jpeg'];
	$format="'%".$format."'";
	
	
	$Q2="select * from Media where URL like $format and Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') or UploaderID=$UserId and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId'))";
	$Q2result=$conn->query($Q2);
	if(mysqli_num_rows($Q2result))
	{
		$count=1;
		$Q2row=mysqli_fetch_assoc($Q2result);
	}
}
if(isset($_POST['mp3'])){
	$format=$_POST['mp3'];
	$format="'%".$format."'";
	
	
	$Q5="select * from Media where URL like $format and (Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) or UploaderID=$UserId)";
	$Q5result=$conn->query($Q5);
	if(mysqli_num_rows($Q5result))
	{
		$count=1;
		$Q5row=mysqli_fetch_assoc($Q5result);
	}
}
if(isset($_POST['jpg'])){
	$format=$_POST['jpg'];
	$format="'%".$format."'";
	
	$Q3="select * from Media where URL like $format and (Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) or UploaderID=$UserId)";
	$Q3result=$conn->query($Q3);
	if(mysqli_num_rows($Q3result))
	{
		$count=1;
		$Q3row=mysqli_fetch_assoc($Q3result);
	}
}
if(isset($_POST['png'])){
	$format=$_POST['png'];
	$format="'%".$format."'";
	
	$Q4="select * from Media where URL like $format and (Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) or UploaderID=$UserId)";
	$Q4result=$conn->query($Q4);
	if(mysqli_num_rows($Q4result))
	{
		$count=1;
		$Q4row=mysqli_fetch_assoc($Q4result);
	}
}
if(isset($_POST['gif'])){
	$format=$_POST['gif'];
	$format="'%".$format."'";
	
	$Q6="select * from Media where URL like $format and (Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) or UploaderID=$UserId)";
	$Q6result=$conn->query($Q6);
	if(mysqli_num_rows($Q6result))
	{
		$count=1;
		$Q6row=mysqli_fetch_assoc($Q6result);
	}
}

if($count==0)
{
	?>
	<h3>No Media to display or You dont have the privileges to view the media</h3>
	<?php
}
else
{
	if($Q1result!='')
while($Q1row = mysqli_fetch_array($Q1result))
	 {


			$MID = $Q1row['MediaID'];
		 $sqlsql = "SELECT UserName From User,Media WHERE ID=UploaderID AND MediaID='$MID'";
			 $reres = $conn -> query($sqlsql);
			 $rowrow = mysqli_fetch_assoc($reres);
			 $upid = $rowrow['UserName'];
			
		 
		  ?>
		  <div class="row">
	<div class="col-md-6">
		  
		  
	 
				
				<video id="video" src="<?php echo $Q1row['URL']; ?>" type="video/mp4" width="360" height="176">
			</video>
			
			
		
       </div>
	   <div class="col-md-4">
		<a href="playvideo.php?id=<?php echo $Q1row['MediaID']; ?>">	<?php echo $Q1row['Name'];?></a>
		
		        <br>Views: <?php echo $Q1row['Views'];?>
			<br>Uploader: <?php echo $upid;?>
			 </div></div><br>

		 <br>
		 
	<?php }

	if($Q5result!='')
while($Q5row = mysqli_fetch_array($Q5result))
	 {


			$MID = $Q5row['MediaID'];
		 $sqlsql = "SELECT UserName From User,Media WHERE ID=UploaderID AND MediaID='$MID'";
			 $reres = $conn -> query($sqlsql);
			 $rowrow = mysqli_fetch_assoc($reres);
			 $upid = $rowrow['UserName'];
			
		 
		  ?>
		  <div class="row">
	<div class="col-md-6">
		  
		  
	           <span class="glyphicon gylphicon-music" aria-hidden="true" style="font-size:75px;"></span>
				
				
			
			
		
       </div>
	   <div class="col-md-4">
		<a href="playaudio.php?id=<?php echo $Q5row['MediaID']; ?>">	<?php echo $Q5row['Name'];?></a>
		
		        <br>Views: <?php echo $Q5row['Views'];?>
			<br>Uploader: <?php echo $upid;?>
			 </div></div><br>

		 <br>
		 
	<?php }	 
if($Q2result!='')
while($Q2row = mysqli_fetch_array($Q2result))
	 {


			$MID = $Q2row['MediaID'];
		 $sqlsql = "SELECT UserName From User,Media WHERE ID=UploaderID AND MediaID='$MID'";
			 $reres = $conn -> query($sqlsql);
			 $rowrow = mysqli_fetch_assoc($reres);
			 $upid = $rowrow['UserName'];
			
		 
		  ?>
		   <div class="row">
	<div class="col-md-6">
				
				<img src="<?php echo $Q2row['URL']; ?>" alt="Image not displayed" width="360" height="176">
			</div>	
			<div class="col-md-4">
	 
			<a href="showimage.php?id=<?php echo $Q2row['MediaID']; ?>">	<?php echo $Q2row['Name'];?></a>
	 
		        <br>Views: <?php echo $Q2row['Views'];?>
				<br>Uploader: <?php echo $upid;?>
			</div></div><br>

		 <br>
		 
	<?php }
	if($Q6result!='')
while($Q6row = mysqli_fetch_array($Q6result))
	 {
        //print_r($Q6row);

			$MID = $Q6row['MediaID'];
		 $sqlsql = "SELECT UserName From User,Media WHERE ID=UploaderID AND MediaID='$MID'";
			 $reres = $conn -> query($sqlsql);
			 $rowrow = mysqli_fetch_assoc($reres);
			 $upid = $rowrow['UserName'];
			
		 
		  ?>
		   <div class="row">
	<div class="col-md-6">
				
				<img src="<?php echo $Q6row['URL']; ?>" alt="Image not displayed" width="360" height="176">
			</div>	
			<div class="col-md-4">
	 
			<a href="showimage.php?id=<?php echo $Q2row['MediaID']; ?>">	<?php echo $Q6row['Name'];?></a>
	 
		        <br>Views: <?php echo $Q6row['Views'];?>
				<br>Uploader: <?php echo $upid;?>
			</div></div><br>

		 <br>
		 
	<?php }
if($Q3result!='')
	while($Q3row = mysqli_fetch_array($Q3result))
	 {


			$MID = $Q3row['MediaID'];
		 $sqlsql = "SELECT UserName From User,Media WHERE ID=UploaderID AND MediaID='$MID'";
			 $reres = $conn -> query($sqlsql);
			 $rowrow = mysqli_fetch_assoc($reres);
			 $upid = $rowrow['UserName'];
			
		 
		  ?>
		  <div class="row">
	<div class="col-md-6">
				
				<img src="<?php echo $Q3row['URL']; ?>" alt="Image not displayed" width="360" height="176">
			</div>	
			<div class="col-md-4">
	 
			<a href="showimage.php?id=<?php echo $Q3row['MediaID']; ?>">	<?php echo $Q3row['Name'];?></a>
	 
		        <br>Views: <?php echo $Q3row['Views'];?>
				<br>Uploader: <?php echo $upid;?>
			</div></div><br>

		 <br>
		 
	<?php }
if($Q4result!='')	
	while($Q4row = mysqli_fetch_array($Q4result))
	 {


			$MID = $Q4row['MediaID'];
		 $sqlsql = "SELECT UserName From User,Media WHERE ID=UploaderID AND MediaID='$MID'";
			 $reres = $conn -> query($sqlsql);
			 $rowrow = mysqli_fetch_assoc($reres);
			 $upid = $rowrow['UserName'];
			
		 
		  ?>
		  <div class="row">
	<div class="col-md-6">
				
				<img src="<?php echo $Q4row['URL']; ?>" alt="Image not displayed" width="360" height="176">
			</div>	
			<div class="col-md-4">
	 
			<a href="showimage.php?id=<?php echo $Q4row['MediaID']; ?>">	<?php echo $Q4row['Name'];?></a>
	 
		        <br>Views: <?php echo $Q4row['Views'];?>
				<br>Uploader: <?php echo $upid;?>
			</div></div><br>

		 <br>
		 
	<?php }	 
}


}

	if(isset($_POST['time'])){
	$time=$_POST['time'];
	

	if($time=='last day'){
		$yesterday=date("Y-m-d", time() - 60 * 60 * 24);
		
		$Q5="select * from Media where UploadTime>'$yesterday' and (Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId')  and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) or UploaderID=$UserId)";
	}
	elseif ($time=='last week') {
		$pastWeek=date("Y-m-d", time() - 60 * 60 * 24*7);
		$Q5="select * from Media where UploadTime>'$pastWeek' and (Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) or UploaderID=$UserId)";
	}
	elseif ($time=='last month') {
		$pastMonth=date("Y-m-d",time()-60*60*24*30);
		$Q5="select * from Media where UploadTime>'$pastMonth' and (Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) or UploaderID=$UserId)";
	}
	else{			//default behavior
		$pastYear=date("Y-m-d",time()-60*60*24*7*52);
		$Q5="select * from Media where UploadTime>'$pastYear' and (Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) or UploaderID=$UserId)";
	}

	$Q5result=$conn->query($Q5);
	
	
	
	if(!mysqli_num_rows($Q5result))
	  {
		?>
		<h3>No Media to display or You dont have the privileges to view the media</h3>
		<?php
	  }
	  else{
		  
		  
		 	
	 while($Q5row = mysqli_fetch_array($Q5result))
	 {


			$MID = $Q5row['MediaID'];
			
		
		 
			 
			 $sqlsql = "SELECT UserName From User,Media WHERE ID=UploaderID AND MediaID='$MID'";
			 $reres = $conn -> query($sqlsql);
			 $rowrow = mysqli_fetch_assoc($reres);
			 $upid = $rowrow['UserName'];
			
		 if($Q5row['Type']=='Video')
	  { 		  
		  ?>
		  <div class="row">
	<div class="col-md-6">
		  
		  
	 
				
				<video id="video" src="<?php echo $Q5row['URL']; ?>" type="video/mp4" width="360" height="176">
			</video>
			
			
		
       </div>
	   <div class="col-md-4">
		<a href="playvideo.php?id=<?php echo $Q5row['MediaID']; ?>">	<?php echo $Q5row['Name'];?></a>
		
		        <br>Views: <?php echo $Q5row['Views'];?>
			<br>Uploader: <?php echo $upid;?>
			 </div></div><br>
	<?php 
	  }
      elseif($Q5row['Type']=='Audio')
	  {
		  ?>
		  <div class="row">
	<div class="col-md-6">
		<span class="glyphicon glyphicon-music" aria-hidden="true" style="font-size: 75px;"></span>
		</div>
	   <div class="col-md-4">
                <a href="playaudio.php?id=<?php echo $Q5row['MediaID']; ?>">	<?php echo $Q5row['Name'];?></a>
		        <br>Views: <?php echo $Q5row['Views'];?>
			<br>Uploader: <?php echo $upid;?>
			</div></div><br>
		<?php  
	  }	
      else{
		  ?>
		  <div class="row">
	<div class="col-md-6">
				
				<img src="<?php echo $Q5row['URL']; ?>" alt="Image not displayed" width="360" height="176">
			</div>	
			<div class="col-md-4">
	  <?php if ($Q5row['Type']=='Image') { ?>
			<a href="showimage.php?id=<?php echo $Q5row['MediaID']; ?>">	<?php echo $Q5row['Name'];?></a>
	  <?php } ?>
	   <?php if ($Q5row['Type']=='Animation') { ?>
			<a href="showanimation.php?id=<?php echo $Q5row['MediaID']; ?>">	<?php echo $Q5row['Name'];?></a>
	  <?php } ?>
		        <br>Views: <?php echo $Q5row['Views'];?>
				<br>Uploader: <?php echo $upid;?>
			</div></div><br>
		 <?php 
	  }?>
		 <br>
		 
	<?php }

		 
	}		
	  
	
	
	
	
	
}
if(isset($_POST['sizeSearch'])){
	//$size=$_POST['filesize'];
	$Q="select URL from Media where Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) or UploaderID=$UserId";
	$Qprep=$dbconn->prepare($Q);
	$Qprep->execute();
	$Qres=$Qprep->fetchAll(PDO::FETCH_ASSOC);
	$size=array();
	//echo "filesize is".filesize($Qres[1]['URL']);
	//print_r($Qres);
	foreach ($Qres as $key=>$value) {
		//echo "url is".$value['URL'];
		if((filesize($value['URL'])) < 100000 && isset($_POST['100kb'])){
			
			array_push($size, $value['URL']);
			
		}
		elseif((filesize($value['URL'])) < 1000000 && isset($_POST['1mb'])){
			
			array_push($size, $value['URL']);
			
		}
		elseif(filesize($value['URL']) < 10000000 && isset($_POST['10mb'])){
			
			array_push($size, $value['URL']);
			
		}
		else{
			if(isset($_POST['100mb'])){
			
			array_push($size, $value['URL']);
			
			}
		}
		//print_r($size);
	}
	if(empty($size))
		{
		?>
		<h3>No Media to display or You dont have the privileges to view the media</h3>
		<?php
	  }
	  else{
		
	foreach($size as $URL){
		
		$sqlsql = "SELECT MediaID,UserName,Type From User,Media WHERE ID=UploaderID AND URL='$URL'";
			 $reres = $conn -> query($sqlsql);
			 $rowrow = mysqli_fetch_assoc($reres);
			 $upid = $rowrow['UserName'];
			 $mtype=$rowrow['Type'];
			 $mID=$rowrow['MediaID'];
			 $sqlsql1 = "SELECT Name,Views FROM Media WHERE URL='$URL'";
			 $reres1 = $conn -> query($sqlsql1);
			 $rowrow1 = mysqli_fetch_assoc($reres1);
			 $mName = $rowrow1['Name'];
			 $mViews = $rowrow1['Views'];
			 	 if($mtype=='Video')
	  { 		  
		  ?>
		  <div class="row">
	<div class="col-md-6">
		  
		  
	 
				
				<video id="video" src="<?php echo $URL; ?>" type="video/mp4" width="360" height="176">
			</video>
			
			
		
       </div>
	   <div class="col-md-4">
		<a href="playvideo.php?id=<?php echo $mID; ?>">	<?php echo $mName;?></a>
		
		        <br>Views: <?php echo $mViews;?>
			<br>Uploader: <?php echo $upid;?>
			 </div></div><br>
	<?php 
	  }
      elseif($mtype=='Audio')
	  {
		  ?>
		  <div class="row">
	<div class="col-md-6">
		<span class="glyphicon glyphicon-music" aria-hidden="true" style="font-size: 75px;"></span>
		</div>
	   <div class="col-md-4">
                <a href="playaudio.php?id=<?php echo $mID; ?>">	<?php echo $mName;?></a>
		        <br>Views: <?php echo $mViews;?>
			<br>Uploader: <?php echo $upid;?>
			</div></div><br>
		<?php  
	  }	
      else{
		  ?>
		  <div class="row">
	<div class="col-md-6">
				
				<img src="<?php echo $URL; ?>" alt="Image not displayed" width="360" height="176">
			</div>	
			<div class="col-md-4">
	  <?php if ($mtype=='Image') { ?>
			<a href="showimage.php?id=<?php echo $mID; ?>">	<?php echo $mName;?></a>
	  <?php } ?>
	   <?php if ($mtype=='Animation') { ?>
			<a href="showanimation.php?id=<?php echo $mID; ?>">	<?php echo $mName;?></a>
	  <?php } ?>
		        <br>Views: <?php echo $mViews;?>
				<br>Uploader: <?php echo $upid;?>
			</div></div><br>
		 <?php 
	  }?>
		 <br>
			 <?php
			 
	}
}	
}	  
	  
	 ?>
</div>
</div>
</div>
</body>
</html>

