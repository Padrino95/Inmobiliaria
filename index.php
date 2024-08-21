<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Assets/Styles/Styles.css">
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
     require_once "./Assets/Funciones/conexion.php";
     session_start();
    $id=check();
    pintar('.',$id);

    ?>

    <main>
        <!--==========================================================Imagen aleatoria=============================================================================================-->
        <section id="portada">
            <?php
            $imagenesAleatorias = scandir("./Assets/Imagenes/Inmuebles");
            $aleatoria = rand(2, count($imagenesAleatorias) - 1);
            echo "<div style='background-image: url(./Assets/Imagenes/Inmuebles/$imagenesAleatorias[$aleatoria]); height:100%; background-repeat: no-repeat; background-size: cover; display: flex;
            justify-content: center; align-items: center; color: whitesmoke;font-size: 50px;';><span>Casas destacadas</span></div>";
            ?>


        </section>
        <!--==========================================================ultimas 3 noticias=========================================================================================-->
        <section id="ultimasNoticias" class="imagenes">
            <?php
            $conexion = conectar();
            $hoy = date("Y-m-d");
            $consulta = $conexion->query("select * from noticias where fecha <= '$hoy' order by fecha desc limit 3");
            $datos = $consulta->fetch_all(MYSQLI_ASSOC);
            echo "<h2 >Ultimas Noticias</h2>";
            echo "<div class='mostrar'>";
            foreach ($datos as $value) {
                echo "<div class='noticias'>";
                echo "<h3>$value[titular]</h3>";
                echo "<span>$value[contenido]</span>";
                $fecha = formatoFecha($value["fecha"]);
                echo "<p>$fecha</p>";
                echo "<img src='./Assets/Imagenes/Noticias/$value[imagen]'>";
                echo "<form method='post' action='./Assets/PHP/infonoticia.php'><button type='submit' name='verMas' value='$value[id]'>Ver mas</button></form>";
                echo "</div>";
            }
            echo "</div>";
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