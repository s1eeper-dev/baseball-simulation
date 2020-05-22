<?php

	putenv ("NLS_LANG=AMERICAN_AMERICA.UTF8");
	$clubs = $_POST['selclub'];
	$clubs = explode(',', $clubs);

?>

<!DOCTYPE html>
<html>
	<head>
		<title>팀 체크</title>
		<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
	</head>

	<body>
		<section>
			<form name="club_check_form" method="post" action="./selAplayer.php">
				<input type="hidden" name="clubs[]" value="<? echo $clubs[0]; ?>">
				<input type="hidden" name="clubs[]" value="<? echo $clubs[1]; ?>">
			</form>

			<script type="text/javascript">
				document.club_check_form.submit();
			</script>
		</section>
	</body>
</html>