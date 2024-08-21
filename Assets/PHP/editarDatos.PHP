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
    checkUser();
    pintar('./Assets/PHP', $id);
    ?>
    <main>
        <section id="editarDatos">
            <?php
            if (isset($_POST['enviarEditar'])) {
                $conexion = conectar();
                $consulta = $conexion->query("select * from clientes where id='$_POST[id]'");
                $datos = $consulta->fetch_all(MYSQLI_ASSOC);
                $direcc = $datos[0]["direccion"];
                $tel1 = $datos[0]["telefono1"];
                $tel2 = $datos[0]["telefono2"];
                echo "<div class='form-box'>
                <h2>Edita un cliente</h2>
                <form method='post' action='#'>
                    <div class='user-box'>
                        <input type='text' name='contraseña' placeholder='🔒' ?>
                        <label>Contraseña</label>
                    </div>
                    <div class='user-box'>
                        <input type='text' name='direccion' value= $direcc>
                        <label>Direccion</label>
                    </div>
                    <div class='user-box'>
                        <input type='text' name='tel1' value=$tel1>
                        <label>Teléfono 1</label>
                    </div>
                    <div class='user-box'>
                        <input type='text' name='tel2' value=$tel2>
                        <label>Teléfono 2</label>
                    </div>
                    <div>
                        <input type='hidden' name='id' value='$_POST[id]'>
                    </div>
                    <input type='submit' name='enviar2'>
                </form>
            </div>";
            }
            ?>
            <?php
            if (isset($_POST['enviar2'])) {
                if (!$_POST["direccion"] || !$_POST["tel1"]) {
                    echo "Debes rellenar todos los campos para poder editar tus datos personales";
                } else {
                    $conexion = conectar();
                    $direccion = trim($_POST["direccion"]);
                    $telefono1 = trim($_POST["tel1"]);
                    if (!$_POST["tel2"]) {
                        if (!$_POST["contraseña"]) {
                            $editarCliente = $conexion->prepare("UPDATE clientes SET direccion = ?, telefono1 = ?, telefono2 = null WHERE id = ?;");
                            $editarCliente->bind_Param("ssi", $direccion, $telefono1, $_POST['id']);
                            $editarCliente->execute();
                            header("refresh:3 ; url= ./clientes.php");
                        } else {
                            $contraseña = md5(trim($_POST["contraseña"]));
                            $editarCliente = $conexion->prepare("UPDATE clientes SET  pass=?, direccion = ?, telefono1 = ?, telefono2 = null WHERE id = ?;");
                            $editarCliente->bind_Param("sssi",  $contraseña, $direccion, $telefono1, $_POST['id']);
                            $editarCliente->execute();
                            header("refresh:3 ; url= ./clientes.php");
                        }
                    } else {
                        $telefono2 = trim($_POST["tel2"]);
                        if (!$_POST["contraseña"]) {
                            $editarCliente = $conexion->prepare("UPDATE clientes SET direccion = ?, telefono1 = ?, telefono2 = ? WHERE id = ?;");
                            $editarCliente->bind_Param("sssi", $direccion, $telefono1, $telefono2, $_POST['id']);
                            $editarCliente->execute();
                            header("refresh:3 ; url= ./clientes.php");
                        } else {
                            $contraseña = md5(trim($_POST["contraseña"]));
                            $editarCliente = $conexion->prepare("UPDATE clientes SET  pass=?, direccion = ?, telefono1 = ?, telefono2 = ? WHERE id = ?;");
                            $editarCliente->bind_Param("ssssi",  $contraseña, $direccion, $telefono1, $telefono2, $_POST['id']);
                            $editarCliente->execute();
                            header("refresh:3 ; url= ./clientes.php");
                        }
                    }
                }
            }
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