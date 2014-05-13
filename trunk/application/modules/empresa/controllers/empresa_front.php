<?php 

class Empresa_front extends MX_Controller {


	function __construct()
	{
		parent::__construct();
		$this->lang->load('front', 'es');
	}
	
	/*
	 * Pagina de nosotros
	 * 
	 * */
	function index()
	{
		$this->nosotros();
	}
	
	/*
	 * Pagina de nosotros
	 * 
	 * */
	function nosotros()
	{
		$data['title'] 	= lang('front_title.nosotros');
		$data['active'] = lang('front_menu.nosotros');
		
		//breadcrumbs
		$data['breadcrumbs'] = array(
										lang('front_menu.inicio') 		=> lang('front.inicio_url'),
										lang('front_menu.nosotros') 	=> lang('front.nosotros_url')
									);
		
		$data['contenido_principal'] = $this->load->view('nosotros',$data,true);
		$this->load->view('front/template',$data);
	}

}
/* End of file exposicion_front.php */