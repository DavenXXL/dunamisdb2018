<?php
$EVENTNAME = $_POST["EVENTNAME"];
$PERSON = $_POST["person"];
$host="localhost";
$user="web";
$db="Dunamis";
$pass="JC5p2svRsFUIrkL1";
$connect = mysqli_connect($host,$user,$pass,$db);
if(!$connect){
  die('Kapcsolódási hiba (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
} else mysqli_query($connect, 'SET NAMES "utf8" collate "utf8_hungarian_ci"');
$sql = "INSERT INTO `$EVENTNAME` (`ID`) VALUES ('".$PERSON."')";
$send = mysqli_query($connect,$sql);
if(!$send){
  die('Query hiba a addtoevent-new.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}
else{
  header('Location: eventshow-new.php?find='.urlencode($EVENTNAME));
}
die("<font color='red'><b>Már korábban hozzá lett adva a kiválasztott listához!</b></font>");
?>
