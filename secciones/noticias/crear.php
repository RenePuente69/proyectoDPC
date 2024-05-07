<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS 
include("../../bd.php");
if ($_POST) {
    //RECOLECTAMOS LOS DATOS DEL METODO POST
    $titulo = (isset($_POST["titulo"]) ? $_POST["titulo"] : "");
    $parrafo = (isset($_POST["parrafo"]) ? $_POST["parrafo"] : "");
    $foto = (isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");
    $link = (isset($_POST["link"]) ? $_POST["link"] : "");
    $autor = (isset($_POST["autor"]) ? $_POST["autor"] : "");
    $fecha = (isset($_POST["fecha"]) ? $_POST["fecha"] : "");
    //INSERTAR DATOS EN LA TABLA EMPLEADOS
    $sentencia = $conexion->prepare("INSERT INTO noticias (id, titulo, parrafo, foto, link, autor, fecha)
                                    VALUES(NULL, :titulo, :parrafo, :foto, :link, :autor, :fecha)");
    $sentencia->bindParam(":titulo", $titulo);
    $sentencia->bindParam(":parrafo", $parrafo);
    $sentencia->bindParam(":link", $link);
    $sentencia->bindParam(":autor", $autor);
    $sentencia->bindParam(":fecha", $fecha);
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
// Obtener la fecha actual
$fecha_actual = date('Y-m-d');
?>
<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<script src="../../template/script.js"></script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Noticias</title>
</head>

<body>
    <h1>Crear Noticias</h1>
    <div class="card">
        <div class="card-header">Crear Noticias</div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <!--TITULO-->
                <div class="mb-3">
                    <label for="titulo" class="form-label">Titulo</label>
                    <input type="text" class="form-control" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Nombre Principal" require />
                </div>
                <!--DESCRIPCION-->
                <div class="mb-3">
                    <label for="parrafo" class="form-label">Descripcion</label>
                    <input type="text" class="form-control" name="parrafo" id="parrafo" aria-describedby="helpId" placeholder="Texto breve" require />
                </div>
                <!--FOTO-->
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="foto" />
                </div>
                <!--LINK-->
                <div class="mb-3">
                    <label for="basic-url" class="form-label">Agregar Link(Opcional)</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">https://ejemplo.com/</span>
                        <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4">
                    </div>
                </div>
                <!--AUTOR-->
                <div class="mb-3">
                    <label for="autor" class="form-label">autor</label>
                    <input type="text" class="form-control" name="autor" id="autor" aria-describedby="helpId" placeholder="autor" />
                </div>
                <!--Fecha-->
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha de ingreso</label>
                    <input type="date" class="form-control" name="fecha" id="fecha" aria-describedby="emailHelpId" value="<?php echo $fecha_actual; ?>" readonly/>
                </div>
                <!--Botones-->
                <button type="submit" class="btn btn-success">Agregar Registro</button>
                <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
            </form>
        </div>
    </div>
</body>

</html>
<?php include("../../template/footer.php"); ?>