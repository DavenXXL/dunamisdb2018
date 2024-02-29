<?php
$host="localhost";
$user="web";
$db="Dunamis";
$pass="JC5p2svRsFUIrkL1";
if(!is_dir("letters/".$_POST["folder"])) mkdir("letters/".$_POST["folder"]);
$target_dir = "letters/".$_POST["folder"]."/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
       /*
	   $connect = mysqli_connect($host,$user,$pass,$db);
		if(!$connect){
  			die('Kapcsolódási hiba (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		}
		mysqli_query($connect, 'SET NAMES "utf8" collate "utf8_hungarian_ci"');
		$send = mysqli_query($connect,"SELECT * FROM `table` WHERE `ID` = '".$_POST["folder"]."' ");
		if(!$send){
        	die('Query hiba az uploadletter.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
   		}
		$row = mysqli_fetch_assoc($send);
		$COMMENT = $row["COMMENT"].'<br><a target="_blank" href="'.$target_file.'">'.$afilename.'</a><br>';
		$sql = "UPDATE `table` SET `COMMENT` = '".$COMMENT."' WHERE `ID` = '".$_POST["folder"]."' ";
		$data = mysqli_query($connect,$sql);
		if(!$data){
        	die('Query hiba az uploadletter.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
   		}
		else */header('Location: show.php?find='.urlencode($_POST["folder"]));
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
