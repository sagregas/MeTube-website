<?php

//This is a php file assuming that the logged in user has preferences already set
$UserId='';
$Q1res='';
require_once('config.php');
			//Later to uncommented
if(!empty($_SESSION['id']))
{$UserId=$_SESSION['id'];

//$UserId=1;			//assumed:2 is logged in users id.0 is guest user's id .This line later needs to be commented


if($UserId){ // to be commented
//if($UserId==$_SESSION['UserId']{
$Q1="select * from (Media inner join UserPreferences on Media.MediaID=UserPreferences.MediaID ) inner join User on Media.UploaderID=User.ID where UserPreferences.UserID='$UserId' and Media.Type='Video' and Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') or UploaderID='$UserId' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) order by UserPreferences.ViewTime desc";
$Q1prep=$dbconn->prepare($Q1);
$Q1prep->execute();
$Q1res=$Q1prep->fetchAll(PDO::FETCH_ASSOC);
}}

//Recently uploaded
if($UserId){
		$Q3="select * from Media where Type = 'Video' and Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') or UploaderID='$UserId' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) order by UploadTime desc Limit 3";
		$Q4="select *,count(*) as cnt from Media inner join MediaStats on Media.MediaID=MediaStats.MediaID where Type='Video' and LikeID!=0 and Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') or UploaderID='$UserId' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) group by MediaStats.MediaID order by cnt limit 3";
		$Q5="select * from Media where Type='Video' and Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') or UploaderID='$UserId' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) order by Views desc limit 3";
		}
		else{
			$Q3="select * from Media where Type='Video' and Sharing='Public' order by UploadTime desc Limit 3";
			$Q4="select *,count(*) as cnt from Media inner join MediaStats on Media.MediaID=MediaStats.MediaID where Type='Video' and Sharing='Public' and LikeID!=0 group by MediaStats.MediaID order by cnt limit 3";
			$Q5="select * from Media where Type='Video' and Sharing='Public' order by Views desc limit 3";
		}
		$Q3prep=$dbconn->prepare($Q3);
		$Q3prep->execute();
		$Q3res=$Q3prep->fetchAll(PDO::FETCH_ASSOC);

//Mostl liked
		$Q4prep=$dbconn->prepare($Q4);
		$Q4prep->execute();
		$Q4res=$Q4prep->fetchAll(PDO::FETCH_ASSOC);	

//Most Viewed
		$Q5prep=$dbconn->prepare($Q5);
		$Q5prep->execute();
		$Q5res=$Q5prep->fetchAll(PDO::FETCH_ASSOC);				
?>
<html>
<head>
<style>

video-list-thumbs{}
.video-list-thumbs > li{
    margin-bottom:12px;
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
@media (min-width:320px) and (max-width: 480px) { 
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

<div class="container" style="margin-left:0 ">

	<ul class="list-unstyled video-list-thumbs row">
			
				<?php
				if($UserId){ 
				
      	?>
				<p>Recommended Videos</p><hr>
				<?php
				foreach ($Q1res as $key => $value) { ?>
				
                                        
					<li class="col-lg-3 col-sm-4 col-xs-6">
					<a href="playvideo.php?id=<?php echo $value['MediaID'];?>">
					<video id="video" src="<?php echo $value['URL']; ?>" type="video/mp4" width="320" height="176" class="img-responsive">
					</video>
	<span class="glyphicon glyphicon-play-circle"></span>
								</a>
					<p><?php echo $value['Name'];?>
                                                                       </p>
                                        </li>
				
				<?php }} ?>
				
		               </ul>


			
			
			<?php
			if(!empty($Q1res))
			foreach ($Q1res as $key => $value) {
				$channel=$value['Channel'];
				$Q2="select * from Media where Channel='$channel' and Type='Video' and Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') or UploaderID='$UserId' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId'))";
				$Q2prep=$dbconn->prepare($Q2);
				$Q2prep->execute();
				$Q2res=$Q2prep->fetchAll(PDO::FETCH_ASSOC);

//To do-Now we have channel name.for each channel name we want the names associted with it.see youtube if confused
				?>
			<hr>
			<p><?php echo $channel." -Recommended Channel"; ?></p><hr>
<ul class="list-unstyled video-list-thumbs row">
			<?php
			foreach ($Q2res as $key => $value) {?>
			<li class="col-lg-3 col-sm-4 col-xs-6">
				<a href="playvideo.php?id=<?php echo $value['MediaID'];?>">
				<video id="video" src="<?php echo $value['URL']; ?>" type="video/mp4" width="320" height="176" class="img-responsive">
				</video>
				
				<span class="glyphicon glyphicon-play-circle"></span>
			
					</a>
					<p><?php echo $value['Name'];?></p>
                                        </li>
				
			<?php }?>
			
			</ul>
			<?php }?>	
		


		<!--Recently uploaded -->
<hr>
			<p>Recently Uploaded</p><hr>
<ul class="list-unstyled video-list-thumbs row">
			<?php 
			foreach ($Q3res as $key => $value) {?>
			<li class="col-lg-3 col-sm-4 col-xs-6">
				<a href="playvideo.php?id=<?php echo $value['MediaID'];?>">
				<video id="video" src="<?php echo $value['URL']; ?>" type="video/mp4" width="320" height="176" class="img-responsive">
				</video>
				
				<span class="glyphicon glyphicon-play-circle"></span>
			
					</a>
					<p><?php echo $value['Name'];?></p>
                                        </li>
				
			<?php } ?>
		</ul>
		<hr>

			<p>Most Viewed</p><hr>
<ul class="list-unstyled video-list-thumbs row">
			<?php 
			foreach ($Q5res as $key => $value) {?>
			<li class="col-lg-3 col-sm-4 col-xs-6">
				<a href="playvideo.php?id=<?php echo $value['MediaID'];?>">
				<video id="video" src="<?php echo $value['URL']; ?>" type="video/mp4" width="320" height="176" class="img-responsive">
				</video>
				
				<span class="glyphicon glyphicon-play-circle"></span>
			
					</a>
					<p><?php echo $value['Name'];?></p>
                                        </li>
				
			<?php } ?>
		</ul>
		<hr>


<ul class="list-unstyled video-list-thumbs row">
		<!-- Most liked -->
<hr>
			<p>Most Popular</p><hr>
			<?php
			//Most liked
foreach ($Q4res as $key => $value) {?>
			<li class="col-lg-3 col-sm-4 col-xs-6">
				<a href="playvideo.php?id=<?php echo $value['MediaID'];?>">
				<video id="video" src="<?php echo $value['URL']; ?>" type="video/mp4" width="320" height="176" class="img-responsive">
				</video>
				
				<span class="glyphicon glyphicon-play-circle"></span>
			
					</a>
					<p><?php echo $value['Name'];?></p>
                                        </li>
				
			<?php }?>
			</ul>
		<hr>
</div>	
	</div>	
</html>
