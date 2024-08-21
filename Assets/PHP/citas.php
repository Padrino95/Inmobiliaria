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
    checkAdmin();
    pintar('./Assets/PHP', $id);
    $conexion = conectar();
    ?>
    <!--=============================================================================MOSTRAR CALENDARIO==============================================================================-->
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

        calendario($dia, $mes, $año);
        $mesAnterior = $mes - 1;
        $mesSiguiente = $mes + 1;
        $añoAnterior = $año - 1;
        $añoSiguiente = $año + 1;
        if ($mesAnterior < 1) {
            echo "<div id='enlacesCalendario' style='display: flex;justify-content: space-between;width: 16%;margin: auto;'>
                <a href='./citas.php?mes=12&año=$añoAnterior' style='padding: 5px;background-color: #7d7d6a;color: black;border-radius: 15px;'>anterior</a>
                <a href='./citas.php?mes=$mesSiguiente&año=$año' style='padding: 5px;background-color: #7d7d6a;color: black;border-radius: 15px;'>siguiente</a>
            </div>";
        } elseif ($mesSiguiente > 12) {
            echo "<div id='enlacesCalendario' style='display: flex;justify-content: space-between;width: 16%;margin: auto;'>
                <a href='./citas.php?mes=$mesAnterior&año=$año' style='padding: 5px;background-color: #7d7d6a;color: black;border-radius: 15px;'>anterior</a>
                <a href='./citas.php?mes=   1&año=$añoSiguiente' style='padding: 5px;background-color: #7d7d6a;color: black;border-radius: 15px;'>siguiente</a>
            </div>";
        } else {
            echo "<div id='enlacesCalendario' style='display: flex;justify-content: space-between;width: 16%;margin: auto;'>
                <a href='./citas.php?mes=$mesAnterior&año=$año' style='padding: 5px;background-color: #7d7d6a;color: black;border-radius: 15px;'>anterior</a>
                <a href='./citas.php?mes=$mesSiguiente&año=$año' style='padding: 5px;background-color: #7d7d6a;color: black;border-radius: 15px;'>siguiente</a>
            </div>";
        }
        ?>
    </section>
    <!--=======================================================================DATOS AÑADIR CITA===========================================================================================-->
    <section id="form">
        <?php
        $consulta = "select AUTO_INCREMENT from information_schema.tables where table_schema= 'inmobiliaria' and table_name='citas'";
        $resultado = $conexion->query($consulta);
        if (!$resultado) {
            echo "Consulta mal escrita";
        } else {
            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
        }

        ?>
        <div class="form-box">
            <h2>Añade una cita</h2>
            <form method="post" action="#" enctype="multipart/form-data">
                <div class="user-box">
                    <input type="text" readonly name="id" value=<?php echo $datos[0]['AUTO_INCREMENT']; ?>> <br>
                    <label>Id</label>
                </div>
                <div class="user-box">
                    <input type="date" name="fecha">
                    <label>fecha</label>
                </div>
                <div class="user-box">
                    <input type="time" name="hora">
                    <label>hora</label>
                </div>
                <div class="user-box">
                    <input type="text" name="lugar">
                    <label>lugar</label>
                </div>
                <div class="user-box">
                    <input type="text" name="motivo" ;>
                    <label>motivo</label>
                </div>
                <div class="user-box idCliente">
                    <select id="cliente_id" name="idCliente">
                        <?php
                        $consultaId = $conexion->query("select id from clientes");
                        $consultaIds = $consultaId->fetch_all(MYSQLI_ASSOC);
                        foreach ($consultaIds as $value) {
                            echo "<option value='$value[id]'>$value[id]</option>";
                        }
                        ?>
                    </select>
                    <label>Id cliente</label>
                </div>

                <input type="submit" name="enviar">
            </form>
        </div>

        <?php
        // ===========================================================INSERTAR CITA======================================================================================
        if (isset($_POST["enviar"])) {
            if (!$_POST["fecha"] || !$_POST["hora"] || !$_POST["lugar"] || !$_POST["motivo"] || !$_POST["idCliente"]) {
                echo "Debes rellenar todos los datos correctamente, serás redirigidio...";
                echo "<meta http-equiv='refresh' content='1;url=#'>";
            } else {

                $motiv = trim($_POST["motivo"]);
                $lug = trim($_POST["lugar"]);

                $inserccion = $conexion->prepare("insert into citas values (null, ?, ?, ?, ?, ?)");
                $inserccion->bind_Param("sssss", $_POST["fecha"], $_POST["hora"], $lug, $motiv, $_POST["idCliente"]);
                $inserccion->execute();
                $inserccion->close();
                echo "<meta http-equiv='refresh' content='1;url=#'>";
            }
        }
        ?>
    </section>


    <!--==================================================================MOSTRAR CITAS===========================================================================================-->
    <section id="mostrarCitas" class="imagenes">
        <?php
        $datos = $conexion->query("select * from citas order by fecha asc");
        if (!$datos) {
            echo "Consulta mal escrita";
        } else {
            $resultado = $datos->fetch_all(MYSQLI_ASSOC);
            if (!$resultado) {
                echo "<h2 style='text-align:center; display:block;'>No hay citas que mostrar</h2>";
            } else {
                echo "<h2 style='text-align:center; display:block;'>Mostrando todos las citas</h2>";
                echo "<table><tr><th>ID</th><th>Fecha</th><th>Hora</th><th>Lugar</th><th>Motivo</th><th>Id Cliente</th><th>Borrar</th><th>Modificar</th></tr>";
                foreach ($resultado as $value) {
                    $cita = $conexion->query("select fecha, hora, Id_cliente from citas where id=$value[id]");
                    $resultado = $cita->fetch_array(MYSQLI_ASSOC);
                    $idCliente=$resultado["Id_cliente"];
                    $fecha=$resultado["fecha"];
                    $arrayFecha=explode("-", $fecha);
                    $hora = $resultado["hora"];
                    $arrayHora=explode(":", $hora);
                    $marcaTiempo= mktime($arrayHora[0],$arrayHora[1], $arrayHora[2],$arrayFecha[1], $arrayFecha[2], $arrayFecha[0]);
                    $valido = $marcaTiempo - time();
                    
                    // sacar nombre de cliente de la cita en vez de id
                    $datos2=$conexion->query("select nombre from clientes where id=$idCliente");
                    $resultado2=$datos2->fetch_array(MYSQLI_ASSOC);
                    $nombre=$resultado2["nombre"];

                    $fecha = formatofecha($value["fecha"]);
                    if ($valido <= 86400) {
                        echo "<tr style='text-align:center;'><td>$value[id]</td><td>$fecha</td><td>$value[hora]</td><td>$value[lugar]</td><td>$value[motivo]</td><td>$nombre</td>
                                <td><form method='post' action='#'><input type='hidden' name='id' value='$value[id]'><input type='submit' name='enviarBorrarCita' value='Borrar' disabled></form></td>
                                <td><form method='post' action='./modificarCita.php'><input type='hidden' name='id' value='$value[id]'><input type='submit' name='enviarModificarCita' value='Modificar' disabled></form></td></tr>";
                    }else{
                        echo "<tr style='text-align:center;'><td>$value[id]</td><td>$fecha</td><td>$value[hora]</td><td>$value[lugar]</td><td>$value[motivo]</td><td>$nombre</td>
                                <td><form method='post' action='#'><input type='hidden' name='id' value='$value[id]'><input type='submit' name='enviarBorrarCita' value='Borrar' ></form></td>
                                <td><form method='post' action='./modificarCita.php'><input type='hidden' name='id' value='$value[id]'><input type='submit' name='enviarModificarCita' value='Modificar'></form></td></tr>";
                    }
                }
                echo "</table>";
            }
        }
        ?>
    </section>
    <!--=================================================================BORRAR CITA================================================================================================-->
    <section id="borrarCita">
        <?php
        if (isset($_POST["enviarBorrarCita"])) {
            $cita = $conexion->query("select fecha, hora from citas where id=$_POST[id]");
            $resultado = $cita->fetch_array(MYSQLI_ASSOC);
            $fecha=$resultado["fecha"];
            $arrayFecha=explode("-", $fecha);
            $hora = $resultado["hora"];
            $arrayHora=explode(":", $hora);
            $marcaTiempo= mktime($arrayHora[0],$arrayHora[1], $arrayHora[2],$arrayFecha[1], $arrayFecha[2], $arrayFecha[0]);
            

            $valido = $marcaTiempo - time();
            if ($valido > 86400) {
                $datos = $conexion->query("delete from citas where id=$_POST[id]");
                echo "<meta http-equiv='refresh' content='1;url=#'>";
                echo "<h2>Cita borrada con éxito</h2>";
            }
        }
        ?>
    </section>


    <!--==================================================================BUSCAR CITA==============================================================================================-->
    <section id="buscarCita" class="imagenes">
        <div class="form-box">
            <h2>Introduce el patrón por el que quieras buscar</h2>
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="user-box">
                    <input type="text" name="busqueda">
                    <label>Patrón</label>
                </div>
                <input type="submit" name="enviarBusqueda">
            </form>
        </div>
        <?php
        if (isset($_POST["enviarBusqueda"])) {
            if (!$_POST["busqueda"]) {
                echo "Debes introducir algun datos para poder buscar";
            } else {
                $valor = "%" . $_POST["busqueda"] . "%";
                $busqueda = $conexion->prepare("select citas.id, fecha, hora, motivo, lugar, nombre from citas, clientes where clientes.id=citas.Id_cliente and (fecha like ? or nombre like ?)");
                $busqueda->bind_param("ss", $valor, $valor);
                $busqueda->bind_result($id, $fecha, $hora, $motivo, $lugar, $nombre);
                $busqueda->execute();
                $busqueda->store_result();
                if ($busqueda->num_rows == 0) {
                    echo "No hay datos";
                } else {
                    echo "<h2 style='text-align:center; display:block;'>Mostrando los clientes que coinciden con tu busqueda</h2>";
                    echo "<table><tr><th>Id</th><th>Fecha</th><th>Hora</th><th>Motivo</th><th>Lugar</th><th>Nombre cliente</th></tr>";
                    while ($busqueda->fetch()) {
                        $fechaCorrecta = formatofecha($fecha);
                        echo "<tr style='text-align:center;'><td>$id</td><td>$fechaCorrecta</td><td>$hora</td><td>$motivo</td><td>$lugar</td><td>$nombre</td></tr>";
                    }
                    echo "</table>";
                    $busqueda->close();
                }
            }
        }
        ?>
    </section>

    <?php
    footer();
    $conexion->close();
    ?>
</body>

</html>