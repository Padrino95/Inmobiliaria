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
    checkAdmin();
    pintar('./Assets/PHP', $id);
    ?>
    <main>
        <section id="form">
            <?php
            require_once "../Funciones/conexion.php";
            $conexion = conectar();
            $consulta = "select AUTO_INCREMENT from information_schema.tables where table_schema= 'inmobiliaria' and table_name='clientes'";
            $resultado = $conexion->query($consulta);
            if (!$resultado) {
                echo "Consulta mal escrita";
            } else {
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            }

            ?>
            <div class="form-box">
                <h2>Añade un cliente</h2>
                <form method="post" action="#" enctype="multipart/form-data">
                    <div class="user-box">
                        <input type="text" readonly name="id" value=<?php echo $datos[0]['AUTO_INCREMENT']; ?>> <br>
                        <label>Id</label>
                    </div>
                    <div class="user-box">
                        <input type="text" name="nombre">
                        <label>Nombre</label>
                    </div>
                    <div class="user-box">
                        <input type="text" name="apellidos">
                        <label>Apellidos</label>
                    </div>
                    <div class="user-box">
                        <input type="text" name="nombreUsuario">
                        <label>Usuario</label>
                    </div>
                    <div class="user-box">
                        <input type="password" name="contraseña">
                        <label>Contraseña</label>
                    </div>
                    <div class="user-box">
                        <input type="text" name="direccion">
                        <label>Direccion</label>
                    </div>
                    <div class="user-box">
                        <input type="text" name="tel1">
                        <label>Teléfono 1</label>
                    </div>
                    <div class="user-box">
                        <input type="text" name="tel2">
                        <label>Teléfono 2</label>
                    </div>
                    <input type="submit" name="enviar">
                </form>
            </div>

            <?php
            if (isset($_POST["enviar"])) {
                if (!$_POST["nombre"] || !$_POST["apellidos"] || !$_POST["direccion"] || !$_POST["tel1"] || !preg_match("/^\+34[6-9][0-9]{8}$/", $_POST["tel1"]) || !$_POST["nombreUsuario"] || !$_POST["contraseña"]) {
                    echo "Debes rellenar todos los datos correctamente, serás redirigidio...";
                    header("refresh:3 ; url= ./clientes.php");
                } else {
                    $nom = trim($_POST["nombre"]);
                    $apellidos = trim($_POST["apellidos"]);
                    $direccion = trim($_POST["direccion"]);
                    $telefono1 = trim($_POST["tel1"]);
                    $telefono2 = trim($_POST["tel2"]);
                    $contraseña = md5(trim($_POST["contraseña"]));
                    $usuario = trim($_POST["nombreUsuario"]);
                    if (!$_POST["tel2"]) {
                        $insertarCliente = "insert into clientes values (null, ?, ?, ?, ?,?,?, null)";
                        $inserccion = $conexion->prepare("$insertarCliente");
                        $inserccion->bind_Param("ssssss", $nom, $apellidos, $usuario, $contraseña, $direccion, $telefono1);
                        $inserccion->execute();
                    } else {
                        if (preg_match("/^\+34[6-9][0-9]{8}$/", $_POST["tel2"])) {
                            $insertarCliente = "insert into clientes values (null, ?, ?, ?, ?, ?,?,?)";
                            $inserccion = $conexion->prepare("$insertarCliente");
                            $inserccion->bind_Param("sssssss", $nom, $apellidos,$usuario, $contraseña, $direccion, $telefono1, $telefono2);
                            $inserccion->execute();
                        } else {
                            echo "Datos mal introducidos";
                        }
                    }
                    header("refresh:3 ; url= ./clientes.php");
                }
            }
            ?>
        </section>
        <section id="form">
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
                    $busqueda = $conexion->prepare("select * from clientes where nombre like ? or apellidos like ? or telefono1 like ? or telefono2 like ?");
                    $busqueda->bind_Param("ssss", $valor, $valor, $valor, $valor);
                    $busqueda->bind_result($id, $nombre, $apellidos, $direccion, $telefono1, $telefono2);
                    $busqueda->execute();
                    $busqueda->store_result();
                    if ($busqueda->num_rows == 0) {
                        echo "No hay datos";
                    } else {
                        echo "<table><tr><th>Id</th><th>Nombre</th><th>Apellidos</th><th>Direccion</th><th>Telefono 1</th><th>Telefono 2</th></tr>";
                        while ($busqueda->fetch()) {
                            echo "<tr><td>$id</td><td>$nombre</td><td>$apellidos</td><td>$direccion</td><td>$telefono1</td><td>$telefono2</td></tr>";
                        }
                        echo "</table>";
                        $busqueda->close();
                        $conexion->close();
                    }
                }
            }
            ?>
        </section>
        <section id="tabla">
            <?php
            $conexion = conectar();
            $consulta = $conexion->query("select * from clientes where id != 0");
            $datos = $consulta->fetch_all(MYSQLI_ASSOC);
            echo "<table><tr><th>Id</th><th>Nombre</th><th>Apellidos</th><th>Direccion</th><th>Telefono 1</th><th>Telefono 2</th><th>Editar</th></tr>";
            foreach ($datos as $value) {
                echo "<tr>";
                echo "<td>$value[id]</td><td>$value[nombre]</td><td>$value[apellidos]</td><td>$value[direccion]</td><td>$value[telefono1]</td><td>$value[telefono2]</td>";
                echo "<td><form method='post' action='./EditarCliente.php'><input type='hidden' name='id' value='$value[id]'><input type='submit' name='enviarEditar' value='Editar'></form></td>";
            }
            echo "</table>";


            $conexion->close();
            ?>
        </section>
    </main>
    <footer>
        <div>
            <div>
                <ul class="lista">
                    <li><a href="./Contacto.html">Contacto</a></li>
                    <li><a href="./FAQ.html">FAQ</a></li>
                    <li><a href="">Copyright © 2023 Requestify Inc. All rights reserved</a></li>
                </ul>
            </div>
        </div>
        <div>
            <span class="material-symbols-outlined">close</span>
            <span class="material-symbols-outlined">Share</span>
            <span class="material-symbols-outlined">Recommend</span>
        </div>
    </footer>
</body>

</html>