<?php

class promocion_front extends MX_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->model('promocion_model');
		if ($this->session->userdata('idioma')=='') $this->session->set_userdata('idioma','en');
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$this->id_idioma=modules::run('idioma/get_idioma_id_from_code',$this->session->userdata('idioma'));
		$this->lang->load('front');
	}

	function index()
	{
		//$this->promociones($this->uri->segment(2));
		
		$data_content = 1;
		
		$data['contenido_principal']=$this->load->view('front/promocion_listado',$data_content,true);
			
		$data['title']='Titulo promocion';
		
		$this->load->view('front/template',$data);
	}
	
	function detalle_promociones($promocion='',$ajax=false)
	{
		//echo 'DETALLE';
		if (is_numeric($promocion) || $promocion=='') $id_promocion=$promocion;
		else $id_promocion=modules::run('services/relations/get_id_from_url','promocion',$promocion);
		$promocion = $this->promocion_model->read($id_promocion);
		$data_content['promocion_detalle'] = $promocion;
			
			$nombre = ($promocion->nombre!='' ? $promocion->nombre : $this->lang->line('sin_titulo'));
			$url = ($promocion->url!='' ? $promocion->url : $promocion->id_promocion);
			
				$data['main']=$this->lang->line('sala_prensa');
				$data['sub']=$this->lang->line('sala_prensa_url');
				$data['title']=$this->lang->line('sala_prensa')." > ".$promocion->titulo_pagina;
				$data['meta_descripcion']=$promocion->descripcion_pagina;
				$data['meta_keywords']=$promocion->keywords;
				
			//$data_content['breadcrumbs']=array('/'=>$this->lang->line('inicio'),$this->lang->line('sala_prensa_url')=>$this->lang->line('sala_prensa'),$this->lang->line('sala_prensa.promociones_url')=>$this->lang->line('sala_prensa.promociones'),$url=>$nombre);
			$data_content['activa']=$this->lang->line('sala_prensa.promociones_url');
			//$data_content['menu_izquierda']=$this->load->view('front/menu_izquierda',$data_content,true);
			
			//$where = array("id_categoria"=>$sub_familia['id_categoria']);
			//$data_content['promociones']=modules::run('services/relations/get_all','promocion',false,'',true);
			
			$data_content['promociones']=modules::run('services/relations/get_all','promocion',false,'',true);
			//$data_content['promociones'] = modules::run('services/relations/get_all_orderby','promocion',false,'',true,'promocion.id_promocion');
			
			$data['contenido_principal']=$this->load->view('front/promocion_listado',$data_content,true);
			
			$data['title']=$promocion->titulo_pagina.' - '.$this->lang->line('promociones');
			
			$this->load->view('front/template',$data);
		
	}

		
	
	function promociones($promocion='',$ajax=false)
	{
		$data['main']=$this->lang->line('sala_prensa');
		if ($promocion==''){
			$this->listado_promociones();
			//echo "Categoria diferente de vacio";
		}
		else
		{
			$this->detalle_promociones($promocion);
		}
	}
	
	function listado_promociones($ajax=false)
	{
		//		$data_content = 1;
		//$data['contenido_principal']=$this->load->view('front/promocion_listado',$data_content,true);
		//$data['title']='Titulo promocion';
		//$this->load->view('front/template',$data);
		
		
			$data['main']=$this->lang->line('sala_prensa');
			$nombre = $this->lang->line('sala_prensa.promociones');
			$url = $this->lang->line('sala_prensa.promociones_url');
			//$data_content['breadcrumbs']=array('/'=>$this->lang->line('inicio'),$this->lang->line('sala_prensa_url')=>$this->lang->line('sala_prensa'),$url=>$nombre);
			$data_content['activa']=$this->lang->line('sala_prensa.promociones_url');
			//$data_content['menu_izquierda']=$this->load->view('front/menu_izquierda',$data_content,true);
			//$where = array("id_categoria"=>$sub_familia['id_categoria']);
			
			$data_content['promociones_listado'] = modules::run('services/relations/get_all_orderby','promocion',false,'',true,'promocion.id_promocion');
			
			
			//echo "<pre>"; print_r($data_content['promociones_listado']); echo "</pre>";
			if (!empty($data_content['promociones_listado']) && $data_content['promociones_listado']!='')
			{
				$promocion_url = (isset($data_content['promociones_listado'][0]->url) && $data_content['promociones_listado'][0]->url!='' ? $data_content['promociones_listado'][0]->url : '');
			     redirect($this->lang->line('promociones_url').'/'.$promocion_url);
			}
			else
			{
				$data_content['promociones_listado'] = modules::run('services/relations/get_from_categoria', $data_content['familia']->id_categoria, 'promocion');
				if (!empty($data_content['promociones_listado']) && $data_content['promociones_listado']!='')
				{
					$promocion_url = (isset($data_content['promociones_listado'][0]->url) && $data_content['promociones_listado'][0]->url!='' ? $data_content['promociones_listado'][0]->url : '');
				     redirect($this->lang->line('promociones_url').'/'.$promocion_url);
				}
				else
				{
					redirect($this->lang->line('promociones_url'));
				}
			}
			
			
			$data_content['promociones']=modules::run('services/relations/get_all','promocion',false,'',true);
			$data['contenido_principal']=$this->load->view('front/promocion_listado',$data_content,true);
			
			$data['title']=$this->lang->line('promociones.meta.title').' - '.$this->lang->line('meta.title');
			$data['meta_descripcion']=$this->lang->line('promociones.meta.description');
			$data['meta_keywords']=$this->lang->line('promociones.meta.keywords');
			
			$this->load->view('front/template',$data);
			
			
	}
	
	function dossier($ajax=false)
	{
			$data['main']=$this->lang->line('sala_prensa');
			$nombre = $this->lang->line('sala_prensa.dossier');
			$url = $this->lang->line('sala_prensa.dossier_url');
			$data_content['breadcrumbs']=array('/'=>$this->lang->line('inicio'),$this->lang->line('sala_prensa_url')=>$this->lang->line('sala_prensa'),$url=>$nombre);
			$data_content['activa']=$this->lang->line('sala_prensa.dossier_url');
			$data_content['menu_izquierda']=$this->load->view('front/menu_izquierda',$data_content,true);
			//$where = array("id_categoria"=>$sub_familia['id_categoria']);
			$data_content['promociones']=modules::run('services/relations/get_all','promocion',false,'',true);
			$data['main_content']=$this->load->view('front/dossier',$data_content,true);
			$this->load->view('front/template',$data);
	}
	
	function imagenes($ajax=false)
	{	
			$data['main']=$this->lang->line('sala_prensa');
			$nombre = $this->lang->line('sala_prensa.imagenes');
			$url = $this->lang->line('sala_prensa.imagenes_url');
			$data_content['breadcrumbs']=array('/'=>$this->lang->line('inicio'),$this->lang->line('sala_prensa_url')=>$this->lang->line('sala_prensa'),$url=>$nombre);
			$data_content['activa']=$this->lang->line('sala_prensa.imagenes_url');
			
			$data_content['categorias_familias'] = modules::run('services/relations/get_categorias',0,false);
			
			$data_content['menu_izquierda']=$this->load->view('front/menu_izquierda',$data_content,true);
			//$where = array("id_categoria"=>$sub_familia['id_categoria']);
			//$data_content['promociones']=modules::run('services/relations/get_all','promocion',false,'',true);
			$data['main_content']=$this->load->view('front/imagenes',$data_content,true);
			$this->load->view('front/template',$data);
	}

}
/* End of file exposicion_front.php */

