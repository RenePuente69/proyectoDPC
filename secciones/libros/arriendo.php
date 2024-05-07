<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS
include("../../bd.php");
// Función para actualizar el estado de los préstamos vencidos
function actualizarEstadoPrestamosVencidos($conexion)
{
    $fecha_actual = date('Y-m-d'); // Obtener la fecha actual en formato YYYY-MM-DD

    $sentencia_actualizar = $conexion->prepare("UPDATE arriendo_libro SET estado = 'EXPIRADO' WHERE fecha_ter < :fecha_actual AND estado != 'EXPIRADO'");
    $sentencia_actualizar->bindParam(':fecha_actual', $fecha_actual);
    $sentencia_actualizar->execute();
}

// Verificar si hay préstamos vencidos y actualizar su estado
actualizarEstadoPrestamosVencidos($conexion);
// Verificar si se ha enviado el formulario para marcar un préstamo como entregado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['marcar_entregado'])) {
    $id_arriendo_entregado = $_POST['id_arriendo'];

    //OBTENER EL ID DEL LIBRO ASOCIADO AL PRESTAMO
    $sentencia_obtener_libro = $conexion->prepare("SELECT idlibro FROM arriendo_libro WHERE id = :id_arriendo");
    $sentencia_obtener_libro->bindParam(':id_arriendo', $id_arriendo_entregado);
    $sentencia_obtener_libro->execute();
    $id_libro = $sentencia_obtener_libro->fetchColumn();

    //ACTUALIZA EL ESTADO A ENTREGADO
    $sentencia_actualizar_estado = $conexion->prepare("UPDATE arriendo_libro SET estado = 'ENTREGADO' WHERE id = :id_arriendo");
    $sentencia_actualizar_estado->bindParam(':id_arriendo', $id_arriendo_entregado);
    $sentencia_actualizar_estado->execute();

    //INCREMENTA EN 1 LA CANTIDAD DE LIBROS
    $sentencia_incrementar_cantidad = $conexion->prepare("UPDATE libros SET cantidad = cantidad + 1 WHERE id = :id_libro");
    $sentencia_incrementar_cantidad->bindParam(':id_libro', $id_libro);
    $sentencia_incrementar_cantidad->execute();

    header("Location: arriendo.php");
    exit(); 
};

//FUNCION DE ELIMINAR
if (isset($_GET['txtId'])) {
    $txtID = (isset($_GET['txtId'])) ? $_GET['txtId'] : "";

    $sentencia = $conexion->prepare("DELETE FROM arriendo_libro WHERE id=:id");

    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    //Mensaje de eliminar de alert
    $mensaje = "Registro Eliminado";
    header("Location: index.php?mensaje=" . $mensaje);
}

//OBTENER VISTA DE PUESTO EN LA BD
$sentencia = $conexion->prepare("SELECT ar.*, CONCAT(e.pnombre, ' ', e.snombre, ' ', e.papellido, ' ', e.sapellido) AS nombre_estudiante, 
                                        l.nombre AS nombre_libro, CONCAT(c.numero, '°', c.letra) AS curso_estudiante
                                 FROM arriendo_libro AS ar
                                 INNER JOIN estudiantes AS e ON ar.idestudiante = e.id
                                 INNER JOIN libros AS l ON ar.idlibro = l.id
                                 INNER JOIN curso AS c ON e.idcurso = c.id");

$sentencia->execute();
$arriendos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$sentencia->execute();
$lista_arriendo = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="../../template/script.js"></script>
<h1>LISTA DE PRESTAMOS</h1>
<br>
<div class="card">
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Libro</th>
                        <th scope="col">Nombre alumno</th>
                        <th scope="col">Curso</th>
                        <th scope="col">Fecha inicio</th>
                        <th scope="col">Fecha termino</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_arriendo as $registro) { ?>
                        <tr class="">
                            <td><?php echo $registro['id']; ?></td>
                            <td><?php echo $registro['nombre_libro']; ?></td>
                            <td><?php echo $registro['nombre_estudiante']; ?></td>
                            <td><?php echo $registro['curso_estudiante']; ?></td>

                            <td><?php echo $registro['fecha_ini']; ?></td>
                            <td><?php echo $registro['fecha_ter']; ?></td>
                            <td><?php echo $registro['estado']; ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="id_arriendo" value="<?php echo $registro['id']; ?>">
                                    <button type="submit" name="marcar_entregado" class="btn btn-success">Entregado</button>
                                </form>
                                <a href="javascript:borrarA(<?php echo $registro['id']; ?>)" class="btn btn-danger" role="button">
                                    <i class="fa-solid fa-trash"></i> Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
        <a href="index.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i>Volver</a>
    </div>

    <?php include("../../template/footer.php"); ?>
    <script>
        function borrarA(id) {
            Swal.fire({
                title: "ADVENTENCIA",
                text: "Verificar si los datos no estan vinculados con empleados y/o usuarios ¿desea continuar?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                cancelButtonText: 'Cancelar',
                confirmButtonText: "Si, borrar"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = "arriendo.php?txtId=" + id;
                }
            });
        }
    </script>
