<?php
$host="localhost";
$user="web";
$db="Dunamis";
$pass="JC5p2svRsFUIrkL1";
$EVENTNAME = $_POST["EVENTNAME"];
$DATE = $_POST["DATE"];
$COMMENT = $_POST["COMMENT"];
$INFO = $_POST["INFO"];
$PLACE = $_POST["PLACE"];
$connect = mysqli_connect($host,$user,$pass,$db);
if (!$connect) {
	die('Kapcsolódási hiba (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}
mysqli_query($connect, 'SET NAMES "utf8" collate "utf8_hungarian_ci"');
$sql = "UPDATE `list_of_events` SET `DATE` = '".$DATE."', `PLACE` = '".$PLACE."', `INFO` = '".$INFO."' , `COMMENT` = '".$COMMENT."' WHERE `EVENTNAME` = '".$EVENTNAME."' ";
$send = mysqli_query($connect,$sql);
if(!$send){
	echo $sql;
	die('Query hiba a eventupdate-new.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}
if(!empty($_POST["DPERSON"])) {
    foreach($_POST["DPERSON"] as $ID) {
		$sql = "DELETE FROM `$EVENTNAME` WHERE `ID` = '$ID'";
		$send2 = mysqli_query($connect,$sql);
		if(!$send2){
			echo $sql;
			die('Query 2 hiba a eventupdate.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		}
	}
}
header('Location: eventshow-new.php?find='.urlencode($EVENTNAME));
?>