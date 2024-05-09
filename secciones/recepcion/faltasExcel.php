<?php
// Verificar el acceso
include("../../funciones.php");
verificarAcceso();
// INCLUIR LA BASE DE DATOS
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

        th,
        td {
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
    <h1>Reporte de Faltas</h1>
    <table>
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
                <tr>
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
// Obtener el contenido del búfer y limpiarlo
$html = ob_get_clean();

// Configurar el contenido del archivo Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Faltas.xls");

// Imprimir el contenido HTML directamente
echo $html;
?>