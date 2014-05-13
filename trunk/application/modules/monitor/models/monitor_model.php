<?php

class Monitor_model extends CI_Model {
	
	function __construct(){
		parent::__construct();	
		$this->load->model('idioma/idioma_model','idioma_model');
		$this->idioma=idioma_model::get_from_code($this->session->userdata('idioma'));
	}

	function read($id,$id_detalle_monitor='',$idioma='')
	{
		$this->db->select('monitor.*');
		//$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		//$this->db->where('detalle_monitor.id_idioma',$idioma);
		$this->db->where('monitor.id_monitor',$id);
		$q=$this->db->get('monitor');
		//echo $this->db->last_query();
		if ($q->num_rows()==1)
			return $q->row();
		else
			return $q->result();
	}
	function get($tabla,$id=''){
		if ($id!='') $this->db->where('id_'.$tabla,$id);
		$q=$this->db->get($tabla);
		if ($q->num_rows()==1)
			return $q->row();
		else
			return $q->result();
	}

	function get_all($idioma=''){
		$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		
		$this->db->where('monitor.id_idioma',$idioma);
		$q=$this->db->get('monitor');
		return $q->result();
	}
	function get_list($f='monitor.id_monitor',$v=1,$group=false){
		$this->db->where($f,$v);
		if ($group) $this->db->group_by('monitor.id_monitor');
		$q=$this->db->get('monitor');
		return $q->result();
	}
	function get_page($start=0,$count=10,$order_field='monitor.id_monitor',$order_dir='desc',$terminos_busqueda=array()){
		switch ($order_field) {
			case 'id_monitor';
				$order_field='monitor.id_monitor';
			break;
			default :
				$order_field=$order_field;
			break;
		}
		
		
		$this->db->select('monitor.*');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='fecha_desde'){
					$this->db->where("fecha >=",$value);
				}elseif ($field=='fecha_hasta'){
					$this->db->where("fecha <=",$value);
				//elseif field=='rol'
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		$this->db->group_by('monitor.id_monitor');
		$this->db->order_by($order_field,$order_dir);
		$q=$this->db->get('monitor',$count,$start);
		//echo $this->db->last_query();
		return $q->result();
	}
	function count_all($terminos_busqueda=array()){
		$this->db->select('count(*) as num_monitor');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='fecha_desde'){
					$this->db->where("fecha >=",$value);
				}elseif ($field=='fecha_hasta'){
					$this->db->where("fecha <=",$value);
				//elseif field=='rol'
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		//$this->db->group_by('monitor.id_monitor');
		$q=$this->db->get('monitor');
		//echo $this->db->last_query();
		$ret=$q->row();
		return $ret->num_monitor;
	}

	function exists($table,$key=array()){
		
		$this->db->where($key);
		$q=$this->db->get($table);
		if ($q->num_rows()>=1) return $q->row();
		else return false;
	}
}
