

<?php

include 'config.php';



if(isset($_POST['submit']))
{
    foreach ($_POST as $key => $value) {
        $key=preg_replace( '/_[^_]*$/', '', $key );
        if($key!="submit" && $key!="Username"){
           if($key=="ID")
{
$ID1= $value;
}
if($value=="on"){
            
	    	
            $sql="DELETE FROM Blockedlist WHERE BlockID IN (SELECT ID FROM User WHERE Username LIKE '$key') AND UserID =$ID1";
          $conn->query($sql);
            }


        }

    }
header("location: Profile1.php");
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

$sql = "SELECT FirstName, LastName, Email, Username FROM User WHERE ID IN (SELECT BlockID from Blockedlist WHERE UserID=$ID)";
$result = $conn -> query($sql);
$count= mysqli_num_rows($result);
//$row=$result->fetch_assoc();
if($count==0)
echo "You havent blocked any users!";
else
{
?>
<table class="data">
<form name="blockmanager" method="post" action="blockmanager.php">
<tr>
<th>First Name</th>
<th>Last Name</th>
<th>User Name</th>
<th>Email</th>
<th>Unblock?</th>
</tr>
<?php
while($row=$result->fetch_assoc()){
?>
 <tr>

 <input type="text" name="ID" value="<?php echo $ID; ?>" hidden>   
       
<input type="text" name="Username" value="<?php echo $row['Username'];?>" hidden> 
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
      echo $row['Username'];
    ?>    </td>
<td>
    <?php
      echo $row['Email'];
    ?>    </td>
            <td>
<input type="checkbox" name="<?php echo $row['Username']; ?>" >
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

