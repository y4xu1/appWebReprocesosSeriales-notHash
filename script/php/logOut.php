<?php

    session_start();
        $_SESSION['user'];
        $_SESSION['name'];
        $_SESSION['rol'];
    session_destroy();
    echo '<script>window.location="../../index.html";</script>';

?>