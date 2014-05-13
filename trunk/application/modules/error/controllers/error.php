<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

class Error extends MX_Controller {

	public function __construct()
	{
		
		parent::__construct();
		
		if ($this->session->userdata('idioma'))
			modules::run('idioma/idioma/set_idioma', $this->session->userdata('idioma'));	
		else
			modules::run('idioma/idioma/set_idioma', 'es');
		$this->lang->load('front');
		
	}
	
	function index()
	{
		//TITULO DE PAGINA
		$data['title']					= lang('front.error_title');
		
		//CARGO EL CONTENIDO PRINCIPAL EN LA PAGINA 
		$data['contenido_principal'] 	= $this->load->view('error',$data,true);
		
		//CARGO EL CONTENIDO PRINCIPAL CON LA AYUDA DEL TEMPLATE
		$this->load->view('front/template',$data);
	}
}

?>