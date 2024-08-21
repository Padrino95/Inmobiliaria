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

    <!--==============================================================MODIFICAR CITA===================================================================================-->
    <section id="modificarCita">
        <?php
        $datos = $conexion->query("select * from citas where id='$_POST[id]'");
        $consulta = $datos->fetch_array(MYSQLI_ASSOC);
        ?>
        <div class="form-box">
            <h2>Modifica una cita</h2>
            <form method="post" action="#" enctype="multipart/form-data">
                <div class="user-box">
                    <input type="text" readonly name="id" value=<?php echo $_POST["id"] ?>> <br>
                    <label>Id</label>
                </div>
                <div class="user-box">
                    <input type="date" name="fecha" value=<?php echo $consulta["fecha"] ?>>
                    <label>fecha</label>
                </div>
                <div class="user-box">
                    <input type="time" name="hora" value=<?php echo $consulta["hora"] ?>>
                    <label>hora</label>
                </div>
                <div class="user-box">
                    <input type="text" name="lugar" value=<?php echo $consulta["lugar"] ?>>
                    <label>lugar</label>
                </div>
                <div class="user-box">
                    <input type="text" name="motivo" value=<?php echo $consulta["motivo"] ?>>
                    <label>motivo</label>
                </div>
                <div class="user-box idCliente">
                    <select id="cliente_id" name="idCliente">
                        <?php
                        $consultaId = $conexion->query("select id from clientes");
                        $consultaIds = $consultaId->fetch_all(MYSQLI_ASSOC);
                        foreach ($consultaIds as $value) {
                            if ($value["id"] == $consulta["Id_cliente"]) {
                                echo "<option value='$value[id]'selected>$value[id]</option>";
                            } else {
                                echo "<option value='$value[id]'>$value[id]</option>";
                            }
                        }
                        ?>
                    </select>
                    <label>Id cliente</label>
                </div>
                <input type="submit" name="enviar">
            </form>
        </div>
        <?php
        if (isset($_POST['enviar'])) {
            if (!$_POST["fecha"] || !$_POST["hora"] || !$_POST["lugar"] || !$_POST["motivo"] || !$_POST["idCliente"]) {
                echo "<h2>Todos los campos deben estar rellenados</h2>";
            } else {
                $lugar = trim($_POST["lugar"]);
                $mot = trim($_POST["motivo"]);
                $busqueda = $conexion->prepare("update citas set fecha=?, hora=?, lugar=?, motivo=?, Id_cliente=? where id =$_POST[id]");
                $busqueda->bind_param("ssssi", $_POST["fecha"], $_POST["hora"], $lugar, $mot, $_POST["idCliente"]);
                $busqueda->execute();
                $busqueda->close();
                header("refresh:1 ; url= ./citas.php");
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