<?php

include('../db/conDatadb.php');
include('../db/conUserdb.php');

session_start();

if (isset($_POST['btnchagStatusSelect'])) {
    changStatus();
} if (isset($_POST['btnchagStatusAct'])) {
    statusAct();
}

function changStatus() {

    if ($_SESSION['rol']!=2) {
        echo '<script>alert("El usuario '.$_SESSION['name'].', no tiene permisos para acceder a esta herramienta");
                        window.location="cambioEstado.php";</script>';
    } else {
        for ($i=0; $i<1000; $i++) {
            if (isset($_POST['cbStatus'.$i])) {
                //CONEXION EN SQL SERVER
                $cnSql = new connectionDBsqlServer;
                $connSql = $cnSql -> connDBsqlServer();
    
                $userName = $_POST['nombreUsuario'.$i];
                $sql = "UPDATE users SET status = 0, statusDate = CURRENT_TIMESTAMP WHERE userName = '$userName'";
                $st = sqlsrv_query($connSql, $sql);
                if ($st) {
                    echo '<script>alert("Usuario inactivado");window.location="../inactivar.php";</script>';
                    sqlsrv_commit($connSql);
                } else {
                    echo '<script>alert("Error");window.location="../inactivar.php";</script>';
                    sqlsrv_rollback($connSql);
                }
            }
        }
    }
    unset($userName, $cnSql, $connSql, $sql, $st, $i);
}

function statusAct() {
    
    if ($_SESSION['rol'] != 2) {
        echo '<script>alert("El usuario '.$_SESSION['name'].', no tiene permisos para acceder a esta herramienta");
                        window.location="cambioEstado.php";</script>';
    } else {
        for ($i=0; $i<1000; $i++) {
            if (isset($_POST['cbStatus'.$i])) {
                //CONEXION EN SQL SERVER
                $cnSql = new connectionDBsqlServer;
                $connSql = $cnSql -> connDBsqlServer();
    
                $userName = $_POST['nombreUsuario'.$i];
                $sql = "UPDATE users SET status = 1, statusDate = NULL, userDate = CURRENT_TIMESTAMP, cusr = '$_SESSION[user]' WHERE userName = '$userName'";
                $st = sqlsrv_query($connSql, $sql);
                if ($st) {
                    echo '<script>alert("Usuario activado");window.location="../inactivar.php";</script>';
                    sqlsrv_commit($connSql);
                } else {
                    echo '<script>alert("Error");window.location="../inactivar.php";</script>';
                    sqlsrv_rollback($connSql);
                }
            }
        }
    }
    unset($userName, $cnSql, $connSql, $sql, $st, $i);
}

?>