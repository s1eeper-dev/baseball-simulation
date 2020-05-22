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

    $ph = (isset($_POST['ph'])) ? $_POST['ph'] : NULL ;  //투수/타자전송받음
    $team = (isset($_POST['team'])) ? $_POST['team'] : NULL ;


    $pnn = (isset($_POST['pnn'])) ? $_POST['pnn'] : NULL ;
    $pnn = explode(',',$pnn);
    $pname=$pnn[0];  //투수 이름
    $pnum=$pnn[1];    //투수 번호


    $hnn = (isset($_POST['hnn'])) ? $_POST['hnn'] : NULL ;
    $hnn = explode(',',$hnn);
    $hname=$hnn[0];  //타자이름
    $hnum=$hnn[1];    //타자 번호


    if($pnn!=null && hnn!=null){

      $stmt  = oci_parse($conn, " select*from vs where P#='".$pnum."' and H#='".$hnum."'");
      oci_execute($stmt);
      $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);

      echo "<table width='500' cellpadding='0' cellspacing='0' border='1'>";   //테이블 태그 시작


      echo "<tr>";
      echo "<td>"."투수 이름"."</td>";
      echo "<td>"."타자 이름"."</td>";
      echo "<td>"."PA"."</td>";
      echo "<td>"."AB"."</td>";
      echo "<td>"."H"."</td>";
      echo "</tr>";

      foreach($rows as $row){
            echo "<tr>";
            echo "<td>".$pname."</td>";
            echo "<td>".$hname."</td>";
            echo "<td>".$row['PA']."</td>";
            echo "<td>".$row['AB']."</td>";
            echo "<td>".$row['H']."</td>";
            echo "</tr>";
      }
      echo "</table>";
    }






    echo "<form class='' action='select_vs_process.php' method='post'>";

      echo "<input type='hidden' id='team' name='team' value='".$team."'>";


    //전달반은 팀에대한 투수 정보 출력
    $stmt  = oci_parse($conn, "select pitcher.P#, pitcher.PNAME, club.CNAME, pitcher.SO, pitcher.BB, pitcher.HBP from pitcher left join club on pitcher.C#=club.C# where pitcher.C#='".$team."'");
    oci_execute($stmt);
    $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);

    echo "<label for='pnn'>".$team." - 선수 이름 및 번호: </label>".$num_rows."<br/>";
    echo "<select id='pnn' name='pnn'>";


    foreach($rows as $row){
      echo "<option value='".$row['PNAME'].",".$row['P#']."'>".$row['PNAME']." - ".$row['P#']."</option>";
    }
    echo "</select>";


     echo "<hr>";



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


    echo "<hr>";


    //전달반은 팀을 제외한 타자 정보 출력
    $stmt  = oci_parse($conn, "select hitter.H#, hitter.HNAME, club.CNAME, hitter.PA, hitter.AB, hitter.H, hitter.B2, hitter.B3, hitter.HR, hitter.GO, hitter.AO from hitter left join club on hitter.C#=club.C# where hitter.C#!='".$team."'");
    oci_execute($stmt);
    $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);

    echo "<label for='hnn'>상대 타자 이름 및 번호: </label>".$num_rows."<br/>";
    echo "<select id='hnn' name='hnn'>";
    foreach($rows as $row){
            echo  "<option value='".$row['HNAME'].",".$row['H#']."'>".$row['HNAME']." - ".$row['H#']."</option>";
    }
    echo "</select>";
    echo "<br/>";
    echo "<br/>";
     echo "<input type='submit' value='전송' />";
    echo "<br/>";
   echo "</form>";


    echo "<table width='500' cellpadding='0' cellspacing='0' border='1'>";   //테이블 태그 시작

    echo "<tr>";
    echo "<td>"."타자 번호"."</td>";
    echo "<td>"."타자 이름"."</td>";
    echo "<td>"."소속 구단"."</td>";
    echo "<td>"."PA"."</td>";
    echo "<td>"."AB"."</td>";
    echo "<td>"."H"."</td>";
    echo "<td>"."B2"."</td>";
    echo "<td>"."B3"."</td>";
    echo "<td>"."HR"."</td>";
    echo "<td>"."GO"."</td>";
    echo "<td>"."AO"."</td>";
    echo "</tr>";

      foreach($rows as $row){
              echo "<tr>";
              echo "<td>".$row['H#']."</td>";
              echo "<td>".$row['HNAME']."</td>";
              echo "<td>".$row['CNAME']."</td>";
              echo "<td>".$row['PA']."</td>";
              echo "<td>".$row['AB']."</td>";
              echo "<td>".$row['H']."</td>";
              echo "<td>".$row['B2']."</td>";
              echo "<td>".$row['B3']."</td>";
              echo "<td>".$row['HR']."</td>";
              echo "<td>".$row['GO']."</td>";
              echo "<td>".$row['AO']."</td>";

              echo "</tr>";
      }
    echo "</table>";





    oci_free_statement($stmt);
    oci_close($conn);




     ?>

     <hr>



    <section>
  </body>
</html>
