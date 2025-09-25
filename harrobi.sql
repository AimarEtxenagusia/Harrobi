-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-09-2025 a las 08:29:15
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `harrobi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bezeroa`
--

CREATE TABLE `bezeroa` (
  `id` int(11) NOT NULL,
  `izena` varchar(20) NOT NULL,
  `abizena` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pasahitza` varchar(50) NOT NULL,
  `nan` varchar(9) NOT NULL,
  `instalazioa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `bezeroa`
--

INSERT INTO `bezeroa` (`id`, `izena`, `abizena`, `email`, `pasahitza`, `nan`, `instalazioa`) VALUES
(1, 'Conchi', 'Garcia', 'conchita@gmail.com', 'Conchita1979', '87654321C', 'Igerilekua'),
(2, 'Aitorr', 'Etxebarriaaa', 'aitor.etxebarria@example.com', 'password123', '12345678A', 'Futbol zelaia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instalazioa`
--

CREATE TABLE `instalazioa` (
  `id` int(11) NOT NULL,
  `izena` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `instalazioa`
--

INSERT INTO `instalazioa` (`id`, `izena`) VALUES
(1, 'Igerilekua'),
(2, 'Gimnasioaaaa'),
(3, 'Padel pista'),
(13, 'Futbol zelaia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `langilea`
--

CREATE TABLE `langilea` (
  `id` int(11) NOT NULL,
  `izena` varchar(20) NOT NULL,
  `abizena` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pasahitza` varchar(50) NOT NULL,
  `nan` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `langilea`
--

INSERT INTO `langilea` (`id`, `izena`, `abizena`, `email`, `pasahitza`, `nan`) VALUES
(1, 'Aimar', 'Etxenagusia', 'aimar@gmail.com', 'Admin123', '12345678A'),
(2, 'Gorka', 'Cereza', 'gorka@gmail.com', 'Admin123', '12345678B'),
(3, 'Jon ', 'Sologaistua', 'jon@gmail.com', 'Admin123', '12345678C'),
(4, 'Iker', 'Nistal', 'iker@gmail.com', 'Admin123', '12345678D');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bezeroa`
--
ALTER TABLE `bezeroa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `instalazioa`
--
ALTER TABLE `instalazioa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `langilea`
--
ALTER TABLE `langilea`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bezeroa`
--
ALTER TABLE `bezeroa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `instalazioa`
--
ALTER TABLE `instalazioa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `langilea`
--
ALTER TABLE `langilea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
