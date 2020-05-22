<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="../../../Dong/style.css">
    <title></title>
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
          <li><input type="button" value="DELETE" onclick="location.href='../delete_Main.php'"></li>
          <li><input type="button" value="UPDATE" onclick="location.href='../../update/update_Main.php'"></li>
          <li><input type="button" value="SELECT" onclick="location.href='../../select/select_Main.php'"></li>
          <li><input type="button" value="SIMULATION" onclick="location.href='../../../Dong/selclub.php'"></li>
        </ul><hr>
    </nav>
    
    <section>
    <?php
    putenv ("NLS_LANG=AMERICAN_AMERICA.UTF8");
    //putenv("NLS_LANG=AMERICAN_AMERICA.KO16MSWIN949");
    require('../../config/config.php');


    $conn = oci_connect($id,$pw,$server);

    if(!$conn){
            echo "Oricale Connect Error";
            exit();
    }



    $ph=$_REQUEST['ph']; //투수/타자전송받음
    $team=$_REQUEST['team'];   //팀 전송받음
    //var_dump($team);






    if($ph=='pitcher'){
      $pnn=explode(',',$_REQUEST['pnn']);
      //var_dump($pnn);
      $pname=$pnn[0];  //선수이름
      $pnum=$pnn[1];    //선수 번호

      //$pnn[0]=이름
      //$pnn[1]=번호
      //$pnum=$_REQUEST['pnum'];    //선수번호 전송받음


      $stmt  = oci_parse($conn, "select * from pitcher");  //계정에 쿼리문 장착
      oci_execute($stmt);                                  //이상유무 판별
      $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);  //실행한 쿼리문 기준 테이블정보 가져오기



      //vs테이블의 넘겨받은 P# 삭제
      $stmt = oci_parse($conn, "delete from vs where P#='".$pnum."'");
      oci_execute($stmt);
      oci_commit($stmt);


      //pitcher 테이블의 넘겨받은 P#삭제
      $stmt = oci_parse($conn, "delete from pitcher where PNAME='".$pname."' and P#='".$pnum."'");
      oci_execute($stmt);
      oci_commit($stmt);


      $stmt  = oci_parse($conn, "select * from pitcher natural join club where C#='".$team."'");
      oci_execute($stmt);
      $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);


    if($team=='C1')  {
      echo "기아 - 투수";
    }else if($team=='C2'){
      echo "두산 - 투수";
    }else if($team=='C3'){
      echo "롯데 - 투수";
    }else if($team=='C4'){
      echo "엔씨 - 투수";
    }else{
      echo "전송실패";
    }
    echo "<hr>";


    echo "Record Count : ".$num_rows."<br/>";

    echo "<table width='500' cellpadding='0' cellspacing='0' border='1'>";   //테이블 태그 시작

    echo "<tr>";
    echo "<td>"."선수 이름"."</td>";
    echo "<td>"."선수 번호"."</td>";
    echo "<td>"."구단"."</td>";
    echo "<td>"."삼진"."</td>";
    echo "<td>"."볼넷"."</td>";
    echo "<td>"."사구"."</td>";
    echo "</tr>";

      foreach($rows as $row){
              echo "<tr>";
              echo "<td>".(string)$row['PNAME']."</td>";
              echo "<td>".$row['P#']."</td>";
              echo "<td>".$row['CNAME']."</td>";
              echo "<td>".$row['SO']."</td>";
              echo "<td>".$row['BB']."</td>";
              echo "<td>".$row['HBP']."</td>";
              echo "</tr>";
      }


      echo "</table>";             //테이블 태그 끝

      oci_free_statement($stmt);
      oci_close($conn);

    }else if('hitter'){


      $hnn=explode(',',$_REQUEST['hnn']);
      $hname=$hnn[0];  //선수이름
      $hnum=$hnn[1];    //선수 번호

      //var_dump($hnn);
      echo "<br/>";
        /* test
      //var_dump($so);
      echo "<br/>";
      //var_dump($bb);
      echo "<br/>";
      //var_dump($hbp);
      echo "<br/>";
      */
      /*
      $stmt  = oci_parse($conn, "select * from hitter");  //계정에 쿼리문 장착
      oci_execute($stmt);                                  //이상유무 판별
      $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);  //실행한 쿼리문 기준 테이블정보 가져오기
      */
      /*
      //만약 num_rows가 1보다 작다면~
      if($num_rows<1){
        echo "table created<br/>";

        $stmt = oci_parse($conn, "select * from pitcher");
        oci_execute($stmt);
        $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);
      }*/

      //vs 테이블의 넘겨받은 H#삭제
      $stmt = oci_parse($conn, "delete from vs where H#='".$hnum."'");
      oci_execute($stmt);
      oci_commit($stmt);



      //hitter 테이블의 넘겨받은 H# 삭제
      $stmt = oci_parse($conn, "delete from hitter where HNAME='".$hname."' and H#='".$hnum."'");
      oci_execute($stmt);
      oci_commit($stmt);


      $stmt  = oci_parse($conn, "select * from hitter natural join club where C#='".$team."'");
      oci_execute($stmt);
      $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);


      if($team=='C1')  {
        echo "기아 - 투수";
      }else if($team=='C2'){
        echo "두산 - 투수";
      }else if($team=='C3'){
        echo "롯데 - 투수";
      }else if($team=='C4'){
        echo "엔씨 - 투수";
      }else{
        echo "전송실패";
      }
      echo "<hr>";


    echo "Record Count : ".$num_rows."<br/>";

    echo "<table width='500' cellpadding='0' cellspacing='0' border='1'>";   //테이블 태그 시작

    echo "<tr>";
    echo "<td>"."선수 이름"."</td>";
    echo "<td>"."선수 번호"."</td>";
    echo "<td>"."구단"."</td>";
    echo "<td>"."타석"."</td>";
    echo "<td>"."타수"."</td>";
    echo "<td>"."안타"."</td>";
    echo "<td>"."2루타"."</td>";
    echo "<td>"."3루타"."</td>";
    echo "<td>"."홈런"."</td>";
    echo "<td>"."뜬공"."</td>";
    echo "<td>"."땅볼"."</td>";
    echo "</tr>";

      foreach($rows as $row){
              echo "<tr>";
              echo "<td>".(string)$row['HNAME']."</td>";
              echo "<td>".$row['H#']."</td>";
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


      echo "</table>";             //테이블 태그 끝

      oci_free_statement($stmt);
      oci_close($conn);



    }else {
      echo "전송실패";
    }

    //header('Location: ../../../index.php'); //페이지 이동 나중에 연구

    ?>

    </section>
  </body>
</html>
