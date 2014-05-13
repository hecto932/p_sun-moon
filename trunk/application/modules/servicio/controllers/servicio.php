<?php

class Servicio extends MX_Controller {

    function __construct() {

		parent::__construct();
		$this->load->helper(array('form', 'url'));
		modules::run('idioma/set_idioma', 'es');
		$this->load->language('back');
        $this->load->model('servicio_model');
        $this->load->helper('multimedia');

    }

    /*
     * Funcciones del admin, con control de aceso */

    function index() {

        $this->listado();
    }

    function listado($order_field = 'servicio.id_servicio', $order_dir = 'desc', $start = 0, $ajax = false) {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        if ($start == 0 && empty($_POST) && $order_field == 'servicio.id_servicio')
        {
        	$this->session->unset_userdata('terminos_busqueda');
        }
        $terminos_busqueda = array();
        $terminos_busqueda = $this->session->userdata('terminos_busqueda');
        if (isset($_POST['texto'])) {
            $terminos_busqueda['texto'] = $_POST['texto'];
        }
        if (isset($_POST['id_servicio'])) {
            $terminos_busqueda['servicio.id_servicio'] = $_POST['id_servicio'];
        }
		if (isset($_POST['id_tipo_servicio'])) {
            $terminos_busqueda['servicio.id_tipo_servicio'] = $_POST['id_tipo_servicio'];
        }
        if (isset($_POST['id_estado'])) {
            $terminos_busqueda['servicio.id_estado'] = $_POST['id_estado'];
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
        $data['order_by_new'] = (($order_field == '') ? 'id_servicio' : $order_field) . "/" . $od;
        $data['url'] = lang('backend_url').'/'.lang('servicios_url').'/'.lang('listado_url');
        $config['base_url'] = '/'.lang('backend_url').'/'.lang('servicios_url').'/'.lang('listado_url').'/'.$order_field.'/'.$order_dir;
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
        $data['num_servicios'] = $this->servicio_model->count_all($terminos_busqueda);
        $config['total_rows'] = $data['num_servicios'];
        if ($config['total_rows'] == 0)
            redirect(lang('backend_url').'/'.lang('servicios_url').'/'.lang('buscar_url').'/'.'ningun_resultado');
        $data['servicios'] = $this->servicio_model->get_page($start, $limit, $order_field, $order_dir, $terminos_busqueda);
        if ($ajax) {
            echo json_encode($data['servicios']);
        }
        else
        {
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['offset'] = $start;
            $data['order_field'] = $order_field;
            $data['order_direction'] = $order_dir;
            $data['active'] = 'servicios';
            if (!empty($terminos_busqueda))
            {
            	$data['sub'] = 'buscar';
            }
            else
			{
				$data['sub'] = 'listado';
			}
            $data['title'] = lang('meta.titulo').' - '.lang('servicios').' - '.lang('listado');
            if (!empty($terminos_busqueda))
            {
                $lbc = reset($terminos_busqueda);
                $lbt = key($terminos_busqueda);

                if ($lbt == 'servicio.id_estado')
                {
                    $bcc = modules::run('services/relations/get_from_id', 'estado', $lbc);
                    $lbc = ucwords($bcc->estado);
                }
                if ($lbt == 'servicio.id_producto')
                {
                    $bcc = modules::run('services/relations/get_from_id', 'producto', $lbc);
                    $lbc = ucwords($bcc->nombre);
                }
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                															array(
                																	lang('backend_url').'/'.lang('servicios_url') => lang('servicios'),
                							 										lang('backend_url').'/'.lang('servicios_url').'/'.lang('buscar_url') => lang('busqueda'),
                							 										lang('backend_url').'/'.lang('servicios_url').'/'.lang('buscar_url').'/'.lang('titulo_url') => $lbc
																				 )
											 						  );
            }
            else
            {
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                															array(
                																	lang('backend_url') => lang('inicio'),
                																	lang('backend_url').'/'.lang('servicios_url') => lang('servicios'),
                							 										lang('backend_url').'/'.lang('servicios_url').'/'.lang('listado_url') => lang('listado')
																				 )
											 						  );
            }
			$data['menu_principal'] = $this->menus->create_mainmenu(lang('servicios_url'), 'listado');
			$data['usuario'] = array(
										'nombre' => $this->session->userdata('nombre'),
										'apellidos' => $this->session->userdata('apellidos')
									);
			$data['contenido_principal'] = $this->load->view('back/listar/listado_servicio', $data, true);
            $this->load->view('back/template_new', $data);
        }
    }

    function buscar($mensaje = '')
	{
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		$this->load->helper('misc');
        $data['active'] = 'servicios';
        $data['sub'] = 'buscar';
        $data['title'] = lang('meta.titulo').' - '.lang('servicios').' - '.lang('buscar_tit_serv');
        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => lang('backend'),
        																lang('backend_url').'/'.lang('servicios_url') => lang('servicios'),
        																lang('backend_url').'/'.lang('servicios_url').'/'.lang('buscar_url') => lang('buscar_tit_serv')));
        $data['mensaje'] = $mensaje;
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('servicios_url'), 'listado');
		$data['tipo_servicio'] = servicio_dropdown($this->servicio_model->get_tipo_servicio(), 'es');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
        $data['contenido_principal'] = $this->load->view('back/buscar/buscar_servicio', $data, true);
        $this->load->view('back/template_new', $data);
    }

    function crear()
    {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		$this->load->helper('misc');
        $data['active'] = 'servicios';
        $data['sub'] = 'crear';
		$data['title'] = lang('meta.titulo').' - '.lang('servicios').' - '.lang('crear_tit_serv');
        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
        															array(
        																	lang('backend_url') => lang('backend'),
										    								lang('backend_url').'/'.lang('servicios_url') => lang('servicios'),
										    							 	lang('backend_url').'/'.lang('servicios_url').'/'.lang('crear_url') => lang('crear_tit_serv')
																		 )
															  );
		$data['array_destacado'] = destacado_dropdown();
        $data['estados'] = modules::run('services/relations/get_all', 'estado', 'true');
        $data['servicios'] = modules::run('services/relations/get_all', 'servicio', 'true');
		$data['tipo_servicio'] = servicio_dropdown($this->servicio_model->get_tipo_servicio(), 'es');
		
		/*
		//Tipo habitacion
		$tipos_habitacion = modules::run('services/relations/get_all', 'tipo_habitacion');
		$temp = array();
		foreach($tipos_habitacion as $tipo)
		{
			$temp[$tipo->id_tipo_habitacion] = ucwords(strtolower($tipo->nombre));
		}
		$data['tipos_habitacion'] = $temp;
		
		//Estado habitacion
		$estados_habitacion = modules::run('services/relations/get_all', 'estado_habitacion');
		$temp = array();
		foreach($estados_habitacion as $estado)
		{
			$temp[$estado->id_estado_habitacion] = ucwords(strtolower($estado->descripcion));
		}
		$data['estados_habitacion'] = $temp;
		*/
		
		//Temporada
		//$data['temporadas'] = modules::run('services/relations/get_all', 'temporada');
		
		//Moneda
		//$data['monedas'] = modules::run('services/relations/get_all', 'moneda');
		
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('servicios_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		$data['crear'] = TRUE;
        $data['contenido_principal'] = $this->load->view('back/crear/crear_servicio', $data, true);
        $this->load->view('back/template_new', $data);
    }


    function fecha_pasada($fecha) {
        return mysql_to_unix($fecha) <= time();
    }

    function create($id = '') {
        $img_folder = 'assets/front/img/';

        if ($id != '')
        {
        	modules::run('services/monitor/add', 'servicio', $id, $this->session->userdata('id_usuario'), 'editar');
        }
        else
        {
        	modules::run('services/monitor/add', 'servicio', '', $this->session->userdata('id_usuario'), 'crear');
        }
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        $this->form_validation->set_rules('id_estado', 'Estado', 'required');
        $config['upload_path'] = './assets/pdf';
        $config['allowed_types'] = 'pdf';
        $this->load->library('upload', $config);
        if ($this->form_validation->run() == FALSE)
        {
            $data['sub'] = 'crear';
            $data['title'] = lang('crear_tit_serv');
            if ($id != '')
            {
                $data['servicio'] = $this->servicio_model->read($id);
                $data['title'] = lang('editar_tit_serv');
            }
            $data['active'] = 'servicios';

            if ($id != '')
            {
            	$data['breadcrumbs'] = $this->menus->create_breadcrumb(
            															array(
            																	'servicio' => lang('servicios'),
            																	'edit'	=>	lang('editar_tit_serv'),
            																	$id	=>	$data['servicio']->nombre
																			 )
																	  );
            }
            else
            {
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                														array(
                																'servicio' => lang('servicios'),
                																'crear' => lang('crear_tit_serv')
																			 )
																	  );
            }
			$data['tipo_servicio'] = servicio_dropdown($this->servicio_model->get_tipo_servicio(), 'es');
            $data['estados'] = modules::run('services/relations/get_all', 'estado', 'true');
            
			/*
            //Tipo habitacion
			$tipos_habitacion = modules::run('services/relations/get_all', 'tipo_habitacion');
			$temp = array();
			foreach($tipos_habitacion as $tipo)
			{
				$temp[$tipo->id_tipo_habitacion] = ucwords(strtolower($tipo->nombre));
			}
			$data['tipos_habitacion'] = $temp;
			
			//Estado habitacion
			$estados_habitacion = modules::run('services/relations/get_all', 'estado_habitacion');
			$temp = array();
			foreach($estados_habitacion as $estado)
			{
				$temp[$estado->id_estado_habitacion] = ucwords(strtolower($estado->descripcion));
			}
			$data['estados_habitacion'] = $temp;
            */
             
            $data['contenido_principal'] = $this->load->view('crear_servicio', $data, true);
            $this->load->view('back/template_new', $data);
        }


         else
         {
			//POST
            $form_data = $_POST;
			
			/*
			//Si el servicio es de tipo habitacion
			$data_habitacion = array();
			if(array_key_exists('id_tipo_habitacion', $form_data))
			{
				$data_habitacion = array(	'id_tipo_habitacion' 	=> $form_data['id_tipo_habitacion'],
											'id_estado_habitacion'	=> $form_data['id_estado_habitacion']);
				
				unset($form_data['id_tipo_habitacion']);
				unset($form_data['id_estado_habitacion']);
			}
			*/
			
			//$form_data['descripcion_ampliada'] = preg_replace("#(<p>&nbsp;</p><br?/>)+#i", '', $form_data['descripcion_ampliada']);

			//Insertar servicio
            $id = $this->servicio_model->update($form_data);
			
			/*
			//Insertar habitacion
			if(!empty($data_habitacion))
			{
				$data_habitacion['id_servicio'] = $id;
				
				//Guardar habitacion
				$this->servicio_model->insert_habitacion($data_habitacion);
			}
			*/
			
			if($this->session->userdata('idioma') == 'es')
			{
            	redirect(lang('backend_url').'/'.lang('servicios_url').'/'.lang('ficha_url').'_'.lang('servicio_url').'/' . $id, 'location');
            }
			else
			{
				redirect(lang('backend_url').'/'.lang('servicios_url').'/'.lang('servicio_url').'_'.lang('ficha_url').'/' . $id, 'location');
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
        $data['active'] = 'servicios';
        $data['sub'] = 'editar';

        $data['servicio'] = $this->servicio_model->read($id);

        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
									        					   array(
									        					   			lang('backend_url') => lang('backend'),
									        								lang('backend_url').'/'.lang('servicios_url') => lang('servicios'),
									        								lang('backend_url').'/'.lang('servicios_url').'/'.lang('ficha_url').'_'.lang('servicio_url').'/'.$id => lang('editar_tit_serv'),
									        								'#' => (isset($data['servicio']->nombre) && $data['servicio']->nombre != '') ? $data['servicio']->nombre : lang('sevicios_sintitulo')
																		)
															  );
        $data['title'] = lang('meta.titulo').' - '.lang('servicios').' - '.lang('editar').' '.$data['servicio']->nombre;
        $data['estados'] = modules::run('services/relations/get_all', 'estado', 'true');
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('servicios_url'), 'listado');
		$data['tipo_servicio'] = servicio_dropdown($this->servicio_model->get_tipo_servicio(), 'es');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
        $data['contenido_principal'] = $this->load->view('back/crear/crear_servicio', $data, true);
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
			redirect('backend/servicios');
		}
        $data['active'] = 'servicios';
        $data['sub'] = 'editar';
        $data['servicio'] = $this->servicio_model->read($id);
        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => lang('backend'),
        																lang('backend_url').'/'.lang('servicios_url') => lang('servicios'),
        																lang('backend_url').'/'.lang('servicios_url').'/'.lang('listado_url') => lang('listado'),
        																lang('backend_url').'/'.lang('servicios_url').'/'.lang('ficha_url').'_'.lang('servicio_url').'/'.$id => (isset($data['servicio']->nombre) ? lang('ficha_inicio').' ' . $data['servicio']->nombre : lang('servicios_sintitulo'))
																	 )
															  );
		/*--- Zona de url ----*/

		//Imagen Principal
		$data['url_add_p'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.$id.'/'.lang('adicionar_url').'/'.lang('principal');
		//Imagenes secundarias
		$data['url_add_s'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.$id.'/'.lang('adicionar_url').'/'.lang('secundarias');
		//Imagenes terciarias
		$data['url_add_t'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.$id.'/'.lang('adicionar_url').'/'.lang('terciarias');
		//Eliminar Imagen
		$data['url_delete'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.lang('eliminar_url');


        $data['title'] = lang('meta.titulo').' - '.lang('servicios').' - '.(isset($data['servicio']->nombre) ? lang('ficha_inicio').' ' . $data['servicio']->nombre : lang('servicios_sintitulo'));
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('servicios_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		$data['accion'] = 'normal';
		$data['sub_activo'] = 'Ficha';
		$data['imagen_principal'] = $this->multimedia_model->get_relation($id, 'servicio', 1);
		$data['imagenes_secundarias'] = $this->multimedia_model->get_relation($id, 'servicio', 2);
		$data['imagenes_terciarias'] = $this->multimedia_model->get_relation($id, 'servicio', 3);
        $data['servicio_idiomas'] = $this->servicio_model->detalles($id);
		
		/*--- Cargas de vistas ---*/
		$data['servicio_imagenes'] = $this->load->view('template/ficha_imagen', $data, true); //Ficha de la sección de imagenes
		$data['ficha_js'] = $this->load->view('template/ficha_imagen_js', $data, true); //Contenido js de la seccion ficha imagenes
		$data['servicio_info'] = $this->load->view('back/ficha/servicio_info', $data, true); //Información básica de la servicio
		$data['idioma_info'] = $this->load->view('back/ficha/idioma_info', $data, true); //Información de los idiomas
		$data['idioma_form'] = $this->load->view('back/ficha/idioma_servicio', $data, true); //Vista para la creación de nuevos idiomas
		$data['idioma_nuevo'] = $this->load->view('back/ficha/idioma_servicio', $data, true); //Vista para la creación de nuevos idiomas
        $data['contenido_principal'] = $this->load->view('back/ficha/ficha_servicio', $data, true); //Carga de contenido principal
        $this->load->view('back/template_new', $data);
    }

    function editar_idioma($id_servicio, $id_detalle_servicio = '')
    {
    	$this->load->model('multimedia/multimedia_model');
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        if ($id_detalle_servicio == '')
		{
			redirect(lang('backend_url').'/'.lang('servicios_url').'/'.lang('ficha_url').'_'.lang('servicio_url').'/'.$id_servicio);
		}
		$data['servicio'] = $this->servicio_model->read($id_servicio, $id_detalle_servicio);
		$data['active'] = 'servicios';
		$data['sub'] = 'ficha';
		$data['accion'] = 'editar';
		$data['sub_activo'] = 'EditLangTab';
		$data['title'] = lang('meta.titulo').' - '.lang('servicios').' - '.lang('editar_idioma');
		
		//AGREGE DE ESTO PARA SOLUCIONAR QUE CUANDO SE EDITABA UN IDIOMA EN SERVICIO, DABA ERROR PHP EN LA FICHA DE IMAGENES
		$data['url_add_p'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.$id_servicio.'/'.lang('adicionar_url').'/'.lang('principal');
		//Imagenes secundarias
		$data['url_add_s'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.$id_servicio.'/'.lang('adicionar_url').'/'.lang('secundarias');
		//Imagenes terciarias
		$data['url_add_t'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.$id_servicio.'/'.lang('adicionar_url').'/'.lang('terciarias');
		//Eliminar Imagen
		$data['url_delete'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.lang('eliminar_url');
		$data['imagen_principal'] = $this->multimedia_model->get_relation($id_servicio, 'servicio', 1);
		$data['imagenes_secundarias'] = $this->multimedia_model->get_relation($id_servicio, 'servicio', 2);
		$data['imagenes_terciarias'] = $this->multimedia_model->get_relation($id_servicio, 'servicio', 3);
		$data['servicio_imagenes'] = $this->load->view('template/ficha_imagen', $data, true); //Ficha de la sección de imagenes
		$data['ficha_js'] = $this->load->view('template/ficha_imagen_js', $data, true); //Contenido js de la seccion ficha imagenes
		//FIN - AGREGE DE ESTO PARA SOLUCIONAR QUE CUANDO SE EDITABA UN IDIOMA EN SERVICIO, DABA ERROR PHP EN LA FICHA DE IMAGENES
		
		$data['servicio_idiomas'] = $this->servicio_model->detalles($id_servicio);
		//$data['servicio_idiomas'] = $this->servicio_model->detalles($id_servicio, $id_detalle_servicio);
		$data['servicio_info'] = $this->load->view('back/ficha/servicio_info', $data, true);
		$data['idioma_info'] = $this->load->view('back/ficha/idioma_info', $data, true);
		$data['idioma_form'] = $this->load->view('back/ficha/idioma_servicio', $data, true);
        $data['menu_principal'] = $this->menus->create_mainmenu(lang('servicios_url'), 'listado');
		$data['usuario'] = array(
								'nombre' => $this->session->userdata('nombre'),
								'apellidos' => $this->session->userdata('apellidos')
							);
        $data['contenido_principal'] = $this->load->view('back/ficha/ficha_servicio', $data, true);
        $this->load->view('back/template_new', $data);

    }
	function validar_url($url)
	{
		$this->form_validation->set_message('validar_url', 'La url indicada ya existe.');
		
		$id_servicio = $this->servicio_model->get_id_servicio_url($url);
		
		if(!empty($id_servicio) && is_numeric($id_servicio) && $id_servicio > 0 && $this->input->post('accion') != 'editar')
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
            $data['active'] = 'servicios';
            $data['sub'] = 'crear';
            $data['title'] = lang('meta.titulo').' - '.lang('servicios').' - '.lang('idioma_edt_serv');
			$temp = (isset($data['nombre']) && $data['nombre'] != '') ? $data['nombre'] : lang('servicios_sintitulo');
            if ($data['id_servicio'] != '')
			{
                $data['servicio'] = modules::run('servicio/read', $data['id_servicio']);
				$data['breadcrumbs'] = $this->menus->create_breadcrumb(
																		array(
																			lang('backend_url') => lang('backend'),
																			lang('backend_url').'/'.lang('servicios_url') => lang('servicios'),
																			lang('backend_url').'/'.lang('servicios_url').'/'.lang('editar_url').'_'.lang('servicio_url').'/'.$data['id_servicio'] => lang('idioma_edt_serv'),
																			lang('backend_url').'/'.lang('servicios_url').'/'.lang('editar_url').'_'.lang('servicio_url').'/'.$data['id_servicio'] => $temp
																		)
																	  );
            }
			else
			{
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
							                							array(
							                								lang('backend_url') => lang('backend'),
																			lang('backend_url').'/'.lang('servicios_url') => lang('servicios'),
							                								lang('backend_url').lang('servicios_url').'/'.lang('crear_url') => lang('crear_tit_serv')
																		)
																	  );
            }


			/*	En esta zona se vuelve a construir la vista de la ficha,
			 * 	es importante cargar todas las vistas necesarias y variables.
			 * 	Para que las imagenes cargen es necesario cargar las vistas y las
			 *  urls de imagen_principal, imagenes_secundarias e inclusive imagenes_terciarias.
			 *
			 * */

			$data['url_add_p'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.$data['id_servicio'].'/'.lang('adicionar_url').'/'.lang('principal'); //Imagen Principal
			$data['url_add_s'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.$data['id_servicio'].'/'.lang('adicionar_url').'/'.lang('secundarias'); //Imagenes secundarias
			$data['url_add_t'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.$data['id_servicio'].'/'.lang('adicionar_url').'/'.lang('terciarias'); //Imagenes terciarias
			$data['url_delete'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.lang('eliminar_url'); //Eliminar Imagen

			$data['imagen_principal'] = $this->multimedia_model->get_relation($data['id_servicio'], 'servicio', 1);
			$data['imagenes_secundarias'] = $this->multimedia_model->get_relation($data['id_servicio'], 'servicio', 2);
			$data['imagenes_terciarias'] = $this->multimedia_model->get_relation($data['id_servicio'], 'servicio', 3);
			$data['accion'] = ($this->input->post('accion') == 'normal') ? 'normal' : 'editar' ;
			$data['sub_activo'] = ($this->input->post('accion') == 'normal') ? 'NewLangTab' : 'EditLangTab' ;
			$data['servicio_idiomas'] = $this->servicio_model->detalles($data['id_servicio']);
			$data['servicio_info'] = $this->load->view('back/ficha/servicio_info', $data, true);
			$data['idioma_info'] = $this->load->view('back/ficha/idioma_info', $data, true);
			$data['idioma_nuevo'] = $this->load->view('back/ficha/idioma_servicio', $data, true); //Vista para la creación de nuevos idiomas
			$data['idioma_form'] = $this->load->view('back/ficha/idioma_servicio', $data, true); //Vista para la creación de nuevos idiomas
			$data['servicio_imagenes'] = $this->load->view('template/ficha_imagen', $data, true); //Ficha de la sección de imagenes
			$data['ficha_js'] = $this->load->view('template/ficha_imagen_js', $data, true); //Contenido js de la seccion ficha imagenes
            $data['menu_principal'] = $this->menus->create_mainmenu(lang('servicios_url'), 'listado');
			$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
            $data['contenido_principal'] = $this->load->view('back/ficha/ficha_servicio', $data, true);
            $this->load->view('back/template_new', $data);
        }
        else
        {
			unset($data['accion']);
            //Convertir saltos de linea en <br />
            //$data['descripcion_ampliada'] = nl2br($data['descripcion_ampliada']);

			$data['descripcion_ampliada'] = preg_replace(array("#<p>&nbsp;</p>#i", "#(<br ?/>)+$#i"), array("", ""), $data['descripcion_ampliada']);

            $id = $this->servicio_model->update_idioma($data);

            modules::run('services/monitor/add', 'detalle_servicio', $id, $this->session->userdata('id_usuario'), 'editar_idioma');
			if($this->session->userdata('idioma') == 'es')
			{
				redirect(lang('backend_url').'/'.lang('servicios_url').'/'.lang('ficha_url').'_'.lang('servicio_url').'/'.$data['id_servicio']);
			}
			else
			{
				redirect(lang('backend_url').'/'.lang('servicios_url').'/'.lang('servicio_url').'_'.lang('ficha_url').'/'.$data['id_servicio']);
			}
        }
    }

	function imagen($id, $destacado = 1)
	{
		$this->lang->load('back', 'es');
        if ($id == '')
		{
			redirect('backend/servicios');
		}
		if ($_FILES)
		{
			require FCPATH.'server/index.php';
			return;
		}

		$data['servicio'] = $this->servicio_model->read($id);
		$data['tipo'] = "servicio";
		$data['id'] = $id;
		$data['destacado'] = $destacado;
		$data['url'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.lang('procesar_url').'_'.lang('imagenes_url');
		$data['imagen'] = TRUE;
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => 	lang('backend'),
        																lang('backend_url').'/'.lang('servicios_url') => lang('servicios'),
        																lang('backend_url').'/'.lang('servicios_url').'/'.lang('listado_url') => lang('listado'),
        																lang('backend_url').'/'.lang('servicios_url').'/'.lang('ficha_url').'_'.lang('servicio_url').'/'.$id => (isset($data['servicio']->nombre) ? lang('ficha_inicio').' ' . $data['servicio']->nombre : lang('servicios_sintitulo')),
        																lang('backend_url').'/'.lang('servicios_url').'/'.lang('ficha_url').'_'.lang('servicio_url').'/'.$id.'/'.lang('adicionar_url') => lang('subir_imagen')
																	 )
															  );
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('servicios_url'), 'listado');
		$data['active'] = 'servicios';
		$data['sub'] = 'ficha';
		$data['title'] = lang('meta.titulo').' - '.lang('servicios').' - '.lang('subir_imagen');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		//$data['file_upload'] = $this->load->view('back/includes/img_upload', $data, true);
		$data['file_upload_js'] = $this->load->view('template/file_upload_js', $data, true); //Widget de subida de imagenes
		$data['file_upload_widget'] = $this->load->view('template/file_upload_widget', $data, true); //Widget de subida de imagenes
		$data['contenido_principal'] = $this->load->view('template/subida_imagen', $data, true);
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
								'id_servicio' => $imagen['id'],
								'id_multimedia' => $id_imagen
						   );
			$this->multimedia_model->crear_rel_multimedia($data_rel, 'servicio');
		}
	}

	function imagen_eliminar(){
		$this->load->model('multimedia/multimedia_model');
		$this->multimedia_model->delete_image($this->input->post('id_multimedia'), 'servicio', $this->input->post('fichero'));
	}

    function eliminar_idioma($id_servicio, $id_detalle_servicio = '', $ajax = false)
    {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        modules::run('services/monitor/add', 'detalle_servicio', $id_detalle_servicio, $this->session->userdata('id_usuario'), 'eliminar_idioma');
        //$detalle = $this->detalle($id);
        $ret = $this->servicio_model->eliminar_idioma($id_detalle_servicio);
        $str = ($ret == true) ? 'true' : 'false';
        if ($ajax)
            echo '[{result:' . $str . '}]';
        else
            redirect('backend/ficha_servicio/' . $id_servicio);
    }
	
	function detalle($id, $ajax = false)
    {
        //$ret = $this->noticia_model->get('detalle_noticia', $id);
        $ret = $this->servicio_model->get('detalle_servicio',$id);
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
        $ret = $this->servicio_model->delete($id);
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
        $ret = $this->servicio_model->read($id, $detalle_id);
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
