<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS
include("../../bd.php");
//OBTENER VISTA DE PUESTO EN LA BD
//TRAER EL CODIGO
if (isset($_GET['txtId'])) {
    $txtID = (isset($_GET['txtId'])) ? $_GET['txtId'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM atrasos WHERE id=:id");

    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
}
$sentencia = $conexion->prepare("SELECT * FROM curso");
$sentencia->execute();
$lista_cursos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="../../template/script.js"></script>
<h1>LISTA CURSOS</h1>
<br>
<div class="card">
    <div class="card-header">
    </div>
    <div class="card-body">
    <a href="index.php" class="btn btn-primary"><i class="fa-solid fa-bars"></i>
    Ver lista general de atrasos</a>
        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">Cursos</th>
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_cursos as $registro) { ?>
                        <tr class="">
                            <td><?php echo $registro['numero'] . '°' . $registro['letra']; ?></td>
                            <td>
                                <a class="btn btn-success" href="vista.php?idCurso=<?php echo $registro['id']; ?>"><i class="fa-solid fa-bars"></i>
                                Ver lista de atrasos</a>
                                <a name="" id="" class="btn btn-warning" href="crearAtraso.php?idCurso=<?php echo $registro['id']; ?>" role="button">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Asignar atraso
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include("../../template/footer.php"); ?>