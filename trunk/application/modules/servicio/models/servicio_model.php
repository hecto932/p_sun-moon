<?php

class servicio_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->model('idioma/idioma_model','idioma_model');
		$this->idioma=idioma_model::get_from_code($this->session->userdata('idioma'));
	}
	function create($data)
	{
		$this->db->insert('servicio',$data);
		return $this->db->insert_id();
	}
	function read($id,$id_detalle_servicio='',$idioma='')
	{
		$this->db->select('servicio.*, detalle_servicio.*, servicio.id_servicio as id_servicio, tipo_servicio.nombre_tipo as nombre_tipo');
		if ($id_detalle_servicio != '') $this->db->where('detalle_servicio.id_detalle_servicio',$id_detalle_servicio);
		$this->db->join('detalle_servicio','servicio.id_servicio=detalle_servicio.id_servicio','left');
		$this->db->join('tipo_servicio', 'servicio.id_tipo_servicio = tipo_servicio.id_tipo_servicio');
		$this->db->where('servicio.id_servicio',$id);
		$this->db->group_by('servicio.id_servicio');
		$q = $this->db->get('servicio');
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

	function get_image($id_servicio)
	{
		$this->db->select('multimedia.*');
		//$this->db->join('rel_servicio_multimedia', 'rel_servicio_multimedia.id_servicio = servicio.id_servicio');
		$this->db->join('multimedia', 'multimedia.id_multimedia = rel_servicio_multimedia.id_multimedia');
		//$this->db->where('servicio.id_servicio', $id_servicio);
		$q=$this->db->get('rel_servicio_multimedia');

	}

	function detalles($id_servicio, $id_detalle = '', $idioma = ''){
		$this->db->join('detalle_servicio','servicio.id_servicio = detalle_servicio.id_servicio');
		if($id_detalle != '')
		{
			$this->db->where('detalle_servicio.id_idioma', $id_detalle);
		}
		if($idioma != '')
		{
			$this->db->where('detalle_servicio.id_idioma', $idioma);
		}
		$this->db->where('servicio.id_servicio',$id_servicio);
		$q=$this->db->get('servicio');
		return $q->result();
	}

	function get_all($idioma = 'es'){
		$this->load->model('idioma/idioma_model');
		$idioma_result = $this->idioma_model->get_from_code($idioma);
		$this->db->join('rel_servicio_multimedia', 'rel_servicio_multimedia.id_servicio = servicio.id_servicio', 'left');
		$this->db->join('detalle_servicio', 'servicio.id_servicio = detalle_servicio.id_servicio', 'left');
		$this->db->join('multimedia', 'rel_servicio_multimedia.id_multimedia = multimedia.id_multimedia', 'left');
		$this->db->order_by('servicio.id_tipo_servicio', 'asc');
		$this->db->where('detalle_servicio.id_idioma', $idioma_result->id_idioma);
		$this->db->or_where('detalle_servicio.id_idioma', null);
		$q=$this->db->get('servicio');
		
		//echo '<pre>'.print_r($this->db->last_query(),true).'</pre><br />';
		//echo '<pre>'.print_r($q->result(),true).'</pre>';die();
		
		return $q->result();
	}

		function get_all_publicado($idioma = 'es'){
		$this->load->model('idioma/idioma_model');
		$idioma_result = $this->idioma_model->get_from_code($idioma);
		$this->db->join('rel_servicio_multimedia', 'rel_servicio_multimedia.id_servicio = servicio.id_servicio', 'left');
		$this->db->join('detalle_servicio', 'servicio.id_servicio = detalle_servicio.id_servicio', 'left');
		$this->db->join('multimedia', 'rel_servicio_multimedia.id_multimedia = multimedia.id_multimedia', 'left');
		$this->db->order_by('servicio.id_tipo_servicio', 'asc');
		$this->db->where('detalle_servicio.id_idioma', $idioma_result->id_idioma);
		$this->db->where('servicio.id_estado', 1);
		$this->db->or_where('detalle_servicio.id_idioma', null);
		$q=$this->db->get('servicio');
		
		$q = $q->result();
		$q = array_filter($q);
		
		foreach($q as $row => $val)
		{
			$row_plus = $row + 1;
			if(isset($q[$row_plus]))
			{
				if(($q[$row]->id_servicio == $q[$row_plus]->id_servicio) && ($q[$row]->id_tipo_servicio == $q[$row_plus]->id_tipo_servicio))
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
		$this->db->join('detalle_servicio','servicio.id_servicio=detalle_servicio.id_servicio');
		$this->db->where('detalle_servicio.id_idioma',$idioma);
		$this->db->distinct();
		$this->db->select('YEAR(`creado`) as year');
		$this->db->order_by('creado','desc');
		$q=$this->db->get('servicio');
		return $q->result_array();
	}

	function get_list($f='servicio.id_servicio',$v=1,$group=false){

		$this->db->join('detalle_servicio','servicio.id_servicio=detalle_servicio.id_servicio');
		$this->db->where($f,$v);
		if ($group) $this->db->group_by('servicio.id_servicio');
		$q=$this->db->get('servicio');
		return $q->result();
	}

	function get_tipo_servicio(){
		$this->db->select('tipo_servicio.*');
		$this->db->order_by('tipo_servicio.nombre_tipo');
		$query = $this->db->get('tipo_servicio');
		return $query->result();
	}


	function get_page($start = 0, $count = 10, $order_field='servicio.id_servicio', $order_dir = 'desc', $terminos_busqueda = array()){
		switch ($order_field) {
			case 'id_servicio';
				$order_field='servicio.id_servicio';
			break;
			default :
				$order_field=$order_field;
			break;
		}


		$this->db->select('servicio.*,detalle_servicio.*, servicio.id_servicio as id_servicio, multimedia.fichero, tipo_servicio.nombre_tipo as nombre_tipo');
		$this->db->join('detalle_servicio','servicio.id_servicio=detalle_servicio.id_servicio','left');
		$this->db->join('tipo_servicio', 'tipo_servicio.id_tipo_servicio = servicio.id_tipo_servicio');
		$this->db->join('rel_servicio_multimedia', 'servicio.id_servicio = rel_servicio_multimedia.id_servicio', 'left');
		$this->db->join('multimedia', 'multimedia.id_multimedia = rel_servicio_multimedia.id_multimedia', 'left');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='servicio.id_producto' && $value!=''){
					$this->db->where($field,$value);
                }elseif ($field=='texto' && $value!=''){
                    //$this->db->join('detalle_servicio','detalle_servicio.id_servicio=servicio.id_servicio');
                    $this->db->where("(detalle_servicio.descripcion_breve LIKE '%$value%' OR detalle_servicio.nombre LIKE '%$value%' OR detalle_servicio.descripcion_ampliada LIKE '%$value%')");

				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		$this->db->group_by('servicio.id_servicio');
		$this->db->order_by($order_field,$order_dir);
		$q=$this->db->get('servicio',$count,$start);
		//echo $this->db->last_query();
		return $q->result();
	}



	function count_all($terminos_busqueda=array()){
		$this->db->select('count(*) as num_servicios');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='servicio.id_servicio' && $value!=''){
					$this->db->where($field,$value);

                }elseif ($field=='texto' && $value!=''){
                    $this->db->join('detalle_servicio','detalle_servicio.id_servicio=servicio.id_servicio');
					$this->db->where("(detalle_servicio.descripcion_breve LIKE '%$value%' OR detalle_servicio.nombre LIKE '%$value%' OR detalle_servicio.descripcion_ampliada LIKE '%$value%')");
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		//$this->db->group_by('servicio.id_servicio');
		$q=$this->db->get('servicio');
		//echo $this->db->last_query();
		$ret=$q->row();
		return $ret->num_servicios;
	}
	function update($data)
	{

		if (isset($data['id_servicio']))
		{
			$servicio=$this->read($data['id_servicio']);
		}
		if (!empty($servicio))
		{
			$this->db->where('id_servicio',$data['id_servicio']);
			$this->db->update('servicio',$data);
			$id=$data['id_servicio'];
		}
		else
		{
			$this->db->insert('servicio',$data);
			$id=$this->db->insert_id();
		}

		return $id;
	}
	function update_idioma($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		$d=array('id_idioma'=>$data['id_idioma'],'id_servicio'=>$data['id_servicio']);
		if (isset($data['id_detalle_servicio']) && $ob=$this->exists('detalle_servicio',$d)){
			if (isset($data['id_detalle_servicio'])){
				$this->db->where('id_detalle_servicio',$data['id_detalle_servicio']);
				$id=$data['id_detalle_servicio'];
			}else{
				$this->db->where($d);
				$id=$ob->id_detalle_servicio;
			}
			$this->db->update('detalle_servicio',$data);

		}else{
			unset($data['id_detalle_servicio']);
			$this->db->insert('detalle_servicio',$data);
			$id=$this->db->insert_id();
		}
		return $id;
	}
	function delete($id){
		$data['id_estado'] = 3;
		$this->db->where('id_servicio',$id);
		return $this->db->update('servicio',$data);
	}

	function eliminar_idioma($id){
		if ($this->db->delete('detalle_servicio', array('id_detalle_servicio' => $id)))
			return true;
		else return false;
	}

	function exists($table,$key=array()){

		$this->db->where($key);
		$q=$this->db->get($table);
		if ($q->num_rows()>=1) return $q->row();
		else return false;
	}

	function get_servicio_titulos_urls(){
		$this->db->select('servicio.id_servicio as id, detalle_servicio.nombre as nombre, detalle_servicio.url as url');
		$this->db->join('detalle_servicio', 'servicio.id_servicio = detalle_servicio.id_servicio');
		$query = $this->db->get('servicio');
		return $query->result();
	}

	function guardar_rel_imagen($data){
		$this->db->insert('rel_servicio_multimedia', $data);
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
	
	function get_id_servicio_url($url)
	{
		$this->db->where('dp.url', $url);
		
		$query 		= $this->db->get('detalle_servicio dp');
		$resultado 	= $query->result();
		
		if($query->num_rows() > 0)
		{
			return $resultado[0]->id_servicio;
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_servicios_tipo($idioma = 'es')
	{
		$query = 
		"
			SELECT ts.*, ds.*, m.fichero
			FROM tipo_servicio ts
			JOIN servicio s ON s.id_tipo_servicio = ts.id_tipo_servicio
			JOIN detalle_servicio ds ON ds.id_servicio = s.id_servicio
			JOIN idioma i ON i.id_idioma = ds.id_idioma
			
			LEFT JOIN (	SELECT mu.*, r.id_servicio 
						FROM rel_servicio_multimedia r
						JOIN multimedia mu ON mu.id_multimedia = r.id_multimedia 
						WHERE mu.destacado = 1) m ON m.id_servicio = s.id_servicio
						
			WHERE s.id_estado = 1 AND i.idioma = ".$this->db->escape($idioma)."
		";
		return $this->db->query($query)->result();
	}
	
	function get_servicios_tipo_rows($idioma = 'es')
	{
		$query = 
		"
			SELECT ts.*, ds.*, m.fichero
			FROM tipo_servicio ts
			JOIN servicio s ON s.id_tipo_servicio = ts.id_tipo_servicio
			JOIN detalle_servicio ds ON ds.id_servicio = s.id_servicio
			JOIN idioma i ON i.id_idioma = ds.id_idioma
			
			LEFT JOIN (	SELECT mu.*, r.id_servicio 
						FROM rel_servicio_multimedia r
						JOIN multimedia mu ON mu.id_multimedia = r.id_multimedia 
						WHERE mu.destacado = 1) m ON m.id_servicio = s.id_servicio
						
			WHERE s.id_estado = 1 AND i.idioma = ".$this->db->escape($idioma)."
		";
		return $this->db->query($query)->num_rows();
	}
	
	function get_datos_servicio($id_servicio, $id_idioma = 'es')
	{
		$query = 
		"
			SELECT s.*, ds.*, m.destacado, m.fichero 
			FROM servicio s
			JOIN detalle_servicio ds ON ds.id_servicio = s.id_servicio
			JOIN idioma i ON i.id_idioma = ds.id_idioma
			LEFT JOIN rel_servicio_multimedia rm ON rm.id_servicio = s.id_servicio
			LEFT JOIN multimedia m ON m.id_multimedia = rm.id_multimedia
			WHERE s.id_servicio = ".$this->db->escape($id_servicio)." AND i.idioma = ".$this->db->escape($id_idioma)."
		";
		
		$resultado = $this->db->query($query)->result_array();
		
		$datos_servicio = $resultado[0];
		unset($datos_servicio['fichero']);
		unset($datos_servicio['destacado']);
		
		$multimedia = array();
		foreach($resultado as $servicio)
		{
			$multimedia[] = array('destacado' => $servicio['destacado'], 'fichero' => $servicio['fichero']);
		}
		
		$datos_servicio['multimedia'] = $multimedia;
		
		return $datos_servicio;
	}
}
