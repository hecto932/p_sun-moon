<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * Controlador de asistencia a eventos
 * @author Ale
 *
 */
class Asistencia extends MX_Controller
{
	/**
	 * Constructor del controlador
	 * @author Ale
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->lang->load('back');
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
		
		$this->load->model('inscripcion_model', 'inscripciones');
		$this->load->model('asistencia_model', 'asistencia');
		$this->load->model('evento_model', 'eventos');
	}
	
	/**
	 * Listado de inscritos para marcar asistencia
	 * @param unknown $id_evento
	 * @param string $order_campo
	 * @param string $order_orden
	 * @param number $from
	 */
	public function listado($id_evento, $order_campo = 'nombres', $order_orden = 'asc', $from = 0)
	{
		if (empty($id_evento) || ! is_numeric($id_evento))
			show_404();
	
		//Obtener datos de evento
		$data['evento'] = $this->eventos->read($id_evento);
	
		//Obtener datos de inscritos
		$data['order_campo'] = $order_campo;
		$data['por_pagina'] = 10;
		$data['from'] = $from;
		$data['new_orden'] = $order_orden == 'desc' ? 'asc' : 'desc';
		$data['inscritos'] = $this->asistencia->get_all_inscripciones($id_evento, $from, $data['por_pagina'], $order_campo, $order_orden);
		$data['total_inscritos'] = $this->inscripciones->count_all($id_evento);
		$data['url_base'] = lang('backend_url').'/'.lang('eventos_url').'/'.lang('asistencia_url')."/$id_evento/$order_campo/$order_orden";
		$data['uri_base'] = lang('backend_url').'/'.lang('eventos_url').'/'.lang('asistencia_url')."/$id_evento";
	
		//Paginacion
		$this->load->library('pagination');
		$config['base_url'] = site_url($data['url_base']);
		$config['total_rows'] = $data['total_inscritos'];
		$config['per_page'] = $data['por_pagina'];
		$config['uri_segment'] = 7;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['next_link'] = "&rsaquo;";
		$config['next_tag_open'] = '<li class="arrow">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = "&lsaquo;";
		$config['prev_tag_open'] = '<li class="arrow">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="current"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = "&raquo;";
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close']= '</li>';
		$config['first_link'] = "&laquo;";
		$config['fist_tag_open'] = '<li>';
		$config['fist_tag_close']= '</li>';
		$this->pagination->initialize($config);
	
		$data['title'] = lang('meta.titulo').' - '.lang('eventos').' - '.lang('asistencia');
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('eventos_url'), 'listado');
		$data['usuario'] = array(
				'nombre' => $this->session->userdata('nombre'),
				'apellidos' => $this->session->userdata('apellidos')
		);
	
		$data['active'] = '';
		$data['sub'] = '';
	
		//Migajas de pan
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(array(	lang('backend_url') => lang('backend'),
				lang('backend_url').'/'.lang('eventos_url') => lang('eventos'),
				lang('backend_url').'/'.lang('eventos_url').'/'.lang('ficha_url').'_'.lang('evento_url').'/'.$id_evento
				=> (isset($data['evento']->nombre) ? lang('ficha_inicio').' ' . ellipsize($data['evento']->nombre, 40, .5) : lang('eventos_sintitulo')),
				lang('backend_url').'/'.lang('eventos_url').'/'.lang('asistencia_url') => lang('asistencia'),
		));
		
		$data['asistencia_css'] = $this->load->view('back/css/asistencia_css', $data, TRUE);
		$data['asistencia_js'] = $this->load->view('back/js/asistencia_js', $data, TRUE);
		$data['listado_inscritos'] = $this->load->view('back/asistencia/listado_inscritos', $data, TRUE);
		$data['contenido_principal'] = $this->load->view('back/asistencia/asistencia_evento', $data, TRUE);
		$this->load->view('back/template_new', $data);
	}
	
	/**
	 * Marcar asistencia de usuario a evento
	 * @author Ale
	 */
	public function marcar()
	{
		$id_inscripcion = $this->input->post('id_inscripcion');
		$dia = $this->input->post('dia');
		
		if ( ! $this->asistencia->existe($id_inscripcion, $dia))
			$this->asistencia->agregar(array(	'id_inscripcion' => $id_inscripcion,
												'dia' => $dia		));
			
		else
			$this->asistencia->eliminar($id_inscripcion, $dia);
	}
}
