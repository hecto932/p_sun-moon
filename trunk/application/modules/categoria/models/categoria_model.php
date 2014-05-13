<?php

class Categoria_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('idioma/idioma_model','idioma_model');
		$this->idioma=idioma_model::get_from_code($this->session->userdata('idioma'));
	}
	function createcategoria($data)
	{
		$this->db->insert('categoria',$data);
		return $this->db->insert_id();
	}
	function createdetalle_categoria($data)
	{
		$this->db->insert('detalle_categoria',$data);
		return $this->db->insert_id();
	}
	function read($id,$id_detalle_categoria='',$idioma='')
	{
		$this->db->select('categoria.*,detalle_categoria.*,categoria.id_categoria as id_categoria');
		
		if ($id_detalle_categoria!='') $this->db->where('detalle_categoria.id_detalle_categoria',$id_detalle_categoria);
		$this->db->join('detalle_categoria', 'detalle_categoria.id_categoria = categoria.id_categoria','left');
		$this->db->where('categoria.id_categoria',$id);
		$this->db->group_by('categoria.id_categoria');
		$q=$this->db->get('categoria');

		//echo $this->db->last_query();
		if ($q->num_rows()==1){
		 	//$q->row();
			//print_r($q);
			//die();
			return $q->row();
			}else{
			// $q->result();
			//print_r($q);
			//die();
			return $q->result();
			}
	}
	function get($tabla,$id=''){
		if ($id!='') $this->db->where('id_'.$tabla,$id);
		$q=$this->db->get($tabla);
		if ($q->num_rows()==1)
			return $q->row();
		else
			return $q->result();
	}

	function detalles($id_categoria){
		$this->db->join('detalle_categoria','categoria.id_categoria=detalle_categoria.id_categoria');
		//$this->db->where('detalle_coleccion.id_idioma',$idioma);
		$this->db->where('categoria.id_categoria',$id_categoria);
		//$this->db->group_by('coleccion.id_coleccion');
		$q=$this->db->get('categoria');
		return $q->result();
	}
	function get_all($idioma=''){
		$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		$this->db->join('detalle_categoria','categoria.id_categoria=detalle_categoria.id_categoria');
		$this->db->where('detalle_categoria.id_idioma',$idioma);
		$q=$this->db->get('categoria');
		return $q->result();
	}
	function get_page($start=0,$count=10,$order_field='categoria.id_categoria',$order_dir='desc',$terminos_busqueda=array()){
		switch ($order_field) {
			case 'id_categoria';
				$order_field='categoria.id_categoria';
			break;
			case 'nombre';
				$order_field='detalle_categoria.nombre';
			break;
			case 'descripcion';
				$order_field='detalle_categoria.descripcion';
			break;
			case 'id_estado';
				$order_field='id_estado';
			break;
			default :
				$order_field=$order_field;
			break;
		}
		
		
		$this->db->select('categoria.*,detalle_categoria.*,categoria.id_categoria as id_categoria',false);
		$this->db->join('detalle_categoria', 'detalle_categoria.id_categoria = categoria.id_categoria','left');
		
		
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='categoria.id_categoria' && $value!=''){
					$this->db->where($field,$value);
				}elseif ($field=='descripcion_categoria.nombre' && $value!=''){
					$this->db->like($field,$value);					
				}elseif ($field=='descripcion_categoria.descripcion' && $value!=''){
					$this->db->like($field,$value);
				}elseif ($field=='categoria.id_estado' && $value!=''){
					$this->db->like($field,$value);
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		$this->db->group_by('categoria.id_categoria');
		$this->db->order_by($order_field,$order_dir);
		$q=$this->db->get('categoria',$count,$start);
		//echo $this->db->last_query();
		return $q->result();
	}
	function count_all($terminos_busqueda=array()){
		$this->db->select('count(*) as num_categorias');

		$this->db->join('detalle_categoria', 'detalle_categoria.id_categoria = categoria.id_categoria');
				
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='categoria.id_categoria' && $value!=''){
					$this->db->where($field,$value);
				}elseif ($field=='descripcion_categoria.nombre' && $value!=''){
					$this->db->like($field,$value);					
				}elseif ($field=='descripcion_categoria.descripcion' && $value!=''){
					$this->db->like($field,$value);
				}elseif ($field=='categoria.id_estado' && $value!=''){
					$this->db->like($field,$value);
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		//$this->db->group_by('categoria.id_categoria');
		$q=$this->db->get('categoria');

		$ret=$q->row();
		return $ret->num_categorias;
	}
	function update($data)
	{
		if (isset($data['id_categoria']) && $data['id_categoria']!='')
			$categoria=$this->read($data['id_categoria']);
		else $categoria=array();
		
		if (!empty($categoria)){
			$this->db->where('id_categoria',$data['id_categoria']);
			$this->db->update('categoria',$data);
			$id=$data['id_categoria'];
		}else{
			$this->db->insert('categoria',$data);
			$id=$this->db->insert_id();
		}
		return $id;
	}
	function updatedetalle_categoria($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		$categoria=$this->read($data['id_categoria']);
		//echo '<pre>'.print_r($categoria,true).'</pre>';
		if (!empty($categoria)){
			$this->db->where('id_categoria',$data['id_categoria']);
			$this->db->update('detalle_categoria',$data);
			$id=$data['id_detalle_categoria'];
		}else{
			$this->db->insert('detalle_categoria',$data);
			$id=$this->db->insert_id();
		}
		
		return $id;
	}
	function update_idioma($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		$d=array('id_idioma'=>$data['id_idioma'],'id_categoria'=>$data['id_categoria']);
		if (isset($data['id_detalle_categoria']) || $ob=$this->exists('detalle_categoria',$d)){
			if (isset($data['id_detalle_categoria'])){
				$this->db->where('id_detalle_categoria',$data['id_detalle_categoria']);
				$id=$data['id_detalle_categoria'];
			}else{
				$this->db->where($d);
				$id=$ob->id_detalle_categoria;
			}
			$this->db->update('detalle_categoria',$data);
			
		}else{
			$this->db->insert('detalle_categoria',$data);
			$id=$this->db->insert_id();
		}
		return $id;
	}
	function delete($id){

	$data = array(
               'id_estado' => '3',
            );
		$this->db->where('id_categoria',$id);
		$this->db->update('categoria',$data);
	return true;
	}
	function eliminar_idioma($id){
		if ($this->db->delete('detalle_categoria', array('id_detalle_categoria' => $id)))
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

