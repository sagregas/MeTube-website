 

<?php 
    
include 'config.php';
if(isset($_POST['submit223']))
{
    foreach ($_POST as $key => $value) {
        $key=preg_replace( '/_[^_]*$/', '', $key );
        if($key!="submit" && $value=="on"){
           //echo $key;
            $sql1 = "SELECT Name FROM ChannelCreator WHERE ChannelID=$key";
			$result1=$conn->query($sql1);
			$row1 = mysqli_fetch_assoc($result1);
			$cName= $row1['Name'];
	    	echo $cName;
            $sql="DELETE FROM Channel WHERE Channel= '$cName'";
          $conn->query($sql);
            $sql="DELETE FROM Media WHERE Channel = '$cName'";
          $conn->query($sql);
            $sql="DELETE FROM ChannelCreator WHERE ChannelID=$key";
          $conn->query($sql);
            


        }

    }
header("location: Profile1.php");
//header("refresh:1; url=Profile1.php");
}


        $ID = $_SESSION['id'];
        $sql = "SELECT * FROM ChannelCreator WHERE OwnerID='$ID'";
        $result = $conn -> query($sql);
        $count= mysqli_num_rows($result);
        if($count==0)
        echo "No Channels";
        else{
         ?>
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
	<table class="data">
	<form name="blockmanager1a" method="post" action="channelmanager.php">
	<tr>
	
	<th>Name</th>
	
	<th>Delete</th>
	</tr> 
        <?php
while($row=$result->fetch_assoc()){
?>
 <tr>
        
   <input type="text" name="<?php echo $row['Name']; ?>" hidden>        
    <td>
    <?php
      echo $row['Name'];
    ?>    </td>

 
            <td>
<input type="checkbox" name="<?php echo $row['ChannelID']; ?>" >
</td>
</tr>

<?php


}
?>
</table>
<input type="submit" class="btn1" name="submit223" value="Confirm">
</form>
<?php } ?>
</body>
</html>

