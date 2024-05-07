<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
include("../../bd.php");
// Verificar si el usuario está logueado y tiene el idpuesto adecuado
if (!isset($_SESSION['logueado']) || ($_SESSION['idpuesto'] != 1)) {
    header("Location: login.php");
    exit;
}
//OBTENER VISTA DE CANTIDAD DE USUARIOS, EMPLEADOS Y PUESTO
$vistaEmpleado = $conexion->prepare("SELECT COUNT(*) FROM empleados");
$vistaPuesto = $conexion->prepare("SELECT COUNT(*) FROM puesto");
$vistaUsuarios = $conexion->prepare("SELECT COUNT(*) FROM usuarios");

$vistaEmpleado->execute();
$vistaPuesto->execute();
$vistaUsuarios->execute();

$lista_empleados = $vistaEmpleado->fetchAll(PDO::FETCH_ASSOC);
$lista_puesto = $vistaPuesto->fetchAll(PDO::FETCH_ASSOC);
$lista_usuarios = $vistaUsuarios->fetchAll(PDO::FETCH_ASSOC);

include("../../template/header.php");

?>

<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="../../template/script.js"></script>
<br>
<div class="p-5 mb-4 bg-light rounded-3 d-flex justify-content-center align-items-center">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Sistema de gestión</h1>
        <h2>Estimado usuario: <?php echo $_SESSION['usuario'] ?></h2>
        <p class="col-md-8 fs-4">
            Este panel de control solo puede ser administrado con el permiso del usuario ADMIN.
        </p>

        <ul class="box-info">
            <li>
                <div class="box-icon-container">
                    <box-icon type='solid' name='hard-hat'></box-icon>
                </div>
                <span class="text">
                    <h2>Empleados:</h2>
                    <h3><?php echo $lista_empleados[0]['COUNT(*)']; ?> en total</h3>
                    <a class="btn btn-primary" href="../empleados/crear.php" role="button">Agregar nuevo empleado</a>
                </span>
            </li>
            <li>
                <div class="box-icon-container">
                    <box-icon name='briefcase-alt-2' type='solid' ></box-icon>
                </div>
                <span class="text">
                    <h2>Puestos:</h2>
                    <h3><?php echo $lista_puesto[0]['COUNT(*)']; ?> en total</h3>
                    <a class="btn btn-primary" href="../puesto/crear.php" role="button">Agregar nuevo puesto</a>
                </span>
            </li>
            <li>
                <div class="box-icon-container">
                  <box-icon type='solid' name='user-pin'></box-icon>
                </div>
                <span class="text">
                    <h2>Usuarios:</h2>
                    <h3><?php echo $lista_usuarios[0]['COUNT(*)']; ?> en total</h3>
                    <a class="btn btn-primary" href="../usuarios/crear.php" role="button">Agregar nuevo usuarios</a>
                </span>
            </li>
            <li>
                <div class="box-icon-container">
                    <box-icon type='logo' name='facebook-circle' color='#FFFFFF'></box-icon>
                </div>
                <span class="text">
                    <a class="btn btn-primary" href="https://web.facebook.com/dparrac?locale=es_LA" role="button">Ir a Facebook</a>
                </span>
            </li>
            <li>
                <div class="box-icon-container">
                    <box-icon name='youtube' type='logo' color='#FFFFFF'></box-icon>
                </div>
                <span class="text">
                    <a class="btn btn-danger" href="https://www.youtube.com/@colegiopolivalentedomingop5734" role="button">Ir a canal de Youtube</a>
                </span>
            </li>
            <li>
                <div class="box-icon-container">
                    <box-icon type='solid' name='business' color='#FFFFFF' ></box-icon>
                </div>
                <span class="text">
                    <a class="btn btn-success" href="https://dparrac.cl/" role="button">Ir al sitio web</a>
                </span>
            </li>
        </ul>
    </div>
</div>

<?php include("../../template/footer.php"); ?>