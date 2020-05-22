<!DOCTYPE html>

<html lang="ko">
	<head>
		<title>스코어보드</title>
		<meta charset="utf-8">
		<style>
			 table.type09 {
				border-collapse: collapse;
				text-align: left;
				line-height: 1.5;

				width: 100%;
			}
			table.type09 thead th {
				font-weight: bold;
				vertical-align: top;
				color: #369;
				border-bottom: 3px solid #036;
			}
			table.type09 tbody th {
				font-weight: bold;
				vertical-align: top;
				padding: 3px;
				border-bottom: 1px solid #ccc;
				background: #f3f6f7;
			}
			table.type09 td {
				vertical-align: top;
				padding: 3px;
				border-bottom: 1px solid #ccc;
			}
	</style>
	</head>
  
	<body>
	<?php
		$Ascore = $_POST['Ascore'];
		$Atotal = 0;
		for($n = 0; $n < count($Ascore); $n++){
			$Atotal += $Ascore[$n];
		}
		
		$Bscore = $_POST['Bscore'];
		$Btotal = 0;
		for($n = 0; $n < count($Bscore); $n++){
			$Btotal += $Bscore[$n];
		}

		$clubs=$_POST['clubs'];		
	?>


			<table class="type09">
			<thead>
			<tr>
				<th></th>
				<th>1회</th>
				<th>2회</th>
				<th>3회</th>
				<th>4회</th>
				<th>5회</th>
				<th>6회</th>
				<th>7회</th>
				<th>8회</th>
				<th>9회</th>
				<th>R</th>
			</tr>
			</thead>
			
			<tbody>
			<tr>
				<th><?echo $clubs[0] ?></th>
				<td><? echo $Ascore[0]; ?></td>
				<td><? echo $Ascore[1]; ?> </td>
				<td><? echo $Ascore[2]; ?></td>
				<td><? echo $Ascore[3]; ?></td>
				<td><? echo $Ascore[4]; ?></td>
				<td><? echo $Ascore[5]; ?></td>
				<td><? echo $Ascore[6]; ?></td>
				<td><? echo $Ascore[7]; ?></td>
				<td><? echo $Ascore[8]; ?></td>
				<td style= "font-weight: bold;"><? echo $Atotal; ?></td>
			</tr>

			<tr>
				<th> <?echo $clubs[1] ?> </th>
				<td><? echo $Bscore[0]; ?></td>
				<td><? echo $Bscore[1]; ?> </td>
				<td><? echo $Bscore[2]; ?></td>
				<td><? echo $Bscore[3]; ?></td>
				<td><? echo $Bscore[4]; ?></td>
				<td><? echo $Bscore[5]; ?></td>
				<td><? echo $Bscore[6]; ?></td>
				<td><? echo $Bscore[7]; ?></td>
				<td><? echo $Bscore[8]; ?></td>
				<td style= "font-weight: bold;"><? echo $Btotal; ?></td>
			</tr>
			</tbody>
	</table>

	</body>
</html>