<?php
session_start();
$url_base = "http://localhost/proyectoDPC/";
if(!isset($_SESSION['usuario'])){
    header("Location:".$url_base."login.php");
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>DPARRAC</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <script src="https://kit.fontawesome.com/d428434f61.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/menu.css">
</head>

<body id="body">
    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>
    </header>

    <div class="menu__side" id="menu_side">

        <div class="name__page">
            <i class="fa-solid fa-landmark"></i>
            <h4>DPARRAC</h4>
        </div>

        <div class="options__menu">

            <a href="<?php echo $url_base; ?>usuarios1/secciones/home.php" class="selected">
                <div class="option">
                    <i class="fas fa-home" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href="<?php echo $url_base; ?>usuarios1/secciones/perfil.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-user" title="Perfil"></i>
                    <h4>Perfil</h4>
                </div>
            </a>

            <a href="<?php echo $url_base; ?>cerrar.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-right-from-bracket" title="Salir"></i>
                    <h4>Cerrar Sessión</h4>
                </div>
            </a>

        </div>

    </div>

<main>

