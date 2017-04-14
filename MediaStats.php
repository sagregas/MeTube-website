<?php
  require_once('config.php');
  $Q1="select * from MediaStats";
$Q1prep=$dbconn->prepare($Q1);
$Q1prep->execute();
$Q1res=$Q1prep->fetchAll(PDO::FETCH_ASSOC);
$previousLikes=$Q1res[0]['LikeID'];
$previousDislikes=$Q1res[0]['DislikeID'];
//$previousViews=$Q1res[0]['Views'];
//$previousSubscribers=$Q1res[0]['SubscriberIds'];
//print_r($previousViews);  //
print_r($previousLikes);  //
print_r($previousDislikes);   //
//print_r($previousSubscribers);  //
echo "Welcome to Media";

//Collecting current id from playvideo.html
if(isset($_POST["UserAccountID"])){
  $currUserId=$_POST["UserAccountID"];
  echo "UserAccountID is:".$currUserId;
}
if(isset($_POST["MediaID"])){
  $currMediaId=$_POST["MediaID"];
  echo "currMediaId is:".$currMediaId;
}
//$currMediaId=1;  //we need to get this from playvideo.html or write this whole code in playlisting.php

//For subscriptions
$Q6="select * from Media where MediaID='$currMediaId'";
$Q6prep=$dbconn->prepare($Q6);
$Q6prep->execute();
$Q6res=$Q6prep->fetchAll(PDO::FETCH_ASSOC);
$subscribeChannel=$Q6res[0]['Channel'];
//echo "subscribe channel is".$subscribeChannel;

//
  $Q7="select LikeID from MediaStats where LikeID='$currUserId' and MediaID='$currMediaId'";
  $Q7prep=$dbconn->prepare($Q7);
  $Q7prep->execute();
  $Q7res=$Q7prep->fetchAll(PDO::FETCH_ASSOC);
  echo "Q7 result is".$Q7res[0]['LikeID'];
  print_r($Q7res);
  if(empty($Q7res)){
    echo "shapath empty aehe";
  }
  $Q8="select DislikeID from MediaStats where DislikeID='$currUserId' and MediaID='$currMediaId'";
  $Q8prep=$dbconn->prepare($Q8);
  $Q8prep->execute();
  $Q8res=$Q8prep->fetchAll(PDO::FETCH_ASSOC);
if(empty($Q8res)){
    echo "shapath 8 pan empty aehe";
  }

//checking if logged in user is not the owner of the media
  if(isset($_POST["Like"])){
    //The following condition exists as Likeids and DislikeIds are complementary
    if(empty($Q7res) && empty($Q8res)){   //checking if the entry exists already
      echo "Inside if";
      $Q="insert into MediaStats values('$currMediaId','$currUserId','0')";
      $Qprep=$dbconn->prepare($Q);
      $Qprep->execute();
    }
    elseif(empty($Q7res)){  //checking if already liked
      $Q1="update MediaStats set LikeID='$currUserId',DislikeID='0' where MediaID='$currMediaId'and DislikeID='$currUserId'";
      $Q1prep=$dbconn->prepare($Q1);
      $Q1prep->execute();
    }
  }
  elseif (isset($_POST["Dislike"])) {
      //The following condition exists as Likeids and DislikeIds are complementary
    if(empty($Q7res) && empty($Q8res)){   //checking if the entry exists already
      echo "Inside if";
      $Q="insert into MediaStats values('$currMediaId','0','$currUserId')";
      $Qprep=$dbconn->prepare($Q);
      $Qprep->execute();
    }
    elseif(empty($Q8res)){  //checking if already liked
      $Q1="update MediaStats set DislikeID='$currUserId',LikeID='0' where MediaId='$currMediaId'and LikeID='$currUserId'";
      $Q1prep=$dbconn->prepare($Q1);
      $Q1prep->execute();
    }
  }
  elseif(isset($_POST['Subscribe'])){
    echo "Subscibe";
        $Q61="insert into Channel (Channel,SubscriberID) values('$subscribeChannel','$currUserId')";
        $Q61prep=$dbconn->prepare($Q61);
        $Q61prep->execute();
  }
  elseif(isset($_POST['unSubscribe'])){
    echo "unSubscibe";
    $Q62="delete from Channel where SubscriberID='$currUserId' and Channel='$subscribeChannel'";
    $Q62prep=$dbconn->prepare($Q62);
    $Q62prep->execute();
  }
  elseif(isset($_POST['addFavorites'])){
    echo "addFavorites";
    $Q71="insert into FavoriteList (UserID,MediaID) values('$currUserId','$currMediaId')";
    $Q71prep=$dbconn->prepare($Q71);
    $Q71prep->execute();
  }
  elseif(isset($_POST['removeFavorites'])){
    echo "Remove FAvorites";
    $Q72="delete from FavoriteList where UserID='$currUserId' and MediaID='$currMediaId'";
    $Q72prep=$dbconn->prepare($Q72);
    $Q72prep->execute();
  }
  elseif(isset($_POST['Rate'])){
    echo "Rating is".$_POST['Rating']."and values are".$currUserId ;
    $Q="select * from MediaRating where RaterID='$currUserId' and MediaID='$currMediaId'";
    $Qprep=$dbconn->prepare($Q);
    $Qprep->execute();
    $Qres=$Qprep->fetchAll(PDO::FETCH_ASSOC);
    $rate=$_POST['Rating'];
  if(empty($Qres)){
    echo "rate is".$rate;
    $Q1="insert into MediaRating values('$currMediaId','$currUserId','$rate')";
    $Q1prep=$dbconn->prepare($Q1);
    $Q1prep->execute();
  }
  else{
    $Q2="update MediaRating set Rating='$rate' where MediaID='$currMediaId' and RaterID='$currUserId'";
    $Q2prep=$dbconn->prepare($Q2);
    $Q2prep->execute();
  }
}
 if($Q6res[0]['Type']=='Video')
header("Location:playvideo.php?id=$currMediaId");     
else if($Q6res[0]['Type']=='Image')
header("Location:showimage.php?id=$currMediaId");
else if($Q6res[0]['Type']=='Audio')
header("Location:playaudio.php?id=$currMediaId");
else if($Q6res[0]['Type']=='Animation')
header("Location:showanimation.php?id=$currMediaId");
?>