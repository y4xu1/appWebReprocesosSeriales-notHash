<?php
    
    if ($_SESSION['rol']!=2 && $_SESSION['rol']!=1) {
        echo '<script>//alert("El usuario '.$_SESSION['name'].', no tiene permisos para acceder a esta herramienta");
                      window.location="../../index.html";</script>';
    } else {
        
    }

    $_SESSION['user'];
    $_SESSION['name'];
    $_SESSION['rol'];

    //Reprocesamiento desde formulario
    function btnReproceso() {

        $strOrden = $_POST ['txtOrden'];
        $intConjunto = $_POST ['txtConjunto'];
        $intPosicion = $_POST ['txtPosicion'];
        $intSecuencia = $_POST ['txtSecuencia'];
        $intSugerencia = $_POST ['txtSugerencia'];
        $strItem = $_POST ['txtItem'];

        $cn = new connectionDB;
        $conn = $cn -> connDB();
        $sql = 'UPDATE TWHCHA255120
                SET T$STAT = 3
                WHERE
                    (T$ORNO = \''. $strOrden .'\' AND T$OSET = \''. $intConjunto.'\' AND T$PONO = \''. $intPosicion .'\' AND 
                    T$SEQN = \''. $intSecuencia .'\' AND T$SERN = \''. $intSugerencia .'\' AND T$ITEM LIKE \'%'. $strItem .'%\') AND 
                    (T$STAT = 5)';

        $st = oci_parse($conn, $sql);
        $r = oci_execute($st, OCI_NO_AUTO_COMMIT);
        if (!$r) {
            
            $e = ocierror($st);
            oci_rollback($conn);
            $f = trigger_error(htmlentities($e['message']), E_USER_ERROR);
            echo '<script>alert("error -> '.$f.'");</script>';
        }
        
        $r = oci_commit($conn);
        if (!$r) {
            
            $e = ocierror($conn);
            $f = trigger_error(htmlentities($e['message']), E_USER_ERROR);
            echo '<script>alert("error -> '.$f.'");</script>';
        }

        responsable($strOrden, $intConjunto, $intPosicion, $intSecuencia, $intSugerencia, $strItem);
        echo '<script>alert("Se reprocesó con exito");</script>';

        unset($strOrden, $intConjunto, $intPosicion, $intSecuencia, $intSugerencia, $strItem, $cn, $conn, $sql, $st, $r);
    }

    //Reprocesamiento de las filas seleccionadas por checkBox
    function btnReprocesarSelected() {

        //$i = filas || $j = columnas
        //Definir limites de $i
        $nOrden = 0;
        for ($i=0; $i<=10000; $i++) {
            if(isset($_POST['cb'.$i.'_10'])) {

                $txtOrno = $_POST['txtFil'.$i.'Col1'];
                $txtConjunto = $_POST['txtFil'.$i.'Col2'];
                $txtPosicion = $_POST['txtFil'.$i.'Col3'];
                $txtSecuencia = $_POST['txtFil'.$i.'Col4'];
                $txtSugerencia = $_POST['txtFil'.$i.'Col5'];
                $txtItem = $_POST['txtFil'.$i.'Col6'];

                $cn = $cn = new connectionDB;
                $conn = $cn -> connDB();

                //---------------Tabla: TWHCHA255120---------------
                $sql = 'UPDATE TWHCHA255120
                        SET T$STAT = 3
                        WHERE
                            (T$ORNO = \''.$txtOrno.'\' AND
                            T$OSET = \''.$txtConjunto.'\' AND
                            T$PONO = \''.$txtPosicion.'\' AND
                            T$SEQN = \''.$txtSecuencia.'\' AND
                            T$SERN = \''.$txtSugerencia.'\' AND
                            T$ITEM LIKE \'%'.$txtItem.'%\') AND
                            (T$STAT = 5)';

                $st = oci_parse($conn, $sql);
                $r = oci_execute($st, OCI_NO_AUTO_COMMIT);
                if (!$r) {
                    
                    $e = ocierror($st);
                    oci_rollback($conn);
                    $f = trigger_error(htmlentities($e['message']), E_USER_ERROR);
                    echo '<script>alert("error -> '.$f.'");</script>';
                }

                //---------------Tabla: TWHCHA253120---------------
                $sql2 = 'UPDATE TWHCHA253120
                        SET T$STAT = 3
                        WHERE
                            (T$ORNO = \''.$txtOrno.'\' AND
                            T$OSET = \''.$txtConjunto.'\' AND
                            T$PONO = \''.$txtPosicion.'\' AND
                            T$SEQN = \''.$txtSecuencia.'\' AND
                            T$SERN = \''.$txtSugerencia.'\' AND
                            T$ITEM LIKE \'%'.$txtItem.'%\')';

                $st2 = oci_parse($conn, $sql2);
                $r = oci_execute($st2, OCI_NO_AUTO_COMMIT);
                if (!$r) {
                    
                    $e = ocierror($st2);
                    oci_rollback($conn);
                    $f = trigger_error(htmlentities($e['message']), E_USER_ERROR);
                    echo '<script>alert("error -> '.$f.'");</script>';
                }
                
                
                $r = oci_commit($conn);
                if (!$r) {
                    
                    $e = ocierror($conn);
                    $f = trigger_error(htmlentities($e['message']), E_USER_ERROR);
                    echo '<script>alert("error -> '.$f.'");</script>';
                }
                
                responsable($txtOrno, $txtConjunto, $txtPosicion, $txtSecuencia, $txtSugerencia, $txtItem);
                echo '<script>alert("Se reprocesó con exito", 3000);</script>';
                $nOrden = $nOrden + 1;
                
            }
        }
        if ($nOrden!=0) {
        } else {
            echo '<script>document.getElementById("notSelected").innerHTML="Seleccione una orden para reprocesarla";</script>';
        }
        $nOrden = null;
        unset($conn, $connSql, $txtOrno, $txtConjunto, $txtPosicion, $txtSecuencia, $txtSugerencia, $txtItem, $nOrden, $f, $r, $cn, $sql, $sql2, $e ,$_POST, $st, $st2);
    }

    function responsable($orden, $conjunto, $posicion, $secuencia, $sugerencia, $item) {

        require_once('db/conUserdb.php');
        
        $cnSqlsrv = new connectionDBsqlServer;
        $connSql = $cnSqlsrv -> connDBsqlServer();
        
        $sql = "INSERT INTO info (orden, conjunto, posicion, secuencia, sugerencia, item, userName, fMod)
                VALUES ('$orden', '$conjunto', '$posicion', '$secuencia', '$sugerencia', '$item', '$_SESSION[user]', CURRENT_TIMESTAMP)";

        $st = sqlsrv_query($connSql, $sql);
        
        if ($st) {
            sqlsrv_commit($connSql);
        } else {
            echo '<script>alert("Error");</script>';
            sqlsrv_rollback($connSql);
        }

        unset($orden, $conjunto, $posicion, $secuencia, $sugerencia, $item, $cnSqlsrv, $connSql, $sql, $st);
    }

?>