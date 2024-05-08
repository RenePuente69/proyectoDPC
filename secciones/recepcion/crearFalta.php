<?php
include("../../funciones.php");
verificarAcceso();
include("../../bd.php");

if ($_POST) {
    $fecha_ini = isset($_POST["fecha"]) ? $_POST["fecha"] : "";
    $fecha_ter = date('Y-m-d'); // Cambiado para obtener la fecha actual
    $motivo = isset($_POST["motivo"]) ? $_POST["motivo"] : "";
    $evidencia = isset($_FILES["evidencia"]['name']) ? $_FILES["evidencia"]['name'] : "";
    $id_estudiante = isset($_POST["idestudiante"]) ? $_POST["idestudiante"] : "";

    $sentencia = $conexion->prepare("INSERT INTO faltas(motivo, fecha_ini, fecha_ter, evidencia, idestudiante) 
                                    VALUES (:motivo, :fecha_ini , :fecha_ter, :evidencia, :idestudiante)");

    $sentencia->bindParam(":motivo", $motivo);
    $sentencia->bindParam(":fecha_ini", $fecha_ini);
    $sentencia->bindParam(":fecha_ter", $fecha_ter); 
    $sentencia->bindParam(":idestudiante", $id_estudiante);

    // Se verifica si se ha enviado una evidencia
    if (!empty($evidencia)) {
        $fecha_foto = new DateTime();
        $nombre_foto = $fecha_foto->getTimestamp() . "_" . $_FILES["evidencia"]['name'];
        $tmp_foto = $_FILES["evidencia"]['tmp_name'];
        move_uploaded_file($tmp_foto, "./" . $nombre_foto);
    } else {
        $nombre_foto = ""; 
    }

    $sentencia->bindParam(":evidencia", $nombre_foto);
    $sentencia->execute();

    $mensaje = "Registro Agregado";
    header("Location: indexFalta.php?mensaje=" . $mensaje);
}

$cursos_query = $conexion->query("SELECT * FROM curso");
$cursos = $cursos_query->fetchAll(PDO::FETCH_ASSOC);

$estudiantes_query = $conexion->query("SELECT * FROM estudiantes");
$estudiantes = $estudiantes_query->fetchAll(PDO::FETCH_ASSOC);

$curso_seleccionado = isset($_POST['curso']) ? $_POST['curso'] : '';

$estudiantes_curso = [];

$fecha_actual = date('Y-m-d');

if (!empty($curso_seleccionado)) {
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
                <label for="fecha" class="form-label">Ingresar fecha de la falta</label>
                <input type="date" class="form-control" name="fecha" id="fecha" aria-describedby="emailHelpId" />
            </div>
            <div class="mb-3">
                <label for="fecha_ter" class="form-label">Fecha de regreso</label>
                <input type="text" class="form-control" name="fecha_ter" id="fecha_ter" aria-describedby="helpId" value="<?php echo $fecha_actual; ?>" readonly/>
            </div>
            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo de la falta</label>
                <input type="text" class="form-control" name="motivo" id="motivo" aria-describedby="helpId" />
            </div>
            <div class="mb-3">
                <label for="evidencia" class="form-label">Evidencia</label>
                <input type="file" class="form-control" name="evidencia" id="evidencia" aria-describedby="helpId" />
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
            <a name="" id="" class="btn btn-danger" href="indexFalta.php" role="button">Cancelar
            </a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<script>
    document.getElementById('curso').addEventListener('change', function() {
        var cursoSeleccionado = this.value;
        var estudiantesSelect = document.getElementById('idestudiante');

        document.getElementById('contenedorEstudiantes').style.display = 'block';

        var opcionesEstudiantes = estudiantesSelect.options;
        for (var i = 0; i < opcionesEstudiantes.length; i++) {
            var estudiante = opcionesEstudiantes[i];
            if (estudiante.dataset.curso !== cursoSeleccionado && estudiante.value !== '') {
                estudiante.style.display = 'none';
            } else {
                estudiante.style.display = 'block';
            }
        }
    });
</script>
<?php include("../../template/footer.php"); ?>
