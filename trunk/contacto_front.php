<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacto_front extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->lang->load('front', 'es');
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
	}

	function index()
	{
		$data['servicios']				= modules::run('servicio/servicio_front/get_services',$this->session->userdata('idioma'));
		$data['title']	= lang('front_title.contacto');
		$data['active'] = lang('front_menu.contacto');
		$data['a'] = rand(0,10);
		$data['b'] = rand(0,10);
		$data['resultado'] = $data['a'] + $data['b'];
		
		//breadcrumbs
		$data['breadcrumbs'] = array(
										lang('front_title.inicio') 		=> lang('front.inicio_url'),
										lang('front_title.contacto') 	=> lang('front.contacto_url')
									);
		
		$data['contenido_principal'] = $this->load->view('front/contacto', $data ,true);
		$this->load->view('front/template',$data);
	}
	
	
	
	function enviar_mensaje()
	{
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;

		
		//ESTABLECEMOS LAS REGLAS
		$this->form_validation->set_rules('nombre_completo',	lang('front.contacto_label1'),		'required|trim');
		$this->form_validation->set_rules('email',				lang('front.contacto_label2'),		'required|trim');
		$this->form_validation->set_rules('telefono',			lang('front.contacto_label5'),		'required|trim');
		$this->form_validation->set_rules('mensaje',			lang('front.contacto_label3'),		'required|trim');
		$this->form_validation->set_rules('captcha',			lang('front.contacto_label6'),		'required|trim|callback_verificar_captcha');
		//ESTABLECEMOS LOS MENSAJES A LAS REGLAS
		$this->form_validation->set_message('required', lang('front.contacto_required'));
		$this->form_validation->set_error_delimiters('<small class="error">', '</small>');
		
		if($this->form_validation->run($this) == TRUE)
		{
			
			//CONFIGURACION PARA EL ENVIO DEL CORREO ELECTRONICO
			$config['protocol'] 	= "sendmail";
			$config['smtp_host'] 	= "ssl://smtp.googlemail.com";
			$config['smtp_port'] 	= 465;
			$config['smtp_user']	= "hf.nsce@gmail.com";
			$config['smtp_pass']	= "20162504h";
			$config['mailtype'] 	= "html";
			$config['charset']		='utf-8';
			$config['newline']		="\r\n";
			$this->load->library('email', $config);
			
			//CONFIGURANDO LA DATA
			$form_data['nombre_completo']	= $this->input->post('nombre_completo');
			$form_data['email']	 			= $this->input->post('email');
			$form_data['telefono']	 		= $this->input->post('telefono');
			$form_data['mensaje']	 		= $this->input->post('mensaje');
			
			$this->email->initialize($config);
			$this->email->from($form_data['email'], $form_data['nombre_completo']);
			
			//OJO
			$this->email->to('hf.nsce@gmail.com', 'Sol y Luna');
			$this->email->cc('gchemello@gmail.com', 'Gerardo');
			
			$this->email->subject('Contacto');
			
			$data_usuario['nombre_completo'] 	= $form_data['nombre_completo'];
			$data_usuario['email'] 				= $form_data['email'];
			$data_usuario['telefono'] 			= $form_data['telefono'];
			$data_usuario['mensaje'] 			= $form_data['mensaje'];

			$this->email->message($this->load->view('correo', $data_usuario, true));
			
			//SI EL CORREO SE ENVIA
			if ($this->email->send())
			{
				//OBTENGO LOS SERVICIOS POR EL IDIOMA PRINCIPAL
				$data['servicios']					= modules::run('servicio/servicio_front/get_services',$this->session->userdata('idioma'));
				//echo '<pre>'.print_r($this->db->last_query(),true).'</pre>';
				
				//OBTENGO EL NUMERO DE SERVICIOS POR EL IDIOMA PRINCIPAL
				$data['numero_servicios']			= modules::run('servicio/servicio_front/num_services',$this->session->userdata('idioma'));
				
				//NUMERO DE SERVICIOS A MOSTRAR
				$data['numero_servicios_random']	= 2;
				
				//OBTENGO LOS BANNERS DE LA PAGINA 
				$data['banners'] 					= modules::run('front/get_banners');
				//$data['banners'] 					= $this->front_model->get_banners();
				
				//RANDOM DE LOS SERCVICIOS	
				$data['random']						= modules::run('front/servicios_random',$data['numero_servicios_random'],$data['numero_servicios']);
				
				$data['message_email'] 			= "exitoso";
				$data['title']					= lang('front_title.inicio');
				$data['contenido_principal'] 	= $this->load->view('front/home',$data,true);
				$this->load->view('front/template',$data);
				
				
			}
			else//SINO SE ENVIA
			{
				
				//OBTENGO LOS SERVICIOS POR EL IDIOMA PRINCIPAL
				$data['servicios']					= modules::run('servicio/servicio_front/get_services',$this->session->userdata('idioma'));
				//echo '<pre>'.print_r($this->db->last_query(),true).'</pre>';
				
				//OBTENGO EL NUMERO DE SERVICIOS POR EL IDIOMA PRINCIPAL
				$data['numero_servicios']			= modules::run('servicio/servicio_front/num_services',$this->session->userdata('idioma'));
				
				//NUMERO DE SERVICIOS A MOSTRAR
				$data['numero_servicios_random']	= 2;
				
				//OBTENGO LOS BANNERS DE LA PAGINA 
				$data['banners'] 					= modules::run('front/get_banners');
				//$data['banners'] 					= $this->front_model->get_banners();
				
				//RANDOM DE LOS SERCVICIOS	
				$data['random']						= modules::run('front/servicios_random',$data['numero_servicios_random'],$data['numero_servicios']);

				$data['message_email'] 			= "error";
				$data['title']					= lang('front_title.inicio');
				$data['contenido_principal'] 	= $this->load->view('front/home',$data,true);
				$this->load->view('front/template',$data);
			}
			 
		}
		else
		{
			$data['a'] = rand(0,10);
			$data['b'] = rand(0,10);
			$data['resultado'] = $data['a'] + $data['b'];
			
			$data['nombre_completo']	= $this->input->post('nombre_completo');
			$data['email']	 			= $this->input->post('email');
			$data['telefono']	 		= $this->input->post('telefono');
			$data['mensaje']	 		= $this->input->post('mensaje');
			$data['captcha']	 		= $this->input->post('captcha');

			$data['title'] 					= lang('front_title.contacto');
			$data['active'] 				= lang('front_menu.contacto');
			$data['contenido_principal'] 	= $this->load->view('front/contacto',$data,true);
			$this->load->view('front/template',$data);
		}
	}

	function verificar_captcha()
	{
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		
		if($this->input->post('resultado_captcha') == $this->input->post('captcha'))
			return true;
		else
		{
			//$this->form_validation->set_message('captcha', 'El campo %s es incorrecto.');
			return FALSE;
		}
	}
}
