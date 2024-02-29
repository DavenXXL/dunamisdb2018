<?PHP
$host="localhost";
$user="web";
$db="Dunamis";
$pass="JC5p2svRsFUIrkL1";
$connect = mysqli_connect($host,$user,$pass,$db);
if(!$connect){
    die('Kapcsolódási hiba (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}
else{ 
mysqli_query($connect, 'SET NAMES "utf8" collate "utf8_hungarian_ci"');
$query = mysqli_query($connect,'SELECT * FROM `table`');
	while($data = mysqli_fetch_assoc($query)){
		if(!empty($data["FB"] && strpos($data["FB"], 'show.php?find=') === false)){
			$ID = strstr($data["FB"], '" target="_BALNK">Messenger',true);
			$ID = substr($ID, strpos($ID, '/t/'));
			$ID = substr($ID,3);
			echo "UPDATE `table` SET `FB` = '$ID' WHERE `ID` = '".$data["ID"]."';<br>";
		}
	}
}
?>