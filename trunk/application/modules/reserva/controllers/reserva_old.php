<?php
class Contacto_front extends MX_Controller {


	function __construct()
	{
		parent::__construct();
		echo $this->config->set_item('language','es');
		$this->load->model('contacto_model');
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$this->id_idioma = modules::run('idioma/get_idioma_id_from_code',$this->session->userdata('idioma'));
		$this->lang->load('front');
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));

	}

	function index($opcion = ''){

		$this->contacto_wtc();
	}

	function emailing_test(){
		$this->load->view('emailing_test');
	}

	function contacto_wtc(){
		$this->load->model('evento/evento_model');
		$this->load->model('noticia/noticia_model');
		$data['main'] = lang('contacto');
		$data['breadcrumbs'] = array(
										'' => lang('breadcrumb_inicio'),
										lang('wtc_url') => lang('breadcrumb_wtc')
									);
		//$data['noticias_footer'] = $this->noticia_model->get_posts(4, 'desc', 1);
		$data['title'] = lang('contacto.meta.title').' - '.lang('inicio.meta.title');
		$data['meta_keywords'] = lang('contacto.meta.keywords').' - '.lang('inicio.meta.title');
		$data['meta_descripcion'] = lang('contacto.meta.description').' | '.lang('inicio.meta.description');
		$data['noticias_footer'] = $this->noticia_model->get_posts(4, 'desc', array('noticia.id_estado' => 1,'detalle_noticia.id_idioma'=>$this->id_idioma));
		$data['eventos_footer'] = $this->evento_model->get_page(0, 4, 'evento.id_evento', 'asc', 'front', array('evento.id_estado' => 1,'detalle_evento.id_idioma'=>$this->id_idioma));
		$data['contacto_js'] = $this->load->view('contacto_js', $data, TRUE);
		$data['contacto_modal'] = $this->load->view('contacto_modal', $data, TRUE);
		$data['contenido_principal'] = $this->load->view('contacto_form', $data, TRUE);
		$this->load->view('front/template', $data);
	}

	function procesar_contacto(){
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('nombre_contacto', /*'nombre_contacto'*/'"'.lang('contacto.nomb_label').'"', 'required');
		$this->form_validation->set_rules('direccion_contacto', /*'direccion_contacto'*/'"'.lang('contacto.dir_label').'"', 'required');
		$this->form_validation->set_rules('correo_contacto', /*'estado_contacto'*/'"'.lang('contacto.corr_label').'"', 'required|valid_email');
		$this->form_validation->set_rules('ciudad_contacto', /*'ciudad_contacto'*/'"'.lang('contacto.ciu_label').'"', 'required');
		$this->form_validation->set_rules('estado_contacto', /*'estado_contacto'*/'"'.lang('contacto.est_label').'"', 'required');
		$this->form_validation->set_rules('postal_contacto', /*'postal_contacto'*/'"'.lang('contacto.cod_label').'"', 'required');
		$this->form_validation->set_rules('mensaje_contacto', /*'mensaje_contacto'*/'"'.lang('contacto.mens_label').'"', 'required');
		if ($this->form_validation->run($this) == FALSE)
		{
			echo json_encode(array(
									'titulo' => lang('contacto.diag_titF'),
									'estado' => lang('contacto.diag_fallo'),
									'mensajes' => array(
														'nombre' => form_error('nombre_contacto'),
														'direccion' => form_error('direccion_contacto'),
														'correo' => form_error('correo_contacto'),
														'ciudad' => form_error('ciudad_contacto'),
														'estado' => form_error('estado_contacto'),
														'postal' => form_error('postal_contacto'),
														'mensaje' => form_error('mensaje_contacto'),
													 )
								  )
			);


		}
		else
		{
			$form_data['correo'] = $this->input->post('correo_contacto');
			$form_data['id_idioma'] = $this->id_idioma;
			$form_data['id_estado'] = '1';
			$form_data['creacion'] = date('Y/m/d');;
			$form_data['nombre'] = $this->input->post('nombre_contacto');
			$form_data['direccion'] = $this->input->post('direccion_contacto');
			$form_data['ciudad'] = $this->input->post('ciudad_contacto');
			$form_data['estado'] = $this->input->post('estado_contacto');
			$form_data['postal'] = $this->input->post('postal_contacto');
			$form_data['mensaje'] = $this->input->post('mensaje_contacto');
			$form_data['subject'] = $this->input->post('seccion_contacto');

			//Proceso de ENVIO DE CORREO ELECTRONICO
			$config['protocol'] 	= "smtp";
			$config['smtp_host'] 	= "ssl://smtp.googlemail.com";
			$config['smtp_port'] 	= 465;
			$config['smtp_user']	= "congressuscenter@gmail.com";
			$config['smtp_pass']	= lang('email_pass');
			$config['mailtype'] 	= "html";
			$config['charset']		='utf-8';
			$config['newline']		="\r\n";
			$this->load->library('email', $config);

			$this->email->initialize($config);
			$this->email->from($form_data['correo'], $form_data['nombre']);
			$this->email->to(lang('email_cp'), lang('nombre_principal'));
			$this->email->cc('gchemello@gmail.com', 'Gerardo');
			$this->email->subject($form_data['seccion_contacto']);
			$data_usuario['url'] = lang('url_principal');
			$data_usuario['direccion'] = $form_data['direccion'];
			$data_usuario['mensaje'] = $form_data['mensaje'];
			$data_usuario['ciudad']	= $form_data['ciudad'];
			$data_usuario['estado'] = $form_data['estado'];
			$data_usuario['nombre'] = $form_data['nombre'];
			$data_usuario['correo'] = $form_data['correo'];
			$data_usuario['postal'] = $form_data['postal'];
			if(isset($form_data['telf']))
			$data_usuario['telf'] = $form_data2['telf'];

			$this->email->message($this->load->view('emailing_contacto', $data_usuario, true));


			if ( !$this->email->send())
			{
				echo json_encode(array(
									'titulo' => lang('contacto.diag_titF'),
									'estado' => lang('contacto.diag_fallo'),
									'mensajes' => array(
														'nombre' => form_error('nombre_contacto'),
														'direccion' => form_error('direccion_contacto'),
														'correo' => form_error('correo_contacto'),
														'ciudad' => form_error('ciudad_contacto'),
														'estado' => form_error('estado_contacto'),
														'postal' => form_error('postal_contacto'),
														'mensaje' => form_error('mensaje_contacto'),
													 )
								  	  )
								);
			}
			else
			{
				echo json_encode(array(
									'titulo' => lang('contacto.diag_titE'),
									'estado' => lang('contacto.diag_exito'),
									'mensajes' => array(
														'nombre' => form_error('nombre_contacto'),
														'direccion' => form_error('direccion_contacto'),
														'correo' => form_error('correo_contacto'),
														'ciudad' => form_error('ciudad_contacto'),
														'estado' => form_error('estado_contacto'),
														'postal' => form_error('postal_contacto'),
														'mensaje' => form_error('mensaje_contacto'),
													 )
								  	   )
								);
			}
		}

	}

}
?>