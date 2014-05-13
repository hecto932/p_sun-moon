<?php

class Monitor extends MX_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->model('monitor_model');
		$this->load->helper(array('form', 'url'));
		modules::run('idioma/set_idioma', 'es');
	}
	
	/* 
	 * Funcciones del admin, con control de aceso */
	function index()
	{
		$this->listado();
	}
	
	function listado($order_field = 'monitor.id_monitor', $order_dir = 'desc', $start = 0, $ajax = false)
	{
		modules::run('usuarios/is_logged_in','admin',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		if ($start==0 && empty($_POST) && $order_field=='monitor.id_monitor') $this->session->unset_userdata('terminos_busqueda');
		$terminos_busqueda=array();
		$terminos_busqueda=$this->session->userdata('terminos_busqueda');
		if (isset($_POST['tipo_contenido'])) {
			$terminos_busqueda['tipo_contenido']=$_POST['tipo_contenido'];
		}
		if (isset($_POST['id_usuario'])) {
			$terminos_busqueda['id_usuario']=$_POST['id_usuario'];
		}
		if (isset($_POST['tipo_accion'])) {
			$terminos_busqueda['tipo_accion']=$_POST['tipo_accion'];
		}

		if (isset($_POST['fecha_desde'])) {
			$terminos_busqueda['fecha_desde']=$this->input->post('fecha_desde');
		}
		if (isset($_POST['fecha_hasta'])) {
			$terminos_busqueda['fecha_hasta']=$this->input->post('fecha_hasta');
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
		$data['order_field']=$order_field;
		$data['order_dir']=$order_dir;
		$data['order_by_new'] = (($order_field=='') ? 'id_monitor' : $order_field) . "/". $od;
		$data['url'] = 'backend/monitor/listado';
		$config['base_url'] = '/backend/monitor/listado/'.$order_field.'/'.$order_dir;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 6;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['next_link'] = "&rsaquo;";
		$config['next_tag_open'] = '<li class="arrow">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = "&lsaquo;";
		$config['prev_tag_open'] = '<li class="arrow">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="current"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = "&raquo;";
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close']= '</li>';
		$config['first_link'] = "&laquo;";
		$config['fist_tag_open'] = '<li>';
		$config['fist_tag_close']= '</li>';



		$data['num_monitor']=$this->monitor_model->count_all($terminos_busqueda);
		$config['total_rows'] = $data['num_monitor'];
		if ($config['total_rows'] == 0)
		{
			redirect(lang('backend_url').'/'.lang('monitor_url').'/'.lang('buscar_url').'/'.lang('ningun_resultado'));
		}
		$data['monitor'] = $this->monitor_model->get_page($start,$limit,$order_field,$order_dir,$terminos_busqueda);
		if ($ajax){
			echo json_encode($data_content['monitor']);
		}else{
			$this->load->library('pagination');
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
			$data['offset'] = $start;
			$data['order_field'] = $order_field;
			$data['order_direction'] = $order_dir;
			$data['active'] = 'monitor';
			if (!empty($terminos_busqueda))
			{
				$data['sub']='buscar';
			}
				
			else
			{
				$data['sub'] = 'listado';
			}
			$data['title']=lang('meta.titulo').' - '.lang('monitor').' - '.lang('listado');;
			if (!empty($terminos_busqueda)) {
				$lbc = reset($terminos_busqueda);
				$lbt = key($terminos_busqueda);
				if ($lbt == 'monitor.id_categoria'){
					$bcc=modules::run('services/relations/get_from_id','categoria',$lbc);
					$lbc=$bcc->nombre;
				}
				$data['breadcrumbs'] = $this->menus->create_breadcrumb(
																			array(
																					lang('backend_url') => lang('backend'),
																					lang('backend_url').'/'.lang('monitor_url') => lang('monitor'),
																					lang('backend_url').'/'.lang('monitor_url').'/'.lang('buscar_url') => lang('busqueda'),
																		    		lang('titulo') => $lbc
																			)
																	   );
			}
			else
			{
				$data['breadcrumbs'] = $this->menus->create_breadcrumb(
																		array(
																				lang('backend_url') => lang('backend'),
																				lang('backend_url').'/'.lang('monitor_url') => lang('monitor'),
																				lang('backend_url').'/'.lang('monitor_url').'/'.lang('listado_url') => lang('listado')
																			 )
																	   );
			}
			$data['menu_principal'] = $this->menus->create_mainmenu(lang('monitor_url'), 'listado');
			$data['usuario'] = array(
										'nombre' => $this->session->userdata('nombre'),
										'apellidos' => $this->session->userdata('apellidos')
									);
			$data['contenido_principal'] = $this->load->view('listado_monitor',$data, true);
			$this->load->view('back/template_new',$data);
		}
	}
	
	function buscar($mensaje='')
	{
		modules::run('usuarios/is_logged_in','admin',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$data['active'] ='monitor';
		$data['sub'] ='buscar';
		$data['mensaje'] = $mensaje;
		$data['title'] = lang('meta.titulo').' - '.lang('monitor').' - '.lang('buscar_tit_mntr');
		/*$data['breadcrumbs'] = $this->menus->create_breadcrumb(
																array(
																		'monitor'=> lang('monitor'),
																		'buscar'=> lang('buscar_tit_mon')
																	 )
															  );*/
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(
        															array(
        																	lang('backend_url') => lang('backend'),
										    								lang('backend_url').'/'.lang('monitor_url') => lang('monitor'),
										    							 	lang('backend_url').'/'.lang('monitor_url').'/'.lang('buscar_url') => lang('buscar_tit_mntr')
																		 )
															  );
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('monitor_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		$data['contenido_principal'] = $this->load->view('buscar_monitor', $data ,true);
		$this->load->view('back/template_new',$data);
	}
	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
