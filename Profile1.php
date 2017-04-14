<?php
session_start();
include 'config.php';
$ID = $_SESSION['id'];
define('VALUE', 'on');
if(empty($ID))
{
header("Location: index.php");
}
//$msg1 = $_SESSION['msg'];

$sql = "SELECT * FROM User WHERE ID=$ID";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$FirstName = $row['FirstName'];
$LastName = $row['LastName'];
$Email = $row['Email'];
$Username = $row['UserName'];
$Birthdate = $row['BirthDate'];
$Location = $row['Location'];
$Description = $row['Description'];

$Locationerr='';
$error = 0;
if(isset($_POST['Confirm']))
{

foreach ($_POST as $key => $value) {
        $key=preg_replace( '/_[^_]*$/', '', $key );
        
        if($value==VALUE){
        if(strpos($key,'Add')!==FALSE){ 
          $a=substr($key,3);
      $sql = "INSERT INTO Friends VALUES ('','$ID','$a')";
          $conn -> query($sql);
          
		  $sql = "INSERT INTO Friends VALUES ('','$a','$ID')";
          $conn -> query($sql);
          
       }
      
       if(strpos($key,'Block')!==FALSE){ 
          $a=substr($key,5);
      
          $sql = "INSERT INTO Blockedlist VALUES ('','$ID','$a')";
          $conn -> query($sql);
       }
	   if(strpos($key,'Remove')!==FALSE){ 
          $a=substr($key,6);
      
          $sql = "DELETE FROM Contacts WHERE ContactID=$a AND UserID=$ID";
          $conn -> query($sql);
		  $sql = "DELETE FROM Contacts WHERE ContactID=$ID AND UserID=$a";
          $conn -> query($sql);
		  $sql = "DELETE FROM Blockedlist WHERE BlockID=$a AND UserID=$ID";
          $conn -> query($sql);
		  $sql = "DELETE FROM Friends WHERE FriendID=$a AND UserID=$ID";
          $conn -> query($sql);
		  $sql = "DELETE FROM Contacts WHERE FriendID=$ID AND UserID=$a";
          $conn -> query($sql);
		  
       }
       }

}}
if(isset($_POST['Submit']))
{
    if(empty($_POST['Location'])){
        $Locationerr="Field cannot be empty";
        $error = 1;
    }
    else
        $Location = $_POST['Location'];
	    $Description = $_POST['Description'];


    if($error==0){
        $sql = "UPDATE User SET Location='$Location' , Description='$Description' WHERE ID='$ID'";
        $conn->query($sql);
    }

}

$ID =  $_SESSION['id'];
$nameerr='';
$msg='';
//include 'Profile1.php';
if(isset($_POST['submit12']))
{
if(empty($_POST['name1']))
{
$nameerr = "Name field required";
}
else{
$name = $_POST['name1'];

$sql = "SELECT * FROM ChannelCreator WHERE Name='$name'";
$result = $conn -> query($sql);
$count= mysqli_num_rows($result);

if($count==0)
{
$sql = "INSERT INTO ChannelCreator VALUES ('','$name','$ID')";
$conn -> query($sql);
$sql = "INSERT INTO Channel VALUES ('','$name','$ID')";
$conn -> query($sql);
$msg = "Your channel has been created successfully";
}
else{
$nameerr = "Name already exists. Choose a different name.";
}
}
}

$grouperr='';
$msg2='';
if(isset($_POST['submit3']))
{
if(empty($_POST['name'])||empty($_POST['title'])||empty($_POST['Sharing']))
{
$grouperr = "Please make sure to enter all fields";
}
else{
$name = $_POST['name'];
$title= $_POST['title'];
$sharing=$_POST['Sharing'];

$sql3 = "SELECT * FROM GroupDis WHERE Name='$name'";
$result3 = $conn -> query($sql3);
$count= mysqli_num_rows($result3);

if($count==0)
{
	
$sql3 = "INSERT INTO GroupDis VALUES ('','$name','$title','$ID','$sharing',now())";
$conn -> query($sql3);
$msg2 = "Your group has been created successfully";
}
else{
$grouperr = "Group already exists. Choose a different name.";
}
}
}

$msg1='';
$ID = $_SESSION['id'];
if(isset($_POST['submit2']))
{
    
  if(empty($_FILES['file']['name'])||empty($_POST['Category'])||empty($_POST['keywords'])||empty($_POST['Channel'])||empty($_POST['Type'])||empty($_POST['Sharing'])||empty($_POST['Discussion'])||empty($_POST['title']))
 {  $msg1="Failed to upload. Please try again. Make sure to enter all the fields";
    
}
    
   else{
    $name= $_FILES['file']['name'];
   $title = $_POST['title'];
    $temp = $_FILES['file']['tmp_name'];
   // echo $name;
   $sharing=$_POST['Sharing'];
   $discussion=$_POST['Discussion'];
    $category = $_POST['Category'];
    $type = $_POST['Type'];
    $keywords = $_POST['keywords'];
    $channel = $_POST['Channel'];
	$url = "test_upload/$name";
    if (move_uploaded_file($_FILES['file']['tmp_name'], 'test_upload/' . $name))
	{ $msg1 = "Successfully uploaded";
	  chmod('test_upload/'.$name,0644);
	}
    else
     $msg1="Failed to upload. Please try again. Make sure to enter all the fields";
   //echo $msg;
    $url = "test_upload/$name";
	
    $sql = "INSERT INTO Media VALUES ('', '$ID', '$title','$url','$type','$category','$keywords',0,'$channel',now(),0,'$sharing','$discussion')";
}
    $conn->query($sql);
   echo mysqli_error($conn);
//header("location: Profile1.php");
//header("refresh:1; url=Profile1.php");

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
  <script type="text/javascript">
        function update(){
            document.getElementById("Edit").setAttribute('style','visibility:hidden');
            document.getElementById("submit").setAttribute('style','visibility:visible');
            document.getElementById("Location").removeAttribute('readonly');
			document.getElementById("Description").removeAttribute('readonly');

        }

    </script>

    <script>
        <?php 
          echo "var chanelerr = '{$nameerr}';";
          echo "var chanelmsg = '{$msg}';";
          echo "var uploadmsg = '{$msg1}';";
		  echo "var groupmsg = '{$msg2}';";
		  echo "var grouperr1 = '{$grouperr}';";
        ?>
    
    if(uploadmsg!=''){
      $(document).ready(function(){ 
                $('#UploadMedia').addClass('active');
                $('#Friends').removeClass('active');
				$('#Contacts').removeClass('active');
        $('#Blocked').removeClass('active');
		$('#CreateGroup').removeClass('active');
        $('#CreateChannel').removeClass('active');
		$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
        $('#Info').removeClass('active');
                $("#Info1").hide();
                $("#Friends1").hide();
				$("#Contacts1").hide();
        $("#Blocked1").hide();
        $('#CreateChannel1').hide();   
        $('#CreateGroup1').hide();
        $('#UploadMedia1').show();

                $("#Info").click(function(){
                $(this).addClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
                $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
        $('#CreateChannel').removeClass('active');
                $("#Info1").show();
                $("#Friends1").hide();
        $("#Blocked1").hide();
        $('#UploadMedia1').hide();  
                $('#CreateChannel1').hide();
        });
            $("#Friends").click(function(){
                $(this).addClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
                $('#Info').removeClass('active');
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
        $('#CreateChannel').removeClass('active');
                $("#Friends1").show();
                $("#Info1").hide();
        $("#Blocked1").hide();
        $('#UploadMedia1').hide();
        $('#CreateChannel1').hide();
            });
           $("#Blocked").click(function(){
                $(this).addClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#UploadMedia').removeClass('active');
        $('#CreateChannel').removeClass('active');
                $("#Blocked1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
        $('#UploadMedia1').hide();
        $('#CreateChannel1').hide();
           
            });
       $("#UploadMedia").click(function(){
                $(this).addClass('active');$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#CreateChannel').removeClass('active');
                $("#UploadMedia1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#CreateChannel1').hide();
           
            });
        $("#CreateChannel").click(function(){
                $(this).addClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#CreateChannel1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
            }); 
			$("#Contacts").click(function(){
                $(this).addClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#CreateChannel').removeClass('active');
				$("#CreateChannel1").hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
		$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
        $('#UploadMedia').removeClass('active');
                $("#Contacts1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
            }); 
			$("#CreateGroup").click(function(){
                $(this).addClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateChannel').removeClass('active');
				$('#CreateChannel1').hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#CreateGroup1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
        });
		$("#MyChannel").click(function(){
                $(this).addClass('active');
				$('#CreateGroup').removeClass('active');
                $("#CreateGroup1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateChannel').removeClass('active');
				$('#CreateChannel1').hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#MyChannel1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
        });
		$("#MyGroup").click(function(){
                $(this).addClass('active');
				$('#CreateGroup').removeClass('active');
                $("#CreateGroup1").hide();
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateChannel').removeClass('active');
				$('#CreateChannel1').hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#MyGroup1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
        });
	  });
        }
        
        
       if((chanelerr!='')||(chanelmsg!='')){
      $(document).ready(function(){ 
	  $(this).addClass('active');
                $('#CreateChannel').addClass('active');
                $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
		$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
		$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
        $('#UploadMedia').removeClass('active');
        $('#Info').removeClass('active');
		$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
                $("#Info1").hide();
                $("#Friends1").hide();
        $("#Blocked1").hide();
        $('#UploadMedia1').hide();  
                $('#CreateChannel1').show();

                $("#Info").click(function(){
                $(this).addClass('active');
                $('#Friends').removeClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
        $('#CreateChannel').removeClass('active');
                $("#Info1").show();
                $("#Friends1").hide();
        $("#Blocked1").hide();
        $('#UploadMedia1').hide();  
                $('#CreateChannel1').hide();
        });
            $("#Friends").click(function(){
                $(this).addClass('active');
				$('#Contacts').removeClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$("#Contacts1").hide();
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
                $('#Info').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
        $('#CreateChannel').removeClass('active');
                $("#Friends1").show();
                $("#Info1").hide();
        $("#Blocked1").hide();
        $('#UploadMedia1').hide();
        $('#CreateChannel1').hide();
            });
           $("#Blocked").click(function(){
                $(this).addClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#UploadMedia').removeClass('active');
        $('#CreateChannel').removeClass('active');
                $("#Blocked1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
        $('#UploadMedia1').hide();
        $('#CreateChannel1').hide();
           
            });
       $("#UploadMedia").click(function(){
                $(this).addClass('active');
                $('#Info').removeClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#CreateChannel').removeClass('active');
                $("#UploadMedia1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#CreateChannel1').hide();
           
            });
        $("#CreateChannel").click(function(){
                $(this).addClass('active');
                $('#Info').removeClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
        $('#Friends').removeClass('active');
		$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#CreateChannel1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
            }); 
			$("#Contacts").click(function(){
                $(this).addClass('active');
				$('#CreateChannel').removeClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$("#CreateChannel1").hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
		$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#Contacts1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
            }); 
			$("#CreateGroup").click(function(){
                $(this).addClass('active');
				$('#Contacts').removeClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$("#Contacts1").hide();
				$('#CreateChannel').removeClass('active');
				$('#CreateChannel1').hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#CreateGroup1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
        });
		$("#MyChannel").click(function(){
                $(this).addClass('active');
				$('#CreateGroup').removeClass('active');
                $("#CreateGroup1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateChannel').removeClass('active');
				$('#CreateChannel1').hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#MyChannel1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
        });
		$("#MyGroup").click(function(){
                $(this).addClass('active');
				$('#CreateGroup').removeClass('active');
                $("#CreateGroup1").hide();
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateChannel').removeClass('active');
				$('#CreateChannel1').hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#MyGroup1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
        });
        });
        
        }
		if((grouperr1!='')||(groupmsg!='')){
      $(document).ready(function(){ 
                $('#CreateGroup').addClass('active');
                $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
		$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
		$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
        $('#UploadMedia').removeClass('active');
        $('#Info').removeClass('active');
		$('#CreateChannel').removeClass('active');
				$('#CreateGroup1').show();
                $("#Info1").hide();
                $("#Friends1").hide();
        $("#Blocked1").hide();
        $('#UploadMedia1').hide();  
                $('#CreateChannel1').hide();

                $("#Info").click(function(){
                $(this).addClass('active');
                $('#Friends').removeClass('active');
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
        $('#CreateChannel').removeClass('active');
                $("#Info1").show();
                $("#Friends1").hide();
        $("#Blocked1").hide();
        $('#UploadMedia1').hide();  
                $('#CreateChannel1').hide();
        });
            $("#Friends").click(function(){
                $(this).addClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
                $('#Info').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
        $('#CreateChannel').removeClass('active');
                $("#Friends1").show();
                $("#Info1").hide();
        $("#Blocked1").hide();
        $('#UploadMedia1').hide();
        $('#CreateChannel1').hide();
            });
           $("#Blocked").click(function(){
                $(this).addClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#UploadMedia').removeClass('active');
        $('#CreateChannel').removeClass('active');
                $("#Blocked1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
        $('#UploadMedia1').hide();
        $('#CreateChannel1').hide();
           
            });
       $("#UploadMedia").click(function(){
                $(this).addClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
                $('#Info').removeClass('active');
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#CreateChannel').removeClass('active');
                $("#UploadMedia1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#CreateChannel1').hide();
           
            });
        $("#CreateChannel").click(function(){
                $(this).addClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
                $('#Info').removeClass('active');
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
        $('#Friends').removeClass('active');
		$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#CreateChannel1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
            }); 
			$("#Contacts").click(function(){
                $(this).addClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#CreateChannel').removeClass('active');
				$("#CreateChannel1").hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
		$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#Contacts1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
            }); 
			$("#CreateGroup").click(function(){
                $(this).addClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateChannel').removeClass('active');
				$('#CreateChannel1').hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#CreateGroup1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
        });
		$("#MyChannel").click(function(){
                $(this).addClass('active');
				$('#CreateGroup').removeClass('active');
                $("#CreateGroup1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateChannel').removeClass('active');
				$('#CreateChannel1').hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#MyChannel1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
        });
		$("#MyGroup").click(function(){
                $(this).addClass('active');
				$('#CreateGroup').removeClass('active');
                $("#CreateGroup1").hide();
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateChannel').removeClass('active');
				$('#CreateChannel1').hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#MyGroup1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
        });
        });
        
        }
        else{
        $(document).ready(function(){
             
            $("#Info").click(function(){
                $(this).addClass('active');
                $('#Friends').removeClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
        $('#CreateChannel').removeClass('active');
                $("#Info1").show();
                $("#Friends1").hide();
        $("#Blocked1").hide();
        $('#UploadMedia1').hide();  
                $('#CreateChannel1').hide();
        });
            $("#Friends").click(function(){
                $(this).addClass('active');
                $('#Info').removeClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
        $('#CreateChannel').removeClass('active');
                $("#Friends1").show();
                $("#Info1").hide();
        $("#Blocked1").hide();
        $('#UploadMedia1').hide();
        $('#CreateChannel1').hide();
            });
           $("#Blocked").click(function(){
                $(this).addClass('active');
                $('#Info').removeClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
        $('#Friends').removeClass('active');
        $('#UploadMedia').removeClass('active');
        $('#CreateChannel').removeClass('active');
                $("#Blocked1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
        $('#UploadMedia1').hide();
        $('#CreateChannel1').hide();
           
            });
       $("#UploadMedia").click(function(){
                $(this).addClass('active');
                $('#Info').removeClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#CreateChannel').removeClass('active');
                $("#UploadMedia1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#CreateChannel1').hide();
           
            });
        $("#CreateChannel").click(function(){
                $(this).addClass('active');
                $('#Info').removeClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#CreateChannel1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
            }); 
			$("#Contacts").click(function(){
                $(this).addClass('active');
				$('#CreateChannel').removeClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$("#CreateChannel1").hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
		$('#CreateGroup').removeClass('active');
				$('#CreateGroup1').hide();
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#Contacts1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
            }); 
			$("#CreateGroup").click(function(){
                $(this).addClass('active');
				$('#Contacts').removeClass('active');
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$("#Contacts1").hide();
				$('#CreateChannel').removeClass('active');
				$('#CreateChannel1').hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#CreateGroup1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
        });
		$("#MyChannel").click(function(){
                $(this).addClass('active');
				$('#CreateGroup').removeClass('active');
                $("#CreateGroup1").hide();
				$('#MyGroup').removeClass('active');
                $("#MyGroup1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateChannel').removeClass('active');
				$('#CreateChannel1').hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#MyChannel1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
        });
		$("#MyGroup").click(function(){
                $(this).addClass('active');
				$('#CreateGroup').removeClass('active');
                $("#CreateGroup1").hide();
				$('#MyChannel').removeClass('active');
                $("#MyChannel1").hide();
				$('#Contacts').removeClass('active');
				$("#Contacts1").hide();
				$('#CreateChannel').removeClass('active');
				$('#CreateChannel1').hide();
                $('#Info').removeClass('active');
        $('#Friends').removeClass('active');
        $('#Blocked').removeClass('active');
        $('#UploadMedia').removeClass('active');
                $("#MyGroup1").show();
                $("#Info1").hide();
        $("#Friends1").hide();
                $("#Blocked1").hide();
        $('#UploadMedia1').hide();
           
        });
            
        });}
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


#searchbar input[type=text]{width:560px;}
</style>
  </head>

  <body>
<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
  
     <a class="navbar-brand" href="home.php" style="color:white; padding-top:0px; padding-bottom:0px; font-size: 40px !important;">
MeTube
</a>
    </nav>
    <nav class="navbar navbar-default navbar-inverse navbar-static-top">
	
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" id="Userlinks">Welcome <?php echo $Username; ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
		  <li><a id="Userlinks" href="featuresearch.php">Adv.Search</a></li>
		  <li><a id="Userlinks" href="home.php">Home</a></li>
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
          <li><a id="Info" class="active" href="#Info">Info</a></li>
		   <li><a id="Contacts" href="#Contacts">My Contacts</a></li>
    <li><a id="Friends" href="#Friends">Friends</a></li>
    
    <li><a id="Blocked" href="#Blocked">Blocked Users</a></li>
    <li><a id="UploadMedia" href="#UploadMedia">Upload Media</a></li>
    <li><a id="CreateChannel" href="#CreateChannel" >Create Channel</a></li>
	<li><a id="CreateGroup" href="#CreateGroup" >Create Group</a></li>
	<li><a id="MyChannel" href="#MyChannel" >My Channels</a></li>
	<li><a id="MyGroup" href="#MyGroup" >My Groups</a></li>
          </ul>
          
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        

          <div id="Info1">


      <h2><?php echo $FirstName." ".$LastName; ?></h2>
<p><?php echo $Email; ?></p>
<p><?php echo $Username; ?></p>
<p><?php echo $Birthdate; ?></p>
<form name="EditProfile" method="post" action="Profile1.php">
    <table style="padding:10px" class="profile">
        <tr>
            <td>Location</td>
            <td><input type="text" id="Location" name="Location" value="<?php echo $Location; ?>" readonly="readonly"></td>
        </tr>
		<tr>
            <td>About Me</td>
            <td><textarea id="Description" name="Description" rows="4" cols="50" readonly="readonly">
<?php echo $Description; ?>
</textarea></td>
        </tr>
        <tr>
            <td><input type="submit" class="btn1" value="Submit" name="Submit" id="submit" style="visibility: hidden"></td>
            <td><input type="button"  class ="btn1" value="Edit" id="Edit" onclick="update()"> </td>
        </tr>
    </table>
	<br>
	<a href="#" id="UserLinks" onclick="window.open('changePassword.php','Change Password','scrollbars=yes,width=650,height=500')">Change Password</a>
</form>
 
    </div>
	<div id="Contacts1" style="display:none">
	<?php 
	
	$sql = "SELECT * FROM User WHERE ID IN (SELECT ContactID FROM Contacts WHERE UserID=$ID)";
	$result5 = $conn->query($sql);
if(mysqli_num_rows($result5)==0)
{
echo "No results";
}
else{?>	<div class="table-responsive">
<table class="data">

                    <tr>

                        <th>FirstName</th>
                        <th>LastName</th>
                        <th>UserName</th>

                        <th>Add Friend?</th>
                        
                        <th>Block?</th>
						 <th>Remove Contact?</th>
                    </tr>
 
            <br><br>
            <form name="usernames" action="Profile1.php" method="post" >
                
                    <?php
                    while($row=$result5->fetch_assoc()){

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
                            echo $row['UserName'];
                            ?>    </td>

                        <?php
                        $FriendID = $row['ID'];

                        $sql1 = "SELECT * FROM Friends WHERE UserID=$ID AND FriendID=$FriendID";
                        $result1 = $conn -> query($sql1);
                        
                        
                        $sql4 = "SELECT * FROM Blockedlist WHERE UserID=$ID AND BlockID=$FriendID";
                        $result4 = $conn -> query($sql4);
                        if(mysqli_num_rows($result1)==1)
                        {
                            ?>
                            <td>
                               Already a Friend
                            </td>
                        <?php }
                        else{?>
                            <td>
                                <input type="checkbox" name="<?php echo "Add".$row['ID']; ?>" >
                            </td>

                            <?php
                        }
                       
                       
                        if(mysqli_num_rows($result4)==1)
                        {
                            ?>
                            <td>
                                Blocked
                            </td>
                        <?php } else{?>
                            <td>
                                <input type="checkbox" name="Block<?php echo $row['ID']; ?>" >
                            </td>
							
                            

                            <?php
                        }?>
						<td>
							<input type="checkbox" name="Remove<?php echo $row['ID']; ?>" >
							</td></tr><?php

                    }
                    ?>
                </table>
               </div>
                <input type="submit" class="btn1" name="Confirm" value="Confirm">
            </form>
         <?php } ?>   
	</div>
	
    <div id="Friends1" style="display:none">
<?php include 'friendmanger.php'; ?>
           </div>

<div id="Blocked1" style="display:none">
  <?php include 'blockmanager.php'; ?>      
    </div>
<div id="UploadMedia1" style="display:none">
  <h3> Welcome to the MeTube upload center </h3>
<p>Kindly adhere to the policies of MeTube while uploading the file. Obscenity will not be tolerated.</p>
<form class="form-horizontal" name="uploader" action="Profile1.php" method="post" enctype="multipart/form-data">
<table class="upload">

<tr>
<td>
Please select the media type
</td>
<td>
<select name="Type">
                    <option value="">Select..</option>
                    <option value="Video">Video</option>
                    <option value="Audio">Audio</option>
            <option value="Image">Image</option>
            <option value="Animation">Animation</option>
</select>
</td>
</tr>
<tr>
<td>
Title
</td>
<td>
<input type="text" name="title">
</td>
</tr>
<tr>
<td>
Choose the file to upload..
</td>
<td>
<input type="file" name="file" />(.mp4 for Video; .mp3 for Audio; .jpeg,.png,.gif for others)
</td>
</tr>
<tr>
<td>
Please select the category
</td>
<td>
<select name="Category">
                    <option value="">Select..</option>
                    <option value="Music">Music</option>
                    <option value="Entertainment">Entertainment</option>
            <option value="Sports">Sports</option>
            <option value="Gaming">Gaming</option>
			<option value="News">News</option>
</select>
</td>
</tr>
<tr>
<td>
Enter keywords (Sepearate each keyword with a space)
</td>
<td>
<input type="text" name="keywords">
</td>
</tr>
<tr>
<td>
Please select the channel
</td>
<td>
<select name="Channel">
            <option value="">Select..</option>
<?php 
$sql = "SELECT * FROM ChannelCreator WHERE OwnerID='$ID'";
$result = $conn -> query($sql);
while($row = $result->fetch_assoc()){
?>
                    
                    <option value="<?php echo $row['Name']; ?>"><?php echo $row['Name']; ?></option>
<?php } ?>                    
</select>
</td>
</tr>
<tr>
<td>
Sharing
</td>
<td>
<select name="Sharing">
                    <option value="">Select..</option>
                    <option value="Public">Public</option>
                    <option value="Contacts">Contacts</option>
            <option value="Friends">Friends</option>
           
</select>
</td>
</tr>
<tr>
<td>
Allow Discussion
</td>
<td>
<select name="Discussion">
                    <option value="">Select..</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
            
           
</select>
</td>
</tr>
</table>        
<input type="submit" class="btn1" name="submit2" value="Upload">
</form>
<p><?php echo $msg1; ?></p>
    
    </div>

<div id="CreateChannel1" style="display:none">
<a name="CreateChannel"></a>
 

<h1>Create your own channel</h1><br>
<form class="form-horizontal" name="channelcreator12" method="post" action="Profile1.php">
<div class="form-group">
      <label class="control-label col-sm-2" for="email">Enter Channel Name:</label>
      <div class="col-sm-3">        
        <input type="text" class="form-control" name="name1" placeholder="Enter channel name"><span class="error"><?php echo $nameerr; ?></span>
      </div>
    </div>
<div class="form-group">        
      <div class="col-sm-offset-1 col-sm-3">
        <input type="submit" class="btn btn-default" id="ChannelButton" name="submit12" value="Create">
      </div>
    </div>

</form>
<p><?php echo $msg; ?><p>   
    </div>
<div id="CreateGroup1" style="display:none">
<h1>Create your own Group</h1><br>
<form class="form-horizontal" name="channelcreator" method="post" action="Profile1.php">
<div class="form-group">
      <label class="control-label col-sm-2" for="email">Enter Group Name:</label>
      <div class="col-sm-3">        
        <input type="text" class="form-control" required="" name="name" placeholder="Enter Group name"><span class="error"><?php echo $grouperr; ?></span>
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="email">Discussion Title:</label>
      <div class="col-sm-3">        
        <textarea class="form-control" id="title" name="title" rows="4" cols="50" required=""></textarea>
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="email">Sharing:</label>
      <div class="col-sm-3">        
        <select class="form-control" name="Sharing">
                    <option value="">Select..</option>
                    <option value="Public">Public</option>
                    <option value="Contacts">Contacts</option>
            <option value="Friends">Friends</option>
           
</select><span class="error"><?php echo $nameerr; ?></span>
      </div>
    </div>
	<br><br>
<div class="form-group">        
      <div class="col-sm-offset-1 col-sm-3">
        <input type="submit" class="btn btn-default" id="ChannelButton" name="submit3" value="Create">
      </div>
    </div>

</form>
<p><?php echo $msg2; ?><p>
</div>
<div id="MyChannel1" style="display:none">
<?php include 'channelmanager.php'; ?>
</div>
<div id="MyGroup1" style="display:none">
<?php include 'groupmanager.php'; ?>
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
