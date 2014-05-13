<?php

class Front_model extends CI_Model{


	function __construct()
	{
		parent::__construct();
	}
	
	function get_banners()
	{
		$data = array(
			"id_estado" => 1
		);
		
		/*
		 * select m.fichero 
			from banner b
			join rel_banner_multimedia r on b.id_banner = r.id_banner
			join multimedia m on m.id_multimedia = r.id_multimedia
		 * 
		 */
		
		$this->db->select('*');
		$this->db->from('banner b');
		$this->db->join('rel_banner_multimedia r', 'b.id_banner = r.id_banner');
		$this->db->join('multimedia m', 'm.id_multimedia = r.id_multimedia');
			
		$resultado = $this->db->get()->result();
		return $resultado;
	}
}