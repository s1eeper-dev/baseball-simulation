<!DOCTYPE html>

<html lang="ko">
	<head>
		<title>승리 예측</title>
		<meta charset="utf-8">
	</head>
  
	<body>
	<?php
		$AwinCount = $_POST['AwinCount'];
		$BwinCount = $_POST['BwinCount'];
		$draw = $_POST['draw'];
		$clubs=$_POST['clubs'];

		$AwinCount = round($AwinCount / 9 * 100, 1);
		$BwinCount = round($BwinCount / 9 * 100, 1);
		$draw = round($draw / 9 * 100, 1);
	?>

			<div style="overflow:hidden; "  >
				<div style="float:left; text-align:left; "> <?echo $clubs[0] ?> </div>
				<div style="float:right; text-align:right; "> <?echo $clubs[1]?> </div>
			</div>

			<div style="height:80px; width:100%; overflow:hidden; line-height:80px;"  >
				<div style="float:left; text-align:left; font-size:20px; background-color:rgb(39,120,177); width:<?echo $AwinCount;?>%;"> <?echo $AwinCount;?>% </div>
				<div style="float:left; text-align:center; background-color:rgb(254,185,56); width:<?echo $draw;?>%;"> Draw </div>
				<div style="float:left; text-align:right; font-size:20px; background-color:rgb(251,8,12); width:<?echo $BwinCount;?>%;"> <?echo $BwinCount;?>% </div>
			</div>
	</body>
</html>