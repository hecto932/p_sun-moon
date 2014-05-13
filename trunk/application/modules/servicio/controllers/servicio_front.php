<?php

class Servicio_front extends MX_Controller {


	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('idioma') == '') $this->session->set_userdata('idioma','es');
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$this->id_idioma = modules::run('idioma/get_idioma_id_from_code',$this->session->userdata('idioma'));
		$this->load->model('servicio/servicio_model');
		$this->lang->load('front', 'es');
	}


	function index($function='nosotros',$id='')
	{
		$this->servicios();
	}
	
	
	function get_services($idioma)
	{
		return $this->servicio_model->get_servicios_tipo($idioma);
	}
	
	function num_services($idioma)
	{
		return $this->servicio_model->get_servicios_tipo_rows($idioma);
	}
	
	function servicios($id_tipo_servicio = '')
	{
		//Consultar servicios por tipo
		$servicios = $this->servicio_model->get_servicios_tipo('es');
		
		//Servicios por tipo
		$data['servicios'] = $servicios;
		
		//Tipos de servicios
		$ids_tipo_servicio = distintos($servicios, 'id_tipo_servicio');
		foreach($ids_tipo_servicio as $tipo_servicio)
		{
			$filtro = filtrar($servicios, "id_tipo_servicio=$tipo_servicio");
			$tipos_servicios[] = array('id_tipo_servicio' => $filtro[0]->id_tipo_servicio, 'nombre_tipo' => $filtro[0]->nombre_tipo);
		}
		$data['tipos_servicio'] = $tipos_servicios;
		
		if($id_tipo_servicio != '' && is_numeric($id_tipo_servicio))
		{
			$servcios_tipo = filtrar($servicios, "id_tipo_servicio=$id_tipo_servicio");
			$data['servicios'] = $servcios_tipo;
			$data['selected_tipo'] = $id_tipo_servicio;
		}
		
		$data['title'] 	= lang('front_title.servicios');
		$data['active'] = lang('front_menu.servicios');
		
		//breadcrumbs
		$data['breadcrumbs'] = array(
										lang('front_menu.inicio') 		=> lang('front.inicio_url'),
										lang('front_menu.servicios') 	=> lang('front.servicios_url')
									);
		
		$data['contenido_principal'] = $this->load->view('front/servicios',$data,true);
		$this->load->view('front/template',$data);
	}
	
	/*
	 * Detalle del servicio
	 * 
	 * */
	function detalle($id_servicio)
	{
		
		//Consultar servicios por tipo
		$servicios = $this->servicio_model->get_servicios_tipo('es');
		
		//Tipos de servicios
		$ids_tipo_servicio = distintos($servicios, 'id_tipo_servicio');
		foreach($ids_tipo_servicio as $tipo_servicio)
		{
			$filtro = filtrar($servicios, "id_tipo_servicio=$tipo_servicio");
			$tipos_servicios[] = array('id_tipo_servicio' => $filtro[0]->id_tipo_servicio, 'nombre_tipo' => $filtro[0]->nombre_tipo);
		}
		$data['tipos_servicio'] = $tipos_servicios;
		
		
		$data['detalle_servicio'] 	= $this->servicio_model->get_datos_servicio($id_servicio, 'es');
		
		$data['imagenes'] 			= $data['detalle_servicio']['multimedia'];
		$data['title'] 				= $data['detalle_servicio']['titulo_pagina'];
		$data['active'] 			= lang('front_menu.servicios');
		
		//breadcrumbs
		$data['breadcrumbs'] = array(
										lang('front_menu.inicio') 			=> lang('front.inicio_url'),
										lang('front_menu.servicios') 		=> lang('front.servicios_url'),
										$data['detalle_servicio']['nombre']	=> lang('front.servicio_url').'/'.lang('front.detalle_url').'/'.$id_servicio
									);
		//die_pre($data);
		$data['contenido_principal'] = $this->load->view('front/detalle-servicio',$data,true);
		$this->load->view('front/template',$data);
	}

}
/* End of file servicios_front.php */
