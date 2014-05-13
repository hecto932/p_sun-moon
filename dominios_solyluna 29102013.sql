-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 29, 2013 at 03:57 PM
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
  `slider` text NOT NULL,
  PRIMARY KEY (`id_banner`),
  KEY `id_estado` (`id_estado`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=3 ;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` VALUES(1, 1, 0, '2013-09-05 00:00:00', '2013-09-05 10:21:09', 0, '1', '', '');
INSERT INTO `banner` VALUES(2, 3, 0, '2013-10-29 00:00:00', '2013-10-29 15:00:53', 0, '1', '', 'fgsrtsdfgfdgdfg   gdfgd d dg df gdf aksjhjksh askjhaksjfh skfjhsdfjkhskfh fhdksh kjdhsfkfh kjdhsfkjh asjkhaskh skjfh');

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
  `valor` double NOT NULL,
  `id_moneda` bigint(20) unsigned NOT NULL,
  `id_temporada` bigint(20) unsigned NOT NULL,
  `id_detalle_tipo_habitacion` int(11) NOT NULL,
  PRIMARY KEY (`id_costo`),
  KEY `fk_costo_moneda1` (`id_moneda`),
  KEY `fk_costo_temporada1` (`id_temporada`),
  KEY `id_detalle_tipo_habitacion` (`id_detalle_tipo_habitacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

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
-- Table structure for table `detalle_habitacion`
--

CREATE TABLE `detalle_habitacion` (
  `id_detalle_habitacion` int(11) NOT NULL AUTO_INCREMENT,
  `id_habitacion` bigint(20) unsigned NOT NULL,
  `id_idioma` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `subtitulo` varchar(50) NOT NULL,
  `descripcion_breve` varchar(200) NOT NULL,
  `descripcion_ampliada` text NOT NULL,
  `descripcion_pagina` varchar(500) NOT NULL,
  `keywords` varchar(500) NOT NULL,
  `titulo_pagina` varchar(150) NOT NULL,
  PRIMARY KEY (`id_detalle_habitacion`),
  KEY `id_habitacion` (`id_habitacion`),
  KEY `id_idioma` (`id_idioma`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `detalle_habitacion`
--

INSERT INTO `detalle_habitacion` VALUES(1, 5, 1, 'habitacin-para-dos-personas', 'Habitación para dos personas', 'Habitación para dos personas', 'Cómoda habitación para dos personas', '<p>C&oacute;moda habitaci&oacute;n para dos personas</p>\n', 'Habitación para dos personas', 'Habitación para dos personas', 'Habitación para dos personas');
INSERT INTO `detalle_habitacion` VALUES(2, 5, 3, 'chambre-confortable-pour-deux-personnes', 'Chambre confortable pour deux personnes', 'Chambre confortable pour deux personnes', 'Chambre confortable pour deux personnes', '<p><span class="short_text" id="result_box" lang="fr"><span class="hps">Chambre</span> <span class="hps">confortable pour deux personnes</span></span></p>\n', 'Chambre confortable pour deux personnes', 'Chambre confortable pour deux personnes', 'Chambre confortable pour deux personnes');
INSERT INTO `detalle_habitacion` VALUES(3, 5, 5, 'confortevole-camera-per-due-persone', 'Confortevole camera per due persone', 'Confortevole camera per due persone', 'Confortevole camera per due persone', '<p><span class="short_text" id="result_box" lang="it"><span class="hps">Confortevole camera</span> <span class="hps">per due</span> <span class="hps">persone</span></span></p>\n', 'Confortevole camera per due persone', 'Confortevole camera per due persone', 'Confortevole camera per due persone');
INSERT INTO `detalle_habitacion` VALUES(5, 4, 5, 'camera-confortevole-per-quattro-persone', 'Camera confortevole per quattro persone', 'Camera confortevole per quattro persone', 'Camera confortevole per quattro persone', '<p><br />\n<span class="short_text" id="result_box" lang="it"><span class="hps">Camera confortevole</span> <span class="hps">per quattro persone</span></span></p>\n', 'Camera confortevole per quattro persone', 'Camera confortevole per quattro persone', 'Camera confortevole per quattro persone');
INSERT INTO `detalle_habitacion` VALUES(6, 4, 3, 'chambre-confortable-pour-quatre-personnes', 'Chambre confortable pour quatre personnes', 'Chambre confortable pour quatre personnes', 'Chambre confortable pour quatre personnes', '<p><br />\n<span class="short_text" id="result_box" lang="fr"><span class="hps">Chambre confortable pour</span> <span class="hps">quatre personnes</span></span></p>\n', 'Chambre confortable pour quatre personnes', 'Chambre confortable pour quatre personnes', 'Chambre confortable pour quatre personnes');
INSERT INTO `detalle_habitacion` VALUES(7, 4, 2, 'comfortable-room-for-four-people', 'Comfortable room for four people', 'Comfortable room for four people', 'Comfortable room for four people', '<p><span class="short_text" id="result_box" lang="en"><span class="hps">Comfortable room for</span> <span class="hps">four people</span></span></p>\n', 'Comfortable room for four people', 'Comfortable room for four people', 'Comfortable room for four people');
INSERT INTO `detalle_habitacion` VALUES(8, 6, 1, 'individual', 'Individual', 'Hermosa habitación individual', 'Hermosa habitación individual Hermosa habitación individual Hermosa habitación individual', '<p><br />\nHermosa habitaci&oacute;n individual Hermosa habitaci&oacute;n individual Hermosa habitaci&oacute;n individual</p>\n', 'Hermosa habitación individual', 'Hermosa habitación individual', 'Hermosa habitación individual');

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
-- Table structure for table `detalle_servicio`
--

CREATE TABLE `detalle_servicio` (
  `id_detalle_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `id_servicio` int(11) NOT NULL,
  `id_idioma` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `subtitulo` varchar(50) NOT NULL,
  `descripcion_breve` varchar(200) NOT NULL,
  `descripcion_ampliada` text NOT NULL,
  `descripcion_pagina` varchar(500) NOT NULL,
  `keywords` varchar(500) NOT NULL,
  `titulo_pagina` varchar(150) NOT NULL,
  PRIMARY KEY (`id_detalle_servicio`),
  KEY `id_servicio` (`id_servicio`),
  KEY `id_idioma` (`id_idioma`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `detalle_servicio`
--

INSERT INTO `detalle_servicio` VALUES(2, 1, 1, 'pensin-completa', 'Pensión Completa', 'Pensión Completa', 'Rico desayuno internacional, merienda para la playa preparada en una cava cooler con hielo, diferente cada día y una exquisita y acogedora cena.', '<p>Rico desayuno internacional, merienda para la playa preparada en una cava cooler con hielo (Agua Mineral, Refrescos, Galletas, Frutas, Almuerzo fr&iacute;o tipo lunch) diferente cada d&iacute;a y una exquisita y acogedora cena.</p>\n', 'Pensión Completa', 'Pensión Completa', 'Pensión Completa');
INSERT INTO `detalle_servicio` VALUES(3, 1, 2, 'full-guesthouse', 'Full Guesthouse', 'Full Guesthouse', 'International breakfast, snack for the beach prepared in a cooler with ice cava, different every day and an exquisite and cozy dinner.', '<p><span id="result_box" lang="en"><span class="hps">Rico</span> <span class="hps">international breakfast</span><span>,</span> <span class="hps">snack</span> <span class="hps">for the beach</span> <span class="hps">prepared in a</span> <span class="hps">cooler</span> <span class="hps">with ice</span> <span class="hps">cava</span></span><span lang="en">&nbsp;<span class="hps atn">(</span><span>Mineral</span> <span class="hps">Water</span><span>, Soft Drinks</span><span>,</span> <span class="hps">Cookies,</span> <span class="hps">Fruit</span><span>, Lunch</span> <span class="hps">lunch</span> <span class="hps">cold</span> <span class="hps">type</span><span>)</span> <span class="hps">different every day and</span> <span class="hps">an exquisite and</span> <span class="hps">cozy</span> <span class="hps">dinner</span><span>.</span></span></p>\n', 'Full Guesthouse', 'Full Guesthouse', 'Full Guesthouse');
INSERT INTO `detalle_servicio` VALUES(4, 1, 3, 'pension-complte', 'Pension complète', 'Pension complète', 'Petit-déjeuner international, un snack prêt pour la plage dans un refroidisseur de vin de glace.', '<p><span id="result_box" lang="fr"><span class="hps">Petit-d&eacute;jeuner international</span><span>, un snack</span> <span class="hps">pr&ecirc;t pour la plage</span> <span class="hps">dans un refroidisseur</span> <span class="hps">de vin de glace</span> <span class="hps atn">(</span><span>eau min&eacute;rale</span><span>, boissons gazeuses,</span> <span class="hps">biscuits</span><span>, fruits,</span> <span class="hps">d&eacute;jeuner</span> <span class="hps">lunch</span> <span class="hps">froid de type</span><span>)</span> <span class="hps">diff&eacute;rent chaque jour</span> <span class="hps">et</span> <span class="hps">un d&icirc;ner exquis</span> <span class="hps">et confortable.</span></span></p>\n', 'Pension complète', 'Pension complète', 'Pension complète');
INSERT INTO `detalle_servicio` VALUES(5, 1, 5, 'pensione-completa', 'Pensione completa', 'Pensione completa', 'Colazione internazionale, spuntino pronto per la spiaggia in un dispositivo di raffreddamento di vino con ghiaccio.', '<p><span id="result_box" lang="it"><span class="hps">Colazione</span> <span class="hps">internazionale</span><span>,</span> <span class="hps">spuntino</span> <span class="hps">pronto per la spiaggia</span> <span class="hps">in un</span> <span class="hps">dispositivo di raffreddamento</span> <span class="hps">di vino con ghiaccio</span> <span class="hps atn">(</span><span>acqua minerale</span><span>,</span> <span class="hps">bibite</span><span>,</span> <span class="hps">biscotti, frutta</span><span>, pranzo</span> <span class="hps">pranzo</span> <span class="hps">tipo</span> <span class="hps">freddo</span><span>)</span> <span class="hps">diverso ogni giorno e</span> <span class="hps">una cena squisita</span> <span class="hps">e accogliente</span><span>.</span></span></p>\n', 'Pensione completa', 'Pensione completa', 'Pensione completa');
INSERT INTO `detalle_servicio` VALUES(6, 1, 6, 'vollpension', 'Vollpension', 'Vollpension', 'Internationales Frühstück, Snack für den Strand in einen Kühler mit Eis cava.', '<p><span id="result_box" lang="de"><span class="hps">Internationales Fr&uuml;hst&uuml;ck</span><span>, Snack</span> <span class="hps">f&uuml;r den Strand</span> <span class="hps">in</span> <span class="hps">einen K&uuml;hler mit</span> <span class="hps">Eis</span> <span class="hps">cava</span> <span class="hps atn">(</span><span>Mineralwasser, alkoholfreie</span> <span class="hps">Getr&auml;nke</span><span>, Kekse</span><span>, Obst,</span> <span class="hps">Mittagessen</span> <span class="hps">Mittagessen</span> <span class="hps">kalte Art</span><span>)</span> <span class="hps">jeden Tag anders</span> <span class="hps">und ein exquisites</span> <span class="hps">und</span> <span class="hps">gem&uuml;tliches Abendessen</span> <span class="hps">vorbereitet.</span></span></p>\n', 'Vollpension', 'Vollpension', 'Vollpension');
INSERT INTO `detalle_servicio` VALUES(7, 1, 4, 'penso-completa', 'Pensão completa', 'Pensão completa', 'Pequeno-almoço internacional, lanche para a praia preparado em um refrigerador com cava gelo.', '<p><span id="result_box" lang="pt"><span class="hps">Pequeno-almo&ccedil;o internacional</span><span>,</span> <span class="hps">lanche</span> <span class="hps">para a praia</span> <span class="hps">preparado</span> <span class="hps">em um refrigerador</span> <span class="hps">com</span> <span class="hps">cava</span> <span class="hps">gelo</span> <span class="hps atn">(</span><span>&aacute;gua mineral</span><span>,</span> <span class="hps">refrigerantes, biscoitos</span><span>,</span> <span class="hps">frutas, almo&ccedil;o</span> <span class="hps">almo&ccedil;o</span> <span class="hps">tipo</span> <span class="hps">frio)</span> <span class="hps">diferente a cada</span> <span class="hps">dia e</span> <span class="hps">um jantar requintado</span> <span class="hps">e acolhedor.</span></span></p>\n', 'Pensão completa', 'Pensão completa', 'Pensão completa');
INSERT INTO `detalle_servicio` VALUES(9, 5, 1, 'media-pensin', 'Media Pensión', 'Media Pension', 'Rico desayuno internacional y una exquisita y acogedora cena. Alojamiento más desayuno.', '<p>Rico desayuno internacional y una exquisita y acogedora cena. Alojamiento m&aacute;s desayuno.</p>\n', 'Media Pension', 'Media Pension', 'Media Pension');
INSERT INTO `detalle_servicio` VALUES(10, 6, 1, 'todo-incluido', 'Todo Incluido', 'Todo Incluido', 'Desayuno internacional, lunch para la playa preparado en una cava cooler con hielo, exquisita y acogedora cena, excursión a una isla cercana por día.', '<p>Rico desayuno internacional, lunch para la playa preparado en una cava cooler con hielo (Agua Mineral, refrescos, galletas, frutas, almuerzo fr&iacute;o tipo lunch) diferente cada d&iacute;a y una exquisita y acogedora cena. Adicionalmente incluye una excursi&oacute;n a una isla cercana por d&iacute;a.</p>\n', 'Todo Incluido', 'Todo Incluido', 'Todo Incluido');
INSERT INTO `detalle_servicio` VALUES(11, 7, 1, 'excursin-a-una-isla-cercana-por-da', 'Excursión a una isla cercana por día', 'Excursión a una isla cercana por día', 'Traslado a los cayos cercanos Madrisky o Francisky (1 diaria) incluyendo sillas y sombrillas.', '<p>Traslado a los cayos cercanos Madrisky o Francisky (1 diaria) incluyendo sillas y sombrillas.</p>\n', 'Excursión a una isla cercana por día', 'Excursión a una isla cercana por día', 'Excursión a una isla cercana por día');
INSERT INTO `detalle_servicio` VALUES(12, 8, 1, 'actividades-deportivas', 'Actividades Deportivas', 'Actividades Deportivas', 'Organización de actividades deportivas y entretenimiento de buceo, pesca deportiva, Windsurf, Kitesurf, Paddle, Kayak', '<p>Organizaci&oacute;n de actividades deportivas y entretenimiento de buceo, pesca deportiva, windsurf, kitesurf, paddle, kayak</p>\n', 'Actividades Deportivas', 'Actividades Deportivas', 'Actividades Deportivas');
INSERT INTO `detalle_servicio` VALUES(13, 9, 1, 'pasaje-areo', 'Pasaje Aéreo', 'Pasaje Aéreo', 'Le compramos el pasaje aéreo si lo desea.', '<p>Le compramos el pasaje a&eacute;reo si lo desea.</p>\n', 'Pasaje Aéreo', 'Pasajes Aéreo', 'Pasaje Aéreo');

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
-- Table structure for table `detalle_tipo_habitacion`
--

CREATE TABLE `detalle_tipo_habitacion` (
  `id_detalle_tipo_habitacion` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_habitacion` bigint(20) unsigned NOT NULL,
  `id_idioma` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `subtitulo` varchar(50) NOT NULL,
  `descripcion_breve` varchar(200) NOT NULL,
  `descripcion_ampliada` text NOT NULL,
  `descripcion_pagina` varchar(500) NOT NULL,
  `keywords` varchar(500) NOT NULL,
  `titulo_pagina` varchar(150) NOT NULL,
  PRIMARY KEY (`id_detalle_tipo_habitacion`),
  KEY `id_tipo_habitacion` (`id_tipo_habitacion`),
  KEY `id_idioma` (`id_idioma`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `detalle_tipo_habitacion`
--

INSERT INTO `detalle_tipo_habitacion` VALUES(1, 15, 1, 'matrimonial1', 'Matrimonial', 'Matrimonial', 'Matrimonial', '<p>Matrimonial</p>\n', 'Matrimonial', 'Matrimonial', 'Matrimonial');
INSERT INTO `detalle_tipo_habitacion` VALUES(11, 15, 2, 'matrimonial', 'Matrimonial', 'Matrimonial', 'Matrimonial', '<p><br />\nMatrimonial</p>\n', 'Matrimonial', 'Matrimonial', 'Matrimonial');
INSERT INTO `detalle_tipo_habitacion` VALUES(13, 15, 5, 'matrimonial2', 'Matrimonial', 'Matrimonial', 'Matrimonial', '<p>Matrimonial</p>\n', 'Matrimonial', 'Matrimonial', 'Matrimonial');
INSERT INTO `detalle_tipo_habitacion` VALUES(15, 17, 1, 'individual', 'Individual', 'Hermosa habitación individual', 'Hermosa habitación individual Hermosa habitación individual Hermosa habitación individual', '<p>Hermosa habitaci&oacute;n individual Hermosa habitaci&oacute;n individual Hermosa habitaci&oacute;n individual</p>\n', 'Hermosa habitación individual', 'Hermosa habitación individual', 'Hermosa habitación individual');
INSERT INTO `detalle_tipo_habitacion` VALUES(16, 16, 2, 'familiar', 'Familiar', 'Familiar', 'Cómoda Habitación Familiar', '<p><br />\nC&oacute;moda Habitaci&oacute;n Familiar</p>\n', 'Habitación Familiar', 'Familiar', 'Familiar');

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
-- Table structure for table `estado_reservacion`
--

CREATE TABLE `estado_reservacion` (
  `id_estado_reservacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_estado_reservacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `estado_reservacion`
--

INSERT INTO `estado_reservacion` VALUES(1, 'disponible');
INSERT INTO `estado_reservacion` VALUES(2, 'pendiente pago');
INSERT INTO `estado_reservacion` VALUES(3, 'reservado');
INSERT INTO `estado_reservacion` VALUES(4, 'checkin');

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
  `codigo` varchar(100) DEFAULT NULL,
  `id_tipo_habitacion` bigint(20) unsigned DEFAULT NULL,
  `id_estado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_habitacion`),
  KEY `fk_habitacion_tipo_habitacion1` (`id_tipo_habitacion`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_estado` (`id_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `habitacion`
--

INSERT INTO `habitacion` VALUES(4, '003', 16, 1, 2);
INSERT INTO `habitacion` VALUES(5, '002', 15, 1, 2);
INSERT INTO `habitacion` VALUES(6, '001', 17, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `idioma`
--

CREATE TABLE `idioma` (
  `id_idioma` int(11) NOT NULL AUTO_INCREMENT,
  `idioma` char(2) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  PRIMARY KEY (`id_idioma`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `idioma`
--

INSERT INTO `idioma` VALUES(1, 'es', 'español');
INSERT INTO `idioma` VALUES(2, 'en', 'english');
INSERT INTO `idioma` VALUES(3, 'fr', 'français');
INSERT INTO `idioma` VALUES(4, 'pt', 'português');
INSERT INTO `idioma` VALUES(5, 'it', 'italiano');
INSERT INTO `idioma` VALUES(6, 'de', 'deutsch');

-- --------------------------------------------------------

--
-- Table structure for table `moneda`
--

CREATE TABLE `moneda` (
  `id_moneda` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `abreviado` varchar(5) NOT NULL,
  `id_idioma` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_moneda`),
  KEY `id_idioma` (`id_idioma`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `moneda`
--

INSERT INTO `moneda` VALUES(1, 'bolívares', 'Bs', NULL);
INSERT INTO `moneda` VALUES(2, 'dollares', 'Dls', NULL);
INSERT INTO `moneda` VALUES(3, 'euros', 'Eur', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=251 ;

--
-- Dumping data for table `monitor`
--

INSERT INTO `monitor` VALUES(1, 'noticias', 0, 'listado', '2013-09-04 14:51:05', 2);
INSERT INTO `monitor` VALUES(2, 'usuario', 0, 'crear', '2013-09-04 16:52:28', 2);
INSERT INTO `monitor` VALUES(3, 'usuario', 3, 'borrar', '2013-09-04 16:53:08', 2);
INSERT INTO `monitor` VALUES(4, 'usuario', 0, 'crear', '2013-09-05 09:26:55', 2);
INSERT INTO `monitor` VALUES(5, 'usuario', 0, 'crear', '2013-09-05 09:27:41', 2);
INSERT INTO `monitor` VALUES(6, 'usuario', 0, 'crear', '2013-09-05 09:28:04', 2);
INSERT INTO `monitor` VALUES(7, 'usuario', 5, 'ficha', '2013-09-05 09:39:28', 2);
INSERT INTO `monitor` VALUES(8, 'usuario', 5, 'ficha', '2013-09-05 09:40:40', 2);
INSERT INTO `monitor` VALUES(9, 'usuario', 5, 'editar', '2013-09-05 09:40:50', 2);
INSERT INTO `monitor` VALUES(10, 'usuario', 5, 'borrar', '2013-09-05 09:51:38', 2);
INSERT INTO `monitor` VALUES(11, 'usuario', 4, 'ficha', '2013-09-05 09:51:44', 2);
INSERT INTO `monitor` VALUES(12, 'usuario', 4, 'editar', '2013-09-05 09:51:48', 2);
INSERT INTO `monitor` VALUES(13, 'usuario', 4, 'ficha', '2013-09-05 09:51:53', 2);
INSERT INTO `monitor` VALUES(14, 'usuario', 4, 'editar', '2013-09-05 09:51:58', 2);
INSERT INTO `monitor` VALUES(15, 'usuario', 4, 'editar', '2013-09-05 09:52:09', 2);
INSERT INTO `monitor` VALUES(16, 'usuario', 4, 'editar', '2013-09-05 09:52:14', 2);
INSERT INTO `monitor` VALUES(17, 'usuario', 4, 'ficha', '2013-09-05 09:52:17', 2);
INSERT INTO `monitor` VALUES(18, 'usuario', 4, 'editar', '2013-09-05 09:52:22', 2);
INSERT INTO `monitor` VALUES(19, 'usuario', 0, 'crear', '2013-09-05 09:53:12', 2);
INSERT INTO `monitor` VALUES(20, 'usuario', 0, 'crear', '2013-09-05 09:53:37', 2);
INSERT INTO `monitor` VALUES(21, 'usuario', 0, 'crear', '2013-09-05 09:54:00', 2);
INSERT INTO `monitor` VALUES(22, 'usuario', 0, 'listado', '2013-09-05 09:54:42', 2);
INSERT INTO `monitor` VALUES(23, 'usuario', 0, 'listado', '2013-09-05 09:55:07', 2);
INSERT INTO `monitor` VALUES(24, 'usuario', 8, 'ficha', '2013-09-05 10:10:53', 2);
INSERT INTO `monitor` VALUES(25, 'usuario', 8, 'editar', '2013-09-05 10:11:01', 2);
INSERT INTO `monitor` VALUES(26, 'usuario', 8, 'borrar', '2013-09-05 10:11:08', 2);
INSERT INTO `monitor` VALUES(27, 'banner', 0, 'crear', '2013-09-05 10:21:09', 2);
INSERT INTO `monitor` VALUES(28, 'banner', 1, 'editar', '2013-09-05 10:21:14', 2);
INSERT INTO `monitor` VALUES(29, 'servicio', 0, 'crear', '2013-09-05 15:04:49', 2);
INSERT INTO `monitor` VALUES(30, 'servicio', 1, 'editar', '2013-09-05 15:14:17', 2);
INSERT INTO `monitor` VALUES(31, 'detalle_servicio', 1, 'editar_idioma', '2013-09-05 15:38:26', 2);
INSERT INTO `monitor` VALUES(32, 'detalle_servicio', 1, 'editar_idioma', '2013-09-05 15:57:08', 2);
INSERT INTO `monitor` VALUES(33, 'detalle_servicio', 1, 'eliminar_idioma', '2013-09-05 15:57:22', 2);
INSERT INTO `monitor` VALUES(34, 'servicio', 1, 'ficha', '2013-09-05 15:57:22', 2);
INSERT INTO `monitor` VALUES(35, 'detalle_servicio', 2, 'editar_idioma', '2013-09-05 15:58:38', 2);
INSERT INTO `monitor` VALUES(36, 'detalle_servicio', 3, 'editar_idioma', '2013-09-05 15:59:59', 2);
INSERT INTO `monitor` VALUES(37, 'detalle_servicio', 4, 'editar_idioma', '2013-09-05 16:18:52', 2);
INSERT INTO `monitor` VALUES(38, 'detalle_servicio', 5, 'editar_idioma', '2013-09-05 16:20:41', 2);
INSERT INTO `monitor` VALUES(39, 'detalle_servicio', 6, 'editar_idioma', '2013-09-05 16:23:36', 2);
INSERT INTO `monitor` VALUES(40, 'detalle_servicio', 7, 'editar_idioma', '2013-09-05 16:26:19', 2);
INSERT INTO `monitor` VALUES(41, 'detalle_servicio', 2, 'editar_idioma', '2013-09-05 16:27:24', 2);
INSERT INTO `monitor` VALUES(42, 'detalle_servicio', 2, 'editar_idioma', '2013-09-05 16:27:52', 2);
INSERT INTO `monitor` VALUES(43, 'detalle_servicio', 2, 'editar_idioma', '2013-09-05 16:43:40', 2);
INSERT INTO `monitor` VALUES(44, 'detalle_servicio', 2, 'editar_idioma', '2013-09-05 16:44:13', 2);
INSERT INTO `monitor` VALUES(45, 'detalle_servicio', 2, 'editar_idioma', '2013-09-05 16:50:40', 2);
INSERT INTO `monitor` VALUES(46, 'detalle_servicio', 2, 'editar_idioma', '2013-09-05 16:50:52', 2);
INSERT INTO `monitor` VALUES(47, 'servicio', 0, 'crear', '2013-09-05 17:15:09', 2);
INSERT INTO `monitor` VALUES(48, 'detalle_servicio', 8, 'editar_idioma', '2013-09-05 17:15:51', 2);
INSERT INTO `monitor` VALUES(49, 'servicio', 0, 'crear', '2013-09-06 09:51:25', 2);
INSERT INTO `monitor` VALUES(50, 'servicio', 0, 'crear', '2013-09-06 14:08:08', 2);
INSERT INTO `monitor` VALUES(51, 'servicio', 0, 'crear', '2013-09-06 14:08:33', 2);
INSERT INTO `monitor` VALUES(52, 'servicio', 0, 'crear', '2013-09-06 14:18:26', 2);
INSERT INTO `monitor` VALUES(53, 'servicio', 0, 'crear', '2013-09-06 14:20:46', 2);
INSERT INTO `monitor` VALUES(54, 'servicio', 0, 'crear', '2013-09-06 14:22:49', 2);
INSERT INTO `monitor` VALUES(55, 'servicio', 0, 'crear', '2013-09-06 14:28:23', 2);
INSERT INTO `monitor` VALUES(56, 'servicio', 0, 'crear', '2013-09-06 15:43:19', 2);
INSERT INTO `monitor` VALUES(57, 'detalle_servicio', 9, 'editar_idioma', '2013-09-06 15:45:09', 2);
INSERT INTO `monitor` VALUES(58, 'servicio', 5, 'editar', '2013-09-06 15:54:24', 2);
INSERT INTO `monitor` VALUES(59, 'servicio', 5, 'editar', '2013-09-06 15:54:30', 2);
INSERT INTO `monitor` VALUES(60, 'usuario', 8, 'ficha', '2013-09-06 16:07:15', 2);
INSERT INTO `monitor` VALUES(61, 'usuario', 8, 'ficha', '2013-09-09 10:53:05', 2);
INSERT INTO `monitor` VALUES(62, 'tipo_habitacion', 0, 'crear', '2013-09-09 15:45:07', 2);
INSERT INTO `monitor` VALUES(63, 'tipo_habitacion', 0, 'crear', '2013-09-09 15:57:16', 2);
INSERT INTO `monitor` VALUES(64, 'tipo_habitacion', 0, 'crear', '2013-09-09 15:58:18', 2);
INSERT INTO `monitor` VALUES(65, 'tipo_habitacion', 0, 'crear', '2013-09-09 16:00:30', 2);
INSERT INTO `monitor` VALUES(66, 'tipo_habitacion', 0, 'crear', '2013-09-09 16:01:17', 2);
INSERT INTO `monitor` VALUES(67, 'tipo_habitacion', 0, 'crear', '2013-09-09 16:02:45', 2);
INSERT INTO `monitor` VALUES(68, 'tipo_habitacion', 0, 'crear', '2013-09-09 16:07:02', 2);
INSERT INTO `monitor` VALUES(69, 'tipo_habitacion', 0, 'crear', '2013-09-09 16:07:32', 2);
INSERT INTO `monitor` VALUES(70, 'tipo_habitacion', 0, 'crear', '2013-09-09 16:09:25', 2);
INSERT INTO `monitor` VALUES(71, 'tipo_habitacion', 3, 'editar', '2013-09-10 11:16:08', 2);
INSERT INTO `monitor` VALUES(72, 'tipo_habitacion', 3, 'editar', '2013-09-10 11:17:02', 2);
INSERT INTO `monitor` VALUES(73, 'tipo_habitacion', 3, 'editar', '2013-09-10 11:17:33', 2);
INSERT INTO `monitor` VALUES(74, 'tipo_habitacion', 3, 'editar', '2013-09-10 11:18:39', 2);
INSERT INTO `monitor` VALUES(75, 'tipo_habitacion', 3, 'editar', '2013-09-10 11:23:20', 2);
INSERT INTO `monitor` VALUES(76, 'tipo_habitacion', 3, 'editar', '2013-09-10 11:25:03', 2);
INSERT INTO `monitor` VALUES(77, 'tipo_habitacion', 3, 'editar', '2013-09-10 11:27:51', 2);
INSERT INTO `monitor` VALUES(78, 'tipo_habitacion', 3, 'editar', '2013-09-10 11:29:01', 2);
INSERT INTO `monitor` VALUES(79, 'tipo_habitacion', 3, 'editar', '2013-09-10 11:29:14', 2);
INSERT INTO `monitor` VALUES(80, 'tipo_habitacion', 3, 'editar', '2013-09-10 11:33:50', 2);
INSERT INTO `monitor` VALUES(81, 'tipo_habitacion', 3, 'editar', '2013-09-10 11:34:18', 2);
INSERT INTO `monitor` VALUES(82, 'tipo_habitacion', 3, 'editar', '2013-09-10 11:35:10', 2);
INSERT INTO `monitor` VALUES(83, 'tipo_habitacion', 0, 'crear', '2013-09-10 11:38:45', 2);
INSERT INTO `monitor` VALUES(84, 'tipo_habitacion', 0, 'crear', '2013-09-10 11:41:04', 2);
INSERT INTO `monitor` VALUES(85, 'tipo_habitacion', 0, 'crear', '2013-09-10 11:42:05', 2);
INSERT INTO `monitor` VALUES(86, 'tipo_habitacion', 0, 'crear', '2013-09-10 11:43:22', 2);
INSERT INTO `monitor` VALUES(87, 'tipo_habitacion', 0, 'crear', '2013-09-10 11:53:44', 2);
INSERT INTO `monitor` VALUES(88, 'tipo_habitacion', 13, 'editar', '2013-09-10 11:56:33', 2);
INSERT INTO `monitor` VALUES(89, 'tipo_habitacion', 13, 'editar', '2013-09-10 11:57:24', 2);
INSERT INTO `monitor` VALUES(90, 'tipo_habitacion', 13, 'editar', '2013-09-10 11:58:04', 2);
INSERT INTO `monitor` VALUES(91, 'tipo_habitacion', 13, 'editar', '2013-09-10 11:59:13', 2);
INSERT INTO `monitor` VALUES(92, 'tipo_habitacion', 13, 'editar', '2013-09-10 11:59:30', 2);
INSERT INTO `monitor` VALUES(93, 'tipo_habitacion', 13, 'editar', '2013-09-10 12:10:39', 2);
INSERT INTO `monitor` VALUES(94, 'tipo_habitacion', 0, 'crear', '2013-09-10 12:12:52', 2);
INSERT INTO `monitor` VALUES(95, 'tipo_habitacion', 14, 'editar', '2013-09-10 12:13:14', 2);
INSERT INTO `monitor` VALUES(96, 'tipo_habitacion', 0, 'crear', '2013-09-10 12:14:41', 2);
INSERT INTO `monitor` VALUES(97, 'tipo_habitacion', 15, 'editar', '2013-09-10 12:17:44', 2);
INSERT INTO `monitor` VALUES(98, 'tipo_habitacion', 15, 'editar', '2013-09-10 12:18:17', 2);
INSERT INTO `monitor` VALUES(99, 'tipo_habitacion', 15, 'editar', '2013-09-10 13:59:12', 2);
INSERT INTO `monitor` VALUES(100, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 14:00:12', 2);
INSERT INTO `monitor` VALUES(101, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 14:07:00', 2);
INSERT INTO `monitor` VALUES(102, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 14:07:13', 2);
INSERT INTO `monitor` VALUES(103, 'detalle_tipo_hab', 2, 'editar_idioma', '2013-09-10 14:08:24', 2);
INSERT INTO `monitor` VALUES(104, 'detalle_tipo_hab', 3, 'editar_idioma', '2013-09-10 14:12:31', 2);
INSERT INTO `monitor` VALUES(105, 'detalle_tipo_hab', 3, 'eliminar_idioma', '2013-09-10 14:12:47', 2);
INSERT INTO `monitor` VALUES(106, 'detalle_tipo_hab', 4, 'editar_idioma', '2013-09-10 14:18:47', 2);
INSERT INTO `monitor` VALUES(107, 'detalle_tipo_hab', 4, 'eliminar_idioma', '2013-09-10 14:18:52', 2);
INSERT INTO `monitor` VALUES(108, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 14:19:22', 2);
INSERT INTO `monitor` VALUES(109, 'detalle_tipo_hab', 5, 'editar_idioma', '2013-09-10 14:20:34', 2);
INSERT INTO `monitor` VALUES(110, 'detalle_tipo_hab', 6, 'editar_idioma', '2013-09-10 14:21:40', 2);
INSERT INTO `monitor` VALUES(111, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 14:22:16', 2);
INSERT INTO `monitor` VALUES(112, 'detalle_tipo_hab', 7, 'editar_idioma', '2013-09-10 14:22:38', 2);
INSERT INTO `monitor` VALUES(113, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 14:23:31', 2);
INSERT INTO `monitor` VALUES(114, 'detalle_tipo_hab', 8, 'editar_idioma', '2013-09-10 14:24:45', 2);
INSERT INTO `monitor` VALUES(115, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 14:28:38', 2);
INSERT INTO `monitor` VALUES(116, 'detalle_tipo_hab', 7, 'eliminar_idioma', '2013-09-10 14:29:40', 2);
INSERT INTO `monitor` VALUES(117, 'detalle_tipo_hab', 8, 'eliminar_idioma', '2013-09-10 14:29:43', 2);
INSERT INTO `monitor` VALUES(118, 'detalle_tipo_hab', 6, 'eliminar_idioma', '2013-09-10 14:29:45', 2);
INSERT INTO `monitor` VALUES(119, 'detalle_tipo_hab', 5, 'eliminar_idioma', '2013-09-10 14:29:47', 2);
INSERT INTO `monitor` VALUES(120, 'detalle_tipo_hab', 2, 'eliminar_idioma', '2013-09-10 14:29:49', 2);
INSERT INTO `monitor` VALUES(121, 'detalle_tipo_hab', 9, 'editar_idioma', '2013-09-10 14:39:59', 2);
INSERT INTO `monitor` VALUES(122, 'detalle_tipo_hab', 9, 'eliminar_idioma', '2013-09-10 14:40:09', 2);
INSERT INTO `monitor` VALUES(123, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 14:41:02', 2);
INSERT INTO `monitor` VALUES(124, 'detalle_tipo_hab', 10, 'editar_idioma', '2013-09-10 14:41:20', 2);
INSERT INTO `monitor` VALUES(125, 'detalle_tipo_hab', 10, 'eliminar_idioma', '2013-09-10 14:41:24', 2);
INSERT INTO `monitor` VALUES(126, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 14:51:17', 2);
INSERT INTO `monitor` VALUES(127, 'detalle_tipo_hab', 11, 'editar_idioma', '2013-09-10 14:51:44', 2);
INSERT INTO `monitor` VALUES(128, 'detalle_tipo_hab', 12, 'editar_idioma', '2013-09-10 14:53:28', 2);
INSERT INTO `monitor` VALUES(129, 'detalle_tipo_hab', 12, 'eliminar_idioma', '2013-09-10 14:53:37', 2);
INSERT INTO `monitor` VALUES(130, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 14:57:11', 2);
INSERT INTO `monitor` VALUES(131, 'detalle_tipo_hab', 13, 'editar_idioma', '2013-09-10 14:57:51', 2);
INSERT INTO `monitor` VALUES(132, 'tipo_habitacion', 0, 'crear', '2013-09-11 09:07:04', 2);
INSERT INTO `monitor` VALUES(133, 'detalle_tipo_hab', 14, 'editar_idioma', '2013-09-11 09:07:53', 2);
INSERT INTO `monitor` VALUES(134, 'habitacion', 0, 'crear', '2013-09-11 10:38:22', 2);
INSERT INTO `monitor` VALUES(135, 'habitacion', 0, 'crear', '2013-09-11 10:40:03', 2);
INSERT INTO `monitor` VALUES(136, 'habitacion', 0, 'crear', '2013-09-11 11:03:28', 2);
INSERT INTO `monitor` VALUES(137, 'habitacion', 0, 'crear', '2013-09-11 11:05:20', 2);
INSERT INTO `monitor` VALUES(138, 'habitacion', 0, 'crear', '2013-09-11 11:05:56', 2);
INSERT INTO `monitor` VALUES(139, 'habitacion', 5, 'editar', '2013-09-11 12:15:24', 2);
INSERT INTO `monitor` VALUES(140, 'detalle_habitaci', 1, 'editar_idioma', '2013-09-11 14:28:45', 2);
INSERT INTO `monitor` VALUES(141, 'detalle_habitaci', 2, 'editar_idioma', '2013-09-11 14:30:03', 2);
INSERT INTO `monitor` VALUES(142, 'detalle_habitaci', 3, 'editar_idioma', '2013-09-11 14:32:36', 2);
INSERT INTO `monitor` VALUES(143, 'habitacion', 5, 'editar', '2013-09-11 14:34:24', 2);
INSERT INTO `monitor` VALUES(144, 'habitacion', 4, 'editar', '2013-09-11 14:34:53', 2);
INSERT INTO `monitor` VALUES(145, 'detalle_habitaci', 4, 'editar_idioma', '2013-09-11 14:35:47', 2);
INSERT INTO `monitor` VALUES(146, 'detalle_habitaci', 5, 'editar_idioma', '2013-09-11 14:36:09', 2);
INSERT INTO `monitor` VALUES(147, 'detalle_habitaci', 6, 'editar_idioma', '2013-09-11 14:36:33', 2);
INSERT INTO `monitor` VALUES(148, 'detalle_habitaci', 7, 'editar_idioma', '2013-09-11 14:37:13', 2);
INSERT INTO `monitor` VALUES(149, 'detalle_habitaci', 4, 'editar_idioma', '2013-09-11 14:44:26', 2);
INSERT INTO `monitor` VALUES(150, 'detalle_servicio', 9, 'editar_idioma', '2013-09-19 15:17:08', 2);
INSERT INTO `monitor` VALUES(151, 'detalle_habitaci', 1, 'editar_idioma', '2013-09-19 15:22:04', 2);
INSERT INTO `monitor` VALUES(152, 'detalle_tipo_hab', 14, 'editar_idioma', '2013-09-19 15:25:29', 2);
INSERT INTO `monitor` VALUES(153, 'servicio', 0, 'crear', '2013-09-20 10:58:06', 2);
INSERT INTO `monitor` VALUES(154, 'detalle_servicio', 10, 'editar_idioma', '2013-09-20 11:00:37', 2);
INSERT INTO `monitor` VALUES(155, 'servicio', 0, 'crear', '2013-09-20 11:05:46', 2);
INSERT INTO `monitor` VALUES(156, 'detalle_servicio', 11, 'editar_idioma', '2013-09-20 11:06:56', 2);
INSERT INTO `monitor` VALUES(157, 'servicio', 0, 'crear', '2013-09-20 11:11:37', 2);
INSERT INTO `monitor` VALUES(158, 'detalle_servicio', 12, 'editar_idioma', '2013-09-20 11:13:22', 2);
INSERT INTO `monitor` VALUES(159, 'servicio', 0, 'crear', '2013-09-20 11:26:40', 2);
INSERT INTO `monitor` VALUES(160, 'detalle_servicio', 13, 'editar_idioma', '2013-09-20 11:27:36', 2);
INSERT INTO `monitor` VALUES(161, 'detalle_servicio', 13, 'editar_idioma', '2013-09-20 11:30:50', 2);
INSERT INTO `monitor` VALUES(162, 'detalle_servicio', 9, 'editar_idioma', '2013-09-24 14:22:52', 2);
INSERT INTO `monitor` VALUES(163, 'tipo_habitacion', 15, 'editar', '2013-10-22 13:53:50', 2);
INSERT INTO `monitor` VALUES(164, 'tipo_habitacion', 0, 'crear', '2013-10-22 14:58:55', 2);
INSERT INTO `monitor` VALUES(165, 'detalle_tipo_hab', 15, 'editar_idioma', '2013-10-22 15:04:24', 2);
INSERT INTO `monitor` VALUES(166, 'habitacion', 0, 'crear', '2013-10-22 15:04:42', 2);
INSERT INTO `monitor` VALUES(167, 'habitacion', 0, 'crear', '2013-10-22 15:23:32', 2);
INSERT INTO `monitor` VALUES(168, 'detalle_habitaci', 8, 'editar_idioma', '2013-10-22 15:24:07', 2);
INSERT INTO `monitor` VALUES(169, 'habitacion', 6, 'editar', '2013-10-22 15:24:29', 2);
INSERT INTO `monitor` VALUES(170, 'detalle_habitaci', 4, 'eliminar_idioma', '2013-10-23 14:00:21', 2);
INSERT INTO `monitor` VALUES(171, 'detalle_tipo_hab', 16, 'editar_idioma', '2013-10-23 14:08:30', 2);
INSERT INTO `monitor` VALUES(172, 'detalle_tipo_hab', 14, 'eliminar_idioma', '2013-10-23 14:08:33', 2);
INSERT INTO `monitor` VALUES(173, 'habitacion', 0, 'crear', '2013-10-24 11:20:06', 2);
INSERT INTO `monitor` VALUES(174, 'habitacion', 0, 'crear', '2013-10-24 11:20:45', 2);
INSERT INTO `monitor` VALUES(175, 'habitacion', 0, 'crear', '2013-10-24 11:21:05', 2);
INSERT INTO `monitor` VALUES(176, 'habitacion', 0, 'crear', '2013-10-24 11:21:43', 2);
INSERT INTO `monitor` VALUES(177, 'habitacion', 0, 'crear', '2013-10-24 11:22:35', 2);
INSERT INTO `monitor` VALUES(178, 'habitacion', 0, 'crear', '2013-10-24 11:23:17', 2);
INSERT INTO `monitor` VALUES(179, 'habitacion', 0, 'crear', '2013-10-24 11:23:30', 2);
INSERT INTO `monitor` VALUES(180, 'habitacion', 0, 'crear', '2013-10-24 11:25:40', 2);
INSERT INTO `monitor` VALUES(181, 'habitacion', 0, 'crear', '2013-10-24 11:25:42', 2);
INSERT INTO `monitor` VALUES(182, 'habitacion', 0, 'crear', '2013-10-24 11:25:53', 2);
INSERT INTO `monitor` VALUES(183, 'habitacion', 6, 'editar', '2013-10-24 11:26:11', 2);
INSERT INTO `monitor` VALUES(184, 'habitacion', 6, 'editar', '2013-10-24 11:27:37', 2);
INSERT INTO `monitor` VALUES(185, 'habitacion', 5, 'editar', '2013-10-24 11:32:21', 2);
INSERT INTO `monitor` VALUES(186, 'habitacion', 4, 'editar', '2013-10-24 11:32:35', 2);
INSERT INTO `monitor` VALUES(187, 'tipo_habitacion', 0, 'crear', '2013-10-28 10:11:05', 2);
INSERT INTO `monitor` VALUES(188, 'tipo_habitacion', 0, 'crear', '2013-10-28 10:11:48', 2);
INSERT INTO `monitor` VALUES(189, 'tipo_habitacion', 0, 'crear', '2013-10-28 10:12:05', 2);
INSERT INTO `monitor` VALUES(190, 'tipo_habitacion', 0, 'crear', '2013-10-28 10:12:38', 2);
INSERT INTO `monitor` VALUES(191, 'tipo_habitacion', 0, 'crear', '2013-10-28 10:13:21', 2);
INSERT INTO `monitor` VALUES(192, 'tipo_habitacion', 0, 'crear', '2013-10-28 10:13:25', 2);
INSERT INTO `monitor` VALUES(193, 'tipo_habitacion', 0, 'crear', '2013-10-28 10:13:46', 2);
INSERT INTO `monitor` VALUES(194, 'tipo_habitacion', 18, 'editar', '2013-10-28 10:14:01', 2);
INSERT INTO `monitor` VALUES(195, 'tipo_habitacion', 15, 'editar', '2013-10-28 13:35:39', 2);
INSERT INTO `monitor` VALUES(196, 'tipo_habitacion', 17, 'editar', '2013-10-28 13:35:55', 2);
INSERT INTO `monitor` VALUES(197, 'tipo_habitacion', 16, 'editar', '2013-10-28 13:36:12', 2);
INSERT INTO `monitor` VALUES(198, 'detalle_tipo_hab', 17, 'editar_idioma', '2013-10-28 16:27:39', 2);
INSERT INTO `monitor` VALUES(199, 'detalle_tipo_hab', 17, 'editar_idioma', '2013-10-29 09:20:59', 2);
INSERT INTO `monitor` VALUES(200, 'detalle_tipo_hab', 17, 'editar_idioma', '2013-10-29 09:41:56', 2);
INSERT INTO `monitor` VALUES(201, 'detalle_tipo_hab', 17, 'editar_idioma', '2013-10-29 10:02:37', 2);
INSERT INTO `monitor` VALUES(202, 'detalle_tipo_hab', 18, 'editar_idioma', '2013-10-29 10:12:57', 2);
INSERT INTO `monitor` VALUES(203, 'tipo_habitacion', 0, 'crear', '2013-10-29 10:44:31', 2);
INSERT INTO `monitor` VALUES(204, 'detalle_tipo_hab', 19, 'editar_idioma', '2013-10-29 10:47:12', 2);
INSERT INTO `monitor` VALUES(205, 'detalle_tipo_hab', 20, 'editar_idioma', '2013-10-29 10:48:47', 2);
INSERT INTO `monitor` VALUES(206, 'detalle_tipo_hab', 20, 'eliminar_idioma', '2013-10-29 11:11:37', 2);
INSERT INTO `monitor` VALUES(207, 'detalle_tipo_hab', 20, 'eliminar_idioma', '2013-10-29 11:15:44', 2);
INSERT INTO `monitor` VALUES(208, 'detalle_tipo_hab', 20, 'eliminar_idioma', '2013-10-29 11:16:49', 2);
INSERT INTO `monitor` VALUES(209, 'detalle_tipo_hab', 19, 'eliminar_idioma', '2013-10-29 11:16:54', 2);
INSERT INTO `monitor` VALUES(210, 'detalle_tipo_hab', 21, 'editar_idioma', '2013-10-29 11:20:21', 2);
INSERT INTO `monitor` VALUES(211, 'detalle_tipo_hab', 22, 'editar_idioma', '2013-10-29 11:21:03', 2);
INSERT INTO `monitor` VALUES(212, 'detalle_tipo_hab', 22, 'eliminar_idioma', '2013-10-29 11:21:26', 2);
INSERT INTO `monitor` VALUES(213, 'detalle_tipo_hab', 21, 'eliminar_idioma', '2013-10-29 11:21:29', 2);
INSERT INTO `monitor` VALUES(214, 'detalle_tipo_hab', 23, 'editar_idioma', '2013-10-29 11:22:19', 2);
INSERT INTO `monitor` VALUES(215, 'detalle_tipo_hab', 24, 'editar_idioma', '2013-10-29 11:22:57', 2);
INSERT INTO `monitor` VALUES(216, 'detalle_tipo_hab', 24, 'eliminar_idioma', '2013-10-29 11:34:12', 2);
INSERT INTO `monitor` VALUES(217, 'detalle_tipo_hab', 23, 'eliminar_idioma', '2013-10-29 11:34:16', 2);
INSERT INTO `monitor` VALUES(218, 'detalle_tipo_hab', 25, 'editar_idioma', '2013-10-29 11:36:04', 2);
INSERT INTO `monitor` VALUES(219, 'detalle_tipo_hab', 25, 'editar_idioma', '2013-10-29 11:36:37', 2);
INSERT INTO `monitor` VALUES(220, 'detalle_tipo_hab', 26, 'editar_idioma', '2013-10-29 11:36:49', 2);
INSERT INTO `monitor` VALUES(221, 'detalle_tipo_hab', 25, 'eliminar_idioma', '2013-10-29 11:36:52', 2);
INSERT INTO `monitor` VALUES(222, 'detalle_tipo_hab', 26, 'editar_idioma', '2013-10-29 11:37:07', 2);
INSERT INTO `monitor` VALUES(223, 'detalle_tipo_hab', 27, 'editar_idioma', '2013-10-29 11:39:20', 2);
INSERT INTO `monitor` VALUES(224, 'detalle_tipo_hab', 26, 'editar_idioma', '2013-10-29 11:39:41', 2);
INSERT INTO `monitor` VALUES(225, 'detalle_tipo_hab', 27, 'eliminar_idioma', '2013-10-29 11:41:02', 2);
INSERT INTO `monitor` VALUES(226, 'detalle_tipo_hab', 26, 'eliminar_idioma', '2013-10-29 11:41:06', 2);
INSERT INTO `monitor` VALUES(227, 'detalle_tipo_hab', 28, 'editar_idioma', '2013-10-29 11:42:18', 2);
INSERT INTO `monitor` VALUES(228, 'detalle_tipo_hab', 29, 'editar_idioma', '2013-10-29 11:42:55', 2);
INSERT INTO `monitor` VALUES(229, 'detalle_tipo_hab', 29, 'eliminar_idioma', '2013-10-29 12:00:22', 2);
INSERT INTO `monitor` VALUES(230, 'detalle_tipo_hab', 28, 'eliminar_idioma', '2013-10-29 12:00:26', 2);
INSERT INTO `monitor` VALUES(231, 'detalle_tipo_hab', 30, 'editar_idioma', '2013-10-29 13:37:01', 2);
INSERT INTO `monitor` VALUES(232, 'detalle_tipo_hab', 31, 'editar_idioma', '2013-10-29 13:38:14', 2);
INSERT INTO `monitor` VALUES(233, 'detalle_tipo_hab', 31, 'editar_idioma', '2013-10-29 14:05:34', 2);
INSERT INTO `monitor` VALUES(234, 'detalle_tipo_hab', 30, 'eliminar_idioma', '2013-10-29 14:05:49', 2);
INSERT INTO `monitor` VALUES(235, 'detalle_tipo_hab', 31, 'eliminar_idioma', '2013-10-29 14:05:52', 2);
INSERT INTO `monitor` VALUES(236, 'banner', 0, 'crear', '2013-10-29 15:00:53', 2);
INSERT INTO `monitor` VALUES(237, 'banner', 2, 'editar', '2013-10-29 15:01:10', 2);
INSERT INTO `monitor` VALUES(238, 'servicio', 0, 'crear', '2013-10-29 15:04:44', 2);
INSERT INTO `monitor` VALUES(239, 'detalle_servicio', 14, 'editar_idioma', '2013-10-29 15:05:27', 2);
INSERT INTO `monitor` VALUES(240, 'detalle_servicio', 15, 'editar_idioma', '2013-10-29 15:07:17', 2);
INSERT INTO `monitor` VALUES(241, 'detalle_servicio', 15, 'eliminar_idioma', '2013-10-29 15:07:56', 2);
INSERT INTO `monitor` VALUES(242, 'servicio', 10, 'ficha', '2013-10-29 15:07:56', 2);
INSERT INTO `monitor` VALUES(243, 'detalle_servicio', 14, 'eliminar_idioma', '2013-10-29 15:08:29', 2);
INSERT INTO `monitor` VALUES(244, 'servicio', 10, 'ficha', '2013-10-29 15:08:30', 2);
INSERT INTO `monitor` VALUES(245, 'tipo_habitacion', 0, 'crear', '2013-10-29 15:45:57', 2);
INSERT INTO `monitor` VALUES(246, 'detalle_tipo_hab', 32, 'editar_idioma', '2013-10-29 15:46:36', 2);
INSERT INTO `monitor` VALUES(247, 'detalle_tipo_hab', 33, 'editar_idioma', '2013-10-29 15:47:18', 2);
INSERT INTO `monitor` VALUES(248, 'detalle_tipo_hab', 33, 'eliminar_idioma', '2013-10-29 15:47:34', 2);
INSERT INTO `monitor` VALUES(249, 'detalle_tipo_hab', 32, 'eliminar_idioma', '2013-10-29 15:47:37', 2);
INSERT INTO `monitor` VALUES(250, 'banner', 2, 'borrar', '2013-10-29 15:51:02', 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=68 ;

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
INSERT INTO `multimedia` VALUES(35, 0, '3582940714_banner_one.jpg', 1, 1, '0000-00-00 00:00:00', '2013-09-05 13:42:53', 2);
INSERT INTO `multimedia` VALUES(41, 1, '4193004010_Posad_4.jpg', 1, 1, '0000-00-00 00:00:00', '2013-09-11 14:27:31', 2);
INSERT INTO `multimedia` VALUES(42, 1, '421694150_Posad_3.jpg', 1, 1, '0000-00-00 00:00:00', '2013-09-11 14:35:10', 2);
INSERT INTO `multimedia` VALUES(62, 1, '6223535808_solylunaservicios-06.png', 1, 1, '0000-00-00 00:00:00', '2013-10-02 14:55:49', 2);
INSERT INTO `multimedia` VALUES(63, 1, '6348039535_solylunaservicios-05.png', 1, 1, '0000-00-00 00:00:00', '2013-10-02 14:56:54', 2);
INSERT INTO `multimedia` VALUES(64, 1, '6493388531_solylunaservicios-04.png', 1, 1, '0000-00-00 00:00:00', '2013-10-02 14:57:17', 2);
INSERT INTO `multimedia` VALUES(65, 1, '6586145042_solylunaservicios-03.png', 1, 1, '0000-00-00 00:00:00', '2013-10-02 14:57:33', 2);
INSERT INTO `multimedia` VALUES(66, 1, '6686765158_solylunaservicios-02.png', 1, 1, '0000-00-00 00:00:00', '2013-10-02 14:57:59', 2);
INSERT INTO `multimedia` VALUES(67, 1, '6734237225_solylunaservicios-01.png', 1, 1, '0000-00-00 00:00:00', '2013-10-02 14:58:17', 2);

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

INSERT INTO `rel_banner_multimedia` VALUES(1, 35);

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

INSERT INTO `rel_habitacion_multimedia` VALUES(5, 41);
INSERT INTO `rel_habitacion_multimedia` VALUES(4, 42);

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
-- Table structure for table `rel_servicio_multimedia`
--

CREATE TABLE `rel_servicio_multimedia` (
  `id_servicio` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  PRIMARY KEY (`id_servicio`,`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rel_servicio_multimedia`
--

INSERT INTO `rel_servicio_multimedia` VALUES(1, 67);
INSERT INTO `rel_servicio_multimedia` VALUES(5, 66);
INSERT INTO `rel_servicio_multimedia` VALUES(6, 65);
INSERT INTO `rel_servicio_multimedia` VALUES(7, 64);
INSERT INTO `rel_servicio_multimedia` VALUES(8, 63);
INSERT INTO `rel_servicio_multimedia` VALUES(9, 62);

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
  `id_estado_reservacion` bigint(20) unsigned DEFAULT NULL,
  `id_estado_activo` bigint(20) unsigned DEFAULT NULL,
  `id_tipo_forma_pago` bigint(20) unsigned DEFAULT NULL,
  `id_usuario_front` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_reservacion`),
  KEY `id_estado_activo` (`id_estado_activo`),
  KEY `id_tipo_forma_pago` (`id_tipo_forma_pago`),
  KEY `id_usuario_front` (`id_usuario_front`),
  KEY `id_estado_reservacion` (`id_estado_reservacion`)
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
-- Table structure for table `servicio`
--

CREATE TABLE `servicio` (
  `id_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_servicio` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_servicio`),
  KEY `id_estado` (`id_estado`),
  KEY `id_tipo_servicio` (`id_tipo_servicio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `servicio`
--

INSERT INTO `servicio` VALUES(1, 4, 1, 0);
INSERT INTO `servicio` VALUES(5, 4, 1, 0);
INSERT INTO `servicio` VALUES(6, 4, 1, 0);
INSERT INTO `servicio` VALUES(7, 2, 1, 0);
INSERT INTO `servicio` VALUES(8, 2, 1, 0);
INSERT INTO `servicio` VALUES(9, 5, 1, 0);

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

INSERT INTO `temporada` VALUES(1, 'Baja');
INSERT INTO `temporada` VALUES(2, 'Alta');

-- --------------------------------------------------------

--
-- Table structure for table `temporada_fecha`
--

CREATE TABLE `temporada_fecha` (
  `id_temporada_fecha` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  `id_temporada` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_temporada_fecha`),
  KEY `id_temporada` (`id_temporada`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `temporada_fecha`
--

INSERT INTO `temporada_fecha` VALUES(1, '2013-01-11', '2013-07-14', 2);
INSERT INTO `temporada_fecha` VALUES(2, '2012-12-15', '2013-01-10', 1);
INSERT INTO `temporada_fecha` VALUES(3, '2013-01-11', '2013-07-14', 2);
INSERT INTO `temporada_fecha` VALUES(4, '2013-07-15', '2013-09-15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `testimonio`
--

CREATE TABLE `testimonio` (
  `id_testimonio` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `comentario` text NOT NULL,
  `rating` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_testimonio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `testimonio`
--

INSERT INTO `testimonio` VALUES(1, 'Hector Jose Flores Colmenarez', 'hecto932@gmail.com', 'Esto es un testimonio de prueba para el dyndns.', 3, NULL, '2013-09-27 14:51:33');
INSERT INTO `testimonio` VALUES(2, 'Oriana Ruiz', 'oruiz92@gmail.com', 'Mensaje de Prueba', 5, NULL, '2013-09-27 20:56:17');
INSERT INTO `testimonio` VALUES(3, 'carlos délgado', 'cd.nsce@gmail.com', 'esta pagina me parece mejor que la pasta dental y cepillarme', 1, NULL, '2013-09-30 14:18:38');
INSERT INTO `testimonio` VALUES(4, 'Hector Jose Flores Colmenarez', 'hecto932@gmail.com', 'asdiahsdhasiudhasiudhasiudhasiudhsi', 1, NULL, '2013-09-30 14:19:04');
INSERT INTO `testimonio` VALUES(5, 'no se', 'nathohno@gmail.com', 'LLEGO EL SEÑOR QUE ME DA MIEDOO', 5, NULL, '2013-09-30 14:19:36');
INSERT INTO `testimonio` VALUES(6, 'carlos délgado', 'carlosjmdelgado@gmail.com', 'hecto932 ha contraido nupcias con DYNDNS', 1, NULL, '2013-09-30 14:23:47');
INSERT INTO `testimonio` VALUES(7, 'Hugo Chávez', 'Chiabevive@yahoo.es', 'AYUDENME ESTOY ATRAPADO EN EL SOTANO DE MIRAFLORES, ME FUI AL BAÑO QUE TIENE EL SOTANO Y SE ME OLVIDO BUSCAR LA LLAVE. \n\n#TROPA AYUDENME; TAMBIEN SE ME ACABO EL PAPEL', 4, NULL, '2013-10-18 23:28:19');
INSERT INTO `testimonio` VALUES(8, 'Hugo Chávez', 'Chiabevive@yahoo.es', 'AYUDENME ESTOY ATRAPADO EN EL SOTANO DE MIRAFLORES, ME FUI AL BAÑO QUE TIENE EL SOTANO Y SE ME OLVIDO BUSCAR LA LLAVE. \n\n#TROPA AYUDENME; TAMBIEN SE ME ACABO EL PAPEL', 4, NULL, '2013-10-18 23:28:42');

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
  `personas` int(11) DEFAULT NULL,
  `id_estado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_tipo_habitacion`),
  KEY `id_estado` (`id_estado`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `tipo_habitacion`
--

INSERT INTO `tipo_habitacion` VALUES(15, 2, 1, 2);
INSERT INTO `tipo_habitacion` VALUES(16, 4, 1, 2);
INSERT INTO `tipo_habitacion` VALUES(17, 1, 1, 2);

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
-- Table structure for table `tipo_servicio`
--

CREATE TABLE `tipo_servicio` (
  `id_tipo_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tipo` varchar(75) NOT NULL,
  PRIMARY KEY (`id_tipo_servicio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tipo_servicio`
--

INSERT INTO `tipo_servicio` VALUES(1, 'hospedaje');
INSERT INTO `tipo_servicio` VALUES(2, 'actividad');
INSERT INTO `tipo_servicio` VALUES(3, 'gastronomia');
INSERT INTO `tipo_servicio` VALUES(4, 'promocional');
INSERT INTO `tipo_servicio` VALUES(5, 'transporte');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` VALUES('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrador', 'admin', 'admin@admin.com', 2, 1, '2010-06-30', '', 2);
INSERT INTO `usuario` VALUES('', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Marioxy', 'Lobo', 'mary@mary.com', 4, 1, '2013-09-05', '0', 2);
INSERT INTO `usuario` VALUES('', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Pedro', 'Camejo', 'pedro@pedro.com', 5, 1, '2013-09-05', '0', 1);
INSERT INTO `usuario` VALUES('', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Gerardo', 'Chemello', 'gchemello@gmail.com', 6, 1, '2013-09-05', '0', 1);
INSERT INTO `usuario` VALUES('', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Fernando', 'Pinto', 'pinto@pinto.com', 7, 1, '2013-09-05', '0', 1);
INSERT INTO `usuario` VALUES('', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Hector', 'Flores', 'hecto932@gmail.com', 8, 1, '2013-09-05', '0', 1);

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
  ADD CONSTRAINT `costo_ibfk_6` FOREIGN KEY (`id_detalle_tipo_habitacion`) REFERENCES `detalle_tipo_habitacion` (`id_detalle_tipo_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `costo_ibfk_4` FOREIGN KEY (`id_moneda`) REFERENCES `moneda` (`id_moneda`),
  ADD CONSTRAINT `costo_ibfk_5` FOREIGN KEY (`id_temporada`) REFERENCES `temporada` (`id_temporada`);

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
-- Constraints for table `detalle_habitacion`
--
ALTER TABLE `detalle_habitacion`
  ADD CONSTRAINT `detalle_habitacion_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`),
  ADD CONSTRAINT `detalle_habitacion_ibfk_2` FOREIGN KEY (`id_habitacion`) REFERENCES `habitacion` (`id_habitacion`);

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
-- Constraints for table `detalle_servicio`
--
ALTER TABLE `detalle_servicio`
  ADD CONSTRAINT `detalle_servicio_ibfk_5` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_servicio_ibfk_6` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `detalle_tipo_habitacion`
--
ALTER TABLE `detalle_tipo_habitacion`
  ADD CONSTRAINT `detalle_tipo_habitacion_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_tipo_habitacion_ibfk_2` FOREIGN KEY (`id_tipo_habitacion`) REFERENCES `tipo_habitacion` (`id_tipo_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `habitacion`
--
ALTER TABLE `habitacion`
  ADD CONSTRAINT `fk_habitacion_tipo_habitacion1` FOREIGN KEY (`id_tipo_habitacion`) REFERENCES `tipo_habitacion` (`id_tipo_habitacion`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `habitacion_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `habitacion_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `moneda`
--
ALTER TABLE `moneda`
  ADD CONSTRAINT `moneda_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `reservacion_ibfk_3` FOREIGN KEY (`id_estado_activo`) REFERENCES `estado_activo` (`id_estado_activo`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reservacion_ibfk_4` FOREIGN KEY (`id_estado_reservacion`) REFERENCES `estado_reservacion` (`id_estado_reservacion`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `reservacion_habitacion`
--
ALTER TABLE `reservacion_habitacion`
  ADD CONSTRAINT `fk_reservacion_has_habitacion_habitacion1` FOREIGN KEY (`id_habitacion`) REFERENCES `habitacion` (`id_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservacion_has_habitacion_reservacion1` FOREIGN KEY (`id_reservacion`) REFERENCES `reservacion` (`id_reservacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `servicio_ibfk_1` FOREIGN KEY (`id_tipo_servicio`) REFERENCES `tipo_servicio` (`id_tipo_servicio`) ON UPDATE CASCADE,
  ADD CONSTRAINT `servicio_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON UPDATE CASCADE;

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
-- Constraints for table `temporada_fecha`
--
ALTER TABLE `temporada_fecha`
  ADD CONSTRAINT `temporada_fecha_ibfk_1` FOREIGN KEY (`id_temporada`) REFERENCES `temporada` (`id_temporada`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tipo_habitacion`
--
ALTER TABLE `tipo_habitacion`
  ADD CONSTRAINT `tipo_habitacion_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `tipo_habitacion_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_estado_usuario`) REFERENCES `estado_usuario` (`id_estado_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;
