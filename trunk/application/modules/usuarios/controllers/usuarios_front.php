<?php

class Usuarios_front extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('idioma'))
		{
			modules::run('idioma/idioma/set_idioma', $this->session->userdata('idioma'));	
		} 
		else
		{
			modules::run('idioma/idioma/set_idioma', 'es');
		}
		$this->load->model('usuarios_model');
		
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->lang->load('front', 'es');
		//echo '<pre>'.print_r($this->session->all_userdata(),true).'</pre>';
		// Gettext: http://codeigniter.com/wiki/Category:Internationalization::Gettext/
		// TODO: lo postpongo para más adelante, ahora mismo me lleva demasiado tiempo
		//$this->load->library('MY_Language');
		//$this->lang->load_gettext( $this->config->get_item('language') ); 
		//$this->gettextbis->line('messSingle', array('plural' => 'messPlur', 'count' => 2, 'd' => 18));
	}
	
	function index()
	{
		$data['title']					= "Iniciar sesión o crearse una cuenta";
		$data['contenido_principal'] 	= $this->load->view('usuarios/front/login_view',$data,true);
			
		$this->load->view('front/template',$data);
	}

	function registro_usuario()
	{
		
		//OBTENGO EL VECTOR DE TODOS LOS PAISES
		$query_paises 					=	$this->usuarios_model->obtener_paises();
		
		//OBTENGO EL VECTOR DE STRINGS DE LOS PAISES
		$data['opt_paises'] 			= 	dropdown($query_paises, 'id_pais', 'descripcion');
		
		//TITULO DE PAGINA
		$data['title']					= 	lang('front_title.inicio');
		
		//CARGO EL CONTENIDO PRINCIPAL EN LA PAGINA 
		$data['contenido_principal'] 	= 	$this->load->view('usuarios/front/registro_usuario',$data,true);
		
		//CARGO EL CONTENIDO PRINCIPAL CON LA AYUDA DEL TEMPLATE
		$this->load->view('front/template',$data);
	}
	
	function registrar_usuario()
	{
	
		$this->form_validation->set_rules("nombre",			lang('front.registro.input_nombre')		,"required|trim");
		$this->form_validation->set_rules("id_pais",		lang('front.registro.input_pais')			,"required");
		$this->form_validation->set_rules("nacionalidad",	lang('front.registro.input_nacionalidad')	,"required");
		$this->form_validation->set_rules("email",			lang('front.registro.input_email')			,"required|valid_email|callback_verificar_email");
		$this->form_validation->set_rules("password",		lang('front.registro.input_password')		,"required|trim|min_length[8]");
		$this->form_validation->set_rules("repassword",		lang('front.registro.input_repassword')		,"required|trim|min_length[8]|matches[password]");
		$this->form_validation->set_rules("telefono",		lang('front.registro.input_telefono')		,"required|trim|is_natural");
		
		$this->form_validation->set_message("required",			lang('front.registro.required'));
		$this->form_validation->set_message("valid_email",		lang('front.registro.valid_email'));
		$this->form_validation->set_message("verificar_email",	lang('front.registro.verificar_email'));
		$this->form_validation->set_message("min_length[8]",	lang('front.registro.min_length'));
		$this->form_validation->set_message("matches",			lang('front.registro.matches'));
		$this->form_validation->set_error_delimiters('<small class="error">', '</small>');
		
		//SI LAS VALIDACIONES SON CORRECTAS
		if($this->form_validation->run($this) == TRUE)
		{
			//CREANDO VECTOR DE DATOS A INSERTAR
			$datos_registro = array(
				"nombre"		=>	$this->input->post("nombre"),
				"email"			=>	$this->input->post("email"),
				"password"		=>	sha1($this->input->post("password")),
				"telefono"		=> 	$this->input->post("telefono"),
				"id_pais"		=> 	$this->input->post("id_pais"),
				"nacionalidad"	=> 	$this->input->post("nacionalidad"),
				"direccion"		=>	$this->input->post("direccion")
			);
			
			//INSERTO LOS DATOS
			$this->usuarios_model->registrar_usuario($datos_registro);
				
			$data['mensaje'] 				= lang('front.registro_mensaje_exitoso');
			$data['titulo']					= lang('front.registro_titulo');
			$data['title'] 					= lang('front.registro_title');
			
			//CONFIGURACION PARA EL ENVIO DEL CORREO ELECTRONICO
			$config['protocol']		= "smtp";
            $config['smtp_host']   	= "ssl://smtp.googlemail.com";
            $config['smtp_port']   	= 465;
            $config['smtp_user'] 	= lang('front.smtp_user');
            $config['smtp_pass']    = lang('front.smtp_pass');
            $config['mailtype']    	= "html";
            $config['charset']    	= 'utf-8';
            $config['newline']     	= "\r\n";
			$this->load->library('email', $config);
			
			$this->email->initialize($config);
			
			$data_usuario['email'] 	= 	$this->input->post("email");
			
			$this->email->from("reserva@losroquessolyluna.com","Sol y Luna");
			$this->email->to($data_usuario['email']);
			$this->email->bcc('gchemello@gmail.com');
			//$this->email->bcc("");
			$this->email->subject("Bienvenido a Sol y Luna");
			
			
			$this->email->message($this->load->view('front/correo_bienvenida', $data_usuario, true));	
			$this->email->send();
				
			//SI EL EMAIL SE ENVIA CORRECTAMENTE
			if($this->input->post('login_fb_google'))
			{
				$datos_usuario = $this->usuarios_model->getData($this->input->post("email"));
				$this->session->set_userdata($datos_usuario[0]);
				redirect('/','location');
			}
				
			
			$data['title']					= "Registro exitoso";
			$data['contenido_principal'] 	= $this->load->view('usuarios/front/mensaje-registro',$data,true);
			
			$this->load->view('front/template',$data);
			
		}
		else
		{
			//pre(validation_errors());
			//DATOS A GUARDAR PARA COLOCARLOS EN LOS INPUTS
			$data = array(
				"nombre"		=>	$this->input->post("nombre"),
				"email"			=>	$this->input->post("email"),
				"telefono"		=> 	$this->input->post("telefono"),
				"id_pais"		=> 	$this->input->post("id_pais"),
				"nacionalidad"	=> 	$this->input->post("nacionalidad"),
				"direccion"		=>	$this->input->post("direccion")
			);
			
			$query_paises = $this->usuarios_model->obtener_paises();
			$data['opt_paises'] = dropdown($query_paises, 'id_pais', 'descripcion');
			
			//TITULO DE PAGINA
			$data['title']	= lang('front_title.inicio');
			
			//CARGO EL CONTENIDO PRINCIPAL EN LA PAGINA 
			$data['contenido_principal'] 	= $this->load->view('usuarios/front/registro_usuario',$data,true);
			
			//CARGO EL CONTENIDO PRINCIPAL CON LA AYUDA DEL TEMPLATE
			$this->load->view('front/template',$data);
			
		}
	}
	
	function verificar_email($email)
	{
		return !$this->usuarios_model->verificar_email($email);
	}
	
	function existe_email($email)
	{
		return $this->usuarios_model->verificar_email($email);
	}	
	
	
	function verificar_sesion()
	{
		return $this->usuarios_model->verificar_sesion();
	}
	
	function iniciar_sesion()
	{	
		$this->form_validation->set_rules("email","Email","required|trim|valid_email|callback_existe_email");
		$this->form_validation->set_rules("password","Password","required|trim|min_length[8]|callback_verificar_sesion");
		
		$this->form_validation->set_message("existe_email",		lang('front.registro.existe_email'));
		$this->form_validation->set_message("required",			lang('front.registro.required'));
		$this->form_validation->set_message("valid_email",		lang('front.registro.valid_email'));
		$this->form_validation->set_message("verificar_email",	lang('front.registro.verificar_email'));
		$this->form_validation->set_message("min_length",		lang('front.registro.min_length'));
		$this->form_validation->set_message("verificar_sesion",	lang('front.registro.verificar_sesion'));
		$this->form_validation->set_error_delimiters('<small class="error">', '</small>');
		
		if($this->form_validation->run($this) == TRUE)
		{
			
			$datos_usuario = $this->usuarios_model->getData($this->input->post("email"));
			$this->session->set_userdata($datos_usuario[0]);
			redirect('usuarios/panel-usuario');
		}
		else
		{
			echo modules::run('usuarios/usuarios_front/index');
		}
		
		
	}
	
	function ajax_verificar_sesion()
	{
		$this->form_validation->set_rules("email","Email","required|trim|valid_email|callback_existe_email");
		$this->form_validation->set_rules("password","Password","required|trim|min_length[8]|callback_verificar_sesion");
		
		$this->form_validation->set_message("existe_email",		lang('front.registro.existe_email'));
		$this->form_validation->set_message("required",			lang('front.registro.required'));
		$this->form_validation->set_message("valid_email",		lang('front.registro.valid_email'));
		$this->form_validation->set_message("verificar_email",	lang('front.registro.verificar_email'));
		$this->form_validation->set_message("min_length",		lang('front.registro.min_length'));
		$this->form_validation->set_message("verificar_sesion",	lang('front.registro.verificar_sesion'));
		
		if($this->form_validation->run($this) == TRUE)
		{
			$ajax_data = array(
				"mensaje"	=>	"correcto"
			);
			
			echo json_encode($ajax_data);
		}
		else
		{
			$ajax_data = array(
				"mensaje"		=>	"Combinacion usuario contraseña incorrecto.",
				"error_email"	=>	form_error("email"),
				"error_password"=>	form_error("password")
			);
			
			echo json_encode($ajax_data);
		}
	}
	
	function ajax_iniciar_sesion()
	{
		$this->form_validation->set_rules("email","Email","required|trim|valid_email|callback_existe_email");
		$this->form_validation->set_rules("password","Password","required|trim|min_length[8]|callback_verificar_sesion");
		
		$this->form_validation->set_message("existe_email",		lang('front.registro.existe_email'));
		$this->form_validation->set_message("required",			lang('front.registro.required'));
		$this->form_validation->set_message("valid_email",		lang('front.registro.valid_email'));
		$this->form_validation->set_message("verificar_email",	lang('front.registro.verificar_email'));
		$this->form_validation->set_message("min_length",		lang('front.registro.min_length'));
		$this->form_validation->set_message("verificar_sesion",	lang('front.registro.verificar_sesion'));
		$this->form_validation->set_error_delimiters('<small class="error">', '</small>');
		if($this->form_validation->run($this) == TRUE)
		{
			
			$datos_usuario = $this->usuarios_model->getData($this->input->post("email"));
			$this->session->set_userdata($datos_usuario[0]);
			redirect("/");
		}
		else
		{
			echo modules::run('iniciar-sesion');
		}
		
	}
	
	function cerrar_sesion()
	{
		delete_cookie("ci_session");
		session_unset('access_token');  
		redirect('/','location');
		
	}

	//ESTA FUNCION MANDA A LA VISTA DE REESTABLECIMIENTO DE CONTRASEÑA
	function olvidar_contrasena()
	{
		//TITULO DE PAGINA
		$data['title']	= lang('front.olvidar.contrasena.title');
		
		//CARGO EL CONTENIDO PRINCIPAL EN LA PAGINA 
		$data['contenido_principal'] 	= $this->load->view('usuarios/front/olvidar_contrasena',$data,true);
		
		//CARGO EL CONTENIDO PRINCIPAL CON LA AYUDA DEL TEMPLATE
		$this->load->view('front/template',$data);
	}

	//ESTA FUNCTION MANDA EL CORREO CON EL LINK DE REESTABLECIMIENTO DE CONTRASEÑA
	function enviar_restablecimiento()
	{
		//REGLAS PARA LOS CAMPOS
		$this->form_validation->set_rules("email","Email","required|valid_email|callback_existe_email");
	
		//MENSAJES PARA CADA ERROR CON SU LENAGUAJE
		$this->form_validation->set_message("existe_email",		lang('front.registro.existe_email'));
		$this->form_validation->set_message("required",			lang('front.registro.required'));
		$this->form_validation->set_message("valid_email",		lang('front.registro.valid_email'));
		$this->form_validation->set_error_delimiters('<small class="error">', '</small>');
		
		//SI LAS VALIDACIONES ESTAN CORRECTAS
		if($this->form_validation->run($this) == TRUE)
		{
			
			//CONFIGURACION PARA EL ENVIO DEL CORREO ELECTRONICO
			$config['protocol'] 	= "smtp";
			$config['smtp_host'] 	= "ssl://smtp.googlemail.com";
			$config['smtp_port'] 	= 465;
			$config['smtp_user']	= lang('front.smtp_user');
			$config['smtp_pass']	= lang('front.smtp_pass');
			$config['mailtype'] 	= "html";
			$config['charset']		='utf-8';
			$config['newline']		="\r\n";
			$this->load->library('email', $config);
			
			//OBTENIENDO DATA DEL USUARIO
			$datos_usuario = $this->usuarios_model->getData($this->input->post("email"));
			
			//CONFIGURANDO LA DATA
			$form_data['nombre_completo']	= $datos_usuario[0]->nombre;
			$form_data['email']	 			= $datos_usuario[0]->email;
			
			//INICIALIZO LA VARIABLE DE CORREO ELECTRONICO
			$this->email->initialize($config);
			
			//QUIEN MANDARA EL CORREO
			$this->email->from(lang('front.smtp_email1'), "Sol y Luna");
			
			//PARA EL USUARIO QUIEN ESTA HACIENDO LA SOLICITUD
			$this->email->to($form_data['email'], $form_data['nombre_completo']);
			$this->email->bcc('gchemello@gmail.com');
			
			//ASUNTO DEL MENSAJE
			$this->email->subject('Restablecimiento de contraseña');
			
			//DATOS NECESARIOS PARA LA PLANTILLA DE CORREO
			$data_usuario['nombre_completo'] 	= $form_data['nombre_completo'];
			
			//CREAMOS EL SHA1 CON LA RECUPERACION
			$data = array(
				"email"			=> $datos_usuario[0]->email,
				"recuperacion"	=> sha1($datos_usuario[0]->id_usuario.$datos_usuario[0]->password.date("YmdHis"))
			);
			$this->usuarios_model->actualizar($data);
			
			//CREAOS EL ENLACE
			$data_usuario['enlace']				= base_url().lang('front.restablecer_url').'/'.$data['recuperacion'];
			
			//CARGAMOS EL MENSAJE CON LA VISTA Y LOS DATOS
			$this->email->message($this->load->view('front/correo', $data_usuario, true));
			
			//SI EL CORREO SE ENVIA
			if ($this->email->send())
			{
				$data['estado']					= lang('front.restablecimiento.estado1');
				$data['mensaje'] 				= lang('front.restablecimiento.mensaje1');
				$data['titulo']					= lang('front.restablecimiento.titulo1');
				$data['title'] 					= lang('front.restablecmiento.title');
				$data['contenido_principal'] 	= $this->load->view('usuarios/front/mensaje-enviado',$data,true);
			
				$this->load->view('front/template',$data);
			}
			else//SINO SE ENVIA
			{
				$data['estado']					= lang('front.restablecimiento.estado2');
				$data['mensaje'] 				= lang('front.restablecimiento.mensaje2');
				$data['titulo']					= lang('front.restablecimiento.titulo2');
				$data['title'] 					= lang('front.restablecmiento.title');
				$data['contenido_principal'] 	= $this->load->view('usuarios/front/mensaje-enviado',$data,true);
			
				$this->load->view('front/template',$data);
			}
			
			
		}
		else
		{
			echo modules::run('usuarios/usuarios_front/olvidar_contrasena');
		}
	}
	
	//ESTA FUNCION MANDA A LA VISTA DE REESTABLECIMIENTO DE CONTRASEÑA
	function restablecer_contrasena($codigo)
	{
		$data = array(
			"recuperacion" => $codigo
		);
		
		//OBTENIENDO DATA DEL USUARIO
		$datos_usuario = $this->usuarios_model->getData($this->input->post("email"));
		
		if($this->usuarios_model->verificar_restablecimiento($data))
		{
			//TITULO DE PAGINA
			$data['title']	= lang('front.restablecer.title');
			
			//CARGO EL CONTENIDO PRINCIPAL EN LA PAGINA 
			$data['contenido_principal'] 	= $this->load->view('usuarios/front/restablecer-contrasena',$data,true);
			
			//CARGO EL CONTENIDO PRINCIPAL CON LA AYUDA DEL TEMPLATE
			$this->load->view('front/template',$data);
		}
		else
		{
			redirect('error');	
		}
	}

	function restableciendo_contrasena()
	{
		$this->form_validation->set_rules("email",				lang('front.restableciendo.email'),"required|trim|valid_email|callback_existe_email");
		$this->form_validation->set_rules("password",			lang('front.restableciendo.password'),"required|trim|min_length[8]");
		$this->form_validation->set_rules("repassword",			lang('front.restableciendo.repassword'),"required|trim|min_length[8]|matches[password]");
		
		$this->form_validation->set_message("existe_email",		lang('front.registro.existe_email'));
		$this->form_validation->set_message("required",			lang('front.registro.required'));
		$this->form_validation->set_message("valid_email",		lang('front.registro.valid_email'));
		$this->form_validation->set_message("min_length",		lang('front.registro.min_length'));
		$this->form_validation->set_error_delimiters('<small class="error">', '</small>');
		
		if($this->form_validation->run($this) == TRUE)
		{
			
			//CREANDO VECTOR DE DATOS A INSERTAR
			$datos_actualizar = array(
				"email"			=>	$this->input->post("email"),
				"password"		=>	sha1($this->input->post("password")),
				"recuperacion"	=>	""
			);
			
			$this->usuarios_model->actualizar($datos_actualizar);
				
			$data['mensaje'] 				= lang('front.restableciendo.mensaje');
			$data['titulo']					= lang('front.restableciendo.titulo');
			$data['title'] 					= lang('front.restableciendo.title');
			$data['contenido_principal'] 	= $this->load->view('usuarios/front/mensaje-registro',$data,true);
			
			$this->load->view('front/template',$data);
		}
		else
		{
			//DATOS A CONSERVAR
			$data['email']	=	$this->input->post("email");
			
			//TITULO DE PAGINA
			$data['title'] 					= lang('front.restableciendo.title');
			
			//CARGO EL CONTENIDO PRINCIPAL EN LA PAGINA 
			$data['contenido_principal'] 	= $this->load->view('usuarios/front/restablecer-contrasena',$data,true);
			
			//CARGO EL CONTENIDO PRINCIPAL CON LA AYUDA DEL TEMPLATE
			$this->load->view('front/template',$data);
		}
	}

	function update_informacion_usuario($id_usuario,$data_update)
	{	
		$this->db->where('id_usuario', $id);
		$this->db->update('usuario_front', $data_update); 
	}
	
	function panel_usuario()
	{
		if($this->session->userdata('id_usuario'))
		{
			//TITULO DE PAGINA
			$data['title'] 					= "Panel de Usuario";
			
			//CARGO EL CONTENIDO PRINCIPAL EN LA PAGINA 
			$data['contenido_principal'] 	= $this->load->view('usuarios/front/panel_usuario',$data,true);
			
			//CARGO EL CONTENIDO PRINCIPAL CON LA AYUDA DEL TEMPLATE
			$this->load->view('front/template',$data);
		}
		else
		{
			redirect('/');
		}
	}
	
	function datos_usuario()
	{
		//die_pre($this->session->all_userdata());
		$id_usuario = $this->session->userdata('id_usuario');
		if($id_usuario)
		{
			//OBTENGO EL VECTOR DE TODOS LOS PAISES
			$query_paises 					=	$this->usuarios_model->obtener_paises();
			
			//OBTENGO EL VECTOR DE STRINGS DE LOS PAISES
			$data['opt_paises'] 			= 	dropdown($query_paises, 'id_pais', 'descripcion');
			
			$data['usuario'] = $this->usuarios_model->get_datos_usuario($id_usuario);
			
			//TITULO DE PAGINA
			$data['title'] 					= "Datos de Usuario";
			
			//CARGO EL CONTENIDO PRINCIPAL EN LA PAGINA 
			$data['contenido_principal'] 	= $this->load->view('usuarios/front/userdata_view',$data,true);
			
			//CARGO EL CONTENIDO PRINCIPAL CON LA AYUDA DEL TEMPLATE
			$this->load->view('front/template',$data);
		}
		else
		{
			redirect('/');
		}
	}
	
	function verificar_contraseña($r1,$r2)
	{
			return ((!empty($r1) || !empty($r2)) && ($r1==$r2));
	}
	
	function verificar_email_duplicado($email)
	{
		return !$this->usuarios_model->verificar_email_duplicado($email);
	}
	
	function update_userdata()
	{
		$this->form_validation->set_rules("nombre",			lang('front.registro.input_nombre')			,"required|trim");
		$this->form_validation->set_rules("id_pais",		lang('front.registro.input_pais')			,"required|trim");
		$this->form_validation->set_rules("nacionalidad",	lang('front.registro.input_nacionalidad')	,"required|trim");
		$this->form_validation->set_rules("telefono",		lang('front.registro.input_telefono')		,"required|trim");
		
		if($this->session->userdata("email") != $this->input->post("email"))
			$this->form_validation->set_rules("email",			lang('front.registro.input_email')			,"required|valid_email|callback_verificar_email_duplicado");
		
		$password = $this->input->post("password");
		$respassword = $this->input->post("repassword");
		
		if(!empty($password) || !empty($repassword))
		{
			
			$this->form_validation->set_rules("password",		lang('front.registro.input_password')		,"required|trim|min_length[8]");
			$this->form_validation->set_rules("repassword",		lang('front.registro.input_repassword')		,"required|trim|min_length[8]|matches[password]");
		}
		else
		{
			$this->form_validation->set_rules("password",		lang('front.registro.input_password')		,"trim|min_length[8]");
			$this->form_validation->set_rules("repassword",		lang('front.registro.input_repassword')		,"trim|min_length[8]|matches[password]");
		
		}
		
	
		$this->form_validation->set_message("required",			lang('front.registro.required'));
		$this->form_validation->set_message("valid_email",		lang('front.registro.valid_email'));
		$this->form_validation->set_message("verificar_email",	lang('front.registro.verificar_email'));
		$this->form_validation->set_message("min_length",		lang('front.registro.min_length'));
		$this->form_validation->set_message("matches",			lang('front.registro.matches'));
		$this->form_validation->set_message("verificar_email_duplicado",lang('front.registro.verificar_email'));
		$this->form_validation->set_error_delimiters('<small class="error">', '</small>');
		
		if($this->form_validation->run($this) == TRUE)
		{
			//DATOS A GUARDAR PARA COLOCARLOS EN LOS INPUTS
			$data = array(
				"nombre"		=>	$this->input->post("nombre"),
				"email"			=>	$this->input->post("email"),
				"telefono"		=> 	$this->input->post("telefono"),
				"id_pais"		=> 	$this->input->post("id_pais"),
				"nacionalidad"	=> 	$this->input->post("nacionalidad"),
				"direccion"		=>	$this->input->post("direccion")
			);
			
			if($this->verificar_contraseña($this->input->post("password"), $this->input->post("repassword")))
				$data["password"] = sha1($this->input->post("password"));

			$this->usuarios_model->update_informacion_usuario($this->session->userdata("id_usuario"),$data);
			$datos_usuario = $this->usuarios_model->getData($this->input->post("email"));
			$this->session->set_userdata($datos_usuario[0]);
			
			//TITULO DE PAGINA
			$data['title'] 					= "Panel de Usuario";
			$data['mensaje'] = "Sus datos han sido actualizado.";
			//CARGO EL CONTENIDO PRINCIPAL EN LA PAGINA 
			$data['contenido_principal'] 	= $this->load->view('usuarios/front/panel_usuario',$data,true);
			
			//CARGO EL CONTENIDO PRINCIPAL CON LA AYUDA DEL TEMPLATE
			$this->load->view('front/template',$data);
		}
		else
		{
			//DATOS A GUARDAR PARA COLOCARLOS EN LOS INPUTS
			$data = array(
				"nombre"		=>	$this->input->post("nombre"),
				"email"			=>	$this->input->post("email"),
				"telefono"		=> 	$this->input->post("telefono"),
				"id_pais"		=> 	$this->input->post("id_pais"),
				"nacionalidad"	=> 	$this->input->post("nacionalidad"),
				"direccion"		=>	$this->input->post("direccion")
			);
			
			$query_paises = $this->usuarios_model->obtener_paises();
			$data['opt_paises'] = dropdown($query_paises, 'id_pais', 'descripcion');
			
			//TITULO DE PAGINA
			$data['title']	= lang('front_title.inicio');
			
			//CARGO EL CONTENIDO PRINCIPAL EN LA PAGINA 
			$data['contenido_principal'] 	= $this->load->view('usuarios/front/userdata_view',$data,true);
			
			//CARGO EL CONTENIDO PRINCIPAL CON LA AYUDA DEL TEMPLATE
			$this->load->view('front/template',$data);
		}
	}
	
	/* 
	 * Funcciones del admin, con control de aceso */
	/*function index()
	{
		//echo "aaa";
		$data['main']='coleccion';
		
		$data['no_sidebar']=true;

		$data['main']=$this->lang->line('inicio');
		$data['sub']='/';
		$data['title']=$this->lang->line('inicio');
		$data_content['breadcrumbs']=array('/',$this->lang->line('inicio'));
		$where = array("tipo_receta"=>"mes");
		$data_content['recetas_mes'] = modules::run('services/relations/get_all_orderby','receta',false,$where,'true','receta.creado');
		
		//$where = array("tipo_receta"=>"mes");
		$order = 'RAND()';
		$data_content['productos'] = modules::run('services/relations/get_all_orderby','producto',false,'','true',$order);
		//$data_content=1;
		//echo "entra aqui tambien";
		//echo "<pre>PRODUCTO Relacionado"; print_r($data_content['productos']); echo "</pre>";
		$data['main_content']=$this->load->view('front/home',$data_content,true);
		$this->load->view('front/template',$data);
	}

	function usuarioUnico(){
			return !$this->usuarios_model->findUsuario($this->input->post('nombre_usuario'));
	}

	function correoUnico(){
			return !$this->usuarios_model->findEmail($this->input->post('correo_usuario'));		
	}

	function correoLogin(){
			return !$this->usuarios_model->findEmail($this->input->post('email'));		
	}
	
	function login($categoria='')
	{
		//echo "aqui va el URL".$categoria;
		if ($categoria==$this->lang->line('recuperar_password_url')) {
			$this->recuperar_page();
		} else {
			//echo 'pagina login';
			$data['main'] = $this->lang->line('login');
			$data['title'] = "Login";
			$data_content['id_idioma'] = $this->id_idioma;
			$data_content['breadcrumbs']=array('/'=>$this->lang->line('inicio'),$this->lang->line('login_url')=>$this->lang->line('login'));
			$data['main_content']=$this->load->view('front/login',$data_content,true);
			$this->load->view('front/template',$data);
		}
	}

	function recuperar_page($categoria='')
	{
		//echo "aqui va el contacto";
			//echo 'pagina recuperar';
			$data['main']=$this->lang->line('login');
			$data_content['id_idioma']=$this->id_idioma;
			$data_content['breadcrumbs'] = array(
													'/' => lang('inicio'), 
													$this->lang->line('login_url') => $this->lang->line('login')
												);
			$data['main_content']=$this->load->view('front/recuperar',$data_content,true);
			$this->load->view('front/template',$data);
		
	}
	
	/**
	 * Recibe el formulario de login
	 * 
	 *
	 */
	function check_login($ajax = false)
	{
		//echo 'entro aqui enviar';
		$data['main'] = lang('login');
		
		$this->form_validation->set_error_delimiters('<p class="errorbox">', '</p>');
		
		
		//$this->form_validation->set_rules('email','Email','required|min_length[3]|trim|valid_email|callback__esUsuarioActivoByEmail');
		//$this->form_validation->set_message('email', '%s no corresponde a ningun usuario registrado y activado');
		//$this->form_validation->set_rules('password','Contraseña','required|trim|callback__esUsuarioActivoByEmailPassword');
		
		$this->form_validation->set_rules('email','Email','required|trim|valid_email|callback_correoLogin');
		$this->form_validation->set_rules('password','Contraseña','required|trim|min_length[3]');
		//$this->form_validation->set_message('min_length', '%s los caracteres minimos son 3');
		$this->form_validation->set_message('correoLogin', 'El correo no esta registrado/activado.');
		
		if (!$this->form_validation->run()) {
			// Muestra la página de login, donde habrá que indicar que
			//	hubo un error en el login.
			$this->login();
		} else {
			$this->load->model('usuarios_model');
			
			$usuario = $this->usuarios_model->validate();
			//echo '<pre>'.print_r($id_usuario,true).'</pre>';
			if ($usuario !== false)  {
				// if the user's credentials validated...
				
				//echo "form validation true y el usuario existe".$this->input->post('url')."<-";
				//$this->user_data();
				$data=(array)$usuario;
				$data['is_logged_in'] = true;
				//echo '<pre>'.print_r($data,true).'</pre>';
				$this->session->set_userdata($data);
				
				if ($ajax!=false) {
					echo json_encode($this->user);
				} else {
					//echo 'true';
					if( $this->input->post('url') !=''  ) {
						$r = $this->input->post('url');
						$r=($this->input->post('url')=='/'.$this->lang->line('login_url_check')) ? '/' : $r;
						redirect($r);
					} else {
						$r=($this->session->userdata('return_url')=='') ? '/' : $this->session->userdata('return_url');
						$r=($this->session->userdata('return_url')=='/'.$this->lang->line('login_url_check')) ? '/' : $r;
						redirect($r);
					}
				}
			} else  {
				// incorrect username or password
				
				//echo "form validation true pero usuario no existe";
				
				if ($ajax!=false){
					echo "[{'result':false}]";
				} else {
					$data['login']=true;
					$data_content['error']= $this->lang->line('login_error');
					$data['main']=$this->lang->line('login');
					$data_content['id_idioma']=$this->id_idioma;
					$data_content['breadcrumbs']=array('/'=>$this->lang->line('inicio'),$this->lang->line('login_url')=>$this->lang->line('login'));
					$data['main_content']=$this->load->view('front/login',$data_content,true);
					$this->load->view('front/template',$data);
		
				}
			}
		}
	}

	
	
	function registro($categoria='') {
		if ($categoria == $this->lang->line('registro_crear_url')) {
			$this->registro_create(); 
		} else {
			//echo '<pre> POST'.print_r($_POST,true).'</pre>';
			$data['main'] = $this->lang->line('registro');
			$data_content['id_idioma'] = $this->id_idioma;
			$data_content['breadcrumbs'] = array(
													'/' => $this->lang->line('inicio'),
													'/'.$this->lang->line('registro_url') => $this->lang->line('registro'),
												);
			$data_content['post'] = $this->session->userdata('register');
			$this->session->unset_userdata('register');
			
			$data['main_content'] = $this->load->view('front/registro_1',$data_content,true);
			$this->load->view('front/template',$data);
		}
	}

	function registro_2($categoria='')
	{
		//echo '<pre> POST2'.print_r($_POST,true).'</pre>';
		
		$data['main'] = $this->lang->line('registro');
		$data_content['id_idioma'] = $this->id_idioma;
		$data_content['breadcrumbs'] = array(
			'/' => $this->lang->line('inicio'),
			'/'.$this->lang->line('registro_url') => $this->lang->line('registro'),
			//''	=> 'Paso 2/2'
		);
		
		$data_content['post'] = $this->session->userdata('register2');
		$this->session->unset_userdata('register2');
		
		
		$data['main_content'] = $this->load->view('front/registro_2',$data_content,true);
		$this->load->view('front/template',$data);
		
	}
	
	function registro_OK($categoria='')
	{
		
		$data['main']=$this->lang->line('registro');
		$data_content['id_idioma']=$this->id_idioma;
		$data_content['breadcrumbs']=array('/'=>$this->lang->line('inicio'),$this->lang->line('registro_url')=>$this->lang->line('registro'));
		$data['main_content']=$this->load->view('front/registro_OK',$data_content,true);
		$this->load->view('front/template',$data);
		
	}

	function registro_MOD($categoria='')
	{
		
		$data['main']=$this->lang->line('registro');
		$data_content['id_idioma']=$this->id_idioma;
		$data_content['breadcrumbs']=array('/'=>$this->lang->line('inicio'),$this->lang->line('registro_url')=>$this->lang->line('registro'));
		$data['main_content']=$this->load->view('front/registro_MOD_OK',$data_content,true);
		$this->load->view('front/template',$data);
		
	}
	
	function activar_usuario($clave='')
	{
		if ($clave=='') {
			redirect('/');
		} else {
			$usuario = $this->usuarios_model->get_key($clave);
			
			//if($usuario['id_rol']!='4') redirect('/');
			//echo '<pre> Usuario['.$usuario.']'.print_r($usuario,true).'</pre>';
			$form_data['id_rol']='3'; // Activa el Rol de Receta al usuario 
			$form_data['id_usuario'] = $usuario['id_usuario'];
			//$form_data['verificacion'] =
			//$this->load->model('usuario/usuario_model');
			//$id=$this->usuario_model->update($form_data);
            
            $this->load->model('usuario/usuario_model');
			$id=$this->usuario_model->update($form_data);
			            
			$data['main'] = $this->lang->line('registro');
			$data_content['id_idioma']=$this->id_idioma;
			$data_content['breadcrumbs']=array(
				'/' => $this->lang->line('inicio'),
				'/'.$this->lang->line('registro_url') => $this->lang->line('registro'),
				''	=> 'Activar');
			//$data['main_content']=$this->load->view('front/activar_OK',$data_content,true);
			$data['main_content']=$this->load->view('front/registro_OK',$data_content,true);
			$this->load->view('front/template',$data);
		}
	}
	
	function registro_create($id='') {

		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<li class="errorbox">', '</li>');
		$this->form_validation->set_message('required', $this->lang->line('form.error.registro.requerido'));
		$this->form_validation->set_message('min_length', $this->lang->line('form.error.registro.min_lenght'));
		
		$prueba = date("Y-m-d");
		
		switch ($this->input->post('paso')) {
			case '2': $this->registro_create_2(); return;
			default: $this->registro_create_1();
		}
			
	}
	
	function registro_create_2() {
		echo '<pre>';
		echo '<h1>registro_create_2</h1>';
		print_r($_POST);
		echo '<h1>registro_create_1</h1>';
		print_r($this->session->userdata('register'));
		echo '</pre>';
		
		// Guardamos datos de paso 1 en sesión
		$this->session->set_userdata('register2', $_POST);
		
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('surname1', 'Apellido 1', 'trim|required||min_length[2]');
		$this->form_validation->set_rules('surname2', 'Apellido 2', 'trim|required|min_length[2]');
		//$this->form_validation->set_rules('select_track', 'Vía', 'trim|required|min_length[1]');
		$this->form_validation->set_rules('phone', 'Teléfono', 'trim|required|min_length[2]');
		$this->form_validation->set_rules('address_name', 'Nombre de la vía', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('address_number', 'Numero', 'trim|required|min_length[1]');
		$this->form_validation->set_rules('address_place', 'Localidad', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('address_cp', 'CP', 'trim|required|min_length[2]');
		$this->form_validation->set_rules('select_province', 'Provincia', 'trim|required|min_length[1]');
		
		if (!modules::run('usuarios/is_logged_in_rol','usuario',$this->uri->uri_string()) ) {
			$this->form_validation->set_rules('accept_conditions', 'Acepto Condiciones', 'trim|required|min_length[2]');
		}
		//date_default_timezone_set ('Europe/Berlin');
		
		
		if (!$this->form_validation->run($this)) {
			$this->registro_2();
		} else {
			//foreach (array_keys($_POST) as $k) {
			//	$form_data_temp[$k]=$this->input->post($k);
			//}
			$form_data_temp = array_merge($this->session->userdata('register'), $_POST);
			//Data principal
			
            if ($this->session->userdata('id_usuario')!='') {
				$form_data['id_usuario'] = $this->session->userdata('id_usuario');
				$usuario = $this->usuarios_model->read($this->session->userdata('id_usuario'));
				$form_data2['id_detalle_usuario'] = $usuario->id_detalle_usuario;
            }
	
          	$form_data['nombre_usuario'] = $form_data_temp['nombre_usuario'];
			$form_data['nombre'] = $form_data_temp['name'];
			$form_data['apellidos'] = $form_data_temp['surname1'];
			$form_data['email'] = $form_data_temp['correo_usuario'];
			$form_data['fecha'] = date('Y-m-d');
			$form_data['password'] = sha1($form_data_temp['clave']);
			
			if ($this->session->userdata('id_usuario')=='') {
				// ID ROL de tipo USUARIO = 3
				$form_data['id_rol'] = 4; //Rol Inactividad 
				$form_data['verificacion'] = sha1($form_data['email'].$form_data['fecha'].$form_data['nombre']);

			}
			
			//echo '<pre> POST'.print_r($_POST,true).'</pre>';   
            $this->load->model('usuario/usuario_model');
            $id = $this->usuario_model->update($form_data);
            //echo 'SI SE REGISTRO EL USUARIO ['.$id.']<br>';
			//$this->registro_2();
			
			//Data Usuario Detalles
			$form_data2['id_usuario'] = $id;
			$form_data2['apellido_1'] = $form_data_temp['surname1'];
			$form_data2['apellido_2'] = $form_data_temp['surname2'];
			$form_data2['telefono'] = $form_data_temp['phone'];
			$form_data2['direccion_via'] = $form_data_temp['via'];
			$form_data2['direccion_via_nombre'] = $form_data_temp['address_name'];
			$form_data2['direccion_numero'] = $form_data_temp['address_number'];
			$form_data2['localidad'] = $form_data_temp['address_place'];; 
			$form_data2['cp'] = $form_data_temp['address_cp'];
			$form_data2['provincia'] = $form_data_temp['select_province'];
			$form_data2['mayor_edad'] = isset($form_data_temp['age']) ? '1' : '0';
			$form_data2['recibir_promos'] = isset($form_data_temp['promotions']) ? '1' : '0';
			
			
			$id = $this->usuario_model->update_idioma($form_data2);
			
			$is_logged_in = $this->session->userdata('is_logged_in');
			
			if (!isset($is_logged_in) || $is_logged_in != true) {
		 		//Proceso de ENVIO DE CORREO ELECTRONICO
				$email = $form_data_temp['correo_usuario'];
				//$email = 'gchemello@gmail.com';
				$this->load->library('email');
				$config['mailtype'] = 'html';
				$this->email->initialize($config);
				$this->email->from($this->lang->line('email_albo_registro'), $this->lang->line('nombre_emisor_registro'));
				$this->email->to($email);
				$this->email->bcc('gchemello@gmail.com');
				//if($this->input->post('email_copia')!='') $this->email->cc($form_data['email']);
				//$this->email->bcc('inaki.garcia@tecknosfera.com','Iñaki García');		
				//$this->email->subject($this->lang->line('contacto.form.tema.'.$form_data['tipo_mensaje']));
				$this->email->subject($this->lang->line('email_subject_registro'));		
				$data_usuario['url'] = $this->lang->line('url_albo');		
				$data_usuario['verificacion'] = $this->lang->line('url_albo').$this->lang->line('activar_url').'/'.$form_data['verificacion'];			
				$this->email->message($this->load->view('front/emailing_registro',$data_usuario,true));			
				
				if ( !$this->email->send()) { //echo "Error envio el Email"; 
											}
				else { //echo "Success envio el Email"; 
				}
			}
			if ($this->session->userdata('id_usuario')=='') {
				// Registrando
				$this->registro_OK();
			} else {
				// Modificando
				$this->registro_MOD();
			} 
		}
		
	}
	
	/*	function registro_create_1() {
		// echo '<pre>'; print_r($_POST); echo '</pre>';
		
		// Guardamos datos de paso 1 en sesión
		$this->session->set_userdata('register', $_POST);
		
		
		if (!modules::run('usuarios/is_logged_in_rol','usuario',$this->uri->uri_string()) ) {
			$this->form_validation->set_rules('nombre_usuario', $this->lang->line('form.error.nombre'), 'trim|required|min_length[3]|callback_usuarioUnico');
			$this->form_validation->set_rules('correo_usuario', $this->lang->line('form.error.correo'), 'trim|required|valid_email|min_length[5]|callback_correoUnico');
			$this->form_validation->set_rules('repeat_correo_usuario', $this->lang->line('form.error.correo.repetir'), 'trim|required|valid_email|min_length[5]|matches[correo_usuario]');
			//$this->form_validation->set_rules('be_of_age', $this->lang->line('form.error.mayor'), 'trim|required|min_length[1]');
			$this->form_validation->set_rules('age', $this->lang->line('form.error.mayor'), 'trim|required|min_length[2]');
		} else  {
			$this->form_validation->set_rules('correo_usuario', $this->lang->line('form.error.correo'), 'trim|required|valid_email|min_length[5]');
			$this->form_validation->set_rules('repeat_correo_usuario', $this->lang->line('form.error.correo.repetir'), 'trim|required|valid_email|min_length[5]|matches[correo_usuario]');
		}
		
		$this->form_validation->set_rules('clave', $this->lang->line('form.error.password'), 'trim|required|min_length[6]');
		$this->form_validation->set_rules('repeat_password_usuario', $this->lang->line('form.error.password.repetir'), 'trim|required|min_length[6]|matches[clave]');
		
		
		$this->form_validation->set_message('valid_email', $this->lang->line('form.error.registro.email'));
		$this->form_validation->set_message('matches', $this->lang->line('form.error.registro.igual'));
		
		$this->form_validation->set_message('usuarioUnico', 'El %s ya existe, intenta con otro nombre.');
		$this->form_validation->set_message('correoUnico', 'El %s ya esta registrado.');
		
		//$this->load->model('usuarios_model');
		//$usuario_login=$this->usuarios_model->get_user($this->session->userdata('id_usuario'));
		//echo '<pre>Usuario:'.$this->session->userdata('id_usuario'); echo print_r($usuario_login,true); echo '</pre>';
			
		if (!$this->form_validation->run($this)) {
			$this->registro();
		} else {
			//echo '<pre> POST'.print_r($_POST,true).'</pre>';   	
			$this->registro_2(); 
		}
	}
	*/
}

/* End of file home_front.php */

?>
