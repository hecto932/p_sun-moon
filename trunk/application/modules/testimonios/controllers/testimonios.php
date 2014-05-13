<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testimonios extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->lang->load('front', 'es');
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->load->model('testimonios/testimonio_model');
		$this->load->library('pagination');
	}
	
	function index()
	{
		$this->page($num = "0");
	}
	
	function page($num = "")
	{
		//CONFIGURACION PREVIA PARA LA PAGINACION
		$config['base_url'] 		= base_url().'testimonios/page/';
		$config['total_rows'] 		= $this->testimonio_model->num_testimonios('creado');
		$config['per_page']			= 5;
		$config['num_links']		= 9;
		$config['uri_segment'] 		= 3;
		
		$config['first_link'] 		= lang('front.primero');
        $config['last_link'] 		= lang('front.ultimo');
        $config['next_link'] 		= lang('front.siguiente');
        $config['prev_link'] 		= lang('front.anterior');
		
		$config['cur_tag_open']		= '<strong class="current"><span>';
		$config['cur_tag_close']	= '</span></strong>';
		
		$config['full_tag_open']	= '<span>';
		$config['full_tag_close']	= '</span>';
		
		$this->pagination->initialize($config);
		
		
		
		$data['a'] 						= rand(0,10);
		$data['b'] 						= rand(0,10);
		$data['resultado'] 				= $data['a'] + $data['b'];
		$data['comentarios'] 			= $this->testimonio_model->get_testimonios_perpage('creado', $config['per_page'], $num);
		$data['paginacion'] 			= $this->pagination->create_links();
		
		$data['title'] 					= lang('front_title.testimonios');
		$data['active'] 				= lang('front_menu.testimonios');
		
		//breadcrumbs
		$data['breadcrumbs'] = array(
										lang('front_menu.inicio') 		=> lang('front.inicio_url'),
										lang('front_menu.testimonios') 	=> lang('front.testimonios_url')
									);
		
		if(isset($_POST['mensaje_comentario_guardado']) && !empty($_POST['mensaje_comentario_guardado'])) 
			$data['mensaje_comentario_guardado'] = $_POST['mensaje_comentario_guardado'];
		
		$data['contenido_principal'] = $this->load->view('testimonios',$data,true);
		$this->load->view('front/template',$data);
	}
	
	function comentar()
	{
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		
		//breadcrumbs
		$data['breadcrumbs'] = array(
										lang('front_menu.inicio') 		=> lang('front.inicio_url'),
										lang('front_menu.testimonios') 	=> lang('front.testimonios_url')
									);
		
		//ESTABLECEMOS LAS REGLAS
		$this->form_validation->set_rules('nombre_completo',	lang('front.testimonios_nombre'),		'required|trim');
		$this->form_validation->set_rules('email',				lang('front.testimonios_email'),		'required|trim');
		$this->form_validation->set_rules('mensaje',			lang('front.testimonios_comentario'),	'required|trim');
		$this->form_validation->set_rules('captcha',			lang('front.testimonios_captcha'),		'required|trim|callback_verificar_captcha');
		
		//ESTABLECEMOS LOS MENSAJES A LAS REGLAS
		$this->form_validation->set_message('required', lang('front.testimonios_required'));
		$this->form_validation->set_message('verificar_captcha'); 
		$this->form_validation->set_error_delimiters('<small class="error">', '</small>');
		
		if($this->form_validation->run($this) == TRUE)
		{
			$data_insert['nombre'] 		= $this->input->post('nombre_completo');
			$data_insert['email']	 	= $this->input->post('email');
			$data_insert['comentario']	= $this->input->post('mensaje');
			$data_insert['rating']	 	= $this->input->post('score');
			
			$this->testimonio_model->insert_testimonio($data_insert);
			$_POST['mensaje_comentario_guardado'] = lang('comentario_guardado');
			$this->index();
		}
		else
		{
			$data['a'] 						= rand(0,10);
			$data['b'] 						= rand(0,10);
			$data['resultado'] 				= $data['a'] + $data['b'];
			$data['nombre_completo']	= $this->input->post('nombre_completo');
			$data['email']	 			= $this->input->post('email');
			$data['score']	 			= $this->input->post('score');
			$data['comentario']	 		= $this->input->post('mensaje');
			$data['captcha']	 		= $this->input->post('captcha');

			$data['title'] 	= lang('front_title.contacto');
			$data['active'] = lang('front_menu.testimonios');
			$data['contenido_principal'] = $this->load->view('testimonios',$data,true);
			$this->load->view('front/template',$data);
		}
	}
	
	function facebook()
	{
		$data['title'] 		= lang('front_title.testimonios');
		$data['active'] 	= lang('front_menu.testimonios');
		
		//breadcrumbs
		$data['breadcrumbs'] = array(
										lang('front_title.inicio') 		=> lang('front.inicio_url'),
										lang('front_title.testimonios') 	=> lang('front.testimonios_url')
									);
		
		$data['contenido_principal'] = $this->load->view('facebook',$data,true);
		$this->load->view('front/template',$data);
	}
	
	function verificar_captcha()
	{		
		return $this->input->post('resultado_captcha') == $this->input->post('captcha');
	}
}
