<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR BASE DE DATOS
include("../../bd.php");

//FUNCION DE EDITAR
if (isset($_GET['txtId'])) {
    $txtID = (isset($_GET['txtId'])) ? $_GET['txtId'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM libros WHERE id=:id");

    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);


    $nombre = $registro["nombre"];
    $autor = $registro["autor"];
    $editorial = $registro["editorial"];
    $cantidad = $registro["cantidad"];
    $foto = $registro["foto"];  
}
//FUNCION DE ACTUALIZAR
if ($_POST) {
    $txtID = (isset($_POST['txtId'])) ? $_POST['txtId'] : "";
    //RECOLECTAMOS LOS DATOS DEL METODO POST
    //CAPTURAR PRIMERO EL NOMBRE COMPLETO DEL LIBROS
    $nombre = (isset($_POST["nombre"]) ? $_POST["nombre"] : "");
    $autor = (isset($_POST["autor"]) ? $_POST["autor"] : "");
    $editorial = (isset($_POST["editorial"]) ? $_POST["editorial"] : "");
    $cantidad = (isset($_POST["cantidad"]) ? $_POST["cantidad"] : "");
    //ACTUALIZAR DATOS EN LA TABLA LIBROS
    $sentencia = $conexion->prepare("UPDATE libros SET
                                    nombre = :nombre,
                                    autor = :autor,
                                    editorial = :editorial,
                                    cantidad = :cantidad
                                    WHERE id = :id");

    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":autor", $autor);
    $sentencia->bindParam(":editorial", $editorial);
    $sentencia->bindParam(":cantidad", $cantidad);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $foto = (isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");

    $fecha_foto=new DateTime();
    $nombre_foto=($foto!='')?$fecha_foto->getTimestamp(). "_".$_FILES["foto"]['name']:"";
    $tmp_foto=$_FILES["foto"]['tmp_name'];
    if($tmp_foto!=''){
        move_uploaded_file($tmp_foto, "./".$nombre_foto);

    //BUSCAR LA FOTO QUE SE INGRESO PARA BORRAR
    $sentencia = $conexion->prepare("SELECT foto FROM libros WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro_foto = $sentencia->fetch(PDO::FETCH_LAZY);

    //BUSCAR REGISTRO SI EXISTE(foto)
    if (isset($registro_foto["foto"]) && $registro_foto["foto"]!="") {
        if (file_exists("./".$registro_foto["foto"])) {
                 unlink("./".$registro_foto["foto"]);
        }
    }
    $sentencia = $conexion->prepare("UPDATE libros SET
                                        foto = :foto
                                        WHERE id = :id");
    $sentencia->bindParam(":foto", $nombre_foto);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    }
    $mensaje="Registro Actualizado";
    header("Location: index.php?mensaje=".$mensaje);
}
?>

<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="../../template/script.js"></script>
<h1>Editar Empleados</h1>
<br>
<div class="card">
    <div class="card-header">Datos del empleado</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
                <label for="txtId" class="form-label">ID EMPLEADO:</label>
                <input type="text" value="<?php echo $txtID; ?>" class="form-control" readonly name="txtId" id="txtId" aria-describedby="helpId" placeholder="ID" />
                <small id="helpId" class="form-text text-muted">ID NO EDITABLE</small>
            </div>

            <div class="mb-3">
                <label for="nombre" class="form-label">Titulo</label>
                <input type="text" value="<?php echo $nombre; ?>" class="form-control" name="nombre" id="nombre" aria-describedby="helpId"  />
            </div>

            <div class="mb-3">
                <label for="autor" class="form-label">Autor</label>
                <input type="text" value="<?php echo $autor; ?>" class="form-control" name="autor" id="autor" aria-describedby="helpId" />
            </div>

            <div class="mb-3">
                <label for="editorial" class="form-label">Editorial</label>
                <input type="text" value="<?php echo $editorial; ?>" class="form-control" name="editorial" id="editorial" aria-describedby="helpId" />
            </div>

            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="text" value="<?php echo $cantidad; ?>" class="form-control" name="cantidad" id="cantidad" aria-describedby="helpId" />
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <br/>
                

                <img width="100" src="<?php echo $foto; ?>" class="rounded" alt="" />

                <br>
                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="foto" />
            </div>

            <button type="submit" class="btn btn-success">Actualizar Registro</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>

<?php include("../../template/footer.php"); ?>