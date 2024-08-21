<!DOCTYPE html>
<html lang="es">

<head>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acceder</title>
        <link rel="stylesheet" href="../Styles/Styles.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@1&display=swap" rel="stylesheet">
        <!-- iconos -->
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
        <!-- animacion -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    </head>
</head>

<body>
    <?php
    require_once("../Funciones/conexion.php");
    session_start();
    $id = check();
    pintar('./Assets/PHP', $id);
    $conexion = conectar();
    ?>
    <!-- =====================================================================================ACCEDER======================================================================================================= -->
    <div class="form-box">
        <h2>Accede</h2>
        <form method="post" action="#">
            <div class="user-box">
                <input type="text" name="usuario">
                <label>Usuario</label>
            </div>
            <div class="user-box">
                <input type="password" name="contraseña">
                <label>Contraseña</label>
            </div>
            <div>
                <input type="checkbox" name="recordar">
                <label for="recordar">Recordar</label>
            </div>
            <input type="submit" name="enviar">
        </form>
    </div>
    <?php

    if (isset($_GET['cerrar'])) {
        setcookie("sesion", "", time() - 3600, "/");
        session_destroy();
        $_SESSION=[];
        header("refresh:0;url=./acceder.php");
    } elseif (isset($_POST["enviar"])) {
        $contraseña = md5($_POST["contraseña"]);
        $consulta = $conexion->prepare("select id, nombre, apellidos from clientes where nombre_usuario=? and pass=?");
        $consulta->bind_param("ss", $_POST["usuario"], $contraseña);
        $consulta->bind_result($id, $nombre, $apellidos);
        $consulta->execute();
        $consulta->store_result();
        if ($consulta->num_rows > 0) {
            $consulta->fetch();
            $_SESSION["usuario"] = $_POST["usuario"];
            $_SESSION["nombre"] = $nombre;
            $_SESSION["apellidos"] = $apellidos;
            $_SESSION["id"] = $id;
            if (isset($_POST["recordar"])) {
                $cadenaSesion = session_encode();
                setcookie("sesion", $cadenaSesion, time() + (86400 * 30), "/");
            }
            header("refresh:1;url=../../index.php");
        } else {
            echo "Usuario o contraseña incorrectos";
            header("refresh:3;url=#");
        }
    }
    ?>
</body>

</html>