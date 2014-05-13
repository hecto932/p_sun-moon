<?php

class Promocion extends MX_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->model('promocion_model');
		

	}
	
	/* 
	 * Funcciones del admin, con control de aceso */
	function index()
	{
		
		$this->listado();
	}
	function listado($order_field='promocion.id_promocion',$order_dir='desc',$start=0,$ajax=false)
	{
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		if ($start==0 && empty($_POST) && $order_field=='promocion.id_promocion') $this->session->unset_userdata('terminos_busqueda');
		$terminos_busqueda=array();
		$terminos_busqueda=$this->session->userdata('terminos_busqueda');
		if (isset($_POST['texto'])) {
			$terminos_busqueda['texto']=$_POST['texto'];
		}
		if (isset($_POST['id_promocion'])) {
			$terminos_busqueda['promocion.id_promocion']=$_POST['id_promocion'];
		}
		if (isset($_POST['id_estado'])) {
			$terminos_busqueda['promocion.id_estado']=$_POST['id_estado'];
		}
        if (isset($_POST['destacado'])) {
			$terminos_busqueda['promocion.destacado']=$_POST['destacado'];
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
		$data_content['order_by_new'] = (($order_field=='') ? 'id_promocion' : $order_field) . "/". $od;
		$data_content['url'] = 'backend/promociones/listado';
		$config['base_url'] = '/backend/promociones/listado/'.$order_field.'/'.$order_dir;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 6;
		$data_content['num_promociones']=$this->promocion_model->count_all($terminos_busqueda);
		$config['total_rows'] = $data_content['num_promociones'];
		if ($config['total_rows']==0) redirect('promocion/buscar/ningun_resultado');
		$data_content['promociones']=$this->promocion_model->get_page($start,$limit,$order_field,$order_dir,$terminos_busqueda);
		if ($ajax){
			echo json_encode($data_content['promociones']);
		}else{
			$this->load->library('pagination');
			$this->pagination->initialize($config); 
			$data_content['pagination'] = $this->pagination->create_links();
			$data_content['offset'] = $start;
			$data_content['order_field'] = $order_field;
			$data_content['order_direction'] = $order_dir;
			$data['main_content'] = $this->load->view('listado_promocion',$data_content,true);
			$data['active']='promocion';
			if (!empty($terminos_busqueda)) $data['sub']='buscar';
			else $data['sub']='listado';
			$data['title']='Promociones';
			if (!empty($terminos_busqueda)) {
				$lbc=reset($terminos_busqueda);
				$lbt=key($terminos_busqueda);

				if ($lbt=='promocion.id_estado'){
					$bcc=modules::run('services/relations/get_from_id','estado',$lbc);
					$lbc=ucwords($bcc->estado);
				}
				if ($lbt=='promocion.id_producto'){
					$bcc=modules::run('services/relations/get_from_id','producto',$lbc);
					$lbc=ucwords($bcc->nombre);
				}
				$data['breadcrumbs']=array('promocion'=>'Promociones','buscar'=>'Busqueda','titulo'=>$lbc);
			}else{
				$data['breadcrumbs']=array('promocion'=>'Promociones','listado'=>'Listado');
			}
			$this->load->view('back/template',$data);
		}
	}
	
	function buscar($mensaje='')
	{
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$data['active']='promocion';
		$data['sub']='buscar';
		$data['title']='Busqueda de Promociones';
		$data['breadcrumbs']=array('promocion'=>'Promociones','buscar'=>'Busqueda de Promociones');
		//$data['relations'] = $this->load->view('relations','',true);
		$dc['mensaje']=$mensaje;
		$data['main_content'] = $this->load->view('buscar_promocion',$dc,true);
		$this->load->view('back/template',$data);
	}
	
	function crear()
	{
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$data['active']='promocion';
		$data['sub']='crear';
		$data['breadcrumbs']=array('promocion'=>'Promociones','crear'=>'Crear una promocion');
		$data_content['estados']=modules::run('services/relations/get_all','estado','true');
		$data_content['productos']=modules::run('services/relations/get_all','producto','true');
		$data['main_content'] = $this->load->view('crear_promocion',$data_content,true);
		$this->load->view('back/template',$data);
	}
	
	
	function fecha_pasada($fecha){
        return mysql_to_unix($fecha) <= time();
    }
	
	function create($id=''){
		
		$img_folder = 'assets/front/img/';
		
		if ($id!='')
			modules::run('services/monitor/add','promocion',$id,$this->session->userdata('id_usuario'),'editar');
		else
			modules::run('services/monitor/add','promocion','',$this->session->userdata('id_usuario'),'crear');
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		$this->form_validation->set_rules('id_estado', 'Estado', 'required');
        $this->form_validation->set_rules('enlace', 'Enlace', 'prep_url|valid_url');
        $this->form_validation->set_rules('creado', 'Fecha', 'required|callback_fecha_pasada');
        $this->form_validation->set_rules('destacado', 'Destacado', '');
        //validar fecha para que no este en el futuro
        $this->form_validation->set_message('fecha_pasada', 'La fecha de publicacion no pueden estar en el futuro');
		
		$config['upload_path'] = './assets/pdf';
        $config['allowed_types'] = 'pdf';
        $this->load->library('upload', $config);
		
		if ($this->form_validation->run($this) == FALSE)
		{
			//echo "false";
			//die();
			$data['sub']='crear';
			$data['title']='Crear nueva promocion';
			if ($id != ''){
				$data_content['promocion']=$this->promocion_model->read($id);
				$data['title']='Editar promocion';
			}
			$data['active']='promocion';
			
			if ($id!=''){
				$data['breadcrumbs']['promocion']='Promociones';
				$data['breadcrumbs']['edit']='Editar una promocion';
				$data['breadcrumbs'][$id]=$data_content['promocion']->nombre;
			}else{
				$data['breadcrumbs']=array('promocion'=>'Promociones','crear'=>'Crear una promocion');
			}
			$data_content['estados']=modules::run('services/relations/get_all','estado','true');
			$data_content['productos']=modules::run('services/relations/get_all','producto','true','producto.id_producto');
			$data['main_content'] = $this->load->view('crear_promocion',$data_content,true);
			$this->load->view('back/template',$data);
			//die();
		}
		/*
		elseif ($_FILES['fichero']['error']!=4 && ! $this->upload->do_upload('fichero'))
        {


            $data['sub']='crear';
			$data['title']='Crear nueva promocion';
			if ($id != ''){
				$data_content['promocion']=$this->promocion_model->read($id);
				$data['title']='Editar promocion';
			}
			$data['active']='promocion';

			if ($id!=''){
				$data['breadcrumbs']['promocion']='Promociones';
				$data['breadcrumbs']['edit']='Editar una promocion';
				$data['breadcrumbs'][$id]=$data_content['promocion']->nombre;
			}else{
				$data['breadcrumbs']=array('promocion'=>'Promociones','crear'=>'Crear una promocion');
			}
            $data_content['error'] =$this->upload->display_errors('<p class="error">', '</p>');
            $data_content['estados']=modules::run('services/relations/get_all','estado','true');
			$data_content['productos']=modules::run('services/relations/get_all','producto','true','producto.id_producto');
			$data['main_content'] = $this->load->view('crear_promocion',$data_content,true);
			$this->load->view('back/template',$data);
            //exit();

		}
		*/
		else
		{

             /*****************/
            /***UPLOAD PDF****/
            /*****************/

			$form_data=$_POST;
			
			if(!isset($form_data['destacado']))  $form_data['destacado'] = 0;
            /*
			if ($_FILES['fichero']['error']!=4){
                $pdf_data = array('upload_data' => $this->upload->data());
               // echo '<pre>'.print_r($pdf_data,true).'</pre>';
                $form_data['fichero']=$pdf_data['upload_data']['file_name'];
                //exit();
            }
            */
			$form_data['id_usuario']=$this->session->userdata('id_usuario');
			if (isset($form_data['productos'])) $rel['producto']=array_unique($form_data['productos']);
			unset($form_data['productos']);
            $img=$form_data['imagenName'];
			if ($form_data['imagenName']==''){
				if (isset($form_data['imagenActual'])) $img=$form_data['imagenActual'];

			}
            
			unset($form_data['imagenActual']);
			unset($form_data['imagenName']);
			unset($form_data['imagen']);
			$id=$this->promocion_model->update($form_data);
            if (isset($img) && $img!=''){
				//insert image into multimedia
	            modules::run('services/relations/delete','promocion','multimedia',$id);
				modules::run('services/relations/insert_image',$img,$id,'promocion');
				if (is_file(FCPATH.$img_folder.'temp/'.$img)){
					if (!is_dir(FCPATH.$img_folder.'thumb/')) mkdir(FCPATH.$img_folder.'thumb/');
					if (!is_dir(FCPATH.$img_folder.'med/')) mkdir(FCPATH.$img_folder.'med/');
					if (!is_dir(FCPATH.$img_folder.'large/')) mkdir(FCPATH.$img_folder.'large/');
					$this->load->library('image_lib');
					$config['image_library'] = 'gd2';
					$config['source_image']	= FCPATH.$img_folder.'temp/'.$img;
					$config['new_image']	= FCPATH.$img_folder.'thumb/'.$img;
					$config['maintain_ratio'] = TRUE;
					$config['width']	 = 140;
					$config['height']	= 90;
					$this->load->library('image_lib');
					$this->image_lib->initialize($config);
					if ( ! $this->image_lib->resize())
					{
						echo $this->image_lib->display_errors();
					}
                    $config['new_image']	= FCPATH.$img_folder.'med/'.$img;
					$config['width']	 = 280;
					$config['height']	= 180;
					$this->image_lib->initialize($config);
					if ( ! $this->image_lib->resize())
					{
						echo $this->image_lib->display_errors();
					}
                    /*
					$config['new_image']	= FCPATH.$img_folder.'large/'.$img;
					$config['width']	 = 1000;
					$config['height']	= 1000;
					$this->image_lib->initialize($config);
					if ( ! $this->image_lib->resize())
					{
						echo $this->image_lib->display_errors();
					}
                     * */

					if (is_file(FCPATH.$img_folder.'temp/'.$img)) unlink( FCPATH.$img_folder.'temp/'.$img);
				}
			}

			redirect('backend/ficha_promocion/'.$id,'location');

		}
		
		
	}

	function edit($id='',$ajax=false){
		if ($id=='') redirect('backend');
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$data['active']='promocion';
		$data['sub']='editar';

		$data_content['promocion']=$this->promocion_model->read($id);
		
		$data['breadcrumbs']=array('promocion'=>'Promociones','edit'=>'Editar una promocion',$id=>$data_content['promocion']->nombre);
		$data['title']='Editar '.$data_content['promocion']->nombre;
		$data_content['estados']=modules::run('services/relations/get_all','estado','true');
		$data_content['productos']=modules::run('services/relations/get_all','producto','true','producto.id_producto');
		$data_content['imagenes']=modules::run('services/relations/get_rel','promocion','imagen',$id,'true');
		
		$data['main_content'] = $this->load->view('crear_promocion',$data_content,true);
		if ($ajax)
			echo $data['main_content'];
		else
			$this->load->view('back/template',$data);
		
		//return json_encode($this->promocion_model->read($id));
	}
	function ficha($id=''){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		if ($id=='') redirect('backend/promociones');
		$data['active']='promocion';
		$data['sub']='editar';
		//$data['relations'] = $this->load->view('relations','',true);
		$data_content['promocion']=$this->promocion_model->read($id);
		$data['breadcrumbs']=array('promocion'=>'Promociones','ficha'=>'Listado',$id=>(isset($data_content['promocion']->nombre) ? 'Ficha de '.$data_content['promocion']->nombre : 'promocion sin titulo'));
		$data['title']=(isset($data_content['promocion']->nombre) ? 'Ficha de '.$data_content['promocion']->nombre : 'Noticia sin titulo');
		$data_content['promocion_idiomas']=$this->promocion_model->detalles($id);
		$data['main_content'] = $this->load->view('ficha_promocion',$data_content,true);
		$this->load->view('back/template',$data);
		//return json_encode($this->promocion_model->read($id));
	}
	function editar_idioma($id_promocion,$id_detalle_promocion=''){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		if ($id_detalle_promocion=='') redirect('backend/ficha_promocion/'.$id_promocion);
		
		echo modules::run('template/editar_idioma_form',$id_promocion,$id_detalle_promocion,'promocion');
		
	}
	function guardar_idioma(){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		//echo '<pre>'.print_r($_POST,true).'</pre>';
		$data_content=$_POST;
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		$this->load->helper(array('form', 'url'));
		$this->form_validation->set_rules('id_idioma', 'Idioma', 'required');
		$this->form_validation->set_rules('nombre', 'Titulo', 'required|min_length[5]');
        $this->form_validation->set_rules('subtitulo', 'Subtitulo', 'min_length[5]');
		$this->form_validation->set_rules('descripcion_breve', 'Descripcion Breve', 'min_length[10]');
        $this->form_validation->set_rules('descripcion_ampliada', 'Descripcion Ampliada', 'min_length[50]');
        $this->form_validation->set_rules('descripcion_imagen', 'Descripcion Imagen', '');
        $this->form_validation->set_rules('titulo_pagina', 'Titulo pagina', 'required|min_length[5]');
        $this->form_validation->set_rules('url', 'URL', 'required');
		$this->form_validation->set_rules('descripcion_pagina', 'Descripcion pagina', 'required|min_length[10]');
		$this->form_validation->set_rules('keywords', 'Palabras clave', 'required');
        
		if ($this->form_validation->run($this) == FALSE)
		{
			$data['active']='promocion';
			$data['sub']='crear';
			$data['title']='Editar idioma promocion';
			if ($data_content['id_promocion']!=''){
				$data_content['promocion']=modules::run('promocion/read',$data_content['id_promocion']);
				$data['breadcrumbs']['promocion']='Promociones';
				$data['breadcrumbs']['edit']='Editar idioma de una promocion';
				$data['breadcrumbs'][$data_content['id_promocion']]=$data_content['nombre'];
				$data_content['imagen']=modules::run('services/relations/get_rel','promocion','imagen',$data_content['id_promocion'],'true');
			}else{
				$data['breadcrumbs']=array('promocion'=>'Promociones','crear'=>'Crear una promocion');
			}
			$data_content['nuevo']=true;
			$data['main_content'] = $this->load->view('template/crear_idioma_form_promocion',$data_content,true);
			$this->load->view('back/template',$data);
			
		}else{
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

			$id=$this->promocion_model->update_idioma($data_content);

			modules::run('services/monitor/add','detalle_promocion',$id,$this->session->userdata('id_usuario'),'editar_idioma');
			redirect('backend/ficha_promocion/'.$data_content['id_promocion']);
		}
	}
	function eliminar_idioma($id,$ajax=false){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		modules::run('services/monitor/add','detalle_promocion',$id,$this->session->userdata('id_usuario'),'eliminar_idioma');
		$detalle=$this->detalle($id);
		$ret=$this->promocion_model->eliminar_idioma($id);
		$str=($ret==true) ? 'true' : 'false';
		if ($ajax) echo '[{result:'.$str.'}]';
		else redirect('backend/ficha_promocion/'.$detalle->id_promocion);
	}
	function delete($id,$ajax=false){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$ret=$this->promocion_model->delete($id);
		$str=($ret==true) ? 'true' : 'false';
		if ($ajax) echo '[{result:'.$str.'}]';
		else return $ret;
	}
	
	
	
	/*
	 * Fin funcciones del admin */
	
	
	/*
	 * Funciones generales, accesibles sin autentificacion */
	
	function read($id,$ajax=false,$detalle_id=''){
		$ret=$this->promocion_model->read($id,$detalle_id);
		if ($ajax) echo json_encode($ret);
		else return $ret;
	}
	function get_promocion($output='json',$id=''){
		$promocion=$this->promocion_model->read($id);
		if ($output=='xml'){
			$domDoc = new DOMDocument;
			$rootElt = $domDoc->createElement('promocion');
			$rootNode = $domDoc->appendChild($rootElt);
			foreach($promocion as $field=>$value){
				$subElt = $domDoc->createElement($field);
				$textNode = $domDoc->createTextNode($value);
				$subElt->appendChild($textNode);
				$rootNode->appendChild($subElt);
			}
			header('Content-Type: text/xml');
			echo $domDoc->saveXML();
		}elseif($output=='json'){
			echo json_encode($promocion);
		}
	}
	function get_promocion_list($output='json',$f='promocion.id_promocion',$v=1,$group=false){
		$Promociones=$this->promocion_model->get_list($f,$v,$group);
		if ($output=='xml'){
			$domDoc = new DOMDocument;
			foreach ($Promociones as $promocion){
				$rootElt = $domDoc->createElement('promocion');
				$rootNode = $domDoc->appendChild($rootElt);
				foreach($promocion as $field=>$value){
					$subElt = $domDoc->createElement($field);
					$textNode = $domDoc->createTextNode($value);
					$subElt->appendChild($textNode);
					$rootNode->appendChild($subElt);
				}
			}
			header('Content-Type: text/xml');
			echo $domDoc->saveXML();
		}elseif($output=='json'){
			echo json_encode($Promociones);
		}
	}
	function detalle($id,$ajax=false){
		$ret=$this->promocion_model->get('detalle_promocion',$id);
		if ($ajax) echo json_encode($ret);
		else return $ret;
	}
	function Promociones_categoria($id_categoria,$ajax=1){
		if ($ajax==1)
			echo modules::run('services/relations/get_from_categoria',$id_categoria,'promocion',$ajax);
		else return modules::run('services/relations/get_from_categoria',$id_categoria,'promocion',$ajax);
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
	/*
	 * Fin funciones callback
	 * 
	 * */
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
