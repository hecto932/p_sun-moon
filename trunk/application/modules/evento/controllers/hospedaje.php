<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * Controlador para manejar disponibildad de hospedaje
 * @author Ale
 *
 */
class Hospedaje extends MX_Controller
{
	/**
	 * Constructor de controlador
	 * @author Ale
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->lang->load('back');
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
		
		$this->load->model('disponibilidad_hospedaje_model', 'hospedaje');
		$this->load->model('tipo_hospedaje_model', 'tipo_hospedaje');
		$this->load->model('evento_model', 'eventos');
	}
	
	/**
	 * Listar opciones de hospedaje disponible
	 * @author Ale
	 */
	public function listado($id_evento, $order_campo = 'id_hospedaje', $order_orden = 'desc', $from = 0)
	{
		if (empty($id_evento))
			show_404();
		
		//Obtener datos de evento
		$data['evento'] = $this->eventos->read($id_evento);
		
		//Obtener datos de facturas
		$data['order_campo'] = $order_campo;
		$data['por_pagina'] = 10;
		$data['from'] = $from;
		$data['new_orden'] = $order_orden == 'desc' ? 'asc' : 'desc';
		$data['hospedaje'] = $this->hospedaje->get_all($id_evento, $from, $data['por_pagina'], $order_campo, $order_orden);
		$data['total_hospedaje'] = $this->hospedaje->count_all($id_evento);
		$data['url_base'] = lang('backend_url').'/'.lang('eventos_url').'/'.lang('hospedaje_url')."/$id_evento/$order_campo/$order_orden";
		$data['uri_base'] = lang('backend_url').'/'.lang('eventos_url').'/'.lang('hospedaje_url');
	
		//Paginacion
		$this->load->library('pagination');
		$config['base_url'] = site_url($data['url_base']);
		$config['total_rows'] = $data['total_hospedaje'];
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
	
		$data['title'] = lang('meta.titulo').' - '.lang('hospedaje');
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('eventos_url'), lang('hospedaje_url'));
		$data['usuario'] = array(
				'nombre' => $this->session->userdata('nombre'),
				'apellidos' => $this->session->userdata('apellidos')
		);
	
		$data['active'] = lang('hospedaje_url');
		$data['sub'] = lang('eventos_url');
	
		//Migajas de pan
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(array(	lang('backend_url') => lang('backend'),
																		lang('backend_url').'/'.lang('eventos_url') => lang('eventos'),
																		lang('backend_url').'/'.lang('eventos_url').'/'.lang('ficha_url').'_'.lang('evento_url').'/'.$id_evento => lang('ficha_inicio').' ' . $data['evento']->nombre,
																		lang('backend_url').'/'.lang('eventos_url').'/'.lang('hospedaje') => lang('hospedaje')
		));
		
		$data['tipo_hospedaje_opt'] = $this->tipo_hospedaje->get_all_dropdown();
		$data['hospedaje_js'] = $this->load->view('back/js/hospedaje_js', $data, TRUE);
		$data['agregar_hospedaje'] = $this->load->view('back/hospedaje/agregar_hospedaje', $data, TRUE);
		$data['hospedaje_listado_js'] = $this->load->view('back/js/hospedaje_listado_js', $data, TRUE);
		$data['listado_hospedaje'] = $this->load->view('back/hospedaje/listado', $data, TRUE);
		$data['contenido_principal'] = $this->load->view('back/hospedaje/hospedaje_evento', $data, TRUE);
		$this->load->view('back/template_new', $data);
	}
	
	/**
	 * Mostrar datos de una factura
	 * @param unknown $id_factura
	 */
	public function consulta($id_factura)
	{
		if (empty($id_factura))
			show_404();
	
		$data['factura'] = $this->facturas->get($id_factura);
		$data['inscripciones'] = $this->facturas->get_inscripciones($id_factura);
	
		//Migajas de pan
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(array(	lang('backend_url') => lang('backend'),
				lang('backend_url').'/'.lang('eventos_url') => lang('eventos'),
				lang('backend_url').'/'.lang('eventos_url').'/'.lang('facturas_url') => lang('facturas'),
				lang('backend_url').'/'.lang('eventos_url').'/'.lang('facturas_url').'/'.lang('consultar_url').'/'.$id_factura => 'FACTURA #'.$id_factura
		));
	
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('eventos_url'), lang('facturas_url'));
		$data['title'] = lang('meta.titulo').' - '.lang('facturas');
		$data['active'] = 'facturas';
		$data['sub'] = 'eventos';
		$data['usuario'] = array(
				'nombre' => $this->session->userdata('nombre'),
				'apellidos' => $this->session->userdata('apellidos')
		);
	
		$data['datos_basicos'] = $this->load->view('back/facturas/datos_basicos', $data, TRUE);
		$data['contenido_principal'] = $this->load->view('back/facturas/consulta', $data, TRUE);
		$this->load->view('back/template_new', $data);
	}
	
	/**
	 * Agregar nueva opción de hospedaje
	 * @author Ale
	 */
	public function agregar()
	{
		//Ejecutar validación de datos
		$errores = $this->validar();
		
		if (count($errores))
		{
			echo json_encode($errores);
		}
		else
		{
			$this->hospedaje->nuevo_hospedaje($_POST);
			echo json_encode(array('sin_errores' => 1));
		}
	}
	
	/**
	 * Validar nueva opcion de hospedaje
	 * @author Ale
	 */
	private function validar()
	{
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		
		$inputs_enviados = array(	'id_tipo_hospedaje',
									'cantidad',
									'precio'			);
		
		//Reglas
		$this->form_validation->set_rules('id_tipo_hospedaje', lang('hospedaje.tipo_hospedaje'), 'required|is_natural');
		$this->form_validation->set_rules('cantidad', lang('hospedaje.cantidad'), 'required|is_natural|callback__check_asignados');
		$this->form_validation->set_rules('precio', lang('hospedaje.precio'), 'required|is_numeric');
		
		$this->form_validation->set_error_delimiters('','');
		$this->form_validation->set_message('required', 'Campo obligatorio');
		$this->form_validation->set_message('is_natural', 'Número inválido');
		$this->form_validation->set_message('is_numeric', 'Número inválido');
		$this->form_validation->set_message('_check_asignados', 'Se necesita una cantidad mayor');
		$this->form_validation->set_message('_greater_than', 'Debe ser mayor a 0');
		
		$this->form_validation->run();
		
		$errores = array();
		foreach ($inputs_enviados as $input)
		{
			if (strlen(form_error($input)))
				$errores[$input] = form_error($input);
		}
		
		return $errores;
	}
	
	/**
	 * Eliminar una opción de hospedaje
	 * @author Ale
	 */
	public function eliminar()
	{
		$id_hospedaje = $this->input->post('id_hospedaje');
		
		$this->hospedaje->eliminar($id_hospedaje);
	}
	
	/**
	 * Callback para verificar si la cantidad estipulada es mayor igual a la de asignados
	 * @param unknown $cantidad
	 */
	public function _check_asignados($cantidad)
	{
		$info = $this->hospedaje->get(	$this->input->post('id_evento'),
										$this->input->post('id_tipo_hospedaje'));
		
		if ( ! empty($info))
		{
			return $this->hospedaje->count_asignados($info->id_hospedaje) <= $cantidad;
		}
		else
			return TRUE;
	}
	
	/**
	 * Verifica que un valor sea mayor a un número específico
	 * @param unknown $value
	 * @param unknown $n
	 * @return boolean
	 */
	public function _greater_than($value, $n)
	{
		return $value >= $n;
	}
}
