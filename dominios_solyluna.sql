-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 04, 2013 at 02:33 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dominios_solyluna`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id_banner` int(11) NOT NULL AUTO_INCREMENT,
  `id_estado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `modificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `destacado` int(11) NOT NULL,
  `enlace` varchar(256) NOT NULL,
  `fichero` varchar(256) NOT NULL,
  PRIMARY KEY (`id_banner`),
  KEY `id_estado` (`id_estado`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

--
-- Dumping data for table `banner`
--


-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `id_estado` int(11) DEFAULT NULL,
  `id_categoria_padre` int(11) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `destacado` tinyint(4) NOT NULL DEFAULT '0',
  `creado` datetime NOT NULL,
  `modificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_tipo_cat` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_categoria`),
  KEY `R_43` (`id_estado`),
  KEY `id_categoria_padre` (`id_categoria_padre`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_tipo_cat` (`id_tipo_cat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `categoria`
--


-- --------------------------------------------------------

--
-- Table structure for table `contacto`
--

CREATE TABLE `contacto` (
  `id_contacto` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(128) NOT NULL,
  `nombre` varchar(256) NOT NULL,
  `telefono` varchar(256) NOT NULL,
  `producto` varchar(256) NOT NULL,
  `vehiculo` varchar(256) NOT NULL,
  `mensaje` text NOT NULL,
  `id_idioma` int(2) NOT NULL,
  `id_estado` int(2) NOT NULL,
  `creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_contacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `contacto`
--


-- --------------------------------------------------------

--
-- Table structure for table `costo`
--

CREATE TABLE `costo` (
  `id_costo` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_moneda` bigint(20) unsigned NOT NULL,
  `id_temporada` bigint(20) unsigned NOT NULL,
  `id_tipo_habitacion` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id_costo`),
  KEY `fk_costo_moneda1` (`id_moneda`),
  KEY `fk_costo_temporada1` (`id_temporada`),
  KEY `fk_costo_tipo_habitacion1` (`id_tipo_habitacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `costo`
--


-- --------------------------------------------------------

--
-- Table structure for table `detalle_banner`
--

CREATE TABLE `detalle_banner` (
  `id_detalle_banner` int(11) NOT NULL AUTO_INCREMENT,
  `id_banner` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `subtitulo` varchar(256) NOT NULL,
  `url` varchar(256) NOT NULL,
  `descripcion_breve` text NOT NULL,
  `descripcion_ampliada` text NOT NULL,
  `id_idioma` int(11) NOT NULL,
  `descripcion_pagina` text NOT NULL,
  `keywords` varchar(180) NOT NULL,
  `titulo_pagina` varchar(256) NOT NULL,
  PRIMARY KEY (`id_detalle_banner`),
  KEY `id_faq` (`id_banner`),
  KEY `id_idioma` (`id_idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

--
-- Dumping data for table `detalle_banner`
--


-- --------------------------------------------------------

--
-- Table structure for table `detalle_categoria`
--

CREATE TABLE `detalle_categoria` (
  `id_detalle_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `descripcion_breve` varchar(512) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL DEFAULT '0',
  `id_idioma` int(11) DEFAULT NULL,
  `descripcion_ampliada` text NOT NULL,
  `url` varchar(256) NOT NULL,
  `titulo_pagina` varchar(256) NOT NULL,
  `descripcion_pagina` text NOT NULL,
  `keywords` varchar(128) NOT NULL,
  PRIMARY KEY (`id_detalle_categoria`),
  KEY `R_45` (`id_categoria`),
  KEY `R_46` (`id_idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `detalle_categoria`
--


-- --------------------------------------------------------

--
-- Table structure for table `detalle_multimedia`
--

CREATE TABLE `detalle_multimedia` (
  `id_detalle_multimedia` int(11) NOT NULL AUTO_INCREMENT,
  `id_multimedia` int(11) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `id_idioma` int(11) NOT NULL,
  `descripcion_multimedia` text NOT NULL,
  PRIMARY KEY (`id_detalle_multimedia`),
  KEY `id_multimedia` (`id_multimedia`),
  KEY `id_idioma` (`id_idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `detalle_multimedia`
--


-- --------------------------------------------------------

--
-- Table structure for table `detalle_noticia`
--

CREATE TABLE `detalle_noticia` (
  `id_detalle_noticia` int(11) NOT NULL AUTO_INCREMENT,
  `id_noticia` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `subtitulo` varchar(256) NOT NULL,
  `url` varchar(256) NOT NULL,
  `descripcion_breve` text NOT NULL,
  `descripcion_ampliada` text NOT NULL,
  `id_idioma` int(11) NOT NULL,
  `descripcion_pagina` text NOT NULL,
  `keywords` varchar(180) NOT NULL,
  `titulo_pagina` varchar(256) NOT NULL,
  PRIMARY KEY (`id_detalle_noticia`),
  KEY `id_faq` (`id_noticia`),
  KEY `id_idioma` (`id_idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

--
-- Dumping data for table `detalle_noticia`
--


-- --------------------------------------------------------

--
-- Table structure for table `detalle_producto`
--

CREATE TABLE `detalle_producto` (
  `id_detalle_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `descripcion_breve` text,
  `id_producto` int(11) NOT NULL,
  `id_idioma` int(11) DEFAULT NULL,
  `titulo` text NOT NULL,
  `descripcion_ampliada` text NOT NULL,
  `titulo2` text NOT NULL,
  `descripcion_ampliada2` text COMMENT 'Descripcion 2',
  `titulo3` text NOT NULL,
  `descripcion_ampliada3` text COMMENT 'Descripcion 3',
  `titulo4` text NOT NULL,
  `descripcion_ampliada4` text COMMENT 'Descripcion 4',
  `valor_energetico` varchar(64) NOT NULL,
  `url` varchar(256) NOT NULL,
  `titulo_pagina` varchar(256) NOT NULL,
  `descripcion_pagina` text NOT NULL,
  `keywords` varchar(128) NOT NULL,
  `pdf` varchar(256) NOT NULL,
  `email_empresa_contacto` text NOT NULL,
  `url_gmap` text NOT NULL,
  `url_twitter` text NOT NULL,
  `url_facebook` text NOT NULL,
  `presentacion` text NOT NULL,
  PRIMARY KEY (`id_detalle_producto`),
  KEY `R_45` (`id_producto`),
  KEY `R_46` (`id_idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `detalle_producto`
--


-- --------------------------------------------------------

--
-- Table structure for table `detalle_promocion`
--

CREATE TABLE `detalle_promocion` (
  `id_detalle_promocion` int(11) NOT NULL AUTO_INCREMENT,
  `id_promocion` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `subtitulo` varchar(256) NOT NULL,
  `url` varchar(256) NOT NULL,
  `descripcion_breve` text NOT NULL,
  `descripcion_ampliada` text NOT NULL,
  `id_idioma` int(11) NOT NULL,
  `descripcion_pagina` text NOT NULL,
  `keywords` varchar(180) NOT NULL,
  `titulo_pagina` varchar(256) NOT NULL,
  PRIMARY KEY (`id_detalle_promocion`),
  KEY `id_faq` (`id_promocion`),
  KEY `id_idioma` (`id_idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

--
-- Dumping data for table `detalle_promocion`
--


-- --------------------------------------------------------

--
-- Table structure for table `detalle_receta`
--

CREATE TABLE `detalle_receta` (
  `id_detalle_receta` int(11) NOT NULL AUTO_INCREMENT,
  `id_idioma` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `descripcion` text NOT NULL,
  `elaboracion` text NOT NULL,
  `url` varchar(128) NOT NULL,
  `descripcion_pagina` text NOT NULL,
  `titulo_pagina` varchar(128) NOT NULL,
  `keywords` varchar(256) NOT NULL,
  PRIMARY KEY (`id_detalle_receta`),
  KEY `id_truco` (`id_receta`),
  KEY `id_idioma` (`id_idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `detalle_receta`
--


-- --------------------------------------------------------

--
-- Table structure for table `detalle_servicio_habitacion`
--

CREATE TABLE `detalle_servicio_habitacion` (
  `id_detalle_servicio_habitacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion_breve` varchar(150) NOT NULL,
  `descripcion_ampliada` text,
  `url` varchar(200) DEFAULT NULL,
  `titulo_pagina` varchar(50) DEFAULT NULL,
  `descripcion_pagina` text,
  `keywords` varchar(100) DEFAULT NULL,
  `id_idioma` int(11) NOT NULL,
  `id_servicio_habitacion` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_detalle_servicio_habitacion`),
  KEY `id_idioma` (`id_idioma`),
  KEY `id_servicio_habitacion` (`id_servicio_habitacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `detalle_servicio_habitacion`
--


-- --------------------------------------------------------

--
-- Table structure for table `detalle_servicio_posada`
--

CREATE TABLE `detalle_servicio_posada` (
  `id_detalle_servicio_posada` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion_breve` varchar(150) NOT NULL,
  `descripcion_ampliada` text,
  `url` varchar(200) NOT NULL,
  `titulo_pagina` varchar(50) DEFAULT NULL,
  `descripcion_pagina` text,
  `keywords` varchar(100) DEFAULT NULL,
  `id_idioma` int(11) NOT NULL,
  `id_servicio_posada` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_detalle_servicio_posada`),
  KEY `id_idioma` (`id_idioma`),
  KEY `id_servicio_posada` (`id_servicio_posada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `detalle_servicio_posada`
--


-- --------------------------------------------------------

--
-- Table structure for table `detalle_usuario`
--

CREATE TABLE `detalle_usuario` (
  `id_detalle_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `apellido_1` varchar(32) NOT NULL,
  `apellido_2` varchar(32) NOT NULL,
  `telefono` varchar(32) DEFAULT NULL,
  `direccion_via` varchar(32) NOT NULL,
  `direccion_via_nombre` varchar(128) NOT NULL,
  `direccion_numero` varchar(32) NOT NULL,
  `localidad` varchar(128) NOT NULL,
  `cp` int(5) NOT NULL,
  `provincia` varchar(128) NOT NULL,
  `mayor_edad` int(11) NOT NULL DEFAULT '0',
  `recibir_promos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_detalle_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `detalle_usuario`
--


-- --------------------------------------------------------

--
-- Table structure for table `estado`
--

CREATE TABLE `estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `estado`
--

INSERT INTO `estado` VALUES(1, 'publicado');
INSERT INTO `estado` VALUES(2, 'guardado');
INSERT INTO `estado` VALUES(3, 'borrado');

-- --------------------------------------------------------

--
-- Table structure for table `estado_activo`
--

CREATE TABLE `estado_activo` (
  `id_estado_activo` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`id_estado_activo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `estado_activo`
--

INSERT INTO `estado_activo` VALUES(1, 'Activo');
INSERT INTO `estado_activo` VALUES(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Table structure for table `estado_habitacion`
--

CREATE TABLE `estado_habitacion` (
  `id_estado_habitacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_estado_habitacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `estado_habitacion`
--

INSERT INTO `estado_habitacion` VALUES(1, 'checkin');
INSERT INTO `estado_habitacion` VALUES(2, 'pendiente pago');
INSERT INTO `estado_habitacion` VALUES(3, 'reservado');
INSERT INTO `estado_habitacion` VALUES(4, 'disponible');

-- --------------------------------------------------------

--
-- Table structure for table `estado_usuario`
--

CREATE TABLE `estado_usuario` (
  `id_estado_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `estado_usuario` varchar(20) NOT NULL,
  PRIMARY KEY (`id_estado_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `estado_usuario`
--

INSERT INTO `estado_usuario` VALUES(1, 'Inactivo');
INSERT INTO `estado_usuario` VALUES(2, 'Activo');

-- --------------------------------------------------------

--
-- Table structure for table `habitacion`
--

CREATE TABLE `habitacion` (
  `id_habitacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `id_tipo_habitacion` bigint(20) unsigned DEFAULT NULL,
  `id_estado_habitacion` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_habitacion`),
  KEY `fk_habitacion_tipo_habitacion1` (`id_tipo_habitacion`),
  KEY `fk_habitacion_estado_habitacion1` (`id_estado_habitacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `habitacion`
--


-- --------------------------------------------------------

--
-- Table structure for table `idioma`
--

CREATE TABLE `idioma` (
  `id_idioma` int(11) NOT NULL AUTO_INCREMENT,
  `idioma` char(2) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  PRIMARY KEY (`id_idioma`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `idioma`
--

INSERT INTO `idioma` VALUES(1, 'es', 'Español');
INSERT INTO `idioma` VALUES(2, 'en', 'English');

-- --------------------------------------------------------

--
-- Table structure for table `moneda`
--

CREATE TABLE `moneda` (
  `id_moneda` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `abreviado` varchar(5) NOT NULL,
  PRIMARY KEY (`id_moneda`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `moneda`
--

INSERT INTO `moneda` VALUES(1, 'bolívares', 'Bs');
INSERT INTO `moneda` VALUES(2, 'dollares', 'dls');

-- --------------------------------------------------------

--
-- Table structure for table `monitor`
--

CREATE TABLE `monitor` (
  `id_monitor` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_contenido` varchar(16) NOT NULL,
  `id_contenido` int(11) NOT NULL,
  `tipo_accion` varchar(16) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_monitor`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `monitor`
--


-- --------------------------------------------------------

--
-- Table structure for table `multimedia`
--

CREATE TABLE `multimedia` (
  `id_multimedia` int(11) NOT NULL AUTO_INCREMENT,
  `destacado` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Imagen Destacada',
  `fichero` varchar(1024) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `actualizado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_multimedia`),
  KEY `fk_multimedia_estado1` (`id_estado`),
  KEY `fk_multimedia_tipo_multimedia1` (`id_tipo`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `multimedia`
--

INSERT INTO `multimedia` VALUES(10, 1, '1661054630_500x300_3.jpg', 1, 1, '0000-00-00 00:00:00', '2012-01-24 08:58:53', 2);
INSERT INTO `multimedia` VALUES(11, 1, '1194002014_borrar_800x600_1.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-13 13:35:54', 2);
INSERT INTO `multimedia` VALUES(12, 2, '1220447898_borrar_800x600_7.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-13 13:36:19', 2);
INSERT INTO `multimedia` VALUES(14, 2, '1430770418_borrar_800x600_2.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-13 13:37:15', 2);
INSERT INTO `multimedia` VALUES(15, 1, '1532511391_borrar_800x600_4.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-13 15:54:26', 2);
INSERT INTO `multimedia` VALUES(16, 2, '1632715962_borrar_800x600_2.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-13 15:54:44', 2);
INSERT INTO `multimedia` VALUES(17, 2, '172192294_borrar_800x600_1.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-13 15:54:44', 2);
INSERT INTO `multimedia` VALUES(21, 1, '2117234388_23310351930_bolsa_con_asa.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-14 10:16:38', 2);
INSERT INTO `multimedia` VALUES(24, 1, '2460872699_home_product2.png', 1, 1, '0000-00-00 00:00:00', '2013-08-21 13:31:59', 2);
INSERT INTO `multimedia` VALUES(25, 1, '2533496217_home_product1.png', 1, 1, '0000-00-00 00:00:00', '2013-08-21 14:58:50', 2);
INSERT INTO `multimedia` VALUES(26, 1, '2697295785_2299934851_BOLSA_BASURA_2.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-21 15:44:09', 2);
INSERT INTO `multimedia` VALUES(27, 1, '2729386450_23868652651_BOLSA_BASURA_2.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-21 15:46:23', 2);
INSERT INTO `multimedia` VALUES(31, 1, '314825222_papel.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-22 13:59:17', 2);
INSERT INTO `multimedia` VALUES(33, 1, '3355190194_2841547464_portacomida.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-26 14:02:30', 2);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id_newsletter` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(128) NOT NULL,
  `id_idioma` int(2) NOT NULL,
  `id_estado` int(2) NOT NULL,
  `creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_newsletter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `newsletter`
--


-- --------------------------------------------------------

--
-- Table structure for table `noticia`
--

CREATE TABLE `noticia` (
  `id_noticia` int(11) NOT NULL AUTO_INCREMENT,
  `id_estado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `modificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `destacado` int(11) NOT NULL,
  `enlace` varchar(256) NOT NULL,
  `fichero` varchar(256) NOT NULL,
  PRIMARY KEY (`id_noticia`),
  KEY `id_estado` (`id_estado`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=23 ;

--
-- Dumping data for table `noticia`
--

INSERT INTO `noticia` VALUES(16, 1, 2, '2012-01-24 00:00:00', '2012-01-24 08:58:53', 0, '', '');
INSERT INTO `noticia` VALUES(18, 2, 2, '2013-08-13 16:19:57', '2013-08-13 16:19:57', 3, '', '');
INSERT INTO `noticia` VALUES(19, 2, 2, '2013-08-13 16:20:06', '2013-08-13 16:20:06', 1, '', '');
INSERT INTO `noticia` VALUES(20, 3, 2, '2013-08-13 16:20:11', '2013-08-13 16:20:11', 1, '', '');
INSERT INTO `noticia` VALUES(21, 1, 2, '2013-08-13 16:20:16', '2013-08-13 16:20:16', 1, '', '');
INSERT INTO `noticia` VALUES(22, 1, 2, '2013-08-13 00:00:00', '2013-08-13 16:21:33', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `posada`
--

CREATE TABLE `posada` (
  `id_posada` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `direccion` text NOT NULL,
  `email_contacto` varchar(50) NOT NULL,
  `telefono_contacto` varchar(45) NOT NULL,
  PRIMARY KEY (`id_posada`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `posada`
--

INSERT INTO `posada` VALUES(1, 'Sol y Luna', 'Los Roques', 'solyluna@gmail.com', '+58412-765-3423');

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `destacado` tinyint(1) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `modificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ean` varchar(16) CHARACTER SET utf8 NOT NULL,
  `codigo_coloplas` varchar(32) CHARACTER SET utf8 NOT NULL,
  `enlace` varchar(256) CHARACTER SET utf8 NOT NULL COMMENT 'Enlace  google Maps',
  `latitud` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `longitud` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `enlace_video` varchar(256) CHARACTER SET utf8 NOT NULL,
  `formato` varchar(128) CHARACTER SET utf8 NOT NULL,
  `unidades_caja` int(11) NOT NULL,
  `precio_unidad` float NOT NULL,
  `nombre_empresa` text NOT NULL,
  `rif_empresa` text NOT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `id_estado` (`id_estado`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `producto`
--


-- --------------------------------------------------------

--
-- Table structure for table `promocion`
--

CREATE TABLE `promocion` (
  `id_promocion` int(11) NOT NULL AUTO_INCREMENT,
  `id_estado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `modificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `destacado` int(11) NOT NULL,
  `enlace` varchar(256) NOT NULL,
  `fichero` varchar(256) NOT NULL,
  PRIMARY KEY (`id_promocion`),
  KEY `id_estado` (`id_estado`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

--
-- Dumping data for table `promocion`
--


-- --------------------------------------------------------

--
-- Table structure for table `receta`
--

CREATE TABLE `receta` (
  `id_receta` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `destacado` int(1) NOT NULL,
  `creado` date NOT NULL,
  `modificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_estado` int(11) NOT NULL,
  `tipo_receta` enum('mes','usuario') NOT NULL,
  PRIMARY KEY (`id_receta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `receta`
--


-- --------------------------------------------------------

--
-- Table structure for table `rel_banner_multimedia`
--

CREATE TABLE `rel_banner_multimedia` (
  `id_banner` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_noticia` (`id_banner`,`id_multimedia`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rel_banner_multimedia`
--


-- --------------------------------------------------------

--
-- Table structure for table `rel_categoria_multimedia`
--

CREATE TABLE `rel_categoria_multimedia` (
  `id_categoria` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_categoria` (`id_categoria`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rel_categoria_multimedia`
--


-- --------------------------------------------------------

--
-- Table structure for table `rel_detalle_receta_tag`
--

CREATE TABLE `rel_detalle_receta_tag` (
  `id_detalle_receta` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL,
  KEY `id_receta` (`id_detalle_receta`),
  KEY `id_tag` (`id_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rel_detalle_receta_tag`
--


-- --------------------------------------------------------

--
-- Table structure for table `rel_habitacion_multimedia`
--

CREATE TABLE `rel_habitacion_multimedia` (
  `id_habitacion` bigint(20) unsigned NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_habitacion` (`id_habitacion`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rel_habitacion_multimedia`
--


-- --------------------------------------------------------

--
-- Table structure for table `rel_noticia_multimedia`
--

CREATE TABLE `rel_noticia_multimedia` (
  `id_noticia` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_noticia` (`id_noticia`,`id_multimedia`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rel_noticia_multimedia`
--


-- --------------------------------------------------------

--
-- Table structure for table `rel_posada_multimedia`
--

CREATE TABLE `rel_posada_multimedia` (
  `id_posada` bigint(20) unsigned NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_posada` (`id_posada`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rel_posada_multimedia`
--


-- --------------------------------------------------------

--
-- Table structure for table `rel_producto_multimedia`
--

CREATE TABLE `rel_producto_multimedia` (
  `id_producto` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  PRIMARY KEY (`id_producto`,`id_multimedia`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rel_producto_multimedia`
--


-- --------------------------------------------------------

--
-- Table structure for table `rel_producto_noticia`
--

CREATE TABLE `rel_producto_noticia` (
  `id_producto` int(11) NOT NULL,
  `id_noticia` int(11) NOT NULL,
  KEY `id_producto` (`id_producto`),
  KEY `id_noticia` (`id_noticia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rel_producto_noticia`
--


-- --------------------------------------------------------

--
-- Table structure for table `rel_producto_producto`
--

CREATE TABLE `rel_producto_producto` (
  `id_producto` int(11) NOT NULL,
  `id_producto_relacionado` int(11) NOT NULL,
  KEY `id_producto` (`id_producto`),
  KEY `id_producto_relacionado` (`id_producto_relacionado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rel_producto_producto`
--


-- --------------------------------------------------------

--
-- Table structure for table `rel_producto_receta`
--

CREATE TABLE `rel_producto_receta` (
  `id_producto` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  KEY `id_producto` (`id_producto`),
  KEY `id_receta` (`id_receta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rel_producto_receta`
--


-- --------------------------------------------------------

--
-- Table structure for table `rel_promocion_multimedia`
--

CREATE TABLE `rel_promocion_multimedia` (
  `id_promocion` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_noticia` (`id_promocion`,`id_multimedia`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rel_promocion_multimedia`
--


-- --------------------------------------------------------

--
-- Table structure for table `rel_receta_multimedia`
--

CREATE TABLE `rel_receta_multimedia` (
  `id_receta` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_multimedia` (`id_multimedia`),
  KEY `id_producto` (`id_receta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rel_receta_multimedia`
--


-- --------------------------------------------------------

--
-- Table structure for table `rel_servicio_habitacion`
--

CREATE TABLE `rel_servicio_habitacion` (
  `id_habitacion` bigint(20) unsigned NOT NULL,
  `id_servicio_habitacion` bigint(20) unsigned NOT NULL,
  KEY `id_habitacion` (`id_habitacion`),
  KEY `id_servicio_habitacion` (`id_servicio_habitacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rel_servicio_habitacion`
--


-- --------------------------------------------------------

--
-- Table structure for table `rel_servicio_posada_multimedia`
--

CREATE TABLE `rel_servicio_posada_multimedia` (
  `id_servicio_posada` bigint(20) unsigned NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_servicio_posada` (`id_servicio_posada`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rel_servicio_posada_multimedia`
--


-- --------------------------------------------------------

--
-- Table structure for table `reservacion`
--

CREATE TABLE `reservacion` (
  `id_reservacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `checkin` datetime NOT NULL,
  `checkout` datetime NOT NULL,
  `creado` datetime NOT NULL,
  `id_estado_activo` bigint(20) unsigned DEFAULT NULL,
  `id_tipo_forma_pago` bigint(20) unsigned DEFAULT NULL,
  `id_usuario_front` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_reservacion`),
  KEY `id_estado_activo` (`id_estado_activo`),
  KEY `id_tipo_forma_pago` (`id_tipo_forma_pago`),
  KEY `id_usuario_front` (`id_usuario_front`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `reservacion`
--


-- --------------------------------------------------------

--
-- Table structure for table `reservacion_habitacion`
--

CREATE TABLE `reservacion_habitacion` (
  `id_reservacion` bigint(20) unsigned NOT NULL,
  `id_habitacion` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id_reservacion`,`id_habitacion`),
  KEY `fk_reservacion_has_habitacion_habitacion1` (`id_habitacion`),
  KEY `fk_reservacion_has_habitacion_reservacion1` (`id_reservacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservacion_habitacion`
--


-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` VALUES(1, 'admin');
INSERT INTO `rol` VALUES(2, 'editor');
INSERT INTO `rol` VALUES(3, 'usuario');
INSERT INTO `rol` VALUES(4, 'inactivo');

-- --------------------------------------------------------

--
-- Table structure for table `servicio_habitacion`
--

CREATE TABLE `servicio_habitacion` (
  `id_servicio_habitacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `destacado` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `modificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `codigo` varchar(50) DEFAULT NULL,
  `id_estado_activo` bigint(20) unsigned DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_servicio_habitacion`),
  KEY `id_estado_activo` (`id_estado_activo`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `servicio_habitacion`
--


-- --------------------------------------------------------

--
-- Table structure for table `servicio_posada`
--

CREATE TABLE `servicio_posada` (
  `id_servicio_posada` bigint(20) unsigned NOT NULL,
  `destacado` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `modificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `codigo` varchar(20) NOT NULL,
  `id_posada` bigint(20) unsigned NOT NULL,
  `id_estado_activo` bigint(20) unsigned DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_servicio_posada`),
  KEY `id_posada` (`id_posada`),
  KEY `id_estado_activo` (`id_estado_activo`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `servicio_posada`
--


-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id_tag` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(64) NOT NULL,
  `id_idioma` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  PRIMARY KEY (`id_tag`),
  KEY `R_51` (`id_idioma`),
  KEY `id_estado` (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tag`
--


-- --------------------------------------------------------

--
-- Table structure for table `temporada`
--

CREATE TABLE `temporada` (
  `id_temporada` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id_temporada`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `temporada`
--

INSERT INTO `temporada` VALUES(1, 'Normal');
INSERT INTO `temporada` VALUES(2, 'Temporada Alta');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_categoria`
--

CREATE TABLE `tipo_categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tipo_categoria`
--

INSERT INTO `tipo_categoria` VALUES(1, 'producto');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_forma_pago`
--

CREATE TABLE `tipo_forma_pago` (
  `id_tipo_forma_pago` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_forma_pago`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tipo_forma_pago`
--

INSERT INTO `tipo_forma_pago` VALUES(1, 'Debito');
INSERT INTO `tipo_forma_pago` VALUES(2, 'Credito');
INSERT INTO `tipo_forma_pago` VALUES(3, 'Cheque');
INSERT INTO `tipo_forma_pago` VALUES(4, 'Transferencia');
INSERT INTO `tipo_forma_pago` VALUES(5, 'Efectivo');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_habitacion`
--

CREATE TABLE `tipo_habitacion` (
  `id_tipo_habitacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `personas` int(11) NOT NULL,
  `costo` double NOT NULL,
  PRIMARY KEY (`id_tipo_habitacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tipo_habitacion`
--


-- --------------------------------------------------------

--
-- Table structure for table `tipo_multimedia`
--

CREATE TABLE `tipo_multimedia` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tipo_multimedia`
--

INSERT INTO `tipo_multimedia` VALUES(1, 'imagen');
INSERT INTO `tipo_multimedia` VALUES(2, 'banner');
INSERT INTO `tipo_multimedia` VALUES(3, 'video');
INSERT INTO `tipo_multimedia` VALUES(4, 'pdf');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `nombre_usuario` varchar(64) NOT NULL,
  `password` char(40) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `apellidos` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_rol` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `verificacion` varchar(256) NOT NULL DEFAULT '0',
  `id_estado_usuario` int(11) DEFAULT '1',
  PRIMARY KEY (`id_usuario`),
  KEY `fk_usuario_rol1` (`id_rol`),
  KEY `fk_usuario_estado_usuario` (`id_estado_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` VALUES('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrador', 'admin', 'admin@admin.com', 2, 1, '2010-06-30', '', 2);
INSERT INTO `usuario` VALUES('gchemello', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Gerardo', 'Chemello', 'gchemello@gmail.com', 3, 2, '2011-07-26', 'e77fd6256d5c46cbb013b9f7cec724d30b04b4ef', 2);

-- --------------------------------------------------------

--
-- Table structure for table `usuario_front`
--

CREATE TABLE `usuario_front` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `usuario_front`
--


-- --------------------------------------------------------

--
-- Table structure for table `votacion`
--

CREATE TABLE `votacion` (
  `id_voto` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_contenido` int(11) NOT NULL,
  `tipo_contenido` varchar(64) NOT NULL,
  `puntos` int(2) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_voto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `votacion`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `categoria_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE,
  ADD CONSTRAINT `categoria_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `categoria_ibfk_3` FOREIGN KEY (`id_tipo_cat`) REFERENCES `tipo_categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `costo`
--
ALTER TABLE `costo`
  ADD CONSTRAINT `fk_costo_moneda1` FOREIGN KEY (`id_moneda`) REFERENCES `moneda` (`id_moneda`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_costo_temporada1` FOREIGN KEY (`id_temporada`) REFERENCES `temporada` (`id_temporada`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_costo_tipo_habitacion1` FOREIGN KEY (`id_tipo_habitacion`) REFERENCES `tipo_habitacion` (`id_tipo_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detalle_banner`
--
ALTER TABLE `detalle_banner`
  ADD CONSTRAINT `detalle_banner_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`);

--
-- Constraints for table `detalle_categoria`
--
ALTER TABLE `detalle_categoria`
  ADD CONSTRAINT `detalle_categoria_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_categoria_ibfk_2` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE;

--
-- Constraints for table `detalle_producto`
--
ALTER TABLE `detalle_producto`
  ADD CONSTRAINT `detalle_producto_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_producto_ibfk_2` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE;

--
-- Constraints for table `detalle_receta`
--
ALTER TABLE `detalle_receta`
  ADD CONSTRAINT `detalle_receta_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_receta_ibfk_2` FOREIGN KEY (`id_receta`) REFERENCES `receta` (`id_receta`) ON DELETE CASCADE;

--
-- Constraints for table `detalle_servicio_habitacion`
--
ALTER TABLE `detalle_servicio_habitacion`
  ADD CONSTRAINT `detalle_servicio_habitacion_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_servicio_habitacion_ibfk_2` FOREIGN KEY (`id_servicio_habitacion`) REFERENCES `servicio_habitacion` (`id_servicio_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detalle_servicio_posada`
--
ALTER TABLE `detalle_servicio_posada`
  ADD CONSTRAINT `detalle_servicio_posada_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_servicio_posada_ibfk_2` FOREIGN KEY (`id_servicio_posada`) REFERENCES `servicio_posada` (`id_servicio_posada`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `habitacion`
--
ALTER TABLE `habitacion`
  ADD CONSTRAINT `fk_habitacion_estado_habitacion1` FOREIGN KEY (`id_estado_habitacion`) REFERENCES `estado_habitacion` (`id_estado_habitacion`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_habitacion_tipo_habitacion1` FOREIGN KEY (`id_tipo_habitacion`) REFERENCES `tipo_habitacion` (`id_tipo_habitacion`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `multimedia`
--
ALTER TABLE `multimedia`
  ADD CONSTRAINT `multimedia_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_multimedia` (`id_tipo`) ON DELETE CASCADE,
  ADD CONSTRAINT `multimedia_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `multimedia_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `noticia`
--
ALTER TABLE `noticia`
  ADD CONSTRAINT `noticia_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `noticia_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `rel_categoria_multimedia`
--
ALTER TABLE `rel_categoria_multimedia`
  ADD CONSTRAINT `rel_categoria_multimedia_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE,
  ADD CONSTRAINT `rel_categoria_multimedia_ibfk_2` FOREIGN KEY (`id_multimedia`) REFERENCES `multimedia` (`id_multimedia`) ON DELETE CASCADE;

--
-- Constraints for table `rel_habitacion_multimedia`
--
ALTER TABLE `rel_habitacion_multimedia`
  ADD CONSTRAINT `rel_habitacion_multimedia_ibfk_1` FOREIGN KEY (`id_habitacion`) REFERENCES `habitacion` (`id_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rel_habitacion_multimedia_ibfk_2` FOREIGN KEY (`id_multimedia`) REFERENCES `multimedia` (`id_multimedia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rel_noticia_multimedia`
--
ALTER TABLE `rel_noticia_multimedia`
  ADD CONSTRAINT `rel_noticia_multimedia_ibfk_1` FOREIGN KEY (`id_noticia`) REFERENCES `noticia` (`id_noticia`) ON DELETE CASCADE,
  ADD CONSTRAINT `rel_noticia_multimedia_ibfk_2` FOREIGN KEY (`id_multimedia`) REFERENCES `multimedia` (`id_multimedia`) ON DELETE CASCADE;

--
-- Constraints for table `rel_posada_multimedia`
--
ALTER TABLE `rel_posada_multimedia`
  ADD CONSTRAINT `rel_posada_multimedia_ibfk_3` FOREIGN KEY (`id_posada`) REFERENCES `posada` (`id_posada`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rel_posada_multimedia_ibfk_4` FOREIGN KEY (`id_multimedia`) REFERENCES `multimedia` (`id_multimedia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rel_producto_multimedia`
--
ALTER TABLE `rel_producto_multimedia`
  ADD CONSTRAINT `rel_producto_multimedia_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `rel_producto_multimedia_ibfk_2` FOREIGN KEY (`id_multimedia`) REFERENCES `multimedia` (`id_multimedia`) ON DELETE CASCADE;

--
-- Constraints for table `rel_producto_noticia`
--
ALTER TABLE `rel_producto_noticia`
  ADD CONSTRAINT `rel_producto_noticia_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `rel_producto_noticia_ibfk_2` FOREIGN KEY (`id_noticia`) REFERENCES `noticia` (`id_noticia`) ON DELETE CASCADE;

--
-- Constraints for table `rel_producto_producto`
--
ALTER TABLE `rel_producto_producto`
  ADD CONSTRAINT `rel_producto_producto_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `rel_producto_producto_ibfk_2` FOREIGN KEY (`id_producto_relacionado`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE;

--
-- Constraints for table `rel_producto_receta`
--
ALTER TABLE `rel_producto_receta`
  ADD CONSTRAINT `rel_producto_receta_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `rel_producto_receta_ibfk_2` FOREIGN KEY (`id_receta`) REFERENCES `receta` (`id_receta`) ON DELETE CASCADE;

--
-- Constraints for table `rel_servicio_habitacion`
--
ALTER TABLE `rel_servicio_habitacion`
  ADD CONSTRAINT `rel_servicio_habitacion_ibfk_1` FOREIGN KEY (`id_habitacion`) REFERENCES `habitacion` (`id_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rel_servicio_habitacion_ibfk_2` FOREIGN KEY (`id_servicio_habitacion`) REFERENCES `servicio_habitacion` (`id_servicio_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rel_servicio_posada_multimedia`
--
ALTER TABLE `rel_servicio_posada_multimedia`
  ADD CONSTRAINT `rel_servicio_posada_multimedia_ibfk_1` FOREIGN KEY (`id_servicio_posada`) REFERENCES `servicio_posada` (`id_servicio_posada`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rel_servicio_posada_multimedia_ibfk_2` FOREIGN KEY (`id_multimedia`) REFERENCES `multimedia` (`id_multimedia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservacion`
--
ALTER TABLE `reservacion`
  ADD CONSTRAINT `reservacion_ibfk_1` FOREIGN KEY (`id_usuario_front`) REFERENCES `usuario_front` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservacion_ibfk_2` FOREIGN KEY (`id_tipo_forma_pago`) REFERENCES `tipo_forma_pago` (`id_tipo_forma_pago`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reservacion_ibfk_3` FOREIGN KEY (`id_estado_activo`) REFERENCES `estado_activo` (`id_estado_activo`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `reservacion_habitacion`
--
ALTER TABLE `reservacion_habitacion`
  ADD CONSTRAINT `fk_reservacion_has_habitacion_habitacion1` FOREIGN KEY (`id_habitacion`) REFERENCES `habitacion` (`id_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservacion_has_habitacion_reservacion1` FOREIGN KEY (`id_reservacion`) REFERENCES `reservacion` (`id_reservacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `servicio_habitacion`
--
ALTER TABLE `servicio_habitacion`
  ADD CONSTRAINT `servicio_habitacion_ibfk_1` FOREIGN KEY (`id_estado_activo`) REFERENCES `estado_activo` (`id_estado_activo`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `servicio_habitacion_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `servicio_posada`
--
ALTER TABLE `servicio_posada`
  ADD CONSTRAINT `servicio_posada_ibfk_1` FOREIGN KEY (`id_posada`) REFERENCES `posada` (`id_posada`) ON UPDATE CASCADE,
  ADD CONSTRAINT `servicio_posada_ibfk_2` FOREIGN KEY (`id_estado_activo`) REFERENCES `estado_activo` (`id_estado_activo`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `servicio_posada_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tag`
--
ALTER TABLE `tag`
  ADD CONSTRAINT `tag_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE,
  ADD CONSTRAINT `tag_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE;

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_estado_usuario`) REFERENCES `estado_usuario` (`id_estado_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;
