<!DOCTYPE html>
<html>
<head>
     <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link type="text/css" rel="stylesheet" href="../../Dong/style.css">
</head>
<body>
  <header>
    <div id="logo"><h1><img src="../../Dong/img/kbo_symbol.jpg">BASEBALL SIMULATION</h1></div>
    <div id="language"><h2>B_TEAM1<br>A789029 노상우 / B189053 이동희<br>B289025 김태관 / B289045 박태환<br></h2></div>
  </header>
		  
  <nav>
    <hr><ul>
      <li><input type="button" value="MAIN" onclick="location.href='../idu.php'"></li>
      <li><input type="button" value="INSERT" onclick="location.href='../insert/insert_Main.php'"></li>
      <li><input type="button" value="DELETE" onclick="location.href='../delete/delete_Main.php'"></li>
      <li><input type="button" value="UPDATE" onclick="location.href='../update/update_Main.php'"></li>
      <li><input type="button" value="SELECT" onclick="location.href='select_Main.php'"></li>
      <li><input type="button" value="SIMULATION" onclick="location.href='../../Dong/selclub.php'"></li>
    </ul><hr>
  </nav>
	
  <section>
  <h1>Select</h1>
  <input type="button" value="Club" onclick="location.href='EXECUTE/select_club_init.php'">
  <input type="button" value="Stadium" onclick="location.href='EXECUTE/select_stadium.php'">
  <input type="button" value="pitcher" onclick="location.href='EXECUTE/select_pitcher.php'">
  <input type="button" value="hitter" onclick="location.href='EXECUTE/select_hitter.php'">
  <input type="button" value="VS" onclick="location.href='EXECUTE/select_vs.php'">


  </section>
</body>
</html>
