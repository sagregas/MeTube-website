<?php session_start(); 
include 'config.php';
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
        
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $("#Videos").click(function(){
                $(this).addClass('active');
                $('#Images').removeClass('active');
 		$('#Animations').removeClass('active');
                $('#Music').removeClass('active');
		$('#Users').removeClass('active');
		
                $("#Videos1").show();
		$("#Images1").hide();
		$("#Music1").hide();		
		$("#Animations1").hide();
                $("#Users1").hide();
			
            });
            $("#Images").click(function(){
                $(this).addClass('active');
                $('#Videos').removeClass('active');
		$('#Animations').removeClass('active');
		$('#Music').removeClass('active');
		$('#Users').removeClass('active');
		
                $("#Images1").show();
                $("#Videos1").hide();
		$("#Music1").hide();
		$("#Users1").hide();
		
		$("#Animations1").hide();
		
            });
	   $("#Music").click(function(){
                $(this).addClass('active');
                $('#Videos').removeClass('active');
		$('#Animations').removeClass('active');
		$('#Images').removeClass('active');
		$('#Users').removeClass('active');
		
                $("#Music1").show();
                $("#Videos1").hide();
		$("#Images1").hide();
		$("#Users1").hide();
		
		$("#Animations1").hide();
		
            });
           $("#Animations").click(function(){
                $(this).addClass('active');
                $('#Videos').removeClass('active');
		$('#Images').removeClass('active');
		$('#Users').removeClass('active');
                $('#Music').removeClass('active');
		
                $("#Animations1").show();
                $("#Videos1").hide();
		$("#Images1").hide();
		$("#Music1").hide();
		$("#Users1").hide();
		
            });
            $("#Users").click(function(){
                $(this).addClass('active');
                $('#Videos').removeClass('active');
		$('#Images').removeClass('active');
		$('#Animations').removeClass('active');
                $('#Music').removeClass('active');
		
                $("#Users1").show();
                $("#Videos1").hide();
		$("#Images1").hide();
		$("#Music1").hide();
		$("#Animations1").hide();
		
            });
            
	    
        });
    </script>
    <style>
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
a#Userlinks:hover{
color:#F66733;
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

    </style>
</head>

<body>
<nav class="navbar navbar-default navbar-fixed-top">
  
     <a class="navbar-brand" href="adminhome.php" style="color:white; padding-top:0px; padding-bottom:0px; font-size: 40px !important;">
MeTube
</a>
    </nav>
<nav class="navbar navbar-default navbar-static-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" id="Userlinks">Welcome Admin</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
           
     
       <li><a id="Userlinks" href="featuresearch.php">Adv.Search</a></li>
            <li><a id="Userlinks" href="Logout.php">Logout</a></li>
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
            <input type="text" class="form-control" name="search" placeholder="Search Media..">
			
            <div class="input-group-btn">
        <input type="submit" name="searchmedia" class="btn btn-default" value="Go!">
      </div>
    </div>
          </form>
        </div>
      </div>
    </nav>
<div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">

    <li><a id="Videos" class="active" href="#Videos" >Videos</a></li>
    <li><a id="Images" href="#Images">Images</a></li>
    <li><a id="Music" href="#Music">Music</a></li>
    <li><a id="Animations" href="#Animations">Animations</a></li>
    <li><a id="Users" href="#Users">Users</a></li>
    

</ul>
 </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
          <div>

    <div id="Videos1" >
      <?php 
        $sql = "SELECT MediaID,UploaderID, Name, Category, Channel, UploadTime FROM Media WHERE Type='Video'";
        $result = $conn -> query($sql);
        $count= mysqli_num_rows($result);
        if($count==0)
        echo "No videos";
        else{
         ?>
	<table class="data">
	<form name="blockmanager1" method="post" action="adminmanager.php">
	<tr>
	<th>Uploader</th>
	<th>Name</th>
	<th>Category</th>
	<th>Channel</th>
	<th>Upload Time</th>
       
	<th>Delete</th>
	</tr> 
        <?php
while($row=$result->fetch_assoc()){
?>
 <tr>
        
            <td>
    <?php
      echo $row['UploaderID'];
    ?>    </td>
    <td>
    <?php
      echo $row['Name'];
    ?>    </td>
<td>
    <?php
      echo $row['Category'];
    ?>    </td>
<td>
    <?php
      echo $row['Channel'];
    ?>    </td>
<td>
    <?php
      echo $row['UploadTime'];
    ?>    </td>

            <td>
<input type="checkbox" name="<?php echo $row['MediaID']; ?>" >
</td>
</tr>

<?php


}
?>
</table>
<input type="submit" class="btn" name="submit" value="Confirm">
</form>
<?php } ?>

         
    </div>
    <div id="Images1" style="display:none">
       <?php 
        $sql = "SELECT MediaID,UploaderID, Name, Category, Channel, UploadTime FROM Media WHERE Type='Image'";
        $result = $conn -> query($sql);
        $count= mysqli_num_rows($result);
        if($count==0)
        echo "No Images";
        else{
         ?>
	<table class="data">
	<form name="blockmanager1" method="post" action="adminmanager.php">
	<tr>
	<th>Uploader</th>
	<th>Name</th>
	<th>Category</th>
	<th>Channel</th>
	<th>Upload Time</th>
        
	<th>Delete</th>
	</tr> 
        <?php
while($row=$result->fetch_assoc()){
?>
 <tr>
        
            <td>
    <?php
      echo $row['UploaderID'];
    ?>    </td>
    <td>
    <?php
      echo $row['Name'];
    ?>    </td>
<td>
    <?php
      echo $row['Category'];
    ?>    </td>
<td>
    <?php
      echo $row['Channel'];
    ?>    </td>
<td>
    <?php
      echo $row['UploadTime'];
    ?>    </td>

            <td>
<input type="checkbox" name="<?php echo $row['MediaID']; ?>" >
</td>
</tr>

<?php


}
?>
</table>
<input type="submit" class="btn" name="submit" value="Confirm">
</form>
<?php } ?>

    </div>
<div id="Music1" style="display:none">
         <?php 
        $sql = "SELECT MediaID,UploaderID, Name, Category, Channel, UploadTime FROM Media WHERE Type='Audio'";
        $result = $conn -> query($sql);
        $count= mysqli_num_rows($result);
        if($count==0)
        echo "No Music";
        else{
         ?>
	<table class="data">
	<form name="blockmanager1" method="post" action="adminmanager.php">
	<tr>
	<th>Uploader</th>
	<th>Name</th>
	<th>Category</th>
	<th>Channel</th>
	<th>Upload Time</th>
        
	<th>Delete</th>
	</tr> 
        <?php
while($row=$result->fetch_assoc()){
?>
 <tr>
        
            <td>
    <?php
      echo $row['UploaderID'];
    ?>    </td>
    <td>
    <?php
      echo $row['Name'];
    ?>    </td>
<td>
    <?php
      echo $row['Category'];
    ?>    </td>
<td>
    <?php
      echo $row['Channel'];
    ?>    </td>
<td>
    <?php
      echo $row['UploadTime'];
    ?>    </td>

            <td>
<input type="checkbox" name="<?php echo $row['MediaID']; ?>" >
</td>
</tr>

<?php


}
?>
</table>
<input type="submit" class="btn" name="submit" value="Confirm">
</form>
<?php } ?>

    </div>
<div id="Animations1" style="display:none">
         <?php 
        $sql = "SELECT MediaID,UploaderID, Name, Category, Channel, UploadTime FROM Media WHERE Type='Animation'";
        $result = $conn -> query($sql);
        $count= mysqli_num_rows($result);
        if($count==0)
        echo "No Animationsl";
        else{
         ?>
	<table class="data">
	<form name="blockmanager1" method="post" action="adminmanager.php">
	<tr>
	<th>Uploader</th>
	<th>Name</th>
	<th>Category</th>
	<th>Channel</th>
	<th>Upload Time</th>
        
	<th>Delete</th>
	</tr> 
        <?php
while($row=$result->fetch_assoc()){
?>
 <tr>
        
            <td>
    <?php
      echo $row['UploaderID'];
    ?>    </td>
    <td>
    <?php
      echo $row['Name'];
    ?>    </td>
<td>
    <?php
      echo $row['Category'];
    ?>    </td>
<td>
    <?php
      echo $row['Channel'];
    ?>    </td>
<td>
    <?php
      echo $row['UploadTime'];
    ?>    </td>

            <td>
<input type="checkbox" name="<?php echo $row['MediaID']; ?>" >
</td>
</tr>

<?php


}
?>
</table>
<input type="submit" class="btn" name="submit" value="Confirm">
</form>
<?php } ?>

    </div>
<div id="Users1" style="display:none">
        <?php 
        $sql = "SELECT ID,FirstName,LastName, Email, UserName, BirthDate, Gender, Location FROM User WHERE ID<>1";
        $result = $conn -> query($sql);
        $count= mysqli_num_rows($result);
        if($count==0)
        echo "No Users";
        else{
         ?>
	<table class="data">
	<form name="blockmanager1" method="post" action="adminmanager.php">
	<tr>
	<th>FirstName</th>
	<th>LastName</th>
	<th>Email</th>
	<th>UserName</th>
	<th>BirthDate</th>
        <th>Gender</th>
	<th>Location</th>
        <th>Remove?</th>
	</tr> 
        <?php
while($row=$result->fetch_assoc()){
?>
 <tr>
        
            <td>
    <?php
      echo $row['FirstName'];
    ?>    </td>
    <td>
    <?php
      echo $row['LastName'];
    ?>    </td>
<td>
    <?php
      echo $row['Email'];
    ?>    </td>
<td>
    <?php
      echo $row['UserName'];
    ?>    </td>
<td>
    <?php
      echo $row['BirthDate'];
    ?>    </td>
<td>
    <?php
      echo $row['Gender'];
    ?>    </td>
<td>
    <?php
      echo $row['Location'];
    ?>    </td>


<td>
<input type="checkbox" name="<?php echo $row['ID']; ?>" >
</td>
</tr>

<?php


}
?>
</table>
<input type="submit" class="btn" name="submit1" value="Confirm">
</form>
<?php } ?>
    </div><div id="Messages1" style="display:none">
        Messages
    </div>
<div id="MyUploads1" style="display:none">
        <?php include 'uploadmanager.php'; ?>
    </div>

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


