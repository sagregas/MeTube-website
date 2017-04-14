 

<?php 
 session_start();  
include 'config.php';
$ID = $_SESSION['id'];
define('VALUE', 'on');



if(isset($_POST['submitplay']))
{

foreach ($_POST as $key => $value) {
        $key=preg_replace( '/_[^_]*$/', '', $key );
        
        if($value==VALUE){
        
       if(strpos($key,'Add')!==FALSE){ 
          $a=substr($key,3);
         // echo $a;
		  // echo $ID;
          $sql = "INSERT INTO Playlist VALUES ('','$ID','$a',now())";
          $conn -> query($sql);
		   
       }
       if(strpos($key,'Remove')!==FALSE){ 
          $a=substr($key,6);
      
          $sql = "DELETE FROM Playlist WHERE MediaID='$a' AND UserID='$ID'";
          $conn -> query($sql);
		   
       }
       }
	   

}
//header("location: home.php");
}



//header("refresh:1; url=Profile1.php");



        
        $sql = "SELECT * FROM FavoriteList, Media WHERE Media.MediaID=FavoriteList.MediaID AND FavoriteList.UserID='$ID'";
        $result = $conn -> query($sql);
        $count= mysqli_num_rows($result);
		
        if($count==0)
        echo "No Media";
        else{
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
         <html>
         <head>
         <style>
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

.btn1{
cursor: pointer;
  margin-top: 15px;
  margin-left:50%;
 /* border-radius: 5px;*/
  text-decoration: none;
  /*padding: 10px;*/
  font-size: 18px;
  transition: .3s;
  -webkit-transition: .3s;
  -moz-transition: .3s;
  -o-transition: .3s;
  display: inline-block;
  color: #F66733;
  border: 2px #F66733 solid;
  background-color:white;
  height: 50px;
  width: 150px;
}
.btn1:hover{
 color: #fff;
  background-color: #F66733;
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


#searchbar input[type=text]{width:560px;}</style>
  </head>

  <body>

<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
  
     <a class="navbar-brand" href="home.php" style="color:white; padding-top:0px; padding-bottom:0px; font-size: 40px !important;">
MeTube
</a>
    </nav>




	<table class="data" style="margin-top:50px">
	<form name="favorite" method="post" action="favorites.php">
	<tr>
	
	<th>Name</th>
	<th>Type</th>
	<th>Channel</th>
	
    <th>View</th>
	<th>Add to playlist?</th>
	<th>Remove from playlist?</th>
	</tr> 
        <?php
while($row=$result->fetch_assoc()){
?>
 <tr>
        
           
    <td>
    <?php
      echo $row['Name'];
    ?>    </td>

 <td>
    <?php
      echo $row['Type'];
    ?>    </td>

<td>
    <?php
      echo $row['Channel'];
    ?>    </td>

	<?php if($row['Type']=='Video'){ ?>
<td>
	<a href="playvideo.php?id=<?php echo $row['MediaID'] ?>" style="color: #F66733">View</a></td><?php }
	
elseif($row['Type']=='Audio'){ ?>	
<td>
	<a href="playaudio.php?id=<?php echo $row['MediaID'] ?>" style="color: #F66733">View</a></td><?php }
elseif($row['Type']=='Image'){ ?>	
<td>
	<a href="showimage.php?id=<?php echo $row['MediaID'] ?>" style="color: #F66733">View</a></td><?php }
else{ ?>	
<td>
	<a href="showanimation.php?id=<?php echo $row['MediaID'] ?>" style="color: #F66733">View</a></td><?php }	
	
                        $MID = $row['MediaID'];

                        
                        $sql3 = "SELECT * FROM Playlist WHERE UserID='$ID' AND MediaID='$MID'";
                        $result3 = $conn -> query($sql3);
                        
                      if(mysqli_num_rows($result3)==1)
                        {
                            ?>
                            <td>
                               In Playlist
                            </td>
                        <?php } else{?>
                            <td>
<input type="checkbox" name="Add<?php echo $row['MediaID']; ?>" >
</td>
                        <?php }
						if(mysqli_num_rows($result3)==0)
                        {
                            ?>
                            <td>
                               Not in Playlist
                            </td>
                        <?php } else{?>
                            <td>
<input type="checkbox" name="Remove<?php echo $row['MediaID']; ?>" >
</td>
                        <?php } ?>
                           
                        
	
            

</tr>

<?php


}
?>
</table>
<input type="submit" class="btn1" name="submitplay" value="Confirm">
</form>
<?php } ?>
<br><br>
<a href="home.php" style="color:#F66733">Back to Home</a>
<a href="playlist.php" style="color:#F66733">View My Playlist</a>
</body>
</html>

