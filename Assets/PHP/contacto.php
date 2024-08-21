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

    <title>Requestify</title>
</head>

<body>
    <?php
    require_once("../Funciones/conexion.php");
    session_start();
    $id = check();
    pintar('./Assets/PHP', $id);
    ?>
    <div class="form-box">
        <h2>Introduce tus datos personales</h2>
        <form method="post" action="#">
            <div class="user-box">
                <input type="text"  name="id" name="nombre"> <br>
                <label>Nombre</label>
            </div>
            <div class="user-box">
                <input type="text" name="apellidos">
                <label>Apellidos</label>
            </div>
            <div class="user-box">
                <input type="text" name="e-mail">
                <label>E-mail</label>
            </div>
            <div class="user-box">
                <input type="text" name="direccion">
                <label>Direccion</label>
            </div>
            <div class="user-box">
                <input type="text" name="tel1">
                <label>Teléfono 1</label>
            </div>
            <input type="submit" name="enviar">
        </form>
    </div>
    <?php
    footer();
    ?>
</body>

</html>