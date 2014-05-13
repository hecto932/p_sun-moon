<?php

class Idioma extends MX_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->model('idioma_model');

	}
	function index()
	{
		
	}
	function get_idioma($id){
		$this->idioma_model->get_from_id($id);
	}
	function get_idioma_id_from_code( $code, $ajax = false ) {
		$idioma = $this->idioma_model->get_from_code( $code );
		if ($ajax) {
			return $idioma->id_idioma;
		} else {
			echo $idioma->id_idioma;
		}
	}
	function get_all(){
		echo json_encode($this->idioma_model->get_all());
	}
	function set_idioma($code = 'es')
	{
		//SI CODE ES VACIO Y EL IDIOMA QUE VIENE POR DEFECTO ES DIFERENTE AL DEL CONFIG
		if ($code != '' && $code != $this->config->item('language'))
		{
			$this->config->set_item('language', $code);//CAMBIO EL IDIOMA DEL CONFIG
		}
		$this->session->set_userdata('idioma',$code); //adicional por hector en 30/10/2013 para sol y luna
		$this->session->set_userdata('id_idioma',$this->idioma_model->get_id($code));//AGREGADO POR HECTOR
	}
	function cambiar_post($ajax=false){
		$code=$this->input->post('idioma');
		$this->cambiar($code,$ajax);
	}
	function cambiar($code='es',$ajax=false){
		
		//echo $this->config->item('language'); die();
		//echo $this->session->userdata('idioma'); die();
		if ($code!=$this->config->item('language') || ($code != $this->session->userdata('idioma'))){
			
			$this->config->set_item('language', $code);
			$this->session->set_userdata('idioma',$code);
			if ($ajax==true)
				echo '[{result:true}]';
			else
				//echo '<pre>'.print_r($this->session->userdata,true).'</pre>';
				redirect($this->session->userdata('back'));
		}else{
			if ($ajax==true)
				echo '[{result:false}]';
			else
				//echo '<pre>'.print_r($this->session->userdata,true).'</pre>';
				redirect($this->session->userdata('back'));
		}
		
	}
	
	function cambiar_idioma($code='es',$ajax=false)
	{
		if ($code != $this->config->item('language') || ($code != $this->session->userdata('idioma')) )
		{
			$this->config->set_item('language', $code);
			$this->session->set_userdata('idioma',$code);
			
			if($ajax == true)
				echo '[{result:true}]';
			else
				//echo '<pre>'.print_r($this->session->userdata,true).'</pre>';
				redirect($_SERVER['HTTP_REFERER']);
		}
		else
		{
			if ($ajax == true)
				echo '[{result:false}]';
			else
				//echo '<pre>'.print_r($this->session->userdata,true).'</pre>';
				redirect($_SERVER['HTTP_REFERER']);
		}
		
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
