<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS
include("../../bd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_ini = $_POST['fecha_ini'];
    $fecha_ter = $_POST['fecha_ter'];
    $estado = $_POST['estado'];
    $id_libro = $_POST['id'];
    $id_estudiante = $_POST['estudiante'];

    $sentencia = $conexion->prepare("INSERT INTO arriendo_libro (id, fecha_ini, fecha_ter, estado, idlibro, idestudiante) VALUES (NULL, :fecha_ini, :fecha_ter, :estado, :idlibro, :idestudiante)");

    $sentencia->bindParam(':fecha_ini', $fecha_ini);
    $sentencia->bindParam(':fecha_ter', $fecha_ter);
    $sentencia->bindParam(':estado', $estado);
    $sentencia->bindParam(':idlibro', $id_libro);
    $sentencia->bindParam(':idestudiante', $id_estudiante);
    $sentencia->execute();

    // MENSAJE DE CONFIRMACION
    $mensaje = "Registro Agregado";

    // ACTUALIZAR LA CANTIDAD DE LIBROS DISPONIBLES
    $sentencia_actualizar_cantidad = $conexion->prepare("UPDATE libros SET cantidad = cantidad - 1 WHERE id = :id_libro");
    $sentencia_actualizar_cantidad->bindParam(':id_libro', $id_libro);
    $sentencia_actualizar_cantidad->execute();

    header("Location: arriendo.php?mensaje=" . $mensaje);
}
//TRAER EL CODIGO
if (isset($_GET['txtId'])) {
    $txtID = (isset($_GET['txtId'])) ? $_GET['txtId'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM libros WHERE id=:id");

    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $nombre = $registro["nombre"];
}


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
<h1>Asignar préstamos</h1>
<br>

<div class="card">
    <div class="card-header">Datos del solicitante</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="id" class="form-label">Código del libro</label>
                <input type="text" value="<?php echo $txtID; ?>" readonly class="form-control" name="id" id="id" aria-describedby="helpId" required />
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Título</label>
                <input type="text" value="<?php echo $nombre; ?>" readonly class="form-control" name="nombre" id="nombre" aria-describedby="helpId" required />
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
                <label for="estudiante" class="form-label">Seleccione un estudiante</label>
                <select class="form-select" name="estudiante" id="estudiante" required>
                    <option value="">Seleccione un estudiante</option>
                    <?php foreach ($estudiantes as $estudiante) : ?>
                        <option value="<?php echo $estudiante['id']; ?>" data-curso="<?php echo $estudiante['idcurso']; ?>">
                            <?php echo $estudiante['pnombre'] . ' ' . $estudiante['snombre'] . ' ' . $estudiante['papellido'] . ' ' . $estudiante['sapellido']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha_ini" class="form-label">Fecha de inicio</label>
                <input type="date" class="form-control" name="fecha_ini" id="fecha_ini" value="<?php echo $fecha_actual; ?>" readonly required />
            </div>
            <div class="mb-3">
                <label for="fecha_ter" class="form-label">Fecha de término</label>
                <input type="date" class="form-control" name="fecha_ter" id="fecha_ter" required />
            </div>
            <div class="mb-3">
                <input type="hidden" name="estado" id="estado" value="ARRENDADO">
            </div>
            <button type="submit" class="btn btn-success">Asignar prestamo</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>


<script>
    document.getElementById('curso').addEventListener('change', function() {
        var cursoSeleccionado = this.value;
        var estudiantesSelect = document.getElementById('estudiante');

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