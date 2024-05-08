<?php
// Verificar el acceso
include("../../funciones.php");
verificarAcceso();
// Incluir la base de datos
include("../../bd.php");
if ($_POST) {
    // Recolectamos los datos del método POST
    $fecha = (isset($_POST["fecha"]) ? $_POST["fecha"] : "");
    $hora = (isset($_POST["hora"]) ? $_POST["hora"] : "");
    $motivo = (isset($_POST["motivo"]) ? $_POST["motivo"] : "");
    $apoderado = (isset($_POST["apoderado"]) ? $_POST["apoderado"] : "");
    $id_estudiante = (isset($_POST["idestudiante"]) ? $_POST["idestudiante"] : "");

    // Preparamos la inserción de los datos
    $sentencia = $conexion->prepare("INSERT INTO retiros(motivo, fecha, hora, apoderado, idestudiante) 
                                    VALUES (:motivo, :fecha, :hora, :apoderado, :idestudiante)");

    // Asignamos los valores que vienen del POST
    $sentencia->bindParam(":motivo", $motivo);
    $sentencia->bindParam(":fecha", $fecha);
    $sentencia->bindParam(":hora", $hora);
    $sentencia->bindParam(":apoderado", $apoderado);
    $sentencia->bindParam(":idestudiante", $id_estudiante);
    $sentencia->execute();

    // Mensaje de confirmación 
    $mensaje = "Registro Agregado";
    header("Location: indexAtraso.php?mensaje=" . $mensaje);
}
date_default_timezone_set("America/Santiago");
// Obtener la fecha actual
$fecha_actual = date('Y-m-d');
// Obtener la hora actual
$hora_actual = date('H:i');

// Consulta para obtener los cursos
$cursos_query = $conexion->query("SELECT * FROM curso");
$cursos = $cursos_query->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener todos los estudiantes
$estudiantes_query = $conexion->query("SELECT * FROM estudiantes");
$estudiantes = $estudiantes_query->fetchAll(PDO::FETCH_ASSOC);

// Variable para almacenar el curso seleccionado
$curso_seleccionado = isset($_POST['curso']) ? $_POST['curso'] : '';

// Variable para almacenar los estudiantes del curso seleccionado
$estudiantes_curso = [];

// Obtener la fecha actual
$fecha_actual = date('Y-m-d');

if (!empty($curso_seleccionado)) {
    // Consulta para obtener los estudiantes del curso seleccionado
    $estudiantes_query = $conexion->prepare("SELECT * FROM estudiantes WHERE idcurso=:idcurso");
    $estudiantes_query->bindParam(":idcurso", $curso_seleccionado);
    $estudiantes_query->execute();
    $estudiantes_curso = $estudiantes_query->fetchAll(PDO::FETCH_ASSOC);
}
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
                <label for="fecha" class="form-label">Fecha de retiro</label>
                <input type="date" class="form-control" name="fecha" id="fecha" aria-describedby="emailHelpId" value="<?php echo $fecha_actual; ?>" readonly />
            </div>
            <div class="mb-3">
                <label for="hora" class="form-label">Hora de retiro</label>
                <input type="text" class="form-control" name="hora" id="hora" aria-describedby="helpId" value="<?php echo $hora_actual; ?>" readonly/>
            </div>

            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo del retiro</label>
                <input type="text" class="form-control" name="motivo" id="motivo" aria-describedby="helpId" />
            </div>
            <div class="mb-3">
                <label for="apoderado" class="form-label">Apoderado quien lo retira</label>
                <input type="text" class="form-control" name="apoderado" id="apoderado" aria-describedby="helpId" />
            </div>
            <div class="mb-3">
                <label for="curso" class="form-label">Seleccione el curso</label>
                <select class="form-select" name="curso" id="curso" required>
                    <option value="">Seleccione un curso</option>
                    <?php foreach ($cursos as $curso) : ?>
                        <option value="<?php echo $curso['id']; ?>" <?php if ($curso['id'] == $curso_seleccionado) echo 'selected'; ?>><?php echo $curso['numero'] . $curso['letra']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3" id="contenedorEstudiantes" style="display: none;">
                <label for="idestudiante" class="form-label">Seleccione un estudiante</label>
                <select class="form-select" name="idestudiante" id="idestudiante" required>
                    <option value="">Seleccione un estudiante</option>
                    <?php foreach ($estudiantes as $estudiante) : ?>
                        <option value="<?php echo $estudiante['id']; ?>" data-curso="<?php echo $estudiante['idcurso']; ?>">
                            <?php echo $estudiante['pnombre'] . ' ' . $estudiante['snombre'] . ' ' . $estudiante['papellido'] . ' ' . $estudiante['sapellido']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-danger" href="indexAtraso.php" role="button">Cancelar
            </a>
            
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<script>
    document.getElementById('curso').addEventListener('change', function() {
        var cursoSeleccionado = this.value;
        var estudiantesSelect = document.getElementById('idestudiante');

        // Mostrar el contenedor de estudiantes
        document.getElementById('contenedorEstudiantes').style.display = 'block';

        // Filtrar estudiantes correspondientes al curso seleccionado
        var opcionesEstudiantes = estudiantesSelect.options;
        for (var i = 0; i < opcionesEstudiantes.length; i++) {
            var estudiante = opcionesEstudiantes[i];
            if (estudiante.dataset.curso !== cursoSeleccionado && estudiante.value !== '') {
                estudiante.style.display = 'none'; // Ocultar estudiantes de otros cursos
            } else {
                estudiante.style.display = 'block'; // Mostrar estudiantes del curso seleccionado
            }
        }
    });
</script>

<?php include("../../template/footer.php"); ?>