<?php
session_start();

require_once('config.php');
	$comment_MediaId=$_POST['MediaId'];
$Q1="select * from Media where MediaID=$comment_MediaId";	
$Q1prep = $dbconn->prepare($Q1);
$Q1prep->execute();
$Q1res=$Q1prep->fetchAll(PDO::FETCH_ASSOC);	
if(isset($_POST['Comment'])){
	$comment_text=$_POST['comment'];
	//$comment_UserId=$_POST['UserId'];
	$comment_UserId=$_SESSION['id'];
	//echo $comment_text;
	//echo $comment_MediaId;
	//echo $comment_UserId;


$Q1="insert into Comments values('','$comment_text','$comment_UserId','$comment_MediaId',now())";	
$Q1prep = $dbconn->prepare($Q1);
$Q1prep->execute();

}
if(isset($_POST['Delete'])){
$deleteComment=$_POST['CommentId'];
$Q1="delete from Comments where CommentID='$deleteComment'";	
$Q1prep = $dbconn->prepare($Q1);
$Q1prep->execute();
}
if($Q1res[0]['Type']=='Video')
header("Location:playvideo.php?id=$comment_MediaId");			//redirect to playvideo.html
else if($Q1res[0]['Type']=='Image')
header("Location:showimage.php?id=$comment_MediaId");
else if($Q1res[0]['Type']=='Audio')
header("Location:playaudio.php?id=$comment_MediaId");
else if($Q1res[0]['Type']=='Animation')
header("Location:showanimation.php?id=$comment_MediaId");
?>
