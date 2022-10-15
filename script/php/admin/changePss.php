<?php

include('../db/conDatadb.php');
include('../db/conUserdb.php');

session_start();

if (isset($_POST['btnChangPsswAdmin'])) {
    btnChangPsswAdmin();
}
if (isset($_POST['btnChangPsswUser'])) {
    btnChangPsswUser();
}

    //función para cambiar la contraseña sin necesidad de la contraseña
    function btnChangPsswAdmin() {

        //CONEXION EN BAAN
        $cn = new connectionDB;
        $conn = $cn -> connDB();
        //CONEXION EN SQL SERVER
        $cnSql = new connectionDBsqlServer;
        $connSql = $cnSql -> connDBsqlServer();

        $_SESSION['user'];
        $txtUser = $_POST['nombreUsuario'];
        $txtNewPssw = $_POST['newPassword'];
        $txtNewPssw2 = $_POST['newPassword2'];

        if ($txtNewPssw != $txtNewPssw2 || (($txtNewPssw == '' || $txtNewPssw == NULL) || ($txtNewPssw2 == '' || $txtNewPssw2 = NULL))) {
            echo '<script>window.location="../cambiarPssw.php";alert("Verifique los datos registrados");</script>';
        } else {

            $sql = 'SELECT * FROM TTTAAD200000 WHERE T$USER LIKE \'%'.$txtUser.'%\'';

            $st = oci_parse($conn, $sql);
            $rs = oci_execute($st);

            $nRow = oci_fetch_all($st, $col);

            if ($nRow != 0) {

                $sql = "SELECT * FROM users WHERE userName = ?";
                $params = array($txtUser);
                
                $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                $stQ = sqlsrv_query($connSql, $sql, $params, $options);
                $rCount = sqlsrv_num_rows($stQ);

                if ($rCount === false) {
                    echo '<script>alert("Error al encontrar resultados.");window.location="../cambiarPssw.php";</script>';
                } else {

                    if ($rCount > 0) {

                        $sql = "UPDATE users SET pssw = '".$txtNewPssw."' WHERE userName = '".$txtUser."'";

                        $st = sqlsrv_query($connSql, $sql);
                        if ($st) {
                            echo '<script>alert("Se logró cambiar la contraseña");window.location="../cambiarPssw.php";</script>';
                            sqlsrv_commit($connSql);
                        } else {
                            echo '<script>alert("Error");//window.location="../cambiarPssw.php";</script>';
                            sqlsrv_rollback($connSql);
                        }
                    } else {
                        echo '<script>alert("Nombre de usuario incorrecto");
                                window.location="../cambiarPssw.php"; 
                            </script>';
                    }
                }

            } else {
                echo '<script>window.location="../cambiarPssw.php";alert("Usuario no existente en BAAN");</script>';
            }
        }
        unset($cn, $conn, $cnSql, $connSql, $txtUser, $txtNewPssw, $txtNewPssw2, $sql, $st, $rs, $nRow, $params, $options, $stQ, $rCount, $newPssw);
    }

    //función para cambiar la contraseña nesecitando su usuario y contraseña
    function btnChangPsswUser() {
        //CONEXION EN BAAN
        $cn = new connectionDB;
        $conn = $cn -> connDB();
        //CONEXION EN SQL SERVER
        $cnSql = new connectionDBsqlServer;
        $connSql = $cnSql -> connDBsqlServer();

        $_SESSION['user'];
        $txtUser = $_POST['nombreUsuario'];
        $txtPssw = $_POST['password'];
        $txtNewPssw = $_POST['newPassword'];
        $txtNewPssw2 = $_POST['newPassword2'];

        if ($txtNewPssw != $txtNewPssw2 || (($txtNewPssw == '' || $txtNewPssw == NULL) || ($txtNewPssw2 == '' || $txtNewPssw2 = NULL))) {
            echo '<script>window.location="../cambiarPssw.php";alert("Verifique los datos registrados");</script>';
        } else {

            $sql = 'SELECT * FROM TTGBRG835120 WHERE T$USER LIKE \'%'.$_SESSION['user'].'%\'';

            $st = oci_parse($conn, $sql);
            $rs = oci_execute($st);

            $nRow = oci_fetch_all($st, $col);

            if ($nRow != 0) {

                $sql = "SELECT * FROM users WHERE userName = ?";
                $params = array($txtUser);
                
                $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                $stQ = sqlsrv_query($connSql, $sql, $params, $options);
                $rCount = sqlsrv_num_rows($stQ);

                if ($rCount === false) {
                    echo '<script>alert("Error al contar resultados.");window.location="../cambiarPssw.php";</script>';
                } else {

                    if ($rCount > 0) {

                        $sqlPssw = "SELECT pssw FROM users WHERE userName = '$txtUser'";
                        $pr = sqlsrv_prepare($connSql, $sqlPssw);
                            if(!$pr) {
                                die( print_r(sqlsrv_errors(), true));
                            }
                            $ex = sqlsrv_execute($pr);
                            if (!$ex) {
                                die( print_r(sqlsrv_errors(), true));
                            }

                        $showPssRow = sqlsrv_fetch_array($pr);

                        if ($txtPssw == $showPssRow['pssw']) {

                            $sql = "UPDATE users SET pssw = '".$txtNewPssw."' WHERE userName = '".$txtUser."'";

                            $st = sqlsrv_query($connSql, $sql);
                            if ($st) {
                                echo '<script>alert("Se logró cambiar la contraseña, por favor inicie sesión");window.location="../../../index.html";</script>';
                                sqlsrv_commit($connSql);
                            } else {
                                echo '<script>alert("Error");window.location="../cambiarPssw.php";</script>';
                                sqlsrv_rollback($connSql);
                            }
                        } else {
                            echo '<script>window.location="../cambiarPssw.php";alert("Contraseña incorrecta");</script>';

                        }

                    } else {
                        echo '<script>alert("Nombre de usuario incorrecto");
                                window.location="../cambiarPssw.php"; 
                            </script>';
                    }
                }

            } else {
                echo '<script>window.location="../cambiarPssw.php";alert("Usuario no existe en BAAN");</script>';
            }
        }
        unset($cn, $conn, $cnSql, $connSql, $txtUser, $txtNewPssw, $txtNewPssw2, $sql, $st, $rs, $nRow, $params, $options, $stQ, $rCount, $newPssw, $sqlPssw, $showPssRow, $showPassword);
    }

?>