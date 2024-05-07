<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
// INCLUIR LA BASE DE DATOS
include("../../bd.php");

$txtID = "";
$pnombre = "";

if (isset($_GET['txtId'])) {
    $txtID = $_GET['txtId'];
    $sentencia = $conexion->prepare("SELECT * FROM empleados WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
}

if ($_POST){
    $usuario = (isset($_POST["usuario"]) ? $_POST["usuario"] : "");
    $password = (isset($_POST["password"]) ? $_POST["password"] : "");
    $idempleado = (isset($_POST["idempleado"]) ? $_POST["idempleado"] : "");
    $foto = (isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");

    // INSERTAR DATOS EN LA TABLA USUARIOS
    $sentencia = $conexion->prepare("INSERT INTO usuarios(id, usuario, password, foto, idempleado)
                                    VALUES(NULL, :usuario, :password, :foto, :idempleado)");
                                    //ARMAR EL NOMBRE DE LA FOTO PARA QUE NO SE SOBRESCRIBA, POR TIEMPO
    $fecha_foto = new DateTime();
    $nombre_foto = ($foto != '') ? $fecha_foto->getTimestamp() . "_" . $_FILES["foto"]['name'] : "";
    $tmp_foto = $_FILES["foto"]['tmp_name'];
    if ($tmp_foto != '') {
        move_uploaded_file($tmp_foto, "./" . $nombre_foto);
    }
    $sentencia->bindParam(":foto", $nombre_foto);
    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password", $password);
    $sentencia->bindParam(":idempleado", $idempleado);
    $sentencia->execute();
    //MENSAJE DE CONFIRMACION
    $mensaje="Registro Agregado";
    header("Location: index.php?mensaje=".$mensaje);
}
?>

<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="../../template/script.js"></script>
<br>
<h1>CREAR USUARIOS</h1>

<div class="card">
    <div class="card-header">Datos del Usuario</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="txtId" class="form-label">ID del Empleado:</label>
                <input type="text" value="<?php echo $txtID; ?>" class="form-control" readonly name="txtId" id="txtId" aria-describedby="helpId" placeholder="ID" />
                <input type="hidden" value="<?php echo $txtID; ?>" name="idempleado">
                <small id="helpId" class="form-text text-muted">ID NO EDITABLE</small>
            </div>

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="usuario@dparrac.cl" />
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Contraseña" />
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="foto" />
            </div>

            <button type="submit" class="btn btn-success">Agregar Usuario</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>

<?php include("../../template/footer.php"); ?>
