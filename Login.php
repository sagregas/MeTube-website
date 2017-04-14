<?php
session_start();
include 'config.php';
$Usernameerr='';
$Passworderr='';
$error=0;
$showError='';
if(isset($_POST['Submit']))
{
    if(empty($_POST['Username'])){
        $Usernameerr="Username field required";
        $error=1;
    }
    if(empty($_POST['Password'])){
        $Passworderr="Password field required";
        $error=1;

    }

    if($error==0){
        $Username = $_POST['Username'];
        $Password = md5($_POST['Password']);
        $sql="SELECT * FROM User WHERE Username='$Username'";
        $result = $conn->query($sql);
        $numRows = $result->num_rows;
        
        if($numRows==1){
            $row = $result->fetch_assoc();
                if($Password==$row['Password']){
                    $_SESSION['id']=$row['ID'];
                    if($_SESSION['id']==1)
                    {
                    header("Location: adminhome.php");
                    }
                    else{
		    header("Location: home.php");
                    }
                }
                else{
                    //echo $row['Password'];
                    $showError="Enter proper credentials";
                   // echo $showError;
                }


        }
        else{
            $showError="Enter proper credentials";
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
<nav class="navbar navbar-default navbar-fixed-top">
  
     <a class="navbar-brand" href="home.php" style="color:white; padding-top:0px; padding-bottom:0px; font-size: 40px !important;">
MeTube
</a>
    </nav>
<form class="form-signin" name="Login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

    <h2 class="form-signin-heading">

    Please sign in

    </h2>
    <label class="sr-only" for="inputEmail">

    Email address

    </label>
    <input id="inputEmail" class="form-control" type="text" autofocus="" placeholder="Username" name="Username"></input>
    <label class="sr-only" for="inputPassword">

    Password

    </label>
    <input id="inputPassword" class="form-control" type="password"  placeholder="Password" name="Password"></input>
    
    <input class="btn btn-lg btn-primary btn-block" style="background-color:black" type="submit" name="Submit" value="Submit">
   <p>
 <span class="error"><?php echo $Usernameerr; ?><br>
<span class="error"><?php echo $Passworderr; ?>
<span class="error"><?php echo $showError; ?>
</p>
</form>
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
