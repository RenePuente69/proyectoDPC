<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS
include("../../bd.php");
if ($_POST) {
    //RECOLECTAMOS LOS DATOS DEL METODO POST
    //CAPTURAR PRIMERO EL NOMBRE COMPLETO DEL ESTUDIANTE
    $id = (isset($_POST["id"]) ? $_POST["id"] : "");
    $pnombre = (isset($_POST["pnombre"]) ? $_POST["pnombre"] : "");
    $snombre = (isset($_POST["snombre"]) ? $_POST["snombre"] : "");
    $papellido = (isset($_POST["papellido"]) ? $_POST["papellido"] : "");
    $sapellido = (isset($_POST["sapellido"]) ? $_POST["sapellido"] : "");
    $direccion = (isset($_POST["direccion"]) ? $_POST["direccion"] : "");
    $telefono = (isset($_POST["telefono"]) ? $_POST["telefono"] : "");
    $fecha = (isset($_POST["fecha"]) ? $_POST["fecha"] : "");
    $idcurso = (isset($_POST["idcurso"]) ? $_POST["idcurso"] : "");

    //INSERTAR DATOS EN LA TABLA EMPLEADOS
    $sentencia = $conexion->prepare("INSERT INTO estudiantes (id, pnombre, snombre, papellido, sapellido, direccion, telefono, fecha, idcurso)
                                    VALUES(:id, :pnombre, :snombre, :papellido, :sapellido, :direccion, :telefono, :fecha, :idcurso)");
    $sentencia->bindParam(":id", $id);
    $sentencia->bindParam(":pnombre", $pnombre);
    $sentencia->bindParam(":snombre", $snombre);
    $sentencia->bindParam(":papellido", $papellido);
    $sentencia->bindParam(":sapellido", $sapellido);
    //ARMAR EL NOMBRE DE LA FOTO PARA QUE NO SE SOBRESCRIBA, POR TIEMPO
    //AGREGAR LOS DATOS FALTANTES
    $sentencia->bindParam(":direccion", $direccion);
    $sentencia->bindParam(":telefono", $telefono);
    $sentencia->bindParam(":fecha", $fecha);
    $sentencia->bindParam(":idcurso", $idcurso);
    $sentencia->execute();
    //MENSAJE DE CONFIRMACION
    $mensaje = "Registro Agregado";
    header("Location: index.php?mensaje=" . $mensaje);
}
//SENTENCIA PARA ATREAR EL CURSO AL ESTUDIANTE
$sentencia = $conexion->prepare("SELECT * FROM curso");
$sentencia->execute();
$lista_curso = $sentencia->fetchAll(PDO::FETCH_ASSOC);
// Obtener la fecha actual
$fecha_actual = date('Y-m-d');

?>
<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="../../template/script.js"></script>
<h1>AGREGAR NUEVO ESTUDIANTES</h1>
<br>
<div class="card">
    <div class="card-header">Los signos (*) son casillas opcionales</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="id" class="form-label">Rut</label>
                <input type="text" class="form-control" name="id" id="id" aria-describedby="helpId" placeholder="Nombre" require />
            </div>

            <div class="mb-3">
                <label for="pnombre" class="form-label">Primer Nombre</label>
                <input type="text" class="form-control" name="pnombre" id="pnombre" aria-describedby="helpId" placeholder="Nombre" require />
            </div>

            <div class="mb-3">
                <label for="snombre" class="form-label">Segundo Nombre (*)</label>
                <input type="text" class="form-control" name="snombre" id="snombre" aria-describedby="helpId" placeholder="Segundo Nombre" />
            </div>

            <div class="mb-3">
                <label for="papellido" class="form-label">Primer Apellido</label>
                <input type="text" class="form-control" name="papellido" id="papellido" aria-describedby="helpId" placeholder="Primer Apellido" require />
            </div>

            <div class="mb-3">
                <label for="sapellido" class="form-label">Segundo Apellido (*)</label>
                <input type="text" class="form-control" name="sapellido" id="sapellido" aria-describedby="helpId" placeholder="Segundo Apellido" />
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Direccion</label>
                <input type="text" class="form-control" name="direccion" id="direccion" aria-describedby="helpId" require />
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Telefono</label>
                <input type="text" class="form-control" name="telefono" id="telefono" aria-describedby="helpId" placeholder="telefono" require />
            </div>

            <div class="mb-3">
                <label for="idcurso" class="form-label">Curso</label>
                <select class="form-select form-select-lg" name="idcurso" id="idcurso">
                    <?php foreach ($lista_curso as $registro) { ?>
                        <option value="<?php echo $registro['id']; ?>">
                            <?php echo $registro['numero'] . '°' . $registro['letra']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha de ingreso</label>
                <input type="date" class="form-control" name="fecha" id="fecha" aria-describedby="emailHelpId" placeholder="Fecha de ingreso en la empresa" value="<?php echo $fecha_actual; ?>" readonly />
            </div>

            <button type="submit" class="btn btn-success">Agregar Registro</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>

<?php include("../../template/footer.php"); ?>