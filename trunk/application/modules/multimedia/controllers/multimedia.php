<?php

class Multimedia extends MX_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->model('multimedia_model');
		

	}
	
	/* 
	 * Funcciones del admin, con control de aceso */
	function index()
	{
		
		$this->listado();
	}
	function listado($order_field='multimedia.id_multimedia',$order_dir='desc',$start=0,$ajax=false,$redir=false)
	{
		$this->session->set_userdata('back','backend/multimedia/listado/'.$order_field.'/'.$order_dir.'/'.$start.'/true');
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		if ($start==0 && empty($_POST) && $order_field=='multimedia.id_multimedia' && $redir==false) $this->session->unset_userdata('terminos_busqueda');
		$terminos_busqueda=array();
		$terminos_busqueda=$this->session->userdata('terminos_busqueda');
		if (isset($_POST['nombre_multimedia'])) {
			$terminos_busqueda['nombre_multimedia']=$_POST['nombre_multimedia'];
		}
		if (isset($_POST['id_multimedia'])) {
			$terminos_busqueda['multimedia.id_multimedia']=$_POST['id_multimedia'];
		}
		if (isset($_POST['id_estado'])) {
			$terminos_busqueda['id_estado']=$_POST['id_estado'];
		}
		if (isset($_POST['id_tipo'])) {
			$terminos_busqueda['id_tipo']=$this->input->post('id_tipo');
		}

		if (isset($_POST['tag'])) {
			$terminos_busqueda['tag']=$this->input->post('tag');
		}
		
		if (isset($_POST) && !empty($_POST)){
			$terminos_busqueda=array_filter($terminos_busqueda);
			$this->session->set_userdata('terminos_busqueda',$terminos_busqueda);
		}
		
		//echo '<pre>'.print_r($terminos_busqueda,true).'</pre>';
		$limit=10;
		$order_string='';
		$order_string.= ($order_field == "") ? '' : $order_field;
		$order_string.= ($order_dir == "") ? '' : ' '.$order_dir;				
		
		$od=($order_dir=='asc') ? 'desc' : 'asc';	
		$data_content['order_field']=$order_field;
		$data_content['order_dir']=$order_dir;
		$data_content['order_by_new'] = (($order_field=='') ? 'id_multimedia' : $order_field) . "/". $od;
		$data_content['url'] = 'backend/multimedia/listado';
		$config['base_url'] = '/backend/multimedia/listado/'.$order_field.'/'.$order_dir;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 6;
		$data_content['num_multimedias']=$this->multimedia_model->count_all($terminos_busqueda);
		$config['total_rows'] = $data_content['num_multimedias'];
		if ($config['total_rows']==0) redirect('multimedia/buscar/ningun_resultado');
		$data_content['multimedias']=$this->multimedia_model->get_page($start,$limit,$order_field,$order_dir,$terminos_busqueda);

		if ($ajax){
			echo json_encode($data_content['multimedias']);
		}else{
			$this->load->library('pagination');
			$this->pagination->initialize($config); 
			$data_content['pagination'] = $this->pagination->create_links();
			$data_content['offset'] = $start;
			$data_content['order_field'] = $order_field;
			$data_content['order_direction'] = $order_dir;
			$data['main_content'] = $this->load->view('listado_multimedia',$data_content,true);
			$data['active']='multimedia';
			if (!empty($terminos_busqueda)) $data['sub']='buscar';
			else $data['sub']='listado';
			$data['title']='Multimedias';
			if (!empty($terminos_busqueda)) {
				
				
				$t=$terminos_busqueda;
				$lbc=reset($t);
				$lbt=key($t);
				if ($lbt=='id_estado'){
					$bcc=modules::run('services/relations/get_from_id','estado',$lbc);
					$lbc=ucwords($bcc->estado);
				}

				
				$data['breadcrumbs']=array('multimedia'=>'Multimedias','buscar'=>'Busqueda','titulo'=>$lbc);
			}else{
				$data['breadcrumbs']=array('multimedia'=>'Multimedias','listado'=>'Listado');
			}
			$this->load->view('back/template',$data);
		}
	}
	
	function buscar($mensaje='')
	{
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$data['active']='multimedia';
		$data['sub']='buscar';
		$dc['mensaje']=$mensaje;
		$data['title']='Busqueda de multimedias';
		$data['breadcrumbs']=array('multimedia'=>'Multimedias','buscar'=>'Busqueda de multimedias');
		//$data['relations'] = $this->load->view('relations','',true);
		$data['main_content'] = $this->load->view('buscar_multimedia',$dc,true);
		$this->load->view('back/template',$data);
	}
	
	function crear()
	{
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$data['active']='multimedia';
		$data['sub']='crear';
		$data['breadcrumbs']=array('multimedia'=>'Multimedias','crear'=>'Crear un multimedia');
		//$data['relations'] = $this->load->view('relations','',true);
		//$data_content['artistas']=modules::run('services/relations/get_all','artista','true','artista.id_artista');
		$data_content['estados']=modules::run('services/relations/get_all','estado','true');
		//$data_content['tecnicas']=modules::run('services/relations/get_all','tecnica','true');
		$data_content['categorias']=modules::run('services/relations/get_all','categoria','true','','true');
		//$data_content['obras']=modules::run('services/relations/get_all','multimedia','true','multimedia.id_multimedia');
//		$data_content['videos']=modules::run('services/relations/get_all','video','true','','true');
//		$data_content['colecciones']=modules::run('services/relations/get_all','coleccion','true','','true');
//		$data_content['catalogos']=modules::run('services/relations/get_all','catalogo','true','','true');
//        $data_content['artistas']=modules::run('services/relations/get_all','artista',false,'','true');
//        $data_content['enlaces']=modules::run('services/relations/get_all','enlace',false,'','true');
//		$data_content['microsites']=modules::run('services/relations/get_all','microsite','true','','true');
		$data['main_content'] = $this->load->view('crear_multimedia',$data_content,true);
		$this->load->view('back/template',$data);
	}
	function create($id=''){
		if ($id!='')
			modules::run('services/monitor/add','multimedia',$id,$this->session->userdata('id_usuario'),'editar');
		else
			modules::run('services/monitor/add','multimedia','',$this->session->userdata('id_usuario'),'crear');
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$data_content['estados']=modules::run('services/relations/get_all','estado','true');
		$data_content['categorias']=modules::run('services/relations/get_all','categoria','true','','true');
		$data_content['videos']=modules::run('services/relations/get_all','video','true','','true');
		$data_content['microsites']=modules::run('services/relations/get_all','microsite','true','','true');
        $data_content['catalogos']=modules::run('services/relations/get_all','catalogo','true','','true');
		$data_content['enlaces']=modules::run('services/relations/get_all','enlace','true','','true');
        $data_content['artistas']=modules::run('services/relations/get_all','artista',false,'','true');
		
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		$this->form_validation->set_rules('id_estado', 'Estado', 'required');
        $this->form_validation->set_rules('videoUrl', 'URL', 'prep_url');
		$this->form_validation->set_rules('obras[]', 'Obras relacionadas', '');
		$this->form_validation->set_rules('microsites[]', 'Microsites relacionadas', '');
		$this->form_validation->set_rules('videos[]', 'Videos relacionados', '');
		$this->form_validation->set_rules('catalogos[]', 'Catalogos relacionados', '');
        $this->form_validation->set_rules('enlaces[]', 'Enlaces relacionados', '');
        $this->form_validation->set_rules('artistas[]', 'Artistas relacionados', '');
		if ($this->form_validation->run($this) == FALSE)
		{
			if ($id != ''){
				$data_content['multimedia']=$this->multimedia_model->read($id);
				$data_content['multimedia_obras']=modules::run('services/relations/get_all_rel_front','multimedia','obra',$id,'true');
				$data_content['multimedia_videos']=modules::run('services/relations/get_all_rel_front','multimedia','video',$id,'true');
				$data_content['multimedia_microsites']=modules::run('services/relations/get_all_rel_front','multimedia','microsite',$id,'true');
				$data_content['multimedia_catalogos']=modules::run('services/relations/get_all_rel_front','multimedia','catalogo',$id,'true');
                $data_content['multimedia_enlaces']=modules::run('services/relations/get_all_rel_front','multimedia','enlace',$id);
                $data_content['multimedia_artistas']=modules::run('services/relations/get_all_rel_front','multimedia','artista',$id);
			}
			$data['active']='multimedia';
			$data['sub']='crear';
			$data['title']='Crear nuevo multimedia';
			if ($id!=''){
				$data['breadcrumbs']['multimedia']='Multimedias';
				$data['breadcrumbs']['edit']='Editar un multimedia';
				$data['breadcrumbs'][$id]=$data_content['multimedia']->nombre_multimedia;
			}else{
				$data['breadcrumbs']=array('multimedia'=>'Multimedias','crear'=>'Crear multimedia');
			}
			
			$data['main_content'] = $this->load->view('crear_multimedia',$data_content,true);
			$this->load->view('back/template',$data);
		}else
		{
			$redir=true;
			            foreach(array_keys($_POST) as $k){$form_data[$k]=($k=='imagenActual' || $k=='imagenName') ? str_replace('/','',$this->input->post($k)) : $this->input->post($k);}

			
			$form_data['id_usuario']=$this->session->userdata('id_usuario');
			//echo '<pre>'.print_r($form_data,true).'</pre>';
		    //die();
			$img='';
			$img=(isset($form_data['imagenName']) ? $form_data['imagenName'] : '');
			//$img=($img=='' ? $form_data['imagenActual'] : '');
			if (!isset($form_data['imagenName']) || $form_data['imagenName']==''){
				if (isset($form_data['imagenActual'])) $img=$form_data['imagenActual'];
				
			}
			//echo $img;
			//die();
			unset($form_data['imagenActual']);
			unset($form_data['imagenName']);
			unset($form_data['imagen']);

			//echo '<pre>'.print_r($_POST,true).'</pre>';
			//die();
			
			//if (!isset($form_data['destacado']) || $form_data['destacado']=='') $form_data['destacado']='0';

			//echo '<pre>'.print_r($form_data,true).'</pre>';
			//redirect to ficha_multimedia.php
			if (isset($form_data['obras'])) $rel['obra']=array_unique($form_data['obras']);
			
			if (isset($form_data['videos'])) $rel['video']=array_unique($form_data['videos']);
			if (isset($form_data['microsites'])) $rel['microsite']=array_unique($form_data['microsites']);
			if (isset($form_data['catalogos'])) $rel['catalogo']=array_unique($form_data['catalogos']);
            if (isset($form_data['artistas'])) $rel['artista']=array_unique($form_data['artistas']);
            if (isset($form_data['enlaces'])) $rel['enlace']=array_unique($form_data['enlaces']);
			if (isset($form_data['filecatalogo'])) $catalogo=array_unique($form_data['filecatalogo']);
			if (isset($form_data['videourl'])) $video_url=$form_data['videourl'];
			if (isset($form_data['fileActual'])) $file_actual=$form_data['fileActual'];
			unset($form_data['videos']);
            unset($form_data['enlaces']);
			unset($form_data['obras']);
			//unset($form_data['filecatalogo']);
			unset($form_data['microsites']);
            unset($form_data['enlaces']);
			unset($form_data['catalogos']);
            unset($form_data['artistas']);
			unset($form_data['videourl']);
			unset($form_data['fileActual']);
			
			
			if (isset($_FILES['filecatalogo']) && !empty($_FILES['filecatalogo'])){
				//echo '<pre>'.print_r($_FILES,true).'</pre>';
				$up_config['upload_path'] = 'assets/pdf/';
				$up_config['allowed_types'] = 'pdf';
				$up_config['max_size']	= '10000';
				$this->load->library('upload', $up_config);
			
				if ( ! $this->upload->do_upload('filecatalogo'))
				{
					if ($_FILES['filecatalogo']['error']==4 && isset($file_actual)){
						$form_data['fichero']=$file_actual;
						$form_data['thumbnail']=$file_actual;
					}else{
						$redir=false;
						$error = $this->upload->display_errors();
						$this->session->set_flashdata('error',$error);
					}
                    if ($id != ''){
                        $data_content['multimedia']=$this->multimedia_model->read($id);
                        $data_content['multimedia_obras']=modules::run('services/relations/get_all_rel_front','multimedia','obra',$id,'true');
                        $data_content['multimedia_videos']=modules::run('services/relations/get_all_rel_front','multimedia','video',$id,'true');
                        $data_content['multimedia_microsites']=modules::run('services/relations/get_all_rel_front','multimedia','microsite',$id,'true');
                        $data_content['multimedia_catalogos']=modules::run('services/relations/get_all_rel_front','multimedia','catalogo',$id,'true');
                        $data_content['multimedia_enlaces']=modules::run('services/relations/get_all_rel_front','multimedia','enlace',$id,'true');
                        $data_content['multimedia_artistas']=modules::run('services/relations/get_all_rel_front','multimedia','artista',$id,'true');
                    }
					$data['active']='multimedia';
					$data['sub']='crear';
					$data['title']='Crear nuevo multimedia';
					if ($id!=''){
						$data['breadcrumbs']['multimedia']='Multimedias';
						$data['breadcrumbs']['edit']='Editar un multimedia';
						$data['breadcrumbs'][$id]=$data_content['multimedia']->nombre_multimedia;
					}else{
						$data['breadcrumbs']=array('multimedia'=>'Multimedias','crear'=>'Crear multimedia');
					}
					
					$data_content['error']=$error;
					$data['main_content'] = $this->load->view('crear_multimedia',$data_content,true);
					$this->load->view('back/template',$data);
					
				}	
				else
				{
					$file_data = $this->upload->data();
					//echo '<pre>'.print_r($file_data,true).'</pre>';
					$form_data['fichero']=$file_data['file_name'];
					$form_data['thumbnail']=$file_data['file_name'];
					//echo 'ok';
				}
			}elseif(isset($file_actual)){
				$form_data['fichero']=$file_actual;
				$form_data['thumbnail']=$file_actual;
				
			}
			
			
			if (isset($video_url)){
				$form_data['fichero']=$video_url;
				$form_data['thumbnail']=$video_url;
				
			}
			
			
			
			if (isset($img) && $img!=''){
				//insert image into multimedia
				
				if (is_file(FCPATH.'assets/img/temp/'.$img)){
					$form_data['fichero']=$img;
					$img_uploaded=$img;
					$form_data['thumbnail']=$img;
					//echo '<pre>'.print_r($form_data,true).'</pre>';
					
					if (!is_dir(FCPATH.'assets/img/thumb/')) mkdir(FCPATH.'assets/img/thumb/');
					if (!is_dir(FCPATH.'assets/img/med/')) mkdir(FCPATH.'assets/img/med/');
					if (!is_dir(FCPATH.'assets/img/large/')) mkdir(FCPATH.'assets/img/large/');
					
					$this->load->library('image_lib');
					$config['image_library'] = 'gd2';
					$config['source_image']	= FCPATH.'assets/img/temp/'.$img_uploaded;
					$new_img_size=getimagesize($config['source_image']);
					$nw=$new_img_size[0];
					$nh=$new_img_size[1];
					$config['new_image']	= FCPATH.'assets/img/thumb/'.$img;
					$r1=$nw/$nh;
					$r2=176/119;
					$config['maintain_ratio'] = TRUE;
					if ($r1 <= $r2){
						$config['master_dim'] = 'width';
						$config['width']	 = 176;
					}else{
						$config['master_dim'] = 'height';
						$config['height']	 = 119;
					}
					//$config['height']	= 120;
					$this->image_lib->initialize($config);
					if ( ! $this->image_lib->resize())
					{
						echo $this->image_lib->display_errors();
						die();
					}
					
					$config['new_image']	= FCPATH.'assets/img/thumb/'.$img;
					$config['maintain_ratio'] = TRUE;
					if ($r1 <= $r2){
						$config['width']	 = 176;
						$config['master_dim'] = 'width';
					}else{
						$config['height']	 = 119;
						$config['master_dim'] = 'height';
					}
					//$config['height']	= 120;
					//$config['height']	= 264;
					$this->image_lib->initialize($config);
					if ( ! $this->image_lib->resize())
					{
						echo $this->image_lib->display_errors();
						die();
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
							die();
						}
								
					}
					
					if ($w>$tw){
						$config_new['image_library'] = 'gd2';
						$config_new['source_image']	= FCPATH.'assets/img/thumb/'.$img;
						$config_new['new_image']	= FCPATH.'assets/img/thumb/'.$img;
						$config_new['width']	 = $tw;
						$config_new['height']	 = $th;
						$config_new['maintain_ratio'] = false;
						
						$config_new['x_axis'] = ($w-$tw)/2;

						$this->image_lib->initialize($config_new); 

						if ( ! $this->image_lib->crop())
						{
							echo $this->image_lib->display_errors();
							die();
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
						die();
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
							die();
						}
					}else{
						copy(FCPATH.'assets/img/temp/'.$img_uploaded,FCPATH.'assets/img/large/'.$img);
					}
					//die();
					if (is_file(FCPATH.'assets/img/temp/'.$img)) unlink( FCPATH.'assets/img/temp/'.$img);
				}
			}
			
			$id=$this->multimedia_model->update($form_data);
			modules::run('services/relations/delete','multimedia','obra',$id);
			modules::run('services/relations/delete','multimedia','multimedia',$id);
			modules::run('services/relations/delete','multimedia','microsite',$id);
            modules::run('services/relations/delete','multimedia','artista',$id);
			//echo '<pre>'.print_r($rel,true).'</pre>';
            //die();
			if (isset($rel) && !empty($rel) && is_array($rel)){
				foreach($rel as $t=>$r){
					modules::run('services/relations/insert_rel','multimedia',$t,$r,$id);
				}
			}
			
			
			if ($redir==true) redirect('backend/ficha_multimedia/'.$id,'location');

		}
		
		
	}

	function edit($id='',$ajax=false){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$data['active']='multimedia';
		$data['sub']='editar';
		//if ($id=='') redirect('backend');
		//$data['relations'] = $this->load->view('relations','',true);
		
		$data_content['multimedia']=$this->multimedia_model->read($id);
		
		$data['breadcrumbs']=array('multimedia'=>'Multimedias','ficha/'.$id=>'Ficha','0'=>$data_content['multimedia']->nombre_multimedia);
		$data['title']='Editar '.$data_content['multimedia']->nombre_multimedia;
		$data_content['artistas']=modules::run('services/relations/get_all','artista','true','','true');
		$data_content['estados']=modules::run('services/relations/get_all','estado','true');
		$data_content['tecnicas']=modules::run('services/relations/get_all','tecnica','true','','true');
		$data_content['categorias']=modules::run('services/relations/get_all','categoria','true','','true');
		$data_content['multimedias']=modules::run('services/relations/get_all','multimedia','true','','true');
		$data_content['microsites']=modules::run('services/relations/get_all','microsite','true','','true');
		$data_content['catalogos']=modules::run('services/relations/get_all','catalogo','true','','true');
        $data_content['artistas']=modules::run('services/relations/get_all','artista',false,'','true');
        $data_content['enlaces']=modules::run('services/relations/get_all','enlace',false,'','true');
		
		$data_content['videos']=modules::run('services/relations/get_all','video','true','','true');
		$data_content['imagenes']=modules::run('services/relations/get_rel','multimedia','imagen',$id,'true');
		$data_content['colecciones']=modules::run('services/relations/get_all','coleccion','true','','true');
		$data_content['multimedia_obras']=modules::run('services/relations/get_all_rel_front','multimedia','obra',$id,'true');
		$data_content['multimedia_videos']=modules::run('services/relations/get_all_rel_front','multimedia','video',$id,'true');
		$data_content['multimedia_microsites']=modules::run('services/relations/get_all_rel_front','multimedia','microsite',$id,'true');
		$data_content['multimedia_catalogos']=modules::run('services/relations/get_all_rel_front','multimedia','catalogo',$id,'true');
		$data_content['multimedia_colecciones']=modules::run('services/relations/get_all_rel_front','multimedia','coleccion',$id,'true');
        $data_content['multimedia_artistas']=modules::run('services/relations/get_all_rel_front','multimedia','artista',$id);
        $data_content['multimedia_enlaces']=modules::run('services/relations/get_all_rel_front','multimedia','enlace',$id);
		$data_content['imagenes']=modules::run('services/relations/get_rel','multimedia','imagen',$id,'true');
		
		$data['main_content'] = $this->load->view('crear_multimedia',$data_content,true);
		//$data['main_content']=json_encode($data_content['multimedia']);
		//echo json_encode($data_content['multimedia']);
		//die();
		
		if ($ajax)
			echo $data['main_content'];
		else
			$this->load->view('back/template',$data);
		
		//return json_encode($this->multimedia_model->read($id));
	}
	function ficha($id=''){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		if ($id=='') redirect('backend/multimedia');
		$data['active']='multimedia';
		$data['sub']='editar';
		//$data['relations'] = $this->load->view('relations','',true);
		$data_content['multimedia']=$this->multimedia_model->read($id);
		$data['breadcrumbs']=array('multimedia'=>'Multimedias','ficha'=>'Listado',$id=>(isset($data_content['multimedia']->nombre_multimedia) ? 'Ficha de '.$data_content['multimedia']->nombre_multimedia : 'Multimedia sin titulo'));
		$data['title']=(isset($data_content['multimedia']->nombre_multimedia) ? 'Ficha de '.$data_content['multimedia']->nombre_multimedia : 'Multimedia sin titulo');
		$data_content['multimedia_idiomas']=$this->multimedia_model->detalles($id);
		$data_content['multimedia_obras']=json_decode(modules::run('services/relations/get_all_rel','multimedia','obra',$id,'true','obra.id_obra'));
		//$data_content['multimedia_multimedias']=json_decode(modules::run('services/relations/get_all_rel','multimedia','multimedia',$id,'true','multimedia.id_multimedia_relacionado'));
		$data_content['multimedia_microsites']=json_decode(modules::run('services/relations/get_rel','multimedia','microsite',$id,'true','microsite.id_microsite'));
		$data_content['multimedia_videos']=json_decode(modules::run('services/relations/get_rel','multimedia','video',$id,'true'));
		$data_content['multimedia_catalogos']=json_decode(modules::run('services/relations/get_rel','multimedia','catalogo',$id,'true'));
        $data_content['multimedia_artistas']=json_decode(modules::run('services/relations/get_rel','multimedia','artista',$id,'true'));
        $data_content['multimedia_enlaces']=modules::run('services/relations/get_all_rel_front','multimedia','enlace',$id);
		//$data_content['imagenes']=modules::run('services/relations/get_rel','multimedia','imagen',$id,'true');
		$data['main_content'] = $this->load->view('ficha_multimedia',$data_content,true);
		$this->load->view('back/template',$data);
		//return json_encode($this->multimedia_model->read($id));
	}
	function editar_idioma($id_multimedia,$id_detalle_multimedia=''){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		if ($id_detalle_multimedia=='') redirect('backend/ficha_multimedia/'.$id_multimedia);
		
		echo modules::run('template/editar_idioma_form',$id_multimedia,$id_detalle_multimedia,'multimedia');
		
	}
	function guardar_idioma(){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		//echo '<pre>'.print_r($_POST,true).'</pre>';
		foreach(array_keys($_POST) as $k){$data_content[$k]=$this->input->post($k);}
		if (isset($data_content['tagsSugerencia'])) unset($data_content['tagsSugerencia']);
		if (isset($data_content['tags'])){
			$tags=$data_content['tags'];
			unset($data_content['tags']);
		}
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
	    if ($data_content['id_multimedia']!='')
			$data_content['multimedia']=modules::run('multimedia/read',$data_content['id_multimedia']);
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		$this->load->helper(array('form', 'url'));
		$this->form_validation->set_rules('id_idioma', 'Idioma', 'required');
		$this->form_validation->set_rules('nombre_multimedia', 'Nombre', 'required|min_length[5]');
        if ($data_content['multimedia']->id_tipo == 2){
            $this->form_validation->set_rules('descripcion_multimedia', 'Descripcion', 'required|min_length[10]');
            $this->form_validation->set_rules('url', 'URL', 'required|alpha_dash|min_length[5]');

            //$this->form_validation->set_rules('descripcion_imagen', 'Descripcion imagen', '');
            $this->form_validation->set_rules('titulo_pagina', 'Titulo pagina', 'required|min_length[5]');
            $this->form_validation->set_rules('descripcion_pagina', 'Descripcion pagina', 'required|min_length[10]');
            $this->form_validation->set_rules('keywords', 'Keywords', 'required|min_length[5]');
            $this->form_validation->set_rules('tags[]', 'Tags', '');
        }
		if ($this->form_validation->run($this) == FALSE)
		{
			$data['active']='multimedia';
			$data['sub']='crear';
			$data['title']='Editar idioma multimedia';
			if ($data_content['id_multimedia']!=''){

				$data['breadcrumbs']['multimedia']='Multimedia';
				$data['breadcrumbs']['edit']='Editar idioma de un multimedia';
				$data['breadcrumbs'][$data_content['id_multimedia']]=(isset($data_content['nombre_multimedia']) ? $data_content['nombre_multimedia'] :'');
			}else{
				$data['breadcrumbs']=array('multimedia'=>'Multimedia','crear'=>'Crear un multimedia');
			}
			
			$data['main_content'] = $this->load->view('template/crear_idioma_form_multimedia',$data_content,true);
			$this->load->view('back/template',$data);
			
		}else{
            unset($data_content['multimedia']);
			$id=$this->multimedia_model->update_idioma($data_content);
			if (isset($tags)){
				//echo '<pre>'.print_r($tags,true).'</pre>';
				$tags=array_unique($tags);
				modules::run('services/relations/delete','detalle_multimedia','tag',$id);
				//echo '<br>services/relations/delete/detalle_multimedia/tag/'.$id;
				foreach($tags as $tag){
					modules::run('services/relations/insert_tag',$tag,'detalle_multimedia',$id,$data_content['id_idioma']);
				}
			}
			modules::run('services/monitor/add','detalle_multimedia',$id,$this->session->userdata('id_usuario'),'editar_idioma');
			redirect('backend/ficha_multimedia/'.$data_content['id_multimedia']);
		}
	}
	function eliminar_idioma($id,$ajax=false){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		modules::run('services/monitor/add','detalle_multimedia',$id,$this->session->userdata('id_usuario'),'eliminar_idioma');
		$detalle=$this->detalle($id);
		$ret=$this->multimedia_model->eliminar_idioma($id);
		$str=($ret==true) ? 'true' : 'false';
		if ($ajax) echo '[{result:'.$str.'}]';
		else redirect('backend/ficha_multimedia/'.$detalle->id_multimedia);
	}
	function delete($id,$ajax=false){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$ret=$this->multimedia_model->delete($id);
		$str=($ret==true) ? 'true' : 'false';
		if ($ajax) echo '[{result:'.$str.'}]';
		else return $ret;
	}
	
	function delete_id($id,$ajax=false){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$ret=$this->multimedia_model->delete_id_from($id);
		$str=($ret==true) ? 'true' : 'false';
		if ($ajax) echo '[{result:'.$str.'}]';
		else return $ret;
	}
	
	
	/*
	 * Fin funcciones del admin */
	
	
	/*
	 * Funciones generales, accesibles sin autentificacion */
	
	function read($id,$ajax=false,$detalle_id=''){
		$ret=$this->multimedia_model->read($id,$detalle_id);
		if ($ajax) echo json_encode($ret);
		else return $ret;
	}
	function get_multimedia($output='json',$id=''){
		$multimedia=$this->multimedia_model->read($id);
		if ($output=='xml'){
			$domDoc = new DOMDocument;
			$rootElt = $domDoc->createElement('multimedia');
			$rootNode = $domDoc->appendChild($rootElt);
			foreach($multimedia as $field=>$value){
				$subElt = $domDoc->createElement($field);
				$textNode = $domDoc->createTextNode($value);
				$subElt->appendChild($textNode);
				$rootNode->appendChild($subElt);
			}
			header('Content-Type: text/xml');
			echo $domDoc->saveXML();
		}elseif($output=='json'){
			echo json_encode($multimedia);
		}
	}
	function get_multimedia_list($output='json',$f='multimedia.id_multimedia',$v=1,$group=false){
		$multimedias=$this->multimedia_model->get_list($f,$v,$group);
		if ($output=='xml'){
			$domDoc = new DOMDocument;
			foreach ($multimedias as $multimedia){
				$rootElt = $domDoc->createElement('multimedia');
				$rootNode = $domDoc->appendChild($rootElt);
				foreach($multimedia as $field=>$value){
					$subElt = $domDoc->createElement($field);
					$textNode = $domDoc->createTextNode($value);
					$subElt->appendChild($textNode);
					$rootNode->appendChild($subElt);
				}
			}
			header('Content-Type: text/xml');
			echo $domDoc->saveXML();
		}elseif($output=='json'){
			echo json_encode($multimedias);
		}
	}
	function detalle($id,$ajax=false){
		$ret=$this->multimedia_model->get('detalle_multimedia',$id);
		if ($ajax) echo json_encode($ret);
		else return $ret;
	}
	function multimedias_categoria($id_categoria,$ajax=1){
		if ($ajax==1)
			echo modules::run('services/relations/get_from_categoria',$id_categoria,'multimedia',$ajax);
		else return modules::run('services/relations/get_from_categoria',$id_categoria,'multimedia',$ajax);
	}
	
	/* 
	 * Fin funciones libres */
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
