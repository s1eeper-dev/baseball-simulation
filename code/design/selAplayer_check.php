<?php

	$clubs = $_POST['clubs'];

	$Apit1 = $_POST['Apit1'];
	$Apit2 = $_POST['Apit2'];
	$Apit3 = $_POST['Apit3'];
	$Apit4 = $_POST['Apit4'];

	$Ahit1 = $_POST['Ahit1'];
	$Ahit2 = $_POST['Ahit2'];
	$Ahit3 = $_POST['Ahit3'];
	$Ahit4 = $_POST['Ahit4'];
	$Ahit5 = $_POST['Ahit5'];
	$Ahit6 = $_POST['Ahit6'];
	$Ahit7 = $_POST['Ahit7'];
	$Ahit8 = $_POST['Ahit8'];
	$Ahit9 = $_POST['Ahit9'];

	if(!($Apit1 && $Apit2 && $Apit3 && $Apit4)){
		echo("
			<script>
				window.alert('투수가 모두 선택되지 않았습니다.');
				history.go(-1);
			</script>
		");
		exit();
	}
	else if(!($Ahit1 && $Ahit2 && $Ahit3 && $Ahit4 && $Ahit5 && $Ahit6 && $Ahit7 && $Ahit8 && $Ahit9)){
		echo("
			<script>
				window.alert('타자가 모두 선택되지 않았습니다.');
				history.go(-1);
			</script>
		");
		exit();
	}
	else{
?>

<!DOCTYPE html>
<html>
	<head>
		<title>A선수 체크</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>

	<body>
		<section>
			<form name="Aplayer_check_form" method="post" action="./selBplayer.php">
				<input type="hidden" name="clubs[]" value="<? echo $clubs[0]; ?>">
				<input type="hidden" name="clubs[]" value="<? echo $clubs[1]; ?>">
				
				<input type="hidden" name="APplayer[]" value="<? echo $Apit1; ?>">
				<input type="hidden" name="APplayer[]" value="<? echo $Apit2; ?>">
				<input type="hidden" name="APplayer[]" value="<? echo $Apit3; ?>">
				<input type="hidden" name="APplayer[]" value="<? echo $Apit4; ?>">

				<input type="hidden" name="AHplayer[]" value="<? echo $Ahit1; ?>">
				<input type="hidden" name="AHplayer[]" value="<? echo $Ahit2; ?>">
				<input type="hidden" name="AHplayer[]" value="<? echo $Ahit3; ?>">
				<input type="hidden" name="AHplayer[]" value="<? echo $Ahit4; ?>">
				<input type="hidden" name="AHplayer[]" value="<? echo $Ahit5; ?>">
				<input type="hidden" name="AHplayer[]" value="<? echo $Ahit6; ?>">
				<input type="hidden" name="AHplayer[]" value="<? echo $Ahit7; ?>">
				<input type="hidden" name="AHplayer[]" value="<? echo $Ahit8; ?>">
				<input type="hidden" name="AHplayer[]" value="<? echo $Ahit9; ?>">
			</form>

			<script type="text/javascript">
				document.Aplayer_check_form.submit();
			</script>
		</section>
	</body>
</html>

<?
	}
?>