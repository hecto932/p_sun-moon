<?php

class Front extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		modules::run('idioma/set_idioma', 'es');
		$this->id_idioma = modules::run('idioma/get_idioma_id_from_code', 'es');
		$this->load->library('user_agent');
		if ($this->session->userdata('idioma') =='') $this->session->set_userdata('idioma','es');
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$this->id_idioma = modules::run('idioma/get_idioma_id_from_code',$this->session->userdata('idioma'));
		$this->lang->load('front',$this->session->userdata('idioma'));
	}

	function index()
	{
		$this->load->model('noticia/noticia_model');
		$this->load->model('evento/evento_model');
		$this->load->model('banner/banner_model');

		if($this->session->userdata('logged_in') == FALSE )
		{
			$this->session->set_userdata('logged_in', FALSE);
		}
		$noticias = $this->noticia_model->get_posts(4, 'desc', array('noticia.id_estado' => 1,'detalle_noticia.id_idioma'=>$this->id_idioma));
		$data['noticias_footer'] = array_slice($noticias, 0, 4);
		$data['eventos_footer'] = $this->evento_model->get_page(0, 4, 'evento.id_evento', 'asc', 'front', array('evento.id_estado' => 1,'detalle_evento.id_idioma'=>$this->id_idioma));
		//$data['eventos_home'] = $this->evento_model->get_posts(4, 'desc', array('evento.id_estado' => 1));
		//$data['eventos_home'] = $this->evento_model->get_page_home(0,2,'evento.id_evento','','front',array('evento.id_estado' => 1));
		$data['eventos_home'] = $this->evento_model->get_page(0,2,'evento.id_evento','','front',array('evento.id_estado' => 1));
		$data['noticias_home'] = array_slice($noticias, 0, 3);
		$data['title'] = lang('menu.inicio').' - '.lang('inicio.meta.title');
		$data['meta_descripcion'] = lang('inicio.meta.description');
		$data['meta_keywords'] = lang('inicio.meta.keywords');
		
		$banners = $this->banner_model->get_page_fichero(0,5,'banner.id_banner','asc',array('banner.id_estado' => 1));
		
		foreach($banners as $banner)
			$ban[$banner->enlace] = $banner->ruta_banner;
		
		for($i=1;$i<=5;$i++)
		{
			if(!isset($ban[$i]))
			{
				$x = $i+1;
				$ban[$i] = base_url().'assets/front/img/temp/banner'.$x.'.jpg';
			}
		}
		
		for($i=1;$i<=5;$i++)
			$new_ban[$i] = $ban[$i];
		
		$datos['banners'] = $new_ban;
		
		$data['banner_css'] = $this->load->view('banner/banner_css', $datos, TRUE);
		$data['contenido_principal'] = $this->load->view('home', $data, TRUE);
		$this->load->view('front/template', $data);
	}

	function wtc()
	{
		$this->load->model('noticia/noticia_model');
		$this->load->model('evento/evento_model');
		if($this->session->userdata('logged_in') == FALSE )
		{
			$this->session->set_userdata('logged_in', FALSE);
		}
		$data['breadcrumbs'] = array(
										'' => lang('breadcrumb_inicio'),
										lang('wtc_url') => lang('breadcrumb_wtc')
									);
		$data['title'] = lang('menu.wtc').' - '.lang('inicio.meta.title');
		$data['noticias_footer'] = $this->noticia_model->get_posts(4, 'desc', array('noticia.id_estado' => 1,'detalle_noticia.id_idioma'=>$this->id_idioma));
		$data['eventos_footer'] = $this->evento_model->get_page(0, 4, 'evento.id_evento', 'asc', 'front', array('evento.id_estado' => 1,'detalle_evento.id_idioma'=>$this->id_idioma));
		$data['meta_descripcion'] = lang('wtc.meta.description');
		$data['meta_keywords'] = lang('wtc.meta.keywords');
		$data['contenido_principal'] = $this->load->view('wtc', $data, TRUE);
		$this->load->view('front/template', $data);
	}

	function wtc_complejo()
	{
		$this->load->model('noticia/noticia_model');
		$this->load->model('evento/evento_model');
		if($this->session->userdata('logged_in') == FALSE )
		{
			$this->session->set_userdata('logged_in', FALSE);
		}
		$data['breadcrumbs'] = array(
										'' => lang('breadcrumb_inicio'),
										lang('complejo_wtc_url') => lang('breadcrumb_wtc_comp')
									);
		$data['title'] = lang('menu.wtc').' - '.lang('inicio.meta.title');
		$data['noticias_footer'] = $this->noticia_model->get_posts(4, 'desc', array('noticia.id_estado' => 1,'detalle_noticia.id_idioma'=>$this->id_idioma));
		$data['eventos_footer'] = $this->evento_model->get_page(0, 4, 'evento.id_evento', 'asc', 'front', array('evento.id_estado' => 1,'detalle_evento.id_idioma'=>$this->id_idioma));
		$data['meta_descripcion'] = lang('wtc.meta.description');
		$data['meta_keywords'] = lang('wtc.meta.keywords');
		$data['contenido_principal'] = $this->load->view('wtc_complejo', $data, TRUE);
		$this->load->view('front/template', $data);
	}

	function hmr(){
		$this->load->model('noticia/noticia_model');
		$this->load->model('evento/evento_model');
		if($this->session->userdata('logged_in') == FALSE )
		{
			$this->session->set_userdata('logged_in', FALSE);
		}
		$data['breadcrumbs'] = array(
										'' => lang('breadcrumb_inicio'),
										lang('hmr_url') => lang('breadcrumb_hmr')
									);
		$data['title'] = lang('menu.wtc').' - '.lang('inicio.meta.title');
		$data['noticias_footer'] = $this->noticia_model->get_posts(4, 'desc', array('noticia.id_estado' => 1,'detalle_noticia.id_idioma'=>$this->id_idioma));
		$data['eventos_footer'] = $this->evento_model->get_page(0, 4, 'evento.id_evento', 'asc', 'front', array('evento.id_estado' => 1,'detalle_evento.id_idioma'=>$this->id_idioma));
		$data['meta_descripcion'] = lang('hmr.meta.description');
		$data['meta_keywords'] = lang('hmr.meta.keywords');
		$data['contenido_principal'] = $this->load->view('hmr', $data, TRUE);
		$this->load->view('front/template', $data);
	}

}

/* End of file front.php */

