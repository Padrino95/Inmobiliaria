<?php
function conectar()
{
    $conectar = new mysqli("localhost", "root", "", "inmobiliaria");
    $conectar->set_charset("UTF8");
    return $conectar;
}
?>

<?php
function checkAdmin()
{
    $id = check();
    if ($id > 0) {
        header("refresh:0;url=../../index.php");
    }elseif ($id==-1) {
        header("refresh:0;url=./acceder.php");
    }
}
function checkUser()
{
    $id = check();
    if ($id == -1) {
        header("refresh:0;url=./acceder.php");
    }elseif ($id==0) {
        header("refresh:0;url=../../index.php");
    }
}
function check()
{
    if (isset($_COOKIE['sesion'])) {
        session_decode($_COOKIE['sesion']);
        $id = $_SESSION['id'];
    } elseif (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
    } else {
        $id = -1;
    }
    return $id;
}
function pintar($ruta, $id)
{
    if ($ruta == './Assets/PHP') {
        $index = '../..';
        $logo = '..';
        $ruta2 = ".";
    } else {
        $index = '.';
        $logo = './Assets';
        $ruta2 = "/Assets/PHP";
    }
    if ($id == 0) {
        echo "<header>
            <div><img src='$logo/Imagenes/Index/logo.png'></div>
            <nav>
                <ul class='lista'>
                    <li><a href='$index/index.php'>Inicio</a></li>
                    <li><a href='$ruta2/noticias.php'>Noticias</a></li>
                    <li><a href='$ruta2/clientes.php'>Clientes</a></li>
                    <li><a href='$ruta2/inmuebles.php'>Inmuebles</a></li>
                    <li><a href='$ruta2/citas.php'>Citas</a></li>
                    <li><a href='$ruta2/contacto.php'>Contacto</a></li>
                    <li><a href='$ruta2/acceder.php?cerrar'>Cerrar sesión de $_SESSION[usuario]</a></li>
                </ul>
            </nav>
            <div>
                <div>
                    <div><span class='material-symbols-outlined'>search</span></div>
                    <div><input type='text' name='buscar'></div>
                </div>
                <div><span class='material-symbols-outlined' class='relleno'>shopping_cart</span></div>
            </div>
        </header>";
    } elseif ($id > 0) {
        echo "<header>
            <div><img src='$logo/Imagenes/Index/logo.png'></div>
            <nav>
                <ul class='lista'>
                    <li><a href='$index/index.php'>Inicio</a></li>
                    <li><a href='$ruta2/misDatos.php'>Mis datos personales</a></li>
                    <li><a href='$ruta2/misInmuebles.php'>Mis inmuebles</a></li>
                    <li><a href='$ruta2/inmueblesDisponibles.php'>Inmuebles disponibles</a></li>
                    <li><a href='$ruta2/misCitas.php'>Mis citas</a></li>
                    <li><a href='$ruta2/acceder.php?cerrar'>Cerrar sesión de $_SESSION[usuario]</a></li>
                </ul>
            </nav>
            <div>
                <div>
                    <div><span class='material-symbols-outlined'>search</span></div>
                    <div><input type='text' name='buscar'></div>
                </div>
                <div><span class='material-symbols-outlined' class='relleno'>shopping_cart</span></div>
            </div>
        </header>";
    } else {
        echo "<header>
            <div><img src='$logo/Imagenes/Index/logo.png'></div>
            <nav>
                <ul class='lista'>
                    <li><a href='$index/index.php'>Inicio</a></li>
                    <li><a href='$ruta2/inmueblesDisponibles.php'>Inmuebles</a></li>
                    <li><a href='$ruta2/acceder.php'>Acceder</a></li>
                    <li><a href='$ruta2/contacto.php'>Contacto</a></li>

                </ul>
            </nav>
            <div>
                <div>
                    <div><span class='material-symbols-outlined'>search</span></div>
                    <div><input type='text' name='buscar'></div>
                </div>
                <div><span class='material-symbols-outlined' class='relleno'>shopping_cart</span></div>
            </div>
        </header>";
    }
}
?>

<?php
function footer()
{
    echo "<footer>
            <div>
                <div>
                    <ul class='lista'>
                        <li><a href='./Contacto.html'>Contacto</a></li>
                        <li><a href='./FAQ.html'>FAQ</a></li>
                        <li><a href=''>Copyright © 2023 Requestify Inc. All rights reserved</a></li>
                    </ul>
                </div>
            </div>
            <div>
                <span class='material-symbols-outlined'>close</span>
                <span class='material-symbols-outlined'>Share</span>
                <span class='material-symbols-outlined'>Recommend</span>
            </div>
        </footer>";
}
?>

<?php
function formatoFecha($fecha)
{
    setlocale(LC_ALL, 'es_ES');
    $marcaTiempo = strtotime($fecha);
    $formato = strftime('%d/%m/%Y', $marcaTiempo);
    return $formato;
}
?>

<?php
function calendario($dia, $mes, $año)
{

    $marcaTiempoPrimerDia = mktime(0, 0, 0, $mes, 1, $año);
    $diaMes = date("N", $marcaTiempoPrimerDia);
    $dias = date("t", $marcaTiempoPrimerDia);
    $celda = 1;

    $hoyA = date("d");
    $mesA = date("n");
    $añoA = date("Y");


    setlocale(LC_ALL, 'es-ES');
    $Nombremes = strftime('%B', $marcaTiempoPrimerDia);
    echo "<h2 style='text-align:center;'>Estás visualizando $Nombremes de $año</h2>";
    echo "<table><tr><th>L</th><th>M</th><th>X</th><th>J</th><th>V</th><th>S</th><th>D</th></tr><tr>";
    for ($i = 1; $i < $diaMes; $i++) {
        echo "<td></td>";
        $celda++;
    }
    for ($i = 1; $i <= $dias; $i++) {
        if (existeCita($i, $mes, $año)) {
            if ($i == $hoyA && $mes == $mesA && $año == $añoA) {
                echo "<td style='text-align:center; background-color:#d9d9c2'><a style='color:yellow' href='./detalleCita.php?enviado=1&dia=$i&mes=$mes&año=$año'>$i</a></td>";
            } else {
                echo "<td style='text-align:center; background-color:#d9d9c2'><a href='./detalleCita.php?enviado=1&dia=$i&mes=$mes&año=$año'>$i</a></td>";
            }
            $celda++;
            if ($celda == 8) {
                $celda = 1;
                echo "</tr><tr>";
            }
        } else {
            if ($i == $hoyA && $mes == $mesA && $año == $añoA) {
                echo "<td style='text-align:center; color:yellow; background-color:#675c58'>$i</td>";
            } else {
                echo "<td style='text-align:center; background-color:#675c58'>$i</td>";
            }
            $celda++;
            if ($celda == 8) {
                $celda = 1;
                echo "</tr><tr>";
            }
        }
    }
    echo "</table><br><br>";
}
?>

<?php
function existeCita($dia, $mes, $año)
{
    $conexion = conectar();
    $fecha = "$año-$mes-$dia";
    $datos = $conexion->query("select * from citas where fecha='$fecha'");
    if ($datos->num_rows > 0) {
        $conexion->close();
        return true;
    } else {
        $conexion->close();
        return false;
    }
}

function existeCitaCliente($dia, $mes, $año, $idCliente)
{
    $conexion = conectar();
    $fecha = "$año-$mes-$dia";
    $datos = $conexion->query("select * from citas where fecha='$fecha' and Id_cliente='$idCliente'");
    if ($datos->num_rows > 0) {
        $conexion->close();
        return true;
    } else {
        $conexion->close();
        return false;
    }
}

function calendarioCliente($dia, $mes, $año, $idCliente)
{

    $marcaTiempoPrimerDia = mktime(0, 0, 0, $mes, 1, $año);
    $diaMes = date("N", $marcaTiempoPrimerDia);
    $dias = date("t", $marcaTiempoPrimerDia);
    $celda = 1;

    $hoyA = date("d");
    $mesA = date("n");
    $añoA = date("Y");


    setlocale(LC_ALL, 'es-ES');
    $Nombremes = strftime('%B', $marcaTiempoPrimerDia);
    echo "<h2 style='text-align:center;'>Estás visualizando $Nombremes de $año</h2>";
    echo "<table><tr><th>L</th><th>M</th><th>X</th><th>J</th><th>V</th><th>S</th><th>D</th></tr><tr>";
    for ($i = 1; $i < $diaMes; $i++) {
        echo "<td></td>";
        $celda++;
    }
    for ($i = 1; $i <= $dias; $i++) {

        if (existeCitaCliente($i, $mes, $año, $idCliente)) {
            if ($i == $hoyA && $mes == $mesA && $año == $añoA) {
                echo "<td style='text-align:center; color:yellow; background-color:#d9d9c2'><a href='./detalleCita.php?enviado=1&dia=$i&mes=$mes&año=$año'>$i</a></td>";
            } else {
                echo "<td style='text-align:center; background-color:#d9d9c2'><a href='./detalleCita.php?enviado=1&dia=$i&mes=$mes&año=$año'>$i</a></td>";
            }
            $celda++;
            if ($celda == 8) {
                $celda = 1;
                echo "</tr><tr>";
            }
        } else {
            if ($i == $hoyA && $mes == $mesA && $año == $añoA) {
                echo "<td style='text-align:center; color:yellow; background-color:#675c58'>$i</td>";
            } else {
                echo "<td style='text-align:center; background-color:#675c58'>$i</td>";
            }
            $celda++;
            if ($celda == 8) {
                $celda = 1;
                echo "</tr><tr>";
            }
        }
    }
    echo "</table><br><br>";
}
?>