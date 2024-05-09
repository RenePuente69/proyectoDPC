<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS
include("../../bd.php");
//OBTENER VISTA DE PUESTO EN LA BD
$sentencia = $conexion->prepare("SELECT r.*, e.id AS idestudiante, CONCAT(e.pnombre, ' ', e.papellido) AS nombre,
                                        CONCAT(c.numero, '°', c.letra) AS curso
                                 FROM retiros r
                                 INNER JOIN estudiantes e ON e.id = r.idestudiante
                                 INNER JOIN curso c ON c.id = e.idcurso");
$sentencia->execute();
$lista_retiros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
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
        <a name="" id="" class="btn btn-success" href="crearRetiro.php" role="button"><i class="fa-solid fa-plus"></i>
            Crear Retiro
        </a>
        <a name="" id="" class="btn btn-danger" href="retirosPDF.php" role="button" title="Generar Reporte"><i class="fa-solid fa-file-pdf"></i>
            PDF
        </a>
        <a name="" id="" class="btn btn-success" href="retirosExcel.php" role="button" title="Generar Reporte"><i class="fa-solid fa-file-excel"></i>
            Excel
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Motivo del atraso</th>
                        <th scope="col">Apoderado</th>
                        <th scope="col">RUT del estudiante</th>
                        <th scope="col">Nombre estudiante</th>
                        <th scope="col">Curso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_retiros as $registro) {?>
                    <tr class="">
                        <td><?php echo $registro['id']; ?></td>
                        <td><?php echo $registro['fecha']; ?></td>
                        <td><?php echo $registro['hora']; ?></td>
                        <td><?php echo $registro['motivo']; ?></td>
                        <td><?php echo $registro['apoderado']; ?></td>
                        <td><?php echo $registro['idestudiante']; ?></td>
                        <td><?php echo $registro['nombre']; ?></td>
                        <td><?php echo $registro['curso']; ?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("../../template/footer.php"); ?>