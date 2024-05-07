<?php
//include("funciones.php");
//verificarAcceso();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$url_base = "http://localhost/proyectoDPC/";
if (!isset($_SESSION['usuario'])) {
    header("Location:" . $url_base . "login.php");
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Panel de Control</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!--Instalacion de los filtros para las tablas-->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <!--Instalacion de alertas-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--Hoja de estilos-->
    <!-- BOX ICONS -->
    <script src="https://kit.fontawesome.com/d428434f61.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/d428434f61.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estilos.css">
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

            <a href="<?php echo $url_base; ?>secciones/home/index.php" class="selected">
                <div class="option">
                    <i class="fas fa-home" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href="<?php echo $url_base; ?>secciones/empleados/">
                <div class="option">
                    <i class="fa-solid fa-user-tie" title="Empleados"></i>
                    <h4>Empleados</h4>
                </div>
            </a>
            <a href="<?php echo $url_base; ?>secciones/puesto/">
                <div class="option">
                    <i class="fa-solid fa-briefcase" title="Puestos"></i>
                    <h4>Puestos</h4>
                </div>
            </a>
            <a href="<?php echo $url_base; ?>secciones/usuarios/">
                <div class="option">
                    <i class="fa-solid fa-circle-user" title="Usuarios"></i>
                    <h4>Usuarios</h4>
                </div>
            </a>
            <a href="<?php echo $url_base; ?>secciones/inspectoria/select.php">
                <div class="option">
                    <i class="fa-solid fa-user-shield" title="Inspectoría"></i>
                    <h4>Inspectoría</h4>
                </div>
            </a>
            <a href="<?php echo $url_base; ?>secciones/noticias/">
                <div class="option">
                    <i class="fa-solid fa-newspaper" title="Noticias"></i>
                    <h4>Noticias</h4>
                </div>
            </a>
            <a href="<?php echo $url_base; ?>secciones/estudiantes/">
                <div class="option">
                    <i class="fa-solid fa-graduation-cap" title="Estudiantes"></i>
                    <h4>Estudiantes</h4>
                </div>
            </a>
            <a href="<?php echo $url_base; ?>secciones/cursos/">
                <div class="option">
                    <i class="fa-brands fa-readme" title="Cursos"></i>
                    <h4>Cursos</h4>
                </div>
            </a>
            <a href="<?php echo $url_base; ?>secciones/libros/">
                <div class="option">
                    <i class="fa-solid fa-book" title="Libros"></i>
                    <h4>Libros</h4>
                </div>
            </a>
            <a href="<?php echo $url_base; ?>secciones/recepcion/home.php">
                <div class="option">
                    <i class="fa-solid fa-door-closed" title="Recepción"></i>
                    <h4>Recepción</h4>
                </div>
            </a>
            <!--<a href="secciones/acercade.php">
                <div class="option">
                    <i class="fa-solid fa-question" title="Acerca de"></i>
                    <h4>Acerca de</h4>
                </div>
            </a>-->

            <a href="javascript:salir()">
                <div class="option">
                    <i class="fa-solid fa-right-from-bracket" title="Salir"></i>
                    <h4>Cerrar Sesión</h4>
                </div>
            </a>

        </div>

    </div>

    <main class="container">
        <!--Alerta de confirmacion-->
        <?php if (isset($_GET['mensaje'])) { ?>
            <script>
                Swal.fire({
                    icon: "success",
                    title: "<?php echo $_GET['mensaje']; ?>"
                });
            </script>
        <?php } ?>