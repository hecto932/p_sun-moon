<?php

class Producto_model extends CI_Model {
	
	function __construct(){
		parent::__construct();	
		$this->load->model('idioma/idioma_model','idioma_model');
		$this->idioma=idioma_model::get_from_code($this->session->userdata('idioma'));
	}
	function create($data)
	{
		$this->db->insert('producto',$data);
		return $this->db->insert_id();
	}
	function read($id,$id_detalle_producto='',$idioma='')
	{
		$this->db->select('categoria.id_tipo_cat, producto.*,detalle_producto.*,producto.id_producto as id_producto');
		//$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		if ($id_detalle_producto!='') $this->db->where('detalle_producto.id_detalle_producto',$id_detalle_producto);
		$this->db->join('detalle_producto','producto.id_producto=detalle_producto.id_producto','left');
		$this->db->join('categoria','producto.id_categoria=categoria.id_categoria');
		//$this->db->where('detalle_producto.id_idioma',$idioma);
		$this->db->where('producto.id_producto',$id);
		$this->db->group_by('producto.id_producto');
		$q=$this->db->get('producto');
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
	function detalles($id_producto){
		$this->db->join('detalle_producto','producto.id_producto=detalle_producto.id_producto');
		//$this->db->where('detalle_producto.id_idioma',$idioma);
		$this->db->where('producto.id_producto',$id_producto);
		//$this->db->group_by('producto.id_producto');
		$q=$this->db->get('producto');
		return $q->result();
	}
	function get_all($idioma=''){
		$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		$this->db->join('detalle_producto','producto.id_producto=detalle_producto.id_producto');
		$this->db->where('detalle_producto.id_idioma',$idioma);
		$q=$this->db->get('producto');
		return $q->result();
	}
	function get_list($f='producto.id_producto',$v=1,$group=false){
		
		$this->db->join('detalle_producto','producto.id_producto=detalle_producto.id_producto');
		$this->db->where($f,$v);
		if ($group) $this->db->group_by('producto.id_producto');
		$q=$this->db->get('producto');
		return $q->result();
	}
	function get_page($start=0,$count=10,$order_field='producto.id_producto',$order_dir='desc',$terminos_busqueda=array()){
		switch ($order_field) {
			case 'id_producto';
				$order_field='producto.id_producto';
			break;
			default :
				$order_field=$order_field;
			break;
		}
		
		
		$this->db->select('producto.*,detalle_producto.*,detalle_categoria.nombre as nombre_categoria,detalle_categoria.descripcion_breve as descripcion_categoria,producto.id_producto as id_producto');
		$this->db->join('detalle_producto','producto.id_producto=detalle_producto.id_producto','left');
		$this->db->join('categoria','producto.id_categoria=categoria.id_categoria');
		$this->db->join('detalle_categoria','producto.id_categoria=detalle_categoria.id_categoria','left');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='fecha_desde' && $value!=''){
					$this->db->where("concat(ano,'-',mes,'-',dia) >=",$value);
				}elseif ($field=='fecha_hasta' && $value!=''){
					$this->db->where("concat(ano,'-',mes,'-',dia) <=",$value);
				}elseif ($field=='producto.id_categoria' && $value!=''){
					$this->db->where($field,$value);
				}elseif ($field=='producto.id_estado' && $value!=''){
					$this->db->where($field,$value);
				}elseif ($field=='tag' && $value!=''){
					$this->db->join('rel_detalle_producto_tag','rel_detalle_producto_tag.id_detalle_producto=detalle_producto.id_detalle_producto');
					$this->db->join('tag','tag.id_tag=rel_detalle_producto_tag.id_tag');
					$this->db->like($field,$value);
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		$this->db->group_by('producto.id_producto');
		$this->db->order_by($order_field,$order_dir);
		$q=$this->db->get('producto',$count,$start);
		
		return $q->result();
	}
	function count_all($terminos_busqueda=array()){
		$this->db->select('count(*) as num_productos');
		
		//TO-DO : Anadir where para terminos de busqueda
		if (!empty($terminos_busqueda)){
			$this->db->join('detalle_producto','producto.id_producto=detalle_producto.id_producto','left');
			$this->db->join('categoria','producto.id_categoria=categoria.id_categoria');
			$this->db->join('detalle_categoria','producto.id_categoria=detalle_categoria.id_categoria','left');

			foreach($terminos_busqueda as $field=>$value){
				if ($field=='fecha_desde'){
					$this->db->where("concat(ano,'-',mes,'-',dia) >=",$value);
				}elseif ($field=='fecha_hasta'){
					$this->db->where("concat(ano,'-',mes,'-',dia) <=",$value);
				}elseif ($field=='producto.id_categoria' && $value!=''){
					$this->db->where($field,$value);
				}elseif ($field=='producto.id_estado' && $value!=''){
					$this->db->where($field,$value);
				}elseif ($field=='tag' && $value!=''){
					$this->db->join('rel_detalle_producto_tag','rel_detalle_producto_tag.id_detalle_producto=detalle_producto.id_detalle_producto');
					$this->db->join('tag','tag.id_tag=rel_detalle_producto_tag.id_tag');
					$this->db->like($field,$value);
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		//$this->db->group_by('producto.id_producto');
		$q=$this->db->get('producto');
		//echo $this->db->last_query();
		//die();
		$ret=$q->row();
		return $ret->num_productos;
	}
	function update($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		if (isset($data['id_producto'])){
			$producto=$this->read($data['id_producto']);
		}
		//echo '<pre>'.print_r($producto,true).'</pre>';
		if (!empty($producto)){
			$this->db->where('id_producto',$data['id_producto']);
			$this->db->update('producto',$data);
			$id=$data['id_producto'];
		}else{
			$data['creado']=date('Y-m-d H:i:s');
			$this->db->insert('producto',$data);
			$id=$this->db->insert_id();
		}
		
		return $id;
	}
	function update_idioma($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		$d=array('id_idioma'=>$data['id_idioma'],'id_producto'=>$data['id_producto']);
		if (isset($data['id_detalle_producto']) || $ob=$this->exists('detalle_producto',$d)){
			if (isset($data['id_detalle_producto'])){
				$this->db->where('id_detalle_producto',$data['id_detalle_producto']);
				$id=$data['id_detalle_producto'];
			}else{
				$this->db->where($d);
				$id=$ob->id_detalle_producto;
			}
			$this->db->update('detalle_producto',$data);
			
		}else{
			$this->db->insert('detalle_producto',$data);
			$id=$this->db->insert_id();
		}
		return $id;
	}
	function delete($id){
		/*
		$imagenes=modules::run('services/relations/get_rel','producto','imagen',$id,'true');
		foreach(json_decode($imagenes) as $img){
			if (is_file(FCPATH.'assets/img/temp/'.$img->fichero)) unlink( FCPATH.'assets/img/temp/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/med/'.$img->fichero)) unlink( FCPATH.'assets/img/med/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/thumb/'.$img->fichero)) unlink( FCPATH.'assets/img/thumb/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/large/'.$img->fichero)) unlink( FCPATH.'assets/img/large/'.$img->fichero);
		}
		if ($this->db->delete('producto', array('id_producto' => $id)))
			return true;
		else return false;
		*/
		$data['id_estado']=3;
		$this->db->where('id_producto',$id);
		return $this->db->update('producto',$data);
	}
	function eliminar_idioma($id){
		if ($this->db->delete('detalle_producto', array('id_detalle_producto' => $id)))
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
