<?php

    session_start();
    $_SESSION['user'];
    $_SESSION['name'];
    $_SESSION['rol'];

    if ($_SESSION['rol']!=2) {
        echo '<script>alert("El usuario '.$_SESSION['name'].', no tiene permisos para acceder a esta herramienta");
                        window.location="cambioEstado.php";</script>';
    }

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../style/pFormar.css">
        <link rel="stylesheet" href="../../style/userStatus.css">
        <link rel="stylesheet" href="../../style/inputs.css">
        <title>Inactivar usuarios</title>
    </head>
    <body>
        <header>
            <nav class="navigation">
                <center>
                    <div class="imageNav">
                        <img src="../../images/logo_challenger.png" alt="logoChallenger" id="challengerLogo">
                        <div class="menu">
                            <center>
                                <?php
                                    if ($_SESSION['rol'] == 2) {
                                        echo '<a href="cambioEstado.php">Registros de ordenes</a>
                                            <a href="inactivar.php">Inhabilitar usuario</a>
                                            <a href="registro.php">Registrar usuario</a>
                                            <a href="cambiarPssw.php">Cambiar contraseña</a>
                                            <a href="../../manual/Manual de usuario (admin) - Plataforma para el cambio de estado de registro - WMS y BAAN.pdf" download="Manual de usuario">Manual de usuario</a>
                                            ';
                                    } else {
                                        echo '<a href="cambioEstado.php">Registros de ordenes</a>
                                            <a href="cambiarPssw.php">Cambiar contraseña</a>
                                            <a href="../../manual/Manual de usuario - Plataforma para el cambio de estado de registro - WMS y BAAN.pdf" download="Manual de usuario">Manual de usuario</a>';
                                    }
                                ?>
                            </center>
                        </div>
                    </div>
                </center>
                <section class="secLogOut">
                    <article class="artLogOut">
                        <form action="logOut.php" method="post">
                            <acronym title="Cerrar sesión">
                            <acronym title="Cerrar sesión">
                                <button type="submit" name="btnLogOut" id="btnLogOut" class="btnLogOut">
                                    <center>
                                        <img src="../../images/logOut.png" alt="" srcset="" class="imgLogOut">
                                    </center>
                                </button>
                            </acronym>
                        </form>
                    </article>
                </section>
            </nav>
        </header>
        <main>
            <center>
                <article class="form" id="changStatus">
                    <div clas="title">
                        <h1>Inhabilitar usuarios</h1>
                    </div>
                    <br><br>
                    <section id="searcher">
                        <form action="" method="post">
                            <center>
                                <input type="text" class="txt txtChangStatus" name="txtParams" id="txtParams" placeholder="Buscar usuario">
                                <input type="submit" class="btn btnChangStatus" name="btnSeaUser" id="btnSeaUser" value="&#x1f50d">
                                <input type="submit" class="btn btnChangStatus" name="btnLimpiar" id="btnLimpiar" value="Limpiar">
                            </center>
                        </form>
                    </section>
                    <section>
                        <div class="tableScroll">
                            <table>
                                <form action="admin/changStatus.php" method="post">
                                    <div id="btns">
                                        <center>
                                            <input type="submit" class="btn btnChangStatus" name="btnchagStatusSelect" id="btnchagStatusSelect" value="Inactivar los seleccionados">
                                            <input type="submit" class="btn btnChangStatus" name="btnchagStatusAct" id="btnchagStatusAct" value="Activar los seleccionados">
                                        </center>
                                    </div>
                                    <tr>
                                        <th>Cédula</th>
                                        <th>Usuario</th>
                                        <th>Nombre del usuario</th>
                                        <!-- <th>Fecha de creación</th> -->
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                    <?php
                                        userList();
                                    ?>
                                </form>
                            </table>
                        </div>
                    </section>
                </article>
            </center>
        </main>
        <footer>
            <article>
                <section class="cR">
                    <center>
                        <p>©️opyRight 2022 - 2023</p>
                    </center>
                </section>
            </article>
        </footer>
        <script>

        </script>
    </body>
</html>
<?php
function userList() {

    include('db/conUserdb.php');
    $cnSql = new connectionDBsqlServer;
    $connSql = $cnSql -> connDBsqlServer();

    if (isset($_POST['btnSeaUser'])) {
        $strParams = $_POST['txtParams'];
        echo '<script>document.getElementById("txtParams").value="'.$strParams.'";</script>';
    } else {
        $strParams = '';
    }

    $sql = "SELECT ccNumber, userName, name, userRol, status 
            FROM users 
            WHERE userName != '$_SESSION[user]' AND (ccNumber LIKE '%$strParams%' OR userName LIKE '%$strParams%' OR name LIKE '%$strParams%')
            ORDER BY status DESC, userRol ASC, userDate DESC
            OFFSET 0 ROWS FETCH NEXT 500 ROWS ONLY";
        
    $pr = sqlsrv_prepare($connSql, $sql);
        if(!$pr) {
            die(print_r(sqlsrv_errors(), true));
        }
        $ex = sqlsrv_execute($pr);
        if (!$ex) {
            die(print_r(sqlsrv_errors(), true));
        }
    $j = 0;
    while ($row = sqlsrv_fetch_array($pr, SQLSRV_FETCH_NUMERIC)) {

        if ($j%2==0) {
            echo '<tr class="clmImpar">';
        } else {
            echo '<tr class="clmPar">';
        }
            echo '<td><center>'.$row[0].'</center></td>';
            echo '<td class="txtUser"><input type="text" class="txtRowTbl" name="nombreUsuario'.$j.'" id="nombreUsuario'.$j.'" value="'.$row[1].'"></td>';
            echo '<td>'.$row[2].'</td>';
            if ($row[3] != 2) {
                echo '<td><center>Usuario</center></td>';
            } else {
                echo '<td><center>Administrador</center></td>';
            }
            if ($row[4] != 0) {
                echo '<td><center>Activo</center></td>';
            } else {
                echo '<td><center>Inactivo</center></td>';
            }
            echo '<td><center><input type="checkbox" name="cbStatus'.$j.'" id="cbStatus'.$j.'"></center></td>';
        echo '</tr>';

        $j = $j+1;
    }
    unset($cnSql, $connSql, $strParams, $sql, $pr, $j, $row);
}
?>