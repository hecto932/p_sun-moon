<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function format_evento($evento, $idioma = "es"){
		$CI =& get_instance();
		$CI->config->set_item('language', $idioma);
		$CI->lang->load('back');

		/*
		* 	Formateo del precio del evento
		* 	Si precio_evento < 0: Sin Asignar
		* 	Si precio_evento = 0: Libre / Gratuito
		* 	Si precio_evento > 0: Costo.
		*
		* */

		$evento->precio_evento = ($evento->precio_evento == 0) ? $CI->lang->line('precio_libre') : (($evento->precio_evento < 0) ? $CI->lang->line('precio_nasig') : $evento->precio_evento.' '.$CI->lang->line('moneda_simbolo')) ;

		/*
		* 	Formateo de la fecha del evento en formato
		* { Día(Lunes..Domingo), Día (01..31) de Més (Enero..Diciembre) de Año }
		*
		* */

		$base_fecha = strtotime($evento->fecha_evento);
		$dia = $CI->lang->line('dia_'.date('N', $base_fecha));
		$fecha_dia = date('d', $base_fecha);
		$mes = ' '.$CI->lang->line('mes_'.date('n', $base_fecha)).' ';
		$anyo = date(' Y', $base_fecha);
		$evento->fecha_eventof = $dia.', '.$fecha_dia.$mes.$CI->lang->line('prep_de').$anyo;

		$base_hora = strtotime($evento->hora_evento);
		$evento->hora_evento = date('g:i A', $base_hora).' / '.date('G:i', $base_hora).' '.$CI->lang->line('horas_abrv');


		/*
		* 	Formateo de la fecha de la actualizacion del evento en formato
		* { Día (01..31) de Més (Enero..Diciembre) de Año }
		*
		* */

		$base_fecha = strtotime($evento->modificado);
		$dia = date('d', $base_fecha);
		$mes = ' '.$CI->lang->line('mes_'.date('n', $base_fecha)).' ';
		$anyo = date(' Y', $base_fecha);
		$evento->fecha_modificado = $dia.$mes.$CI->lang->line('prep_de').$anyo;

		return $evento;
}

function format_pagos($pagos, $idioma = 'es'){
	$CI =& get_instance();
	$CI->config->set_item('language', $idioma);
	$CI->lang->load('back');
	$modos = '';
	foreach($pagos as $key => $value){
		$modos .= $CI->lang->line('eventos.pago_'.$key).', ';
	}

	$modos[strripos($modos, ',')] = '.';
	return $modos;
}
