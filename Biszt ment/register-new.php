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
								die('Query hiba a register-new.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
							}
							else{
								header('Location: index-new.php?ID='.urlencode($EMAIL));
							}
						}
					}else echo "<font color='red' size='2'><b>Új személy hozzáadása csak akkor lehetséges ha a néven kívül legalább az E-mail címet vagy a Telefonszámot is megadod!</b></font>";
				}
				?>
				<h3>Új személy hozzáadása</h3>
				<form method='POST' accept-charset='ISO-3166-2'>
					<input type='hidden' name='person' value=''>
					<br><h6>Név:</h6>
					<input style="width: 250px; background-color: #bccae1;" type='text' name='NAME' value=''>
					<br><h6>Telefonszám:</h6>
					<input style="width: 250px; background-color: #bccae1;" type='text' name='PHONE' value=''>
					<br><h6>E-mail cím:</h6>
					<input style="width: 250px; background-color: #bccae1;" type='text' name='EMAIL' value=''>
					<br><h6>Ország:</h6>
					<input style="width: 250px; background-color: #bccae1;" type='text' name='COUNTRY' value=''>
					<br><h6>Város:</h6>
					<input style="width: 250px; background-color: #bccae1;" type='text' name='CITY' value=''>
					<br><h6>Megjegyzés:</h6>
					<textarea style="width: 250px; height: 100px; background-color: #bccae1;" name='INFO' value=''></textarea>
					<br><h6>Facebook:</h6>
					<input style="width: 500px; background-color: #bccae1;" type="text" placeholder="FB kép link" name="pic"><br>
					<input style="width: 500px; background-color: #bccae1;" type="text" placeholder="FB profil link" name="link"><br>
					<input style="width: 500px; background-color: #bccae1;" type="text" placeholder="Messenger link" name="mess"><br>
					<h6>Beágyazott internetes tartalom:</h6>
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