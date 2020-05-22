<!DOCTYPE html>
	<html>
		<head>
			<title>btn_sql</title>
			<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
		</head>

		<body>
			<form name="btn_form" method="post" action="select_club.php">
				<? $sql = "select * from CLUB natural join STADIUM "; ?>
				<input type="hidden" name="sql" value="<? echo $sql; ?>">
			</form>

			<script type="text/javascript">
				document.btn_form.submit();
			</script>
		</body>
	</html>