<?php
	putenv ("NLS_LANG=AMERICAN_AMERICA.UTF8");
	$btn = $_POST['btn_value'];
	?>

	<!DOCTYPE html>
	<html>
		<head>
			<title>btn_sql</title>
			<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
		</head>

		<body>
			<? if($btn == "CNAME" || $btn == "S#" || $btn == "GN" || $btn == "W" || $btn == "L" || $btn == "D" || $btn == "WR") { ?>
				<form name="btn_form" method="post" action="./select_club.php">
					<? if($btn == "CNAME") { $sql = "select * from CLUB natural join STADIUM order by CNAME DESC"; }	//이름?>
					<? if($btn == "S#") { $sql = "select * from CLUB natural join STADIUM order by SNAME DESC"; }		//구장번호?>
					<? if($btn == "GN") { $sql = "select * from CLUB natural join STADIUM order by GN DESC"; }			//구단번호?>
					<? if($btn == "W") { $sql = "select * from CLUB natural join STADIUM order by W DESC"; }			//승리?>
					<? if($btn == "L") { $sql = "select * from CLUB natural join STADIUM order by L DESC"; }			//패배?>
					<? if($btn == "D") { $sql = "select * from CLUB natural join STADIUM order by D DESC"; }			//무승부?>
					<? if($btn == "WR") { $sql = "select * from CLUB natural join STADIUM order by WR DESC"; }			//경기수?>

					<input type="hidden" name="sql" value="<? echo $sql; ?>">
				</form>
			<? } ?>

			<script type="text/javascript">
				document.btn_form.submit();
			</script>
		</body>
	</html>