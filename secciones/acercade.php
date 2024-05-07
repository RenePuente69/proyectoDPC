<?php 
//Verificar el acceso
include("../funciones.php");
verificarAcceso();
//Incluir Base de datos
include("../template/header.php"); 
?>
<link rel="stylesheet" href="../template/estilos.css">
<link rel="stylesheet" href="../assets/css/contenido.css">
<script src="../template/script.js"></script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información</title>
</head>
<body>
<div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        Funciones de Administrador(actualmente)
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>Funciones Principales de ADMIN</strong> 
        <br>
        *Empleados 
        *Puesto
        *Usuarios
        *Noticias
      </div>
    </div>
  </div>
</div>
</body>
</html>
<?php include("../template/footer.php"); ?>