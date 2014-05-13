<?php

class Multimedia_front extends Controller {


	function Multimedia_front()
	{
		parent::Controller();
		$this->load->model('multimedia_model');
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$this->id_idioma=modules::run('idioma/get_idioma_id_from_code',$this->session->userdata('idioma'));
		$this->lang->load('front',$this->session->userdata('idioma'));
		

	}
	

	function video($video='')
	{
		if (is_numeric($video)) $id_video=$video;
		else $id_video=modules::run('services/relations/get_id_from_url','video',$video);
		if ($id_video=='') $this->uri->uri_string();
		
		//echo "AAAaaa".$video.' '.$id_video;
		$data['main']='coleccion';
		$data['sub']='';
		$data['indice_izquierdo']=true;
		$data_content['multimedia']=modules::run('services/relations/get_from_id','video',$id_video,false,true);
        if (empty($data_content['multimedia'])) show_404($this->uri->uri_string());
		//echo '<pre>'.print_r($data_content['multimedia'],true).'</pre>';
		$data['breadcrumbs']=array('video'=>'Videos',$video=>(isset($data_content['multimedia']->nombre_multimedia) ? $data_content['multimedia']->nombre_multimedia : 'Multimedia sin titulo'));
		$data_content['datos_video']=json_decode(file_get_contents('http://oohembed.com/oohembed/?url='.$data_content['multimedia']->fichero));
		//echo '<pre>'.print_r($data_content['datos_video'],true).'</pre>';
		$data_destacados=modules::run('services/relations/destacados','multimedia',$id_video);
		
		$data['destacados']=$this->load->view('front/destacados',$data_destacados,true);
		$data['title']=(isset($data_content['multimedia']->titulo_pagina) ? $data_content['multimedia']->titulo_pagina : 'Multimedia sin titulo') . ' - Video';
		$data['meta_descripcion']=$data_content['multimedia']->descripcion_pagina;
		$data['meta_keywords']=$data_content['multimedia']->keywords;
		$data_content['title']=$data['title'];
		//$data['titulo_side_a']=$data['title'];
		$data_content['tags']=modules::run('services/relations/get_rel','detalle_multimedia','tag',$data_content['multimedia']->id_detalle_multimedia,false,'tag.id_tag',array("tag.id_idioma"=>$this->id_idioma,'tag.id_estado'=>1));
		//$data_content['imagenes']=modules::run('services/relations/get_rel','multimedia','imagen',$id,'true');
		$data['main_content'] = $this->load->view('front/video',$data_content,true);
		$this->load->view('front/template',$data);
		//return json_encode($this->multimedia_model->read($id));
	}
	
}

/* End of file multimedia_front.php */
/* Location: ./system/application/controllers/welcome.php */
