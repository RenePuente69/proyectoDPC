<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS
include("../../bd.php");
//FUNCION DE ELIMINAR
if (isset($_GET['txtId'])) {
    $txtID = (isset($_GET['txtId'])) ? $_GET['txtId'] : "";

    //BUSCAR LA FOTO QUE SE INGRESO PARA BORRAR
    $sentencia = $conexion->prepare("SELECT foto FROM empleados WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro_foto = $sentencia->fetch(PDO::FETCH_LAZY);

    //BUSCAR REGISTRO SI EXISTE(foto)
    if (isset($registro_foto["foto"]) && $registro_foto["foto"] != "") {
        if (file_exists("./" . $registro_foto["foto"])) {
            unlink("./" . $registro_foto["foto"]);
        }
    }
    /*BUSCAR REGISTRO SI EXISTE(puede servir para curriculum)
    if (isset($registro_foto["foto"]) && $registro_foto["foto"]!="") {
        if (file_exists("./".$registro_foto["foto"])) {
                 unlink("./".$registro_foto["foto"]);
        }
    }*/


    //SENTENCIA SQL PARA ELIMINAR REGISTRO
    $sentencia = $conexion->prepare("DELETE FROM empleados WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    //Mensaje de eliminar de alert
    $mensaje = "Registro Eliminado";
    header("Location: index.php?mensaje=" . $mensaje);
}
//OBTENER VISTA DE PUESTO EN LA BD
$sentencia = $conexion->prepare("SELECT *,
                                    (SELECT nombrepuesto FROM puesto 
                                    WHERE puesto.id = empleados.idpuesto limit 1) as puesto 
                                FROM empleados
                                ORDER BY pnombre");
$sentencia->execute();
$lista_empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../template/header.php"); ?>
    <link rel="stylesheet" href="../../template/estilos.css">
    <link rel="stylesheet" href="../../assets/css/contenido.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="../../template/script.js"></script>
<h1>LISTA EMPLEADO</h1>
<br>
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-success" href="crear.php" role="button"><i class="fa-solid fa-plus"></i>
            Agregar nuevo empleado
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
                        <th scope="col">RUT del Empleado</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Puesto</th>
                        <th scope="col">Fecha de ingreso</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_empleados as $registro) { ?>
                        <tr class="">
                            <td><?php echo $registro['id']; ?></td>
                            <td><?php echo $registro['pnombre']; ?>
                                <?php echo $registro['snombre']; ?></td>
                            <td><?php echo $registro['papellido']; ?>
                                <?php echo $registro['sapellido']; ?></td>
                            <td>
                                <img width="50" src="<?php echo $registro['foto']; ?>" class="img-fluid rounded" alt="" />
                            </td>
                            <td><?php echo $registro['correopersonal']; ?></td>
                            <td><?php echo $registro['telefono']; ?></td>
                            <td><?php echo $registro['puesto']; ?></td>
                            <td><?php echo $registro['fechaingreso']; ?></td>
                            <td>
                                <a name="" id="" class="btn btn-primary" href="editar.php?txtId=<?php echo $registro['id']; ?>&fechaingreso=<?php echo $registro['fechaingreso']; ?>" role="button">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Editar
                                </a>
                                <a name="" id="" class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id']; ?>)" role="button">
                                    <i class="fa-solid fa-trash"></i>
                                    Eliminar
                                </a>
                                <a name="" id="" class="btn btn-success" href="../usuarios/crear.php?txtId=<?php echo $registro['id']; ?>" role="button">
                                    <i class="fa-solid fa-user-plus"></i>
                                    Agregar a usuarios
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include("../../template/footer.php"); ?>