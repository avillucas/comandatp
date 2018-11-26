-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2018 a las 14:57:43
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id7086796_tpprog3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimentos`
--

CREATE TABLE `alimentos` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` float UNSIGNED NOT NULL,
  `sector_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alimentos`
--

INSERT INTO `alimentos` (`id`, `nombre`, `precio`, `sector_id`) VALUES
(1, 'Empanada JYQ', 1.5, 4),
(2, 'Empanada Calabreza ', 1.5, 4),
(3, 'Cabernet Sauvignon', 20, 2),
(4, 'Pinta Cerveza Negra ', 20, 3),
(5, 'Capcake zanahoria', 10, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comandas`
--

CREATE TABLE `comandas` (
  `id` int(11) UNSIGNED NOT NULL,
  `mozo_id` int(11) UNSIGNED NOT NULL,
  `mesa_id` int(11) UNSIGNED NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `codigo` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comandas`
--

INSERT INTO `comandas` (`id`, `mozo_id`, `mesa_id`, `nombre_cliente`, `codigo`) VALUES
(1, 1, 1, 'tito', '5r0te');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) UNSIGNED NOT NULL,
  `activo` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `activo`) VALUES
(1, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `id` int(11) UNSIGNED NOT NULL,
  `comanda_id` int(11) UNSIGNED NOT NULL,
  `puntuacion_restaurante` tinyint(1) UNSIGNED NOT NULL,
  `puntuacion_mozo` tinyint(1) UNSIGNED NOT NULL,
  `puntuacion_preparador` tinyint(1) UNSIGNED NOT NULL,
  `puntuacion_mesa` tinyint(1) UNSIGNED NOT NULL,
  `comentario` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) UNSIGNED NOT NULL,
  `estado_id` int(11) UNSIGNED NOT NULL,
  `codigo` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `estado_id`, `codigo`) VALUES
(1, 1, '12345'),
(3, 1, '12346');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas_estado`
--

CREATE TABLE `mesas_estado` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mesas_estado`
--

INSERT INTO `mesas_estado` (`id`, `nombre`) VALUES
(1, 'cerrada'),
(3, 'con cliente comiendo'),
(2, 'con cliente esperando'),
(4, 'con cliente pagando');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mozos`
--

CREATE TABLE `mozos` (
  `id` int(11) UNSIGNED NOT NULL,
  `empleado_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mozos`
--

INSERT INTO `mozos` (`id`, `empleado_id`) VALUES
(1, 1),
(3, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) UNSIGNED NOT NULL,
  `encargado_id` int(11) UNSIGNED DEFAULT NULL,
  `alimento_id` int(11) UNSIGNED NOT NULL,
  `estado_id` int(11) UNSIGNED NOT NULL,
  `comanda_id` int(11) UNSIGNED NOT NULL,
  `cantidad` int(11) UNSIGNED NOT NULL,
  `tiempo_estimado` int(11) UNSIGNED DEFAULT NULL COMMENT 'En minutos',
  `momento_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `momento_preparacion` timestamp NULL DEFAULT NULL,
  `momento_de_entrega` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `encargado_id`, `alimento_id`, `estado_id`, `comanda_id`, `cantidad`, `tiempo_estimado`, `momento_creacion`, `momento_preparacion`, `momento_de_entrega`) VALUES
(1, 1, 1, 3, 1, 3, 30, '2018-11-26 07:11:00', '2018-11-26 07:11:32', '2018-11-26 07:11:13'),
(2, 1, 1, 1, 1, 3, NULL, '2018-11-26 07:11:00', NULL, NULL),
(3, 1, 1, 1, 1, 3, NULL, '2018-11-26 07:11:00', NULL, NULL),
(4, 1, 1, 1, 1, 3, NULL, '2018-11-26 07:11:00', NULL, NULL),
(5, 1, 1, 1, 1, 3, NULL, '2018-11-26 07:11:00', NULL, NULL),
(6, 1, 1, 1, 1, 3, NULL, '2018-11-26 07:11:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_estado`
--

CREATE TABLE `pedidos_estado` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pedidos_estado`
--

INSERT INTO `pedidos_estado` (`id`, `nombre`) VALUES
(4, 'cancelado'),
(2, 'en preparacion'),
(3, 'listo para servir'),
(1, 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preparadores`
--

CREATE TABLE `preparadores` (
  `id` int(11) UNSIGNED NOT NULL,
  `sector_id` int(11) UNSIGNED DEFAULT NULL,
  `empleado_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `preparadores`
--

INSERT INTO `preparadores` (`id`, `sector_id`, `empleado_id`) VALUES
(1, 4, 4),
(2, 2, 5),
(3, 3, 6),
(4, 1, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectores`
--

CREATE TABLE `sectores` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sectores`
--

INSERT INTO `sectores` (`id`, `nombre`) VALUES
(2, 'bar'),
(3, 'barra'),
(1, 'candy bar'),
(4, 'cocina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clave` char(35) COLLATE utf8_unicode_ci NOT NULL,
  `empleado_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `clave`, `empleado_id`) VALUES
(1, 'mozo1', 'mozo1@tester.com.ar', 'd1110387a0209a9a26480b6b575a546f', 1),
(4, 'socio1', 'socio1@tester.com.ar', '63811d7dc29b4c62dc122e652e5096f2', NULL),
(5, 'cocinero1', 'cocinero1@tester.com.ar', '110169456ce5030bba735693870435ff', 4),
(6, 'barman1', 'barman1@tester.com.ar', 'aa3940e9560f65e5a97ce4d79997689e', 5),
(7, 'cervecero1', 'cervecero1@tester.com.ar', '0ec8c1665b2ddbc5f50ba90e35cb70b9', 6),
(8, 'repostero1', 'repostero1@tester.com.ar', '723130af99dce181a98823e000b891cc', 7);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alimentos`
--
ALTER TABLE `alimentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alimento_nombre_unico` (`nombre`),
  ADD KEY `sector_id` (`sector_id`);

--
-- Indices de la tabla `comandas`
--
ALTER TABLE `comandas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mesa_mozo` (`mozo_id`) USING BTREE,
  ADD KEY `mesa_comanda` (`mesa_id`) USING BTREE;

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `encuesta_comanda` (`comanda_id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mesas_solo_un_codigo` (`codigo`),
  ADD KEY `mesa_estado` (`estado_id`) USING BTREE;

--
-- Indices de la tabla `mesas_estado`
--
ALTER TABLE `mesas_estado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mesa_solo_uno` (`nombre`);

--
-- Indices de la tabla `mozos`
--
ALTER TABLE `mozos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empleado_id` (`empleado_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `pedido_encargado` (`encargado_id`),
  ADD KEY `pedido_alimento` (`alimento_id`),
  ADD KEY `pedido_comanda` (`comanda_id`),
  ADD KEY `pedido_estado` (`estado_id`) USING BTREE;

--
-- Indices de la tabla `pedidos_estado`
--
ALTER TABLE `pedidos_estado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `solo un nombre` (`nombre`);

--
-- Indices de la tabla `preparadores`
--
ALTER TABLE `preparadores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sector_id` (`sector_id`),
  ADD KEY `empleado_id` (`empleado_id`);

--
-- Indices de la tabla `sectores`
--
ALTER TABLE `sectores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `solo_un_sector_nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `solo_un_email` (`email`),
  ADD KEY `usuario_empleado_valido` (`empleado_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alimentos`
--
ALTER TABLE `alimentos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `comandas`
--
ALTER TABLE `comandas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mesas_estado`
--
ALTER TABLE `mesas_estado`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `mozos`
--
ALTER TABLE `mozos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedidos_estado`
--
ALTER TABLE `pedidos_estado`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `preparadores`
--
ALTER TABLE `preparadores`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sectores`
--
ALTER TABLE `sectores`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alimentos`
--
ALTER TABLE `alimentos`
  ADD CONSTRAINT `alimento_sector_preparador` FOREIGN KEY (`sector_id`) REFERENCES `sectores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comandas`
--
ALTER TABLE `comandas`
  ADD CONSTRAINT `mesa_comanda_valida` FOREIGN KEY (`mesa_id`) REFERENCES `mesas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mesa_mozo_valido` FOREIGN KEY (`mozo_id`) REFERENCES `mozos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD CONSTRAINT `encuesta_comanda_valida` FOREIGN KEY (`comanda_id`) REFERENCES `comandas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD CONSTRAINT `mesa_estado_valido` FOREIGN KEY (`estado_id`) REFERENCES `mesas_estado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mozos`
--
ALTER TABLE `mozos`
  ADD CONSTRAINT `mozo_empleado_valido` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedido_alimento_valido` FOREIGN KEY (`alimento_id`) REFERENCES `alimentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedido_comanda_valida` FOREIGN KEY (`comanda_id`) REFERENCES `comandas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedido_encargado_valido` FOREIGN KEY (`encargado_id`) REFERENCES `preparadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedido_estado_valido` FOREIGN KEY (`estado_id`) REFERENCES `pedidos_estado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `preparadores`
--
ALTER TABLE `preparadores`
  ADD CONSTRAINT `preparador_empleado_valido` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sector_preparador` FOREIGN KEY (`sector_id`) REFERENCES `sectores` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuario_empleado_valido` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
