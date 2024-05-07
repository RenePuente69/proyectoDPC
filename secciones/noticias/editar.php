<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//Incluir base de datos
include("../../bd.php");
if (isset($_GET['txtId'])) {
    $txtID = (isset($_GET['txtId'])) ? $_GET['txtId'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM noticias WHERE id=:id");

    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $titulo = $registro["titulo"];
    $parrafo = $registro["parrafo"];
    $link = $registro["link"];
    $autor = $registro["autor"];
    $foto = $registro["foto"];
}
//FUNCION ACTUALIZAR
if ($_POST) {
    $txtID = (isset($_POST['txtId'])) ? $_POST['txtId'] : "";
    //RECOLECTAMOS LOS DATOS DEL METODO POST
    $titulo = (isset($_POST["titulo"]) ? $_POST["titulo"] : "");
    $parrafo = (isset($_POST["parrafo"]) ? $_POST["parrafo"] : "");
    $link = (isset($_POST["link"]) ? $_POST["link"] : "");
    $autor = (isset($_POST["autor"]) ? $_POST["autor"] : "");

    //ACTUALIZAR DATOS EN LA TABLA NOTICIAS
    $sentencia = $conexion->prepare("UPDATE noticias SET
                                    titulo = :titulo,
                                    parrafo = :parrafo,
                                    link = :link,
                                    autor = :autor
                                    WHERE id = :id");
    $sentencia->bindParam(":titulo", $titulo);
    $sentencia->bindParam(":parrafo", $parrafo);
    $sentencia->bindParam(":link", $link);
    $sentencia->bindParam(":autor", $autor);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    //RESCATAR FOTO
    $foto = (isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");
    $fecha_foto = new DateTime();
    $nombre_foto = ($foto != '') ? $fecha_foto->getTimestamp() . "_" . $_FILES["foto"]['name'] : "";
    $tmp_foto = $_FILES["foto"]['tmp_name'];
    if ($tmp_foto != '') {
        move_uploaded_file($tmp_foto, "./" . $nombre_foto);
        //BUSCAR LA FOTO QUE SE INGRESO PARA BORRAR
        $sentencia = $conexion->prepare("SELECT foto FROM noticias WHERE id=:id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registro_foto = $sentencia->fetch(PDO::FETCH_LAZY);

        //BUSCAR REGISTRO SI EXISTE(foto)
        if (isset($registro_foto["foto"]) && $registro_foto["foto"] != "") {
            if (file_exists("./" . $registro_foto["foto"])) {
                unlink("./" . $registro_foto["foto"]);
            }
        }
        $sentencia = $conexion->prepare("UPDATE noticias SET
                                            foto = :foto
                                            WHERE id = :id");
        $sentencia->bindParam(":foto", $nombre_foto);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }
    $mensaje = "Registro Actualizado";
    header("Location: index.php?mensaje=".$mensaje);
}
?>

<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<script src="../../template/script.js"></script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="card">
        <div class="card-header">Puesto</div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="txtId" class="form-label">ID de la noticia:</label>
                    <input type="text" value="<?php echo $txtID; ?>" class="form-control" readonly name="txtId" id="txtId" aria-describedby="helpId" placeholder="ID" />
                    <small id="helpId" class="form-text text-muted">ID NO EDITABLE</small>
                </div>

                <!--Agregar los datos editables-->
                <div class="mb-3">
                    <label for="titulo" class="form-label">Tituto</label>
                    <input type="text" value="<?php echo $titulo; ?>" class="form-control" name="titulo" id="titulo" aria-describedby="helpId" placeholder="" />
                </div>
                <div class="mb-3">
                    <label for="parrafo" class="form-label">Parrafo</label>
                    <input type="text" value="<?php echo $parrafo; ?>" class="form-control" name="parrafo" id="parrafo" aria-describedby="helpId" placeholder="" />
                </div>
                <div class="mb-3">
                    <label for="link" class="form-label">Link</label>
                    <input type="text" value="<?php echo $link; ?>" class="form-control" name="link" id="link" aria-describedby="helpId" placeholder="link nuevo" />
                </div>
                <div class="mb-3">
                    <label for="autor" class="form-label">Autor</label>
                    <input type="text" value="<?php echo $autor; ?>" class="form-control" name="autor" id="autor" aria-describedby="helpId" placeholder="" />
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <br />
                    <img width="100" src="<?php echo $foto; ?>" class="rounded" alt="" />
                    <br>
                    <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="foto" />
                </div>

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar
                </a>
            </form>
        </div>
        <div class="card-footer text-muted"></div>
    </div>
</body>

</html>
<?php include("../../template/footer.php"); ?>