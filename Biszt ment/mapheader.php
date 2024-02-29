<?php
$mapnum = "map".$_GET["num"];
header('Location: index.php?ID='.urlencode($mapnum));
?>