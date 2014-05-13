<?php

class Banner_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('idioma/idioma_model','idioma_model');
		$this->idioma=idioma_model::get_from_code($this->session->userdata('idioma'));
	}
	
	function create($data)
	{
		$this->db->insert('banner',$data);
		return $this->db->insert_id();
	}
	function read($id,$id_detalle_banner='',$idioma='')
	{
		$this->db->select('banner.*,detalle_banner.*,banner.id_banner as id_banner');
		//$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		if ($id_detalle_banner!='') $this->db->where('detalle_banner.id_detalle_banner',$id_detalle_banner);
		$this->db->join('detalle_banner','banner.id_banner=detalle_banner.id_banner','left');
		//$this->db->where('detalle_banner.id_idioma',$idioma);
		$this->db->where('banner.id_banner',$id);
		$this->db->group_by('banner.id_banner');
		$q=$this->db->get('banner');
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
	function detalles($id_banner){
		$this->db->join('detalle_banner','banner.id_banner=detalle_banner.id_banner');
		//$this->db->where('detalle_banner.id_idioma',$idioma);
		$this->db->where('banner.id_banner',$id_banner);
		//$this->db->group_by('banner.id_banner');
		$q=$this->db->get('banner');
		return $q->result();
	}
	function get_all($idioma=''){
		$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		$this->db->join('detalle_banner','banner.id_banner=detalle_banner.id_banner');
		$this->db->where('detalle_banner.id_idioma',$idioma);
		$q=$this->db->get('banner');
		return $q->result();
	}
	function get_list($f='banner.id_banner',$v=1,$group=false){
		
		$this->db->join('detalle_banner','banner.id_banner=detalle_banner.id_banner');
		$this->db->where($f,$v);
		if ($group) $this->db->group_by('banner.id_banner');
		$q=$this->db->get('banner');
		return $q->result();
	}
	
	function get_page($start = 0, $count = 10, $order_field='banner.id_banner', $order_dir = 'asc',  $terminos_busqueda = array())
	{
		switch ($order_field) {
			case 'id_banner';
				$order_field='banner.id_banner';
			break;
			default :
				$order_field=$order_field;
			break;
		}


		$this->db->select('banner.*, multimedia.fichero');
		$this->db->join('rel_banner_multimedia', 'banner.id_banner = rel_banner_multimedia.id_banner', 'left');
		$this->db->join('multimedia', 'multimedia.id_multimedia = rel_banner_multimedia.id_multimedia AND multimedia.destacado = 0', 'left');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if (($field=='banner.id_producto') && $value!=''){
					$this->db->where($field,$value);
                }else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		//$this->db->where('multimedia.fichero',);
		$this->db->group_by('banner.id_banner');
		$this->db->order_by($order_field,$order_dir);
		
		$q=$this->db->get('banner',$count,$start);
		$result = $q->result();
		
		return $result;
	}

	function get_page_fichero($start = 0, $count = 10, $order_field='banner.id_banner', $order_dir = 'asc',  $terminos_busqueda = array())
	{
		switch ($order_field) {
			case 'id_banner';
				$order_field='banner.id_banner';
			break;
			default :
				$order_field=$order_field;
			break;
		}


		$this->db->select('banner.id_banner,banner.enlace, multimedia.fichero');
		$this->db->join('rel_banner_multimedia', 'banner.id_banner = rel_banner_multimedia.id_banner', 'left');
		$this->db->join('multimedia', 'multimedia.id_multimedia = rel_banner_multimedia.id_multimedia AND multimedia.destacado = 0');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if (($field=='banner.id_producto') && $value!=''){
					$this->db->where($field,$value);
                }else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		//$this->db->where('multimedia.fichero',);
		$this->db->where('banner.id_estado',1);
		$this->db->group_by('banner.id_banner');
		$this->db->order_by($order_field,$order_dir);
		
		$q=$this->db->get('banner',$count,$start);
		$result = $q->result();
		
		foreach ($result as $k => $banner)
		{
			$banner->ruta_banner = base_url().'assets/front/img/large/'.$banner->fichero;
		}
		
		return $result;
	}
	
	function count_all($terminos_busqueda=array()){
		$this->db->select('count(*) as num_banners');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='banner.id_banner' && $value!=''){
					$this->db->where($field,$value);
				
                }elseif ($field=='texto' && $value!=''){
                    $this->db->join('detalle_banner','detalle_banner.id_banner=banner.id_banner');
					$this->db->where("(detalle_banner.descripcion_breve LIKE '%$value%' OR detalle_banner.nombre LIKE '%$value%' OR detalle_banner.descripcion_ampliada LIKE '%$value%')");
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		//$this->db->group_by('banner.id_banner');
		$q=$this->db->get('banner');
		//echo $this->db->last_query();
		$ret=$q->row();
		return $ret->num_banners;
	}
	function update($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		if (isset($data['id_banner'])){
			$banner=$this->read($data['id_banner']);
		}
		//echo '<pre>'.print_r($banner,true).'</pre>';
		if (!empty($banner)){
			$this->db->where('id_banner',$data['id_banner']);
			$this->db->update('banner',$data);
			$id=$data['id_banner'];
		}else{
			$data['creado']=date('Y-m-d H:i:s');
			$this->db->insert('banner',$data);
			$id=$this->db->insert_id();
		}
		
		return $id;
	}
	function update_idioma($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		$d=array('id_idioma'=>$data['id_idioma'],'id_banner'=>$data['id_banner']);
		if (isset($data['id_detalle_banner']) || $ob=$this->exists('detalle_banner',$d)){
			if (isset($data['id_detalle_banner'])){
				$this->db->where('id_detalle_banner',$data['id_detalle_banner']);
				$id=$data['id_detalle_banner'];
			}else{
				$this->db->where($d);
				$id=$ob->id_detalle_banner;
			}
			$this->db->update('detalle_banner',$data);
			
		}else{
			$this->db->insert('detalle_banner',$data);
			$id=$this->db->insert_id();
		}
		return $id;
	}
	function delete($id){
		/*
		$imagenes=modules::run('services/relations/get_rel','banner','imagen',$id,'true');
		foreach(json_decode($imagenes) as $img){
			if (is_file(FCPATH.'assets/img/temp/'.$img->fichero)) unlink( FCPATH.'assets/img/temp/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/med/'.$img->fichero)) unlink( FCPATH.'assets/img/med/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/thumb/'.$img->fichero)) unlink( FCPATH.'assets/img/thumb/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/large/'.$img->fichero)) unlink( FCPATH.'assets/img/large/'.$img->fichero);
		}
		if ($this->db->delete('banner', array('id_banner' => $id)))
			return true;
		else return false;
		*/
		$data['id_estado']=3;
		$this->db->where('id_banner',$id);
		return $this->db->update('banner',$data);
	}
	function eliminar_idioma($id){
		if ($this->db->delete('detalle_banner', array('id_detalle_banner' => $id)))
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
