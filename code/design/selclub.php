 <?php
	putenv ("NLS_LANG=AMERICAN_AMERICA.UTF8");

	require('../idu/config/config.php');
	$conn = oci_connect($id,$pw,$server);

	if(!$conn){
		echo "Oricale Connect Error";
		exit();
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>팀 선택</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="style.css">

		<script>
				var count = 0;
				var array = [2]; 
				
				function OnOff(){
					if(count < 2){
						var obj = document.getElementsByName('club');
						for(i=0; i < obj.length; i++){
							if(obj[i].checked){
								array[count] = obj[i].value;
								obj[i].disabled = "ture";
							}
						}
						count++;
						if(count == 2)
							getArray1();
					}
					else{
						alert("2팀만 선택가능");
					}
				}
				
				function getArray1(){
					var t = array[0] + "," + array[1];
					document.getElementById("selclub").value = t;
				}
		</script>
    </head>

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
			<h2>원정팀 선택 후 홈팀 선택</h2>
			<?
				$sql = "select * from CLUB";
				$stmt = oci_parse($conn, $sql);
				oci_execute($stmt);
				oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);
			?>

			<form name="selclub_form" method="post" action="./selclub_check.php">
				<?
					foreach($rows as $row){
						echo '<input type="radio" name="club" value="';
						echo $row['C#'];
						echo '"onclick="OnOff()";>'.$row[CNAME].'<br>';
					}
				?>
				<br>
				<input type="hidden" name="selclub" id="selclub" />
				<input type="submit" value="팀선택 완료">			
			</form>
		</section>
    </body>
</html> 

<?

	oci_free_statement( $stmt );
	oci_close($conn);

?>
