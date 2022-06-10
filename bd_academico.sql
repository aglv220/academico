-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2022 a las 02:05:13
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_academico`
--
CREATE DATABASE IF NOT EXISTS `bd_academico` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bd_academico`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `ID` int(11) NOT NULL,
  `curso_ID` int(11) NOT NULL,
  `tipo_actividad` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `fecha_disponible` datetime NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_tipo`
--

CREATE TABLE `actividad_tipo` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `ID` int(11) NOT NULL,
  `usuario_ID` int(11) NOT NULL,
  `nombres` varchar(200) NOT NULL,
  `apellidos` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `ID` int(11) NOT NULL,
  `usuario_ID` int(50) NOT NULL,
  `nombres` varchar(200) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `carrera` varchar(50) NOT NULL,
  `ciclo` tinyint(2) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `celular` char(9) NOT NULL,
  `fec_nac` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`ID`, `usuario_ID`, `nombres`, `apellidos`, `carrera`, `ciclo`, `codigo`, `celular`, `fec_nac`) VALUES
(1, 1, 'Angel Laos', 'Valencia', 'angular', 6, 'u2121345', '992172945', '1233-02-12'),
(4, 4, 'Angel', 'Laos Valencia', 'Ingeniería de sistemas', 6, 'u2121375', '963788190', '1993-12-22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_alumno`
--

CREATE TABLE `curso_alumno` (
  `ID` int(11) NOT NULL,
  `usuario_ID` int(11) NOT NULL,
  `curso_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion_log`
--

CREATE TABLE `notificacion_log` (
  `ID` int(11) NOT NULL,
  `notificacion_pendiente_ID` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion_pendiente`
--

CREATE TABLE `notificacion_pendiente` (
  `ID` int(11) NOT NULL,
  `usuario_ID` int(11) NOT NULL,
  `actividad_ID` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subtarea`
--

CREATE TABLE `subtarea` (
  `ID` int(11) NOT NULL,
  `actividad_ID` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trazabilidad`
--

CREATE TABLE `trazabilidad` (
  `ID` int(11) NOT NULL,
  `actividad_ID` int(11) NOT NULL,
  `detalle` varchar(250) NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID` int(11) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID`, `correo`, `password`) VALUES
(1, 'u21213645@utp.edu.pe', '$2y$10$OwpVrZoYg7GQUeuZQSVg/u1kWriq7L9c23qMdbuSmZVXODZQ/OA.e'),
(4, 'u21213625@utp.edu.pe', '$2y$10$clkCl6IxNJzZHuvpr1iV9u01dx4mGRtuGevswMMgxTk/qmtV5lL5S');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CURSO_ID` (`curso_ID`) USING BTREE,
  ADD KEY `TIPO_ACTIVIDAD` (`tipo_actividad`) USING BTREE;

--
-- Indices de la tabla `actividad_tipo`
--
ALTER TABLE `actividad_tipo`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `USUARIO_ID` (`usuario_ID`) USING BTREE;

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `USUARIO_ID` (`usuario_ID`) USING BTREE;

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `curso_alumno`
--
ALTER TABLE `curso_alumno`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `USUARIO_ID` (`usuario_ID`) USING BTREE,
  ADD KEY `CURSO_ID` (`curso_ID`) USING BTREE;

--
-- Indices de la tabla `notificacion_log`
--
ALTER TABLE `notificacion_log`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `NOTIFICACION_PENDIENTE_ID` (`notificacion_pendiente_ID`);

--
-- Indices de la tabla `notificacion_pendiente`
--
ALTER TABLE `notificacion_pendiente`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `USUARIO_ID` (`usuario_ID`) USING BTREE,
  ADD KEY `ACTIVIDAD_ID` (`actividad_ID`) USING BTREE;

--
-- Indices de la tabla `subtarea`
--
ALTER TABLE `subtarea`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ACTIVIDAD_ID` (`actividad_ID`);

--
-- Indices de la tabla `trazabilidad`
--
ALTER TABLE `trazabilidad`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ACTIVIDAD_ID` (`actividad_ID`) USING BTREE;

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `actividad_tipo`
--
ALTER TABLE `actividad_tipo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `curso_alumno`
--
ALTER TABLE `curso_alumno`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificacion_log`
--
ALTER TABLE `notificacion_log`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificacion_pendiente`
--
ALTER TABLE `notificacion_pendiente`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `subtarea`
--
ALTER TABLE `subtarea`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trazabilidad`
--
ALTER TABLE `trazabilidad`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD CONSTRAINT `actividad_ibfk_1` FOREIGN KEY (`curso_ID`) REFERENCES `curso_alumno` (`ID`),
  ADD CONSTRAINT `actividad_ibfk_2` FOREIGN KEY (`tipo_actividad`) REFERENCES `actividad_tipo` (`ID`);

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`usuario_ID`) REFERENCES `usuario` (`ID`);

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `alumno_ibfk_1` FOREIGN KEY (`usuario_ID`) REFERENCES `usuario` (`ID`);

--
-- Filtros para la tabla `curso_alumno`
--
ALTER TABLE `curso_alumno`
  ADD CONSTRAINT `curso_alumno_ibfk_1` FOREIGN KEY (`usuario_ID`) REFERENCES `usuario` (`ID`),
  ADD CONSTRAINT `curso_alumno_ibfk_2` FOREIGN KEY (`curso_ID`) REFERENCES `curso` (`ID`);

--
-- Filtros para la tabla `notificacion_log`
--
ALTER TABLE `notificacion_log`
  ADD CONSTRAINT `notificacion_log_ibfk_1` FOREIGN KEY (`notificacion_pendiente_ID`) REFERENCES `notificacion_pendiente` (`ID`);

--
-- Filtros para la tabla `notificacion_pendiente`
--
ALTER TABLE `notificacion_pendiente`
  ADD CONSTRAINT `notificacion_pendiente_ibfk_1` FOREIGN KEY (`usuario_ID`) REFERENCES `usuario` (`ID`),
  ADD CONSTRAINT `notificacion_pendiente_ibfk_2` FOREIGN KEY (`actividad_ID`) REFERENCES `actividad` (`ID`);

--
-- Filtros para la tabla `subtarea`
--
ALTER TABLE `subtarea`
  ADD CONSTRAINT `subtarea_ibfk_2` FOREIGN KEY (`actividad_ID`) REFERENCES `actividad` (`ID`);

--
-- Filtros para la tabla `trazabilidad`
--
ALTER TABLE `trazabilidad`
  ADD CONSTRAINT `trazabilidad_ibfk_1` FOREIGN KEY (`actividad_ID`) REFERENCES `actividad` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
