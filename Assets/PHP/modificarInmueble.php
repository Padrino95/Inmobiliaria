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
    $id=check();
    checkAdmin();
    pintar('./Assets/PHP',$id);
    ?>
    <main>
        <!--======================================================================EDITAR INMUEBLE======================================================================================-->
        <section id="editarInmueble">
            <div class="form-box">
                <h2>Edita un inmueble</h2>
                <form method="post" action="#">
                    <div class="user-box">
                         <input type='hidden' name='id' value='<?php echo $_POST['id'] ?>'> <!--id inmueble -->
                    </div>
                    <div class="user-box">
                        <select id="cliente_id" name="idCliente">
                            <?php
                            $conexion = conectar();
                            $consultaId = $conexion->query("select nombre, id from clientes where id != 0");
                            $consultaIds = $consultaId->fetch_all(MYSQLI_ASSOC);
                            foreach ($consultaIds as $value) {
                                echo "<option value='$value[id]'>$value[nombre]</option>";
                            }
                            ?>
                        </select>
                        <label id="labelModificarCliente">Cliente</label>
                    </div>
                    <input type="submit" name="enviar">
                </form>
            </div>

            <?php
            if (isset($_POST["enviar"])) {
                if (!$_POST["idCliente"]) {
                    echo "<h2>Debes seleccionar un cliente</h2>";
                } else {
                    $busqueda = $conexion->prepare("update inmuebles set id_cliente =? where id =?");
                    $busqueda->bind_param("ii", $_POST["idCliente"], $_POST["id"]);
                    $busqueda->execute();
                    $busqueda->close();
                    echo "<h2>Inmueble editado correctamente</h2>";
                    echo "<meta http-equiv='refresh' content='3; url=./inmuebles.php'>";
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