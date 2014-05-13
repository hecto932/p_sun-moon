-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 01-11-2013 a las 13:45:20
-- Versión del servidor: 5.1.63-cll
-- Versión de PHP: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `chemello_solyluna`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banner`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `banner`
--

INSERT INTO `banner` (`id_banner`, `id_estado`, `id_usuario`, `creado`, `modificado`, `destacado`, `enlace`, `fichero`, `slider`) VALUES
(1, 1, 0, '2013-09-05 00:00:00', '2013-09-05 14:51:09', 0, '1', '', ''),
(2, 3, 0, '2013-10-29 00:00:00', '2013-10-29 19:30:53', 0, '1', '', 'fgsrtsdfgfdgdfg   gdfgd d dg df gdf aksjhjksh askjhaksjfh skfjhsdfjkhskfh fhdksh kjdhsfkfh kjdhsfkjh asjkhaskh skjfh');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
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
-- Estructura de tabla para la tabla `contacto`
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
-- Estructura de tabla para la tabla `costo`
--

CREATE TABLE IF NOT EXISTS `costo` (
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_banner`
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
-- Estructura de tabla para la tabla `detalle_categoria`
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
-- Estructura de tabla para la tabla `detalle_habitacion`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `detalle_habitacion`
--

INSERT INTO `detalle_habitacion` (`id_detalle_habitacion`, `id_habitacion`, `id_idioma`, `url`, `nombre`, `subtitulo`, `descripcion_breve`, `descripcion_ampliada`, `descripcion_pagina`, `keywords`, `titulo_pagina`) VALUES
(1, 5, 1, 'habitacin-para-dos-personas', 'Habitación para dos personas', 'Habitación para dos personas', 'Cómoda habitación para dos personas', '<p>C&oacute;moda habitaci&oacute;n para dos personas</p>\n', 'Habitación para dos personas', 'Habitación para dos personas', 'Habitación para dos personas'),
(2, 5, 3, 'chambre-confortable-pour-deux-personnes', 'Chambre confortable pour deux personnes', 'Chambre confortable pour deux personnes', 'Chambre confortable pour deux personnes', '<p><span class="short_text" id="result_box" lang="fr"><span class="hps">Chambre</span> <span class="hps">confortable pour deux personnes</span></span></p>\n', 'Chambre confortable pour deux personnes', 'Chambre confortable pour deux personnes', 'Chambre confortable pour deux personnes'),
(3, 5, 5, 'confortevole-camera-per-due-persone', 'Confortevole camera per due persone', 'Confortevole camera per due persone', 'Confortevole camera per due persone', '<p><span class="short_text" id="result_box" lang="it"><span class="hps">Confortevole camera</span> <span class="hps">per due</span> <span class="hps">persone</span></span></p>\n', 'Confortevole camera per due persone', 'Confortevole camera per due persone', 'Confortevole camera per due persone'),
(5, 4, 5, 'camera-confortevole-per-quattro-persone', 'Camera confortevole per quattro persone', 'Camera confortevole per quattro persone', 'Camera confortevole per quattro persone', '<p><br />\n<span class="short_text" id="result_box" lang="it"><span class="hps">Camera confortevole</span> <span class="hps">per quattro persone</span></span></p>\n', 'Camera confortevole per quattro persone', 'Camera confortevole per quattro persone', 'Camera confortevole per quattro persone'),
(6, 4, 3, 'chambre-confortable-pour-quatre-personnes', 'Chambre confortable pour quatre personnes', 'Chambre confortable pour quatre personnes', 'Chambre confortable pour quatre personnes', '<p><br />\n<span class="short_text" id="result_box" lang="fr"><span class="hps">Chambre confortable pour</span> <span class="hps">quatre personnes</span></span></p>\n', 'Chambre confortable pour quatre personnes', 'Chambre confortable pour quatre personnes', 'Chambre confortable pour quatre personnes'),
(7, 4, 2, 'comfortable-room-for-four-people', 'Comfortable room for four people', 'Comfortable room for four people', 'Comfortable room for four people', '<p><span class="short_text" id="result_box" lang="en"><span class="hps">Comfortable room for</span> <span class="hps">four people</span></span></p>\n', 'Comfortable room for four people', 'Comfortable room for four people', 'Comfortable room for four people'),
(8, 6, 1, 'individual', 'Individual', 'Hermosa habitación individual', 'Hermosa habitación individual Hermosa habitación individual Hermosa habitación individual', '<p><br />\nHermosa habitaci&oacute;n individual Hermosa habitaci&oacute;n individual Hermosa habitaci&oacute;n individual</p>\n', 'Hermosa habitación individual', 'Hermosa habitación individual', 'Hermosa habitación individual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_multimedia`
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
-- Estructura de tabla para la tabla `detalle_noticia`
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
-- Estructura de tabla para la tabla `detalle_producto`
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
-- Estructura de tabla para la tabla `detalle_promocion`
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
-- Estructura de tabla para la tabla `detalle_receta`
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
-- Estructura de tabla para la tabla `detalle_servicio`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `detalle_servicio`
--

INSERT INTO `detalle_servicio` (`id_detalle_servicio`, `id_servicio`, `id_idioma`, `url`, `nombre`, `subtitulo`, `descripcion_breve`, `descripcion_ampliada`, `descripcion_pagina`, `keywords`, `titulo_pagina`) VALUES
(2, 1, 1, 'pensin-completa', 'Pensión Completa', 'Pensión Completa', 'Rico desayuno internacional, merienda para la playa preparada en una cava cooler con hielo, diferente cada día y una exquisita y acogedora cena.', '<p>Rico desayuno internacional, merienda para la playa preparada en una cava cooler con hielo (Agua Mineral, Refrescos, Galletas, Frutas, Almuerzo fr&iacute;o tipo lunch) diferente cada d&iacute;a y una exquisita y acogedora cena.</p>\n', 'Pensión Completa', 'Pensión Completa', 'Pensión Completa'),
(3, 1, 2, 'full-guesthouse', 'Full Guesthouse', 'Full Guesthouse', 'International breakfast, snack for the beach prepared in a cooler with ice cava, different every day and an exquisite and cozy dinner.', '<p><span id="result_box" lang="en"><span class="hps">Rico</span> <span class="hps">international breakfast</span><span>,</span> <span class="hps">snack</span> <span class="hps">for the beach</span> <span class="hps">prepared in a</span> <span class="hps">cooler</span> <span class="hps">with ice</span> <span class="hps">cava</span></span><span lang="en">&nbsp;<span class="hps atn">(</span><span>Mineral</span> <span class="hps">Water</span><span>, Soft Drinks</span><span>,</span> <span class="hps">Cookies,</span> <span class="hps">Fruit</span><span>, Lunch</span> <span class="hps">lunch</span> <span class="hps">cold</span> <span class="hps">type</span><span>)</span> <span class="hps">different every day and</span> <span class="hps">an exquisite and</span> <span class="hps">cozy</span> <span class="hps">dinner</span><span>.</span></span></p>\n', 'Full Guesthouse', 'Full Guesthouse', 'Full Guesthouse'),
(4, 1, 3, 'pension-complte', 'Pension complète', 'Pension complète', 'Petit-déjeuner international, un snack prêt pour la plage dans un refroidisseur de vin de glace.', '<p><span id="result_box" lang="fr"><span class="hps">Petit-d&eacute;jeuner international</span><span>, un snack</span> <span class="hps">pr&ecirc;t pour la plage</span> <span class="hps">dans un refroidisseur</span> <span class="hps">de vin de glace</span> <span class="hps atn">(</span><span>eau min&eacute;rale</span><span>, boissons gazeuses,</span> <span class="hps">biscuits</span><span>, fruits,</span> <span class="hps">d&eacute;jeuner</span> <span class="hps">lunch</span> <span class="hps">froid de type</span><span>)</span> <span class="hps">diff&eacute;rent chaque jour</span> <span class="hps">et</span> <span class="hps">un d&icirc;ner exquis</span> <span class="hps">et confortable.</span></span></p>\n', 'Pension complète', 'Pension complète', 'Pension complète'),
(5, 1, 5, 'pensione-completa', 'Pensione completa', 'Pensione completa', 'Colazione internazionale, spuntino pronto per la spiaggia in un dispositivo di raffreddamento di vino con ghiaccio.', '<p><span id="result_box" lang="it"><span class="hps">Colazione</span> <span class="hps">internazionale</span><span>,</span> <span class="hps">spuntino</span> <span class="hps">pronto per la spiaggia</span> <span class="hps">in un</span> <span class="hps">dispositivo di raffreddamento</span> <span class="hps">di vino con ghiaccio</span> <span class="hps atn">(</span><span>acqua minerale</span><span>,</span> <span class="hps">bibite</span><span>,</span> <span class="hps">biscotti, frutta</span><span>, pranzo</span> <span class="hps">pranzo</span> <span class="hps">tipo</span> <span class="hps">freddo</span><span>)</span> <span class="hps">diverso ogni giorno e</span> <span class="hps">una cena squisita</span> <span class="hps">e accogliente</span><span>.</span></span></p>\n', 'Pensione completa', 'Pensione completa', 'Pensione completa'),
(6, 1, 6, 'vollpension', 'Vollpension', 'Vollpension', 'Internationales Frühstück, Snack für den Strand in einen Kühler mit Eis cava.', '<p><span id="result_box" lang="de"><span class="hps">Internationales Fr&uuml;hst&uuml;ck</span><span>, Snack</span> <span class="hps">f&uuml;r den Strand</span> <span class="hps">in</span> <span class="hps">einen K&uuml;hler mit</span> <span class="hps">Eis</span> <span class="hps">cava</span> <span class="hps atn">(</span><span>Mineralwasser, alkoholfreie</span> <span class="hps">Getr&auml;nke</span><span>, Kekse</span><span>, Obst,</span> <span class="hps">Mittagessen</span> <span class="hps">Mittagessen</span> <span class="hps">kalte Art</span><span>)</span> <span class="hps">jeden Tag anders</span> <span class="hps">und ein exquisites</span> <span class="hps">und</span> <span class="hps">gem&uuml;tliches Abendessen</span> <span class="hps">vorbereitet.</span></span></p>\n', 'Vollpension', 'Vollpension', 'Vollpension'),
(7, 1, 4, 'penso-completa', 'Pensão completa', 'Pensão completa', 'Pequeno-almoço internacional, lanche para a praia preparado em um refrigerador com cava gelo.', '<p><span id="result_box" lang="pt"><span class="hps">Pequeno-almo&ccedil;o internacional</span><span>,</span> <span class="hps">lanche</span> <span class="hps">para a praia</span> <span class="hps">preparado</span> <span class="hps">em um refrigerador</span> <span class="hps">com</span> <span class="hps">cava</span> <span class="hps">gelo</span> <span class="hps atn">(</span><span>&aacute;gua mineral</span><span>,</span> <span class="hps">refrigerantes, biscoitos</span><span>,</span> <span class="hps">frutas, almo&ccedil;o</span> <span class="hps">almo&ccedil;o</span> <span class="hps">tipo</span> <span class="hps">frio)</span> <span class="hps">diferente a cada</span> <span class="hps">dia e</span> <span class="hps">um jantar requintado</span> <span class="hps">e acolhedor.</span></span></p>\n', 'Pensão completa', 'Pensão completa', 'Pensão completa'),
(9, 5, 1, 'media-pensin', 'Media Pensión', 'Media Pension', 'Rico desayuno internacional y una exquisita y acogedora cena. Alojamiento más desayuno.', '<p>Rico desayuno internacional y una exquisita y acogedora cena. Alojamiento m&aacute;s desayuno.</p>\n', 'Media Pension', 'Media Pension', 'Media Pension'),
(10, 6, 1, 'todo-incluido', 'Todo Incluido', 'Todo Incluido', 'Desayuno internacional, lunch para la playa preparado en una cava cooler con hielo, exquisita y acogedora cena, excursión a una isla cercana por día.', '<p>Rico desayuno internacional, lunch para la playa preparado en una cava cooler con hielo (Agua Mineral, refrescos, galletas, frutas, almuerzo fr&iacute;o tipo lunch) diferente cada d&iacute;a y una exquisita y acogedora cena. Adicionalmente incluye una excursi&oacute;n a una isla cercana por d&iacute;a.</p>\n', 'Todo Incluido', 'Todo Incluido', 'Todo Incluido'),
(11, 7, 1, 'excursin-a-una-isla-cercana-por-da', 'Excursión a una isla cercana por día', 'Excursión a una isla cercana por día', 'Traslado a los cayos cercanos Madrisky o Francisky (1 diaria) incluyendo sillas y sombrillas.', '<p>Traslado a los cayos cercanos Madrisky o Francisky (1 diaria) incluyendo sillas y sombrillas.</p>\n', 'Excursión a una isla cercana por día', 'Excursión a una isla cercana por día', 'Excursión a una isla cercana por día'),
(12, 8, 1, 'actividades-deportivas', 'Actividades Deportivas', 'Actividades Deportivas', 'Organización de actividades deportivas y entretenimiento de buceo, pesca deportiva, Windsurf, Kitesurf, Paddle, Kayak', '<p>Organizaci&oacute;n de actividades deportivas y entretenimiento de buceo, pesca deportiva, windsurf, kitesurf, paddle, kayak</p>\n', 'Actividades Deportivas', 'Actividades Deportivas', 'Actividades Deportivas'),
(13, 9, 1, 'pasaje-areo', 'Pasaje Aéreo', 'Pasaje Aéreo', 'Le compramos el pasaje aéreo si lo desea.', '<p>Le compramos el pasaje a&eacute;reo si lo desea.</p>\n', 'Pasaje Aéreo', 'Pasajes Aéreo', 'Pasaje Aéreo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_servicio_habitacion`
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
-- Estructura de tabla para la tabla `detalle_servicio_posada`
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
-- Estructura de tabla para la tabla `detalle_tipo_habitacion`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Volcado de datos para la tabla `detalle_tipo_habitacion`
--

INSERT INTO `detalle_tipo_habitacion` (`id_detalle_tipo_habitacion`, `id_tipo_habitacion`, `id_idioma`, `url`, `nombre`, `subtitulo`, `descripcion_breve`, `descripcion_ampliada`, `descripcion_pagina`, `keywords`, `titulo_pagina`) VALUES
(1, 15, 1, 'matrimonial1', 'Matrimonial', 'Matrimonial', 'Matrimonial', '<p>Matrimonial</p>\n', 'Matrimonial', 'Matrimonial', 'Matrimonial'),
(11, 15, 2, 'matrimonial', 'Matrimonial', 'Matrimonial', 'Matrimonial', '<p><br />\nMatrimonial</p>\n', 'Matrimonial', 'Matrimonial', 'Matrimonial'),
(13, 15, 5, 'matrimonial2', 'Matrimonial', 'Matrimonial', 'Matrimonial', '<p>Matrimonial</p>\n', 'Matrimonial', 'Matrimonial', 'Matrimonial'),
(15, 17, 1, 'individual', 'Individual', 'Hermosa habitación individual', 'Hermosa habitación individual Hermosa habitación individual Hermosa habitación individual', '<p>Hermosa habitaci&oacute;n individual Hermosa habitaci&oacute;n individual Hermosa habitaci&oacute;n individual</p>\n', 'Hermosa habitación individual', 'Hermosa habitación individual', 'Hermosa habitación individual'),
(16, 16, 2, 'familiar', 'Familiar', 'Familiar', 'Cómoda Habitación Familiar', '<p><br />\nC&oacute;moda Habitaci&oacute;n Familiar</p>\n', 'Habitación Familiar', 'Familiar', 'Familiar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_usuario`
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
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_estado`, `estado`) VALUES
(1, 'publicado'),
(2, 'guardado'),
(3, 'borrado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_activo`
--

CREATE TABLE IF NOT EXISTS `estado_activo` (
  `id_estado_activo` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`id_estado_activo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `estado_activo`
--

INSERT INTO `estado_activo` (`id_estado_activo`, `descripcion`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_reservacion`
--

CREATE TABLE IF NOT EXISTS `estado_reservacion` (
  `id_estado_reservacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_estado_reservacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `estado_reservacion`
--

INSERT INTO `estado_reservacion` (`id_estado_reservacion`, `descripcion`) VALUES
(1, 'disponible'),
(2, 'pendiente pago'),
(3, 'reservado'),
(4, 'checkin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_usuario`
--

CREATE TABLE IF NOT EXISTS `estado_usuario` (
  `id_estado_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `estado_usuario` varchar(20) NOT NULL,
  PRIMARY KEY (`id_estado_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `estado_usuario`
--

INSERT INTO `estado_usuario` (`id_estado_usuario`, `estado_usuario`) VALUES
(1, 'Inactivo'),
(2, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE IF NOT EXISTS `habitacion` (
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
-- Volcado de datos para la tabla `habitacion`
--

INSERT INTO `habitacion` (`id_habitacion`, `codigo`, `id_tipo_habitacion`, `id_estado`, `id_usuario`) VALUES
(4, '003', 16, 1, 2),
(5, '002', 15, 1, 2),
(6, '001', 17, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `idioma`
--

CREATE TABLE IF NOT EXISTS `idioma` (
  `id_idioma` int(11) NOT NULL AUTO_INCREMENT,
  `idioma` char(2) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  PRIMARY KEY (`id_idioma`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `idioma`
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
-- Estructura de tabla para la tabla `moneda`
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
-- Volcado de datos para la tabla `moneda`
--

INSERT INTO `moneda` (`id_moneda`, `nombre`, `abreviado`, `id_idioma`) VALUES
(1, 'bolívares', 'Bs', NULL),
(2, 'dollares', 'Dls', NULL),
(3, 'euros', 'Eur', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monitor`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=251 ;

--
-- Volcado de datos para la tabla `monitor`
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
(162, 'detalle_servicio', 9, 'editar_idioma', '2013-09-24 18:52:52', 2),
(163, 'tipo_habitacion', 15, 'editar', '2013-10-22 18:23:50', 2),
(164, 'tipo_habitacion', 0, 'crear', '2013-10-22 19:28:55', 2),
(165, 'detalle_tipo_hab', 15, 'editar_idioma', '2013-10-22 19:34:24', 2),
(166, 'habitacion', 0, 'crear', '2013-10-22 19:34:42', 2),
(167, 'habitacion', 0, 'crear', '2013-10-22 19:53:32', 2),
(168, 'detalle_habitaci', 8, 'editar_idioma', '2013-10-22 19:54:07', 2),
(169, 'habitacion', 6, 'editar', '2013-10-22 19:54:29', 2),
(170, 'detalle_habitaci', 4, 'eliminar_idioma', '2013-10-23 18:30:21', 2),
(171, 'detalle_tipo_hab', 16, 'editar_idioma', '2013-10-23 18:38:30', 2),
(172, 'detalle_tipo_hab', 14, 'eliminar_idioma', '2013-10-23 18:38:33', 2),
(173, 'habitacion', 0, 'crear', '2013-10-24 15:50:06', 2),
(174, 'habitacion', 0, 'crear', '2013-10-24 15:50:45', 2),
(175, 'habitacion', 0, 'crear', '2013-10-24 15:51:05', 2),
(176, 'habitacion', 0, 'crear', '2013-10-24 15:51:43', 2),
(177, 'habitacion', 0, 'crear', '2013-10-24 15:52:35', 2),
(178, 'habitacion', 0, 'crear', '2013-10-24 15:53:17', 2),
(179, 'habitacion', 0, 'crear', '2013-10-24 15:53:30', 2),
(180, 'habitacion', 0, 'crear', '2013-10-24 15:55:40', 2),
(181, 'habitacion', 0, 'crear', '2013-10-24 15:55:42', 2),
(182, 'habitacion', 0, 'crear', '2013-10-24 15:55:53', 2),
(183, 'habitacion', 6, 'editar', '2013-10-24 15:56:11', 2),
(184, 'habitacion', 6, 'editar', '2013-10-24 15:57:37', 2),
(185, 'habitacion', 5, 'editar', '2013-10-24 16:02:21', 2),
(186, 'habitacion', 4, 'editar', '2013-10-24 16:02:35', 2),
(187, 'tipo_habitacion', 0, 'crear', '2013-10-28 14:41:05', 2),
(188, 'tipo_habitacion', 0, 'crear', '2013-10-28 14:41:48', 2),
(189, 'tipo_habitacion', 0, 'crear', '2013-10-28 14:42:05', 2),
(190, 'tipo_habitacion', 0, 'crear', '2013-10-28 14:42:38', 2),
(191, 'tipo_habitacion', 0, 'crear', '2013-10-28 14:43:21', 2),
(192, 'tipo_habitacion', 0, 'crear', '2013-10-28 14:43:25', 2),
(193, 'tipo_habitacion', 0, 'crear', '2013-10-28 14:43:46', 2),
(194, 'tipo_habitacion', 18, 'editar', '2013-10-28 14:44:01', 2),
(195, 'tipo_habitacion', 15, 'editar', '2013-10-28 18:05:39', 2),
(196, 'tipo_habitacion', 17, 'editar', '2013-10-28 18:05:55', 2),
(197, 'tipo_habitacion', 16, 'editar', '2013-10-28 18:06:12', 2),
(198, 'detalle_tipo_hab', 17, 'editar_idioma', '2013-10-28 20:57:39', 2),
(199, 'detalle_tipo_hab', 17, 'editar_idioma', '2013-10-29 13:50:59', 2),
(200, 'detalle_tipo_hab', 17, 'editar_idioma', '2013-10-29 14:11:56', 2),
(201, 'detalle_tipo_hab', 17, 'editar_idioma', '2013-10-29 14:32:37', 2),
(202, 'detalle_tipo_hab', 18, 'editar_idioma', '2013-10-29 14:42:57', 2),
(203, 'tipo_habitacion', 0, 'crear', '2013-10-29 15:14:31', 2),
(204, 'detalle_tipo_hab', 19, 'editar_idioma', '2013-10-29 15:17:12', 2),
(205, 'detalle_tipo_hab', 20, 'editar_idioma', '2013-10-29 15:18:47', 2),
(206, 'detalle_tipo_hab', 20, 'eliminar_idioma', '2013-10-29 15:41:37', 2),
(207, 'detalle_tipo_hab', 20, 'eliminar_idioma', '2013-10-29 15:45:44', 2),
(208, 'detalle_tipo_hab', 20, 'eliminar_idioma', '2013-10-29 15:46:49', 2),
(209, 'detalle_tipo_hab', 19, 'eliminar_idioma', '2013-10-29 15:46:54', 2),
(210, 'detalle_tipo_hab', 21, 'editar_idioma', '2013-10-29 15:50:21', 2),
(211, 'detalle_tipo_hab', 22, 'editar_idioma', '2013-10-29 15:51:03', 2),
(212, 'detalle_tipo_hab', 22, 'eliminar_idioma', '2013-10-29 15:51:26', 2),
(213, 'detalle_tipo_hab', 21, 'eliminar_idioma', '2013-10-29 15:51:29', 2),
(214, 'detalle_tipo_hab', 23, 'editar_idioma', '2013-10-29 15:52:19', 2),
(215, 'detalle_tipo_hab', 24, 'editar_idioma', '2013-10-29 15:52:57', 2),
(216, 'detalle_tipo_hab', 24, 'eliminar_idioma', '2013-10-29 16:04:12', 2),
(217, 'detalle_tipo_hab', 23, 'eliminar_idioma', '2013-10-29 16:04:16', 2),
(218, 'detalle_tipo_hab', 25, 'editar_idioma', '2013-10-29 16:06:04', 2),
(219, 'detalle_tipo_hab', 25, 'editar_idioma', '2013-10-29 16:06:37', 2),
(220, 'detalle_tipo_hab', 26, 'editar_idioma', '2013-10-29 16:06:49', 2),
(221, 'detalle_tipo_hab', 25, 'eliminar_idioma', '2013-10-29 16:06:52', 2),
(222, 'detalle_tipo_hab', 26, 'editar_idioma', '2013-10-29 16:07:07', 2),
(223, 'detalle_tipo_hab', 27, 'editar_idioma', '2013-10-29 16:09:20', 2),
(224, 'detalle_tipo_hab', 26, 'editar_idioma', '2013-10-29 16:09:41', 2),
(225, 'detalle_tipo_hab', 27, 'eliminar_idioma', '2013-10-29 16:11:02', 2),
(226, 'detalle_tipo_hab', 26, 'eliminar_idioma', '2013-10-29 16:11:06', 2),
(227, 'detalle_tipo_hab', 28, 'editar_idioma', '2013-10-29 16:12:18', 2),
(228, 'detalle_tipo_hab', 29, 'editar_idioma', '2013-10-29 16:12:55', 2),
(229, 'detalle_tipo_hab', 29, 'eliminar_idioma', '2013-10-29 16:30:22', 2),
(230, 'detalle_tipo_hab', 28, 'eliminar_idioma', '2013-10-29 16:30:26', 2),
(231, 'detalle_tipo_hab', 30, 'editar_idioma', '2013-10-29 18:07:01', 2),
(232, 'detalle_tipo_hab', 31, 'editar_idioma', '2013-10-29 18:08:14', 2),
(233, 'detalle_tipo_hab', 31, 'editar_idioma', '2013-10-29 18:35:34', 2),
(234, 'detalle_tipo_hab', 30, 'eliminar_idioma', '2013-10-29 18:35:49', 2),
(235, 'detalle_tipo_hab', 31, 'eliminar_idioma', '2013-10-29 18:35:52', 2),
(236, 'banner', 0, 'crear', '2013-10-29 19:30:53', 2),
(237, 'banner', 2, 'editar', '2013-10-29 19:31:10', 2),
(238, 'servicio', 0, 'crear', '2013-10-29 19:34:44', 2),
(239, 'detalle_servicio', 14, 'editar_idioma', '2013-10-29 19:35:27', 2),
(240, 'detalle_servicio', 15, 'editar_idioma', '2013-10-29 19:37:17', 2),
(241, 'detalle_servicio', 15, 'eliminar_idioma', '2013-10-29 19:37:56', 2),
(242, 'servicio', 10, 'ficha', '2013-10-29 19:37:56', 2),
(243, 'detalle_servicio', 14, 'eliminar_idioma', '2013-10-29 19:38:29', 2),
(244, 'servicio', 10, 'ficha', '2013-10-29 19:38:30', 2),
(245, 'tipo_habitacion', 0, 'crear', '2013-10-29 20:15:57', 2),
(246, 'detalle_tipo_hab', 32, 'editar_idioma', '2013-10-29 20:16:36', 2),
(247, 'detalle_tipo_hab', 33, 'editar_idioma', '2013-10-29 20:17:18', 2),
(248, 'detalle_tipo_hab', 33, 'eliminar_idioma', '2013-10-29 20:17:34', 2),
(249, 'detalle_tipo_hab', 32, 'eliminar_idioma', '2013-10-29 20:17:37', 2),
(250, 'banner', 2, 'borrar', '2013-10-29 20:21:02', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `multimedia`
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
-- Volcado de datos para la tabla `multimedia`
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
-- Estructura de tabla para la tabla `newsletter`
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
-- Estructura de tabla para la tabla `noticia`
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
-- Volcado de datos para la tabla `noticia`
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
-- Estructura de tabla para la tabla `posada`
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
-- Volcado de datos para la tabla `posada`
--

INSERT INTO `posada` (`id_posada`, `Nombre`, `direccion`, `email_contacto`, `telefono_contacto`) VALUES
(1, 'Sol y Luna', 'Los Roques', 'solyluna@gmail.com', '+58412-765-3423');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
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
-- Estructura de tabla para la tabla `promocion`
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
-- Estructura de tabla para la tabla `receta`
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
-- Estructura de tabla para la tabla `rel_banner_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_banner_multimedia` (
  `id_banner` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_noticia` (`id_banner`,`id_multimedia`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rel_banner_multimedia`
--

INSERT INTO `rel_banner_multimedia` (`id_banner`, `id_multimedia`) VALUES
(1, 35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_categoria_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_categoria_multimedia` (
  `id_categoria` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_categoria` (`id_categoria`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_detalle_receta_tag`
--

CREATE TABLE IF NOT EXISTS `rel_detalle_receta_tag` (
  `id_detalle_receta` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL,
  KEY `id_receta` (`id_detalle_receta`),
  KEY `id_tag` (`id_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_habitacion_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_habitacion_multimedia` (
  `id_habitacion` bigint(20) unsigned NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_habitacion` (`id_habitacion`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rel_habitacion_multimedia`
--

INSERT INTO `rel_habitacion_multimedia` (`id_habitacion`, `id_multimedia`) VALUES
(5, 41),
(4, 42);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_noticia_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_noticia_multimedia` (
  `id_noticia` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_noticia` (`id_noticia`,`id_multimedia`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_posada_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_posada_multimedia` (
  `id_posada` bigint(20) unsigned NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_posada` (`id_posada`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_producto_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_producto_multimedia` (
  `id_producto` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  PRIMARY KEY (`id_producto`,`id_multimedia`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_producto_noticia`
--

CREATE TABLE IF NOT EXISTS `rel_producto_noticia` (
  `id_producto` int(11) NOT NULL,
  `id_noticia` int(11) NOT NULL,
  KEY `id_producto` (`id_producto`),
  KEY `id_noticia` (`id_noticia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_producto_producto`
--

CREATE TABLE IF NOT EXISTS `rel_producto_producto` (
  `id_producto` int(11) NOT NULL,
  `id_producto_relacionado` int(11) NOT NULL,
  KEY `id_producto` (`id_producto`),
  KEY `id_producto_relacionado` (`id_producto_relacionado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_producto_receta`
--

CREATE TABLE IF NOT EXISTS `rel_producto_receta` (
  `id_producto` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  KEY `id_producto` (`id_producto`),
  KEY `id_receta` (`id_receta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_promocion_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_promocion_multimedia` (
  `id_promocion` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_noticia` (`id_promocion`,`id_multimedia`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_receta_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_receta_multimedia` (
  `id_receta` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_multimedia` (`id_multimedia`),
  KEY `id_producto` (`id_receta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_servicio_habitacion`
--

CREATE TABLE IF NOT EXISTS `rel_servicio_habitacion` (
  `id_habitacion` bigint(20) unsigned NOT NULL,
  `id_servicio_habitacion` bigint(20) unsigned NOT NULL,
  KEY `id_habitacion` (`id_habitacion`),
  KEY `id_servicio_habitacion` (`id_servicio_habitacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_servicio_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_servicio_multimedia` (
  `id_servicio` int(11) NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  PRIMARY KEY (`id_servicio`,`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rel_servicio_multimedia`
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
-- Estructura de tabla para la tabla `rel_servicio_posada_multimedia`
--

CREATE TABLE IF NOT EXISTS `rel_servicio_posada_multimedia` (
  `id_servicio_posada` bigint(20) unsigned NOT NULL,
  `id_multimedia` int(11) NOT NULL,
  KEY `id_servicio_posada` (`id_servicio_posada`),
  KEY `id_multimedia` (`id_multimedia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservacion`
--

CREATE TABLE IF NOT EXISTS `reservacion` (
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservacion_habitacion`
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
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`) VALUES
(1, 'admin'),
(2, 'editor'),
(3, 'usuario'),
(4, 'inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE IF NOT EXISTS `servicio` (
  `id_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_servicio` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_servicio`),
  KEY `id_estado` (`id_estado`),
  KEY `id_tipo_servicio` (`id_tipo_servicio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id_servicio`, `id_tipo_servicio`, `id_estado`, `id_usuario`) VALUES
(1, 4, 1, 0),
(5, 4, 1, 0),
(6, 4, 1, 0),
(7, 2, 1, 0),
(8, 2, 1, 0),
(9, 5, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio_habitacion`
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
-- Estructura de tabla para la tabla `servicio_posada`
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
-- Estructura de tabla para la tabla `tag`
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
-- Estructura de tabla para la tabla `temporada`
--

CREATE TABLE IF NOT EXISTS `temporada` (
  `id_temporada` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id_temporada`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `temporada`
--

INSERT INTO `temporada` (`id_temporada`, `nombre`) VALUES
(1, 'Baja'),
(2, 'Alta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temporada_fecha`
--

CREATE TABLE IF NOT EXISTS `temporada_fecha` (
  `id_temporada_fecha` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  `id_temporada` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_temporada_fecha`),
  KEY `id_temporada` (`id_temporada`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `temporada_fecha`
--

INSERT INTO `temporada_fecha` (`id_temporada_fecha`, `inicio`, `fin`, `id_temporada`) VALUES
(1, '2013-01-11', '2013-07-14', 1),
(5, '2013-07-15', '2013-09-15', 2),
(6, '2013-09-16', '2013-12-08', 1),
(7, '2013-12-09', '2013-01-10', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testimonio`
--

CREATE TABLE IF NOT EXISTS `testimonio` (
  `id_testimonio` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_estado` int(11) NOT NULL DEFAULT '2',
  `nombre` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `comentario` text NOT NULL,
  `rating` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_testimonio`),
  KEY `id_estado` (`id_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `testimonio`
--

INSERT INTO `testimonio` (`id_testimonio`, `id_estado`, `nombre`, `email`, `comentario`, `rating`, `id_usuario`, `creado`) VALUES
(1, 2, 'Hector Jose Flores Colmenarez', 'hecto932@gmail.com', 'Excelente posada, super contento de haber estado con ustedes por un fin de semana, excelente atención, 100% recomendados!! gracias por todo!!', 5, NULL, '2013-09-27 19:21:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_categoria`
--

CREATE TABLE IF NOT EXISTS `tipo_categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `tipo_categoria`
--

INSERT INTO `tipo_categoria` (`id`, `nombre`) VALUES
(1, 'producto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_forma_pago`
--

CREATE TABLE IF NOT EXISTS `tipo_forma_pago` (
  `id_tipo_forma_pago` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_forma_pago`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `tipo_forma_pago`
--

INSERT INTO `tipo_forma_pago` (`id_tipo_forma_pago`, `descripcion`) VALUES
(1, 'Debito'),
(2, 'Credito'),
(3, 'Cheque'),
(4, 'Transferencia'),
(5, 'Efectivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_habitacion`
--

CREATE TABLE IF NOT EXISTS `tipo_habitacion` (
  `id_tipo_habitacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `personas` int(11) DEFAULT NULL,
  `id_estado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_tipo_habitacion`),
  KEY `id_estado` (`id_estado`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Volcado de datos para la tabla `tipo_habitacion`
--

INSERT INTO `tipo_habitacion` (`id_tipo_habitacion`, `personas`, `id_estado`, `id_usuario`) VALUES
(15, 2, 1, 2),
(16, 4, 1, 2),
(17, 1, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_multimedia`
--

CREATE TABLE IF NOT EXISTS `tipo_multimedia` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tipo_multimedia`
--

INSERT INTO `tipo_multimedia` (`id_tipo`, `nombre`) VALUES
(1, 'imagen'),
(2, 'banner'),
(3, 'video'),
(4, 'pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_servicio`
--

CREATE TABLE IF NOT EXISTS `tipo_servicio` (
  `id_tipo_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tipo` varchar(75) NOT NULL,
  PRIMARY KEY (`id_tipo_servicio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `tipo_servicio`
--

INSERT INTO `tipo_servicio` (`id_tipo_servicio`, `nombre_tipo`) VALUES
(1, 'hospedaje'),
(2, 'actividad'),
(3, 'gastronomia'),
(4, 'promocional'),
(5, 'transporte');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
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
-- Volcado de datos para la tabla `usuario`
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
-- Estructura de tabla para la tabla `usuario_front`
--

CREATE TABLE IF NOT EXISTS `usuario_front` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votacion`
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
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `categoria_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE,
  ADD CONSTRAINT `categoria_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `categoria_ibfk_3` FOREIGN KEY (`id_tipo_cat`) REFERENCES `tipo_categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `costo`
--
ALTER TABLE `costo`
  ADD CONSTRAINT `costo_ibfk_6` FOREIGN KEY (`id_detalle_tipo_habitacion`) REFERENCES `detalle_tipo_habitacion` (`id_detalle_tipo_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `costo_ibfk_4` FOREIGN KEY (`id_moneda`) REFERENCES `moneda` (`id_moneda`),
  ADD CONSTRAINT `costo_ibfk_5` FOREIGN KEY (`id_temporada`) REFERENCES `temporada` (`id_temporada`);

--
-- Filtros para la tabla `detalle_banner`
--
ALTER TABLE `detalle_banner`
  ADD CONSTRAINT `detalle_banner_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`);

--
-- Filtros para la tabla `detalle_categoria`
--
ALTER TABLE `detalle_categoria`
  ADD CONSTRAINT `detalle_categoria_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_categoria_ibfk_2` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_habitacion`
--
ALTER TABLE `detalle_habitacion`
  ADD CONSTRAINT `detalle_habitacion_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`),
  ADD CONSTRAINT `detalle_habitacion_ibfk_2` FOREIGN KEY (`id_habitacion`) REFERENCES `habitacion` (`id_habitacion`);

--
-- Filtros para la tabla `detalle_producto`
--
ALTER TABLE `detalle_producto`
  ADD CONSTRAINT `detalle_producto_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_producto_ibfk_2` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_receta`
--
ALTER TABLE `detalle_receta`
  ADD CONSTRAINT `detalle_receta_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_receta_ibfk_2` FOREIGN KEY (`id_receta`) REFERENCES `receta` (`id_receta`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_servicio`
--
ALTER TABLE `detalle_servicio`
  ADD CONSTRAINT `detalle_servicio_ibfk_5` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_servicio_ibfk_6` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_servicio_habitacion`
--
ALTER TABLE `detalle_servicio_habitacion`
  ADD CONSTRAINT `detalle_servicio_habitacion_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_servicio_habitacion_ibfk_2` FOREIGN KEY (`id_servicio_habitacion`) REFERENCES `servicio_habitacion` (`id_servicio_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_servicio_posada`
--
ALTER TABLE `detalle_servicio_posada`
  ADD CONSTRAINT `detalle_servicio_posada_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_servicio_posada_ibfk_2` FOREIGN KEY (`id_servicio_posada`) REFERENCES `servicio_posada` (`id_servicio_posada`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_tipo_habitacion`
--
ALTER TABLE `detalle_tipo_habitacion`
  ADD CONSTRAINT `detalle_tipo_habitacion_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_tipo_habitacion_ibfk_2` FOREIGN KEY (`id_tipo_habitacion`) REFERENCES `tipo_habitacion` (`id_tipo_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD CONSTRAINT `fk_habitacion_tipo_habitacion1` FOREIGN KEY (`id_tipo_habitacion`) REFERENCES `tipo_habitacion` (`id_tipo_habitacion`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `habitacion_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `habitacion_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `moneda`
--
ALTER TABLE `moneda`
  ADD CONSTRAINT `moneda_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `multimedia`
--
ALTER TABLE `multimedia`
  ADD CONSTRAINT `multimedia_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_multimedia` (`id_tipo`) ON DELETE CASCADE,
  ADD CONSTRAINT `multimedia_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `multimedia_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD CONSTRAINT `noticia_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `noticia_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `rel_categoria_multimedia`
--
ALTER TABLE `rel_categoria_multimedia`
  ADD CONSTRAINT `rel_categoria_multimedia_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE,
  ADD CONSTRAINT `rel_categoria_multimedia_ibfk_2` FOREIGN KEY (`id_multimedia`) REFERENCES `multimedia` (`id_multimedia`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rel_habitacion_multimedia`
--
ALTER TABLE `rel_habitacion_multimedia`
  ADD CONSTRAINT `rel_habitacion_multimedia_ibfk_1` FOREIGN KEY (`id_habitacion`) REFERENCES `habitacion` (`id_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rel_habitacion_multimedia_ibfk_2` FOREIGN KEY (`id_multimedia`) REFERENCES `multimedia` (`id_multimedia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rel_noticia_multimedia`
--
ALTER TABLE `rel_noticia_multimedia`
  ADD CONSTRAINT `rel_noticia_multimedia_ibfk_1` FOREIGN KEY (`id_noticia`) REFERENCES `noticia` (`id_noticia`) ON DELETE CASCADE,
  ADD CONSTRAINT `rel_noticia_multimedia_ibfk_2` FOREIGN KEY (`id_multimedia`) REFERENCES `multimedia` (`id_multimedia`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rel_posada_multimedia`
--
ALTER TABLE `rel_posada_multimedia`
  ADD CONSTRAINT `rel_posada_multimedia_ibfk_3` FOREIGN KEY (`id_posada`) REFERENCES `posada` (`id_posada`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rel_posada_multimedia_ibfk_4` FOREIGN KEY (`id_multimedia`) REFERENCES `multimedia` (`id_multimedia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rel_producto_multimedia`
--
ALTER TABLE `rel_producto_multimedia`
  ADD CONSTRAINT `rel_producto_multimedia_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `rel_producto_multimedia_ibfk_2` FOREIGN KEY (`id_multimedia`) REFERENCES `multimedia` (`id_multimedia`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rel_producto_noticia`
--
ALTER TABLE `rel_producto_noticia`
  ADD CONSTRAINT `rel_producto_noticia_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `rel_producto_noticia_ibfk_2` FOREIGN KEY (`id_noticia`) REFERENCES `noticia` (`id_noticia`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rel_producto_producto`
--
ALTER TABLE `rel_producto_producto`
  ADD CONSTRAINT `rel_producto_producto_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `rel_producto_producto_ibfk_2` FOREIGN KEY (`id_producto_relacionado`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rel_producto_receta`
--
ALTER TABLE `rel_producto_receta`
  ADD CONSTRAINT `rel_producto_receta_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `rel_producto_receta_ibfk_2` FOREIGN KEY (`id_receta`) REFERENCES `receta` (`id_receta`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rel_servicio_habitacion`
--
ALTER TABLE `rel_servicio_habitacion`
  ADD CONSTRAINT `rel_servicio_habitacion_ibfk_1` FOREIGN KEY (`id_habitacion`) REFERENCES `habitacion` (`id_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rel_servicio_habitacion_ibfk_2` FOREIGN KEY (`id_servicio_habitacion`) REFERENCES `servicio_habitacion` (`id_servicio_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rel_servicio_posada_multimedia`
--
ALTER TABLE `rel_servicio_posada_multimedia`
  ADD CONSTRAINT `rel_servicio_posada_multimedia_ibfk_1` FOREIGN KEY (`id_servicio_posada`) REFERENCES `servicio_posada` (`id_servicio_posada`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rel_servicio_posada_multimedia_ibfk_2` FOREIGN KEY (`id_multimedia`) REFERENCES `multimedia` (`id_multimedia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservacion`
--
ALTER TABLE `reservacion`
  ADD CONSTRAINT `reservacion_ibfk_1` FOREIGN KEY (`id_usuario_front`) REFERENCES `usuario_front` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservacion_ibfk_2` FOREIGN KEY (`id_tipo_forma_pago`) REFERENCES `tipo_forma_pago` (`id_tipo_forma_pago`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reservacion_ibfk_3` FOREIGN KEY (`id_estado_activo`) REFERENCES `estado_activo` (`id_estado_activo`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reservacion_ibfk_4` FOREIGN KEY (`id_estado_reservacion`) REFERENCES `estado_reservacion` (`id_estado_reservacion`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservacion_habitacion`
--
ALTER TABLE `reservacion_habitacion`
  ADD CONSTRAINT `fk_reservacion_has_habitacion_habitacion1` FOREIGN KEY (`id_habitacion`) REFERENCES `habitacion` (`id_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservacion_has_habitacion_reservacion1` FOREIGN KEY (`id_reservacion`) REFERENCES `reservacion` (`id_reservacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `servicio_ibfk_1` FOREIGN KEY (`id_tipo_servicio`) REFERENCES `tipo_servicio` (`id_tipo_servicio`) ON UPDATE CASCADE,
  ADD CONSTRAINT `servicio_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicio_habitacion`
--
ALTER TABLE `servicio_habitacion`
  ADD CONSTRAINT `servicio_habitacion_ibfk_1` FOREIGN KEY (`id_estado_activo`) REFERENCES `estado_activo` (`id_estado_activo`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `servicio_habitacion_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicio_posada`
--
ALTER TABLE `servicio_posada`
  ADD CONSTRAINT `servicio_posada_ibfk_1` FOREIGN KEY (`id_posada`) REFERENCES `posada` (`id_posada`) ON UPDATE CASCADE,
  ADD CONSTRAINT `servicio_posada_ibfk_2` FOREIGN KEY (`id_estado_activo`) REFERENCES `estado_activo` (`id_estado_activo`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `servicio_posada_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `tag`
--
ALTER TABLE `tag`
  ADD CONSTRAINT `tag_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE,
  ADD CONSTRAINT `tag_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE;

--
-- Filtros para la tabla `temporada_fecha`
--
ALTER TABLE `temporada_fecha`
  ADD CONSTRAINT `temporada_fecha_ibfk_1` FOREIGN KEY (`id_temporada`) REFERENCES `temporada` (`id_temporada`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD CONSTRAINT `testimonio_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `tipo_habitacion`
--
ALTER TABLE `tipo_habitacion`
  ADD CONSTRAINT `tipo_habitacion_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `tipo_habitacion_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_estado_usuario`) REFERENCES `estado_usuario` (`id_estado_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
