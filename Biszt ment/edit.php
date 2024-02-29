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
    $send = mysqli_query($connect,"SELECT * FROM `table` WHERE `ID` = '".$_POST["person"]."' ");
    if(!$send){
        die('Query hiba a edit.php-ban (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
	else{
   	$row = mysqli_fetch_assoc($send);
		echo "<form method='POST' accept-charset='ISO-3166-2' action='sendedit.php'><input type='hidden' name='person' value='".$row["ID"]."'>";
		echo "<br>Név:<br>";
        echo "<input style='width: 200px;' type='text' name='NAME' value='".$row["NAME"]."'>";
        echo "<br>Telefonszám:<br>";
        echo "<input style='width: 200px;' type='text' name='PHONE' value='".$row["PHONE"]."'>";
        echo "<br>E-mail cím:<br>";
        echo "<input style='width: 200px;' type='text' name='EMAIL' value='".$row["EMAIL"]."'>";
     	echo "<br>Ország:<br>";
       	echo "<input style='width: 200px;' type='text' name='COUNTRY' value='".$row["COUNTRY"]."'>";
       	echo "<br>Város:<br>";
        echo "<input style='width: 200px;' type='text' name='CITY' value='".$row["CITY"]."'>";
		echo "<br>Megjegyzés:<br>";
        echo "<textarea style='width: 400px; height: 120px;' name='INFO' >".$row["INFO"]."</textarea>";
		echo "<br>Facebook:<br>";
        echo '<input style="width: 400px; " type="text" placeholder="FB kép link" name="pic"><br>';
		echo '<input style="width: 400px; "type="text" placeholder="FB profil link" name="link"><br>';
		echo '<input style="width: 400px; "type="text" placeholder="Messenger link" name="mess"><br>';
        echo "<br>Beágyazott internetes tartalmak:<br>";
        echo "<textarea style='width: 400px; height: 180px;' name='COMMENT'>".$row["COMMENT"]."</textarea><br>";
		echo "<input type='submit' value='Mehet!'></form>";
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
