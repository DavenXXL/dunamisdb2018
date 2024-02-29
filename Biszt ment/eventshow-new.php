<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Dünamisz Adatbázis</title>
<link href="css/tooplate_style.css" rel="stylesheet" type="text/css" />

</head>
<body>

<div id="tooplate_wrapper"><div id="top"></div>

	<div id="templatmeo_header">
    	        
		<div id="site_title"><h1><a href="index-new.php">Dünamisz Adatbázis</a></h1></div>
		
		<div id="tooplate_menu">
            <ul>
					<li><a href="index-new.php">Home</a></li>
					<li><a href="index-new.php?ID=events">Események</a></li>
					<li><a href="eventadd-new.php">Új esemény</a></li>					
					<li><a href="index-new.php?ID=persons">Személyek</a></li>
					<li><a href="register-new.php">Új személy</a></li>
					<li class="last"><a href="delete-new.php">Törlés</a></li>  						
            </ul>    	
      </div> <!-- end of tooplate_menu -->
            
   </div>
   
   <div id="tooplate_main">
		
		<div class="col_w100p">
		<form action="index-new.php" method="POST"  accept-charset="ISO-3166-2"><input placeholder="Keresés: Név, Telefonszám, E-mail cím, Ország, Város, Megjegyzés" style="width: 445px; height: 40px; border-radius: 10px; background-color: #fee481;" name="ID" type="text"></form>
		</div>
		
		<div><TABLE cellSpacing=0 cellPadding=0 align=center border=0><TR><TD style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent">
		
			<div class="content_box">
			
				<div class="col_w900">
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
        die('Query hiba a eventshow-new.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
	else{
		$row = mysqli_fetch_assoc($send);
		if(mysqli_num_rows($send)>0){
			echo "<h2><b>Esemény adatlapja</b></h2><br><br>";
			echo "<center><table class='hoverTable'>";
			echo "<tr><td style='color: white; background: #061E5E'>Eseménynév:</td><td style='color: #902237; font-size: 20px; font-weight: bold'>".$row["EVENTNAME"]."</td></tr>";
			echo "<tr><td style='color: white; background: #061E5E'>Dátum:</td><td>".$row["DATE"]."</td></tr>";
			echo "<tr><td style='color: white; background: #061E5E'>Helyszín:</td><td>".$row["PLACE"]."</td></tr>";
			echo "<tr><td style='color: white; background: #061E5E'>Megjegyzés:</td><td style='color: #902237; font-size: 18px; font-weight: bold'>".$row["INFO"]."</td></tr>";
			echo "</table></center><br>";
			// Beágyazott internetes tartalmak
			echo $row["COMMENT"];			
			// Kapcsolódó személyek
			$send = mysqli_query($connect,"SELECT * FROM `".$_GET["find"]."`");
			echo "<br><br><h5><b>Kapcsolódó személyek:</b></h5>";
			$numcontacts = mysqli_num_rows($send);
			if($numcontacts > 0){
				echo "<b>Találatok száma: ".$numcontacts."</b><br>";
				echo "<center><table WIDTH=680; class='hoverTable'><tr><td style='color:white; background: #061E5E'>Név</td><td style='color:white; background: #061E5E'>E-mail cím</td><td style='color:white; background: #061E5E'>Telefonszám</td></tr>";
				if($send != false) while ($rowa = mysqli_fetch_assoc($send)){
					$sourceofrowb = mysqli_query($connect,"SELECT * FROM `table` WHERE ID = '".$rowa["ID"]."' ");
					$rowb = mysqli_fetch_assoc($sourceofrowb);
					echo '<tr><td><a href="show-new.php?find=', urlencode($rowb["ID"]), '">'.$rowb["NAME"].'</a>';
					echo "<td>".$rowb["EMAIL"]."</td>";
					echo "<td>".$rowb["PHONE"]."</td></tr>";
				}
				echo "</table></center>";
			}
			// Kapcsolódó dokumentumok
			echo "<br><h5><b>Kapcsolódó dokumentumok:</b></h5>";
			if (file_exists('letters/'.$row["EVENTNAME"].'/') && !is_dir_empty('letters/'.$row["EVENTNAME"].'/')){
				if ($handle = opendir('letters/'.$row["EVENTNAME"].'/')) {
				echo "<center><table class='hoverTable'><tr><td style='color:white; background: #061E5E'>Dokumentum fájlneve</td></tr>";
					while (false !== ($entry = readdir($handle))) {
						if ($entry != "." && $entry != "..") {
							echo "<tr><td><a target='_blank' href='letters/".$row["EVENTNAME"]."/".$entry."'>".$entry."</td></tr>";
						}
					}
					closedir($handle);
					echo "</table></center><br>";
				}
			}
			echo "Kapcsolódó dokumentum (html, txt, pdf, jpg, png, gif) feltöltése<br>";
			echo "<center><form method='POST' action='eventletterupload-new.php' enctype='multipart/form-data'>";
			echo "<input type='hidden' name='folder' value='".$row["EVENTNAME"]."'>";
			echo "<input type='file' name='file'>";
			echo "<input type='submit' value='Fájl feltöltés' name='submit'>";
			echo "</form><br><br><form method='POST' action='eventedit-new.php'><input type='hidden' name='EVENTNAME' value='".$_GET["find"]."'><input type='submit' name='submit' value='Szerkesztés'></form></center>";
		}else echo "<b><font color='#001559'>Nincs találat ilyen eventre! </font></b>";
	}
}
?>
						<a class="gototop" href="#top"></a>
				
					<div class="cleaner"></div>
				
				</div> 
				
			</div><!-- end of a content box -->
			
		</TD></TR></TABLE></div>
	</div> <!-- end of main --> 
	<div id="tooplate_footer"><h6><font color="#486CA4">Copyright © 2017 Szabó Dávid Barnabás</font></h6><BR><BR>
   </div> <!-- end of tooplate_footer -->

</div> <!-- end of wrapper -->
</body>
</html>