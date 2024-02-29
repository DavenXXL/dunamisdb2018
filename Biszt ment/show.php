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
    $send = mysqli_query($connect,"SELECT * FROM `table` WHERE `ID` = '".$_GET["find"]."' ");
    if(!$send){
        die('Query hiba a show.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
	  else{
			if (mysqli_num_rows($send) > 0){
				//ADATLAP
        $row = mysqli_fetch_assoc($send);
				echo "<h3><b>Adatlap:</b></h3>";
				echo "<table class='hoverTable'>";
				echo "<tr><td style='color:white;background: #061E5E'>Név:</td><td>".$row["NAME"]."</td></tr>";
				echo "<tr><td style='color:white;background: #061E5E'>Telefonszám:</td><td>".$row["PHONE"]."</td></tr>";
				echo "<tr><td style='color:white;background: #061E5E'>E-mail cím:</td><td>".$row["EMAIL"]."</td></tr>";
				echo "<tr><td style='color:white;background: #061E5E'>Ország:</td><td>".$row["COUNTRY"]."</td></tr>";
				echo "<tr><td style='color:white;background: #061E5E'>Város:</td><td>".$row["CITY"]."</td></tr>";
				echo "<tr><td style='color:white;background: #061E5E'>Megjegyzés:</td><td>".$row["INFO"]."</td></tr>";
				echo "<tr><td style='color:white;background: #061E5E'>Facebook:</td><td>".$row["FB"]."</td></tr></table>";
				//ESEMÉNYEK
				echo "<br><br><h3><b>Kapcsolódó események:</b></h3>";
				$eventlist = mysqli_query($connect,"SELECT * FROM `list_of_events`");
				if(!$eventlist){
					die('Query hiba a list_of_events szekcióban(' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
				}
				else{
					$x = 0;
					while($events = mysqli_fetch_assoc($eventlist)){
						$actual = mysqli_query($connect,"SELECT * FROM `".$events["EVENTNAME"]."` WHERE ID = '".$row["ID"]."'");
         				if (!$actual){
                			die('Query hiba a list_of_events szekcióban(' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
            			}
						else if(mysqli_num_rows($actual)>0){
							$eventdimension[$x][0] = '<tr><td><a href="eventshow.php?find='.urlencode($events["EVENTNAME"]).'">'.$events["EVENTNAME"].'</a></td>';
							$eventdimension[$x][1] = "<td>".$events["DATE"]."</td>";
							$eventdimension[$x][2] = "<td>".$events["PLACE"]."</td></tr>";
							$x = $x + 1;
						}
					}
					if($x>0){
						echo "<table class='hoverTable'><tr style='color:white;background: #061E5E'><td><b>Eseménynév</b></td><td><b>Dátum</b></td><td><b>Helyszín</b></td></tr>";
						foreach($eventdimension as $key => $value){
							echo $value[0];
							echo $value[1];
							echo $value[2];
						}
						echo "</table>";
					}
				}
				echo "Hozzáadás eseményhez:";
				$data = mysqli_query($connect,"SELECT * FROM `list_of_events`");
				echo '<form method="POST" action="addtoevent.php"><input type="hidden" name="person" value="'.$row["ID"].'">';
				echo "<select name='EVENTNAME'>";
				while ($rowa = mysqli_fetch_assoc($data)){
					echo "<option value='".$rowa["EVENTNAME"]."'>".$rowa["EVENTNAME"]."</option>";
				}
				echo "</select>";
				echo "<input type='submit' value='Add hozzá!'></form><br>";
				//FÁJLOK
				echo "<br><h3><b>Kapcsolódó dukumentumok:</b></h3>";
				if (file_exists('letters/'.$row["ID"].'/') && !is_dir_empty('letters/'.$row["ID"].'/')){
					if ($handle = opendir('letters/'.$row["ID"].'/')) {
					echo "<table class='hoverTable'><tr style='color:white;background: #061E5E'><td><b>Fájlnév</b></td></tr>";
						while (false !== ($entry = readdir($handle))) {
							if ($entry != "." && $entry != "..") {
								echo "<tr><td><a target='_blank' href='letters/".$row["ID"]."/".$entry."'>".$entry."</td></tr>";
							}
						}
						closedir($handle);
						echo "</table>";
					}
				}
				echo "Kapcsolódó dokumentum (html, txt, pdf, jpg, png, gif) feltöltése<br>";
				echo "<form method='POST' action='uploadletter.php' enctype='multipart/form-data'>";
				echo "<input type='hidden' name='folder' value='".$row["ID"]."'>";
				echo "<input type='file' name='file'>";
				echo "<input type='submit' value='Fájl feltöltés' name='submit'>";
				echo "</form>";
				echo "<br><br>";
				echo $row["COMMENT"];
				echo '<br><br><form method="POST" action="edit.php"><input type="hidden" name="person" value="'.$row["ID"].'"><input type="submit" value="Szerkesztés"></form>';
			}else echo "<b><font color='#001559'>Nincs találat ilyen E-mail címre! </font></b>";
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
