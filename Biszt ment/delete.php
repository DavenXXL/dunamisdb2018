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
					die('Query hiba a delete.php eventdel 1. szekciójában (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
				}
				else{
					$send = mysqli_query($connect,"DROP TABLE `".$_POST["EVENTNAME"]."`");
					if (!$send) {
						die('Query hiba a delete.php eventdel 2. szekciójában (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
					}
					else{
						if(file_exists("letters/".$_POST["EVENTNAME"]."/") && !Delete("letters/".$_POST["EVENTNAME"]."/")) echo "<font color='red' size='4'>Nem sikerült eltávolítani az eseményhez kapcsolódó fájlokat</font><br><br>";
						else echo "<font color='green' size='4'>Az esemény törlése sikeresen megtörtént!</font><br><br>";
					}
				}
			}
			if(isset($_POST["persondel"])){
				$data = mysqli_query($connect,"SELECT EMAIL FROM `table` WHERE ID = '".$_POST["ID"]."'");
				if (!$data) {
					die('Query hiba a delete.php persondel 1. szekciójában (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
				}
				$row = mysqli_fetch_assoc($data);
				$send = mysqli_query($connect,"DELETE FROM `table` WHERE ID = '".$_POST["ID"]."'");
				if (!$send) {
					die('Query hiba a delete.php persondel 2.szekciójában (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
				}
				else{
					if(file_exists("letters/".$_POST["ID"]."/") && !Delete("letters/".$_POST["ID"]."/")) echo "<font color='red' size='4'>Nem sikerült eltávolítani az személyhez kapcsolódó fájlokat</font><br><br>";
					else echo "<font color='green' size='4'>A személy törlése sikeresen megtörtént!</font><br><br>";
				}
			}
			if(isset($_POST["filedel"])){
				if(!unlink($_POST["FILE"])) echo "<font color='red' size='4'>A fájl törlése sikertelen!</font><br><br>";
				else echo "<font color='green' size='4'>A fájl törlése sikeresen megtörtént!</font><br><br>";
			}
			?>
			<form method="POST">
				<h2>Esemény törlése:</h2>
				<input type="text" name="EVENTNAME" placeholder="Eseménynév"><br>
				<input type="submit" name="eventdel"><br><br>
				<h2>Személy törlése:</h2>
				<input type="text" name="ID" placeholder="ID"><br>
				<input type="submit" name="persondel">
				<br><br><h2>Fájl törlése</h2>
				<input style="width: 400px;" type="text" name="FILE" placeholder="Fájl útvonal"><br>
				<input type="submit" name="filedel">
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
