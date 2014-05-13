<?php

class Tipo_habitacion extends MX_Controller {

    function __construct()
    {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		modules::run('idioma/set_idioma', 'es');
		$this->load->language('back');
        $this->load->model('tipo_habitacion_model');
        $this->load->helper('multimedia');
    }

    /*
     * Funcciones del admin, con control de aceso */
    function index()
    {
        $this->listado();
    }

    function listado($order_field = 'tipo_habitacion.id_tipo_habitacion', $order_dir = 'desc', $start = 0, $ajax = false)
    {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        
        if ($start == 0 && empty($_POST) && $order_field == 'tipo_habitacion.id_tipo_habitacion')
        {
        	$this->session->unset_userdata('terminos_busqueda');
        }
		
        $terminos_busqueda = array();
        $terminos_busqueda = $this->session->userdata('terminos_busqueda');
		
        if (isset($_POST['texto']))
        {
            $terminos_busqueda['texto'] = $_POST['texto'];
        }
        if (isset($_POST['id_tipo_habitacion']))
        {
            $terminos_busqueda['tipo_habitacion.id_tipo_habitacion'] = $_POST['id_tipo_habitacion'];
        }
        if (isset($_POST['id_estado']))
        {
            $terminos_busqueda['tipo_habitacion.id_estado'] = $_POST['id_estado'];
        }
        if (isset($_POST) && !empty($_POST))
        {
            $terminos_busqueda = array_filter($terminos_busqueda);
            $this->session->set_userdata('terminos_busqueda', $terminos_busqueda);
        }
		
        $limit = 5;
        $order_string = '';
        $order_string.= ($order_field == "") 	? '' : $order_field;
        $order_string.= ($order_dir == "") 		? '' : ' ' . $order_dir;

        $od = ($order_dir == 'asc') ? 'desc' : 'asc';
        $data['order_field'] 		= $order_field;
        $data['order_dir'] 			= $order_dir;
        $data['order_by_new'] 		= (($order_field == '') ? 'id_tipo_habitacion' : $order_field) . "/" . $od;
        $data['url'] 				= lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('listado_url');
        $config['base_url'] 		= '/'.lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('listado_url').'/'.$order_field.'/'.$order_dir;
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
        $data['num_tipos_habitacion'] = $this->tipo_habitacion_model->count_all($terminos_busqueda);
		
        $config['total_rows'] 		= $data['num_tipos_habitacion'];
		
        if ($config['total_rows'] == 0) redirect(lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('buscar_url').'/'.'ningun_resultado');
        
        $data['tipos_habitacion'] = $this->tipo_habitacion_model->get_page($start, $limit, $order_field, $order_dir, $terminos_busqueda);
        if ($ajax)
        {
            echo json_encode($data['tipos_habitacion']);
        }
        else
        {
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $data['pagination'] 		= $this->pagination->create_links();
            $data['offset'] 			= $start;
            $data['order_field'] 		= $order_field;
            $data['order_direction'] 	= $order_dir;
            $data['active'] 			= 'tipos_habitacion';
            if (!empty($terminos_busqueda))
            {
            	$data['sub'] = 'buscar';
            }
            else
			{
				$data['sub'] = 'listado';
			}
            $data['title'] = lang('meta.titulo').' - '.lang('tipos_habitacion').' - '.lang('listado');
            
            if (!empty($terminos_busqueda))
            {
                $lbc = reset($terminos_busqueda);
                $lbt = key($terminos_busqueda);

                if ($lbt == 'tipo_habitacion.id_estado')
                {
                    $bcc = modules::run('services/relations/get_from_id', 'estado', $lbc);
                    $lbc = ucwords($bcc->estado);
                }
				
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                															array(
                																	lang('backend_url').'/'.lang('tipos_habitacion_url') => lang('tipos_habitacion'),
                							 										lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('buscar_url') => lang('busqueda'),
                							 										lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('buscar_url').'/'.lang('titulo_url') => $lbc
																				 )
											 						  );
            }
            else
            {
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                															array(
                																	lang('backend_url') => lang('inicio'),
                																	lang('backend_url').'/'.lang('tipos_habitacion_url') => lang('tipos_habitacion'),
                							 										lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('listado_url') => lang('listado')
																				 )
											 						  );
            }
			$data['menu_principal'] = $this->menus->create_mainmenu(lang('tipos_habitacion_url'), 'listado');
			$data['usuario'] = array(
										'nombre' => $this->session->userdata('nombre'),
										'apellidos' => $this->session->userdata('apellidos')
									);
			
			$data['contenido_principal'] = $this->load->view('back/listar/listado_tipo_habitacion', $data, true);
            $this->load->view('back/template_new', $data);
        }
    }

    function buscar($mensaje = '')
	{
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		
		$this->load->helper('misc');
        
        $data['active'] 	= 'tipos_habitacion';
        $data['sub'] 		= 'buscar';
        $data['title'] 		= lang('meta.titulo').' - '.lang('tipos_habitacion').' - '.lang('buscar_tit_tipo_hab');
        
        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => lang('backend'),
        																lang('backend_url').'/'.lang('tipos_habitacion_url') => lang('tipos_habitacion'),
        																lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('buscar_url') => lang('buscar_tit_tipo_hab')));
        $data['mensaje'] 		= $mensaje;
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('tipos_habitacion_url'), 'listado');
		
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
        
        $data['contenido_principal'] = $this->load->view('back/buscar/buscar_tipo_habitacion', $data, true);
        
        $this->load->view('back/template_new', $data);
    }

    function crear()
    {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		$this->load->helper('misc');
        
        $data['active'] 		= 'tipos_habitacion';
        $data['sub'] 			= 'crear';
		$data['title'] 			= lang('meta.titulo').' - '.lang('tipos_habitacion').' - '.lang('crear_tit_tipo_hab');
        $data['breadcrumbs'] 	= $this->menus->create_breadcrumb(
        															array(
        																	lang('backend_url') => lang('backend'),
										    								lang('backend_url').'/'.lang('tipos_habitacion_url') => lang('tipos_habitacion'),
										    							 	lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('crear_url') => lang('crear_tit_tipo_hab')
																		 )
															  );
		
		$data['array_destacado'] 	= destacado_dropdown();
        $data['estados'] 			= modules::run('services/relations/get_all', 'estado', 'true');
        $data['tipos_habitacion'] 	= modules::run('services/relations/get_all', 'tipo_habitacion', 'true');
		
		//Temporada
		//$data['temporadas'] = modules::run('services/relations/get_all', 'temporada');
		//Moneda
		//$data['monedas'] = modules::run('services/relations/get_all', 'moneda');
		
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('tipos_habitacion_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		$data['crear'] = TRUE;
        $data['contenido_principal'] = $this->load->view('back/crear/crear_tipo_habitacion', $data, true);
        $this->load->view('back/template_new', $data);
    }
	
    function fecha_pasada($fecha)
    {
        return mysql_to_unix($fecha) <= time();
    }

    function create($id = '')
    {
        $img_folder = 'assets/front/img/';
		
        if ($id != '')
        {
        	modules::run('services/monitor/add', 'tipo_habitacion', $id, $this->session->userdata('id_usuario'), 'editar');
        }
        else
        {
        	modules::run('services/monitor/add', 'tipo_habitacion', '', $this->session->userdata('id_usuario'), 'crear');
        }
        
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        $this->form_validation->set_rules('id_estado', 'Estado', 'required');
		$this->form_validation->set_rules('personas', 'Personas', 'required|integer');
       
	    $config['upload_path'] 		= './assets/pdf';
        $config['allowed_types'] 	= 'pdf';
        
        $this->load->library('upload', $config);
        if ($this->form_validation->run() == FALSE)
        {
            $data['sub'] 	= 'crear';
            $data['title'] 	= lang('crear_tit_tipo_hab');
            if ($id != '')
            {
                $data['tipo_habitacion'] 	= $this->tipo_habitacion_model->read($id);
                $data['title'] 				= lang('editar_tit_tipo_hab');
            }
            $data['active'] = 'tipos_habitacion';

            if ($id != '')
            {
            	$data['breadcrumbs'] = $this->menus->create_breadcrumb(
            															array(
            																	'tipo_habitacion' 	=> lang('tipos_habitacion'),
            																	'edit'				=> lang('editar_tit_tipo_hab'),
            																	$id					=> $data['tipo_habitacion']->nombre
																			 )
																	  );
            }
            else
            {
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                														array(
                																'tipo_habitacion' 	=> lang('tipos_habitacion'),
                																'crear' 			=> lang('crear_tit_tipo_hab')
																			 )
																	  );
            }
			
            $data['estados'] = modules::run('services/relations/get_all', 'estado', 'true');
            
			//Temporada
			//$data['temporadas'] = modules::run('services/relations/get_all', 'temporada');
			//Moneda
			//$data['monedas'] = modules::run('services/relations/get_all', 'moneda');
             
            $data['contenido_principal'] = $this->load->view('back/crear/crear_tipo_habitacion', $data, true);
            $this->load->view('back/template_new', $data);
        }
        else
        {
			//Usuario
			$form_data['id_usuario'] = $this->session->userdata('id_usuario');
			
			//$costos_index = 0;
			
			//Estado
			if($this->input->post('id_estado'))
			{
				$form_data['id_estado'] = $this->input->post('id_estado');
				//$costos_index++;
			}
			
			//Id tipo habitacion
			if($this->input->post('id_tipo_habitacion'))
			{
				$form_data['id_tipo_habitacion'] = $this->input->post('id_tipo_habitacion');
				//$costos_index++;
			}
			
			//Personas
			if($this->input->post('personas'))
			{
				$form_data['personas'] = $this->input->post('personas');
				//$costos_index++;
			}
			
			//Costos
			//$costos = array_slice($_POST, $costos_index);
			
			//Insertar tipo habitacion
            $id = $this->tipo_habitacion_model->update($form_data);
			
			//Insertar costos de habitacion
			/*
			foreach($costos as $key => $value)
			{
				if(!empty($value) && $id > 0)
				{
					list($id_temporada, $id_moneda) = explode('_', $key);
					
					$data_costos[] = array(	'id_temporada' 			=> $id_temporada,
											'id_moneda'				=> $id_moneda,
											'id_tipo_habitacion'	=> $id,
											'valor'					=> $value);
				}
			}
			$this->tipo_habitacion_model->insert_costos($data_costos);
			*/
			
			if($this->session->userdata('idioma') == 'es')
			{
            	redirect(lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('ficha_url').'_'.lang('tipo_habitacion_url').'/' . $id, 'location');
            }
			else
			{
				redirect(lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('tipo_habitacion_url').'_'.lang('ficha_url').'/' . $id, 'location');
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
        $data['active'] 	= 'tipos_habitacion';
        $data['sub'] 		= 'editar';

        $data['tipo_habitacion'] = $this->tipo_habitacion_model->read($id);

        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
									        					   array(
									        					   			lang('backend_url') => lang('backend'),
									        								lang('backend_url').'/'.lang('tipos_habitacion_url') => lang('tipos_habitacion'),
									        								lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('ficha_url').'_'.lang('tipo_habitacion_url').'/'.$id => lang('editar_tit_tipo_hab'),
									        								'#' => (isset($data['tipo_habitacion']->nombre) && $data['tipo_habitacion']->nombre != '') ? $data['tipo_habitacion']->nombre : lang('tipo_habitacion_sintitulo')
																		)
															  );
		
        $data['title'] 			= lang('meta.titulo').' - '.lang('tipos_habitacion').' - '.lang('editar').' '.$data['tipo_habitacion']->nombre;
        $data['estados'] 		= modules::run('services/relations/get_all', 'estado', 'true');
		
		//Temporada
		//$data['temporadas'] 	= modules::run('services/relations/get_all', 'temporada');
		//Moneda
		//$data['monedas'] 		= modules::run('services/relations/get_all', 'moneda');
		//Costos del tipo de habitacion
		//$data['costos_tipo_habitacion'] = $this->tipo_habitacion_model->get_costos_tipo_habitacion($id);
		
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('tipos_habitacion_url'), 'listado');
		$data['usuario'] 		= array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
        $data['contenido_principal'] = $this->load->view('back/crear/crear_tipo_habitacion', $data, true);
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
			redirect('backend/tipos_habitacion');
		}
        
        $data['active'] 			= 'tipos_habitacion';
        $data['sub'] 				= 'editar';
        $data['tipo_habitacion'] 	= $this->tipo_habitacion_model->read($id);
        $data['breadcrumbs'] 		= $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => lang('backend'),
        																lang('backend_url').'/'.lang('tipos_habitacion_url') => lang('tipos_habitacion'),
        																lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('listado_url') => lang('listado'),
        																lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('ficha_url').'_'.lang('tipo_habitacion_url').'/'.$id => (isset($data['tipo_habitacion']->nombre) ? lang('ficha_inicio').' ' . $data['tipo_habitacion']->nombre : lang('tipo_habitacion_sintitulo'))
																	 )
															  );
		/*--- Zona de url ----*/

		//Imagen Principal
		$data['url_add_p'] = base_url().lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('imagenes_url').'/'.$id.'/'.lang('adicionar_url').'/'.lang('principal');
		//Imagenes secundarias
		$data['url_add_s'] = base_url().lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('imagenes_url').'/'.$id.'/'.lang('adicionar_url').'/'.lang('secundarias');
		//Imagenes terciarias
		$data['url_add_t'] = base_url().lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('imagenes_url').'/'.$id.'/'.lang('adicionar_url').'/'.lang('terciarias');
		//Eliminar Imagen
		$data['url_delete'] = base_url().lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('imagenes_url').'/'.lang('eliminar_url');
		
        $data['title'] = lang('meta.titulo').' - '.lang('tipos_habitacion').' - '.(isset($data['tipo_habitacion']->nombre) ? lang('ficha_inicio').' ' . $data['tipo_habitacion']->nombre : lang('tipo_habitacion_sintitulo'));
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('tipos_habitacion_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
								
		$data['accion'] 					= 'normal';
		$data['sub_activo'] 				= 'Ficha';
		$data['imagen_principal'] 			= $this->multimedia_model->get_relation($id, 'tipo_habitacion', 1);
		$data['imagenes_secundarias'] 		= $this->multimedia_model->get_relation($id, 'tipo_habitacion', 2);
		$data['imagenes_terciarias'] 		= $this->multimedia_model->get_relation($id, 'tipo_habitacion', 3);
        
        //Tipos de habitacion por idioma
        $data['tipo_habitacion_idiomas'] 	= $this->tipo_habitacion_model->detalles($id);
		$ids_detalle = distintos($data['tipo_habitacion_idiomas'], 'id_detalle_tipo_habitacion');
		
		 //Costos por idioma
		$data['costos'] = $this->tipo_habitacion_model->get_costos_tipo_habitacion($ids_detalle);
		
		//Monedas
		$monedas = modules::run('services/relations/get_all', 'moneda');
		foreach($monedas as $opt)
		{
			$opciones[$opt->id_moneda] = ucwords(strtolower($opt->nombre));
		}
		$data['opt_moneda'] = $opciones;
		
		/*--- Cargas de vistas ---*/
		$data['tipo_habitacion_imagenes'] 	= $this->load->view('template/ficha_imagen', $data, true); //Ficha de la sección de imagenes
		$data['ficha_js'] 					= $this->load->view('template/ficha_imagen_js', $data, true); //Contenido js de la seccion ficha imagenes
		$data['tipo_habitacion_info'] 		= $this->load->view('back/ficha/tipo_habitacion_info', $data, true); //Información básica de la servicio
		$data['idioma_info'] 				= $this->load->view('back/ficha/idioma_info', $data, true); //Información de los idiomas
		$data['idioma_form'] 				= $this->load->view('back/ficha/idioma_tipo_habitacion', $data, true); //Vista para la creación de nuevos idiomas
		$data['idioma_nuevo'] 				= $this->load->view('back/ficha/idioma_tipo_habitacion', $data, true); //Vista para la creación de nuevos idiomas
        $data['contenido_principal'] 		= $this->load->view('back/ficha/ficha_tipo_habitacion', $data, true); //Carga de contenido principal
        $this->load->view('back/template_new', $data);
    }

    function editar_idioma($id_tipo_habitacion, $id_detalle_tipo_habitacion = '')
    {
    	$this->load->model('multimedia/multimedia_model');
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
       
		if ($id_detalle_tipo_habitacion == '')
		{
			redirect(lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('ficha_url').'_'.lang('tipo_habitacion_url').'/'.$id_tipo_habitacion);
		}
		
		$data['tipo_habitacion'] 	= $this->tipo_habitacion_model->read($id_tipo_habitacion, $id_detalle_tipo_habitacion);
		$data['active'] 			= 'tipos_habitacion';
		$data['sub'] 				= 'ficha';
		$data['accion'] 			= 'editar';
		$data['sub_activo'] 		= 'EditLangTab';
		$data['title'] 				= lang('meta.titulo').' - '.lang('tipos_habitacion').' - '.lang('editar_idioma');
		
		//AGREGE DE ESTO PARA SOLUCIONAR QUE CUANDO SE EDITABA UN IDIOMA EN SERVICIO, DABA ERROR PHP EN LA FICHA DE IMAGENES
		$data['url_add_p'] 					= base_url().lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('imagenes_url').'/'.$id_tipo_habitacion.'/'.lang('adicionar_url').'/'.lang('principal');
		//Imagenes secundarias
		$data['url_add_s'] 					= base_url().lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('imagenes_url').'/'.$id_tipo_habitacion.'/'.lang('adicionar_url').'/'.lang('secundarias');
		//Imagenes terciarias
		$data['url_add_t'] 					= base_url().lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('imagenes_url').'/'.$id_tipo_habitacion.'/'.lang('adicionar_url').'/'.lang('terciarias');
		//Eliminar Imagen
		$data['url_delete'] 				= base_url().lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('imagenes_url').'/'.lang('eliminar_url');
		$data['imagen_principal'] 			= $this->multimedia_model->get_relation($id_tipo_habitacion, 'tipo_habitacion', 1);
		$data['imagenes_secundarias'] 		= $this->multimedia_model->get_relation($id_tipo_habitacion, 'tipo_habitacion', 2);
		$data['imagenes_terciarias'] 		= $this->multimedia_model->get_relation($id_tipo_habitacion, 'tipo_habitacion', 3);
		$data['tipo_habitacion_imagenes'] 	= $this->load->view('template/ficha_imagen', $data, true); //Ficha de la sección de imagenes
		$data['ficha_js'] 					= $this->load->view('template/ficha_imagen_js', $data, true); //Contenido js de la seccion ficha imagenes
		//FIN - AGREGE DE ESTO PARA SOLUCIONAR QUE CUANDO SE EDITABA UN IDIOMA EN SERVICIO, DABA ERROR PHP EN LA FICHA DE IMAGENES
		
		//Monedas
		$monedas = modules::run('services/relations/get_all', 'moneda');
		foreach($monedas as $opt)
		{
			$opciones[$opt->id_moneda] = ucwords(strtolower($opt->nombre));
		}
		$data['opt_moneda'] = $opciones;
		
		//Costo
		$id_detalle = (isset($id_detalle_tipo_habitacion) && !empty($id_detalle_tipo_habitacion)) ? $id_detalle_tipo_habitacion : $data['tipo_habitacion']->id_detalle_tipo_habitacion;
		$data['costos'] = $this->tipo_habitacion_model->get_costos_tipo_habitacion($id_detalle);
		
		$data['tipo_habitacion_idiomas'] 	= $this->tipo_habitacion_model->detalles($id_tipo_habitacion);
		//$data['servicio_idiomas'] 		= $this->servicio_model->detalles($id_servicio, $id_detalle_servicio);
		$data['tipo_habitacion_info'] 		= $this->load->view('back/ficha/tipo_habitacion_info', $data, true);
		$data['idioma_info'] 				= $this->load->view('back/ficha/idioma_info', $data, true);
		$data['idioma_form'] 				= $this->load->view('back/ficha/idioma_tipo_habitacion', $data, true);
        $data['menu_principal'] 			= $this->menus->create_mainmenu(lang('tipos_habitacion_url'), 'listado');
		$data['usuario'] = array(
								'nombre' => $this->session->userdata('nombre'),
								'apellidos' => $this->session->userdata('apellidos')
							);
        $data['contenido_principal'] = $this->load->view('back/ficha/ficha_tipo_habitacion', $data, true);
        $this->load->view('back/template_new', $data);

    }
	function validar_url($url)
	{
		$this->form_validation->set_message('validar_url', 'La url indicada ya existe.');
		$id_tipo_habitacion = $this->tipo_habitacion_model->get_id_tipo_habitacion_url($url);
		
		if(!empty($id_tipo_habitacion) && is_numeric($id_tipo_habitacion) && $id_tipo_habitacion > 0 && $this->input->post('accion') != 'editar')
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
		
        $this->form_validation->set_rules('id_idioma', 			'Idioma', 				'required');
        $this->form_validation->set_rules('nombre', 			'Titulo', 				'required|min_length[5]');
        $this->form_validation->set_rules('subtitulo', 			'Subtitulo', 			'min_length[5]');
        $this->form_validation->set_rules('descripcion_breve', 	'Descripcion Breve', 	'min_length[10]|required');
        $this->form_validation->set_rules('url', 				'URL', 					'required|callback_validar_url');
        $this->form_validation->set_rules('titulo_pagina', 		'Titulo pagina', 		'required|min_length[5]');
        $this->form_validation->set_rules('descripcion_pagina', 'Descripcion pagina', 	'required|min_length[10]');
        $this->form_validation->set_rules('keywords', 			'Palabras clave', 		'required');
		
		$this->form_validation->set_rules('costo_alta', 		lang('costo_alta'), 			'required|numeric');
		$this->form_validation->set_rules('costo_baja', 		lang('costo_baja'), 			'required|numeric');
		$this->form_validation->set_rules('id_moneda', 			lang('tipo_habitacion_moneda'), 'required|numeric');
		
        if ($this->form_validation->run($this) == FALSE)
        {
            $data['active'] 	= 'tipos_habitacion';
            $data['sub'] 		= 'crear';
            $data['title'] 		= lang('meta.titulo').' - '.lang('tipos_habitacion').' - '.lang('idioma_edt_tipo_hab');
			
			//Monedas
			$monedas = modules::run('services/relations/get_all', 'moneda');
			foreach($monedas as $opt)
			{
				$opciones[$opt->id_moneda] = ucwords(strtolower($opt->nombre));
			}
			$data['opt_moneda'] = $opciones;
			
			$temp = (isset($data['nombre']) && $data['nombre'] != '') ? $data['nombre'] : lang('tipo_habitacion_sintitulo');
            if ($data['id_tipo_habitacion'] != '')
			{
                $data['tipo_habitacion'] = modules::run('tipo_habitacion/read', $data['id_tipo_habitacion']);
				$data['breadcrumbs'] = $this->menus->create_breadcrumb(
																		array(
																			lang('backend_url') => lang('backend'),
																			lang('backend_url').'/'.lang('tipos_habitacion_url') => lang('tipos_habitacion'),
																			lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('editar_url').'_'.lang('tipo_habitacion_url').'/'.$data['id_tipo_habitacion'] => lang('idioma_edt_tipo_hab'),
																			lang('backend_url').'/'.lang('tipos_habitacion').'/'.lang('editar_url').'_'.lang('tipo_habitacion_url').'/'.$data['id_tipo_habitacion'] => $temp
																		)
																	  );
            }
			else
			{
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
							                							array(
							                								lang('backend_url') => lang('backend'),
																			lang('backend_url').'/'.lang('tipos_habitacion_url') => lang('tipos_habitacion'),
							                								lang('backend_url').lang('tipos_habitacion_url').'/'.lang('crear_url') => lang('crear_tit_tipo_hab')
																		)
																	  );
            }
			
			/*	En esta zona se vuelve a construir la vista de la ficha,
			 * 	es importante cargar todas las vistas necesarias y variables.
			 * 	Para que las imagenes cargen es necesario cargar las vistas y las
			 *  urls de imagen_principal, imagenes_secundarias e inclusive imagenes_terciarias.
			 *
			 * */

			$data['url_add_p'] = base_url().lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('imagenes_url').'/'.$data['id_tipo_habitacion'].'/'.lang('adicionar_url').'/'.lang('principal'); //Imagen Principal
			$data['url_add_s'] = base_url().lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('imagenes_url').'/'.$data['id_tipo_habitacion'].'/'.lang('adicionar_url').'/'.lang('secundarias'); //Imagenes secundarias
			$data['url_add_t'] = base_url().lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('imagenes_url').'/'.$data['id_tipo_habitacion'].'/'.lang('adicionar_url').'/'.lang('terciarias'); //Imagenes terciarias
			$data['url_delete'] = base_url().lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('imagenes_url').'/'.lang('eliminar_url'); //Eliminar Imagen

			$data['imagen_principal'] 		= $this->multimedia_model->get_relation($data['id_tipo_habitacion'], 'tipo_habitacion', 1);
			$data['imagenes_secundarias'] 	= $this->multimedia_model->get_relation($data['id_tipo_habitacion'], 'tipo_habitacion', 2);
			$data['imagenes_terciarias'] 	= $this->multimedia_model->get_relation($data['id_tipo_habitacion'], 'tipo_habitacion', 3);
			
			$data['accion'] 					= ($this->input->post('accion') == 'normal') ? 'normal' : 'editar' ;
			$data['sub_activo'] 				= ($this->input->post('accion') == 'normal') ? 'NewLangTab' : 'EditLangTab' ;
			$data['tipo_habitacion_idiomas'] 	= $this->tipo_habitacion_model->detalles($data['id_tipo_habitacion']);
			$data['tipo_habitacion_info'] 		= $this->load->view('back/ficha/tipo_habitacion_info', $data, true);
			$data['idioma_info'] 				= $this->load->view('back/ficha/idioma_info', $data, true);
			$data['idioma_nuevo'] 				= $this->load->view('back/ficha/idioma_tipo_habitacion', $data, true); //Vista para la creación de nuevos idiomas
			$data['idioma_form'] 				= $this->load->view('back/ficha/idioma_tipo_habitacion', $data, true); //Vista para la creación de nuevos idiomas
			$data['tipo_habitacion_imagenes'] 	= $this->load->view('template/ficha_imagen', $data, true); 				//Ficha de la sección de imagenes
			$data['ficha_js'] 					= $this->load->view('template/ficha_imagen_js', $data, true); 			//Contenido js de la seccion ficha imagenes
            
            $data['menu_principal'] 			= $this->menus->create_mainmenu(lang('tipos_habitacion_url'), 'listado');
			
			$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
            $data['contenido_principal'] = $this->load->view('back/ficha/ficha_tipo_habitacion', $data, true);
            $this->load->view('back/template_new', $data);
        }
        else
        {
			unset($data['accion']);
            //Convertir saltos de linea en <br />
            //$data['descripcion_ampliada'] = nl2br($data['descripcion_ampliada']);
			
			//Formatear descripcion ampliada
			$data['descripcion_ampliada'] = preg_replace(array("#<p>&nbsp;</p>#i", "#(<br ?/>)+$#i"), array("", ""), $data['descripcion_ampliada']);
			
			//Extraer costos
			$datos_costos = array(	'costo_alta'	=> $data['costo_alta'],
									'costo_baja'	=> $data['costo_baja'],
									'id_moneda'		=> $data['id_moneda']);
			unset($data['costo_alta']); unset($data['costo_baja']); unset($data['id_moneda']);
			
			//Guardar datos del detalle
            $id = $this->tipo_habitacion_model->update_idioma($data);
			
			//Guardar costos
			$datos_costos['id_detalle_tipo_habitacion'] = $id;
			$this->tipo_habitacion_model->guardar_costos($datos_costos);
			
            modules::run('services/monitor/add', 'detalle_tipo_habitacion', $id, $this->session->userdata('id_usuario'), 'editar_idioma');
			if($this->session->userdata('idioma') == 'es')
			{
				redirect(lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('ficha_url').'_'.lang('tipo_habitacion_url').'/'.$data['id_tipo_habitacion']);
			}
			else
			{
				redirect(lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('tipo_habitacion_url').'_'.lang('ficha_url').'/'.$data['id_tipo_habitacion']);
			}
        }
    }
	
	function imagen($id, $destacado = 1)
	{
		$this->lang->load('back', 'es');
        if ($id == '')
		{
			redirect('backend/tipos_habitacion');
		}
		if ($_FILES)
		{
			require FCPATH.'server/index.php';
			return;
		}

		$data['tipo_habitacion']= $this->tipo_habitacion_model->read($id);
		$data['tipo'] 			= "tipo_habitacion";
		$data['id'] 			= $id;
		$data['destacado'] 		= $destacado;
		$data['url'] 			= base_url().lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('imagenes_url').'/'.lang('procesar_url').'_'.lang('imagenes_url');
		$data['imagen'] = TRUE;
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => 	lang('backend'),
        																lang('backend_url').'/'.lang('tipos_habitacion_url') => lang('tipos_habitacion'),
        																lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('listado_url') => lang('listado'),
        																lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('ficha_url').'_'.lang('tipo_habitacion_url').'/'.$id => (isset($data['tipo_habitacion']->nombre) ? lang('ficha_inicio').' ' . $data['tipo_habitacion']->nombre : lang('tipos_habitacion_sintitulo')),
        																lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('ficha_url').'_'.lang('tipo_habitacion_url').'/'.$id.'/'.lang('adicionar_url') => lang('subir_imagen')
																	 )
															  );
		
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('tipos_habitacion_url'), 'listado');
		$data['active'] 		= 'tipos_habitacion';
		$data['sub'] 			= 'ficha';
		$data['title'] 			= lang('meta.titulo').' - '.lang('tipos_habitacion').' - '.lang('subir_imagen');
		
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
								'id_tipo_habitacion' => $imagen['id'],
								'id_multimedia' => $id_imagen
						   );
			$this->multimedia_model->crear_rel_multimedia($data_rel, 'tipo_habitacion');
		}
	}

	function imagen_eliminar(){
		$this->load->model('multimedia/multimedia_model');
		$this->multimedia_model->delete_image($this->input->post('id_multimedia'), 'tipo_habitacion', $this->input->post('fichero'));
	}
	
    function eliminar_idioma($id_tipo_habitacion, $id_detalle_tipo_habitacion = '', $ajax = false)
    {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        modules::run('services/monitor/add', 'detalle_tipo_habitacion', $id_detalle_tipo_habitacion, $this->session->userdata('id_usuario'), 'eliminar_idioma');
        //$detalle = $this->detalle($id);
        $ret = $this->tipo_habitacion_model->eliminar_idioma($id_detalle_tipo_habitacion);
        $str = ($ret == true) ? 'true' : 'false';
        if ($ajax)
            echo '[{result:' . $str . '}]';
        else
            redirect('backend/tipos_habitacion/ficha_tipo_habitacion/' . $id_tipo_habitacion);
    }
	
	function detalle($id, $ajax = false)
    {
        //$ret = $this->noticia_model->get('detalle_noticia', $id);
        $ret = $this->tipo_habitacion_model->get('detalle_tipo_habitacion',$id);
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
        $ret = $this->tipo_habitacion_model->delete($id);
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
        $ret = $this->tipo_habitacion_model->read($id, $detalle_id);
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
