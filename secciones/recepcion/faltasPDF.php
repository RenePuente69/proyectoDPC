<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<?php
//INCLUIR LA BASE DE DATOS
include("../../bd.php");
//OBTENER VISTA DE PUESTO EN LA BD
$sentencia = $conexion->prepare("SELECT f.*, e.id AS idestudiante, CONCAT(e.pnombre, ' ', e.papellido) AS nombre,
                                        CONCAT(c.numero, '°', c.letra) AS curso
                                 FROM faltas f
                                 INNER JOIN estudiantes e ON e.id = f.idestudiante
                                 INNER JOIN curso c ON c.id = e.idcurso");
$sentencia->execute();
$lista_faltas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <h1>Reportes de Faltas</h1>
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
</body>

</html>

<?php

$html = ob_get_clean();
//echo $html;

require '../../libreria/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);

//$dompdf->setPaper('letter'); //vertical
$dompdf->setPaper('A4', 'landscape'); //papel horizontal
$dompdf->render();

//el false visualiza el pdf y el true descarga inmediatamente el archivo
$dompdf->stream("Empleados_.pdf", array("Attachment" => false));
?>