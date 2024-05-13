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
$sentencia = $conexion->prepare("SELECT *,
                                    (SELECT CONCAT(numero, '°' ,letra) FROM curso
                                    WHERE curso.id = estudiantes.idcurso LIMIT 1) AS curso_concatenado
                                FROM estudiantes");
$sentencia->execute();
$lista_estudiantes = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <h1>Reportes de Estudiantes</h1>
    <table class="table" id="tabla_id">
        <thead>
            <tr>
                <th scope="col">RUT</th>
                <th scope="col">Nombres</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Dirección</th>
                <th scope="col">Telefono</th>
                <th scope="col">Curso</th>
                <th scope="col">Fecha de ingreso</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lista_estudiantes as $registro) { ?>
                <tr class="">
                    <td><?php echo $registro['id']; ?></td>
                    <td><?php echo $registro['pnombre']; ?>
                        <?php echo $registro['snombre']; ?></td>
                    <td><?php echo $registro['papellido']; ?>
                        <?php echo $registro['sapellido']; ?></td>
                    <td><?php echo $registro['direccion']; ?></td>
                    <td><?php echo $registro['telefono']; ?></td>
                    <td><?php echo $registro['curso_concatenado']; ?></td>
                    <td><?php echo $registro['fecha']; ?></td>
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
$dompdf->stream("Estudiantes__.pdf", array("Attachment" => false));
?>