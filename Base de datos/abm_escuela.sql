-- MariaDB dump 10.19-11.3.0-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: abm_escuela
-- ------------------------------------------------------
-- Server version	11.3.0-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `asignaturas`
--

DROP TABLE IF EXISTS `asignaturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asignaturas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `cantidaddehoras` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asignaturas`
--

LOCK TABLES `asignaturas` WRITE;
/*!40000 ALTER TABLE `asignaturas` DISABLE KEYS */;
INSERT INTO `asignaturas` VALUES
(3,'Matemáticas',50),
(4,'Lengua Española',40),
(5,'Ciencias Naturales',45);
/*!40000 ALTER TABLE `asignaturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asistencias`
--

DROP TABLE IF EXISTS `asistencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profesor_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_profesor_id` (`profesor_id`),
  CONSTRAINT `fk_profesor_id` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asistencias`
--

LOCK TABLES `asistencias` WRITE;
/*!40000 ALTER TABLE `asistencias` DISABLE KEYS */;
INSERT INTO `asistencias` VALUES
(1,33,'2023-11-16','presente'),
(2,40,'2023-11-16','presente'),
(3,47,'2023-11-24','justificado'),
(4,40,'2023-11-24','ausente'),
(5,47,'2023-11-25','ausente'),
(6,61,'2023-11-16','justificado'),
(7,40,'2023-11-16','presente'),
(8,58,'2023-11-16','presente'),
(9,51,'2023-12-10','presente'),
(10,33,'2023-12-10','justificado'),
(11,33,'2023-12-10','justificado'),
(12,33,'2023-12-29','justificado'),
(13,59,'2023-11-16','justificado'),
(14,58,'2023-12-01','presente'),
(15,46,'2023-11-16','ausente'),
(16,40,'2023-11-16','presente'),
(17,51,'2023-11-17','presente'),
(18,50,'2023-11-18','presente'),
(19,93,'2023-11-24','presente'),
(20,94,'2023-11-24','justificado');
/*!40000 ALTER TABLE `asistencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carreras`
--

DROP TABLE IF EXISTS `carreras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carreras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carreras`
--

LOCK TABLES `carreras` WRITE;
/*!40000 ALTER TABLE `carreras` DISABLE KEYS */;
INSERT INTO `carreras` VALUES
(1,'Carrera 1','Descripción de Carrera 1'),
(2,'Carrera 2','Descripción de Carrera 2'),
(3,'Carrera 3','Descripción de Carrera 3');
/*!40000 ALTER TABLE `carreras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `licencias`
--

DROP TABLE IF EXISTS `licencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `licencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `fechadeinicio` date NOT NULL,
  `fechadefin` date NOT NULL,
  `idprofesor` int(11) NOT NULL,
  `idtipos_licencias` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `licencias_FK` (`idprofesor`),
  KEY `licencias_FK_1` (`idtipos_licencias`),
  CONSTRAINT `licencias_FK` FOREIGN KEY (`idprofesor`) REFERENCES `profesores` (`id`),
  CONSTRAINT `licencias_FK_1` FOREIGN KEY (`idtipos_licencias`) REFERENCES `tipos_licencias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `licencias`
--

LOCK TABLES `licencias` WRITE;
/*!40000 ALTER TABLE `licencias` DISABLE KEYS */;
/*!40000 ALTER TABLE `licencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permisos`
--

DROP TABLE IF EXISTS `permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(254) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos`
--

LOCK TABLES `permisos` WRITE;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
INSERT INTO `permisos` VALUES
(1,'admin','Descripción del Permiso1','2023-11-21 09:02:46','2023-11-21 09:02:46'),
(2,'docente','Descripción del Permiso2','2023-11-21 09:02:46','2023-11-21 09:02:46'),
(3,'preceptor','Descripción del Permiso3','2023-11-21 09:02:46','2023-11-21 09:02:46');
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesores`
--

DROP TABLE IF EXISTS `profesores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profesores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombreyapellido` varchar(255) NOT NULL,
  `dni` varchar(255) NOT NULL,
  `domicilio` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `cv` varchar(255) NOT NULL,
  `fechadeingreso` date NOT NULL,
  `fechadebaja` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesores`
--

LOCK TABLES `profesores` WRITE;
/*!40000 ALTER TABLE `profesores` DISABLE KEYS */;
INSERT INTO `profesores` VALUES
(33,'Kenny Pablo','123123','3333','123123','admin@gmail.comASas','undefined','Captura de pantalla 2023-10-30 205651.png','2023-12-02','2023-11-12'),
(40,'Pablo Esteban','123123','santa','123123','admin@gmail.comASas','Captura de pantalla 2023-10-29 135658.png','Captura de pantalla 2023-10-30 205651.png','2023-11-25','2023-11-06'),
(46,'Juan Pérez','12345678','Calle 123','123456789','juanperez@email.com','foto.jpg','cv.pdf','2023-11-12',NULL),
(47,'María González','87654321','Calle 456','987654321','mariagonzalez@email.com','foto2.jpg','cv2.pdf','2023-11-11',NULL),
(48,'Pedro López','34567890','Calle 789','76543210','pedrolopez@email.com','foto3.jpg','cv3.pdf','2023-11-10',NULL),
(50,'Roberto Martínez','98765432','Calle 1213','32109876','robertomarti@email.com','foto5.jpg','cv5.pdf','2023-11-08',NULL),
(51,'Laura García','76543210','Calle 1415','10987654','lauragarcia@email.com','foto6.jpg','cv6.pdf','2023-11-07',NULL),
(52,'David Fernández','54321098','Calle 1617','98765432','davidfernan@email.com','foto7.jpg','cv7.pdf','2023-11-06',NULL),
(53,'Cristina Álvarez','32109876','Calle 1819','76543210','cristinaalv@email.com','foto8.jpg','cv8.pdf','2023-11-05',NULL),
(55,'Isabel Romero','98765432','Calle 2223','32109876','isabelromero@email.com','foto10.jpg','cv10.pdf','2023-11-03',NULL),
(56,'Luis Moreno','76543210','Calle 2425','10987654','luismoreno@email.com','foto11.jpg','cv11.pdf','2023-11-02',NULL),
(57,'Anabel Ruiz','54321098','Calle 2627','98765432','anabelruiz@email.com','foto12.jpg','cv12.pdf','2023-11-01',NULL),
(58,'Javier López','32109876','Calle 2829','76543210','javierlopez@email.com','foto13.jpg','cv13.pdf','2023-10-31',NULL),
(59,'Marta Gómez','10987654','Calle 3031','54321098','martagomez@email.com','foto14.jpg','cv14.pdf','2023-10-30',NULL),
(60,'Ruben Acosta','123123','santa','123123','admin@gmail.comASas','Captura de pantalla 2023-10-29 145952.png','Captura de pantalla 2023-11-01 102306.png','2023-11-12','2023-12-10'),
(61,'fabian Acosta','123123','santa','123123','admin@gmail.comASas','Captura de pantalla 2023-10-29 135658.png','Captura de pantalla 2023-10-29 134813.png','2023-11-12','2023-11-12'),
(62,'Pablo ramirez','123123','asd','123123','admin@gmail.comASas','Captura de pantalla 2023-10-29 134813.png','Captura de pantalla 2023-10-29 145952.png','2023-11-12','2023-11-26'),
(63,'Pablo ramirez','123123','asd','123123','admin@gmail.comASas','Captura de pantalla 2023-10-29 134813.png','Captura de pantalla 2023-10-29 145952.png','2023-11-12','2023-11-26'),
(64,'Pablo ramirezs','123123','asd','123123','admin@gmail.comASas','[object Object]','[object Object]','2023-11-12','2023-12-09'),
(65,'Fernando Jimenez','31355346','Barrio prueba','123123','admin@gmail.comASas','Captura de pantalla 2023-10-29 145952.png','Captura de pantalla 2023-10-29 145952.png','2023-11-16','2023-12-10'),
(66,'asddddasd','31355346','Barrio prueba','123123','admin@gmail.comASas','Captura de pantalla 2023-10-29 134813.png','Captura de pantalla 2023-10-29 135658.png','2023-11-16','2023-11-16'),
(71,'Pablo fabian','31355346','santa','123123','admin@gmail.comASas','[object Object]','','2023-11-18','2023-11-05'),
(72,'Pablo fabian','31355346','santa','123123','admin@gmail.comASas','[object Object]','','2023-11-18','2023-11-05'),
(73,'Pablo fabian','31355346','santa','123123','admin@gmail.comASas','[object Object]','','2023-11-18','2023-11-05'),
(74,'Pablo fabian','31355346','santa','123123','admin@gmail.comASas','[object Object]','','2023-11-18','2023-11-05'),
(75,'Pablo fabian','31355346','santa','123123','admin@gmail.comASas','[object Object]','','2023-11-18','2023-11-05'),
(76,'Pablo fabian','31355346','santa','123123','admin@gmail.comASas','[object Object]','','2023-11-18','2023-11-18'),
(77,'Pablo fabian','31355346','santa','123123','admin@gmail.comASas','[object Object]','','2023-11-18','2023-11-18'),
(78,'Pablo fabian','31355346','santa','123123','admin@gmail.comASas','[object Object]','','2023-11-18','2023-11-18'),
(79,'Pablo fabian','31355346','santa','123123','admin@gmail.comASas','[object Object]','','2023-11-18','2023-11-18'),
(80,'Pablo fabian','31355346','santa','123123','admin@gmail.comASas','[object Object]','','2023-11-18','2023-11-18'),
(81,'Pablo fabian','31355346','santa','123123','admin@gmail.comASas','[object Object]','','2023-11-18','2023-11-18'),
(83,'fjimenes','31355346','Barrio prueba','123123','admin@gmail.comASas','[object Object]','[object Object]','2023-11-18','2023-11-18'),
(84,'fjimenes','31355346','Barrio prueba','123123','admin@gmail.comASas','[object Object]','[object Object]','2023-11-18','2023-11-18'),
(85,'edaurdo','123123','Barrio prueba','123123','admin@gmail.comASas','Captura de pantalla 2023-10-29 134813.png','[object Object]','2023-11-19','2023-11-19'),
(86,'edaurdoaaa','123123','Barrio prueba','123123','admin@gmail.comASas','[object Object]','[object Object]','2023-11-07','2023-11-21'),
(88,'edaurdoaaa','123123','Barrio prueba','123123','admin@gmail.comASas','Captura de pantalla 2023-11-01 094544.png','[object Object]','2023-11-07','2023-11-21'),
(90,'Fernando Jimenezyyyyyyyyyyyyyyy','123123','Barrio prueba','123123','admin@gmail.comASas','undefined','[object Object]','2023-11-22','2023-11-21'),
(93,'Pablo Esteban','','','','','Captura de pantalla 2023-11-01 094544.png','[object Object]','2023-11-21','2023-11-21'),
(94,'Pablo Esteban acosta','','Barrio prueba','123123','admin@gmail.comASas','Captura de pantalla 2023-11-01 094544.png','[object Object]','2023-11-21','2023-11-21'),
(95,'prueba','31355346','3333','123123','admin@gmail.comASas','Captura de pantalla 2023-10-29 134813.png','[object Object]','2023-11-21','2023-11-21'),
(96,'prueba5','31355346','3333','123123','admin@gmail.comASas','Captura de pantalla 2023-10-29 134813.png','[object Object]','2023-11-21','2023-11-21'),
(97,'prueba5','31355346','3333','123123','admin@gmail.comASas','Captura de pantalla 2023-10-29 134813.png','[object Object]','2023-11-21','2023-11-21'),
(98,'prueba5','31355346','3333','123123','admin@gmail.comASas','Captura de pantalla 2023-10-29 134813.png','[object Object]','2023-11-21','2023-11-21'),
(99,'Fernando kenny','123123','asd','123123','admin@gmail.comASas','','undefined','2023-11-21','2023-11-21'),
(100,'Fernando kenny22','123123','asd','123123','admin@gmail.comASas','Captura de pantalla 2023-10-30 205651.png','ConstanciaCBU-CABA, 14 noviembre 2023.pdf','2023-11-21','2023-11-21');
/*!40000 ALTER TABLE `profesores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesores_asignaturas`
--

DROP TABLE IF EXISTS `profesores_asignaturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profesores_asignaturas` (
  `id_profesor` int(11) NOT NULL,
  `id_asignatura` int(11) NOT NULL,
  `cantidad_horas` int(11) NOT NULL,
  PRIMARY KEY (`id_profesor`,`id_asignatura`),
  KEY `profesores_asignaturas_FK_2` (`id_asignatura`),
  CONSTRAINT `profesores_asignaturas_FK_1` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id`),
  CONSTRAINT `profesores_asignaturas_FK_2` FOREIGN KEY (`id_asignatura`) REFERENCES `asignaturas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesores_asignaturas`
--

LOCK TABLES `profesores_asignaturas` WRITE;
/*!40000 ALTER TABLE `profesores_asignaturas` DISABLE KEYS */;
INSERT INTO `profesores_asignaturas` VALUES
(33,3,50);
/*!40000 ALTER TABLE `profesores_asignaturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesores_carreras`
--

DROP TABLE IF EXISTS `profesores_carreras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profesores_carreras` (
  `id_profesor` int(11) NOT NULL,
  `id_carrera` int(11) NOT NULL,
  PRIMARY KEY (`id_profesor`,`id_carrera`),
  KEY `profesores_carreras_FK_2` (`id_carrera`),
  CONSTRAINT `profesores_carreras_FK_1` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id`),
  CONSTRAINT `profesores_carreras_FK_2` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesores_carreras`
--

LOCK TABLES `profesores_carreras` WRITE;
/*!40000 ALTER TABLE `profesores_carreras` DISABLE KEYS */;
INSERT INTO `profesores_carreras` VALUES
(33,2);
/*!40000 ALTER TABLE `profesores_carreras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_licencias`
--

DROP TABLE IF EXISTS `tipos_licencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipos_licencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipodelicencia` varchar(254) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_licencias`
--

LOCK TABLES `tipos_licencias` WRITE;
/*!40000 ALTER TABLE `tipos_licencias` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipos_licencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `id_permisos` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuarios_FK` (`id_permisos`),
  CONSTRAINT `usuarios_FK` FOREIGN KEY (`id_permisos`) REFERENCES `permisos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES
(1,'1234','paablokenny20@gmail.com','Jaime',2),
(2,'1234','fjimenez@gmail.com','Fjimenez',1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-25 12:45:46
