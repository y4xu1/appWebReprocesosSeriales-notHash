<?php

include('../db/conDatadb.php');
include('../db/conUserdb.php');

session_start();

if (isset($_POST['btnAddUser'])) {
    addUser();
}

function addUser() {

    //CONEXION EN BAAN
    $cn = new connectionDB;
    $conn = $cn -> connDB();
    //CONEXION EN SQL SERVER
    $cnSql = new connectionDBsqlServer;
    $connSql = $cnSql -> connDBsqlServer();

    $txtUser = $_POST['nombreUsuario'];
    $year = date("Y");
    $txtPssw = 'ch4_'.$txtUser.'*'.$year.'*';
    $txtRol = $_POST['rol'];
    $_SESSION['user'];

    if ($txtRol != "" || $txtRol != null) {
        
        $sql = 'SELECT * FROM TTTAAD200000 WHERE T$USER LIKE \'%'.$txtUser.'%\'';
    
        $st = oci_parse($conn, $sql);
        $rs = oci_execute($st);

        $nRow = oci_fetch_all($st, $col);

        if ($nRow > 0) {
            
            //Nombre de usuario
            $st2 = oci_parse($conn, $sql);
            oci_execute($st2);
            $row = oci_fetch_array($st2, OCI_ASSOC+OCI_RETURN_NULLS);
            $name = $row['T$NAME'];

            //Cédula de usuario
            $sql = 'SELECT TTGBRG835120.T$DPRT FROM TTGBRG835120 WHERE TTGBRG835120.T$USER LIKE \'%'.$txtUser.'%\'';
            $st2 = oci_parse($conn, $sql);
            oci_execute($st2);
            $row = oci_fetch_array($st2, OCI_ASSOC+OCI_RETURN_NULLS);
            $ccNumber = $row['T$DPRT'];

            if ($ccNumber != "" || $ccNumber != NULL || is_int($ccNumber)) {
            } else {
                $ccNumber = "000";
            }

            if ($_SESSION['rol'] != 2) {
                echo '<script>alert("Usted no tiene permisos para activar usuarios");window.location="../cambioEstado.php"</script>';
            } else {

                $sql = "INSERT INTO users
                            (userName, pssw, name, ccNumber, status, statusDate, userDate, cusr, userRol)
                        VALUES ('$txtUser', '$txtPssw', '$name', '$ccNumber', '1', null, CURRENT_TIMESTAMP, '$_SESSION[user]', '$txtRol')";

                $st = sqlsrv_query($connSql, $sql);
                if ($st) {
                    echo '<script>alert("Usuario creado");window.location="../registro.php";</script>';
                    sqlsrv_commit($connSql);
                } else {
                    echo '<script>alert("Error");window.location="../registro.php";</script>';
                    sqlsrv_rollback($connSql);
                }
            }


        } else {
            echo '<script>alert("Usuario no encotrado en BAAN");window.location="../registro.php";</script>';
        }
    } else {
        echo '<script>alert("Rol no indicado");window.location="../registro.php";</script>';
    }
    unset($cn, $conn, $cnSql, $connSql, $txtUser, $year, $txtPssw, $txtRol, $sql, $st, $rs, $nRow, $st2, $row, $name, $ccNumber, $pssw);
}

?>