<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * 
 * Controlador de front/productos
 * 
 * @author Steve
 */
class Error extends MX_Controller {

	/**
	 * 
	 * Constructor de la clase
	 * 
	 */
	public function __construct()
	{
		
		parent::__construct();
		
		if ($this->session->userdata('idioma') == '')
			$this->session->set_userdata('idioma','en');
		
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		
		$this->id_idioma = modules::run('idioma/get_idioma_id_from_code',$this->session->userdata('idioma'));
		
		$this->lang->load('front');
		
	}

	/**
	 * 
	 * Página principal
	 * 
	 */
	public function index()
	{
		$data['error']=1;
		$data['title']=$this->lang->line('productos.meta.title').' | '.$this->lang->line('inicio.meta.title');
		$data['meta_descripcion']=$this->lang->line('productos.meta.description').' | '.$this->lang->line('inicio.meta.description');
		$data['meta_keywords']=$this->lang->line('productos.meta.keywords').' | '.$this->lang->line('inicio.meta.keywords');
		
		$data['contenido_principal'] = $this->load->view('error', $data);
		//$this->load->view('front/template', $data);

		
		
	}
}
/* End of file exposicion_front.php */