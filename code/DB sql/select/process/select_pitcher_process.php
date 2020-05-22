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

    $team=$_POST['team'];

    putenv ("NLS_LANG=AMERICAN_AMERICA.UTF8");
    //putenv("NLS_LANG=AMERICAN_AMERICA.KO16MSWIN949");
    require('../../config/config.php');


    $conn = oci_connect($id,$pw,$server);

    if(!$conn){
            echo "Oricale Connect Error";
            exit();
    }


      //전체현황 출력


      $stmt  = oci_parse($conn, "select pitcher.P#, pitcher.PNAME, club.C# ,club.CNAME, pitcher.SO, pitcher.BB, pitcher.HBP from pitcher left join club on pitcher.C#=club.C# where club.C#='".$team."'" );
      oci_execute($stmt);
      $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);
      echo "투수 목록: ".$num_rows."<br/>";

      echo "<table width='500' cellpadding='0' cellspacing='0' border='1'>";   //테이블 태그 시작

      echo "<tr>";
      echo "<td>"."투수 번호"."</td>";
      echo "<td>"."투수 이름"."</td>";
      echo "<td>"."소속 구단"."</td>";
      echo "<td>"."SO"."</td>";
      echo "<td>"."BB"."</td>";
      echo "<td>"."HBP"."</td>";
      echo "</tr>";

        foreach($rows as $row){
                echo "<tr>";
                echo "<td>".$row['P#']."</td>";
                echo "<td>".$row['PNAME']."</td>";
                echo "<td>".$row['CNAME']."</td>";
                echo "<td>".$row['SO']."</td>";
                echo "<td>".$row['BB']."</td>";
                echo "<td>".$row['HBP']."</td>";

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
