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
          <li><input type="button" value="INSERT" onclick="location.href='../insert_Main.php'"></li>
          <li><input type="button" value="DELETE" onclick="location.href='../../delete/delete_Main.php'"></li>
          <li><input type="button" value="UPDATE" onclick="location.href='../../update/update_Main.php'"></li>
          <li><input type="button" value="SELECT" onclick="location.href='../../select/select_Main.php'"></li>
          <li><input type="button" value="SIMULATION" onclick="location.href='../../../Dong/selclub.php'"></li>
        </ul><hr>
    </nav>
    
    <section>
    <h1>Insert</h1>

    <?php   //계정접속
    putenv ("NLS_LANG=AMERICAN_AMERICA.UTF8");
    //putenv("NLS_LANG=AMERICAN_AMERICA.KO16MSWIN949");
    require('../../config/config.php');


    $conn = oci_connect($id,$pw,$server);

    if(!$conn){
            echo "Oricale Connect Error";
            exit();
    }


    $team = $_REQUEST['team'];   //팀 받아옴  C1~c4
    $ph = $_REQUEST['ph'];           //타자 또는 투수라는 것 받아옴 pitcher/hitter


    echo "<hr>";
     ?>


     <?php
     if($ph=='pitcher'){




       echo "<form action='../process/insert_process.php' method='post'>";
       echo "<label for='team'>";  //전송받은 팀별로 현황을 보여줌
       if($team=='C1'){
         echo "기아";
       }else if($team=='C2'){
          echo "두산";
        }else if($team=='C3'){
          echo "롯데";
        }else if($team=='C4'){
          echo "엔씨";
        }else {
          echo "전송실패";
        }
       echo "</label>";
       echo "<input type='hidden' id='team' name='team' value='".$team."' >";


       echo "<label for='ph'>";
       echo " -투수";
       echo "</label>";
       echo "<input type='hidden' id='ph' name='ph' value='".$ph."' >";


       echo "<hr>";


           echo "<p>";
               echo "<label for='pname'>선수이름</label>";
               echo "<input type='text' id='pname' name='pname' required autocomplete=off />";
           echo "</p>";

           echo "<p>";
               echo "<label for='pnum'>선수 번호</label>";
               echo "<input type='text' id='pnum' name='pnum' required autocomplete=off />";
               echo "<br />";
           echo "</p>";

           echo "<p>";
               echo "<label for='so'>삼진</label>";
               echo "<input type='text' id='so' name='so' required autocomplete=off />";
               echo "<br />";
           echo "</p>";

           echo "<p>";
               echo "<label for='bb'>볼넷</label>";
               echo "<input type='text' id='bb' name='bb' required autocomplete=off />";
               echo "<br />";
           echo "</p>";

           echo "<p>";
               echo "<label for='hbp'>사구</label>";
               echo "<input type='text' id='hbp' name='hbp' required autocomplete=off />";
               echo "<br />";
           echo "</p>";



               echo "<br />";

           echo "<input type='submit' value='전송' required />";
       echo "</form>";

     }else if($ph=='hitter'){




       echo "<form action='../process/insert_process.php' method='post'>";
       echo "<label for='team'>";  //전송받은 팀별로 현황을 보여줌
       if($team=='C1'){
         echo "기아";
       }else if($team=='C2'){
          echo "두산";
        }else if($team=='C3'){
          echo "롯데";
        }else if($team=='C4'){
          echo "엔씨";
        }else {
          echo "전송실패";
        }
       echo "</label>";
       echo "<input type='hidden' id='team' name='team' value='".$team."' >";



       echo "<label for='ph'>";
       echo " -타자";
        echo "</label>";
       echo "<input type='hidden' id='ph' name='ph' value='".$ph."' >";


       echo "<hr>";

           echo "<p>";
               echo "<label for='hname'>선수이름</label>";
               echo "<input type='text' id='hname' name='hname' required autocomplete=off />";
           echo "</p>";

           echo "<p>";
               echo "<label for='hnum'>선수 번호</label>";
               echo "<input type='text' id='hnum' name='hnum' required autocomplete=off />";
               echo "<br />";
           echo "</p>";



           echo "<p>";
               echo "<label for='pa'>타석</label>";
               echo "<input type='text' id='pa' name='pa' required autocomplete=off />";
               echo "<br />";
           echo "</p>";

           echo "<p>";
               echo "<label for='ab'>타수</label>";
               echo "<input type='text' id='ab' name='ab' required autocomplete=off />";
               echo "<br />";
           echo "</p>";

           echo "<p>";
               echo "<label for='h'>안타</label>";
               echo "<input type='text' id='h' name='h' required autocomplete=off />";
               echo "<br />";
           echo "</p>";

           echo "<p>";
               echo "<label for='b2'>2루타</label>";
               echo "<input type='text' id='b2' name='b2' required autocomplete=off />";
               echo "<br />";
           echo "</p>";

           echo "<p>";
               echo "<label for='b3'>3루타</label>";
               echo "<input type='text' id='b3' name='b3' required autocomplete=off />";
               echo "<br />";
           echo "</p>";

           echo "<p>";
               echo "<label for='hr'>홈런</label>";
               echo "<input type='text' id='hr' name='hr' required autocomplete=off />";
               echo "<br />";
           echo "</p>";

           echo "<p>";
               echo "<label for='go'>땅볼</label>";
               echo "<input type='text' id='go' name='go' required autocomplete=off />";
               echo "<br />";
           echo "</p>";

           echo "<p>";
               echo "<label for='ao'>뜬공</label>";
               echo "<input type='text' id='ao' name='ao' required autocomplete=off />";
               echo "<br />";
           echo "</p>";

           echo "<br />";


           echo "<input type='submit' value='전송' required />";

       echo "</form>";


     }else{
       echo "전송실패";
     }
      ?>

  </section>
  </body>
</html>
