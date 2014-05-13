<?php

/******************************************************************
 * Crontrolador principal del sistema
 * 
 * Se encarga de cargar la vista principal del sistema
 */

class Site extends CI_Controller {
	
	function __construc()
	{
		parent::__construc();
	}
	
	function index ()
	{
		//Se carga la vista principal y se indica que el contenido
		//principal el la pagina de inicio.
		
		$data['contenido_principal'] = 'principal';
		$this->load->view('front/site_view', $data);
	}
}

?>