<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link type="text/css" rel="stylesheet" href="../../../Dong/style.css">
  </head>

  <body>
    <header>
        <div id="logo"><h1><img src="../../../Dong/img/kbo_symbol.jpg">BASEBALL SIMULATION</h1></div>
        <div id="language"><h2>B_TEAM1<br>A789029 노상우 / B189053 이동희<br>B289025 김태관 / B289045 박태환<br></h2></div>
    </header>
		  
    <nav>
        <hr><ul>
          <li><input type="button" value="MAIN" onclick="location.href='../../idu.php'"></li>
          <li><input type="button" value="INSERT" onclick="location.href='../../insert/insert_Main.php'"></li>
          <li><input type="button" value="DELETE" onclick="location.href='../../delete/delete_Main.php'"></li>
          <li><input type="button" value="UPDATE" onclick="location.href='../../update/update_Main.php'"></li>
          <li><input type="button" value="SELECT" onclick="location.href='../select_Main.php'"></li>
          <li><input type="button" value="SIMULATION" onclick="location.href='../../../Dong/selclub.php'"></li>
        </ul><hr>
    </nav>
    
	<section>

    <h1>Select</h1>
    <?php
    putenv ("NLS_LANG=AMERICAN_AMERICA.UTF8");
    //putenv("NLS_LANG=AMERICAN_AMERICA.KO16MSWIN949");
    require('../../config/config.php');


    $conn = oci_connect($id,$pw,$server);

    if(!$conn){
            echo "Oricale Connect Error";
            exit();
    }


      //전체현황 출력
      $sql = $_POST['sql'];

      $stmt  = oci_parse($conn, $sql);
      oci_execute($stmt);
      $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);
      echo "구단 목록: ".$num_rows."<br/>";

      echo "<table width='500' cellpadding='0' cellspacing='0' border='1'>";   //테이블 태그 시작

      echo "<tr>";
	echo "<td>"."구단 이름"."</td>";
	echo "<td>"."소속된 구장"."</td>";
	echo "<td>"."GN"."</td>";
	echo "<td>"."W"."</td>";
	echo "<td>"."L"."</td>";
	echo "<td>"."D"."</td>";
	echo "<td>"."WR"."</td>";
      echo "</tr>";

        foreach($rows as $row){
                echo "<tr>";
                echo "<td>".$row['CNAME']."</td>";
                echo "<td>".$row['SNAME']."</td>";
                echo "<td>".$row['GN']."</td>";
                echo "<td>".$row['W']."</td>";
                echo "<td>".$row['L']."</td>";
                echo "<td>".$row['D']."</td>";
                echo "<td>".$row['WR']."</td>";
                echo "</tr>";
        }


        echo "</table>";


          oci_free_statement($stmt);
          oci_close($conn);




     ?>
	<br><label>내림차순정렬</label>
        <ul>
          <li><form name="btn_form" method="post" action="./sql.php">
			<input type="hidden" name="btn_value" value="CNAME">
			<input type="submit" value="구단">
		</form></li>
          <li><form name="btn_form" method="post" action="./sql.php">
			<input type="hidden" name="btn_value" value="S#">
			<input type="submit" value="구장">
		</form></li>
          <li><form name="btn_form" method="post" action="./sql.php">
			<input type="hidden" name="btn_value" value="GN">
			<input type="submit" value="GN">
		</form></li>
          <li><form name="btn_form" method="post" action="./sql.php">
			<input type="hidden" name="btn_value" value="W">
			<input type="submit" value="W">
		</form></li>
          <li><form name="btn_form" method="post" action="./sql.php">
			<input type="hidden" name="btn_value" value="L">
			<input type="submit" value="L">
		</form></li>
          <li><form name="btn_form" method="post" action="./sql.php">
			<input type="hidden" name="btn_value" value="D">
			<input type="submit" value="D">
		</form></li>
          <li><form name="btn_form" method="post" action="./sql.php">
			<input type="hidden" name="btn_value" value="WR">
			<input type="submit" value="WR">
		</form></li>
        </ul>

     <hr>


    </section>
  </body>
</html>
