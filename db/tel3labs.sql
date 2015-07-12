-- phpMyAdmin SQL Dump
-- version 4.4.0
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 12-07-2015 a las 15:00:59
-- Versión del servidor: 5.6.23
-- Versión de PHP: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `tel3labs`
--
CREATE DATABASE IF NOT EXISTS `tel3labs` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tel3labs`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

DROP TABLE IF EXISTS `perfiles`;
CREATE TABLE IF NOT EXISTS `perfiles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `perfiles`
--

TRUNCATE TABLE `perfiles`;
--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'guest');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `mail` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `usuarios`
--

TRUNCATE TABLE `usuarios`;
--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `name`, `mail`) VALUES
(1, 'juan carlos', 'juanca@mail.com'),
(18, 'test', 'test@test.com'),
(19, 'test2', 'test2@test.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_perfiles`
--

DROP TABLE IF EXISTS `usuarios_perfiles`;
CREATE TABLE IF NOT EXISTS `usuarios_perfiles` (
  `usuarios_id` int(11) NOT NULL,
  `perfiles_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `usuarios_perfiles`
--

TRUNCATE TABLE `usuarios_perfiles`;
--
-- Volcado de datos para la tabla `usuarios_perfiles`
--

INSERT INTO `usuarios_perfiles` (`usuarios_id`, `perfiles_id`) VALUES
(1, 1),
(18, 1),
(19, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `usuarios_perfiles`
--
ALTER TABLE `usuarios_perfiles`
  ADD KEY `usuarios_id` (`usuarios_id`),
  ADD KEY `perfiles_id` (`perfiles_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuarios_perfiles`
--
ALTER TABLE `usuarios_perfiles`
  ADD CONSTRAINT `usuarios_perfiles_ibfk_1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuarios_perfiles_ibfk_2` FOREIGN KEY (`perfiles_id`) REFERENCES `perfiles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
