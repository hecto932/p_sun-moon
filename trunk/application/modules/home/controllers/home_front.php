<?php

class Home_front extends Controller {


	function Home_front()
	{
		parent::Controller();
		echo $this->config->set_item('language','en');
		//$this->load->model('home_model');
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$this->id_idioma=modules::run('idioma/get_idioma_id_from_code',$this->session->userdata('idioma'));
		$this->lang->load('front');
	}
	
	/* 
	 * Funcciones del admin, con control de aceso */
	function index()
	{
		$data['main']='coleccion';
		
		$data['no_sidebar']=true;

		$data['main']=$this->lang->line('inicio');
		$data['sub']='/';
		$data['title']=$this->lang->line('inicio');
		//$data_content['breadcrumbs']=array('/',$this->lang->line('inicio'));
		$data_content = array();
		$where = array("tipo_receta"=>"mes");
		//$data_content['recetas_mes'] = modules::run('services/relations/get_all_orderby','receta',false,$where,'true','receta.creado');
		
		$order = 'RAND()';
		//$data_content['productos'] = modules::run('services/relations/get_all_orderby','producto',false,'','true',$order);
		$data['main_content']=$this->load->view('front/home',$data_content,true);
		$this->load->view('front/template',$data);
	}
	
	
	function promociones_home()
	{
		//echo "aqui va las promociones";
		$data['main']=$this->lang->line('promociones');
		$data_content['id_idioma']=$this->id_idioma;
		$data_content['breadcrumbs']=array('/'=>$this->lang->line('inicio'),$this->lang->line('promociones_url')=>$this->lang->line('promociones'));
		$data['main_content']=$this->load->view('front/promociones',$data_content,true);
		$this->load->view('front/template',$data);
	}
	
	function contacto($categoria='')
	{
		//echo "aqui va el contacto";
		if($categoria=='') {
			$this->contacto_home();
		} else if ($categoria == $this->lang->line('contacto_enviar_url')) {
			$this->contacto_enviar();
		}
		
		/*$data_content['id_idioma']=$this->id_idioma;
		$data_content['breadcrumbs']=array('/'=>$this->lang->line('inicio'),$this->lang->line('contacto_url')=>$this->lang->line('contacto'));
		$data['main_content']=$this->load->view('front/contacto',$data_content,true);
		$this->load->view('front/template',$data);*/
	}
	
	function internacional($ajax=false)
	{

		$data['main']=$this->lang->line('isabel_intl');
		$data['sub']=$this->lang->line('isabel_intl_url');
		$data['title']=$this->lang->line('isabel_intl');
		//$data_content['activa']=$this->lang->line('nutricion.proteinas_url');
		$data_content['breadcrumbs']=array('/'=>$this->lang->line('inicio'),$this->lang->line('isabel_intl_url')=>$this->lang->line('isabel_intl'));
		$data['main_content']=$this->load->view('front/internacional',$data_content,true);
		$this->load->view('front/template',$data);
	}
	
	function politica_privacidad($ajax=false)
	{

		$data['main']=$this->lang->line('politica_privacidad');
		$data['sub']=$this->lang->line('politica_privacidad_url');
		$data['title']=$this->lang->line('politica_privacidad');
		//$data_content['activa']=$this->lang->line('nutricion.proteinas_url');
		$data_content['breadcrumbs']=array('/'=>$this->lang->line('inicio'),$this->lang->line('politica_privacidad_url')=>$this->lang->line('politica_privacidad'));
		$data['main_content']=$this->load->view('front/politica_privacidad',$data_content,true);
		$this->load->view('front/template',$data);
	}
	
	function faqs_detalle($id='',$ajax=false)
	{
		//echo 'el id'.$id;
		$data['main']=$this->lang->line('faq');
		$data['sub']=$this->lang->line('faq_url');
		$data['title']=$this->lang->line('faq');
		$data_content['activa']=$this->lang->line('faq_url');
		$data_content['faq'] = (($this->lang->line('faq.t1.v'.$id)!='') ? $id : '1');
		$data_content['breadcrumbs'] = array(
			'/' => $this->lang->line('inicio'),
			'/'.$this->lang->line('faq_url')=>$this->lang->line('faq'),
			'/faqs/productos/'	=> 'Productos',
			//'/'.$this->lang->line('faq.t1.v'.$id.'.url') => $this->lang->line('faq.t1.v'.$id),
			''	=> 'Nombre de producto',
		);
		$data['main_content']=$this->load->view('front/faqs_detalle',$data_content,true);
		$this->load->view('front/template',$data);
	
	}
	
	function faqs_productos()
	{
		$data['main']=$this->lang->line('faq');
		$data['sub']=$this->lang->line('faq_url');
		$data['title']=$this->lang->line('faq');
		$data_content['activa']=$this->lang->line('faq_url');
		$data_content['breadcrumbs'] = array(
			'/' => $this->lang->line('inicio'),
			'/'.$this->lang->line('faq_url') => $this->lang->line('faq'),
			''	=> 'Productos'
		);
		//$data_content['menu_izquierda']=$this->load->view('front/menu_izquierda',$data_content,true);
		$data['main_content']=$this->load->view('front/faqs_productos',$data_content,true);
		$this->load->view('front/template',$data);
	}
	
	function faqs($categoria='', $id='', $ajax=false)
	{
		switch ($categoria) {
			case 'productos':
				if ($id) {
					$this->faqs_detalle($id);
				} else {
					$this->faqs_productos();
				}
				break;
			case 'albo':
				$data['main']=$this->lang->line('faq');
				$data['sub']=$this->lang->line('faq_url');
				$data['title']=$this->lang->line('faq');
				$data_content['activa']=$this->lang->line('faq_url');
				$data_content['breadcrumbs'] = array(
					'/' => $this->lang->line('inicio'),
					'/'.$this->lang->line('faq_url') => $this->lang->line('faq'),
				);
				//$data_content['menu_izquierda']=$this->load->view('front/menu_izquierda',$data_content,true);
				$data['main_content']=$this->load->view('front/faqs',$data_content,true);
				$this->load->view('front/template',$data);
				break;
			default:
				redirect('faqs/albo');
		}
	}
	
	function contacto_home()
	{
		//echo "aqui va el contacto";
		$data['main']=$this->lang->line('contacto');
		$data['sub']=$this->lang->line('contacto_url');
		$data['title']=$this->lang->line('contacto');
		$data_content['id_idioma']=$this->id_idioma;
		$data_content['breadcrumbs']=array('/'=>$this->lang->line('inicio'),$this->lang->line('contacto_url')=>$this->lang->line('contacto'));
		$data['main_content']=$this->load->view('front/contacto',$data_content,true);
		$this->load->view('front/template',$data);
	}
	
	function contacto_enviar()
	{
		//echo 'entro aqui enviar';
		$data['main'] = $this->lang->line('contacto');
		$data['sub'] = $this->lang->line('contacto_url');
		$data['title'] = $this->lang->line('contacto');
		
		$this->load->library('form_validation');
		//$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		$this->form_validation->set_error_delimiters('', '');
		$this->load->helper(array('form', 'url'));
				
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[2]');
		$this->form_validation->set_rules('email', 'Correo Electronico', 'trim|required|valid_email|min_length[3]');
		$this->form_validation->set_rules('tipo_mensaje', 'Tipo de Mensaje', 'trim|required|min_length[1]');
		$this->form_validation->set_rules('mensaje', 'Mensaje', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('provincia', 'Provincia', 'trim|required|min_length[1]');
		

		$this->form_validation->set_message('required', " class='error' ");
		$this->form_validation->set_message('min_length', " class='error' ");
		$this->form_validation->set_message('valid_email', " class='error' ");
	
        
        if (!$this->form_validation->run($this)) {
			// Mostrar pagina con errores
			
        	// FIXME: no entiendo qué es este código
			$data['active']='categoria';
			$data['sub']='crear';
			$data['title']='Editar idioma categoria';
			
			
			//echo "No se envia el correo";
			$data_content['breadcrumbs'] = array(
				'/' => $this->lang->line('inicio'),
				'/' . $this->lang->line('contacto_url') => $this->lang->line('contacto'),
			);
			$data['main_content'] = $this->load->view('front/contacto', $data_content, true);
			$this->load->view('front/template',$data);
			
		} else {
				//enviar correo electronico
				foreach(array_keys($_POST) as $k){
                    $form_data[$k]=$this->input->post($k);
                }
                
			 //echo '<pre>'.print_r($_POST,true).'</pre>';
			 
			 //Proceso de ENVIO DE CORREO ELECTRONICO
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			
			$this->email->from( $this->lang->line('contacto.email.noreply'), $this->lang->line('contacto.email.emisor') );
			
			// El destinatario del email es temporalmente Javier Pérez de Tecknosfera (en front_lang.php)
			// Debe ser un contacto del cliente
			$this->email->to($this->lang->line('contacto.email'));
			$this->email->bcc('gchemello@gmail.com');
			
			// Envío de copia de este email?
			if ($this->input->post('email_copia')) {
				$this->email->cc($form_data['email']);
			}
			//$correos = array('inaki.garcia@tecknosfera.com','laura.goicoechea@tecknosfera.com','gchemello@gmail.com');
			//$this->email->bcc($correos);
			//$this->email->bcc('inaki.garcia@tecknosfera.com','Iñaki');
			//$this->email->bcc('laura.goicoechea@tecknosfera.com','Laura');
			//$this->email->bcc('gchemello@gmail.com','Gerardo Chemello');
			//$this->email->bcc('javier.perez@tecknosfera.com','Javier Pérez');
			
			// Asunto del email
			$subject = $this->lang->line('contacto.email.subject').' '.$this->lang->line('contacto.form.tema.'.$form_data['tipo_mensaje']);
			$this->email->subject($subject);
			
			$data_usuario['url'] = $this->lang->line('url_albo');
			$data_usuario['tipo_mensaje'] = $this->lang->line('contacto.form.tema.' . $form_data['tipo_mensaje']);
			$data_usuario['mensaje'] = $form_data['mensaje'];
			$data_usuario['provincia'] = $form_data['provincia'];
			$data_usuario['nombre'] = $form_data['nombre'];
			$data_usuario['email'] = $form_data['email'];
			
			$this->email->message($this->load->view('front/emailing_contacto',$data_usuario,true));
			
			if ( !$this->email->send()) {
    			// Generate error
    			echo $this->email->print_debugger();
    			$data_content['breadcrumbs'] = array(
    				'/'=>$this->lang->line('inicio'),
    				$this->lang->line('contacto_url')=>$this->lang->line('contacto'),
    			);
				$data['main_content'] = $this->load->view('front/contacto_fail',$data_content,true);
				$this->load->view('front/template',$data);
			} else  {
				$data_content['breadcrumbs'] = array(
					'/'=>$this->lang->line('inicio'),
					$this->lang->line('contacto_url')=>$this->lang->line('contacto'),
				);
				$data['main_content'] = $this->load->view('front/contacto_ok',$data_content,true);
				$this->load->view('front/template',$data);	
			}
            

			
		}
		//echo "aqui va el contacto";
	//	$data_content['breadcrumbs']=array('/',$this->lang->line('inicio'),$this->lang->line('contacto_url')=>$this->lang->line('contacto'));
	//	$data['main_content']=$this->load->view('front/contacto',$data_content,true);
	//	$this->load->view('front/template',$data);
	}
	
	
	function correoRecov(){
			$this->load->model('usuarios/usuarios_model');
			return $this->usuarios_model->findEmail($this->input->post('recov_email'));		
	}
	
	function recuperar_OK(){
		$data['main']=$this->lang->line('recuperar_password');
		$data_content['id_idioma']=$this->id_idioma;
		$data_content['breadcrumbs']=array('/'=>$this->lang->line('inicio'),$this->lang->line('recuperar_password_url')=>$this->lang->line('recuperar_password'));
		$data['main_content']=$this->load->view('front/recuperar_OK',$data_content,true);
		$this->load->view('front/template',$data);
	}
	function recuperar_KO(){
			$data['main']=$this->lang->line('recuperar_password');
			$data_content['id_idioma']=$this->id_idioma;
			//$data_content['error_news'] = $this->lang->line('recuperar_password_ya_registro');
			$data_content['breadcrumbs']=array('/'=>$this->lang->line('inicio'),$this->lang->line('recuperar_password_url')=>$this->lang->line('recuperar_password'));
			$data['main_content']=$this->load->view('front/recuperar_KO',$data_content,true);
			$this->load->view('front/template',$data);	
	}
	
	function recuperar_password()
	{
		//echo "aqui va el contacto";
		$data['main']=$this->lang->line('recuperar_password');
		$data['sub']=$this->lang->line('recuperar_password_url');
		$data['title']=$this->lang->line('recuperar_password');
		
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		//$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		$this->form_validation->set_error_delimiters('<p>', '</p>');
		
				
		$this->form_validation->set_rules('recov_email', 'Correo Electrónico', 'trim|required|valid_email|min_length[5]|callback_correoRecov');
		
		$url = ($this->input->post('url') != '' ? $this->input->post('url') : '');
		//$this->form_validation->set_rules('email_copia', 'Copia a email', 'trim|required|min_length[5]');
		//$this->form_validation->set_rules('provincia', 'Provincia', 'trim|required|min_length[1]');
		$this->form_validation->set_message('required', "El campo %s es obligatorio");
		$this->form_validation->set_message('min_length', "Debe tener un minimo de 5 caracteres");
		$this->form_validation->set_message('valid_email', "Debe introducir un correo electrónica válido.");
		$this->form_validation->set_message('correoRecov', $this->lang->line('recuperar_no_existe'));
		
		if ($this->form_validation->run($this) == FALSE)
		{
			$this->recuperar_KO();
		}
		else
		{
			//enviar correo electronico
				foreach(array_keys($_POST) as $k){
                    $form_data2[$k]=$this->input->post($k);
                }
                
			 //echo '<pre>'.print_r($_POST,true).'</pre>';
			
			//$form_data['id_idioma']=$this->id_idioma;
			//$form_data['id_estado']='1';
			
			$this->load->model('usuarios/usuarios_model');
			$usuario=$this->usuarios_model->get_email($form_data2['recov_email']);
			
			$this->load->model('usuario/usuario_model');
			$contrasena = $this->usuarios_model->_gen_pass();
			//echo '<pre>Nuevo:'.$contrasena.'</pre>';
			//echo '<br><br><pre>'.print_r($usuario,true).'</pre>';
			
			//Password Nuevo
			$form_data['password']=sha1($contrasena);
			//$form_data['password']=sha1($contrasena);
			$form_data['id_usuario'] = $usuario['id_usuario'];
			
			$id=$this->usuario_model->update($form_data);
				
				
				//die();
			 //Proceso de ENVIO DE CORREO ELECTRONICO
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from($this->lang->line('email_isabel_recuperar'),$this->lang->line('nombre_emisor_recuperar'));
			$this->email->to($form_data2['recov_email']);
			$this->email->bcc('gchemello@gmail.com');
			//if($this->input->post('email_copia')!='') $this->email->cc($form_data['email']);
			//$this->email->bcc('inaki.garcia@tecknosfera.com','Iñaki García');		
			//$this->email->subject($this->lang->line('contacto.form.tema.'.$form_data['tipo_mensaje']));
			$this->email->subject($this->lang->line('email_subject_recuperar'));		
			$data_usuario['url'] = $this->lang->line('url_isabel');
			$data_usuario['mensaje'] = $contrasena;			
			$this->email->message($this->load->view('front/emailing_recuperar',$data_usuario,true));	
			//echo "Leggo hasta aca";		
			if ( !$this->email->send()) {  $this->recuperar_KO(); } // Error
			else {  $this->recuperar_OK(); } // Success
		}
		
	}
}

/* End of file home_front.php */
