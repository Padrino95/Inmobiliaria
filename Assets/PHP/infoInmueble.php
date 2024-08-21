<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/Styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@1&display=swap" rel="stylesheet">
    <!-- iconos -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <!-- animacion -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <title>Modificar Inmueble</title>
</head>

<body>
    <?php
    require_once("../Funciones/conexion.php");
    session_start();
    $id = check();

    pintar('./Assets/PHP', $id);
    ?>
    <main>
        <!--=========================================================================INFO INMUEBLE========================================================================-->
        <section id="vermas" class="imagenes">
            <?php
            $conexion = conectar();
            if (isset($_POST["enviar"])) {
                $id = $_POST["id"];
            } elseif (isset($_GET["id"])) {
                $id = $_GET["id"];
            }

            $datos = $conexion->query("select * from inmuebles where id = $id");
            $datos = $datos->fetch_array(MYSQLI_ASSOC);
            echo "<div class='noticiaCompleta'>
                <div><img src='../Imagenes/Inmuebles/" . $datos["imagen"] . "'></div>
                <h2>Inmueble numero $datos[id]. $datos[descripcion]</h2>
                <p>Direccion: $datos[direccion]</p>
                <p>Precio: $datos[precio]</p>
            </div>";
            ?>
        </section>
    </main>
    <?php
    $conexion->close();
    footer();
    ?>
</body>

</html>