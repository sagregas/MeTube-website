<?php
include 'config.php';
include 'Users.php';

$ID = $_GET['id'];

$sql = "SELECT * FROM User WHERE ID=$ID";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$FirstName = $row['FirstName'];
$LastName = $row['LastName'];
$Email = $row['Email'];
$Username = $row['Username'];
$Birthdate = $row['Birthdate'];
$Location = $row['Location'];

$Locationerr;
$error = 0;
if(isset($_POST['Submit']))
{
    if(empty($_POST['Location'])){
        $Locationerr="Field cannot be empty";
        $error = 1;
    }
    else
        $Location = $_POST['Location'];


    if($error==0){
        $sql = "UPDATE User SET Location='$Location' WHERE ID='$ID'";
        $conn->query($sql);
    }

}
if(isset($_POST['Go']))
{
    foreach ($_POST as $key => $value) {
        $key=preg_replace( '/_[^_]*$/', '', $key );
        if($key!="Go"){
            //echo $key;
            $sql="SELECT ID From User WHERE Username='$key'";
           $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $ans=$row['ID'];
            if($value =="Accept"){
               //echo "IN ";
                $sql = "INSERT INTO Friends VALUES ('','$ID','$ans')";
               $conn->query($sql);
                $sql = "DELETE FROM FriendRequest WHERE FriendID='$ID' AND  UserID='$ans'";
                $conn->query($sql);

            }
            if($value=="Reject"){
               $sql = "DELETE FROM FriendRequest WHERE FriendID='$ID' AND  UserID='$ans'";
               $conn->query($sql);
            }


        }
    }

}



?>

<html>
<head>
    <title>MeTube - <?php echo $FirstName." ".$LastName; ?></title>
    <script type="text/javascript">
        function update(){
            document.getElementById("Edit").setAttribute('style','visibility:hidden');
            document.getElementById("submit").setAttribute('style','visibility:visible');
            document.getElementById("Location").removeAttribute('readonly');

        }
    </script>

</head>
<body>
<h2><?php echo $FirstName." ".$LastName; ?></h2>
<p><?php echo $Email; ?></p>
<p><?php echo $Username; ?></p>
<p><?php echo $Birthdate; ?></p>
<form name="EditProfile" method="post" action="Profile.php?id=<?php echo $ID; ?>">
    <table>
        <tr>
            <td>Location</td>
            <td><input type="text" id="Location" name="Location" value="<?php echo $Location; ?>" readonly="readonly"></td>
        </tr>
        <tr>
            <td><input type="submit" value="Submit" name="Submit" id="submit" style="visibility: hidden"></td>
            <td><input type="button" value="Edit" id="Edit" onclick="update()"> </td>
        </tr>
    </table>
</form>

<?php showUsers($ID,$conn); ?>
<br><br>
<?php
$sql = "SELECT Username FROM FriendRequest INNER JOIN User ON ID = UserID WHERE FriendID ='$ID'";
$result = $conn->query($sql);

while($row=$result->fetch_assoc()){
    ?>
<form name="Requests" method="post" action="Profile.php?id=<?php echo $ID; ?>">
    <table>
        <tr>
            <td>
    <?php
      echo $row['Username'];
    ?>    </td>
            <td>
<input type="radio" name="<?php echo $row['Username'];?> " value="Accept" >Accept
        </td>
            <td>
                <input type="radio" name="<?php echo $row['Username'];?> " value="Reject" >Reject
            </td>
</tr>

<?php

}
?>
        <tr><td><input type="submit" name="Go" value="Go"></td></tr>
    </table>
</form>
</body>
</html>
