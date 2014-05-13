<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * Controlador temporadas
 * @author mvlg
 *
 */
class Temporada extends MX_Controller
{
	/**
	 * Constructor de controlador
	 * @author mvlg
	 */
	public function __construct()
	{
		parent::__construct();
		$this->lang->load('back');
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
		
		//Cargar modelo
		$this->load->model('temporada_model', 'temporada');
	}
	
	/*
	 * Listado
	 * 
	 */
	public function listado($order_campo = 'nombre', $order_orden = 'desc', $from = 0)
	{
		$data['order_campo'] 		= $order_campo;
		$data['por_pagina'] 		= 10;
		$data['from'] 				= $from;
		$data['new_orden'] 			= $order_orden == 'desc' ? 'asc' : 'desc';
		
		$data['temporadas'] 		= $this->temporada->get_all($from, $data['por_pagina'], $order_campo, $order_orden);
		$data['total_temporadas'] 	= $this->temporada->count_all();
		
		$data['url_base'] 			= lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('temporadas_url')."/$order_campo/$order_orden";
		$data['uri_base'] 			= lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('temporadas_url');
	
		//Paginacion
		$this->load->library('pagination');
		$config['base_url'] 		= site_url($data['url_base']);
		$config['total_rows'] 		= $data['total_temporadas'];
		$config['per_page'] 		= $data['por_pagina'];
		$config['uri_segment'] 		= 6;
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close'] 	= '</li>';
		$config['full_tag_open'] 	= '<ul class="pagination">';
		$config['full_tag_close'] 	= '</ul>';
		$config['next_link'] 		= "&rsaquo;";
		$config['next_tag_open'] 	= '<li class="arrow">';
		$config['next_tag_close'] 	= '</li>';
		$config['prev_link'] 		= "&lsaquo;";
		$config['prev_tag_open'] 	= '<li class="arrow">';
		$config['prev_tag_close'] 	= '</li>';
		$config['cur_tag_open'] 	= '<li class="current"><a href="#">';
		$config['cur_tag_close'] 	= '</a></li>';
		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '</li>';
		$config['last_link'] 		= "&raquo;";
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close']	= '</li>';
		$config['first_link'] 		= "&laquo;";
		$config['fist_tag_open'] 	= '<li>';
		$config['fist_tag_close']	= '</li>';

		$this->pagination->initialize($config);

		$data['title'] = lang('meta.titulo').' - '.lang('tipos_habitacion').' - '.lang('temporadas');
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('tipos_habitacion_url'), 'listado');
		$data['usuario'] = array(	'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos') );

		$data['active'] = 'temporadas';
		$data['sub'] = 'listado';
		
		//Temporadas alta y baja
		$opciones_temporada = $this->temporada->get_temporadas();
		foreach($opciones_temporada as $opcion)
		{
			$opt_temporada[$opcion->id_temporada] = $opcion->nombre;
		}
		$data['opt_temporada'] = $opt_temporada;
		
		//Migajas de pan
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(array(	
				lang('backend_url') => lang('backend'),
				lang('backend_url').'/'.lang('tipos_habitacion_url') => lang('temporadas'),
				lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('temporadas_url') => lang('listado_temporadas')
		));
		
		$data['listado_temporadas'] 	= $this->load->view('back/temporada/listado', $data, TRUE);
		$data['agregar_temporada'] 		= $this->load->view('back/temporada/agregar', $data, TRUE);
		$data['contenido_principal'] 	= $this->load->view('back/temporada/temporadas', $data, TRUE);
		
		$this->load->view('back/template_new', $data);
	}
	
	/*
	 * Guardar temporada
	 * 
	 * */
	function guardar_temporada()
	{
		if($_POST)
		{
			$id_temporada 	= $this->input->post('id_temporada');
			$inicio 		= $this->input->post('inicio');
			$fin 			= $this->input->post('fin');
			
			if(!empty($id_temporada) && !empty($inicio) && !empty($fin))
			{
				//Año actual
				$anio = date('Y');
				
				//Inicio
				list($dia, $mes) = explode('-', $inicio);
				$inicio = implode('-', array($anio, $mes, $dia));
				
				//Fin
				list($dia, $mes) = explode('-', $fin);
				$fin = implode('-', array($anio, $mes, $dia));
				
				//Data
				$data_temporada = array('id_temporada' 	=> $id_temporada,
										'inicio'		=> $inicio,
										'fin'			=> $fin);
				
				//Editar
				if($this->input->post('id_temporada_fecha'))
				{
					$data_temporada['id_temporada_fecha'] = $this->input->post('id_temporada_fecha');
				}
				
				$this->temporada->update_temporada_fecha($data_temporada);
			}
			
			//Listado
			redirect('/'.lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('temporadas_url'));
		}
		else
		{
			//Listado
			redirect('/'.lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('temporadas_url'));
		}
	}

	/*
	 * Eliminar Temporada
	 * 
	 * */
	function eliminar_temporada($id_temporada_fecha)
	{
		if($id_temporada_fecha > 0)
		{
			$this->temporada->eliminar_temporada($id_temporada_fecha);
		}
		
		//Listado
		redirect('/'.lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('temporadas_url'));
	}

	/*
	 * Editar Temporada
	 * 
	 * */
	function editar_temporada($id_temporada_fecha)
	{
		$data['title'] = lang('meta.titulo').' - '.lang('tipos_habitacion').' - '.lang('temporadas');
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('tipos_habitacion_url'), 'listado');
		$data['usuario'] = array(	'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos') );

		$data['active'] = 'temporadas';
		$data['sub'] 	= 'listado';
		
		//Temporadas alta y baja
		$opciones_temporada = $this->temporada->get_temporadas();
		foreach($opciones_temporada as $opcion)
		{
			$opt_temporada[$opcion->id_temporada] = $opcion->nombre;
		}
		$data['opt_temporada'] = $opt_temporada;
		
		//Datos temporada
		$data['datos_temporada'] = $this->temporada->get_temporada($id_temporada_fecha);
		
		//Migajas de pan
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(array(	
				lang('backend_url') => lang('backend'),
				lang('backend_url').'/'.lang('tipos_habitacion_url') => lang('temporadas'),
				lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('temporadas_url') => lang('listado_temporadas')
		));

		$data['contenido_principal'] 	= $this->load->view('back/temporada/agregar', $data, TRUE);
		
		$this->load->view('back/template_new', $data);
	}
}