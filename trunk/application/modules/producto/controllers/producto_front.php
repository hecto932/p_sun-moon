<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * 
 * Controlador de front/productos
 * 
 * @author Ale
 */
class Producto_front extends MX_Controller {

	/**
	 * 
	 * Constructor de la clase
	 * 
	 */
	public function __construct()
	{
		
		parent::__construct();
		
		$this->load->model('producto_model');
		
		if ($this->session->userdata('idioma') == '')
			$this->session->set_userdata('idioma','en');
		
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		
		$this->id_idioma = modules::run('idioma/get_idioma_id_from_code',$this->session->userdata('idioma'));
		
		$this->lang->load('front');
		
	}

	/**
	 * 
	 * Página principal
	 * 
	 */
	public function index()
	{
		
		$arbol = modules::run('services/relations/get_arbol_categorias', 0);
		$data['arbol_cat']  = array();
		$data['error']  = 0;
		$data['placeholder'] = lang('productos_placeholder_categoria');
		if(isset($arbol)&&($arbol!=NULL))
		{
		foreach ($arbol as $valor) {
			
			$data['arbol_cat']=array_merge($data['arbol_cat'],$valor->child);
		}
		}

		//echo '<pre>'.print_r($data['arbol_cat'], TRUE).'</pre>'; die('xxxx');
		if(isset($data['arbol_cat'])&&($data['arbol_cat']!=NULL))
			{
			$data['title']=$this->lang->line('productos.meta.title').' | '.$this->lang->line('inicio.meta.title');
			$data['meta_descripcion']=$this->lang->line('productos.meta.description').' | '.$this->lang->line('inicio.meta.description');
			$data['meta_keywords']=$this->lang->line('productos.meta.keywords').' | '.$this->lang->line('inicio.meta.keywords');
			}else{
				$data['error']=1;
				$data['title']=$this->lang->line('productos.meta.title').' | '.$this->lang->line('inicio.meta.title');
				$data['meta_descripcion']=$this->lang->line('productos.meta.description').' | '.$this->lang->line('inicio.meta.description');
				$data['meta_keywords']=$this->lang->line('productos.meta.keywords').' | '.$this->lang->line('inicio.meta.keywords');
			}
		
		$data['contenido_principal'] = $this->load->view('front/listado_categorias', $data, TRUE);
		$this->load->view('front/template', $data);
		
		
	}

	public function listar_subcategorias($url='')
	{
		
		    if(is_numeric($url))
		{
			$id_categorias=$url;
		}else{
			$id_categorias=modules::run('services/relations/get_id_categoria_url', $url);

		}
		if(isset($id_categorias)&&($id_categorias!='')) 
		{
		
		$titulo_pagina = modules::run('services/relations/get_titulo_pagina', $id_categorias);
		$descripcion_pagina = modules::run('services/relations/get_descripcion_pagina', $id_categorias);
		$keywords = modules::run('services/relations/get_keywords_pagina', $id_categorias);
		$data['id'] = $id_categorias;
		$data['error']  = 0;
		$data['placeholder'] = lang('productos_placeholder_categoria');
		$arbol_cat = array();

		$data['subcategorias'] = modules::run('services/relations/get_arbol_categorias', $id_categorias);
		//echo '<pre>'.print_r($data['subcategorias'], TRUE).'</pre>'; die('xxxx');
		
		$arbol = modules::run('services/relations/get_arbol_categorias', 0);
		//echo '<pre>'.print_r($arbol, TRUE).'</pre>'; die('xxxx');
		if(isset($arbol)&&($arbol!=NULL))
		{
			foreach ($arbol as $valor)
			{
			$arbol_cat=array_merge($arbol_cat,$valor->child);
			}
			 foreach($arbol_cat as $categoria)
			 { if($categoria->id_categoria==$id_categorias)
			 	{
			 		$data['padre_nombre'] =  $categoria->nombre;
				} 
			 } 
			 
			$data['title']=$titulo_pagina.' | '.$this->lang->line('productos.meta.title').' | '.$this->lang->line('meta.title');
			$data['meta_descripcion']=$descripcion_pagina.' | '.$this->lang->line('productos.meta.description').' | '.$this->lang->line('meta.description');
			$data['meta_keywords']=$keywords.' | '.$this->lang->line('productos.meta.keywords').' | '.$this->lang->line('meta.keywords');
		}
		
		if($data['subcategorias']==NULL)
		{
			$data['error'] = 1;
		}
		
		
		$data['contenido_principal'] = $this->load->view('front/listado_subcategorias', $data, TRUE);
	    $this->load->view('front/template', $data);	
		
		}else{
			redirect('productos');
		}
	
	}
	

	public function listar($url='')
	{
		if(is_numeric($url))
		{
			$id_categorias=$url;
		}else{
			$id_categorias=modules::run('services/relations/get_id_categoria_url', $url);
			//echo $id_categoria;die('xx');
		}
		if(isset($id_categorias)&&($id_categorias!='')) 
		{
			$titulo_pagina = modules::run('services/relations/get_titulo_pagina', $id_categorias);
			$descripcion_pagina = modules::run('services/relations/get_descripcion_pagina', $id_categorias);
			$keywords = modules::run('services/relations/get_keywords_pagina', $id_categorias);

			$data['id']=$id_categorias;
			$data['error']=0;
			$arbol_cat  = array();
			$arbol_cat_2  = array();
			$data['placeholder'] = lang('productos_placeholder_producto');
			$arbol = modules::run('services/relations/get_arbol_categorias', 0);
			foreach ($arbol as $valor) 
			{
				$arbol_cat =array_merge($arbol_cat,$valor->child);
			}
			foreach ($arbol_cat as $valor) 
			{
				$arbol_cat_2 =array_merge($arbol_cat_2,$valor->child);
			}

			foreach($arbol_cat_2 as $categoria)
			 {
				if($categoria->id_categoria==$id_categorias)
			 	{
			 		$id_padre = $categoria->id_categoria_padre;
					$padre_1 = modules::run('services/relations/get_categoria_id', $id_padre);
					$data['padre_nombre_2'] = $categoria->nombre;
				}
			 }
			 //echo '<pre>'.print_r($padre_1[0],TRUE).'</pre>';die('ooooo');
			 $data['padre_nombre_1'] = $padre_1[0]->nombre;
			 $data['padre_url_1']	 = $padre_1[0]->url;
			 $padre_titulo	 		 = $padre_1[0]->titulo_pagina;
			 $padre_descripcion		 = $padre_1[0]->descripcion_pagina;
			 $padre_keywords		 = $padre_1[0]->keywords;

				$data['arbol_productos'] = modules::run('services/relations/get_from_categoria', $data['id'], 'producto',false,true);
				//echo '<pre>'.print_r($data['arbol_cat'],TRUE).'</pre>';die('ooooo');
				
				if(isset($data['arbol_productos'])&&($data['arbol_productos']!=NULL))
				{
			
				$data['title']=$titulo_pagina.' | '.$padre_titulo.' | '.$this->lang->line('productos.meta.title').' | '.$this->lang->line('meta.title');
				$data['meta_descripcion']=$descripcion_pagina.' | '.$padre_descripcion.' | '.$this->lang->line('productos.meta.description').' | '.$this->lang->line('meta.description');
				$data['meta_keywords']=$keywords.' | '.$padre_keywords.' | '.$this->lang->line('productos.meta.keywords').' | '.$this->lang->line('meta.keywords');
				
			}else{
				
				$data['error']=1;
				$data['title']=$this->lang->line('productos.meta.title').' | '.$this->lang->line('inicio.meta.title');
				$data['meta_descripcion']=$this->lang->line('productos.meta.description').' | '.$this->lang->line('inicio.meta.description');
				$data['meta_keywords']=$this->lang->line('productos.meta.keywords').' | '.$this->lang->line('inicio.meta.keywords');
			
			}
			
				$data['contenido_principal'] = $this->load->view('front/listado_productos', $data, TRUE);
				$this->load->view('front/template', $data);	
			
		}else{
			redirect('productos');
		}

		
	}
	

	public function detalle($url='')
	{
		if(is_numeric($url))
		{
			$id_producto=$url;
			
		}else{
			$id_producto=modules::run('services/relations/get_id_producto_url', $url);
			//echo $id_categoria;die('xx');
		}
		if(isset($id_producto)&&($id_producto!='')) {
			
		$titulo_pagina = modules::run('services/relations/get_titulo_pagina_producto', $id_producto);
		$descripcion_pagina = modules::run('services/relations/get_descripcion_pagina_producto', $id_producto);
		$keywords = modules::run('services/relations/get_keywords_pagina_producto', $id_producto);
		
		$id_categoria = modules::run('services/relations/get_id_padre_producto', $id_producto);
		$titulo_pagina_padre = modules::run('services/relations/get_titulo_pagina', $id_categoria);
		$descripcion_pagina_padre = modules::run('services/relations/get_descripcion_pagina', $id_categoria);
		$keywords_padre = modules::run('services/relations/get_keywords_pagina', $id_categoria);
		
		$id_abuelo = modules::run('services/relations/get_id_padre', $id_categoria);
		$titulo_pagina_abuelo = modules::run('services/relations/get_titulo_pagina', $id_abuelo);
		$descripcion_pagina_abuelo = modules::run('services/relations/get_descripcion_pagina', $id_abuelo);
		$keywords_abuelo = modules::run('services/relations/get_keywords_pagina', $id_abuelo);
		
		$data['producto']=$this->producto_model->read($id_producto);
		$data['relacion']=modules::run('services/relations/get_rel','producto','producto', $id_producto);
		$data['producto_min_1']=$this->producto_model->read($id_producto+1);
		$data['producto_min_2']=$this->producto_model->read($id_producto-1);
		//echo '<pre>'.print_r($relacion, TRUE).'</pre>'; die('');
		$data['error']  = 0;
		$data['placeholder'] = lang('productos_placeholder_producto');
    	$data['imagen'] = modules::run('services/relations/get_rel', 'producto', 'imagen', $id_producto,'',false);
		//echo '<pre>'.print_r($data['imagen'],TRUE).'</pre>';die('ooooo');
		if(isset($data['producto'])&&($data['producto']!=NULL))
			{
			$data['title']=$titulo_pagina.' | '.$titulo_pagina_padre.' | '.$titulo_pagina_abuelo.' | '.$this->lang->line('productos.meta.title').' | '.$this->lang->line('meta.title');
			$data['meta_descripcion']=$descripcion_pagina.' | '.$descripcion_pagina_padre.' | '.$descripcion_pagina_abuelo.' | '.$this->lang->line('productos.meta.description').' | '.$this->lang->line('meta.description');
			$data['meta_keywords']=$keywords.' | '.$keywords_padre.' | '.$keywords_abuelo.' | '.$this->lang->line('productos.meta.keywords').' | '.$this->lang->line('meta.keywords');
			}else{
			$data['error']=1;
			$data['title']=$this->lang->line('productos.meta.title').' | '.$this->lang->line('inicio.meta.title');
			$data['meta_descripcion']=$this->lang->line('productos.meta.description');
			$data['meta_keywords']=$this->lang->line('productos.meta.keywords');
			}
			$data['contenido_principal'] = $this->load->view('front/productos_detalle', $data, TRUE);
			$this->load->view('front/template', $data);	
		
		}else{
			redirect('productos');
		}
		
	}

}

/* End of file exposicion_front.php */
