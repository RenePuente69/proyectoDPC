<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//FUNCION DE ELIMINAR
if (isset($_GET['txtId'])) {
    $txtID = (isset($_GET['txtId'])) ? $_GET['txtId'] : "";

    //SENTENCIA SQL PARA ELIMINAR REGISTRO
    $sentencia = $conexion->prepare("DELETE FROM estudiantes WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    //Mensaje de eliminar de alert
    $mensaje = "Registro Eliminado";
    header("Location: index.php?mensaje=" . $mensaje);
}
//INCLUIR LA BASE DE DATOS
include("../../bd.php");
//OBTENER VISTA DE PUESTO EN LA BD
$sentencia = $conexion->prepare("SELECT *,
                                    (SELECT CONCAT(numero, '°' ,letra) FROM curso
                                    WHERE curso.id = estudiantes.idcurso LIMIT 1) AS curso_concatenado
                                FROM estudiantes");
$sentencia->execute();
$lista_estudiantes = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="../../template/script.js"></script>
<h1>LISTA DE ESTUDIANTES</h1>
<br>
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-success" href="crear.php" role="button"><i class="fa-solid fa-plus"></i>
            Agregar nuevo estudiante
        </a>
        <a name="" id="" class="btn btn-danger" href="reportesPDF.php" role="button" title="Generar Reporte"><i class="fa-solid fa-file-pdf"></i>
            PDF
        </a>
        <a name="" id="" class="btn btn-success" href="reportesExcel.php" role="button" title="Generar Reporte"><i class="fa-solid fa-file-excel"></i>
            Excel
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">RUT</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Curso</th>
                        <th scope="col">Fecha de ingreso</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_estudiantes as $registro) { ?>
                        <tr class="">
                            <td><?php echo $registro['id']; ?></td>
                            <td><?php echo $registro['pnombre']; ?>
                                <?php echo $registro['snombre']; ?></td>
                            <td><?php echo $registro['papellido']; ?>
                                <?php echo $registro['sapellido']; ?></td>
                            <td><?php echo $registro['direccion']; ?></td>
                            <td><?php echo $registro['telefono']; ?></td>
                            <td><?php echo $registro['curso_concatenado']; ?></td>
                            <td><?php echo $registro['fecha']; ?></td>
                            <td>
                                <a name="" id="" class="btn btn-primary" href="editar.php?txtId=<?php echo $registro['id']; ?>&fecha=<?php echo $registro['fecha']; ?>" role="button">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Editar
                                </a>
                                <a name="" id="" class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id']; ?>)" role="button">
                                    <i class="fa-solid fa-trash"></i>
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include("../../template/footer.php"); ?>