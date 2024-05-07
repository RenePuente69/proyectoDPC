<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR BASE DE DATOS
include("../../bd.php");

//FUNCION DE EDITAR
if (isset($_GET['txtId'])) {
    $txtID = (isset($_GET['txtId'])) ? $_GET['txtId'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM estudiantes WHERE id=:id");

    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);


    $pnombre = $registro["pnombre"];
    $snombre = $registro["snombre"];
    $papellido = $registro["papellido"];
    $sapellido = $registro["sapellido"];
    $telefono = $registro["telefono"];
    $direccion = $registro["direccion"];
    $idcurso = $registro["idcurso"];
    $fecha = $registro["fecha"];

    $sentencia = $conexion->prepare("SELECT * FROM curso");
    $sentencia->execute();
    $lista_curso = $sentencia->fetchAll(PDO::FETCH_ASSOC);
   
}
//FUNCION DE ACTUALIZAR
if ($_POST) {
    $txtID = (isset($_POST['txtId'])) ? $_POST['txtId'] : "";
    //RECOLECTAMOS LOS DATOS DEL METODO POST
    //CAPTURAR PRIMERO EL NOMBRE COMPLETO DEL EMPLEADO
    $id = (isset($_POST["id"]) ? $_POST["id"] : "");
    $pnombre = (isset($_POST["pnombre"]) ? $_POST["pnombre"] : "");
    $snombre = (isset($_POST["snombre"]) ? $_POST["snombre"] : "");
    $papellido = (isset($_POST["papellido"]) ? $_POST["papellido"] : "");
    $sapellido = (isset($_POST["sapellido"]) ? $_POST["sapellido"] : "");
    $telefono = (isset($_POST["telefono"]) ? $_POST["telefono"] : "");
    $idcurso = (isset($_POST["idcurso"]) ? $_POST["idcurso"] : "");
    $direccion = (isset($_POST["direccion"]) ? $_POST["direccion"] : "");
    $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';
    
    //ACTUALIZAR DATOS EN LA TABLA ESTUDIANTES
    $sentencia = $conexion->prepare("UPDATE estudiantes SET
                                    pnombre = :pnombre,
                                    snombre = :snombre,
                                    papellido = :papellido,
                                    sapellido = :sapellido,
                                    direccion = :direccion,
                                    telefono = :telefono,
                                    fecha = :fecha,
                                    idcurso = :idcurso
                                    WHERE id = :id");

    $sentencia->bindParam(":pnombre", $pnombre);
    $sentencia->bindParam(":snombre", $snombre);
    $sentencia->bindParam(":papellido", $papellido);
    $sentencia->bindParam(":sapellido", $sapellido);
    $sentencia->bindParam(":direccion", $direccion);
    $sentencia->bindParam(":telefono", $telefono);
    $sentencia->bindParam(":fecha", $fecha);
    $sentencia->bindParam(":idcurso", $idcurso);
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
<h1>Editar Estudiante</h1>
<br>
<div class="card">
    <div class="card-header">Datos del estudiante</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
                <label for="txtId" class="form-label">RUT Estudiante:</label>
                <input type="text" value="<?php echo $txtID; ?>" class="form-control" readonly name="txtId" id="txtId" aria-describedby="helpId" placeholder="ID" />
                <small id="helpId" class="form-text text-muted">RUT NO EDITABLE</small>
            </div>

            <div class="mb-3">
                <label for="pnombre" class="form-label">Primer Nombre</label>
                <input type="text" value="<?php echo $pnombre; ?>" class="form-control" name="pnombre" id="pnombre" aria-describedby="helpId" />
            </div>

            <div class="mb-3">
                <label for="snombre" class="form-label">Segundo Nombre</label>
                <input type="text" value="<?php echo $snombre; ?>" class="form-control" name="snombre" id="snombre" aria-describedby="helpId" />
            </div>

            <div class="mb-3">
                <label for="papellido" class="form-label">Primer Apellido</label>
                <input type="text" value="<?php echo $papellido; ?>" class="form-control" name="papellido" id="papellido" aria-describedby="helpId"  />
            </div>

            <div class="mb-3">
                <label for="sapellido" class="form-label">Segundo Apellido</label>
                <input type="text" value="<?php echo $sapellido; ?>" class="form-control" name="sapellido" id="sapellido" aria-describedby="helpId"/>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Direccion</label>
                <input type="text" value="<?php echo $direccion; ?>" class="form-control" name="direccion" id="direccion" aria-describedby="helpId" placeholder="ejemplo@gmail.com"/>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Telefono</label>
                <input type="text" value="<?php echo $telefono; ?>" class="form-control" name="telefono" id="telefono" aria-describedby="helpId"/>
            </div>

            <div class="mb-3">
                <label for="idcurso" value="<?php echo $idcurso; ?>" class="form-label">Curso</label>
                <select class="form-select form-select-lg" name="idcurso" id="idcurso">
                    <?php foreach ($lista_curso as $registro) { ?>
                        <option <?php echo ($idcurso==$registro['id'])?"selected":""?> value="<?php echo $registro['id']; ?>">
                            <?php echo $registro['numero'] . '°' . $registro['letra']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha de ingreso</label>
                <input type="date" value="<?php echo $fecha; ?>" readonly class="form-control" name="fecha" id="fecha" aria-describedby="emailHelpId"/>
            </div> 

            <button type="submit" class="btn btn-success">Actualizar Registro</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>

<?php include("../../template/footer.php"); ?>