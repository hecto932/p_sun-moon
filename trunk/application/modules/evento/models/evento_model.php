<?php

class evento_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->model('idioma/idioma_model','idioma_model');
		$this->idioma=idioma_model::get_from_code($this->session->userdata('idioma'));
	}

	function add_pago_evento($id, $pagos){
		$temp = '';
		foreach ($pagos as $key => $id_pago) {
			$this->db->where('rel_evento_pago.id_evento', $id);
			$this->db->where('rel_evento_pago.id_tipo_pago', $id_pago);
			$query = $this->db->get('rel_evento_pago');
			if($query->num_rows() != 1){
				$var_batch[] = array('id_evento' => $id, 'id_tipo_pago' => $id_pago);
			}

		}
		if(isset($var_batch)){
			$this->db->insert_batch('rel_evento_pago', $var_batch);
		}
	}

	function del_pago_evento($id, $pagos){
		foreach($pagos as $pago){
			$this->db->where('rel_evento_pago.id_evento', $id);
			$this->db->where('rel_evento_pago.id_tipo_pago', $pago);
			$this->db->delete('rel_evento_pago');
		}
	}

	function create($data)
	{
		$this->db->insert('evento',$data);
		return $this->db->insert_id();
	}
	
	function add_section($section,$id)
	{
		$this->db->where('id',$id);
		$this->db->insert('evento',$section);
	}

	function read($id, $id_detalle_evento='', $idioma='')
	{
		$this->db->select('evento.*,detalle_evento.*, evento.id_evento as id_evento');
		//$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		if ($id_detalle_evento!=''){
			$this->db->where('detalle_evento.id_detalle_evento',$id_detalle_evento);
			$this->db->join('detalle_evento','evento.id_evento = detalle_evento.id_evento');
		}
		else{
			$this->db->join('detalle_evento','evento.id_evento = detalle_evento.id_evento', 'left');
		}
		$this->db->where('evento.id_evento', $id);
		$this->db->group_by('evento.id_evento');
		$q = $this->db->get('evento');
		//echo $this->db->last_query();
		if ($q->num_rows()==1)
			return $q->row();
		else
			return $q->result();
	}

	function read_rel_evento_pago($id){
		$this->db->select('rel_evento_pago.*');
		$this->db->where('rel_evento_pago.id_evento', $id);
		$query = $this->db->get('rel_evento_pago');
		return $query->result();
	}

	function get($id, $idioma=''){
		$this->db->select('evento.*, detalle_evento.*, evento.id_evento as id_evento');
		$this->db->join('detalle_evento', 'detalle_evento.id_evento = evento.id_evento');
		if($idioma != ''){
			$this->db->where('detalle_evento.id_idioma', $idioma);
		}
		$this->db->where('evento.id_evento', $id);
		$query = $this->db->get('evento')->first_row();
		
		if ( ! empty($query))
			$query->ficheros = array();
		
		//Buscar ficheros multimedia
		$this->db->select('multimedia.fichero');
		$this->db->where('id_evento', $id);
		$this->db->join('multimedia', 'multimedia.id_multimedia = rel_evento_multimedia.id_multimedia');
		$multimedia = $this->db->get('rel_evento_multimedia')->result();
		
		foreach ($multimedia as $fichero)
			$query->ficheros[] = $fichero->fichero;
		
		return $query;
	}

	function get_tipo_pago(){
		$this->db->select('tipo_pago.*');
		$query = $this->db->get('tipo_pago');
		return $query->result();
	}

	function get_rel_evento_pago($id){
		$this->db->select('rel_evento_pago.id_tipo_pago');
		$this->db->where('rel_evento_pago.id_evento', $id);
		$query = $this->db->get('rel_evento_pago');
		$result = array();
		foreach($query->result() as $pago){
			$result[$pago->id_tipo_pago] = TRUE;
		}
		return $result;
	}
	
	function exist_url($url='')
	{
		$query = $this->db->get_where('detalle_evento',array('url'=>$url));
		return ($query->num_rows() > 0) ? TRUE : FALSE;
	}

	function get_by_id($id_evento)
	{
		$this->db->select('evento.*,evento.id_evento as id_evento, detalle_evento.*, multimedia.fichero');
		$this->db->join('detalle_evento', 'evento.id_evento = detalle_evento.id_evento');
		$this->db->join('rel_evento_multimedia', 'evento.id_evento = rel_evento_multimedia.id_evento', 'left');
		$this->db->join('multimedia', 'multimedia.id_multimedia = rel_evento_multimedia.id_multimedia', 'left');
		$this->db->where('evento.id_evento', $id_evento);
		$q=$this->db->get('evento');
		
		return $q->result();
	}

	function get_posts($num_posts, $orden = 'desc', $donde = array()){
		$this->db->select('evento.*,evento.id_evento as id_evento, detalle_evento.*, multimedia.fichero');
		$this->db->join('detalle_evento', 'evento.id_evento = detalle_evento.id_evento');
		$this->db->join('rel_evento_multimedia', 'evento.id_evento = rel_evento_multimedia.id_evento', 'left');
		$this->db->join('multimedia', 'multimedia.id_multimedia = rel_evento_multimedia.id_multimedia', 'left');
		if (!empty($donde))
		{
			foreach($donde as $condicion => $valor)
			{
				$this->db->where($condicion, $valor);
			}
		}
		$this->db->order_by('evento.fecha_evento', $orden);
		$query = $this->db->get('evento', $num_posts);
		return $query->result();
	}

	function get_posts_noimage($num_posts, $orden = 'desc', $donde = array()){
		$this->db->select('evento.*,evento.id_evento as id_evento, detalle_evento.*');
		$this->db->join('detalle_evento', 'evento.id_evento = detalle_evento.id_evento');
		if (!empty($donde))
		{
			foreach($donde as $condicion => $valor)
			{
				$this->db->where($condicion, $valor);
			}
		}
		$this->db->order_by('evento.fecha_evento', $orden);
		$query = $this->db->get('evento', $num_posts);
		
		//echo '<pre>'.print_r($query->result(),true).'</pre>'.'<pre>'.$this->db->last_query().'</pre>';die();
		return $query->result();
	}

	function get_last_five_post(){
		$this->db->select('evento.id_evento as id, detalle_evento.nombre as nombre, detalle_evento.url as url, detalle_evento.titulo_pagina as titulo_pagina');
		$this->db->join('detalle_evento', 'evento.id_evento = detalle_evento.id_evento');
		$this->db->order_by('evento.fecha_evento','desc');
		$query = $this->db->get('evento', 5);
		return $query->result();
	}

	function get_tipo_evento(){
		$this->db->select('tipo_evento.*');
		$query = $this->db->get('tipo_evento');
		return $query->result();
	}

	function get_tipo_evento_dropdown(){
		$this->db->select('tipo_evento.*');
		$query = $this->db->get('tipo_evento');
		$array_eventos = $query->result();
		$result = array();
		if(count($array_eventos) > 0){
			foreach($array_eventos as $value){
				$result[$value->id_tipo_evento] = $value->nombre_tipo;
			}
		}
		return $result;
	}

	function get_id_from_url($url)
	{
		// $this->db->select('detalle_evento.id_evento');
		$this->db->join('evento','evento.id_evento = detalle_evento.id_evento');
		$this->db->where('evento.id_estado',1);
		$this->db->where('detalle_evento.url', $url);
		$this->db->order_by('evento.modificado','desc');
		$query = $this->db->get('detalle_evento');
		// die_pre($query->first_row());
		return $query->row()->id_evento;
	}

	function get_image($id_evento)
	{
		$this->db->select('multimedia.fichero');
		//$this->db->join('rel_evento_multimedia', 'rel_evento_multimedia.id_evento = evento.id_evento');
		$this->db->join('multimedia', 'multimedia.id_multimedia = rel_evento_multimedia.id_multimedia');
		//$this->db->join('evento', 'evento.id_evento = rel_evento_multimedia.id_evento');
		$this->db->where('rel_evento_multimedia.id_evento', $id_evento);
		$q=$this->db->get('rel_evento_multimedia');
		return $q->result();
	}

	function detalles($id_evento, $id_detalle = '', $idioma = ''){
		$this->db->join('detalle_evento','evento.id_evento = detalle_evento.id_evento');
		if($id_detalle != '')
		{
			$this->db->where('detalle_evento.id_detalle_evento', $id_detalle);
		}
		if($idioma != '')
		{
			$this->db->where('detalle_evento.id_idioma', $idioma);
		}
		$this->db->where('evento.id_evento',$id_evento);
		$q=$this->db->get('evento');
		return $q->result();
	}

	function get_all($idioma=''){
		$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		$this->db->join('detalle_evento','evento.id_evento=detalle_evento.id_evento');
		$this->db->where('detalle_evento.id_idioma',$idioma);
		$q=$this->db->get('evento');
		return $q->result();
	}

	function get_all_public($idioma=''){
		$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		$this->db->select('evento.*,evento.id_evento as id_evento, detalle_evento.*, multimedia.fichero');
		$this->db->join('detalle_evento','evento.id_evento=detalle_evento.id_evento');
		$this->db->join('rel_evento_multimedia', 'evento.id_evento = rel_evento_multimedia.id_evento', 'left');
		$this->db->join('multimedia', 'multimedia.id_multimedia = rel_evento_multimedia.id_multimedia', 'left');
		$this->db->where('detalle_evento.id_idioma',$idioma);
		$this->db->where('evento.id_estado','1');
		$q=$this->db->get('evento');
		return $q->result();
	}

	function get_all_years($idioma=''){
		$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		$this->db->join('detalle_evento','evento.id_evento=detalle_evento.id_evento');
		$this->db->where('detalle_evento.id_idioma',$idioma);
		$this->db->distinct();
		$this->db->select('YEAR(`creado`) as year');
		$this->db->order_by('creado','desc');
		$q=$this->db->get('evento');
		return $q->result_array();
	}

	function get_list($f='evento.id_evento',$v=1,$group=false){

		$this->db->join('detalle_evento','evento.id_evento=detalle_evento.id_evento');
		$this->db->where($f,$v);
		if ($group) $this->db->group_by('evento.id_evento');
		$q=$this->db->get('evento');
		return $q->result();
	}

	function get_page($start = 0, $count = 10, $order_field='evento.id_evento', $order_dir = '', $call = 'back',  $terminos_busqueda = array()){
		switch ($order_field) {
			case 'id_evento';
				$order_field='evento.id_evento';
			break;
			default :
				$order_field=$order_field;
			break;
		}


		$this->db->select('evento.*, detalle_evento.id_detalle_evento, detalle_evento.id_idioma, detalle_evento.nombre, detalle_evento.subtitulo, detalle_evento.url,
		detalle_evento.id_idioma, detalle_evento.descripcion_breve, detalle_evento.descripcion_ampliada, detalle_evento.lugar_evento, detalle_evento.centros_pago,
		detalle_evento.descripcion_pagina, detalle_evento.keywords, detalle_evento.titulo_pagina, group_concat(m1.fichero) as ficheros1, group_concat(m2.fichero) as ficheros2, group_concat(m4.fichero) as ficheros4', FALSE);
		if($call == 'back'){
			$this->db->join('detalle_evento','evento.id_evento=detalle_evento.id_evento','left');
		}
		else{
			$this->db->join('detalle_evento','evento.id_evento=detalle_evento.id_evento');
		}
		$this->db->join('rel_evento_multimedia', 'evento.id_evento = rel_evento_multimedia.id_evento', 'left');
		//$this->db->join('multimedia', 'multimedia.id_multimedia = rel_evento_multimedia.id_multimedia', 'left');
		$this->db->join('multimedia m1', 'm1.id_multimedia = rel_evento_multimedia.id_multimedia AND m1.destacado = 1', 'left');
		$this->db->join('multimedia m2', 'm2.id_multimedia = rel_evento_multimedia.id_multimedia AND m2.destacado = 2', 'left');
		$this->db->join('multimedia m4', 'm4.id_multimedia = rel_evento_multimedia.id_multimedia AND m4.destacado = 4', 'left');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if (($field=='evento.id_producto' || $field='detalle_evento.id_idioma') && $value!=''){
					$this->db->where($field,$value);
                }elseif ($field=='texto' && $value!=''){
                    //$this->db->join('detalle_evento','detalle_evento.id_evento=evento.id_evento');
                    $this->db->where("(detalle_evento.descripcion_breve LIKE '%$value%' OR detalle_evento.nombre LIKE '%$value%' OR detalle_evento.descripcion_ampliada LIKE '%$value%')");

				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		if($call == 'front')
			$this->db->where('evento.id_estado',1);
			
		$this->db->group_by('evento.id_evento');
		if($call == 'front')
			$this->db->order_by('evento.fecha_evento',$order_dir);
		else
			$this->db->order_by($order_field,$order_dir);
		
		$q=$this->db->get('evento',$count,$start);
		//echo '<pre>'.print_r($q->result(),true).'</pre>'.'<pre>'.$this->db->last_query().'</pre>';die();
		$result = $q->result();
		// die_pre($this->db->last_query());
		foreach ($result as $k => $evento)
		{
			if (strlen($evento->ficheros1))
				$result[$k]->ficheros1 = explode(",",$evento->ficheros1);
			if (strlen($evento->ficheros2))
				$result[$k]->ficheros2 = explode(",",$evento->ficheros2);
			if (strlen($evento->ficheros4))
				$result[$k]->ficheros4 = explode(",",$evento->ficheros4);
		}
		
		return $result;
	}
	
	
	function get_page_home($start = 0, $count = 10, $order_field='evento.id_evento', $order_dir = '', $call = 'back',  $terminos_busqueda = array()){
		switch ($order_field) {
			case 'id_evento';
				$order_field='evento.id_evento';
			break;
			default :
				$order_field=$order_field;
			break;
		}


		$this->db->select('evento.*, detalle_evento.id_detalle_evento, detalle_evento.nombre, detalle_evento.subtitulo, detalle_evento.url,
		detalle_evento.id_idioma, detalle_evento.descripcion_breve, detalle_evento.descripcion_ampliada, detalle_evento.lugar_evento, detalle_evento.centros_pago,
		detalle_evento.descripcion_pagina, detalle_evento.keywords, detalle_evento.titulo_pagina, group_concat(m1.fichero) as ficheros1, group_concat(m2.fichero) as ficheros2, group_concat(m4.fichero) as ficheros4', FALSE);
		if($call == 'back'){
			$this->db->join('detalle_evento','evento.id_evento=detalle_evento.id_evento','left');
		}
		else{
			$this->db->join('detalle_evento','evento.id_evento=detalle_evento.id_evento');
		}
		$this->db->join('rel_evento_multimedia', 'evento.id_evento = rel_evento_multimedia.id_evento', 'left');
		//$this->db->join('multimedia', 'multimedia.id_multimedia = rel_evento_multimedia.id_multimedia', 'left');
		$this->db->join('multimedia m1', 'm1.id_multimedia = rel_evento_multimedia.id_multimedia AND m1.destacado = 1', 'left');
		$this->db->join('multimedia m2', 'm2.id_multimedia = rel_evento_multimedia.id_multimedia AND m2.destacado = 2', 'left');
		$this->db->join('multimedia m4', 'm4.id_multimedia = rel_evento_multimedia.id_multimedia AND m4.destacado = 4', 'left');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='evento.id_producto' && $value!=''){
					$this->db->where($field,$value);
                }elseif ($field=='texto' && $value!=''){
                    //$this->db->join('detalle_evento','detalle_evento.id_evento=evento.id_evento');
                    $this->db->where("(detalle_evento.descripcion_breve LIKE '%$value%' OR detalle_evento.nombre LIKE '%$value%' OR detalle_evento.descripcion_ampliada LIKE '%$value%')");

				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		$this->db->where('evento.id_estado',1);
		$this->db->where('evento.section',2);
		$this->db->group_by('evento.id_evento');
		if($call == 'front')
			$this->db->order_by('evento.fecha_evento',$order_dir);
		else
			$this->db->order_by($order_field,$order_dir);
		
		$q=$this->db->get('evento',$count,$start);
		//echo '<pre>'.print_r($q->result(),true).'</pre>'.'<pre>'.$this->db->last_query().'</pre>';die();
		$result = $q->result();
		
		foreach ($result as $k => $evento)
		{
			if (strlen($evento->ficheros1))
				$result[$k]->ficheros1 = explode(",",$evento->ficheros1);
			if (strlen($evento->ficheros2))
				$result[$k]->ficheros2 = explode(",",$evento->ficheros2);
			if (strlen($evento->ficheros4))
				$result[$k]->ficheros4 = explode(",",$evento->ficheros4);
		}
		
		return $result;
	}



	function get_estado(){
		$this->db->select('evento.*, detalle_evento.*, multimedia.*');
		$this->db->join('detalle_evento', 'evento.id_evento = detalle_evento.id_evento', 'left');
		$this->db->join('rel_evento_multimedia', 'evento.id_evento = rel_evento_multimedia.id_evento', 'left');
		$this->db->join('multimedia', 'multimedia.id_multimedia = rel_evento_multimedia.id_multimedia', 'left');
		$query = $this->db->get('evento');
		return $query->result();
	}


	function count_all($terminos_busqueda=array()){
		$this->db->select('count(*) as num_eventos');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='evento.id_evento' && $value!=''){
					$this->db->where($field,$value);

                }elseif ($field=='texto' && $value!=''){
                    $this->db->join('detalle_evento','detalle_evento.id_evento=evento.id_evento');
					$this->db->where("(detalle_evento.descripcion_breve LIKE '%$value%' OR detalle_evento.nombre LIKE '%$value%' OR detalle_evento.descripcion_ampliada LIKE '%$value%')");
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		//$this->db->group_by('evento.id_evento');
		$q=$this->db->get('evento');
		//echo $this->db->last_query();
		$ret=$q->row();
		return $ret->num_eventos;
	}

	function update($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		if (isset($data['id_evento'])){
			$evento=$this->read($data['id_evento']);
		}
		//echo '<pre>'.print_r($evento,true).'</pre>';
		if (!empty($evento)){
			$this->db->where('id_evento',$data['id_evento']);
			$this->db->update('evento',$data);
			$id=$data['id_evento'];
		}else{
			$data['creado']=date('Y-m-d H:i:s');
			$this->db->insert('evento',$data);
			$id=$this->db->insert_id();
		}

		return $id;
	}

	function update_idioma($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';die();
		$d=array('id_idioma'=>$data['id_idioma'],'id_evento'=>$data['id_evento']);
		if (isset($data['id_detalle_evento']) && $ob=$this->exists('detalle_evento',$d)){
			if (isset($data['id_detalle_evento'])){
				$this->db->where('id_detalle_evento',$data['id_detalle_evento']);
				$id=$data['id_detalle_evento'];
			}else{
				$this->db->where($d);
				$id=$ob->id_detalle_evento;
			}
			$this->db->update('detalle_evento',$data);

		}else{
			//echo '<pre>'.print_r($data, true).'</pre>'; die();
			//$data['id_detalle_evento'] = $this->db->count_all('detalle_evento') + 1;
			unset($data['id_detalle_evento']);
			$this->db->insert('detalle_evento',$data);
			$id=$this->db->insert_id();
		}
		return $id;
	}

	function delete($id){
		/*
		$imagenes=modules::run('services/relations/get_rel','evento','imagen',$id,'true');
		foreach(json_decode($imagenes) as $img){
			if (is_file(FCPATH.'assets/img/temp/'.$img->fichero)) unlink( FCPATH.'assets/img/temp/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/med/'.$img->fichero)) unlink( FCPATH.'assets/img/med/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/thumb/'.$img->fichero)) unlink( FCPATH.'assets/img/thumb/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/large/'.$img->fichero)) unlink( FCPATH.'assets/img/large/'.$img->fichero);
		}
		if ($this->db->delete('evento', array('id_evento' => $id)))
			return true;
		else return false;
		*/
		$data['id_estado'] = 3;
		$this->db->where('id_evento',$id);
		return $this->db->update('evento',$data);
	}

	function eliminar_idioma($id){
		if ($this->db->delete('detalle_evento', array('id_detalle_evento' => $id)))
			return true;
		else return false;
	}

	function exists($table,$key=array()){

		$this->db->where($key);
		$q=$this->db->get($table);
		if ($q->num_rows()>=1) return $q->row();
		else return false;
	}

	function get_evento_titulos_urls(){
		$this->db->select('evento.id_evento as id, detalle_evento.nombre as nombre, detalle_evento.url as url');
		$this->db->join('detalle_evento', 'evento.id_evento = detalle_evento.id_evento');
		$query = $this->db->get('evento');
		return $query->result();
	}

	function guardar_rel_imagen($data){
		$this->db->insert('rel_evento_multimedia', $data);
	}

	function guardar_imagen($data){
		$this->db->insert('multimedia', $data);
		$id = $this->db->insert_id();
		return $id;
	}

	function operacion_fecha($fecha,$dias) 
	{
		$fecha_sin_horas=explode(" ",$fecha); 	
		list ($ano,$mes,$dia)=explode("-",$fecha_sin_horas[0]);
		if (!checkdate($mes,$dia,$ano)){return false;} 
		$dia=$dia+$dias; 
		$fecha=date( "Y-m-d", mktime(0,0,0,$mes,$dia,$ano) );
		$fecha_2=$fecha.' 00:00:00';
		return $fecha; 
	}

	function get_eventos_fecha($fecha1='', $fecha2='', $id_idioma = 1)
	{
		$evento_total = array();
		$i=1;		
		while(($fecha1<=$fecha2)&&($i<=5))
		{
			$this->db->select('evento.*, detalle_evento.id_detalle_evento, detalle_evento.id_idioma, detalle_evento.nombre, detalle_evento.subtitulo, detalle_evento.url,
			detalle_evento.descripcion_breve, detalle_evento.descripcion_ampliada, detalle_evento.id_idioma, detalle_evento.descripcion_breve,
			detalle_evento.descripcion_pagina, detalle_evento.keywords, detalle_evento.titulo_pagina, group_concat(m1.fichero) as ficheros1', FALSE);
			$this->db->join('detalle_evento','evento.id_evento=detalle_evento.id_evento');
			$this->db->join('rel_evento_multimedia', 'evento.id_evento = rel_evento_multimedia.id_evento', 'left');
			$this->db->join('multimedia m1', 'm1.id_multimedia = rel_evento_multimedia.id_multimedia AND m1.destacado = 1', 'left');
		    $this->db->where('evento.id_estado', '1');
			$this->db->where('detalle_evento.id_idioma', $id_idioma);
			$this->db->like('evento.fecha_evento', $fecha1);
			$this->db->group_by('evento.id_evento');
			$this->db->order_by('evento.fecha_evento','DESC'); 
			$evento = $this->db->get('evento')->result();
			
			$evento_total = array_merge($evento_total,$evento);
			$fecha1= $this->operacion_fecha($fecha1, '1');
			if(count($evento)==1)
			$i=$i+1;
		}

		foreach ($evento_total as $k => $evento)
		{
			if (strlen($evento->ficheros1))
				$evento_total[$k]->ficheros1 = explode(",",$evento->ficheros1);
		}
	
		//die("<pre>".print_r($evento_total, TRUE). $this->db->last_query() ."</pre>");
		return $evento_total;
	}

	function get_id_from($tabla,$unique,$type)
	{
		$query = $this->db->get_where($tabla,array($type => $unique));
		if($query->num_rows() == 0)
			return FALSE;
		$query = $query->result();
		if($type == 'cedula')
			return $query[0]->id_usuario;
		if($type == 'rif')
			return $query[0]->id_empresa;
	}

	function set_usuario_evento($usuario)
	{
		$query = $this->db->get_where('usuario_evento',array('cedula' => $usuario['cedula']));
		
		if($query->num_rows() == 0)
		{
			$this->db->insert('usuario_evento', $usuario);
			$id = $this->db->insert_id();
		}else
		{
			$query = $query->result();
			$id = $query[0]->id_usuario;
		}
		return $id;
	}

	function set_evento_inscripcion($inscripcion)
	{
		$filters = array
		(
			'id_evento' => $inscripcion['id_evento'], 'id_usuario' => $inscripcion['id_usuario'],
			'id_usuario_contacto' => $inscripcion['id_usuario_contacto']
		);
		
		$query = $this->db->get_where('evento_inscripcion',$filters);
		if($query->num_rows() == 0)
		{
			$this->db->insert('evento_inscripcion', $inscripcion);
			$id = $this->db->insert_id();
		}else
		{
			$query = $query->result();
			$id = $query[0]->id_inscripcion;
		}
		//die("<pre>".print_r($query, TRUE). $this->db->last_query() ."</pre>");
		return $id;
	}
	
	function set_factura($factura)
	{
		$this->db->insert('evento_factura', $factura);
		$id = $this->db->insert_id();
		return $id;
	}

	function set_evento_empresa($empresa)
	{
		$query = $this->db->get_where('evento_empresa',array('rif' => $empresa['rif'],'email'=>$empresa['email']));
		
		if($query->num_rows() == 0)
		{
			$this->db->insert('evento_empresa', $empresa);
			$id = $this->db->insert_id();
		}else
		{
			$query = $query->result();
			$id = $query[0]->id_empresa;
		}
		return $id;
	}

	function set_evento_empresa_usuario($relacion)
	{
		$query = $this->db->get_where('evento_empresa_usuario',array('id_empresa' => $relacion['id_empresa'],'id_usuario' => $relacion['id_usuario']));
		if($query->num_rows() == 0)
			$this->db->insert('evento_empresa_usuario', $relacion);
	}
}
