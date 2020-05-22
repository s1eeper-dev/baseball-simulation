<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
          <li><input type="button" value="INSERT" onclick="location.href='../insert_Main.php'"></li>
          <li><input type="button" value="DELETE" onclick="location.href='../../delete/delete_Main.php'"></li>
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


    $team=$_REQUEST['team'];        //팀 전송받음
    $ph=$_REQUEST['ph'];       // 투수 타자 전송받음

    /*
    var_dump($team);
    echo "<br/>";
    var_dump($ph);
    echo "<br/>";
    */






    /*
    //만약 num_rows가 1보다 작다면 테이블을 만들겠다~ 정도의 조건문
    $stmt  = oci_parse($conn, "select * from pitcher");  //계정에 쿼리문 장착
    oci_execute($stmt);                                  //이상유무 판별
    $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);  //실행한 쿼리문 기준 테이블정보 가져오기

    if($num_rows<1){
      echo "table created<br/>";

      $stmt = oci_parse($conn, "select * from pitcher");
      oci_execute($stmt);
      $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);
    }*/

    if($ph=='pitcher'){
      $pname=$_REQUEST['pname'];  //선수이름
      $pnum=$_REQUEST['pnum'];    //선수번호 전송받음
      $so=(integer)$_REQUEST['so'];   //삼진
      $bb=(integer)$_REQUEST['bb'];   //볼넷
      $hbp=(integer)$_REQUEST['hbp'];     //사구 전송받음
/*

      var_dump($pname);
      echo "<br/>";
      var_dump($pnum);
      echo "<br/>";
      var_dump($so);
      echo "<br/>";
      var_dump($bb);
      echo "<br/>";
      var_dump($hbp);
      echo "<br/>";
      */

      //투수테이블에 데이터 입력
      $stmt = oci_parse($conn, "insert into PITCHER values ('".$pnum."','".$pname."','".$team."' ,'".$so."', '".$bb."', '".$hbp."')");
      oci_execute($stmt);
      oci_commit($stmt);





      //타자테이블에서 불러오기 시작
      $stmt  = oci_parse($conn, "select * from hitter where C#!='".$team."'");   //투수팀을 제외한 타자 현황보여주기
      oci_execute($stmt);
      $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);   //추가할 행갯수 가져옴.

/*
      $li=array();      // 이런식으로 배열사용가능
      $i=0;
      foreach($rows as $row){
        $li[$i]=$row['H#'];
        $i++;
      }
      print_r($li);
      */



      //저장된 배열만큼 vs테이블에 데이터 입력 P#는 고정 H#이 여러개               -- H#,P#,           --PA,AB,H 속성에는 0을 넣음

      $zero=0;
      foreach($rows as $row){
        $stmt = oci_parse($conn, "insert into VS values ('".$row['H#']."','".$pnum."','".$zero."' ,'".$zero."', '".$zero."')");
        oci_execute($stmt);
        oci_commit($stmt);
      }




      echo "<hr>";






    $stmt  = oci_parse($conn, "select * from pitcher natural join club where C#='".$team."'");   //현황보여주기
    oci_execute($stmt);
    $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);

    echo "투수 정보 현황";
    echo "<br/>";
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

    }else if($ph='hitter'){

      $hname=$_REQUEST['hname'];  //선수이름
      $hnum=$_REQUEST['hnum'];    //선수번호 전송받음
      $pa=(integer)$_REQUEST['pa'];   //타석
      $ab=(integer)$_REQUEST['ab'];   //타수
      $h=(integer)$_REQUEST['h'];   //안타
      $b2=(integer)$_REQUEST['b2'];   //2루타
      $b3=(integer)$_REQUEST['b3'];   //3루타
      $hr=(integer)$_REQUEST['hr'];   //홈런
      $go=(integer)$_REQUEST['go'];   //뜬공
      $ao=(integer)$_REQUEST['ao'];     //땅볼 전송받음
/*
      var_dump($hname);
      echo "<br/>";
      var_dump($hnum);
      echo "<br/>";
      var_dump($pa);
      echo "<br/>";
      var_dump($ab);
      echo "<br/>";
      var_dump($h);
      echo "<br/>";
      var_dump($b2);
      echo "<br/>";
      var_dump($b3);
      echo "<br/>";
      var_dump($hr);
      echo "<br/>";
      var_dump($go);
      echo "<br/>";
      var_dump($ao);
      echo "<br/>";
*/
      //타자 테이블에 데이터 입력
      $stmt = oci_parse($conn, "insert into hitter values ('".$hnum."','".$hname."','".$team."' ,'".$pa."', '".$ab."', '".$h."', '".$b2."', '".$b3."', '".$hr."', '".$go."', '".$ao."')");
      oci_execute($stmt);
      oci_commit($stmt);



      //투수테이블에서 불러오기 시작
      $stmt  = oci_parse($conn, "select * from pitcher natural join club where C#!='".$team."'");   //타자팀을 제외한 투수 현황보여주기
      oci_execute($stmt);
      $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);   //추가할 행갯수 가져옴.



      //저장된 배열만큼 vs테이블에 데이터 입력 H#는 고정 P#이 여러개               -- H#,P#,           --PA,AB,H 속성에는 0을 넣음

      $zero=0;
      foreach($rows as $row){
        $stmt = oci_parse($conn, "insert into VS values ('".$hnum."','".$row['P#']."','".$zero."' ,'".$zero."', '".$zero."')");
        oci_execute($stmt);
        oci_commit($stmt);
      }







    $stmt  = oci_parse($conn, "select * from hitter natural join club where C#='".$team."'");
    oci_execute($stmt);
    $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);

    echo "타자 정보 현황";
    echo "<br/>";
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

    }else{
      echo "전송실패";

    }



    //header('Location: ../../../index.php'); //페이지 이동 나중에 연구

    ?>

  </section>
  </body>
</html>
