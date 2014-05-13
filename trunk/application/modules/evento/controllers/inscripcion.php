<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * Controlador para manejar inscripciones a eventos
 * desde backend
 * @author Ale
 */
class Inscripcion extends MX_Controller
{
	/**
	 * Constructor del controlador
	 * @author Ale
	 */
	public function __construct()
	{
		parent::__construct();
		
		modules::run('idioma/set_idioma', 'es');
		$this->lang->load('back');
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
		
		$this->load->helper(array('text'));
		
		//Carga de modelos
		$this->load->model('evento_model', 'eventos');
		$this->load->model('inscripcion_model', 'inscripciones');
		$this->load->model('factura_model', 'facturacion');
		$this->load->model('empresa_model', 'empresas');
		
		//Cargar modelo de usuarios
		$this->load->model('usuario_model', 'usuarios');
	}
	
	/**
	 * Lista de inscritos en un evento
	 * @author Ale
	 * @param unknown $id_evento
	 */
	public function listado($id_evento, $order_campo = 'id_inscripcion', $order_orden = 'desc', $from = 0)
	{
		if (empty($id_evento) || ! is_numeric($id_evento))
			show_404();
		
		//Obtener datos de evento
		$data['evento'] = $this->eventos->read($id_evento);
		
		//Obtener datos de inscritos
		$data['order_campo'] = $order_campo;
		$data['por_pagina'] = 10;
		$data['from'] = $from;
		$data['new_orden'] = $order_orden == 'desc' ? 'asc' : 'desc';
		$data['inscritos'] = $this->inscripciones->get_all($id_evento, $from, $data['por_pagina'], $order_campo, $order_orden,1);
		
		//$datos_reporte = $this->inscripciones->get_all($id_evento, '', '', 'u.cedula', 'ASC' , 1);
		$datos_reporte['id_evento'] = $id_evento;
		$data['reporte_inscritos'] = $this->load->view('back/inscripciones/reporte_inscritos', $datos_reporte, TRUE);
		
		$data['total_inscritos'] = $this->inscripciones->count_all($id_evento);
		$data['url_base'] = lang('backend_url').'/'.lang('eventos_url').'/'.lang('listado_inscritos_url')."/$id_evento/$order_campo/$order_orden";
		$data['uri_base'] = lang('backend_url').'/'.lang('eventos_url').'/'.lang('listado_inscritos_url')."/$id_evento";
		
		//Paginacion
		$this->load->library('pagination');
		$config['base_url'] = site_url($data['url_base']);
		$config['total_rows'] = $data['total_inscritos'];
		$config['per_page'] = $data['por_pagina'];
		$config['uri_segment'] = 7;
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
		$this->pagination->initialize($config);
		
		$data['title'] = lang('meta.titulo').' - '.lang('eventos').' - '.lang('inscripciones');
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('eventos_url'), 'listado');
		$data['usuario'] = array(
				'nombre' => $this->session->userdata('nombre'),
				'apellidos' => $this->session->userdata('apellidos')
		);
		
		$data['active'] = '';
		$data['sub'] = '';
		
		//Migajas de pan
		$data['breadcrumbs'] = $this->menus->create_breadcrumb(array(	lang('backend_url') => lang('backend'),
																		lang('backend_url').'/'.lang('eventos_url') => lang('eventos'),
																		lang('backend_url').'/'.lang('eventos_url').'/'.lang('ficha_url').'_'.lang('evento_url').'/'.$id_evento 
																			=> (isset($data['evento']->nombre) ? lang('ficha_inicio').' ' . ellipsize($data['evento']->nombre, 40, .5) : lang('eventos_sintitulo')),
																		lang('backend_url').'/'.lang('eventos_url').'/'.lang('listado_inscritos_url') => lang('listado_inscritos'),
																	)
																);
		$data['listado_inscritos'] = $this->load->view('back/inscripciones/listado_inscritos', $data, TRUE);
		$data['datos_contacto_js'] = $this->load->view('back/js/inscripciones_datos_contacto_js', $data, TRUE);
		$data['datos_contacto'] = $this->load->view('back/inscripciones/datos_contacto', $data, TRUE);
		$data['datos_asistente'] = json_encode($this->load->view('back/inscripciones/datos_asistente', $data, TRUE));
		
		$data['modo_factura_opt'] = $this->facturacion->get_modos_factura();
		$data['nombre_factura_opt'] = array();
		$data['datos_empresa'] = json_encode($this->load->view('back/inscripciones/datos_empresa', $data, TRUE));
		$data['datos_facturacion_js'] = $this->load->view('back/js/inscripciones_datos_facturacion_js', $data, TRUE);
		$data['datos_facturacion'] = $this->load->view('back/inscripciones/datos_facturacion', $data, TRUE);
		
		$data['formulario_inscribir_js'] = $this->load->view('back/js/inscripciones_formulario_inscribir_js', $data, TRUE);
		$data['formulario_inscripcion'] = $this->load->view('back/inscripciones/formulario_inscribir', $data, TRUE);
		$data['contenido_principal'] = $this->load->view('back/inscripciones/inscripciones_evento', $data, TRUE);
		$this->load->view('back/template_new', $data);
	}
	
	/**
	 * Reliza inscripción de participantes via AJAX
	 * @author Ale
	 */
	public function inscribir()
	{
		//die_pre($_POST);
		$errores = $this->validar_datos();
		
		if (count($errores))
		{
			echo json_encode($errores);
		}
		else
		{
			$this->inscripciones->agregar_inscripcion($_POST);
			echo json_encode(array('sin_errores' => 1));
		}
	}
	
	/**
	 * Verifica datos de inscripción
	 * @author Ale
	 */
	private function validar_datos()
	{
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->form_validation->set_error_delimiters('', '');
		
		$total_asistentes = $this->input->post('total_asistentes');
		$inputs_enviados = array();
	
		//Establecer reglas
		$this->form_validation->set_rules('contacto_cedula', lang('inscritos.cedula'), 'integer|callback__identificador_contacto|callback__check_inscrito_contacto_cedula');
		$this->form_validation->set_rules('contacto_rif', lang('inscritos.rif'), 'callback__check_inscrito_contacto_rif');
		$this->form_validation->set_rules('contacto_email', lang('inscritos.email'), 'valid_email|callback__check_inscrito_contacto_email');
		$this->form_validation->set_rules('contacto_nombres', lang('inscritos.nombres'), 'required');
		$this->form_validation->set_rules('contacto_apellidos', lang('inscritos.apellidos'), 'required');
		$this->form_validation->set_rules('contacto_telefono1', lang('inscritos.telefono1'), 'callback__telefono_valido');
		$this->form_validation->set_rules('contacto_telefono2', lang('inscritos.telefono2'), 'callback__telefono_valido');
		
		for ($i = 1; $i <= $total_asistentes; $i++)
		{
			$this->form_validation->set_rules('cedula_'.$i, lang('inscritos.cedula'), 'integer|callback__identificador_asistente['.$i.']|callback__check_inscrito_cedula');
			$this->form_validation->set_rules('rif_'.$i, lang('inscritos.rif'), 'callback__check_inscrito_rif');
			$this->form_validation->set_rules('email_'.$i, lang('inscritos.email'), 'valid_email|callback__check_inscrito_email');
			$this->form_validation->set_rules('nombres_'.$i, lang('inscritos.nombres'), 'required');
			$this->form_validation->set_rules('apellidos_'.$i, lang('inscritos.apellidos'), 'required');
			$this->form_validation->set_rules('telefono1_'.$i, lang('inscritos.telefono1'), 'callback__telefono_valido');
			$this->form_validation->set_rules('telefono2_'.$i, lang('inscritos.telefono2'), 'callback__telefono_valido');
			
			$inputs_enviados[] = "cedula_$i";
			$inputs_enviados[] = "rif_$i";
			$inputs_enviados[] = "email_$i";
			$inputs_enviados[] = "nombres_$i";
			$inputs_enviados[] = "apellidos_$i";
			$inputs_enviados[] = "telefono1_$i";
			$inputs_enviados[] = "telefono2_$i";
		}
		
		//Si se enviaron datos de nueva empresa
		if ($this->input->post('nombre_factura') == '1' && $this->input->post('id_empresa') == '0')
		{
			$this->form_validation->set_rules('empresa_rif', lang('empresa_evento.rif'), 'required');
			$this->form_validation->set_rules('empresa_email', lang('empresa_evento.email'), 'valid_email');
			$this->form_validation->set_rules('empresa_razon_social', lang('empresa_evento.razon_social'), 'required');
			$this->form_validation->set_rules('empresa_telefono1', lang('empresa_evento.telefono1'), 'callback__telefono_valido');
			$this->form_validation->set_rules('empresa_telefono2', lang('empresa_evento.telefono2'), 'callback__telefono_valido');
			
			$inputs_enviados[] = 'empresa_rif';
			$inputs_enviados[] = 'empresa_email';
			$inputs_enviados[] = 'empresa_razon_social';
			$inputs_enviados[] = 'empresa_telefono1';
			$inputs_enviados[] = 'empresa_telefono2';
		}
	
		//Mensajes
		$this->form_validation->set_message('required', 'Campo obligatorio');
		$this->form_validation->set_message('valid_email', 'Correo electrónico inválido');
		$this->form_validation->set_message('integer', 'Cédula inválida');
		$this->form_validation->set_message('_identificador_contacto', 'Debe introducir cédula, RIF o correo electrónico');
		$this->form_validation->set_message('_identificador_asistente', 'Debe introducir cédula, RIF o correo electrónico');
		$this->form_validation->set_message('_telefono_valido', 'Teléfono inválido');
		$this->form_validation->set_message('_check_inscrito_cedula', 'Usuario ya inscrito');
		$this->form_validation->set_message('_check_inscrito_rif', 'Usuario ya inscrito');
		$this->form_validation->set_message('_check_inscrito_email', 'Usuario ya inscrito');
		$this->form_validation->set_message('_check_inscrito_contacto_cedula', 'Usuario ya inscrito');
		$this->form_validation->set_message('_check_inscrito_contacto_rif', 'Usuario ya inscrito');
		$this->form_validation->set_message('_check_inscrito_contacto_email', 'Usuario ya inscrito');
	
		$correcto = $this->form_validation->run();
		
		$inputs_enviados = array_merge($inputs_enviados,array(	'contacto_cedula',
																'contacto_rif',
																'contacto_email',
																'contacto_nombres',
																'contacto_apellidos',
																'contacto_telefono1',
																'contacto_telefono2'));
				
		$errores = array();
		foreach ($inputs_enviados as $campo)
		{
			if (strlen(form_error($campo)))
				$errores[$campo] = form_error($campo);
		}
	
		return $errores;
	}
	
	/**
	 * Editar datos de una inscripción
	 * @author Ale
	 */
	public function editar()
	{
		
	}
	
	
	/*
	 * Reporte en excel de inscritos en un evento 
	 * 
	 * */
	public function reporte_inscripciones($id_evento)
	{
		//Datos del eventos
		$this->load->model('evento_model');
		$datos_evento = $this->evento_model->read($id_evento);
		
		//Datos de los inscritos al evento
		$datos_reporte = $this->inscripciones->get_all($id_evento, '', '', 'u.cedula', 'ASC' , 1);
		//die_pre($datos_reporte);
		
		//Libreria EXCEL
		$this->load->library("pxl");
		
		//Arrays de Estilos
		$style_bfont14		 = array( 'font' => array('bold' => true,'size' => 14, 'color' => array('rgb' => '006FB3')) );
		$style_bfont14_black = array( 'font' => array('bold' => true,'size' => 14, 'color' => array('rgb' => '000000')) );
		$style_bfont12 		 = array( 'font' => array('bold' => true,'size' => 14, 'color' => array('rgb' => 'FFFFFF')),
								 'fill' => array( 'type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'0077BF') ) );
								 
		$style_fill 	= array( 'fill' => array( 'type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'F0F0F0') ) );
			
		//Crear variable de excel, titulo y descricion del documento.
		$objPHPExcel = new PHPExcel();
			
		//Activar la hoja de excel 0
		$sheet = $objPHPExcel->setActiveSheetIndex(0);
			
		//Valores iniciales.
		$cell = 'A';
		$row = '1';
			
		//Si hay datos para el reporte.
		if(count($datos_reporte) > 0)
		{
			//Establecer titulo.
			$sheet->setCellValue(('A') 	. ($row), 	'WTC VALENCIA REPORTE DE INSCRITOS');
			$sheet->getStyle(('A') 		. ($row).	":".('J') . ($row))->applyFromArray($style_bfont14);
			$sheet->mergeCells(('A') 	. ($row).	":".('J') . ($row));
			
			$row = $row + 2;
			//Datos del evento
			$sheet->setCellValue(('A') 	. ($row), 	$datos_evento->nombre);
			$sheet->getStyle(('A') 		. ($row).	":".('J') . ($row))->applyFromArray($style_bfont14_black);
			$sheet->mergeCells(('A') 	. ($row).	":".('J') . ($row));
			
			$row++;
			//Datos del evento
			$sheet->setCellValue(('A') 	. ($row), 	'Tipo evento: '.lang('eventos_tipo_'.$datos_evento->id_tipo_evento));
			$sheet->getStyle(('A') 		. ($row).	":".('J') . ($row))->applyFromArray($style_bfont14_black);
			$sheet->mergeCells(('A') 	. ($row).	":".('J') . ($row));
			
			//Establecer columnas Excel.
			$row = '6';
			$sheet->getStyle(('A') . ($row).":".('K') . ($row))->applyFromArray($style_bfont12);
			$sheet->setCellValue(('A') . ($row), 'Nro');
			$sheet->setCellValue(('B') . ($row), 'Cédula/RIF');
			$sheet->setCellValue(('C') . ($row), 'Nombre y Apellido');
			$sheet->setCellValue(('D') . ($row), 'Correo');
		  	$sheet->setCellValue(('E') . ($row), 'Teléfono');
			$sheet->setCellValue(('F') . ($row), 'Dirección');
			$sheet->setCellValue(('G') . ($row), 'Desea Hospedaje');
			$sheet->setCellValue(('H') . ($row), 'Persona Contacto');
			$sheet->setCellValue(('I') . ($row), 'Cédula');
			$sheet->setCellValue(('J') . ($row), 'Correo');
			$sheet->setCellValue(('K') . ($row), 'Teléfono');
			
			$num_inscritos = 0;
				
			foreach($datos_reporte as $inscrito)
			{
				$num_inscritos++;
				
				//Imprimir 
				$sheet->setCellValue(('A') . (++$row), 	$num_inscritos.". ");
				$sheet->setCellValue(('B') . ($row), 	number_format($inscrito->cedula, 0, '.', '.') );
				$sheet->setCellValue(('C') . ($row), 	$inscrito->nombres.', '. $inscrito->apellidos );
				$sheet->setCellValue(('D') . ($row), 	$inscrito->email);
				$sheet->setCellValue(('E') . ($row), 	((isset($inscrito->telefono2) && !empty($inscrito->telefono2)) ? $inscrito->telefono1.' / '.$inscrito->telefono2 : $inscrito->telefono1) );
				$sheet->setCellValue(('F') . ($row), 	$inscrito->direccion);
				$sheet->setCellValue(('G') . ($row), 	( ($inscrito->desea_hospedaje = 1) ? 'SI' : 'NO' ) );
				$sheet->setCellValue(('H') . ($row), 	($inscrito->cedula != $inscrito->contacto_cedula) ? $inscrito->contacto_nombres.' '.$inscrito->contacto_apellidos : 'Auto-inscrito' );
				
				if($inscrito->cedula != $inscrito->contacto_cedula)
				{
					$sheet->setCellValue(('I') . ($row), 	number_format($inscrito->contacto_cedula, 0, '.', '.') );
					$sheet->setCellValue(('J') . ($row), 	$inscrito->contacto_email);
					$sheet->setCellValue(('K') . ($row), 	((isset($inscrito->telefono2) && !empty($inscrito->contacto_telefono2)) ? $inscrito->contacto_telefono1.' / '.$inscrito->contacto_telefono2 : $inscrito->contacto_telefono1) );
				}
				//Si la fila es impar, pintar en fondo de color.
				if($row%2==0) $sheet->getStyle(('A') . ($row).":".('K') . ($row))->applyFromArray($style_fill);
			}
				
			//Establcer tamano fijo de columna.
			for($i=0; $i<12; $i++) $sheet->getColumnDimensionByColumn($i)->setAutoSize(true);

			//Establecer nombre de la hoja de excel.
			$sheet->setTitle('Inscritos');
			
			//Establecer nombre de archivo
			$nombre_archivo = "Inscritos";
		}
		else
		{
			//Mensaje
			$sin_datos = "No hay inscritos en el evento";
			$sheet->setCellValue(('A') 	. ($row+3), 	$sin_datos);
			$sheet->getStyle(('A') 		. ($row+3).		":".('J') . ($row+3))->applyFromArray($style_bfont14);
			$sheet->mergeCells(('A') 	. ($row+3).		":".('J') . ($row+3));
			
			//Establecer nombre de la hoja de excel.
			$sheet->setTitle('sin_datos');
			
			//Establecer nombre de archivo
			$nombre_archivo = "sin_datos";
		}
			
	    header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"{$nombre_archivo}.xls\"");
		header("Cache-Control: max-age=0");
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
		$objWriter->save("php://output");
		exit;
	} 
	 
	/**
	 * Verifica si se estableció alguno de los identificadores de usuario (cedula, rif, email)
	 * @author Ale
	 */
	public function _identificador_contacto()
	{
		return 	$this->input->post('contacto_cedula') != '' || $this->input->post('contacto_rif') != '' || $this->input->post('contacto_email') != '';
	}
	
	/**
	 * Verifica si se estableció alguno de los identificadores de usuario (cedula, rif, email)
	 * @author Ale
	 */
	public function _identificador_asistente($value, $arg)
	{
		return 	$this->input->post('cedula_'.$arg) != '' || $this->input->post('rif_'.$arg) != '' || $this->input->post('email_'.$arg) != '';
	}
	
	/**
	 * Verifica si un número de teléfono es válido
	 * @param unknown $telefono
	 */
	public function _telefono_valido($telefono)
	{
		return $this->usuarios->telefono_valido($telefono);
	}
	
	/**
	 * Verifica que una cedula esté inscrita en un evento
	 * @param unknown $str
	 */
	public function _check_inscrito_cedula($str)
	{
		return ! $this->inscripciones->existe_por_datos_usuario($this->input->post('id_evento'), array('cedula' => $str));
	}
	
	/**
	 * Verifica que un rif esté inscrita en un evento
	 * @param unknown $str
	 */
	public function _check_inscrito_rif($str)
	{
		return ! $this->inscripciones->existe_por_datos_usuario($this->input->post('id_evento'), array('rif' => $str));
	}
	
	/**
	 * Verifica que un email esté inscrita en un evento
	 * @param unknown $str
	 */
	public function _check_inscrito_email($str)
	{
		return ! $this->inscripciones->existe_por_datos_usuario($this->input->post('id_evento'), array('email' => $str));
	}
	
	/**
	 * Verifica que una cedula esté inscrita en un evento
	 * @param unknown $str
	 */
	public function _check_inscrito_contacto_cedula($str)
	{
		return ($this->input->post('contacto_asiste') == 'true' && ! $this->inscripciones->existe_por_datos_usuario($this->input->post('id_evento'), array('cedula' => $str)))
				|| $this->input->post('contacto_asiste') == 'false';
	}
	
	/**
	 * Verifica que un rif esté inscrita en un evento
	 * @param unknown $str
	 */
	public function _check_inscrito_contacto_rif($str)
	{
		return ($this->input->post('contacto_asiste') == 'true' && ! $this->inscripciones->existe_por_datos_usuario($this->input->post('id_evento'), array('rif' => $str)))
				|| $this->input->post('contacto_asiste') == 'false';
	}
	
	/**
	 * Verifica que un email esté inscrita en un evento
	 * @param unknown $str
	 */
	public function _check_inscrito_contacto_email($str)
	{
		return ($this->input->post('contacto_asiste') == 'true' && ! $this->inscripciones->existe_por_datos_usuario($this->input->post('id_evento'), array('email' => $str)))
				|| $this->input->post('contacto_asiste') == 'false';
	}
}
