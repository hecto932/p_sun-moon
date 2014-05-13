<?php 

class Portafolio_front extends MX_Controller {


	function __construct()
	{
		parent::__construct();
		//$this->load->model('producto_model');
		if ($this->session->userdata('idioma')=='') $this->session->set_userdata('idioma','en');
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$this->id_idioma=modules::run('idioma/get_idioma_id_from_code',$this->session->userdata('idioma'));
		$this->lang->load('front');
	}

	function index($function='nosotros',$id='')
	{
		$this->portafolio();
	}
	


	function portafolio($ajax=false)
	{
		

		$data['main']=$this->lang->line('empresa');
		$data['sub']=$this->lang->line('empresa_url');
		$data['title'] = $this->lang->line('portafolio.meta.title').' | '.$this->lang->line('inicio.meta.title');
		$data['meta_descripcion'] = $this->lang->line('portafolio.meta.description').' | '.$this->lang->line('inicio.meta.description');
		$data['meta_keywords'] = $this->lang->line('portafolio.meta.keywords').' | '.$this->lang->line('inicio.meta.keywords');
		$data['contenido_principal']=$this->load->view('portafolio_listado', $data, true);
		
		$this->load->view('front/template',$data);
	}
	

}
/* End of file exposicion_front.php */