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
					$NAME = $_POST["NAME"];
					$EMAIL = $_POST["EMAIL"];
					$PHONE = $_POST["PHONE"];
					$COUNTRY = $_POST["COUNTRY"];
					$CITY = $_POST["CITY"];
					$INFO = $_POST["INFO"];
					$COMMENT = $_POST["COMMENT"];
					$fbset = true;
					if((!empty($EMAIL) || !empty($PHONE)) && !empty($NAME)){
						if(empty($_POST["link"]) || empty($_POST["pic"]) || empty($_POST["mess"])) $fbset = false;
						else $FB = '<a target="_BALNK" href="'.$_POST["link"].'"><img style="max-width: 120px;" src="'.$_POST["pic"].'"></a><br><br><a href="'.$_POST["mess"].'" target="_BALNK">Messenger levelezés</a>';
						$connect = mysqli_connect($host,$user,$pass,$db);
						if (!$connect) {
							die('Kapcsolódási hiba (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
						}
						else{
							mysqli_query($connect, 'SET NAMES "utf8" collate "utf8_hungarian_ci"');
							if($fbset)$send = mysqli_query($connect,"INSERT INTO `table` (`NAME`, `EMAIL`, `PHONE`, `COUNTRY`, `CITY`, `INFO`, `COMMENT` , `FB`) VALUES ('$NAME', '$EMAIL', '$PHONE', '$COUNTRY', '$CITY', '$INFO', '$COMMENT', '$FB')");
							else $send = mysqli_query($connect,"INSERT INTO `table` (`NAME`, `EMAIL`, `PHONE`, `COUNTRY`, `CITY`, `INFO`, `COMMENT`) VALUES ('$NAME', '$EMAIL', '$PHONE', '$COUNTRY', '$CITY', '$INFO', '$COMMENT')");
							if (!$send) {
								die('Query hiba a register.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
							}
							else{
								header('Location: index.php?ID='.urlencode($EMAIL));
							}
						}
					}else echo "<font color='red' size='2'><b>Új személy hozzáadása csak akkor lehetséges ha a néven kívül legalább az E-mail címet vagy a Telefonszámot is megadod!</b></font>";
				}
				?>
				<form method='POST' accept-charset='ISO-3166-2'>
					<input type='hidden' name='person' value=''>
					<br>Név:<br>
					<input style="width: 200px;" type='text' name='NAME' value=''>
					<br>Telefonszám:<br>
					<input style="width: 200px;" type='text' name='PHONE' value=''>
					<br>E-mail cím:<br>
					<input style="width: 200px;" type='text' name='EMAIL' value=''>
					<br>Ország:<br>
					<input style="width: 200px;" type='text' name='COUNTRY' value=''>
					<br>Város:<br>
					<input style="width: 200px;" type='text' name='CITY' value=''>
					<br>Megjegyzés:<br>
					<textarea style="width: 400px; height: 120px;" name='INFO' value=''></textarea>
					<br>Facebook:<br>
					<input style="width: 400px;" type="text" placeholder="FB kép link" name="pic"><br>
					<input style="width: 400px;" type="text" placeholder="FB profil link" name="link"><br>
					<input style="width: 400px;" type="text" placeholder="Messenger link" name="mess"><br>
					<br>Beágyazott internetes tartalom:<br>
					<textarea style="width: 400px; height: 180px;" name='COMMENT'></textarea><br>
					<input type='submit' name="submit" value='Hozzáadás!'>
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
