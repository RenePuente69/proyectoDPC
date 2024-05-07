<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
ob_start();
?>
<?php
//INCLUIR LA BASE DE DATOS
include("../../bd.php");

$sentencia = $conexion->prepare("SELECT * FROM libros");
$sentencia->execute();
$lista_libros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
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
                <th scope="col">Codigo</th>
                <th scope="col">Titulo</th>
                <th scope="col">Autor</th>
                <th scope="col">Editorial</th>
                <th scope="col">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lista_libros as $registro) { ?>
                <tr class="">
                    <td><?php echo $registro['id']; ?></td>
                    <td><?php echo $registro['nombre']; ?></td>
                    <td><?php echo $registro['autor']; ?></td>
                    <td><?php echo $registro['editorial']; ?></td>
                    <td><?php echo $registro['cantidad']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>

<?php

$html=ob_get_clean();
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
