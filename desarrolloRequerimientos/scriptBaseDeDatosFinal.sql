-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-01-2016 a las 22:23:33
-- Versión del servidor: 5.6.25
-- Versión de PHP: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `desarrollo_requerimiento`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE IF NOT EXISTS `actividad` (
  `idActividad` int(11) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `actividadDefault` tinyint(1) NOT NULL,
  `defaultModificacion` tinyint(1) NOT NULL,
  `ordenEjecucion` decimal(10,0) NOT NULL,
  `duracionHrs` decimal(10,0) NOT NULL,
  `idProyecto` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo_artefacto`
--

CREATE TABLE IF NOT EXISTS `archivo_artefacto` (
  `idArchivo` int(11) NOT NULL,
  `idArtefacto` int(11) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `ruta` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `url` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo_peticion_interesados`
--

CREATE TABLE IF NOT EXISTS `archivo_peticion_interesados` (
  `idArchivo` int(11) NOT NULL,
  `idPeticion` int(11) NOT NULL,
  `nombre` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `ruta` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `url` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artefacto`
--

CREATE TABLE IF NOT EXISTS `artefacto` (
  `idArtefacto` int(11) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcionDetallada` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `idEstatus` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atributo`
--

CREATE TABLE IF NOT EXISTS `atributo` (
  `idAtributo` int(11) NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `valor` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `atributo`
--

INSERT INTO `atributo` (`idAtributo`, `descripcion`, `valor`) VALUES
(1, 'Necesidad', 'Alto'),
(2, 'Necesidad', 'Medio'),
(3, 'Necesidad', 'Bajo'),
(4, 'Riesgo', 'Alto'),
(5, 'Riego', 'Medio'),
(6, 'Riesgo', 'Bajo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cambio_glosario`
--

CREATE TABLE IF NOT EXISTS `cambio_glosario` (
  `idCambio` int(11) NOT NULL,
  `idDefinicion` int(11) NOT NULL,
  `idOperacion` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idRol` int(11) NOT NULL,
  `fechaOperacion` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cambio_requerimiento`
--

CREATE TABLE IF NOT EXISTS `cambio_requerimiento` (
  `idCambio` int(11) NOT NULL,
  `idRequerimiento` int(11) NOT NULL,
  `idRequerimientoUsuario` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `fechaOperacion` datetime NOT NULL,
  `idOperacion` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idRol` int(11) NOT NULL,
  `idActividad` int(11) DEFAULT NULL,
  `idLineaBase` int(11) DEFAULT NULL,
  `idProyecto` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caso_prueba`
--

CREATE TABLE IF NOT EXISTS `caso_prueba` (
  `idCasoPrueba` int(11) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `precondicion` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `poscondicion` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `responsable` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcionDetallada` varchar(3000) COLLATE utf8_spanish_ci NOT NULL,
  `idEstatus` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `definicion`
--

CREATE TABLE IF NOT EXISTS `definicion` (
  `idDefinicion` int(11) NOT NULL,
  `idGlosario` int(11) NOT NULL,
  `palabra` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `definicion` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `definicion_linea_base`
--

CREATE TABLE IF NOT EXISTS `definicion_linea_base` (
  `idDefinicion` int(11) NOT NULL,
  `idLineaBase` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus`
--

CREATE TABLE IF NOT EXISTS `estatus` (
  `idEstatus` int(11) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `todos` tinyint(1) NOT NULL,
  `requisitos` tinyint(1) NOT NULL,
  `actividades` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estatus`
--

INSERT INTO `estatus` (`idEstatus`, `descripcion`, `todos`, `requisitos`, `actividades`) VALUES
(1, 'Activo', 1, 1, 1),
(2, 'Cancelado', 1, 1, 1),
(3, 'En espera', 0, 1, 0),
(4, 'Asignado', 0, 1, 1),
(5, 'Revisado', 0, 1, 0),
(6, 'Aprobado', 0, 1, 0),
(7, 'En ejecución', 0, 0, 1),
(8, 'Terminado', 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `glosario`
--

CREATE TABLE IF NOT EXISTS `glosario` (
  `idGlosario` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `objetivo` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `idProyecto` int(11) NOT NULL,
  `idEstatus` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linea_base`
--

CREATE TABLE IF NOT EXISTS `linea_base` (
  `idLineaBase` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `usuarioCreacion` int(11) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `idEstatus` int(11) NOT NULL,
  `estaAprobada` tinyint(1) NOT NULL,
  `usuarioAprobacion` int(11) DEFAULT NULL,
  `fechaAprobacion` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE IF NOT EXISTS `modulo` (
  `idModulo` int(11) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `nombreIcono` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`idModulo`, `descripcion`, `nombreIcono`) VALUES
(3, 'Catálogos', 'fa fa-copy'),
(4, 'Requerimientos', 'fa fa-list-alt'),
(5, 'Pruebas', 'fa fa-edit'),
(6, 'Líneas base', 'fa fa-tasks'),
(7, 'SRS', 'fa fa-table'),
(8, 'Métricas', 'fa fa-bar-chart');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcion`
--

CREATE TABLE IF NOT EXISTS `opcion` (
  `idOpcion` int(11) NOT NULL,
  `idModulo` int(11) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `nombreControlador` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `opcion`
--

INSERT INTO `opcion` (`idOpcion`, `idModulo`, `descripcion`, `nombreControlador`) VALUES
(1, 3, 'Usuarios', 'usuarios'),
(2, 3, 'Roles', 'roles'),
(3, 3, 'Módulos', 'modulos'),
(4, 3, 'Opciones', 'opciones'),
(6, 3, 'Rol opciones', 'rolOpciones'),
(7, 3, 'Estatus', 'estatus'),
(8, 3, 'Actividades', 'actividades'),
(9, 3, 'Tipos requerimiento', 'tiposRequerimiento'),
(10, 3, 'Prioridades', 'prioridades'),
(12, 3, 'Operaciones', 'operaciones'),
(13, 3, 'Proyectos', 'proyectos'),
(14, 3, 'Atributos', 'atributos'),
(15, 3, 'Glosarios', 'glosarios'),
(16, 4, 'Peticiones interesados', 'peticiones'),
(17, 4, 'Artefactos', 'artefactos'),
(18, 5, 'Casos de prueba', 'casosPruebas'),
(19, 4, 'Definiciones de glosario', 'definiciones'),
(20, 4, 'Requerimientos', 'requerimientos'),
(21, 5, 'Asignación de caso de prueba', 'casoPruebaRequerimiento'),
(22, 8, 'Métricas generales', 'metricasGenerales'),
(23, 6, 'Líneas base', 'lineasBase'),
(24, 7, 'SRS', 'srs'),
(25, 8, 'Métricas proyecto', 'metricasProyecto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operacion`
--

CREATE TABLE IF NOT EXISTS `operacion` (
  `idOperacion` int(11) NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `operacion`
--

INSERT INTO `operacion` (`idOperacion`, `descripcion`) VALUES
(1, 'Alta'),
(2, 'Eliminación'),
(3, 'Cambio de estatus'),
(4, 'Modificación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peticion_interesados`
--

CREATE TABLE IF NOT EXISTS `peticion_interesados` (
  `idPeticion` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcionDetallada` varchar(3000) COLLATE utf8_spanish_ci NOT NULL,
  `idEstatus` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prioridad`
--

CREATE TABLE IF NOT EXISTS `prioridad` (
  `idPrioridad` int(11) NOT NULL,
  `descripcion` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `prioridad`
--

INSERT INTO `prioridad` (`idPrioridad`, `descripcion`, `orden`) VALUES
(2, 'Alta', 2),
(3, 'Media', 3),
(4, 'Baja', 4),
(5, 'Urgente', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

CREATE TABLE IF NOT EXISTS `proyecto` (
  `idProyecto` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaTermino` date NOT NULL,
  `usuarioCreacion` int(11) NOT NULL,
  `idEstatus` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proyecto`
--

INSERT INTO `proyecto` (`idProyecto`, `nombre`, `descripcion`, `fechaInicio`, `fechaTermino`, `usuarioCreacion`, `idEstatus`) VALUES
(1, 'Proyecto 1', 'El presente es un proyecto de prueba.', '2015-11-25', '2015-11-28', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requerimiento`
--

CREATE TABLE IF NOT EXISTS `requerimiento` (
  `idRequerimiento` int(11) NOT NULL,
  `idRequerimientoUsuario` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `precondicion` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `postcondicion` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `descripcionCorta` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `descripcionDetallada` varchar(10000) COLLATE utf8_spanish_ci NOT NULL,
  `idProyecto` int(11) NOT NULL,
  `idTipo` int(11) NOT NULL,
  `idPrioridad` int(11) NOT NULL,
  `idEstatus` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requerimiento_actividad`
--

CREATE TABLE IF NOT EXISTS `requerimiento_actividad` (
  `idActividad` int(11) NOT NULL,
  `idRequerimiento` int(11) NOT NULL,
  `idRequerimientoUsuario` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `hrsReales` decimal(10,0) NOT NULL,
  `responsable` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idEstatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requerimiento_artefacto`
--

CREATE TABLE IF NOT EXISTS `requerimiento_artefacto` (
  `idArtefacto` int(11) NOT NULL,
  `idRequerimiento` int(11) NOT NULL,
  `idRequerimientoUsuario` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requerimiento_atributo`
--

CREATE TABLE IF NOT EXISTS `requerimiento_atributo` (
  `idAtributo` int(11) NOT NULL,
  `idRequerimiento` int(11) NOT NULL,
  `idRequerimientoUsuario` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requerimiento_caso_prueba`
--

CREATE TABLE IF NOT EXISTS `requerimiento_caso_prueba` (
  `idCasoPrueba` int(11) NOT NULL,
  `idRequerimiento` int(11) NOT NULL,
  `idRequerimientoUsuario` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requerimiento_linea_base`
--

CREATE TABLE IF NOT EXISTS `requerimiento_linea_base` (
  `idRequerimiento` int(11) NOT NULL,
  `idRequerimientoUsuario` int(11) NOT NULL,
  `idLineaBase` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requerimiento_peticion_interesados`
--

CREATE TABLE IF NOT EXISTS `requerimiento_peticion_interesados` (
  `idPeticion` int(11) NOT NULL,
  `idRequerimiento` int(11) NOT NULL,
  `idRequerimientoUsuario` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `idRol` int(11) NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `descripcion`) VALUES
(1, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_opcion`
--

CREATE TABLE IF NOT EXISTS `rol_opcion` (
  `idRol` int(11) NOT NULL,
  `idOpcion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `rol_opcion`
--

INSERT INTO `rol_opcion` (`idRol`, `idOpcion`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `srs`
--

CREATE TABLE IF NOT EXISTS `srs` (
  `idSRS` int(11) NOT NULL,
  `idLineaBase` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL,
  `proposito` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `alcance` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `objetivo` varchar(700) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_requerimiento`
--

CREATE TABLE IF NOT EXISTS `tipo_requerimiento` (
  `idTipo` int(11) NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `furps` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_requerimiento`
--

INSERT INTO `tipo_requerimiento` (`idTipo`, `descripcion`, `furps`) VALUES
(1, 'Confiabilidad', 1),
(2, 'Usabilidad', 1),
(3, 'Funcionalidad', 1),
(4, 'Suportabilidad', 1),
(5, 'Rendimiento', 1),
(6, 'Legales', 0),
(7, 'Usuario interfaces', 0),
(9, 'Seguridad', 0),
(10, 'Configuración del sistema', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL,
  `usuario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `esAdministrador` tinyint(1) NOT NULL,
  `correo` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `usuario`, `password`, `nombre`, `esAdministrador`, `correo`) VALUES
(1, 'admin', 'admin123', 'Administrador', 1, 'admin@admin.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE IF NOT EXISTS `usuario_rol` (
  `idUsuario` int(11) NOT NULL,
  `idRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` (`idUsuario`, `idRol`) VALUES
(1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`idActividad`);

--
-- Indices de la tabla `archivo_artefacto`
--
ALTER TABLE `archivo_artefacto`
  ADD PRIMARY KEY (`idArchivo`);

--
-- Indices de la tabla `archivo_peticion_interesados`
--
ALTER TABLE `archivo_peticion_interesados`
  ADD PRIMARY KEY (`idArchivo`);

--
-- Indices de la tabla `artefacto`
--
ALTER TABLE `artefacto`
  ADD PRIMARY KEY (`idArtefacto`);

--
-- Indices de la tabla `atributo`
--
ALTER TABLE `atributo`
  ADD PRIMARY KEY (`idAtributo`);

--
-- Indices de la tabla `cambio_glosario`
--
ALTER TABLE `cambio_glosario`
  ADD PRIMARY KEY (`idCambio`);

--
-- Indices de la tabla `cambio_requerimiento`
--
ALTER TABLE `cambio_requerimiento`
  ADD PRIMARY KEY (`idCambio`);

--
-- Indices de la tabla `caso_prueba`
--
ALTER TABLE `caso_prueba`
  ADD PRIMARY KEY (`idCasoPrueba`);

--
-- Indices de la tabla `definicion`
--
ALTER TABLE `definicion`
  ADD PRIMARY KEY (`idDefinicion`);

--
-- Indices de la tabla `definicion_linea_base`
--
ALTER TABLE `definicion_linea_base`
  ADD PRIMARY KEY (`idDefinicion`,`idLineaBase`,`idProyecto`);

--
-- Indices de la tabla `estatus`
--
ALTER TABLE `estatus`
  ADD PRIMARY KEY (`idEstatus`);

--
-- Indices de la tabla `glosario`
--
ALTER TABLE `glosario`
  ADD PRIMARY KEY (`idGlosario`);

--
-- Indices de la tabla `linea_base`
--
ALTER TABLE `linea_base`
  ADD PRIMARY KEY (`idLineaBase`,`idProyecto`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`idModulo`);

--
-- Indices de la tabla `opcion`
--
ALTER TABLE `opcion`
  ADD PRIMARY KEY (`idOpcion`);

--
-- Indices de la tabla `operacion`
--
ALTER TABLE `operacion`
  ADD PRIMARY KEY (`idOperacion`);

--
-- Indices de la tabla `peticion_interesados`
--
ALTER TABLE `peticion_interesados`
  ADD PRIMARY KEY (`idPeticion`);

--
-- Indices de la tabla `prioridad`
--
ALTER TABLE `prioridad`
  ADD PRIMARY KEY (`idPrioridad`);

--
-- Indices de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`idProyecto`);

--
-- Indices de la tabla `requerimiento`
--
ALTER TABLE `requerimiento`
  ADD PRIMARY KEY (`idRequerimiento`,`idRequerimientoUsuario`);

--
-- Indices de la tabla `requerimiento_actividad`
--
ALTER TABLE `requerimiento_actividad`
  ADD PRIMARY KEY (`idActividad`,`idRequerimiento`,`idRequerimientoUsuario`);

--
-- Indices de la tabla `requerimiento_artefacto`
--
ALTER TABLE `requerimiento_artefacto`
  ADD PRIMARY KEY (`idArtefacto`,`idRequerimiento`,`idRequerimientoUsuario`);

--
-- Indices de la tabla `requerimiento_linea_base`
--
ALTER TABLE `requerimiento_linea_base`
  ADD PRIMARY KEY (`idRequerimiento`,`idRequerimientoUsuario`,`idLineaBase`,`idProyecto`);

--
-- Indices de la tabla `requerimiento_peticion_interesados`
--
ALTER TABLE `requerimiento_peticion_interesados`
  ADD PRIMARY KEY (`idPeticion`,`idRequerimiento`,`idRequerimientoUsuario`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `rol_opcion`
--
ALTER TABLE `rol_opcion`
  ADD PRIMARY KEY (`idRol`,`idOpcion`);

--
-- Indices de la tabla `srs`
--
ALTER TABLE `srs`
  ADD PRIMARY KEY (`idSRS`);

--
-- Indices de la tabla `tipo_requerimiento`
--
ALTER TABLE `tipo_requerimiento`
  ADD PRIMARY KEY (`idTipo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD PRIMARY KEY (`idUsuario`,`idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `idActividad` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `archivo_artefacto`
--
ALTER TABLE `archivo_artefacto`
  MODIFY `idArchivo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `archivo_peticion_interesados`
--
ALTER TABLE `archivo_peticion_interesados`
  MODIFY `idArchivo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `artefacto`
--
ALTER TABLE `artefacto`
  MODIFY `idArtefacto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `atributo`
--
ALTER TABLE `atributo`
  MODIFY `idAtributo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `cambio_glosario`
--
ALTER TABLE `cambio_glosario`
  MODIFY `idCambio` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `cambio_requerimiento`
--
ALTER TABLE `cambio_requerimiento`
  MODIFY `idCambio` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT de la tabla `caso_prueba`
--
ALTER TABLE `caso_prueba`
  MODIFY `idCasoPrueba` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `definicion`
--
ALTER TABLE `definicion`
  MODIFY `idDefinicion` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de la tabla `estatus`
--
ALTER TABLE `estatus`
  MODIFY `idEstatus` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `glosario`
--
ALTER TABLE `glosario`
  MODIFY `idGlosario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `linea_base`
--
ALTER TABLE `linea_base`
  MODIFY `idLineaBase` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `idModulo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `opcion`
--
ALTER TABLE `opcion`
  MODIFY `idOpcion` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT de la tabla `operacion`
--
ALTER TABLE `operacion`
  MODIFY `idOperacion` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `peticion_interesados`
--
ALTER TABLE `peticion_interesados`
  MODIFY `idPeticion` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `prioridad`
--
ALTER TABLE `prioridad`
  MODIFY `idPrioridad` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `idProyecto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `requerimiento`
--
ALTER TABLE `requerimiento`
  MODIFY `idRequerimiento` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `srs`
--
ALTER TABLE `srs`
  MODIFY `idSRS` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tipo_requerimiento`
--
ALTER TABLE `tipo_requerimiento`
  MODIFY `idTipo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
