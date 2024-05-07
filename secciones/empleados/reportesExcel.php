<?php
// Verificar el acceso
include("../../funciones.php");
verificarAcceso();

// Iniciar el almacenamiento en búfer de salida
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<?php
// INCLUIR LA BASE DE DATOS
include("../../bd.php");

// Consultar los datos de empleados desde la base de datos
$sentencia = $conexion->prepare("SELECT *,
                                (SELECT nombrepuesto FROM puesto 
                                WHERE puesto.id = empleados.idpuesto LIMIT 1) AS puesto 
                                FROM empleados");
$sentencia->execute();
$lista_empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <h1>Reportes de Empleados</h1>
    <table>
        <thead>
            <tr>
                <th>ID Empleado</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Telefono</th>
                <th>Puesto</th>
                <th>Fecha de ingreso</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lista_empleados as $registro) { ?>
                <tr>
                    <td><?php echo $registro['id']; ?></td>
                    <td><?php echo $registro['pnombre'] . ' ' . $registro['snombre']; ?></td>
                    <td><?php echo $registro['papellido'] . ' ' . $registro['sapellido']; ?></td>
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
// Obtener el contenido del búfer y limpiarlo
$html = ob_get_clean();

// Configurar el contenido del archivo Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Empleados.xls");

// Imprimir el contenido HTML directamente
echo $html;
?>
