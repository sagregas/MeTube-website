 

<?php 
        
include 'config.php';


        $ID = $_SESSION['id'];
        $sql = "SELECT GroupID,Name,TimeCreated From GroupDis WHERE Sharing='Public' AND OwnerID NOT IN (SELECT UserID FROM Blockedlist WHERE BlockID='$ID') or OwnerID='$ID' UNION SELECT GroupID,Name,TimeCreated From GroupDis WHERE Sharing='Contacts' AND OwnerID IN (SELECT ContactID FROM Contacts WHERE UserID='$ID') AND OwnerID NOT IN (SELECT UserID FROM Blockedlist WHERE BlockID='$ID') UNION SELECT GroupID,Name,TimeCreated From GroupDis WHERE Sharing='Friends' AND OwnerID IN (SELECT FriendID FROM Friends WHERE UserID='$ID') AND OwnerID NOT IN (SELECT UserID FROM Blockedlist WHERE BlockID='$ID') ";
        $result = $conn -> query($sql);
        $count= mysqli_num_rows($result);
        if($count==0)
        echo "No Groups To Show";
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
	
	<tr>
	
	<th>Name</th>
	
	<th>Creation Time</th>
        
	</tr> 
        <?php
while($row=$result->fetch_assoc()){
?>
 <tr>
        
           
    <td>
   <a href="discussions.php?id=<?php echo $row['GroupID']; ?>" style="color:#F66733"> <?php
      echo $row['Name'];
    ?>  </a>  </td>

 <td>
    <?php
      echo $row['TimeCreated'];
    ?>    </td>

</tr>





<?php } ?>
</table>
</body>
</html>
		<?php } ?>
