<?php
// Verificar el acceso
include("../../funciones.php");
verificarAcceso();
// INCLUIR LA BASE DE DATOS
include("../../bd.php");
// Consultar los datos de libros desde la base de datos
$sentencia = $conexion->prepare("SELECT * FROM libros");
$sentencia->execute();
$lista_libros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
// Iniciar el almacenamiento en búfer de salida
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Libros</title>
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

<body>
    <h1>Reporte de Libros</h1>
    <table>
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Titulo</th>
                <th>Autor</th>
                <th>Editorial</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lista_libros as $registro) { ?>
                <tr>
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
// Obtener el contenido del búfer y limpiarlo
$html = ob_get_clean();

// Configurar el contenido del archivo Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Libros.xls");

// Imprimir el contenido HTML directamente
echo $html;
?>
