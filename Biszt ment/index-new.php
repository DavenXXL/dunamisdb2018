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
		
		<div class="col_w100p"><form action="index-new.php" method="POST"  accept-charset="ISO-3166-2"><input placeholder="Keresés: Név, Telefonszám, E-mail cím, Ország, Város, Megjegyzés" style="width: 445px; height: 40px; border-radius: 10px; background-color: #bccae1;" name="ID" type="text"></form></div>
		
		<div><TABLE cellSpacing=0 cellPadding=0 align=center border=0><TR><TD style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent">
		
			<div class="content_box">
			
				<div class="col_w900"><?php
function regioprint($connect,$mapid){
	$send = mysqli_query($connect,"SELECT * FROM `map".$mapid."`");
	if(!$send){
		die("Hiba a REGIOPRINT -ben!");
	}
	else{
		$x = 0;
		while($record = mysqli_fetch_assoc($send)){
			$data = mysqli_query($connect,"SELECT * FROM `table` WHERE CITY = '".$record["CITY"]."'");
			while($row = mysqli_fetch_assoc($data)){
				$records[$x][0] = "<a href='show-new.php?find=".urlencode($row["ID"])."'>".$row["NAME"]."</a>";
				$records[$x][1] = $row["EMAIL"];
				$records[$x][2] = $row["PHONE"];
				$records[$x][3] = $row["COUNTRY"];
				$records[$x][4] = $row["CITY"];
        $records[$x][5] = $row["ID"];
				$save[$x][0] = $row["EMAIL"];
        $namepart = explode(" ",$row["NAME"]);
        if(strpos($namepart[count($namepart)-1], "né") !== false) $save[$x][1] = $row["NAME"];
        else $save[$x][1] = $namepart[count($namepart)-1];
				$x = $x + 1;
			}
		}
		$mapname[1] = "Nyugat-Dunántúl";
		$mapname[2] = "Közép-Dunántúl";
		$mapname[3] = "Dél-Dunántúl";
		$mapname[4] = "Közép-Magyarország";
		$mapname[5] = "Észak-Magyarország";
		$mapname[6] = "Észak-Alföld";
		$mapname[7] = "Dél-Alföld";
		echo "<h1>".$mapname[$mapid]."</h1><br>";
		echo "<br><b>Találatok száma: ".$x."</b><br>";
		echo "<center><table WIDTH='87%' class='hoverTable'><tr><td style='color:white; background: #061E5E'><b>Név</b></td><td style='color:white; background: #061E5E'><b>E-mail cím</b></td><td style='color:white; background: #061E5E'><b>Telefonszám</b></td><td style='color:white; background: #061E5E'><b>Ország</b></td><td style='color:white; background: #061E5E'><b>Város</b></td><td style='color:white; background: #061E5E'><b>JMK</b></td></tr>";
		foreach($records as $key => $value){
			$JMK = mysqli_query($connect,"SELECT * FROM `JMK` WHERE ID = '".$value[5]."'");
			echo "<tr><td>".$value[0]."</td>";
			echo "<td>".$value[1]."</td>";
			echo "<td>".$value[2]."</td>";
			echo "<td>".$value[3]."</td>";
			echo "<td>".$value[4]."</td>";
			if(mysqli_num_rows($JMK)>0) echo "<td><img src='pipa.png'></td></tr>";
			else echo "<td><img src='x.png'></td></tr>";
		}
		echo "</table></center>";
		savetofile($save);
		echo "<form action='tmp/save.csv'><input type='submit' value='Letöltés'></form>";
	}
}
function savetofile($save){
	$file = fopen("tmp/save.csv", "w");
	foreach($save as $key => $value){
    if($value[0] != NULL){
      $row = iconv("UTF-8","ISO-8859-2",$value[0]).";".iconv("UTF-8","ISO-8859-2",$value[1]).";\n";
	    fwrite($file,$row);
    }
	}
}
function printlist($connect,$send){
	$x = 0;
	while ($row = mysqli_fetch_assoc($send)){
		$records[$x][0] = "<a href='show-new.php?find=".urlencode($row["ID"])."'>".$row["NAME"]."</a>";
		$records[$x][1] = $row["EMAIL"];
		$records[$x][2] = $row["PHONE"];
		$records[$x][3] = $row["COUNTRY"];
		$records[$x][4] = $row["CITY"];
    $records[$x][5] = $row["ID"];
    $save[$x][0] = $row["EMAIL"];
    $namepart = explode(" ",$row["NAME"]);
    if(strpos($namepart[count($namepart)-1], "né") !== false) $save[$x][1] = $row["NAME"];
    else $save[$x][1] = $namepart[count($namepart)-1];
		$x = $x + 1;
	}
	if(mysqli_num_rows($send)>0){
		savetofile($save);
		echo "<h2><b>SZEMÉLYEK</b></h2><br>";
		echo "<b>Találatok száma: ".$x."</b><br>";
		echo "<center><table WIDTH='87%' class='hoverTable'><tr><td style='color:white; background: #061E5E'><b>Név</b></td><td style='color:white; background: #061E5E'><b>E-mail cím</b></td><td style='color:white; background: #061E5E'><b>Telefonszám</b></td><td style='color:white; background: #061E5E'><b>Ország</b></td><td style='color:white; background: #061E5E'><b>Város</b></td><td style='color:white; background: #061E5E'><b>JMK</b></td></tr>";
		foreach($records as $key => $value){
			$JMK = mysqli_query($connect,"SELECT * FROM `JMK` WHERE ID = '".$value[5]."'");
			echo "<tr><td>".$value[0]."</td>";
			echo "<td>".$value[1]."</td>";
			echo "<td>".$value[2]."</td>";
			echo "<td>".$value[3]."</td>";
			echo "<td>".$value[4]."</td>";
			if(mysqli_num_rows($JMK)>0) echo "<td><img src='pipa.png'></td></tr>";
			else echo "<td><img src='x.png'></td></tr>";
		}
		echo "</table></center>";
	}
	return mysqli_num_rows($send);
}
if(!empty($_POST["ID"]))$FIND = trim($_POST["ID"]);
elseif(!empty($_GET["ID"])) $FIND = trim($_GET["ID"]);
else $FIND = "$";
$showdownload = true;
$host="localhost";
$user="web";
$db="Dunamis";
$pass="JC5p2svRsFUIrkL1";
$connect = mysqli_connect($host,$user,$pass,$db);
if(!$connect){
    die('Kapcsolódási hiba (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}
else mysqli_query($connect, 'SET NAMES "utf8" collate "utf8_hungarian_ci"');
if($FIND == "$"){
	$events = false;
	echo "<h2><b>MAGYARORSZÁG RÉGIÓI</b></h2><br><br>";
	echo '<img alt="Magyarország régiói" src="regiok.png" style="width: 890px; height: 547px; display: block; margin-left: auto; margin-right: auto" usemap="#Map" border="0">
	<map id="Map" name="Map">
	<area coords="253,165,233,161,208,146,191,131,174,112,152,113,147,129,141,137,142,164,125,171,115,168,104,173,95,164,82,161,74,169,63,172,75,185,93,187,94,204,89,218,80,219,63,224,63,244,62,263,71,276,67,288,62,300,38,302,18,327,38,326,41,339,40,349,46,363,51,375,66,390,74,404,91,409,94,425,111,425,115,433,129,432,137,427,133,414,147,414,155,399,156,388,161,368,161,354,182,351,174,338,174,325,166,320,158,319,161,311,157,306,148,305,143,290,157,287,159,276,160,257,160,247,169,239,153,222,173,222,186,214,188,221,205,217,223,217,232,217,232,227,226,235,230,245,234,252,237,242,246,234,248,221,253,201,250,185" href="index-new.php?ID=*map1" shape="poly">
	<area coords="381,170,372,151,347,160,327,160,303,163,264,162,256,166,253,211,248,236,234,253,222,234,225,219,203,222,190,222,177,222,160,223,172,237,164,260,162,272,160,290,150,292,152,301,162,304,164,315,174,321,175,329,181,339,183,349,195,349,226,338,248,330,259,319,267,312,277,312,287,318,290,330,287,337,289,347,299,340,310,348,317,345,324,353,331,348,336,351,344,359,350,362,356,351,370,344,375,332,382,327,384,318,386,305,382,295,376,286,372,269,378,261,372,253,368,242,360,230,363,224,356,212,351,201,357,187,357,179,369,175" href="index-new.php?ID=*map2" shape="poly">
	<area coords="316,542,347,518,363,513,368,492,358,489,369,462,370,447,374,436,375,417,377,403,375,387,376,375,389,361,383,346,373,346,360,351,356,364,347,370,341,361,330,355,318,355,307,352,295,350,283,350,285,328,281,318,272,317,265,318,257,330,243,334,225,343,207,349,189,354,173,354,165,357,162,369,162,385,162,398,158,407,152,415,141,418,141,428,135,438,125,438,116,439,147,461,156,473,162,487,169,498,179,502,201,502,203,510,214,519,227,526,239,535" href="index-new.php?ID=*map3" shape="poly">
	<area coords="533,301,526,279,529,266,520,259,520,247,514,236,498,220,490,207,482,205,475,193,471,185,470,171,461,167,454,172,447,172,447,160,441,153,420,149,406,146,395,138,386,122,391,113,382,105,369,110,359,120,360,136,371,146,380,157,382,177,377,183,362,185,359,201,357,207,363,218,363,228,369,239,374,245,378,256,381,266,378,280,384,288,396,297,410,292,423,283,433,284,433,291,431,301,443,297,453,296,452,287,458,284,469,284,472,294,478,302,485,304,490,309,501,315,503,305,510,308,520,310" href="index-new.php?ID=*map4" shape="poly">
	<area coords="703,5,687,5,676,20,657,19,633,15,623,10,598,11,584,12,580,29,570,47,562,66,551,65,536,68,527,80,517,84,510,93,497,86,482,80,469,73,457,84,455,97,444,99,419,104,398,104,395,104,395,113,395,123,398,135,408,139,423,144,445,151,453,160,452,169,466,168,472,179,477,189,494,189,503,182,515,180,522,185,524,197,534,193,547,189,548,196,555,203,558,216,572,221,586,212,601,205,616,188,612,176,623,174,629,175,643,165,656,157,657,147,661,131,658,122,657,110,662,103,668,105,679,102,688,103,699,103,701,96,696,88,697,78,704,78,712,73,723,71,745,70,757,65,767,55,778,52,785,44,789,36,765,37,746,39,727,38,723,18,680,10,706,7,713,8,710,21,690,9,676,9,656,11,629,11,600,8,664,12" href="index-new.php?ID=*map5" shape="poly">
	<area coords="837,143,857,144,870,131,876,122,881,109,881,90,872,83,855,91,850,88,840,64,825,58,810,36,797,31,792,48,774,58,758,69,735,81,708,82,708,96,696,107,677,111,659,111,665,125,662,154,652,175,627,179,621,193,599,211,578,220,556,223,554,204,539,196,521,198,512,184,497,189,479,191,523,243,530,265,534,274,535,290,537,301,541,315,538,324,535,335,537,341,554,340,565,340,575,340,571,326,584,318,603,318,612,312,611,297,625,287,628,277,645,260,656,255,661,258,675,268,690,269,690,282,682,287,683,297,714,307,728,299,736,288,750,280,763,266,760,255,768,231,777,227,781,217,778,208,788,193,798,187,802,165,813,159,828,156,851,146" href="index-new.php?ID=*map6" shape="poly">
	<area coords="368,515,376,490,365,484,374,462,383,442,383,415,383,398,379,380,389,368,392,357,387,337,387,324,388,297,401,297,423,284,427,295,444,299,461,292,463,285,473,294,484,319,505,316,527,311,535,305,530,327,527,339,543,344,564,347,578,330,589,322,616,323,618,312,614,300,625,297,633,290,635,274,652,263,667,271,688,271,681,293,691,302,707,307,731,307,738,294,741,309,729,319,729,328,717,343,720,354,718,360,711,367,699,374,696,385,691,396,695,406,693,414,681,414,683,432,669,438,663,444,637,440,620,446,617,460,609,467,593,461,580,462,561,472,538,464,521,465,504,469,483,461,465,464,463,476,444,486,434,492,417,493,406,487,398,501,392,509" href="index-new.php?ID=*map7" shape="poly">
	</map>';
}
elseif($FIND == "persons"){
	$events = false;
	$send = mysqli_query($connect,"SELECT * FROM `table`");
	printlist($connect,$send);
  echo "<form action='tmp/save.csv'><input type='submit' value='Letöltés'></form>";
}
elseif($FIND == "addevent"){
	header("Location: eventadd-new.php");
}
elseif($FIND == "addperson"){
	header("Location: register-new.php");
}
elseif($FIND == "delete"){
	header("Location: delete-new.php");
}
elseif(strpos($FIND,"*map") !== FALSE){
	$events = false;
	regioprint($connect,substr($FIND, -1));
}
elseif($FIND == "events"){
	//EVENTS
	$events = true;
	$send = mysqli_query($connect,"SELECT * FROM `list_of_events`");
	if(!$send){
		die("Hiba az EVENTS szekcióban");
	}
	else{
		echo "<h2><b>ESEMÉNYEK</b></h2><br>";
		echo "<center><table WIDTH='600' class='hoverTable'><tr><td style='color:white; background: #061E5E'><b>Eseménynév</b></td><td style='color:white; background: #061E5E'><b>Dátum</b></td><td style='color:white; background: #061E5E'><b>Helyszín</b></td></tr>";
		while ($row = mysqli_fetch_assoc($send)){
			echo "<tr><td><a href='eventshow-new.php?find=".urlencode($row["EVENTNAME"])."'>".$row["EVENTNAME"]."</a></td>";
			echo "<td>".$row["DATE"]."</td>";
			echo "<td>".$row["PLACE"]."</td></tr>";
		}
		echo "</table></center>";
	}
}
else{
	$events = false;
	if(is_numeric($FIND) && strlen($FIND)<14){
		//PHONE
		$send = mysqli_query($connect,"SELECT * FROM `table` WHERE PHONE = '$FIND'");
		if(!$send){
			die("Hiba a PHONE szekcióban!");
		}
		elseif(printlist($connect,$send) == 0) echo "<br><br><b>Nincs találat ilyen Telefonszámra!</b></font>";
	}
	else{
		if(strpos($FIND,"@") !== FALSE){
			//EMAIL
			$send = mysqli_query($connect,"SELECT * FROM `table` WHERE EMAIL LIKE '%$FIND%'");
			if(!$send){
				die("Hiba a EMAIL szekcióban!");
			}
			elseif(printlist($connect,$send) == 0) echo "<br><br><b>Nincs találat ilyen E-mail címre!</b></font>";
		}
		else{
			//EVENTNAME
			$send = mysqli_query($connect,"SELECT * FROM `list_of_events` WHERE EVENTNAME = '$FIND'");
			if(!$send){
				die("<br><br>Hiba az EVENTNAME szekcióban!");
			}
			elseif(mysqli_num_rows($send) == 0){
				//CITY
				$send = mysqli_query($connect,"SELECT * FROM `table` WHERE CITY = '$FIND'");
				if(!$send){
					die("<br><br>Hiba a CITY szekcióban!");
				}
				elseif(printlist($connect,$send) == 0){
					//COUNTRY
					$send = mysqli_query($connect,"SELECT * FROM `table` WHERE COUNTRY = '$FIND'");
					if(!$send){
						die("<br><br>Hiba a COUNTRY szekcióban!");
					}
					elseif(printlist($connect,$send) == 0){
						//NAME
						$send = mysqli_query($connect,"SELECT * FROM `table` WHERE NAME LIKE '%$FIND%'");
						if(!$send){
							die("<br><br>Hiba a NAME szekcióban!");
						}
						elseif(printlist($connect,$send) == 0){
							//INFO
							$send = mysqli_query($connect,"SELECT * FROM `table` WHERE INFO LIKE '%$FIND%'");
							if(!$send){
								die("<br><br>Hiba a INFO szekcióban!");
							}
							elseif(printlist($connect,$send) == 0){
								//FB
								$send = mysqli_query($connect,"SELECT * FROM `table` WHERE FB LIKE '%$FIND%'");
								if(!$send){
									die("<br><br>Hiba a FB szekcióban!");
								}
								elseif(printlist($connect,$send) == 0){
									$showdownload = false;
									echo "<br><br><b>Nincs találat ilyen városra, országra, névre, megjegyzésre, facebook ID-ra vagy felhasználónévre!</b></font>";
								}
							}
						}
					}
				}
			}
			else{
				$row = mysqli_fetch_assoc($send);
				header("Location: eventshow-new.php?find=".urlencode($row["EVENTNAME"]));
				$showdownload = false;
			}
			if($showdownload)echo "<form action='tmp/save.csv'><input type='submit' value='Letöltés'></form>";
		}
	}
}
if(!$events)echo "<br><br><a href='register-new.php'>ÚJ SZEMÉLY HOZZÁADÁSA</a>";
else echo "<br><br><a href='eventadd-new.php'>ÚJ ESEMÉNY HOZZÁADÁSA</a>";
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