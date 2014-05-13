<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reserva_front extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('idioma'))
		{
			modules::run('idioma/idioma/set_idioma', $this->session->userdata('idioma'));	
		} 
		else
		{
			modules::run('idioma/idioma/set_idioma', 'es');
		}
		
		$this->lang->load('front');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->load->model('reserva_model');
		$this->load->model('usuarios/usuarios_model');
		//echo "<pre>".print_r($this->session->all_userdata(),true)."</pre>";
	}

	function index()
	{
		$data['active'] = lang('front_menu.reservar');
		$data['title'] 					= lang('front.title_reservacion');
		$data['contenido_principal'] 	= $this->load->view('reserva/front/reservar_view',$data,true);
		$this->load->view('front/template',$data);
	}
	
	/*
	 * Validacion de fecha
	 * 
	 * */
	function _verificar_fechas()
	{
		$this->form_validation->set_message('_verificar_fechas', lang('front.rango_fecha'));
		
		$llegada 	= date_format(date_create($this->input->post('fecha_llegada')), 'd-m-Y H:i:s');
		$salida 	= date_format(date_create($this->input->post('fecha_salida')), 'd-m-Y H:i:s');
		
		//Validar dia y mes
		list($d, $m, $anio) = preg_split("/(\-|\/)/", $llegada);
		$dia_valido 	= (intval($d) >= 1 && intval($d) <= 31) ? TRUE : FALSE;
		$mes_valido 	= (intval($m) >= 1 && intval($m) <= 12) ? TRUE : FALSE;
		$llegada_valida = $dia_valido && $mes_valido;
		
		list($d, $m, $anio) = preg_split("/(\-|\/)/", $salida);
		$dia_valido 	= (intval($d) >= 1 && intval($d) <= 31) ? TRUE : FALSE;
		$mes_valido 	= (intval($m) >= 1 && intval($m) <= 12) ? TRUE : FALSE;
		$salida_valida 	= $dia_valido && $mes_valido;
		
		//Verificar secuencia
		$inicio 		= date_create($llegada);
		$fin 			= date_create($salida);
		$intervalo 		= date_diff($inicio, $fin);
		$secuencia_valida = ($intervalo->invert == 0 && $intervalo->days > 0) ? TRUE : FALSE;
		//$secuencia_valida = ($intervalo->invert == 0) ? TRUE : FALSE;
		
		//"#^[0-9]{2}\-[0-9]{2}\-[0-9]{4} [0-9]{2}\:[0-9]{2}\:[0-9]{2}$#"
		return (	(preg_match("#^[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4} [0-9]{2}\:[0-9]{2}\:[0-9]{2}$#", $llegada) ||
					preg_match("#^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4} [0-9]{2}\:[0-9]{2}\:[0-9]{2}$#", $llegada)) &&
					
					(preg_match("#^[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4} [0-9]{2}\:[0-9]{2}\:[0-9]{2}$#", $salida) ||
					preg_match("#^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4} [0-9]{2}\:[0-9]{2}\:[0-9]{2}$#", $salida))
					
					&& $llegada_valida && $salida_valida && $secuencia_valida);
	}
	
	function calcular_dia_estadia()
	{
		$dateTime1 = new DateTime($this->input->post('fecha_llegada'));
		$dateTime2 = new DateTime($this->input->post('fecha_salida'));
		$dateTime1 = $dateTime1->format('Y-m-d'); 
		$dateTime2 = $dateTime2->format('Y-m-d'); 
		
		$inicio		= date_create($dateTime1);
		$fin 		= date_create($dateTime2);
		$intervalo 	= date_diff($inicio, $fin);	
			
		return $intervalo->days < 29;
	}
	
	//PASO 1
	//VERIFICA LAS HABITACIONES DISPONIBLES EN UN RANGO DE FECHAS
	function fecha_reservacion()
	{	
		//ESTABLECEMOS LAS REGLAS
		$this->form_validation->set_rules('fecha_llegada',	lang('front.inicio_label1'),	'required|trim');
		$this->form_validation->set_rules('fecha_salida',	lang('front.inicio_label2'),	'required|trim|callback__verificar_fechas|callback_calcular_dia_estadia');
		
		//ESTABLECEMOS LOS MENSAJES A LAS REGLAS
		$this->form_validation->set_message('required', lang('front.campo_vacio'));
		$this->form_validation->set_message('calcular_dia_estadia',"Los dias de estadia no pueden ser mayor a 28");
		$this->form_validation->set_error_delimiters('<small class="error">', '</small>');	
		
		//SI LOS CAMPOS PASARON LAS REGLAS
		if ($this->form_validation->run($this) == TRUE)
		{
			$dateTime1 = new DateTime($this->input->post('fecha_llegada'));
			$dateTime2 = new DateTime($this->input->post('fecha_salida'));
			$dateTime1 = $dateTime1->format('Y-m-d'); 
			$dateTime2 = $dateTime2->format('Y-m-d'); 
			
			$inicio		= date_create($dateTime1);
			$fin 		= date_create($dateTime2);
			$intervalo 	= date_diff($inicio, $fin);	
			
			$data = array(
				"fecha_llegada" => $this->input->post('fecha_llegada'),
				"fecha_salida"	=> $this->input->post('fecha_salida'),
				"noches"		=> $intervalo->days,
				"temporada"		=> $this->reserva_model->get_temporada_actual()
			);
			
			$data['hab_disponibles'] 		= $this->reserva_model->get_disponibles_tipo_habitacion($this->session->userdata('id_idioma'), $data['temporada'], $dateTime1, $dateTime2);
			$data['title'] 					= lang('front.title_reservacion');
			//die_pre($data);
			$data['contenido_principal'] 	= $this->load->view('reserva/front/reservar_view',$data,true);
			
			$this->load->view('front/template',$data);
			
		}
		else
		{
			echo modules::run('front');
		}
	}

	function ajax_disponibilidad()
	{
		//ESTABLECEMOS LAS REGLAS
		$this->form_validation->set_rules('fecha_llegada',	lang('front.inicio_label1'),	'required|trim');
		$this->form_validation->set_rules('fecha_salida',	lang('front.inicio_label2'),	'required|trim|callback__verificar_fechas|callback_calcular_dia_estadia');
		
		//ESTABLECEMOS LOS MENSAJES A LAS REGLAS
		$this->form_validation->set_message('required', lang('front.campo_vacio'));
		$this->form_validation->set_message('calcular_dia_estadia',"Los dias de estadia no pueden ser mayor a 28");
		
		//SI LOS CAMPOS PASARON LAS REGLAS
		if ($this->form_validation->run($this) == TRUE)
		{
			$dateTime1 = new DateTime($this->input->post('fecha_llegada'));
			$dateTime2 = new DateTime($this->input->post('fecha_salida'));
			$dateTime1 = $dateTime1->format('Y-m-d'); 
			$dateTime2 = $dateTime2->format('Y-m-d'); 
			
			$inicio		= date_create($dateTime1);
			$fin 		= date_create($dateTime2);
			$intervalo 	= date_diff($inicio, $fin);	
			
			$data = array(
				"mensaje"		=> "bien",
				"fecha_llegada" => $this->input->post('fecha_llegada'),
				"fecha_salida"	=> $this->input->post('fecha_salida'),
				"noches"		=> $intervalo->days,
				"temporada"		=> $this->reserva_model->get_temporada_actual()
			);
			
			$data['hab_disponibles'] = $this->reserva_model->get_disponibles_tipo_habitacion($this->session->userdata('id_idioma'), $data['temporada'], $dateTime1, $dateTime2);
			
			$data['vacio'] = true;
			$data['error'] = "Disculpe, no hay habitaciones disponibles en la fechas indicadas.";
			
			foreach($data['hab_disponibles'] as $hd => $value)
			{
				if($value->habitaciones>0)
				{
					$data['vacio'] = FALSE;
					$data['error'] = '';
				}
			}
			
			echo json_encode($data);
		}
		else
		{
			$data = array(
				"mensaje"		=> "mal",
				"error"			=> form_error('fecha_salida')
			);
			echo json_encode($data);
		}
			
	}
	
	//OBTENGO LOS DATOS DE LA HABITACION POR MEDIO DEL ID A TRAVES DE UN VECTOR DE HABITACIONES
	function get_habitacion_id($id_habitacion,$habitaciones)
	{
		$encontrado = FALSE;
		$i = 0;
		while(!$encontrado && $i<count($habitaciones))
		{
			if($habitaciones[$i]['id_tipo_habitacion'] == $id_habitacion )
				$encontrado=true;
			else
				++$i;
		}
		
		return $habitaciones[$i];
	}
	
	//VERIFICO SI AL MENOS SE ESCOGIO UNA HABITACION CALLBACK
	function verificar_habitaciones($habitaciones)
	{
		$encontrado = FALSE;
		
		foreach ($habitaciones as $key => $value) 
			if(!$encontrado && $value!=0)
				$encontrado=TRUE;
		
		return $encontrado;
	}
	
	//PASO2
	//ORGANIZA LOS DATOS DE LA RESERVA 
	function datos_reserva()
	{
		
		if($_POST)
		{
			$this->form_validation->set_rules('tip_hab',		"Habitaciones",'required|callback_verificar_habitaciones');
		
			//ESTABLECEMOS LOS MENSAJES A LAS REGLAS
			$this->form_validation->set_message('required', lang('front.campo_vacio'));
			$this->form_validation->set_message('verificar_habitaciones', lang('front.reserva.habitaciones.habitaciones_required'));
			$this->form_validation->set_error_delimiters('<small class="error" style="font-size:12px;">', '</small>');	
			
			if ($this->form_validation->run($this) == TRUE)
			{
				
				
				
				$data = array(
					"fecha_llegada"		=> $this->input->post('fecha_llegada'),
					"fecha_salida"		=> $this->input->post('fecha_salida'),
					"noches"			=> $this->input->post('noches'),
					"temporada"			=> $this->input->post('temporada'),
					"hab_disponibles" 	=> $this->reserva_model->get_disponibles_tipo_habitacion($this->session->userdata("id_idioma"), $_POST['temporada'], $_POST['fecha_llegada'], $_POST['fecha_salida']),				
					"tip_habs" 			=> $_POST['tip_hab']
				);
			  	
				
				
				$i=0;
				foreach($data['hab_disponibles'] as $hd => $value)
				{
					foreach($value as $h => $value2)
					{
						$hab_disponibles[$i][$h] = $value2;
					}
					++$i;
				}
				
				$data['hab_disponibles'] = $hab_disponibles;
				
				//CANTIDAS DE HABITACIONES RESERVADAS
				$cant_habitaciones = 0;
				
				//ACUMULADOR PARA EL PRECIO TOTAL DE LAS HABITACIONES SELECCIONADAS
				$precio = 0;
				
				//POR CADA TIPO DE HABITACION SELECCIONADA OBTENGO SU INFORMACION Y CALCULO PRECIO TOTAL Y CANTIDAD DE HABITACIONES ESCOGIDAS
				foreach($_POST['tip_hab'] as $h => $value)
				{
					if($value > 0)
					{
						for($i=0;$i<$value;++$i)
						{
							$r = $this->get_habitacion_id($h, $data['hab_disponibles']);
							$resultado[$cant_habitaciones] = array(
								"id_tipo_habitacion"	=> $r['id_tipo_habitacion'],
								"tipo_descrip"			=> $r['tipo_descrip'],
								"tipo"					=> $r['tipo'],
								"personas"				=> $r['personas'],
								"valor"					=> $r['valor'],
								"moneda_abreviado"		=> $r['moneda_abreviado'],
								"habitaciones"			=> $r['habitaciones'],
								"seleccionadas"			=> $value
							);
							$cant_habitaciones+=1;
						}					
						$precio+=$r['valor']*$value;
						$denominacion = $r['moneda_abreviado'];
					}
				}
				
				//GUARDO LA CANTIDAD DE HABITACIONES TOTAL
				$data['cant_habitaciones'] = $cant_habitaciones;
				
				//GUARDO EL PRECIO TOTAL DE LA RESERVA
				$data['precio']	= $precio * $_POST['noches'];
				
				//GUARDO LA DENOMINACION DE LA MONEDA
				$data['denominacion']	= $denominacion;
				
				$data['habs'] = $resultado;
				
				$data['title'] 					= lang('front.title_reservacion');
				$data['contenido_principal'] 	= $this->load->view('reserva/front/datos-reserva',$data,true);
				$this->load->view('front/template',$data);
			}
			else
			{
					
				
				
				$dateTime1 = new DateTime($this->input->post('fecha_llegada'));
				$dateTime2 = new DateTime($this->input->post('fecha_salida'));
				$dateTime1 = $dateTime1->format('Y-m-d'); 
				$dateTime2 = $dateTime2->format('Y-m-d'); 
				
				$inicio		= date_create($dateTime1);
				$fin 		= date_create($dateTime2);
				$intervalo 	= date_diff($inicio, $fin);	
				
				$data = array(
					"fecha_llegada"		=> $this->input->post('fecha_llegada'),
					"fecha_salida"		=> $this->input->post('fecha_salida'),
					"noches"			=> $this->input->post('noches'),
					"temporada"			=> $this->input->post('temporada'),
					"hab_disponibles" 	=> $this->reserva_model->get_disponibles_tipo_habitacion($this->session->userdata("id_idioma"), $_POST['temporada'],$dateTime1, $dateTime2)				
				);
				
				$data['title'] 					= lang('front.title_reservacion');
				$data['contenido_principal'] 	= $this->load->view('reserva/front/reservar_view',$data,true);
				$this->load->view('front/template',$data);
			}
		}
		else
		{
			redirect("/");
		}
	}
	

	function _validad_hora($hora)
	{
		$this->form_validation->set_message('_validad_hora', lang('front.hora_invalida'));
		if(preg_match("/(2[0-3]|[01][0-9]):[0-5][0-9]/", $hora))
			return TRUE;
		else return FALSE;
	}
	
	//VERIFICA SI EL CORREO EXISTE
	function verificar_email($email)
	{
		return !$this->usuarios_model->verificar_email($email);
	}
	
	//VERIFICA SI EL CORREO ESTA USADO
	function existe_email($email)
	{
		return $this->usuarios_model->verificar_email($email);
	}	
	
	//VERIFICA LA SESSION
	function verificar_sesion()
	{
		return $this->usuarios_model->verificar_sesion();
	}
	
	//INICIA SESION
	function iniciar_sesion()
	{
		
		if($_POST)
		{
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
	
			$this->form_validation->set_rules("email","Email","required|trim|valid_email");
			$this->form_validation->set_rules("password","Password","required|trim|min_length[8]|callback_verificar_sesion");
			
			$this->form_validation->set_message("existe_email",		lang('front.registro.existe_email'));
			$this->form_validation->set_message("required",			lang('front.registro.required'));
			$this->form_validation->set_message("valid_email",		lang('front.registro.valid_email'));
			$this->form_validation->set_message("verificar_email",	lang('front.registro.verificar_email'));
			$this->form_validation->set_message("min_length",		lang('front.registro.min_length'));
			$this->form_validation->set_message("verificar_sesion",	lang('front.registro.verificar_sesion'));
			$this->form_validation->set_error_delimiters('<small class="error">', '</small>');
			
			if($this->form_validation->run($this) == TRUE)
			{
				
				$datos_usuario = $this->usuarios_model->getData($this->input->post("email"));
				$this->session->set_userdata($datos_usuario[0]);
				
				$data = array(
					"id_usuario"		=>	$this->session->userdata('id_usuario'),
					"titular_reserva"	=> 	$this->session->userdata('nombre'),
					"email"				=>	$this->session->userdata('email'),
					"mensaje"			=>	"Iniciado"
				);
				echo json_encode($data);
			}
			else
			{
				$data = array(
					"mensaje"	=>	"error"
				);
				
				echo json_encode($data);
			}
		}
		else
		{
			redirect("/");
		}
	}

	//VERIFICA SI SE HA INICIADO SESION
	function verificar_sesion_iniciada($id_usuario)
	{
		return $id_usuario!="";
	}
	
	//VERIFICA QUE CADA HABITACION TENGA UN TITULAR
	function verificar_clientes($clientes)
	{
		$band = true;
		for($i=0;$i<count($clientes) && $band;++$i)
			if($clientes[$i]=="")
				$band=FALSE;
			
		return $band;
	}

	function direccion_reservacion()
	{

		//die_pre($_POST);
		if($_POST)
		{
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
			
			$this->form_validation->set_rules("tratamiento","Tratamiento","required");
			$this->form_validation->set_rules("nombre_cliente","Cliente","required|callback_verificar_clientes");
			$this->form_validation->set_rules("sesion","Iniciado sesion","required");
			
			$this->form_validation->set_message("verificar_sesion_iniciada","Para continuar con la reserva debe iniciar sesion.");
			$this->form_validation->set_message("required",			lang('front.registro.required'));
			$this->form_validation->set_message("valid_email",		lang('front.registro.valid_email'));
			$this->form_validation->set_message("verificar_clientes","Una o mas habitaciones necesitan un titular");
			
			
			$this->form_validation->set_error_delimiters('<div class="alert-box alert round" style="font-size:12px;">', '</div>');
			
			if($this->form_validation->run($this) == TRUE)
			{
				//OBTENGO TODOS LOS TIPOS DE HABITACIONES DISPONIBLES
				//$data['hab_disponibles'] = $this->reserva_model->get_disponibles_tipo_habitacion($this->session->userdata("id_idioma"), $_POST['temporada'], $_POST['fecha_llegada'], $_POST['fecha_salida']);
				
				//OBTENGO LAS PETICIONES Y LOS NOMBRES DE CLIENTES 
				$peticiones = $_POST['peticiones'];
				$titulares = $_POST['nombre_cliente'];
				
				//OBTENGO LA VARIABLE DE RESERVACION PARA MODIFICARLA
				$data['titular_reserva']		= $this->session->userdata("nombre");
				$data['personas'] 				= count($_POST['habs']);
				$data['tratamiento'] 			= $this->input->post("tratamiento");
				$data['habs'] 					= $_POST['habs'];
				
				for($i=0;$i<count($data['habs']);++$i)
				{
					$data['habs'][$i]['peticion']			= $peticiones[$i];
					$data['habs'][$i]['nombre_titular'] 	= $titulares[$i];
				}
				
				$data['fecha_llegada'] 	= $this->input->post('fecha_llegada');
				$data['fecha_salida'] 	= $this->input->post('fecha_salida');
				
			  	
				//NUMERO DE PERSONAS
				$data['personas'] = count($_POST['nombre_cliente']);
				
				//NUMERO DE NOCHES 
				$data['noches'] = $this->input->post('noches');
				
				//OBTENGO LA TEMPORADA ACTUAL
				$data['temporada'] = $this->reserva_model->get_temporada_actual();
				
				//GUARDO LA CANTIDAD DE HABITACIONES TOTAL
				$data['cant_habitaciones'] = $this->input->post('cant_habitaciones');
				
				//GUARDO EL PRECIO TOTAL DE LA RESERVA
				$data['precio']	= $this->input->post('precio');
				
				//GUARDO LA DENOMINACION DE LA MONEDA
				$data['denominacion']	= $this->input->post('denominacion');
				
				//ACTUALIZO LA COOKIE
				$data['tip_habs'] = $_POST['tip_habs'];
				
				$data['hab_disponibles'] = $_POST['hab_disponibles'];
				
				//OBTENGO EL VECTOR DE TODOS LOS PAISES
				$query_paises 					=	$this->usuarios_model->obtener_paises();
				
				//OBTENGO EL VECTOR DE STRINGS DE LOS PAISES
				$data['opt_paises'] 			= 	dropdown($query_paises, 'id_pais', 'descripcion');
				
				$query_forma_pago = $this->reserva_model->get_formas_pago();
				$data['formas_pago']= dropdown($query_forma_pago, 'id_tipo_forma_pago', 'descripcion');

				$data['title'] 					= lang('front.title_reservacion');
				$data['contenido_principal'] 	= $this->load->view('reserva/front/direccion-reserva',$data,true);
				//echo "<pre>".print_r($data,TRUE)."</pre>";
				$this->load->view('front/template',$data);
				
			}
			else
			{
				//die_pre($_POST);
				$peticiones = $_POST['peticiones'];
				$titulares = $_POST['nombre_cliente'];
				
				//OBTENGO LA VARIABLE DE RESERVACION PARA MODIFICARLA
				
				$data['personas'] 				= count($_POST['habs']);
				$data['tratamiento'] 			= $this->input->post("tratamiento");
				$data['titular_reservacion']	= $this->session->userdata("nombre");
				$data['habs'] 					= $_POST['habs'];
				
				for($i=0;$i<count($data['habs']);++$i)
				{
					$data['habs'][$i]['peticion']			= $peticiones[$i];
					$data['habs'][$i]['nombre_titular'] 	= $titulares[$i];
				}
				
				$data['fecha_llegada'] 	= $this->input->post('fecha_llegada');
				$data['fecha_salida'] 	= $this->input->post('fecha_salida');
				
				//CONFIGURANDO FECHAS PARA LA BUSQUEDA DE HABITACIONES
			    $dateTime1 = new DateTime($data['fecha_llegada']);
				$dateTime2 = new DateTime($data['fecha_salida']);			
				$dateTime1 = $dateTime1->format('d-m-Y'); 
				$dateTime2 = $dateTime2->format('d-m-Y'); 
			  	
				//NUMERO DE NOCHES 
				$data['noches'] = $dateTime2 - $dateTime1;
				
				//OBTENGO LA TEMPORADA ACTUAL
				$data['temporada'] = $this->reserva_model->get_temporada_actual();
				
				//GUARDO LA CANTIDAD DE HABITACIONES TOTAL
				$data['cant_habitaciones'] = $this->input->post('cant_habitaciones');
				
				//GUARDO EL PRECIO TOTAL DE LA RESERVA
				$data['precio']	= $this->input->post('precio');
				
				//GUARDO LA DENOMINACION DE LA MONEDA
				$data['denominacion']	= $this->input->post('denominacion');
				
				//ACTUALIZO LA COOKIE
				$data['tip_habs'] = $_POST['tip_habs'];
				
				$data['hab_disponibles'] = $_POST['hab_disponibles'];
				
				//OBTENGO EL VECTOR DE TODOS LOS PAISES
				$query_paises 					=	$this->usuarios_model->obtener_paises();
				
				//OBTENGO EL VECTOR DE STRINGS DE LOS PAISES
				$data['opt_paises'] 			= 	dropdown($query_paises, 'id_pais', 'descripcion');
				
				$query_forma_pago = $this->reserva_model->get_formas_pago();
				$data['formas_pago']= dropdown($query_forma_pago, 'id_tipo_forma_pago', 'descripcion');
				
				
				
				//echo "<pre>".print_r(validation_errors(),TRUE)."</pre>";
				$data['title'] 					= lang('front.title_reservacion');
				$data['contenido_principal'] 	= $this->load->view('reserva/front/datos-reserva',$data,true);
				$this->load->view('front/template',$data);
			}
			
		}	
		else
		{
			redirect("/");
		}
		
		
	}

	function ajax_direccion_reserva()
	{
		if($_POST)
		{
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
			
			$this->form_validation->set_rules("tratamiento","Tratamiento","required");
			$this->form_validation->set_rules("nombre_cliente","Cliente","required|callback_verificar_clientes");
			$this->form_validation->set_rules("sesion","Iniciado sesion","required");
			
			$this->form_validation->set_message("verificar_sesion_iniciada","Para continuar con la reserva debe iniciar sesion.");
			$this->form_validation->set_message("required",			lang('front.registro.required'));
			$this->form_validation->set_message("valid_email",		lang('front.registro.valid_email'));
			$this->form_validation->set_message("verificar_clientes","Una o mas habitaciones necesitan un titular");
			
			if($this->form_validation->run($this) == TRUE)
			{
				$data = array(
					"mensaje"	=>	"correcto"
				);
				
				echo json_encode($data);
			}
			else
			{
				$data = array(
					"mensaje"				=>	"nocorrecto",
					"error_tratamiento"		=>	form_error("tratamiento"),
					"error_nombre_cliente"	=>	form_error("nombre_cliente"),
					"error_sesion"			=>	form_error('sesion')
				);
				
				echo json_encode($data);
			}
			
		}
	}

	function get_code_reserva()
	{
		$characters = array(
			"A","B","C","D","E","F","G","H","J","K","L","M",
			"N","P","Q","R","S","T","U","V","W","X","Y","Z",
			"1","2","3","4","5","6","7","8","9"
		);
				
		//CREAMOS UN VECTOR VACIO QUE LLEVARA LA CLAVE
		$keys = array();

		//CONTADOR EN 0 HASTA 6, ES DECIR, CALCULARA UNA CLAVE DE 7 CARACTERES
		while(count($keys) < 7) {
		    $x = mt_rand(0, count($characters)-1);
		    if(!in_array($x, $keys)) {
		       $keys[] = $x;
		    }
		}
		
		foreach($keys as $key){
		   $random_chars .= $characters[$key];
		}
		
		return $random_chars;
	}
	
	function generar_codigo_reserva()
	{
		$codigo_reserva = $this->get_code_reserva();
		while($this->reserva_model->existe_codigo_reservacion($codigo_reserva))
			$codigo_reserva = $this->get_code_reserva();
		
		return $codigo_reserva;
			
	}

	function guardar_reserva()
	{
		$this->load->library('mpdf');
		if($_POST)
		{
			$this->form_validation->set_rules("telefono","Telefono","required|trim");
			$this->form_validation->set_rules("aerolinea","Aerolinea","required|trim");
			
			$this->form_validation->set_message("required","El campo %s es obligatorio");
			
			$this->form_validation->set_error_delimiters('<small class="error" style="font-size: 12px;">', '</small>');
			
			if($this->form_validation->run($this) == TRUE)
			{
		
				//CONFIGURANDO FECHAS PARA LA BUSQUEDA DE HABITACIONES
			    $dateTime1 = new DateTime($this->input->post('fecha_llegada'));
				$dateTime2 = new DateTime($this->input->post('fecha_salida'));			
				$dateTime1 = $dateTime1->format('Y-m-d'); 
				$dateTime2 = $dateTime2->format('Y-m-d'); 
				
				$data_reservacion = array(
					"codigo_reserva"		=>	$this->generar_codigo_reserva(),
					"personas"				=> 	$this->input->post('personas'),
					"aerolinea"				=> 	$this->input->post("aerolinea"),
					"checkin"				=>	$dateTime1,
					"checkout"				=>	$dateTime2,
					"id_estado_reservacion"	=> 	2,
					"id_estado_activo"		=> 	1,
					"id_tipo_forma_pago"	=> 	$this->input->post("id_tipo_forma_pago"),
					"precio"				=>  $this->input->post('precio'),
					"id_usuario_front"		=> 	$this->session->userdata("id_usuario"),
					"observaciones"			=>	$this->input->post("observaciones")
								
				);
				
				$data_update = array(
					"telefono"	=> $this->input->post("telefono"),
					"id_pais"	=> $this->input->post("id_pais")
				);
				
				
				$this->usuarios_model->update_informacion_usuario($this->session->userdata("id_usuario"),$data_update);
				$datos_usuario = $this->usuarios_model->getData($this->session->userdata("email"));
				$this->session->set_userdata($datos_usuario[0]);
			
				//GUARDAMOS LA RESERVACION
				$this->reserva_model->reservar_habitacion($data_reservacion);
				
				$id_reservacion = $this->reserva_model->get_id_reservacion($data_reservacion['codigo_reserva']);
				
				$reservacion = $_POST['habs'];
				
				for($i=0;$i<count($reservacion);++$i)
				{
					$reserva_tipo_habitacion['id_reservacion'] 			= $id_reservacion;
					$reserva_tipo_habitacion['peticion'] 				= $reservacion[$i]['peticion'];
					$reserva_tipo_habitacion['id_tipo_habitacion'] 		= $reservacion[$i]['id_tipo_habitacion'];
					
					$this->reserva_model->insertar_reservacion_tipo_habitacion($reserva_tipo_habitacion);

					$id_reservacion_tipo_habitacion 					=  $this->db->insert_id();
					$huesped['tratamiento']								= "Sr(a)";
					$huesped['nombre'] 									= $reservacion[$i]['nombre_titular'];
					$huesped['id_reservacion_tipo_habitacion'] 			= $id_reservacion_tipo_habitacion;

					$this->reserva_model->insertar_huesped($huesped); 
				}
							
				//CONFIGURACION PARA EL ENVIO DEL CORREO ELECTRONICO
				$config['protocol']		= "smtp";
                $config['smtp_host']   	= "ssl://smtp.googlemail.com";
                $config['smtp_port']   	= 465;
                $config['smtp_user'] 	= lang('front.smtp_user');
                $config['smtp_pass']    = lang('front.smtp_pass');
                $config['mailtype']    	= "html";
                $config['charset']    	= 'utf-8';
                $config['newline']     	= "\r\n";
				$this->load->library('email', $config);
				
				
				
				//CONFIGURANDO LA DATA
				$form_data['pais']				= $this->usuarios_model->get_pais($this->session->userdata("id_pais"));
				$form_data['direccion']			= $this->session->userdata("direccion");
				$form_data['checkin']			= $this->input->post('fecha_llegada').' '.$this->input->post('hora_llegada');
				$form_data['checkout']			= $this->input->post('fecha_salida').' '.$this->input->post('hora_salida');
				$form_data['codigo_reserva']	= $data_reservacion['codigo_reserva'];
				$form_data['tipo_forma_pago']	= $this->reserva_model->get_forma_pago($this->input->post("id_tipo_forma_pago"));
				$form_data['denominacion']		= $this->input->post('denominacion');
				$form_data['noches']			= $this->input->post('noches');
				$form_data['personas']			= $this->input->post('personas');
				$form_data['titular_reserva']	= $this->input->post('titular_reserva');
				$form_data['tratamiento']		= $this->input->post('tratamiento');
				$form_data['nombre_completo']	= $this->input->post('titular_reservacion');
				$form_data['email']	 			= $this->session->userdata("email");
				$form_data['telefono']	 		= $this->session->userdata('telefono');
				$form_data['nacionalidad']		= $this->session->userdata('nacionalidad');
				$form_data['aerolinea']			= $this->input->post('aerolinea');
				$form_data['fecha_llegada']		= $this->input->post('fecha_llegada');
				$form_data['hora_llegada']		= $this->input->post('hora_llegada');
				$form_data['fecha_salida']		= $this->input->post('fecha_salida');
				$form_data['hora_salida']		= $this->input->post('hora_salida');
				$form_data['observaciones']		= $this->input->post('observaciones');
				$form_data['numero_habitaciones'] = $this->input->post('cant_habitaciones');
				$form_data['habitaciones']		= $this->input->post('habs');
				$form_data['precio_total']		= $this->input->post('precio');
				
				$reserva_pdf = $this->load->view('reserva/front/datos_reservacion_pdf',$form_data,true);
				$reserva_pdf_name = 'assets/front/pdf/reserva'.'_'.$this->session->userdata('nombre').'.pdf';
				$stylesheet = "assets/front/css/factura.css";
				$mpdf = new mPDF();
				$mpdf->WriteHTML($stylesheet,1);
				$mpdf->WriteHTML($reserva_pdf,2);
				$footer = 
				"
				<div>
					<span>
						<b>Fecha de creacion: </b>".date("Y-m-d H:i:s")."
					</span>
				</div>
				";
				$mpdf->setHTMLFooter($footer);
				$mpdf->Output($reserva_pdf_name,'F');
				
				
				$this->email->initialize($config);
				
				$this->email->from(lang('front.smtp_email1'),"Sol y Luna");
				$this->email->to($form_data['email']);
				$this->email->bcc('gchemello@gmail.com');
				//$this->email->bcc("");
				$this->email->subject("Tu reserva en Sol y Luna");
				$this->email->attach($reserva_pdf_name);
				
				$data_usuario['codigo_reserva']			= $form_data['codigo_reserva'];
				$data_usuario['forma_pago']				= $form_data['tipo_forma_pago'];
				$data_usuario['denominacion']			= $form_data['denominacion'];
				$data_usuario['noches']					= $form_data['noches'];
				$data_usuario['precio_total']			= $form_data['precio_total'];
				$data_usuario['personas']				= $form_data['personas'];
				$data_usuario['habitaciones']			= $form_data['habitaciones'];
				$data_usuario['numero_habitaciones']	= $form_data['numero_habitaciones'];
				$data_usuario['nombre_completo'] 		= $form_data['nombre_completo'];
				$data_usuario['email'] 					= $form_data['email'];
				$data_usuario['telefono'] 				= $form_data['telefono'];
				$data_usuario['nacionalidad'] 			= $form_data['nacionalidad'];
				$data_usuario['personas'] 				= $form_data['personas'];
				$data_usuario['aerolinea'] 				= $form_data['aerolinea'];
				$data_usuario['fecha_llegada'] 			= $form_data['fecha_llegada'];
				$data_usuario['hora_llegada'] 			= $form_data['hora_llegada'];
				$data_usuario['fecha_salida'] 			= $form_data['fecha_salida'];
				$data_usuario['hora_salida'] 			= $form_data['hora_salida'];
				$data_usuario['observaciones'] 			= $form_data['observaciones'];
				$data_usuario['titular_reserva']		= $form_data['titular_reserva'];
				$data_usuario['tratamiento']			= $form_data['tratamiento'];
								
				$this->email->message($this->load->view('front/correo_usuario', $data_usuario, true));
				
				//SI EL EMAIL SE ENVIA CORRECTAMENTE
				if ($this->email->send())
				{				
					$this->email->from(lang('front.smtp_email1'),"Sol y Luna");
					$this->email->to(lang('front.smtp_email1'));
					$this->email->bcc('gchemello@gmail.com');
					$this->email->subject($this->session->userdata("nombre")." ha realizado una reserva.");
					//$this->email->attach($reserva_pdf_name);
					
					$data_usuario['codigo_reserva']			= $form_data['codigo_reserva'];
					$data_usuario['forma_pago']				= $form_data['tipo_forma_pago'];
					$data_usuario['denominacion']			= $form_data['denominacion'];
					$data_usuario['noches']					= $form_data['noches'];
					$data_usuario['precio_total']			= $form_data['precio_total'];
					$data_usuario['personas']				= $form_data['personas'];
					$data_usuario['habitaciones']			= $form_data['habitaciones'];
					$data_usuario['numero_habitaciones']	= $form_data['numero_habitaciones'];
					$data_usuario['titular_reserva']	= $form_data['titular_reserva'];	
					$data_usuario['nombre_completo'] 	= $form_data['nombre_completo'];
					$data_usuario['email'] 				= $form_data['email'];
					$data_usuario['telefono'] 			= $form_data['telefono'];
					$data_usuario['nacionalidad'] 		= $form_data['nacionalidad'];
					$data_usuario['personas'] 			= $form_data['personas'];
					$data_usuario['aerolinea'] 			= $form_data['aerolinea'];
					$data_usuario['fecha_llegada'] 		= $form_data['fecha_llegada'];
					$data_usuario['hora_llegada'] 		= $form_data['hora_llegada'];
					$data_usuario['fecha_salida'] 		= $form_data['fecha_salida'];
					$data_usuario['hora_salida'] 		= $form_data['hora_salida'];
					$data_usuario['observaciones'] 		= $form_data['observaciones'];
					
					$this->email->message($this->load->view('front/correo_admin', $data_usuario, true));
					$this->email->send();
					
					$data['mensaje'] 				= lang('front.reserva.mensaje-exitoso');
					$data['titulo']					= lang('front.title_reservacion');
					$data['title'] 					= lang('front_title.reserva');
					unlink($reserva_pdf_name);
					
					redirect("reserva/reserva_front/show_reserva/".$data_usuario['codigo_reserva']);
					/*
					$data['contenido_principal'] 	= $this->load->view('reserva/mensaje-enviado',$data,true);
					
					$this->load->view('front/template',$data);
					 **/
					
				}
				else//SI NO SE ENVIA CORRECTAMENTE
				{
					//echo $this->email->print_debugger();	
					$data['mensaje'] 				= lang('front.reserva.mensaje-error');
					$data['titulo']					= lang('front.title_reservacion');
					$data['title'] 					= lang('front_title.reserva');
					$data['contenido_principal'] 	= $this->load->view('reserva/mensaje-enviado',$data,true);
					$this->load->view('front/template',$data);
				}
				
				
			}
			else
			{
				echo "<pre>".print_r($_POST,TRUE)."</pre>";
				
				//CONFIGURANDO FECHAS PARA LA BUSQUEDA DE HABITACIONES
			    $dateTime1 = new DateTime($this->input->post('fecha_llegada'));
				$dateTime2 = new DateTime($this->input->post('fecha_salida'));			
				$dateTime1 = $dateTime1->format('Y-m-d'); 
				$dateTime2 = $dateTime2->format('Y-m-d'); 
				
				$data = array(
					"titular_reserva"		=> 	$this->input->post('titular_reserva'),
					"fecha_llegada" 		=>	$this->input->post('fecha_llegada'),
					"fecha_salida"			=>	$this->input->post('fecha_salida'),
					"personas"				=> 	$this->input->post('personas'),
					"aerolinea"				=> 	$this->input->post("aerolinea"),
					"checkin"				=>	$dateTime1,
					"checkout"				=>	$dateTime2,
					"id_estado_reservacion"	=> 	2,
					"id_estado_activo"		=> 	1,
					"id_tipo_forma_pago"	=> 	$this->input->post("id_tipo_forma_pago"),
					"precio"				=>  $this->input->post('precio'),
					"id_usuario_front"		=> 	$this->session->userdata("id_usuario"),
					"observaciones"			=>	$this->input->post("observaciones"),
					"tratamiento"			=> 	$this->input->post("tratamiento")
				);
				
				//die_pre($data);
					
				$data['tratamiento'] 			= $this->input->post("tratamiento");
				$data['habs'] 					= $_POST['habs'];
				
			  	
				//NUMERO DE NOCHES 
				$data['noches'] = $this->input->post('noches');
				
				//OBTENGO LA TEMPORADA ACTUAL
				$data['temporada'] = $this->reserva_model->get_temporada_actual();
				
				//GUARDO LA CANTIDAD DE HABITACIONES TOTAL
				$data['cant_habitaciones'] = $this->input->post('cant_habitaciones');
				
				//GUARDO EL PRECIO TOTAL DE LA RESERVA
				$data['precio']	= $this->input->post('precio');
				
				//GUARDO LA DENOMINACION DE LA MONEDA
				$data['denominacion']	= $this->input->post('denominacion');
				
				//ACTUALIZO LA COOKIE
				$data['tip_habs'] = $_POST['tip_habs'];
				
				$data['hab_disponibles'] = $_POST['hab_disponibles'];
				
				//OBTENGO EL VECTOR DE TODOS LOS PAISES
				$query_paises 					=	$this->usuarios_model->obtener_paises();
				
				//OBTENGO EL VECTOR DE STRINGS DE LOS PAISES
				$data['opt_paises'] 			= 	dropdown($query_paises, 'id_pais', 'descripcion');
				
				$query_forma_pago = $this->reserva_model->get_formas_pago();
				$data['formas_pago']= dropdown($query_forma_pago, 'id_tipo_forma_pago', 'descripcion');
				
				//DATA GUARDARDA
				$data['direccion'] 			= $this->input->post("direccion");
				$data['aerolinea'] 			= $this->input->post("aerolinea");
				$data['hora_llegada'] 		= $this->input->post("hora_llegada");
				$data['hora_salida'] 		= $this->input->post("hora_salida");
				$data['telefono'] 			= $this->input->post("telefono");
				$data['id_tipo_forma_pago'] = $this->input->post("id_tipo_forma_pago");
				
				//OBTENGO EL VECTOR DE TODOS LOS PAISES
				$query_paises 					=	$this->usuarios_model->obtener_paises();
				
				//OBTENGO EL VECTOR DE STRINGS DE LOS PAISES
				$data['opt_paises'] 			= 	dropdown($query_paises, 'id_pais', 'descripcion');
				
				$query_forma_pago = $this->reserva_model->get_formas_pago();
				$data['formas_pago']= dropdown($query_forma_pago, 'id_tipo_forma_pago', 'descripcion');
				
				$data['title'] 					= lang('front.title_reservacion');
				$data['contenido_principal'] 	= $this->load->view('reserva/front/direccion-reserva',$data,true);
			
				$this->load->view('front/template',$data);
			}
			
			
		}
		else
		{
			redirect("/");
		}
		
	}

	function reservas_usuario($mensaje = '')
	{
		$id_usuario = $this->session->userdata("id_usuario");
		$reservaciones = $this->reserva_model->get_reservas_usuario($id_usuario);
		if(empty($reservaciones))
		{
			$data['mensaje'] = "Lo sentimos, no tenemos ninguna reservación de usted registrada en el sistema.";
			$data['reservaciones']			= $reservaciones;
			$data['title'] 					= lang('front.title_reservacion');
			$data['contenido_principal'] 	= $this->load->view('reserva/front/reservacion_usuario',$data,true);
			
			$this->load->view('front/template',$data);
		}
		else
		{
			foreach($reservaciones as $r => $value)
			{
				$value->id_estado_reservacion = $this->reserva_model->get_estado_reservacion($value->id_estado_reservacion);
			}
			$data['reservaciones']			= $reservaciones;
			$data['title'] 					= lang('front.title_reservacion');
			$data['contenido_principal'] 	= $this->load->view('reserva/front/reservacion_usuario',$data,true);
			
			$this->load->view('front/template',$data);
		}
		
	}
	
	function ajax_guardar_reserva()
	{
		$this->form_validation->set_rules("telefono","Telefono","required|trim");
		$this->form_validation->set_rules("aerolinea","Aerolinea","required|trim");
		
		$this->form_validation->set_message("required","El campo %s es obligatorio");
		
		if($this->form_validation->run($this) == TRUE)
		{
			$data = array(
				"mensaje"			=>	"Correcto"
			);
			
			echo json_encode($data);
		}
		else
		{
			$data = array(
				"mensaje"			=>	"Error",
				"error_telefono"	=>	form_error('telefono'),
				"error_aerolinea"	=>	form_error('aerolinea')
			);
			
			echo json_encode($data);
		}
	}
	
	function download_reserva($codigo_reserva)
	{
		$this->load->library('mpdf');
		$reservacion = $this->reserva_model->get_detalle_reservacion($codigo_reserva);
		
		$id_idioma = $this->session->userdata("id_idioma");
		$id_reservacion = $reservacion->id_reservacion;
		$id_temporada = $this->reserva_model->get_temporada_actual();
		
		$huespedes = $this->reserva_model->get_huesped_reserva($id_idioma,$id_reservacion,$id_temporada);
		
		$data = array(
			"titular_reserva"	=>	$this->session->userdata('nombre'),
			"email"				=> 	$this->session->userdata('email'),
			"telefono"			=>	$this->session->userdata('telefono'),
			"direccion"			=>	$this->session->userdata('direccion'),
			"pais"				=> 	$this->usuarios_model->get_pais($this->session->userdata('id_pais')),
			"nacionalidad"		=> 	$this->session->userdata('nacionalidad'),
			"codigo_reserva"	=>	$reservacion->codigo_reserva,
			"personas"			=>	$reservacion->personas,
			"aerolinea"			=>	$reservacion->aerolinea,
			"checkin"			=>	$reservacion->checkin,
			"checkout"			=> 	$reservacion->checkout,
			"tipo_forma_pago"	=>	$this->reserva_model->get_forma_pago($reservacion->id_tipo_forma_pago),
			"precio_total"		=>	$reservacion->precio
				
		);
		
		$i=0;
		foreach($huespedes as $h => $value)
		{
			$habitaciones[$i]['nombre_titular']		= $value->huesped;
			$habitaciones[$i]['tipo']				= $value->tipo;
			$habitaciones[$i]['tipo_descrip']		= $value->descripcion_breve;
			$habitaciones[$i]['moneda_abreviado']	= $value->denominacion;
			$habitaciones[$i]['valor']				= $value->valor;
			$habitaciones[$i]['peticion']			= $value->peticion;
			++$i;
		}
		
		$dateTime1 = new DateTime($data['checkin']);
		$dateTime2 = new DateTime($data['checkout']);
		$dateTime1 = $dateTime1->format('Y-m-d H:m:s'); 
		$dateTime2 = $dateTime2->format('Y-m-d H:m:s'); 
		
		$inicio		= date_create($dateTime1);
		$fin 		= date_create($dateTime2);
		$intervalo 	= date_diff($inicio, $fin);	
		
		$data['noches']	= $intervalo->days;
		
		$data['habitaciones'] = $habitaciones;
		$data['numero_habitaciones'] = count($data['habitaciones']);
		
		$reserva_pdf = $this->load->view('reserva/front/datos_reservacion_pdf',$data,true);
		$reserva_pdf_name = $data['codigo_reserva'].'_'.$this->session->userdata('nombre').'.pdf';
		$stylesheet = "assets/front/css/factura.css";
		$mpdf = new mPDF();
		$mpdf->WriteHTML($stylesheet,1);
		$mpdf->WriteHTML($reserva_pdf,2);
		$footer = 
		"
		<div>
			<span>
				<b>Fecha de creacion: </b>".date("Y-m-d H:i:s")."
			</span>
		</div>
		";
		$mpdf->setHTMLFooter($footer);
		$mpdf->Output($reserva_pdf_name,'D');
	}

	function show_reserva($codigo_reserva)
	{
		if($this->session->userdata('nombre'))
		{
			$reservacion = $this->reserva_model->get_detalle_reservacion($codigo_reserva);
			
			$id_idioma = $this->session->userdata("id_idioma");
			$id_reservacion = $reservacion->id_reservacion;
			$id_temporada = $this->reserva_model->get_temporada_actual();
			
			$huespedes = $this->reserva_model->get_huesped_reserva($id_idioma,$id_reservacion,$id_temporada);
			
			$data = array(
				"id_reservacion"	=>	$reservacion->id_reservacion,
				"titular_reserva"	=>	$this->session->userdata('nombre'),
				"email"				=> 	$this->session->userdata('email'),
				"telefono"			=>	$this->session->userdata('telefono'),
				"direccion"			=>	$this->session->userdata('direccion'),
				"id_pais"			=>	$this->session->userdata('id_pais'),
				"pais"				=> 	$this->usuarios_model->get_pais($this->session->userdata('id_pais')),
				"nacionalidad"		=> 	$this->session->userdata('nacionalidad'),
				"codigo_reserva"	=>	$reservacion->codigo_reserva,
				"personas"			=>	$reservacion->personas,
				"aerolinea"			=>	$reservacion->aerolinea,
				"checkin"			=>	$reservacion->checkin,
				"checkout"			=> 	$reservacion->checkout,
				"id_tipo_forma_pago"=> 	$reservacion->id_tipo_forma_pago,
				"tipo_forma_pago"	=>	$this->reserva_model->get_forma_pago($reservacion->id_tipo_forma_pago),
				"precio_total"		=>	$reservacion->precio,
				"id_estado_reservacion"	=> $reservacion->id_estado_reservacion,
					
			);
			
			$i=0;
			foreach($huespedes as $h => $value)
			{
				$habitaciones[$i]['nombre_titular']		= $value->huesped;
				$habitaciones[$i]['tipo']				= $value->tipo;
				$habitaciones[$i]['tipo_descrip']		= $value->descripcion_breve;
				$habitaciones[$i]['moneda_abreviado']	= $value->denominacion;
				$habitaciones[$i]['valor']				= $value->valor;
				$habitaciones[$i]['peticion']			= $value->peticion;
				$data['denominacion'] 					= $value->denominacion;
				++$i;
			}
			
			$dateTime1 = new DateTime($data['checkin']);
			$dateTime2 = new DateTime($data['checkout']);
			$dateTime1 = $dateTime1->format('Y-m-d H:m:s'); 
			$dateTime2 = $dateTime2->format('Y-m-d H:m:s'); 
			
			$inicio		= date_create($dateTime1);
			$fin 		= date_create($dateTime2);
			$intervalo 	= date_diff($inicio, $fin);	
			
			$data['noches']	= $intervalo->days;
			
			$data['habitaciones'] = $habitaciones;
			$data['numero_habitaciones'] = count($data['habitaciones']);
			
			$query_forma_pago = $this->reserva_model->get_formas_pago();
			$data['formas_pago']= dropdown($query_forma_pago, 'id_tipo_forma_pago', 'descripcion');
			
			$data['title'] 					= lang('front.title_reservacion');
			$data['contenido_principal'] 	= $this->load->view('reserva/front/reserva_view',$data,true);
			
			$this->load->view('front/template',$data);
		}
		else
		{
			redirect('iniciar-sesion');
		}
		
	}

	function set_reserva($codigo_reserva)
	{
		if($this->session->userdata('nombre'))
		{
			$reservacion = $this->reserva_model->get_detalle_reservacion($codigo_reserva);
		
			$id_idioma = $this->session->userdata("id_idioma");
			$id_reservacion = $reservacion->id_reservacion;
			$id_temporada = $this->reserva_model->get_temporada_actual();
			
			$huespedes = $this->reserva_model->get_huesped_reserva($id_idioma,$id_reservacion,$id_temporada);
			//die_pre($reservacion);
			$data = array(
				"id_reservacion"	=>	$reservacion->id_reservacion,
				"id_estado_reservacion"=>$reservacion->id_estado_reservacion,
				"titular_reserva"	=>	$this->session->userdata('nombre'),
				"email"				=> 	$this->session->userdata('email'),
				"telefono"			=>	$this->session->userdata('telefono'),
				"direccion"			=>	$this->session->userdata('direccion'),
				"pais"				=> 	$this->usuarios_model->get_pais($this->session->userdata('id_pais')),
				"nacionalidad"		=> 	$this->session->userdata('nacionalidad'),
				"codigo_reserva"	=>	$reservacion->codigo_reserva,
				"personas"			=>	$reservacion->personas,
				"aerolinea"			=>	$reservacion->aerolinea,
				"checkin"			=>	$reservacion->checkin,
				"checkout"			=> 	$reservacion->checkout,
				"tipo_forma_pago"	=>	$this->reserva_model->get_forma_pago($reservacion->id_tipo_forma_pago),
				"precio_total"		=>	$reservacion->precio,
				"id_tipo_forma_pago"=> 	$reservacion->id_tipo_forma_pago
					
			);
			
			$i=0;
			foreach($huespedes as $h => $value)
			{
				$habitaciones[$i]['nombre_titular']		= $value->huesped;
				$habitaciones[$i]['tipo']				= $value->tipo;
				$habitaciones[$i]['tipo_descrip']		= $value->descripcion_breve;
				$habitaciones[$i]['moneda_abreviado']	= $value->denominacion;
				$habitaciones[$i]['valor']				= $value->valor;
				$habitaciones[$i]['peticion']			= $value->peticion;
				$habitaciones[$i]['personas']			= $value->personas;
				++$i;
			}
			
			$dateTime1 = new DateTime($data['checkin']);
			$dateTime2 = new DateTime($data['checkout']);
			$dateTime1 = $dateTime1->format('Y-m-d H:m:s'); 
			$dateTime2 = $dateTime2->format('Y-m-d H:m:s'); 
			
			$inicio		= date_create($dateTime1);
			$fin 		= date_create($dateTime2);
			$intervalo 	= date_diff($inicio, $fin);	
			
			$data['noches']	= $intervalo->days;
			
			$data['habitaciones'] = $habitaciones;
			$data['numero_habitaciones'] = count($data['habitaciones']);
			//pre($reservacion);
			
			//pre($huespedes);
			
			$query_forma_pago = $this->reserva_model->get_formas_pago();
			$data['formas_pago']= dropdown($query_forma_pago, 'id_tipo_forma_pago', 'descripcion');
			
			$query_paises 					=	$this->usuarios_model->obtener_paises();
			$data['opt_paises'] 			= 	dropdown($query_paises, 'id_pais', 'descripcion');
			
			$data['title'] 					= lang('front.title_reservacion');
			$data['contenido_principal'] 	= $this->load->view('reserva/front/set_reserva_view',$data,true);
			
			$this->load->view('front/template',$data);
		}
	}
	
	function verificar_disponibilidad_tipo_habitacion()
	{
		$dateTime1 		= new DateTime($this->input->post("checkin"));
		$dateTime2 		= new DateTime($this->input->post("checkout"));
		$dateTime1 		= $dateTime1->format('Y-m-d'); 
		$dateTime2 		= $dateTime2->format('Y-m-d'); 
		$id_temporada 	= $this->reserva_model->get_temporada_actual();
		
		$habitaciones_disponibles 	= $this->reserva_model->get_disponibles_tipo_habitacion($this->session->userdata("id_idioma"), $id_temporada, $dateTime1, $dateTime2);
		
		$i=0;
		foreach($habitaciones_disponibles as $hd => $value)
		{
			foreach($value as $h => $value2)
			{
				$hab_disponibles[$i][$h] = $value2;
			}
			++$i;
		}
		
		$reservacion = $this->reserva_model->get_detalle_reservacion($this->input->post('codigo_reserva'));
				
		$id_idioma = $this->session->userdata("id_idioma");
		$id_reservacion = $reservacion->id_reservacion;
		$id_temporada = $this->reserva_model->get_temporada_actual();
		
		$huespedes = $this->reserva_model->get_huesped_reserva($id_idioma,$id_reservacion,$id_temporada);

		$i=0;
		foreach($huespedes as $h => $value)
		{
			$habitaciones[$i]['nombre_titular']					= $value->huesped;
			$habitaciones[$i]['tipo']							= $value->tipo;
			$habitaciones[$i]['tipo_descrip']					= $value->descripcion_breve;
			$habitaciones[$i]['moneda_abreviado']				= $value->denominacion;
			$habitaciones[$i]['valor']							= $value->valor;
			$habitaciones[$i]['peticion']						= $value->peticion;
			$habitaciones[$i]['personas']						= $value->personas;
			$habitaciones[$i]['id_tipo_habitacion']				= $value->id_tipo_habitacion;
			$habitaciones[$i]['id_reservacion_tipo_habitacion']	= $value->id_reservacion_tipo_habitacion;
			$habitaciones[$i]['id_huesped']						= $value->id_huesped;
			++$i;
		}
		
		$disponibilidad = true;
		for($i=0;$i<count($habitaciones) && $disponibilidad;++$i)
		{
			for($j=0;$j<count($hab_disponibles) && $disponibilidad;++$j)
			{
				if(($habitaciones[$i]['id_tipo_habitacion'] == $hab_disponibles[$j]['id_tipo_habitacion']) && !($hab_disponibles[$j]['habitaciones'] > 0))
				{
					$disponibilidad = FALSE;
				}
				elseif(($habitaciones[$i]['id_tipo_habitacion'] == $hab_disponibles[$j]['id_tipo_habitacion']) && ($hab_disponibles[$j]['habitaciones'] > 0))
				{
					$hab_disponibles[$j]['habitaciones'] -=1;
				}
			}
		}
		
		return $disponibilidad;
	}

	
	function update_reserva()
	{
		$this->load->library('mpdf');
		if($_POST)
		{
			$reservacion = $this->reserva_model->get_detalle_reservacion($_POST['codigo_reserva']);
			
			$this->form_validation->set_rules("nombre_cliente","Nombre cliente","required");
			$this->form_validation->set_rules("peticiones","Peticion","required");
			
			if(!$reservacion->checkin == $this->input->post('checkin') && !$reservacion->checkout == $this->input->post('checkout'))
			{
				$this->form_validation->set_rules("checkin","Peticion","required|trim");
				$this->form_validation->set_rules("checkout","Peticion","required|trim|callback_verificar_disponibilidad_tipo_habitacion");
			}
			
			$this->form_validation->set_message("required","El campo %s es obligatorio");
			$this->form_validation->set_message("verificar_disponibilidad_tipo_habitacion","No existe disponibilidad de habitaciones en la fecha escogida.");
			
			
			$this->form_validation->set_error_delimiters('<div class="alert-box success radius"style="font-size: 13px;">',
			 '<a href="reserva/reserva_front/set_reserva/'.$this->input->post('codigo_reserva').'" class="close">&times;</a></div>');
			
			if($this->form_validation->run($this) == TRUE)
			{
				$reservacion 	= $this->reserva_model->get_detalle_reservacion($_POST['codigo_reserva']);
		
				$id_idioma 		= $this->session->userdata("id_idioma");
				$id_reservacion = $reservacion->id_reservacion;
				$id_temporada 	= $this->reserva_model->get_temporada_actual();
				
				$huespedes 		= $this->reserva_model->get_huesped_reserva($id_idioma,$id_reservacion,$id_temporada);
				
				//pre($huespedes);
				
				$i=0;
				foreach($huespedes as $h => $value)
				{
					$habitaciones[$i]['nombre_titular']					= $value->huesped;
					$habitaciones[$i]['tipo']							= $value->tipo;
					$habitaciones[$i]['tipo_descrip']					= $value->descripcion_breve;
					$habitaciones[$i]['moneda_abreviado']				= $value->denominacion;
					$habitaciones[$i]['valor']							= $value->valor;
					$habitaciones[$i]['peticion']						= $value->peticion;
					$habitaciones[$i]['personas']						= $value->personas;
					$habitaciones[$i]['id_tipo_habitacion']				= $value->id_tipo_habitacion;
					$habitaciones[$i]['id_reservacion_tipo_habitacion']	= $value->id_reservacion_tipo_habitacion;
					$habitaciones[$i]['id_huesped']						= $value->id_huesped;
					++$i;
				}
				
				for($i=0;$i<count($habitaciones);++$i)
				{
					$reserva_tipo_habitacion['id_reservacion'] 			= $id_reservacion;
					$reserva_tipo_habitacion['peticion'] 				= $_POST['peticiones'][$i];
					$reserva_tipo_habitacion['id_tipo_habitacion'] 		= $habitaciones[$i]['id_tipo_habitacion'];
					$reserva_tipo_habitacion['id_reservacion_tipo_habitacion']	= $habitaciones[$i]['id_reservacion_tipo_habitacion'];

					$this->reserva_model->update_reservacion_tipo_habitacion($reserva_tipo_habitacion);
					
					$huesped['tratamiento']								= "Sr(a)";
					$huesped['nombre'] 									= $_POST['nombre_cliente'][$i];
					$huesped['id_reservacion_tipo_habitacion'] 			= $habitaciones[$i]['id_reservacion_tipo_habitacion'];
					$huesped['id_huesped']								= $habitaciones[$i]['id_huesped'];
					
					$this->reserva_model->update_huesped($huesped);
				}
				
				$dateTime1 = new DateTime($this->input->post('checkin'));
				$dateTime2 = new DateTime($this->input->post('checkout'));
				$dateTime1 = $dateTime1->format('Y-m-d'); 
				$dateTime2 = $dateTime2->format('Y-m-d'); 
				
				$inicio		= date_create($dateTime1);
				$fin 		= date_create($dateTime2);
				$intervalo 	= date_diff($inicio, $fin);	
				
				$reservacion_update = array(
					"id_reservacion"	=>	$id_reservacion,
					"checkin"			=> 	$dateTime1,
					"checkout"			=>	$dateTime2
				);
				
				$this->reserva_model->update_reservacion($reservacion_update);
				
				$mensaje = "Su reserva ha sido actualizada correctamente.";
				$id_usuario = $this->session->userdata("id_usuario");
				$reservaciones = $this->reserva_model->get_reservas_usuario($id_usuario);
				foreach($reservaciones as $r => $value)
				{
					$value->id_estado_reservacion = $this->reserva_model->get_estado_reservacion($value->id_estado_reservacion);
				}
				$data['reservaciones']			= $reservaciones;
				$data['noches']	= $intervalo->days;
				
				//GENERANDO PDF
				$reservacion = $this->reserva_model->get_detalle_reservacion($this->input->post("codigo_reserva"));
		
				$id_idioma = $this->session->userdata("id_idioma");
				$id_reservacion = $reservacion->id_reservacion;
				$id_temporada = $this->reserva_model->get_temporada_actual();
				
				$huespedes = $this->reserva_model->get_huesped_reserva($id_idioma,$id_reservacion,$id_temporada);
				
				$data = array(
					"titular_reserva"	=>	$this->session->userdata('nombre'),
					"email"				=> 	$this->session->userdata('email'),
					"telefono"			=>	$this->session->userdata('telefono'),
					"direccion"			=>	$this->session->userdata('direccion'),
					"pais"				=> 	$this->usuarios_model->get_pais($this->session->userdata('id_pais')),
					"nacionalidad"		=> 	$this->session->userdata('nacionalidad'),
					"codigo_reserva"	=>	$reservacion->codigo_reserva,
					"personas"			=>	$reservacion->personas,
					"aerolinea"			=>	$reservacion->aerolinea,
					"checkin"			=>	$reservacion->checkin,
					"checkout"			=> 	$reservacion->checkout,
					"tipo_forma_pago"	=>	$this->reserva_model->get_forma_pago($reservacion->id_tipo_forma_pago),
					"precio_total"		=>	$reservacion->precio
						
				);
				
				$i=0;
				foreach($huespedes as $h => $value)
				{
					$habitaciones[$i]['nombre_titular']		= $value->huesped;
					$habitaciones[$i]['tipo']				= $value->tipo;
					$habitaciones[$i]['tipo_descrip']		= $value->descripcion_breve;
					$habitaciones[$i]['moneda_abreviado']	= $value->denominacion;
					$habitaciones[$i]['valor']				= $value->valor;
					$habitaciones[$i]['peticion']			= $value->peticion;
					++$i;
				}
				
				$dateTime1 = new DateTime($data['checkin']);
				$dateTime2 = new DateTime($data['checkout']);
				$dateTime1 = $dateTime1->format('Y-m-d H:m:s'); 
				$dateTime2 = $dateTime2->format('Y-m-d H:m:s'); 
				
				$inicio		= date_create($dateTime1);
				$fin 		= date_create($dateTime2);
				$intervalo 	= date_diff($inicio, $fin);	
				
				$data['noches']	= $intervalo->days;
				
				$data['habitaciones'] = $habitaciones;
				$data['numero_habitaciones'] = count($data['habitaciones']);
				
				$reserva_pdf = $this->load->view('reserva/front/datos_reservacion_pdf',$data,true);
				$reserva_pdf_name = 'assets/front/pdf/'.$data['codigo_reserva'].'_'.$this->session->userdata('nombre').'.pdf';
				$stylesheet = "assets/front/css/factura.css";
				$mpdf = new mPDF();
				$mpdf->WriteHTML($stylesheet,1);
				$mpdf->WriteHTML($reserva_pdf,2);
				$footer = 
				"
				<div>
					<span>
						<b>Fecha de creacion: </b>".date("Y-m-d H:i:s")."
					</span>
				</div>
				";
				$mpdf->setHTMLFooter($footer);
				$mpdf->Output($reserva_pdf_name,'F');
				
				//CONFIGURACION PARA EL ENVIO DEL CORREO ELECTRONICO
				$config['protocol']		= "smtp";
	            $config['smtp_host']   	= "ssl://smtp.googlemail.com";
	            $config['smtp_port']   	= 465;
	            $config['smtp_user'] 	= lang('front.smtp_user');
	            $config['smtp_pass']    = lang('front.smtp_pass');
	            $config['mailtype']    	= "html";
	            $config['charset']    	= 'utf-8';
	            $config['newline']     	= "\r\n";
				$this->load->library('email', $config);
				
				$this->email->initialize($config);
				
				$this->email->from(lang('front.smtp_email1'),"Sol y Luna");
				$this->email->to($this->session->userdata('email'));
				$this->email->bcc('gchemello@gmail.com');
				//$this->email->bcc("");
				$this->email->subject($this->session->userdata("nombre").", tu reserva se ha acutalizado.");
				$this->email->attach($reserva_pdf_name);
				
				$data_usuario = array(
					"codigo_reserva"	=>	$reservacion->codigo_reserva,
					"checkin"			=>	$reservacion->checkin,
					"checkout"			=>	$reservacion->checkout,
					"titular_reserva"	=>	$this->session->userdata("nombre")
				);
				
				$this->email->message($this->load->view('front/correo_usuario_modificar', $data_usuario, true));			
				$this->email->send();
				
				$this->email->from(lang('front.smtp_email1'),"Sol y Luna");
				$this->email->to(lang('front.smtp_email1'));
				$this->email->bcc('gchemello@gmail.com');
				//$this->email->bcc("");
				$this->email->subject("Se ha actualizado la reserva de ".$this->session->userdata("nombre"));
				
				$data_usuario = array(
					"codigo_reserva"	=>	$reservacion->codigo_reserva,
					"checkin"			=>	$reservacion->checkin,
					"checkout"			=>	$reservacion->checkout,
					"titular_reserva"	=>	$this->session->userdata("nombre")
				);
				
				$this->email->message($this->load->view('front/correo_admin_modificar', $data_usuario, true));			
				$this->email->send();
				
				//GENERANDO PDF
				$data['reservaciones']			= $reservaciones;
				$data['update']					= "Su reservacion ha sido actualizada exitosamente.";
				$data['title'] 					= lang('front.title_reservacion');
				$data['contenido_principal'] 	= $this->load->view('reserva/front/reservacion_usuario',$data,true);
				unlink($reserva_pdf_name);
				$this->load->view('front/template',$data);
				
			}
			else
			{
				if($this->session->userdata('id_usuario'))
				{				
					$reservacion = $this->reserva_model->get_detalle_reservacion($this->input->post('codigo_reserva'));
				
					$id_idioma = $this->session->userdata("id_idioma");
					$id_reservacion = $reservacion->id_reservacion;
					$id_temporada = $this->reserva_model->get_temporada_actual();
					
					$huespedes = $this->reserva_model->get_huesped_reserva($id_idioma,$id_reservacion,$id_temporada);
					
					$data = array(
						"titular_reserva"	=>	$this->session->userdata('nombre'),
						"email"				=> 	$this->session->userdata('email'),
						"telefono"			=>	$this->session->userdata('telefono'),
						"direccion"			=>	$this->session->userdata('direccion'),
						"pais"				=> 	$this->usuarios_model->get_pais($this->session->userdata('id_pais')),
						"nacionalidad"		=> 	$this->session->userdata('nacionalidad'),
						"codigo_reserva"	=>	$reservacion->codigo_reserva,
						"personas"			=>	$reservacion->personas,
						"aerolinea"			=>	$reservacion->aerolinea,
						"checkin"			=>	$reservacion->checkin,
						"checkout"			=> 	$reservacion->checkout,
						"tipo_forma_pago"	=>	$this->reserva_model->get_forma_pago($reservacion->id_tipo_forma_pago),
						"precio_total"		=>	$reservacion->precio,
						"id_tipo_forma_pago"=> 	$reservacion->id_tipo_forma_pago
							
					);
					
					$i=0;
					foreach($huespedes as $h => $value)
					{
						$habitaciones[$i]['nombre_titular']		= $value->huesped;
						$habitaciones[$i]['tipo']				= $value->tipo;
						$habitaciones[$i]['tipo_descrip']		= $value->descripcion_breve;
						$habitaciones[$i]['moneda_abreviado']	= $value->denominacion;
						$habitaciones[$i]['valor']				= $value->valor;
						$habitaciones[$i]['peticion']			= $value->peticion;
						$habitaciones[$i]['personas']			= $value->personas;
						++$i;
					}
					
					$dateTime1 = new DateTime($data['checkin']);
					$dateTime2 = new DateTime($data['checkout']);
					$dateTime1 = $dateTime1->format('Y-m-d H:m:s'); 
					$dateTime2 = $dateTime2->format('Y-m-d H:m:s'); 
					
					$inicio		= date_create($dateTime1);
					$fin 		= date_create($dateTime2);
					$intervalo 	= date_diff($inicio, $fin);	
					
					$data['noches']	= $intervalo->days;
					
					$data['habitaciones'] = $habitaciones;
					$data['numero_habitaciones'] = count($data['habitaciones']);
					
					$query_forma_pago = $this->reserva_model->get_formas_pago();
					$data['formas_pago']= dropdown($query_forma_pago, 'id_tipo_forma_pago', 'descripcion');
					
					$query_paises 					=	$this->usuarios_model->obtener_paises();
					$data['opt_paises'] 			= 	dropdown($query_paises, 'id_pais', 'descripcion');
					
					$data['title'] 					= lang('front.title_reservacion');
					$data['contenido_principal'] 	= $this->load->view('reserva/front/set_reserva_view',$data,true);
					
					$this->load->view('front/template',$data);
				}
				else
				{
					redirect("/");
				}
			}
		}
		else
		{
			redirect("/");
		}
	}
	
	function cancel_reserva($codigo_reserva)
	{
		$reservacion = $this->reserva_model->get_detalle_reservacion($codigo_reserva);
		if($this->session->userdata('id_usuario') == $reservacion->id_usuario_front)
		{
			$id_reservacion = $reservacion->id_reservacion;
			
			$this->reserva_model->cancel_reserva($id_reservacion);
			
			$id_usuario = $this->session->userdata("id_usuario");
			$reservaciones = $this->reserva_model->get_reservas_usuario($id_usuario);
			
			foreach($reservaciones as $r => $value)
				$value->id_estado_reservacion = $this->reserva_model->get_estado_reservacion($value->id_estado_reservacion);
			
			//CONFIGURACION PARA EL ENVIO DEL CORREO ELECTRONICO
			$config['protocol']		= "smtp";
            $config['smtp_host']   	= "ssl://smtp.googlemail.com";
            $config['smtp_port']   	= 465;
            $config['smtp_user'] 	= lang('front.smtp_user');
            $config['smtp_pass']    = lang('front.smtp_pass');
            $config['mailtype']    	= "html";
            $config['charset']    	= 'utf-8';
            $config['newline']     	= "\r\n";
			$this->load->library('email', $config);
			
			$this->email->initialize($config);
			
			$this->email->from(lang('front.smtp_email1'),"Sol y Luna");
			$this->email->to($this->session->userdata('email'));
			$this->email->bcc('gchemello@gmail.com');
			//$this->email->bcc("");
			$this->email->subject($this->session->userdata("nombre").", tu reserva se ha acutalizado.");
			
			$data_usuario = array(
				"codigo_reserva"	=>	$reservacion->codigo_reserva,
				"checkin"			=>	$reservacion->checkin,
				"checkout"			=>	$reservacion->checkout,
				"titular_reserva"	=>	$this->session->userdata("nombre")
			);
			
			$this->email->message($this->load->view('front/correo_usuario_cancelar', $data_usuario, true));			
			$this->email->send();
			
			$this->email->from(lang('front.smtp_email1'),"Sol y Luna");
			$this->email->to(lang('front.smtp_email1'));
			$this->email->bcc('gchemello@gmail.com');
			//$this->email->bcc("");
			$this->email->subject("Se ha actualizado la reserva de ".$this->session->userdata("nombre"));
			
			$this->email->message($this->load->view('front/correo_admin_cancelar', $data_usuario, true));			
			$this->email->send();
			
			$data['update']					= "Su reserva ha sido cancelada satisfactoriamente.";
			$data['reservaciones']			= $reservaciones;
			$data['title'] 					= lang('front.title_reservacion');
			$data['contenido_principal'] 	= $this->load->view('reserva/front/reservacion_usuario',$data,true);	
			$this->load->view('front/template',$data);
		}
		else
		{
			redirect("/");
		}
	}
	
	function ajax_agregar_pago()
	{

		if($_POST)
		{
			$this->form_validation->set_rules("id_reservacion","id_reservacion","required");
			$this->form_validation->set_rules("fecha_pago","Fecha de pago","required");
			$this->form_validation->set_rules("id_tipo_forma_pago","Tipo de pago","required");
			$this->form_validation->set_rules("numero_referencia","Numero de referencia","required");
			$this->form_validation->set_rules("tipo_moneda","Tipo de moneda","required");
			$this->form_validation->set_rules("monto","Monto","required");
			
			$this->form_validation->set_message("required","%s este campo es requerido.");
			
			if($this->form_validation->run($this) == TRUE)
			{
				$dateTime1 = new DateTime($this->input->post("fecha_pago"));
				$dateTime1 = $dateTime1->format('Y-m-d'); 
				$data = array (
					
					"id_reservacion"		=>	$this->input->post("id_reservacion"),
					"fecha_pago"			=>	$dateTime1,
					"id_tipo_forma_pago" 	=>	$this->input->post("id_tipo_forma_pago"),
					"numero_referencia"		=>	$this->input->post("numero_referencia"),
					"tipo_moneda"			=>	$this->input->post("tipo_moneda"),
					"monto"					=>	$this->input->post("monto")	
				);
				
				$this->reserva_model->agregar_pago($data);
				
				$data = array(
					"mensaje"			=>	"correcto",
					"id_reservacion"	=>	$this->input->post("id_reservacion")
				);
				
				//CONFIGURACION PARA EL ENVIO DEL CORREO ELECTRONICO
				$config['protocol']		= "smtp";
	            $config['smtp_host']   	= "ssl://smtp.googlemail.com";
	            $config['smtp_port']   	= 465;
	            $config['smtp_user'] 	= lang('front.smtp_user');
	            $config['smtp_pass']    = lang('front.smtp_pass');
	            $config['mailtype']    	= "html";
	            $config['charset']    	= 'utf-8';
	            $config['newline']     	= "\r\n";
				$this->load->library('email', $config);
				
				$this->email->initialize($config);
				
				$this->email->from(lang('front.smtp_email1'),"Sol y Luna");
				$this->email->to($this->session->userdata('email'));
				$this->email->bcc('gchemello@gmail.com');
				//$this->email->bcc("");
				$this->email->subject("Aviso de pago");
				
				$data_usuario = array (
					"codigo_reserva"		=>	$this->reserva_model->get_codigo_reservacion($this->input->post("id_reservacion")),
					"titular_reserva"		=>	$this->session->userdata('nombre'),
					"fecha_pago"			=>	$this->input->post("fecha_pago"),
					"tipo_forma_pago" 		=>	$this->reserva_model->get_forma_pago($this->input->post("id_tipo_forma_pago")),
					"numero_referencia"		=>	$this->input->post("numero_referencia"),
					"tipo_moneda"			=>	$this->reserva_model->get_moneda($this->input->post("tipo_moneda")),
					"monto"					=>	$this->input->post("monto")	
				);
				
				$this->email->message($this->load->view('front/correo_pago_usuario', $data_usuario, true));
				if($this->email->send())
				{
					$this->email->from(lang('front.smtp_email1'),"Sol y Luna");
					$this->email->to(lang('front.smtp_email1'));
					$this->email->bcc('gchemello@gmail.com');
					//$this->email->bcc("");
					$this->email->subject("Aviso de pago");
					
					
					$this->email->message($this->load->view('front/correo_pago_admin', $data_usuario, true));
					$this->email->send();
				}
							
				
				echo json_encode($data);
			}	
			else
			{
				$data = array(
					"mensaje"				=>	"nocorrecto",
					"id_reservacion"		=>	$this->input->post("id_reservacion")
				);
				
				echo json_encode($data);
			}
			
			
		}
		else
		{
			redirect("/");
		}
	}	
}

/* End of file reserva.php */
/* Location: ./modules/reserva/controllers/reserva.php */