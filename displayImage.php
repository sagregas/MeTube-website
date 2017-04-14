<?php
$Imageid=$_GET['id'];
include 'config.php';
$sql = "SELECT URL FROM Media WHERE MediaID='$Imageid'";
$result = $conn -> query($sql);
$row = mysqli_fetch_assoc($result);

?>
<html>
<head>
	<title></title>
</head>
<body>
<img src="<?php echo $row['URL']; ?>" alt="Image not displayed" width="100%" height="100%">
</body>
</html>