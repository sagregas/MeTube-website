<?php
session_start();
$UserId='';
$search='';
$type='';
$category='';
require_once('config.php');
if(array_key_exists('id', $_SESSION)){
$UserId=$_SESSION['id'];
}

if(!empty($_GET['word']))
{
	$search=$_GET['word'];
    $type='All';
    $category='All';
}
else{
if(isset($_POST['searchmedia'])){
	$category=$_POST['category'];
	$type=$_POST['type'];
	$search=$_POST['search'];
}}
	$search=strtolower($search);
	

	if($type=='All')
		{$type="'%'";}
	else
		{$type = "'".$type."'";}
	if($category=='All')
		{$category="'%'";}
	else
		{$category = "'".$category."'";}
	
    if(!empty($UserId))
	{$sql="select * from Media where Type like $type and Category like $category and Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID=$UserId) union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID=$UserId) or UploaderID=$UserId and UploaderID not in (select UserID from Blockedlist where BlockID=$UserId) union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID=$UserId) and UploaderID not in (select UserID from Blockedlist where BlockID=$UserId)) order by Counter desc";
	}
    else
	{
		$sql = "select * from Media where Type like $type and Category like $category and Media.MediaID in (select Media.MediaID from Media where Sharing='Public')";
	}		
	$row=$dbconn->prepare($sql);
	$row->execute();
	$result=$row->fetchAll(PDO::FETCH_ASSOC); 
	//print_r($result);
	$sqlup="update Media set Counter='0' where Type not like $type and Category not like $category and Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID=$UserId) union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID=$UserId) or UploaderID=$UserId and UploaderID not in (select UserID from Blockedlist where BlockID=$UserId) union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID=$UserId) and UploaderID not in (select UserID from Blockedlist where BlockID=$UserId)) order by Counter desc";
	$rowup=$dbconn->prepare($sqlup);
	$rowup->execute();
	$resultup=$rowup->fetchAll(PDO::FETCH_ASSOC); 
	//print_r($result);
	foreach ($result as $key => $value) 
	{ 
	    $keyword=$value['Keywords'];
	    $medId=$value['MediaID'];
		$value['Name']=strtolower($value['Name']);
	    //print_r($value['Keywords']);
	    $temp=0;
		$temp1=0;
	    	 //this is used to avoid checking keywords against the clicked media(self)
		    $pieces=explode(" ", $keyword);
//print_r($pieces);			
		    foreach ($pieces as $valuee) {
		        //echo $value."/n";
		        //echo $value;
				$valuee=strtolower($valuee);
			
				 $temp=$temp+substr_count($search, $valuee);
	             		
				//echo $temp;
				//echo $search;
		    }
			
		    $pieces=explode(" ", $search); 
            if(!empty($search))
		    foreach ($pieces as $valuee) {
		        //echo $value."/n";
		        //echo $value;
		        
		        $temp1=$temp1+substr_count($value['Name'], $valuee);
		    }
			$temp2=$temp+$temp1;
		   // echo $temp;
	        //Entering into the counter column of the table
	    $Q1="update Media set Counter='$temp2' where MediaID='$medId'";
	    $Q1prep=$dbconn->prepare($Q1);
	    $Q1prep->execute();
	}

	/*foreach ($result as $key => $value) 
	{ 
	    $medId=$value['MediaID'];
	    
	         $temp1=0;
	    	 //this is used to avoid checking keywords against the clicked media(self)
$value['Name']=strtolower($value['Name']);
		    $pieces=explode(" ", $search); 
            if(!empty($search))
		    foreach ($pieces as $valuee) {
		        //echo $value."/n";
		        //echo $value;
		        
		        $temp1=$temp1+substr_count($value['Name'], $valuee);
		    }
		    $temp1 = $temp1+$temp;
	        //Entering into the counter column of the table
	    $Q1="update Media set Counter='$temp1' where MediaID='$medId'";
	    $Q1prep=$dbconn->prepare($Q1);
	    $Q1prep->execute();
	}*/
if($UserId){
if(!empty($search)){
			$sql1="select * from Media where Type like $type and Category like $category and Counter<>'0' and Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID=$UserId) union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID=$UserId) or UploaderID=$UserId and UploaderID not in (select UserID from Blockedlist where BlockID=$UserId) union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID=$UserId) and UploaderID not in (select UserID from Blockedlist where BlockID=$UserId)) order by Counter desc";
}else{
			$sql1="select * from Media where Type like $type and Category like $category and Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID=$UserId) union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID=$UserId) or UploaderID=$UserId and UploaderID not in (select UserID from Blockedlist where BlockID=$UserId) union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID=$UserId) and UploaderID not in (select UserID from Blockedlist where BlockID=$UserId)) order by Counter desc";	
			}
			
}
else
{
	if(!empty($search)){
		$sql1="select * from Media where Type like $type and Category like $category and Counter<>'0' and Media.MediaID in (select Media.MediaID from Media where Sharing='Public')";
	}
	else{
		$sql1="select * from Media where Type like $type and Category like $category and Media.MediaID in (select Media.MediaID from Media where Sharing='Public')";
	}
}	
$result1=$conn->query($sql1);			
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
</style>
</head>

<body>
<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
  
     <a class="navbar-brand" href="home.php" style="color:white; padding-top:0px; padding-bottom:0px; font-size: 40px !important;">
MeTube
</a>
    </nav>
	<nav class="navbar navbar-default navbar-inverse navbar-static-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            
            <li><a id="Userlinks"  href="home.php">Home</a></li>
            
          </ul>
          <form class="navbar-form navbar-center" id="searchbar" method="post" action="searchmedia.php" style="width:80%">
            <div class="input-group add-on">
			<select class="form-control" style="width:15%" name="type">
        <option value="All">All</option>
        <option value="Video">Video</option>
        <option value="Audio">Audio</option>
        <option value="Image">Image</option>
		<option value="Animation">Animation</option>
		
      </select>
	  <select class="form-control" style="width:15%" name="category">
        <option value="All">All</option>
        <option value="Music">Music</option>
        <option value="Entertainment">Entertainment</option>
        <option value="Sports">Sports</option>
		<option value="Gaming">Gaming</option>
		<option value="News">News</option>
      </select>
            <input type="text" style="width:70%" class="form-control" name="search" placeholder="Search Media..">
			
            <div class="input-group-btn">
        <input type="submit" name="searchmedia"  class="btn btn-default" value="Go!">
      </div>
    </div>
          </form>
   
        </div>
      </div>
    </nav>
	<div class="container-fluid" style="text-align:center">
	<div class="row" style="padding:0px;margin-left:0px">
    <div class="col-md-7">	
	
	<br><br>
	<h3>Search Results</h3>
	<br><br><br>
<?php
	  if(!mysqli_num_rows($result1))
	  {
		?>
		<h3>No Media to display or You dont have the privileges to view the media</h3>
		<?php
	  }
	  else{
		  
		  
		 	
	 while($row1 = mysqli_fetch_array($result1))
	 {


			$MID = $row1['MediaID'];
			
		 $sql5 = "SELECT * FROM Media WHERE MediaID='$MID'";
		 $result5 = $conn -> query($sql5);
		 $row5 = mysqli_fetch_assoc($result5);
		 $MID5 = $row5['MediaID'];
		 
			 
			 $sqlsql = "SELECT UserName From User,Media WHERE ID=UploaderID AND MediaID='$MID'";
			 $reres = $conn -> query($sqlsql);
			 $rowrow = mysqli_fetch_assoc($reres);
			 $upid = $rowrow['UserName'];
			
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
			<br>Uploader: <?php echo $upid;?>
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
			<br>Uploader: <?php echo $upid;?>
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
				<br>Uploader: <?php echo $upid;?>
			</div></div><br>
		 <?php 
	  }?>
		 <br>
		 
	<?php }

		 
	}		
	  
	  
	 ?>
     </div>
	 
	 <div class="col-md-5">
	 <br><br>
	<h3>Word Cloud</h3>
	<br><br><br>
	 <?php include 'WordCloud.php'; ?>
	 </div>
	 </div>
	 </div>
	<!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
         	

        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
</body>
</html>

		
