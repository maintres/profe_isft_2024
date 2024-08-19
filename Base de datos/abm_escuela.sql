-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 20-08-2024 a las 00:06:26
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
  `FK_carrera` int(11) NOT NULL,
  `etapa` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignaturas`
--

INSERT INTO `asignaturas` (`id`, `nombre`, `cantidaddehoras`, `FK_carrera`, `etapa`) VALUES
(1, 'Programacion', 3, 1, 'Activo'),
(2, 'Matematica', 3, 1, 'Activo'),
(3, 'Lengua', 2, 2, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `id` int(11) NOT NULL,
  `profesor_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` enum('Presente','Ausente','Tarde','Justificada') NOT NULL,
  `etapa` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`id`, `profesor_id`, `fecha`, `estado`, `etapa`) VALUES
(2, 2, '2024-08-09', 'Ausente', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `etapa` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id`, `nombre`, `descripcion`, `etapa`) VALUES
(1, 'Desarrollo de Software', 'DDS', 'Activo'),
(2, 'Energia Renovable', '--', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dicta`
--

CREATE TABLE `dicta` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `FKmateria` int(11) DEFAULT NULL,
  `tipo` enum('titular','interino','suplente') NOT NULL,
  `Baja` enum('SI','NO') NOT NULL,
  `Fecha_baja` date DEFAULT NULL,
  `motivo_baja` varchar(255) DEFAULT NULL,
  `FK_carrera` int(11) DEFAULT NULL,
  `etapa` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dicta`
--

INSERT INTO `dicta` (`id`, `usuario_id`, `FKmateria`, `tipo`, `Baja`, `Fecha_baja`, `motivo_baja`, `FK_carrera`, `etapa`) VALUES
(1, 5, 1, 'titular', 'NO', NULL, NULL, 1, 'Activo'),
(2, 3, 3, 'titular', 'NO', NULL, NULL, 2, 'Activo'),
(3, 3, 2, 'titular', 'NO', NULL, NULL, 1, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencias`
--

CREATE TABLE `licencias` (
  `id` int(11) NOT NULL,
  `fechadeinicio` date NOT NULL,
  `fechadefin` date NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `idtipos_licencias` int(11) NOT NULL,
  `etapa` varchar(15) DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `licencias`
--

INSERT INTO `licencias` (`id`, `fechadeinicio`, `fechadefin`, `usuario_id`, `idtipos_licencias`, `etapa`) VALUES
(1, '2024-08-10', '2024-08-24', 2, 7, 'Inactivo');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_clases`
--

CREATE TABLE `registro_clases` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `carrera_id` int(11) DEFAULT NULL,
  `materia_id` int(11) DEFAULT NULL,
  `fecha` text NOT NULL,
  `hora_entrada` time NOT NULL,
  `hora_salida` time DEFAULT NULL,
  `etapa` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`) VALUES
(1, 'admin'),
(2, 'Profesor'),
(3, 'Preceptor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_licencias`
--

CREATE TABLE `tipos_licencias` (
  `id` int(11) NOT NULL,
  `tipodelicencia` varchar(254) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `etapa` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `correo` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `fechadeingreso` date NOT NULL,
  `fechadebaja` date DEFAULT NULL,
  `etapa` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `id_rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `dni`, `celular`, `correo`, `password`, `direccion`, `foto`, `cv`, `fechadeingreso`, `fechadebaja`, `etapa`, `id_rol`) VALUES
(1, 'Lucas', 'Gomez', '4423189', '2646984561', 'lucas@gmail.com', '123', '9 de julio', NULL, NULL, '2024-08-08', NULL, 'Activo', 1),
(2, 'Demian Agustín ', 'Perez', '45973121', '2646057672', 'dem@gmail.com', '123', 'laprida', '', '', '2024-08-08', '2024-08-09', 'Activo', 2),
(3, 'Marcos', 'Gomez', '45470152', '2646058711', 'marco11s@gmail.com', '123', '9 de julio', '', '', '2024-08-10', NULL, 'Activo', 2),
(4, 'Gabriel', 'Fernandez', '44232168', '2646754234', 'gabriel@gmail.com', '123', 'juan jofre', NULL, NULL, '2024-08-07', NULL, 'Activo', 3),
(5, 'carlos', 'gomez', '44234176', '2646956576', 'carlos@gmail.com', '123', 'pppp', '', '', '2024-08-10', NULL, 'Activo', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_asignaciones`
--

CREATE TABLE `usuario_asignaciones` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `tipo_asignacion` enum('carrera','asignatura') NOT NULL,
  `referencia_id` int(11) DEFAULT NULL,
  `cantidad_horas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_carrera` (`FK_carrera`);

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profesor_id` (`profesor_id`);

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
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `FKmateria` (`FKmateria`),
  ADD KEY `FK_carrera` (`FK_carrera`);

--
-- Indices de la tabla `licencias`
--
ALTER TABLE `licencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `idtipos_licencias` (`idtipos_licencias`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registro_clases`
--
ALTER TABLE `registro_clases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `carrera_id` (`carrera_id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tipos_licencias`
--
ALTER TABLE `tipos_licencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `email` (`correo`),
  ADD KEY `rol_id` (`id_rol`);

--
-- Indices de la tabla `usuario_asignaciones`
--
ALTER TABLE `usuario_asignaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `referencia_id` (`referencia_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `dicta`
--
ALTER TABLE `dicta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `licencias`
--
ALTER TABLE `licencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_clases`
--
ALTER TABLE `registro_clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipos_licencias`
--
ALTER TABLE `tipos_licencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario_asignaciones`
--
ALTER TABLE `usuario_asignaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD CONSTRAINT `asignaturas_ibfk_1` FOREIGN KEY (`FK_carrera`) REFERENCES `carreras` (`id`);

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`profesor_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `dicta`
--
ALTER TABLE `dicta`
  ADD CONSTRAINT `dicta_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dicta_ibfk_2` FOREIGN KEY (`FKmateria`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dicta_ibfk_3` FOREIGN KEY (`FK_carrera`) REFERENCES `carreras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `licencias`
--
ALTER TABLE `licencias`
  ADD CONSTRAINT `licencias_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `licencias_ibfk_2` FOREIGN KEY (`idtipos_licencias`) REFERENCES `tipos_licencias` (`id`);

--
-- Filtros para la tabla `registro_clases`
--
ALTER TABLE `registro_clases`
  ADD CONSTRAINT `registro_clases_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `registro_clases_ibfk_2` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `registro_clases_ibfk_3` FOREIGN KEY (`materia_id`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_asignaciones`
--
ALTER TABLE `usuario_asignaciones`
  ADD CONSTRAINT `usuario_asignaciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_asignaciones_ibfk_2` FOREIGN KEY (`referencia_id`) REFERENCES `carreras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_asignaciones_ibfk_3` FOREIGN KEY (`referencia_id`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
