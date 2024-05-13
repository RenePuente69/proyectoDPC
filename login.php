<?php
session_start();

if ($_POST) {
    include("./bd.php");

    //OBTENER VISTA DE PUESTO EN LA BD
    $sentencia = $conexion->prepare("SELECT *,count(*) as n_usuarios, e.idpuesto, u.foto as foto
                                    FROM usuarios u JOIN empleados e ON u.idempleado = e.id
                                    WHERE usuario=:usuario AND
                                    password=:password");
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];
    //$idpuesto = $_POST["idpuesto"];

    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password", $password);
    $sentencia->execute();

    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    if ($registro["n_usuarios"] > 0) {
        $_SESSION['usuario'] = $registro["usuario"];
        $_SESSION['logueado'] = true;
        $_SESSION['idpuesto'] = $registro["idpuesto"];
        // Obtener la ruta de la imagen del usuario
        $foto = $registro["foto"];
        if ($registro["idpuesto"] == 1) {
            header("Location:secciones/home/index.php");
        } elseif ($registro["idpuesto"] == 2) {
            header("Location:usuarios1/secciones/home.php");
        } elseif ($registro["idpuesto"] == 3) {
            header("Location:usuarios2/home.php");
        }
    } else {
        $mensaje = "--Usuario o Contraseña Incorrectos--";
    }
}
?>

<?php if (isset($_GET['mensaje'])) { ?>
    <script>
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "<?php echo $_GET['mensaje']; ?>"
        });
    </script>
<?php } ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/d428434f61.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Iniciar Sesion</title>
</head>

<body>
    <section>
        <div class="contenedor">
            <div class="formulario">

                <form action="" method="POST">
                    <h2>Iniciar Sesión</h2>
                    <?php if (isset($mensaje)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $mensaje; ?></strong>
                        </div>
                    <?php } ?>
                    <div class="input-contenedor">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" class="form-control" name="usuario" id="usuario" required>
                        <label for="usuario">Usuario</label>
                    </div>
                    <div class="input-contenedor">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" class="form-control" name="password" id="password" required>
                        <label for="password">Clave de Acceso</label>
                    </div>
                    <button type="submit" class="btn">Acceder</button>
                </form>
            </div>
        </div>
    </section>
</body>

</html>