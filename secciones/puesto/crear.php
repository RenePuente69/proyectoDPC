<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS
include("../../bd.php");
//FUNCION PARA INSERTAR DATOS
if ($_POST) {
    //RECOLECTAMOS LOS DATOS DEL METODO POST
    $nombrePuesto = (isset($_POST["nombrepuesto"]) ? $_POST["nombrepuesto"] : "");
    //PREPARAR LA INSERCCION DE LOS DATOS
    $sentencia = $conexion->prepare("INSERT INTO puesto(id, nombrepuesto) VALUES (null, :nombrepuesto)");
    //ASIGNANDO VALORES QUE VIENEN DEL POST
    $sentencia->bindParam(":nombrepuesto", $nombrePuesto);
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
<h1>CREAR PUESTO</h1>

<div class="card">
    <div class="card-header">Puestos</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombrepuesto" class="form-label">Ingresa un nuevo puesto</label>
                <input type="text" class="form-control" name="nombrepuesto" id="nombrepuesto" aria-describedby="helpId" placeholder="Nombre del puesto" />
            </div>

            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar
            </a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>


<?php include("../../template/footer.php"); ?>