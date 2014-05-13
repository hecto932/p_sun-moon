<?php

class Evento extends MX_Controller {

    function __construct() {

		parent::__construct();
		$this->load->helper(array('form', 'url'));
		modules::run('idioma/set_idioma', 'es');
        $this->load->model('evento_model');
        $this->load->helper('multimedia');

    }

    /*
     * Funcciones del admin, con control de aceso */

    function index() {

        $this->listado();
    }

    function listado($order_field = 'evento.id_evento', $order_dir = 'desc', $start = 0, $ajax = false) {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        if ($start == 0 && empty($_POST) && $order_field == 'evento.id_evento')
        {
        	$this->session->unset_userdata('terminos_busqueda');
        }
        $terminos_busqueda = array();
        $terminos_busqueda = $this->session->userdata('terminos_busqueda');
        if (isset($_POST['texto'])) {
            $terminos_busqueda['texto'] = $_POST['texto'];
        }
        if (isset($_POST['id_evento'])) {
            $terminos_busqueda['evento.id_evento'] = $_POST['id_evento'];
        }
        if (isset($_POST['id_estado'])) {
            $terminos_busqueda['evento.id_estado'] = $_POST['id_estado'];
        }
		

        if (isset($_POST) && !empty($_POST)) {
            $terminos_busqueda = array_filter($terminos_busqueda);
            $this->session->set_userdata('terminos_busqueda', $terminos_busqueda);
        }
        $limit = 5;
        $order_string = '';
        $order_string.= ($order_field == "") ? '' : $order_field;
        $order_string.= ($order_dir == "") ? '' : ' ' . $order_dir;

        $od = ($order_dir == 'asc') ? 'desc' : 'asc';
        $data['order_field'] = $order_field;
        $data['order_dir'] = $order_dir;
        $data['order_by_new'] = (($order_field == '') ? 'id_evento' : $order_field) . "/" . $od;
        $data['url'] = lang('backend_url').'/'.lang('eventos_url').'/'.lang('listado_url');
        $config['base_url'] = '/'.lang('backend_url').'/'.lang('eventos_url').'/'.lang('listado_url').'/'.$order_field.'/'.$order_dir;
        $config['per_page'] = $limit;
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
        $data['num_eventos'] = $this->evento_model->count_all($terminos_busqueda);
        
        // $data['num_eventos'] = count($data['eventos']);
        $config['total_rows'] = $data['num_eventos'];
        if ($config['total_rows'] == 0)
		{
            redirect(lang('backend_url').'/'.lang('eventos_url').'/'.lang('buscar_url').'/'.lang('ningun_resultado'));
		}
		$data['eventos'] = $this->evento_model->get_page($start, $limit, $order_field, $order_dir, 'back', $terminos_busqueda);
        if ($ajax)
        {
            echo json_encode($data['eventos']);
        }
        else
        {
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['offset'] = $start;
            $data['order_field'] = $order_field;
            $data['order_direction'] = $order_dir;
            $data['active'] = 'eventos';
            if (!empty($terminos_busqueda))
            {
            	$data['sub'] = 'buscar';
            }
            else
			{
				$data['sub'] = 'listado';
			}
            $data['title'] = lang('meta.titulo').' - '.lang('eventos').' - '.lang('listado');
            if (!empty($terminos_busqueda))
            {
                $lbc = reset($terminos_busqueda);
                $lbt = key($terminos_busqueda);
				
                if ($lbt == 'evento.id_estado')
                {
                    $bcc = modules::run('services/relations/get_from_id', 'estado', $lbc);
                    $lbc = ucwords($bcc->estado);
				}
                if ($lbt == 'evento.id_producto')
                {
                    $bcc = modules::run('services/relations/get_from_id', 'producto', $lbc);
                    $lbc = ucwords($bcc->nombre);
                }
               // echo 'lbc:<pre>'.print_r($lbc,true).'</pre><br>lbt:<pre>'.print_r($lbt,true).'</pre>';die();
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                															array(
                																	lang('backend_url') => lang('backend'),
                																	lang('backend_url').'/'.lang('eventos_url') => lang('eventos'),
                							 										lang('backend_url').'/'.lang('eventos_url').'/'.lang('buscar_url') => lang('busqueda'),
                							 										lang('titulo') => $lbc
																				 )
											 						  );
            }
            else
            {
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                															array(
                																	lang('backend_url') => lang('backend'),
                																	lang('backend_url').'/'.lang('eventos_url') => lang('eventos'),
                							 										lang('backend_url').'/'.lang('eventos_url').'/'.lang('listado_url') => lang('listado')
																				 )
											 						  );
            }
			$data['menu_principal'] = $this->menus->create_mainmenu(lang('eventos_url'), 'listado');
			$data['usuario'] = array(
										'nombre' => $this->session->userdata('nombre'),
										'apellidos' => $this->session->userdata('apellidos')
									);
			$data['contenido_principal'] = $this->load->view('back/listar/listado_evento', $data, true);
            $this->load->view('back/template_new', $data);
        }
    }

    function buscar($mensaje = '')
	{
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        $data['active'] = 'eventos';
        $data['sub'] = 'buscar';
        $data['title'] = lang('meta.titulo').' - '.lang('eventos').' - '.lang('buscar_tit_evn');
        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => lang('backend'),
        																lang('backend_url').'/'.lang('eventos_url') => lang('eventos'),
        																lang('backend_url').'/'.lang('eventos_url').'/'.lang('buscar_url') => lang('buscar_tit_evn')));
        $data['mensaje'] = $mensaje;
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('eventos_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
        $data['contenido_principal'] = $this->load->view('back/buscar/buscar_evento', $data, true);
        $this->load->view('back/template_new', $data);
    }

    function crear()
    {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		$this->load->helper('misc');
        $data['active'] = 'eventos';
        $data['sub'] = 'crear';
		$data['title'] = lang('meta.titulo').' - '.lang('eventos').' - '.lang('crear_tit_evn');
        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
        															array(
        																	lang('backend_url') => lang('backend'),
										    								lang('backend_url').'/'.lang('eventos_url') => lang('eventos'),
										    							 	lang('backend_url').'/'.lang('eventos_url').'/'.lang('crear_url') => lang('crear_tit_evn')
																		 )
															  );

		$data['array_destacado'] = destacado_dropdown();
		$data['tipo_eventos'] = get_tipo_eventos();
        $data['estados'] = modules::run('services/relations/get_all', 'estado', 'true');
		$data['tipo_servicios'] = $this->evento_model->get_tipo_evento_dropdown();
		$data['tipo_pagos'] = $this->evento_model->get_tipo_pago();
        $data['eventos'] = modules::run('services/relations/get_all', 'evento', 'true');
		$data['eventos_js'] = $this->load->view('back/js/eventos_js', $data, true);
		$data['eventos_css']	= $this->load->view('back/css/evento_css', $data, true	);
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('eventos_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		$data['crear'] = TRUE;
        $data['contenido_principal'] = $this->load->view('back/crear/crear_evento', $data, true);
        $this->load->view('back/template_new', $data);
    }


    function create($id = '') {
        $img_folder = 'assets/front/img/';

        if ($id != '')
        {
        	modules::run('services/monitor/add', 'evento', $id, $this->session->userdata('id_usuario'), 'editar');
        }
        else
        {
        	modules::run('services/monitor/add', 'evento', '', $this->session->userdata('id_usuario'), 'crear');
        }
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        $this->load->library('form_validation');
		$this->load->helper('misc');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        $this->form_validation->set_rules('id_estado', 'Estado', 'required');
        $this->form_validation->set_rules('creado', 'Fecha', 'required|callback_fecha_pasada');
        $this->form_validation->set_message('fecha_pasada', 'La fecha de publicacion no pueden estar en el futuro');
        $config['upload_path'] = './assets/pdf';
        $config['allowed_types'] = 'pdf';
        $this->load->library('upload', $config);
        if ($this->form_validation->run() == FALSE)
        {
            $data['sub'] = 'crear';
            $data['title'] = lang('meta.titulo').' - '.lang('eventos').' - '.lang('crear_tit_evn');
            if ($id != '')
            {
                $data['evento'] = $this->evento_model->read($id);
                $data['title'] = lang('editar_tit_evn');
            }
            $data['active'] = 'evento';

            if ($id != '')
            {
            	$data['breadcrumbs'] = $this->menus->create_breadcrumb(
            															array(
            																	'evento' => lang('eventos'),
            																	'edit'	=>	lang('editar_tit_evn'),
            																	$id	=>	$data['evento']->nombre
																			 )
																	  );
            }
            else
            {
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                														array(
                																'evento' => lang('eventos'),
                																'crear' => lang('crear_tit_evn')
																			 )
																	  );
            }
			$data['array_destacado'] = destacado_dropdown();
			$data['tipo_eventos'] = get_tipo_eventos();
			$data['tipo_pagos'] = $this->evento_model->get_tipo_pago();
            $data['estados'] = modules::run('services/relations/get_all', 'estado', 'true');
			$data['eventos_js'] = $this->load->view('back/js/eventos_js', $data, true);
            $data['contenido_principal'] = $this->load->view('back/crear/crear_evento', $data, true);
            $this->load->view('back/template_new', $data);
        }


         else
         {

            $form_data = $_POST;
			unset($form_data['section']);
			
			$data['tipo_pagos'] = $this->evento_model->get_tipo_pago();
			$add_evento_pagos = array();
			$del_evento_pagos = array();
			foreach($data['tipo_pagos'] as $pago){
				if(isset($form_data[$pago->nombre_pago])){
					$add_evento_pagos[$pago->id_tipo_pago] = $pago->id_tipo_pago;
					unset($form_data[$pago->nombre_pago]);
				}
				else{
					$del_evento_pagos[$pago->id_tipo_pago] = $pago->id_tipo_pago;
				}
			}
			
			if ( ! array_key_exists('inscripcion', $form_data))
			{
				$form_data['inscripcion'] = "0";
			}
			$form_data['precio_evento'] = str_replace('.', '', $form_data['precio_evento']);
            $id = $this->evento_model->update($form_data);
			$this->evento_model->add_pago_evento($id, $add_evento_pagos);
			$this->evento_model->del_pago_evento($id, $del_evento_pagos);

			/*$section = array('section'=>$form_data['section']);
			$this->evento_model->add_section($section,$id);
			unset($form_data['section']);*/
			
			if($this->session->userdata('idioma') == 'es')
			{
            	redirect(lang('backend_url').'/'.lang('eventos_url').'/'.lang('ficha_url').'_'.lang('evento_url').'/' . $id, 'location');
            }
			else
			{
				redirect(lang('backend_url').'/'.lang('eventos_url').'/'.lang('articulo_url').'_'.lang('ficha_url').'/' . $id, 'location');
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
        $data['active'] = 'evento';
        $data['sub'] = 'editar';
		$this->load->helper('misc');
        $data['evento'] = $this->evento_model->read($id);
		$data['rel_evento_pago'] = $this->evento_model->get_rel_evento_pago($id);
		//echo '<pre>'.print_r($data['rel_evento_pago'], true).'</pre>'; die();
        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
									        					   array(
									        					   			lang('backend_url') => lang('backend'),
									        								lang('backend_url').'/'.lang('eventos_url') => lang('eventos'),
									        								lang('backend_url').'/'.lang('eventos_url').'/'.lang('ficha_url').'_'.lang('evento_url').'/'.$id => lang('editar_tit_even'),
									        								'#' => $data['evento']->nombre
																		)
															  );
        $data['title'] = lang('meta.titulo').' - '.lang('eventos').' - '.lang('editar').' '.$data['evento']->nombre;
		$data['eventos_js'] = $this->load->view('back/js/eventos_js', $data, true);
		$tipo_eventos = $this->evento_model->get_tipo_evento();
		$data['array_destacado'] = destacado_dropdown();
		$data['tipo_eventos'] = get_tipo_eventos();
		$data['tipo_pagos'] = $this->evento_model->get_tipo_pago();
        $data['estados'] = modules::run('services/relations/get_all', 'estado', 'true');
		$data['eventos_css'] = $this->load->view('back/css/evento_css', $data, true);
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('eventos_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
        $data['contenido_principal'] = $this->load->view('back/crear/crear_evento', $data, true);
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
		$this->load->helper('misc');
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', 'es');
        if ($id == '')
		{
			redirect('backend/eventos');
		}
        $data['active'] = 'evento';
        $data['sub'] = 'editar';
        $data['evento'] = $this->evento_model->read($id);
        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => lang('backend'),
        																lang('backend_url').'/'.lang('eventos_url') => lang('eventos'),
        																lang('backend_url').'/'.lang('eventos_url').'/'.lang('listado_url') => lang('listado'),
        																lang('backend_url').'/'.lang('eventos_url').'/'.lang('ficha_url').'_'.lang('evento_url').'/'.$id => (isset($data['evento']->nombre) ? lang('ficha_inicio').' ' . $data['evento']->nombre : lang('eventos_sintitulo'))
																	 )
															  );
		/*--- Zona de url ----*/


		$data['url_add_p'] = base_url().lang('backend_url').'/'.lang('eventos_url').'/'.lang('imagenes_url').'/'.$id.'/'.lang('adicionar_url').'/'.lang('principal'); //Imagen Principal
		$data['url_add_s'] = base_url().lang('backend_url').'/'.lang('eventos_url').'/'.lang('imagenes_url').'/'.$id.'/'.lang('adicionar_url').'/'.lang('secundarias'); //Imagenes secundarias
		$data['url_add_t'] = base_url().lang('backend_url').'/'.lang('eventos_url').'/'.lang('imagenes_url').'/'.$id.'/'.lang('adicionar_url').'/'.lang('terciarias'); //Imagenes terciarias
		$data['url_delete'] = base_url().lang('backend_url').'/'.lang('eventos_url').'/'.lang('imagenes_url').'/'.lang('eliminar_url'); //Eliminar Imagen


        $data['title'] = lang('meta.titulo').' - '.lang('eventos').' - '.(isset($data['evento']->nombre) ? lang('ficha_inicio').' ' . $data['evento']->nombre : lang('eventos_sintitulo'));
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('eventos_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		$data['accion'] = 'normal';
		$data['sub_activo'] = 'Ficha';
		$data['imagen_principal'] = $this->multimedia_model->get_relation($id, 'evento', 1);
		$data['imagenes_secundarias'] = $this->multimedia_model->get_relation($id, 'evento', 2);
		$data['imagenes_terciarias'] = $this->multimedia_model->get_relation($id, 'evento', 3);
		$data['archivos'] = $this->multimedia_model->get_relation($id, 'evento', 4);
        $data['evento_idiomas'] = $this->evento_model->detalles($id);


		/*--- Cargas de vistas ---*/
		$data['evento_imagenes'] = $this->load->view('template/ficha_imagen', $data, true); //Ficha de la sección de imagenes
		$data['ficha_js'] = $this->load->view('template/ficha_imagen_js', $data, true); //Contenido js de la seccion ficha imagenes
		$data['eventos_js'] = $this->load->view('back/js/eventos_js.php', $data, true);
		$data['evento_info'] = $this->load->view('back/ficha/evento_info', $data, true); //Información básica de la evento
		$data['idioma_info'] = $this->load->view('back/ficha/idioma_info', $data, true); //Información de los idiomas
		$data['idioma_form'] = $this->load->view('back/ficha/idioma_evento', $data, true); //Vista para la edición de nuevos idiomas
		$data['idioma_nuevo'] = $this->load->view('back/ficha/idioma_evento', $data, true); //Vista para la creación de nuevos idiomas
        $data['contenido_principal'] = $this->load->view('back/ficha/ficha_evento', $data, true); //Carga de contenido principal
        $this->load->view('back/template_new', $data);
    }

    function editar_idioma($id_evento, $id_detalle_evento = '')
    {
    	$this->load->model('multimedia/multimedia_model');
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        if ($id_detalle_evento == '')
		{
			redirect(lang('backend_url').'/'.lang('eventos_url').'/'.lang('ficha_url').'_'.lang('evento_url').'/'.$id_evento);
		}
		$data['evento'] = $this->evento_model->read($id_evento, $id_detalle_evento);
//		echo '<pre>' . print_r($data['evento']) . '</pre>'; die();
		$data['active'] = 'eventos';
		$data['sub'] = 'ficha';
		$data['accion'] = 'editar';
		$data['sub_activo'] = 'EditLangTab';
		$data['title'] = lang('meta.titulo').' - '.lang('eventos').' - '.lang('editar_idioma');
		$data['imagen_principal'] = $this->multimedia_model->get_relation($id_evento, 'evento', 1);
		$data['imagenes_secundarias'] = $this->multimedia_model->get_relation($id_evento, 'evento', 2);
		$data['imagenes_terciarias'] = $this->multimedia_model->get_relation($id_evento, 'evento', 3);
		$data['url_add_p'] = base_url().lang('backend_url').'/'.lang('eventos_url').'/'.lang('imagenes_url').'/'.$id_evento.'/'.lang('adicionar_url').'/'.lang('principal'); //Imagen Principal
		$data['url_add_s'] = base_url().lang('backend_url').'/'.lang('eventos_url').'/'.lang('imagenes_url').'/'.$id_evento.'/'.lang('adicionar_url').'/'.lang('secundarias');	//Imagenes secundarias
		$data['url_add_t'] = base_url().lang('backend_url').'/'.lang('eventos_url').'/'.lang('imagenes_url').'/'.$id_evento.'/'.lang('adicionar_url').'/'.lang('terciarias');	//Imagenes terciarias
		$data['url_delete'] = base_url().lang('backend_url').'/'.lang('eventos_url').'/'.lang('imagenes_url').'/'.lang('eliminar_url'); //Eliminar Imagen
		$data['evento_imagenes'] = $this->load->view('template/ficha_imagen', $data, true); //Ficha de la sección de imagenes
		$data['ficha_js'] = $this->load->view('template/ficha_imagen_js', $data, true); //Contenido js de la seccion ficha imagenes
		$data['evento_idiomas'] = $this->evento_model->detalles($id_evento, $id_detalle_evento);
		$data['evento_info'] = $this->load->view('back/ficha/evento_info', $data, true);
		$data['idioma_info'] = $this->load->view('back/ficha/idioma_info', $data, true);
		$data['idioma_form'] = $this->load->view('back/ficha/idioma_evento', $data, true);
        $data['menu_principal'] = $this->menus->create_mainmenu(lang('eventos_url'), 'listado');
		$data['usuario'] = array(
								'nombre' => $this->session->userdata('nombre'),
								'apellidos' => $this->session->userdata('apellidos')
							);
        $data['contenido_principal'] = $this->load->view('back/ficha/ficha_evento', $data, true);
        $this->load->view('back/template_new', $data);

    }


    function guardar_idioma()
    {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        $data = $_POST;
		/*$pago = $data['centros_pago'];
		unset($data['centros_pagos']);
		$data['centros_pago'] = $pago;*/
		
		$this->load->model('multimedia/multimedia_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        $this->load->helper(array('form', 'url'));
        $this->form_validation->set_rules('id_idioma', lang('evento_idi_idioma'), 'required');
        $this->form_validation->set_rules('nombre', lang('evento_idi_nombre'), 'required|min_length[5]');
        $this->form_validation->set_rules('subtitulo', lang('evento_idi_subtit'), 'min_length[5]');
        $this->form_validation->set_rules('descripcion_breve', lang('evento_idi_descb'), 'min_length[10]|required');
        $this->form_validation->set_rules('descripcion_ampliada', lang('evento_idi_desca'), 'min_length[50]|required');
        $this->form_validation->set_rules('url', lang('evento_idi_url'), 'required|callback_existe_url');
        $this->form_validation->set_rules('titulo_pagina', lang('evento_idi_titpag'), 'required|min_length[5]');
        $this->form_validation->set_rules('descripcion_pagina', lang('evento_idi_descpag'), 'required|min_length[10]');
        $this->form_validation->set_rules('keywords', lang('evento_idi_keywords'), 'required');
        if ($this->form_validation->run($this) == FALSE)
        {
            $data['active'] = 'evento';
            $data['sub'] = 'crear';
            $data['title'] = lang('meta.titulo').' - '.lang('eventos').' - '.lang('idioma_edt_evn');
            if ($data['id_evento'] != '')
			{
                $data['evento'] = modules::run('evento/read', $data['id_evento']);
				$data['breadcrumbs'] = $this->menus->create_breadcrumb(
																		array(
																			lang('backend_url').'/'.lang('eventos_url') => lang('eventos'),
																			lang('backend_url').'/'.lang('eventos_url').'/'.lang('ficha_url').'_'.lang('evento_url').'/'.$data['id_evento'] => lang('eventos_ficha_tit'),
																			'#' => lang('idioma_edt_evn'),
																			'#' => ($data['nombre'] != '') ? $data['nombre'] : lang('eventos_sintitulo')
																		)
																	  );
            }
			else
			{
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
							                							array(
							                								lang('backend_url').'/'.lang('eventos_url') => lang('eventos'),
							                								lang('backend_url').'/'.lang('eventos_url').'/'.lang('crear_url') => lang('crear_tit_evn')
																		)
																	  );
            }

			/*	En esta zona se vuelve a construir la vista de la ficha,
			 * 	es importante cargar todas las vistas necesarias y variables.
			 * 	Para que las imagenes cargen es necesario cargar las vistas y las
			 *  urls de imagen_principal, imagenes_secundarias e inclusive imagenes_terciarias.
			 *
			 * */

			$data['imagen_principal'] = $this->multimedia_model->get_relation($data['id_evento'], 'evento', 1);
			$data['imagenes_secundarias'] = $this->multimedia_model->get_relation($data['id_evento'], 'evento', 2);
			$data['imagenes_terciarias'] = $this->multimedia_model->get_relation($data['id_evento'], 'evento', 3);
			$data['url_add_p'] = base_url().lang('backend_url').'/'.lang('eventos_url').'/'.lang('imagenes_url').'/'.$data['id_evento'].'/'.lang('adicionar_url').'/'.lang('principal'); //Imagen Principal
			$data['url_add_s'] = base_url().lang('backend_url').'/'.lang('eventos_url').'/'.lang('imagenes_url').'/'.$data['id_evento'].'/'.lang('adicionar_url').'/'.lang('secundarias');	//Imagenes secundarias
			$data['url_add_t'] = base_url().lang('backend_url').'/'.lang('eventos_url').'/'.lang('imagenes_url').'/'.$data['id_evento'].'/'.lang('adicionar_url').'/'.lang('terciarias');	//Imagenes terciarias
			$data['url_delete'] = base_url().lang('backend_url').'/'.lang('eventos_url').'/'.lang('imagenes_url').'/'.lang('eliminar_url'); //Eliminar Imagen


			$data['accion'] = ($this->input->post('accion') == 'normal') ? 'normal' : 'editar' ;
			$data['sub_activo'] = ($this->input->post('accion') == 'normal') ? 'NewLangTab' : 'EditLangTab';



			$data['evento_idiomas'] = $this->evento_model->detalles($data['id_evento']);
			$data['evento_imagenes'] = $this->load->view('template/ficha_imagen', $data, true); //Ficha de la sección de imagenes
			$data['ficha_js'] = $this->load->view('template/ficha_imagen_js', $data, true); //Contenido js de la seccion ficha imagenes
			$data['evento_info'] = $this->load->view('back/ficha/evento_info', $data, true);
			$data['idioma_info'] = $this->load->view('back/ficha/idioma_info', $data, true);
			$data['idioma_nuevo'] = $this->load->view('back/ficha/idioma_evento', $data, true); //Vista para la creación de nuevos idiomas
			$data['idioma_form'] = $this->load->view('back/ficha/idioma_evento', $data, true); //Vista para la edición de nuevos idiomas
            $data['menu_principal'] = $this->menus->create_mainmenu(lang('eventos_url'), 'listado');
			$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
            $data['contenido_principal'] = $this->load->view('back/ficha/ficha_evento', $data, true);
            $this->load->view('back/template_new', $data);
        }
        else
        {
			unset($data['accion']);
            //Convertir saltos de linea en <br />
            //$data['descripcion_ampliada'] = nl2br($data['descripcion_ampliada']);

            $data['descripcion_ampliada'] = preg_replace("#(<p>&nbsp;</p><br?/>)+#i", '', $data['descripcion_ampliada']);

            $id = $this->evento_model->update_idioma($data);

            modules::run('services/monitor/add', 'detalle_evento', $id, $this->session->userdata('id_usuario'), 'editar_idioma');
			if($this->session->userdata('idioma') == 'es')
			{
				redirect(lang('backend_url').'/'.lang('eventos_url').'/'.lang('ficha_url').'_'.lang('evento_url').'/'.$data['id_evento']);
			}
			else
			{
				redirect(lang('backend_url').'/'.lang('eventos_url').'/'.lang('evento_url').'_'.lang('ficha_url').'/'.$data['id_evento']);
			}
        }
    }

	function imagen($id, $destacado = 1)
	{
		$this->lang->load('back', 'es');
        if ($id == '')
		{
			redirect('backend/eventos');
		}
		if ($_FILES)
		{
			require FCPATH.'server/index.php';
			return;
		}

		$data['evento'] = $this->evento_model->read($id);
		$data['tipo'] = "evento";
		$data['id'] = $id;
		$data['destacado'] = $destacado;
		$data['url'] = base_url().lang('backend_url').'/'.lang('eventos_url').'/'.lang('imagenes_url').'/'.lang('procesar_url').'_'.lang('imagenes_url');
		$data['imagen'] = TRUE;
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => 	lang('backend'),
        																lang('backend_url').'/'.lang('eventos_url') => lang('eventos'),
        																lang('backend_url').'/'.lang('eventos_url').'/'.lang('listado_url') => lang('listado'),
        																lang('backend_url').'/'.lang('eventos_url').'/'.lang('ficha_url').'_'.lang('evento_url').'/'.$id => (isset($data['evento']->nombre) ? lang('ficha_inicio').' ' . $data['evento']->nombre : lang('eventos_sintitulo')),
        																lang('backend_url').'/'.lang('eventos_url').'/'.lang('ficha_url').'_'.lang('evento_url').'/'.$id.'/'.lang('adicionar_url') => lang('subir_imagen')
																	 )
															  );
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('eventos_url'), 'listado');
		$data['active'] = 'eventos';
		$data['sub'] = 'ficha';
		$data['title'] = lang('meta.titulo').' - '.lang('eventos').' - '.lang('subir_imagen');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		$data['file_upload_js'] = $this->load->view('template/file_upload_js', $data, true); //Widget de subida de imagenes
		$data['file_upload_widget'] = $this->load->view('template/file_upload_widget', $data, true); //Widget de subida de imagenes
		$data['contenido_principal'] = $this->load->view('back/ficha/subida_imagen', $data, true);
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
								//'id_evento' => 1,
								'id_estado' => 1,
								'id_usuario' => $this->session->userdata('id_usuario')
						 );
			$id_imagen = $this->multimedia_model->guardar_imagen($data_img, 800, 600, 400, 300, 130, 115);
			$data_rel = array(
								'id_evento' => $imagen['id'],
								'id_multimedia' => $id_imagen
						   );
			$this->multimedia_model->crear_rel_multimedia($data_rel, 'evento');
		}
	}

	function imagen_eliminar(){
		$this->load->model('multimedia/multimedia_model');
		$this->multimedia_model->delete_image($this->input->post('id_multimedia'), 'evento', $this->input->post('fichero'));
	}

    function eliminar_idioma($id_evento, $id_detalle_evento, $ajax = false)
    {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        modules::run('services/monitor/add', 'detalle_evento', $id_detalle_evento, $this->session->userdata('id_usuario'), 'eliminar_idioma');
       // $detalle = $this->detalle($id);
        $ret = $this->evento_model->eliminar_idioma($id_detalle_evento);
        $str = ($ret == true) ? 'true' : 'false';
        if ($ajax)
            echo '[{result:' . $str . '}]';
        else
            redirect('backend/eventos/ficha_evento/' . $id_evento);
    }

	function eliminar_pdf($id_evento='', $fichero=''){
		//$data = $_POST;
		$this->load->language('back');
		$this->load->helper('misc');
		$url_ficha = base_url().lang('backend_url').'/'.lang('eventos_url').'/'.lang('ficha_url').'_'.lang('evento_url').'/'.$id_evento;
		$this->load->model('multimedia/multimedia_model');
		$relacion = $this->multimedia_model->get_relation($id_evento, 'evento', 4);
		$id_multimedia = $relacion[0]->id_multimedia;
		$band = $this->multimedia_model->delete_document($id_multimedia, 'evento', 'eventos', $fichero);
		if($band == TRUE){
			$this->session->set_flashdata('mensaje', lang('archivo_elim'));
		}
		else {
			$this->session->set_flashdata('mensaje', lang('archivo_nelim'));
		}
		redirect($url_ficha);
	}

    function delete($id, $ajax = false)
    {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        $ret = $this->evento_model->delete($id);
        $str = ($ret == true) ? 'true' : 'false';
        if ($ajax)
            echo '[{result:' . $str . '}]';
        else
            $this->listado();
    }
	
	function delete_insc($id, $ajax = false)
    {
    	$this->load->model('inscripcion_model');
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        $ret = $this->inscripcion_model->delete($id);
        $str = ($ret == true) ? 'true' : 'false';
        if ($ajax)
            echo '[{result:' . $str . '}]';
        else
            $this->listado();
    }

    /*
     * Fin funcciones del admin */


    /*
     * Funciones generales, accesibles sin autentificacion */

    function read($id, $ajax = false, $detalle_id = '') {
        $ret = $this->evento_model->read($id, $detalle_id);
        if ($ajax)
            echo json_encode($ret);
        else
            return $ret;
    }
	
	function exist_url()
	{
		$url = $this->input->post('url');
		if($this->evento_model->exist_url($url))
		{
			echo 'true';
			return TRUE;
		}else
		{
			echo 'false';
			return FALSE;
		}
	}
	
	function existe_url()
	{
		$url = $this->input->post('url');
		if(!$this->evento_model->exist_url($url))
		{
			echo 'true';
			return TRUE;
		}else
		{
			echo 'false';
			$this->form_validation->set_message('existe_url','Ya se existe un evento con ese URL.');
			return FALSE;
		}
	}

	function subir_pdf(){
		$data = $_POST;
		$this->load->language('back');
		$this->load->model('multimedia/multimedia_model');
		$url_ficha = base_url().lang('backend_url').'/'.lang('eventos_url').'/'.lang('ficha_url').'_'.lang('evento_url').'/'.$data['id_evento'];
		if (empty($_FILES['pdf_file']['name']))
		{
			if($_FILES['pdf_file']['error'] == 4)
			{
				$this->session->set_flashdata('mensaje', lang('archivo_nosubb'));
			}
			redirect($url_ficha);
		}
		else
		{
			$temp_resumen = pathinfo($_FILES['pdf_file']['name']);
			$config['file_name']		= $temp_resumen['basename'];
			$config['upload_path']  	= './assets/front/uploads/eventos/pdf';
			$config['allowed_types'] 	= 'pdf|gif|png|jpg|ppt|doc|xls|docx|xlsx';
			$config['max_size']			= '3500';
			$direccion_archivo = base_url().str_replace('./', '', $config['upload_path']).'/'.$temp_resumen['filename'].'.'.$temp_resumen['extension'];
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('pdf_file'))
			{
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('mensaje', lang('archivo_nosubc'));
			}
			else {
				$this->session->set_flashdata('mensaje', lang('archivo_sub'));
				$data_pdf = array(
									'fichero' => $temp_resumen['basename'],
									'destacado' => 4,
									'id_tipo' => 4,
									'id_estado' => 1,
									'id_usuario' => $this->session->userdata('id_usuario')
							 	);
				$id_multimedia = $this->multimedia_model->update($data_pdf);
				$data_rel = array(
									'id_evento' => $data['id_evento'],
									'id_multimedia' => $id_multimedia
							   );
				$this->multimedia_model->crear_rel_multimedia($data_rel, 'evento');
				
			}
			redirect($url_ficha);
		}
	}

    function get_evento_list($output = 'json', $f = 'evento.id_evento', $v = 1, $group = false)
    {
        $eventos = $this->evento_model->get_list($f, $v, $group);
        if ($output == 'xml') {
            $domDoc = new DOMDocument;
            foreach ($eventos as $evento)
            {
                $rootElt = $domDoc->createElement('evento');
                $rootNode = $domDoc->appendChild($rootElt);
                foreach ($evento as $field => $value)
                {
                    $subElt = $domDoc->createElement($field);
                    $textNode = $domDoc->createTextNode($value);
                    $subElt->appendChild($textNode);
                    $rootNode->appendChild($subElt);
                }
            }
            header('Content-Type: text/xml');
            echo $domDoc->saveXML();
        }
        elseif ($output == 'json')
        {
            echo json_encode($eventos);
        }
    }

    function detalle($id, $ajax = false)
    {
        //$ret = $this->evento_model->get('detalle_evento', $id);
        $ret = $this->evento_model->get($id); 	
       // echo '<pre>'. print_r($ret). '</pre>';die();
        	
        if ($ajax)
		{
			echo json_encode($ret);
		}
        else
		{
			return $ret;
		}
    }

    function eventos_categoria($id_categoria, $ajax = 1)
    {
        if ($ajax == 1)
		{
			echo modules::run('services/relations/get_from_categoria', $id_categoria, 'evento', $ajax);
		}
        else
		{
			return modules::run('services/relations/get_from_categoria', $id_categoria, 'evento', $ajax);
		}
    }
}





/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
