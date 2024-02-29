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
       header('Location: eventshow-new.php?find='.urlencode($_POST["folder"]));
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>