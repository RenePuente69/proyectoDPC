<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS
include("../../bd.php");
//FUNCION DE ELIMINAR
if (isset($_GET['txtId'])) {
    $txtID = (isset($_GET['txtId'])) ? $_GET['txtId'] : "";

    $sentencia = $conexion->prepare("DELETE FROM puesto WHERE id=:id");

    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    //Mensaje de eliminar de alert
    $mensaje = "Registro Eliminado";
    header("Location: index.php?mensaje=" . $mensaje);
}

//OBTENER VISTA DE PUESTO EN LA BD
$sentencia = $conexion->prepare("SELECT * FROM puesto");
$sentencia->execute();
$lista_puesto = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="../../template/script.js"></script>

<h1>LISTA DE PUESTO</h1>
<br>
<div class="card">
    <div class="card-header"><a name="" id="" class="btn btn-success" href="crear.php" role="button">
            <i class="fa-solid fa-plus"></i>
            Agregar Nuevo Puesto
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID Puesto</th>
                        <th scope="col">Nombre puesto</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($lista_puesto as $registro) { ?>

                        <tr class="">
                            <td scope="row"><?php echo $registro['id']; ?></td>
                            <td><?php echo $registro['nombrepuesto']; ?></td>
                            <td>
                                <a class="btn btn-primary" href="editar.php?txtId=<?php echo $registro['id']; ?>" role="button">
                                <i class="fa-solid fa-pen-to-square"></i>
                                    Editar
                                </a>

                                <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id']; ?>)" role="button">
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
</div>


<?php include("../../template/footer.php"); ?>