<?php

class habitacion_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->model('idioma/idioma_model','idioma_model');
		$this->idioma=idioma_model::get_from_code($this->session->userdata('idioma'));
	}
	function create($data)
	{
		$this->db->insert('habitacion',$data);
		return $this->db->insert_id();
	}
	function read($id,$id_detalle_habitacion='',$idioma='')
	{
		/*
		$this->db->select(	'habitacion.*, detalle_habitacion.*, habitacion.id_habitacion as id_habitacion, detalle_tipo_habitacion.nombre as nombre_tipo,
							estado_habitacion.descripcion as estado_habitacion');
		*/
		
		$this->db->select(	'habitacion.*, detalle_habitacion.*, habitacion.id_habitacion as id_habitacion, detalle_tipo_habitacion.nombre as nombre_tipo');
		
		if ($id_detalle_habitacion != '') $this->db->where('detalle_habitacion.id_detalle_habitacion',$id_detalle_habitacion);
		$this->db->join('detalle_habitacion','habitacion.id_habitacion=detalle_habitacion.id_habitacion','left');
		$this->db->join('detalle_tipo_habitacion', 'habitacion.id_tipo_habitacion = detalle_tipo_habitacion.id_tipo_habitacion', 'left');
		
		//$this->db->join('estado_habitacion', 'habitacion.id_estado_habitacion = estado_habitacion.id_estado_habitacion', 'left');
		
		$this->db->where('habitacion.id_habitacion',$id);
		$this->db->group_by('habitacion.id_habitacion');
		$q = $this->db->get('habitacion');
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

	/*
	function get_posts($num_posts = 0, $donde = array()){
		$this->db->select('servicio.*, servicio.id_servicio as id_servicio, detalle_servicio.*, multimedia.fichero');
		$this->db->join('rel_servicio_multimedia', 'rel_servicio_multimedia.id_servicio = servicio.id_servicio');
		$this->db->join('detalle_servicio', 'servicio.id_servicio = detalle_servicio.id_servicio');
		$this->db->join('multimedia', 'rel_servicio_multimedia.id_multimedia = multimedia.id_multimedia');
		
		if (!empty($donde))
		{
			foreach($donde as $condicion => $valor)
			{
				$this->db->where($condicion, $valor);
			}
		}
		if ($num_posts > 0)
		{
			$query = $this->db->get('servicio', $num_posts);
		}
		else
		{
			$query = $this->db->get('servicio');
		}
		
		$q = $query->result();
		
		for($i=0;$i<count($q);$i++)
		{
			if(isset($q[$i+1]))
			{
				if($q[$i]->id_servicio == $q[$i+1]->id_servicio)
				{
					unset($q[$i]);
				}
			}
		}
		$q = array_filter($q);
		$q = array_values($q);
		$q = array_reverse($q);
		
		return $q;
	}

	function get_last_five_post(){
		$this->db->select('servicio.id_servicio as id, detalle_servicio.nombre as nombre, detalle_servicio.url as url, detalle_servicio.titulo_pagina as titulo_pagina');
		$this->db->join('detalle_servicio', 'servicio.id_servicio = detalle_servicio.id_servicio');
		$this->db->order_by('servicio.creado','desc');
		$query = $this->db->get('servicio', 5);
		return $query->result();
	}
	*/
	
	function get_image($id_habitacion)
	{
		$this->db->select('multimedia.*');
		$this->db->join('multimedia', 'multimedia.id_multimedia = rel_habitacion_multimedia.id_multimedia');
		$q=$this->db->get('rel_habitacion_multimedia');

	}

	function detalles($id_habitacion, $id_detalle = '', $idioma = ''){
		$this->db->join('detalle_habitacion','habitacion.id_habitacion = detalle_habitacion.id_habitacion');
		if($id_detalle != '')
		{
			$this->db->where('detalle_habitacion.id_idioma', $id_detalle);
		}
		if($idioma != '')
		{
			$this->db->where('detalle_habitacion.id_idioma', $idioma);
		}
		$this->db->where('habitacion.id_habitacion',$id_habitacion);
		$q=$this->db->get('habitacion');
		return $q->result();
	}

	function get_all($idioma = 'es'){
		$this->load->model('idioma/idioma_model');
		$idioma_result = $this->idioma_model->get_from_code($idioma);
		$this->db->join('rel_habitacion_multimedia', 'rel_habitacion_multimedia.id_habitacion = habitacion.id_habitacion', 'left');
		$this->db->join('detalle_habitacion', 'habitacion.id_habitacion = detalle_habitacion.id_habitacion', 'left');
		$this->db->join('multimedia', 'rel_habitacion_multimedia.id_multimedia = multimedia.id_multimedia', 'left');
		$this->db->order_by('habitacion.id_tipo_habitacion', 'asc');
		$this->db->where('detalle_habitacion.id_idioma', $idioma_result->id_idioma);
		$this->db->or_where('detalle_habitacion.id_idioma', null);
		$q=$this->db->get('habitacion');
		
		//echo '<pre>'.print_r($this->db->last_query(),true).'</pre><br />';
		//echo '<pre>'.print_r($q->result(),true).'</pre>';die();
		
		return $q->result();
	}

		function get_all_publicado($idioma = 'es'){
		$this->load->model('idioma/idioma_model');
		$idioma_result = $this->idioma_model->get_from_code($idioma);
		$this->db->join('rel_habitacion_multimedia', 'rel_habitacion_multimedia.id_habitacion = habitacion.id_habitacion', 'left');
		$this->db->join('detalle_habitacion', 'habitacion.id_habitacion = detalle_habitacion.id_habitacion', 'left');
		$this->db->join('multimedia', 'rel_habitacion_multimedia.id_multimedia = multimedia.id_multimedia', 'left');
		$this->db->order_by('habitacion.id_tipo_habitacion', 'asc');
		$this->db->where('detalle_habitacion.id_idioma', $idioma_result->id_idioma);
		$this->db->where('habitacion.id_estado', 1);
		$this->db->or_where('detalle_habitacion.id_idioma', null);
		$q=$this->db->get('habitacion');
		
		$q = $q->result();
		$q = array_filter($q);
		
		foreach($q as $row => $val)
		{
			$row_plus = $row + 1;
			if(isset($q[$row_plus]))
			{
				if(($q[$row]->id_habitacion == $q[$row_plus]->id_habitacion) && ($q[$row]->id_tipo_habitacion == $q[$row_plus]->id_tipo_habitacion))
				{
					unset($q[$row_plus]);
				}
			}
		}
		
		//echo '<pre>'.print_r($this->db->last_query(),true).'</pre><br />';
		//echo '<pre>'.print_r($q,true).'</pre>';die();
		
		return $q;
	}



	function get_all_years($idioma=''){
		$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		$this->db->join('detalle_habitacion','habitacion.id_habitacion=detalle_habitacion.id_habitacion');
		$this->db->where('detalle_habitacion.id_idioma',$idioma);
		$this->db->distinct();
		$this->db->select('YEAR(`creado`) as year');
		$this->db->order_by('creado','desc');
		$q=$this->db->get('habitacion');
		return $q->result_array();
	}

	function get_list($f='habitacion.id_habitacion',$v=1,$group=false){

		$this->db->join('detalle_habitacion','habitacion.id_habitacion=detalle_habitacion.id_habitacion');
		$this->db->where($f,$v);
		if ($group) $this->db->group_by('habitacion.id_habitacion');
		$q=$this->db->get('habitacion');
		return $q->result();
	}

	function get_tipo_habitacion(){
		$this->db->select('detalle_tipo_habitacion.*');
		$this->db->order_by('detalle_tipo_habitacion.nombre');
		$query = $this->db->get('detalle_tipo_habitacion');
		return $query->result();
	}


	function get_page($start = 0, $count = 10, $order_field='habitacion.id_habitacion', $order_dir = 'desc', $terminos_busqueda = array()){
		switch ($order_field) {
			case 'id_habitacion';
				$order_field='habitacion.id_habitacion';
			break;
			default :
				$order_field=$order_field;
			break;
		}


		$this->db->select('habitacion.*,detalle_habitacion.*, habitacion.id_habitacion as id_habitacion, multimedia.fichero, detalle_tipo_habitacion.nombre as nombre_tipo');
		$this->db->join('detalle_habitacion','habitacion.id_habitacion=detalle_habitacion.id_habitacion','left');
		$this->db->join('detalle_tipo_habitacion', 'detalle_tipo_habitacion.id_tipo_habitacion = habitacion.id_tipo_habitacion');
		$this->db->join('rel_habitacion_multimedia', 'habitacion.id_habitacion = rel_habitacion_multimedia.id_habitacion', 'left');
		$this->db->join('multimedia', 'multimedia.id_multimedia = rel_habitacion_multimedia.id_multimedia', 'left');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='habitacion.id_producto' && $value!=''){
					$this->db->where($field,$value);
                }elseif ($field=='texto' && $value!=''){
                    $this->db->where("(detalle_habitacion.descripcion_breve LIKE '%$value%' OR detalle_habitacion.nombre LIKE '%$value%' OR detalle_habitacion.descripcion_ampliada LIKE '%$value%')");

				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		$this->db->group_by('habitacion.id_habitacion');
		$this->db->order_by($order_field,$order_dir);
		$q=$this->db->get('habitacion',$count,$start);
		//echo $this->db->last_query();
		return $q->result();
	}



	function count_all($terminos_busqueda=array()){
		$this->db->select('count(*) as num_habitacions');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='habitacion.id_habitacion' && $value!=''){
					$this->db->where($field,$value);

                }elseif ($field=='texto' && $value!=''){
                    $this->db->join('detalle_habitacion','detalle_habitacion.id_habitacion=habitacion.id_habitacion');
					$this->db->where("(detalle_habitacion.descripcion_breve LIKE '%$value%' OR detalle_habitacion.nombre LIKE '%$value%' OR detalle_habitacion.descripcion_ampliada LIKE '%$value%')");
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		//$this->db->group_by('servicio.id_servicio');
		$q=$this->db->get('habitacion');
		//echo $this->db->last_query();
		$ret=$q->row();
		return $ret->num_habitacions;
	}
	function update($data)
	{

		if (isset($data['id_habitacion']))
		{
			$habitacion=$this->read($data['id_habitacion']);
		}
		if (!empty($habitacion))
		{
			$this->db->where('id_habitacion',$data['id_habitacion']);
			$this->db->update('habitacion',$data);
			$id=$data['id_habitacion'];
		}
		else
		{
			$this->db->insert('habitacion',$data);
			$id=$this->db->insert_id();
		}

		return $id;
	}
	function update_idioma($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		$d=array('id_idioma'=>$data['id_idioma'],'id_habitacion'=>$data['id_habitacion']);
		if (isset($data['id_detalle_habitacion']) && $ob=$this->exists('detalle_habitacion',$d)){
			if (isset($data['id_detalle_habitacion'])){
				$this->db->where('id_detalle_habitacion',$data['id_detalle_habitacion']);
				$id=$data['id_detalle_habitacion'];
			}else{
				$this->db->where($d);
				$id=$ob->id_detalle_habitacion;
			}
			$this->db->update('detalle_habitacion',$data);

		}else{
			unset($data['id_detalle_habitacion']);
			$this->db->insert('detalle_habitacion',$data);
			$id=$this->db->insert_id();
		}
		return $id;
	}
	function delete($id){
		$data['id_estado'] = 3;
		$this->db->where('id_habitacion',$id);
		return $this->db->update('habitacion',$data);
	}

	function eliminar_idioma($id){
		if ($this->db->delete('detalle_habitacion', array('id_detalle_habitacion' => $id)))
			return true;
		else return false;
	}

	function exists($table,$key=array()){

		$this->db->where($key);
		$q=$this->db->get($table);
		if ($q->num_rows()>=1) return $q->row();
		else return false;
	}

	function get_habitacion_titulos_urls(){
		$this->db->select('habitacion.id_habitacion as id, detalle_habitacion.nombre as nombre, detalle_habitacion.url as url');
		$this->db->join('detalle_habitacion', 'habitacion.id_habitacion = detalle_habitacion.id_habitacion');
		$query = $this->db->get('habitacion');
		return $query->result();
	}

	function guardar_rel_imagen($data){
		$this->db->insert('rel_habitacion_multimedia', $data);
	}

	function guardar_imagen($data){
		$this->db->insert('multimedia', $data);
		$id = $this->db->insert_id();
		return $id;
	}
	
	function insert_habitacion($data)
	{
		if(!empty($data))
			$this->db->insert('habitacion', $data);
	}
	
	/*
	function get_estados_habitacion()
	{
		return $this->db->get('estado_habitacion')->result();
	}
	*/
	
	function get_id_habitacion_url($url)
	{
		$this->db->where('dp.url', $url);
		
		$query 		= $this->db->get('detalle_habitacion dp');
		$resultado 	= $query->result();
		
		if($query->num_rows() > 0)
		{
			return $resultado[0]->id_habitacion;
		}
		else
		{
			return FALSE;
		}
	}
}
