</main>
<script src="script.js"></script>
<footer>
<!-- place footer here -->
</footer>
<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<!--Incorporar la funcion del script para la filtracion de datos en las tablas-->
<script>
    $(document).ready(function() {
        $("#tabla_id").DataTable({
            "pagesLength": 5,
            lengthMenu: [
                [5, 10, 25, 50],
                [5, 10, 25, 50]
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
            }
        });
    });
</script>
<script>
    function borrar(id) {
        Swal.fire({
            title: "ADVENTENCIA",
            text: "Verificar si los datos no estan vinculados con otros datos ¿desea continuar?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            cancelButtonText: 'Cancelar',
            confirmButtonText: "Si, borrar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "index.php?txtId=" + id;
            }
        });
    }
</script>
<script>
    function salir() {
        Swal.fire({
            title: "Cerrar Sesión",
            text: "¿Está seguro de que desea cerrar la sesión?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            cancelButtonText: 'Cancelar',
            confirmButtonText: "Sí, cerrar sesión"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "<?php echo $url_base; ?>cerrar.php";
            }
        });
    }
</script>
</body>

</html>