<?php
// Verificar el acceso
include("../../funciones.php");
verificarAcceso();
// INCLUIR LA BASE DE DATOS
include("../../bd.php");

// TRAER EL ID DEL CURSO SELECCIONADO
if (isset($_GET['idCurso'])) {
    $idCurso = $_GET['idCurso'];

    //SENTENCIA DE LA VISTA
    $sentencia = $conexion->prepare("SELECT a.*, e.id AS idestudiante, CONCAT(e.pnombre, ' ', e.papellido) AS nombre,
                                        CONCAT(c.numero, '°', c.letra) AS curso
                                     FROM atrasos a
                                     INNER JOIN estudiantes e ON e.id = a.idestudiante
                                     INNER JOIN curso c ON c.id = e.idcurso
                                     WHERE c.id = :idCurso");

    $sentencia->bindParam(":idCurso", $idCurso);
    $sentencia->execute();
    $lista_atrasos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Manejar el caso en que no se proporciona un ID de curso válido
    echo "No se ha seleccionado un curso válido.";
    exit(); // Terminar la ejecución del script
}
?>

<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="../../template/script.js"></script>
<h1>LISTA ATRASOS</h1>
<br>
<div class="card">
    <div class="card-header">
    </div>
    <div class="card-body">
        <a href="select.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i>
            Volver</a>
        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Clase</th>
                        <th scope="col">Dia</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Motivo del atraso</th>
                        <th scope="col">rut del estudiante</th>
                        <th scope="col">Nombre estudiante</th>
                        <th scope="col">Curso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_atrasos as $registro) { ?>
                        <tr class="">
                            <td><?php echo $registro['id']; ?></td>
                            <td><?php echo $registro['clase']; ?></td>
                            <td><?php echo $registro['dia']; ?></td>
                            <td><?php echo $registro['hora']; ?></td>
                            <td><?php echo $registro['motivo']; ?></td>
                            <td><?php echo $registro['idestudiante']; ?></td>
                            <td><?php echo $registro['nombre']; ?></td>
                            <td><?php echo $registro['curso']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include("../../template/footer.php"); ?>