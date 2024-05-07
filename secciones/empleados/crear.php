<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS
include("../../bd.php");
if ($_POST) {
    //RECOLECTAMOS LOS DATOS DEL METODO POST
    //CAPTURAR PRIMERO EL NOMBRE COMPLETO DEL EMPLEADO
    $id = (isset($_POST["id"]) ? $_POST["id"] : "");
    $pnombre = (isset($_POST["pnombre"]) ? $_POST["pnombre"] : "");
    $snombre = (isset($_POST["snombre"]) ? $_POST["snombre"] : "");
    $papellido = (isset($_POST["papellido"]) ? $_POST["papellido"] : "");
    $sapellido = (isset($_POST["sapellido"]) ? $_POST["sapellido"] : "");
    //RECOLECTAR EL RESTO DE LOS DATOS DE LOS EMPLEADOS
    $foto = (isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");
    $correopersonal = (isset($_POST["correopersonal"]) ? $_POST["correopersonal"] : "");
    $telefono = (isset($_POST["telefono"]) ? $_POST["telefono"] : "");
    $idpuesto = (isset($_POST["idpuesto"]) ? $_POST["idpuesto"] : "");
    $fechaingreso = (isset($_POST["fechaingreso"]) ? $_POST["fechaingreso"] : "");
    //INSERTAR DATOS EN LA TABLA EMPLEADOS
    $sentencia = $conexion->prepare("INSERT INTO empleados (id, pnombre, snombre, papellido, sapellido, foto, 
                                                            correopersonal, telefono, idpuesto, fechaingreso)
                                    VALUES(:id, :pnombre, :snombre, :papellido, :sapellido, :foto, :correopersonal, :telefono, :idpuesto, :fechaingreso)");
    $sentencia->bindParam(":id", $id);
    $sentencia->bindParam(":pnombre", $pnombre);
    $sentencia->bindParam(":snombre", $snombre);
    $sentencia->bindParam(":papellido", $papellido);
    $sentencia->bindParam(":sapellido", $sapellido);
    //ARMAR EL NOMBRE DE LA FOTO PARA QUE NO SE SOBRESCRIBA, POR TIEMPO
    $fecha_foto = new DateTime();
    $nombre_foto = ($foto != '') ? $fecha_foto->getTimestamp() . "_" . $_FILES["foto"]['name'] : "";
    $tmp_foto = $_FILES["foto"]['tmp_name'];
    if ($tmp_foto != '') {
        move_uploaded_file($tmp_foto, "./" . $nombre_foto);
    }
    $sentencia->bindParam(":foto", $nombre_foto);
    //AGREGAR LOS DATOS FALTANTES
    $sentencia->bindParam(":correopersonal", $correopersonal);
    $sentencia->bindParam(":telefono", $telefono);
    $sentencia->bindParam(":idpuesto", $idpuesto);
    $sentencia->bindParam(":fechaingreso", $fechaingreso);
    $sentencia->execute();
    //MENSAJE DE CONFIRMACION
    $mensaje = "Registro Agregado";
    header("Location: index.php?mensaje=" . $mensaje);
}
//SENTENCIA PARA ATREAR EL NOMBRE DEL PUESTO AL EMPLEADO
$sentencia = $conexion->prepare("SELECT * FROM puesto");
$sentencia->execute();
$lista_puesto = $sentencia->fetchAll(PDO::FETCH_ASSOC);
// Obtener la fecha actual
$fecha_actual = date('Y-m-d');


?>
<?php include("../../template/header.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="../../template/script.js"></script>
<h1>AGREGAR NUEVO EMPLEADO</h1>
<br>
<div class="card">
    <div class="card-header">Datos del empleado</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="id" class="form-label">RUT</label>
                <input type="text" class="form-control" name="id" id="id" aria-describedby="helpId" placeholder="SIN DIGITO VERIFICADOR" required />
            </div>
            <div class="mb-3">
                <label for="pnombre" class="form-label">Primer Nombre</label>
                <input type="text" class="form-control" name="pnombre" id="pnombre" aria-describedby="helpId" placeholder="Nombre" require />
            </div>

            <div class="mb-3">
                <label for="snombre" class="form-label">Segundo Nombre</label>
                <input type="text" class="form-control" name="snombre" id="snombre" aria-describedby="helpId" placeholder="Segundo Nombre" />
            </div>

            <div class="mb-3">
                <label for="papellido" class="form-label">Primer Apellido</label>
                <input type="text" class="form-control" name="papellido" id="papellido" aria-describedby="helpId" placeholder="Primer Apellido" require />
            </div>

            <div class="mb-3">
                <label for="sapellido" class="form-label">Segundo Apellido</label>
                <input type="text" class="form-control" name="sapellido" id="sapellido" aria-describedby="helpId" placeholder="Segundo Apellido" />
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="foto" />
            </div>

            <div class="mb-3">
                <label for="correopersonal" class="form-label">Correo Personal</label>
                <input type="text" class="form-control" name="correopersonal" id="correopersonal" aria-describedby="helpId" placeholder="correopersonal" require />
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Telefono</label>
                <input type="text" class="form-control" name="telefono" id="telefono" aria-describedby="helpId" placeholder="telefono" require />
            </div>

            <div class="mb-3">
                <label for="idpuesto" class="form-label">Puesto</label>

                <select class="form-select form-select-lg" name="idpuesto" id="idpuesto">
                    <?php foreach ($lista_puesto as $registro) { ?>
                        <option value="<?php echo $registro['id']; ?>">
                            <?php echo $registro['nombrepuesto']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fechaingreso" class="form-label">Fecha de ingreso</label>
                <input type="date" class="form-control" name="fechaingreso" id="fechaingreso" aria-describedby="emailHelpId" placeholder="Fecha de ingreso en la empresa" value="<?php echo $fecha_actual; ?>" readonly />
            </div>

            <button type="submit" class="btn btn-success">Agregar Registro</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>

<?php include("../../template/footer.php"); ?>