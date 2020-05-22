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
          <li><input type="button" value="DELETE" onclick="location.href='../delete_Main.php'"></li>
          <li><input type="button" value="UPDATE" onclick="location.href='../../update/update_Main.php'"></li>
          <li><input type="button" value="SELECT" onclick="location.href='../../select/select_Main.php'"></li>
          <li><input type="button" value="SIMULATION" onclick="location.href='../../../Dong/selclub.php'"></li>
        </ul><hr>
    </nav>
    
    <section>
    <h1>Delete</h1>
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



    if($ph=='pitcher'){

      echo "<hr>";

      echo "<form class='' action='../process/delete_process.php' method='post'>";



        echo "<label for='pit'>투수의 이름과 번호를 입력하면 삭제</label>";
        echo "<input type='hidden' id='pit' name='ph' value='pitcher'>";
        echo "<hr>";

        echo "<input type='hidden' id='team' name='team' value='".$team."'>";




       //선수 이름 및번호 전송 시작
       $stmt  = oci_parse($conn, "select P#,PNAME from pitcher where C#='".$team."'");
       oci_execute($stmt);
       $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);

       echo "<label for='pnn'>선수 이름 및 번호</label>";
       echo "<select id='pnn' name='pnn'>";


       foreach($rows as $row){
         echo "<option value='".$row['PNAME'].",".$row['P#']."'>".$row['PNAME']." - ".$row['P#']."</option>";
       }
       echo "</select>";


        echo "<hr>";
        echo "<input type='submit' name='' value='전송하기'>";
      echo "</form>";



      //전체현황 출력


      $stmt  = oci_parse($conn, "select * from pitcher natural join club where C#='".$team."' ");
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





    }else if($ph=='hitter'){


      echo "<form class='' action='../process/delete_process.php' method='post'>";
        echo "<label for='hit'> 타자의 정보를 입력하면 삭제 </label>
        <input type='hidden' id='hit' name='ph' value='hitter' >";   //hitter전송

        //team전송
        echo "<input type='hidden' id='team' name='team' value='".$team."'>";

        echo "<hr>";



       //선수이름 및 번호 전송 시작
       $stmt  = oci_parse($conn, "select H#,HNAME from hitter where C#='".$team."'");
       oci_execute($stmt);
       $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);

       echo "<label for='hnn'>선수 이름 및 번호</label>";
       echo "<select id='hnn' name='hnn'>";
       foreach($rows as $row){
               echo  "<option value='".$row['HNAME'].",".$row['H#']."'>".$row['HNAME']." - ".$row['H#']."</option>";
       }
       echo "</select>";

       echo "<br/>";


        echo "<input type='submit' value='전송' />";

      echo "</form>";




      echo "<hr>";


      //전체현황출력

      $stmt  = oci_parse($conn, "select * from hitter natural join club where C#='".$team."' ");
      oci_execute($stmt);
      $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);


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

     ?>

    <hr>


  </body>
</html>
