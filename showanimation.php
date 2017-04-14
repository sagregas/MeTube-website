<?php
session_start();
$UserId='';
if(array_key_exists('id',$_SESSION))
$UserId = $_SESSION['id'];
require_once('config.php');
$views=0;
$averageRating=0;
$totalRating=0;

$sql="select * from Media where Type='Animation' order by Counter desc";
$row=$dbconn->prepare($sql);
$row->execute();
$result=$row->fetchAll(PDO::FETCH_ASSOC);
if(isset($_GET['id']))
	{
          $currMediaId=$_GET['id'];
          $_SESSION['mediaId']=$currMediaId;
         }		//this page requires to get id from previous page.It is must
else
	$currMediaId=$result[0]['MediaID'];		//this need to be deleted


$sql1 = "SELECT * from Media WHERE MediaID='$currMediaId' and Type='Animation'";		//changed-Aditya added Type
$result1 = $dbconn -> prepare($sql1);
$result1 -> execute();	
$row1=$result1->fetchAll(PDO::FETCH_ASSOC);	//to be commented
$text=$row1[0]['Name'];
$views=$row1[0]['Views'] + 1;
$Q7 = "UPDATE Media SET Views='$views' WHERE MediaID='$currMediaId'";
$Q7prep = $dbconn -> prepare($Q7);
$Q7prep->execute();
  //The text (through MediaId stored in $currMediaId) has to be received from playvideo.html
//$currMediaId=4;        //here hard coding currentmediaid to media id of the clicked video.


/*Now that we have got Current MediaId,if the user is logged in we will add this into the UserPreferences*/
if($UserId!=0){			//Guest user has 0 id
	$UQ1="select * from UserPreferences inner join Media on UserPreferences.MediaID=Media.MediaID where UserID='$UserId' and MediaID='$currMediaId' and Type='Animation'";//MediaId=$currMediaId
	$UQ1prep=$dbconn->prepare($UQ1);
	$UQ1prep->execute();
	$UQ1res=$UQ1prep->fetchAll(PDO::FETCH_ASSOC);
	$rows1=$UQ1prep->rowCount();

	if(!empty($rows1)){			//Note the PDO::rowCount() function does not work with Mysql server
		//$cnt=$UQ1res[0]['Count']+1;
		$UQ2="update UserPreferences set ViewTime=now() where MediaID='$currMediaId' and UserID='$UserId'";
		$UQ2prep=$dbconn->prepare($UQ2);
		$UQ2prep->execute();
		$UQ2res=$UQ2prep->fetchAll(PDO::FETCH_ASSOC);
	}

	else{
		$UQ2="select * from UserPreferences inner join Media on UserPreferences.MediaID=Media.MediaID where UserID='$UserId' and Type='Animation' order by ViewTime";
		$UQ2prep=$dbconn->prepare($UQ2);
		$UQ2prep->execute();
		$UQ2res=$UQ2prep->fetchAll(PDO::FETCH_ASSOC);
		$rows2=$UQ2prep->rowCount();
		if($rows2<3)	{  //Change the number from 3 to 5 otr higher.The number used is to restrict the limit on remembering the history
			$UQ3="insert into UserPreferences values('$currMediaId','$UserId',now())";
			$UQ3prep=$dbconn->prepare($UQ3);
			$UQ3prep->execute();
			
		}	//Change the number from 3 to 5 otr higher.The number used is to restrict the limit on remembering the history

		else{
			$med=$UQ2res[0]['MediaID'];
			$UQ3="update UserPreferences set MediaID='$currMediaId',UserID='$UserId',ViewTime=now() where UserID='$UserId' and MediaID='$med'";
			$UQ3prep=$dbconn->prepare($UQ3);
			$UQ3prep->execute();
		}
   
	}
}

//The below section is common and independent of the logged in user


foreach ($result as $value) {
    
    $keyword=$value['Keywords'];
    $medId=$value['MediaID'];
    
   // $currMediaId=$value[0];
    $temp=0;
    if($currMediaId!=$medId){ 	 //this is used to avoid checking keywords against the clicked media(self)
	    $pieces=explode(" ", $keyword);        
	    foreach ($pieces as $value) {
	        //echo $value."/n";
	        $temp=$temp+substr_count($text, $value);
	    }
    }
    else{
        $nametag=$value['Name'];
    	$first=$value['Name'];
    	$type=$value['Type'];
    	$URL=$value['URL'];
    }
        //echo $temp;
        //Entering into the counter column of the table
    $Q1="update Media set Counter='$temp' where MediaID='$medId'";
    $Q1prep=$dbconn->prepare($Q1);
    $Q1prep->execute();
}


$Q2="select * from Media Where MediaID<>$currMediaId and Type='Animation' and Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') or UploaderID=$UserId and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) order by Counter desc";
$Q2prep=$dbconn->prepare($Q2);
$Q2prep->execute();
$Q2res=$Q2prep->fetchAll(PDO::FETCH_ASSOC);
foreach ($Q2res as $key => $value) {			
//echo $value['MediaId'];			//to be commented

}
/* For displaying Likes,dislikes,views and subscribers*/

//Likes
$Q3="select count(*) as count from MediaStats where MediaID='$currMediaId' and LikeID!=0 group by MediaID;";
$Q3prep=$dbconn->prepare($Q3);
$Q3prep->execute();
$Q3res=$Q3prep->fetchAll(PDO::FETCH_ASSOC);
foreach ($Q3res as $key => $value) {
	$Likes=$value['count'];
	
}
if(empty($Likes))
	$Likes=0;

$Q5="select count(*) as count from MediaStats where MediaID='$currMediaId' and DislikeID!=0 group by MediaID;";
$Q5prep=$dbconn->prepare($Q5);
$Q5prep->execute();
$Q5res=$Q5prep->fetchAll(PDO::FETCH_ASSOC);
foreach ($Q5res as $key => $value) {
	$Dislikes=$value['count'];
	
}
if(empty($Dislikes))
	$Dislikes=0;
	
//For displaying media Rating of user
$Q8="select Rating from MediaRating where MediaID=$currMediaId and RaterID='$UserId'";
$Q8prep=$dbconn->prepare($Q8);
$Q8prep->execute();
$Q8res=$Q8prep->fetchAll(PDO::FETCH_ASSOC);
//For displaying rating of Media as whole
$Q9="SELECT *,count(*) as cnt,sum(Rating) as total from MediaRating where MediaID='$currMediaId' group by MediaID";
$Q9prep=$dbconn->prepare($Q9);
$Q9prep->execute();
$Q9res=$Q9prep->fetchAll(PDO::FETCH_ASSOC);
if(!empty($Q9res)){
$totalRating=$Q9res[0]['total'];
$ratingCount=$Q9res[0]['cnt'];
if($ratingCount!=0)
$averageRating=$totalRating/$ratingCount;	
else
$averageRating=0;	
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
.navbar-fixed-top {
    border: 0px none;
    background-color:#F66733;
    padding-top:20px;
   
}
.row{margin-top:65px}
</style>
</head>
<body>

<div class="container-fluid">
<nav class="navbar navbar-default navbar-fixed-top">
  
     <a class="navbar-brand" href="home.php" style="color:white; padding-top:0px; padding-bottom:0px; font-size: 40px !important;">
MeTube
</a>
    </nav>
	<div class="row">
        <div class="col-md-8">
	
		<h1><?php echo $nametag; ?></h1>
		<img src="<?php echo $URL; ?>" alt="Animation not displayed" width="700" height="400"><br>
		<a href="displayImage.php?id=<?php echo $currMediaId; ?>">View Fullscreen</a>
		<br><br>
    <table width="700"><tr><td>
		<form method="post" action="download.php">

		<!--All the likes ,dislikes subscriptions should be included only when the current user is not the owner of the media-->
		<!-- Write a query here above comment-->	
    		<button type="submit" name="download" class="btn btn-default btn-lg" style="background:transparent; border:none"> <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span></button>
		</form></td><td>
		<form id="toMedStat" method="post" <?php if($UserId) { ?> action="MediaStats.php"<?php } ?>>
			<button type="submit" name="Like" class="btn btn-default btn-lg" style="background:transparent; border:none"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="false"></span></button><?php echo $Likes; ?>
			<input type="hidden" name="UserAccountID" value="<?php echo $UserId ?>"/>
			<input type="hidden" name="MediaID" value="<?php echo $currMediaId ?>"/>	
			<button type="submit" name="Dislike" class="btn btn-default btn-lg" style="background:transparent; border:none"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="false"></span></button><?php echo $Dislikes; ?>
			</td>
		<td>
			<p><span class="glyphicon glyphicon-eye-open" aria-hidden="false"></span> &nbsp;&nbsp;&nbsp;<?php echo $views; ?></p></td></tr></table>
		
			
			<?php 
			  $currChannel=$row1[0]['Channel'];
			  ?>
			 <b> Channel Name : <?php
			  echo $currChannel; ?></b>
			  <?php
			  $Q6="select * from Channel where SubscriberID='$UserId'and Channel='$currChannel'";
		      $Q6prep=$dbconn->prepare($Q6);
		      $Q6prep->execute();
		      $Q6res=$Q6prep->fetchAll(PDO::FETCH_ASSOC);
		      $Q7="select * from FavoriteList where UserID='$UserId' and MediaID='$currMediaId'";
		      $Q7prep=$dbconn->prepare($Q7);
		      $Q7prep->execute();
		      $Q7res=$Q7prep->fetchAll(PDO::FETCH_ASSOC);
		      if(empty($Q6res)){
			?>
			<button type="submit" class="btn btn-default" name="Subscribe">Subscribe</button>
			<?php } 
			else {?>
			<button type="submit" class="btn btn-default" name="unSubscribe">Unsubscribe</button>
			<?php }
			if(empty($Q7res)){
			?>
			<button type="submit" class="btn btn-default" name="addFavorites">Add To Favorite</button>
			<?php } 
			else { ?>
			<button type="submit" class="btn btn-default " name="removeFavorites">Remove From Favorite</button>
			<?php } ?>
			<br><br>
			<h5>Media Rating</h5>
			<select name="Rating" style="height:30px; width:70px">
              		<option value="0"> 0 </option>
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
		            <option value="3"> 3 </option>
		            <option value="4"> 4 </option>
		            <option value="5"> 5 </option>
			</select>

			<button type="submit" class="btn btn-default" name="Rate">Rate Media</button>
		</form>	
			<h4>Average Rating for the Media <?php echo $averageRating; ?></h4>
			



<!--experimenting with script to load the current video-->

<!--comments-->
<?php 
$Q="select * from User inner join Comments on ID=FromUserID WHERE ToMediaID='$currMediaId' order by Time";
$Qprep=$dbconn->prepare($Q);
$Qprep->execute();
$Qres=$Qprep->fetchAll(PDO::FETCH_ASSOC);

?>
<?php 
if($UserId){
if($row1[0]['Discussion']==='Yes') { ?>
<br>
Comment:<br />

		<form method="post" action="comments.php" enctype="multipart/form-data">
		<div class="form-group">
      <div class="col-sm-10"> 
			<textarea class="form-control" name="comment" required='' rows='5' cols='95'></textarea><br />
		</div>
    </div>
<div class="form-group">        
      <div class="col-sm-offset-8 col-sm-2">	
			<input type="hidden" name="MediaId" value="<?php echo $currMediaId;?>">
			<input type="submit"  class="btn btn-default" value="Submit" name="Comment">
			</div>
    </div>
		</form>	
		<br><br><br><br><br><br><br><br><br><br><hr>
		<h4>Comments</h4><hr>
<?php } 
else
	echo "The owner has disallowed any discussions on this media";
}?>	<br>	
<?php
if(!$UserId)
{ ?>	
<h4>Comments</h4><hr>

<?php 
}
foreach ($Qres as $key => $value) {?>


<p><?php echo $value['Text']; ?> <p><br><br>
<p><i><?php echo $value['UserName']."     ".$value['Time']; ?> </i></p>

<!--for deleting comments -->
	<?php if($UserId==$value['FromUserID']){ 	$commentId=$value['CommentID'];?> 
		<form class="form-horizontal" method="post" action="comments.php" enctype="multipart/form-data">
			<input type="hidden" name="CommentId" value="<?php echo $commentId;?>">
			<input type="hidden" name="MediaId" value="<?php echo $currMediaId;?>">
			<div class="form-group">        
      <div class="col-sm-offset-8 col-sm-2">
			<input type="submit"  class="btn btn-default" value="Delete" name="Delete">	
			</div>
    </div></form>
		<?php }?><hr>
<?php }?>

	</div>
		


<div class="col-md-4">
		<h3 style="margin-top:20px;">You may also like</h3>
		<ul style="list-style-type:none">
			<?php
			foreach ($Q2res as $key => $value) {?>
			<li>
			 <?php 
			 $me = $value['MediaID'];
			 $sqlsql = "SELECT UserName From User,Media WHERE ID=UploaderID AND MediaID='$me'";
			 $reres = $conn -> query($sqlsql);
			 $rowrow = mysqli_fetch_assoc($reres);
			 $upid = $rowrow['UserName'];
			 ?>
				<a href="showanimation.php?id=<?php echo $value['MediaID']; ?>">
				<img src="<?php echo $value['URL']; ?>" alt="Animation not displayed" width="360" height="176"><br>
			<?php echo $value['Name'];?></a>
			<br>Uploader: <?php echo $upid;?>
		        <br>Views: <?php echo $value['Views'];?>
			</li><br>
			<?php }?>
		</ul> 
	                   
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

