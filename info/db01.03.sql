-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-05-2019 a las 01:18:23
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `parcial2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) UNSIGNED NOT NULL,
  `tipo` enum('liquido','solido') DEFAULT 'liquido',
  `descripcion` text,
  `fecha_vencimiento` date NOT NULL,
  `precio` int(11) NOT NULL,
  `ruta_de_foto` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `tipo`, `descripcion`, `fecha_vencimiento`, `precio`, `ruta_de_foto`) VALUES
(1, 'liquido', 'asdasdasdasdasdasdasdasd', '2019-08-09', 10, 'https://www.encopadebalon.com/3493-large_default/coca-cola-lata-33cl-caja-24unid.jpg'),
(2, 'solido', 'Zapato', '2019-05-16', 1000, 'https://images.ssstatic.com/zapato-tacon-y-plataforma-7794344n0-00000067.jpg'),
(3, 'liquido', 'Coca ligth', '2019-09-21', 5, 'https://www.encopadebalon.com/3493-large_default/coca-cola-lata-33cl-caja-24unid.jpg');



--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;
