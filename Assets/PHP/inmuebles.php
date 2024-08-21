<!DOCTYPE html>
<html lang="en">

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
    $id=check();
    checkAdmin();
    pintar('./Assets/PHP',$id);
    ?>
    <main>
        <!--===========================================AÑADIR INMUEBLE==========================================================================================-->
        <section id="añadirInmueble">
            <?php
            require_once "../Funciones/conexion.php";
            $conexion = conectar();
            $consulta = "select AUTO_INCREMENT from information_schema.tables where table_schema= 'inmobiliaria' and table_name='inmuebles'";
            $resultado = $conexion->query($consulta);
            if (!$resultado) {
                echo "Consulta mal escrita";
            } else {
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            }

            ?>
            <div class="form-box">
                <h2>Añade un inmueble</h2>
                <form method="post" action="#" enctype="multipart/form-data">
                    <div class="user-box">
                        <input type="text" readonly name="id" value=<?php echo $datos[0]['AUTO_INCREMENT']; ?>> <br>
                        <label>Id</label>
                    </div>
                    <div class="user-box">
                        <input type="text" name="direccion">
                        <label>Direccion</label>
                    </div>
                    <div class="user-box">
                        <input type="text" name="descripcion">
                        <label>Descripcion</label>
                    </div>
                    <div class="user-box">
                        <input type="text" name="precio">
                        <label>Precio</label>
                    </div>
                    <div class="user-box">
                        <input type="file" name="imagen">
                        <label>Imagen </label>
                    </div>
                    <input type="submit" name="enviar">
                </form>
            </div>
            <?php
            if (isset($_POST["enviar"])) {
                if (!$_POST["direccion"] || !$_POST["descripcion"] || !$_POST["precio"] || !$_FILES["imagen"]) {
                    echo "<h2>Debes introducir todos los datos</h2>";
                    header("refresh:10 ; url=#");
                } else {
                    $info = pathinfo($_FILES['imagen']['name']);
                    $extension = $info['extension'];
                    if (!file_exists('../Imagenes')) {
                        mkdir("../Imagenes");
                        if (!file_exists('../Imagenes/inmuebles')) {
                            mkdir("../Imagenes/inmuebles");
                        }
                    }
                    move_uploaded_file($_FILES['imagen']['tmp_name'], "../Imagenes/inmuebles/$_POST[id].$extension");

                    $ruta = "$_POST[id].$extension";

                    $insertar = $conexion->prepare("insert into inmuebles values(null,?,?,?,?,null)");
                    $insertar->bind_param("ssss",$ruta, $_POST["direccion"], $_POST["descripcion"],  $_POST["precio"]);
                    $insertar->execute();
                    $insertar->close();
                    header("refresh:3 ; url=#");
                }
            }
            ?>
        </section>
        <!--==================================================================MOSTRAR INMUEBLE====================================================================================-->
        <section id="mostrarInmuebles" class="imagenes">
            <?php
            $datos = $conexion->query("select * from inmuebles");
            if (!$datos) {
                echo "Consulta mal escrita";
            } else {
                $resultado = $datos->fetch_all(MYSQLI_ASSOC);
                if (!$resultado) {
                    echo "<h2 style='width:25%; margin:auto;margin-bottom:40px;'>No hay inmuebles que mostrar</h2>";
                } else {
                    echo "<h2 style='width:25%; margin:auto;margin-bottom:40px;'>Mostrando todos los inmuebles</h2>";
                    echo "<table><tr><th>Direccion</th><th>Imagen</th><th>Nombre Cliente</th><th>Borrar</th><th>Modificiar</th></tr>";
                    foreach ($resultado as $value) {
                        if ($value["id_cliente"] == null) {
                            echo "<tr><td>$value[direccion]</td><td><a href='./infoInmueble.php?id=$value[id]'><img src='../Imagenes/Inmuebles/$value[imagen]'></a></td><td>disponible</td>
                            <td><form method='post' action='#'><input type='hidden' name='id' value='$value[id]'><input type='submit' name='enviarBorrarInmueble' value='Borrar'></form></td>
                            <td><form method='post' action='./modificarInmueble.php'><input type='hidden' name='id' value='$value[id]'><input type='submit' name='enviarModificarInmueble' value='Modificar'></form></td></tr>";
                        } else {
                            $datos = $conexion->query("select nombre from clientes where id = $value[id_cliente]");
                            $resultado = $datos->fetch_array(MYSQLI_ASSOC);
                            echo "<tr><td>$value[direccion]</td><td><a href='./infoInmueble.php?id=$value[id]'><img src='../Imagenes/Inmuebles/$value[imagen]'></a></td><td>$resultado[nombre]</td>
                            <td><form method='post' action='#'><input type='hidden' name='id' value='$value[id]'><input type='submit' name='enviarBorrarInmueble' value='Borrar' disabled></form></td>
                            <td><form method='post' action='./modificarInmueble.php'><input type='hidden' name='id' value='$value[id]'><input type='submit' name='enviarModificarInmueble' value='Modificar' disabled></form></td></tr>";
                        }
                    }
                    echo "</table>";
                }
            }
            ?>
        </section>
        <!--==================================================================BUSCAR INMUEBLE==========================================================================================-->
        <section id="buscarInmueble" class="imagenes">
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
                    $busqueda = $conexion->prepare("select * from inmuebles where direccion like ? or precio like ?");
                    $busqueda->bind_param("ss", $valor, $valor);
                    $busqueda->bind_result($id, $imagen, $direccion, $descripcion, $precio, $idCliente);
                    $busqueda->execute();
                    $busqueda->store_result();
                    if ($busqueda->num_rows == 0) {
                        echo "No hay datos";
                    } else {
                        echo "<table><tr><th>Id</th><th>Direccion</th><th>Descripcion</th><th>Precio</th><th>Imagen</th><th>Id Cliente</th></tr>";
                        while ($busqueda->fetch()) {
                            if ($idCliente == null) {
                                echo "<tr><td>$id</td><td>$direccion</td><td>$descripcion</td><td>$precio</td><td><img src='../Imagenes/Inmuebles/$imagen'></td><td>disponible</td></tr>";
                            } else {
                                echo "<tr><td>$id</td><td>$direccion</td><td>$descripcion</td><td>$precio</td><td><img src='../Imagenes/Inmuebles/$imagen'></td><td>$idCliente</td></tr>";
                            }
                        }
                        echo "</table>";
                        $busqueda->close();
                    }
                }
            }
            ?>
        </section>
        <!--==============================================================================BORRAR INMUEBLE=============================================================================-->
        <section id="borrarInmueble">
            <?php
            if (isset($_POST["enviarBorrarInmueble"])) {
                // sacamos la ruta de la imagen
                $rutaBorrar = $conexion->prepare("select imagen from inmuebles where id =?");
                $rutaBorrar->bind_param("i", $_POST["id"]);
                $rutaBorrar->bind_result($ruta);
                $rutaBorrar->execute();
                $rutaBorrar->fetch();
                $rutaBorrar->close();

                //borramos la iamgen de local 
                unlink("../Imagenes/Inmuebles/$ruta");

                //borramos el inmueble de la BD
                $borrar = $conexion->prepare("delete from inmuebles where id =?");
                $borrar->bind_param("i", $_POST["id"]);
                $borrar->execute();
                $borrar->close();

                echo "<h2>Inmueble borrado con éxito</h2>";
                echo "<meta http-equiv='refresh' content='1; url=#'>";
            }
            ?>
        </section>
        <?php
        $conexion->close();
        ?>
    </main>
    <?php
    footer();
    ?>
</body>

</html>