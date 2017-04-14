<?php
session_start();
$ID=$_SESSION['id'];
require_once('config.php');
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

<h3>Welcome to Advanced Search</h3>
<br><br>
<div class="row">
<form name="advsearch" class="form-horizontal" method="post" action="featuresearch.php">
Select one option from the list: <br><br>
<select class="form-control" name="type">
<option value="dataformat">By data format</option>
<option value="timeformat">By time</option>
<option value="size">By size</option> 
</select><br>
<input type="submit" name="submit" value="Submit" class="btn btn-default">
</form>
</div>
<div class="row">
<br><br>
<?php
if(isset($_POST['submit']))
{
if(isset($_POST['type']))
{	
if($_POST['type']=='dataformat')
{?>	
<form class="form-horizontal" id="toMedStat" method="post" action="MediaFeatureSearch.php">	
<p>Data Formats</p>

<input class="form-control" type="checkbox" name="mp4" value="mp4"> mp4 <br>
<input class="form-control" type="checkbox" name="mp3" value="mp3"> mp3 <br>
<input class="form-control" type="checkbox" name="jpg" value="jpg"> jpg <br>
<input class="form-control" type="checkbox" name="jpeg" value="jpeg"> jpeg <br>
<input class="form-control" type="checkbox" name="png" value="png"> png <br>
<input class="form-control" type="checkbox" name="gif" value="gif"> gif <br><br>
<button type="submit" class="btn btn-default" name="dataSearch">Search</button>
</form>
<?php }
if($_POST['type']=='timeformat')
{
 ?>

<form class="form-horizontal" id="toMedStat" method="post" action="MediaFeatureSearch.php">	
<p>Time Uploaded</p>

<input class="form-control" type="radio" name="time" value="last day"> last day <br>
<input class="form-control" type="radio" name="time" value="last week"> last week <br>
<input class="form-control" type="radio" name="time" value="last month"> last month <br>
<input class="form-control" type="radio" name="time" value="last year"> last year <br><br>
<button type="submit" class="btn btn-default" name="timeSearch">Search</button>
</form>
<?php }
if($_POST['type']=='size')
{
 ?>

<form class="form-horizontal" id="toMedStat" method="post" action="MediaFeatureSearch.php">	
<p>File size</p>

<input class="form-control" type="radio" name="100kb" value="less than 100KB"> less than 100KB <br>
<input class="form-control" type="radio" name="1mb" value="less than 1MB"> less than 1MB <br>
<input class="form-control" type="radio" name="10mb" value="less than 10MB"> less than 10MB<br>
<input class="form-control" type="radio" name="100mb" value="less than 100MB"> less than 100MB<br><br>
<button type="submit" class="btn btn-default btn-lg" name="sizeSearch">Search</button>

</form>
<?php
}
}
}
?>


</div>

</div>
</body>
</html>