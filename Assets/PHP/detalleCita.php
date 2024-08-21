<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Styles/Styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@1&display=swap" rel="stylesheet">
    <!-- iconos -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <!-- animacion -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>
    <?php
    require_once("../Funciones/conexion.php");
    session_start();
    $id = check();
    checkUser();
    pintar('./Assets/PHP', $id);
    $conexion = conectar();
    ?>
    <!--====================================================================DETALLE CITA====================================================-->
    <section id="detalleCita">
        <?php
        if (isset($_GET['enviado'])) {
            $fecha = "$_GET[año]-$_GET[mes]-$_GET[dia]";
            $datos = $conexion->query("select * from citas where fecha='$fecha'");
            $resultado = $datos->fetch_all(MYSQLI_ASSOC);
            echo"<div class='mostrar'>";
            foreach ($resultado as $value) {
                $fechaBuena = formatoFecha($value["fecha"]);
                $consulta = $conexion->query("select nombre from clientes where id='$value[Id_cliente]'");
                $nombreCliente = $consulta->fetch_array(MYSQLI_ASSOC);
                $cliente=$nombreCliente["nombre"];
                echo "<div class='cita'><h2>Cita número $value[id]</h2><br>
                <span>Tendrá lugar el dia $fechaBuena</span><br><br>
                <span>A las $value[hora]</span><br><br>
                <span>En $value[lugar]</span><br><br>
                <span>Con motivo de $value[motivo]</span><br><br>
                <span>Con el cliente $cliente</span><br></div>";
            }
            echo"</div>";
        }
        ?>
    </section>
    <?php
    $conexion->close();
    footer();
    ?>
</body>

</html>