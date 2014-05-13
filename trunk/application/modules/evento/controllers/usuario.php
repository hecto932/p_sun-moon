<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * Controlador de Usuario de Eventos
 * @author Ale
 *
 */
class Usuario extends MX_Controller
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
		
		$this->load->model('usuario_model', 'usuarios');
		$this->load->model('empresa_model', 'empresas');
	}
	
	/**
	 * Lista de usuarios
	 * @author Ale
	 */
	public function listado($order_campo = 'id_usuario', $order_orden = 'desc', $from = 0)
	{
		//Obtener datos de usuarios
		$data['order_campo'] = $order_campo;
		$data['por_pagina'] = 10;
		$data['from'] = $from;
		$data['new_orden'] = $order_orden == 'desc' ? 'asc' : 'desc';
		$data['usuarios'] = $this->usuarios->get_all($from, $data['por_pagina'], $order_campo, $order_orden);
		$data['total_usuarios'] = $this->usuarios->count_all();
		$data['url_base'] = lang('backend_url').'/'.lang('eventos_url').'/'.lang('usuarios_url')."/$order_campo/$order_orden";
		$data['uri_base'] = lang('backend_url').'/'.lang('eventos_url').'/'.lang('usuarios_url');
	
		//Paginacion
		$this->load->library('pagination');
		$config['base_url'] = site_url($data['url_base']);
		$config['total_rows'] = $data['total_usuarios'];
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
	
		$data['title'] = lang('meta.titulo').' - '.lang('eventos').' - '.lang('usuarios');
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('eventos_url'), 'listado');
		$data['usuario'] = array(
				'nombre' => $this->session->userdata('nombre'),
				'apellidos' => $this->session->userdata('apellidos')
		);
	
		$data['active'] = 'usuarios';
		$data['sub'] = 'eventos';
	
		//Migajas de pan
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(array(	
				lang('backend_url') => lang('backend'),
				lang('backend_url').'/'.lang('eventos_url') => lang('eventos'),
				lang('backend_url').'/'.lang('eventos_url').'/'.lang('usuarios_url') => lang('listado_usuarios')
		));
		
		$data['usuarios_listado_js'] = $this->load->view('back/js/usuarios_listado_js', $data, TRUE);
		$data['usuarios_agregar_js'] = $this->load->view('back/js/usuarios_agregar_js', $data, TRUE);
		$data['listado_usuarios'] = $this->load->view('back/usuarios/listado', $data, TRUE);
		$data['agregar_usuario'] = $this->load->view('back/usuarios/agregar', $data, TRUE);
		$data['contenido_principal'] = $this->load->view('back/usuarios/usuarios_evento', $data, TRUE);
		$this->load->view('back/template_new', $data);
	}
	
	/**
	 * Agregar un usuario nuevo
	 * @author Ale
	 */
	public function agregar()
	{
		$errores = $this->validar();
		
		if (count($errores))
			echo json_encode($errores);
		else
		{
			if ($this->input->post('id_usuario') == ''):
				$this->usuarios->agregar(array(	'cedula' => $this->input->post('cedula'),
												'rif' => $this->input->post('rif'),
												'email' => $this->input->post('email'),
												'nombres' => $this->input->post('nombres'),
												'apellidos' => $this->input->post('apellidos'),
												'telefono1' => $this->input->post('telefono1'),
												'telefono2' => $this->input->post('telefono2'),
												'direccion' => $this->input->post('direccion')
				));
			else:
				$this->usuarios->actualizar($this->input->post('id_usuario'),
											array(	'cedula' => $this->input->post('cedula'),
													'rif' => $this->input->post('rif'),
													'email' => $this->input->post('email'),
													'nombres' => $this->input->post('nombres'),
													'apellidos' => $this->input->post('apellidos'),
													'telefono1' => $this->input->post('telefono1'),
													'telefono2' => $this->input->post('telefono2'),
													'direccion' => $this->input->post('direccion')
				));
			endif;
			echo json_encode(array('sin_errores' => 1));
		}
	}
	
	/**
	 * Validacion de datos de usuario
	 * @author Ale
	 */
	public function validar()
	{
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		
		$inputs_enviados = array(
				'cedula',
				'rif',
				'email',
				'nombres',
				'apellidos',
				'telefono1',
				'telefono2',
				'direccion'
		);
		
		$this->form_validation->set_rules('cedula', lang('usuarios_eventos.cedula'), 'numeric|callback__identificador_usuario|callback__cedula_unica');
		$this->form_validation->set_rules('rif', lang('usuarios_eventos.rif'), 'callback__rif_valido|callback__rif_unico');
		$this->form_validation->set_rules('email', lang('usuarios_eventos.email'), 'valid_email|callback__email_unico');
		$this->form_validation->set_rules('nombres', lang('usuarios_eventos.nombres'), 'required');
		$this->form_validation->set_rules('apellidos', lang('usuarios_eventos.apellidos'), 'required');
		$this->form_validation->set_rules('telefono1', lang('usuarios_eventos.telefono1'), 'callback__telefono_valido');
		$this->form_validation->set_rules('telefono2', lang('usuarios_eventos.telefono2'), 'callback__telefono_valido');
		
		$this->form_validation->set_message('numeric', 'Número inválido');
		$this->form_validation->set_message('valid_email', 'E-Mail inválido');
		$this->form_validation->set_message('required', 'Campo obligatorio');
		$this->form_validation->set_message('_identificador_usuario', 'Se requiere cédula, RIF ó E-mail');
		$this->form_validation->set_message('_rif_valido', 'RIF inválido');
		$this->form_validation->set_message('_rif_unico', 'Ya está registrado');
		$this->form_validation->set_message('_cedula_unica', 'Ya está registrado');
		$this->form_validation->set_message('_email_unico', 'Ya está registrado');
		$this->form_validation->set_message('_telefono_valido', 'Teléfono inválido');
		$this->form_validation->set_error_delimiters('', '');
		
		$this->form_validation->run();
		
		$errores = array();
		foreach ($inputs_enviados as $input)
			if (strlen(form_error($input)))
				$errores[$input] = form_error($input);
			
		return $errores;
	}
	
	/**
	 * Edición de datos de usuario
	 * @author Ale
	 * @param unknown $id_usuario
	 */
	public function editar($id_usuario)
	{
		$data['title'] = lang('meta.titulo').' - '.lang('eventos').' - '.lang('usuarios');
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('eventos_url'), 'listado');
		$data['usuario'] = array(
				'nombre' => $this->session->userdata('nombre'),
				'apellidos' => $this->session->userdata('apellidos')
		);
		
		$data['active'] = 'usuarios';
		$data['sub'] = 'eventos';
		
		//Obtener datos de usuario
		$data['data_usuario'] = $this->usuarios->get($id_usuario);
		
		if (empty($data['data_usuario']))
			show_404();
		
		//Migajas de pan
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(array(
				lang('backend_url') => lang('backend'),
				lang('backend_url').'/'.lang('eventos_url') => lang('eventos'),
				lang('backend_url').'/'.lang('eventos_url').'/'.lang('usuarios_url') => lang('listado_usuarios'),
				lang('backend_url').'/'.lang('eventos_url').'/'.lang('usuarios_url').'/'.lang('editar_url') => lang('editar')
		));
		
		$data['usuarios_editar_js'] = $this->load->view('back/js/usuarios_editar_js', $data, TRUE);
		$data['editar_datos'] = $this->load->view('back/usuarios/editar_datos', $data, TRUE);
		$data['contenido_principal'] = $this->load->view('back/usuarios/editar', $data, TRUE);
		$this->load->view('back/template_new', $data);
	}
	
	/**
	 * Elimina un usuario
	 * @author Ale
	 */
	public function eliminar()
	{
		$id_usuario = $this->input->post('id_usuario');
		$this->usuarios->eliminar($id_usuario);
	}
	
	/**
	 * Verifica que se haya enviado cedula, rif o email
	 * @author Ale
	 */
	public function _identificador_usuario()
	{
		return $this->input->post('cedula') != '' || $this->input->post('rif') != '' || $this->input->post('email') != '';
	}
	
	/**
	 * Verifica si rif es válido
	 * @param unknown $rif
	 */
	public function _rif_valido($rif)
	{
		return $rif == '' || preg_match("/^(v|j|g|e)\-[0-9]{8}\-[0-9]$/i", $rif) == 1;
	}
	
	/**
	 * Verifica si el rif no existe
	 * @author Ale
	 */
	public function _rif_unico($rif)
	{
		return $rif == '' || ! $this->usuarios->existe_rif($rif, $this->input->post('id_usuario'));
	}
	
	/**
	 * Verifica que la cédula no exista
	 * @param unknown $cedula
	 */
	public function _cedula_unica($cedula)
	{
		return $cedula == '' || ! $this->usuarios->existe_cedula($cedula, $this->input->post('id_usuario'));
	}
	
	/**
	 * Verifica que el email no exista
	 * @param unknown $email
	 */
	public function _email_unico($email)
	{
		return $email == '' || ! $this->usuarios->existe_email($email, $this->input->post('id_usuario'));
	}
	
	/**
	 * Verifica que el telefono introducido es válido
	 * @param unknown $telefono
	 * @return boolean
	 */
	public function _telefono_valido($telefono)
	{
		return $telefono == '' || preg_match("/^0(2|4)[0-9]{2}\-?[0-9]{7}$/", $telefono) == 1;
	}
}