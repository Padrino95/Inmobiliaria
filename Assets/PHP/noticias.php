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
        <!--==========================================================VER MAS==========================================================-->
        <section id="vermas" class="imagenes">
            <?php
            require_once "../Funciones/conexion.php";
            $conexion = conectar();
            ?>
        </section>
        <section id="form">
            <?php
            $consulta = "select AUTO_INCREMENT from information_schema.tables where table_schema= 'inmobiliaria' and table_name='noticias'";
            $resultado = $conexion->query($consulta);
            if (!$resultado) {
                echo "Consulta mal escrita";
            } else {
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            }

            ?>
            <div class="form-box">
                <h2>Añade una noticia</h2>
                <form method="post" action="#" enctype="multipart/form-data">
                    <div class="user-box">
                        <input type="text" readonly name="id" value=<?php echo $datos[0]['AUTO_INCREMENT']; ?>> <br>
                        <label>Id</label>
                    </div>
                    <div class="user-box">
                        <input type="text" name="titular">
                        <label>Titular</label>
                    </div>
                    <div class="user-box">
                        <input type="text" name="contenido">
                        <label>Contenido</label>
                    </div>
                    <div class="user-box">
                        <input type="file" name="imagen">
                        <label>Imagen identificativa</label>
                    </div>
                    <div class="user-box">
                        <input type="date" name="fecha" ;>
                        <label>Fecha</label>
                    </div>

                    <input type="submit" name="enviar">
                </form>
            </div>

            <?php
            // ===========================================================INSERTAR NOTICIA======================================================================================
            if (isset($_POST["enviar"])) {
                if (!$_POST["titular"] || !$_POST["contenido"] || !$_FILES["imagen"] || !$_POST["fecha"]) {
                    echo "Debes rellenar todos los datos correctamente, serás redirigidio...";
                    header("refresh:3 ; url= ./noticias.php");
                } else {
                    $info = pathinfo($_FILES['imagen']['name']);
                    $extension = $info['extension'];
                    if (!file_exists('../Imagenes')) {
                        mkdir("../Imagenes");
                        if (!file_exists('../Imagenes/Noticias')) {
                            mkdir("../Imagenes/Noticias");
                        }
                    }
                    move_uploaded_file($_FILES['imagen']['tmp_name'], "../Imagenes/Noticias/$_POST[id].$extension");

                    $tit = trim($_POST["titular"]);
                    $conte = trim($_POST["contenido"]);
                    $ruta = "$_POST[id].$extension";
                    $inserccion = $conexion->prepare("insert into noticias values (null, ?, ?, ?, ?)");
                    $inserccion->bind_Param("ssss", $tit, $conte, $ruta, $_POST["fecha"]);
                    $inserccion->execute();
                    $inserccion->close();
                    header("refresh:3 ; url= ./noticias.php");
                }
            }
            ?>
        </section>

        <!-- ==============================================================BUSCAR NOTICIA======================================================================================= -->
        <section id="buscarNoticia">
            <div class="form-box">
                <h2>Introduce el titular por el que quieras buscar</h2>
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
                $busqueda = trim($_POST["busqueda"]);
                if (!$busqueda) {
                    echo "No has introducido ningun patron por el que buscar";
                } else {
                    $busquedaNoticia = "%" . $_POST["busqueda"] . "%";
                    $buscar = $conexion->prepare("select * from noticias where titular like ?");
                    $buscar->bind_Param("s", $busquedaNoticia);
                    $buscar->bind_result($id, $titular, $contenido, $imagen, $fecha);
                    $buscar->execute();
                    $buscar->store_result();
                    if ($buscar->num_rows == 0) {
                        echo "No hay datos";
                    } else {
                        while ($buscar->fetch()) {
                            echo "<div class='noticiaCompleta'><h2>$titular numero $id</h2><p>$contenido</p><img src='../Imagenes/Noticias/$imagen'><span>$fecha</span></div>";
                        }
                        $buscar->close();
                    }
                }
            }
            ?>
        </section>
        <section id="tabla" class="imagenes">
            <h2>Aqui se muestran todas las noticias</h2>
            <?php
            // ============================================================MOSTRAR NOTICIAS===================================================================================
            $noticias = $conexion->query("select count(id) total from noticias");
            $numNoticias = $noticias->fetch_array(MYSQLI_ASSOC);
            $totalPaginas = ceil($numNoticias["total"] / 4);

            if (!isset($_GET["pag"])) {
                $paginaActual = 0;
            } else {
                if ($_GET["pag"] < 0) {
                    $paginaActual = 0;
                } elseif ($_GET["pag"] > $totalPaginas - 1) {
                    $paginaActual = $totalPaginas - 1;
                } else {
                    $paginaActual = $_GET["pag"];
                }
            }

            $consulta = $conexion->query("select * from noticias limit " . ($paginaActual * 4) . ",4");
            $datos = $consulta->fetch_all(MYSQLI_ASSOC);
            echo "<table><tr><th>Titular</th><th>Imagen</th><th>Borrar</th><th>Ver mas</th></tr>";
            foreach ($datos as $value) {
                echo "<tr>";
                $fechabien = formatoFecha($value["fecha"]);
                echo "<td> $value[titular]</td><td><img src='../Imagenes/Noticias/$value[imagen]' ></td>";
                echo "<td><form method='post' action=' #'><input type='hidden' name='id' value='$value[id]'><input type='submit' name='enviarBorrarNoticia' value='Borrar'></form></td>";
                echo "<td><form method='post' action=' #'><input type='hidden' name='id' value='$value[id]'><input type='submit' name='enviarVerNoticia' value='Ver'></form></td>";
            }
            echo "</tr></table>";





            // controlar que el boton siguiente no se muestre como enlace en la pagina maxima


            if ($paginaActual == $totalPaginas - 1) {
                echo "<div id='enlacesPaginas'><a href='./noticias.php?pag=" . ($paginaActual - 1) . "'>anterior</a>";
                echo "siguiente</div>";
            } elseif ($paginaActual == 0) {
                echo "<div id='enlacesPaginas'>anterior";
                echo "<a href='./noticias.php?pag=" . ($paginaActual + 1) . "'>siguiente</a></div>";
            } else {
                echo "<div id='enlacesPaginas'>
                <a href='./noticias.php?pag=" . ($paginaActual - 1) . "'>anterior</a>
                <a href='./noticias.php?pag=" . ($paginaActual + 1) . "'>siguiente</a>
                </div>";
            }

            if (isset($_POST["enviarVerNoticia"])) {
                $datos = $conexion->query("select * from noticias where id = $_POST[id]");
                $datos = $datos->fetch_array(MYSQLI_ASSOC);
                $fecha = formatoFecha($datos["fecha"]);
                echo "<div class='noticiaCompleta'>";
                echo "<div>";
                echo "<h2>Mostrando noticia seleccionada</h2>";
                echo "<h3>Noticia numero $datos[id] $datos[titular]</h3>";
                echo "<span>$datos[contenido]</span>";
                $fecha = formatoFecha($datos["fecha"]);
                echo "<p>$fecha</p>";
                echo "<img src='../Imagenes/Noticias/$datos[imagen]'>";
                echo "</div>";
                echo "</div>";
                // echo "<table><tr><th>ID</th><th>Titular</th><th>Contenido</th><th>Imagen</th><th>Fecha</th></tr>";
                // echo "<tr><td>$datos[id]</td><td>$datos[titular]</td><td>$datos[contenido]</td><td><img src='../Imagenes/Noticias/" . $datos["imagen"] . "'></td><td>$fecha</td></tr>";
                // echo "</table>";
            }

            ?>
        </section>
        <!-- ================================================================BORRAR NOTICIA======================================================================================= -->
        <section id="borrarNoticia">
            <?php
            if (isset($_POST["enviarBorrarNoticia"])) {

                $rutaBorrar = $conexion->prepare("select imagen from noticias where id=?");

                $rutaBorrar->bind_param("i", $_POST["id"]);
                $rutaBorrar->bind_result($imagenRuta);
                $rutaBorrar->execute();
                $rutaBorrar->fetch();
                $rutaBorrar->close();

                $borrar = $conexion->prepare("delete from noticias where id=?");
                $borrar->bind_param("i", $_POST['id']);
                $borrar->execute();
                unlink("../Imagenes/Noticias/$imagenRuta");
                $borrar->close();
                echo "<h2>Noticia borrada con éxito</h2> <br>";
                echo "<meta http-equiv='refresh' content='1;url=#'>";
            }
            ?>
        </section>
        <?php
        $conexion->close();
        ?>
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