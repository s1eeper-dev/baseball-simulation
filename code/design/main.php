<!doctype html>

<html lang="ko">
	<head>
		<meta charset="UTF-8">
		<title>가상대결 전체화면</title>
		<style>
			frame {height:600px;width:1000px;border:1px dotted red}
		</style>
	</head>
	<div>
	<frameset cols="50%,50%" border=0px>
		<frameset rows="15%,64%,21%" border=0px>
			<frame src="tab_inning_cover.php" name="tab_inning" scrolling=no>

			<frame src="simulation_inning_cover.php" name="simulation_inning" scrolling=auto>

			<frame src="prediction_cover.php" name="prediction" scrolling=no>
		</frameset>

		<frame src="../idu/idu.php" name="idu" scrolling=auto>
	</frameset>
	</div>
</html>
