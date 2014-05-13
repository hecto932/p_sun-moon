<?php

class Home_model extends CI_Model {
	
	function __construct(){
		parent::__construct();	
		$this->id_idioma=modules::run('idioma/get_idioma_id_from_code',$this->session->userdata('idioma'));
	}
	function create($data)
	{
		$this->db->insert('obra',$data);
		return $this->db->insert_id();
	}
	function read($id,$id_detalle_home='',$idioma='')
	{
		$this->db->select('home.*,detalle_home.*,home.id_home as id_home');
		//$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		if ($id_detalle_home!='') $this->db->where('detalle_home.id_detalle_home',$id_detalle_home);
		$this->db->join('detalle_home','home.id_home=detalle_home.id_home','left');
		//$this->db->where('detalle_obra.id_idioma',$idioma);
		$this->db->where('home.id_home',$id);
		$this->db->group_by('home.id_home');
		$q=$this->db->get('home');
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
	function detalles($id_home){
		$this->db->join('detalle_home','home.id_home=detalle_home.id_home');
		//$this->db->where('detalle_obra.id_idioma',$idioma);
		$this->db->where('home.id_home',$id_home);
		//$this->db->group_by('obra.id_obra');
		$q=$this->db->get('home');
		return $q->result();
	}
	function get_all($idioma=''){
		$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		$this->db->join('detalle_obra','obra.id_obra=detalle_obra.id_obra');
		$this->db->where('detalle_obra.id_idioma',$idioma);
		$q=$this->db->get('obra');
		return $q->result();
	}
	function get_list($f='obra.id_obra',$v=1,$group=false){
		
		$this->db->join('detalle_obra','obra.id_obra=detalle_obra.id_obra');
		$this->db->where($f,$v);
		if ($group) $this->db->group_by('obra.id_obra');
		$q=$this->db->get('obra');
		return $q->result();
	}
	function get_page($start=0,$count=10,$order_field='obra.id_obra',$order_dir='desc',$terminos_busqueda=array()){
		switch ($order_field) {
			case 'id_obra';
				$order_field='obra.id_obra';
			break;
			default :
				$order_field=$order_field;
			break;
		}
		
		
		$this->db->select('obra.*,detalle_obra.*,detalle_categoria.nombre as nombre_categoria,detalle_categoria.descripcion as descripcion_categoria,obra.id_obra as id_obra');
		$this->db->join('detalle_obra','obra.id_obra=detalle_obra.id_obra','left');
		$this->db->join('categoria','obra.id_categoria=categoria.id_categoria');
		$this->db->join('detalle_categoria','obra.id_categoria=detalle_categoria.id_categoria');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='fecha_desde' && $value!=''){
					$this->db->where("concat(ano,'-',mes,'-',dia) >=",$value);
				}elseif ($field=='fecha_hasta' && $value!=''){
					$this->db->where("concat(ano,'-',mes,'-',dia) <=",$value);
				}elseif ($field=='obra.id_categoria' && $value!=''){
					$this->db->where($field,$value);
				}elseif ($field=='obra.id_estado' && $value!=''){
					$this->db->where($field,$value);
				}elseif ($field=='tag' && $value!=''){
					$this->db->join('rel_detalle_obra_tag','rel_detalle_obra_tag.id_detalle_obra=detalle_obra.id_detalle_obra');
					$this->db->join('tag','tag.id_tag=rel_detalle_obra_tag.id_tag');
					$this->db->like($field,$value);
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		$this->db->group_by('obra.id_obra');
		$this->db->order_by($order_field,$order_dir);
		$q=$this->db->get('obra',$count,$start);
		//echo $this->db->last_query();
		return $q->result();
	}
	function count_all($terminos_busqueda=array()){
		$this->db->select('count(*) as num_obras');
		
		//TO-DO : Anadir where para terminos de busqueda
		if (!empty($terminos_busqueda)){
			$this->db->join('detalle_obra','obra.id_obra=detalle_obra.id_obra','left');
			$this->db->join('categoria','obra.id_categoria=categoria.id_categoria');
			$this->db->join('detalle_categoria','obra.id_categoria=detalle_categoria.id_categoria');

			foreach($terminos_busqueda as $field=>$value){
				if ($field=='fecha_desde'){
					$this->db->where("concat(ano,'-',mes,'-',dia) >=",$value);
				}elseif ($field=='fecha_hasta'){
					$this->db->where("concat(ano,'-',mes,'-',dia) <=",$value);
				}elseif ($field=='obra.id_categoria' && $value!=''){
					$this->db->where($field,$value);
				}elseif ($field=='obra.id_estado' && $value!=''){
					$this->db->where($field,$value);
				}elseif ($field=='tag' && $value!=''){
					$this->db->join('rel_detalle_obra_tag','rel_detalle_obra_tag.id_detalle_obra=detalle_obra.id_detalle_obra');
					$this->db->join('tag','tag.id_tag=rel_detalle_obra_tag.id_tag');
					$this->db->like($field,$value);
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		//$this->db->group_by('obra.id_obra');
		$q=$this->db->get('obra');
		//echo $this->db->last_query();
		$ret=$q->row();
		return $ret->num_obras;
	}
	function update($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		if (isset($data['id_home'])){
			$home=$this->read($data['id_home']);
		}
		//echo '<pre>'.print_r($obra,true).'</pre>';
		if (!empty($home)){
			$this->db->where('id_home',$data['id_home']);
			$this->db->update('home',$data);
			$id=$data['id_home'];
		}else{
			$data['creado']=date('Y-m-d H:i:s');
			$this->db->insert('home',$data);
			$id=$this->db->insert_id();
		}
		
		return $id;
	}
	function update_idioma($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		$d=array('id_idioma'=>$data['id_idioma'],'id_home'=>$data['id_home']);
		if (isset($data['id_detalle_home']) || $ob=$this->exists('detalle_home',$d)){
			if (isset($data['id_detalle_home'])){
				$this->db->where('id_detalle_home',$data['id_detalle_home']);
				$id=$data['id_detalle_home'];
			}else{
				$this->db->where($d);
				$id=$ob->id_detalle_home;
			}
			$this->db->update('detalle_home',$data);
			
		}else{
			$this->db->insert('detalle_home',$data);
			$id=$this->db->insert_id();
		}
		return $id;
	}
	function delete($id){
		/*
		$imagenes=modules::run('services/relations/get_rel','obra','imagen',$id,'true');
		foreach(json_decode($imagenes) as $img){
			if (is_file(FCPATH.'assets/img/temp/'.$img->fichero)) unlink( FCPATH.'assets/img/temp/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/med/'.$img->fichero)) unlink( FCPATH.'assets/img/med/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/thumb/'.$img->fichero)) unlink( FCPATH.'assets/img/thumb/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/large/'.$img->fichero)) unlink( FCPATH.'assets/img/large/'.$img->fichero);
		}
		if ($this->db->delete('obra', array('id_obra' => $id)))
			return true;
		else return false;
		*/
		$data['id_estado']=3;
		$this->db->where('id_home',$id);
		return $this->db->update('home',$data);
	}
	function eliminar_idioma($id){
		if ($this->db->delete('detalle_home', array('id_detalle_home' => $id)))
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
