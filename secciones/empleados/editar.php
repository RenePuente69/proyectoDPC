<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR BASE DE DATOS
include("../../bd.php");

//FUNCION DE EDITAR
if (isset($_GET['txtId'])) {
    $txtID = (isset($_GET['txtId'])) ? $_GET['txtId'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM empleados WHERE id=:id");

    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);


    $pnombre = $registro["pnombre"];
    $snombre = $registro["snombre"];
    $papellido = $registro["papellido"];
    $sapellido = $registro["sapellido"];

    $foto = $registro["foto"];
    $correopersonal = $registro["correopersonal"];
    $telefono = $registro["telefono"];

    $idpuesto = $registro["idpuesto"];
    $fechaIngreso = $registro["fechaIngreso"];
    //TRAER LOS PUESTOS
    $sentencia = $conexion->prepare("SELECT * FROM puesto");
    $sentencia->execute();
    $lista_puesto = $sentencia->fetchAll(PDO::FETCH_ASSOC);
   
}
//FUNCION DE ACTUALIZAR
if ($_POST) {
    $txtID = (isset($_POST['txtId'])) ? $_POST['txtId'] : "";
    //RECOLECTAMOS LOS DATOS DEL METODO POST
    //CAPTURAR PRIMERO EL NOMBRE COMPLETO DEL EMPLEADO
    $pnombre = (isset($_POST["pnombre"]) ? $_POST["pnombre"] : "");
    $snombre = (isset($_POST["snombre"]) ? $_POST["snombre"] : "");
    $papellido = (isset($_POST["papellido"]) ? $_POST["papellido"] : "");
    $sapellido = (isset($_POST["sapellido"]) ? $_POST["sapellido"] : "");
    //RECOLECTAR EL RESTO DE LOS DATOS DE LOS EMPLEADOS
    $correopersonal = (isset($_POST["correopersonal"]) ? $_POST["correopersonal"] : "");
    $telefono = (isset($_POST["telefono"]) ? $_POST["telefono"] : "");
    $idpuesto = (isset($_POST["idpuesto"]) ? $_POST["idpuesto"] : "");
    $fechaingreso = isset($_GET['fechaingreso']) ? $_GET['fechaingreso'] : '';
    //ACTUALIZAR DATOS EN LA TABLA EMPLEADOS
    $sentencia = $conexion->prepare("UPDATE empleados SET
                                    pnombre = :pnombre,
                                    snombre = :snombre,
                                    papellido = :papellido,
                                    sapellido = :sapellido,
                                    correopersonal = :correopersonal,
                                    telefono = :telefono,
                                    idpuesto = :idpuesto,
                                    fechaingreso = :fechaingreso
                                    WHERE id = :id");

    $sentencia->bindParam(":pnombre", $pnombre);
    $sentencia->bindParam(":snombre", $snombre);
    $sentencia->bindParam(":papellido", $papellido);
    $sentencia->bindParam(":sapellido", $sapellido);

    $sentencia->bindParam(":correopersonal", $correopersonal);
    $sentencia->bindParam(":telefono", $telefono);
    $sentencia->bindParam(":idpuesto", $idpuesto);
    $sentencia->bindParam(":fechaingreso", $fechaingreso);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $foto = (isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");

    $fecha_foto=new DateTime();
    $nombre_foto=($foto!='')?$fecha_foto->getTimestamp(). "_".$_FILES["foto"]['name']:"";
    $tmp_foto=$_FILES["foto"]['tmp_name'];
    if($tmp_foto!=''){
        move_uploaded_file($tmp_foto, "./".$nombre_foto);

    //BUSCAR LA FOTO QUE SE INGRESO PARA BORRAR
    $sentencia = $conexion->prepare("SELECT foto FROM empleados WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro_foto = $sentencia->fetch(PDO::FETCH_LAZY);

    //BUSCAR REGISTRO SI EXISTE(foto)
    if (isset($registro_foto["foto"]) && $registro_foto["foto"]!="") {
        if (file_exists("./".$registro_foto["foto"])) {
                 unlink("./".$registro_foto["foto"]);
        }
    }
    $sentencia = $conexion->prepare("UPDATE empleados SET
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
                <label for="pnombre" class="form-label">Primer Nombre</label>
                <input type="text" value="<?php echo $pnombre; ?>" class="form-control" name="pnombre" id="pnombre" aria-describedby="helpId" placeholder="Nombre" />
            </div>

            <div class="mb-3">
                <label for="snombre" class="form-label">Segundo Nombre</label>
                <input type="text" value="<?php echo $snombre; ?>" class="form-control" name="snombre" id="snombre" aria-describedby="helpId" placeholder="Segundo Nombre" />
            </div>

            <div class="mb-3">
                <label for="papellido" class="form-label">Primer Apellido</label>
                <input type="text" value="<?php echo $papellido; ?>" class="form-control" name="papellido" id="papellido" aria-describedby="helpId" placeholder="Primer Apellido" />
            </div>

            <div class="mb-3">
                <label for="sapellido" class="form-label">Segundo Apellido</label>
                <input type="text" value="<?php echo $sapellido; ?>" class="form-control" name="sapellido" id="sapellido" aria-describedby="helpId" placeholder="Segundo Apellido" />
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <br/>
                

                <img width="100" src="<?php echo $foto; ?>" class="rounded" alt="" />

                <br>
                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="foto" />
            </div>

            <div class="mb-3">
                <label for="correopersonal" class="form-label">correo Personal</label>
                <input type="text" value="<?php echo $correopersonal; ?>" class="form-control" name="correopersonal" id="correopersonal" aria-describedby="helpId" placeholder="correopersonal" />
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Telefono</label>
                <input type="text" value="<?php echo $telefono; ?>" class="form-control" name="telefono" id="telefono" aria-describedby="helpId" placeholder="telefono" />
            </div>

            <div class="mb-3">
                <label for="idpuesto" value="<?php echo $idpuesto; ?>" class="form-label">Puesto</label>
                <select class="form-select form-select-lg" name="idpuesto" id="idpuesto">
                    <?php foreach ($lista_puesto as $registro) { ?>
                        <option <?php echo ($idpuesto==$registro['id'])?"selected":""?> value="<?php echo $registro['id']; ?>">
                            <?php echo $registro['nombrepuesto']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fechaingreso" class="form-label">Fecha de ingreso</label>
                <input type="date" value="<?php echo $fechaingreso; ?>" class="form-control" name="fechaingreso" id="fechaingreso" aria-describedby="emailHelpId" placeholder="Fecha de ingreso en la empresa" />
            </div> 

            <button type="submit" class="btn btn-success">Actualizar Registro</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>

<?php include("../../template/footer.php"); ?>