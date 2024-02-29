<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Dünamisz</title>
</head>
<body>
    <div id="logo">
  		<a href="index.php?ID=$"><img src="dunamis.png"></a>
    </div>
<div id="page">
    <div id="pagetop">
	<font class="maintitle">Dünamisz Adatbázis</font>
        <div class="links">
            <ul>
           	   	<li>
				<form action="index.php" method="POST"  accept-charset="ISO-3166-2">
						<input placeholder="Keresés: Név, Telefonszám, E-mail cím, Ország, Város, Megjegyzés" style="width: 445px; height: 40px;border-radius: 10px" name="ID" type="text">
              	</form>
				</li>
            </ul>
        </div>
	</div>
    <div id="header"></div>
    <div id="main">
        <div class="content">
            <div class="main_body">
<?php
function is_dir_empty($dir) {
  if (!is_readable($dir)) return NULL;
  return (count(scandir($dir)) == 2);
}
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
    $send = mysqli_query($connect,"SELECT * FROM `list_of_events` WHERE EVENTNAME = '".$_GET["find"]."' ");
    if(!$send){
        die('Query hiba a eventshow.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
	else{
		$row = mysqli_fetch_assoc($send);
		if(mysqli_num_rows($send)>0){
			echo "<div id='find'><table class='hoverTable'><tr style='color:white;background: #061E5E'><td><h1 style='text-align: center'>".$row["EVENTNAME"]."</h1></td></tr>";
			echo "<tr><td><h3><b>Dátum:</b></h3><b>".$row["DATE"]."</b></td></tr>";
			echo "<tr><td><h3><b>Helyszín:</b></h3><b>".$row["PLACE"]."</b></td></tr>";
			echo "<tr><td><h3><b>Megjegyzés:</b></h3>";
			echo $row["INFO"]."</td></tr>";
			echo "<br><tr><td><h3><b>Beágyazott internetes tartalmak:</b></h3>";
			echo $row["COMMENT"]."</td></tr>";
			echo "</div></table><br><br>";
			$send = mysqli_query($connect,"SELECT * FROM `".$_GET["find"]."`");
			echo "<h3><b>Kapcsolódó személyek:</b></h3>";
			$numcontacts = mysqli_num_rows($send);
			if($numcontacts > 0){
				echo "<b>Találatok száma: ".$numcontacts."</b><br><br>";
				echo "<table class='hoverTable'><tr style='color:white;background: #061E5E'><td><b>Név</b></td><td><b>E-mail cím</b></td><td><b>Telefonszám</b></td></tr>";
				if($send != false) while ($rowa = mysqli_fetch_assoc($send)){
					$sourceofrowb = mysqli_query($connect,"SELECT * FROM `table` WHERE ID = '".$rowa["ID"]."' ");
					$rowb = mysqli_fetch_assoc($sourceofrowb);
					echo '<tr><td><a href="show.php?find=', urlencode($rowb["ID"]), '">'.$rowb["NAME"].'</a>';
					echo "<td>".$rowb["EMAIL"]."</td>";
					echo "<td>".$rowb["PHONE"]."</td></tr>";
				}
				echo "</table><br><br>";
			}
			echo "<br><h3><b>Kapcsolódó dukumentumok:</b></h3>";
			if (file_exists('letters/'.$row["EVENTNAME"].'/') && !is_dir_empty('letters/'.$row["EVENTNAME"].'/')){
				if ($handle = opendir('letters/'.$row["EVENTNAME"].'/')) {
				echo "<table class='hoverTable'><tr style='color:white;background: #061E5E'><td><b>Fájlnév</b></td></tr>";
					while (false !== ($entry = readdir($handle))) {
						if ($entry != "." && $entry != "..") {
							echo "<tr><td><a target='_blank' href='letters/".$row["EVENTNAME"]."/".$entry."'>".$entry."</td></tr>";
						}
					}
					closedir($handle);
					echo "</table>";
				}
			}
			echo "Kapcsolódó dokumentum (html, txt, pdf, jpg, png, gif) feltöltése<br>";
			echo "<center><form method='POST' action='eventletterupload.php' enctype='multipart/form-data'>";
			echo "<input type='hidden' name='folder' value='".$row["EVENTNAME"]."'>";
			echo "<input type='file' name='file'>";
			echo "<input type='submit' value='Fájl feltöltés' name='submit'>";
			echo "</form><br><br><form method='POST' action='eventedit.php'><input type='hidden' name='EVENTNAME' value='".$_GET["find"]."'><input type='submit' name='submit' value='Szerkesztés'></form></center>";
		}else echo "<b><font color='#001559'>Nincs találat ilyen eventre! </font></b>";
	}
}
?>
            </div>
        </div>
        <div class="clear">&nbsp;</div>
		</div>
		<div id="footer">
			<p>
				Copyright © Szabó Dávid Barnabás
			</p>
		</div>
	</div>
</body>
</html>
