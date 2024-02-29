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
				if(isset($_POST["submit"])){
					$host="localhost";
					$user="web";
					$db="Dunamis";
					$pass="JC5p2svRsFUIrkL1";
					$EVENTNAME = $_POST["EVENTNAME"];
					$DATE = $_POST["DATE"];
					$COMMENT = $_POST["COMMENT"];
					$INFO = $_POST["INFO"];
					$PLACE = $_POST["PLACE"];
					if(!empty($EVENTNAME)){
						$connect = mysqli_connect($host,$user,$pass,$db);
						if (!$connect) {
							die('Kapcsolódási hiba (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
						}
						else{
							mysqli_query($connect, 'SET NAMES "utf8" collate "utf8_hungarian_ci"');
							$send = mysqli_query($connect,"INSERT INTO `list_of_events`(`EVENTNAME`, `DATE`, `COMMENT`, `PLACE`, `INFO`) VALUES ('$EVENTNAME','$DATE','$COMMENT','$PLACE','$INFO')");
							$send2 = mysqli_query($connect,"CREATE TABLE `$EVENTNAME` (`ID` int(5) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;");
							if (!$send || !$send2) {
								die('Query hiba a eventadd-new.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
							}
							else{
								header('Location: eventshow-new.php?find='.urlencode($EVENTNAME));
							}
						}
					}
					else "<font color='red'><b>Nincs Eseménynév</b></font>";
				}
				?>
				<h3>Új esemény hozzáadása</h3>
				<form method='POST' accept-charset='ISO-3166-2'>
					<input type='hidden' name='person' value=''>
					<br><h6>Eseménynév:</h6>
					<input style="width: 250px; background-color: #bccae1;" type='text' name='EVENTNAME' value=''>
					<br><h6>Dátum:</h6>
					<input style="width: 250px; background-color: #bccae1;" type='text' name='DATE' value=''>
					<br><h6>Helyszín:</h6>
					<input style="width: 250px; background-color: #bccae1;" type='text' name='PLACE' value=''>
					<br><h6>Megjegyzés:</h6>
					<textarea style="width: 250px; height: 100px; background-color: #bccae1;" name='INFO' value=''></textarea>
					<br><h6>Beágyazott internetes tartalom:</h6>
					<textarea style="width: 500px; height: 180px; background-color: #bccae1;" name='COMMENT'></textarea><br>
					<input type='submit' name="submit" value='HOZZÁADÁS'>
				</form>
				
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
