<?php

class tipo_habitacion_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->model('idioma/idioma_model','idioma_model');
		$this->idioma=idioma_model::get_from_code($this->session->userdata('idioma'));
	}
	function create($data)
	{
		$this->db->insert('tipo_habitacion',$data);
		return $this->db->insert_id();
	}
	function read($id,$id_detalle_tipo_habitacion='',$idioma='')
	{
		$this->db->select('tipo_habitacion.*, detalle_tipo_habitacion.*, tipo_habitacion.id_tipo_habitacion as id_tipo_habitacion');
		if ($id_detalle_tipo_habitacion != '') $this->db->where('detalle_tipo_habitacion.id_detalle_tipo_habitacion',$id_detalle_tipo_habitacion);
		$this->db->join('detalle_tipo_habitacion','tipo_habitacion.id_tipo_habitacion = detalle_tipo_habitacion.id_tipo_habitacion','left');
		$this->db->where('tipo_habitacion.id_tipo_habitacion',$id);
		$this->db->group_by('tipo_habitacion.id_tipo_habitacion');
		$q = $this->db->get('tipo_habitacion');
		if ($q->num_rows() == 1)
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

	function detalles($id_tipo_habitacion, $id_detalle = '', $idioma = ''){
		$this->db->join('detalle_tipo_habitacion','tipo_habitacion.id_tipo_habitacion = detalle_tipo_habitacion.id_tipo_habitacion');
		if($id_detalle != '')
		{
			$this->db->where('detalle_tipo_habitacion.id_idioma', $id_detalle);
		}
		if($idioma != '')
		{
			$this->db->where('detalle_tipo_habitacion.id_idioma', $idioma);
		}
		$this->db->where('tipo_habitacion.id_tipo_habitacion',$id_tipo_habitacion);
		$q=$this->db->get('tipo_habitacion');
		return $q->result();
	}

	function get_all($idioma = 'es'){
		$this->load->model('idioma/idioma_model');
		$idioma_result = $this->idioma_model->get_from_code($idioma);
		$this->db->join('rel_tipo_habitacion_multimedia', 'rel_tipo_habitacion_multimedia.id_tipo_habitacion = tipo_habitacion.id_tipo_habitacion', 'left');
		$this->db->join('detalle_tipo_habitacion', 'tipo_habitacion.id_tipo_habitacion = detalle_tipo_habitacion.id_tipo_habitacion', 'left');
		$this->db->join('multimedia', 'rel_tipo_habitacion_multimedia.id_multimedia = multimedia.id_multimedia', 'left');
		$this->db->where('detalle_tipo_habitacion.id_idioma', $idioma_result->id_idioma);
		$this->db->or_where('detalle_tipo_habitacion.id_idioma', null);
		$q=$this->db->get('tipo_habitacion');
		
		//echo '<pre>'.print_r($this->db->last_query(),true).'</pre><br />';
		//echo '<pre>'.print_r($q->result(),true).'</pre>';die();
		
		return $q->result();
	}

		function get_all_publicado($idioma = 'es'){
		$this->load->model('idioma/idioma_model');
		$idioma_result = $this->idioma_model->get_from_code($idioma);
		$this->db->join('rel_tipo_habitacion_multimedia', 'rel_tipo_habitacion_multimedia.id_tipo_habitacion = tipo_habitacion.id_tipo_habitacion', 'left');
		$this->db->join('detalle_tipo_habitacion', 'tipo_habitacion.id_tipo_habitacion = detalle_tipo_habitacion.id_tipo_habitacion', 'left');
		$this->db->join('multimedia', 'rel_tipo_habitacion_multimedia.id_multimedia = multimedia.id_multimedia', 'left');
		//$this->db->order_by('servicio.id_tipo_servicio', 'asc');
		$this->db->where('detalle_tipo_habitacion.id_idioma', $idioma_result->id_idioma);
		$this->db->where('tipo_habitacion.id_estado', 1);
		$this->db->or_where('detalle_tipo_habitacion.id_idioma', null);
		$q=$this->db->get('tipo_habitacion');
		
		$q = $q->result();
		$q = array_filter($q);
		
		foreach($q as $row => $val)
		{
			$row_plus = $row + 1;
			if(isset($q[$row_plus]))
			{
				if(($q[$row]->id_tipo_habitacion == $q[$row_plus]->id_tipo_habitacion))
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
		$this->db->join('detalle_tipo_habitacion','tipo_habitacion.id_tipo_habitacion = detalle_tipo_habitacion.id_tipo_habitacion');
		$this->db->where('detalle_tipo_habitacion.id_idioma',$idioma);
		$this->db->distinct();
		$this->db->select('YEAR(`creado`) as year');
		$this->db->order_by('creado','desc');
		$q=$this->db->get('tipo_habitacion');
		return $q->result_array();
	}

	function get_list($f = 'tipo_habitacion.id_tipo_habitacion', $v = 1, $group = false){

		$this->db->join('detalle_tipo_habitacion','tipo_habitacion.id_tipo_habitacion = detalle_tipo_habitacion.id_tipo_habitacion');
		$this->db->where($f,$v);
		if ($group) $this->db->group_by('tipo_habitacion.id_tipo_habitacion');
		$q=$this->db->get('tipo_habitacion');
		return $q->result();
	}

	function get_page($start = 0, $count = 10, $order_field='tipo_habitacion.id_tipo_habitacion', $order_dir = 'desc', $terminos_busqueda = array()){
		switch ($order_field) {
			case 'id_tipo_habitacion';
				$order_field = 'tipo_habitacion.id_tipo_habitacion';
			break;
			default :
				$order_field = $order_field;
			break;
		}


		$this->db->select(	'tipo_habitacion.*, detalle_tipo_habitacion.*, tipo_habitacion.id_tipo_habitacion as id_tipo_habitacion');
		$this->db->join('detalle_tipo_habitacion','tipo_habitacion.id_tipo_habitacion = detalle_tipo_habitacion.id_tipo_habitacion','left');
		//$this->db->join('tipo_servicio', 'tipo_servicio.id_tipo_servicio = servicio.id_tipo_servicio');
		$this->db->join('rel_tipo_habitacion_multimedia', 'rel_tipo_habitacion_multimedia.id_tipo_habitacion = rel_tipo_habitacion_multimedia.id_tipo_habitacion', 'left');
		$this->db->join('multimedia', 'multimedia.id_multimedia = rel_tipo_habitacion_multimedia.id_multimedia', 'left');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='texto' && $value!=''){
                    //$this->db->join('detalle_servicio','detalle_servicio.id_servicio=servicio.id_servicio');
                    $this->db->where("(detalle_tipo_habitacion.descripcion_breve LIKE '%$value%' OR detalle_tipo_habitacion.nombre LIKE '%$value%' OR detalle_tipo_habitacion.descripcion_ampliada LIKE '%$value%')");

				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		$this->db->group_by('tipo_habitacion.id_tipo_habitacion');
		$this->db->order_by($order_field,$order_dir);
		$q=$this->db->get('tipo_habitacion',$count,$start);
		//echo $this->db->last_query();
		return $q->result();
	}
	
	function count_all($terminos_busqueda=array()){
		$this->db->select('count(*) as num_tipos_habitacion');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='tipo_habitacion.id_tipo_habitacion' && $value!=''){
					$this->db->where($field,$value);

                }elseif ($field=='texto' && $value!=''){
                    $this->db->join('detalle_tipo_habitacion','detalle_tipo_habitacion.id_tipo_habitacion = tipo_habitacion.id_tipo_habitacion');
					$this->db->where("(detalle_tipo_habitacion.descripcion_breve LIKE '%$value%' OR detalle_tipo_habitacion.nombre LIKE '%$value%' OR detalle_tipo_habitacion.descripcion_ampliada LIKE '%$value%')");
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		//$this->db->group_by('servicio.id_servicio');
		$q=$this->db->get('tipo_habitacion');
		//echo $this->db->last_query();
		$ret=$q->row();
		return $ret->num_tipos_habitacion;
	}
	function update($data)
	{
		if (isset($data['id_tipo_habitacion']))
		{
			$temp=$this->read($data['id_tipo_habitacion']);
		}
		if (!empty($temp))
		{
			$this->db->where('id_tipo_habitacion',$data['id_tipo_habitacion']);
			$this->db->update('tipo_habitacion',$data);
			$id=$data['id_tipo_habitacion'];
		}
		else
		{
			$this->db->insert('tipo_habitacion',$data);
			$id=$this->db->insert_id();
		}

		return $id;
	}
	function tiene_costo_asociado($id_detalle_tipo_habitacion)
	{
		$this->db->where('id_detalle_tipo_habitacion', $id_detalle_tipo_habitacion);
		$result = $this->db->get('costo')->result();
		return (empty($result)) ? FALSE : TRUE;
	}
	
	function insert_costos_deprecado($data)
	{
		if (!empty($data))
		{
			if(isset($data[0]['id_tipo_habitacion']) && $this->tiene_costo_asociado($data[0]['id_tipo_habitacion']))
			{
				$this->db->where('id_tipo_habitacion',$data[0]['id_tipo_habitacion']);
				$this->db->delete('costo');
			}
			//OJO: Mejorar y colocar un insert_batch
			foreach($data as $info)
			{
				$this->db->insert('costo', $info);
			}
		}
	}
	
	function guardar_costos($data)
	{
		$temporada_alta = array('id_temporada' 					=> 2,
								'id_moneda'						=> $data['id_moneda'],
								'id_detalle_tipo_habitacion'	=> $data['id_detalle_tipo_habitacion'],
								'valor'							=> $data['costo_alta']);
		
		$temporada_baja = array('id_temporada' 					=> 1,
								'id_moneda'						=> $data['id_moneda'],
								'id_detalle_tipo_habitacion'	=> $data['id_detalle_tipo_habitacion'],
								'valor'							=> $data['costo_baja']);
		
		if($this->tiene_costo_asociado($data['id_detalle_tipo_habitacion']))
		{
			$this->db->where('id_detalle_tipo_habitacion', $temporada_alta['id_detalle_tipo_habitacion']);
			$this->db->where('id_temporada', $temporada_alta['id_temporada']);
			unset($temporada_alta['id_detalle_tipo_habitacion']);
			unset($temporada_alta['id_temporada']);
			$this->db->update('costo', $temporada_alta);
			
			$this->db->where('id_detalle_tipo_habitacion', $temporada_baja['id_detalle_tipo_habitacion']);
			$this->db->where('id_temporada', $temporada_baja['id_temporada']);
			unset($temporada_baja['id_detalle_tipo_habitacion']);
			unset($temporada_baja['id_temporada']);
			$this->db->update('costo', $temporada_baja);
		}
		else
		{
			$this->db->insert('costo', $temporada_alta);
			$this->db->insert('costo', $temporada_baja);
		}
	}
	
	function update_idioma($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		$d=array('id_idioma'=>$data['id_idioma'],'id_tipo_habitacion'=>$data['id_tipo_habitacion']);
		if (isset($data['id_detalle_tipo_habitacion']) && $ob=$this->exists('detalle_tipo_habitacion',$d)){
			if (isset($data['id_detalle_tipo_habitacion'])){
				$this->db->where('id_detalle_tipo_habitacion',$data['id_detalle_tipo_habitacion']);
				$id=$data['id_detalle_tipo_habitacion'];
			}else{
				$this->db->where($d);
				$id=$ob->id_detalle_tipo_habitacion;
			}
			$this->db->update('detalle_tipo_habitacion',$data);

		}else{
			unset($data['id_detalle_tipo_habitacion']);
			$this->db->insert('detalle_tipo_habitacion',$data);
			$id=$this->db->insert_id();
		}
		return $id;
	}
	function delete($id){
		$data['id_estado'] = 3;
		$this->db->where('id_tipo_habitacion',$id);
		return $this->db->update('tipo_habitacion',$data);
	}

	function eliminar_idioma($id){
		if ($this->db->delete('detalle_tipo_habitacion', array('id_detalle_tipo_habitacion' => $id)))
			return true;
		else return false;
	}

	function exists($table,$key=array()){

		$this->db->where($key);
		$q=$this->db->get($table);
		if ($q->num_rows()>=1) return $q->row();
		else return false;
	}

	function get_tipo_habitacion_titulos_urls(){
		$this->db->select('tipo_habitacion.id_tipo_habitacion as id, detalle_tipo_habitacion.nombre as nombre, detalle_tipo_habitacion.url as url');
		$this->db->join('detalle_tipo_habitacion', 'tipo_habitacion.id_tipo_habitacion = detalle_tipo_habitacion.id_tipo_habitacion');
		$query = $this->db->get('tipo_habitacion');
		return $query->result();
	}

	function guardar_rel_imagen($data){
		$this->db->insert('rel_tipo_habitacion_multimedia', $data);
	}

	function guardar_imagen($data){
		$this->db->insert('multimedia', $data);
		$id = $this->db->insert_id();
		return $id;
	}
	
	function get_costos_tipo_habitacion_deprecado($id_tipo_habitacion)
	{
		$this->db->where('id_tipo_habitacion', $id_tipo_habitacion);
		return $this->db->get('costo')->result();
		
	}
	
	function get_costos_tipo_habitacion($id_detalle_tipo_habitacion)
	{
		if(!empty($id_detalle_tipo_habitacion))
		{
			$this->db->select('c.*, m.nombre as moneda');
			$this->db->join('moneda m', 'm.id_moneda = c.id_moneda');
			
			if(is_array($id_detalle_tipo_habitacion))
			{
				$this->db->where_in('c.id_detalle_tipo_habitacion', $id_detalle_tipo_habitacion);
			}
			else $this->db->where('c.id_detalle_tipo_habitacion', $id_detalle_tipo_habitacion);
			
			return $this->db->get('costo c')->result();
		}
	}
	
	function get_id_tipo_habitacion_url($url)
	{
		$this->db->where('dp.url', $url);
		
		$query 		= $this->db->get('detalle_tipo_habitacion dp');
		$resultado 	= $query->result();
		
		if($query->num_rows() > 0)
		{
			return $resultado[0]->id_tipo_habitacion;
		}
		else
		{
			return FALSE;
		}
	}
	
}
