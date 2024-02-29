<?php
$host="localhost";
$user="web";
$db="Dunamis";
$pass="JC5p2svRsFUIrkL1";
$connect = mysqli_connect($host,$user,$pass,$db);
if(!$connect){
    die('Kapcsolódási hiba (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}
else mysqli_query($connect, 'SET NAMES "utf8" collate "utf8_hungarian_ci"');
$file = fopen("tmp/new.csv", "w");
$handle = file_get_contents("tmp/inputfile.csv");
$x = 0;
$line = explode("\n",$handle);
do{
  $data = mysqli_query($connect,"SELECT * FROM `table` WHERE EMAIL = '".trim($line[$x])."'");
  if(!$data) echo "ERROR";
  else {
    if(mysqli_num_rows($data) != 0){
      echo "<font color='green'>".$line[$x]."</font><br>";
    }
    else{
      echo "<font color='red'>".$line[$x]."</font><br>";
    	fwrite($file,$line[$x]);
    }
  }
  $y = $x;
  $x = $x + 1;
}
while($line[$y] != "");
fclose($file);
?>
