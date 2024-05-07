<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS
include("../../bd.php");
//FUNCION PARA INSERTAR DATOS
if ($_POST) {
    //RECOLECTAMOS LOS DATOS DEL METODO POST
    $numero = (isset($_POST["numero"]) ? $_POST["numero"] : "");
    $letra = (isset($_POST["letra"]) ? $_POST["letra"] : "");
    //PREPARAR LA INSERCCION DE LOS DATOS
    $sentencia = $conexion->prepare("INSERT INTO curso(id, numero, letra) VALUES (null, :numero, :letra)");
    //ASIGNANDO VALORES QUE VIENEN DEL POST
    $sentencia->bindParam(":numero", $numero);
    $sentencia->bindParam(":letra", $letra);
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
<h1>CREAR CURSOS</h1>

<div class="card">
    <div class="card-header">Agregar nuevo curso</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="numero" class="form-label">Ingresa un numero del curso</label>
                <input type="text" class="form-control" name="numero" id="numero" aria-describedby="helpId"/>
            </div>
            <div class="mb-3">
                <label for="letra" class="form-label">Ingresa la letra del curso</label>
                <input type="text" class="form-control" name="letra" id="letra" aria-describedby="helpId"/>
            </div>
            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar
            </a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>


<?php include("../../template/footer.php"); ?>