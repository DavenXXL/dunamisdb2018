<?php
$host="localhost";
$user="web";
$db="Dunamis";
$pass="JC5p2svRsFUIrkL1";
$person = $_POST["person"];
$NAME = $_POST["NAME"];
$EMAIL = $_POST["EMAIL"];
$PHONE = $_POST["PHONE"];
$COUNTRY = $_POST["COUNTRY"];
$CITY = $_POST["CITY"];
$COMMENT = $_POST["COMMENT"];
$INFO = $_POST["INFO"];
$fbset = true;
if(empty($_POST["link"]) || empty($_POST["pic"]) || empty($_POST["mess"])) $fbset = false;
else $FB = '<a target="_BALNK" href="'.$_POST["link"].'"><img style="max-width: 120px;" src="'.$_POST["pic"].'"></a><br><br><a href="'.$_POST["mess"].'" target="_BALNK">Messenger levelezés</a>';
$connect = mysqli_connect($host,$user,$pass,$db);
if (!$connect) {
	die('Kapcsolódási hiba (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}
mysqli_query($connect, 'SET NAMES "utf8" collate "utf8_hungarian_ci"');
$send = mysqli_query($connect,"UPDATE `table` SET `NAME` =  '".$NAME."', `PHONE` = '".$PHONE."', `EMAIL` = '".$EMAIL."', `COUNTRY` = '".$COUNTRY."', `CITY` = '".$CITY."', `COMMENT` = '".$COMMENT."', `INFO` = '".$INFO."' WHERE `ID` = '".$person."' ");
if (!$send) {
	die('Query hiba a sendedit.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}
if($fbset) $send = mysqli_query($connect,"UPDATE `table` SET `FB` = '".$FB."' WHERE `ID` = '".$person."' "); 
if (!$send) {
	die('Query hiba a sendedit.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}
header('Location: show.php?find='.urlencode($person));
?>
