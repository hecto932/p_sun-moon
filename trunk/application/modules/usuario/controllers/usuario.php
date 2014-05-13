<?php

class Usuario extends MX_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('usuario_model');
		modules::run('usuarios/is_logged_in','admin',$this->uri->uri_string());
		$this->load->helper(array('form', 'url'));
		modules::run('idioma/set_idioma', 'es');
        $this->load->helper('multimedia');
	}

	function index()
	{
		$this->listado();
	}

	function listado($order_field = 'usuario.id_usuario', $order_dir = 'desc', $start = 0, $ajax = false)
	{
		if ($start == 0 && empty($_POST) && $order_field == 'usuario.id_usuario')
		{
			 $this->session->unset_userdata('terminos_busqueda');
		}
		$terminos_busqueda = array();
		$terminos_busqueda = $this->session->userdata('terminos_busqueda');
		if (isset($_POST['nombre']))
		{
			$terminos_busqueda['usuario.nombre'] = $this->input->post('nombre');
		}
		if (isset($_POST['apellidos']))
		{
			$terminos_busqueda['usuario.apellidos'] = $this->input->post('apellidos');
		}
		if (isset($_POST['email']))
		{
			$terminos_busqueda['usuario.email'] = $this->input->post('email');
		}
		if (isset($_POST) && !empty($_POST))
		{
			$terminos_busqueda = array_filter($terminos_busqueda);
			$this->session->set_userdata('terminos_busqueda',$terminos_busqueda);
		}
		$limit = 10;
		$order_string = '';
		$order_string .= ($order_field == "") ? '' : $order_field;
		$order_string .= ($order_dir == "") ? '' : ' '.$order_dir;

		$od = ($order_dir=='asc') ? 'desc' : 'asc';
		$data['order_field'] = $order_field;
		$data['order_dir'] = $order_dir;
		$data['order_by_new'] = (($order_field == '') ? 'id_usuario' : $order_field) . "/". $od;
		$data['url'] = lang('backend_url').'/'.lang('usuarios_url').'/'.lang('listado_url');
		$config['base_url'] = '/'.lang('backend_url').'/'.lang('usuarios_url').'/'.lang('listado_url').'/'.$order_field.'/'.$order_dir;
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
		$data['num_usuarios'] = $this->usuario_model->count_all($terminos_busqueda);
		$config['total_rows'] = $data['num_usuarios'];
		if ($config['total_rows'] == 0)
		{
			redirect(lang('backend_url').'/'.lang('usuarios_url').'/'.lang('buscar_url').'/'.lang('ningun_resultado'));
		}
		$data['usuarios'] = $this->usuario_model->get_page($start, $limit, $order_field, $order_dir, $terminos_busqueda);
		if ($ajax)
		{
			echo json_encode($data['usuarios']);
		}
		else
		{
			$this->load->library('pagination');
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			$data['offset'] = $start;
			$data['order_field'] = $order_field;
			$data['order_direction'] = $order_dir;
			$data['active'] = 'usuario';
			if (!empty($terminos_busqueda))
			{
				$data['sub']='buscar';
			}
			else
			{
				$data['sub']='listado';
			}
			$data['title'] = lang('meta.titulo').' - '.lang('usuarios').' - '.lang('listado'); 
			if (!empty($terminos_busqueda))
			{
				$lbc=reset($terminos_busqueda);
				$lbt=key($terminos_busqueda);
				
				if ($lbt=='usuario.id_rol')
				{
					$bcc = modules::run('services/relations/get_from_id','rol',$lbc);
					$lbc = $bcc->nombre;
				}
				if ($lbt=='usuario.id_usuario')
				{
					$bcc = modules::run('services/relations/get_from_id','usuario',$lbc);
					$lbc = $bcc->nombre;
				}
				//echo 'lbc:<pre>'.print_r($lbc,true).'</pre><br>lbt:<pre>'.print_r($lbt,true).'</pre>';die();
				$data['breadcrumbs'] = $this->menus->create_breadcrumb(
																			array(
																					lang('backend_url') => lang('backend'),
																					lang('backend_url').'/'.lang('usuarios_url') => lang('usuarios'),
																					lang('backend_url').'/'.lang('usuarios_url').'/'.lang('buscar_url') => lang('busqueda'),
																					lang('titulo') => $lbc
																		    	)
																	   );
			}
			else
			{
				$data['breadcrumbs'] = $this->menus->create_breadcrumb(
																		array(
																				lang('backend_url') => lang('backend'),
																				lang('backend_url').'/'.lang('usuarios_url') => lang('usuarios'),
																				lang('backend_url').'/'.lang('usuarios_url').'/'.lang('listado_url') => lang('listado')
																			 )
																	   );
			}
			$data['menu_principal'] = $this->menus->create_mainmenu(lang('usuarios_url'), 'listado');
			$data['usuario'] = array(
										'nombre' => $this->session->userdata('nombre'),
										'apellidos' => $this->session->userdata('apellidos')
									);
			$data['contenido_principal'] = $this->load->view('back/listado_usuario',$data,true);
			$this->load->view('back/template_new',$data);
		}
	}

	function buscar($mensaje='')
	{
		$data['active'] = 'usuario';
		$data['sub'] = 'buscar';
		$data['title'] = lang('meta.titulo').' - '.lang('usuarios').' - '.lang('buscar_tit_usrs');
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(
																	array(
																			lang('backend_url') => lang('backend'),
																			lang('backend_url').'/'.lang('usuarios_url') => lang('usuarios'),
																			lang('backend_url').'/'.lang('usuarios_url').'/'.lang('buscar_url') => lang('buscar_tit_usrs')
								    						  			 )
															   );
		
		$data['mensaje'] = $mensaje;
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('usuarios_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		$data['contenido_principal'] = $this->load->view('back/buscar_usuario',$data, true);
		$this->load->view('back/template_new',$data);
	}

	function crear()
	{
		$this->load->helper('misc');
		$data['active'] = 'usuario';
		$data['sub'] = 'crear';
		$data['title'] = lang('meta.titulo').' - '.lang('usuarios').' - '.lang('crear_tit_usrs');
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(
																	array(
																			lang('backend_url') => lang('backend'),
																			lang('backend_url').'/'.lang('usuarios_url') => lang('usuarios'),
																			lang('backend_url').'/'.lang('usuarios_url').'/'.lang('crear_url') => lang('crear_tit_usrs')
																	)
															   );
		//$data['usuarios'] = modules::run('usuario/get_all','true');
		//$data['estados'] = modules::run('services/relations/get_all','estado','true');
		$data['estados'] = modules::run('services/relations/get_all', 'estado', 'true');
		$data['estados_usuario'] = modules::run('services/relations/get_all', 'estado_usuario', 'true');
        $data['usuarios'] = modules::run('services/relations/get_all', 'usuario', 'true');
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('usuarios_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		$data['crear'] = TRUE;
		$data['contenido_principal'] = $this->load->view('back/crear_usuario', $data, true);
		$this->load->view('back/template_new',$data);
	}

	function create($id=''){
		
		if ($id!='')
		{
			//modules::run('services/monitor/add','tecnica',$id,$this->session->userdata('id_usuario'),'editar');
			modules::run('services/monitor/add','usuario',$id,$this->session->userdata('id_usuario'),'editar');
		}
		else
		{
			//modules::run('services/monitor/add','tecnica','',$this->session->userdata('id_usuario'),'crear');
			modules::run('services/monitor/add','usuario','',$this->session->userdata('id_usuario'),'crear');
		}

		$data['estados'] = modules::run('services/relations/get_all','estado','true');
		$data['estados_usuario'] = modules::run('services/relations/get_all', 'estado_usuario', 'true');
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('usuarios_url'), 'listado');
		$this->load->helper('misc');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		$this->load->helper(array('form', 'url'));

		//checkear el email
		if($id == '')
		{
			if(isset($_POST['email']))
			{
					$email = $this->input->post('email');
					if($email != '')
					{
						$email = $this->usuario_model->comprobaremail($email);
						if(isset($email->id_usuario))
						{
							if($email->id_usuario !='')
							{
								$data_content['error'] = lang('usuario_ya_existe');
								$_POST['email'] = $lang('usuario_email_existe');
							}
						}
				}
			}
		}

		$this->form_validation->set_rules('nombre', lang('usuarios_nom'), 'required|trim');
		$this->form_validation->set_rules('apellidos', lang('usuarios_ape'), 'required|trim');
		$this->form_validation->set_rules('email', lang('usuarios_ema'), 'required|valid_email|trim');
		$this->form_validation->set_rules('id_rol', lang('usuarios_rol'), 'required');


		if ($this->form_validation->run($this) == FALSE)
		{
			if ($id != '')
			{
				$data['usuarios']=$this->usuario_model->read($id);
			}/*else{
				$data=array();
				$data['nombre']='';
				$data['apellidos']='';
				$data['email']='';
				$data['password']='';
				$data['id_rol']='2';
				$data['fecha']=date('Y-m-d');
				$data['password']='';
				$id=$this->usuario_model->create($data);
				$data['id_usuario']=$id;
				$data_content['usuario']=$this->usuario_model->read($id);
				$res=modules::run('usuario/delete',$id,'');


				//ESTO HAY QUE ARREGLARLO PQ COGE EL ID DEL USUARIO Y SI SALIMOS DE ESTA PAGINA SIN GUARDAR EL ID DEL AUTOINCREMENT POCO A POCO VA A UMENTANDO
			}*/
			$data['active'] = 'usuario';
			$data['sub'] = 'crear';
			$data['title'] = lang('meta.titulo').' - '.lang('usuarios').' - '.lang('crear_tit_usrs');
			if ($id != '')
            {
            	$data['breadcrumbs'] = $this->menus->create_breadcrumb(
            															array(
            																	lang('backend_url') => lang('backend'),
            																	lang('backend_url').'/'.lang('usuarios_url') => lang('usuarios'),
            																	lang('backend_url').'/'.lang('usuarios_url').'/'.lang('editar_url')	=>	lang('editar_tit_usr'),
            																	$id	=>	$data['usuarios']->nombre
																			 )
																	  );
            }
            else
            {
                $data['breadcrumbs'] = $this->menus->create_breadcrumb(
                														array(
                																lang('backend_url') => lang('backend'),
            																	lang('backend_url').'/'.lang('usuarios_url') => lang('usuarios'),
                																lang('backend_url').'/'.lang('usuarios_url').'/'.lang('crear_url') => lang('crear_tit_usrs')
																			 )
																	  );
            }
			$data['contenido_principal'] = $this->load->view('back/crear_usuario',$data,true);
			$this->load->view('back/template_new',$data);
		}
		else
		{

			$form_data = $_POST;
			//echo '<pre>'.print_r($form_data,true).'</pre>';die();
			$form_data['password'] = sha1($this->input->post('password'));

			$fechaactual = date('Y-m-d');
			$form_data['fecha'] = $fechaactual;
			
			if ($id != '')
			{	
				$id = $this->usuario_model->update($form_data);
			}
			else
			{
				$id = $this->usuario_model->update($form_data);
			}

			//modules::run('services/relations/delete','usuario','coleccion',$id);
			//modules::run('services/relations/delete','usuario','microsite',$id);
			if($form_data['nombre'] == '')
			{
				redirect(lang('backend_url').'/'.lang('usuarios_url').'/'.lang('editar_url').'_'.lang('usuario').'/'.$id,'location');
			}
			else
			{
				redirect(lang('backend_url').'/'.lang('usuarios_url'));
			}

		}
	}

	function edit($id='',$ajax=false)
	{
		if ($id == '')
		{
			redirect(lang('backend_url').'/'.lang('usuarios_url'));
		}
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
		$this->load->helper('misc');
		$data['active'] = 'usuario';
		$data['sub'] = 'editar';
		$data['usuarios'] = $this->usuario_model->read($id);
		/*$data['breadcrumbs'] = array(
										lang('usuario') => lang('backend_url').'/'.lang('usuarios_url'),
									 	lang('backend_url').'/'.lang('usuarios_url').'/'.lang('editar_url').'_'.lang('usuario_url') => lang('usuarios_editar'),
									 																																					$id=>$data_content['usuario']->nombre.' '.$data_content['usuario']->apellidos
									 );*/

		/*$data['breadcrumbs'] = $this->menus->create_breadcrumb(
									        					   array(
									        					   			lang('backend_url') => lang('backend'),
									        								lang('backend_url').'/'.lang('usuarios_url') => lang('usuario'),
									        								lang('backend_url').'/'.lang('usuarios_url').'/'.lang('editar_url').'_'.lang('usuario_url').'/'.$id => lang('editar_tit_usr'),
									        								lang('backend_url').'/'.lang('usuarios_url').'/'.lang('editar_url').'_'.lang('usuario_url').'/'.$id => (isset($data['usuario']->nombre) && $data['usuario']->nombre != '') ? $data['usuario']->nombre : lang('usuario_no_encontrado')
																		)
															  );*/
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(
									        					   array(
									        					   			lang('backend_url') => lang('backend'),
									        								lang('backend_url').'/'.lang('usuarios_url') => lang('usuarios'),
									        								lang('backend_url').'/'.lang('usuarios_url').'/'.lang('ficha_url').'_'.lang('usuario_url').'/'.$id => lang('editar_tit_usr'),
									        								'#' => (isset($data['usuarios']->nombre) && $data['usuarios']->nombre != '') ? $data['usuarios']->nombre : lang('usuario_no_encontrado')
																		)
															  );
		$data['title'] = lang('meta.titulo').' - '.lang('usuario').' - '.lang('editar').' '.$data['usuarios']->nombre;
		$data['estados'] = modules::run('services/relations/get_all', 'estado', 'true');
		$data['estados_usuario'] = modules::run('services/relations/get_all', 'estado_usuario', 'true');
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('usuarios_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		$data['contenido_principal'] = $this->load->view('back/crear_usuario',$data,true);
		if ($ajax)
		{
			echo $data['contenido_principal'];
		}
		else
		{
			$this->load->view('back/template_new',$data);
		}
	}

	function ficha($id = '')
	{

		if ($id == '')
		{
			redirect(lang('backend_url').'/'.lang('usuarios_url'));
		}
		$data['active'] = 'usuario';
		$data['sub'] = 'editar';
		$data['usuario_info'] = $this->usuario_model->read($id);
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(
        														array(
        																lang('backend_url') => lang('backend'),
        																lang('backend_url').'/'.lang('usuarios_url') => lang('usuarios'),
        																lang('backend_url').'/'.lang('usuarios_url').'/'.lang('ficha_url').'_'.lang('noticia_url').'/'.$id => $data['usuario_info']->nombre.' '.$data['usuario_info']->apellidos
																	 )
															  );
		$data['title'] = lang('meta.titulo').' - '.lang('ficha').' de '.$data['usuario_info']->nombre.' '.$data['usuario_info']->apellidos;
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('usuarios_url'), 'listado');
		$data['usuario'] = array(
									'nombre' => $this->session->userdata('nombre'),
									'apellidos' => $this->session->userdata('apellidos')
								);
		$data['accion'] = 'normal';
		$data['sub_activo'] = 'Ficha';
		$data['contenido_principal'] = $this->load->view('back/ficha_usuario',$data,true);
		$this->load->view('back/template_new',$data);
	}

	function editar_idioma($id_usuario, $id_detalle_usuario = '')
	{
		if ($id_detalle_usuario=='')
		{
			redirect(lang('backend_url').'/'.lang('usuarios_url').'/'.lang('ficha_url').'_'.lang('usuario_url').'/'.$id_usuario);
		}
		echo modules::run('template/editar_idioma_form',$id_usuario,$id_detalle_usuario,'usuario');
	}

	function guardar_idioma()
	{
		$data = $_POST;
		if (isset($data['tagsSugerencia']))
		{
			unset($data['tagsSugerencia']);
		}
		if (isset($data['tags']))
		{
			$tags=$data['tags'];
			unset($data['tags']);
		}
		$id = $this->usuario_model->update_idioma($data);
		if (isset($tags))
		{
			$tags = array_unique($tags);
			modules::run('services/relations/delete','detalle_usuario','tag',$id);
			foreach($tags as $tag)
			{
				modules::run('services/relations/insert_tag',$tag,'detalle_usuario',$id,$data['id_idioma']);
			}
		}

		if($this->session->userdata('idioma') == 'es')
		{
			redirect(lang('backend_url').'/'.lang('usuarios_url').'/'.lang('ficha_url').'_'.lang('usuario_url').'/'.$data['id_usuario']);
		}
		else
		{
			redirect(lang('backend_url').'/'.lang('usuarios_url').'/'.lang('usuario_url').'_'.lang('ficha_url').'_'.$data['id_usuario'].'/'.$data['id_usuario']);
		}

	}

	function eliminar_idioma($id,$ajax=false)
	{
		$detalle=$this->detalle($id);
		$ret=$this->usuario_model->eliminar_idioma($id);
		$str=($ret == true) ? 'true' : 'false';
		if ($ajax)
		{
			echo '[{result:'.$str.'}]';
		}
		else
			if($this->session->userdata('idioma') == 'es')
			{
				redirect(lang('backend_url').'/'.lang('usuarios_url').'/'.lang('ficha_url').'_'.lang('usuario_url').'/'.$detalle->id_usuario);
			}
			else
			{
				redirect(lang('backend_url').'/'.lang('usuario_url').'/'.lang('usuario_url').'_'.lang('ficha_url').'/'.$detalle->id_usuario);
			}

	}
	
	//Elimina un usuario de la base de datos
	function delete($id, $ajax = false)
	{
		$ret = $this->usuario_model->delete($id);
		$str = ($ret == true) ? 'true' : 'false';
		if ($ajax)
		{
			echo '[{result:'.$str.'}]';
		}
		else
		{
			return $ret;
		}
	}
	
	//Cambia el estado de un usuario a inactivo
	function delete_user($id, $ajax = false)
	{
		$ret = $this->usuario_model->delete_user($id);
		$str = ($ret == true) ? 'true' : 'false';
		if ($ajax)
		{
			echo '[{result:'.$str.'}]';
		}
		else
		{
			return $ret;
		}
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

	function usuarios_categoria($id_categoria, $ajax = 1)
	{
		if ($ajax == 1)
		{
			echo modules::run('services/relations/get_from_categoria',$id_categoria,'usuario',$ajax);
		}
		else
		{
			return modules::run('services/relations/get_from_categoria',$id_categoria,'usuario',$ajax);
		}
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
