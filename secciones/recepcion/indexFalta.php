<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS
include("../../bd.php");
//FUNCION DE ELIMINAR
if (isset($_GET['txtId'])) {
    $txtID = (isset($_GET['txtId'])) ? $_GET['txtId'] : "";

    //BUSCAR LA FOTO QUE SE INGRESO PARA BORRAR
    $sentencia = $conexion->prepare("SELECT evidencia FROM faltas WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro_foto = $sentencia->fetch(PDO::FETCH_LAZY);

    //BUSCAR REGISTRO SI EXISTE(foto)
    if (isset($registro_foto["evidencia"]) && $registro_foto["evidencia"] != "") {
        if (file_exists("./" . $registro_foto["evidencia"])) {
            unlink("./" . $registro_foto["evidencia"]);
        }
    }
    /*BUSCAR REGISTRO SI EXISTE(puede servir para curriculum)
    if (isset($registro_foto["foto"]) && $registro_foto["foto"]!="") {
        if (file_exists("./".$registro_foto["foto"])) {
                 unlink("./".$registro_foto["foto"]);
        }
    }*/


    //SENTENCIA SQL PARA ELIMINAR REGISTRO
    $sentencia = $conexion->prepare("DELETE FROM faltas WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    //Mensaje de eliminar de alert
    $mensaje = "Registro Eliminado";
    header("Location: indexFaltas.php?mensaje=" . $mensaje);
}
//OBTENER VISTA DE PUESTO EN LA BD
$sentencia = $conexion->prepare("SELECT f.*, e.id AS idestudiante, CONCAT(e.pnombre, ' ', e.papellido) AS nombre,
                                        CONCAT(c.numero, '°', c.letra) AS curso
                                 FROM faltas f
                                 INNER JOIN estudiantes e ON e.id = f.idestudiante
                                 INNER JOIN curso c ON c.id = e.idcurso");
$sentencia->execute();
$lista_faltas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="../../template/script.js"></script>

<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="home.php" role="button"><i class="fa-solid fa-arrow-left"></i>
            Volver
        </a>
        <a name="" id="" class="btn btn-success" href="crearFalta.php" role="button" title="Crear Falta"><i class="fa-solid fa-plus"></i>
            Crear Falta
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Fecha inicio</th>
                        <th scope="col">Fecha Termino</th>
                        <th scope="col">Motivo de la falta</th>
                        <th scope="col">RUT del estudiante</th>
                        <th scope="col">Nombre estudiante</th>
                        <th scope="col">Curso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_faltas as $registro) { ?>
                        <tr class="">
                            <td><?php echo $registro['id']; ?></td>
                            <td><?php echo $registro['fecha_ini']; ?></td>
                            <td><?php echo $registro['fecha_ter']; ?></td>
                            <td><?php echo $registro['motivo']; ?></td>
                            <td><?php echo $registro['idestudiante']; ?></td>
                            <td><?php echo $registro['nombre']; ?></td>
                            <td><?php echo $registro['curso']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("../../template/footer.php"); ?>