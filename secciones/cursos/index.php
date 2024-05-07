<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS
include("../../bd.php");
//FUNCION DE ELIMINAR
if (isset($_GET['txtId'])) {
    $txtID = (isset($_GET['txtId'])) ? $_GET['txtId'] : "";

    $sentencia = $conexion->prepare("DELETE FROM curso WHERE id=:id");

    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    //Mensaje de eliminar de alert
    $mensaje = "Registro Eliminado";
    header("Location: index.php?mensaje=" . $mensaje);
}

//OBTENER VISTA DE PUESTO EN LA BD
$sentencia = $conexion->prepare("SELECT * FROM curso");
$sentencia->execute();
$lista_cursos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

//OBTENER VISTA DE CANTIDAD DE ALUMNOS POR CURSO
$vistaAlumnosPorCurso = $conexion->prepare("SELECT c.id AS id_curso, CONCAT(c.numero, '°', c.letra) AS curso, COUNT(e.id) AS total_alumnos
                                    FROM curso c
                                    LEFT JOIN estudiantes e ON c.id = e.idcurso
                                    GROUP BY c.id");
$vistaAlumnosPorCurso->execute();
$lista_alumnos_por_curso = $vistaAlumnosPorCurso->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="../../template/script.js"></script>

<h1>LISTA DE CURSOS</h1>
<br>
<div class="card">
    <div class="card-header"><a name="" id="" class="btn btn-success" href="crear.php" role="button">
            <i class="fa-solid fa-plus"></i>
            Agregar nuevo curso
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID Curso</th>
                        <th scope="col">Cursos Inscritos</th>
                        <th scope="col">Cantidad de alumnos</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($lista_cursos as $curso) { ?>
                        <tr>
                            <td><?php echo $curso['id']; ?></td>
                            <td><?php echo $curso['numero'] . '°' . $curso['letra']; ?></td>
                            <td>
                                <?php
                                // Buscar el total de estudiantes por curso en $lista_alumnos_por_curso
                                $total_alumnos_curso = 0;
                                foreach ($lista_alumnos_por_curso as $alumnos_por_curso) {
                                    if ($alumnos_por_curso['id_curso'] == $curso['id']) {
                                        $total_alumnos_curso = $alumnos_por_curso['total_alumnos'];
                                        break;
                                    }
                                }
                                echo $total_alumnos_curso;
                                ?>
                            </td>
                            <td>
                                <a class="btn btn-primary" href="editar.php?txtId=<?php echo $curso['id']; ?>" role="button">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </a>
                                <a class="btn btn-danger" href="javascript:borrar(<?php echo $curso['id']; ?>)" role="button">
                                    <i class="fa-solid fa-trash"></i> Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>


<?php include("../../template/footer.php"); ?>