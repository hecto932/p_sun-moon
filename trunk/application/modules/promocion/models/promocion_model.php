<?php

class Promocion_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('idioma/idioma_model','idioma_model');
		$this->idioma=idioma_model::get_from_code($this->session->userdata('idioma'));
	}
	function create($data)
	{
		$this->db->insert('promocion',$data);
		return $this->db->insert_id();
	}
	function read($id,$id_detalle_promocion='',$idioma='')
	{
		$this->db->select('promocion.*,detalle_promocion.*,promocion.id_promocion as id_promocion');
		//$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		if ($id_detalle_promocion!='') $this->db->where('detalle_promocion.id_detalle_promocion',$id_detalle_promocion);
		$this->db->join('detalle_promocion','promocion.id_promocion=detalle_promocion.id_promocion','left');
		//$this->db->where('detalle_promocion.id_idioma',$idioma);
		$this->db->where('promocion.id_promocion',$id);
		$this->db->group_by('promocion.id_promocion');
		$q=$this->db->get('promocion');
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
	function detalles($id_promocion){
		$this->db->join('detalle_promocion','promocion.id_promocion=detalle_promocion.id_promocion');
		//$this->db->where('detalle_promocion.id_idioma',$idioma);
		$this->db->where('promocion.id_promocion',$id_promocion);
		//$this->db->group_by('promocion.id_promocion');
		$q=$this->db->get('promocion');
		return $q->result();
	}
	function get_all($idioma=''){
		$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		$this->db->join('detalle_promocion','promocion.id_promocion=detalle_promocion.id_promocion');
		$this->db->where('detalle_promocion.id_idioma',$idioma);
		$q=$this->db->get('promocion');
		return $q->result();
	}
	function get_list($f='promocion.id_promocion',$v=1,$group=false){
		
		$this->db->join('detalle_promocion','promocion.id_promocion=detalle_promocion.id_promocion');
		$this->db->where($f,$v);
		if ($group) $this->db->group_by('promocion.id_promocion');
		$q=$this->db->get('promocion');
		return $q->result();
	}
	function get_page($start=0,$count=10,$order_field='promocion.id_promocion',$order_dir='desc',$terminos_busqueda=array()){
		switch ($order_field) {
			case 'id_promocion';
				$order_field='promocion.id_promocion';
			break;
			default :
				$order_field=$order_field;
			break;
		}
		
		
		$this->db->select('promocion.*,detalle_promocion.*,promocion.id_promocion as id_promocion');
		$this->db->join('detalle_promocion','promocion.id_promocion=detalle_promocion.id_promocion','left');
		//$this->db->join('categoria','promocion.id_categoria=categoria.id_categoria');
		//$this->db->join('detalle_categoria','promocion.id_categoria=detalle_categoria.id_categoria');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='promocion.id_producto' && $value!=''){
					$this->db->where($field,$value);
                }elseif ($field=='texto' && $value!=''){
                    //$this->db->join('detalle_promocion','detalle_promocion.id_promocion=promocion.id_promocion');
                    $this->db->where("(detalle_promocion.descripcion_breve LIKE '%$value%' OR detalle_promocion.nombre LIKE '%$value%' OR detalle_promocion.descripcion_ampliada LIKE '%$value%')");

				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		$this->db->group_by('promocion.id_promocion');
		$this->db->order_by($order_field,$order_dir);
		$q=$this->db->get('promocion',$count,$start);
		//echo $this->db->last_query();
		return $q->result();
	}
	function count_all($terminos_busqueda=array()){
		$this->db->select('count(*) as num_promociones');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='promocion.id_promocion' && $value!=''){
					$this->db->where($field,$value);
				
                }elseif ($field=='texto' && $value!=''){
                    $this->db->join('detalle_promocion','detalle_promocion.id_promocion=promocion.id_promocion');
					$this->db->where("(detalle_promocion.descripcion_breve LIKE '%$value%' OR detalle_promocion.nombre LIKE '%$value%' OR detalle_promocion.descripcion_ampliada LIKE '%$value%')");
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		//$this->db->group_by('promocion.id_promocion');
		$q=$this->db->get('promocion');
		//echo $this->db->last_query();
		$ret=$q->row();
		return $ret->num_promociones;
	}
	function update($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		if (isset($data['id_promocion'])){
			$promocion=$this->read($data['id_promocion']);
		}
		//echo '<pre>'.print_r($promocion,true).'</pre>';
		if (!empty($promocion)){
			$this->db->where('id_promocion',$data['id_promocion']);
			$this->db->update('promocion',$data);
			$id=$data['id_promocion'];
		}else{
			$data['creado']=date('Y-m-d H:i:s');
			$this->db->insert('promocion',$data);
			$id=$this->db->insert_id();
		}
		
		return $id;
	}
	function update_idioma($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		$d=array('id_idioma'=>$data['id_idioma'],'id_promocion'=>$data['id_promocion']);
		if (isset($data['id_detalle_promocion']) || $ob=$this->exists('detalle_promocion',$d)){
			if (isset($data['id_detalle_promocion'])){
				$this->db->where('id_detalle_promocion',$data['id_detalle_promocion']);
				$id=$data['id_detalle_promocion'];
			}else{
				$this->db->where($d);
				$id=$ob->id_detalle_promocion;
			}
			$this->db->update('detalle_promocion',$data);
			
		}else{
			$this->db->insert('detalle_promocion',$data);
			$id=$this->db->insert_id();
		}
		return $id;
	}
	function delete($id){
		/*
		$imagenes=modules::run('services/relations/get_rel','promocion','imagen',$id,'true');
		foreach(json_decode($imagenes) as $img){
			if (is_file(FCPATH.'assets/img/temp/'.$img->fichero)) unlink( FCPATH.'assets/img/temp/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/med/'.$img->fichero)) unlink( FCPATH.'assets/img/med/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/thumb/'.$img->fichero)) unlink( FCPATH.'assets/img/thumb/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/large/'.$img->fichero)) unlink( FCPATH.'assets/img/large/'.$img->fichero);
		}
		if ($this->db->delete('promocion', array('id_promocion' => $id)))
			return true;
		else return false;
		*/
		$data['id_estado']=3;
		$this->db->where('id_promocion',$id);
		return $this->db->update('promocion',$data);
	}
	function eliminar_idioma($id){
		if ($this->db->delete('detalle_promocion', array('id_detalle_promocion' => $id)))
			return true;
		else return false;
	}
	function exists($table,$key=array()){
		
		$this->db->where($key);
		$q=$this->db->get($table);
		if ($q->num_rows()>=1) return $q->row();
		else return false;
	}
}
