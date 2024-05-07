<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS
include("../../bd.php");
if ($_POST) {
    //RECOLECTAMOS LOS DATOS DEL METODO POST
    $id = (isset($_POST["id"]) ? $_POST["id"] : "");
    $nombre = (isset($_POST["nombre"]) ? $_POST["nombre"] : "");
    $autor = (isset($_POST["autor"]) ? $_POST["autor"] : "");
    $editorial = (isset($_POST["editorial"]) ? $_POST["editorial"] : "");
    $cantidad = (isset($_POST["cantidad"]) ? $_POST["cantidad"] : "");
    $foto = (isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");
    //INSERTAR DATOS EN LA TABLA LIBROS
    $sentencia = $conexion->prepare("INSERT INTO libros (id, nombre, autor, editorial, cantidad, foto)
                                    VALUES(:id, :nombre, :autor, :editorial, :cantidad, :foto)");
    $sentencia->bindParam(":id", $id);
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":autor", $autor);
    $sentencia->bindParam(":editorial", $editorial);
    $sentencia->bindParam(":cantidad", $cantidad);
    //ARMAR EL NOMBRE DE LA FOTO PARA QUE NO SE SOBRESCRIBA, POR TIEMPO
    $fecha_foto = new DateTime();
    $nombre_foto = ($foto != '') ? $fecha_foto->getTimestamp() . "_" . $_FILES["foto"]['name'] : "";
    $tmp_foto = $_FILES["foto"]['tmp_name'];
    if ($tmp_foto != '') {
        move_uploaded_file($tmp_foto, "./" . $nombre_foto);
    }
    $sentencia->bindParam(":foto", $nombre_foto);
    $sentencia->execute();
    //MENSAJE DE CONFIRMACION
    $mensaje = "Registro Agregado";
    header("Location: index.php?mensaje=" . $mensaje);
}

?>
<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="../../template/script.js"></script>
<h1>AGREGAR NUEVO LIBRO</h1>
<br>
<div class="card">
    <div class="card-header">Datos del libro</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="id" class="form-label">Codigo</label>
                <input type="text" class="form-control" name="id" id="id" aria-describedby="helpId" require />
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Titulo</label>
                <input type="text" class="form-control" name="nombre" id="nombre" aria-describedby="helpId"require />
            </div>

            <div class="mb-3">
                <label for="autor" class="form-label">Autor</label>
                <input type="text" class="form-control" name="autor" id="autor" aria-describedby="helpId" />
            </div>

            <div class="mb-3">
                <label for="editorial" class="form-label">Editorial</label>
                <input type="text" class="form-control" name="editorial" id="editorial" aria-describedby="helpId"  require />
            </div>

            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="text" class="form-control" name="cantidad" id="cantidad" aria-describedby="helpId" />
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="foto" />
            </div>

            <button type="submit" class="btn btn-success">Agregar Registro</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>

<?php include("../../template/footer.php"); ?>