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
          <li><input type="button" value="UPDATE" onclick="location.href='../update_Main.php'"></li>
          <li><input type="button" value="SELECT" onclick="location.href='../../select/select_Main.php'"></li>
          <li><input type="button" value="SIMULATION" onclick="location.href='../../../Dong/selclub.php'"></li>
        </ul><hr>
    </nav>
    
    <section>

    <h1>Update</h1>

    <?php
    putenv ("NLS_LANG=AMERICAN_AMERICA.UTF8");
    //putenv("NLS_LANG=AMERICAN_AMERICA.KO16MSWIN949");
    require('../../config/config.php');


    $conn = oci_connect($id,$pw,$server);

    if(!$conn){
            echo "Oricale Connect Error";
            exit();
    }


    $team = $_REQUEST['team'];   //팀 받아옴  C1~c4
    $ph = $_REQUEST['PH'];           //타자 또는 투수라는 것 받아옴 pitcher/hitter
    //var_dump($team);
    //var_dump($ph);
     ?>
     <br>




    <form action="../process/update_process.php" method="post">

      <?php

       if($team=='C1') {            //C1~C4 전송
         echo "<label for='kia'>팀: 기아</label>
         <input type='hidden' id='kia' name='team' value='C1' readonly>";
       }else if($team=='C2'){
         echo "<label for='doosan'>팀: 두산</label>
         <input type='hidden' id='doosan' name='team' value='C2' readonly>";
       }else if($team=='C3'){
         echo "<label for='lotte'>팀: 롯데</label>
         <input type='hidden' id='lotte' name='team' value='C3' readonly>";
       }else if($team=='C4'){
         echo "<label for='nc'>팀: NC</label>
         <input type='hidden' id='nc' name='team' value='C4' readonly>";
       }else
       {
         echo "전송실패";
       }



       if($ph=='pitcher') {

         echo "<label for='pit'> - 투수 </label>
         <input type='hidden' id='hit' name='ph' value='pitcher' 'readonly'>";  //pitcher전송


         echo "<hr>";


         //선수 이름 및번호 전송 시작
         $stmt  = oci_parse($conn, "select P#,PNAME from pitcher where C#='".$team."' order by P#");
         oci_execute($stmt);
         $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);

         echo "<label for='pnn'>선수 이름 및 번호</label>";
         echo "<select id='pnn' name='pnn'>";


         foreach($rows as $row){
           echo "<option value='".$row['PNAME'].",".$row['P#']."'>".$row['PNAME']." - ".$row['P#']."</option>";
         }
         echo "</select>";



       echo "<hr>";





       echo "<p>";
       echo "<label for='so'>삼진</label>";
       echo "<input type='text' id='so' name='so'  required autocomplete=off />";
       echo "</p>";


       echo "<p>";
       echo "<label for='bb'>볼넷</label>";
       echo "<input type='text' id='bb' name='bb' required required autocomplete=off/>";
       echo "</p>";

       echo "<p>";
       echo "<label for='hbp'>사구</label>";
       echo "<input type='text' id='hbp' name='hbp' required required autocomplete=off/>";
       echo "</p>";
       echo "<br/>";

       echo "<input type='submit' value='전송' required />";


       echo "<hr>";


       //전체현황 출력
       $stmt  = oci_parse($conn, "select * from pitcher natural join club where C#='".$team."' order by P#");
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














       }else if($ph=='hitter') {

         echo "<label for='pit'> - 타자 </label>
         <input type='hidden' id='hit' name='ph' value='hitter'>";   //hitter전송

         echo "<hr>";

         //타자 선수이름 및 번호 전송 시작
         $stmt  = oci_parse($conn, "select H#,HNAME from hitter where C#='".$team."' order by H#");
         oci_execute($stmt);
         $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);

         echo "<label for='hnn'>선수 이름 및 번호</label>";
         echo "<select id='hnn' name='hnn'>";
         foreach($rows as $row){
                 echo  "<option value='".$row['HNAME'].",".$row['H#']."'>".$row['HNAME']." - ".$row['H#']."</option>";
         }
         echo "</select>";

         echo "<hr>";

         //타자에대한 투수 이름 및번 호 전송 시작

         $stmt  = oci_parse($conn, "select P#,PNAME,C# from pitcher where C# != '".$team."' order by C#");
         oci_execute($stmt);
         $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);


         echo "<label for='pnn'>상대 투수</label>";
         echo "<select id='pnn' name='pnn'>";

         foreach($rows as $row){
           echo "<option value='".$row['PNAME'].",".$row['P#']."'>".$row['PNAME']." - ".$row['P#'];


           if($row['C#']=='C1'){
             echo " - 기아";
           }else if($row['C#']=='C2'){
             echo " - 두산";
           }else if($row['C#']=='C3'){
             echo " - 롯데";
           }else if($row['C#']=='C4'){
             echo " - 엔씨";
           }else{
             echo "전송실패";
           }


           echo "</option>";
         }
         echo "</select>";


       echo "<hr>";


         echo "<p>";
         echo "<label for='pa'>타석</label>";
         echo "<input type='text' id='pa' name='pa' required required autocomplete=off />";
         echo "</p>";

         echo "<p>";
         echo "<label for='ab'>타수</label>";
         echo "<input type='text' id='ab' name='ab' required required autocomplete=off/>";
         echo "</p>";


         echo "<p>";
         echo "<label for='h'>안타</label>";
         echo "<input type='text' id='h' name='h' required required autocomplete=off/>";
         echo "</p>";


         echo "<p>";
         echo "<label for='b2'>2루타</label>";
         echo "<input type='text' id='b2' name='b2' required required autocomplete=off/>";
         echo "</p>";

         echo "<p>";
         echo "<label for='b3'>3루타</label>";
         echo "<input type='text' id='b3' name='b3' required required autocomplete=off/>";
         echo "</p>";

         echo "<p>";
         echo "<label for='hr'>홈런</label>";
         echo "<input type='text' id='hr' name='hr' required required autocomplete=off/>";
         echo "</p>";

         echo "<p>";
         echo "<label for='go'>뜬공</label>";
         echo "<input type='text' id='go' name='go' required required autocomplete=off/>";
         echo "</p>";

         echo "<p>";
         echo "<label for='ao'>땅볼</label>";
         echo "<input type='text' id='ao' name='ao' required required autocomplete=off/>";
         echo "</p>";


         echo "<br/>";


         echo "<input type='submit' value='전송' required />";






         echo "<hr>";


         //전체현황출력

         $stmt  = oci_parse($conn, "select * from hitter natural join club where C#='".$team."' order by H#");
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
         echo "타자 투수 정보 전송실패";


       }

       ?>

    </form>
    <hr>


    </section>
  </body>
</html>
