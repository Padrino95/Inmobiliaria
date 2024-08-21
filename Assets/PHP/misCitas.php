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
    $conexion = conectar();
    ?>
    <main>
        <!--===============================================================================CALENDARIO==========================================================================================-->
        <section id="calendario">
            <?php
            if (!isset($_GET['mes'])) {
                $dia = date('d');
                $mes = date('m');
                $año = date('Y');
            } else {
                $dia = 1;
                $mes = $_GET['mes'];
                $año = $_GET['año'];
            }

            calendarioCliente($dia, $mes, $año, $_SESSION["id"]);
            $mesAnterior = $mes - 1;
            $mesSiguiente = $mes + 1;
            $añoAnterior = $año - 1;
            $añoSiguiente = $año + 1;
            if ($mesAnterior < 1) {
                echo "<div id='enlacesCalendario' style='display: flex;justify-content: space-between;width: 16%;margin: auto;'>
                <a href='./misCitas.php?mes=12&año=$añoAnterior' style='padding: 5px;background-color: #7d7d6a;color: black;border-radius: 15px;'>anterior</a>
                <a href='./misCitas.php?mes=$mesSiguiente&año=$año' style='padding: 5px;background-color: #7d7d6a;color: black;border-radius: 15px;'>siguiente</a>
            </div>";
            } elseif ($mesSiguiente > 12) {
                echo "<div id='enlacesCalendario' style='display: flex;justify-content: space-between;width: 16%;margin: auto;'>
                <a href='./misCitas.php?mes=$mesAnterior&año=$año' style='padding: 5px;background-color: #7d7d6a;color: black;border-radius: 15px;'>anterior</a>
                <a href='./misCitas.php?mes=   1&año=$añoSiguiente' style='padding: 5px;background-color: #7d7d6a;color: black;border-radius: 15px;'>siguiente</a>
            </div>";
            } else {
                echo "<div id='enlacesCalendario' style='display: flex;justify-content: space-between;width: 16%;margin: auto;'>
                <a href='./misCitas.php?mes=$mesAnterior&año=$año' style='padding: 5px;background-color: #7d7d6a;color: black;border-radius: 15px;'>anterior</a>
                <a href='./misCitas.php?mes=$mesSiguiente&año=$año' style='padding: 5px;background-color: #7d7d6a;color: black;border-radius: 15px;'>siguiente</a>
            </div>";
            }
            ?>
        </section>
        <!--===========================================================================MOSTRAR CITAS============================================================================-->
        <section id="mostrarCitas" class="imagenes">
            <?php
            $datos = $conexion->query("select * from citas where Id_cliente=$_SESSION[id] order by fecha asc");
            if (!$datos) {
                echo "Consulta mal escrita";
            } else {
                $resultado = $datos->fetch_all(MYSQLI_ASSOC);
                if (!$resultado) {
                    echo "<h2 style='text-align:center; display:block;'>No hay citas que mostrar</h2>";
                } else {
                    echo "<h2 style='text-align:center; display:block;'>Mostrando todos las citas</h2>";
                    echo "<table><tr><th>Nº</th><th>Fecha</th><th>Hora</th><th>Lugar</th><th>Motivo</th></tr>";
                    foreach ($resultado as $value) {
                        $cita = $conexion->query("select fecha, hora from citas where Id_cliente=$_SESSION[id]");
                        $resultado = $cita->fetch_array(MYSQLI_ASSOC);
                        $fecha = $resultado["fecha"];
                        $arrayFecha = explode("-", $fecha);
                        $hora = $resultado["hora"];
                        $arrayHora = explode(":", $hora);
                        $marcaTiempo = mktime($arrayHora[0], $arrayHora[1], $arrayHora[2], $arrayFecha[1], $arrayFecha[2], $arrayFecha[0]);
                        $fecha = formatofecha($value["fecha"]);
                        echo "<tr style='text-align:center;'><td>$value[id]</td><td>$fecha</td><td>$value[hora]</td><td>$value[lugar]</td><td>$value[motivo]</td></tr>";
                    }
                    echo "</table>";
                }
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