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
    <h1>Reportes de Empleados</h1>
    <table>
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
                <tr>
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
// Obtener el contenido del búfer y limpiarlo
$html = ob_get_clean();

// Configurar el contenido del archivo Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Empleados.xls");

// Imprimir el contenido HTML directamente
echo $html;
?>