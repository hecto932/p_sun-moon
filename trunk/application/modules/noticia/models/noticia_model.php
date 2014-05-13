<?php

class Noticia_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->model('idioma/idioma_model','idioma_model');
		$this->idioma=idioma_model::get_from_code($this->session->userdata('idioma'));
	}

	function create($data)
	{
		$this->db->insert('noticia',$data);
		return $this->db->insert_id();
	}

	function get($id, $idioma=''){
		$this->db->select('noticia.*, detalle_noticia.*, noticia.id_noticia as id_noticia');
		$this->db->join('detalle_noticia', 'detalle_noticia.id_detalle_noticia = noticia.id_noticia');
		if($idioma != ''){
			$this->db->join('idioma', 'detalle_noticia.id_idioma = idioma.id_idioma');
			$this->db->where('idioma.idioma', $idioma);
		}
		$this->db->where('noticia.id_noticia', $id);
		$query = $this->db->get('noticia');
		return $query->row();
	}

	function read($id, $id_detalle_noticia='', $idioma='')
	{
		$this->db->select('noticia.*,detalle_noticia.*,noticia.id_noticia as id_noticia');
		//$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		if ($id_detalle_noticia!='') $this->db->where('detalle_noticia.id_detalle_noticia',$id_detalle_noticia);
		$this->db->join('detalle_noticia','noticia.id_noticia=detalle_noticia.id_noticia','left');
		//$this->db->where('detalle_noticia.id_idioma', $idioma);
		$this->db->where('noticia.id_noticia', $id);
		$q=$this->db->get('noticia');
		return $q->row();
	}

	function get_posts($num_posts, $orden = 'desc', $donde = array()){
		$this->db->select('noticia.id_noticia as id, detalle_noticia.id_idioma, noticia.creado as fecha_creacion, detalle_noticia.nombre as nombre, detalle_noticia.url as url, detalle_noticia.titulo_pagina as titulo_pagina, detalle_noticia.descripcion_breve as descripcion_breve, multimedia.fichero');
		$this->db->join('detalle_noticia', 'noticia.id_noticia = detalle_noticia.id_noticia');
		$this->db->join('rel_noticia_multimedia', 'rel_noticia_multimedia.id_noticia = noticia.id_noticia', 'left');
		$this->db->join('multimedia', 'multimedia.id_multimedia = rel_noticia_multimedia.id_multimedia', 'left');
		if(!empty($donde)){
			foreach($donde as $condicion => $valor){
				$this->db->where($condicion, $valor);
			}
		}
		$this->db->order_by('noticia.creado', $orden);
		$query = $this->db->get('noticia', $num_posts);
		return $query->result();
	}
	
	function get_posts_economicas($num_posts, $orden = 'desc', $donde = array())
	{
		$this->db->select('noticia.id_noticia as id, noticia.creado as fecha_creacion, noticia.seccion as seccion, detalle_noticia.nombre as nombre, detalle_noticia.url as url, detalle_noticia.titulo_pagina as titulo_pagina, detalle_noticia.descripcion_breve as descripcion_breve, multimedia.fichero');
		$this->db->join('detalle_noticia', 'noticia.id_noticia = detalle_noticia.id_noticia');
		$this->db->join('rel_noticia_multimedia', 'rel_noticia_multimedia.id_noticia = noticia.id_noticia', 'left');
		$this->db->join('multimedia', 'multimedia.id_multimedia = rel_noticia_multimedia.id_multimedia', 'left');
		$this->db->where('seccion','economia');
		$this->db->or_where('seccion','ambas');
		if(!empty($donde)){
			foreach($donde as $condicion => $valor){
				$this->db->where($condicion, $valor);
			}
		}
		$this->db->order_by('noticia.creado', $orden);
		$query = $this->db->get('noticia', $num_posts);
		return $query->result();
	}

	function get_last_five_post(){
		$this->db->select('noticia.id_noticia as id, detalle_noticia.nombre as nombre, detalle_noticia.url as url, detalle_noticia.titulo_pagina as titulo_pagina');
		$this->db->join('detalle_noticia', 'noticia.id_noticia = detalle_noticia.id_noticia');
		$this->db->order_by('noticia.creado','desc');
		$query = $this->db->get('noticia', 5);
		return $query->result();
	}

	function get_image($id_noticia)
	{
		$this->db->select('multimedia.*');
		//$this->db->join('rel_noticia_multimedia', 'rel_noticia_multimedia.id_noticia = noticia.id_noticia');
		$this->db->join('multimedia', 'multimedia.id_multimedia = rel_noticia_multimedia.id_multimedia');
		//$this->db->where('noticia.id_noticia', $id_noticia);
		$q=$this->db->get('rel_noticia_multimedia');

	}

	function detalles($id_noticia, $id_detalle = '', $idioma = ''){
		$this->db->join('detalle_noticia','noticia.id_noticia = detalle_noticia.id_noticia');
		if($id_detalle != '')
		{
			$this->db->where('detalle_noticia.id_idioma', $id_detalle);
		}
		if($idioma != '')
		{
			$this->db->where('detalle_noticia.id_idioma', $idioma);
		}
		$this->db->where('noticia.id_noticia',$id_noticia);
		$q=$this->db->get('noticia');
		return $q->result();
	}

	function get_all($idioma=''){
		$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		$this->db->join('detalle_noticia','noticia.id_noticia=detalle_noticia.id_noticia');
		$this->db->where('detalle_noticia.id_idioma',$idioma);
		$q=$this->db->get('noticia');
		return $q->result();
	}

	function get_all_years($idioma=''){
		$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		$this->db->join('detalle_noticia','noticia.id_noticia=detalle_noticia.id_noticia');
		$this->db->where('detalle_noticia.id_idioma',$idioma);
		$this->db->distinct();
		$this->db->select('YEAR(`creado`) as year');
		$this->db->order_by('creado','desc');
		$q=$this->db->get('noticia');
		return $q->result_array();
	}

	function get_list($f='noticia.id_noticia',$v=1,$group=false){

		$this->db->join('detalle_noticia','noticia.id_noticia=detalle_noticia.id_noticia');
		$this->db->where($f,$v);
		if ($group) $this->db->group_by('noticia.id_noticia');
		$q=$this->db->get('noticia');
		return $q->result();
	}

	function get_page($start = 0, $count = 10, $order_field='noticia.id_noticia', $order_dir = 'desc', $call = 'back', $terminos_busqueda = array()){
		switch ($order_field) {
			case 'id_noticia';
				$order_field='noticia.id_noticia';
			break;
			default :
				$order_field=$order_field;
			break;
		}


		$this->db->select('noticia.*,detalle_noticia.*, noticia.id_noticia as id_noticia, multimedia.fichero');
		if($call == 'back'){
			$this->db->join('detalle_noticia','noticia.id_noticia=detalle_noticia.id_noticia','left');
		}
		else{
			$this->db->join('detalle_noticia','noticia.id_noticia=detalle_noticia.id_noticia');
		}

		$this->db->join('rel_noticia_multimedia', 'noticia.id_noticia = rel_noticia_multimedia.id_noticia', 'left');
		$this->db->join('multimedia', 'multimedia.id_multimedia = rel_noticia_multimedia.id_multimedia', 'left');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if (($field=='noticia.id_noticia' || $field=='detalle_noticia.id_idioma') && $value!=''){
					$this->db->where($field,$value);
                }elseif ($field=='texto' && $value!=''){
                    //$this->db->join('detalle_noticia','detalle_noticia.id_noticia=noticia.id_noticia');
                    $this->db->where("(detalle_noticia.descripcion_breve LIKE '%$value%' OR detalle_noticia.nombre LIKE '%$value%' OR detalle_noticia.descripcion_ampliada LIKE '%$value%')");

				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		$this->db->group_by('noticia.id_noticia');
		$this->db->order_by($order_field,$order_dir);
		$q=$this->db->get('noticia',$count,$start);

		return $q->result();
	}



	function count_all($terminos_busqueda=array(), $call = 'back'){
		$this->db->select('count(*) as num_noticias');
		if($call != 'back'){
			$this->db->join('detalle_noticia', 'detalle_noticia.id_noticia = noticia.id_noticia');
		}
		else{
			if (!empty($terminos_busqueda)){
				foreach($terminos_busqueda as $field=>$value){
					if ($field=='noticia.id_noticia' && $value!=''){
						$this->db->where($field,$value);

	                }elseif ($field=='texto' && $value!=''){
	                    $this->db->join('detalle_noticia','detalle_noticia.id_noticia=noticia.id_noticia');
						$this->db->where("(detalle_noticia.descripcion_breve LIKE '%$value%' OR detalle_noticia.nombre LIKE '%$value%' OR detalle_noticia.descripcion_ampliada LIKE '%$value%')");
					}else{
						if ($value!='' && !is_array($value))
							$this->db->like($field,$value);
					}
				}
			}
		}

		//$this->db->group_by('noticia.id_noticia');
		$q=$this->db->get('noticia');
		//echo $this->db->last_query();
		$ret=$q->row();
		return $ret->num_noticias;
	}

	function update($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		if (isset($data['id_noticia'])){
			$noticia=$this->read($data['id_noticia']);
		}
		//echo '<pre>'.print_r($noticia,true).'</pre>';
		if (!empty($noticia)){
			$this->db->where('id_noticia',$data['id_noticia']);
			$this->db->update('noticia',$data);
			$id=$data['id_noticia'];
		}else{
			$data['creado']=date('Y-m-d H:i:s');
			$this->db->insert('noticia',$data);
			$id=$this->db->insert_id();
		}

		return $id;
	}

	function update_idioma($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		$d=array('id_idioma'=>$data['id_idioma'],'id_noticia'=>$data['id_noticia']);
		
		if (isset($data['id_detalle_noticia']) && $ob=$this->exists('detalle_noticia',$d)){
			if (isset($data['id_detalle_noticia'])){
				$this->db->where('id_detalle_noticia',$data['id_detalle_noticia']);
				$id=$data['id_detalle_noticia'];
			}else{
				$this->db->where($d);
				$id=$ob->id_detalle_noticia;
			}
			$this->db->update('detalle_noticia',$data);

		}else{
			unset($data['id_detalle_noticia']);
			$this->db->insert('detalle_noticia',$data);
			$id=$this->db->insert_id();
		}
		return $id;
	}

	function delete($id){
		/*
		$imagenes=modules::run('services/relations/get_rel','noticia','imagen',$id,'true');
		foreach(json_decode($imagenes) as $img){
			if (is_file(FCPATH.'assets/img/temp/'.$img->fichero)) unlink( FCPATH.'assets/img/temp/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/med/'.$img->fichero)) unlink( FCPATH.'assets/img/med/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/thumb/'.$img->fichero)) unlink( FCPATH.'assets/img/thumb/'.$img->fichero);
			if (is_file(FCPATH.'assets/img/large/'.$img->fichero)) unlink( FCPATH.'assets/img/large/'.$img->fichero);
		}
		if ($this->db->delete('noticia', array('id_noticia' => $id)))
			return true;
		else return false;
		*/
		$data['id_estado'] = 3;
		$this->db->where('id_noticia',$id);
		return $this->db->update('noticia',$data);
	}

	function eliminar_idioma($id){
		if ($this->db->delete('detalle_noticia', array('id_detalle_noticia' => $id)))
			return true;
		else return false;
	}

	function exists($table,$key=array()){

		$this->db->where($key);
		$q=$this->db->get($table);
		if ($q->num_rows()>=1) return $q->row();
		else return false;
	}

	function get_noticia_titulos_urls(){
		$this->db->select('noticia.id_noticia as id, detalle_noticia.nombre as nombre, detalle_noticia.url as url');
		$this->db->join('detalle_noticia', 'noticia.id_noticia = detalle_noticia.id_noticia');
		$query = $this->db->get('noticia');
		return $query->result();
	}

	function guardar_rel_imagen($data){
		$this->db->insert('rel_noticia_multimedia', $data);
	}

	function guardar_imagen($data){
		$this->db->insert('multimedia', $data);
		$id = $this->db->insert_id();
		return $id;
	}

	function get_id_from_url($url){
		$this->db->select('detalle_noticia.id_noticia');
		$this->db->where('detalle_noticia.url', $url);
		$query = $this->db->get('detalle_noticia');
		return $query->row()->id_noticia;
	}

	function get_noticias_fecha($fecha1='', $fecha2='', $id_idioma=1)
	{
		$noticia_total = array();
		$i=1;
		while(($fecha1<=$fecha2)&&($i<=5))
		{
			$this->db->select('noticia.*, detalle_noticia.id_detalle_noticia, detalle_noticia.nombre, detalle_noticia.id_idioma, detalle_noticia.subtitulo, detalle_noticia.url,
			detalle_noticia.descripcion_breve, detalle_noticia.descripcion_ampliada, detalle_noticia.id_idioma, detalle_noticia.descripcion_breve,
			detalle_noticia.descripcion_pagina, detalle_noticia.keywords, detalle_noticia.titulo_pagina, multimedia.fichero');
			$this->db->join('detalle_noticia','noticia.id_noticia=detalle_noticia.id_noticia');
			$this->db->join('rel_noticia_multimedia', 'noticia.id_noticia = rel_noticia_multimedia.id_noticia', 'left');
			$this->db->join('multimedia', 'multimedia.id_multimedia = rel_noticia_multimedia.id_multimedia', 'left');
		    $this->db->where('noticia.id_estado', '1');	
			$this->db->like('noticia.creado', $fecha1);
			$this->db->like('detalle_noticia.id_idioma', $id_idioma);
			$this->db->group_by('noticia.id_noticia');
			$this->db->order_by('noticia.creado','DESC');
			$noticia = $this->db->get('noticia')->result();
			
			$noticia_total = array_merge($noticia_total,$noticia);
			$fecha1= $this->operacion_fecha($fecha1, '1');
			if(count($noticia)==1)
			$i=$i+1;
		}
	
		//die("<pre>".print_r($noticia_total, TRUE). $this->db->last_query() ."</pre>");
		return $noticia_total;
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
}
