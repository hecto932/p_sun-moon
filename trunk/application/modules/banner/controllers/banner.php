<?php

class Banner extends MX_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		modules::run('idioma/set_idioma', 'es');
		modules::run('usuarios/is_logged_in','admin',$this->uri->uri_string());
        $this->load->helper('multimedia');
		$this->load->model('banner_model');
		
		//$img_folder = 'assets/front/assets/img/';

	}
	
	/* 
	 * Funcciones del admin, con control de aceso */
	function index()
	{
		
		$this->listado();
	}

	function listado($order_field = 'banner.id_banner', $order_dir = 'desc', $start = 0, $ajax = false) {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        if ($start == 0 && empty($_POST) && $order_field == 'banner.id_banner')
        {
        	$this->session->unset_userdata('terminos_busqueda');
        }
        $terminos_busqueda = array();
        $terminos_busqueda = $this->session->userdata('terminos_busqueda');
        if (isset($_POST['texto'])) {
            $terminos_busqueda['texto'] = $_POST['texto'];
        }
        if (isset($_POST['id_banner'])) {
            $terminos_busqueda['banner.id_banner'] = $_POST['id_banner'];
        }
        if (isset($_POST['id_estado'])) {
            $terminos_busqueda['banner.id_estado'] = $_POST['id_estado'];
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
        $data['order_field'] = $order_field;
        $data['order_dir'] = $order_dir;
        $data['order_by_new'] = (($order_field == '') ? 'id_banner' : $order_field) . "/" . $od;
        $data['url'] = lang('backend_url').'/'.lang('banners_url').'/'.lang('listado_url');
        $config['base_url'] = '/'.lang('backend_url').'/'.lang('banners_url').'/'.lang('listado_url').'/'.$order_field.'/'.$order_dir;
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
        $data['num_banners'] = $this->banner_model->count_all($terminos_busqueda);
        $config['total_rows'] = $data['num_banners'];
        //if ($config['total_rows'] == 0)
            //redirect(lang('backend_url').'/'.lang('banners_url').'/'.lang('buscar_url').'/'.lang('ningun_resultado'));
           
        $data['banners'] = $this->banner_model->get_page($start, $limit, $order_field, $order_dir, $terminos_busqueda);
        if ($ajax) {
            echo json_encode($data['banners']);
        }
        else
        {
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['offset'] = $start;
            $data['order_field'] = $order_field;
            $data['order_direction'] = $order_dir;
            $data['active'] = 'banners';
            if (!empty($terminos_busqueda))
            {
            	$data['sub'] = 'buscar';
            }
            else
			{
				$data['sub'] = 'listado';
			}
            $data['title'] = lang('meta.titulo').' - '.lang('banners').' - '.lang('listado');
            if (!empty($terminos_busqueda))
            {
                $lbc = reset($terminos_busqueda);
                $lbt = key($terminos_busqueda);

                if ($lbt == 'banners.id_estado')
                {
                    $bcc = modules::run('services/relations/get_from_id', 'estado', $lbc);
                    $lbc = ucwords($bcc->estado);
                }
                if ($lbt == 'banners.id_producto')
                {
                    $bcc = modules::run('services/relations/get_from_id', 'producto', $lbc);
                    $lbc = ucwords($bcc->nombre);
                }
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                															array(
                																	lang('backend_url') => lang('backend'),
                																	lang('backend_url').'/'.lang('banners_url') => lang('banners'),
                							 										lang('backend_url').'/'.lang('banners_url').'/'.lang('buscar_url') => lang('busqueda'),
                							 										lang('titulo') => $lbc
																				 )
											 						  );
            }
            else
            {
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                															array(
                																	lang('backend_url') => lang('backend'),
                																	lang('backend_url').'/'.lang('banners_url') => lang('banners'),
                							 										lang('backend_url').'/'.lang('banners_url').'/'.lang('listado_url') => lang('listado')
																				 )
											 						  );
            }
			$data['menu_principal'] = $this->menus->create_mainmenu(lang('banners_url'), 'listado');
			$data['usuario'] = array(
										'nombre' => $this->session->userdata('nombre'),
										'apellidos' => $this->session->userdata('apellidos')
									);
			$data['contenido_principal'] = $this->load->view('listado_banner', $data, true);
            $this->load->view('back/template_new', $data);
        }
    }
	
	function buscar($mensaje='')
	{
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        $data['active'] = 'banner';
        $data['sub'] = 'buscar';
        $data['title'] = lang('meta.titulo').' - '.lang('banners').' - '.lang('buscar_tit_bnn');
        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => lang('backend'),
        																lang('backend_url').'/'.lang('banners_url') => lang('banners'),
        																lang('backend_url').'/'.lang('banners_url').'/'.lang('buscar_url') => lang('buscar_tit_ban')));
        $data['mensaje'] = $mensaje;
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('banners_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
        $data['contenido_principal'] = $this->load->view('buscar_banner', $data, true);
        $this->load->view('back/template_new', $data);
	}
	
	function crear()
	{
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		$this->load->helper('misc');
        $data['active'] = 'banner';
        $data['sub'] = 'crear';
		$data['title'] = lang('meta.titulo').' - '.lang('banners').' - '.lang('crear_tit_bnn');
        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
        															array(
        																	lang('backend_url') => lang('backend'),
										    								lang('backend_url').'/'.lang('banners_url') => lang('banners'),
										    							 	lang('backend_url').'/'.lang('banners_url').'/'.lang('crear_url') => lang('crear_tit_bnn')
																		 )
															  );
        $data['estados'] = modules::run('services/relations/get_all', 'estado', 'true');
		//$data['banners_js'] = $this->load->view('back/js/banner_js.php', $data, true);
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('banners_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		$data['crear'] = TRUE;
        $data['contenido_principal'] = $this->load->view('crear_banner', $data, true);
        $this->load->view('back/template_new', $data);
	}
	
	
	function fecha_pasada($fecha){
        return mysql_to_unix($fecha) <= time();
    }
	
	function create($id='')
	{
		$img_folder = 'assets/front/img/';

        if ($id != '')
        {
        	modules::run('services/monitor/add', 'banner', $id, $this->session->userdata('id_usuario'), 'editar');
        }
        else
        {
        	modules::run('services/monitor/add', 'banner', '', $this->session->userdata('id_usuario'), 'crear');
        }
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        $this->form_validation->set_rules('id_estado', 'Estado', 'required');
		$this->form_validation->set_rules('slider', 'Slider', '');
		
        $this->load->library('upload');

        if ($this->form_validation->run() == FALSE)
        {
            $data['sub'] = 'crear';
            $data['title'] = lang('crear_tit_bnn');
            if ($id != '')
            {
                $data['banner'] = $this->banner_model->read($id);
                $data['title'] = lang('editar_tit_bnn');
            }
            $data['active'] = 'banner';

            if ($id != '')
            {
            	$data['breadcrumbs'] = $this->menus->create_breadcrumb(
            															array(
            																	'banner' => lang('banners'),
            																	'edit'	=>	lang('editar_tit_bnn'),
            																	$id	=>	'Banner '.$data['banner']->id_banner
																			 )
																	  );
            }
            else
            {
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                														array(
                																'banner' => lang('banners'),
                																'crear' => lang('crear_tit_bnn')
																			 )
																	  );
            }
            $data['estados'] = modules::run('services/relations/get_all', 'estado', 'true');
            $data['contenido_principal'] = $this->load->view('crear_banner', $data, true);
            $this->load->view('back/template_new', $data);
        }
		else
		{
		
		    $form_data = $_POST;
			$id = $this->banner_model->update($form_data);
			if($this->session->userdata('idioma') == 'es')
			{
				redirect(lang('backend_url').'/'.lang('banners_url').'/'.lang('ficha_url').'_'.lang('banner_url').'/' . $id, 'location');
			}
			else
			{
				redirect(lang('backend_url').'/'.lang('banners_url').'/'.lang('articulo_url').'_'.lang('ficha_url').'/' . $id, 'location');
			}
		}
	}

	function edit($id='',$ajax=false)
	{
		//die_pre($id);
		if ($id == '')
		{
            redirect('backend');
		}
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		$this->load->helper('misc');
        $data['active'] = 'banner';
        $data['sub'] = 'editar';

        $data['banner'] = $this->banner_model->read($id);

		$data['breadcrumbs'] = $this->menus->create_breadcrumb(
									        					   array(
									        					   			lang('backend_url') => lang('backend'),
									        								lang('backend_url').'/'.lang('banners_url') => lang('banners'),
									        								lang('backend_url').'/'.lang('banners_url').'/'.lang('ficha_url').'_'.lang('banner_url').'/'.$id => lang('editar_tit_bnn'),
									        								'#' => 'Banner '.$data['banner']->id_banner
																		)
															  );
		$data['title'] = lang('meta.titulo').' - '.lang('banners').' - '.lang('editar').' Banner '.$data['banner']->id_banner;
		$data['estados'] = modules::run('services/relations/get_all', 'estado', 'true');
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('banners_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
        $data['contenido_principal'] = $this->load->view('crear_banner', $data, true);
        if ($ajax)
		{
            echo $data['contenido_principal'];
		}
        else
		{
            $this->load->view('back/template_new', $data);
		}
	}

	function ficha($id='')
	{
		$this->load->model('multimedia/multimedia_model');
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        if ($id == '')
		{
			redirect('backend/banners');
		}
        $data['active'] = 'banner';
        $data['sub'] = 'editar';
        $data['banner'] = $this->banner_model->read($id);
        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => lang('backend'),
        																lang('backend_url').'/'.lang('banners_url') => lang('banners'),
        																lang('backend_url').'/'.lang('banners_url').'/'.lang('listado_url') => lang('listado'),
        																lang('backend_url').'/'.lang('banners_url').'/'.lang('ficha_url').'_'.lang('banner_url').'/'.$id => lang('ficha_inicio').' Banner '.$data['banner']->id_banner
																	 )
															  );
		/*--- Zona de url ----*/

		//Imagen Principal
		$data['url_add_p'] = base_url().lang('backend_url').'/'.lang('banners_url').'/'.lang('imagenes_url').'/'.$id.'/'.lang('adicionar_url').'/'.lang('principal');
		//Eliminar Imagen
		$data['url_delete'] = base_url().lang('backend_url').'/'.lang('banners_url').'/'.lang('imagenes_url').'/'.lang('eliminar_url');


        $data['title'] = lang('meta.titulo').' - '.lang('banners').' - '.lang('ficha_inicio').' Banner'.$data['banner']->id_banner;
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('banners_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		$data['accion'] = 'normal';
		$data['sub_activo'] = 'Ficha';
		$data['imagen_principal'] = $this->multimedia_model->get_relation($id, 'banner', 0);
        $data['banner_idiomas'] = $this->banner_model->detalles($id);

		/*--- Cargas de vistas ---*/
		$data['banner_imagenes'] = $this->load->view('template/ficha_imagen', $data, true); //Ficha de la sección de imagenes
		$data['ficha_js'] = $this->load->view('template/ficha_imagen_js', $data, true); //Contenido js de la seccion ficha imagenes
		$data['banner_info'] = $this->load->view('banner_info', $data, true); //Información básica de la banner
		$data['idioma_info'] = $this->load->view('idioma_info', $data, true); //Información de los idiomas
		//$data['idioma_form'] = $this->load->view('idioma_banner', $data, true); //Vista para la creación de nuevos idiomas
		//$data['idioma_nuevo'] = $this->load->view('idioma_banner', $data, true); //Vista para la creación de nuevos idiomas
        $data['contenido_principal'] = $this->load->view('ficha_banner', $data, true); //Carga de contenido principal
        $this->load->view('back/template_new', $data);
	}
	
	function editar_idioma($id_banner,$id_detalle_banner='')
	{
		$this->load->model('multimedia/multimedia_model');
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        if ($id_detalle_banner == '')
		{
			redirect(lang('backend_url').'/'.lang('banners_url').'/'.lang('ficha_url').'_'.lang('banner_url').'/'.$id_banner);
		}
		//$data['banner'] = $this->banner_model->read($id_banner);
		$data['banner'] = $this->banner_model->read($id_banner,$id_detalle_banner);
		$data['active'] = 'banners';
		$data['sub'] = 'ficha';
		$data['accion'] = 'editar';
		$data['sub_activo'] = 'EditLangTab';
		$data['title'] = lang('meta.titulo').' - '.lang('banners').' - '.lang('editar_idioma');
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(
																		array(
																			base_url().lang('backend_url') => lang('backend'),
																			'banner' => lang('banners'),
																			lang('backend_url').'/'.lang('banners_url').'/'.lang('ficha_url').'/'.$id_banner => lang('idioma_edt_bnn'),
																			$id_banner => 'Banner '.$data['banner']->id_banner
																		)
																	  );
		
		//AGREGE DE ESTO PARA SOLUCIONAR QUE CUANDO SE EDITABA UN IDIOMA EN SERVICIO, DABA ERROR PHP EN LA FICHA DE IMAGENES
		$data['url_add_p'] = base_url().lang('backend_url').'/'.lang('banners_url').'/'.lang('imagenes_url').'/'.$id_banner.'/'.lang('adicionar_url').'/'.lang('principal');
		//Eliminar Imagen
		$data['url_delete'] = base_url().lang('backend_url').'/'.lang('banners_url').'/'.lang('imagenes_url').'/'.lang('eliminar_url');
		$data['imagen_principal'] = $this->multimedia_model->get_relation($id_banner, 'banner', 0);
		$data['banner_imagenes'] = $this->load->view('template/ficha_imagen', $data, true); //Ficha de la sección de imagenes
		$data['ficha_js'] = $this->load->view('template/ficha_imagen_js', $data, true); //Contenido js de la seccion ficha imagenes
		//FIN - AGREGE DE ESTO PARA SOLUCIONAR QUE CUANDO SE EDITABA UN IDIOMA EN SERVICIO, DABA ERROR PHP EN LA FICHA DE IMAGENES
		
		
		$data['banner_idiomas'] = $this->banner_model->detalles($id_banner, $id_detalle_banner);
		$data['banner'] = $this->load->view('banner_info', $data, true);
		$data['idioma_info'] = $this->load->view('idioma_info', $data, true);
		//$data['idioma_form'] = $this->load->view('idioma_banner', $data, true);
        $data['menu_principal'] = $this->menus->create_mainmenu(lang('banners_url'), 'listado');
		$data['usuario'] = array(
								'nombre' => $this->session->userdata('nombre'),
								'apellidos' => $this->session->userdata('apellidos')
							);
        $data['contenido_principal'] = $this->load->view('ficha_banner', $data, true);
        $this->load->view('back/template_new', $data);
	}

	function guardar_idioma()
	{
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        $data = $_POST;
		//die_pre($data);
		$this->load->model('multimedia/multimedia_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        $this->load->helper(array('form', 'url'));
        $this->form_validation->set_rules('id_idioma', 'Idioma', 'required');
        $this->form_validation->set_rules('nombre', 'Titulo', 'required|min_length[5]');
        $this->form_validation->set_rules('subtitulo', 'Subtitulo', 'min_length[5]');
        $this->form_validation->set_rules('descripcion_breve', 'Descripcion Breve', 'min_length[10]|required');
        $this->form_validation->set_rules('descripcion_ampliada', 'Descripcion Ampliada', 'min_length[50]|required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('titulo_pagina', 'Titulo pagina', 'required|min_length[5]');
        $this->form_validation->set_rules('descripcion_pagina', 'Descripcion pagina', 'required|min_length[10]');
        $this->form_validation->set_rules('keywords', 'Palabras clave', 'required');

        if ($this->form_validation->run($this) == FALSE)
        {
            $data['active'] = 'banner';
            $data['sub'] = 'crear';
            $data['title'] = lang('meta.titulo').' - '.lang('banners').' - '.lang('idioma_edt_bnn');
            if ($data['id_banner'] != '')
			{
                $data['banner'] = modules::run('banner/read', $data['id_banner']);
				$temp_bread = ($this->session->userdata('idioma') == 'es') ? lang('ficha_url').'_'.lang('banner_url').'/'.$data['id_banner']: lang('banner_url').'_'.lang('ficha_url').'/'.$data['id_banner'];
				$data['breadcrumbs'] = $this->menus->create_breadcrumb(
																		array(
																			base_url().lang('backend_url') => lang('backend'),
																			'banner' => lang('banners'),
																			lang('backend_url').'/'.lang('banners_url').'/'.$temp_bread => lang('idioma_edt_bnn'),
																			$data['id_banner'] => (isset($data['nombre']) && $data['nombre'] != '') ? $data['nombre'] : lang('banners_sinnombre')
																		)
																	  );
            }
			else
			{
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
							                							array(
							                								 base_url().lang('backend_url') => lang('backend'),
							                								'banner' => lang('banners'),
							                								'crear' => lang('crear_tit_bnn')
																		)
																	  );
            }


			/*	En esta zona se vuelve a construir la vista de la ficha,
			 * 	es importante cargar todas las vistas necesarias y variables.
			 * 	Para que las imagenes cargen es necesario cargar las vistas y las
			 *  urls de imagen_principal, imagenes_secundarias e inclusive imagenes_terciarias.
			 *
			 * */


			$data['url_add_p'] = base_url().lang('backend_url').'/'.lang('banners_url').'/'.lang('imagenes_url').'/'.$data['id_banner'].'/'.lang('adicionar_url').'/'.lang('principal'); //Imagen Principal
			$data['url_add_s'] = base_url().lang('backend_url').'/'.lang('banners_url').'/'.lang('imagenes_url').'/'.$data['id_banner'].'/'.lang('adicionar_url').'/'.lang('secundarias'); //Imagenes secundarias
			$data['url_add_t'] = base_url().lang('backend_url').'/'.lang('banners_url').'/'.lang('imagenes_url').'/'.$data['id_banner'].'/'.lang('adicionar_url').'/'.lang('terciarias'); //Imagenes terciarias
			$data['url_delete'] = base_url().lang('backend_url').'/'.lang('banners_url').'/'.lang('imagenes_url').'/'.lang('eliminar_url'); //Eliminar Imagen
			$data['imagen_principal'] = $this->multimedia_model->get_relation($data['id_banner'], 'banner', 0);
			$data['accion'] = ($this->input->post('accion') == 'normal') ? 'normal' : 'editar' ;
			$data['sub_activo'] = ($this->input->post('accion') == 'normal') ? 'NewLangTab' : 'EditLangTab' ;
			$data['banner_idiomas'] = $this->banner_model->detalles($data['id_banner']);
			$data['banner_info'] = $this->load->view('banner_info', $data, true);
			$data['idioma_info'] = $this->load->view('idioma_info', $data, true);
			//$data['idioma_form'] = $this->load->view('idioma_banner', $data, true);
			//$data['idioma_nuevo'] = $this->load->view('idioma_banner', $data, true);
			$data['banner_imagenes'] = $this->load->view('template/ficha_imagen', $data, true); //Ficha de la sección de imagenes
			$data['ficha_js'] = $this->load->view('template/ficha_imagen_js', $data, true); //Contenido js de la seccion ficha imagenes
            $data['menu_principal'] = $this->menus->create_mainmenu(lang('banners_url'), 'listado');
			$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
            $data['contenido_principal'] = $this->load->view('ficha_banner', $data, true);
            $this->load->view('back/template_new', $data);
        }
        else
        {
			unset($data['accion']);
            //Convertir saltos de linea en <br />
            //$data['descripcion_ampliada'] = nl2br($data['descripcion_ampliada']);
			//echo $data['descripcion_ampliada'];
			$data['descripcion_ampliada'] = preg_replace(array("#<p>&nbsp;</p>#i", "#(<br ?/>)+$#i"), array("", ""), $data['descripcion_ampliada']);
			//die($data['descripcion_ampliada']);

            $id = $this->banner_model->update_idioma($data);

            modules::run('services/monitor/add', 'detalle_banner', $id, $this->session->userdata('id_usuario'), 'editar_idioma');
			if($this->session->userdata('idioma') == 'es')
			{
				redirect(lang('backend_url').'/'.lang('banners_url').'/'.lang('ficha_url').'_'.lang('banner_url').'/'.$data['id_banner']);
			}
			else
			{
				redirect(lang('backend_url').'/'.lang('banners_url').'/'.lang('banner_url').'_'.lang('ficha_url').'/'.$data['id_banner']);
			}
        }
	}

	function imagen($id, $destacado = 0)
	{
		$this->lang->load('back', 'es');
        if ($id == '')
		{
			redirect(lang('backend_url').'/'.lang('banners_url'));
		}
		if ($_FILES)
		{
			require FCPATH.'server/index.php';
			return;
		}

		$data['banner'] = $this->banner_model->read($id);
		$data['tipo'] = "banner";
		$data['id'] = $id;
		$data['destacado'] = $destacado;
		$data['url'] = base_url().lang('backend_url').'/'.lang('banners_url').'/'.lang('imagenes_url').'/'.lang('procesar_url').'_'.lang('imagenes_url');
		$data['imagen'] = TRUE;
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => 	lang('backend'),
        																lang('backend_url').'/'.lang('banners_url') => lang('banners'),
        																lang('backend_url').'/'.lang('banners_url').'/'.lang('listado_url') => lang('listado'),
        																lang('backend_url').'/'.lang('banners_url').'/'.lang('ficha_url').'_'.lang('banner_url').'/'.$id => lang('ficha_inicio').' Banner '.$data['banner']->id_banner,
        																lang('backend_url').'/'.lang('banners_url').'/'.lang('ficha_url').'_'.lang('banner_url').'/'.$id.'/'.lang('adicionar_url') => lang('subir_imagen')
																	 )
															  );
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('banners_url'), 'listado');
		$data['active'] = 'banners';
		$data['sub'] = 'ficha';
		$data['title'] = lang('meta.titulo').' - '.lang('banners').' - '.lang('subir_imagen');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		$data['file_upload_js'] = $this->load->view('template/file_upload_js', $data, true); //Widget de subida de imagenes
		$data['file_upload_widget'] = $this->load->view('template/file_upload_widget', $data, true); //Widget de subida de imagenes
		$data['contenido_principal'] = $this->load->view('subida_imagen', $data, true);
		$this->load->view('back/template_new', $data);
	}


	function imagen_procesar()
	{
		$this->load->model('multimedia/multimedia_model');
		$imagenes = $this->input->post('valores');
		foreach($imagenes as $imagen){
			$data_img = array(
								'fichero' => $imagen['fichero'],
								'id_tipo' => 1,
								'id_estado' => 1,
								'id_usuario' => $this->session->userdata('id_usuario')
						 );
			$id_imagen = $this->multimedia_model->guardar_imagen($data_img, 1920, 560, 600, 175, 300, 88);
			$data_rel = array(
								'id_banner' => $imagen['id'],
								'id_multimedia' => $id_imagen
						   );
			$this->multimedia_model->crear_rel_multimedia($data_rel, 'banner');
		}
	}

	function imagen_eliminar(){
		$this->load->model('multimedia/multimedia_model');
		$this->multimedia_model->delete_image($this->input->post('id_multimedia'), 'banner', $this->input->post('fichero'));
	}

	function eliminar_idioma($id,$ajax=false)
	{
		 modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        modules::run('services/monitor/add', 'detalle_banner', $id_detalle_banner, $this->session->userdata('id_usuario'), 'eliminar_idioma');
       // $detalle = $this->detalle($id);
		//echo '<pre>'.print_r($detalle, true).'</pre>'; die();
        $ret = $this->banner_model->eliminar_idioma($id_detalle_banner);
        $str = ($ret == true) ? 'true' : 'false';
        if ($ajax)
            echo '[{result:' . $str . '}]';
        else
            redirect('backend/ficha_banner/' . $id_banner);
	}
	
	function delete($id,$ajax=false)
	{
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        $ret = $this->banner_model->delete($id);
        $str = ($ret == true) ? 'true' : 'false';
        if ($ajax)
            echo '[{result:' . $str . '}]';
        else
            return $ret;
	}
	
	
	
	/*
	 * Fin funcciones del admin */
	
	
	/*
	 * Funciones generales, accesibles sin autentificacion */
	
	function read($id,$ajax=false,$detalle_id=''){
		$ret=$this->banner_model->read($id,$detalle_id);
		if ($ajax) echo json_encode($ret);
		else return $ret;
	}
	function get_banner($output='json',$id=''){
		$banner=$this->banner_model->read($id);
		if ($output=='xml'){
			$domDoc = new DOMDocument;
			$rootElt = $domDoc->createElement('banner');
			$rootNode = $domDoc->appendChild($rootElt);
			foreach($banner as $field=>$value){
				$subElt = $domDoc->createElement($field);
				$textNode = $domDoc->createTextNode($value);
				$subElt->appendChild($textNode);
				$rootNode->appendChild($subElt);
			}
			header('Content-Type: text/xml');
			echo $domDoc->saveXML();
		}elseif($output=='json'){
			echo json_encode($banner);
		}
	}
	function get_banner_list($output='json',$f='banner.id_banner',$v=1,$group=false){
		$Banners=$this->banner_model->get_list($f,$v,$group);
		if ($output=='xml'){
			$domDoc = new DOMDocument;
			foreach ($Banners as $banner){
				$rootElt = $domDoc->createElement('banner');
				$rootNode = $domDoc->appendChild($rootElt);
				foreach($banner as $field=>$value){
					$subElt = $domDoc->createElement($field);
					$textNode = $domDoc->createTextNode($value);
					$subElt->appendChild($textNode);
					$rootNode->appendChild($subElt);
				}
			}
			header('Content-Type: text/xml');
			echo $domDoc->saveXML();
		}elseif($output=='json'){
			echo json_encode($Banners);
		}
	}
	function detalle($id,$ajax=false){
		$ret=$this->banner_model->get('detalle_banner',$id);
		if ($ajax) echo json_encode($ret);
		else return $ret;
	}
	function Banners_categoria($id_categoria,$ajax=1){
		if ($ajax==1)
			echo modules::run('services/relations/get_from_categoria',$id_categoria,'banner',$ajax);
		else return modules::run('services/relations/get_from_categoria',$id_categoria,'banner',$ajax);
	}
	
	/* 
	 * Fin funciones libres */
	
	/*funciones de callback
	 * */
	function dia_check($str)
	{
		if ((int)$str > 31)
		{
			$this->form_validation->set_message('dia_check', 'El dia debe ser inferior a 31');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	function mes_check($str)
	{
		if ((int)$str > 12)
		{
			$this->form_validation->set_message('mes_check', 'El mes debe ser inferior a 12');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	function ano_check($str)
	{
		if ((int)$str > date('Y'))
		{
			$this->form_validation->set_message('ano_check', 'El año debe ser inferior a '.date('Y'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	/*
	 * Fin funciones callback
	 * 
	 * */
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
