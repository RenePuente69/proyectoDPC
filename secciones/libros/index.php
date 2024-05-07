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
    $sentencia = $conexion->prepare("SELECT foto FROM libros WHERE id=:id");
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
    $sentencia = $conexion->prepare("DELETE FROM libros WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    //Mensaje de eliminar de alert
    $mensaje = "Registro Eliminado";
    header("Location: index.php?mensaje=" . $mensaje);
}
//OBTENER VISTA DE PUESTO EN LA BD
$sentencia = $conexion->prepare("SELECT * FROM libros");
$sentencia->execute();
$lista_libros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="../../template/script.js"></script>
<h1>LISTA DE LIBROS</h1>
<br>
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-success" href="crear.php" role="button"><i class="fa-solid fa-plus"></i>
            Agregar nuevo libro
        </a>
        <a name="" id="" class="btn btn-warning" href="arriendo.php" role="button"><i class="fa-solid fa-list"></i>
            Ver arriendos
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
                        <th scope="col">Codigo</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Editorial</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_libros as $registro) { ?>
                        <tr class="">
                            <td><?php echo $registro['id']; ?></td>
                            <td><?php echo $registro['nombre']; ?></td>
                            <td><?php echo $registro['autor']; ?></td>
                            <td><?php echo $registro['editorial']; ?></td>
                            <td> <?php echo $registro['cantidad']; ?></td>
                            <td>
                                <img width="50" src="<?php echo $registro['foto']; ?>" class="img-fluid rounded" alt="" />
                            </td>
                            <td>
                                <a name="" id="" class="btn btn-primary" href="editar.php?txtId=<?php echo $registro['id']; ?>" role="button">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Editar
                                </a>
                                <a name="" id="" class="btn btn-warning" href="prestamos.php?txtId=<?php echo $registro['id']; ?>" role="button">
                                    <i class="fa-solid fa-address-book"></i>
                                    Asignar prestamo
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

