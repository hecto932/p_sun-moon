<?php

class Habitacion extends MX_Controller {

    function __construct() {

		parent::__construct();
		$this->load->helper(array('form', 'url'));
		modules::run('idioma/set_idioma', 'es');
		$this->load->language('back');
        $this->load->model('habitacion_model');
        $this->load->helper('multimedia');

    }

    /*
     * Funcciones del admin, con control de aceso */

    function index() {

        $this->listado();
    }

    function listado($order_field = 'habitacion.id_habitacion', $order_dir = 'desc', $start = 0, $ajax = false) {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        if ($start == 0 && empty($_POST) && $order_field == 'habitacion.id_habitacion')
        {
        	$this->session->unset_userdata('terminos_busqueda');
        }
        $terminos_busqueda = array();
        $terminos_busqueda = $this->session->userdata('terminos_busqueda');
        if (isset($_POST['texto'])) {
            $terminos_busqueda['texto'] = $_POST['texto'];
        }
        if (isset($_POST['id_habitacion'])) {
            $terminos_busqueda['habitacion.id_habitacion'] = $_POST['id_habitacion'];
        }
		if (isset($_POST['id_tipo_habitacion'])) {
            $terminos_busqueda['habitacion.id_tipo_habitacion'] = $_POST['id_tipo_habitacion'];
        }
        if (isset($_POST['id_estado'])) {
            $terminos_busqueda['habitacion.id_estado'] = $_POST['id_estado'];
        }
		
        if (isset($_POST) && !empty($_POST)) {
            $terminos_busqueda = array_filter($terminos_busqueda);
            $this->session->set_userdata('terminos_busqueda', $terminos_busqueda);
        }
		
        //echo '<pre>'.print_r($terminos_busqueda,true).'</pre>';
        $limit = 5;
        $order_string = '';
        $order_string.= ($order_field == "") ? '' : $order_field;
        $order_string.= ($order_dir == "") ? '' : ' ' . $order_dir;

        $od = ($order_dir == 'asc') ? 'desc' : 'asc';
        $data['order_field'] 		= $order_field;
        $data['order_dir'] 			= $order_dir;
        $data['order_by_new'] 		= (($order_field == '') ? 'id_habitacion' : $order_field) . "/" . $od;
        $data['url'] 				= lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('listado_url');
        $config['base_url'] 		= '/'.lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('listado_url').'/'.$order_field.'/'.$order_dir;
        $config['per_page'] 		= $limit;
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
		
        $data['num_habitaciones'] = $this->habitacion_model->count_all($terminos_busqueda);
        $config['total_rows'] = $data['num_habitaciones'];
        if ($config['total_rows'] == 0)
            redirect(lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('buscar_url').'/'.'ningun_resultado');
        $data['habitaciones'] = $this->habitacion_model->get_page($start, $limit, $order_field, $order_dir, $terminos_busqueda);
        if ($ajax) {
            echo json_encode($data['habitaciones']);
        }
        else
        {
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['offset'] = $start;
            $data['order_field'] = $order_field;
            $data['order_direction'] = $order_dir;
            $data['active'] = 'habitaciones';
            if (!empty($terminos_busqueda))
            {
            	$data['sub'] = 'buscar';
            }
            else
			{
				$data['sub'] = 'listado';
			}
            $data['title'] = lang('meta.titulo').' - '.lang('habitaciones').' - '.lang('listado');
            if (!empty($terminos_busqueda))
            {
                $lbc = reset($terminos_busqueda);
                $lbt = key($terminos_busqueda);

                if ($lbt == 'habitacion.id_estado')
                {
                    $bcc = modules::run('services/relations/get_from_id', 'estado', $lbc);
                    $lbc = ucwords($bcc->estado);
                }
                if ($lbt == 'habitacion.id_producto')
                {
                    $bcc = modules::run('services/relations/get_from_id', 'producto', $lbc);
                    $lbc = ucwords($bcc->nombre);
                }
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                															array(
                																	lang('backend_url').'/'.lang('habitaciones_url') => lang('habitaciones'),
                							 										lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('buscar_url') => lang('busqueda'),
                							 										lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('buscar_url').'/'.lang('titulo_url') => $lbc
																				 )
											 						  );
            }
            else
            {
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                															array(
                																	lang('backend_url') => lang('inicio'),
                																	lang('backend_url').'/'.lang('habitaciones_url') => lang('habitaciones'),
                							 										lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('listado_url') => lang('listado')
																				 )
											 						  );
            }
			$data['menu_principal'] = $this->menus->create_mainmenu(lang('habitaciones_url'), 'listado');
			$data['usuario'] = array(
										'nombre' => $this->session->userdata('nombre'),
										'apellidos' => $this->session->userdata('apellidos')
									);
			$data['contenido_principal'] = $this->load->view('back/listar/listado_habitacion', $data, true);
            $this->load->view('back/template_new', $data);
        }
    }

    function buscar($mensaje = '')
	{
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		$this->load->helper('misc');
        $data['active'] = 'habitaciones';
        $data['sub'] = 'buscar';
        $data['title'] = lang('meta.titulo').' - '.lang('habitaciones').' - '.lang('buscar_tit_hab');
        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => lang('backend'),
        																lang('backend_url').'/'.lang('habitaciones_url') => lang('habitaciones'),
        																lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('buscar_url') => lang('buscar_tit_hab')));
        $data['mensaje'] = $mensaje;
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('habitaciones_url'), 'listado');
		$data['tipo_habitacion'] = habitacion_dropdown($this->habitacion_model->get_tipo_habitacion(), 'es');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
        $data['contenido_principal'] = $this->load->view('back/buscar/buscar_habitacion', $data, true);
        $this->load->view('back/template_new', $data);
    }

    function crear()
    {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		$this->load->helper('misc');
		
        $data['active'] 		= 'habitaciones';
        $data['sub'] 			= 'crear';
		$data['title'] 			= lang('meta.titulo').' - '.lang('habitaciones').' - '.lang('crear_tit_hab');
        $data['breadcrumbs'] 	= $this->menus->create_breadcrumb(
        															array(
        																	lang('backend_url') => lang('backend'),
										    								lang('backend_url').'/'.lang('habitaciones_url') => lang('habitaciones'),
										    							 	lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('crear_url') => lang('crear_tit_hab')
																		 )
															  );
		$data['array_destacado'] 	= destacado_dropdown();
        $data['estados'] 			= modules::run('services/relations/get_all', 'estado', 'true');
        $data['habitaciones'] 		= modules::run('services/relations/get_all', 'habitacion', 'true');
		$data['tipo_habitacion'] 	= habitacion_dropdown($this->habitacion_model->get_tipo_habitacion(), 'es');
		
		//Estados de habitacion
		/*
		$estados_habitacion = $this->habitacion_model->get_estados_habitacion();
		foreach($estados_habitacion as $estado_hab)
		{
			$temp[$estado_hab->id_estado_habitacion] = ucwords(strtolower($estado_hab->descripcion));
		}
		$data['estado_habitacion'] = $temp;
		*/
		 
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('habitaciones_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		$data['crear'] = TRUE;
        $data['contenido_principal'] = $this->load->view('back/crear/crear_habitacion', $data, true);
        $this->load->view('back/template_new', $data);
    }


    function fecha_pasada($fecha) {
        return mysql_to_unix($fecha) <= time();
    }

    function create($id = '')
    {
        $img_folder = 'assets/front/img/';

        if ($id != '')
        {
        	modules::run('services/monitor/add', 'habitacion', $id, $this->session->userdata('id_usuario'), 'editar');
        }
        else
        {
        	modules::run('services/monitor/add', 'habitacion', '', $this->session->userdata('id_usuario'), 'crear');
        }
		
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        $this->form_validation->set_rules('id_estado', 'Estado', 'required');
		$this->form_validation->set_rules('codigo', 'Código', 'required');
       
	    $config['upload_path'] = './assets/pdf';
        $config['allowed_types'] = 'pdf';
        $this->load->library('upload', $config);
        
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('habitaciones_url'), 'listado');
		
        if ($this->form_validation->run() == FALSE)
        {
            $data['sub'] 	= 'crear';
            $data['title'] 	= lang('crear_tit_hab');
			
            if ($id != '')
            {
                $data['habitacion'] 	= $this->habitacion_model->read($id);
                $data['title'] 			= lang('editar_tit_hab');
            }
            $data['active'] = 'habitaciones';

            if ($id != '')
            {
            	$data['breadcrumbs'] = $this->menus->create_breadcrumb(
            															array(
            																	'habitacion' 	=> lang('habitaciones'),
            																	'edit'			=>	lang('editar_tit_hab'),
            																	$id				=>	$data['habitacion']->nombre
																			 )
																	  );
            }
            else
            {
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                														array(
                																'habitacion' => lang('habitaciones'),
                																'crear' => lang('crear_tit_hab')
																			 )
																	  );
            }
			
			$data['tipo_habitacion'] = habitacion_dropdown($this->habitacion_model->get_tipo_habitacion(), 'es');
            $data['estados'] = modules::run('services/relations/get_all', 'estado', 'true');
			
			//Estados de habitacion
			/*
			$estados_habitacion = $this->habitacion_model->get_estados_habitacion();
			foreach($estados_habitacion as $estado_hab)
			{
				$temp[$estado_hab->id_estado_habitacion] = ucwords(strtolower($estado_hab->descripcion));
			}
			$data['estado_habitacion'] = $temp; 
			*/
			
            $data['contenido_principal'] = $this->load->view('back/crear/crear_habitacion', $data, true);
            $this->load->view('back/template_new', $data);
        }
         else
         {
			//POST
            $form_data = $_POST;
			
			//Usuario
			$form_data['id_usuario'] = $this->session->userdata('id_usuario');
			
			//Insertar habitacion
            $id = $this->habitacion_model->update($form_data);
			
			if($this->session->userdata('idioma') == 'es')
			{
            	redirect(lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('ficha_url').'_'.lang('habitacion_url').'/' . $id, 'location');
            }
			else
			{
				redirect(lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('habitacion_url').'_'.lang('ficha_url').'/' . $id, 'location');
			}
        }
    }

    function edit($id = '', $ajax = false)
    {
        if ($id == '')
		{
            redirect('backend');
		}
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		
		$this->load->helper('misc');
        $data['active'] 	= 'habitaciones';
        $data['sub'] 		= 'editar';

        $data['habitacion'] = $this->habitacion_model->read($id);

        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
									        					   array(
									        					   			lang('backend_url') => lang('backend'),
									        								lang('backend_url').'/'.lang('habitaciones_url') => lang('habitaciones'),
									        								lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('ficha_url').'_'.lang('habitacion_url').'/'.$id => lang('editar_tit_hab'),
									        								'#' => (isset($data['habitacion']->nombre) && $data['habitacion']->nombre != '') ? $data['habitacion']->nombre : lang('habitaciones_sintitulo')
																		)
															  );
															  
        $data['title'] 				= lang('meta.titulo').' - '.lang('habitaciones').' - '.lang('editar').' '.$data['habitacion']->nombre;
        $data['estados'] 			= modules::run('services/relations/get_all', 'estado', 'true');
		
		//Estados de habitacion
		/*
		$estados_habitacion = $this->habitacion_model->get_estados_habitacion();
		foreach($estados_habitacion as $estado_hab)
		{
			$temp[$estado_hab->id_estado_habitacion] = ucwords(strtolower($estado_hab->descripcion));
		}
		$data['estado_habitacion'] = $temp;
		*/
		
		$data['menu_principal'] 	= $this->menus->create_mainmenu(lang('habitaciones_url'), 'listado');
		$data['tipo_habitacion'] 	= habitacion_dropdown($this->habitacion_model->get_tipo_habitacion(), 'es');
		
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
								
        $data['contenido_principal'] = $this->load->view('back/crear/crear_habitacion', $data, true);
        if ($ajax)
		{
            echo $data['contenido_principal'];
		}
        else
		{
            $this->load->view('back/template_new', $data);
		}
    }

    function ficha($id = '')
    {
    	$this->load->model('multimedia/multimedia_model');
       
	    modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
       
	    if ($id == '')
		{
			redirect('backend/habitaciones');
		}
        
        $data['active'] 		= 'habitaciones';
        $data['sub'] 			= 'editar';
        $data['habitacion'] 	= $this->habitacion_model->read($id);
        $data['breadcrumbs'] 	= $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => lang('backend'),
        																lang('backend_url').'/'.lang('habitaciones_url') => lang('habitaciones'),
        																lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('listado_url') => lang('listado'),
        																lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('ficha_url').'_'.lang('habitacion_url').'/'.$id => (isset($data['habitacion']->nombre) ? lang('ficha_inicio').' ' . $data['habitacion']->nombre : lang('habitaciones_sintitulo'))
																	 )
															  );
		/*--- Zona de url ----*/

		//Imagen Principal
		$data['url_add_p'] = base_url().lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('imagenes_url').'/'.$id.'/'.lang('adicionar_url').'/'.lang('principal');
		//Imagenes secundarias
		$data['url_add_s'] = base_url().lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('imagenes_url').'/'.$id.'/'.lang('adicionar_url').'/'.lang('secundarias');
		//Imagenes terciarias
		$data['url_add_t'] = base_url().lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('imagenes_url').'/'.$id.'/'.lang('adicionar_url').'/'.lang('terciarias');
		//Eliminar Imagen
		$data['url_delete'] = base_url().lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('imagenes_url').'/'.lang('eliminar_url');


        $data['title'] = lang('meta.titulo').' - '.lang('habitaciones').' - '.(isset($data['habitacion']->nombre) ? lang('ficha_inicio').' ' . $data['habitacion']->nombre : lang('habitaciones_sintitulo'));
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('habitaciones_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
								
		$data['accion'] 				= 'normal';
		$data['sub_activo'] 			= 'Ficha';
		$data['imagen_principal'] 		= $this->multimedia_model->get_relation($id, 'habitacion', 1);
		$data['imagenes_secundarias'] 	= $this->multimedia_model->get_relation($id, 'habitacion', 2);
		$data['imagenes_terciarias'] 	= $this->multimedia_model->get_relation($id, 'habitacion', 3);
        $data['habitacion_idiomas'] 		= $this->habitacion_model->detalles($id);
		
		/*--- Cargas de vistas ---*/
		$data['habitacion_imagenes'] 		= $this->load->view('template/ficha_imagen', $data, true);  	//Ficha de la sección de imagenes
		$data['ficha_js'] 					= $this->load->view('template/ficha_imagen_js', $data, true); 	//Contenido js de la seccion ficha imagenes
		$data['habitacion_info'] 			= $this->load->view('back/ficha/habitacion_info', $data, true); 	//Información básica de la servicio
		$data['idioma_info'] 				= $this->load->view('back/ficha/idioma_info', $data, true); 	//Información de los idiomas
		$data['idioma_form'] 				= $this->load->view('back/ficha/idioma_habitacion', $data, true); //Vista para la creación de nuevos idiomas
		$data['idioma_nuevo'] 				= $this->load->view('back/ficha/idioma_habitacion', $data, true); //Vista para la creación de nuevos idiomas
        $data['contenido_principal'] 		= $this->load->view('back/ficha/ficha_habitacion', $data, true); 	//Carga de contenido principal
        $this->load->view('back/template_new', $data);
    }

    function editar_idioma($id_habitacion, $id_detalle_habitacion = '')
    {
    	$this->load->model('multimedia/multimedia_model');
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        if ($id_detalle_habitacion == '')
		{
			redirect(lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('ficha_url').'_'.lang('habitacion_url').'/'.$id_habitacion);
		}
		$data['habitacion'] 	= $this->habitacion_model->read($id_habitacion, $id_detalle_habitacion);
		$data['active'] 		= 'habitaciones';
		$data['sub'] 			= 'ficha';
		$data['accion'] 		= 'editar';
		$data['sub_activo']	 	= 'EditLangTab';
		$data['title'] 			= lang('meta.titulo').' - '.lang('habitaciones').' - '.lang('editar_idioma');
		
		//AGREGE DE ESTO PARA SOLUCIONAR QUE CUANDO SE EDITABA UN IDIOMA EN SERVICIO, DABA ERROR PHP EN LA FICHA DE IMAGENES
		$data['url_add_p'] 				= base_url().lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('imagenes_url').'/'.$id_habitacion.'/'.lang('adicionar_url').'/'.lang('principal');
		//Imagenes secundarias
		$data['url_add_s'] 				= base_url().lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('imagenes_url').'/'.$id_habitacion.'/'.lang('adicionar_url').'/'.lang('secundarias');
		//Imagenes terciarias
		$data['url_add_t'] 				= base_url().lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('imagenes_url').'/'.$id_habitacion.'/'.lang('adicionar_url').'/'.lang('terciarias');
		//Eliminar Imagen
		$data['url_delete'] 			= base_url().lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('imagenes_url').'/'.lang('eliminar_url');
		$data['imagen_principal'] 		= $this->multimedia_model->get_relation($id_habitacion, 'habitacion', 1);
		$data['imagenes_secundarias'] 	= $this->multimedia_model->get_relation($id_habitacion, 'habitacion', 2);
		$data['imagenes_terciarias'] 	= $this->multimedia_model->get_relation($id_habitacion, 'habitacion', 3);
		$data['habitacion_imagenes'] 	= $this->load->view('template/ficha_imagen', $data, true); //Ficha de la sección de imagenes
		$data['ficha_js'] 				= $this->load->view('template/ficha_imagen_js', $data, true); //Contenido js de la seccion ficha imagenes
		//FIN - AGREGE DE ESTO PARA SOLUCIONAR QUE CUANDO SE EDITABA UN IDIOMA EN SERVICIO, DABA ERROR PHP EN LA FICHA DE IMAGENES
		
		$data['habitacion_idiomas'] 	= $this->habitacion_model->detalles($id_habitacion);
		//$data['servicio_idiomas'] 	= $this->servicio_model->detalles($id_servicio, $id_detalle_servicio);
		$data['habitacion_info'] 		= $this->load->view('back/ficha/habitacion_info', $data, true);
		$data['idioma_info'] 			= $this->load->view('back/ficha/idioma_info', $data, true);
		$data['idioma_form'] 			= $this->load->view('back/ficha/idioma_habitacion', $data, true);
        $data['menu_principal'] 		= $this->menus->create_mainmenu(lang('habitaciones_url'), 'listado');
		
		$data['usuario'] = array(
								'nombre' => $this->session->userdata('nombre'),
								'apellidos' => $this->session->userdata('apellidos')
							);
							
        $data['contenido_principal'] = $this->load->view('back/ficha/ficha_habitacion', $data, true);
        $this->load->view('back/template_new', $data);

    }
	function validar_url($url)
	{
		$this->form_validation->set_message('validar_url', 'La url indicada ya existe.');
		
		$id_habitacion = $this->habitacion_model->get_id_habitacion_url($url);
		
		if(!empty($id_habitacion) && is_numeric($id_habitacion) && $id_habitacion > 0 && $this->input->post('accion') != 'editar')
			$return = FALSE;
		else $return = TRUE;
		
		return $return;
	}
    function guardar_idioma()
    {
    	$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        $data = $_POST;
		$this->load->model('multimedia/multimedia_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        $this->load->helper(array('form', 'url'));
        $this->form_validation->set_rules('id_idioma', 'Idioma', 'required');
        $this->form_validation->set_rules('nombre', 'Titulo', 'required|min_length[5]');
        $this->form_validation->set_rules('subtitulo', 'Subtitulo', 'min_length[5]');
        $this->form_validation->set_rules('descripcion_breve', 'Descripcion Breve', 'min_length[10]|required');
        $this->form_validation->set_rules('descripcion_ampliada', 'Descripcion Ampliada', 'min_length[50]|required');
        $this->form_validation->set_rules('url', 'URL', 'required|callback_validar_url');
        $this->form_validation->set_rules('titulo_pagina', 'Titulo pagina', 'required|min_length[5]');
        $this->form_validation->set_rules('descripcion_pagina', 'Descripcion pagina', 'required|min_length[10]');
        $this->form_validation->set_rules('keywords', 'Palabras clave', 'required');

        if ($this->form_validation->run($this) == FALSE)
        {
            $data['active'] 	= 'habitaciones';
            $data['sub'] 		= 'crear';
            $data['title'] 		= lang('meta.titulo').' - '.lang('habitaciones').' - '.lang('idioma_edt_hab');
			
			$temp = (isset($data['nombre']) && $data['nombre'] != '') ? $data['nombre'] : lang('habitaciones_sintitulo');
            
            if ($data['id_habitacion'] != '')
			{
                $data['habitacion'] = modules::run('habitacion/read', $data['id_habitacion']);
				$data['breadcrumbs'] = $this->menus->create_breadcrumb(
																		array(
																			lang('backend_url') => lang('backend'),
																			lang('backend_url').'/'.lang('habitaciones_url') => lang('habitaciones'),
																			lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('editar_url').'_'.lang('habitacion_url').'/'.$data['id_habitacion'] => lang('idioma_edt_hab'),
																			lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('editar_url').'_'.lang('habitacion_url').'/'.$data['id_habitacion'] => $temp
																		)
																	  );
            }
			else
			{
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
							                							array(
							                								lang('backend_url') => lang('backend'),
																			lang('backend_url').'/'.lang('habitaciones_url') => lang('habitaciones'),
							                								lang('backend_url').lang('habitaciones_url').'/'.lang('crear_url') => lang('crear_tit_hab')
																		)
																	  );
            }


			/*	En esta zona se vuelve a construir la vista de la ficha,
			 * 	es importante cargar todas las vistas necesarias y variables.
			 * 	Para que las imagenes cargen es necesario cargar las vistas y las
			 *  urls de imagen_principal, imagenes_secundarias e inclusive imagenes_terciarias.
			 *
			 * */

			$data['url_add_p'] 	= base_url().lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('imagenes_url').'/'.$data['id_habitacion'].'/'.lang('adicionar_url').'/'.lang('principal'); //Imagen Principal
			$data['url_add_s'] 	= base_url().lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('imagenes_url').'/'.$data['id_habitacion'].'/'.lang('adicionar_url').'/'.lang('secundarias'); //Imagenes secundarias
			$data['url_add_t'] 	= base_url().lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('imagenes_url').'/'.$data['id_habitacion'].'/'.lang('adicionar_url').'/'.lang('terciarias'); //Imagenes terciarias
			$data['url_delete'] = base_url().lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('imagenes_url').'/'.lang('eliminar_url'); //Eliminar Imagen

			$data['imagen_principal'] 		= $this->multimedia_model->get_relation($data['id_habitacion'], 'habitacion', 1);
			$data['imagenes_secundarias'] 	= $this->multimedia_model->get_relation($data['id_habitacion'], 'habitacion', 2);
			$data['imagenes_terciarias'] 	= $this->multimedia_model->get_relation($data['id_habitacion'], 'habitacion', 3);
			$data['accion'] 				= ($this->input->post('accion') == 'normal') ? 'normal' : 'editar' ;
			$data['sub_activo'] 			= ($this->input->post('accion') == 'normal') ? 'NewLangTab' : 'EditLangTab' ;
			$data['habitacion_idiomas'] 	= $this->habitacion_model->detalles($data['id_habitacion']);
			$data['habitacion_info'] 		= $this->load->view('back/ficha/habitacion_info', $data, true);
			$data['idioma_info'] 			= $this->load->view('back/ficha/idioma_info', $data, true);
			$data['idioma_nuevo'] 			= $this->load->view('back/ficha/idioma_habitacion', $data, true); //Vista para la creación de nuevos idiomas
			$data['idioma_form'] 			= $this->load->view('back/ficha/idioma_habitacion', $data, true); //Vista para la creación de nuevos idiomas
			$data['habitacion_imagenes'] 	= $this->load->view('template/ficha_imagen', $data, true); //Ficha de la sección de imagenes
			$data['ficha_js'] 				= $this->load->view('template/ficha_imagen_js', $data, true); //Contenido js de la seccion ficha imagenes
            $data['menu_principal'] 		= $this->menus->create_mainmenu(lang('habitaciones_url'), 'listado');
			
			$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
            $data['contenido_principal'] = $this->load->view('back/ficha/ficha_habitacion', $data, true);
            $this->load->view('back/template_new', $data);
        }
        else
        {
			unset($data['accion']);
            //Convertir saltos de linea en <br />
            //$data['descripcion_ampliada'] = nl2br($data['descripcion_ampliada']);

			$data['descripcion_ampliada'] = preg_replace(array("#<p>&nbsp;</p>#i", "#(<br ?/>)+$#i"), array("", ""), $data['descripcion_ampliada']);

            $id = $this->habitacion_model->update_idioma($data);

            modules::run('services/monitor/add', 'detalle_habitacion', $id, $this->session->userdata('id_usuario'), 'editar_idioma');
			if($this->session->userdata('idioma') == 'es')
			{
				redirect(lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('ficha_url').'_'.lang('habitacion_url').'/'.$data['id_habitacion']);
			}
			else
			{
				redirect(lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('habitacion_url').'_'.lang('ficha_url').'/'.$data['id_habitacion']);
			}
        }
    }

	function imagen($id, $destacado = 1)
	{
		$this->lang->load('back', 'es');
        if ($id == '')
		{
			redirect('backend/habitaciones');
		}
		if ($_FILES)
		{
			require FCPATH.'server/index.php';
			return;
		}

		$data['habitacion'] 	= $this->habitacion_model->read($id);
		$data['tipo'] 			= "habitacion";
		$data['id'] 			= $id;
		$data['destacado'] 		= $destacado;
		$data['url'] 			= base_url().lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('imagenes_url').'/'.lang('procesar_url').'_'.lang('imagenes_url');
		$data['imagen'] = TRUE;
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => 	lang('backend'),
        																lang('backend_url').'/'.lang('habitaciones_url') => lang('habitaciones'),
        																lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('listado_url') => lang('listado'),
        																lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('ficha_url').'_'.lang('habitacion_url').'/'.$id => (isset($data['habitacion']->nombre) ? lang('ficha_inicio').' ' . $data['habitacion']->nombre : lang('habitaciones_sintitulo')),
        																lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('ficha_url').'_'.lang('habitacion_url').'/'.$id.'/'.lang('adicionar_url') => lang('subir_imagen')
																	 )
															  );
		
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('habitaciones_url'), 'listado');
		$data['active'] 		= 'habitaciones';
		$data['sub'] 			= 'ficha';
		$data['title'] 			= lang('meta.titulo').' - '.lang('habitaciones').' - '.lang('subir_imagen');
		
		$data['usuario'] 		= array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		
		//$data['file_upload'] = $this->load->view('back/includes/img_upload', $data, true);
		
		$data['file_upload_js'] 		= $this->load->view('template/file_upload_js', $data, true); //Widget de subida de imagenes
		$data['file_upload_widget'] 	= $this->load->view('template/file_upload_widget', $data, true); //Widget de subida de imagenes
		$data['contenido_principal'] 	= $this->load->view('template/subida_imagen', $data, true);
		$this->load->view('back/template_new', $data);
	}


	function imagen_procesar()
	{
		$this->load->model('multimedia/multimedia_model');
		$imagenes = $this->input->post('valores');

		$name = array(1, 2 , 3, 4);
		foreach($imagenes as $imagen){
			$data_img = array(
								'fichero' => $imagen['fichero'],
								'destacado' => $imagen['destacado'],
								'id_tipo' => 1,
								'id_estado' => 1,
								'id_usuario' => $this->session->userdata('id_usuario')
						 );
			$id_imagen = $this->multimedia_model->guardar_imagen($data_img, 800, 600, 400, 300, 130, 115);
			$data_rel = array(
								'id_habitacion' => $imagen['id'],
								'id_multimedia' => $id_imagen
						   );
			$this->multimedia_model->crear_rel_multimedia($data_rel, 'habitacion');
		}
	}

	function imagen_eliminar(){
		$this->load->model('multimedia/multimedia_model');
		$this->multimedia_model->delete_image($this->input->post('id_multimedia'), 'habitacion', $this->input->post('fichero'));
	}

    function eliminar_idioma($id_habitacion, $id_detalle_habitacion = '', $ajax = false)
    {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        modules::run('services/monitor/add', 'detalle_habitacion', $id_detalle_habitacion, $this->session->userdata('id_usuario'), 'eliminar_idioma');
        //$detalle = $this->detalle($id);
        $ret = $this->habitacion_model->eliminar_idioma($id_detalle_habitacion);
        $str = ($ret == true) ? 'true' : 'false';
        if ($ajax)
            echo '[{result:' . $str . '}]';
        else
            redirect('backend/ficha_habitacion/' . $id_habitacion);
    }
	
	function detalle($id, $ajax = false)
    {
        //$ret = $this->noticia_model->get('detalle_noticia', $id);
        $ret = $this->habitacion_model->get('detalle_habitacion',$id);
        if ($ajax)
		{
			echo json_encode($ret);
		}
        else
		{
			return $ret;
		}
    }

    function delete($id, $ajax = false)
    {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        $ret = $this->habitacion_model->delete($id);
        $str = ($ret == true) ? 'true' : 'false';
        if ($ajax)
            echo '[{result:' . $str . '}]';
        else
            //return $ret;
            return $this->listado();
    }

    /*
     * Fin funcciones del admin */


    /*
     * Funciones generales, accesibles sin autentificacion */

    function read($id, $ajax = false, $detalle_id = '') {
        $ret = $this->habitacion_model->read($id, $detalle_id);
        if ($ajax)
            echo json_encode($ret);
        else
            return $ret;
    }





    /*
     * Fin funciones libres */

    /* funciones de callback
     * */


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
