<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

class evento_front extends MX_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->model('evento_model');
		$this->load->model('noticia/noticia_model');
		if ($this->session->userdata('idioma') =='') $this->session->set_userdata('idioma','es');
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$this->id_idioma = modules::run('idioma/get_idioma_id_from_code',$this->session->userdata('idioma'));
		$this->lang->load('front');
	}

	function index()
	{
		$this->blog();
	}

	function blog($order_field = 'evento.id_evento', $order_dir = 'desc', $start = 0, $estado_evento = 0){		
		$this->load->library('pagination');
		$this->load->model('noticia/noticia_model');
		$num_eventos = $this->evento_model->count_all('','front');
		$config['total_rows'] = $num_eventos;
		$limit = 6;
		$data['url']	= lang('eventos_url').'_'.lang('blog_url');
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

		
		
		$lunes = date("Y-m-d",strtotime("monday"));
		$domingo = date("Y-m-d",strtotime("sunday"));
		
		$primerdia = new DateTime();
		$primerdia->modify('first day of this month');
		$primerdia = date("Y-m-d",strtotime($primerdia->format('Y-m-d')));
		
		$ultimodia = new DateTime();
		$ultimodia->modify('last day of this month');
		$ultimodia = date("Y-m-d",strtotime($ultimodia->format('Y-m-d')));
		
		//die('lunes: '.$lunes.'<br>domingo: '.$domingo.'<br>$primerdia: '.$primerdia.'<br>$ultimodia: '.$ultimodia);
		
		if($estado_evento == 0)
			$data['eventos'] = $this->evento_model->get_page($start, $limit, $order_field, 'asc', 'front', array('evento.id_estado' => 1,'detalle_evento.id_idioma'=>$this->id_idioma));
		if($estado_evento == 2)
			$data['eventos'] = $this->evento_model->get_eventos_fecha($lunes, $domingo);
		if($estado_evento == 1)
			$data['eventos'] = $this->evento_model->get_eventos_fecha($primerdia, $ultimodia);
			
		$data['num_eventos'] = count($data['eventos']);
		if ($config['total_rows'] == 0)
            redirect('evento/buscar/ningun_resultado');
		
		// die_pre($data['eventos']);
		$data['order_active'] = $estado_evento;
		
		$data['title'] = lang('eventos.meta.title').' - '.lang('inicio.meta.title');
		$cont = $limit/2;
		$data['noticias_footer'] = $this->noticia_model->get_posts(4, 'desc', array('noticia.id_estado' => 1,'detalle_noticia.id_idioma'=>$this->id_idioma));
		$data['eventos_footer'] = array_slice($data['eventos'], 0, 4);
		$data['meta_keywords'] = lang('eventos.meta.keywords').' | '.lang('inicio.meta.title');
		$data['meta_descripcion'] = lang('eventos.meta.description').' | '.' | '.lang('inicio.meta.description');
		$data['breadcrumbs'] = array(
										'' => lang('breadcrumb_inicio'),
										lang('wtc_url') => lang('breadcrumb_eventos')
									);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['offset'] = $start;
        $data['contenido_principal'] = $this->load->view('front/evento_listado', $data, true);
		$this->load->view('front/template', $data);
	}


	function detalle_eventos($evento='',$form_status='')
	{
		$this->load->model('multimedia/multimedia_model');
		$this->load->helper('evento');
		if (is_numeric($evento) || $evento=='')
		{
			$id_evento = $evento;
		}
		else
		{
			$id_evento = $this->evento_model->get_id_from_url($evento);
		}
		//echo '$form_status<pre>'.print_r($form_status,true).'</pre>';die();
		
		$data['detalle_evento'] = format_evento($this->evento_model->get($id_evento,$this->id_idioma), $this->session->userdata('idioma'));
		$data['imagenes'] = $this->evento_model->get_image($id_evento);
		$data['modos_pago'] = format_pagos($this->evento_model->get_rel_evento_pago($id_evento));
		$data['imagen_principal'] = $this->multimedia_model->get_relation($id_evento, 'evento', 1);
		$data['imagenes_secundarias'] = $this->multimedia_model->get_relation($id_evento, 'evento', 2);
		$temp = $this->multimedia_model->get_relation($id_evento, 'evento', 1, 4);
		$data['documento'] = (count($temp) > 0) ? $temp[0] : $temp ;
		$data['archivo_eventos'] = $this->evento_model->get_page(0, 6, 'evento.id_evento', 'asc', 'front', array('evento.id_estado' => 1,'detalle_evento.id_idioma'=>$this->id_idioma));
		$data['eventos_footer'] = array_slice($data['archivo_eventos'], 0, 4);
		$data['noticias_footer'] = $this->noticia_model->get_posts(4, 'desc', array('noticia.id_estado' => 1,'detalle_noticia.id_idioma'=>$this->id_idioma));
		$data['breadcrumbs'] = array(
										'' => lang('breadcrumb_inicio'),
										lang('eventos_url') => lang('breadcrumb_eventos'),
										'#' => $data['detalle_evento']->nombre
									);
		$data['form_status'] = $form_status;
		$data['main'] = lang('sala_prensa');
		$data['sub'] = lang('sala_prensa_url');
		$data['meta_descripcion'] = $data['detalle_evento']->descripcion_pagina;
		$data['meta_keywords'] = $data['detalle_evento']->keywords;
		$data['contenido_principal'] = $this->load->view('front/evento_detalle', $data, true);
		$data['title'] = $data['detalle_evento']->titulo_pagina.' - '.lang('eventos.meta.title').' - '.lang('inicio.meta.title');
		$this->load->view('front/template',$data);
	}

	function inscripcion_evento($id_evento = '')
	{
		//echo '<pre>'.print_r($id_evento,true).'</pre>';die();
		if (is_numeric($id_evento) || $id_evento=='')
			$id_evento = $id_evento;
		else
			$id_evento = $this->evento_model->get_id_from_url($id_evento);
		$this->load->model('multimedia/multimedia_model');
		$this->load->helper('evento');
		$data['noticias_footer'] = $this->noticia_model->get_posts(4, 'desc', array('noticia.id_estado' => 1,'detalle_noticia.id_idioma'=>$this->id_idioma));
		$data['eventos_footer'] = $this->evento_model->get_page(0, 4, 'evento.id_evento', 'asc', 'front', array('evento.id_estado' => 1,'detalle_evento.id_idioma'=>$this->id_idioma));
		$data['detalle_evento'] = format_evento($this->evento_model->get($id_evento,$this->id_idioma), $this->session->userdata('idioma'));
		$data['breadcrumbs'] = array(
										'' => lang('breadcrumb_inicio'),
										lang('eventos_url') => lang('breadcrumb_eventos'),
										'#' => $data['detalle_evento']->nombre
									);
		$data['meta_descripcion'] = $data['detalle_evento']->descripcion_pagina;
		$data['meta_keywords'] = $data['detalle_evento']->keywords;
		$data['contenido_principal'] = $this->load->view('front/evento_form', $data, true);
		$data['title'] = lang('eventos.meta.title').' - '.lang('inicio.meta.title');
		$this->load->view('front/template',$data);
	}
	
	function inscripcion_juridica($id_evento = '')
	{
		//echo '<pre>'.print_r($id_evento,true).'</pre>';die();
		if (is_numeric($id_evento) || $id_evento=='')
			$id_evento = $id_evento;
		else
			$id_evento = $this->evento_model->get_id_from_url($id_evento);
		$this->load->model('multimedia/multimedia_model');
		$this->load->helper('evento');
		$data['noticias_footer'] = $this->noticia_model->get_posts(4, 'desc', array('noticia.id_estado' => 1,'detalle_noticia.id_idioma'=>$this->id_idioma));
		$data['eventos_footer'] = $this->evento_model->get_page(0, 4, 'evento.id_evento', 'asc', 'front', array('evento.id_estado' => 1,'detalle_evento.id_idioma'=>$this->id_idioma));
		$data['detalle_evento'] = format_evento($this->evento_model->get($id_evento,$this->id_idioma), $this->session->userdata('idioma'));
		$data['breadcrumbs'] = array(
										'' => lang('breadcrumb_inicio'),
										lang('eventos_url') => lang('breadcrumb_eventos'),
										'#' => $data['detalle_evento']->nombre
									);
		$data['meta_descripcion'] = $data['detalle_evento']->descripcion_pagina;
		$data['meta_keywords'] = $data['detalle_evento']->keywords;
		$data['contenido_principal'] = $this->load->view('front/evento_form_juridicas', $data, true);
		$data['title'] = lang('eventos.meta.title').' - '.lang('inicio.meta.title');
		$this->load->view('front/template',$data);
	}

	function guardar_inscripcion($id_evento='')
	{
		//$this->load->model('multimedia/multimedia_model');
		$this->load->helper('evento');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$data['noticias_footer'] = $this->noticia_model->get_posts(4, 'desc', array('noticia.id_estado' => 1,'detalle_noticia.id_idioma'=>$this->id_idioma));
		$data['eventos_footer'] = $this->evento_model->get_page(0, 4, 'evento.id_evento', 'asc', 'front', array('evento.id_estado' => 1,'detalle_evento.id_idioma'=>$this->id_idioma));
		
		if (is_numeric($id_evento) || $id_evento=='')
			$id_evento = $id_evento;
		else
			$id_evento = $this->evento_model->get_id_from_url($id_evento);
		
		$data = $_POST;
		//echo '<pre>'.print_r($data,true).'</pre>';die();
		for($i=1;$i<=$data['add_invitado'];$i++)
		{
			$users[] = array
			(
				'cedula' => $data['cedula_user'.$i], 'tlfn' => $data['tlfn_user'.$i],
				'nombre1' => $data['nombre1_user'.$i], 'nombre2' => $data['nombre2_user'.$i],
				'apellido1' => $data['apellido1_user'.$i], 'apellido2' => $data['apellido2_user'.$i],
				'email'	=> $data['email_user'.$i],
				'hospedaje' => $data['radbutton_hospedaje'.$i]
			);
		}
		$data['users'] = $users;
		$data['detalle_evento'] = format_evento($this->evento_model->get($id_evento,$this->id_idioma), $this->session->userdata('idioma'));
		
		$this->form_validation->set_rules('cedula','"'.lang('evnt.insc_cedula').'"','required|numeric');
		$this->form_validation->set_rules('nombre1','"'.lang('evnt.insc_nombre').'"','required');
		$this->form_validation->set_rules('apellido1','"'.lang('evnt.insc_apellido').'"','required');
		$this->form_validation->set_rules('email','"'.lang('evnt.insc_email').'"','required|valid_email');
		$this->form_validation->set_rules('tlfn','"'.lang('evnt.insc_telefono').'"','required');
		$this->form_validation->set_rules('contacto_asiste','"'.lang('evnt.asistencia').'"','required');
		$this->form_validation->set_rules('rif','"'.lang('evnt.insc_rif').'"','required');
		$this->form_validation->set_rules('dir_fiscal','"'.lang('evnt.insc_dir_fiscal').'"','required');
		
		if(!$this->form_validation->run($this))
		{
			$data['form_status'] = 'ERROR';
			$data['breadcrumbs'] = array(
										'' => lang('breadcrumb_inicio'),
										lang('eventos_url') => lang('breadcrumb_eventos'),
										'#' => $data['detalle_evento']->nombre
									);
			$data['detalle_evento'] = format_evento($this->evento_model->get($id_evento,$this->id_idioma), $this->session->userdata('idioma'));
			$data['meta_descripcion'] = $data['detalle_evento']->descripcion_pagina;
			$data['meta_keywords'] = $data['detalle_evento']->keywords;
			$data['title'] = lang('eventos.meta.title').' - '.lang('inicio.meta.title');
			$data['contenido_principal'] = $this->load->view('front/evento_form', $data, true);
			$this->load->view('front/template',$data);
		}else
		{
			//SE GUARDA PRIMERO EL USUARIO DE CONTACTO Y SE OBTIENE SU ID RESPECTIVO
			$usuario_contacto = array
			(
				'cedula' => $data['cedula'],
				'rif' => $data['rif'],
				'nombres' => $data['nombre1'].' '.$data['nombre2'],
				'apellidos' => $data['apellido1'].' '.$data['apellido2'],
				'email' => $data['email'],
				'telefono1' => $data['tlfn'],
				'direccion' => $data['dir_fiscal']
			);
			$id_usuario_contacto = $this->evento_model->set_usuario_evento($usuario_contacto);
			
			//SE GENERA LA FACTURA
			$id_factura = $this->evento_model->set_factura(array('id_usuario' => $id_usuario_contacto));
			
			//SE GENERAN LOS DATOS CORRESPONDIENTES A LA INSCRIPCION DEL USUARIO DE CONTACTO
			$inscripcion = array
			(
				'id_evento' => $id_evento,
				'id_usuario' => $id_usuario_contacto,
				'id_usuario_contacto' => $id_usuario_contacto,
				'desea_hospedaje' => 0,
				'id_factura' => $id_factura,
			);
			if($data['contacto_asiste']=='Sí') $inscripcion['desea_hospedaje'] = 1;
			$id_inscripcion = $this->evento_model->set_evento_inscripcion($inscripcion);
			
			//SE GUARDA LA INFORMACION DE LOS USUARIOS INVITADOS O INSCRITOS POR UN CONTACTO Y SE OBTIENEN SUS IDS
			for($i=1;$i<=$data['add_invitado'];$i++)
			{
				$usuario_invitado = array
				(
					'cedula' => $data['cedula_user'.$i], 'telefono1' => $data['tlfn'],
					'nombres' => $data['nombre1_user'.$i].' '.$data['nombre2_user'.$i],
					'apellidos' => $data['apellido1_user'.$i].' '.$data['apellido2_user'.$i],
					'email' => $data['email_user'.$i]
				);
				$id_usuario_invitado = $this->evento_model->set_usuario_evento($usuario_invitado);
				
				//SE GENERAN LOS DATOS CORRESPONDIENTES A LA INSCRIPCION DE CADA USUARIO INVITADO
				$inscripcion = array
				(
					'id_evento' => $id_evento,
					'id_usuario' => $id_usuario_invitado,
					'id_usuario_contacto' => $id_usuario_contacto,
					'desea_hospedaje' => 0,
					'id_factura' => $id_factura,
				);
				if($data['radbutton_hospedaje'.$i]=='Sí') $inscripcion['desea_hospedaje'] = 1;
				$id_inscripcion = $this->evento_model->set_evento_inscripcion($inscripcion);
			}
			//$this->detalle_eventos($id_evento,'SUCCESS');
			$this->generar_planilla($data,'natural');
		}
		
	}

	function guardar_insc_juridica($id_evento='')
	{
		$this->load->helper('evento');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$data['noticias_footer'] = $this->noticia_model->get_posts(4, 'desc', array('noticia.id_estado' => 1,'detalle_noticia.id_idioma'=>$this->id_idioma));
		$data['eventos_footer'] = $this->evento_model->get_page(0, 4, 'evento.id_evento', 'asc', 'front', array('evento.id_estado' => 1,'detalle_evento.id_idioma'=>$this->id_idioma));
		
		if (is_numeric($id_evento) || $id_evento=='')
			$id_evento = $id_evento;
		else
			$id_evento = $this->evento_model->get_id_from_url($id_evento);
		
		$data = $_POST;
		//echo '<pre>'.print_r($data,true).'</pre>';die();
		for($i=1;$i<=$data['add_invitado'];$i++)
		{
			$users[] = array
			(
				'cedula' => $data['cedula_user'.$i], 'tlfn' => $data['tlfn_user'.$i],
				'nombre1' => $data['nombre1_user'.$i], 'nombre2' => $data['nombre2_user'.$i],
				'apellido1' => $data['apellido1_user'.$i], 'apellido2' => $data['apellido2_user'.$i],
				'email' => $data['email_user'.$i],
				'hospedaje' => $data['radbutton_hospedaje'.$i]
			);
		}
		$data['users'] = $users;
		$data['detalle_evento'] = format_evento($this->evento_model->get($id_evento,$this->id_idioma), $this->session->userdata('idioma'));
		
		$this->form_validation->set_rules('rzn_social','"'.lang('evnt.insc_razon_soc').'"','required');
		$this->form_validation->set_rules('rif','"'.lang('evnt.insc_rif').'"','required');
		$this->form_validation->set_rules('email_empresa','"'.lang('evnt.insc_email_empresa').'"','required|valid_email');
		$this->form_validation->set_rules('tlfn_fijo','"'.lang('evnt.insc_telefono').' '.lang('evnt.insc_fijo').'"','required');
		$this->form_validation->set_rules('tlfn_movil','"'.lang('evnt.insc_telefono').' '.lang('evnt.insc_movil').'"','required');
		$this->form_validation->set_rules('dir_fiscal','"'.lang('evnt.insc_dir_fiscal').'"','required');
		
		$this->form_validation->set_rules('cedula','"'.lang('evnt.insc_cedula').'"','required|numeric');
		$this->form_validation->set_rules('nombre1','"'.lang('evnt.insc_nombre').'"','required');
		$this->form_validation->set_rules('apellido1','"'.lang('evnt.insc_apellido').'"','required');
		$this->form_validation->set_rules('cargo','"'.lang('evnt.insc_cargo').'"','required');
		$this->form_validation->set_rules('email','"'.lang('evnt.insc_email').'"','required|valid_email');
		$this->form_validation->set_rules('tlfn','"'.lang('evnt.insc_telefono').'"','required');
		$this->form_validation->set_rules('contacto_asiste','"'.lang('evnt.asistencia').'"','required');
		
		if(!$this->form_validation->run($this))
		{
			$data['form_status'] = 'ERROR';
			$data['breadcrumbs'] = array(
										'' => lang('breadcrumb_inicio'),
										lang('eventos_url') => lang('breadcrumb_eventos'),
										'#' => $data['detalle_evento']->nombre
									);
			$data['detalle_evento'] = format_evento($this->evento_model->get($id_evento,$this->id_idioma), $this->session->userdata('idioma'));
			$data['meta_descripcion'] = $data['detalle_evento']->descripcion_pagina;
			$data['meta_keywords'] = $data['detalle_evento']->keywords;
			$data['title'] = lang('eventos.meta.title').' - '.lang('inicio.meta.title');
			$data['contenido_principal'] = $this->load->view('front/evento_form', $data, true);
			$this->load->view('front/template',$data);
		}else
		{
			//SE GUARDAN LOS DATOS DE LA EMPRESA
			$evento_empresa = array
			(
				'razon_social' => $data['rzn_social'],
				'rif' => $data['rif'],
				'email' => $data['email_empresa'],
				'telefono1' => $data['tlfn_fijo'], 'telefono2' => $data['tlfn_movil'],
				'direccion' => $data['dir_fiscal']
			);
			$id_evento_empresa = $this->evento_model->set_evento_empresa($evento_empresa);
			
			//SE GUARDAN LOS DATOS DEL USUARIO DE CONTACTO
			$usuario_contacto = array
			(
				'cedula' => $data['cedula'],
				'nombres' => $data['nombre1'].' '.$data['nombre2'],
				'apellidos' => $data['apellido1'].' '.$data['apellido2'],
				'email' => $data['email'],
				'telefono1' => $data['tlfn']
			);
			$id_usuario_contacto = $this->evento_model->set_usuario_evento($usuario_contacto);
			
			//DATOS PARA LA TABLA DE RELACION DE EVENTO_EMPRESA_USUARIO
			$evento_empresa_usuario = array('id_empresa' => $id_evento_empresa, 'id_usuario' => $id_usuario_contacto, 'cargo' => $data['cargo']);
			$this->evento_model->set_evento_empresa_usuario($evento_empresa_usuario);
			
			//SE GENERA LA FACTURA
			$id_factura = $this->evento_model->set_factura(array('id_empresa' => $id_evento_empresa));
			
			//SE GENERAN LOS DATOS CORRESPONDIENTES A LA INSCRIPCION DEL USUARIO DE CONTACTO
			$inscripcion = array
			(
				'id_evento' => $id_evento,
				'id_usuario' => $id_usuario_contacto,
				'id_usuario_contacto' => $id_usuario_contacto,
				'desea_hospedaje' => 0,
				'id_factura' => $id_factura,
			);
			if($data['contacto_asiste']=='Sí') $inscripcion['desea_hospedaje'] = 1;
			$id_inscripcion = $this->evento_model->set_evento_inscripcion($inscripcion);
			
			//SE GUARDA LA INFORMACION DE LOS USUARIOS INVITADOS O INSCRITOS POR UN CONTACTO Y SE OBTIENEN SUS IDS
			for($i=1;$i<=$data['add_invitado'];$i++)
			{
				$usuario_invitado = array
				(
					'cedula' => $data['cedula_user'.$i], 'telefono1' => $data['tlfn'],
					'nombres' => $data['nombre1_user'.$i].' '.$data['nombre2_user'.$i],
					'apellidos' => $data['apellido1_user'.$i].' '.$data['apellido2_user'.$i],
					'email' => $data['email_user'.$i]
				);
				$id_usuario_invitado = $this->evento_model->set_usuario_evento($usuario_invitado);
				
				//SE GENERAN LOS DATOS CORRESPONDIENTES A LA INSCRIPCION DE CADA USUARIO INVITADO
				$inscripcion = array
				(
					'id_evento' => $id_evento,
					'id_usuario' => $id_usuario_invitado,
					'id_usuario_contacto' => $id_usuario_contacto,
					'desea_hospedaje' => 0,
					'id_factura' => $id_factura,
				);
				if($data['radbutton_hospedaje'.$i]=='Sí') $inscripcion['desea_hospedaje'] = 1;
				$id_inscripcion = $this->evento_model->set_evento_inscripcion($inscripcion);
			}
			//$this->detalle_eventos($id_evento,'SUCCESS');
			$this->generar_planilla($data,'juridica');
		}
	}

	function generar_planilla($data='',$from='')
	{
		$nombre = $data['nombre1'].' '.$data['apellido1'];
		$correo = (isset($data['email_empresa'])) ? $data['email_empresa'] : $data['email'];
		//die_pre($correo);
		$subject = 'Inscripción del Evento: '.$data['detalle_evento']->nombre;
		
		//Proceso de ENVIO DE CORREO ELECTRONICO
		$config['protocol'] 	= "smtp";
		$config['smtp_host'] 	= "ssl://smtp.googlemail.com";
		$config['smtp_port'] 	= 465;
		// $config['smtp_user']	= "congressuscenter@gmail.com";
		// $config['smtp_pass']	= lang('email_pass');
		$config['smtp_user']	= "fp.nsce@gmail.com";
		$config['smtp_pass']	= 'fpnsce.wintech';
		$config['mailtype'] 	= "html";
		$config['charset']		='utf-8';
		$config['newline']		="\r\n";
		$this->load->library('email', $config);
		$this->email->initialize($config);
		$this->email->from($correo,$nombre);
		$this->email->to('fp.nsce@wtcvalencia.com','Congressus Center');
		$this->email->bcc('gchemello@gmail.com');
		// $this->email->cc('gchemello@gmail.com', 'Gerardo');
		$this->email->subject($subject);
		
		
		$this->load->library('mpdf');
		if($from=='natural')
			$planilla = $this->load->view('front/planilla_inscripcion', $data, TRUE);
		else
			$planilla = $this->load->view('front/planilla_juridica', $data, TRUE);
		
		$mpdf = new mPDF();
		$mpdf->WriteHTML($planilla);
		
		$content = $mpdf->Output('planilla.pdf','S');
		$this->email->attach($content);
		
		$mpdf->Output('planilla.pdf','I');
		
		$this->detalle_eventos($data['detalle_evento']->id_evento,'SUCCESS');
		//$this->detalle_eventos($data['detalle_evento']->id_evento);
	}

}
/* End of file exposicion_front.php */

