<?php

class Producto extends MX_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->model('producto_model');
		modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		$this->lang->load('back');
		$this->load->helper('multimedia');
		$this->load->model('idioma/idioma_model');
		$idiomas = $this->idioma_model->get_all();
	}
	
	/* 
	 * Funcciones del admin, con control de aceso */
	function index()
	{
			$this->listado();
	}
	function listado($order_field='producto.id_producto',$order_dir='desc',$start=0,$ajax=false)
	{
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		if ($start==0 && empty($_POST) && $order_field=='producto.id_producto') $this->session->unset_userdata('terminos_busqueda');
		$terminos_busqueda=array();
		$terminos_busqueda=$this->session->userdata('terminos_busqueda');
		if (isset($_POST['nombre'])) {
			$terminos_busqueda['detalle_producto.nombre']=$_POST['nombre'];
		}
		if (isset($_POST['id_categoria'])) {
			$terminos_busqueda['producto.id_categoria']=$_POST['id_categoria'];
		}
		if (isset($_POST['id_estado'])) {
			$terminos_busqueda['producto.id_estado']=$_POST['id_estado'];
		}
		if (isset($_POST['destacado'])) {
			$terminos_busqueda['destacado']=$this->input->post('destacado');
		}
		if (isset($_POST['codigo_coloplas'])) {
			$terminos_busqueda['codigo_coloplas']=$this->input->post('codigo_coloplas');
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
		$data_content['order_by_new'] = (($order_field=='') ? 'id_producto' : $order_field) . "/". $od;
		$data_content['url'] = 'backend/'.lang('productos_url').'/listado';
		$config['base_url'] = '/backend/'.lang('productos_url').'/listado/'.$order_field.'/'.$order_dir;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 6;
		$data_content['num_productos']=$this->producto_model->count_all($terminos_busqueda);
		$config['total_rows'] = $data_content['num_productos'];
		if ($config['total_rows']==0) redirect(lang('producto_url').'/buscar/ningun_resultado');
		$data_content['productos']=$this->producto_model->get_page($start,$limit,$order_field,$order_dir,$terminos_busqueda);
		if ($ajax){
			echo json_encode($data_content['productos']);
		}else{
			$this->load->library('pagination');
			$this->pagination->initialize($config); 
			$data_content['pagination'] = $this->pagination->create_links();
			$data_content['offset'] = $start;
			$data_content['order_field'] = $order_field;
			$data_content['order_direction'] = $order_dir;
			//$data_content['idiomas'] = $idiomas;
			$data['main_content'] = $this->load->view('listado_producto',$data_content,true);
			$data['active']='producto';
			if (!empty($terminos_busqueda)) $data['sub']='buscar';
			else $data['sub']='listado';
			$data['title']= lang('productos');
			if (!empty($terminos_busqueda)) {
				$lbc=reset($terminos_busqueda);
				$lbt=key($terminos_busqueda);
				if ($lbt=='producto.id_categoria'){
					$bcc=modules::run('services/relations/get_from_id','categoria',$lbc);
					$lbc=ucwords($bcc->nombre);
				}
				if ($lbt=='destacado'){
					
					$lbc='Destacado';
				}
				if ($lbt=='producto.id_estado'){
					$bcc=modules::run('services/relations/get_from_id','estado',$lbc);
					$lbc=ucwords($bcc->estado);
				}
				$data['breadcrumbs']=array(lang('backend_url') => lang('backend'),lang('productos_url') => lang('productos'),'buscar'=>lang('busqueda'),'titulo'=>$lbc);
			}else{
				$data['breadcrumbs']=array(lang('backend_url')=>lang('backend'),lang('productos_url') => lang('productos'),'listado'=>lang('listado'));
			}
			$this->load->view('back/template',$data);
		}
	}
	
	function buscar($mensaje='')
	{
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$data['active']='producto';
		$data['sub']='buscar';
		$data['title']= lang('buscar_tit_prod');
		$data['breadcrumbs']=array(lang('backend_url') => lang('backend'), lang('productos_url') => lang('productos'), 'buscar' => lang('buscar_tit_prod'));
		//$data['relations'] = $this->load->view('relations','',true);
		$dc['mensaje']=$mensaje;
		$data['main_content'] = $this->load->view('buscar_producto',$dc,true);
		$this->load->view('back/template',$data);
	}
	
	function crear()
	{
		
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$data['active']='producto';
		$data['sub']='crear';
		$data['breadcrumbs'] = array(lang('backend_url') => lang('backend'), lang('productos_url') => lang('productos'),'crear' => lang('producto_crear'));
		//$data['relations'] = $this->load->view('relations','',true);
		//$data_content['artistas']=modules::run('services/relations/get_all','artista','true','artista.id_artista');
		$data_content['estados']=modules::run('services/relations/get_all','estado','true');
		
		$data_content['tipos_cat'] = modules::run('services/relations/get_all', 'tipo_categoria', 'true');
		//$data_content['tecnicas']=modules::run('services/relations/get_all','tecnica','true');
		$data_content['arbol_categorias'] = modules::run('services/relations/arbol_categorias', 1, '0', '0', 'producto');
		//echo '<pre>'.print_r($data_content['arbol_categorias'],true).'</pre>';die();
		$data_content['recetas']=modules::run('services/relations/get_all','categoria','true');
		$data_content['productos']=modules::run('services/relations/get_all','producto','true','producto.id_producto');
		$data_content['categorias']=modules::run('services/relations/get_categorias_optgroup');
		//$data_content['categorias']=modules::run('services/relations/get_id_categorias_from_padre',0);
		//echo "<pre>" . print_r($data_content['categorias']) . "</pre>";die();
		//$data_content['videos']=modules::run('services/re lations/get_all','video','true','multimedia.id_multimedia');
		//$data_content['colecciones']=modules::run('services/relations/get_all','coleccion','true','coleccion.id_coleccion');
		//$data_content['catalogos']=modules::run('services/relations/get_all','catalogo','true','multimedia.id_multimedia');
		//$data_content['microsites']=modules::run('services/relations/get_all','microsite','true','microsite.id_microsite');
		$data['main_content'] = $this->load->view('crear_producto',$data_content,true);
		$this->load->view('back/template',$data);
	}
	
	
	
	
	function create($id=''){
		if ($id!=''){
			modules::run('services/monitor/add',$this->lang->line('producto'),$id,$this->session->userdata('id_usuario'),'editar');
		}else{
			modules::run('services/monitor/add',$this->lang->line('producto'),'',$this->session->userdata('id_usuario'),'crear');
			$id=0;
		}
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$data['title']= lang('crear_tit_prod');
		//$data_content['artistas']=modules::run('services/relations/get_all','artista','true','artsita.id_artista');
		//echo '<pre>'.print_r(json_decode($data_content['artistas']),true).'</pre>';
		//die();
		//echo '<pre> hola'.print_r($_POST,true).'</pre>';
		$data_content['arbol_categorias']=modules::run('services/relations/arbol_categorias','0',$id,'producto');
		$data_content['estados']=modules::run('services/relations/get_all','estado','true');
		//$data_content['tecnicas']=modules::run('services/relations/get_all','tecnica','true','tecnica.id_tecnica');
		//$data_content['categorias']=modules::run('services/relations/get_all','categoria','true','categoria.id_categoria');
		$data_content['categorias']=modules::run('services/relations/get_categorias_optgroup');
		//die('<pre>'.print_r(modules::run('services/relations/get_all','categoria','true','categoria.id_categoria'), TRUE).'</pre>');
		$data_content['productos']=modules::run('services/relations/get_all','producto','true','producto.id_producto');
		
		//$data_content['videos']=modules::run('services/relations/get_all','video','true','multimedia.id_multimedia');
		//$data_content['microsites']=modules::run('services/relations/get_all','microsite','true','microsite.id_microsite');
		//$data_content['colecciones']=modules::run('services/relations/get_all','coleccion','true','coleccion.id_coleccion');
		//$data_content['catalogos']=modules::run('services/relations/get_all','catalogo','true','multimedia.id_multimedia');
		//echo '<pre>'.print_r($data,true).'</pre>';
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		//$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		//$this->load->helper(array('form', 'url'));
	
		//$this->form_validation->set_rules('dia', 'Dia', 'callback_dia_check');
		$this->form_validation->set_rules('productos[]', 'Productos relacionados', '');
		//$this->form_validation->set_rules('ean', 'EAN', 'required');
		$this->form_validation->set_rules('codigo_coloplas', 'Codigo Producto', 'required');
		$this->form_validation->set_rules('id_estado', 'Estado', 'required');
		$this->form_validation->set_rules('id_categoria', 'Categoria', 'required');
		$this->form_validation->set_rules('destacado', 'Destacado', '');
		$this->form_validation->set_rules('latitud', 'Latitud Google Maps', '');
		$this->form_validation->set_rules('longitud', 'Longitud Google Maps', '');
		$this->form_validation->set_rules('enlace_video', 'Enlace', 'prep_url|valid_url');
		
		
		if ($this->form_validation->run($this) == FALSE)
		{
			//echo "false";
			//die();
			$data['sub']='crear';
			$data['title']= lang('crear_tit_prod');
			if ($id != ''){
				
				$data_content['producto']=$this->producto_model->read($id);
				$data_content['producto_productos']=modules::run('services/relations/get_all_rel','producto','producto',$id,'true','producto.id_producto');
				$data_content['tipos_cat'] = modules::run('services/relations/get_all', 'tipo_categoria', 'true');
				$data_content['arbol_categorias'] = modules::run('services/relations/arbol_categorias', 1, '0', '0', 'producto');
				//$data_content['producto_videos']=modules::run('services/relations/get_all_rel','producto','video',$id,'true','multimedia.id_multimedia');
				//$data_content['producto_colecciones']=modules::run('services/relations/get_rel','producto','coleccion',$id,'true','coleccion.id_coleccion');
				//$data_content['producto_microsites']=modules::run('services/relations/get_all_rel','producto','microsite',$id,'true','microsite.id_microsite');
				//$data_content['producto_catalogos']=modules::run('services/relations/get_all_rel','producto','catalogo',$id,'true','multimedia.id_multimedia');
				$data_content['imagenes']=modules::run('services/relations/get_rel','producto','imagen',$id,'true');
				$data['title']= lang('producto_editar');
			}
			else{
				$data_content['tipos_cat'] = modules::run('services/relations/get_all', 'tipo_categoria', 'true');
				$data_content['arbol_categorias'] = modules::run('services/relations/arbol_categorias', 1, '0', '0', 'producto');
			}
			$data['active']='producto';
			
			if ($id!=''){
				$data['breadcrumbs']['producto'] = lang('productos');
				$data['breadcrumbs']['edit'] = lang('producto_editar');
				$data['breadcrumbs'][$id] = $data_content['producto']->nombre;
			}else{
				$data['breadcrumbs']=array(lang('backend_url') => lang('backend'), lang('productos_url') => lang('productos'), 'crear' => lang('producto_crear'));
			}
			
			$data['main_content'] = $this->load->view('crear_producto',$data_content,true);
			$this->load->view('back/template',$data);
			//die();
		}else
		{
			$form_data = $_POST;
			//print_r($form_data);die();
			if(!isset($form_data['destacado']))  $form_data['destacado'] = 0;
			
			$form_data['id_usuario']=$this->session->userdata('id_usuario');
			
			
			/*$img=$form_data['imagenName'];
					
			if ($form_data['imagenName']!=''){
				if(isset($form_data['imagenActual']) && $form_data['imagenActual']!='') {
					foreach($form_data['imagenActual'] as $k=>$im_id){
						modules::run('services/relations/delete','producto','multimedia',$im_id);
						modules::run('multimedia/delete_id', $im_id);
					}
				}	
			}	*/
			
			unset($form_data['imagenActual']); unset($form_data['imagenName']); unset($form_data['imagen']);
			
			$img2=$form_data['imagenName2'];
			if ($form_data['imagenName2']!=''){
				if(isset($form_data['imagenActual2']) && $form_data['imagenActual2']!='') {
					foreach($form_data['imagenActual2'] as $k=>$im_id){
							//modules::run('services/relations/delete','producto','multimedia',$im_id);
							//modules::run('multimedia/delete_id', $im_id);
						}
				}
				//if (isset($form_data['imagenActual2'])) $img2=$form_data['imagenActual2'];
				
			}
			
			unset($form_data['imagenActual2']); unset($form_data['imagenName2']); unset($form_data['imagen2']);
			
			
			
			/*$img3=$form_data['imagenName3'];
			if ($form_data['imagenName3']==''){
				if (isset($form_data['imagenActual3'])) $img3=$form_data['imagenActual3'];
				
			}
			unset($form_data['imagenActual3']); unset($form_data['imagenName3']); unset($form_data['imagen3']);

			
			
			$img4=$form_data['imagenName4'];
			if ($form_data['imagenName4']==''){
				if (isset($form_data['imagenActual4'])) $img4=$form_data['imagenActual4'];
				
			}
			unset($form_data['imagenActual4']); unset($form_data['imagenName4']); unset($form_data['imagen4']);
			*/
			
//			echo '<pre>'.print_r($img2,true).'</pre>';
//			die();
			if (isset($form_data['productos'])) $rel['producto']=array_unique($form_data['productos']);

			unset($form_data['productos']);
			unset($form_data['id_tipo_cat']);
			$id=$this->producto_model->update($form_data);
			
			//Borra las relaciones de multimedia en el REL y las inserta todas nuevamente.
			//modules::run('services/relations/delete','producto','multimedia',$id);
			
			modules::run('services/relations/delete','producto','producto',$id);

			if (isset($rel) && !empty($rel) && is_array($rel)){
				foreach($rel as $t=>$r){
					modules::run('services/relations/insert_rel','producto',$t,$r,$id);
				}
			}
			
			// Foto Logo - Destacado = 1
			
			if (isset($img) && $img!='') $this->crear_multimedia($img, $id, 'producto', '1', '', '100', '71', '140', '100', '140', '100');// $this->crear_multimedia($img,$id,'producto','1','','20','40','40','80','80','160');
			
			// Foto Principal - Destacado = '0'
			//if (isset($img2) && $img2!='' && !empty($img2)) $this->crear_multimedia($img2,$id,'producto','','','120','75','720','450','1440','900');
			if (isset($img2) && $img2!='' && !empty($img2)){
				foreach($img2 as $k=>$im){ 
					$this->crear_multimedia($im,$id,'producto','2','','100','47','530','250','530','250');
				}
			}
			/*
			// Foto Planos - Destacado = 2
			if (isset($img3) && $img3!='' && !empty($img3)){
				foreach($img3 as $k=>$im){ 
					$this->crear_multimedia($im,$id,'producto','2','','50','66','200','250','400','500');
				}
			}
			
			// Foto Inmuebles - Destacado = 3
			if (isset($img4) && $img4!='' && !empty($img4)){
				foreach($img4 as $k=>$im){ 
					$this->crear_multimedia($im,$id,'producto','3','','150','75','250','125','500','250');
				}
			}*/

			redirect('backend/ficha_'.lang('producto_url').'/'.$id,'location');

		}
		
		
	}

	function edit($id='',$ajax=false){
		if ($id=='') redirect('backend');
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$data['active']='producto';
		$data['sub']='editar';
		//if ($id=='') redirect('backend');
		//$data['relations'] = $this->load->view('relations','',true);
		
		$data_content['producto']=$this->producto_model->read($id);
		
		$data['breadcrumbs']=array(lang('backend_url') => lang('backend'), lang('productos_url') => lang('productos'),'edit' => lang('producto_editar'), $id => $data_content['producto']->nombre);
		
		$data['title']='Editar '.$data_content['producto']->nombre;
		//$data_content['artistas']=modules::run('services/relations/get_all','artista','true','artista.id_artista');
		$data_content['estados']=modules::run('services/relations/get_all','estado','true');
		$data_content['tipos_cat'] = modules::run('services/relations/get_all', 'tipo_categoria', 'true');
		//echo "<pre>"; print_r($data_content );die();
		$data_content['arbol_categorias'] = modules::run('services/relations/arbol_categorias', $data_content['producto']->id_tipo_cat, $id, $data_content['producto']->id_categoria, 'producto');
        
		//$data_content['tecnicas']=modules::run('services/relations/get_all','tecnica','true');
		//$data_content['arbol_categorias']=modules::run('services/relations/arbol_categorias','0',$data_content['producto']->id_categoria,'producto');
		
		$data_content['recetas']=modules::run('services/relations/get_all','categoria','true');
		$data_content['productos']=modules::run('services/relations/get_all','producto','true');
		//$data_content['microsites']=modules::run('services/relations/get_all','microsite','true');
		//$data_content['catalogos']=modules::run('services/relations/get_all','catalogo','true');
		
		//$data_content['videos']=modules::run('services/relations/get_all','video','true');
		$data_content['imagenes']=modules::run('services/relations/get_rel','producto','imagen',$id,'true');
		//$data_content['colecciones']=modules::run('services/relations/get_all','coleccion','true');
		$data_content['producto_productos']=modules::run('services/relations/get_all_rel','producto','producto',$id,'true','producto.id_producto');
		//echo "<pre>" . print_r($data_content['productos'])."</pre>";
		//echo "<pre>" . print_r($data_content['producto_productos'])."</pre>";die();
		//$data_content['producto_videos']=modules::run('services/relations/get_all_rel','producto','video',$id,'true','multimedia.id_multimedia');
		//$data_content['producto_microsites']=modules::run('services/relations/get_all_rel','producto','microsite',$id,'true','microsite.id_microsite');
		//$data_content['producto_catalogos']=modules::run('services/relations/get_all_rel','producto','catalogo',$id,'true','multimedia.id_multimedia');
		//$data_content['producto_colecciones']=modules::run('services/relations/get_rel','producto','coleccion',$id,'true','coleccion.id_coleccion');
		$data_content['imagenes']=modules::run('services/relations/get_rel','producto','imagen',$id,'true');
		$data_content['categorias']=modules::run('services/relations/get_categorias_optgroup');
		
		//echo "<pre>ProdITEM"; print_r($data_content['categorias']); echo "</pre>";
		
		$data['main_content'] = $this->load->view('crear_producto',$data_content,true);
		//$data['main_content']=json_encode($data_content['producto']);
		//echo json_encode($data_content['producto']);
		//die();
		
		if ($ajax)
			echo $data['main_content'];
		else
			$this->load->view('back/template',$data);
		
		//return json_encode($this->producto_model->read($id));
	}
	function ficha($id=''){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		if ($id=='') redirect('backend/'.lang('producto_url'));
		$data['active']='producto';
		$data['sub']='editar';
		//$data['relations'] = $this->load->view('relations','',true);
		$data_content['producto']=$this->producto_model->read($id);
		$data['breadcrumbs']=array(lang('backend_url') => lang('backend'), lang('productos_url') => lang('productos'),''=> lang('listado'), $id=>(isset($data_content['producto']->nombre) ? $this->lang->line('ficha_titulo').' '.$data_content['producto']->nombre : lang('producto_sintitulo')));
		$data['title']=(isset($data_content['producto']->nombre) ? lang('ficha_inicio').' '.$data_content['producto']->nombre : lang('producto_sintitulo'));
		$data_content['producto_idiomas'] = $this->producto_model->detalles($id);
		$data_content['cat_path']=modules::run('services/relations/get_categoria_bc',$data_content['producto']->id_categoria);
		$data_content['producto_productos']=json_decode(modules::run('services/relations/get_all_rel','producto','producto',$id,'true','producto.id_producto'));
		//$data_content['producto_videos']=json_decode(modules::run('services/relations/get_all_rel','producto','video',$id,'true','multimedia.id_multimedia'));
		//$data_content['producto_catalogos']=json_decode(modules::run('services/relations/get_all_rel','producto','catalogo',$id,'true','multimedia.id_multimedia'));
		//$data_content['producto_colecciones']=json_decode(modules::run('services/relations/get_rel','producto','coleccion',$id,'true','coleccion.id_coleccion'));
		//$data_content['producto_microsites']=json_decode(modules::run('services/relations/get_rel','producto','microsite',$id,'true','microsite.id_microsite'));
		$data_content['imagenes']=modules::run('services/relations/get_rel','producto','imagen',$id,'true');
		$data['main_content'] = $this->load->view('ficha_producto',$data_content,true);
		$this->load->view('back/template',$data);
		//return json_encode($this->producto_model->read($id));
	}
	function editar_idioma($id_producto,$id_detalle_producto=''){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		if ($id_detalle_producto=='') redirect('backend/ficha_producto/'.$id_producto);
		
		echo modules::run('template/editar_idioma_form',$id_producto,$id_detalle_producto,'producto');
		
	}
	function guardar_idioma(){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		//echo '<pre> POST:'.print_r($_POST,true).'</pre>';
		//echo '<pre> FILES:'.print_r($_FILES,true).'</pre>';
		$data_content=$_POST;
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		$this->load->helper(array('form', 'url'));
		$this->form_validation->set_rules('id_idioma', 'Idioma', 'required');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required|min_length[5]');
		$this->form_validation->set_rules('descripcion_breve', 'Descripcion Breve', 'min_length[10]');
		$this->form_validation->set_rules('descripcion_ampliada', 'Descripcion Ampliada', 'min_length[50]');
		$this->form_validation->set_rules('url', 'URL', 'required|min_length[5]');
		$this->form_validation->set_rules('descripcion_imagen', 'Descripcion Imagen', '');
		$this->form_validation->set_rules('titulo_pagina', 'Titulo pagina', 'required|min_length[5]');
		$this->form_validation->set_rules('descripcion_pagina', 'Descripcion Pagina', '');
		$this->form_validation->set_rules('keywords', 'Plabras clave', '');
		$this->form_validation->set_rules('tags', 'Tags', '');
		
        $config['upload_path'] = './assets/front/pdf';
        $config['allowed_types'] = 'pdf';
        $this->load->library('upload', $config);
        
        
        
		if ($this->form_validation->run($this) == FALSE)
		{
			$data['active']='producto';
			$data['sub']='crear';
			$data['title']= lang('idioma_editar').' '.lang('producto_url');
			if ($data_content['id_producto']!=''){
				$data_content['producto']=modules::run($this->lang->line('producto_url').'/read',$data_content['id_producto']);
				$data['breadcrumbs']['producto'] = lang('productos');
				$data['breadcrumbs']['edit'] = lang('idioma_edt_prd');
				$data['breadcrumbs'][$data_content['id_producto']] = $data_content['nombre'];
				//$data_content['imagen']=modules::run('services/relations/get_rel','producto','imagen',$data_content['id_producto'],'true');
				$fichero = modules::run('services/relations/get_rel','producto','imagen',$data_content['id_producto'],'false');
				$data_content['imagen'] = $fichero->fichero;
			}else{
				$data['breadcrumbs'] = array(lang('producto_url') => lang('productos'),'crear' => lang('producto_crear'));
			}
			$data_content['nuevo'] = true;
			$data['main_content'] = $this->load->view('template/crear_idioma_form_producto',$data_content,true);
			$this->load->view('back/template',$data);
			
		}if(isset($_FILES['pdf']['error']) && $_FILES['pdf']['error'] !=4 && ! $this->upload->do_upload('pdf')){
			$data['active']='producto';
			$data['sub']='crear';
			$data['title'] = lang('idioma_edt_prd');
			if ($data_content['id_producto']!=''){
				$data_content['producto']=modules::run($this->lang->line('producto_url').'/read',$data_content['id_producto']);
				$data['breadcrumbs']['producto'] = lang('productos');
				$data['breadcrumbs']['edit'] = lang('idioma_edt_prd');
				$data['breadcrumbs'][$data_content['id_producto']] = $data_content['nombre'];
				//$data_content['imagen']=modules::run('services/relations/get_rel','producto','imagen',$data_content['id_producto'],'true');
				$fichero = modules::run('services/relations/get_rel','producto','imagen',$data_content['id_producto'],'false');
				$data_content['imagen']=$fichero->fichero;
			}else{
				$data['breadcrumbs']=array(lang('producto_url') => lang('productos'),'crear' => lang('productos_crear'));
			}
			$data_content['nuevo']=true;
			$data_content['error'] =$this->upload->display_errors('<p class="error">', '</p>');
			$data['main_content'] = $this->load->view('template/crear_idioma_form_producto',$data_content,true);
			$this->load->view('back/template',$data);
			
		}
		else{
			
			/*****************/
            /***UPLOAD PDF****/
            /*****************/
            if (isset($_FILES['pdf']['error']) && $_FILES['pdf']['error']!=4){
                $pdf_data = array('upload_data' => $this->upload->data());
                //echo '<pre>'.print_r($pdf_data,true).'</pre>';
                $data_content['pdf']=$pdf_data['upload_data']['file_name'];
                //exit();
            }
            
            
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
			$id=$this->producto_model->update_idioma($data_content);
			if (isset($tags)){
				$tags=array_unique($tags);
				modules::run('services/relations/delete','detalle_producto','tag',$id);
				foreach($tags as $tag){
					modules::run('services/relations/insert_tag',$tag,'detalle_producto',$id,$data_content['id_idioma']);
				}
			}
			modules::run('services/monitor/add','detalle_producto',$id,$this->session->userdata('id_usuario'),'editar_idioma');
			redirect('backend/ficha_'.lang('producto_url').'/'.$data_content['id_producto']);
		}
	}
	function eliminar_idioma($id,$ajax=false){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		modules::run('services/monitor/add','detalle_'.lang('producto_url'),$id,$this->session->userdata('id_usuario'),'eliminar_idioma');
		$detalle=$this->detalle($id);
		$ret=$this->producto_model->eliminar_idioma($id);
		$str=($ret==true) ? 'true' : 'false';
		if ($ajax) echo '[{result:'.$str.'}]';
		else redirect('backend/ficha_'.lang('producto_url').'/'.$detalle->id_producto);
	}
	function delete($id,$ajax=false){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$ret=$this->producto_model->delete($id);
		$str=($ret==true) ? 'true' : 'false';
		if ($ajax) echo '[{result:'.$str.'}]';
		else return $ret;
	}
	
	
	
	/*
	 * Fin funcciones del admin */
	
	
	/*
	 * Funciones generales, accesibles sin autentificacion */
	
	function read($id,$ajax=false,$detalle_id=''){
		$ret=$this->producto_model->read($id,$detalle_id);
		if ($ajax) echo json_encode($ret);
		else return $ret;
	}
	function get_producto($output='json',$id=''){
		$producto=$this->producto_model->read($id);
		if ($output=='xml'){
			$domDoc = new DOMDocument;
			$rootElt = $domDoc->createElement('producto');
			$rootNode = $domDoc->appendChild($rootElt);
			foreach($producto as $field=>$value){
				$subElt = $domDoc->createElement($field);
				$textNode = $domDoc->createTextNode($value);
				$subElt->appendChild($textNode);
				$rootNode->appendChild($subElt);
			}
			header('Content-Type: text/xml');
			echo $domDoc->saveXML();
		}elseif($output=='json'){
			echo json_encode($producto);
		}
	}
	function get_producto_list($output='json',$f='producto.id_producto',$v=1,$group=false){
		$productos=$this->producto_model->get_list($f,$v,$group);
		if ($output=='xml'){
			$domDoc = new DOMDocument;
			foreach ($productos as $producto){
				$rootElt = $domDoc->createElement('producto');
				$rootNode = $domDoc->appendChild($rootElt);
				foreach($producto as $field=>$value){
					$subElt = $domDoc->createElement($field);
					$textNode = $domDoc->createTextNode($value);
					$subElt->appendChild($textNode);
					$rootNode->appendChild($subElt);
				}
			}
			header('Content-Type: text/xml');
			echo $domDoc->saveXML();
		}elseif($output=='json'){
			echo json_encode($productos);
		}
	}
	function detalle($id,$ajax=false){
		$ret=$this->producto_model->get('detalle_producto',$id);
		if ($ajax) echo json_encode($ret);
		else return $ret;
	}
	function productos_categoria($id_categoria,$ajax=1){
		if ($ajax==1)
			echo modules::run('services/relations/get_from_categoria',$id_categoria,'producto',$ajax);
		else return modules::run('services/relations/get_from_categoria',$id_categoria,'producto',$ajax);
	}
	
	/* 
	 * Fin funciones libres */
	
	/*funciones de callback
	 * */
	function dia_check($str)
	{
		if ((int)$str > 31)
		{
			$this->form_validation->set_message('dia_check', lang('dia_check'));
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
			$this->form_validation->set_message('mes_check', lang('mes_check'));
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
			$this->form_validation->set_message('ano_check', lang('ano_check').date('Y'));
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
	
	
	function crear_multimedia($img='',$id='',$tipo='',$destacado='',$img_folder='',$width='120',$height='120',$med_w='400',$med_h='400', $large_w='800',$large_h='800')
	{
				$img_folder = ($img_folder!='' ? $img_folder : 'assets/front/img/');
				$img_new = $id.rand(5,99999999).'_'.$img;
				
				//insert image into multimedia
				modules::run('services/relations/insert_image',$img_new,$id,$tipo,$destacado);
				if (is_file(FCPATH.$img_folder.'temp/'.$img)){
					if (!is_dir(FCPATH.$img_folder.'thumb/')) mkdir(FCPATH.$img_folder.'thumb/');
					if (!is_dir(FCPATH.$img_folder.'med/')) mkdir(FCPATH.$img_folder.'med/');
					if (!is_dir(FCPATH.$img_folder.'large/')) mkdir(FCPATH.$img_folder.'large/');
					$this->load->library('image_lib');
					$config['image_library'] = 'gd2';
					$config['source_image']	= FCPATH.$img_folder.'temp/'.$img;
					
					
					// Imagen Thumbnail
					
					$config['new_image']	= FCPATH.$img_folder.'thumb/'.$img_new;
					$config['maintain_ratio'] = TRUE;
					$config['width']	 = $width;
					$config['height']	= $height;
					$this->load->library('image_lib');
					$this->image_lib->initialize($config);
					if ( ! $this->image_lib->resize())
					{
						echo $this->image_lib->display_errors();
					}
					
					// Imagen Medium
					
					$config['new_image']	= FCPATH.$img_folder.'med/'.$img_new;
					$config['width']	 = $med_w;
					$config['height']	= $med_h;
					
					$this->image_lib->initialize($config);
					if ( ! $this->image_lib->resize())
					{
						echo $this->image_lib->display_errors();
					}
					
					// Imagen Large
					$config['new_image']	= FCPATH.$img_folder.'large/'.$img_new;
					$config['width']	 = $large_w;
					$config['height']	= $large_h;
					$this->image_lib->initialize($config);
					if ( ! $this->image_lib->resize())
					{
						echo $this->image_lib->display_errors();
					}
					if (is_file(FCPATH.$img_folder.'temp/'.$img)) unlink( FCPATH.$img_folder.'temp/'.$img);
				}
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
