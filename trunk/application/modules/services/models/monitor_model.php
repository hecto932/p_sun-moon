<?php
class Monitor_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('idioma/idioma_model','idioma_model');
		$this->idioma=idioma_model::get_from_code($this->session->userdata('idioma'));
	}
	
	function insert($table,$data){
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	

}
