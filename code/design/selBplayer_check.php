<?php

	$clubs = $_POST['clubs'];
	$APplayer = $_POST['APplayer'];
	$AHplayer = $_POST['AHplayer'];

	$Bpit1 = $_POST['Bpit1'];
	$Bpit2 = $_POST['Bpit2'];
	$Bpit3 = $_POST['Bpit3'];
	$Bpit4 = $_POST['Bpit4'];

	$Bhit1 = $_POST['Bhit1'];
	$Bhit2 = $_POST['Bhit2'];
	$Bhit3 = $_POST['Bhit3'];
	$Bhit4 = $_POST['Bhit4'];
	$Bhit5 = $_POST['Bhit5'];
	$Bhit6 = $_POST['Bhit6'];
	$Bhit7 = $_POST['Bhit7'];
	$Bhit8 = $_POST['Bhit8'];
	$Bhit9 = $_POST['Bhit9'];

	if(!($Bpit1 && $Bpit2 && $Bpit3 && $Bpit4)){
		echo("
			<script>
				window.alert('투수가 모두 선택되지 않았습니다.');
				history.go(-1);
			</script>
		");
		exit();
	}
	else if(!($Bhit1 && $Bhit2 && $Bhit3 && $Bhit4 && $Bhit5 && $Bhit6 && $Bhit7 && $Bhit8 && $Bhit9)){
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
		<title>B선수 체크</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>

	<body>
		<section>
			<form name="Bplayer_check_form" method="post" action="../simulation/DO_echo.php">
				<input type="hidden" name="clubs[]" value="<? echo $clubs[0]; ?>">
				<input type="hidden" name="clubs[]" value="<? echo $clubs[1]; ?>">
				
				<input type="hidden" name="APplayer[]" value="<? echo $APplayer[0]; ?>">
				<input type="hidden" name="APplayer[]" value="<? echo $APplayer[1]; ?>">
				<input type="hidden" name="APplayer[]" value="<? echo $APplayer[2]; ?>">
				<input type="hidden" name="APplayer[]" value="<? echo $APplayer[3]; ?>">

				<input type="hidden" name="AHplayer[]" value="<? echo $AHplayer[0]; ?>">
				<input type="hidden" name="AHplayer[]" value="<? echo $AHplayer[1]; ?>">
				<input type="hidden" name="AHplayer[]" value="<? echo $AHplayer[2]; ?>">
				<input type="hidden" name="AHplayer[]" value="<? echo $AHplayer[3]; ?>">
				<input type="hidden" name="AHplayer[]" value="<? echo $AHplayer[4]; ?>">
				<input type="hidden" name="AHplayer[]" value="<? echo $AHplayer[5]; ?>">
				<input type="hidden" name="AHplayer[]" value="<? echo $AHplayer[6]; ?>">
				<input type="hidden" name="AHplayer[]" value="<? echo $AHplayer[7]; ?>">
				<input type="hidden" name="AHplayer[]" value="<? echo $AHplayer[8]; ?>">

				<input type="hidden" name="BPplayer[]" value="<? echo $Bpit1; ?>">
				<input type="hidden" name="BPplayer[]" value="<? echo $Bpit2; ?>">
				<input type="hidden" name="BPplayer[]" value="<? echo $Bpit3; ?>">
				<input type="hidden" name="BPplayer[]" value="<? echo $Bpit4; ?>">

				<input type="hidden" name="BHplayer[]" value="<? echo $Bhit1; ?>">
				<input type="hidden" name="BHplayer[]" value="<? echo $Bhit2; ?>">
				<input type="hidden" name="BHplayer[]" value="<? echo $Bhit3; ?>">
				<input type="hidden" name="BHplayer[]" value="<? echo $Bhit4; ?>">
				<input type="hidden" name="BHplayer[]" value="<? echo $Bhit5; ?>">
				<input type="hidden" name="BHplayer[]" value="<? echo $Bhit6; ?>">
				<input type="hidden" name="BHplayer[]" value="<? echo $Bhit7; ?>">
				<input type="hidden" name="BHplayer[]" value="<? echo $Bhit8; ?>">
				<input type="hidden" name="BHplayer[]" value="<? echo $Bhit9; ?>">
			</form>

			<script type="text/javascript">
				document.Bplayer_check_form.submit();
			</script>
		</section>
	</body>
</html>

<?
	}
?>