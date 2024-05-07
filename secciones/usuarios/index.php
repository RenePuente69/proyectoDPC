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
    $sentencia = $conexion->prepare("SELECT foto FROM usuarios WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro_foto = $sentencia->fetch(PDO::FETCH_LAZY);
    //BUSCAR REGISTRO SI EXISTE(foto)
    if (isset($registro_foto["foto"]) && $registro_foto["foto"] != "") {
        if (file_exists("./" . $registro_foto["foto"])) {
            unlink("./" . $registro_foto["foto"]);
        }
    }

    $sentencia = $conexion->prepare("DELETE FROM usuarios WHERE id=:id");

    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    header("Location: index.php");
}
//SENTENCIA PARA VER DATOS DE LA TABLA USUARIOS(y traer el nombre del puesto)
$sentencia = $conexion->prepare("SELECT u.id, u.usuario, CONCAT(e.pnombre ,' ', e.papellido) AS nombre_empleado, u.foto AS foto,
                                    (SELECT nombrepuesto FROM puesto WHERE id = e.idpuesto) AS puesto 
                                FROM usuarios u 
                                JOIN empleados e ON u.idempleado = e.id");
$sentencia->execute();
$lista_usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="../../template/script.js"></script>
<br>
<h1>LISTA DE USUARIOS</h1>
<br>
<div class="card">
    <div class="card-header">
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID del Usuario</th>
                        <th scope="col">nombre del usuario</th>
                        <th scope="col">contraseña</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Nombre del Empleado</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($lista_usuarios as $registro) { ?>

                        <tr class="">
                            <td scope="row"><?php echo $registro['id']; ?></td>
                            <td><?php echo $registro['usuario']; ?></td>
                            <td>****</td>
                            <td><?php echo $registro['puesto']; ?></td>
                            <td><?php echo $registro['nombre_empleado']; ?></td>
                            <td>
                                <img width="50" src="<?php echo $registro['foto']; ?>" class="img-fluid rounded" alt="" />
                            </td>
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