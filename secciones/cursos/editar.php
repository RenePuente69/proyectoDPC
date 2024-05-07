<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS
include("../../bd.php");

//FUNCION DE EDITAR
if (isset($_GET['txtId'])) {
    $txtID = (isset($_GET['txtId'])) ? $_GET['txtId'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM curso WHERE id=:id");

    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $numero = $registro["numero"];
    $letra = $registro["letra"];
}

//FUNCION PARA ACTUALIZAR DATOS
if ($_POST) {
    //RECOLECTAMOS LOS DATOS DEL METODO POST
    $txtID = (isset($_POST['txtId'])) ? $_GET['txtId'] : "";
    $numero = (isset($_POST["numero"]) ? $_POST["numero"] : "");
    $letra = (isset($_POST["letra"]) ? $_POST["letra"] : "");
    //PREPARAR LA ACTUALIZACION DE LOS DATOS
    $sentencia = $conexion->prepare("UPDATE curso SET 
                                            numero=:numero,
                                            letra=:letra
                                        WHERE id=:id");
    //ASIGNANDO VALORES QUE VIENEN DEL POST
    $sentencia->bindParam(":numero", $numero);
    $sentencia->bindParam(":letra", $letra);
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
                <label for="numero" class="form-label">Editar el numero</label>
                <input type="text" value="<?php echo $numero; ?>" class="form-control" name="numero" id="numero" aria-describedby="helpId"/>
            </div>
            <div class="mb-3">
                <label for="letra" class="form-label">Editar el letra</label>
                <input type="text" value="<?php echo $letra; ?>" class="form-control" name="letra" id="letra" aria-describedby="helpId"/>
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar
            </a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>


<?php include("../../template/footer.php"); ?>