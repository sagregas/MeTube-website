<?php
session_start();
$mediaID = $_SESSION['mediaId'];
include 'config.php';
if(isset($_POST['download'])){
	$Q1="select * from Media where MediaID='$mediaID'";
$Q1prep=$dbconn->prepare($Q1);
$Q1prep->execute();
$Q1res=$Q1prep->fetchAll(PDO::FETCH_ASSOC);

$url= $Q1res[0]['URL'];
$name=$Q1res[0]['Name'];
$name1=str_replace("test_upload/","","$url");

 header('Content-Description: File Transfer');

    header('Content-Type: application/force-download');

    header("Content-Disposition: attachment; filename=\"" . basename($name1) . "\";");

    header('Content-Transfer-Encoding: binary');

    header('Expires: 0');

    header('Cache-Control: must-revalidate');

    header('Pragma: public');

    header('Content-Length: ' . filesize($url));

    ob_clean();

    flush();

    readfile($url); //showing the path to the server where the file is to be download

    exit;
}

?>
