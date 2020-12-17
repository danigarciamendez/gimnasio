-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-12-2020 a las 00:07:24
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gimnasio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `aforo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `nombre`, `descripcion`, `aforo`) VALUES
(1, 'Yogae', 'Sesión de Yoga', 8),
(2, 'Aerobic', 'Sesión de aerobic 2.1', 10),
(3, 'Cardio', 'Sesión de cardio intensivo', 10),
(4, 'Kickboxing', 'Sesión de kickboxing', 6),
(5, 'Calistenia', 'Sesión de Calistenia', 5),
(6, 'Zumba', 'Sesión de Zumba', 10),
(7, 'Yumpay', 'Sesión de Yumpay', 6),
(8, 'Bicicleta', 'Sesión de Bicicleta para 7 personas', 7),
(9, 'Pesas', 'Sesión de Pesas para 9 personas', 9),
(10, 'Kickboxing', 'Sesión de Kickboxing para 6 personas', 6),
(11, 'Pilates', 'Sesión de Pilates para 8 personas', 8),
(12, 'Bicicleta', 'Sesión de Bicicleta para 7 personas', 7),
(13, 'Pesas', 'Sesión de Pesas para 9 personas', 9),
(14, 'Kickboxing', 'Sesión de Kickboxing para 6 personas', 6),
(15, 'Pilates', 'Sesión de Pilates para 8 personas', 8),
(16, 'B.Pump', 'Sesión de B.Pump para 7 personas', 7),
(17, 'Aquafitness', 'Sesión de Aquafitness para 4 personas', 4),
(18, 'Padel', 'Sesión de Padel para 4 personas', 4),
(19, 'Pesos pesados', 'Sesión de Pesos pesados para 6 personas', 6),
(20, 'Ballet', 'Sesión de Ballet para 6 personas', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramos`
--

CREATE TABLE `tramos` (
  `id` int(11) NOT NULL,
  `dia` varchar(15) NOT NULL,
  `hora_inicio` time NOT NULL DEFAULT current_timestamp(),
  `hora_fin` time DEFAULT NULL,
  `actividad_id` int(11) NOT NULL,
  `fecha_alta` date NOT NULL,
  `fecha_baja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tramos`
--

INSERT INTO `tramos` (`id`, `dia`, `hora_inicio`, `hora_fin`, `actividad_id`, `fecha_alta`, `fecha_baja`) VALUES
(2, 'Lunes', '09:00:00', '09:45:00', 2, '2020-12-10', NULL),
(3, 'Lunes', '10:00:00', '10:30:00', 3, '2020-12-10', NULL),
(4, 'Lunes', '11:00:00', '11:45:00', 4, '2020-12-10', NULL),
(5, 'Lunes', '12:00:00', '13:00:00', 1, '2020-12-10', NULL),
(6, 'Martes', '09:15:00', '10:15:00', 2, '2020-12-10', NULL),
(7, 'Martes', '10:30:00', '11:00:00', 3, '2020-12-10', NULL),
(8, 'Martes', '11:15:00', '12:00:00', 4, '2020-12-10', NULL),
(9, 'Martes', '12:30:00', '13:30:00', 2, '2020-12-10', NULL),
(10, 'Lunes', '13:15:00', '14:15:00', 2, '2020-12-12', NULL),
(16, 'Jueves', '09:00:00', '10:00:00', 10, '2020-12-16', NULL),
(17, 'Jueves', '10:15:00', '11:15:00', 1, '2020-12-16', NULL),
(18, 'Jueves', '11:30:00', '12:15:00', 4, '2020-12-16', NULL),
(19, 'Jueves', '12:30:00', '13:00:00', 7, '2020-12-16', NULL),
(20, 'Jueves', '13:15:00', '14:15:00', 2, '2020-12-16', NULL),
(21, 'Jueves', '14:30:00', '15:30:00', 12, '2020-12-16', NULL),
(22, 'Jueves', '15:45:00', '17:00:00', 8, '2020-12-16', NULL),
(23, 'Martes', '14:30:00', '15:30:00', 12, '2020-12-17', NULL),
(24, 'Martes', '15:45:00', '17:00:00', 3, '2020-12-17', NULL),
(25, 'Martes', '17:15:00', '18:00:00', 11, '2020-12-17', NULL),
(26, 'Miercoles', '09:00:00', '10:00:00', 5, '2020-12-17', NULL),
(27, 'Miercoles', '10:15:00', '11:15:00', 2, '2020-12-17', NULL),
(28, 'Miercoles', '11:30:00', '12:15:00', 4, '2020-12-17', NULL),
(29, 'Miercoles', '12:45:00', '14:00:00', 7, '2020-12-17', NULL),
(30, 'Miercoles', '14:15:00', '15:30:00', 12, '2020-12-17', NULL),
(31, 'Miercoles', '15:45:00', '17:00:00', 3, '2020-12-17', NULL),
(32, 'Miercoles', '17:15:00', '18:00:00', 11, '2020-12-17', NULL),
(33, 'Viernes', '09:30:00', '10:30:00', 6, '2020-12-17', NULL),
(34, 'Viernes', '10:45:00', '11:45:00', 12, '2020-12-17', NULL),
(35, 'Viernes', '12:00:00', '12:45:00', 9, '2020-12-17', NULL),
(36, 'Viernes', '13:00:00', '14:00:00', 7, '2020-12-17', NULL),
(37, 'Viernes', '14:15:00', '15:30:00', 3, '2020-12-17', NULL),
(38, 'Viernes', '17:15:00', '18:00:00', 11, '2020-12-17', NULL),
(39, 'Sabado', '09:00:00', '10:00:00', 4, '2020-12-17', NULL),
(40, 'Sabado', '10:15:00', '11:15:00', 7, '2020-12-17', NULL),
(41, 'Sabado', '11:30:00', '12:15:00', 9, '2020-12-17', NULL),
(42, 'Sabado', '12:30:00', '13:00:00', 8, '2020-12-17', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramo_usuario`
--

CREATE TABLE `tramo_usuario` (
  `id` int(11) NOT NULL,
  `tramo_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_actividad` date NOT NULL,
  `fecha_reserva` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tramo_usuario`
--

INSERT INTO `tramo_usuario` (`id`, `tramo_id`, `usuario_id`, `fecha_actividad`, `fecha_reserva`) VALUES
(2, 3, 1, '2007-12-20', '2011-12-20'),
(3, 4, 1, '2020-12-07', '2020-12-11'),
(6, 8, 1, '2008-12-20', '2020-12-12'),
(7, 9, 1, '2008-12-20', '2020-12-13'),
(8, 6, 1, '2008-12-20', '2020-12-13'),
(10, 7, 1, '2015-12-20', '2020-12-14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(8) NOT NULL,
  `nif` varchar(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `imagen` varchar(300) DEFAULT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` int(11) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `rol_tipo` varchar(15) NOT NULL,
  `email_conf` int(11) NOT NULL DEFAULT 0,
  `cad_rec_pass` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nif`, `nombre`, `apellidos`, `imagen`, `login`, `password`, `email`, `telefono`, `direccion`, `rol_tipo`, `email_conf`, `cad_rec_pass`) VALUES
(1, '49059161W', 'Daniel', 'Garcia Méndez', '228-2284269_1080p-naruto-wallpaper-hd.jpg', 'daniel', 'daniel', 'b3garciadaniel@gmail.com', 684290547, 'C/Doctor Marañon 28', 'admin', 1, '6ba58e4833273a14'),
(2, '23423423', 'Xabi', 'Alonso', '1606747092-1511115427-042.png', 'xabi945', 'javier', 'xabialonso@gmail.com', 654090532, 'Calle KO', 'usuario', 1, NULL),
(5, '49059161W', 'Jonny', 'Banauny', '1511115345-009.png', 'jonny', 'jonny', 'b3garciadaniel@gmail.com', 684290547, 'C/Doctor', 'admin', 1, ''),
(7, '49098754W', 'Muertin', 'Gomez', '1607963850-a8MPxC.jpg', 'muertin', '416a6024aad73c4f1b7d', 'muertin@gmail.com', 622459897, 'C/ Doctore Marañone 25', 'usuario', 0, NULL),
(9, '73485457', 'admin', 'Adminsitrador', '1608155351-ws_Naruto_Shippuden.jpg', 'admin', 'd033e22ae348aeb5660f', 'b3garciadaniel@gmail.com', 684290547, 'C/Doctor Marañon 28', 'usuario', 0, NULL),
(10, '73485457', 'admin', 'Méndez', '1608155496-itachi.jpg', 'askjna', 'd033e22ae348aeb5660f', 'b3@gmail.com', 684290547, 'C/Doctor Marañon 28', 'usuario', 0, NULL),
(11, '49089321L', 'Daniel', 'García Méndez', NULL, 'admin', 'admin', '684290645', 0, 'C/ Doctor Fleming Nº 23 Almonte, Huelva', 'admin', 1, NULL),
(12, '45065333L', 'Martin', 'Borrero López', NULL, 'usuario', 'usuario', '684290645', 0, 'C/ Águila Imperial Nº 23 Matalascañas, Huelva', 'usuario', 0, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tramos`
--
ALTER TABLE `tramos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actividad_id` (`actividad_id`);

--
-- Indices de la tabla `tramo_usuario`
--
ALTER TABLE `tramo_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tramo_id` (`tramo_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tramos`
--
ALTER TABLE `tramos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `tramo_usuario`
--
ALTER TABLE `tramo_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tramos`
--
ALTER TABLE `tramos`
  ADD CONSTRAINT `tramos_ibfk_1` FOREIGN KEY (`actividad_id`) REFERENCES `actividades` (`id`);

--
-- Filtros para la tabla `tramo_usuario`
--
ALTER TABLE `tramo_usuario`
  ADD CONSTRAINT `tramo_usuario_ibfk_1` FOREIGN KEY (`tramo_id`) REFERENCES `tramos` (`id`),
  ADD CONSTRAINT `tramo_usuario_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
