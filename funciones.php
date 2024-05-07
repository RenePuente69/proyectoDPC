<?php
function verificarAcceso() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['logueado']) || ($_SESSION['idpuesto'] != 1)) {
        header("Location: ../../error404.php");
        exit;
    }
}
?>
