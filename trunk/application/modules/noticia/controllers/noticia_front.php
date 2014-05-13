<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

class Noticia_front extends MX_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->model('noticia_model');
		$this->load->model('evento/evento_model');
		if ($this->session->userdata('idioma') =='') $this->session->set_userdata('idioma','es');
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$this->id_idioma = modules::run('idioma/get_idioma_id_from_code',$this->session->userdata('idioma'));
		$this->lang->load('front');
	}

	function index()
	{
		$this->blog();
	}


	function blog($order_field = 'noticia.id_noticia', $order_dir = 'desc', $start = 0, $estado_noticia = 0){
		$this->load->library('pagination');
		$num_noticias = $this->noticia_model->count_all('','front');
		$config['total_rows'] = $num_noticias;
		$limit = 3;
		$data['url']	= lang('noticias_url').'_'.lang('blog_url');
		$config['base_url'] = base_url().$data['url'];
		$config['per_page']	= $limit;
		$config['uri_segment'] = 2;
		$config['first_link'] = lang('primer_link');
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = lang('ultimo_link');
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['full_tag_open']  = "<ul class = 'pagination right'>";
		$config['full_tag_close'] = "</ul>";
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li class = "arrow">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li class = "arrow">';
		$config['next_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="current"><a href="">';
		$config['cur_tag_close'] = '</a></li>';

		$data['num_noticias'] = $this->noticia_model->count_all();
		if ($config['total_rows'] == 0)
            redirect('noticia/buscar/ningun_resultado');
		
		$lunes = date("Y-m-d",strtotime("monday"));
		$domingo = date("Y-m-d",strtotime("sunday"));
		
		$primerdia = new DateTime();
		$primerdia->modify('first day of this month');
		$primerdia = date("Y-m-d",strtotime($primerdia->format('Y-m-d')));
		
		$ultimodia = new DateTime();
		$ultimodia->modify('last day of this month');
		$ultimodia = date("Y-m-d",strtotime($ultimodia->format('Y-m-d')));
		
		//die('lunes: '.$lunes.'<br>domingo: '.$domingo.'<br>$primerdia: '.$primerdia.'<br>$ultimodia: '.$ultimodia);
		
		if($estado_noticia == 0)
        	$data['noticias'] = $this->noticia_model->get_page($start, $limit, $order_field, $order_dir, 'front', array('noticia.id_estado' => 1,'detalle_noticia.id_idioma' => $this->id_idioma));
		if($estado_noticia == 2)
        	$data['noticias'] = $this->noticia_model->get_noticias_fecha($lunes, $domingo);
		if($estado_noticia == 1)
        	$data['noticias'] = $this->noticia_model->get_noticias_fecha($primerdia, $ultimodia);
		
		$data['order_active'] = $estado_noticia;
		
		$data['title'] = lang('noticias.meta.title').' - '.lang('inicio.meta.title');
		$data['noticias_archivo'] = $this->noticia_model->get_posts(6, 'desc', array('noticia.id_estado' => 1,'detalle_noticia.id_idioma' => $this->id_idioma));
		$data['noticias_footer'] = array_slice($data['noticias_archivo'], 0, 4);
		$data['eventos_footer'] = $this->evento_model->get_page(0, 4, 'evento.id_evento', 'asc', 'front', array('evento.id_estado' => 1,'detalle_evento.id_idioma'=>$this->id_idioma));
		$data['meta_keywords'] = lang('noticias.meta.keywords').' - '.lang('inicio.meta.title');
		$data['meta_descripcion'] = lang('noticias.meta.description').' | '.lang('blog.meta.description').' | '.lang('inicio.meta.description');
		$data['noticia_principal'] = array_shift($data['noticias']);
		$data['noticias_secundarias'] = $data['noticias'];
		unset($data['noticias']);
		$data['breadcrumbs'] = array(
										'' => lang('breadcrumb_inicio'),
										lang('wtc_url') => lang('breadcrumb_noticias')
									);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['contenido_principal'] = $this->load->view('front/noticia_listado', $data, true);
		$this->load->view('front/template', $data);
	}


	function detalle_noticias($noticia='', $ajax=false)
	{
		$this->load->model('multimedia/multimedia_model');
		if (is_numeric($noticia) || $noticia=='')
		{
			$id_noticia = $noticia;
		}
		else
		{
			$id_noticia = $this->noticia_model->get_id_from_url($noticia);
		}
		$data['detalle_noticia'] = $this->noticia_model->read($id_noticia);
		$data['noticias_archivo'] = $this->noticia_model->get_posts(6, 'asc', array('noticia.id_estado' => 1));
		$data['imagen_principal'] = $this->multimedia_model->get_relation($id_noticia, 'noticia', 1);
		$data['imagenes_secundarias'] = $this->multimedia_model->get_relation($id_noticia, 'noticia', 2);
		$data['noticias_footer'] = $this->noticia_model->get_posts(4, 'desc', array('noticia.id_estado' => 1,'detalle_noticia.id_idioma' => $this->id_idioma));
		$data['eventos_footer'] = $this->evento_model->get_page(0, 4, 'evento.id_evento', 'asc', 'front', array('evento.id_estado' => 1,'detalle_evento.id_idioma'=>$this->id_idioma));
		$data['breadcrumbs'] = array(
										'' => lang('breadcrumb_inicio'),
										lang('noticias_url') => lang('breadcrumb_noticias'),
										'#' => $data['detalle_noticia']->nombre

									);
		$data['main'] = lang('sala_prensa');
		$data['sub'] = lang('sala_prensa_url');
		$data['meta_descripcion'] = $data['detalle_noticia']->descripcion_pagina;
		$data['meta_keywords'] = $data['detalle_noticia']->keywords;
		$data['contenido_principal'] = $this->load->view('front/noticia_detalle', $data, true);
		$data['title'] = $data['detalle_noticia']->titulo_pagina.' - '.lang('blog.meta.title').' - '.lang('inicio.meta.title');
		$this->load->view('front/template',$data);
	}

}
/* End of file exposicion_front.php */

