<?php

class Multimedia_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->model('idioma/idioma_model','idioma_model');
		$this->idioma=idioma_model::get_from_code($this->session->userdata('idioma'));
	}

	function create($data)
	{
		$this->db->insert('multimedia', $data);
		return $this->db->insert_id();
	}


	function crear_rel_multimedia($data, $tabla){
		$this->db->insert('rel_'.$tabla.'_multimedia', $data);
	}
	
	/*function get_id($fichero)
	{
		$this->db->
	}*/

	function guardar_imagen($data, $large_w = 940, $large_h = 705, $med_w = 800, $med_h = 600, $thumb_w = 80, $thumb_h = 80){
		$this->db->insert('multimedia', $data);
		$id = $this->db->insert_id();
		$img_folder = 'assets/front/img/';
        $img_new = $id . rand(5, 99999999) . '_' . $data['fichero'];
		if (is_file(FCPATH . $img_folder . 'temp/' . $data['fichero'])) {
            if (!is_dir(FCPATH . $img_folder . 'thumb/'))
                mkdir(FCPATH . $img_folder . 'thumb/');
            if (!is_dir(FCPATH . $img_folder . 'med/'))
                mkdir(FCPATH . $img_folder . 'med/');
            if (!is_dir(FCPATH . $img_folder . 'large/'))
                mkdir(FCPATH . $img_folder . 'large/');
            $this->load->library('image_lib');
            $config['image_library'] = 'gd2';
            $config['source_image'] = FCPATH . $img_folder . 'temp/' . $data['fichero'];

            // Imagen Thumbnail

            $config['new_image'] = FCPATH . $img_folder . 'thumb/' . $img_new;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = $thumb_w;
            $config['height'] = $thumb_h;

            $this->image_lib->initialize($config);
            if (!$this->image_lib->resize()) {
                echo json_encode($this->image_lib->display_errors());
            }


            // Imagen Medium

            $config['new_image'] = FCPATH . $img_folder . 'med/' . $img_new;
            $config['width'] = $med_w;
            $config['height'] = $med_h;

            $this->image_lib->initialize($config);
            if (!$this->image_lib->resize()) {
                echo json_encode($this->image_lib->display_errors());
            }


            // Imagen Large
            $config['new_image'] = FCPATH . $img_folder . 'large/' . $img_new;
            $config['width'] = $large_w;
            $config['height'] = $large_h;
            $this->image_lib->initialize($config);
            if (!$this->image_lib->resize()) {
                echo json_encode($this->image_lib->display_errors());
            }

            if (is_file(FCPATH . $img_folder . 'temp/' . $data['fichero']))
                unlink(FCPATH . $img_folder . 'temp/' . $data['fichero']);
        }
		$this->db->update('multimedia', array('fichero' => $img_new), array('id_multimedia' => $id));
		return $id;
	}

	function get_relation($id, $rel, $type = 1, $id_tipo = ''){
		$this->db->select('multimedia.*');
		$this->db->join('rel_'.$rel.'_multimedia', 'multimedia.id_multimedia = rel_'.$rel.'_multimedia.id_multimedia');
		$this->db->where('rel_'.$rel.'_multimedia.id_'.$rel, $id);
		$this->db->where('multimedia.destacado', $type);
			
		if (strlen($id_tipo))
			$this->db->where('multimedia.id_tipo', $id_tipo);
		$query = $this->db->get('multimedia');
		return $query->result();
		if($query->num_rows == 1){
			return $query->row();
		}
		else{
			return $query->result();
		}
	}

	function read($id,$id_detalle_multimedia='',$idioma='')
	{
		$this->db->select('multimedia.*,detalle_multimedia.*,multimedia.id_multimedia as id_multimedia');
		if ($id_detalle_multimedia!='') $this->db->where('detalle_multimedia.id_detalle_multimedia',$id_detalle_multimedia);
		$this->db->join('detalle_multimedia','multimedia.id_multimedia=detalle_multimedia.id_multimedia','left');
		$this->db->where('multimedia.id_multimedia',$id);
		$this->db->group_by('multimedia.id_multimedia');
		$q = $this->db->get('multimedia');
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
	function detalles($id_multimedia){
		$this->db->join('detalle_multimedia','multimedia.id_multimedia=detalle_multimedia.id_multimedia');
		//$this->db->where('detalle_multimedia.id_idioma',$idioma);
		$this->db->where('multimedia.id_multimedia',$id_multimedia);
		//$this->db->group_by('multimedia.id_multimedia');
		$q=$this->db->get('multimedia');
		return $q->result();
	}
	function get_all($idioma=''){
		$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		$this->db->join('detalle_multimedia','multimedia.id_multimedia=detalle_multimedia.id_multimedia');
		$this->db->where('detalle_multimedia.id_idioma',$idioma);
		$q=$this->db->get('multimedia');
		return $q->result();
	}
	function get_list($f='multimedia.id_multimedia',$v=1,$group=false){

		$this->db->join('detalle_multimedia','multimedia.id_multimedia=detalle_multimedia.id_multimedia');
		$this->db->where($f,$v);
		if ($group) $this->db->group_by('multimedia.id_multimedia');
		$q=$this->db->get('multimedia');
		return $q->result();
	}
	function get_page($start=0,$count=10,$order_field='multimedia.id_multimedia',$order_dir='desc',$terminos_busqueda=array()){
		switch ($order_field) {
			case 'id_multimedia';
				$order_field='multimedia.id_multimedia';
			break;
			case 'tipo';
				$order_field='multimedia.id_tipo';
			break;
			case 'nombre';
				$order_field='detalle_multimedia.nombre_multimedia';
			break;
			default :
				$order_field=$order_field;
			break;
		}


		$this->db->select('multimedia.*,detalle_multimedia.*,multimedia.id_multimedia as id_multimedia');
		$this->db->join('detalle_multimedia','multimedia.id_multimedia=detalle_multimedia.id_multimedia','left');
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='multimedia.id_multimedia' && $value!=''){
					$this->db->where("multimedia.id_multimedia",$value);
				}elseif ($field=='id_tipo' && $value!=''){
					$this->db->where($field,$value);
				}elseif ($field=='id_estado' && $value!=''){
					$this->db->where($field,$value);
				}elseif ($field=='tag' && $value!=''){
					$this->db->join('rel_detalle_multimedia_tag','rel_detalle_multimedia_tag.id_detalle_multimedia=detalle_multimedia.id_detalle_multimedia');
					$this->db->join('tag','tag.id_tag=rel_detalle_multimedia_tag.id_tag');
					$this->db->like($field,$value);
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
        $this->db->where ('id_tipo !=','1');
		$this->db->group_by('multimedia.id_multimedia');
		$this->db->order_by($order_field,$order_dir);
		$q=$this->db->get('multimedia',$count,$start);
		//echo $this->db->last_query();
		return $q->result();
	}
	function count_all($terminos_busqueda=array()){
		$this->db->select('count(*) as num_multimedias');
		if (!empty($terminos_busqueda)){
			$this->db->join('detalle_multimedia','multimedia.id_multimedia=detalle_multimedia.id_multimedia','left');
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='multimedia.id_multimedia' && $value!=''){
					$this->db->where("multimedia.id_multimedia",$value);
				}elseif ($field=='id_tipo' && $value!=''){
					$this->db->where($field,$value);
				}elseif ($field=='id_estado' && $value!=''){
					$this->db->where($field,$value);
				}elseif ($field=='tag' && $value!=''){
					$this->db->join('rel_detalle_multimedia_tag','rel_detalle_multimedia_tag.id_detalle_multimedia=detalle_multimedia.id_detalle_multimedia');
					$this->db->join('tag','tag.id_tag=rel_detalle_multimedia_tag.id_tag');
					$this->db->like($field,$value);
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		//$this->db->group_by('multimedia.id_multimedia');
        $this->db->where ('id_tipo !=','1');
		$q=$this->db->get('multimedia');
		//echo $this->db->last_query();
		$ret=$q->row();
		return $ret->num_multimedias;
	}
	function update($data)
	{

		if (isset($data['id_multimedia'])){
			$multimedia=$this->read($data['id_multimedia']);
		}
		if (!empty($multimedia)){
			$this->db->where('id_multimedia',$data['id_multimedia']);
			$this->db->update('multimedia',$data);
			$id=$data['id_multimedia'];
		}else{
			$data['creado'] = date('Y-m-d H:i:s');
			$this->db->insert('multimedia',$data);
			$id=$this->db->insert_id();
		}

		return $id;
	}
	function update_idioma($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		$d=array('id_idioma'=>$data['id_idioma'],'id_multimedia'=>$data['id_multimedia']);
		if (isset($data['id_detalle_multimedia']) || $ob=$this->exists('detalle_multimedia',$d)){
			if (isset($data['id_detalle_multimedia'])){
				$this->db->where('id_detalle_multimedia',$data['id_detalle_multimedia']);
				$id=$data['id_detalle_multimedia'];
			}else{
				$this->db->where($d);
				$id=$ob->id_detalle_multimedia;
			}
			$this->db->update('detalle_multimedia',$data);

		}else{
			$this->db->insert('detalle_multimedia',$data);
			$id=$this->db->insert_id();
		}
		return $id;
	}

	function delete($id){
		$data['id_estado'] = 3;
		$this->db->where('id_multimedia',$id);
		return $this->db->update('multimedia',$data);
	}



	function delete_image($id, $rel, $fichero){
		$this->db->delete('rel_'.$rel.'_multimedia', array('id_multimedia' => $id));
		$this->db->delete('multimedia', array('id_multimedia' => $id));
		if (is_file(FCPATH.'assets/front/img/temp/'.$fichero)) unlink( FCPATH.'assets/front/img/temp/'.$fichero);
		if (is_file(FCPATH.'assets/front/img/med/'.$fichero)) unlink( FCPATH.'assets/front/img/med/'.$fichero);
		if (is_file(FCPATH.'assets/front/img/thumb/'.$fichero)) unlink( FCPATH.'assets/front/img/thumb/'.$fichero);
		if (is_file(FCPATH.'assets/front/img/large/'.$fichero)) unlink( FCPATH.'assets/front/img/large/'.$fichero);
	}

	function delete_document($id, $rel, $rel_plural , $fichero){
		$this->db->delete('rel_'.$rel.'_multimedia', array('id_multimedia' => $id));
		$this->db->delete('multimedia', array('id_multimedia' => $id));
		if (is_file(FCPATH.'assets/front/uploads/'.$rel_plural.'/pdf/'.$fichero)){
			unlink(FCPATH.'assets/front/uploads/'.$rel_plural.'/pdf/'.$fichero);
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function delete_id_from($id){
		$imagenes = modules::run('services/relations/get_where','multimedia', array("multimedia.id_multimedia" => $id));
		foreach($imagenes as $img){
			if (is_file(FCPATH.'assets/front/img/temp/'.$img->fichero)) unlink( FCPATH.'assets/front/img/temp/'.$img->fichero);
			if (is_file(FCPATH.'assets/front/img/med/'.$img->fichero)) unlink( FCPATH.'assets/front/img/med/'.$img->fichero);
			if (is_file(FCPATH.'assets/front/img/thumb/'.$img->fichero)) unlink( FCPATH.'assets/front/img/thumb/'.$img->fichero);
			if (is_file(FCPATH.'assets/front/img/large/'.$img->fichero)) unlink( FCPATH.'assets/front/img/large/'.$img->fichero);
		}
		if ($this->db->delete('multimedia', array('id_multimedia' => $id)))
			return true;
		else return false;
	}

	function eliminar_idioma($id){
		if ($this->db->delete('detalle_multimedia', array('id_detalle_multimedia' => $id)))
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
