-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 29, 2013 at 03:45 PM
-- Server version: 5.5.24
-- PHP Version: 5.3.10-1ubuntu3.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


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

CREATE TABLE IF NOT EXISTS `banner` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=2 ;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id_banner`, `id_estado`, `id_usuario`, `creado`, `modificado`, `destacado`, `enlace`, `fichero`, `slider`) VALUES
(1, 1, 0, '2013-09-05 00:00:00', '2013-09-05 14:51:09', 0, '1', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
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

-- --------------------------------------------------------

--
-- Table structure for table `contacto`
--

CREATE TABLE IF NOT EXISTS `contacto` (
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

-- --------------------------------------------------------

--
-- Table structure for table `costo`
--

CREATE TABLE IF NOT EXISTS `costo` (
  `id_costo` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `valor` double NOT NULL,
  `id_moneda` bigint(20) unsigned NOT NULL,
  `id_temporada` bigint(20) unsigned NOT NULL,
  `id_tipo_habitacion` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id_costo`),
  KEY `fk_costo_moneda1` (`id_moneda`),
  KEY `fk_costo_temporada1` (`id_temporada`),
  KEY `fk_costo_tipo_habitacion1` (`id_tipo_habitacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=107 ;

--
-- Dumping data for table `costo`
--

INSERT INTO `costo` (`id_costo`, `valor`, `id_moneda`, `id_temporada`, `id_tipo_habitacion`) VALUES
(70, 100, 1, 1, 13),
(71, 200, 1, 2, 13),
(72, 300, 2, 1, 13),
(73, 400, 2, 2, 13),
(74, 500, 3, 1, 13),
(75, 600, 3, 2, 13),
(81, 105, 1, 1, 14),
(82, 205, 1, 2, 14),
(83, 305, 2, 1, 14),
(84, 405, 2, 2, 14),
(85, 505, 3, 1, 14),
(86, 605, 3, 2, 14),
(97, 3000, 2, 1, 15),
(98, 4000, 2, 2, 15),
(99, 5000, 3, 1, 15),
(100, 6000, 3, 2, 15),
(101, 100, 1, 1, 16),
(102, 200, 1, 2, 16),
(103, 300, 2, 1, 16),
(104, 400, 2, 2, 16),
(105, 500, 3, 1, 16),
(106, 600, 3, 2, 16);

-- --------------------------------------------------------

--
-- Table structure for table `detalle_banner`
--

CREATE TABLE IF NOT EXISTS `detalle_banner` (
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

-- --------------------------------------------------------

--
-- Table structure for table `detalle_categoria`
--

CREATE TABLE IF NOT EXISTS `detalle_categoria` (
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

-- --------------------------------------------------------

--
-- Table structure for table `detalle_habitacion`
--

CREATE TABLE IF NOT EXISTS `detalle_habitacion` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `detalle_habitacion`
--

INSERT INTO `detalle_habitacion` (`id_detalle_habitacion`, `id_habitacion`, `id_idioma`, `url`, `nombre`, `subtitulo`, `descripcion_breve`, `descripcion_ampliada`, `descripcion_pagina`, `keywords`, `titulo_pagina`) VALUES
(1, 5, 1, 'habitacin-para-dos-personas', 'Habitación para dos personas', 'Habitación para dos personas', 'Cómoda habitación para dos personas', '<p>C&oacute;moda habitaci&oacute;n para dos personas</p>\n', 'Habitación para dos personas', 'Habitación para dos personas', 'Habitación para dos personas'),
(2, 5, 3, 'chambre-confortable-pour-deux-personnes', 'Chambre confortable pour deux personnes', 'Chambre confortable pour deux personnes', 'Chambre confortable pour deux personnes', '<p><span class="short_text" id="result_box" lang="fr"><span class="hps">Chambre</span> <span class="hps">confortable pour deux personnes</span></span></p>\n', 'Chambre confortable pour deux personnes', 'Chambre confortable pour deux personnes', 'Chambre confortable pour deux personnes'),
(3, 5, 5, 'confortevole-camera-per-due-persone', 'Confortevole camera per due persone', 'Confortevole camera per due persone', 'Confortevole camera per due persone', '<p><span class="short_text" id="result_box" lang="it"><span class="hps">Confortevole camera</span> <span class="hps">per due</span> <span class="hps">persone</span></span></p>\n', 'Confortevole camera per due persone', 'Confortevole camera per due persone', 'Confortevole camera per due persone'),
(4, 4, 1, 'cmoda-habitacin-para-cuatro-personas', 'Cómoda habitación para cuatro personas', 'Cómoda habitación para cuatro personas', 'Cómoda habitación para cuatro personas', '<p><br />\nC&oacute;moda habitaci&oacute;n para cuatro personas...</p>\n', 'Cómoda habitación para cuatro personas', 'Cómoda habitación para cuatro personas', 'Cómoda habitación para cuatro personas'),
(5, 4, 5, 'camera-confortevole-per-quattro-persone', 'Camera confortevole per quattro persone', 'Camera confortevole per quattro persone', 'Camera confortevole per quattro persone', '<p><br />\n<span class="short_text" id="result_box" lang="it"><span class="hps">Camera confortevole</span> <span class="hps">per quattro persone</span></span></p>\n', 'Camera confortevole per quattro persone', 'Camera confortevole per quattro persone', 'Camera confortevole per quattro persone'),
(6, 4, 3, 'chambre-confortable-pour-quatre-personnes', 'Chambre confortable pour quatre personnes', 'Chambre confortable pour quatre personnes', 'Chambre confortable pour quatre personnes', '<p><br />\n<span class="short_text" id="result_box" lang="fr"><span class="hps">Chambre confortable pour</span> <span class="hps">quatre personnes</span></span></p>\n', 'Chambre confortable pour quatre personnes', 'Chambre confortable pour quatre personnes', 'Chambre confortable pour quatre personnes'),
(7, 4, 2, 'comfortable-room-for-four-people', 'Comfortable room for four people', 'Comfortable room for four people', 'Comfortable room for four people', '<p><span class="short_text" id="result_box" lang="en"><span class="hps">Comfortable room for</span> <span class="hps">four people</span></span></p>\n', 'Comfortable room for four people', 'Comfortable room for four people', 'Comfortable room for four people');

-- --------------------------------------------------------

--
-- Table structure for table `detalle_multimedia`
--

CREATE TABLE IF NOT EXISTS `detalle_multimedia` (
  `id_detalle_multimedia` int(11) NOT NULL AUTO_INCREMENT,
  `id_multimedia` int(11) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `id_idioma` int(11) NOT NULL,
  `descripcion_multimedia` text NOT NULL,
  PRIMARY KEY (`id_detalle_multimedia`),
  KEY `id_multimedia` (`id_multimedia`),
  KEY `id_idioma` (`id_idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_noticia`
--

CREATE TABLE IF NOT EXISTS `detalle_noticia` (
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

-- --------------------------------------------------------

--
-- Table structure for table `detalle_producto`
--

CREATE TABLE IF NOT EXISTS `detalle_producto` (
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

-- --------------------------------------------------------

--
-- Table structure for table `detalle_promocion`
--

CREATE TABLE IF NOT EXISTS `detalle_promocion` (
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

-- --------------------------------------------------------

--
-- Table structure for table `detalle_receta`
--

CREATE TABLE IF NOT EXISTS `detalle_receta` (
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

-- --------------------------------------------------------

--
-- Table structure for table `detalle_servicio`
--

CREATE TABLE IF NOT EXISTS `detalle_servicio` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `detalle_servicio`
--

INSERT INTO `detalle_servicio` (`id_detalle_servicio`, `id_servicio`, `id_idioma`, `url`, `nombre`, `subtitulo`, `descripcion_breve`, `descripcion_ampliada`, `descripcion_pagina`, `keywords`, `titulo_pagina`) VALUES
(2, 1, 1, 'pensin-completa', 'Pensión Completa', 'Pensión Completa', 'Rico desayuno internacional, merienda para la playa preparada en una cava cooler con hielo, diferente cada día y una exquisita y acogedora cena.', '<p>Rico desayuno internacional, merienda para la playa preparada en una cava cooler con hielo (Agua Mineral, Refrescos, Galletas, Frutas, Almuerzo fr&iacute;o tipo lunch) diferente cada d&iacute;a y una exquisita y acogedora cena.</p>\n', 'Pensión Completa', 'Pensión Completa', 'Pensión Completa'),
(3, 1, 2, 'full-guesthouse', 'Full Guesthouse', 'Full Guesthouse', 'International breakfast, snack for the beach prepared in a cooler with ice cava, different every day and an exquisite and cozy dinner.', '<p><span id="result_box" lang="en"><span class="hps">Rico</span> <span class="hps">international breakfast</span><span>,</span> <span class="hps">snack</span> <span class="hps">for the beach</span> <span class="hps">prepared in a</span> <span class="hps">cooler</span> <span class="hps">with ice</span> <span class="hps">cava</span></span><span lang="en">&nbsp;<span class="hps atn">(</span><span>Mineral</span> <span class="hps">Water</span><span>, Soft Drinks</span><span>,</span> <span class="hps">Cookies,</span> <span class="hps">Fruit</span><span>, Lunch</span> <span class="hps">lunch</span> <span class="hps">cold</span> <span class="hps">type</span><span>)</span> <span class="hps">different every day and</span> <span class="hps">an exquisite and</span> <span class="hps">cozy</span> <span class="hps">dinner</span><span>.</span></span></p>\n', 'Full Guesthouse', 'Full Guesthouse', 'Full Guesthouse'),
(4, 1, 3, 'pension-complte', 'Pension complète', 'Pension complète', 'Petit-déjeuner international, un snack prêt pour la plage dans un refroidisseur de vin de glace.', '<p><span id="result_box" lang="fr"><span class="hps">Petit-d&eacute;jeuner international</span><span>, un snack</span> <span class="hps">pr&ecirc;t pour la plage</span> <span class="hps">dans un refroidisseur</span> <span class="hps">de vin de glace</span> <span class="hps atn">(</span><span>eau min&eacute;rale</span><span>, boissons gazeuses,</span> <span class="hps">biscuits</span><span>, fruits,</span> <span class="hps">d&eacute;jeuner</span> <span class="hps">lunch</span> <span class="hps">froid de type</span><span>)</span> <span class="hps">diff&eacute;rent chaque jour</span> <span class="hps">et</span> <span class="hps">un d&icirc;ner exquis</span> <span class="hps">et confortable.</span></span></p>\n', 'Pension complète', 'Pension complète', 'Pension complète'),
(5, 1, 5, 'pensione-completa', 'Pensione completa', 'Pensione completa', 'Colazione internazionale, spuntino pronto per la spiaggia in un dispositivo di raffreddamento di vino con ghiaccio.', '<p><span id="result_box" lang="it"><span class="hps">Colazione</span> <span class="hps">internazionale</span><span>,</span> <span class="hps">spuntino</span> <span class="hps">pronto per la spiaggia</span> <span class="hps">in un</span> <span class="hps">dispositivo di raffreddamento</span> <span class="hps">di vino con ghiaccio</span> <span class="hps atn">(</span><span>acqua minerale</span><span>,</span> <span class="hps">bibite</span><span>,</span> <span class="hps">biscotti, frutta</span><span>, pranzo</span> <span class="hps">pranzo</span> <span class="hps">tipo</span> <span class="hps">freddo</span><span>)</span> <span class="hps">diverso ogni giorno e</span> <span class="hps">una cena squisita</span> <span class="hps">e accogliente</span><span>.</span></span></p>\n', 'Pensione completa', 'Pensione completa', 'Pensione completa'),
(6, 1, 6, 'vollpension', 'Vollpension', 'Vollpension', 'Internationales Frühstück, Snack für den Strand in einen Kühler mit Eis cava.', '<p><span id="result_box" lang="de"><span class="hps">Internationales Fr&uuml;hst&uuml;ck</span><span>, Snack</span> <span class="hps">f&uuml;r den Strand</span> <span class="hps">in</span> <span class="hps">einen K&uuml;hler mit</span> <span class="hps">Eis</span> <span class="hps">cava</span> <span class="hps atn">(</span><span>Mineralwasser, alkoholfreie</span> <span class="hps">Getr&auml;nke</span><span>, Kekse</span><span>, Obst,</span> <span class="hps">Mittagessen</span> <span class="hps">Mittagessen</span> <span class="hps">kalte Art</span><span>)</span> <span class="hps">jeden Tag anders</span> <span class="hps">und ein exquisites</span> <span class="hps">und</span> <span class="hps">gem&uuml;tliches Abendessen</span> <span class="hps">vorbereitet.</span></span></p>\n', 'Vollpension', 'Vollpension', 'Vollpension'),
(7, 1, 4, 'penso-completa', 'Pensão completa', 'Pensão completa', 'Pequeno-almoço internacional, lanche para a praia preparado em um refrigerador com cava gelo.', '<p><span id="result_box" lang="pt"><span class="hps">Pequeno-almo&ccedil;o internacional</span><span>,</span> <span class="hps">lanche</span> <span class="hps">para a praia</span> <span class="hps">preparado</span> <span class="hps">em um refrigerador</span> <span class="hps">com</span> <span class="hps">cava</span> <span class="hps">gelo</span> <span class="hps atn">(</span><span>&aacute;gua mineral</span><span>,</span> <span class="hps">refrigerantes, biscoitos</span><span>,</span> <span class="hps">frutas, almo&ccedil;o</span> <span class="hps">almo&ccedil;o</span> <span class="hps">tipo</span> <span class="hps">frio)</span> <span class="hps">diferente a cada</span> <span class="hps">dia e</span> <span class="hps">um jantar requintado</span> <span class="hps">e acolhedor.</span></span></p>\n', 'Pensão completa', 'Pensão completa', 'Pensão completa'),
(8, 2, 1, 'borrar', 'Borrar', 'Borrar', 'Borrar Borrar Borrar Borrar Borrar Borrar Borrar Borrar Borrar', '<p>Borrar Borrar Borrar Borrar Borrar Borrar Borrar Borrar Borrar Borrar</p>\n', 'Borrar Borrar Borrar Borrar Borrar Borrar Borrar Borrar', 'Borrar', 'Borrar'),
(9, 5, 1, 'media-pensin', 'Media Pensión', 'Media Pension', 'Rico desayuno internacional y una exquisita y acogedora cena. Alojamiento más desayuno.', '<p>Rico desayuno internacional y una exquisita y acogedora cena. Alojamiento m&aacute;s desayuno.</p>\n', 'Media Pension', 'Media Pension', 'Media Pension'),
(10, 6, 1, 'todo-incluido', 'Todo Incluido', 'Todo Incluido', 'Desayuno internacional, lunch para la playa preparado en una cava cooler con hielo, exquisita y acogedora cena, excursión a una isla cercana por día.', '<p>Rico desayuno internacional, lunch para la playa preparado en una cava cooler con hielo (Agua Mineral, refrescos, galletas, frutas, almuerzo fr&iacute;o tipo lunch) diferente cada d&iacute;a y una exquisita y acogedora cena. Adicionalmente incluye una excursi&oacute;n a una isla cercana por d&iacute;a.</p>\n', 'Todo Incluido', 'Todo Incluido', 'Todo Incluido'),
(11, 7, 1, 'excursin-a-una-isla-cercana-por-da', 'Excursión a una isla cercana por día', 'Excursión a una isla cercana por día', 'Traslado a los cayos cercanos Madrisky o Francisky (1 diaria) incluyendo sillas y sombrillas.', '<p>Traslado a los cayos cercanos Madrisky o Francisky (1 diaria) incluyendo sillas y sombrillas.</p>\n', 'Excursión a una isla cercana por día', 'Excursión a una isla cercana por día', 'Excursión a una isla cercana por día'),
(12, 8, 1, 'actividades-deportivas', 'Actividades Deportivas', 'Actividades Deportivas', 'Organización de actividades deportivas y entretenimiento de buceo, pesca deportiva, Windsurf, Kitesurf, Paddle, Kayak', '<p>Organizaci&oacute;n de actividades deportivas y entretenimiento de buceo, pesca deportiva, windsurf, kitesurf, paddle, kayak</p>\n', 'Actividades Deportivas', 'Actividades Deportivas', 'Actividades Deportivas'),
(13, 9, 1, 'pasaje-areo', 'Pasaje Aéreo', 'Pasaje Aéreo', 'Le compramos el pasaje aéreo si lo desea.', '<p>Le compramos el pasaje a&eacute;reo si lo desea.</p>\n', 'Pasaje Aéreo', 'Pasajes Aéreo', 'Pasaje Aéreo');

-- --------------------------------------------------------

--
-- Table structure for table `detalle_servicio_habitacion`
--

CREATE TABLE IF NOT EXISTS `detalle_servicio_habitacion` (
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

-- --------------------------------------------------------

--
-- Table structure for table `detalle_servicio_posada`
--

CREATE TABLE IF NOT EXISTS `detalle_servicio_posada` (
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

-- --------------------------------------------------------

--
-- Table structure for table `detalle_tipo_habitacion`
--

CREATE TABLE IF NOT EXISTS `detalle_tipo_habitacion` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `detalle_tipo_habitacion`
--

INSERT INTO `detalle_tipo_habitacion` (`id_detalle_tipo_habitacion`, `id_tipo_habitacion`, `id_idioma`, `url`, `nombre`, `subtitulo`, `descripcion_breve`, `descripcion_ampliada`, `descripcion_pagina`, `keywords`, `titulo_pagina`) VALUES
(1, 15, 1, 'matrimonial1', 'Matrimonial', 'Matrimonial', 'Matrimonial', '<p>Matrimonial</p>\n', 'Matrimonial', 'Matrimonial', 'Matrimonial'),
(11, 15, 2, 'matrimonial', 'Matrimonial', 'Matrimonial', 'Matrimonial', '<p><br />\nMatrimonial</p>\n', 'Matrimonial', 'Matrimonial', 'Matrimonial'),
(13, 15, 5, 'matrimonial2', 'Matrimonial', 'Matrimonial', 'Matrimonial', '<p>Matrimonial</p>\n', 'Matrimonial', 'Matrimonial', 'Matrimonial'),
(14, 16, 1, 'familiar', 'Familiar', 'Familiar', 'Cómoda Habitación Familiar', '<p><br />\nC&oacute;moda Habitaci&oacute;n Familiar</p>\n', 'Habitación Familiar', 'Familiar', 'Familiar');

-- --------------------------------------------------------

--
-- Table structure for table `detalle_usuario`
--

CREATE TABLE IF NOT EXISTS `detalle_usuario` (
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

-- --------------------------------------------------------

--
-- Table structure for table `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `estado`
--

INSERT INTO `estado` (`id_estado`, `estado`) VALUES
(1, 'publicado'),
(2, 'guardado'),
(3, 'borrado');

-- --------------------------------------------------------

--
-- Table structure for table `estado_activo`
--

CREATE TABLE IF NOT EXISTS `estado_activo` (
  `id_estado_activo` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`id_estado_activo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `estado_activo`
--

INSERT INTO `estado_activo` (`id_estado_activo`, `descripcion`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Table structure for table `estado_habitacion`
--

CREATE TABLE IF NOT EXISTS `estado_habitacion` (
  `id_estado_habitacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_estado_habitacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `estado_habitacion`
--

INSERT INTO `estado_habitacion` (`id_estado_habitacion`, `descripcion`) VALUES
(1, 'disponible'),
(2, 'pendiente pago'),
(3, 'reservado'),
(4, 'checkin');

-- --------------------------------------------------------

--
-- Table structure for table `estado_usuario`
--

CREATE TABLE IF NOT EXISTS `estado_usuario` (
  `id_estado_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `estado_usuario` varchar(20) NOT NULL,
  PRIMARY KEY (`id_estado_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `estado_usuario`
--

INSERT INTO `estado_usuario` (`id_estado_usuario`, `estado_usuario`) VALUES
(1, 'Inactivo'),
(2, 'Activo');

-- --------------------------------------------------------

--
-- Table structure for table `habitacion`
--

CREATE TABLE IF NOT EXISTS `habitacion` (
  `id_habitacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `id_tipo_habitacion` bigint(20) unsigned DEFAULT NULL,
  `id_estado_habitacion` bigint(20) unsigned DEFAULT NULL,
  `id_estado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_habitacion`),
  KEY `fk_habitacion_tipo_habitacion1` (`id_tipo_habitacion`),
  KEY `fk_habitacion_estado_habitacion1` (`id_estado_habitacion`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_estado` (`id_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `habitacion`
--

INSERT INTO `habitacion` (`id_habitacion`, `nombre`, `id_tipo_habitacion`, `id_estado_habitacion`, `id_estado`, `id_usuario`) VALUES
(2, NULL, 16, 1, 3, 2),
(3, NULL, 15, 1, 3, 2),
(4, NULL, 16, 1, 1, 2),
(5, NULL, 15, 2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `idioma`
--

CREATE TABLE IF NOT EXISTS `idioma` (
  `id_idioma` int(11) NOT NULL AUTO_INCREMENT,
  `idioma` char(2) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  PRIMARY KEY (`id_idioma`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `idioma`
--

INSERT INTO `idioma` (`id_idioma`, `idioma`, `nombre`) VALUES
(1, 'es', 'español'),
(2, 'en', 'english'),
(3, 'fr', 'français'),
(4, 'pt', 'português'),
(5, 'it', 'italiano'),
(6, 'de', 'deutsch');

-- --------------------------------------------------------

--
-- Table structure for table `moneda`
--

CREATE TABLE IF NOT EXISTS `moneda` (
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

INSERT INTO `moneda` (`id_moneda`, `nombre`, `abreviado`, `id_idioma`) VALUES
(1, 'bolívares', 'Bs', NULL),
(2, 'dollares', 'dls', NULL),
(3, 'euros', 'Eur', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `monitor`
--

CREATE TABLE IF NOT EXISTS `monitor` (
  `id_monitor` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_contenido` varchar(16) NOT NULL,
  `id_contenido` int(11) NOT NULL,
  `tipo_accion` varchar(16) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_monitor`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=163 ;

--
-- Dumping data for table `monitor`
--

INSERT INTO `monitor` (`id_monitor`, `tipo_contenido`, `id_contenido`, `tipo_accion`, `fecha`, `id_usuario`) VALUES
(1, 'noticias', 0, 'listado', '2013-09-04 19:21:05', 2),
(2, 'usuario', 0, 'crear', '2013-09-04 21:22:28', 2),
(3, 'usuario', 3, 'borrar', '2013-09-04 21:23:08', 2),
(4, 'usuario', 0, 'crear', '2013-09-05 13:56:55', 2),
(5, 'usuario', 0, 'crear', '2013-09-05 13:57:41', 2),
(6, 'usuario', 0, 'crear', '2013-09-05 13:58:04', 2),
(7, 'usuario', 5, 'ficha', '2013-09-05 14:09:28', 2),
(8, 'usuario', 5, 'ficha', '2013-09-05 14:10:40', 2),
(9, 'usuario', 5, 'editar', '2013-09-05 14:10:50', 2),
(10, 'usuario', 5, 'borrar', '2013-09-05 14:21:38', 2),
(11, 'usuario', 4, 'ficha', '2013-09-05 14:21:44', 2),
(12, 'usuario', 4, 'editar', '2013-09-05 14:21:48', 2),
(13, 'usuario', 4, 'ficha', '2013-09-05 14:21:53', 2),
(14, 'usuario', 4, 'editar', '2013-09-05 14:21:58', 2),
(15, 'usuario', 4, 'editar', '2013-09-05 14:22:09', 2),
(16, 'usuario', 4, 'editar', '2013-09-05 14:22:14', 2),
(17, 'usuario', 4, 'ficha', '2013-09-05 14:22:17', 2),
(18, 'usuario', 4, 'editar', '2013-09-05 14:22:22', 2),
(19, 'usuario', 0, 'crear', '2013-09-05 14:23:12', 2),
(20, 'usuario', 0, 'crear', '2013-09-05 14:23:37', 2),
(21, 'usuario', 0, 'crear', '2013-09-05 14:24:00', 2),
(22, 'usuario', 0, 'listado', '2013-09-05 14:24:42', 2),
(23, 'usuario', 0, 'listado', '2013-09-05 14:25:07', 2),
(24, 'usuario', 8, 'ficha', '2013-09-05 14:40:53', 2),
(25, 'usuario', 8, 'editar', '2013-09-05 14:41:01', 2),
(26, 'usuario', 8, 'borrar', '2013-09-05 14:41:08', 2),
(27, 'banner', 0, 'crear', '2013-09-05 14:51:09', 2),
(28, 'banner', 1, 'editar', '2013-09-05 14:51:14', 2),
(29, 'servicio', 0, 'crear', '2013-09-05 19:34:49', 2),
(30, 'servicio', 1, 'editar', '2013-09-05 19:44:17', 2),
(31, 'detalle_servicio', 1, 'editar_idioma', '2013-09-05 20:08:26', 2),
(32, 'detalle_servicio', 1, 'editar_idioma', '2013-09-05 20:27:08', 2),
(33, 'detalle_servicio', 1, 'eliminar_idioma', '2013-09-05 20:27:22', 2),
(34, 'servicio', 1, 'ficha', '2013-09-05 20:27:22', 2),
(35, 'detalle_servicio', 2, 'editar_idioma', '2013-09-05 20:28:38', 2),
(36, 'detalle_servicio', 3, 'editar_idioma', '2013-09-05 20:29:59', 2),
(37, 'detalle_servicio', 4, 'editar_idioma', '2013-09-05 20:48:52', 2),
(38, 'detalle_servicio', 5, 'editar_idioma', '2013-09-05 20:50:41', 2),
(39, 'detalle_servicio', 6, 'editar_idioma', '2013-09-05 20:53:36', 2),
(40, 'detalle_servicio', 7, 'editar_idioma', '2013-09-05 20:56:19', 2),
(41, 'detalle_servicio', 2, 'editar_idioma', '2013-09-05 20:57:24', 2),
(42, 'detalle_servicio', 2, 'editar_idioma', '2013-09-05 20:57:52', 2),
(43, 'detalle_servicio', 2, 'editar_idioma', '2013-09-05 21:13:40', 2),
(44, 'detalle_servicio', 2, 'editar_idioma', '2013-09-05 21:14:13', 2),
(45, 'detalle_servicio', 2, 'editar_idioma', '2013-09-05 21:20:40', 2),
(46, 'detalle_servicio', 2, 'editar_idioma', '2013-09-05 21:20:52', 2),
(47, 'servicio', 0, 'crear', '2013-09-05 21:45:09', 2),
(48, 'detalle_servicio', 8, 'editar_idioma', '2013-09-05 21:45:51', 2),
(49, 'servicio', 0, 'crear', '2013-09-06 14:21:25', 2),
(50, 'servicio', 0, 'crear', '2013-09-06 18:38:08', 2),
(51, 'servicio', 0, 'crear', '2013-09-06 18:38:33', 2),
(52, 'servicio', 0, 'crear', '2013-09-06 18:48:26', 2),
(53, 'servicio', 0, 'crear', '2013-09-06 18:50:46', 2),
(54, 'servicio', 0, 'crear', '2013-09-06 18:52:49', 2),
(55, 'servicio', 0, 'crear', '2013-09-06 18:58:23', 2),
(56, 'servicio', 0, 'crear', '2013-09-06 20:13:19', 2),
(57, 'detalle_servicio', 9, 'editar_idioma', '2013-09-06 20:15:09', 2),
(58, 'servicio', 5, 'editar', '2013-09-06 20:24:24', 2),
(59, 'servicio', 5, 'editar', '2013-09-06 20:24:30', 2),
(60, 'usuario', 8, 'ficha', '2013-09-06 20:37:15', 2),
(61, 'usuario', 8, 'ficha', '2013-09-09 15:23:05', 2),
(62, 'tipo_habitacion', 0, 'crear', '2013-09-09 20:15:07', 2),
(63, 'tipo_habitacion', 0, 'crear', '2013-09-09 20:27:16', 2),
(64, 'tipo_habitacion', 0, 'crear', '2013-09-09 20:28:18', 2),
(65, 'tipo_habitacion', 0, 'crear', '2013-09-09 20:30:30', 2),
(66, 'tipo_habitacion', 0, 'crear', '2013-09-09 20:31:17', 2),
(67, 'tipo_habitacion', 0, 'crear', '2013-09-09 20:32:45', 2),
(68, 'tipo_habitacion', 0, 'crear', '2013-09-09 20:37:02', 2),
(69, 'tipo_habitacion', 0, 'crear', '2013-09-09 20:37:32', 2),
(70, 'tipo_habitacion', 0, 'crear', '2013-09-09 20:39:25', 2),
(71, 'tipo_habitacion', 3, 'editar', '2013-09-10 15:46:08', 2),
(72, 'tipo_habitacion', 3, 'editar', '2013-09-10 15:47:02', 2),
(73, 'tipo_habitacion', 3, 'editar', '2013-09-10 15:47:33', 2),
(74, 'tipo_habitacion', 3, 'editar', '2013-09-10 15:48:39', 2),
(75, 'tipo_habitacion', 3, 'editar', '2013-09-10 15:53:20', 2),
(76, 'tipo_habitacion', 3, 'editar', '2013-09-10 15:55:03', 2),
(77, 'tipo_habitacion', 3, 'editar', '2013-09-10 15:57:51', 2),
(78, 'tipo_habitacion', 3, 'editar', '2013-09-10 15:59:01', 2),
(79, 'tipo_habitacion', 3, 'editar', '2013-09-10 15:59:14', 2),
(80, 'tipo_habitacion', 3, 'editar', '2013-09-10 16:03:50', 2),
(81, 'tipo_habitacion', 3, 'editar', '2013-09-10 16:04:18', 2),
(82, 'tipo_habitacion', 3, 'editar', '2013-09-10 16:05:10', 2),
(83, 'tipo_habitacion', 0, 'crear', '2013-09-10 16:08:45', 2),
(84, 'tipo_habitacion', 0, 'crear', '2013-09-10 16:11:04', 2),
(85, 'tipo_habitacion', 0, 'crear', '2013-09-10 16:12:05', 2),
(86, 'tipo_habitacion', 0, 'crear', '2013-09-10 16:13:22', 2),
(87, 'tipo_habitacion', 0, 'crear', '2013-09-10 16:23:44', 2),
(88, 'tipo_habitacion', 13, 'editar', '2013-09-10 16:26:33', 2),
(89, 'tipo_habitacion', 13, 'editar', '2013-09-10 16:27:24', 2),
(90, 'tipo_habitacion', 13, 'editar', '2013-09-10 16:28:04', 2),
(91, 'tipo_habitacion', 13, 'editar', '2013-09-10 16:29:13', 2),
(92, 'tipo_habitacion', 13, 'editar', '2013-09-10 16:29:30', 2),
(93, 'tipo_habitacion', 13, 'editar', '2013-09-10 16:40:39', 2),
(94, 'tipo_habitacion', 0, 'crear', '2013-09-10 16:42:52', 2),
(95, 'tipo_habitacion', 14, 'editar', '2013-09-10 16:43:14', 2),
(96, 'tipo_habitacion', 0, 'crear', '2013-09-10 16:44:41', 2),
(97, 'tipo_habitacion', 15, 'editar', '2013-09-10 16:47:44', 2),
(98, 'tipo_habitacion', 15, 'editar', '2013-09-10 16:48:17', 2),
(99, 'tipo_habitacion', 15, 'editar', '2013-09-10 18:29:12', 2),
(100, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 18:30:12', 2),
(101, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 18:37:00', 2),
(102, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 18:37:13', 2),
(103, 'detalle_tipo_hab', 2, 'editar_idioma', '2013-09-10 18:38:24', 2),
(104, 'detalle_tipo_hab', 3, 'editar_idioma', '2013-09-10 18:42:31', 2),
(105, 'detalle_tipo_hab', 3, 'eliminar_idioma', '2013-09-10 18:42:47', 2),
(106, 'detalle_tipo_hab', 4, 'editar_idioma', '2013-09-10 18:48:47', 2),
(107, 'detalle_tipo_hab', 4, 'eliminar_idioma', '2013-09-10 18:48:52', 2),
(108, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 18:49:22', 2),
(109, 'detalle_tipo_hab', 5, 'editar_idioma', '2013-09-10 18:50:34', 2),
(110, 'detalle_tipo_hab', 6, 'editar_idioma', '2013-09-10 18:51:40', 2),
(111, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 18:52:16', 2),
(112, 'detalle_tipo_hab', 7, 'editar_idioma', '2013-09-10 18:52:38', 2),
(113, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 18:53:31', 2),
(114, 'detalle_tipo_hab', 8, 'editar_idioma', '2013-09-10 18:54:45', 2),
(115, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 18:58:38', 2),
(116, 'detalle_tipo_hab', 7, 'eliminar_idioma', '2013-09-10 18:59:40', 2),
(117, 'detalle_tipo_hab', 8, 'eliminar_idioma', '2013-09-10 18:59:43', 2),
(118, 'detalle_tipo_hab', 6, 'eliminar_idioma', '2013-09-10 18:59:45', 2),
(119, 'detalle_tipo_hab', 5, 'eliminar_idioma', '2013-09-10 18:59:47', 2),
(120, 'detalle_tipo_hab', 2, 'eliminar_idioma', '2013-09-10 18:59:49', 2),
(121, 'detalle_tipo_hab', 9, 'editar_idioma', '2013-09-10 19:09:59', 2),
(122, 'detalle_tipo_hab', 9, 'eliminar_idioma', '2013-09-10 19:10:09', 2),
(123, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 19:11:02', 2),
(124, 'detalle_tipo_hab', 10, 'editar_idioma', '2013-09-10 19:11:20', 2),
(125, 'detalle_tipo_hab', 10, 'eliminar_idioma', '2013-09-10 19:11:24', 2),
(126, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 19:21:17', 2),
(127, 'detalle_tipo_hab', 11, 'editar_idioma', '2013-09-10 19:21:44', 2),
(128, 'detalle_tipo_hab', 12, 'editar_idioma', '2013-09-10 19:23:28', 2),
(129, 'detalle_tipo_hab', 12, 'eliminar_idioma', '2013-09-10 19:23:37', 2),
(130, 'detalle_tipo_hab', 1, 'editar_idioma', '2013-09-10 19:27:11', 2),
(131, 'detalle_tipo_hab', 13, 'editar_idioma', '2013-09-10 19:27:51', 2),
(132, 'tipo_habitacion', 0, 'crear', '2013-09-11 13:37:04', 2),
(133, 'detalle_tipo_hab', 14, 'editar_idioma', '2013-09-11 13:37:53', 2),
(134, 'habitacion', 0, 'crear', '2013-09-11 15:08:22', 2),
(135, 'habitacion', 0, 'crear', '2013-09-11 15:10:03', 2),
(136, 'habitacion', 0, 'crear', '2013-09-11 15:33:28', 2),
(137, 'habitacion', 0, 'crear', '2013-09-11 15:35:20', 2),
(138, 'habitacion', 0, 'crear', '2013-09-11 15:35:56', 2),
(139, 'habitacion', 5, 'editar', '2013-09-11 16:45:24', 2),
(140, 'detalle_habitaci', 1, 'editar_idioma', '2013-09-11 18:58:45', 2),
(141, 'detalle_habitaci', 2, 'editar_idioma', '2013-09-11 19:00:03', 2),
(142, 'detalle_habitaci', 3, 'editar_idioma', '2013-09-11 19:02:36', 2),
(143, 'habitacion', 5, 'editar', '2013-09-11 19:04:24', 2),
(144, 'habitacion', 4, 'editar', '2013-09-11 19:04:53', 2),
(145, 'detalle_habitaci', 4, 'editar_idioma', '2013-09-11 19:05:47', 2),
(146, 'detalle_habitaci', 5, 'editar_idioma', '2013-09-11 19:06:09', 2),
(147, 'detalle_habitaci', 6, 'editar_idioma', '2013-09-11 19:06:33', 2),
(148, 'detalle_habitaci', 7, 'editar_idioma', '2013-09-11 19:07:13', 2),
(149, 'detalle_habitaci', 4, 'editar_idioma', '2013-09-11 19:14:26', 2),
(150, 'detalle_servicio', 9, 'editar_idioma', '2013-09-19 19:47:08', 2),
(151, 'detalle_habitaci', 1, 'editar_idioma', '2013-09-19 19:52:04', 2),
(152, 'detalle_tipo_hab', 14, 'editar_idioma', '2013-09-19 19:55:29', 2),
(153, 'servicio', 0, 'crear', '2013-09-20 15:28:06', 2),
(154, 'detalle_servicio', 10, 'editar_idioma', '2013-09-20 15:30:37', 2),
(155, 'servicio', 0, 'crear', '2013-09-20 15:35:46', 2),
(156, 'detalle_servicio', 11, 'editar_idioma', '2013-09-20 15:36:56', 2),
(157, 'servicio', 0, 'crear', '2013-09-20 15:41:37', 2),
(158, 'detalle_servicio', 12, 'editar_idioma', '2013-09-20 15:43:22', 2),
(159, 'servicio', 0, 'crear', '2013-09-20 15:56:40', 2),
(160, 'detalle_servicio', 13, 'editar_idioma', '2013-09-20 15:57:36', 2),
(161, 'detalle_servicio', 13, 'editar_idioma', '2013-09-20 16:00:50', 2),
(162, 'detalle_servicio', 9, 'editar_idioma', '2013-09-24 18:52:52', 2);

-- --------------------------------------------------------

--
-- Table structure for table `multimedia`
--

CREATE TABLE IF NOT EXISTS `multimedia` (
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

INSERT INTO `multimedia` (`id_multimedia`, `destacado`, `fichero`, `id_tipo`, `id_estado`, `creado`, `actualizado`, `id_usuario`) VALUES
(10, 1, '1661054630_500x300_3.jpg', 1, 1, '0000-00-00 00:00:00', '2012-01-24 13:28:53', 2),
(11, 1, '1194002014_borrar_800x600_1.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-13 18:05:54', 2),
(12, 2, '1220447898_borrar_800x600_7.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-13 18:06:19', 2),
(14, 2, '1430770418_borrar_800x600_2.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-13 18:07:15', 2),
(15, 1, '1532511391_borrar_800x600_4.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-13 20:24:26', 2),
(16, 2, '1632715962_borrar_800x600_2.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-13 20:24:44', 2),
(17, 2, '172192294_borrar_800x600_1.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-13 20:24:44', 2),
(21, 1, '2117234388_23310351930_bolsa_con_asa.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-14 14:46:38', 2),
(24, 1, '2460872699_home_product2.png', 1, 1, '0000-00-00 00:00:00', '2013-08-21 18:01:59', 2),
(25, 1, '2533496217_home_product1.png', 1, 1, '0000-00-00 00:00:00', '2013-08-21 19:28:50', 2),
(26, 1, '2697295785_2299934851_BOLSA_BASURA_2.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-21 20:14:09', 2),
(27, 1, '2729386450_23868652651_BOLSA_BASURA_2.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-21 20:16:23', 2),
(31, 1, '314825222_papel.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-22 18:29:17', 2),
(33, 1, '3355190194_2841547464_portacomida.jpg', 1, 1, '0000-00-00 00:00:00', '2013-08-26 18:32:30', 2),
(35, 0, '3582940714_banner_one.jpg', 1, 1, '0000-00-00 00:00:00', '2013-09-05 18:12:53', 2),
(41, 1, '4193004010_Posad_4.jpg', 1, 1, '0000-00-00 00:00:00', '2013-09-11 18:57:31', 2),
(42, 1, '421694150_Posad_3.jpg', 1, 1, '0000-00-00 00:00:00', '2013-09-11 19:05:10', 2),
(62, 1, '6223535808_solylunaservicios-06.png', 1, 1, '0000-00-00 00:00:00', '2013-10-02 19:25:49', 2),
(63, 1, '6348039535_solylunaservicios-05.png', 1, 1, '0000-00-00 00:00:00', '2013-10-02 19:26:54', 2),
(64, 1, '6493388531_solylunaservicios-04.png', 1, 1, '0000-00-00 00:00:00', '2013-10-02 19:27:17', 2),
(65, 1, '6586145042_solylunaservicios-03.png', 1, 1, '0000-00-00 00:00:00', '2013-10-02 19:27:33', 2),
(66, 1, '6686765158_solylunaservicios-02.png', 1, 1, '0000-00-00 00:00:00', '2013-10-02 19:27:59', 2),
(67, 1, '6734237225_solylunaservicios-01.png', 1, 1, '0000-00-00 00:00:00', '2013-10-02 19:28:17', 2);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `id_newsletter` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(128) NOT NULL,
  `id_idioma` int(2) NOT NULL,
  `id_estado` int(2) NOT NULL,
  `creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_newsletter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `noticia`
--

CREATE TABLE IF NOT EXISTS `noticia` (
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

INSERT INTO `noticia` (`id_noticia`, `id_estado`, `id_usuario`, `creado`, `modificado`, `destacado`, `enlace`, `fichero`) VALUES
(16, 1, 2, '2012-01-24 00:00:00', '2012-01-24 13:28:53', 0, '', ''),
(18, 2, 2, '2013-08-13 16:19:57', '2013-08-13 20:49:57', 3, '', ''),
(19, 2, 2, '2013-08-13 16:20:06', '2013-08-13 20:50:06', 1, '', ''),
(20, 3, 2, '2013-08-13 16:20:11', '2013-08-13 20:50:11', 1, '', ''),
(21, 1, 2, '2013-08-13 16:20:16', '2013-08-13 20:50:16', 1, '', ''),
(22, 1, 2, '2013-08-13 00:00:00', '2013-08-13 20:51:33', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `posada`
--

CREATE TABLE IF NOT EXISTS `posada` (
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

INSERT INTO `posada` (`id_posada`, `Nombre`, `direccion`, `email_contacto`, `telefono_contacto`) VALUES
(1, 'Sol y Luna', 'Los Roques', 'solyluna@gmail.com', '+58412-765-3423');

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE IF NOT EXISTS `producto` (
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

-- --------------------------------------------------------

--
-- Table structure for table `promocion`
--

CREATE TABLE IF NOT EXISTS `promocion` (
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

-- --------------------------------------------------------

--
-- Table structure for table `receta`
--

CREATE TABLE IF NOT EXISTS `receta` (
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

-- --------------------------------------------------------

--
-- Table structure for table `rel_banner_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_banner_multimedia` (
  `id_banner` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_noticia` (`id_banner`,`id_multimedia`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rel_banner_multimedia`
--

INSERT INTO `rel_banner_multimedia` (`id_banner`, `id_multimedia`) VALUES
(1, 35);

-- --------------------------------------------------------

--
-- Table structure for table `rel_categoria_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_categoria_multimedia` (
  `id_categoria` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_categoria` (`id_categoria`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rel_detalle_receta_tag`
--

CREATE TABLE IF NOT EXISTS `rel_detalle_receta_tag` (
  `id_detalle_receta` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL,
  KEY `id_receta` (`id_detalle_receta`),
  KEY `id_tag` (`id_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rel_habitacion_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_habitacion_multimedia` (
  `id_habitacion` bigint(20) unsigned NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_habitacion` (`id_habitacion`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rel_habitacion_multimedia`
--

INSERT INTO `rel_habitacion_multimedia` (`id_habitacion`, `id_multimedia`) VALUES
(5, 41),
(4, 42);

-- --------------------------------------------------------

--
-- Table structure for table `rel_noticia_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_noticia_multimedia` (
  `id_noticia` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_noticia` (`id_noticia`,`id_multimedia`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rel_posada_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_posada_multimedia` (
  `id_posada` bigint(20) unsigned NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_posada` (`id_posada`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rel_producto_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_producto_multimedia` (
  `id_producto` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  PRIMARY KEY (`id_producto`,`id_multimedia`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rel_producto_noticia`
--

CREATE TABLE IF NOT EXISTS `rel_producto_noticia` (
  `id_producto` int(11) NOT NULL,
  `id_noticia` int(11) NOT NULL,
  KEY `id_producto` (`id_producto`),
  KEY `id_noticia` (`id_noticia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rel_producto_producto`
--

CREATE TABLE IF NOT EXISTS `rel_producto_producto` (
  `id_producto` int(11) NOT NULL,
  `id_producto_relacionado` int(11) NOT NULL,
  KEY `id_producto` (`id_producto`),
  KEY `id_producto_relacionado` (`id_producto_relacionado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rel_producto_receta`
--

CREATE TABLE IF NOT EXISTS `rel_producto_receta` (
  `id_producto` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  KEY `id_producto` (`id_producto`),
  KEY `id_receta` (`id_receta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rel_promocion_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_promocion_multimedia` (
  `id_promocion` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_noticia` (`id_promocion`,`id_multimedia`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rel_receta_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_receta_multimedia` (
  `id_receta` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_multimedia` (`id_multimedia`),
  KEY `id_producto` (`id_receta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rel_servicio_habitacion`
--

CREATE TABLE IF NOT EXISTS `rel_servicio_habitacion` (
  `id_habitacion` bigint(20) unsigned NOT NULL,
  `id_servicio_habitacion` bigint(20) unsigned NOT NULL,
  KEY `id_habitacion` (`id_habitacion`),
  KEY `id_servicio_habitacion` (`id_servicio_habitacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rel_servicio_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_servicio_multimedia` (
  `id_servicio` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  PRIMARY KEY (`id_servicio`,`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rel_servicio_multimedia`
--

INSERT INTO `rel_servicio_multimedia` (`id_servicio`, `id_multimedia`) VALUES
(1, 67),
(5, 66),
(6, 65),
(7, 64),
(8, 63),
(9, 62);

-- --------------------------------------------------------

--
-- Table structure for table `rel_servicio_posada_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_servicio_posada_multimedia` (
  `id_servicio_posada` bigint(20) unsigned NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_servicio_posada` (`id_servicio_posada`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reservacion`
--

CREATE TABLE IF NOT EXISTS `reservacion` (
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

-- --------------------------------------------------------

--
-- Table structure for table `reservacion_habitacion`
--

CREATE TABLE IF NOT EXISTS `reservacion_habitacion` (
  `id_reservacion` bigint(20) unsigned NOT NULL,
  `id_habitacion` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id_reservacion`,`id_habitacion`),
  KEY `fk_reservacion_has_habitacion_habitacion1` (`id_habitacion`),
  KEY `fk_reservacion_has_habitacion_reservacion1` (`id_reservacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`) VALUES
(1, 'admin'),
(2, 'editor'),
(3, 'usuario'),
(4, 'inactivo');

-- --------------------------------------------------------

--
-- Table structure for table `servicio`
--

CREATE TABLE IF NOT EXISTS `servicio` (
  `id_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_servicio` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_servicio`),
  KEY `id_estado` (`id_estado`),
  KEY `id_tipo_servicio` (`id_tipo_servicio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `servicio`
--

INSERT INTO `servicio` (`id_servicio`, `id_tipo_servicio`, `id_estado`, `id_usuario`) VALUES
(1, 4, 1, 0),
(2, 4, 3, 0),
(3, 3, 3, 0),
(4, 1, 3, 0),
(5, 4, 1, 0),
(6, 4, 1, 0),
(7, 2, 1, 0),
(8, 2, 1, 0),
(9, 5, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `servicio_habitacion`
--

CREATE TABLE IF NOT EXISTS `servicio_habitacion` (
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

-- --------------------------------------------------------

--
-- Table structure for table `servicio_posada`
--

CREATE TABLE IF NOT EXISTS `servicio_posada` (
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

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id_tag` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(64) NOT NULL,
  `id_idioma` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  PRIMARY KEY (`id_tag`),
  KEY `R_51` (`id_idioma`),
  KEY `id_estado` (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `temporada`
--

CREATE TABLE IF NOT EXISTS `temporada` (
  `id_temporada` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id_temporada`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `temporada`
--

INSERT INTO `temporada` (`id_temporada`, `nombre`) VALUES
(1, 'Baja'),
(2, 'Alta');

-- --------------------------------------------------------

--
-- Table structure for table `testimonio`
--

CREATE TABLE IF NOT EXISTS `testimonio` (
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

INSERT INTO `testimonio` (`id_testimonio`, `nombre`, `email`, `comentario`, `rating`, `id_usuario`, `creado`) VALUES
(1, 'Hector Jose Flores Colmenarez', 'hecto932@gmail.com', 'Esto es un testimonio de prueba para el dyndns.', 3, NULL, '2013-09-27 19:21:33'),
(2, 'Oriana Ruiz', 'oruiz92@gmail.com', 'Mensaje de Prueba', 5, NULL, '2013-09-28 01:26:17'),
(3, 'carlos délgado', 'cd.nsce@gmail.com', 'esta pagina me parece mejor que la pasta dental y cepillarme', 1, NULL, '2013-09-30 18:48:38'),
(4, 'Hector Jose Flores Colmenarez', 'hecto932@gmail.com', 'asdiahsdhasiudhasiudhasiudhasiudhsi', 1, NULL, '2013-09-30 18:49:04'),
(5, 'no se', 'nathohno@gmail.com', 'LLEGO EL SEÑOR QUE ME DA MIEDOO', 5, NULL, '2013-09-30 18:49:36'),
(6, 'carlos délgado', 'carlosjmdelgado@gmail.com', 'hecto932 ha contraido nupcias con DYNDNS', 1, NULL, '2013-09-30 18:53:47'),
(7, 'Hugo Chávez', 'Chiabevive@yahoo.es', 'AYUDENME ESTOY ATRAPADO EN EL SOTANO DE MIRAFLORES, ME FUI AL BAÑO QUE TIENE EL SOTANO Y SE ME OLVIDO BUSCAR LA LLAVE. \n\n#TROPA AYUDENME; TAMBIEN SE ME ACABO EL PAPEL', 4, NULL, '2013-10-19 03:58:19'),
(8, 'Hugo Chávez', 'Chiabevive@yahoo.es', 'AYUDENME ESTOY ATRAPADO EN EL SOTANO DE MIRAFLORES, ME FUI AL BAÑO QUE TIENE EL SOTANO Y SE ME OLVIDO BUSCAR LA LLAVE. \n\n#TROPA AYUDENME; TAMBIEN SE ME ACABO EL PAPEL', 4, NULL, '2013-10-19 03:58:42');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_categoria`
--

CREATE TABLE IF NOT EXISTS `tipo_categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tipo_categoria`
--

INSERT INTO `tipo_categoria` (`id`, `nombre`) VALUES
(1, 'producto');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_forma_pago`
--

CREATE TABLE IF NOT EXISTS `tipo_forma_pago` (
  `id_tipo_forma_pago` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_forma_pago`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tipo_forma_pago`
--

INSERT INTO `tipo_forma_pago` (`id_tipo_forma_pago`, `descripcion`) VALUES
(1, 'Debito'),
(2, 'Credito'),
(3, 'Cheque'),
(4, 'Transferencia'),
(5, 'Efectivo');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_habitacion`
--

CREATE TABLE IF NOT EXISTS `tipo_habitacion` (
  `id_tipo_habitacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_estado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_tipo_habitacion`),
  KEY `id_estado` (`id_estado`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `tipo_habitacion`
--

INSERT INTO `tipo_habitacion` (`id_tipo_habitacion`, `id_estado`, `id_usuario`) VALUES
(13, 2, 2),
(14, 1, 2),
(15, 3, 2),
(16, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tipo_multimedia`
--

CREATE TABLE IF NOT EXISTS `tipo_multimedia` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tipo_multimedia`
--

INSERT INTO `tipo_multimedia` (`id_tipo`, `nombre`) VALUES
(1, 'imagen'),
(2, 'banner'),
(3, 'video'),
(4, 'pdf');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_servicio`
--

CREATE TABLE IF NOT EXISTS `tipo_servicio` (
  `id_tipo_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tipo` varchar(75) NOT NULL,
  PRIMARY KEY (`id_tipo_servicio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tipo_servicio`
--

INSERT INTO `tipo_servicio` (`id_tipo_servicio`, `nombre_tipo`) VALUES
(1, 'hospedaje'),
(2, 'actividad'),
(3, 'gastronomia'),
(4, 'promocional'),
(5, 'transporte');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
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

INSERT INTO `usuario` (`nombre_usuario`, `password`, `nombre`, `apellidos`, `email`, `id_usuario`, `id_rol`, `fecha`, `verificacion`, `id_estado_usuario`) VALUES
('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrador', 'admin', 'admin@admin.com', 2, 1, '2010-06-30', '', 2),
('', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Marioxy', 'Lobo', 'mary@mary.com', 4, 1, '2013-09-05', '0', 2),
('', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Pedro', 'Camejo', 'pedro@pedro.com', 5, 1, '2013-09-05', '0', 1),
('', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Gerardo', 'Chemello', 'gchemello@gmail.com', 6, 1, '2013-09-05', '0', 1),
('', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Fernando', 'Pinto', 'pinto@pinto.com', 7, 1, '2013-09-05', '0', 1),
('', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Hector', 'Flores', 'hecto932@gmail.com', 8, 1, '2013-09-05', '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuario_front`
--

CREATE TABLE IF NOT EXISTS `usuario_front` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `votacion`
--

CREATE TABLE IF NOT EXISTS `votacion` (
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
  ADD CONSTRAINT `costo_ibfk_4` FOREIGN KEY (`id_moneda`) REFERENCES `moneda` (`id_moneda`),
  ADD CONSTRAINT `costo_ibfk_5` FOREIGN KEY (`id_temporada`) REFERENCES `temporada` (`id_temporada`),
  ADD CONSTRAINT `costo_ibfk_6` FOREIGN KEY (`id_tipo_habitacion`) REFERENCES `tipo_habitacion` (`id_tipo_habitacion`);

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
  ADD CONSTRAINT `fk_habitacion_estado_habitacion1` FOREIGN KEY (`id_estado_habitacion`) REFERENCES `estado_habitacion` (`id_estado_habitacion`) ON DELETE SET NULL ON UPDATE CASCADE,
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
  ADD CONSTRAINT `reservacion_ibfk_3` FOREIGN KEY (`id_estado_activo`) REFERENCES `estado_activo` (`id_estado_activo`) ON DELETE SET NULL ON UPDATE CASCADE;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
