use proyecto;
DROP DATABASE proyecto;
create DATABASE proyecto;
USE proyecto;


CREATE TABLE `area` (
  `id` int(11) primary key NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `ambiente` (
  `id_ambiente` int(11) primary key NOT NULL AUTO_INCREMENT,
  `nombre_ambiente` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `id_area` int(11) NOT NULL,
  FOREIGN KEY (`id_area`) REFERENCES `area` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tipo_cuentadante` (
  `id_cuentadante` int(11) primary key NOT NULL AUTO_INCREMENT,
  `nombre_cuent` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `cuentadante` (
  `id` int(11) primary key NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `documento` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  FOREIGN KEY (`tipo`) REFERENCES `tipo_cuentadante` (`id_cuentadante`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `elemento` (
  `id_elemento` int(11) primary key NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `und_medida` varchar(255) NOT NULL,
  `ambiente` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `cantidad_solicitada` int(11),
  `cantidad_entregada` int(11) DEFAULT 0,
  `nombre` varchar(255) NOT NULL,
  `estado` varchar(11) NOT NULL,
  `observaciones` varchar(255) NOT NULL,
   FOREIGN KEY (`ambiente`) REFERENCES `ambiente` (`id_ambiente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `especialidad` (
  `id` int(11) primary key NOT NULL AUTO_INCREMENT,
  `nombre_especialidad` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rol` (
  `id_rol` int(11) primary key NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `instructor` (
  `id` int(11) primary key NOT NULL AUTO_INCREMENT,
  `cedula` int(11) NOT NULL,
  `nombre_instructor` varchar(255) NOT NULL,
  `celular` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` int(11) NOT NULL,
  `especialidad` int(11) NOT NULL,
  FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`especialidad`) REFERENCES `especialidad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `programa` (
  `id_programa` int(11) primary key NOT NULL AUTO_INCREMENT,
  `nombre_programa` varchar(255) NOT NULL,
  `id_instructor` int(11) NOT NULL,
  FOREIGN KEY (`id_instructor`) REFERENCES `instructor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `ficha` (
  `numero_ficha` int(11) primary key NOT NULL,
  `id_programa` int(11) NOT NULL,
  FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `maquina` (
  `id` int(11) primary key NOT NULL AUTO_INCREMENT,
  `serial` int(11) NOT NULL,
  `adquisicion` date NOT NULL,
  `nombre_maquina` varchar(255) NOT NULL,
   `marca` varchar(255) NOT NULL,
   `modelo` varchar(255) NOT NULL,
  `placa`  int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `id_ambiente` int(11) NOT NULL,
  FOREIGN KEY (`id_ambiente`) REFERENCES `ambiente` (`id_ambiente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `solicitud_anual` (
  `id_anual` int(11) primary key NOT NULL AUTO_INCREMENT,
  `fecha_soli` date NOT NULL,
  `nombre_solici` varchar(255) NOT NULL,
  `documento` int(11) NOT NULL,
  `ficha_soli` int(11) NOT NULL,
  `programa_soli` int(11) NOT NULL,
  `cantidad_soli` int(11) NOT NULL,
  FOREIGN KEY (`ficha_soli`) REFERENCES `ficha` (`numero_ficha`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`programa_soli`) REFERENCES `programa` (`id_programa`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `solicitud_periodica` (
  `id` int(11) primary key NOT NULL AUTO_INCREMENT,
  `cod_peri` varchar(255) NOT NULL,
  `fecha_soli` date NOT NULL,
  `area` int(11) NOT NULL,
  `cargo`varchar(255) NOT NULL,
  `cod_regi` int(11) NOT NULL,
  `nom_regi` varchar(255) NOT NULL,
  `cod_costo` int(11) NOT NULL,
  `nom_costo` varchar(255) NOT NULL,
  `nom_jefe` varchar(255) NOT NULL,
  `tipo_cuentadante` int(11) NOT NULL,
  `dest_bien` varchar(255) NOT NULL,
  `num_fich` int(11) NOT NULL,
  `firma` LONGBLOB,
  `nombre_solici`varchar(255) NOT NULL,
  `documento_s`  int(11) NOT NULL,
  FOREIGN KEY (`area`) REFERENCES `ambiente` (`id_ambiente`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`tipo_cuentadante`) REFERENCES `tipo_cuentadante` (`id_cuentadante`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `mantenimiento` (
  `id` int(11) primary key NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tipo_mantenimiento` (
  `id` int(11) primary key NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `solicitud_mantenimiento` (
  `id` int(11) primary key NOT NULL AUTO_INCREMENT,
  `solicitud` int(11) NOT NULL,
  `fecha_soli` date NOT NULL,
  `necesidad` varchar(255) NOT NULL,
  `maquina` int(11) NOT NULL,
  `tipo` int(11)  NOT NULL,
  `suministro` varchar(255) NOT NULL,
  `id_instructor` int(11) NOT NULL,
  `id_ambiente` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  FOREIGN KEY (`solicitud`) REFERENCES `tipo_mantenimiento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`maquina`) REFERENCES `maquina` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`id_instructor`) REFERENCES `instructor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`id_ambiente`) REFERENCES `ambiente` (`id_ambiente`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `transaccional_reporte` (
  `id_transaccional` int(11) primary key NOT NULL AUTO_INCREMENT,
  `total_solicitud` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `elementos_solicitud_periodica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_solicitud` int(11) NOT NULL,
  `id_elemento` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_solicitud`) REFERENCES `solicitud_periodica` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`id_elemento`) REFERENCES `elemento` (`id_elemento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `elemento_solicitud_anual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_soli` DATE NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `id_elemento` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_solicitud`) REFERENCES `solicitud_anual` (`id_anual`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`id_elemento`) REFERENCES `elemento` (`id_elemento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `cuentadante_solicitud` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_solicitud` int(11) NOT NULL,
  `id_cuentadante` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_solicitud`) REFERENCES `solicitud_periodica` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`id_cuentadante`) REFERENCES `cuentadante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*----------------------------INSERTAR DATOS----------------------------------------*/

INSERT INTO `area` (`id`, `nombre`) VALUES
(1, 'ADMINISTRATIVO'),
(2, 'FORMACION');

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

INSERT INTO `tipo_cuentadante` (`id_cuentadante`, `nombre_cuent`) VALUES
(1, 'UNIPERSONAL'),
(2, 'MULTIPLE');

INSERT INTO `cuentadante` (`id`, `nombre`, `documento`, `tipo`) VALUES
(1, 'JUAN', 123, 1),
(2, 'ana', 123, 2),
(3, 'melisa', 156, 2),
(4, 'miriam', 123, 2);

INSERT INTO `especialidad` (`id`, `nombre_especialidad`) VALUES
(1, 'INGENIERO');

INSERT INTO `rol` (`id_rol`, `nombre`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'COORDINADOR'),
(3, 'ALMACEN'),
(4, 'PERSONAL');

INSERT INTO `instructor` (`id`, `cedula`, `nombre_instructor`, `celular`, `correo`, `contrasena`, `rol`, `especialidad`) VALUES
(1, 654, 'yurani', '1256', 'yurani@gmail.com', '$2y$10$tJJpq0XfuwkXdAazW7K81OmfZoQRR9UZyv/6b0d1deAttsmvXj7Y.', 1, 1),
(2, 2345, 'ana lucia', '345666', 'ana@gmail.com', '$2y$10$AWDi8a8ce/HvlAAZOpuat.XmYg.SG367Gb2h.QxFVZFUGz0.sQNpy', 4, 1),
(3, 234, 'sofia', '12345', 'sofia@gmail.com', '$2y$10$ciHVD9YTEw5HBBXiMSJ70e2lSn2Nc1FzZsVQDFntLKZj/6bWpPFi6', 2, 1),
(4, 1, 'admin', '1', 'admin@admin.com', '$2y$10$9RcxZ8ofeUqo46dJhZt6leA7pz2M9elEJMjnd9to0MwbgOlP2QLEa', 3, 1);

INSERT INTO `programa` (`id_programa`, `nombre_programa`, `id_instructor`) VALUES
(1, 'ADSO', 4);

INSERT INTO `ficha` (`numero_ficha`, `id_programa`) VALUES
(2532155, 1);

INSERT INTO `elemento` (`id_elemento`, `codigo`, `descripcion`, `und_medida`, `ambiente`, `cantidad`, `cantidad_solicitada`, `cantidad_entregada`, `nombre`, `estado`, `observaciones`) VALUES 
('1', '01', 'Lapiz', 'Caja', '7', '100', '0', '0', 'Lapiz n8', '1', 'Lapiz del numero 8');

INSERT INTO `maquina` (`id`, `serial`, `adquisicion`, `nombre_maquina`, `marca`, `modelo`, `placa`, `cantidad`, `id_ambiente`) VALUES
(1, 12345, '2024-05-21', 'impresora', 'epson', 'tx135', '3244566', 9, 15),
(2, 23334, '2024-05-21', 'impresora', 'epson', 'tx1390', '3244566', 78, 14);

INSERT INTO `mantenimiento` (`id`, `nombre`) VALUES
(1, 'PREVENTIVO'),
(2, 'CORRECTIVO');

INSERT INTO `tipo_mantenimiento` (`id`, `nombre`) VALUES 
(1, 'MANTENIMIENTO DE INFRAESTRCTURA'), 
(2, 'ADECUACIÓN DE INFRAESTRCTURA'), 
(3, 'EVENTO'),
(4, 'SERVICIO'),
(5, 'OTRO');