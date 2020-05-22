<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
  </head>
  <body>
    <?php

    putenv ("NLS_LANG=AMERICAN_AMERICA.UTF8");

    $conn = oci_connect("a789029","a789029","203.249.87.162:1521/orcl");

    if(!$conn){
            echo "Oricale Connect Error";
            exit();
    }


    $stmt  = oci_parse($conn, "select * from tt2");
    oci_execute($stmt);

    $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);
    if($num_rows<1){

      $stmt = oci_parse($conn, "create table tt2 (id# int not null, name varchar(50) not null, primary key(id#))");
        oci_execute($stmt);
        oci_commit($conn);

        $stmt = oci_parse($conn, "insert into tt2(id#, name) values (1, 'hong')");
        oci_execute($stmt);
        oci_commit($stmt);

        $stmt = oci_parse($conn, "insert into tt2(id#, name) values(2, 'kim')");
        oci_execute($stmt);
        oci_commit($stmt);

        echo "table created<br/>";

        $stmt = oci_parse($conn, "select * from stadium");
        oci_execute($stmt);
        $num_rows = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);
    }

    $stmt  = oci_parse($conn, "select * from tt2");
    oci_execute($stmt);
    $stmt = oci_parse($conn, "insert into tt2(id#, name) values (3, '45ong')");
    oci_execute($stmt);
    oci_commit($stmt);

    $stmt = oci_parse($conn, "insert into tt2(id#, name) values (4, '535ong')");
    oci_execute($stmt);
    oci_commit($stmt);



    echo "Record Count : ".$num_rows."<br/>";

    echo "<table width='500' cellpadding='0' cellspacing='0' border='1'>";

    foreach($rows as $row){
            echo "<tr>";
            echo "<td>".$row['ID#']."</td>";
            echo "<td>".$row['NAME']."</td>";
            $var1=$row[CL];
            $var2=$row[FH];
            $sum=$var1+$var2;

            echo "<td>".$sum."</td>";
            echo "</tr>";
    }

    echo "</table>";

    oci_free_statement($stmt);
    oci_close($conn);
    ?>


  </body>
</html>
