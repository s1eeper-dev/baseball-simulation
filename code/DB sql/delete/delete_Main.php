<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
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
          <li><input type="button" value="DELETE" onclick="location.href='delete_Main.php'"></li>
          <li><input type="button" value="UPDATE" onclick="location.href='../update/update_Main.php'"></li>
          <li><input type="button" value="SELECT" onclick="location.href='../select/select_Main.php'"></li>
          <li><input type="button" value="SIMULATION" onclick="location.href='../../Dong/selclub.php'"></li>
        </ul><hr>
    </nav>

	<section>
    <h1>Delete</h1>

    <hr>

    <form class="" action="EXECUTE/delete_value.php" method="post">
      <label for="selectTeam">팀</label>
      <select class="team" id=selectTeam name="team" >
        <option value="">선택</option>
        <option value="C1">기아</option>
        <option value="C2">두산</option>
        <option value="C3">롯데</option>
        <option value="C4">엔씨</option>
      </select>


      <label for="ph">투수/타자</label>
      <select class="ph" id=ph name="ph" >
        <option value="">선택</option>
        <option value="pitcher">투수</option>
        <option value="hitter">타자</option>
      </select>

      <input type="submit" name="" value="전송">
    </form>


    <hr>




	</section>
  </body>
</html>
