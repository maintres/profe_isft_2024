-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-08-2024 a las 20:28:17
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `abm_escuela`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

CREATE TABLE `asignaturas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cantidaddehoras` int(11) NOT NULL,
  `etapa` varchar(15) NOT NULL,
  `FK_carrera` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `asignaturas`
--

INSERT INTO `asignaturas` (`id`, `nombre`, `cantidaddehoras`, `etapa`, `FK_carrera`) VALUES
(1, 'Programacion', 3, 'Activo', 2),
(2, 'matematicas', 2, 'Activo', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL,
  `profesor_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(25) NOT NULL,
  `etapa` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`id`, `profesor_id`, `fecha`, `estado`, `etapa`) VALUES
(3, 3, '2024-08-06', 'presente', ''),
(4, 1, '2024-08-06', '', ''),
(5, 2, '2024-08-06', 'ausente', ''),
(6, 1, '2024-08-06', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `etapa` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id`, `nombre`, `descripcion`, `etapa`) VALUES
(2, 'Desarrollo de Software', '--', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dicta`
--

CREATE TABLE `dicta` (
  `id` int(11) NOT NULL,
  `FKprofesor` int(11) DEFAULT NULL,
  `FKmateria` int(11) DEFAULT NULL,
  `tipo` enum('titular','interino','suplente') DEFAULT NULL,
  `Baja` enum('SI','NO') DEFAULT NULL,
  `Fecha_baja` date DEFAULT NULL,
  `motivo_baja` varchar(255) DEFAULT NULL,
  `etapa` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `dicta`
--

INSERT INTO `dicta` (`id`, `FKprofesor`, `FKmateria`, `tipo`, `Baja`, `Fecha_baja`, `motivo_baja`, `etapa`) VALUES
(1, 1, 1, 'titular', NULL, NULL, NULL, 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencias`
--

CREATE TABLE `licencias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fechadeinicio` date NOT NULL,
  `fechadefin` date NOT NULL,
  `idprofesor` int(11) NOT NULL,
  `idtipos_licencias` int(11) NOT NULL,
  `etapa` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `licencias`
--

INSERT INTO `licencias` (`id`, `nombre`, `fechadeinicio`, `fechadefin`, `idprofesor`, `idtipos_licencias`, `etapa`) VALUES
(2, 'd', '2024-08-08', '0000-00-00', 2, 7, 'Inactivo'),
(3, 'd', '2024-08-17', '0000-00-00', 2, 7, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(254) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id` int(11) NOT NULL,
  `nombreyapellido` varchar(255) NOT NULL,
  `dni` varchar(255) NOT NULL,
  `domicilio` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `cv` varchar(255) NOT NULL,
  `fechadeingreso` date NOT NULL,
  `fechadebaja` date DEFAULT NULL,
  `etapa` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `nombreyapellido`, `dni`, `domicilio`, `telefono`, `email`, `foto`, `cv`, `fechadeingreso`, `fechadebaja`, `etapa`) VALUES
(1, 'maxi', '38015715', 'brasi', '4', 'maxiolmos1993@gmail.com', '', '', '2024-08-16', '0000-00-00', 'Activo'),
(2, 'd', '2', 'd', '2', 'dem23@gmail.com', '', '', '2024-08-19', '0000-00-00', 'Activo'),
(3, 'g', '34', 'g', '4', 'fer.olmos93@gmail.com', '', '', '2024-08-16', '2024-08-06', 'Inactivo'),
(4, 'Hernan A', '44634317', 'calle 21 de febrero', '2645677654', 'hernanandrada277@gmail.com', '9taPAiQkRduEpjE4Ol_7xQ.jpg', 'iulNj9t_Q325IIgq6ouhog.jpg', '2024-02-21', NULL, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores_asignaturas`
--

CREATE TABLE `profesores_asignaturas` (
  `id_profesor` int(11) NOT NULL,
  `id_asignatura` int(11) NOT NULL,
  `cantidad_horas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores_carreras`
--

CREATE TABLE `profesores_carreras` (
  `id_profesor` int(11) NOT NULL,
  `id_carrera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_licencias`
--

CREATE TABLE `tipos_licencias` (
  `id` int(11) NOT NULL,
  `tipodelicencia` varchar(254) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `etapa` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipos_licencias`
--

INSERT INTO `tipos_licencias` (`id`, `tipodelicencia`, `descripcion`, `etapa`) VALUES
(5, 'Medica', 'ninguna', 'Inactivo'),
(6, 'discapasidad', 'jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj', 'Inactivo'),
(7, 'Enfermedad', '', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `id_permisos` int(11) NOT NULL,
  `etapa` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `password`, `correo`, `nombre`, `id_permisos`, `etapa`) VALUES
(1, '123', 'paablokenny20@gmail.com', 'Jaime', 2, 'Activo'),
(2, '123', 'fjimenez@gmail.com', 'Fjimenez', 1, 'Activo'),
(3, '123', 'a@a.cd', 'd', 3, 'Activo'),
(4, '123', 'maxi@gmail.com', 'maxi', 3, 'Activo'),
(5, '123', '22a@a.cd', 'maxi', 1, 'Activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_carrera` (`FK_carrera`);

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_profesor_id` (`profesor_id`);

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dicta`
--
ALTER TABLE `dicta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKprofesor` (`FKprofesor`),
  ADD KEY `FKmateria` (`FKmateria`);

--
-- Indices de la tabla `licencias`
--
ALTER TABLE `licencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `licencias_FK` (`idprofesor`),
  ADD KEY `licencias_FK_1` (`idtipos_licencias`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profesores_asignaturas`
--
ALTER TABLE `profesores_asignaturas`
  ADD PRIMARY KEY (`id_profesor`,`id_asignatura`),
  ADD KEY `profesores_asignaturas_FK_2` (`id_asignatura`);

--
-- Indices de la tabla `profesores_carreras`
--
ALTER TABLE `profesores_carreras`
  ADD PRIMARY KEY (`id_profesor`,`id_carrera`),
  ADD KEY `profesores_carreras_FK_2` (`id_carrera`);

--
-- Indices de la tabla `tipos_licencias`
--
ALTER TABLE `tipos_licencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarios_FK` (`id_permisos`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `dicta`
--
ALTER TABLE `dicta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `licencias`
--
ALTER TABLE `licencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipos_licencias`
--
ALTER TABLE `tipos_licencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD CONSTRAINT `fk_carrera` FOREIGN KEY (`FK_carrera`) REFERENCES `carreras` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `fk_profesor_id` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`);

--
-- Filtros para la tabla `dicta`
--
ALTER TABLE `dicta`
  ADD CONSTRAINT `dicta_ibfk_1` FOREIGN KEY (`FKprofesor`) REFERENCES `profesores` (`id`),
  ADD CONSTRAINT `dicta_ibfk_2` FOREIGN KEY (`FKmateria`) REFERENCES `asignaturas` (`id`);

--
-- Filtros para la tabla `licencias`
--
ALTER TABLE `licencias`
  ADD CONSTRAINT `licencias_FK` FOREIGN KEY (`idprofesor`) REFERENCES `profesores` (`id`),
  ADD CONSTRAINT `licencias_FK_1` FOREIGN KEY (`idtipos_licencias`) REFERENCES `tipos_licencias` (`id`);

--
-- Filtros para la tabla `profesores_asignaturas`
--
ALTER TABLE `profesores_asignaturas`
  ADD CONSTRAINT `profesores_asignaturas_FK_1` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id`),
  ADD CONSTRAINT `profesores_asignaturas_FK_2` FOREIGN KEY (`id_asignatura`) REFERENCES `asignaturas` (`id`);

--
-- Filtros para la tabla `profesores_carreras`
--
ALTER TABLE `profesores_carreras`
  ADD CONSTRAINT `profesores_carreras_FK_1` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id`),
  ADD CONSTRAINT `profesores_carreras_FK_2` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
