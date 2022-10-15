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
        <link rel="stylesheet" href="../../style/forms.css">
        <link rel="stylesheet" href="../../style/inputs.css">
        <title>Registrar usuario</title>
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
                <article class="form" id="signUp">
                    <form action="admin/signUp.php" method="post">
                        <center>
                            <div>
                                <h3>Registrar usuarios nuevos</h3>
                                <br>
                                <p>Recuerde que al registrar un usuario, primero<br>
                                    debe estar registrado como un usuario de BAAN
                                </p>
                                <br>
                                <input type="text" class="txt txtSignUp" name="nombreUsuario" id="nombreUsuario" placeholder="Nombre de usuario">
                                <select class="txt txtSignUp" name="rol" id="rol">
                                    <option value="">Seleccione el rol</option>
                                    <option value="2">Administrador</option>
                                    <option value="1">Usuario bajo supervisión</option>
                                </select>
                                <input type="submit" class="btn btnSignUp" name="btnAddUser" id="btnAddUser" value="Registrar usuario">
                            </div>
                        </center>
                    </form>
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
    </body>
</html>