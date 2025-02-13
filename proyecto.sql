-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-02-2025 a las 22:09:48
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
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ambiente`
--

CREATE TABLE `ambiente` (
  `id_ambiente` int(11) NOT NULL,
  `nombre_ambiente` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `id_area` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ambiente`
--

INSERT INTO `ambiente` (`id_ambiente`, `nombre_ambiente`, `descripcion`, `id_area`) VALUES
(1, 'COORDINACION FORMACION PROFESIONAL', 'ubicado en tercer piso', 1),
(2, 'FORMACION PROFESIONAL', 'ubicado en tercer piso', 1),
(3, 'CAFETERIA', 'ubicado en tercer piso', 1),
(4, 'ADMINISTRACION EDUCATIVA', 'ubicado en tercer piso', 1),
(5, 'LABORATORIO', 'ubicado en tercer piso', 1),
(6, 'PRODUCCION', 'ubicado en tercer piso', 1),
(7, 'ALMACEN', 'ubicado en tercer piso', 1),
(8, 'GESTION DOCUMENTAL', 'ubicado en tercer piso', 2),
(9, 'SERIGRAFIA', 'ubicado en tercer piso', 2),
(10, 'SUBDIRECCION', 'ubicado en tercer piso', 1),
(11, 'IMPRESION OFSET', 'ubicado en tercer piso', 2),
(12, 'HUB CREATIVO', 'ubicado en tercer piso', 2),
(13, 'INSTRUCTORES', 'ubicado en tercer piso', 2),
(14, 'COORDINACION ACADEMICA', 'ubicado en tercer piso', 1),
(15, 'SERVICIOS GENERALES', 'ubicado en tercer piso', 1),
(16, 'FORMACION COMPLEMENTARIA', 'ubicado en tercer piso', 2),
(17, 'ARTICULACION CON LA MEDIA', 'ubicado en tercer piso', 1),
(18, 'TALLER ENI', 'ubicado en tercer piso', 2),
(19, 'ASEO', 'ubicado en tercer piso', 1),
(20, 'ENCUADERNACION', 'ubicado en tercer piso', 2),
(21, 'ADMINISTRATIVA', 'ubicado en tercer piso', 1),
(22, 'BOCETACION PARA DISEÑO GRAFICO', 'ubicado en tercer piso', 2),
(23, 'FLEXOGRAFIA', 'ubicado en tercer piso', 2),
(24, 'PRENSA', 'ubicado en tercer piso', 2),
(25, 'IMPRESION 3D', 'ubicado en tercer piso', 2),
(26, 'BIENESTAR', 'ubicado en tercer piso', 1),
(27, 'BILINGUISMO', 'ubicado en tercer piso', 2),
(28, 'TRABAJADOR OFICIAL', 'ubicado en tercer piso', 1),
(29, 'AUDIOVISUALES', 'ubicado en tercer piso', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`id`, `nombre`) VALUES
(1, 'ADMINISTRATIVO'),
(2, 'FORMACION');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentadante`
--

CREATE TABLE `cuentadante` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `documento` int(11) NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuentadante`
--

INSERT INTO `cuentadante` (`id`, `nombre`, `documento`, `tipo`) VALUES
(1, 'JUAN', 123, 1),
(2, 'ana', 123, 2),
(3, 'melisa', 156, 2),
(4, 'miriam', 123, 2),
(5, 'Carolina batidas', 10001326, 1),
(6, 'Carolina estrada ', 215151200, 1),
(7, 'Carolina batidas', 1, 1),
(8, 'Carolina batidas', 2, 1),
(9, 'Carolina batidas', 0, 1),
(10, 'Alvarado nose ', 20121211, 1),
(11, 'Alvarado nose ', 3, 1),
(12, 'Alvarado nose ', 4, 1),
(13, 'Carolina batidas', 5, 1),
(14, '', 0, 1),
(15, '4554', 100650210, 1),
(16, '4554', 1, 1),
(17, '4554', 2147483647, 1),
(18, 'Carolina batidas', 1000620538, 1),
(19, '2121202021515', 1, 1),
(20, 'Carolina batid', 222, 1),
(21, 'Carolina batidas', 2454544, 1),
(22, 'Alvarado nose ', 100000000, 1),
(23, 'Alejandro bustamante', 1000620597, 1),
(24, 'Carolina batidas', 20202, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentadante_solicitud`
--

CREATE TABLE `cuentadante_solicitud` (
  `id` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `id_cuentadante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuentadante_solicitud`
--

INSERT INTO `cuentadante_solicitud` (`id`, `id_solicitud`, `id_cuentadante`) VALUES
(1, 1, 5),
(2, 2, 6),
(3, 3, 7),
(4, 4, 8),
(5, 5, 9),
(6, 6, 10),
(7, 7, 11),
(8, 8, 12),
(9, 9, 13),
(10, 10, 14),
(11, 11, 15),
(12, 12, 15),
(13, 13, 16),
(14, 14, 17),
(15, 15, 16),
(16, 16, 18),
(17, 17, 18),
(18, 18, 9),
(19, 19, 19),
(20, 20, 20),
(21, 21, 21),
(22, 22, 21),
(23, 23, 22),
(24, 24, 22),
(25, 25, 23),
(26, 26, 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elemento`
--

CREATE TABLE `elemento` (
  `id_elemento` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `und_medida` varchar(255) NOT NULL,
  `ambiente` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `cantidad_solicitada` int(11) DEFAULT NULL,
  `cantidad_entregada` int(11) DEFAULT 0,
  `nombre` varchar(255) NOT NULL,
  `estado` varchar(11) NOT NULL,
  `observaciones` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `elemento`
--

INSERT INTO `elemento` (`id_elemento`, `codigo`, `descripcion`, `und_medida`, `ambiente`, `cantidad`, `cantidad_solicitada`, `cantidad_entregada`, `nombre`, `estado`, `observaciones`) VALUES
(1, 1, 'Lapiz', 'Caja', 7, 100, 0, 0, 'Lapiz n8', '1', 'Lapiz del numero 8');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elementos_solicitud_periodica`
--

CREATE TABLE `elementos_solicitud_periodica` (
  `id` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `id_elemento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elemento_solicitud_anual`
--

CREATE TABLE `elemento_solicitud_anual` (
  `id` int(11) NOT NULL,
  `fecha_soli` date NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `id_elemento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `id` int(11) NOT NULL,
  `nombre_especialidad` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` (`id`, `nombre_especialidad`) VALUES
(1, 'INGENIERO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha`
--

CREATE TABLE `ficha` (
  `numero_ficha` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ficha`
--

INSERT INTO `ficha` (`numero_ficha`, `id_programa`) VALUES
(2532155, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instructor`
--

CREATE TABLE `instructor` (
  `id` int(11) NOT NULL,
  `cedula` int(11) NOT NULL,
  `nombre_instructor` varchar(255) NOT NULL,
  `celular` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` int(11) NOT NULL,
  `especialidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `instructor`
--

INSERT INTO `instructor` (`id`, `cedula`, `nombre_instructor`, `celular`, `correo`, `contrasena`, `rol`, `especialidad`) VALUES
(1, 654, 'yurani', '1256', 'yurani@gmail.com', '$2y$10$tJJpq0XfuwkXdAazW7K81OmfZoQRR9UZyv/6b0d1deAttsmvXj7Y.', 1, 1),
(2, 2345, 'ana lucia', '345666', 'ana@gmail.com', '$2y$10$AWDi8a8ce/HvlAAZOpuat.XmYg.SG367Gb2h.QxFVZFUGz0.sQNpy', 4, 1),
(3, 234, 'sofia', '12345', 'sofia@gmail.com', '$2y$10$ciHVD9YTEw5HBBXiMSJ70e2lSn2Nc1FzZsVQDFntLKZj/6bWpPFi6', 2, 1),
(4, 1, 'admin', '1', 'admin@admin.com', '$2y$10$9RcxZ8ofeUqo46dJhZt6leA7pz2M9elEJMjnd9to0MwbgOlP2QLEa', 3, 1),
(5, 12345678, 'Maycol', '1234567890', 'ADMINEW@gmail.com', '$2y$10$Ky7niPwkrhEzwOPwX6K8hOZwxgK66VsHFMz.Y6Q9SqSTpVP4zxriK', 1, 1),
(6, 1000235150, 'CAROLINA', '3142812099', 'carolina@gmail.com', '$2y$10$if60KtV3fT/DCdu9W8N49egVNaktv8bviWujQDIKLMSP.OqmV.ctC', 4, 1),
(7, 123456, 'ANDREA', '31428154', 'andreacenigraf@gmail.com', '$2y$10$PBUDnChponRvRWcuyVIwVOTy1WwUpAMpSJN98/SX9Q3zKjEP0bMRG', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimiento`
--

CREATE TABLE `mantenimiento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mantenimiento`
--

INSERT INTO `mantenimiento` (`id`, `nombre`) VALUES
(1, 'PREVENTIVO'),
(2, 'CORRECTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maquina`
--

CREATE TABLE `maquina` (
  `id` int(11) NOT NULL,
  `serial` int(11) NOT NULL,
  `adquisicion` date NOT NULL,
  `nombre_maquina` varchar(255) NOT NULL,
  `marca` varchar(255) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `placa` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `id_ambiente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `maquina`
--

INSERT INTO `maquina` (`id`, `serial`, `adquisicion`, `nombre_maquina`, `marca`, `modelo`, `placa`, `cantidad`, `id_ambiente`) VALUES
(1, 12345, '2024-05-21', 'impresora', 'epson', 'tx135', 3244566, 9, 15),
(2, 23334, '2024-05-21', 'impresora', 'epson', 'tx1390', 3244566, 78, 14),
(3, 1010, '2024-11-28', 'Hp Cp', '550', '2021', 111, 10101, 10),
(4, 2, '2024-12-03', 'Hp Cp', '550', '2023', 1, 25, 9),
(5, 1, '2024-12-03', 'Hp Cp', '550', '2021', 2, 11, 12),
(6, 10, '2024-12-07', 'Hp Cp', '550', '2021', 22, 22, 10),
(7, 0, '2024-12-09', 'Aula 108', '00', '00', 0, 1, 25),
(8, 202, '2024-12-09', '0202', '0202', '0202', 202, 22, 10),
(9, 225, '2024-12-11', 'Aula 108', '22', '223', 224, 2, 7),
(10, 11, '0000-00-00', 'Computador ', 'LENOVO', '2008', 5520, 5, 29),
(11, 22, '0000-00-00', 'Computador ', '22', '22', 22, 22, 11),
(12, 3, '0000-00-00', 'Computador ', '03', '3', 3, 3, 8),
(13, 44, '0000-00-00', 'Hp', 'ju', 'j44', 44, 44, 10),
(14, 55, '0000-00-00', '55', '55', '55', 55, 55, 8),
(15, 88, '0000-00-00', 'Computador ', '88', '88', 88, 88, 10),
(16, 15, '0000-00-00', 'Computador ', 'LENOVO', '2015', 265, 8, 7),
(17, 4, '0000-00-00', '04', '04', '04', 4, 4, 9),
(18, 32, '0000-00-00', '032', '032', '032', 32, 23, 9),
(19, 55555, '0000-00-00', '555555', '555555', '555555', 55555, 55555, 14),
(20, 555, '0000-00-00', '04', '01', '02', 0, 7777, 17),
(21, 101, '0000-00-00', '04', '010', '000', 10, 101, 2),
(22, 110, '0000-00-00', 'Computador ', 'LENOVO', '2021', 0, 0, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa`
--

CREATE TABLE `programa` (
  `id_programa` int(11) NOT NULL,
  `nombre_programa` varchar(255) NOT NULL,
  `id_instructor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `programa`
--

INSERT INTO `programa` (`id_programa`, `nombre_programa`, `id_instructor`) VALUES
(1, 'ADSO', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'COORDINADOR'),
(3, 'ALMACEN'),
(4, 'PERSONAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_anual`
--

CREATE TABLE `solicitud_anual` (
  `id_anual` int(11) NOT NULL,
  `fecha_soli` date NOT NULL,
  `nombre_solici` varchar(255) NOT NULL,
  `documento` int(11) NOT NULL,
  `ficha_soli` int(11) NOT NULL,
  `programa_soli` int(11) NOT NULL,
  `cantidad_soli` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud_anual`
--

INSERT INTO `solicitud_anual` (`id_anual`, `fecha_soli`, `nombre_solici`, `documento`, `ficha_soli`, `programa_soli`, `cantidad_soli`) VALUES
(29, '2025-01-30', 'CAROLINA', 1000235150, 2532155, 1, 0),
(30, '2025-02-03', 'CAROLINA', 1000235150, 2532155, 1, 12),
(31, '2025-02-11', 'CAROLINA', 1000235150, 2532155, 1, 1010),
(32, '2025-02-11', 'CAROLINA', 1000235150, 2532155, 1, 505),
(33, '2025-02-11', 'CAROLINA', 1000235150, 2532155, 1, 10100),
(34, '2025-02-11', 'CAROLINA', 1000235150, 2532155, 1, 10100),
(35, '2025-02-11', 'CAROLINA', 1000235150, 2532155, 1, 1010),
(36, '2025-02-11', 'CAROLINA', 1000235150, 2532155, 1, 1010),
(37, '2025-02-11', 'CAROLINA', 1000235150, 2532155, 1, 1010),
(38, '2025-02-12', 'CAROLINA', 1000235150, 2532155, 1, 15),
(39, '2025-02-12', 'CAROLINA', 1000235150, 2532155, 1, -2),
(40, '2025-02-12', 'CAROLINA', 1000235150, 2532155, 1, 1010),
(41, '2025-02-12', 'CAROLINA', 1000235150, 2532155, 1, 1010),
(42, '2025-02-12', 'CAROLINA', 1000235150, 2532155, 1, 1010),
(43, '2025-02-12', 'CAROLINA', 1000235150, 2532155, 1, 1010),
(44, '2025-02-12', 'CAROLINA', 1000235150, 2532155, 1, 101),
(45, '2025-02-12', 'CAROLINA', 1000235150, 2532155, 1, 1010),
(46, '2025-02-12', 'CAROLINA', 1000235150, 2532155, 1, 10101),
(47, '2025-02-12', 'CAROLINA', 1000235150, 2532155, 1, 4441),
(52, '2025-02-12', 'CAROLINA', 1000235150, 2532155, 1, 1010),
(53, '2025-02-12', 'CAROLINA', 1000235150, 2532155, 1, 10101),
(54, '2025-02-12', 'CAROLINA', 1000235150, 2532155, 1, 1111),
(55, '2025-02-12', 'CAROLINA', 1000235150, 2532155, 1, 0),
(56, '2025-02-12', 'CAROLINA', 1000235150, 2532155, 1, 0),
(57, '2025-02-12', 'CAROLINA', 1000235150, 2532155, 1, 1010),
(58, '2025-02-13', 'CAROLINA', 1000235150, 2532155, 1, 20),
(59, '2025-02-13', 'CAROLINA', 1000235150, 2532155, 1, 1010),
(66, '2025-02-13', 'Maycol', 12345678, 2532155, 1, 5),
(67, '2025-02-13', 'CAROLINA', 1000235150, 2532155, 1, 5),
(68, '2025-02-13', 'CAROLINA', 1000235150, 2532155, 1, 1010);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_mantenimiento`
--

CREATE TABLE `solicitud_mantenimiento` (
  `id` int(11) NOT NULL,
  `solicitud` int(11) NOT NULL,
  `fecha_soli` date NOT NULL,
  `necesidad` varchar(255) NOT NULL,
  `maquina` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `suministro` varchar(255) NOT NULL,
  `id_instructor` int(11) NOT NULL,
  `id_ambiente` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud_mantenimiento`
--

INSERT INTO `solicitud_mantenimiento` (`id`, `solicitud`, `fecha_soli`, `necesidad`, `maquina`, `tipo`, `suministro`, `id_instructor`, `id_ambiente`, `id_rol`) VALUES
(1, 2, '2024-11-28', 'Necesito arreglar el piso owo ', 3, 1, '1010', 6, 10, 4),
(2, 2, '2024-11-28', 'Necesito arreglar el piso owo ', 3, 1, '1010', 6, 10, 4),
(3, 2, '2024-11-28', 'Necesito arreglar el piso owo ', 3, 1, '1010', 6, 10, 4),
(4, 1, '2024-12-03', 'sE REQUIERE MAntenimiento en equipos de la oficina', 4, 1, 'Teclas', 6, 9, 4),
(5, 1, '2024-12-03', 'Necesito arreglar el piso owo ', 5, 1, 'nqada', 6, 12, 4),
(6, 4, '2024-12-07', 'Necesito arreglar el piso owo ', 6, 1, '', 6, 10, 4),
(7, 3, '2024-12-09', 'Se requiere un ambiente para la presentacion de los proyectos de cerigrafia', 7, 2, 'Ninguna', 6, 25, 4),
(8, 3, '2024-12-09', 'Se requiere un ambiente para la presentacion de los proyectos de cerigrafia', 7, 2, 'Ninguna', 6, 25, 4),
(9, 3, '2024-12-09', 'Se requiere un ambiente para la presentacion de los proyectos de cerigrafia', 7, 2, 'Ninguna', 6, 25, 4),
(10, 5, '2024-12-09', 'noshe owo', 7, 2, '00', 6, 16, 4),
(11, 2, '2024-12-09', 'Necesito arreglar el piso owo ', 7, 2, '000', 6, 12, 4),
(12, 1, '2024-12-09', 'Solicitud 01', 5, 0, '', 6, 8, 4),
(13, 1, '2024-12-09', 'Solicitud 01', 5, 0, '', 6, 8, 4),
(14, 1, '2024-12-09', 'Necesito arreglar el piso owo ', 5, 0, '', 6, 10, 4),
(15, 3, '2024-12-09', 'Necesito arreglar el piso owo ', 5, 0, '', 6, 11, 4),
(16, 1, '2024-12-11', 'Solicitud 01', 5, 0, '', 6, 9, 4),
(17, 2, '2024-12-11', 'noshe owo', 9, 0, '', 6, 7, 4),
(18, 3, '2024-12-11', 'Se solicitara equipos de computo para exposiciones de proyecto', 10, 0, '', 6, 29, 4),
(19, 3, '2024-12-11', 'Se solicitara equipos de computo para exposiciones de proyecto', 10, 0, '', 6, 29, 4),
(20, 5, '2024-12-11', 'Se solicitara equipos de computo para exposiciones de proyecto', 5, 0, '', 6, 10, 4),
(21, 1, '2024-12-11', '02', 4, 0, '', 6, 7, 4),
(22, 2, '2024-12-11', 'Se solicitara equipos de computo para exposiciones de proyecto', 5, 0, '', 6, 11, 4),
(23, 1, '2024-12-11', 'Se solicitara equipos de computo para exposiciones de proyecto', 4, 0, '', 6, 12, 4),
(24, 5, '2024-12-11', '02', 11, 0, '', 6, 11, 4),
(25, 5, '2024-12-11', '02', 11, 0, '', 6, 11, 4),
(26, 2, '2024-12-11', 'Se solicitara equipos de computo para exposiciones de proyecto', 12, 0, '', 6, 8, 4),
(27, 2, '2024-12-11', '02', 11, 0, '', 6, 9, 4),
(28, 5, '2024-12-11', 'Nose', 13, 0, '', 6, 10, 4),
(29, 5, '2024-12-11', 'Nose', 13, 0, '', 6, 10, 4),
(30, 2, '2024-12-11', 'Nose', 14, 0, '', 6, 8, 4),
(31, 2, '2024-12-11', '02', 15, 0, '', 6, 10, 4),
(32, 2, '2024-12-11', '02', 7, 0, '', 6, 10, 4),
(33, 3, '2024-12-12', '02', 7, 0, '', 6, 8, 4),
(34, 3, '2024-12-12', '02', 7, 0, '', 6, 8, 4),
(35, 3, '2024-12-12', '02', 7, 0, '', 6, 8, 4),
(36, 3, '2024-12-12', '02', 7, 0, '', 6, 8, 4),
(37, 3, '2024-12-12', '02', 7, 0, '', 6, 8, 4),
(38, 3, '2024-12-12', '02', 7, 0, '', 6, 8, 4),
(39, 1, '2024-12-12', 'ppp', 7, 0, '', 6, 15, 4),
(40, 1, '2024-12-12', 'ppp', 7, 0, '', 6, 15, 4),
(41, 1, '2024-12-12', 'ppp', 7, 0, '', 6, 15, 4),
(42, 4, '2024-12-12', '02', 7, 0, '', 6, 13, 4),
(43, 4, '2024-12-12', '02', 7, 0, '', 6, 13, 4),
(44, 3, '2024-12-12', '99', 7, 0, '', 6, 13, 4),
(45, 3, '2024-12-12', '99', 7, 0, '', 6, 13, 4),
(46, 3, '2024-12-12', '99', 7, 0, '', 6, 13, 4),
(47, 3, '2024-12-12', '99', 7, 0, '', 6, 13, 4),
(48, 3, '2024-12-12', '99', 7, 0, '', 6, 13, 4),
(49, 3, '2024-12-12', '99', 7, 0, '', 6, 13, 4),
(50, 3, '2024-12-12', '99', 7, 0, '', 6, 13, 4),
(51, 5, '2025-01-23', 'Solicitud de computadores ', 16, 0, '', 6, 7, 4),
(52, 5, '2025-01-23', 'Solicitud de computadores ', 16, 0, '', 6, 7, 4),
(53, 5, '2025-01-23', 'Solicitud de computadores ', 16, 0, '', 6, 7, 4),
(54, 4, '2025-01-27', 'Solicitud de computadores ', 10, 0, '', 6, 9, 4),
(55, 1, '2025-01-27', 'Nose', 5, 0, '', 6, 14, 4),
(56, 3, '2025-01-27', '02', 7, 0, '', 6, 13, 4),
(63, 2, '2025-01-27', '02', 5, 0, '', 6, 15, 4),
(64, 2, '2025-01-27', '02', 5, 0, '', 6, 15, 4),
(65, 2, '2025-01-27', '02', 5, 0, '', 6, 15, 4),
(66, 2, '2025-01-27', '02', 5, 0, '', 6, 15, 4),
(67, 3, '2025-01-27', 'Se solicitara equipos de computo para exposiciones de proyecto', 6, 0, '', 6, 13, 4),
(68, 3, '2025-01-27', 'Se solicitara equipos de computo para exposiciones de proyecto', 6, 0, '', 6, 13, 4),
(69, 3, '2025-01-27', 'Se solicitara equipos de computo para exposiciones de proyecto', 6, 0, '', 6, 13, 4),
(70, 3, '2025-01-27', 'Se solicitara equipos de computo para exposiciones de proyecto', 6, 0, '', 6, 13, 4),
(71, 3, '2025-01-27', 'Se solicitara equipos de computo para exposiciones de proyecto', 6, 0, '', 6, 13, 4),
(72, 3, '2025-01-27', 'Se solicitara equipos de computo para exposiciones de proyecto', 6, 0, '', 6, 13, 4),
(73, 1, '2025-01-27', 'ppp', 17, 0, '', 6, 9, 4),
(74, 3, '2025-01-27', 'Solicitud de computadores ', 17, 0, '', 6, 8, 4),
(75, 3, '2025-01-27', 'Solicitud de computadores ', 17, 0, '', 6, 8, 4),
(76, 2, '2025-01-27', 'Solicitud de computadores ', 11, 0, '', 6, 7, 4),
(77, 2, '2025-01-27', 'Solicitud de computadores ', 11, 0, '', 6, 7, 4),
(78, 3, '2025-01-27', 'ppp', 18, 0, '', 6, 9, 4),
(79, 3, '2025-01-27', 'ppp', 18, 0, '', 6, 9, 4),
(80, 3, '2025-01-27', 'Se solicitara equipos de computo para exposiciones de proyecto', 7, 0, '', 6, 10, 4),
(81, 5, '2025-01-27', '02', 10, 0, '', 6, 1, 4),
(82, 1, '2025-01-27', 'Nose', 19, 0, '', 6, 14, 4),
(83, 2, '2025-01-27', 'ppp', 20, 0, '', 6, 17, 4),
(84, 3, '2025-01-29', 'Solicitud de computadores ', 7, 0, '', 6, 12, 4),
(85, 1, '2025-01-30', 'Solicitud de computadores ', 5, 0, '', 6, 12, 4),
(86, 4, '2025-01-30', 'Nose', 5, 0, '', 6, 8, 4),
(87, 1, '2025-01-30', 'Se solicitara equipos de computo para exposiciones de proyecto', 14, 0, '', 6, 7, 4),
(88, 3, '2025-01-30', 'Nose', 21, 0, '', 6, 2, 4),
(89, 3, '2025-01-30', 'Nose', 21, 0, '', 6, 2, 4),
(90, 2, '2025-01-30', 'Solicitud de computadores ', 7, 0, '', 6, 5, 4),
(91, 2, '2025-01-30', 'Solicitud de computadores ', 7, 0, '', 6, 5, 4),
(92, 3, '2025-01-30', 'Se solicitara equipos de computo para exposiciones de proyecto', 7, 0, '', 6, 11, 4),
(93, 1, '2025-01-31', 'Se solicitara equipos de computo para exposiciones de proyecto', 7, 0, '', 6, 16, 4),
(94, 3, '2025-02-03', 'Nose', 4, 0, '', 6, 13, 4),
(95, 2, '2025-02-03', 'ppp', 7, 0, '', 6, 6, 4),
(96, 1, '2025-02-07', 'Se solicitara equipos de computo para exposiciones de proyecto', 22, 0, '', 6, 7, 4),
(97, 1, '2025-02-07', 'Se solicitara equipos de computo para exposiciones de proyecto', 22, 0, '', 6, 7, 4),
(98, 3, '2025-02-13', 'Solicitud de computadores ', 3, 0, '', 6, 8, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_periodica`
--

CREATE TABLE `solicitud_periodica` (
  `id` int(11) NOT NULL,
  `cod_peri` varchar(255) NOT NULL,
  `fecha_soli` date NOT NULL,
  `area` int(11) NOT NULL,
  `cargo` varchar(255) NOT NULL,
  `cod_regi` int(11) NOT NULL,
  `nom_regi` varchar(255) NOT NULL,
  `cod_costo` int(11) NOT NULL,
  `nom_costo` varchar(255) NOT NULL,
  `nom_jefe` varchar(255) NOT NULL,
  `tipo_cuentadante` int(11) NOT NULL,
  `dest_bien` varchar(255) NOT NULL,
  `num_fich` int(11) NOT NULL,
  `firma` longblob DEFAULT NULL,
  `nombre_solici` varchar(255) NOT NULL,
  `documento_s` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud_periodica`
--

INSERT INTO `solicitud_periodica` (`id`, `cod_peri`, `fecha_soli`, `area`, `cargo`, `cod_regi`, `nom_regi`, `cod_costo`, `nom_costo`, `nom_jefe`, `tipo_cuentadante`, `dest_bien`, `num_fich`, `firma`, `nombre_solici`, `documento_s`) VALUES
(1, '', '2024-11-28', 9, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Maycol ', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(2, '', '2024-12-03', 3, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Nanci ', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(3, '', '2024-12-03', 9, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Alejandro', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(4, '', '2024-12-03', 9, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Alejandro', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(5, '', '2024-12-03', 9, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Nanci ', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(6, '', '2024-12-03', 9, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Nanci ', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(7, '', '2024-12-03', 9, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Alejandro', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(8, '', '2024-12-03', 16, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Alejandro', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(9, '', '2024-12-03', 9, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Alejandro paniagua', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(10, '', '2024-12-09', 9, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Alejandro', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(11, '', '2025-01-23', 16, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Alejandro', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(12, '', '2025-01-23', 16, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Alejandro', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(13, '', '2025-01-27', 3, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Maycol ', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(14, '', '2025-01-29', 26, 'Instructor ', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Carolina Bracamonte ', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(15, '', '2025-01-29', 16, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Nanci ', 1, '1', 2532155, NULL, 'CAROLINA', 1000235150),
(16, '', '2025-01-29', 9, 'jefe de area serigrafia', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Maycol ', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(17, '', '2025-01-29', 9, 'jefe de area serigrafia', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Maycol ', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(18, '', '2025-01-29', 16, 'Instructor ', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Alejandro', 1, '2', 0, NULL, 'CAROLINA', 1000235150),
(19, '', '2025-02-03', 9, 'Profesor ', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Alejandro', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(20, '', '2025-02-03', 3, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Carolina Bracamonte ', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(21, '', '2025-02-03', 9, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Alejandro', 1, '2', 0, NULL, 'CAROLINA', 1000235150),
(22, '', '2025-02-03', 9, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Alejandro', 1, '2', 0, NULL, 'CAROLINA', 1000235150),
(23, '', '2025-02-10', 3, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Alejandro paniagua', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(24, '', '2025-02-10', 3, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Alejandro paniagua', 1, '1', 0, NULL, 'CAROLINA', 1000235150),
(25, '', '2025-02-11', 16, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Carolina Bracamonte ', 1, '1', 2532155, NULL, 'CAROLINA', 1000235150),
(26, '', '2025-02-11', 16, 'Instructor', 11, 'DISTRITO CAPITAL', 9217, 'CENIGRAF', 'Alejandro', 1, '1', 0, NULL, 'CAROLINA', 1000235150);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cuentadante`
--

CREATE TABLE `tipo_cuentadante` (
  `id_cuentadante` int(11) NOT NULL,
  `nombre_cuent` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_cuentadante`
--

INSERT INTO `tipo_cuentadante` (`id_cuentadante`, `nombre_cuent`) VALUES
(1, 'UNIPERSONAL'),
(2, 'MULTIPLE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_mantenimiento`
--

CREATE TABLE `tipo_mantenimiento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_mantenimiento`
--

INSERT INTO `tipo_mantenimiento` (`id`, `nombre`) VALUES
(1, 'MANTENIMIENTO DE INFRAESTRCTURA'),
(2, 'ADECUACIÓN DE INFRAESTRCTURA'),
(3, 'EVENTO'),
(4, 'SERVICIO'),
(5, 'OTRO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaccional_reporte`
--

CREATE TABLE `transaccional_reporte` (
  `id_transaccional` int(11) NOT NULL,
  `total_solicitud` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ambiente`
--
ALTER TABLE `ambiente`
  ADD PRIMARY KEY (`id_ambiente`),
  ADD KEY `id_area` (`id_area`);

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuentadante`
--
ALTER TABLE `cuentadante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo` (`tipo`);

--
-- Indices de la tabla `cuentadante_solicitud`
--
ALTER TABLE `cuentadante_solicitud`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_solicitud` (`id_solicitud`),
  ADD KEY `id_cuentadante` (`id_cuentadante`);

--
-- Indices de la tabla `elemento`
--
ALTER TABLE `elemento`
  ADD PRIMARY KEY (`id_elemento`),
  ADD KEY `ambiente` (`ambiente`);

--
-- Indices de la tabla `elementos_solicitud_periodica`
--
ALTER TABLE `elementos_solicitud_periodica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_solicitud` (`id_solicitud`),
  ADD KEY `id_elemento` (`id_elemento`);

--
-- Indices de la tabla `elemento_solicitud_anual`
--
ALTER TABLE `elemento_solicitud_anual`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_solicitud` (`id_solicitud`),
  ADD KEY `id_elemento` (`id_elemento`);

--
-- Indices de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ficha`
--
ALTER TABLE `ficha`
  ADD PRIMARY KEY (`numero_ficha`),
  ADD KEY `id_programa` (`id_programa`);

--
-- Indices de la tabla `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol` (`rol`),
  ADD KEY `especialidad` (`especialidad`);

--
-- Indices de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `maquina`
--
ALTER TABLE `maquina`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ambiente` (`id_ambiente`);

--
-- Indices de la tabla `programa`
--
ALTER TABLE `programa`
  ADD PRIMARY KEY (`id_programa`),
  ADD KEY `id_instructor` (`id_instructor`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `solicitud_anual`
--
ALTER TABLE `solicitud_anual`
  ADD PRIMARY KEY (`id_anual`),
  ADD KEY `ficha_soli` (`ficha_soli`),
  ADD KEY `programa_soli` (`programa_soli`);

--
-- Indices de la tabla `solicitud_mantenimiento`
--
ALTER TABLE `solicitud_mantenimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solicitud` (`solicitud`),
  ADD KEY `maquina` (`maquina`),
  ADD KEY `id_instructor` (`id_instructor`),
  ADD KEY `id_ambiente` (`id_ambiente`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `solicitud_periodica`
--
ALTER TABLE `solicitud_periodica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `area` (`area`),
  ADD KEY `tipo_cuentadante` (`tipo_cuentadante`);

--
-- Indices de la tabla `tipo_cuentadante`
--
ALTER TABLE `tipo_cuentadante`
  ADD PRIMARY KEY (`id_cuentadante`);

--
-- Indices de la tabla `tipo_mantenimiento`
--
ALTER TABLE `tipo_mantenimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `transaccional_reporte`
--
ALTER TABLE `transaccional_reporte`
  ADD PRIMARY KEY (`id_transaccional`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ambiente`
--
ALTER TABLE `ambiente`
  MODIFY `id_ambiente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cuentadante`
--
ALTER TABLE `cuentadante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `cuentadante_solicitud`
--
ALTER TABLE `cuentadante_solicitud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `elemento`
--
ALTER TABLE `elemento`
  MODIFY `id_elemento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `elementos_solicitud_periodica`
--
ALTER TABLE `elementos_solicitud_periodica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `elemento_solicitud_anual`
--
ALTER TABLE `elemento_solicitud_anual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `instructor`
--
ALTER TABLE `instructor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `maquina`
--
ALTER TABLE `maquina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `programa`
--
ALTER TABLE `programa`
  MODIFY `id_programa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `solicitud_anual`
--
ALTER TABLE `solicitud_anual`
  MODIFY `id_anual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `solicitud_mantenimiento`
--
ALTER TABLE `solicitud_mantenimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT de la tabla `solicitud_periodica`
--
ALTER TABLE `solicitud_periodica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `tipo_cuentadante`
--
ALTER TABLE `tipo_cuentadante`
  MODIFY `id_cuentadante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_mantenimiento`
--
ALTER TABLE `tipo_mantenimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `transaccional_reporte`
--
ALTER TABLE `transaccional_reporte`
  MODIFY `id_transaccional` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ambiente`
--
ALTER TABLE `ambiente`
  ADD CONSTRAINT `ambiente_ibfk_1` FOREIGN KEY (`id_area`) REFERENCES `area` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cuentadante`
--
ALTER TABLE `cuentadante`
  ADD CONSTRAINT `cuentadante_ibfk_1` FOREIGN KEY (`tipo`) REFERENCES `tipo_cuentadante` (`id_cuentadante`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cuentadante_solicitud`
--
ALTER TABLE `cuentadante_solicitud`
  ADD CONSTRAINT `cuentadante_solicitud_ibfk_1` FOREIGN KEY (`id_solicitud`) REFERENCES `solicitud_periodica` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cuentadante_solicitud_ibfk_2` FOREIGN KEY (`id_cuentadante`) REFERENCES `cuentadante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `elemento`
--
ALTER TABLE `elemento`
  ADD CONSTRAINT `elemento_ibfk_1` FOREIGN KEY (`ambiente`) REFERENCES `ambiente` (`id_ambiente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `elementos_solicitud_periodica`
--
ALTER TABLE `elementos_solicitud_periodica`
  ADD CONSTRAINT `elementos_solicitud_periodica_ibfk_1` FOREIGN KEY (`id_solicitud`) REFERENCES `solicitud_periodica` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `elementos_solicitud_periodica_ibfk_2` FOREIGN KEY (`id_elemento`) REFERENCES `elemento` (`id_elemento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `elemento_solicitud_anual`
--
ALTER TABLE `elemento_solicitud_anual`
  ADD CONSTRAINT `elemento_solicitud_anual_ibfk_1` FOREIGN KEY (`id_solicitud`) REFERENCES `solicitud_anual` (`id_anual`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `elemento_solicitud_anual_ibfk_2` FOREIGN KEY (`id_elemento`) REFERENCES `elemento` (`id_elemento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ficha`
--
ALTER TABLE `ficha`
  ADD CONSTRAINT `ficha_ibfk_1` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `instructor`
--
ALTER TABLE `instructor`
  ADD CONSTRAINT `instructor_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `instructor_ibfk_2` FOREIGN KEY (`especialidad`) REFERENCES `especialidad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `maquina`
--
ALTER TABLE `maquina`
  ADD CONSTRAINT `maquina_ibfk_1` FOREIGN KEY (`id_ambiente`) REFERENCES `ambiente` (`id_ambiente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `programa`
--
ALTER TABLE `programa`
  ADD CONSTRAINT `programa_ibfk_1` FOREIGN KEY (`id_instructor`) REFERENCES `instructor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitud_anual`
--
ALTER TABLE `solicitud_anual`
  ADD CONSTRAINT `solicitud_anual_ibfk_1` FOREIGN KEY (`ficha_soli`) REFERENCES `ficha` (`numero_ficha`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `solicitud_anual_ibfk_2` FOREIGN KEY (`programa_soli`) REFERENCES `programa` (`id_programa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitud_mantenimiento`
--
ALTER TABLE `solicitud_mantenimiento`
  ADD CONSTRAINT `solicitud_mantenimiento_ibfk_1` FOREIGN KEY (`solicitud`) REFERENCES `tipo_mantenimiento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `solicitud_mantenimiento_ibfk_2` FOREIGN KEY (`maquina`) REFERENCES `maquina` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `solicitud_mantenimiento_ibfk_3` FOREIGN KEY (`id_instructor`) REFERENCES `instructor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `solicitud_mantenimiento_ibfk_4` FOREIGN KEY (`id_ambiente`) REFERENCES `ambiente` (`id_ambiente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `solicitud_mantenimiento_ibfk_5` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitud_periodica`
--
ALTER TABLE `solicitud_periodica`
  ADD CONSTRAINT `solicitud_periodica_ibfk_1` FOREIGN KEY (`area`) REFERENCES `ambiente` (`id_ambiente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `solicitud_periodica_ibfk_2` FOREIGN KEY (`tipo_cuentadante`) REFERENCES `tipo_cuentadante` (`id_cuentadante`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
