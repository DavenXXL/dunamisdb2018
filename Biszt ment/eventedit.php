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
    $send = mysqli_query($connect,"SELECT * FROM `list_of_events` WHERE EVENTNAME = '".$_POST["EVENTNAME"]."' ");
    if(!$send){
        die('Query hiba a eventedit.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
	else{
		$row = mysqli_fetch_assoc($send);
		if(mysqli_num_rows($send)>0){
			echo "<form action='eventupdate.php' method='POST'><h1>".$row["EVENTNAME"]."</h1><h3>";
			echo "<input type='hidden' name='EVENTNAME' value='".$_POST["EVENTNAME"]."'>";
			echo "<br>Dátum:<br>";
			echo "<input type='text' name='DATE' value='".$row["DATE"]."'><br>";
			echo "<br>Helyszín:<br>";
			echo "<input type='text' name='PLACE' value='".$row["PLACE"]."'><br>";
			echo "<br>Megjegyzés:</h3>";
			echo "<textarea style='width: 457px; height: 115px;' name='INFO'>".$row["INFO"]."</textarea><br>";
			echo "<h3><br>Beágyazott internetes tartalmak:</h3>";
			echo "<textarea style='width: 457px; height: 115px;' name='COMMENT'>".$row["COMMENT"]."</textarea>";
			$send = mysqli_query($connect,"SELECT * FROM `".$_POST["EVENTNAME"]."`");
			echo "<table class='hoverTable'><tr style='color:white;background: #061E5E'><td><b>Törlés</b></td><td><b>Név</b></td><td>E-mail cím</td></tr>";
			if($send != false) while ($rowb = mysqli_fetch_assoc($send)) {
				$data = mysqli_query($connect,"SELECT * FROM `table` WHERE ID = '".$rowb["ID"]."'");
				if($data != false) $rowa = mysqli_fetch_assoc($data);
				echo '<tr><td><input type="checkbox" name="DPERSON[]" value="'.$rowa["ID"].'"></td><td><a href="show.php?find=', urlencode($rowa["EMAIL"]), '">'.$rowa["NAME"].'</a>';
				echo "<td>".$rowa["EMAIL"]."</td></tr>";
			}
			echo "</table><input type='submit' name='submit' value='Mehet!'></form>";
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
