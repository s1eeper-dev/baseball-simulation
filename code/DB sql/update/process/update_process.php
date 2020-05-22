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
          <li><input type="button" value="DELETE" onclick="location.href='../../delete/delete_Main.php'"></li>
          <li><input type="button" value="UPDATE" onclick="location.href='../update_Main.php'"></li>
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

    $ph=$_REQUEST['ph'];
    $team=$_REQUEST['team'];




    if($ph=='pitcher') {

      $pnn=explode(',',$_REQUEST['pnn']);
      $pname=$pnn[0];  //선수이름
      $pnum=$pnn[1];    //선수 번호
      $so=$_REQUEST['so'];     //삼진
      $bb=$_REQUEST['bb'];      //볼넷
      $hbp=$_REQUEST['hbp'];    //사구


      $stmt  = oci_parse($conn, "select SO,BB,HBP from pitcher where P# = '".$pnum."'");  //계정에 쿼리문 장착
      oci_execute($stmt);                                  //이상유무 판별
      $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);  //실행한 쿼리문 기준 테이블정보 가져오기


      $Sum_so=0;
      $Sum_bb=0;
      $Sum_hbp=0;


      foreach($rows as $row){
        $Sum_so=($row['SO']+$so);

        $Sum_bb=($row['BB']+$bb);

        $Sum_hbp=($row['HBP']+$hbp);

        }




        $stmt = oci_parse($conn, "update pitcher set SO='".$Sum_so."',BB='".$Sum_bb."',HBP='".$Sum_hbp."' where P#='".$pnum."' and PNAME='".$pname."'");
        oci_execute($stmt);
        oci_commit($stmt);



        $stmt  = oci_parse($conn, "select * from pitcher natural join club where P#='".$pnum."' and PNAME='".$pname."' order by P#");
        oci_execute($stmt);
        $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);


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


        echo "</table>";


          oci_free_statement($stmt);
          oci_close($conn);

    }else if('hitter'){


      $hnn=explode(',',$_REQUEST['hnn']);
      $hname=$hnn[0];  //타자 선수이름
      $hnum=$hnn[1];    //타자 선수 번호
      $pa=$_REQUEST['pa'];    //타석
      $ab=$_REQUEST['ab'];    //타수
      $h=$_REQUEST['h'];    //안타
      $b2=$_REQUEST['b2'];    //2루타
      $b3=$_REQUEST['b3'];    //3루타
      $hr=$_REQUEST['hr'];    //홈런
      $go=$_REQUEST['go'];    //뜬공
      $ao=$_REQUEST['ao'];    //땅볼

      $pnn=explode(',',$_REQUEST['pnn']);
      $pname=$pnn[0];  //상대투수이름           -혹시몰라 전송받음
      $pnum=$pnn[1];    //상대투수선수 번호     -일단 이것만 이용


      $stmt  = oci_parse($conn, "select PA,AB,H,B2,B3,HR,GO,AO from hitter where H# = '".$hnum."'");  //계정에 쿼리문 장착
      oci_execute($stmt);                                  //이상유무 판별
      $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);  //실행한 쿼리문 기준 테이블정보 가져오기


      $Sum_pa=0;
      $Sum_ab=0;
      $Sum_h=0;
      $Sum_b2=0;
      $Sum_b3=0;
      $Sum_hr=0;
      $Sum_go=0;
      $Sum_ao=0;



      foreach($rows as $row){
        $Sum_pa=($row['PA']+$pa);

        $Sum_ab=($row['AB']+$ab);

        $Sum_h=($row['H']+$h);

        $Sum_b2=($row['B2']+$b2);

        $Sum_b3=($row['B3']+$b3);

        $Sum_hr=($row['HR']+$hr);

        $Sum_go=($row['GO']+$go);

        $Sum_ao=($row['AO']+$ao);

        }


        echo "<hr>";
        //히터 업데이트
        $stmt = oci_parse($conn, "update hitter set PA='".$Sum_pa."',AB='".$Sum_ab."',H='".$Sum_h."',B2='".$Sum_b2."',B3='".$Sum_b3."',HR='".$Sum_hr."',GO='".$Sum_go."',AO='".$Sum_ao."' where H#='".$hnum."' and HNAME='".$hname."'");
        oci_execute($stmt);
        oci_commit($stmt);



        //여기서부터 vs

        $stmt  = oci_parse($conn, "select PA,AB,H from vs where H# = '".$hnum."' and P#='".$pnum."'");  //계정에 쿼리문 장착
        oci_execute($stmt);                                  //이상유무 판별
        $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);  //실행한 쿼리문 기준 테이블정보 가져오기


        $Sum_pa_vs = 0;
        $Sum_ab_vs = 0;
        $Sum_h_vs = 0;



        foreach($rows as $row){
          $Sum_pa_vs = ($row['PA']+$pa);

          $Sum_ab_vs=($row['AB']+$ab);

          $Sum_h_vs = ($row['H']+$h);

          }





        //vs테이블- 지정된 투수의 행에 업데이트
        $stmt = oci_parse($conn, "update vs set PA='".$Sum_pa_vs."',AB='".$Sum_ab_vs."',H='".$Sum_h_vs."' where H#='".$hnum."' and P#='".$pnum."'");
        oci_execute($stmt);
        oci_commit($stmt);





        $stmt  = oci_parse($conn, "select * from hitter natural join club where H#='".$hnum."' and HNAME='".$hname."' order by H#");
        oci_execute($stmt);
        $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        echo "투수테이블";
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


          echo "</table>";


          echo "<hr>";


          $stmt  = oci_parse($conn, "select * from vs where H#='".$hnum."' and P#='".$pnum."'");
          oci_execute($stmt);
          $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);


          echo "vs테이블";
          echo "<br/>";
          echo "Record Count : ".$num_rows."<br/>";

          echo "<table width='500' cellpadding='0' cellspacing='0' border='1'>";   //테이블 태그 시작

          echo "<tr>";
          echo "<td>"."투수 번호"."</td>";
          echo "<td>"."타자 번호"."</td>";
          echo "<td>"."타석"."</td>";
          echo "<td>"."타수"."</td>";
          echo "<td>"."안타"."</td>";
          echo "</tr>";

            foreach($rows as $row){
                    echo "<tr>";
                    echo "<td>".$row['P#']."</td>";
                    echo "<td>".$row['H#']."</td>";
                    echo "<td>".$row['PA']."</td>";
                    echo "<td>".$row['AB']."</td>";
                    echo "<td>".$row['H']."</td>";
                    echo "</tr>";
            }


            echo "</table>";


          oci_free_statement($stmt);
          oci_close($conn);




    }else {
      echo "타자 투수정보 전송실패";

    }




    //header('Location: ../../../index.php'); //페이지 이동 나중에 연구

    ?>


    </section>
  </body>
</html>
