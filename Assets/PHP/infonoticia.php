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
    <main>
        <!--==========================================================VER MAS==========================================================-->
        <section id="vermas" class="imagenes">
            <?php
            require_once "../Funciones/conexion.php";
            $conexion = conectar();
            if (isset($_POST["verMas"])) {
                $datos = $conexion->query("select * from noticias where id = $_POST[verMas]");
                $datos = $datos->fetch_array(MYSQLI_ASSOC);
                $fecha = formatoFecha($datos["fecha"]);
                echo "<div class='noticiaCompleta'>
                <div><img src='../Imagenes/Noticias/" . $datos["imagen"] . "'></div>
                <h2>Noticia numero $datos[id]. $datos[titular]</h2>
                <p>$datos[contenido]</p>
                <span>Granada $fecha</span>
            </div>";
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