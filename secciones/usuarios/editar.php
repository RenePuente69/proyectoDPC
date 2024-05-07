<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS
//FUNCION DE EDITAR
include("../../bd.php");
if (isset($_GET['txtId'])) {
    $txtID = (isset($_GET['txtId'])) ? $_GET['txtId'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM usuarios WHERE id=:id");

    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $usuario = $registro["usuario"];
    $password = $registro["password"];
}
if ($_POST) {
    $txtID = (isset($_POST['txtId'])) ? $_POST['txtId'] : "";
    //RECOLECTAMOS LOS DATOS DEL METODO POST
    //CAPTURAR PRIMERO EL NOMBRE COMPLETO DEL EMPLEADO
    $usuario = (isset($_POST["usuario"]) ? $_POST["usuario"] : "");
    $password = (isset($_POST["password"]) ? $_POST["password"] : "");
    //ACTUALIZAR DATOS EN LA TABLA EMPLEADOS
    $sentencia = $conexion->prepare("UPDATE usuarios SET
                                    usuario = :usuario,
                                    password = :password
                                    WHERE id = :id");
    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password", $password);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    //REDIRIGIR AL INDEX
    $mensaje="Registro Actualizado";
    header("Location: index.php?mensaje=".$mensaje);
}
?>
<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="../../template/script.js"></script>
<br>
<h1>Editar Usuario</h1>
<br>
<div class="card">
    <div class="card-header">Datos del empleado</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
                <label for="txtId" class="form-label">ID USUARIO:</label>
                <input type="text" value="<?php echo $txtID; ?>" class="form-control" readonly name="txtId" id="txtId" aria-describedby="helpId" placeholder="ID" />
                <small id="helpId" class="form-text text-muted">ID NO EDITABLE</small>
            </div>

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" value="<?php echo $usuario; ?>" class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="usuario@dparra.cl" />
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" value="<?php echo $password; ?>" class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Contraseña Nueva" />
            </div>

            <button type="submit" class="btn btn-success">Actualizar Registro</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>
<?php include("../../template/footer.php"); ?>