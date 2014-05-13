<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * Controlador de Facturas
 * Backend
 * @author Ale
 *
 */
class Factura extends MX_Controller
{
	/**
	 * Constructor controlador
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->lang->load('back');
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
		
		$this->load->model('factura_model', 'facturas');
		$this->load->model('pago_model', 'pagos');
		$this->load->model('tipo_pago_model', 'tipo_pago');
	}
	
	/**
	 * Listar facturas
	 */
	public function listado($order_campo = 'id_factura', $order_orden = 'desc', $from = 0)
	{
		//Obtener datos de facturas
		$data['order_campo'] = $order_campo;
		$data['por_pagina'] = 10;
		$data['from'] = $from;
		$data['new_orden'] = $order_orden == 'desc' ? 'asc' : 'desc';
		$data['facturas'] = $this->facturas->get_all($from, $data['por_pagina'], $order_campo, $order_orden);
		$data['total_facturas'] = $this->facturas->count_all();
		$data['url_base'] = lang('backend_url').'/'.lang('eventos_url').'/'.lang('facturas_url')."/$order_campo/$order_orden";
		$data['uri_base'] = lang('backend_url').'/'.lang('eventos_url').'/'.lang('facturas_url');
		
		//Paginacion
		$this->load->library('pagination');
		$config['base_url'] = site_url($data['url_base']);
		$config['total_rows'] = $data['total_facturas'];
		$config['per_page'] = $data['por_pagina'];
		$config['uri_segment'] = 6;
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
		
		$data['title'] = lang('meta.titulo').' - '.lang('facturas');
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('eventos_url'), lang('facturas_url'));
		$data['usuario'] = array(
				'nombre' => $this->session->userdata('nombre'),
				'apellidos' => $this->session->userdata('apellidos')
		);
		
		$data['active'] = 'facturas';
		$data['sub'] = 'eventos';
		
		//Migajas de pan
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(array(	lang('backend_url') => lang('backend'),
																		lang('backend_url').'/'.lang('eventos_url') => lang('eventos'),
																		lang('backend_url').'/'.lang('eventos_url').'/'.lang('facturas') => lang('facturas')
		)
		);
		
		$data['contenido_principal'] = $this->load->view('back/facturas/listado', $data, TRUE);
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
		$data['monto'] = $this->facturas->monto_factura($id_factura);
		$data['inscripciones'] = $this->facturas->get_inscripciones($id_factura);
		$data['pagos'] = $this->pagos->get_all_by_factura($id_factura);
		$data['total_pagos'] = $this->pagos->suma_pagos($id_factura);
		
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
		
		$data['factura_js'] = $this->load->view('back/js/factura_js', $data, TRUE);
		$data['datos_basicos'] = $this->load->view('back/facturas/datos_basicos', $data, TRUE);
		$data['tipo_pago_opt'] = $this->tipo_pago->dropdown_all();
		$data['pagos_js'] = $this->load->view('back/js/pagos_js', $data, TRUE);
		$data['registrar_pagos'] = $this->load->view('back/facturas/pagos', $data, TRUE);
		$data['contenido_principal'] = $this->load->view('back/facturas/consulta', $data, TRUE);
		$this->load->view('back/template_new', $data);
	}
	
	/**
	 * Agregar pago a factura
	 * @author Ale
	 */
	public function agregar_pago()
	{
		$errores = $this->validar_pago();
		
		if (count($errores))
		{
			echo json_encode($errores);
		}
		else
		{
			$this->pagos->agregar(array(	'id_factura' => $this->input->post('id_factura'),
											'referencia' => $this->input->post('referencia'),
											'monto' => $this->input->post('monto'),
											'id_tipo_pago' => $this->input->post('id_tipo_pago')	));
			
			//Si con este pago se iguala el monto de la factura, marcar factura cancelada
			if ($this->pagos->suma_pagos($this->input->post('id_factura')) >= $this->facturas->monto_factura($this->input->post('id_factura')))
			{
				$this->facturas->actualizar($this->input->post('id_factura'), array('cancelada' => 1));
			}
			echo json_encode(array('sin_errores' => 1));
		}
	}
	
	/**
	 * Validación de datos de pago
	 * @author Ale
	 */
	private function validar_pago()
	{
		$this->load->library('form_validation');
		$this->form_validation->CI =& get_instance();
		
		$inputs_enviados = array(	'id_tipo_pago',
									'referencia',
									'monto'			);
		
		$this->form_validation->set_rules('id_tipo_pago', lang('pagos.tipo_pago'), 'required|is_natural');
		$this->form_validation->set_rules('referencia', lang('pagos.referencia'), 'required|is_natural');
		$this->form_validation->set_rules('monto', lang('pagos.monto'), 'required|numeric');
		
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_message('required', 'Campo requerido');
		$this->form_validation->set_message('is_natural', 'Número inválido');
		$this->form_validation->set_message('numeric', 'Número inválido');
		
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
	 * Anular una factura
	 * @author Ale
	 */
	public function anular()
	{
		$id_factura = $this->input->post('id_factura');
		$anular = $this->input->post('anular');
		$this->facturas->actualizar($id_factura, array('anulada' => $anular));
	}
	
	/**
	 * Cancelar una factura
	 * @author Ale
	 */
	public function cancelar()
	{
		$id_factura = $this->input->post('id_factura');
		$cancelar = $this->input->post('cancelar');
		$this->facturas->actualizar($id_factura, array('cancelada' => $cancelar));
	}
}
