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
		
		<!-- <div class="col_w100p">
		<form action="index-new.php" method="POST"  accept-charset="ISO-3166-2"><input placeholder="Keresés: Név, Telefonszám, E-mail cím, Ország, Város, Megjegyzés" style="width: 445px; height: 40px; border-radius: 10px; background-color: #fee481;" name="ID" type="text"></form>
		</div> -->
		
		<div><TABLE cellSpacing=0 cellPadding=0 align=center border=0><TR><TD style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent">
		
			<div class="content_box">
			
				<div class="col_w900">
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
        die('Query hiba a eventedit-new.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
	else{
		$row = mysqli_fetch_assoc($send);
		if(mysqli_num_rows($send)>0){
			echo "<form action='eventupdate-new.php' method='POST'><h2><b>".$row["EVENTNAME"]."</b></h2>";
			echo "<input type='hidden' name='EVENTNAME' value='".$_POST["EVENTNAME"]."'>";
			echo "<br><h3>Esemény adatlapjának szerkesztése</h3>";
			echo "<br><h6>Dátum:</h6>";
			echo "<input style='width: 250px; background-color: #bccae1;' type='text' name='DATE' value='".$row["DATE"]."'><br>";
			echo "<br><h6>Helyszín:</h6>";
			echo "<input style='width: 250px; background-color: #bccae1;' type='text' name='PLACE' value='".$row["PLACE"]."'><br>";
			echo "<br><h6>Megjegyzés:</h6>";
			echo "<textarea style='width: 250px; height: 100px; background-color: #bccae1;' name='INFO'>".$row["INFO"]."</textarea><br>";
			echo "<br><h6>Beágyazott internetes tartalmak:</h6>";
			echo "<textarea style='width: 500px; height: 250px; background-color: #bccae1;' name='COMMENT'>".$row["COMMENT"]."</textarea>";
			$send = mysqli_query($connect,"SELECT * FROM `".$_POST["EVENTNAME"]."`");
			echo "<br><br><h6>Kapcsolódó személyek törlése:</h6>";
			echo "<center><table WIDTH=680; class='hoverTable'><tr><td style='color:white;background: #061E5E'><b>Törlés</b></td><td style='color:white;background: #061E5E'><b>Név</b></td><td style='color:white;background: #061E5E'><b>E-mail cím</b></td><td style='color:white; background: #061E5E'><b>Telefonszám</b></td></tr>";
			if($send != false) while ($rowb = mysqli_fetch_assoc($send)) {
				$data = mysqli_query($connect,"SELECT * FROM `table` WHERE ID = '".$rowb["ID"]."'");
				if($data != false) $rowa = mysqli_fetch_assoc($data);
				echo '<tr><td><input type="checkbox" name="DPERSON[]" value="'.$rowa["ID"].'"></td><td><a href="show-new.php?find=', urlencode($rowa["EMAIL"]), '">'.$rowa["NAME"].'</a>';
				echo "<td>".$rowa["EMAIL"]."</td><td>".$rowa["PHONE"]."</td></tr>";
			}
			echo "</table></center><input type='submit' name='submit' value='Mehet!'></form>";
		}else echo "<b>Nincs találat ilyen eseményre!</b>";
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
