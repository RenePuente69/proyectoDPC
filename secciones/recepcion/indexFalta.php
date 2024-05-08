<?php
//Verificar el acceso
include("../../funciones.php");
verificarAcceso();
//INCLUIR LA BASE DE DATOS
include("../../bd.php");
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
        <a name="" id="" class="btn btn-danger" href="reportesPDF.php" role="button" title="Generar Reporte"><i class="fa-solid fa-file-pdf"></i>
            PDF
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Fecha Desde</th>
                        <th scope="col">Fecha Hasta</th>
                        <th scope="col">Motivo de la falta</th>
                        <th scope="col">Evidencia</th>
                        <th scope="col">RUT</th>
                        <th scope="col">Nombre estudiante</th>
                        <th scope="col">Curso</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td>1</td>
                        <td>1/8/23</td>
                        <td>1/8/23</td>
                        <td>pololeando</td>
                        <td>evidencia.jpg</td>
                        <td>14545445</td>
                        <td>pedro</td>
                        <td>1°A</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("../../template/footer.php"); ?>