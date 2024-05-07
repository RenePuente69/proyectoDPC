<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
include("../../bd.php");
if (isset($_GET['txtId'])) {
    $txtID = (isset($_GET['txtId'])) ? $_GET['txtId'] : "";

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
    /*BUSCAR REGISTRO SI EXISTE(puede servir para curriculum)
    if (isset($registro_foto["foto"]) && $registro_foto["foto"]!="") {
        if (file_exists("./".$registro_foto["foto"])) {
                 unlink("./".$registro_foto["foto"]);
        }
    }*/


    //SENTENCIA SQL PARA ELIMINAR REGISTRO
    $sentencia = $conexion->prepare("DELETE FROM noticias WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    //Mensaje de eliminar de alert
    $mensaje="Registro Eliminado";
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
    <title>Noticias</title>
    <link rel="stylesheet" href="../../template/estilos.css">
    <link rel="stylesheet" href="cartas.css">
</head>

<body>
    <div class="container-wrapper">
        <div>
            <a class="btn btn-success" href="crear.php" role="button"><i class="fa-solid fa-plus"></i>
                Agregar nueva noticia
            </a>
        </div>
        <br>
        <div class="container">
            <?php
            include("../../bd.php");

            $sentencia = $conexion->prepare("SELECT * FROM noticias");
            $sentencia->execute();
            $lista_noticias = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            foreach ($lista_noticias as $registro) {
            ?>
                <div class="card">
                    <div class="card-header">
                        <a name="" id="" class="btn btn-primary" href="../noticias/editar.php?txtId=<?php echo $registro['id']; ?>" role="button"><i class="fa-solid fa-pen-to-square"></i> Editar</a>  
                        <a name="" id="" class="btn btn-danger" href="javascript:borrarNoticia(<?php echo $registro['id']; ?>)" role="button"><i class="fa-solid fa-trash"></i> Eliminar</a>
                    </div>
                    <figure>
                        <img src="<?php echo $registro['foto']; ?>" alt="">
                    </figure>
                    <div class="contenido">
                        <h3><?php echo $registro['titulo']; ?></h3>
                        <p><?php echo $registro['parrafo']; ?></p>
                        <p>Publicado por: <?php echo $_SESSION['usuario'] ?></p>
                        <a href="<?php echo $registro['link']; ?>">Leer más</a>
                        <br>
                        <p><?php echo $registro['fecha']; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>
<script>
    function borrarNoticia(id) {
        Swal.fire({
            title: "ADVENTENCIA",
            text: "Se eliminara la publicación a usuarios",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            cancelButtonText: 'Cancelar',
            confirmButtonText: "Si, borrar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "index.php?txtId=" + id;
            }
        });
    }
</script>
<?php include("../../template/footer.php"); ?>