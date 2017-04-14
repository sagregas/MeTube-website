<?php

include 'config.php';



if(isset($_POST['submit']))
{
    foreach ($_POST as $key => $value) {
        $key=preg_replace( '/_[^_]*$/', '', $key );
        if($key!="submit"){
           if($key=="ID")
{
$ID1= $value;
}
if($key=="riquelm")
{
$ch= $value;
}
if($value=="on"){
            
	    	
            $sql="DELETE FROM Channel WHERE Channel='$ch' AND SubscriberID ='$ID1'";
          $conn->query($sql);
            }


        }

    }
header("location: home.php");
//header("refresh:1; url=Profile1.php");
}

?>
<!DOCTYPE html>
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
</style>

</head>
<body>
<?php
$ID = $_SESSION['id'];

$sql = "SELECT Channel FROM Channel WHERE SubscriberID='$ID'";
$result = $conn -> query($sql);
$count= mysqli_num_rows($result);
//$row=$result->fetch_assoc();
if($count==0)
echo "You have no subscriptions!";
else
{

?>
<table class="data">
<form name="subscriptions" method="post" action="subscriptions.php">
<tr>
<th>Channel Name</th>

<th>View</th>
<th>Unsubscribe?</th>
</tr>
<?php
while($row=$result->fetch_assoc()){
	$channel = $row['Channel'];	
$sql1 = "SELECT MediaID FROM Media WHERE Channel='$channel' ORDER BY UploadTime LIMIT 1";
	$result1 = $conn -> query($sql1);
	$row1=$result1->fetch_assoc();
?>
 <tr>

 <input type="text" name="ID" value="<?php echo $ID; ?>" hidden>  
       
<input type="text" name="riquelm" value="<?php echo $row['Channel'];?>" hidden> 
            <td>
    <?php
      echo $row['Channel'];
    ?>    </td>
    
<td><a href="channel.php?id=<?php echo $row1['MediaID'] ?>" style="color: #F66733">View</a>
</td>
            <td>
<input type="checkbox" name="<?php echo $row['Channel']; ?>" >
</td>
</tr>

<?php


}
?>


</table>
<input type="submit" class="btn1" name="submit" value="Confirm">
</form>
<?php } ?>
</body>
</html>