<!DOCTYPE html>
<?php
    include('script/php/db/conDatadb.php');
    include('script/php/db/conUserdb.php');

    $sql = 'SELECT * FROM TWHCHA258120';//10 ROWS{OORG, ORNO, OSET, PONO, SEQN SERN, DATE, DESC, REFCNTD, REFCNTU}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        tr, th, td {
            border: 1px solid black;
            
        }
        table {
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>OORG</th>
            <th>ORNO</th>
            <th>OSET</th>
            <th>PONO</th>
            <th>SEQN</th>
            <th>SERN</th>
            <th>DATE</th>
            <th>DESC</th>
            <th>REFCNTD</th>
            <th>REFCNTU</th>
        </tr>
        <!-- < ?php

            $cn = new connectionDB;
            $conn = $cn -> connDB();
            
            $st = oci_parse($conn, $sql);
            #$rs = oci_execute($st,OCI_DEFAULT);
            $rs = oci_execute($st);
            if ($rs) {

                while ($row = oci_fetch_row($st)) {

                    echo '<tr>';
                    for ($i=0; $i<8; $i++) {
                        
                        echo '<td>'.$row[$i].'</td>';
                    }
                    echo '</tr>';
                }
            } else {

                echo '<script> alert("No se puede realizar la consulta");</script>';
            }

        ?> -->
    </table>
    <?php

        $cnSqlSrv = new connectionDBsqlServer;
        $connSqlSrv = $cnSqlSrv -> connDBsqlServer();

        if($connSqlSrv != true) {
            die( print_r( sqlsrv_errors(), true));
        } else {
            echo 'conectado';
        }

        $sql = 'SELECT * FROM info';
        $pr = sqlsrv_prepare($connSqlSrv, $sql);
        if(!$pr) {
            die( print_r( sqlsrv_errors(), true));
        }

        $ex = sqlsrv_execute($pr);
        if (!$ex) {
            die( print_r( sqlsrv_errors(), true));
        }

        while ($row = sqlsrv_fetch_array($pr)) {

            echo '<br>';
            echo '<br>'.$row[0].' | ';
            echo $row[1].' | '.$row[2].' | '.$row[3].' | '.$row[4].' | '.$row[5].' | '.$row[6].' | '.$row[7].' | ';//.$row[8];
            echo '<br>';
        }

        //contar la cantidad de filas
        echo '<br><br><br>';
        $params = array(); $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $prQ = sqlsrv_query($connSqlSrv, $sql, $params, $options);
        $row_count = sqlsrv_num_rows($prQ);
        if ($row_count === false) 
            {echo "Error in retrieveing row count.";}
        else
            {echo 'N°('.$row_count.')';}
        echo '<br><br>';
        
        //sqlsrv_free_stmt($pr)
    ?>
</body>
</html>