<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
ob_start();
?>
<?php
//INCLUIR LA BASE DE DATOS
include("../../bd.php");

//OBTENER VISTA DE PUESTO EN LA BD
$sentencia = $conexion->prepare("SELECT ar.*, CONCAT(e.pnombre, ' ', e.snombre, ' ', e.papellido, ' ', e.sapellido) AS nombre_estudiante, 
                                        l.nombre AS nombre_libro, CONCAT(c.numero, '°', c.letra) AS curso_estudiante
                                 FROM arriendo_libro AS ar
                                 INNER JOIN estudiantes AS e ON ar.idestudiante = e.id
                                 INNER JOIN libros AS l ON ar.idlibro = l.id
                                 INNER JOIN curso AS c ON e.idcurso = c.id");
$sentencia->execute();
$lista_arriendo = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Libros</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <h1>Reporte de Libros</h1>
    <table class="table" id="tabla_id">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Libro</th>
                <th scope="col">Nombre alumno</th>
                <th scope="col">Curso</th>
                <th scope="col">Fecha inicio</th>
                <th scope="col">Fecha termino</th>
                <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lista_arriendo as $registro) { ?>
                <tr class="">
                    <td><?php echo $registro['id']; ?></td>
                    <td><?php echo $registro['nombre_libro']; ?></td>
                    <td><?php echo $registro['nombre_estudiante']; ?></td>
                    <td><?php echo $registro['curso_estudiante']; ?></td>
                    <td><?php echo $registro['fecha_ini']; ?></td>
                    <td><?php echo $registro['fecha_ter']; ?></td>
                    <td><?php echo $registro['estado']; ?></td>
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

$dompdf->setPaper('A4', 'landscape'); // Papel horizontal
$dompdf->render();

// El false visualiza el PDF y el true descarga inmediatamente el archivo
$dompdf->stream("Libros.pdf", array("Attachment" => false));
?>