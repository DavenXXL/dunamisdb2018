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
		<form action="index-new.php" method="POST"  accept-charset="ISO-3166-2"><input placeholder="Keresés: Név, Telefonszám, E-mail cím, Ország, Város, Megjegyzés" style="width: 445px; height: 40px; border-radius: 10px; background-color: #f5adad;" name="ID" type="text"></form>
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
    $send = mysqli_query($connect,"SELECT * FROM `table` WHERE `ID` = '".$_GET["find"]."' ");
    if(!$send){
        die('Query hiba a show-new.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
	  else{
			if (mysqli_num_rows($send) > 0){
				//ADATLAP
        $row = mysqli_fetch_assoc($send);
				echo "<h2><b>Személy adatlapja</b></h2><br><br>";
				echo "<center><table class='hoverTable'>";
				echo "<tr><td style='color:white;background: #061E5E'>Név:</td><td style='color: #902237; font-size: 20px; font-weight: bold'>".$row["NAME"]."</td></tr>";
				echo "<tr><td style='color:white;background: #061E5E'>Telefonszám:</td><td>".$row["PHONE"]."</td></tr>";
				echo "<tr><td style='color:white;background: #061E5E'>E-mail cím:</td><td>".$row["EMAIL"]."</td></tr>";
				echo "<tr><td style='color:white;background: #061E5E'>Ország:</td><td>".$row["COUNTRY"]."</td></tr>";
				echo "<tr><td style='color:white;background: #061E5E'>Város:</td><td>".$row["CITY"]."</td></tr>";
				echo "<tr><td style='color:white;background: #061E5E'>Megjegyzés:</td><td style='color: #902237; font-size: 16px; font-weight: bold'>".$row["INFO"]."</td></tr>";
				echo "<tr><td style='color:white;background: #061E5E'>Facebook:</td><td>".$row["FB"]."</td></tr></table></center>";
				//ESEMÉNYEK
				echo "<br><br><h5><b>Kapcsolódó események:</b></h5>";
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
							$eventdimension[$x][0] = '<tr><td><a href="eventshow-new.php?find='.urlencode($events["EVENTNAME"]).'">'.$events["EVENTNAME"].'</a></td>';
							$eventdimension[$x][1] = "<td>".$events["DATE"]."</td>";
							$eventdimension[$x][2] = "<td>".$events["PLACE"]."</td></tr>";
							$x = $x + 1;
						}
					}
					if($x>0){
						echo "<center><table class='hoverTable'><tr><td style='color:white; background: #061E5E'>Eseménynév</td><td style='color:white; background: #061E5E'>Dátum</td><td style='color:white; background: #061E5E'>Helyszín</td></tr>";
						foreach($eventdimension as $key => $value){
							echo $value[0];
							echo $value[1];
							echo $value[2];
						}
						echo "</table></center><br>";
					}
				}
				echo "Hozzáadás eseményhez:";
				$data = mysqli_query($connect,"SELECT * FROM `list_of_events`");
				echo '<form method="POST" action="addtoevent-new.php"><input type="hidden" name="person" value="'.$row["ID"].'">';
				echo "<select name='EVENTNAME'>";
				while ($rowa = mysqli_fetch_assoc($data)){
					echo "<option value='".$rowa["EVENTNAME"]."'>".$rowa["EVENTNAME"]."</option>";
				}
				echo "</select>";
				echo "<input type='submit' value='Add hozzá!'></form><br>";
				//FÁJLOK
				echo "<br><h5><b>Kapcsolódó dokumentumok:</b></h5>";
				if (file_exists('letters/'.$row["ID"].'/') && !is_dir_empty('letters/'.$row["ID"].'/')){
					if ($handle = opendir('letters/'.$row["ID"].'/')) {
					echo "<center><table class='hoverTable'><tr><td style='color:white;background: #061E5E'>Dokumentum fájlneve</td></tr>";
						while (false !== ($entry = readdir($handle))) {
							if ($entry != "." && $entry != "..") {
								echo "<tr><td><a target='_blank' href='letters/".$row["ID"]."/".$entry."'>".$entry."</td></tr>";
							}
						}
						closedir($handle);
						echo "</table></center><br>";
					}
				}
				echo "Kapcsolódó dokumentum (html, txt, pdf, jpg, png, gif) feltöltése:";
				echo "<form method='POST' action='uploadletter-new.php' enctype='multipart/form-data'>";
				echo "<input type='hidden' name='folder' value='".$row["ID"]."'>";
				echo "<input type='file' name='file'>";
				echo "<input type='submit' value='Fájl feltöltés' name='submit'>";
				echo "</form>";
				echo "<br><br>";
				echo $row["COMMENT"];
				echo '<form method="POST" action="edit-new.php"><input type="hidden" name="person" value="'.$row["ID"].'"><input type="submit" value="Szerkesztés"></form>';
			}else echo "<b>Nincs találat ilyen E-mail címre!</b>";
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