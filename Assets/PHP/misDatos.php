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
        <?php
        $conexion = conectar();
        $consulta = $conexion->query("select * from clientes where id = $id");
        $resultado = $consulta->fetch_all(MYSQLI_ASSOC);
            echo "<h2 style='width:25%; margin:auto;margin-bottom:40px;'>Mostrando tus datos personales</h2>";
            echo "<table><tr><th>Nombre</th><th>Apellidos</th><th>Nombre_Usuario</th><th>Direccion</th><th>Tel1</th><th>Tel2</th><th>Editar</th></tr>";
            foreach ($resultado as $value) {
                echo "<tr><td>$value[nombre]</td><td>$value[apellidos]</td><td>$value[nombre_usuario]</td><td>$value[direccion]</td><td>$value[telefono1]</td><td>$value[telefono2]</td>";
                echo"<td><form method='post' action='./editarDatos.php'><input type='hidden' name='id' value='$value[id]'><input type='submit' name='enviarEditar' value='Editar'></form></td></tr>";
            }
            echo "</table>";
        ?>
    </main>
    <?php
    $conexion->close();
    footer();
    ?>
</body>

</html>