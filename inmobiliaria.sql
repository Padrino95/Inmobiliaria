-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-01-2024 a las 22:47:31
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inmobiliaria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `lugar` varchar(100) NOT NULL,
  `motivo` varchar(200) NOT NULL,
  `Id_cliente` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `fecha`, `hora`, `lugar`, `motivo`, `Id_cliente`) VALUES
(1, '2024-01-19', '12:42:00', 'EAG', 'reunión', 1),
(2, '2024-01-13', '12:41:00', 'Plaza de toros', 'reunión', 2),
(3, '2024-02-08', '21:00:00', 'Estación de autobuses', 'Entrevista', 3),
(4, '2024-01-18', '23:07:00', 'Universidad', 'reunion', 2),
(5, '2024-01-26', '22:19:00', 'Cafeteria central', 'meeting', 1),
(6, '2023-12-07', '20:44:00', 'Centro de negocios', 'reunión con posible cliente', 1),
(7, '2024-02-10', '23:04:00', 'Universidad', 'reunión con posible cliente', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(75) NOT NULL,
  `apellidos` varchar(75) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `telefono1` varchar(12) NOT NULL,
  `telefono2` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellidos`, `nombre_usuario`, `pass`, `direccion`, `telefono1`, `telefono2`) VALUES
(0, 'Administrador', 'Administrador', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '000000000', NULL),
(1, 'Alberto', 'Maldonado Lopez', 'Alberto27', 'c54e7837e0cd0ced286cb5995327d1ab', 'c/cisne', '674381559', NULL),
(2, 'Julio', 'López Martín', 'Rom', 'cae82d4350cc23aca7fc9ae38dab38ab', 'av/ Palos de la Frontera 11', '958440383', NULL),
(3, 'David', 'De la marta', 'DavidDSK', '81dc9bdb52d04dc20036dbd8313ed055', 'c/ pedro de valencia 22', '635637791', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inmuebles`
--

CREATE TABLE `inmuebles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `precio` double(10,2) NOT NULL,
  `id_cliente` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `inmuebles`
--

INSERT INTO `inmuebles` (`id`, `imagen`, `direccion`, `descripcion`, `precio`, `id_cliente`) VALUES
(1, '1.jpg', 'c/cisne 3', 'Chalet de primera calidad', 350000.00, 1),
(2, '2.jpg', 'c/ camino de ronda', 'piso totalmente amueblado', 150000.00, 2),
(3, '3.jpg', 'c/ Tranquila 123', 'Ubicada en el apacible Barrio Sereno, esta encantadora casa de dos pisos es perfecta para aquellos que buscan una vida tranquila sin alejarse demasiado de las comodidades urbanas. Con tres dormitorios amplios, dos baños modernos y una cocina totalmente equipada, esta propiedad es ideal para familias o aquellos que buscan espacio adicional para oficinas en casa. El jardín trasero ofrece un refugio sereno, perfecto para relajarse después de un día agitado.', 250000.00, NULL),
(4, '4.jpg', 'Avd Moderna 145', 'Si anhelas el estilo de vida urbano, este moderno apartamento en el Centro Urbano es una opción ideal. Con impresionantes vistas panorámicas desde las ventanas del piso al techo, este condominio de lujo de un dormitorio ofrece un diseño contemporáneo y comodidades de primer nivel. Disfruta de acceso directo a tiendas de moda, restaurantes y vida nocturna. Este es el lugar perfecto para aquellos que buscan el ajetreo de la ciudad a su puerta.', 300000.00, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titular` varchar(100) NOT NULL,
  `contenido` varchar(500) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`id`, `titular`, `contenido`, `imagen`, `fecha`) VALUES
(1, 'Granada Experimenta un Auge Inmobiliario: El Mercado Se Calienta', 'En un emocionante giro para el mercado inmobiliario local, Granada está experimentando un auge sin precedentes en la demanda de propiedades. La ciudad, conocida por su rica historia y encanto cultural, está viendo un aumento significativo en la búsqueda de viviendas. Con una combinación de propiedades históricas y desarrollos modernos, Granada se está convirtiendo rápidamente en el destino elegido para aquellos que buscan la combinación perfecta de tradición y estilo de vida contemporáneo.', '1.jpg', '2024-01-11'),
(2, 'Nueva Opción Ecológica en Granada: Desarrollo de Viviendas Sostenibles', 'La inmobiliaria de Granada se enorgullece de presentar un emocionante desarrollo de viviendas sostenibles en el corazón de la ciudad. Este proyecto vanguardista no solo ofrece comodidades modernas, sino que también se centra en la sostenibilidad ambiental. Desde sistemas de energía renovable hasta diseños que maximizan la eficiencia energética, estas propiedades representan un paso audaz hacia un futuro más ecológico. Descubre cómo puedes vivir de manera sostenible sin comprometer el lujo.', '2.jpg', '2024-01-09'),
(3, 'Granada: Un Destino Emergente para Inversionistas Inmobiliarios', 'Los inversionistas inmobiliarios están mirando con interés hacia Granada, ya que la ciudad emerge como un destino de inversión prometedor. Con un mercado inmobiliario en crecimiento y una demanda constante de propiedades únicas, Granada se ha convertido en el foco de atención de aquellos que buscan oportunidades estratégicas. La combinación de precios competitivos y la belleza arquitectónica única de la ciudad ha atraído la atención de inversionistas locales e internacionales.', '3.jpg', '2024-01-02'),
(4, 'Granada Innovadora: Proyecto de Viviendas Inteligentes Rompe Barreras', 'En un paso audaz hacia el futuro, un nuevo proyecto residencial en Granada está llevando la experiencia de vivir a un nivel completamente nuevo. Estas viviendas inteligentes, equipadas con tecnología de vanguardia, ofrecen a los residentes un control sin precedentes sobre su entorno. Desde sistemas de seguridad avanzados hasta la automatización del hogar, estas propiedades están redefiniendo el concepto de comodidad y eficiencia en el mercado inmobiliario de Granada. Descubre cómo la innovación ', '4.jpg', '2024-02-01');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_c_c` (`Id_cliente`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Id` (`id`);

--
-- Indices de la tabla `inmuebles`
--
ALTER TABLE `inmuebles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Id` (`id`),
  ADD KEY `inmuebles_ibfk_1` (`id_cliente`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `inmuebles`
--
ALTER TABLE `inmuebles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `id_c_c` FOREIGN KEY (`Id_cliente`) REFERENCES `clientes` (`id`);

--
-- Filtros para la tabla `inmuebles`
--
ALTER TABLE `inmuebles`
  ADD CONSTRAINT `inmuebles_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
