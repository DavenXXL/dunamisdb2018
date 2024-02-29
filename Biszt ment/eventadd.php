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
								die('Query hiba a eventadd.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
							}
							else{
								header('Location: eventshow.php?find='.urlencode($EVENTNAME));
							}
						}
					}
					else "<font color='red'><b>Nincs Eseménynév</b></font>";
				}
				?>
				<form method='POST' accept-charset='ISO-3166-2'>
					<input type='hidden' name='person' value=''>
					<br>Eseménynév:<br>
					<input style="width: 200px;" type='text' name='EVENTNAME' value=''>
					<br>Dátum:<br>
					<input style="width: 200px;" type='text' name='DATE' value=''>
					<br>Helyszín:<br>
					<input style="width: 200px;" type='text' name='PLACE' value=''>
					<br>Megjegyzés:<br>
					<textarea style="width: 400px; height: 120px;" name='INFO' value=''></textarea>
					<br>Beágyazott internetes tartalom:<br>
					<textarea style="width: 400px; height: 120px;" name='COMMENT'></textarea><br>
					<input type='submit' name="submit" value='Regisztráció!'>
				</form>
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
