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


      $stmt  = oci_parse($conn, " select * from stadium ");
      oci_execute($stmt);
      $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);
      echo "경기장 목록: ".$num_rows."<br/>";

      echo "<table width='500' cellpadding='0' cellspacing='0' border='1'>";   //테이블 태그 시작

      echo "<tr>";
      echo "<td>"."구장 이름"."</td>";
      echo "<td>"."소속 구단"."</td>";
      echo "<td>"."LRF"."</td>";
      echo "<td>"."LR"."</td>";
      echo "<td>"."CF"."</td>";
      echo "<td>"."FH"."</td>";

      echo "</tr>";

        foreach($rows as $row){
                echo "<tr>";
                echo "<td>".$row['SNAME']."</td>";
                echo "<td>".$row['HCLUB']."</td>";
                echo "<td>".$row['LRF']."</td>";
                echo "<td>".$row['LR']."</td>";
                echo "<td>".$row['CF']."</td>";
                echo "<td>".$row['FH']."</td>";
                echo "</tr>";
        }


        echo "</table>";


          oci_free_statement($stmt);
          oci_close($conn);



     ?>
     <hr>



    </section>
  </body>
</html>
