<?php
session_start();
$_SESSION['user'];
$_SESSION['name'];
$_SESSION['rol'];

if ($_SESSION['rol'] != 2 && $_SESSION['rol'] != 1) {
    echo '<script>alert("El usuario \"'.$_SESSION['name'].'\", no tiene permisos para acceder a esta herramienta");
                    window.location="../../index.html";</script>';
} else {
    
}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../style/pFormar.css">
        <link rel="stylesheet" href="../../style/listBusqueda.css">
        <link rel="stylesheet" href="../../style/inputs.css">
        <title>Seriales</title>
        <style>
            #notSelected {
                color: red;
                padding: 16px 6px;
            }
            #selectedRepro {
                position: absolute;
                margin-top: 520px;
            }
        </style>
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
        <br><br>
        <main>
            <div id="logBackground"></div>
            <section class="title">
                <center>
                    <h1>Cambio de estado de registro integrado WMS - BAAN</h1>
                </center>
            </section>
            <section id="contenidoReprocess">
                <center>
                    <article class="formReprocess">
                        <form name="formRe" id="formRe" action="" method="POST">
                            <input type="text" name="txtOrden" class="txt txtReprocess" id="txtOrden" placeholder="ORDEN">
                            <input type="text" name="txtConjunto" class="txt txtReprocess" id="txtConjunto" placeholder="CONJUNTO">
                            <input type="text" name="txtPosicion" class="txt txtReprocess" id="txtPosicion" placeholder="POSICIÓN">
                            <input type="text" name="txtSecuencia" class="txt txtReprocess" id="txtSecuencia" placeholder="SECUENCIA">
                            <input type="text" name="txtSugerencia" class="txt txtReprocess" id="txtSugerencia" placeholder="SUGERENCIA">
                            <input type="text" name="txtItem" class="txt txtReprocess" id="txtItem" placeholder="ARTÍCULO">
                            <input type="submit" name="btnBuscar" class="btn btnReprocess" id="btnBuscar" value="&#x1f50d" onclick="document.formRe.action=''; document.formRe.submit();">
                            <input type="submit" name="btnLimpiar" class="btn btnReprocess" id="btnLimpiar" value="Limpiar" onclick="document.formRe.actio=''; document.formRe.submit();">
                        </form>
                    </article>
                </center>
                <center>
                    <article class="listReprocess">
                        <div class="tableScroll">
                            <table class="listBusqueda">
                                <form name="formReprocess" id="formReprocess" action="" method="post">
                                    <center>
                                        <div id="selectedRepro">
                                            <input type="submit" name="btnReproSel" class="btn btnReprocess" id="btn_ReprocesarSelected" value="Reprocesar lo seleccionado" >
                                            <label for="" id="notSelected" id="mesagge"></label>
                                        </div>
                                    </center>
                                    <tr>
                                        <th id="1">Registro</th>
                                        <th id="2">Orden</th>
                                        <th id="3">Conjunto</th>
                                        <th id="4">Posicion</th>
                                        <th id="5">Secuencia</th>
                                        <th id="6">Sugerencia</th>
                                        <th id="7">Articulo</th>
                                        <th id="8">Estado</th>
                                        <th id="9">Tipo de estado</th>
                                        <th id="10">Descripcion del estado</th>
                                        <th id="11">Selección</th>
                                    </tr>
                                    <div id="showTable">
                                        <?php
                                            include('searcher.php');
                                            if (isset($_POST['btnBuscar'])) {
                                                busquedaSP();
                                            } else {
                                                busquedaSP();
                                            }
                                        ?>
                                    </div>
                                </form>
                            </table>
                        </div>
                    </article>
                </center>
            </section>
        </main>
        <br><br><br>
        <footer>
            <article>
                <section class="cR">
                    <center>
                        <p>©️opyRight 2022 - 2023</p>
                    </center>
                </section>
            </article>
        </footer>
        <?php
        include("./rsQ.php");
        if (isset($_POST['btnReprocess'])) {
            btnReproceso();
        } else if (isset($_POST['btnReproSel'])) {
            btnReprocesarSelected();
        }
        ?>
    </body>
</html>