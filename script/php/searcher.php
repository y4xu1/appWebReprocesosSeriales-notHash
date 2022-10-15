<?php

if ($_SESSION['rol']!=2 && $_SESSION['rol']!=1) {
    echo '<script>alert("El usuario '.$_SESSION['name'].', no tiene permisos para acceder a esta herramienta");
                    window.location="../../index.html";</script>';
} else {
    
}

include('db/conDatadb.php');

    //Listar tabla de resultado de Errores
    function busquedaSP() {

        if (isset($_POST['btnBuscar'])) {
            $strOrden = $_POST['txtOrden'];
            $intConjunto = $_POST['txtConjunto'];
            $intPosicion = $_POST['txtPosicion'];
            $intSecuencia = $_POST['txtSecuencia'];
            $intSugerencia = $_POST['txtSugerencia'];
            $strItem = $_POST['txtItem'];

            echo '<script>document.getElementById("txtOrden").value="'.$strOrden.'";</script>';
            echo '<script>document.getElementById("txtConjunto").value="'.$intConjunto.'";</script>';
            echo '<script>document.getElementById("txtPosicion").value="'.$intPosicion.'";</script>';
            echo '<script>document.getElementById("txtSecuencia").value="'.$intSecuencia.'";</script>';
            echo '<script>document.getElementById("txtSugerencia").value="'.$intSugerencia.'";</script>';
            echo '<script>document.getElementById("txtItem").value="'.$strItem.'";</script>';
        } else {
            $strOrden = '';
            $intConjunto = '';
            $intPosicion = '';
            $intSecuencia = '';
            $intSugerencia = '';
            $strItem = '';
        }

        $cn = new connectionDB;
        $conn = $cn -> connDB();
        $sql = 'SELECT 
                    ROW_NUMBER() OVER(ORDER BY T$FMOV DESC), TWHCHA255120.T$ORNO, TWHCHA255120.T$OSET, TWHCHA255120.T$PONO, TWHCHA255120.T$SEQN, TWHCHA255120.T$SERN, TWHCHA255120.T$ITEM, TWHCHA255120.T$STAT, TWHCHA255120.T$DESC,
                    TWHCHA258120.T$DESC 
                FROM 
                    TWHCHA255120, TWHCHA258120
                WHERE 
                    (TWHCHA255120.T$OORG = 1 OR TWHCHA255120.T$OORG = 22) AND 
                    (TWHCHA255120.T$ORNO LIKE \'%'. $strOrden .'%\' AND TWHCHA255120.T$OSET LIKE \'%'. $intConjunto .'%\' AND TWHCHA255120.T$PONO LIKE \'%'. $intPosicion .'%\' AND TWHCHA255120.T$SEQN LIKE \'%'. $intSecuencia .'%\' AND TWHCHA255120.T$SERN LIKE \'%'. $intSugerencia .'%\' AND TWHCHA255120.T$ITEM LIKE \'%'. $strItem .'%\') AND 
                    (TWHCHA255120.T$ORNO = TWHCHA258120.T$ORNO AND TWHCHA255120.T$OSET = TWHCHA258120.T$OSET AND TWHCHA255120.T$PONO = TWHCHA258120.T$PONO AND TWHCHA255120.T$SERN = TWHCHA258120.T$SERN) AND 
                    (TWHCHA255120.T$STAT = 5) AND
                    ROWNUM <= 500
                ORDER BY TWHCHA255120.T$FMOV DESC';

        $st = oci_parse($conn, $sql);
        $rs = oci_execute($st);

        if ($rs) {
            
            //$i = filas || $j = columnas
            $i = 0;
            while ($row = oci_fetch_row($st)) {
                
                if ($i%2==0) { $n = 'Impar'; } else { $n= 'Par'; }
                echo '<tr class="col'.$n.'">';
                for ($j=0; $j<10; $j++) {
                    echo '<td><input type="text" name="txtFil'.$i.'Col'.$j.'" class="txtRowTbl clm'.$j.'" id="txtFil'.$i.'Col'.$j.'" value="'.$row[$j].'"></td>';
                }
                    echo '<td><center><input type="checkbox" name="cb'.$i.'_'.$j.'" class="cbRowTbl" id="cb'.$i.'-'.$j.'"></center></td>';
                echo '</tr>';
                
                $i = $i+1;
            }
        }
        unset($strOrden, $intConjunto, $intPosicion, $intSecuencia, $intSugerencia, $strItem, $cn, $conn, $sql, $st, $rs, $i, $row, $j);
    }

    //función de búsqueda a tiempo real (en proceso)
    function buscarSP() {
        
        $cn = new connectionDB;
        $conn = $cn -> connDB();

        if (isset($_POST['txtOrden'])) {
            $q = $_POST['txtOrden'];
            $sql = 'SELECT 
                    ROW_NUMBER() OVER(ORDER BY T$FMOV DESC), TWHCHA255120.T$ORNO, TWHCHA255120.T$OSET, TWHCHA255120.T$PONO, TWHCHA255120.T$SEQN, TWHCHA255120.T$SERN, TWHCHA255120.T$ITEM, TWHCHA255120.T$STAT, TWHCHA255120.T$DESC,
                    TWHCHA258120.T$DESC 
                FROM 
                    TWHCHA255120, TWHCHA258120, TWHCHA253120 
                WHERE 
                    (TWHCHA255120.T$OORG = 1 OR TWHCHA255120.T$OORG = 22) AND 
                    (TWHCHA255120.T$ORNO LIKE \'%'. $q .'%\' AND TWHCHA255120.T$OSET LIKE \'%'.'%\' AND TWHCHA255120.T$PONO LIKE \'%'.'%\' AND TWHCHA255120.T$SEQN LIKE \'%'.'%\' AND TWHCHA255120.T$SERN LIKE \'%'.'%\' AND TWHCHA255120.T$ITEM LIKE \'%'.'%\') AND 
                    (TWHCHA255120.T$ORNO = TWHCHA253120.T$ORNO AND TWHCHA255120.T$OSET = TWHCHA253120.T$OSET AND TWHCHA255120.T$PONO = TWHCHA253120.T$PONO AND TWHCHA255120.T$SERN = TWHCHA253120.T$SERN) AND
                    (TWHCHA255120.T$ORNO = TWHCHA258120.T$ORNO AND TWHCHA255120.T$OSET = TWHCHA258120.T$OSET AND TWHCHA255120.T$PONO = TWHCHA258120.T$PONO AND TWHCHA255120.T$SERN = TWHCHA258120.T$SERN) AND 
                    (TWHCHA255120.T$STAT = 5 OR TWHCHA255120.T$DESC LIKE \'%Error%\')
                ORDER BY TWHCHA255120.T$FMOV DESC';

            $st = oci_parse($conn, $sql);
            $rs = oci_execute($st);
            if ($rs) {
                $j = 1;

                while ($row = oci_fetch_row($st)) {
                    echo '<tr>';

                    for ($i=0; $i<10; $i++) {
                        echo '<td>'.$row[$i].'</td>';
                    }
                        echo '<td><center><input type="checkbox" name="selected" class="selected" id="selected'.$i.'"></center></td>';
                    echo '</tr>';
                }
            }
        } else {
            echo '<script>alert("No se encontraron coincidencias con la busqueda");</script>';
        }
        unset($strOrden, $intConjunto, $intPosicion, $intSecuencia, $intSugerencia, $strItem, $cn, $conn, $sql, $st, $rs, $i, $row, $j, $q);
    }
?>