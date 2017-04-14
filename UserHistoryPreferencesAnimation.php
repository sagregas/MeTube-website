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
$Q1="select * from (Media inner join UserPreferences on Media.MediaID=UserPreferences.MediaID ) inner join User on Media.UploaderID=User.ID where UserPreferences.UserID='$UserId' and Media.Type='Animation' and Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') or UploaderID=$UserId and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId'))order by UserPreferences.ViewTime desc";
$Q1prep=$dbconn->prepare($Q1);
$Q1prep->execute();
$Q1res=$Q1prep->fetchAll(PDO::FETCH_ASSOC);
}}

 if($UserId){
		$Q3="select * from Media where Type = 'Animation' and Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') or UploaderId=$UserId and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) order by UploadTime desc Limit 3";
		$Q4="select *,count(*) as cnt from Media inner join MediaStats on Media.MediaID=MediaStats.MediaID where Type='Animation' and LikeID!=0 and Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') or UploaderID=$UserId and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) group by MediaStats.MediaID order by cnt limit 3";
		$Q5="select * from Media where Type='Animation' and Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') or UploaderID=$UserId and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId')) order by Views desc limit 3";
		}
		else{
			$Q3="select * from Media where Type='Animation' and Sharing='Public' order by UploadTime desc Limit 3";
			$Q4="select *,count(*) as cnt from Media inner join MediaStats on Media.MediaID=MediaStats.MediaID where Type='Animation' and Sharing='Public' and LikeID!=0 group by MediaStats.MediaID order by cnt limit 3";
			$Q5="select * from Media where Type='Animation' and Sharing='Public' order by Views desc limit 3";
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
</style>

</head>

<div class="container" style="margin-left:0 ">

	
			
				<?php
				if($UserId){ 
				
      	?>
				<p>Recommended Animations</p><hr>
				<div class="row">
				<?php
				foreach ($Q1res as $key => $value) {	?>
				<div class="col-md-4">
				<a href="showanimation.php?id=<?php echo $value['MediaID'];?>">
				<img src="<?php echo $value['URL']; ?>" alt="Animation is not being displayed" style="width:304px;height:228px;"></img></a>
				<p><?php echo $value['Name'];?></p>
                </div>
				<?php }} ?>
		        </div>

			<?php
			if(!empty($Q1res))
			foreach ($Q1res as $key => $value) {
				$channel=$value['Channel'];
				$Q2="select * from Media where Channel='$channel' and Type='Animation' and Media.MediaID in (select Media.MediaID from Media where Sharing='Public' and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing ='Friends' and UploaderID in (select FriendID from Friends where UserID='$UserId') or UploaderId=$UserId and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId') union select Media.MediaID from Media where Sharing='Contacts' and UploaderID in (select ContactID from Contacts where UserID='$UserId') and UploaderID not in (select UserID from Blockedlist where BlockID='$UserId'))";
				$Q2prep=$dbconn->prepare($Q2);
				$Q2prep->execute();
				$Q2res=$Q2prep->fetchAll(PDO::FETCH_ASSOC);

//To do-Now we have channel name.for each channel name we want the names associted with it.see youtube if confused
				?>
			<hr>
			<p><?php echo $channel." -Recommended Channel"; ?></p><hr>
			<div class="row">
			<?php
			foreach ($Q2res as $key => $value) {?>
			<div class="col-md-4">
				<a href="showanimation.php?id=<?php echo $value['MediaID'];?>">
				<img src="<?php echo $value['URL']; ?>" alt="Animation is not being displayed" style="width:304px;height:228px;"></img></a>
				<p><?php echo $value['Name'];?></p>
            </div>
				
			<?php }?>
			
			</div>
			<?php }?>	
		


		<!--Recently uploaded -->
<hr>
			<p>Recently Uploaded</p><hr>
			<div class="row">
			<?php 
			foreach ($Q3res as $key => $value) {?>
			<div class="col-md-4">
				<a href="showanimation.php?id=<?php echo $value['MediaID'];?>">
				<img src="<?php echo $value['URL']; ?>" alt="Animation is not being displayed" style="width:304px;height:228px;"></img></a>
					<p><?php echo $value['Name'];?></p>
                                        </div>
				
			<?php } ?>
		</div>
		<hr>

<!--Most viewed -->		
			<p>Most Viewed</p><hr>
			<div class="row">
			<?php 
			foreach ($Q5res as $key => $value) {?>
			<div class="col-md-4">
				<a href="showanimation.php?id=<?php echo $value['MediaID'];?>">
				<img src="<?php echo $value['URL']; ?>" alt="Animation is not being displayed" style="width:304px;height:228px;"></img></a>
					<p><?php echo $value['Name'];?></p>
            </div>
				
			<?php } ?>
		</div>
		<hr>

		<!-- Most liked -->
	
<hr>
			<p>Most Popular</p><hr>
				<div class="row">
			<?php
			//Most liked
foreach ($Q4res as $key => $value) {?>
			<div class="col-md-4">
				<a href="showanimation.php?id=<?php echo $value['MediaID'];?>">
				<img src="<?php echo $value['URL']; ?>" alt="Animation is not being displayed" style="width:304px;height:228px;"></a>
					<p><?php echo $value['Name'];?></p>
                                        </div>
				
			<?php }?>
			</div>
		<hr>
</div>	
	
</html>
