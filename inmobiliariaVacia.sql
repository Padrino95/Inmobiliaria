-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2023 a las 12:42:22
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
(1, '2023-12-15', '14:00:00', 'Oficina principal', 'Presentación de propiedades disponibles', 1),
(2, '2023-12-20', '16:30:00', 'Café del Centro', 'Discusión de requisitos y preferencias', 2),
(3, '2024-01-05', '11:00:00', 'Residencia del cliente', 'Inspección de propiedad', 3),
(4, '2024-01-10', '15:45:00', 'Sala Principal', 'Revisión', 4),
(5, '2023-12-18', '12:30:00', 'Restaurante La Terraza', 'Almuerzo de presentación', 5),
(6, '2024-01-08', '10:15:00', 'Oficina de diseño de interiores', 'Asesoramiento en decoración', 6),
(7, '2023-12-22', '17:00:00', 'Centro de conferencias', 'Participación en feria inmobiliaria', 7),
(8, '2024-01-03', '14:45:00', 'Propiedad en venta', 'Visita a propiedad', 8),
(9, '2023-12-12', '13:00:00', 'Club de golf', 'Discusión de propiedades exclusivas', 9),
(10, '2023-12-28', '09:30:00', 'Centro de negocios', 'Sesión de planificación estratégica', 10),
(11, '2023-12-18', '16:00:00', 'Oficina de Ventas', 'Revisión de Propiedades', 8),
(12, '2023-12-06', '10:30:00', 'Sala de Reuniones', 'Discusión de Requisitos', 1),
(13, '2023-12-01', '14:15:00', 'Cafetería Central', 'Presentación de Opciones', 2),
(14, '2023-11-25', '11:00:00', 'Oficina Principal', 'Negociación de Contrato', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(75) NOT NULL,
  `apellidos` varchar(75) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `telefono1` varchar(12) NOT NULL,
  `telefono2` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellidos`, `direccion`, `telefono1`, `telefono2`) VALUES
(1, 'Juan', 'Martínez López', 'Calle Gran Vía, 123', '+34612345678', '+34678901234'),
(2, 'Ana', 'García Ruiz', 'Avenida Principal, 456', '+34679012345', NULL),
(3, 'Manuel', 'Fernández Pérez', 'Plaza del Sol, 789', '+34687890123', '+34679012345'),
(4, 'Laura', 'Rodríguez Gómez', 'Calle Mayor, 101', '+34654321098', NULL),
(5, 'David', 'Sánchez Martín', 'Paseo de la Castellana, 210', '+34645678901', '+34654321098'),
(6, 'María', 'Pérez González', 'Calle Real, 567', '+34678901234', NULL),
(7, 'Javier', 'López Hernández', 'Avenida de la Libertad, 876', '+34687890123', '+34678901234'),
(8, 'Marta', 'Gómez Rodríguez', 'Callejón de los Sueños, 543', '+34679012345', NULL),
(9, 'Carlos', 'Martínez Pérez', 'Ronda de la Luna, 987', '+34612345678', '+34679012345'),
(10, 'Isabel', 'Ruiz Sánchez', 'Callejón Sin Salida, 234', '+34654321098', '+34612345678');

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
(2, '2.jpg', 'Avenida Principal, 456', 'Amplio apartamento con vistas panorámicas. Totalmente amueblado y equipado. A pocos minutos del centro de la ciudad.', 250000.00, NULL),
(3, '3.jpg', 'Avenida del Parque, 456', 'Casa adosada con jardín y garaje. Zona tranquila y segura. Perfecta para familias.', 350000.00, 4),
(4, '4.jpg', 'Plaza del Sol, 789', 'Loft moderno en el corazón del centro histórico. Techos altos y diseño contemporáneo.', 180000.00, NULL),
(5, '5.jpg', 'Calle Robles, 101', 'Chalet independiente con piscina y amplio jardín. Entorno natural y privado.', 450000.00, NULL),
(6, '6.jpg', 'Paseo de la Playa, 210', 'Ático con terraza frente al mar. Vistas espectaculares y acceso directo a la playa.', 600000.00, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titular` varchar(100) NOT NULL,
  `contenido` varchar(1000) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`id`, `titular`, `contenido`, `imagen`, `fecha`) VALUES
(1, 'Granada, una joya en el mercado inmobiliario: Descubre las mejores oportunidades', 'En el pintoresco escenario de Granada, te ofrecemos un abanico de oportunidades únicas en el mercado inmobiliario. Desde encantadores apartamentos con vistas a la Alhambra hasta modernas residencias en el corazón del Albayzín, nuestra inmobiliaria está comprometida en ayudarte a encontrar el hogar de tus sueños. Con más de dos décadas de experiencia, conocemos cada rincón de esta ciudad andaluza y hemos seleccionado cuidadosamente propiedades que reflejan la esencia de Granada. Descubre la fusión entre la rica historia de la ciudad y las comodidades modernas en cada rincón de nuestros listados. Ya sea que busques la tranquilidad de la Vega de Granada o la vitalidad del centro histórico, estamos aquí para convertir tus sueños inmobiliarios en realidad. ¡Explora con nosotros y encuentra tu lugar en esta joya del sur de España!', '1.jpg', '2023-12-06'),
(2, 'Viviendas con encanto andaluz: Descubre la esencia de Granada', 'Sumérgete en la auténtica esencia andaluza con nuestras exclusivas propiedades en Granada. Desde casas tradicionales con patios llenos de flores hasta modernos pisos que capturan la esencia del estilo de vida único de la región. Cada propiedad que ofrecemos cuenta una historia de tradición y modernidad, fusionando la arquitectura andaluza con las comodidades contemporáneas. En la ciudad de Granada, donde la historia se mezcla con la vida moderna, nuestras viviendas reflejan la riqueza cultural y la calidez de este rincón del sur de España. Descubre la autenticidad en cada rincón de tu nuevo hogar y deja que la esencia de Granada se convierta en parte de tu vida diaria.', '2.jpg', '2023-12-08'),
(3, 'Inversiones inteligentes en Granada: El mercado inmobiliario en auge', 'Granada no solo es un lugar encantador para vivir, sino también una oportunidad de inversión excepcional. Nuestra inmobiliaria te presenta un análisis del mercado en constante crecimiento en esta ciudad andaluza. Desde apartamentos en el animado centro hasta encantadoras casas en los suburbios, hay opciones para todos los inversores. Descubre cómo el mercado inmobiliario de Granada ofrece rendimientos sólidos y crecimiento a largo plazo. Con un equipo de expertos en el mercado local, estamos aquí para guiarte en cada paso de tu viaje de inversión. ¡Aprovecha el auge del mercado inmobiliario en Granada y haz inversiones inteligentes que perduren!', '3.jpg', '2023-12-04'),
(4, 'Nuevo proyecto residencial: Exclusividad y confort en el corazón de Granada', 'Te presentamos nuestro último proyecto residencial en Granada, una fusión perfecta de exclusividad y confort. Descubre viviendas diseñadas con elegancia y atención al detalle, ubicadas estratégicamente en el corazón de esta ciudad andaluza. Desde modernos apartamentos con vistas panorámicas hasta acogedores estudios, cada residencia ofrece un espacio que refleja calidad y estilo de vida contemporáneo. El proyecto incorpora comodidades modernas, zonas verdes y una arquitectura distintiva que armoniza con el entorno histórico. Conviértete en parte de esta experiencia única y descubre la combinación perfecta de exclusividad y confort en el corazón de Granada.', '4.jpg', '2023-12-07'),
(5, 'Viviendas sostenibles en Granada: Un compromiso con el futuro', 'En nuestra inmobiliaria, estamos comprometidos con un enfoque sostenible para el hogar. Presentamos una selección exclusiva de viviendas sostenibles en Granada, diseñadas para aquellos que buscan un equilibrio entre el lujo moderno y la responsabilidad ambiental. Desde la eficiencia energética hasta materiales respetuosos con el medio ambiente, estas propiedades representan el futuro del estilo de vida sostenible. Descubre cómo puedes vivir en armonía con la naturaleza sin comprometer el confort y la elegancia. Únete a nosotros en el viaje hacia un futuro más sostenible y experimenta la innovación en cada rincón de tu nuevo hogar en Granada.', '5.jpg', '2023-12-03'),
(6, 'Lujo andaluz: Propiedades exclusivas en Granada', 'Experimenta el verdadero lujo andaluz con nuestras propiedades exclusivas en Granada. Desde majestuosas villas con jardines exuberantes hasta elegantes pisos con vistas panorámicas, estas residencias ofrecen un estilo de vida excepcional en una de las ciudades más cautivadoras de España. Cada propiedad refleja la elegancia y el lujo, fusionando el encanto andaluz con comodidades modernas. Descubre la excelencia en cada detalle, desde acabados de alta gama hasta servicios personalizados. Si buscas un hogar que trascienda las expectativas, nuestras propiedades exclusivas en Granada te ofrecen una vida llena de opulencia y distinción.', '6.jpg', '2023-11-28');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `inmuebles`
--
ALTER TABLE `inmuebles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
