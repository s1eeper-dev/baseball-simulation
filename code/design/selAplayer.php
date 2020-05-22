<?php
	putenv ("NLS_LANG=AMERICAN_AMERICA.UTF8");
	require('../idu/config/config.php');
	$conn = oci_connect($id,$pw,$server);

	if(!$conn){
		echo "Oricale Connect Error";
		exit();
	}

	$clubs = $_POST['clubs'];

?>

<!DOCTYPE html>
<html>
	<head>
		<title>A구단 선수 선택</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="style.css">
	</head>

<script type="text/javascript">
   function Fun(){
    var fm = this.form;
    var ln = this.name.length-1;
    var p = this.name.substring(ln)*1-1;
    var n = this.name.substring(ln)*1+1;
    var v = this.value;
    var nm = this.name.substring(0, ln);
    var pv;
    var to = this.options[0];

    while ((pv=fm[nm+(p--)] || fm[nm+(n++)])){
     if(v == pv.value){
      to.selected = true;
      return;
     }
    }
   }
</script>

	<body>
		<header>
			<div id="logo"><h1><img src="./img/kbo_symbol.jpg">BASEBALL SIMULATION</h1></div>
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
			<form name="form" method="post" action="./selAplayer_check.php">
				<input type="hidden" name="clubs[]" value="<? echo $clubs[0]; ?>">
				<input type="hidden" name="clubs[]" value="<? echo $clubs[1]; ?>">

				<?
				$sql_C = "select CNAME from CLUB where C#='$clubs[0]'";
				$stmt = oci_parse($conn, $sql_C);
				oci_execute($stmt);
				oci_fetch_all($stmt, $row, null, null, OCI_FETCHSTATEMENT_BY_ROW);
				?>

				<h1> <? echo $row[0][CNAME]; ?> </h1>
				<hr>


				<?
				$sql_P = "select * from PITCHER where C#='$clubs[0]'";
				$stmt = oci_parse($conn, $sql_P);
				oci_execute($stmt);
				oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);

				for ( $i=0 ; $i<4 ; $i++ ) {
					if ( $i == 0 ) { ?> 선발투수 :  <select name="Apit1"><? } 
					else if ( $i == 1 ) { ?> 1번 볼펜투수 :  <select name="Apit2" onchange="Fun.call(this)"><? } 
					else if ( $i == 2 ) { ?> 2번 볼펜투수 :  <select name="Apit3" onchange="Fun.call(this)"><? } 
					else if ( $i == 3 ) { ?> 3번 볼펜투수 :  <select name="Apit4" onchange="Fun.call(this)"><? } 
					?> <option selected value="0">선택</option> <?
					foreach($rows as $row){
						echo '<option value="';
						echo $row['P#'];
						echo '">'.$row[PNAME].'</option>';
					}
					?> </select><br><br> <?
				}
?>				
				<hr>

				<?
				$sql_H = "select * from HITTER where C#='$clubs[0]'";
				$stmt = oci_parse($conn, $sql_H);
				oci_execute($stmt);
				oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);

				for ( $i=0 ; $i<9 ; $i++ ) {
					if ( $i == 0 ) { ?> 1번 타자 :  <select name="Ahit1"><? } 
					else if ( $i == 1 ) { ?> 2번 타자 :  <select name="Ahit2" onchange="Fun.call(this)"><? } 
					else if ( $i == 2 ) { ?> 3번 타자 :  <select name="Ahit3" onchange="Fun.call(this)"><? } 
					else if ( $i == 3 ) { ?> 4번 타자 :  <select name="Ahit4" onchange="Fun.call(this)"><? } 
					else if ( $i == 4 ) { ?> 5번 타자 :  <select name="Ahit5" onchange="Fun.call(this)"><? } 
					else if ( $i == 5 ) { ?> 6번 타자 :  <select name="Ahit6" onchange="Fun.call(this)"><? }
					else if ( $i == 6 ) { ?> 7번 타자 :  <select name="Ahit7" onchange="Fun.call(this)"><? } 
					else if ( $i == 7 ) { ?> 8번 타자 :  <select name="Ahit8" onchange="Fun.call(this)"><? } 
					else if ( $i == 8 ) { ?> 9번 타자 :  <select name="Ahit9" onchange="Fun.call(this)"><? } 
					?> <option selected value="0">선택</option> <?
					foreach($rows as $row){
						echo '<option value="';
						echo $row['H#'];
						echo '">'.$row[HNAME].'</option>';
					}
					?> </select><br><br> <?
				}
?>
				<hr>
				<input type="submit" value="선수선택 완료">
			</form>
		</section>
	</body>
</html>

<?
	oci_free_statement( $stmt );
	oci_close($conn);
?>