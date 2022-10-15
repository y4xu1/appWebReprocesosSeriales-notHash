<?php

    session_start();
    $_SESSION['user'];
    $_SESSION['name'];
    $_SESSION['rol'];

    if ($_SESSION['rol']!=2 && $_SESSION['rol']!=1) {
        echo '<script>alert("El usuario '.$_SESSION['name'].', no tiene permisos para acceder a esta herramienta");
                        window.location="cambioEstado.php";</script>';
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
        <!-- <link rel="stylesheet" href="../../style/forms.css"> -->
        <link rel="stylesheet" href="../../style/inputs.css">
        <title>Cambiar contraseña</title>
        <style>
            main article[class="form"] {
                width: 30%;
            }
            #changPss form, #signUp form {
                margin: 35% 0% 64.5% 0%;
            }
            #changPss form div {
                padding: 20px;
                width: 300px;
                border-radius: 8px;box-shadow: 0px 0px 10px gray;
                background: rgba(220, 220, 220, 0.3);
            }
            #changPss form div:hover, #signUp form div:hover {
                background: rgba(255, 255, 255, 0.7);
            }
            #changPss form div h3, #signUp form div h3 {
                margin-top: 15px;
            }
            #changPss form input, #signUp form input {
                display: block;
            }
            #signUp form div {
                padding: 20px;
                width: 400px;
                border-radius: 8px;box-shadow: 0px 0px 10px gray;
                background: rgba(220, 220, 220, 0.3);
            }
            #message {
                margin: 15px 0px 18px 0px;
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
        <main>
            <center>
                <article class="form" id="changPss">
                    <form action="admin/changePss.php" method="post">
                        <center>
                            <div>
                                <h3>Cambiar contraseña</h3>
                                <br>
                                <p>
                                    <?php
                                        if ($_SESSION['rol'] == 2) {
                                            echo 'Únicamente realice un cambio de contraseña cuando un usuario lo haya solicitado.';
                                        } else {
                                            echo 'En caso de no saber su contraseña o no recordarla, comuniquese con los administradores.';
                                        }
                                    ?>
                                </p>
                                <p id="message"></p>
                                <?php
                                    if ($_SESSION['rol'] == 2) {
                                        echo '<input type="text" class="txt txtChangPssw" name="nombreUsuario" id="nombreUsuario" placeholder="Nombre de usuario">';
                                    } else {
                                        echo '<input type="text" class="txt txtChangPssw" name="" id="nombreUsuario" placeholder="Nombre de usuario" value="'.$_SESSION['user'].'" disabled>';
                                        echo '<input type="text" class="txt txtChangPssw" name="nombreUsuario" id="nombreUsuario" placeholder="Nombre de usuario" value="'.$_SESSION['user'].'" style="visibility: hidden; position: absolute;">';
                                    }
                                ?>
                                <?php
                                    if ($_SESSION['rol'] == 2) {
                                    } else {
                                        echo '<input type="password" class="txt txtChangPssw" name="password" id="password" placeholder="Ingrese su contraseña">';
                                    }
                                ?>
                                <input type="password" class="txt txtChangPssw" name="newPassword" id="newPassword" placeholder="Nueva contraseña" onkeyup="btnAct()" onkeydown="btnAct()">
                                <input type="password" class="txt txtChangPssw" name="newPassword2" id="newPassword2" placeholder="Confirme la contraseña" onkeyup="btnAct()" onkeydown="btnAct()">
                                <?php
                                    if ($_SESSION['rol'] == 2) {
                                        echo '<input type="submit" class="btn btnChangPssw" name="btnChangPsswAdmin" id="btnChangPsswAdmin" value="Cambiar contraseña">';
                                    } else {
                                        echo '<input type="submit" class="btn btnChangPssw" name="btnChangPsswUser" id="btnChangPsswUser" value="Cambiar contraseña" >';
                                    }
                                ?>
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
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>

            function btnAct() {

                var pssw = document.getElementById("newPassword");
                var psswVal = pssw.value;
                var pssw2 = document.getElementById("newPassword2");
                var psswVal2 = pssw2.value;
                var btnAdmin = document.getElementById("btnChangPsswAdmin");
                var btn = document.getElementById("btnChangPsswUser");

                document.getElementById("message").style = "font-size: 13px;color: rgb(220, 0, 0);";

                if (psswVal.length >= 8) {
                    var spChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
                    if (spChar.test(psswVal)) {
                        if (psswVal == psswVal2) {
                            document.getElementById("message").style = "color: rgb(0, 150, 0);";
                            document.getElementById("message").innerHTML = "Puede continuar";
                            <?php
                                if ($_SESSION['rol'] == 2) {
                                    echo 'btnAdmin.disabled = false;';
                                } else {
                                    echo 'btn.disabled = false;';
                                }
                            ?>
                        } else {
                            document.getElementById("message").innerHTML = "Las contraseñas no coinciden";
                            <?php
                                if ($_SESSION['rol'] == 2) {
                                    echo 'btnAdmin.disabled = true;';
                                } else {
                                    echo 'btn.disabled = true;';
                                }
                            ?>
                        }
                    } else {
                        document.getElementById("message").innerHTML = "Debe tener al menos un (1) caracter especial";
                        <?php
                            if ($_SESSION['rol'] == 2) {
                                echo 'btnAdmin.disabled = true;';
                            } else {
                                echo 'btn.disabled = true;';
                            }
                        ?>
                    }
                } else {
                    document.getElementById("message").innerHTML = "Debe tener mínimo 8 dígitos";
                    <?php
                        if ($_SESSION['rol'] == 2) {
                            echo 'btnAdmin.disabled = true;';
                        } else {
                            echo 'btn.disabled = true;';
                        }
                    ?>
                }
            }
        </script>
    </body>
</html>