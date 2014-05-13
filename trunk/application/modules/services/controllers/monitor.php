<?php

class Monitor extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('monitor_model');
	}
	
	function index()
	{
		
	}
	function add($tipo_contenido,$id_contenido,$id_usuario,$tipo_accion){
		$data['tipo_contenido']=$tipo_contenido;
		$data['id_contenido']=$id_contenido;
		$data['id_usuario']=$id_usuario;
		$data['tipo_accion']=$tipo_accion;
		$id=$this->monitor_model->insert('monitor',$data);
	}
	
}

/* End of file monitor.php */

