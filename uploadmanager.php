 

<?php 
        
include 'config.php';
if(isset($_POST['submit']))
{
    foreach ($_POST as $key => $value) {
        $key=preg_replace( '/_[^_]*$/', '', $key );
        if($key!="submit" && $value=="on"){
            
            $sql = "DELETE FROM Playlist WHERE MediaID=$key";
			$conn->query($sql);
	    	
            $sql="DELETE FROM Media WHERE MediaID=$key";
          $conn->query($sql);
            


        }

    }
header("location: home.php");
//header("refresh:1; url=Profile1.php");
}


        $ID = $_SESSION['id'];
        $sql = "SELECT MediaID, Name, Type,Category, Channel, UploadTime FROM Media WHERE UploaderID=$ID";
        $result = $conn -> query($sql);
        $count= mysqli_num_rows($result);
        if($count==0)
        echo "No Media";
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
	<form name="blockmanager1a" method="post" action="uploadmanager.php">
	<tr>
	
	<th>Name</th>
	<th>Type</th>
	<th>Category</th>
	<th>Channel</th>
	<th>Upload Time</th>
        <th>View</th>
	<th>Delete</th>
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
      echo $row['Category'];
    ?>    </td>
<td>
    <?php
      echo $row['Channel'];
    ?>    </td>
<td>
    <?php
      echo $row['UploadTime'];
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
	<a href="showanimation.php?id=<?php echo $row['MediaID'] ?>" style="color: #F66733">View</a></td><?php }	?>
	
            <td>
<input type="checkbox" name="<?php echo $row['MediaID']; ?>" >
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

