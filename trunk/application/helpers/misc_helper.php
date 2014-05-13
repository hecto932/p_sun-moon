<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//PASAR FECHAS DE FORMATO DD-MM-AAAA a AAAA-MM-DD
function sql_format_date($fecha_in, $fecha_out)
{
	//Fecha in: pasar de dd-mm-aaaa H:i:s a aaaa-mm-aa H:i:s 
	list($d, $m, $anio_hora) 	= explode('-', $fecha_in);
	list($a, $hora)				= explode(' ', $anio_hora);
	$fecha_in					= implode('-', array($a, $m, $d));
	$fecha_in					.= ' ' . $hora;
	
	//Fecha out: pasar de dd-mm-aaaa H:i:s a aaaa-mm-aa H:i:s 
	list($d, $m, $anio_hora) 	= explode('-', $fecha_out);
	list($a, $hora)				= explode(' ', $anio_hora);
	$fecha_out					= implode('-', array($a, $m, $d));
	
	$result = array(
		"checkin"	=> $fecha_in,
		"checkout"	=> $fecha_out
	);
	
	return $result;
}

function mes_letras($mes)
{
	$mes = intval($mes);
	
    switch ($mes)
    {
        case 1:
            return "Enero";
        case 2:
            return "Febrero";
        case 3:
            return "Marzo";
        case 4:
            return "Abril";
        case 5:
            return "Mayo";
        case 6:
            return "Junio";
        case 7:
            return "Julio";
        case 8:
            return "Agosto";
        case 9:
            return "Septiembre";
        case 10:
            return "Octubre";
        case 11:
            return "Noviembre";
        case 12:
            return "Diciembre";
        default:
            return lang('sin_datos');
    }
}

/**
 * 
 * Hace <pre>print_r de un array con die
 * 
 * @author Ale
 */
function die_pre($array = array())
{
    die("<pre>die_pre:<br />".print_r($array, TRUE)."<br />/die_pre</pre>");
}

function pre($array = array())
{
    echo "<pre>die_pre:<br />".print_r($array, TRUE)."<br />/die_pre</pre>";
}

/*
 * La siguiente función se encarga de crear
 * dos arreglos desde @a hasta @b.
 *
 * */

function destacado_dropdown() {
	$array_destacado = array_combine(range(1, 100), range(1, 100));
	return $array_destacado;

}

/*	La función idioma_values se encarga
 *  de determinar el valor de un input
 * 	en el formulario de creación/edicción
 *	de detalles.
 *
 *  @set_value contiene el valor de la forma de error de CI
 * 	@accion contiene la acción que se realiza en dichos momentos
 *  @variable contiene el valor de la variable del evento
 * 	EJEMPLO:
 * 	$noticia->nombre.
 *
 * */

function idioma_values($set_value, $variable, $accion) {
	if($accion == 'normal' && $set_value == ''){
		return '';
	}
	elseif($accion == 'normal' && $set_value != ''){
		return $set_value;
	}
	elseif($accion == 'editar' && $set_value == '' && $variable != ''){
		return $variable;
	}
	else{
		return $set_value;
	}
}

/*
 *
 *
 *
 *
 * */


function get_tipo_eventos()
{
	$CI =& get_instance();
	$CI->load->model('evento/evento_model');
	$CI->config->set_item('language', 'es');
	$CI->lang->load('back');
	$tipo_eventos = array();
	$temp = $CI->evento_model->get_tipo_evento();
	foreach($temp as $value){
			$tipo_eventos[$value->id_tipo_evento] =  $CI->lang->line('eventos_tipo_'.$value->id_tipo_evento);
	}
	return $tipo_eventos;
}

function ordenar_servicios($servicios){
	
	
	
	$result = array();
	foreach($servicios as $servicio)
	{
		$result[$servicio->id_tipo_servicio][] = $servicio;
	}
	return $result;
}

function servicio_dropdown($tipo_servicio, $idioma = 'es'){
	$CI =& get_instance();
	$CI->config->set_item('language', $idioma);
	$CI->lang->load('back');
	$temp = array();
	foreach($tipo_servicio as $tipo){
			$temp[$tipo->id_tipo_servicio] = lang('servicio_'.$tipo->nombre_tipo);
	}
	return $temp;
}

function habitacion_dropdown($tipo_habitacion, $idioma = 'es'){
	$temp = array();
	foreach($tipo_habitacion as $tipo){
			$temp[$tipo->id_tipo_habitacion] = $tipo->nombre;
	}
	return $temp;
}

/*
 *	La siguiente función obtiene la dirección
 *  de la primera imagen disponible de un objeto
 *
 *
 *
 * */

function get_dir_imagen($principal, $secundarias, $terciarias){
 	if(isset($principal) && !empty($principal))
	{
		$fichero = $principal[0]->fichero;
		$direccion = base_url().'assets/front/img/large/'.$fichero;
	}
	elseif(isset($secundarias) && !empty($secundarias))
	{
		$fichero = $secundarias[0]->fichero;
		$direccion = base_url().'assets/front/img/large/'.$fichero;
	}
	elseif(isset($terciarias) && !empty($terciarias))
	{
		$fichero = $terciarias[0]->fichero;
		$direccion = base_url().'assets/front/img/large/'.$terciarias;
	}
	else
	{
		$direccion = base_url().'assets/back/img/template/placeholder_med.jpg';
	}
	return $direccion;
}


function get_info_imagen($principal, $secundarias, $terciarias, $idioma = 'es'){
	$imagen = new stdClass();
	$CI =& get_instance();
	$CI->config->set_item('language', $idioma);
	$CI->lang->load('back');
	if(isset($principal) && !empty($principal)){
		$imagen->fichero = substr($principal[0]->fichero, 0, strpos($principal[0]->fichero,'.'));
		$imagen->extension = strtolower(substr(strrchr($principal[0]->fichero,'.'), 1));
		$imagen->dia = date("d/m/Y", strtotime($principal[0]->actualizado));
		$imagen->hora = date("H:i:s", strtotime($principal[0]->actualizado));
		$imagen->destacado = lang('imagen_t'.$principal[0]->destacado);
	}
	elseif(isset($secundarias) && !empty($secundarias)){
		$imagen->fichero = substr($secundarias[0]->fichero, 0, strpos($secundarias[0]->fichero,'.'));
		$imagen->extension = strtolower(substr(strrchr($secundarias[0]->fichero,'.'), 1));
		$imagen->dia = date("d/m/Y", strtotime($secundarias[0]->actualizado));
		$imagen->hora = date("H:i:s", strtotime($secundarias[0]->actualizado));
		$imagen->timestamp = strtotime($secundarias[0]->actualizado);
		$imagen->destacado = lang('imagen_t'.$secundarias[0]->destacado);
	}
	elseif(isset($terciarias) && !empty($terciarias)){
		$imagen->fichero = substr($terciarias[0]->fichero, 0, strpos($terciarias[0]->fichero,'.'));
		$imagen->extension = strtolower(substr(strrchr($terciarias[0]->fichero,'.'), 1));
		$imagen->dia = date("d/m/Y", strtotime($terciarias[0]->actualizado));
		$imagen->hora = date("H:i:s", strtotime($terciarias[0]->actualizado));
		$imagen->timestamp = strtotime($terciarias[0]->actualizado);
		$imagen->destacado = lang('imagen_t'.$terciarias[0]->destacado);
	}
	else{
		$imagen->fichero = 'N/A';
		$imagen->extension = 'N/A';
		$imagen->dia = 'N/A';
		$imagen->hora = 'N/A';
		$imagen->timestamp = 'N/A';
		$imagen->destacado = 'N/A';
	}
	return $imagen;
}

/*
 *	La función se encarga de retornar el tamaño
 *	de un documento
 *
 * */


function get_documento_size($dir, $fichero, $decimal = 2){
	$bytes = filesize($dir.$fichero);
	$size = array('Bytes','KB','MB','GB','TB','PB','EB','ZB','YB');
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimal}f ", $bytes / pow(1024, $factor)) . @$size[$factor];
}

if ( ! function_exists('die_pre'))
{
	function die_pre($data = array())
	{
		die("<pre>".print_r($data, TRUE)."</pre>");
	}
}

if (! function_exists('query_arrow'))
{
	function query_arrow($field, $field_value, $new_order)
	{
		if ($field == $field_value && $new_order == 'asc')
			return ' '.img('assets/back/img/template/arrow-down.png');
		else if ($field == $field_value && $new_order == 'desc')
			return ' '.img('assets/back/img/template/arrow-up.png');
		else
			return '';
	}
}

/**
 * 
 * Devuelve un subarray de clases que cumplan con el valor especificado de cierta propiedad
 * 
 * @param unknown_type $array
 * @param unknown_type $property
 * @param unknown_type $value
 */
function where($array, $property, $value, $sorted = FALSE)
{
	
	$temp = array();
	$i = 0;
	if (is_array($array))
	{
		$last_value = NULL;
		foreach ($array as $pos)
		{
			if (($value != 'NULL' && $pos->$property == $value) || ($value == 'NULL' && is_null($pos->$property)))
			{
				$temp[] = $pos;
				$i++;
			}
			
			if ($sorted && ! is_null($last_value) && $i > 1 && $pos->$property != $last_value)
				break;
				
			$last_value = $pos->$property;
		}
	}
	
	return $temp;
	
}

function filtrar($target = array(), $filtros = '', $sufijo = '')
{
	$temp = $target;
    
    $filtros = preg_replace("/^:/", "", $filtros);
    $filtros = preg_replace("/:$/", "", $filtros);
	
	//Si es AND
	if (preg_match("/.:./", $filtros))
	{
		$filtros = preg_split("/:/", $filtros);
		
		//Aplicar cada filtro en orden
		foreach ($filtros as $filtro)
		{            
			//Si es un !=
			if (preg_match("/.!=./", $filtro))
			{
				$filtro = preg_split("/!=/", $filtro);
				if (array_key_exists(0, $temp) && property_exists($temp[0], trim($filtro[0]).$sufijo))
					$temp = where_not($temp, trim($filtro[0]).$sufijo, trim($filtro[1]));
				else
					$temp = where_not($temp, trim($filtro[0]), trim($filtro[1]));
			}
			
			//Si es un >=
			else if (preg_match("/.>=./", $filtro))
			{
				$filtro = preg_split("/>=/", $filtro);
				if (array_key_exists(0, $temp) && property_exists($temp[0], trim($filtro[0]).$sufijo))
					$temp = where_mayor($temp, trim($filtro[0]).$sufijo, trim($filtro[1]), TRUE);
				else
					$temp = where_mayor($temp, trim($filtro[0]), trim($filtro[1]), TRUE);
			}
			
			//Si es un <=
			else if (preg_match("/.<=./", $filtro))
			{
				$filtro = preg_split("/<=/", $filtro);
				if (array_key_exists(0, $temp) && property_exists($temp[0], trim($filtro[0]).$sufijo))
					$temp = where_menor($temp, trim($filtro[0]).$sufijo, trim($filtro[1]), TRUE);
				else
					$temp = where_menor($temp, trim($filtro[0]), trim($filtro[1]), TRUE);
			}
			
			//Si es un <
			else if (preg_match("/.<./", $filtro))
			{
				$filtro = preg_split("/</", $filtro);
				if (array_key_exists(0, $temp) && property_exists($temp[0], trim($filtro[0]).$sufijo))
					$temp = where_menor($temp, trim($filtro[0]).$sufijo, trim($filtro[1]));
				else
					$temp = where_menor($temp, trim($filtro[0]), trim($filtro[1]));
			}
            
            //Si es un =
            else if (preg_match("/.=./", $filtro))
            {
                $filtro = preg_split("/=/", $filtro);
                if (array_key_exists(0, $temp) && property_exists($temp[0], trim($filtro[0]).$sufijo))
                    $temp = where($temp, trim($filtro[0]).$sufijo, trim($filtro[1]));
                else
                    $temp = where($temp, trim($filtro[0]), trim($filtro[1]));
            }
            
            //Si es un >
            else if (preg_match("/.>./", $filtro))
            {
                $filtro = preg_split("/>/", $filtro);
                if (array_key_exists(0, $temp) && property_exists($temp[0], trim($filtro[0]).$sufijo))
                    $temp = where_mayor($temp, trim($filtro[0]).$sufijo, trim($filtro[1]));
                else
                    $temp = where_mayor($temp, trim($filtro[0]), trim($filtro[1]));
            }
		}
		
		return is_array($temp) ? $temp : array();
	}
	
	//Es OR
	else if (preg_match("/.;./", $filtros))
	{
		$filtros 	= preg_split("/;/", $filtros);
		$temp 		= array();
		
		//Aplicar cada filtro en orden
		foreach ($filtros as $filtro)
		{
			//Si es un !=
			if (preg_match("/.!=./", $filtro))
			{
				$filtro = preg_split("/!=/", $filtro);
				if (array_key_exists(0, $target) && property_exists($target[0], $filtro[0].$sufijo)) {
					foreach (where_not($target, trim($filtro[0]).$sufijo, trim($filtro[1])) as $valor) {
						if ( ! in_array($valor, $temp))
							$temp[] = $valor;
					}
				}
				else {
					foreach (where_not($target, trim($filtro[0]), trim($filtro[1])) as $valor) {
						if ( ! in_array($valor, $temp))
							$temp[] = $valor;
					}
				}
			}
			
			//Si es un >=
			else if (preg_match("/.>=./", $filtro))
			{
				$filtro = preg_split("/>=/", $filtro);
				if (array_key_exists(0, $target) && property_exists($target[0], $filtro[0].$sufijo)) {
					foreach (where_mayor($target, trim($filtro[0]).$sufijo, trim($filtro[1]), TRUE) as $valor) {
						if ( ! in_array($valor, $temp))
							$temp[] = $valor;
					}
				}
				else {
					foreach (where_mayor($target, trim($filtro[0]), trim($filtro[1]), TRUE) as $valor) {
						if ( ! in_array($valor, $temp))
							$temp[] = $valor;
					}
				}
			}
			
			//Si es un <=
			else if (preg_match("/.<=./", $filtro))
			{
				$filtro = preg_split("/<=/", $filtro);
				if (array_key_exists(0, $target) && property_exists($target[0], $filtro[0].$sufijo)) {
					foreach (where_menor($target, trim($filtro[0]).$sufijo, trim($filtro[1]), TRUE) as $valor) {
						if ( ! in_array($valor, $temp))
							$temp[] = $valor;
					}
				}
				else {
					foreach (where_menor($target, trim($filtro[0]), trim($filtro[1]), TRUE) as $valor) {
						if ( ! in_array($valor, $temp))
							$temp[] = $valor;
					}
				}
			}
			
			//Si es un <
			else if (preg_match("/.<./", $filtro))
			{
				$filtro = preg_split("/</", $filtro);
				if (array_key_exists(0, $target) && property_exists($target[0], $filtro[0].$sufijo)) {
					foreach (where_menor($target, trim($filtro[0]).$sufijo, trim($filtro[1])) as $valor) {
						if ( ! in_array($valor, $temp))
							$temp[] = $valor;
					}
				}
				else {
					foreach (where_menor($target, trim($filtro[0]), trim($filtro[1])) as $valor) {
						if ( ! in_array($valor, $temp))
							$temp[] = $valor;
					}
				}
			}
            
            //Si es un =
            else if (preg_match("/.=./", $filtro))
            {
                $filtro = preg_split("/=/", $filtro);
                if (array_key_exists(0, $target) && property_exists($target[0], $filtro[0].$sufijo)) {
                    foreach (where($target, trim($filtro[0]).$sufijo, trim($filtro[1])) as $valor) {
                        if ( ! in_array($valor, $temp))
                            $temp[] = $valor;
                    }
                }
                else {
                    foreach (where($target, trim($filtro[0]), trim($filtro[1])) as $valor) {
                        if ( ! in_array($valor, $temp))
                            $temp[] = $valor;
                    }
                }
            }
            
            //Si es un >
            else if (preg_match("/.>./", $filtro))
            {
                $filtro = preg_split("/>/", $filtro);
                if (array_key_exists(0, $target) && property_exists($target[0], $filtro[0].$sufijo)) {
                    foreach (where_mayor($target, trim($filtro[0]).$sufijo, trim($filtro[1])) as $valor) {
                        if ( ! in_array($valor, $temp))
                            $temp[] = $valor;
                    }
                }
                else {
                    foreach (where_mayor($target, trim($filtro[0]), trim($filtro[1])) as $valor) {
                        if ( ! in_array($valor, $temp))
                            $temp[] = $valor;
                    }
                }
            }
		}
		
		return is_array($temp) ? $temp : array();
		
	}
	
	//Si no hay separadores
	else if (strlen($filtros))
	{
	    //Quitar separadores al final de la cadena si existen
	    $filtros = preg_replace("/(;|:)$/", "", $filtros);
        
		//Si es un !=
		if (preg_match("/.!=./", $filtros))
		{
			$filtro = preg_split("/!=/", $filtros);
			if (array_key_exists(0, $temp) && property_exists($temp[0], trim($filtro[0]).$sufijo))
				$temp = where_not($temp, trim($filtro[0]).$sufijo, trim($filtro[1]));
			else
				$temp = where_not($temp, trim($filtro[0]), trim($filtro[1]));
		}
		
		//Si es un >=
		else if (preg_match("/.>=./", $filtros))
		{
			$filtro = preg_split("/>=/", $filtros);
			if (array_key_exists(0, $temp) && property_exists($temp[0], trim($filtro[0]).$sufijo))
				$temp = where_mayor($temp, trim($filtro[0]).$sufijo, trim($filtro[1]), TRUE);
			else
				$temp = where_mayor($temp, trim($filtro[0]), trim($filtro[1]), TRUE);
		}
        
        //Si es un <=
        else if (preg_match("/.<=./", $filtros))
        {
            $filtro = preg_split("/<=/", $filtros);
            if (array_key_exists(0, $temp) && property_exists($temp[0], trim($filtro[0]).$sufijo))
                $temp = where_menor($temp, trim($filtro[0]).$sufijo, trim($filtro[1]), TRUE);
            else
                $temp = where_menor($temp, trim($filtro[0]), trim($filtro[1]), TRUE);
        }
		
		//Si es un >
		else if (preg_match("/.>./", $filtros))
		{
			$filtro = preg_split("/>/", $filtros);
			if (array_key_exists(0, $temp) && property_exists($temp[0], trim($filtro[0]).$sufijo))
				$temp = where_mayor($temp, trim($filtro[0]).$sufijo, trim($filtro[1]));
			else
				$temp = where_mayor($temp, trim($filtro[0]), trim($filtro[1]));
		}
        
        //Si es un =
        else if (preg_match("/.=./", $filtros))
        {
            $filtro = preg_split("/=/", $filtros);          
            if (array_key_exists(0, $temp) && property_exists($temp[0], trim($filtro[0]).$sufijo))
                $temp = where($temp, trim($filtro[0]).$sufijo, trim($filtro[1]));
            else
                $temp = where($temp, trim($filtro[0]), trim($filtro[1]));
        }
		
		//Si es un <
		else if (preg_match("/.<./", $filtros))
		{
			$filtro = preg_split("/</", $filtros);
			if (array_key_exists(0, $temp) && property_exists($temp[0], trim($filtro[0]).$sufijo))
				$temp = where_menor($temp, trim($filtro[0]).$sufijo, trim($filtro[1]));
			else
				$temp = where_menor($temp, trim($filtro[0]), trim($filtro[1]));
		}
		
		return is_array($temp) ? $temp : array();
	}
	
	else
		return is_array($temp) ? $temp : array();
	
}

/**
 * 
 * Distintos valores en un array de objetos para una propiedad específica
 * 
 */
function distintos($array, $propiedad)
{
	$temp = array();
	
	foreach ($array as $objeto) {
		if ( ! in_array($objeto->$propiedad, $temp))
			$temp[] = $objeto->$propiedad;
	}
	
	return $temp;
}

function flip_timestamp($fecha)
{
	list($d, $m, $anio_hora) 	= explode('-', $fecha);
	list($a, $hora)				= explode(' ', $anio_hora);
	$fecha						= implode('-', array($a, $m, $d));
	$fecha						.= ' ' . $hora;
	
	return $fecha;
}

function flip_fecha($fecha)
{
	list($d, $m, $a) 	= explode('-', $fecha);
	$fecha				= implode('-', array($a, $m, $d));
	
	return $fecha;
}

function quitar_seg_timestamp($fecha)
{
	list($fecha, $hora) = explode(' ', $fecha);
	list($h, $i, $s) = explode(':', $hora);
	
	return $fecha.' '.$h.':'.$i;
}

function dropdown($result, $campo_id, $campos_valor, $separador = '-', $dummy = FALSE, $dummy_text = '', $dummy_ultimo = FALSE)
{
	$dropdown = array();
	if ($dummy && ! $dummy_ultimo) $dropdown[-1] = $dummy_text;
	
	foreach ($result as $objeto)
	{
		$dropdown[$objeto->$campo_id] = '';
		
		if (is_array($campos_valor))
		{
			$size = count($campos_valor);
			for ($i = 0; $i < $size; $i++)
			{
				$dropdown[$objeto->$campo_id] .= $objeto->$campos_valor[$i];
				if ($i < $size-1) $dropdown[$objeto->$campo_id] .= $separador;
			}
		}
		else
			$dropdown[$objeto->$campo_id] = $objeto->$campos_valor;
	}
    
    if ($dummy && $dummy_ultimo) $dropdown[-1] = $dummy_text;
		
	return $dropdown;
	
}