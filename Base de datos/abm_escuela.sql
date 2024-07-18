-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 18-07-2024 a las 19:38:12
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
  `cantidaddehoras` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `asignaturas`
--

INSERT INTO `asignaturas` (`id`, `nombre`, `cantidaddehoras`) VALUES
(3, 'Matemáticas', 50),
(4, 'Lengua Española', 40),
(5, 'Ciencias Naturales', 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL,
  `profesor_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`id`, `profesor_id`, `fecha`, `estado`) VALUES
(1, 33, '2023-11-16', 'presente'),
(2, 40, '2023-11-16', 'presente'),
(3, 47, '2023-11-24', 'justificado'),
(4, 40, '2023-11-24', 'ausente'),
(5, 47, '2023-11-25', 'ausente'),
(6, 61, '2023-11-16', 'justificado'),
(7, 40, '2023-11-16', 'presente'),
(8, 58, '2023-11-16', 'presente'),
(9, 51, '2023-12-10', 'presente'),
(10, 33, '2023-12-10', 'justificado'),
(11, 33, '2023-12-10', 'justificado'),
(12, 33, '2023-12-29', 'justificado'),
(13, 59, '2023-11-16', 'justificado'),
(14, 58, '2023-12-01', 'presente'),
(15, 46, '2023-11-16', 'ausente'),
(16, 40, '2023-11-16', 'presente'),
(17, 51, '2023-11-17', 'presente'),
(18, 50, '2023-11-18', 'presente'),
(19, 93, '2023-11-24', 'presente'),
(20, 94, '2023-11-24', 'justificado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Carrera 1', 'Descripción de Carrera 1'),
(2, 'Carrera 2', 'Descripción de Carrera 2'),
(3, 'Carrera 3', 'Descripción de Carrera 3');

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
  `motivo_baja` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `idtipos_licencias` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `nombre`, `descripcion`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 'admin', 'Descripción del Permiso1', '2023-11-21 09:02:46', '2023-11-21 09:02:46'),
(2, 'docente', 'Descripción del Permiso2', '2023-11-21 09:02:46', '2023-11-21 09:02:46'),
(3, 'preceptor', 'Descripción del Permiso3', '2023-11-21 09:02:46', '2023-11-21 09:02:46');

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
  `fechadebaja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `nombreyapellido`, `dni`, `domicilio`, `telefono`, `email`, `foto`, `cv`, `fechadeingreso`, `fechadebaja`) VALUES
(33, 'Kenny Pablo', '123123', '3333', '123123', 'admin@gmail.comASas', 'undefined', 'Captura de pantalla 2023-10-30 205651.png', '2023-12-02', '2023-11-12'),
(40, 'Pablo Esteban', '123123', 'santa', '123123', 'admin@gmail.comASas', 'Captura de pantalla 2023-10-29 135658.png', 'Captura de pantalla 2023-10-30 205651.png', '2023-11-25', '2023-11-06'),
(46, 'Juan Pérez', '12345678', 'Calle 123', '123456789', 'juanperez@email.com', 'foto.jpg', 'cv.pdf', '2023-11-12', NULL),
(47, 'María González', '87654321', 'Calle 456', '987654321', 'mariagonzalez@email.com', 'foto2.jpg', 'cv2.pdf', '2023-11-11', NULL),
(48, 'Pedro López', '34567890', 'Calle 789', '76543210', 'pedrolopez@email.com', 'foto3.jpg', 'cv3.pdf', '2023-11-10', NULL),
(50, 'Roberto Martínez', '98765432', 'Calle 1213', '32109876', 'robertomarti@email.com', 'foto5.jpg', 'cv5.pdf', '2023-11-08', NULL),
(51, 'Laura García', '76543210', 'Calle 1415', '10987654', 'lauragarcia@email.com', 'foto6.jpg', 'cv6.pdf', '2023-11-07', NULL),
(52, 'David Fernández', '54321098', 'Calle 1617', '98765432', 'davidfernan@email.com', 'foto7.jpg', 'cv7.pdf', '2023-11-06', NULL),
(53, 'Cristina Álvarez', '32109876', 'Calle 1819', '76543210', 'cristinaalv@email.com', 'foto8.jpg', 'cv8.pdf', '2023-11-05', NULL),
(55, 'Isabel Romero', '98765432', 'Calle 2223', '32109876', 'isabelromero@email.com', 'foto10.jpg', 'cv10.pdf', '2023-11-03', NULL),
(56, 'Luis Moreno', '76543210', 'Calle 2425', '10987654', 'luismoreno@email.com', 'foto11.jpg', 'cv11.pdf', '2023-11-02', NULL),
(57, 'Anabel Ruiz', '54321098', 'Calle 2627', '98765432', 'anabelruiz@email.com', 'foto12.jpg', 'cv12.pdf', '2023-11-01', NULL),
(58, 'Javier López', '32109876', 'Calle 2829', '76543210', 'javierlopez@email.com', 'foto13.jpg', 'cv13.pdf', '2023-10-31', NULL),
(59, 'Marta Gómez', '10987654', 'Calle 3031', '54321098', 'martagomez@email.com', 'foto14.jpg', 'cv14.pdf', '2023-10-30', NULL),
(60, 'Ruben Acosta', '123123', 'santa', '123123', 'admin@gmail.comASas', 'Captura de pantalla 2023-10-29 145952.png', 'Captura de pantalla 2023-11-01 102306.png', '2023-11-12', '2023-12-10'),
(61, 'fabian Acosta', '123123', 'santa', '123123', 'admin@gmail.comASas', 'Captura de pantalla 2023-10-29 135658.png', 'Captura de pantalla 2023-10-29 134813.png', '2023-11-12', '2023-11-12'),
(62, 'Pablo ramirez', '123123', 'asd', '123123', 'admin@gmail.comASas', 'Captura de pantalla 2023-10-29 134813.png', 'Captura de pantalla 2023-10-29 145952.png', '2023-11-12', '2023-11-26'),
(63, 'Pablo ramirez', '123123', 'asd', '123123', 'admin@gmail.comASas', 'Captura de pantalla 2023-10-29 134813.png', 'Captura de pantalla 2023-10-29 145952.png', '2023-11-12', '2023-11-26'),
(64, 'Pablo ramirezs', '123123', 'asd', '123123', 'admin@gmail.comASas', '[object Object]', '[object Object]', '2023-11-12', '2023-12-09'),
(65, 'Fernando Jimenez', '31355346', 'Barrio prueba', '123123', 'admin@gmail.comASas', 'Captura de pantalla 2023-10-29 145952.png', 'Captura de pantalla 2023-10-29 145952.png', '2023-11-16', '2023-12-10'),
(66, 'asddddasd', '31355346', 'Barrio prueba', '123123', 'admin@gmail.comASas', 'Captura de pantalla 2023-10-29 134813.png', 'Captura de pantalla 2023-10-29 135658.png', '2023-11-16', '2023-11-16'),
(71, 'Pablo fabian', '31355346', 'santa', '123123', 'admin@gmail.comASas', '[object Object]', '', '2023-11-18', '2023-11-05'),
(72, 'Pablo fabian', '31355346', 'santa', '123123', 'admin@gmail.comASas', '[object Object]', '', '2023-11-18', '2023-11-05'),
(73, 'Pablo fabian', '31355346', 'santa', '123123', 'admin@gmail.comASas', '[object Object]', '', '2023-11-18', '2023-11-05'),
(74, 'Pablo fabian', '31355346', 'santa', '123123', 'admin@gmail.comASas', '[object Object]', '', '2023-11-18', '2023-11-05'),
(75, 'Pablo fabian', '31355346', 'santa', '123123', 'admin@gmail.comASas', '[object Object]', '', '2023-11-18', '2023-11-05'),
(76, 'Pablo fabian', '31355346', 'santa', '123123', 'admin@gmail.comASas', '[object Object]', '', '2023-11-18', '2023-11-18'),
(77, 'Pablo fabian', '31355346', 'santa', '123123', 'admin@gmail.comASas', '[object Object]', '', '2023-11-18', '2023-11-18'),
(78, 'Pablo fabian', '31355346', 'santa', '123123', 'admin@gmail.comASas', '[object Object]', '', '2023-11-18', '2023-11-18'),
(79, 'Pablo fabian', '31355346', 'santa', '123123', 'admin@gmail.comASas', '[object Object]', '', '2023-11-18', '2023-11-18'),
(80, 'Pablo fabian', '31355346', 'santa', '123123', 'admin@gmail.comASas', '[object Object]', '', '2023-11-18', '2023-11-18'),
(81, 'Pablo fabian', '31355346', 'santa', '123123', 'admin@gmail.comASas', '[object Object]', '', '2023-11-18', '2023-11-18'),
(83, 'fjimenes', '31355346', 'Barrio prueba', '123123', 'admin@gmail.comASas', '[object Object]', '[object Object]', '2023-11-18', '2023-11-18'),
(84, 'fjimenes', '31355346', 'Barrio prueba', '123123', 'admin@gmail.comASas', '[object Object]', '[object Object]', '2023-11-18', '2023-11-18'),
(85, 'edaurdo', '123123', 'Barrio prueba', '123123', 'admin@gmail.comASas', 'Captura de pantalla 2023-10-29 134813.png', '[object Object]', '2023-11-19', '2023-11-19'),
(86, 'edaurdoaaa', '123123', 'Barrio prueba', '123123', 'admin@gmail.comASas', '[object Object]', '[object Object]', '2023-11-07', '2023-11-21'),
(88, 'edaurdoaaa', '123123', 'Barrio prueba', '123123', 'admin@gmail.comASas', 'Captura de pantalla 2023-11-01 094544.png', '[object Object]', '2023-11-07', '2023-11-21'),
(90, 'Fernando Jimenezyyyyyyyyyyyyyyy', '123123', 'Barrio prueba', '123123', 'admin@gmail.comASas', 'undefined', '[object Object]', '2023-11-22', '2023-11-21'),
(93, 'Pablo Esteban', '', '', '', '', 'Captura de pantalla 2023-11-01 094544.png', '[object Object]', '2023-11-21', '2023-11-21'),
(94, 'Pablo Esteban acosta', '', 'Barrio prueba', '123123', 'admin@gmail.comASas', 'Captura de pantalla 2023-11-01 094544.png', '[object Object]', '2023-11-21', '2023-11-21'),
(95, 'prueba', '31355346', '3333', '123123', 'admin@gmail.comASas', 'Captura de pantalla 2023-10-29 134813.png', '[object Object]', '2023-11-21', '2023-11-21'),
(96, 'prueba5', '31355346', '3333', '123123', 'admin@gmail.comASas', 'Captura de pantalla 2023-10-29 134813.png', '[object Object]', '2023-11-21', '2023-11-21'),
(97, 'prueba5', '31355346', '3333', '123123', 'admin@gmail.comASas', 'Captura de pantalla 2023-10-29 134813.png', '[object Object]', '2023-11-21', '2023-11-21'),
(98, 'prueba5', '31355346', '3333', '123123', 'admin@gmail.comASas', 'Captura de pantalla 2023-10-29 134813.png', '[object Object]', '2023-11-21', '2023-11-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores_asignaturas`
--

CREATE TABLE `profesores_asignaturas` (
  `id_profesor` int(11) NOT NULL,
  `id_asignatura` int(11) NOT NULL,
  `cantidad_horas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores_asignaturas`
--

INSERT INTO `profesores_asignaturas` (`id_profesor`, `id_asignatura`, `cantidad_horas`) VALUES
(33, 3, 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores_carreras`
--

CREATE TABLE `profesores_carreras` (
  `id_profesor` int(11) NOT NULL,
  `id_carrera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores_carreras`
--

INSERT INTO `profesores_carreras` (`id_profesor`, `id_carrera`) VALUES
(33, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_licencias`
--

CREATE TABLE `tipos_licencias` (
  `id` int(11) NOT NULL,
  `tipodelicencia` varchar(254) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `id_permisos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `password`, `correo`, `nombre`, `id_permisos`) VALUES
(1, '1234', 'paablokenny20@gmail.com', 'Jaime', 2),
(2, '1234', 'fjimenez@gmail.com', 'Fjimenez', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `dicta`
--
ALTER TABLE `dicta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `licencias`
--
ALTER TABLE `licencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `tipos_licencias`
--
ALTER TABLE `tipos_licencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

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

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_FK` FOREIGN KEY (`id_permisos`) REFERENCES `permisos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
