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

$sentencia = $conexion->prepare("SELECT *,
                                (SELECT nombrepuesto FROM puesto 
                                WHERE puesto.id = empleados.idpuesto limit 1) as puesto 
                                FROM empleados");
$sentencia->execute();
$lista_empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <h1>Reportes de Empleados</h1>
    <table class="table" id="tabla_id">
        <thead>
            <tr>
                <th scope="col">ID Empleado</th>
                <th scope="col">Nombres</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Imagen</th>
                <th scope="col">Correo</th>
                <th scope="col">Telefono</th>
                <th scope="col">Puesto</th>
                <th scope="col">Fecha de ingreso</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lista_empleados as $registro) { ?>
                <tr class="">
                    <td><?php echo $registro['id']; ?></td>
                    <td><?php echo $registro['pnombre']; ?>
                        <?php echo $registro['snombre']; ?></td>
                    <td><?php echo $registro['papellido']; ?>
                        <?php echo $registro['sapellido']; ?></td>
                    <td>
                        <img width="100" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/proyectodpc/secciones/empleados/<?php echo $registro['foto']; ?>" class="img-fluid rounded" alt="" />
                    </td>
                    <td><?php echo $registro['correopersonal']; ?></td>
                    <td><?php echo $registro['telefono']; ?></td>
                    <td><?php echo $registro['puesto']; ?></td>
                    <td><?php echo $registro['fechaingreso']; ?></td>
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

//$dompdf->setPaper('letter'); //vertical
$dompdf->setPaper('A4', 'landscape'); //papel horizontal
$dompdf->render();

//el false visualiza el pdf y el true descarga inmediatamente el archivo
$dompdf->stream("Empleados_.pdf", array("Attachment" => false));
?>