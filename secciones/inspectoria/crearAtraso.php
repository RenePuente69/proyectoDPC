<?php
// Verificar el acceso
include("../../funciones.php");
verificarAcceso();
// Incluir la base de datos
include("../../bd.php");

if ($_POST) {
    // Recolectamos los datos del método POST
    $clase = (isset($_POST["clase"]) ? $_POST["clase"] : "");
    $motivo = (isset($_POST["motivo"]) ? $_POST["motivo"] : "");
    $dia = (isset($_POST["dia"]) ? $_POST["dia"] : "");
    $hora = (isset($_POST["hora"]) ? $_POST["hora"] : "");
    $idEstudiante = (isset($_POST["idEstudiante"]) ? $_POST["idEstudiante"] : "");

    // Preparamos la inserción de los datos
    $sentencia = $conexion->prepare("INSERT INTO atrasos(clase, motivo, dia, hora, idestudiante) VALUES (:clase, :motivo, :dia , :hora, :idEstudiante)");

    // Asignamos los valores que vienen del POST
    $sentencia->bindParam(":clase", $clase);
    $sentencia->bindParam(":motivo", $motivo);
    $sentencia->bindParam(":dia", $dia);
    $sentencia->bindParam(":hora", $hora);
    $sentencia->bindParam(":idEstudiante", $idEstudiante);
    $sentencia->execute();

    // Mensaje de confirmación 
    $mensaje = "Registro Agregado";
    header("Location: index.php?mensaje=" . $mensaje);
}

// Obtener el ID del curso desde la URL
$idCurso = (isset($_GET['idCurso'])) ? $_GET['idCurso'] : null;

// Obtener la lista de estudiantes asociados a ese curso
$sentencia = $conexion->prepare("SELECT * FROM estudiantes WHERE idcurso = :idCurso");
$sentencia->bindParam(":idCurso", $idCurso);
$sentencia->execute();
$lista_estudiantes = $sentencia->fetchAll(PDO::FETCH_ASSOC);

date_default_timezone_set("America/Santiago");
// Obtener la fecha actual
$fecha_actual = date('Y-m-d');
//Obtener la hora actual
$hora_actual = date('H:i');
?>

<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="../../template/script.js"></script>
<h1>AGREGAR ATRASO</h1>
<div class="card">
    <div class="card-header">Ingrese los datos del estudiante</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="clase" class="form-label">Ingrese la clase</label>
                <input type="text" class="form-control" name="clase" id="clase" aria-describedby="helpId" />
            </div>
            <div class="mb-3">
                <label for="dia" class="form-label">Fecha de atraso</label>
                <input type="date" class="form-control" name="dia" id="dia" aria-describedby="emailHelpId" value="<?php echo $fecha_actual; ?>" readonly />
            </div>
            <div class="mb-3">
                <label for="hora" class="form-label">Hora de atraso</label>
                <input type="text" class="form-control" name="hora" id="hora" aria-describedby="helpId" value="<?php echo $hora_actual; ?>" readonly/>
            </div>

            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo del atraso</label>
                <input type="text" class="form-control" name="motivo" id="motivo" aria-describedby="helpId" />
            </div>
            <div class="mb-3">
                <label for="idEstudiante" class="form-label">Seleccione un estudiante</label>
                <select class="form-control" name="idEstudiante" id="idEstudiante">
                    <?php foreach ($lista_estudiantes as $estudiante) { ?>
                        <option value="<?php echo $estudiante['id']; ?>"><?php echo $estudiante['pnombre'] . ' ' . $estudiante['papellido']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-danger" href="select.php" role="button">Cancelar
            </a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../template/footer.php"); ?>