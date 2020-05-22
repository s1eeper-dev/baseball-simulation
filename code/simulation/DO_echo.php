<?php
	putenv ("NLS_LANG=AMERICAN_AMERICA.UTF8");

	$conn = oci_connect("a789029", "a789029", "203.249.87.162:1521/orcl");

    if(!$conn){
            echo "Oricale Connect Error";
            exit();
    }

	include ("/var/www/html/b_team/b_team1/simulation/BaseballQueue.php");
	include ("/var/www/html/b_team/b_team1/simulation/PlayerData2L.php");
	include ("/var/www/html/b_team/b_team1/simulation/Printer.php");
	
	$printer = new Printer();
	$Queue = new BaseballQueue($printer);
	$objA = new PlayerData($printer,$Queue);
	$objB = new PlayerData($printer,$Queue);

	$clubs=$_POST['clubs'];

	$Apit=$_POST['APplayer'];
	$Ahit=$_POST['AHplayer'];

	$Bpit=$_POST['BPplayer'];
	$Bhit=$_POST['BHplayer'];
	
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link type="text/css" rel="stylesheet" href="../Dong/style.css">
</head>
<body>
<header>
<div id="logo"><h1><img src="../Dong/img/kbo_symbol.jpg">BASEBALL SIMULATION</h1></div>
<div id="language"><h2>B_TEAM1<br>A789029 노상우 / B189053 이동희<br>B289025 김태관 / B289045 박태환<br></h2></div>
</header>
		  
<nav>
<hr><ul>
<li><input type="button" value="MAIN" onclick="location.href='../idu/idu.php'"></li>
<li><input type="button" value="INSERT" onclick="location.href='../idu/insert/insert_Main.php'"></li>
<li><input type="button" value="DELETE" onclick="location.href='../idu/delete/delete_Main.php'"></li>
<li><input type="button" value="UPDATE" onclick="location.href='../idu/update/update_Main.php'"></li>
<li><input type="button" value="SELECT" onclick="location.href='../idu/select/select_Main.php'"></li>
<li><input type="button" value="SIMULATION" onclick="location.href='../Dong/selclub.php'"></li>
</ul><hr>
</nav>

<section>

<?//################################### B 팀 투수 vs A 팀 타자 ###################################

	for($n = 0; $n < count($Bpit); $n++){
		$sql_BP = "select * from PITCHER where P#=" . "'" . $Bpit[$n]. "'";
		$stmt = oci_parse($conn, $sql_BP);
		oci_execute($stmt);
		oci_fetch_all($stmt, $BPs, null, null, OCI_FETCHSTATEMENT_BY_ROW);

		$objA->setPitcher($BPs[0][PNAME],$BPs[0][SO],$BPs[0][BB],$BPs[0][HBP]);
	}


	for($n = 0; $n < count($Ahit); $n++){
		$sql_AH = "select * from HITTER where H#=". "'" . $Ahit[$n] . "'";
		$stmt = oci_parse($conn, $sql_AH);
		oci_execute($stmt);
		oci_fetch_all($stmt, $AHs, null, null, OCI_FETCHSTATEMENT_BY_ROW);
		
		$objA->setHitter($AHs[0][HNAME], $AHs[0][PA], $AHs[0][AB], $AHs[0][H], $AHs[0][B2], $AHs[0][B3], $AHs[0][HR], $AHs[0][GO], $AHs[0][AO] );
	}


	for($n = 0; $n < count($BPs); $n++){
		for($l = 0; $l < count($AHs); $l++){	
			$pitcher_num = $BPs[$n]['P#'];
			$hitter_num = $AHs[$l]['H#'];
			$sql_3 = "select * from VS where P# =". "'" .$pitcher_num. "'" . "and H# = " . "'" .$hitter_num. "'";
			$parse  = oci_parse($conn, $sql_3);
			oci_execute($parse);
			oci_fetch_all($parse, $VSs, null, null, OCI_FETCHSTATEMENT_BY_ROW);
		
			$objA->setVs($n,$l, $VSs[0][PA],$VSs[0][AB],$VSs[0][H]);
		}
	}
?>

<?//################################### A 팀 투수 vs B 팀 타자 ###################################


	for($n = 0; $n < count($Apit); $n++){
		$sql_AP = "select * from PITCHER where P#=" . "'" . $Apit[$n]. "'";
		$stmt = oci_parse($conn, $sql_AP);
		oci_execute($stmt);
		oci_fetch_all($stmt, $APs, null, null, OCI_FETCHSTATEMENT_BY_ROW);

		$objB->setPitcher($APs[0][PNAME],$APs[0][SO],$APs[0][BB],$APs[0][HBP]);
	}


	for($n = 0; $n < count($Bhit); $n++){
		$sql_BH = "select * from HITTER where H#=". "'" . $Bhit[$n] . "'";
		$stmt = oci_parse($conn, $sql_BH);
		oci_execute($stmt);
		oci_fetch_all($stmt, $BHs, null, null, OCI_FETCHSTATEMENT_BY_ROW);
		
		$objB->setHitter($BHs[0][HNAME], $BHs[0][PA], $BHs[0][AB], $BHs[0][H], $BHs[0][B2], $BHs[0][B3], $BHs[0][HR], $BHs[0][GO], $BHs[0][AO] );
	}

	
	for($n = 0; $n < count($APs); $n++){
		for($l = 0; $l < count($BHs); $l++){	
			$pitcher_num = $APs[$n]['P#'];
			$hitter_num = $BHs[$l]['H#'];
			$sql_3 = "select * from VS where P# =". "'" .$pitcher_num. "'" . "and H# = " . "'" .$hitter_num. "'";
			$parse  = oci_parse($conn, $sql_3);
			oci_execute($parse);
			oci_fetch_all($parse, $VSs, null, null, OCI_FETCHSTATEMENT_BY_ROW);
		
			$objB->setVs($n,$l, $VSs[0][PA],$VSs[0][AB],$VSs[0][H]);
		}
	}
?>
	


<?	//#########################   시뮬레이션   #########################
	 $text = array();
	 $Ascore = array();
	 $Bscore = array();
	 $name = "_inning.php";

	for($eniing  = 0; $eniing  <9; $eniing++){
		$objA->Play();
		$text[$eniing] = $printer->getPrintPlay();
		$Ascore[$eniing] = $Queue->getInningScore();		
		
		$text[$eniing] = $text[$eniing]."</br></br>".($eniing+1)."회 초 공격 종료 </br></br>";
		
		$objB->Play();
		$text[$eniing] = $text[$eniing].$printer->getPrintPlay();
		$Bscore[$eniing] = $Queue->getInningScore();

		$text[$eniing] = $text[$eniing]."</br></br>".($eniing+1)."회 말 공격 종료 </br></br>";

		$fileName = ($eniing+1).$name;
		?>		
		<form style = "display: inline;" method="post" action='../Dong/<? echo $fileName; ?>'>
			<input type='hidden' name='text' value='<? echo $text[$eniing]; ?>'>
			<input type = "submit" value = "<? echo ($eniing+1); ?>회" onclick="parent.simulation_inning.location.href='../Dong/<? echo $fileName; ?>'" formtarget="simulation_inning">
		</form>
		<?
	}
?>

<?############################## club ##############################?>

<? 		
		$sql_club = "select * from CLUB where C#=". "'" . $clubs[0] . "'". "or C#=". "'" . $clubs[1] . "'" ;
		$stmt = oci_parse($conn, $sql_club);
		oci_execute($stmt);
		oci_fetch_all($stmt, $club, null, null, OCI_FETCHSTATEMENT_BY_ROW);	

		if($club[0]['C#'] == $clubs[0]){
			$clubs[0] = $club[0][CNAME];
			$clubs[1] = $club[1][CNAME];
		}
		else{
			$clubs[1] = $club[0][CNAME];
			$clubs[0] = $club[1][CNAME];
		}
?>

<?############################## 스코어 보드 ##############################?>

		<form name ="scoreBoard" method="post" action='../Dong/tab_inning.php'>
			<?for($n = 0; $n < 9; $n++){?>
			<input type='hidden' name='Ascore[]' value='<? echo $Ascore[$n]; ?>'>
			<input type='hidden' name='Bscore[]' value='<? echo $Bscore[$n]; ?>'>
			<?}?>
			<input type="hidden" name="clubs[]" value="<? echo $clubs[0]; ?>">
            <input type="hidden" name="clubs[]" value="<? echo $clubs[1]; ?>">
			<input type = "submit" id = "btn1" style="display:none;" onclick="parent.tab_inning.location.href='../Dong/tab_inning.php'" formtarget="tab_inning">	
		</form>
		
<?############################## 경기 예측 ##############################
	$AwinCount = 0;
	$BwinCount = 0;
	$draw = 0;

   for($n = 0; $n<9; $n++){
	  
      $A = 0;
      $B = 0;
      
      for($eniing  = 0; $eniing  <9; $eniing++){
         $objA->Play();
         $A = $A + $Queue->getInningScore();      
         
         $objB->Play();
         $B = $B + $Queue->getInningScore();
      }
      
	  if($A > $B)
         $AwinCount++;
      elseif ($A < $B)
         $BwinCount++;
	  else
		  $draw++;

   }
?>
	<form name = "predict" method="post" action='../Dong/prediction.php'>
		<input type='hidden' name='AwinCount' value='<? echo $AwinCount; ?>'>
		<input type='hidden' name='BwinCount' value='<? echo $BwinCount; ?>'>
		<input type='hidden' name='draw' value='<? echo $draw; ?>'>
		<input type="hidden" name="clubs[]" value="<? echo $clubs[0]; ?>">
        <input type="hidden" name="clubs[]" value="<? echo $clubs[1]; ?>">
		<input type = "submit" id = "btn2" style="display:none;" onclick="parent.prediction.location.href='../Dong/prediction.php'" formtarget="prediction">	
	</form>

		<script type="text/javascript">
			document.scoreBoard.btn1.click();
			document.predict.btn2.click();
       	</script>

</section>
</body>
</html>

<?
	oci_free_statement( $stmt );
	oci_close($conn);
?>



