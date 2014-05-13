<?php

class Testimonio extends MX_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('testimonio_model');
		modules::run('usuarios/is_logged_in','admin',$this->uri->uri_string());
		$this->load->helper(array('form', 'url'));
		modules::run('idioma/set_idioma', 'es');
	}

	function index()
	{
		$this->listado();
	}

	function listado($order_field = 'testimonio.id_testimonio', $order_dir = 'desc', $start = 0, $ajax = false)
	{
		if ($start == 0 && empty($_POST) && $order_field == 'testimonio.id_testimonio')
		{
			 $this->session->unset_userdata('terminos_busqueda');
		}
		
		$terminos_busqueda = array();
		$terminos_busqueda = $this->session->userdata('terminos_busqueda');
		
        if (isset($_POST['texto']))
        {
            $terminos_busqueda['texto'] = $_POST['texto'];
        }
        if (isset($_POST['id_estado']))
        {
            $terminos_busqueda['testimonio.id_estado'] = $_POST['id_estado'];
        }
		if (isset($_POST['rating']))
        {
            $terminos_busqueda['testimonio.rating'] = $_POST['rating'];
        }
		
        if (isset($_POST) && !empty($_POST))
        {
            $terminos_busqueda = array_filter($terminos_busqueda);
            $this->session->set_userdata('terminos_busqueda', $terminos_busqueda);
        }
		
		$limit = 10;
		$order_string = '';
		$order_string .= ($order_field == "") ? '' : $order_field;
		$order_string .= ($order_dir == "") ? '' : ' '.$order_dir;

		$od = ($order_dir == 'asc') ? 'desc' : 'asc';
		
		$data['order_field'] 		= $order_field;
		$data['order_dir'] 			= $order_dir;
		$data['order_by_new'] 		= (($order_field == '') ? 'id_testimonio' : $order_field) . "/". $od;
		$data['url'] 				= lang('backend_url').'/'.lang('testimonios_url').'/'.lang('listado_url');
		$config['base_url'] 		= '/'.lang('backend_url').'/'.lang('testimonios_url').'/'.lang('listado_url').'/'.$order_field.'/'.$order_dir;
		$config['per_page'] 		= $limit;
		$config['uri_segment'] 		= 6;
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close'] 	= '</li>';
		$config['full_tag_open'] 	= '<ul class="pagination">';
		$config['full_tag_close'] 	= '</ul>';
		$config['next_link'] 		= "&rsaquo;";
		$config['next_tag_open'] 	= '<li class="arrow">';
		$config['next_tag_close'] 	= '</li>';
		$config['prev_link'] 		= "&lsaquo;";
		$config['prev_tag_open'] 	= '<li class="arrow">';
		$config['prev_tag_close']	= '</li>';
		$config['cur_tag_open'] 	= '<li class="current"><a href="#">';
		$config['cur_tag_close'] 	= '</a></li>';
		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '</li>';
		$config['last_link'] 		= "&raquo;";
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close']	= '</li>';
		$config['first_link'] 		= "&laquo;";
		$config['fist_tag_open'] 	= '<li>';
		$config['fist_tag_close']	= '</li>';
		$data['num_testimonios'] 	= $this->testimonio_model->count_all($terminos_busqueda);
		$config['total_rows'] 		= $data['num_testimonios'];
		
		if ($config['total_rows'] == 0)
		{
			redirect(lang('backend_url').'/'.lang('testimonios_url').'/'.lang('buscar_url').'/'.lang('ningun_resultado'));
		}
		
		$data['testimonios'] = $this->testimonio_model->get_page($start, $limit, $order_field, $order_dir, $terminos_busqueda);
		
		if ($ajax)
		{
			echo json_encode($data['testimonios']);
		}
		else
		{
			$this->load->library('pagination');
			$this->pagination->initialize($config);
			$data['pagination'] 		= $this->pagination->create_links();
			$data['offset'] 			= $start;
			$data['order_field'] 		= $order_field;
			$data['order_direction'] 	= $order_dir;
			$data['active'] 			= 'testimonios';
			
			if (!empty($terminos_busqueda))
			{
				$data['sub'] = 'buscar';
			}
			else
			{
				$data['sub'] = 'listado';
			}
			$data['title'] = lang('meta.titulo').' - '.lang('testimonios_url').' - '.lang('listado'); 
			if (!empty($terminos_busqueda))
			{
				$lbc = reset($terminos_busqueda);
				$lbt = key($terminos_busqueda);
				
				if ($lbt=='testimonio.id_testimonio')
				{
					$bcc = modules::run('services/relations/get_from_id','testimonio',$lbc);
					$lbc = $bcc->nombre;
				}
				//echo 'lbc:<pre>'.print_r($lbc,true).'</pre><br>lbt:<pre>'.print_r($lbt,true).'</pre>';die();
				$data['breadcrumbs'] = $this->menus->create_breadcrumb(
																			array(
																					lang('backend_url') => lang('backend'),
																					lang('backend_url').'/'.lang('testimonios_url') => lang('testimonios'),
																					lang('backend_url').'/'.lang('testimonios_url').'/'.lang('buscar_url') => lang('busqueda'),
																					lang('titulo') => $lbc
																		    	)
																	   );
			}
			else
			{
				$data['breadcrumbs'] = $this->menus->create_breadcrumb(
																		array(
																				lang('backend_url') => lang('backend'),
																				lang('backend_url').'/'.lang('testimonios_url') => lang('testimonios'),
																				lang('backend_url').'/'.lang('testimonios_url').'/'.lang('listado_url') => lang('listado')
																			 )
																	   );
			}
			$data['menu_principal'] = $this->menus->create_mainmenu(lang('tertimonios'), 'listado');
			$data['usuario'] = array(
										'nombre' => $this->session->userdata('nombre'),
										'apellidos' => $this->session->userdata('apellidos')
									);
			$data['contenido_principal'] = $this->load->view('back/listado_testimonio',$data,true);
			$this->load->view('back/template_new',$data);
		}
	}

	function buscar($mensaje = '')
	{
		$data['active'] 		= 'testimonios';
		$data['sub'] 			= 'buscar';
		$data['title'] 			= lang('meta.titulo').' - '.lang('testimonios').' - '.lang('buscar_tit_test');
		$data['breadcrumbs'] 	= $this->menus->create_breadcrumb(
																	array(
																			lang('backend_url') => lang('backend'),
																			lang('backend_url').'/'.lang('testimonios_url') => lang('testimonios'),
																			lang('backend_url').'/'.lang('testimonios_url').'/'.lang('buscar_url') => lang('buscar_tit_test')
								    						  			 )
															   );
		
		$data['estados'] 		= modules::run('services/relations/get_all', 'estado', 'true');
		$data['mensaje'] 		= $mensaje;
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('testimonios_url'), 'listado');
		$data['usuario'] 		= array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		$data['contenido_principal'] = $this->load->view('back/buscar_testimonio',$data, true);
		$this->load->view('back/template_new',$data);
	}

	function borrar_testimonio($id)
	{
		$this->testimonio_model->cambiar_estado_testimonio($id, 3);
		redirect(lang('backend_url').'/'.lang('testimonios_url').'/'.lang('listado_url'));
	}
	function publicar_testimonio($id)
	{
		$this->testimonio_model->cambiar_estado_testimonio($id, 1);
		redirect(lang('backend_url').'/'.lang('testimonios_url').'/'.lang('listado_url'));
	}
	function guardar_testimonio($id)
	{
		$this->testimonio_model->cambiar_estado_testimonio($id, 2);
		redirect(lang('backend_url').'/'.lang('testimonios_url').'/'.lang('listado_url'));
	}
	
	function read($id, $ajax = false, $detalle_id = '')
	{
		$ret = $this->usuario_model->read($id,$detalle_id);
		if ($ajax)
		{
			echo json_encode($ret);
		}
		else
		{
			return $ret;
		}
	}

	function detalle($id, $ajax = false)
	{
		$ret = $this->usuario_model->get('detalle_usuario',$id);
		if ($ajax)
		{
			echo json_encode($ret);
		}
		else
		{
			return $ret;
		}
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
