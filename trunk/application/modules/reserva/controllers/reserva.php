<?php

class Reserva extends MX_Controller
{
    function __construct()
    {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		modules::run('idioma/set_idioma', 'es');
		$this->load->language('back');
        $this->load->model('reserva_model');
        $this->load->helper('multimedia');
    }

    /*
     * Funcciones del admin, con control de aceso 
	 * 
	 * */
    function index()
    {
        $this->listado();
    }
	
	/*============================================== ASIGNACION DE HABITACION ==============================================*/
	
	/*
	 * Listado de huespedes listo para asignar habitacion
	 * */
	function asignaciones($order_field = 'r.id_reservacion', $order_dir = 'desc', $start = 0, $ajax = false)
	{
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		
        $limit = 15;
        $order_string = '';
        $order_string.= ($order_field == "") 	? '' : $order_field;
        $order_string.= ($order_dir == "") 		? '' : ' ' . $order_dir;

        $od = ($order_dir == 'asc') ? 'desc' : 'asc';
		
        $data['order_field'] 		= $order_field;
        $data['order_dir'] 			= $order_dir;
        $data['order_by_new'] 		= (($order_field == '') ? 'id_reservacion' : $order_field) . "/" . $od;
        $data['url'] 				= lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('asignacion_url');
       	
	    $config['base_url'] 		= '/'.lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('listado_url').'/'.$order_field.'/'.$order_dir;
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
		
        $data['num_reservaciones'] = $this->reserva_model->count_asignaciones();
		
        $config['total_rows'] = $data['num_reservaciones'];
		
        if ($config['total_rows'] == 0)
        {
        	$this->session->set_flashdata('mensaje_redirect', lang('reservacion_no_asignar'));
        	redirect(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('resumen_url'));	
        	//redirect(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('buscar_url').'/'.'ningun_resultado');
		}
        
        $data['reservaciones'] = $this->reserva_model->get_asignaciones($start, $limit, $order_field, $order_dir);
        
        if ($ajax)
        {
            echo json_encode($data['reservaciones']);
        }
        else
        {
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $data['pagination'] 		= $this->pagination->create_links();
            $data['offset'] 			= $start;
            $data['order_field'] 		= $order_field;
            $data['order_direction'] 	= $order_dir;
            $data['active'] 			= 'reservaciones';
			
            if (!empty($terminos_busqueda))
            {
            	$data['sub'] = 'buscar';
            }
            else
			{
				$data['sub'] = 'asignacion';
			}
            $data['title'] = lang('meta.titulo').' - '.lang('reservacion').' - '.lang('asignacion');
			
            $data['breadcrumbs'] = $this->menus->create_breadcrumb(
            															array(
            																	lang('backend_url') => lang('inicio'),
            																	lang('backend_url').'/'.lang('reservaciones_url') => lang('reservaciones'),
            							 										lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('asignacion_url') => lang('asignacion')
																			 )
										 						  );
            
			$data['menu_principal'] = $this->menus->create_mainmenu(lang('reservaciones_url'), 'asignacion');

			$data['usuario'] = array(
										'nombre' 	=> $this->session->userdata('nombre'),
										'apellidos' => $this->session->userdata('apellidos')
									);
			
			//Panel de botones de reserva
			$data['panel_botones'] = $this->load->view('back/administracion/panel_reserva', '', true);
			
			$data['contenido_principal'] = $this->load->view('back/asignacion_reservacion', $data, true);
            $this->load->view('back/template_new', $data);
        }
	}
	
	/*
	 * Realizar asignacion de habitaciones
	 * 
	 * */
	function realizar_asignacion($id = '')
	{
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        
        if ($id == '')
		{
			redirect('backend/reservaciones/asignacion');
		}
		else
		{
			//Si la reservacion existe 
			$datos_reservacion	= $this->reserva_model->read($id);
			if(empty( $datos_reservacion)) redirect('backend/reservaciones/asignacion');
		}
		
        $data['active'] 				= 'reservaciones';
        $data['sub'] 					= 'asignacion';
		$data['reservacion'] 			= $datos_reservacion;
		$data['redirect_asignacion']	= "backend/reservaciones/asignacion";
		
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(
    															array(
    																	lang('backend_url') => lang('inicio'),
    																	lang('backend_url').'/'.lang('reservaciones_url') => lang('reservaciones'),
    							 										lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('asignacion_url') => lang('asignacion'),
    							 										'/' => lang('asignar')
																	 )
								 							);

		$data['title'] = lang('meta.titulo').' - '.lang('reservacion').' - '.lang('asignacion');
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('reservaciones_url'), 'asignacion');
		
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		
		$data['sub_activo'] 	= 'Asignacion';
		
		/*--- Cargas de vistas ---*/
		$data['data_asignacion']			= $data_asignacion = $this->reserva_model->get_reservacion_huespedes($id, $this->session->userdata('idioma'));
		$data['opt_tipo_habitacion']		= dropdown($data_asignacion, 'id_tipo_habitacion', 'tipo_habitacion', '', TRUE, 'Sin Información');
		$data['id_reservacion']				= $id;
		$data['asignacion_habitacion'] 		= $this->load->view('back/asignacion_habitacion', $data, true);
		
        $data['contenido_principal'] 		= $this->load->view('back/ficha_reservacion', $data, true); 	//Carga de contenido principal
        $this->load->view('back/template_new', $data);
	}
	
	/*
	 * Validar tipo de habitacion seleccionada
	 * 
	 * */
	function tipo_habitacion_seleccionada()
	{
		//POST
		$habitacion = $this->input->post('habitacion');
		
		//Mensaje
		$this->form_validation->set_message('tipo_habitacion_seleccionada', lang('reservacion_tipo_habitacion_seleccionada_error'));
		
		//Return
		$return = FALSE;
		
		foreach($habitacion as $id_tipo_habitacion => $cantidad)
		{
			if($cantidad > 0)
			{
				$return = TRUE;
				break;
			}
		}
		
		return $return;
	}
	
	/*============================================= REALIZAR RESERVACIONES ==================================================*/
	
	/*
	 * Validar tipo de habitacion seleccionada
	 * 
	 * */
	function huesped_requerido()
	{
		//POST
		$huespedes = $this->input->post('huesped');
		
		//Mensaje
		$this->form_validation->set_message('huesped_requerido', lang('reservacion_huesped_requerido_error'));
		
		//Return
		$return = TRUE;
		
		foreach($huespedes as $huesped)
		{
			if(empty($huesped))
			{
				$return = FALSE;
				break;
			}
		}
		
		return $return;
	}
	
	function verificar_fechas()
	{
		$this->form_validation->set_message('verificar_fechas', lang('reservacion_rango_fecha'));
		
		$llegada 	= date_format(date_create($this->input->post('checkin')), 'd-m-Y H:i:s');
		$salida 	= date_format(date_create($this->input->post('checkout')), 'd-m-Y H:i:s');
		
		//Validar dia y mes
		list($d, $m, $anio) = preg_split("/(\-|\/)/", $llegada);
		$dia_valido 	= (intval($d) >= 1 && intval($d) <= 31) ? TRUE : FALSE;
		$mes_valido 	= (intval($m) >= 1 && intval($m) <= 12) ? TRUE : FALSE;
		$llegada_valida = $dia_valido && $mes_valido;
		
		list($d, $m, $anio) = preg_split("/(\-|\/)/", $salida);
		$dia_valido 	= (intval($d) >= 1 && intval($d) <= 31) ? TRUE : FALSE;
		$mes_valido 	= (intval($m) >= 1 && intval($m) <= 12) ? TRUE : FALSE;
		$salida_valida 	= $dia_valido && $mes_valido;
		
		//Verificar secuencia
		$inicio 		= date_create($llegada);
		$fin 			= date_create($salida);
		$intervalo 		= date_diff($inicio, $fin);
		$secuencia_valida = ($intervalo->invert == 0 && $intervalo->days > 0) ? TRUE : FALSE;
		//$secuencia_valida = ($intervalo->invert == 0) ? TRUE : FALSE;
		
		//"#^[0-9]{2}\-[0-9]{2}\-[0-9]{4} [0-9]{2}\:[0-9]{2}\:[0-9]{2}$#"
		return (	(preg_match("#^[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4} [0-9]{2}\:[0-9]{2}\:[0-9]{2}$#", $llegada) ||
					preg_match("#^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4} [0-9]{2}\:[0-9]{2}\:[0-9]{2}$#", $llegada)) &&
					
					(preg_match("#^[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4} [0-9]{2}\:[0-9]{2}\:[0-9]{2}$#", $salida) ||
					preg_match("#^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4} [0-9]{2}\:[0-9]{2}\:[0-9]{2}$#", $salida))
					
					&& $llegada_valida && $salida_valida && $secuencia_valida);
	}
	
	/*
	 * Realizar reservacion
	 * 
	 * */
	function reservar()
	{
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		
    	//Title
        $data['title'] = lang('meta.titulo').' - '.lang('reservacion').' - '.lang('reservar');
		$data['sub'] = lang('reservar_url');
		$data['active'] = lang('reservaciones_url');
		
		//POST
		if($this->input->post('efectuar_reserva'))
		{
			//die_pre($_POST);
			
			//Repopulate fechas
			$data['checkin'] = $this->input->post('checkin');
			$data['checkout'] = $this->input->post('checkout');
			
			//Set Values
			$data['value_tratamiento'] 	= $this->input->post('tratamiento');
			$data['value_nombre'] 		= $this->input->post('nombre');
			$data['value_email'] 		= $this->input->post('email');
			$data['value_password'] 	= $this->input->post('password');
			$data['value_aerolinea'] 	= $this->input->post('aerolinea');
			$data['value_pais'] 		= $this->input->post('id_pais');
			$data['value_nacionalidad'] = $this->input->post('nacionalidad');
			$data['value_pago'] 		= $this->input->post('id_tipo_forma_pago');
			$data['value_telefono']		= $this->input->post('telefono');
			$data['value_direccion'] 	= $this->input->post('direccion');
			
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
	        
	        $this->form_validation->set_error_delimiters('<div class="alert-box" style="background-color: #F5DADA !important; color: #AC210F !important; font-weight: normal;">', '<a class="close" href="">×</a></div>');
	        $this->load->helper(array('form', 'url'));
			
			//Rules
			$this->form_validation->set_rules('checkin', 			lang('reservacion_checkin'), 			'required');
			$this->form_validation->set_rules('checkout', 			lang('reservacion_checkout'), 			'required|callback_verificar_fechas');
			$this->form_validation->set_rules('habitacion', 		lang('reservacion_tipo_habitacion'), 	'required|callback_tipo_habitacion_seleccionada');
	        $this->form_validation->set_rules('tratamiento', 		lang('reservacion_tratamiento'), 		'required');
	        $this->form_validation->set_rules('email', 				lang('reservacion_email'), 				'required|valid_email');
	        $this->form_validation->set_rules('nombre', 			lang('reservacion_cliente'), 			'required');
			$this->form_validation->set_rules('telefono', 			lang('reservacion_telefono'), 			'required|is_natural');
			$this->form_validation->set_rules('aerolinea', 			lang('reservacion_aerolinea'), 			'required');
			$this->form_validation->set_rules('id_tipo_forma_pago', lang('reservacion_forma_pago'), 		'required');
			$this->form_validation->set_rules('direccion', 			lang('reservacion_direccion'), 			'required');
			$this->form_validation->set_rules('nacionalidad', 		lang('reservacion_nacionalidad'), 		'required');
			$this->form_validation->set_rules('password', 			lang('reservacion_contraseña'), 		'required|min_length[8]');
			$this->form_validation->set_rules('huesped', 			lang('reservacion_huesped'), 			'required|callback_huesped_requerido');
			
	        if ($this->form_validation->run($this) == TRUE)
	        {
	        	//Usuario Front ----------------------------------------------------------------------------------
	        	$insert_usuario_front = array(	'nombre' 		=> $this->input->post('nombre'),
												'telefono'		=> $this->input->post('telefono'),
												'id_pais'		=> $this->input->post('id_pais'),
												'direccion'		=> $this->input->post('direccion'),
												'nacionalidad'	=> $this->input->post('nacionalidad'),
												'email'			=> $this->input->post('email'),
												'password'		=> sha1($this->input->post('password')));
				
				//Info para el email de reservacion
				$data_email['email'] 			= $this->input->post('email');
				$data_email['telefono'] 		= $this->input->post('telefono');
				$data_email['nacionalidad'] 	= $this->input->post('nacionalidad');
				$data_email['nombre_completo'] 	= $this->input->post('nombre');
				$data_email['titular_reserva']	= $this->input->post('nombre');
				$data_email['tratamiento'] 		= '';
				$data_email['password'] 		= $this->input->post('password');

				$id_usuario_front = $this->reserva_model->insert_reserva($insert_usuario_front, 'usuario_front');
				
				//Fin Usuario Front -------------------------------------------------------------------------------
				
				//Cacular costo -----------------------------------------------------------------------------------
	        	$habitaciones = $this->input->post('habitacion');
	        	$personas = 0; $total_costo = 0;
				foreach($habitaciones as $id_tipo_habitacion => $cantidad_costo)
				{
					list($cantidad, $costo) = explode('_', $cantidad_costo);
					if($cantidad > 0)
					{
						$personas++;
						$costo = $costo * $cantidad;
						$total_costo += $costo;
					}
				}
	        	//Fin Cacular costo -------------------------------------------------------------------------------
				
				//Reservacion -------------------------------------------------------------------------------------
				$codigo_reserva = modules::run('reserva/reserva_front/generar_codigo_reserva');
	        	$insert_reservacion = array(
					"codigo_reserva"		=>	$codigo_reserva,
					"personas"				=> 	$personas, //Esto en realidad en la cantidad de habitaciones, pero bueno... en el front esta asi.
					"aerolinea"				=> 	$this->input->post("aerolinea"),
					"checkin"				=>	$this->input->post("checkin"),
					"checkout"				=>	$this->input->post("checkout"),
					"id_estado_reservacion"	=> 	2, //Pendiente por pago
					"id_estado_activo"		=> 	1, //Activo
					"id_tipo_forma_pago"	=> 	$this->input->post("id_tipo_forma_pago"),
					"precio"				=>  $total_costo,
					"id_usuario_front"		=> 	$id_usuario_front,
					'id_usuario_back'		=>  $this->session->userdata('id_usuario'),
					"observaciones"			=>	'',
					"creado"				=>	date('Y-m-d h:i:s')
								
				);
				$id_reservacion = $this->reserva_model->insert_reserva($insert_reservacion, 'reservacion');
				
				//Info para el email de reservacion
				$data_email['codigo_reserva'] 	= $codigo_reserva;
				$data_email['personas'] 		= $personas;
				$data_email['aerolinea'] 		= $this->input->post("aerolinea");
				$data_email['checkin']			= $this->input->post("checkin");
				$data_email['checkout'] 		= $this->input->post("checkout");
				$data_email['hora_llegada'] 	= '00:00';
				$data_email['hora_salida'] 		= '00:00';
				$data_email['precio_total']		= $total_costo;
				$data_email['denominacion']		= $this->input->post('denominacion');
				$datetime1 						= new DateTime($this->input->post("checkin"));
				$datetime2 						= new DateTime($this->input->post("checkout"));
				$data_email['noches']			= $datetime1->diff($datetime2);
				$data_email['tipo_forma_pago']	= $this->reserva_model->get_forma_pago($this->input->post("id_tipo_forma_pago"));
				
				//Fin Reservacion -------------------------------------------------------------------------------------
				
				//Reservacion - tipo habitacion -----------------------------------------------------------------------
				$tratamiento_huesped = $this->input->post('tratamiento_huesped');
				$huesped = $this->input->post('huesped');
				$total_habitaciones = 0;
				
				foreach($habitaciones as $id_tipo_habitacion => $cantidad_costo)
				{
					list($cantidad, $costo) = explode('_', $cantidad_costo);
					$total_habitaciones = $total_habitaciones + $cantidad;
					for($i = 1; $i <= $cantidad; $i++)
					{
						//Insert reservacion_tipo_habitacion
						$insert_reservacion_tipo_habitacion = array('id_tipo_habitacion' 	=> $id_tipo_habitacion,
																	'id_reservacion' 		=> $id_reservacion,
																	'peticion' 				=> null);
						
						$id_reservacion_tipo_habitacion = $this->reserva_model->insert_reserva($insert_reservacion_tipo_habitacion, 'reservacion_tipo_habitacion');
						
						//Insert Huesped
						$huesped_tratamiento = $id_tipo_habitacion.'_'.$i;
						
						$insert_huesped = array('tratamiento'						=> $tratamiento_huesped[$huesped_tratamiento],
												'nombre'							=> $huesped[$huesped_tratamiento],
												'id_reservacion_tipo_habitacion'	=> $id_reservacion_tipo_habitacion);
												
						$id_huesped = $this->reserva_model->insert_reserva($insert_huesped, 'huesped');
						
					}
				}
				
				//Info para el email de reservacion
				$data_email['numero_habitaciones'] = $total_habitaciones;
				
				//Fin Reservacion - tipo habitacion -----------------------------------------------------------------------
				
				//Enviar Correo -------------------------------------------------------------------------------------------
				$config['protocol']		= "smtp";
                $config['smtp_host']   	= "ssl://smtp.googlemail.com";
                $config['smtp_port']   	= 465;
                $config['smtp_user'] 	= lang('smtp_solyluna.from.email');
                $config['smtp_pass']    = lang('smtp_solyluna.from.pass');
                $config['mailtype']    	= "html";
                $config['charset']    	= 'utf-8';
                $config['newline']     	= "\r\n";
				
				$this->load->library('email', $config);
				$this->email->initialize($config);
				
				$this->email->from(lang('smtp_solyluna.from.email'), lang('email_sol_luna'));
				$this->email->to($data_email['email']);
				$this->email->bcc('gchemello@gmail.com');
				
				//OJO BORRAR/////////////////////////////
				//$this->email->bcc("gchemello@gmail.com");
				//$this->email->bcc("mvlg.nsce@gmail.com");
				/////////////////////////////////////////
				
				$this->email->subject(lang('email_asunto_1'));

				$this->email->message($this->load->view('reserva/front/correo_usuario', $data_email, true));
				
				//SI EL EMAIL SE ENVIA CORRECTAMENTE
				if ($this->email->send())
				{				
					$this->email->from(lang('smtp_solyluna.from.email'), lang('email_sol_luna'));
					$this->email->to('smtp_solyluna.from.email');
					$this->email->bcc('gchemello@gmail.com');
					
					//OJO BORRAR/////////////////////////////
					//$this->email->bcc("gchemello@gmail.com");
					//$this->email->bcc("mvlg.nsce@gmail.com");
					/////////////////////////////////////////
				
					$this->email->subject($data_email['titular_reserva']." ".lang('email_asunto_2'));
					
					$this->email->message($this->load->view('reserva/front/correo_admin', $data_email, true));
					$this->email->send();
				}
				
				//Fin Enviar Correo -------------------------------------------------------------------------------------------
				
				//Redirect backend/reservaciones/listado
				redirect(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('listado_url'));
	        }
		}
		
		//Breadcrumbs
        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
        															array(
        																	lang('backend_url') => lang('inicio'),
        																	lang('backend_url').'/'.lang('reservaciones_url') => lang('reservaciones'),
        							 										lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('asignacion_url') => lang('reservar')
																		 )
									 						  );
        
		//Menu
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('reservaciones_url'), lang('reservar'));
		
		//Usuario
		$data['usuario'] = array('nombre' => $this->session->userdata('nombre'), 'apellidos' => $this->session->userdata('apellidos') );
		
		//Panel de botones de reserva
		$data['panel_botones'] = $this->load->view('back/administracion/panel_reserva', '', true);
		
		//cargar vista
		$data['contenido_principal'] = $this->load->view('back/administracion/reservar', $data, true);
        $this->load->view('back/template_new', $data);
	}
	
	/*
	 * Habitaciones disponibles por tipo
	 * 
	 * */
	function ajax_get_disponibles_tipo_habitacion()
	{
		//Temporada actual
		$id_temporada = $this->reserva_model->get_temporada_actual();
		
		//Idioma
		$id_idioma = $this->session->userdata('id_idioma');
		
		//Fechas
		$checkin = new DateTime($this->input->post('in'));
		$checkout = new DateTime($this->input->post('out'));
		$checkin = $checkin->format('Y-m-d'); 
		$checkout = $checkout->format('Y-m-d');
		$data['checkin'] = $checkin;
		$data['checkout'] = $checkout;
		
		//Formas de pagos
		$formas_pago = $this->reserva_model->get_formas_pago();
		$data['opt_forma_pago'] = dropdown($formas_pago, 'id_tipo_forma_pago', 'descripcion');
		
		//Paises
		$paises = $this->reserva_model->get_paises();
		$data['opt_paises'] = dropdown($paises, 'id_pais', 'descripcion');
		
		//Tratamiendo
		$data['opt_tratamiento'] = array('Sr' 	=> lang('tratamiento_sr'),
										'Srta'	=> lang('tratamiento_srta'),
										'Sra'	=> lang('tratamiento_sra'));
		
		//Disponibilidad
		$data['habitaciones'] = $habitaciones = $disponibilidad_habitaciones = $this->reserva_model->get_disponibles_tipo_habitacion($id_idioma, $id_temporada, $checkin, $checkout);
		$hay_habitaciones = FALSE;
		foreach($habitaciones as $tipo)
		{
			if($tipo->habitaciones > 0)
			{
				$hay_habitaciones = TRUE;
				break;
			}
		}
		
		if($hay_habitaciones)
		{
			$html = $this->load->view('back/administracion/reservar_disponibles', $data, TRUE);
		}
		else
		{
			$html = '<div class="alert-box alert">'.lang('no_habitaciones_disponibles').'<a class="close" href="">×</a></div>';
		}
		
		echo $html;
	}
	
	/*================================================ GESION DEL MODULO DE RESERVA ======================================================*/
	
	/*
	 * Listado de reservaciones
	 * 
	 * */
    function listado($order_field = 'r.id_reservacion', $order_dir = 'desc', $start = 0, $ajax = false)
    {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        
        if ($start == 0 && empty($_POST) && $order_field == 'reservacion.id_reservacion')
        {
        	$this->session->unset_userdata('terminos_busqueda');
        }
		
        $terminos_busqueda = array();
        //$terminos_busqueda = $this->session->userdata('terminos_busqueda');
		
        if (isset($_POST['id_reservacion']))
        {
            $terminos_busqueda['id_reservacion'] = $_POST['id_reservacion'];
        }
		if (isset($_POST['id_estado_reservacion']) && $_POST['id_estado_reservacion'] != -1)
        {
            $terminos_busqueda['id_estado_reservacion'] = $_POST['id_estado_reservacion'];
        }
        if (isset($_POST['id_estado_activo']) && $_POST['id_estado_activo'] != -1)
        {
            $terminos_busqueda['id_estado_activo'] = $_POST['id_estado_activo'];
        }
		if (isset($_POST['cliente']))
        {
            $terminos_busqueda['cliente'] = $_POST['cliente'];
        }
		if (isset($_POST['checkin']))
        {
            $terminos_busqueda['checkin'] = $_POST['checkin'];
        }
		if (isset($_POST['checkout']))
        {
            $terminos_busqueda['checkout'] = $_POST['checkout'];
        }
        if (isset($_POST) && !empty($_POST))
        {
            $terminos_busqueda = array_filter($terminos_busqueda);
            $this->session->set_userdata('terminos_busqueda', $terminos_busqueda);
        }
		
        $limit = 15;
        $order_string = '';
        $order_string.= ($order_field == "") 	? '' : $order_field;
        $order_string.= ($order_dir == "") 		? '' : ' ' . $order_dir;

        $od = ($order_dir == 'asc') ? 'desc' : 'asc';
		
        $data['order_field'] 		= $order_field;
        $data['order_dir'] 			= $order_dir;
        $data['order_by_new'] 		= (($order_field == '') ? 'id_reservacion' : $order_field) . "/" . $od;
        $data['url'] 				= lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('listado_url');
       	
	    $config['base_url'] 		= '/'.lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('listado_url').'/'.$order_field.'/'.$order_dir;
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
		
        $data['num_reservaciones'] = $this->reserva_model->count_all($terminos_busqueda);
		
        $config['total_rows'] = $data['num_reservaciones'];
		
        if ($config['total_rows'] == 0) redirect(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('buscar_url').'/'.'ningun_resultado');
        
        $data['reservaciones'] = $this->reserva_model->get_page($start, $limit, $order_field, $order_dir, $terminos_busqueda);
        
        if ($ajax)
        {
            echo json_encode($data['reservaciones']);
        }
        else
        {
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $data['pagination'] 		= $this->pagination->create_links();
            $data['offset'] 			= $start;
            $data['order_field'] 		= $order_field;
            $data['order_direction'] 	= $order_dir;
            $data['active'] 			= 'reservaciones';
			
            if (!empty($terminos_busqueda))
            {
            	$data['sub'] = 'buscar';
            }
            else
			{
				$data['sub'] = 'listado';
			}
            $data['title'] = lang('meta.titulo').' - '.lang('reservacion').' - '.lang('listado');
            
            if (!empty($terminos_busqueda))
            {
                $lbc = reset($terminos_busqueda);
                $lbt = key($terminos_busqueda);

				/*
                if ($lbt == 'reservacion.id_estado')
                {
                    $bcc = modules::run('services/relations/get_from_id', 'estado', $lbc);
                    $lbc = ucwords($bcc->estado);
                }
				*/
				
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                															array(
                																	lang('backend_url').'/'.lang('reservaciones_url') => lang('reservaciones'),
                							 										lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('buscar_url') => lang('busqueda'),
                							 										lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('buscar_url').'/'.lang('titulo_url') => $lbc
																				 )
											 						  );
            }
            else
            {
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                															array(
                																	lang('backend_url') => lang('inicio'),
                																	lang('backend_url').'/'.lang('reservaciones_url') => lang('reservaciones'),
                							 										lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('listado_url') => lang('listado')
																				 )
											 						  );
            }
			$data['menu_principal'] = $this->menus->create_mainmenu(lang('reservaciones_url'), 'listado');

			$data['usuario'] = array(
										'nombre' 	=> $this->session->userdata('nombre'),
										'apellidos' => $this->session->userdata('apellidos')
									);
			
			//Panel de botones de reserva
			$data['panel_botones'] = $this->load->view('back/administracion/panel_reserva', '', true);
			
			$data['contenido_principal'] = $this->load->view('back/listado_reservacion', $data, true);
            $this->load->view('back/template_new', $data);
        }
    }

    function buscar($mensaje = '')
	{
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		
		$this->load->helper('misc');
        
        $data['active'] 	= 'reservaciones';
        $data['sub'] 		= 'buscar';
        $data['title'] 		= lang('meta.titulo').' - '.lang('reservaciones').' - '.lang('buscar_tit_reserva');
        
		$activo = modules::run('services/relations/get_all', 'estado_activo');
		$data['opt_activo'] = dropdown($activo, 'id_estado_activo', 'descripcion', '', TRUE, '');
		
		$estado_reservacion = modules::run('services/relations/get_all', 'estado_reservacion');
		$data['opt_est_reservacion'] = dropdown($estado_reservacion, 'id_estado_reservacion', 'descripcion', '', TRUE, '');
		
        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => lang('backend'),
        																lang('backend_url').'/'.lang('reservaciones_url') => lang('reservaciones'),
        																lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('buscar_url') => lang('buscar_tit_reserva')));
        $data['mensaje'] 		= $mensaje;
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('reservaciones_url'), 'listado');
		
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
        
        $data['contenido_principal'] = $this->load->view('back/buscar_reservacion', $data, true);
        
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
        if ($id != '')
        {
        	modules::run('services/monitor/add', 'reservacion', $id, $this->session->userdata('id_usuario'), 'editar');
        }
        else
        {
        	modules::run('services/monitor/add', 'reservacion', '', $this->session->userdata('id_usuario'), 'crear');
        }
        
		if ($id == '')
		{
            redirect('backend');
		}
		else
		{
			//Si la reservacion existe 
			$datos_reservacion	= $this->reserva_model->read($id);
			if(empty($datos_reservacion)) redirect('backend/reservaciones');
		}
		
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        
        $this->form_validation->set_rules('aerolinea', 		'Aerolinea', 		'required');
		$this->form_validation->set_rules('personas', 		'Personas', 		'required|integer');
		$this->form_validation->set_rules('checkin', 		'Chekcin', 			'required|callback_validar_fecha_hora');
		$this->form_validation->set_rules('checkout', 		'chekcout', 		'required|callback_validar_fecha_hora');
		//$this->form_validation->set_rules('habitaciones', 	'Habitaciones', 	'required');
		
        if ($this->form_validation->run() == FALSE)
        {
            $data['sub'] 	= 'crear';
            $data['title'] 	= lang('crear_tit_reserva');
            
            if ($id != '')
            {
                $data['title'] 				= lang('editar_tit_reserva');
            }
            $data['active'] = 'reservaciones';
			$data['reservacion'] = $datos_reservacion[0];
			
            if ($id != '')
            {
            	$data['breadcrumbs'] = $this->menus->create_breadcrumb(
            															array(
            																	'reservacion' 		=> lang('reservaciones'),
            																	'edit'				=> lang('editar_tit_reserva'),
            																	$id					=> $data['reservacion']->codigo_reserva
																			 )
																	  );
            }
            else
            {
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                														array(
                																'reservacion' 		=> lang('reservaciones'),
                																'crear' 			=> lang('crear_tit_reserva')
																			 )
																	  );
            }
			
			$activo = modules::run('services/relations/get_all', 'estado_activo');
			$data['opt_activo'] = dropdown($activo, 'id_estado_activo', 'descripcion');
			
			$estado_reservacion = modules::run('services/relations/get_all', 'estado_reservacion');
			$data['opt_est_reservacion'] = dropdown($estado_reservacion, 'id_estado_reservacion', 'descripcion');
			
			$forma_pago = modules::run('services/relations/get_all', 'tipo_forma_pago');
			$data['opt_forma_pago'] = dropdown($forma_pago, 'id_tipo_forma_pago', 'descripcion');
			
			$data['habitaciones_disponibles'] 	= dropdown($datos_reservacion, 'id_habitacion', 'habitacion');
			$data['habitaciones_selected'] 		= distintos($datos_reservacion, 'id_habitacion');
			
			$data['cargar_chosen'] = TRUE;
			
            $data['contenido_principal'] = $this->load->view('back/editar_reservacion', $data, true);
            $this->load->view('back/template_new', $data);
        }
        else
        {
			$datos_update = array(	'aerolinea' 			=> $this->input->post('aerolinea'),
									'personas' 				=> $this->input->post('personas'),
									'checkin' 				=> flip_timestamp($this->input->post('checkin')),
									'checkout' 				=> flip_timestamp($this->input->post('checkout')),
									'id_estado_activo' 		=> $this->input->post('id_activo'),
									'id_estado_reservacion' => $this->input->post('id_estado_reservacion'),
									'id_tipo_forma_pago' 	=> $this->input->post('id_tipo_forma_pago'),
									'id_reservacion'		=> $this->input->post('id_reservacion'));
			
			//Update reservacion
            $id = $this->reserva_model->update($datos_update);

			//Update habitaciones asociadas
			$this->reserva_model->update_reserva_habitacion($this->input->post('id_reservacion'), $this->input->post('habitaciones'));
			
			if($this->session->userdata('idioma') == 'es')
			{
            	redirect(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('ficha_url').'_'.lang('reservacion_url').'/' . $id, 'location');
            }
			else
			{
				redirect(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('reservacion_url').'_'.lang('ficha_url').'/' . $id, 'location');
			}
        }
    }
	
	function ajax_get_habitaciones_disponibles()
	{
		$in 			= $this->input->post('in');
		$out 			= $this->input->post('out');
		$id_reservacion	= $this->input->post('id_reservacion');
		$resp = $this->reserva_model->ajax_get_disponibles_fecha($in, $out, $id_reservacion);
		
		echo json_encode($resp);
	}
	
	function ajax_get_reserva_tipo_habitacion()
	{
		$id_tipo_habitacion = $this->input->post('id_tipo_habitacion');
		$id_reservacion 	= $this->input->post('id_reservacion');
		$resp = $this->reserva_model->get_reserva_tipo_habitacion($id_tipo_habitacion, $id_reservacion, $this->session->userdata('idioma'));
		
		//En caso de realizar la asignacion desde el top-menu "Asignación de habitación"
		$input_redirect = '';
		$redirect_asignacion = $this->input->post('redirect_asignacion');
		if(!empty($redirect_asignacion) && $redirect_asignacion != '0')
		{
			$input_redirect = '<input type="hidden" name="redirect_asignacion" value="'.$redirect_asignacion.'" /> ';
		}
		
		$html = '<form method="POST" class="custom" action="/reserva/reserva/asignar_habitacion">
				 <input type="hidden" name="id_reservacion" value="'.$id_reservacion.'" />
				 <input type="hidden" name="id_tipo_habitacion" value="'.$id_tipo_habitacion.'" />
				 '.$input_redirect;
				 
		foreach($resp as $data)
		{
			$habitaciones_disponibles = $this->reserva_model->get_habitaciones_disponibles($id_tipo_habitacion, $data->checkin, $data->checkout);
			//die_pre($this->db->last_query());
			$data->habitaciones_disponibles = dropdown($habitaciones_disponibles, 'id_habitacion', 'codigo');
			
			//Si ya tiene habitacion asignada
			$asignacion = $this->reserva_model->get_habitacion_reservacion($data->id_reservacion_tipo_habitacion);
			$data->habitacion_asignada = '';
			if(!empty($asignacion))
			{
				$data->habitacion_asignada = $asignacion[0]->codigo;
			}
			
			$vista = $this->load->view('back/asignacion_tipo_habitacion', $data, TRUE);
			$html .= $vista;
		}
		
		$html .= '<button type="submit" >Asignar</button>';
		
		$html .= '</form>';
		
		echo $html;
	}
	
	function asignar_habitacion()
	{
		//POST
		$data_post = $_POST;
		
		//En caso de realizar la asignacion desde el top-menu "Asignación de habitación"/////
		if($this->input->post('redirect_asignacion'))
		{
			$redirect_to_asignacion_menu = $this->input->post('redirect_asignacion');
			unset($data_post['redirect_asignacion']);
		}
		////////////////////////////////////////////////////////////////////////////////////
		
		if(isset($data_post['id_reservacion']) && isset($data_post['id_tipo_habitacion']))
		{
			//Id reservacion
			$id_reservacion = $data_post['id_reservacion'];
			unset($data_post['id_reservacion']);
			
			//Id_tipo_habitacion
			$id_tipo_habitacion = $data_post['id_tipo_habitacion'];
			unset($data_post['id_tipo_habitacion']);
		}
		else redirect('backend/reservaciones');
		 
		//Validacion caiman
		$count_input = count($data_post);
		$count_distintos = count(array_unique($data_post));
		
		//Si se asignó la misma habitacion a 'reservas' distintas
		if($count_input > $count_distintos)
		{
			//Muestra un error
			$data['asignacion_error'] = TRUE;
			
			//Tipo de habitacion seleccionada
			$data['selected_tipo_habitacion'] = $id_tipo_habitacion;
			
			modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
	        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
	        
	        if ($id_reservacion == '')
			{
				redirect('backend/reservaciones');
			}
			else
			{
				//Si la reservacion existe 
				$datos_reservacion	= $this->reserva_model->read($id_reservacion);
				if(empty($datos_reservacion)) redirect('backend/reservaciones');
			}
			
	        $data['active'] 			= 'reservaciones';
	        $data['sub'] 				= 'editar';
			$data['reservacion'] 		= $datos_reservacion;
	        $data['breadcrumbs'] 		= $this->menus->create_breadcrumb(
	        														array(
	        																lang('backend_url') => lang('backend'),
	        																lang('backend_url').'/'.lang('reservaciones_url') => lang('reservaciones'),
	        																lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('listado_url') => lang('listado'),
	        																lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('ficha_url').'_'.lang('reservacion_url').'/'.$id_reservacion => (isset($data['reservacion']->codigo_reserva) ? lang('ficha_inicio').' ' . $data['reservacion']->codigo_reserva : lang('reservacion_sintitulo'))
																		 )
																  );

	        $data['title'] 			= lang('meta.titulo').' - '.lang('reservaciones').' - '.(isset($data['reservacion']->codigo_reserva) ? lang('ficha_inicio').' ' . $data['reservacion']->nombre : lang('reservacion_sintitulo'));
			$data['menu_principal'] = $this->menus->create_mainmenu(lang('reservaciones_url'), 'listado');
			$data['usuario'] 		= array('nombre' => $this->session->userdata('nombre'),'apellidos' => $this->session->userdata('apellidos'));
			
			$data['accion'] 		= 'normal';
			$data['sub_activo'] 	= 'Asignacion';
			
			/*--- Cargas de vistas ---*/
			$data['reservacion_info'] 			= $this->load->view('back/reservacion_info', $data, true); 	//Información básica de la servicio
			$data['data_asignacion']			= $data_asignacion = $this->reserva_model->get_reservacion_huespedes($id_reservacion, $this->session->userdata('idioma'));
			$data['opt_tipo_habitacion']		= dropdown($data_asignacion, 'id_tipo_habitacion', 'tipo_habitacion', '', TRUE, 'Sin Información');
			$data['id_reservacion']				= $id_reservacion;
			$data['asignacion_habitacion'] 		= $this->load->view('back/asignacion_habitacion', $data, true);
	        $data['contenido_principal'] 		= $this->load->view('back/ficha_reservacion', $data, true); 	//Carga de contenido principal
	       
	       	$this->load->view('back/template_new', $data);
		}
		else
		{
			//Realizar asignacion
			$this->reserva_model->insertar_asignacion($data_post);
			
			//Redirect
			if(isset($redirect_to_asignacion_menu) && !empty($redirect_to_asignacion_menu))
			{
				//En caso de realizar la asignacion desde el top-menu "Asignación de habitación"
				redirect($redirect_to_asignacion_menu);
			}
			else redirect('/backend/reservaciones/ficha_reservacion/'.$id_reservacion);
		}
	}
	
    function edit($id = '', $ajax = false)
    {
        if ($id == '')
		{
            redirect('backend');
		}
		else
		{
			//Si la reservacion existe 
			$datos_reservacion	= $this->reserva_model->read($id);
			if(empty($datos_reservacion)) redirect('backend/reservaciones');
		}
		
		//panel de botones de reserva
		$data['panel_botones'] = $this->load->view('back/administracion/panel_reserva', '', true);
		
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		
		$this->load->helper('misc');
        $data['active'] 	= 'reservaciones';
        $data['sub'] 		= 'editar';

        $data['reservacion'] = $datos_reservacion[0];
		
		$activo = modules::run('services/relations/get_all', 'estado_activo');
		$data['opt_activo'] = dropdown($activo, 'id_estado_activo', 'descripcion');
		
		$estado_reservacion = modules::run('services/relations/get_all', 'estado_reservacion');
		$data['opt_est_reservacion'] = dropdown($estado_reservacion, 'id_estado_reservacion', 'descripcion');
		
		$forma_pago = modules::run('services/relations/get_all', 'tipo_forma_pago');
		$data['opt_forma_pago'] = dropdown($forma_pago, 'id_tipo_forma_pago', 'descripcion');
		
		$data['habitaciones_disponibles'] 	= dropdown($datos_reservacion, 'id_habitacion', 'habitacion');
		$data['habitaciones_selected'] 		= distintos($datos_reservacion, 'id_habitacion');
		
		$data['cargar_chosen'] = TRUE;
		
        $data['breadcrumbs'] = $this->menus->create_breadcrumb(
									        					   array(
									        					   			lang('backend_url') => lang('backend'),
									        								lang('backend_url').'/'.lang('reservaciones_url') => lang('reservaciones'),
									        								lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('ficha_url').'_'.lang('reservacion_url').'/'.$id => lang('editar_tit_reserva'),
									        								'#' => (isset($data['reservacion']->codigo_reserva) && $data['reservacion']->codigo_reserva != '') ? $data['reservacion']->codigo_reserva : lang('reservacion_sintitulo')
																		)
															  );
		
        $data['title'] 			= lang('meta.titulo').' - '.lang('reservaciones').' - '.lang('editar').' '.$data['reservacion']->codigo_reserva;
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('reservaciones_url'), 'listado');
		$data['usuario'] 		= array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
        $data['contenido_principal'] = $this->load->view('back/editar_reservacion', $data, true);
		
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
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        
        if ($id == '')
		{
			redirect('backend/reservaciones');
		}
		else
		{
			//Si la reservacion existe 
			$datos_reservacion	= $this->reserva_model->read($id);
			if(empty( $datos_reservacion)) redirect('backend/reservaciones');
		}
		
        $data['active'] 			= 'reservaciones';
        $data['sub'] 				= 'editar';
		$data['reservacion'] 		= $datos_reservacion;
        $data['breadcrumbs'] 		= $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => lang('backend'),
        																lang('backend_url').'/'.lang('reservaciones_url') => lang('reservaciones'),
        																lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('listado_url') => lang('listado'),
        																lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('ficha_url').'_'.lang('reservacion_url').'/'.$id => (isset($data['reservacion']->codigo_reserva) ? lang('ficha_inicio').' ' . $data['reservacion']->codigo_reserva : lang('reservacion_sintitulo'))
																	 )
															  );

        $data['title'] = lang('meta.titulo').' - '.lang('reservaciones').' - '.(isset($data['reservacion']->codigo_reserva) ? lang('ficha_inicio').' ' . $data['reservacion']->nombre : lang('reservacion_sintitulo'));
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('reservaciones_url'), 'listado');
		
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);

		$data['accion'] 					= 'normal';
		$data['sub_activo'] 				= 'Ficha';
		
		/*--- Cargas de vistas ---*/
		$data['reservacion_info'] 			= $this->load->view('back/reservacion_info', $data, true); 	//Información básica de la servicio
		$data['data_asignacion']			= $data_asignacion = $this->reserva_model->get_reservacion_huespedes($id, $this->session->userdata('idioma'));
		$data['opt_tipo_habitacion']		= dropdown($data_asignacion, 'id_tipo_habitacion', 'tipo_habitacion', '', TRUE, 'Sin Información');
		$data['id_reservacion']				= $id;
		$data['asignacion_habitacion'] 		= $this->load->view('back/asignacion_habitacion', $data, true);
		$data['panel_botones'] 				= $this->load->view('back/administracion/panel_reserva', '', true);
		
		//$data['idioma_info'] 				= $this->load->view('back/ficha/idioma_info', $data, true); 			//Información de los idiomas
		//$data['idioma_form'] 				= $this->load->view('back/ficha/idioma_tipo_habitacion', $data, true); 	//Vista para la creación de nuevos idiomas
		//$data['idioma_nuevo'] 			= $this->load->view('back/ficha/idioma_tipo_habitacion', $data, true); 	//Vista para la creación de nuevos idiomas
        $data['contenido_principal'] 		= $this->load->view('back/ficha_reservacion', $data, true); 	//Carga de contenido principal
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
		//$data['url_add_p'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.$id_servicio.'/'.lang('adicionar_url').'/'.lang('principal');
		//Imagenes secundarias
		//$data['url_add_s'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.$id_servicio.'/'.lang('adicionar_url').'/'.lang('secundarias');
		//Imagenes terciarias
		//$data['url_add_t'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.$id_servicio.'/'.lang('adicionar_url').'/'.lang('terciarias');
		//Eliminar Imagen
		//$data['url_delete'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.lang('eliminar_url');
		//$data['imagen_principal'] = $this->multimedia_model->get_relation($id_servicio, 'servicio', 1);
		//$data['imagenes_secundarias'] = $this->multimedia_model->get_relation($id_servicio, 'servicio', 2);
		//$data['imagenes_terciarias'] = $this->multimedia_model->get_relation($id_servicio, 'servicio', 3);
		//$data['servicio_imagenes'] = $this->load->view('template/ficha_imagen', $data, true); //Ficha de la sección de imagenes
		//$data['ficha_js'] = $this->load->view('template/ficha_imagen_js', $data, true); //Contenido js de la seccion ficha imagenes
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
	
	function validar_fecha_hora($fecha)
	{
		$this->form_validation->set_message('validar_fecha_hora', 'La fecha o la hora del campo %s es invalida.');
		
		$fecha = date_format(date_create($fecha), 'd-m-Y H:i:s');
		
		//Validar dia y mes
		list($d, $m, $anio) = preg_split("-", $fecha);
		$dia_valido = (intval($d) >= 1 && intval($d) <= 31) ? TRUE : FALSE;
		$mes_valido = (intval($m) >= 1 && intval($m) <= 12) ? TRUE : FALSE;
		
		//Validar hora
		list($a, $hora) = explode(' ', $anio);
		list($h, $min) 	= explode(':', $hora);
		$hora_valida 	= (intval($h) >= 0 && intval($h) <= 23) ? TRUE : FALSE;
		$min_valido 	= (intval($min) >= 0 && intval($min) <= 59) ? TRUE : FALSE;
		
		return ( (preg_match("#^[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4} [0-9]{2}\:[0-9]{2}\:[0-9]{2}$#", $fecha)) && $dia_valido && $mes_valido && $hora_valida && $min_valido);
	
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

			//$data['url_add_p'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.$data['id_servicio'].'/'.lang('adicionar_url').'/'.lang('principal'); //Imagen Principal
			//$data['url_add_s'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.$data['id_servicio'].'/'.lang('adicionar_url').'/'.lang('secundarias'); //Imagenes secundarias
			//$data['url_add_t'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.$data['id_servicio'].'/'.lang('adicionar_url').'/'.lang('terciarias'); //Imagenes terciarias
			//$data['url_delete'] = base_url().lang('backend_url').'/'.lang('servicios_url').'/'.lang('imagenes_url').'/'.lang('eliminar_url'); //Eliminar Imagen

			//$data['imagen_principal'] = $this->multimedia_model->get_relation($data['id_servicio'], 'servicio', 1);
			//$data['imagenes_secundarias'] = $this->multimedia_model->get_relation($data['id_servicio'], 'servicio', 2);
			//$data['imagenes_terciarias'] = $this->multimedia_model->get_relation($data['id_servicio'], 'servicio', 3);
			
			$data['accion'] 					= ($this->input->post('accion') == 'normal') ? 'normal' : 'editar' ;
			$data['sub_activo'] 				= ($this->input->post('accion') == 'normal') ? 'NewLangTab' : 'EditLangTab' ;
			$data['tipo_habitacion_idiomas'] 	= $this->tipo_habitacion_model->detalles($data['id_tipo_habitacion']);
			$data['tipo_habitacion_info'] 		= $this->load->view('back/ficha/tipo_habitacion_info', $data, true);
			$data['idioma_info'] 				= $this->load->view('back/ficha/idioma_info', $data, true);
			$data['idioma_nuevo'] 				= $this->load->view('back/ficha/idioma_tipo_habitacion', $data, true); //Vista para la creación de nuevos idiomas
			$data['idioma_form'] 				= $this->load->view('back/ficha/idioma_tipo_habitacion', $data, true); //Vista para la creación de nuevos idiomas
			
			//$data['servicio_imagenes'] 			= $this->load->view('template/ficha_imagen', $data, true); //Ficha de la sección de imagenes
			//$data['ficha_js'] 					= $this->load->view('template/ficha_imagen_js', $data, true); //Contenido js de la seccion ficha imagenes
            
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
	
	/*
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
	*/
	
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
	
	/*================================================ RESUMEN RESERVAS ====================================================*/
	
	function resumen_diario_deprecado($order_field = 'r.id_reservacion', $order_dir = 'desc', $start = 0)
	{
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		
		$filtro_fecha = $this->input->post('filtro_fecha');
		$filtro_nav = $this->input->post('filtro_nav');
		
		if(!empty($filtro_fecha))
		{
			//Para consulta
			$filtro_fecha = flip_fecha($filtro_fecha);
			
			if(!empty($filtro_nav) && $filtro_nav == 'despues')
			{
				$filtro_fecha = date('Y-m-d', strtotime($filtro_fecha . ' + 1 day'));
			}
			else if(!empty($filtro_nav) && $filtro_nav == 'antes')
			{
				$filtro_fecha = date('Y-m-d', strtotime($filtro_fecha . ' - 1 day'));
			}
			
			//Para la vista
			$data['filtro_fecha'] = date('d-m-Y', strtotime($filtro_fecha));
		}
		else
		{
			//Para la vista
			$data['filtro_fecha'] = date('d-m-Y');
			
			//Para consulta
			$filtro_fecha = date('Y-m-d'); 
		}
		
		$limit = 15;
        $order_string = '';
        $order_string.= ($order_field == "") 	? '' : $order_field;
        $order_string.= ($order_dir == "") 		? '' : ' ' . $order_dir;

        $od = ($order_dir == 'asc') ? 'desc' : 'asc';
		
        $data['order_field'] 		= $order_field;
        $data['order_dir'] 			= $order_dir;
        $data['order_by_new'] 		= (($order_field == '') ? 'id_reservacion' : $order_field) . "/" . $od;
       	
	    $config['base_url'] 		= '/'.lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('resumen_url').'/'.$order_field.'/'.$order_dir;
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
		
        $data['num_reservaciones'] = $this->reserva_model->count_huespedes_resumen($filtro_fecha);
        $config['total_rows'] = $data['num_reservaciones'];
        
        $data['listado'] = $this->reserva_model->get_huespedes_resumen($filtro_fecha, $start, $limit, $order_field, $order_dir);
		
		$this->load->library('pagination');
        $this->pagination->initialize($config);
        $data['pagination'] 		= $this->pagination->create_links();
        $data['offset'] 			= $start;
        $data['order_field'] 		= $order_field;
        $data['order_direction'] 	= $order_dir;
		
        $data['active'] 	= 'reservaciones';
        $data['sub'] 		= 'resumen';
		$data['url'] 		= lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('resumen_url');
		
        $data['breadcrumbs'] 		= $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => lang('backend'),
        																lang('backend_url').'/'.lang('reservaciones_url') => lang('reservaciones'),
        																lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('resumen_url') => lang('resumen'),
																	 )
															  );
		
		$data['title'] = lang('meta.titulo').' - '.lang('reservacion').' - '.lang('resumen');
		
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('reservaciones_url'), 'resumen');
		
		$data['usuario'] = array('nombre' => $this->session->userdata('nombre'), 'apellidos' => $this->session->userdata('apellidos'));

		$data['sub_activo'] 				= 'Huespedes';
		
		/*--- Cargas de vistas ---*/
		$data['huespedes_actuales'] 		= $this->load->view('back/administracion/resumen_huespedes', $data, true);


        $data['contenido_principal'] 		= $this->load->view('back/administracion/resumen_diario', $data, true); 	//Carga de contenido principal
        $this->load->view('back/template_new', $data);
	}
	
	/*
	 * Resumen diario
	 * 
	 * */
	function resumen_diario()
	{
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		
		//die_pre($_POST);
		
		$data['mensaje_flash'] = $this->session->flashdata('mensaje_redirect');
		
		//Ficha activa
		$data['sub_activo'] = ($this->input->post('panel_habitaciones')) ? 'Habitaciones' : 'Huespedes';
		
		$filtro_fecha = $this->input->post('filtro_fecha');
		$filtro_nav = $this->input->post('filtro_nav'); 
		
		//Ficha de Huespedes--------------------------------------------------------------------------
		if(!empty($filtro_fecha))
		{
			//Para consulta
			
			$filtro_fecha = flip_fecha($filtro_fecha);
			
			if(!empty($filtro_nav) && $filtro_nav == 'despues')
			{
				$filtro_fecha = date('Y-m-d', strtotime($filtro_fecha . ' + 1 day'));
			}
			else if(!empty($filtro_nav) && $filtro_nav == 'antes')
			{
				$filtro_fecha = date('Y-m-d', strtotime($filtro_fecha . ' - 1 day'));
			}
			
			//Para la vista
			$data['filtro_fecha'] = date('d-m-Y', strtotime($filtro_fecha));
		}
		else
		{
			$data['filtro_fecha'] = date('d-m-Y');
			$filtro_fecha = date('Y-m-d');
		}
		
		
		//Huespedes
        $data['listado'] = $this->reserva_model->get_huespedes_resumen($filtro_fecha);
		
		//die_pre($this->db->last_query());
		
		//Reservas - Estado reservacion = 3 (reservado) sin habitaciones asignadas
        $data['reservadas'] = $this->reserva_model->get_reservaciones_resumen($filtro_fecha, 3);
		
		//Pendiente por pago - Estado reservacion = 2 (pendiente)
        $data['pendientes'] = $this->reserva_model->get_pendiente_resumen($filtro_fecha, 2);
		
		//Ficha de Habitaciones ------------------------------------------------------------------------
		
		$fecha_habitaciones_post = $this->input->post('fecha_habitaciones');
		$habitacion_nav = $this->input->post('habitacion_nav');
		$data['fecha_habitaciones'] = date('d-m-Y');
		$fecha_habitaciones = date('Y-m-d'); 
		
		if(!empty($fecha_habitaciones_post))
		{
			//Ficha activa
			$data['sub_activo'] = 'Habitaciones';
			
			//Para consulta
			$fecha_habitaciones = flip_fecha($fecha_habitaciones_post);
			
			if(!empty($habitacion_nav) && $habitacion_nav == 'siguiente')
				$fecha_habitaciones = date('Y-m-d', strtotime($fecha_habitaciones . ' + 1 day'));
			
			else if(!empty($habitacion_nav) && $habitacion_nav == 'anterior')
				$fecha_habitaciones = date('Y-m-d', strtotime($fecha_habitaciones . ' - 1 day'));
			
			//Para la vista
			$data['fecha_habitaciones'] = date('d-m-Y', strtotime($fecha_habitaciones));
		}
		
		//Habitaciones ocupadas
		$habitaciones_ocupadas = $this->reserva_model->get_habitaciones_ocupadas($fecha_habitaciones);
		
		foreach($habitaciones_ocupadas as $habitacion)
		{
			$check_in 	= ($habitacion->checkin == $fecha_habitaciones);
			$check_out 	= ($habitacion->checkout == $fecha_habitaciones);
			
			$ocupacion[$habitacion->id_habitacion]['codigo'] 	= $habitacion->codigo;
			$ocupacion[$habitacion->id_habitacion]['tipo'] 		= $habitacion->tipo;
			
			if($check_in) 
			{
				$ocupacion[$habitacion->id_habitacion]['in'] 				= $habitacion->checkin;
				$ocupacion[$habitacion->id_habitacion]['in_nombre'] 		= $habitacion->nombre;
				$ocupacion[$habitacion->id_habitacion]['in_telefono'] 		= $habitacion->telefono;
				$ocupacion[$habitacion->id_habitacion]['in_email'] 			= $habitacion->email;
				$ocupacion[$habitacion->id_habitacion]['in_reservacion'] 	= $habitacion->id_reservacion;
			}
			
			if($check_out)
			{
				$ocupacion[$habitacion->id_habitacion]['out'] 				= $habitacion->checkout;
				$ocupacion[$habitacion->id_habitacion]['out_nombre'] 		= $habitacion->nombre;
				$ocupacion[$habitacion->id_habitacion]['out_telefono'] 		= $habitacion->telefono;
				$ocupacion[$habitacion->id_habitacion]['out_email'] 		= $habitacion->email;
				$ocupacion[$habitacion->id_habitacion]['out_reservacion'] 	= $habitacion->id_reservacion;
			}
			
			if(!$check_in && !$check_out && !empty($habitacion->nombre))
			{
				$ocupacion[$habitacion->id_habitacion]['huesped'] 				= $habitacion->nombre;
				$ocupacion[$habitacion->id_habitacion]['huesped_telefono'] 		= $habitacion->telefono;
				$ocupacion[$habitacion->id_habitacion]['huesped_email'] 		= $habitacion->email;
				$ocupacion[$habitacion->id_habitacion]['huesped_reservacion'] 	= $habitacion->id_reservacion;
			}
		}
		$data['habitaciones_ocupadas'] = $ocupacion;
		
        $data['active'] = 'reservaciones';
        $data['sub'] 	= 'resumen';
		$data['url'] 	= lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('resumen_url');
		
        $data['breadcrumbs'] = $this->menus->create_breadcrumb(array(lang('backend_url') => lang('backend'),
        															 lang('backend_url').'/'.lang('reservaciones_url') => lang('reservaciones'),
        															 lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('resumen_url') => lang('resumen')));
		
		$data['title'] 			= lang('meta.titulo').' - '.lang('reservacion').' - '.lang('resumen');
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('reservaciones_url'), 'resumen');
		$data['usuario'] 		= array('nombre' => $this->session->userdata('nombre'), 'apellidos' => $this->session->userdata('apellidos'));
		
		/*--- Cargas de vistas ---*/
		$data['huespedes_actuales'] 		= $this->load->view('back/administracion/resumen_huespedes', $data, true);
		$data['habitaciones_actuales'] 		= $this->load->view('back/administracion/resumen_habitaciones', $data, true);
		$data['panel_botones'] 				= $this->load->view('back/administracion/panel_reserva', '', true);
		
        $data['contenido_principal'] 		= $this->load->view('back/administracion/resumen_diario', $data, true);
		
        $this->load->view('back/template_new', $data);
	}
	
    /*
     * Fin funcciones del admin */
	
	/*================================================ GESTION DE PAGOS ====================================================*/
	
	function listado_pagos($order_field = 'fecha_pago', $order_dir = 'desc', $start = 0, $ajax = false)
	{
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		
        $limit = 15;
        $order_string = '';
        $order_string.= ($order_field == "") 	? '' : $order_field;
        $order_string.= ($order_dir == "") 		? '' : ' ' . $order_dir;

        $od = ($order_dir == 'asc') ? 'desc' : 'asc';
		
        $data['order_field'] 		= $order_field;
        $data['order_dir'] 			= $order_dir;
        $data['order_by_new'] 		= (($order_field == '') ? 'id_pago' : $order_field) . "/" . $od;
        $data['url'] 				= lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('pagos_url');
       	
	    $config['base_url'] 		= '/'.lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('pagos_url').'/'.$order_field.'/'.$order_dir;
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
		
        $data['num_pagos'] = $this->reserva_model->count_listado_pagos();
		
        $config['total_rows'] = $data['num_pagos'];
		
        if ($config['total_rows'] == 0)
        {
        	$this->session->set_flashdata('mensaje_redirect', lang('reservacion_no_pagos'));
        	redirect(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('resumen_url'));
		}
        
        $data['pagos'] = $this->reserva_model->get_listado_pagos($start, $limit, $order_field, $order_dir);
        
        if ($ajax)
        {
            echo json_encode($data['pagos']);
        }
        else
        {
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $data['pagination'] 		= $this->pagination->create_links();
            $data['offset'] 			= $start;
            $data['order_field'] 		= $order_field;
            $data['order_direction'] 	= $order_dir;
            $data['active'] 			= 'reservaciones';
			
            if (!empty($terminos_busqueda))
            {
            	$data['sub'] = 'buscar';
            }
            else
			{
				$data['sub'] = 'pagos';
			}
            $data['title'] = lang('meta.titulo').' - '.lang('reservacion').' - '.lang('pagos');
			
            $data['breadcrumbs'] = $this->menus->create_breadcrumb(
            															array(
            																	lang('backend_url') => lang('inicio'),
            																	lang('backend_url').'/'.lang('reservaciones_url') => lang('reservaciones'),
            							 										lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('pagos_url') => lang('pagos')
																			 )
										 						  );
            
			$data['menu_principal'] = $this->menus->create_mainmenu(lang('reservaciones_url'), 'pagos');

			$data['usuario'] = array(
										'nombre' 	=> $this->session->userdata('nombre'),
										'apellidos' => $this->session->userdata('apellidos')
									);
			
			//Panel de botones de reserva
			$data['panel_botones'] = $this->load->view('back/administracion/panel_reserva', '', true);
			
			$data['contenido_principal'] = $this->load->view('back/administracion/listado_pagos', $data, true);
            $this->load->view('back/template_new', $data);
        }
	}
	
	function confirmar_pago($id_pago)
	{
		//Datos del pago
		$pago = $this->reserva_model->get_pago($id_pago);
		
		//Confirmado / 0 pendiente, 1 confirmado 
		$confirmado = ($pago[0]->confirmado == 0) ? 1 : 0;
		
		//Estado de reservacion / 3 reservado, 2 pendiente
		$id_estado_reserva = ($pago[0]->confirmado == 0) ? 3 : 2;
		
		//Update
		$this->reserva_model->update_estado_pago($id_pago, $confirmado, $pago[0]->id_reservacion, $id_estado_reserva);
		
		//Redirect
		redirect('backend/reservaciones/pagos');
	}
	
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
