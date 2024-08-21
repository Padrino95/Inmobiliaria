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
    checkUser();
    pintar('./Assets/PHP', $id);
    ?>
    <main>
        <section class="imagenes">
            <?php
            $conexion = conectar();
            $consulta = $conexion->query("select * from inmuebles where id = $id");
            $resultado = $consulta->fetch_all(MYSQLI_ASSOC);
            if (!$resultado) {
                echo "<h2 style='width:25%; margin:auto;margin-bottom:40px;'>No hay inmuebles que mostrar</h2>";
            } else {
                echo "<h2 style='width:25%; margin:auto;margin-bottom:40px;'>Mostrando todos los inmuebles</h2>";
                echo "<table><tr><th>Imagen</th><th>Direccion</th><th>Precio</th><th>Descripcción</th></tr>";
                foreach ($resultado as $value) {
                    echo "<tr><td><img src='../Imagenes/Inmuebles/$value[imagen]'></td><td>$value[direccion]</td><td>$value[precio]</td><td>$value[descripcion]</td></tr>";
                }
                echo "</table>";
            }
            ?>
        </section>
    </main>
    <?php
    $conexion->close();
    footer();
    ?>
</body>

</html>