<?php

    include('db/conDatadb.php');
    require_once('db/conUserdb.php');
    
    $cnSql = new connectionDBsqlServer;
    $connSql = $cnSql -> connDBsqlServer();

    session_start();

    $cn = new connectionDB;
    $conn = $cn -> connDB();

    $user = $_POST['userName'];
    $_SESSION['user'] = $user;
    $userPss = $_POST['userPss'];
    $params = array($_SESSION['user']);

    $sqlUserName = 'SELECT T$NAME FROM TTTAAD200000 WHERE T$USER = \''.$_SESSION['user'].'\'';
    $stUserName = oci_parse($conn, $sqlUserName);
    $rsUserName = oci_execute($stUserName);
    $rowUserName = oci_fetch_row($stUserName);
    
    $_SESSION['name'] = $rowUserName[0];
    
    if (isset($_POST['btnLog'])) {

        $sql = 'SELECT * FROM TTTAAD200000 WHERE T$USER LIKE \'%'.$_SESSION['user'].'%\'';

        $st = oci_parse($conn, $sql);
        $rs = oci_execute($st);

        $nRow = oci_fetch_all($st, $col);

        if ($_SESSION['user'] == 'yscarden' || $nRow > 0) {

            $sql = "SELECT * FROM users WHERE userName = ?";
            
            $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
            $stQ = sqlsrv_query($connSql, $sql, $params, $options);
            $rCount = sqlsrv_num_rows($stQ);

            if ($rCount === false) {
                echo '<script>alert("Error al contar resultados.");
                        window.location="../../index.html";
                    </script>';
            }
            else {

                if ($rCount > 0) {

                    $sqlStatus = "SELECT status FROM users WHERE userName = ?";
                    $prStatus = sqlsrv_prepare($connSql, $sqlStatus, $params);
                        if(!$prStatus) {
                            die(print_r(sqlsrv_errors(), true));
                        }
                        $exStatus = sqlsrv_execute($prStatus);
                        if (!$exStatus) {
                            die(print_r(sqlsrv_errors(), true));
                        }

                    $statusRow = sqlsrv_fetch_array($prStatus, SQLSRV_FETCH_ASSOC);
                    $status = $statusRow['status'];

                    if ($status != 0) {
                        
                        $sqlPssw = "SELECT pssw FROM users WHERE userName = ?";
                        $pr = sqlsrv_prepare($connSql, $sqlPssw, $params);
                            if(!$pr) {
                                die( print_r(sqlsrv_errors(), true));
                            }
                            $ex = sqlsrv_execute($pr);
                            if (!$ex) {
                                die( print_r(sqlsrv_errors(), true));
                            }

                        $showPssRow = sqlsrv_fetch_array($pr);
                        if ($userPss == $showPssRow['pssw']) {

                            $sqlRol = "SELECT userRol FROM users WHERE userName = ? AND status = '1'";
                            $prRol = sqlsrv_prepare($connSql, $sqlRol, $params);
                                if(!$prRol) {
                                    die(print_r(sqlsrv_errors(), true));
                                }
                                $exRol = sqlsrv_execute($prRol);
                                if (!$exRol) {
                                    die(print_r(sqlsrv_errors(), true));
                                }
        
                            $rolRow = sqlsrv_fetch_array($prRol, SQLSRV_FETCH_ASSOC);
                            $rol = $rolRow['userRol'];
                            $_SESSION['rol'] = $rol;

                            if ($rol != 2) {

                                echo '<script>window.location="cambioEstado.php";//alert("Usuario con permisos bajo supervisión");</script>';
                            } else {
                                echo '<script>window.location="cambioEstado.php";//alert("Usuario administrador");</script>';
                            }
                        } else {
                            echo '<script>alert("Contraseña incorrecta");
                                    window.location="../../index.html"; 
                                </script>';
                        }
                    } else {
                        echo '<script>alert("Su usuario \"'.$_SESSION['user'].'\" se encuentra inactivo.");
                                window.location="../../index.html";
                            </script>';
                    }
                } else {
                    echo '<script>alert("Nombre de usuario incorrecto");
                            window.location="../../index.html"; 
                        </script>';
                }
            }
        } else {
            echo '<script>alert("Usuario no encontrado en BAAN"); 
                    window.location="../../index.html"; 
                </script>';
        }
    }

    if (isset($_POST['btnReg'])) {

        $passw = password_hash('jcasas', PASSWORD_BCRYPT);

        $sql = "INSERT INTO users(userName, pssw, name, ccNumber, status, statusDate, userDate, cusr, userRol)
                VALUES ('jcasas', '$passw', 'Casas Jorge', '123456879', '1', '2023-09-19', '2022-09-19', 'y4xul', '1')";

        $st = sqlsrv_query($connSql, $sql);
        if ($st) {
            echo '<script>alert("Usuario creado");</script>';
            sqlsrv_commit($connSql);
        } else {
            sqlsrv_rollback($connSql);
        }
    }
    
    unset($cnSql, $connSql, $cn, $conn, $user, $userPss, $params, $sqlUserName, $stUserName, $rsUserName, $rowUserName, $sql, $st, $rs, $nRow, $options, $stQ, $rCount,
        $sqlStatus, $prStatus, $exStatus, $statusRow, $status, $sqlPssw, $pr, $showPssRow, $showPassword, $sqlRol, $prRol, $exRol, $rolRow, $rol, $passw);
?>