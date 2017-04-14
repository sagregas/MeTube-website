<?php
session_start();
$ID=$_SESSION['id'];
include 'config.php';
$oldpassworderr='';
$newpassworderr='';
$confirmnewpassworderr='';
$error=0;
$showError='';
$msg='';
if(isset($_POST['Submit']))
{
    if(empty($_POST['oldpassword'])){
        $oldpassworderr="Field required";
        $error=1;
    }
    if(empty($_POST['newpassword'])){
        $newpassworderr="Field required";
        $error=1;

    }
	 if(empty($_POST['confirmnewpassword'])){
        $confirmnewpassworderr="Field required";
        $error=1;

    }
	if($_POST['newpassword']!=$_POST['confirmnewpassword'])
	{
		$showError="New passwords dont match";
		$error=1;
	}

    if($error==0){
        $OP = md5($_POST['oldpassword']);
        //$Password = md5($_POST['Password']);
        $sql="SELECT * FROM User WHERE Password='$OP' AND ID='$ID'";
        $result = $conn->query($sql);
        $numRows = $result->num_rows;
        $NP = md5($_POST['newpassword']);
        if($numRows==1){
          $sql2 = "UPDATE User SET Password='$NP' WHERE Password='$OP'";
          $conn->query($sql2);     
	      $msg= "Password changed. Please Close this Window";

        }
        else{
            $oldpassworderr="Wrong data inserted";
            //echo $showError;
        }

    }
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
        
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
   <style>
body{

padding-top: 50px;}
.form-signin {
    max-width: 330px;
    padding: 15px;
    margin: 0px auto;
    margin-top: 200px;
    
}

.navbar-fixed-top {
    border: 0px none;
    background-color:#F66733;
   padding-top:20px;
   
}

</style>
</head>
<body>
<form class="form-signin" name="Login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

   
    <label class="sr-only" for="inputEmail">

    Old password

    </label>
    <input id="inputEmail" class="form-control" type="password" autofocus="" placeholder="Old Password" name="oldpassword"></input>
    <label class="sr-only" for="inputPassword">

    New Password

    </label>
    <input id="inputPassword" class="form-control" type="password"  placeholder="New Password" name="newpassword"></input>
	<label class="sr-only" for="inputPassword">

    Confirm New Password

    </label>
    <input id="inputPassword" class="form-control" type="password"  placeholder="Confirm New Password" name="confirmnewpassword"></input>
	
    
    <input class="btn btn-lg btn-primary btn-block" style="background-color:black" type="submit" name="Submit" value="Submit">
   <p>
 <span class="error"><?php echo $oldpassworderr; ?><br>
<span class="error"><?php echo $newpassworderr; ?><br>
<span class="error"><?php echo $confirmnewpassworderr; ?><br>
<span class="error"><?php echo $showError; ?><br>
<span class="error"><?php echo $msg; ?><br>
</p>
</form>
</body>
</html>