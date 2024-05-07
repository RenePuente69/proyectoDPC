<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS
include("../../bd.php");

//FUNCION DE EDITAR
if (isset($_GET['txtId'])) {
    $txtID = (isset($_GET['txtId'])) ? $_GET['txtId'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM puesto WHERE id=:id");

    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    //CARGA SOLO UN REGISTRO
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $nombredelpuesto = $registro["nombrepuesto"];
}

//FUNCION PARA ACTUALIZAR DATOS
if ($_POST) {
    //RECOLECTAMOS LOS DATOS DEL METODO POST
    $txtID = (isset($_POST['txtId'])) ? $_GET['txtId'] : "";
    $nombrePuesto = (isset($_POST["nombrepuesto"]) ?
        $_POST["nombrepuesto"] : "");
    //PREPARAR LA ACTUALIZACION DE LOS DATOS
    $sentencia = $conexion->prepare("UPDATE  puesto SET nombrepuesto=:nombrepuesto
                                        WHERE id=:id");
    //ASIGNANDO VALORES QUE VIENEN DEL POST
    $sentencia->bindParam(":nombrepuesto", $nombrePuesto);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $mensaje="Registro Actualizado";
    header("Location: index.php?mensaje=".$mensaje);
}
?>
<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="../../template/script.js"></script>
<h1>Editar Puesto</h1>
<br>
<div class="card">
    <div class="card-header">Puesto</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="txtId" class="form-label">ID PUESTO:</label>
                <input type="text" value="<?php echo $txtID; ?>" class="form-control" readonly name="txtId" id="txtId" aria-describedby="helpId" placeholder="ID" />
                <small id="helpId" class="form-text text-muted">ID NO EDITABLE</small>
            </div>


            <div class="mb-3">
                <label for="nombrepuesto" class="form-label">Editar el puesto</label>
                <input type="text" value="<?php echo $nombredelpuesto; ?>" class="form-control" name="nombrepuesto" id="nombrepuesto" aria-describedby="helpId" placeholder="Nombre del puesto:" />
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar
            </a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>


<?php include("../../template/footer.php"); ?>