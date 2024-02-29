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
			function Delete($path)
{
    if (is_dir($path) === true)
    {
        $files = array_diff(scandir($path), array('.', '..'));

        foreach ($files as $file)
        {
            Delete(realpath($path) . '/' . $file);
        }

        return rmdir($path);
    }

    else if (is_file($path) === true)
    {
        return unlink($path);
    }

    return false;
}
			$host="localhost";
			$user="web";
			$db="Dunamis";
			$pass="JC5p2svRsFUIrkL1";
			$table = "table";
			$connect=mysqli_connect($host,$user,$pass,$db);
			mysqli_query($connect, 'SET NAMES "utf8" collate "utf8_hungarian_ci"');
			if (!$connect) {
				die('Kapcsolódási hiba (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
			}
			if(isset($_POST["eventdel"])){
				$send = mysqli_query($connect,"DELETE FROM `list_of_events` WHERE EVENTNAME = '".$_POST["EVENTNAME"]."'");
				if (!$send) {
					die('Query hiba a delete-new.php eventdel 1. szekciójában (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
				}
				else{
					$send = mysqli_query($connect,"DROP TABLE `".$_POST["EVENTNAME"]."`");
					if (!$send) {
						die('Query hiba a delete-new.php eventdel 2. szekciójában (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
					}
					else{
						if(file_exists("letters/".$_POST["EVENTNAME"]."/") && !Delete("letters/".$_POST["EVENTNAME"]."/")) echo "<font color='red'><h5>Nem sikerült eltávolítani az eseményhez kapcsolódó fájlokat!</h5></font><br><br>";
						else echo "<font color='green'><h5>Az esemény törlése sikeresen megtörtént!</h5></font><br><br>";
					}
				}
			}
			if(isset($_POST["persondel"])){
				$data = mysqli_query($connect,"SELECT EMAIL FROM `table` WHERE ID = '".$_POST["ID"]."'");
				if (!$data) {
					die('Query hiba a delete-new.php persondel 1. szekciójában (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
				}
				$row = mysqli_fetch_assoc($data);
				$send = mysqli_query($connect,"DELETE FROM `table` WHERE ID = '".$_POST["ID"]."'");
				if (!$send) {
					die('Query hiba a delete-new.php persondel 2.szekciójában (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
				}
				else{
					if(file_exists("letters/".$_POST["ID"]."/") && !Delete("letters/".$_POST["ID"]."/")) echo "<font color='red'><h5>Nem sikerült eltávolítani az személyhez kapcsolódó fájlokat</h5></font><br><br>";
					else echo "<font color='green'><h5>A személy törlése sikeresen megtörtént!</h5></font><br><br>";
				}
			}
			if(isset($_POST["filedel"])){
				if(!unlink($_POST["FILE"])) echo "<font color='red'><h5>A fájl törlése sikertelen!</h5></font><br><br>";
				else echo "<font color='green'><h5>A fájl törlése sikeresen megtörtént!</h5></font><br><br>";
			}
			?>
			<form method="POST">
				<h5>Esemény törlése:</h5>
				<input style="width: 200px; background-color: #bccae1;" type="text" name="EVENTNAME" placeholder="Eseménynév"><br>
				<input type="submit" name="eventdel" value="Törlöm az eseményt"><br><br>
				<h5>Személy törlése:</h5>
				<input style="width: 200px; background-color: #bccae1;" type="text" name="ID" placeholder="ID"><br>
				<input type="submit" name="persondel" value="Törlöm a személyt">
				<br><br><h5>Dokumentum törlése:</h5>
				<input style="width: 400px; background-color: #bccae1;" type="text" name="FILE" placeholder="Dokumentum fájl útvonala"><br>
				<input type="submit" name="filedel" value="Törlöm a dokumentumot">
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