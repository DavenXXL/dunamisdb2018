<?php
$mapnum = "map".$_GET["num"];
header('Location: index-new.php?ID='.urlencode($mapnum));
?>