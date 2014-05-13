<?php

class Home extends MX_Controller {


	function __construct()
	{
		parent::__construct();
		$this->cajas=array(1=>'izquierda',2=>'central',3=>'derecha');
		$this->load->model('home_model');

	}

	/* 
	 * Funcciones del admin, con control de aceso */
	
	function index()
	{
		$this->ficha();
	}
	
	function main()
	{
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$data['main_content'] = 'Home'; //$this->load->view('listado_obra',$data_content,true);
		$data['active']='home';
		$data['sub']='';
		$data['title']='Home';
		$data['breadcrumbs']=array('home'=>'Home');
		$this->load->view('back/template',$data);
	}
	
	function create($id=''){
		if ($id!='')
			modules::run('services/monitor/add','home',$id,$this->session->userdata('id_usuario'),'editar');
		else
			modules::run('services/monitor/add','home','',$this->session->userdata('id_usuario'),'crear');
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
			            foreach(array_keys($_POST) as $k){$form_data[$k]=($k=='imagenActual' || $k=='imagenName') ? str_replace('/','',$this->input->post($k)) : $this->input->post($k);}

			$form_data['id_usuario']=$this->session->userdata('id_usuario');
			$img=$form_data['imagenName'];
			if ($form_data['imagenName']==''){
				if (isset($form_data['imagenActual'])){
					$img=$form_data['imagenActual'];
					//modules::run('services/relations/delete','home','multimedia',$id);
				}
			}
			$img_uploaded=$form_data['imagenName'];
			unset($form_data['imagenActual']);
			unset($form_data['imagenName']);
			unset($form_data['imagen']);
			$id=$this->home_model->update($form_data);
			$img='home_'.$id.'_'.$img_uploaded;
			

			

			if (isset($img) && $img!=''){
				//delete all images
				
				//insert image into multimedia
				if (is_file(FCPATH.'assets/img/temp/'.$img_uploaded)){
					modules::run('services/relations/delete','home','multimedia',$id);
					modules::run('services/relations/insert_image',$img,$id,'home');
				
					if (!is_dir(FCPATH.'assets/img/thumb/')) mkdir(FCPATH.'assets/img/thumb/');
					if (!is_dir(FCPATH.'assets/img/med/')) mkdir(FCPATH.'assets/img/med/');
					if (!is_dir(FCPATH.'assets/img/large/')) mkdir(FCPATH.'assets/img/large/');
					
					$this->load->library('image_lib');
					$config['image_library'] = 'gd2';
					$config['source_image']	= FCPATH.'assets/img/temp/'.$img_uploaded;
					$config['new_image']	= FCPATH.'assets/img/thumb/'.$img;
					$config['width']	 = 176;
					$config['maintain_ratio'] = TRUE;
					$config['master_dim'] = 'width';
					//$config['height']	= 120;
					$this->image_lib->initialize($config);
					if ( ! $this->image_lib->resize())
					{
						echo $this->image_lib->display_errors();
						//die();
					}
					
					$config['new_image']	= FCPATH.'assets/img/thumb/'.$img;
					$config['width']	 = 176;
					$config['master_dim'] = 'width';
					//$config['height']	= 264;
					$this->image_lib->initialize($config);
					if ( ! $this->image_lib->resize())
					{
						echo $this->image_lib->display_errors();
						//die();
					}
					$tw=176;
					$th=119;
					$img_size=getimagesize($config['new_image']);
					$w=$img_size[0];
					$h=$img_size[1];
					
					if ($h>$th){
						$config_new['image_library'] = 'gd2';
						$config_new['source_image']	= FCPATH.'assets/img/thumb/'.$img;
						$config_new['new_image']	= FCPATH.'assets/img/thumb/'.$img;
						$config_new['width']	 = $tw;
						$config_new['height']	 = $th;
						$config_new['maintain_ratio'] = false;
						
						$config_new['y_axis'] = ($h-$th)/2;

						$this->image_lib->initialize($config_new); 

						if ( ! $this->image_lib->crop())
						{
							echo $this->image_lib->display_errors();
							//die();
						}
								
					}
					
					
					$config['new_image']	= FCPATH.'assets/img/med/'.$img;
					$config['width']	 = 330;
					$config['master_dim'] = 'width';
					//$config['height']	= 264;
					$this->image_lib->initialize($config);
					if ( ! $this->image_lib->resize())
					{
						echo $this->image_lib->display_errors();
						//die();
					}
					
					
					$tw=330;
					$th=100;
					$img_size=getimagesize($config['new_image']);
					$w=$img_size[0];
					$h=$img_size[1];
					
					if ($h>$th){
						$config_new['image_library'] = 'gd2';
						$config_new['source_image']	= FCPATH.'assets/img/med/'.$img;
						$config_new['new_image']	= FCPATH.'assets/img/med/'.$img;
						$config_new['width']	 = $tw;
						$config_new['height']	 = $th;
						$config_new['maintain_ratio'] = false;
						
						$config_new['y_axis'] = ($h-$th)/2;

						$this->image_lib->initialize($config_new); 

						if ( ! $this->image_lib->crop())
						{
							echo $this->image_lib->display_errors();
							//die();
						}
								
					}
					
					
					$img_size=getimagesize($config['source_image']);
					if ($img_size[0]>=1280){
						$config['new_image']	= FCPATH.'assets/img/large/'.$img;
						$config['width']	 = 1280;
						$config['master_dim'] = 'width';
						//$config['height']	= 264;
						$this->image_lib->initialize($config);
						if ( ! $this->image_lib->resize())
						{
							echo $this->image_lib->display_errors();
							//die();
						}
					}
					if (is_file(FCPATH.'assets/img/temp/'.$img)) unlink( FCPATH.'assets/img/temp/'.$img);
				}
			}
			//echo '<pre>'.print_r($_POST,true).'</pre>';
			//echo "true";
			//die();
			redirect('backend/home/ficha/'.$id,'location');

		
		
		
	}
/*
	function load(){
		while (true){
			ini_set('max_execution_time','3600');
			$i=$i*25-200/268^3;
			
		}
	}
*/

	function edit($id='',$ajax=false){
		if ($id=='') redirect('home/create');
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$data['active']='home';
		
		$data['sub']=$this->cajas[$id];
		$data_content['location']=$data['sub'];
		//if ($id=='') redirect('backend');
		//$data['relations'] = $this->load->view('relations','',true);
		
		$data_content['home']=$this->home_model->read($id);
		$canal=$data_content['home']->canal;
		if ($data_content['home']->canal!='exposicion' && $data_content['home']->canal!='publicacion') $canal='';
		$data_content['categorias']=modules::run('services/relations/get_where','categoria','{"canal":"'.$canal.'"}');
		$data['breadcrumbs']=array('home'=>'Cajas',$id=>(isset($data_content['home']->titulo) ? 'Ficha de '.$data_content['home']->titulo : 'Caja '.$data['sub'].' sin titulo'));
		$data['title']='Editar caja home '.$data['sub'];

		$data_content['imagenes']=modules::run('services/relations/get_rel','home','imagen',$id,'true');
		
		$data['main_content'] = $this->load->view('crear_home',$data_content,true);
		//$data['main_content']=json_encode($data_content['obra']);
		//echo json_encode($data_content['obra']);
		//die();
		
		if ($ajax)
			echo $data['main_content'];
		else
			$this->load->view('back/template',$data);
		
		//return json_encode($this->obra_model->read($id));
	}
	function ficha($id=1){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		if ($id=='') redirect('backend');
		$data['active']='home';
		
		$data['sub']=$this->cajas[$id];
		$data_content['location']=$data['sub'];
		//$data['relations'] = $this->load->view('relations','',true);
		$data_content['home']=$this->home_model->read($id);
		if (empty($data_content['home'])) redirect('home/edit');
		//echo '<pre>'.print_r($data_content['home'],true).'</pre>';
		$data['breadcrumbs']=array('backend/home/ficha/1'=>'Backend',$id=>(isset($data_content['home']->titulo) && !empty($data_content['home']->titulo) ? 'Caja '.$data['sub'].' '.$data_content['home']->titulo : 'Caja '.$data['sub'].' sin titulo'));
		$data['title']=(isset($data_content['home']->titulo) ? 'Ficha de '.$data_content['home']->titulo : 'Caja '.$data['sub'].' sin titulo');
		$data_content['home_idiomas']=$this->home_model->detalles($id);
	//	echo '<pre>'.print_r($data_content['home_idiomas'],true).'</pre>';
		$data_content['home_canal']=$data_content['home']->canal;
		$data_content['home_categoria']=modules::run('services/relations/get_from_id','categoria',$data_content['home']->id_categoria);
		$data_content['imagenes']=modules::run('services/relations/get_rel','home','imagen',$id,'true');
		$data['main_content'] = $this->load->view('ficha_home',$data_content,true);
		$this->load->view('back/template',$data);
		//return json_encode($this->obra_model->read($id));
	}
	function editar_idioma($id_home,$id_detalle_home=''){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		if ($id_detalle_home=='') redirect('backend/home/ficha/'.$id_home);
		
		echo modules::run('template/editar_idioma_form',$id_home,$id_detalle_home,'home');
		
	}

	function guardar_idioma(){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		//echo '<pre>'.print_r($_POST,true).'</pre>';
		foreach(array_keys($_POST) as $k){$data_content[$k]=$this->input->post($k);}
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		$this->load->helper(array('form', 'url'));
		$this->form_validation->set_rules('id_idioma', 'Idioma', 'required');
		$this->form_validation->set_rules('titulo', 'Titulo', 'min_length[5]');
		$this->form_validation->set_rules('enlace_titulo', 'Enlace Titulo', 'trim|callback_valid_domain|prep_url');
		$this->form_validation->set_rules('subtitulo', 'Subtitulo', 'min_length[5]');
		$this->form_validation->set_rules('enlace_subtitulo', 'Enlace Subtitulo', 'trim|callback_valid_domain|prep_url');
		$this->form_validation->set_rules('texto', 'Texto', 'min_length[5]');
		$this->form_validation->set_rules('enlace_texto', 'Enlace texto', 'trim|callback_valid_domain|prep_url');
		
		$this->form_validation->set_rules('descripcion', 'Descripcion', 'min_length[10]');
		$this->form_validation->set_rules('descripcion_imagen', 'Descripcion Imagen', 'min_length[10]');
		$this->form_validation->set_message('valid_domain', 'Enlace invalido');
		/*
		$this->form_validation->set_rules('descripcion_ampliada', 'Descripcion Ampliada', 'min_length[50]');
		$this->form_validation->set_rules('url', 'URL', 'required|min_length[5]');
		$this->form_validation->set_rules('descripcion_imagen', 'Descripcion Imagen', '');
		$this->form_validation->set_rules('titulo_y_pie', 'Titulo y pie', 'min_length[5]');
		$this->form_validation->set_rules('publicado_en', 'Publicado en', '');
		$this->form_validation->set_rules('soporte', 'Soporte', '');
		$this->form_validation->set_rules('titulo_pagina', 'Titulo Pagina', '');
		$this->form_validation->set_rules('descripcion_pagina', 'Descripcion Pagina', '');
		$this->form_validation->set_rules('keywords', 'Plabras clave', '');
		$this->form_validation->set_rules('tags', 'Tags', '');
		* */
		
		
		if ($this->form_validation->run($this) == FALSE)
		{
			$data['active']='home';
			$data['sub']='crear';
			$data['title']='Editar idioma';
			if ($data_content['id_home']!=''){
				$data_content['home']=modules::run('home/read',$data_content['id_home']);
				$data['breadcrumbs']['home']='Home';
				$data['breadcrumbs']['edit']='Editar idioma';
				$data['breadcrumbs'][$data_content['id_home']]=$data_content['titulo'];
				$data_content['imagen']=modules::run('services/relations/get_rel','home','imagen',$data_content['id_home'],'true');
			}else{
				$data['breadcrumbs']=array('home'=>'Cajas Home');
			}
			$data_content['nuevo']=true;
			$data['main_content'] = $this->load->view('template/crear_idioma_form_home',$data_content,true);
			$this->load->view('back/template',$data);
			//die();
		}else{
			$home=modules::run('home/read',$data_content['id_home']);
			if ($data_content['titulo']=='' && isset($home->id_categoria)){
				$cat=modules::run('services/relations/get_from_id','categoria',$home->id_categoria);
				$data_content['titulo']=$cat->nombre;
			}
			//if ($data_content['titulo']=='' && !isset($home->id_categoria)){
			//	$data_content['titulo']=$home->canal;
			//}
			$data_content['enlace_titulo']=prep_url($data_content['enlace_titulo']);
			$data_content['enlace_subtitulo']=prep_url($data_content['enlace_subtitulo']);
			$data_content['enlace_texto']=prep_url($data_content['enlace_texto']);
			if(isset($data_content['descripcion_imagen'])){
				$img['descripcion_multimedia']=$data_content['descripcion_imagen'];
				$img['id_idioma']=$data_content['id_idioma'];
				$img['id_multimedia']=$data_content['descripcion_imagen_id'];
				modules::run('services/relations/insert_detalle_multimedia',$img);
				unset($data_content['descripcion_imagen']);
				unset($data_content['descripcion_imagen_id']);
				unset($data_content['id_detalle_multimedia']);
				///echo "aaa";
			}
			$id=$this->home_model->update_idioma($data_content);

			//modules::run('services/monitor/add','detalle_home',$id,$this->session->userdata('id_usuario'),'editar_idioma');
			redirect('backend/home/ficha/'.$data_content['id_home']);
		}
	}
	function eliminar_idioma($id,$ajax=false){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		modules::run('services/monitor/add','detalle_home',$id,$this->session->userdata('id_usuario'),'eliminar_idioma');
		$detalle=$this->detalle($id);
		$ret=$this->home_model->eliminar_idioma($id);
		$str=($ret==true) ? 'true' : 'false';
		if ($ajax) echo '[{result:'.$str.'}]';
		else redirect('backend/home/ficha/'.$detalle->id_home);
	}
	function delete($id,$ajax=false){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$ret=$this->obra_model->delete($id);
		$str=($ret==true) ? 'true' : 'false';
		if ($ajax) echo '[{result:'.$str.'}]';
		else return $ret;
	}
	
	
	
	/*
	 * Fin funcciones del admin */
	
	
	/*
	 * Funciones generales, accesibles sin autentificacion */
	
	function read($id,$ajax=false,$detalle_id=''){
		$ret=$this->home_model->read($id,$detalle_id);
		if ($ajax) echo json_encode($ret);
		else return $ret;
	}
	function get_obra($output='json',$id=''){
		$obra=$this->obra_model->read($id);
		if ($output=='xml'){
			$domDoc = new DOMDocument;
			$rootElt = $domDoc->createElement('obra');
			$rootNode = $domDoc->appendChild($rootElt);
			foreach($obra as $field=>$value){
				$subElt = $domDoc->createElement($field);
				$textNode = $domDoc->createTextNode($value);
				$subElt->appendChild($textNode);
				$rootNode->appendChild($subElt);
			}
			header('Content-Type: text/xml');
			echo $domDoc->saveXML();
		}elseif($output=='json'){
			echo json_encode($obra);
		}
	}
	function get_obra_list($output='json',$f='obra.id_obra',$v=1,$group=false){
		$obras=$this->obra_model->get_list($f,$v,$group);
		if ($output=='xml'){
			$domDoc = new DOMDocument;
			foreach ($obras as $obra){
				$rootElt = $domDoc->createElement('obra');
				$rootNode = $domDoc->appendChild($rootElt);
				foreach($obra as $field=>$value){
					$subElt = $domDoc->createElement($field);
					$textNode = $domDoc->createTextNode($value);
					$subElt->appendChild($textNode);
					$rootNode->appendChild($subElt);
				}
			}
			header('Content-Type: text/xml');
			echo $domDoc->saveXML();
		}elseif($output=='json'){
			echo json_encode($obras);
		}
	}
	function detalle($id,$ajax=false){
		$ret=$this->home_model->get('detalle_home',$id);
		if ($ajax) echo json_encode($ret);
		else return $ret;
	}
	function obras_categoria($id_categoria,$ajax=1){
		if ($ajax==1)
			echo modules::run('services/relations/get_from_categoria',$id_categoria,'obra',$ajax);
		else return modules::run('services/relations/get_from_categoria',$id_categoria,'obra',$ajax);
	}
	
	/* 
	 * Fin funciones libres */
	
	/*funciones de callback
	 * */
	function dia_check($str)
	{
		if ((int)$str > 31)
		{
			$this->form_validation->set_message('dia_check', 'El dia debe ser inferior a 31');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	function mes_check($str)
	{
		if ((int)$str > 12)
		{
			$this->form_validation->set_message('mes_check', 'El mes debe ser inferior a 12');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	function ano_check($str)
	{
		if ((int)$str > date('Y'))
		{
			$this->form_validation->set_message('ano_check', 'El año debe ser inferior a '.date('Y'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	function valid_domain($str){
		if ($str=='') return true;
		$str=str_replace('http://','',$str);
		return (preg_match('/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}/',$str)==1);
	}
	/*
	 * Fin funciones callback
	 * 
	 * */
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
	
