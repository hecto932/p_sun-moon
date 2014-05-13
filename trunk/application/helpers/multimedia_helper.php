<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * Este helper ayuda con ciertas tareas relacionados a los elementos multimedia del sitio
 * @author Alejandro
 * */


function generate_thumbs($img='', $object, $type, $attr, $input, $actual=false) {
	$html = '';
	$alt = (isset($object->$attr)) ? 'Ficha de ' . $object->$attr : ucwords($type) . ' sin ' . $attr;
	$act_img = '';
	if (isset($img) && is_array($img) && !empty($img)) {
		foreach($img as $k => $im) {
			if($actual) $act_img = '<input type="hidden" name="' . $input . '" value="' . $im->id_multimedia . '" />';
			$html .= 
			$act_img . '<div id="imagen_' . $im->id_multimedia . '" class="boxgrid captionfull">' .
			'<img src="/assets/front/img/thumb/' . $im->fichero . '" alt="' . $alt . ' " width="100" height="60" />' .
			'<div class="cover boxcaption"><img onclick="eliminarMultimedia(\'' . $im->id_multimedia . '\'); " href="javascript:void(0)" src="../../../../assets/back/assets/css/images/close_img.png"/>' .
			'</div></div>';
			/*$html .= 
			'<li id="imagen_' . $im->id_multimedia . '">'.$act_img.'
				<img src="/assets/front/img/thumb/' . $im->fichero . '" alt="' . $alt . '" width="50"/> 
				<a class="eliminar" href="javascript:void(0)" onclick="eliminarMultimedia(\'' . $im->id_multimedia . '\');">X</a>
			</li>';*/
		}
	}
	
	return $html;
	
}

function generate_thumbs_2($img='', $object, $type, $attr, $input, $name, $actual=false) {
	$html = '';
	$alt = (isset($object->$attr)) ? 'Ficha de ' . $object->$attr : ucwords($type) . ' sin ' . $attr;
	$act_img = '';
	if (isset($img) && is_array($img) && !empty($img)) {
		foreach($img as $k => $im) {
			if($actual) $act_img = '<input type="hidden" name="' . $input . '" value="' . $im->id_multimedia . '" />';
			$html .= 
			$act_img . '<div id="imagen_' . $im->id_multimedia . '" class="boxgrid captionfull" name="' . $name . '">' .
			'<img src="/assets/front/img/thumb/' . $im->fichero . '" alt="' . $alt . ' " width="100" height="60" />' .
			'<div class="cover boxcaption"><img onclick="eliminarMultimedia(\'' . $im->id_multimedia . '\'); " href="javascript:void(0)" src="../../../../assets/back/assets/css/images/close_img.png"/>' .
			'</div></div>';
			/*$html .= 
			'<li id="imagen_' . $im->id_multimedia . '">'.$act_img.'
				<img src="/assets/front/img/thumb/' . $im->fichero . '" alt="' . $alt . '" width="50"/> 
				<a class="eliminar" href="javascript:void(0)" onclick="eliminarMultimedia(\'' . $im->id_multimedia . '\');">X</a>
			</li>';*/
		}
	}
	
	return $html;	
}
