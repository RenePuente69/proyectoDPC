<?php include("../../template/header.php"); ?>
<link rel="stylesheet" href="../../template/estilos.css">
<link rel="stylesheet" href="../../assets/css/contenido.css">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="../../template/script.js"></script>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
    <link rel="stylesheet" href="../../template/estilos.css">
    <link rel="stylesheet" href="../noticias/cartas.css">
</head>

<body>
    <div class="container-wrapper">
        <br>
        <div class="container">
            <div class="card">
                <figure>
                    <img src="<?php echo $registro['foto']; ?>" alt="">
                </figure>
                <div class="contenido">
                    <h3>ATRASOS</h3>
                    <p>En esta sección puede ingresar los atrasos de los alumnos al ingreso del establecimiento.</p>
                    <a href="">Ingresar aquí</a>
                </div>
            </div>
            <div class="card">
                <figure>
                    <img src="<?php echo $registro['foto']; ?>" alt="">
                </figure>
                <div class="contenido">
                    <h3>RETIROS</h3>
                    <p>En esta sección se ingresa los retiros del alumnos del establecimiento.</p>
                    <a href="">Ingresar aquí</a>
                </div>
            </div>
            <div class="card">
                <figure>
                    <img src="<?php echo $registro['foto']; ?>" alt="">
                </figure>
                <div class="contenido">
                    <h3>FALTAS</h3>
                    <p>En esta sección se ingresa las falta de mas de un día a clases.</p>
                    <a href="">Ingresar aquí</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>


<?php include("../../template/footer.php"); ?>