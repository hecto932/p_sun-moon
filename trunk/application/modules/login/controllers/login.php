<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************************************************
 * Controlador Para el registro y login en el sistema
 * 
 * Contiene todas las funciones necesarias para el registro de usuario y
 * el acceso del sistema de estos
 */

class Login extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}
	
	//Si el controlador login es invocado por url se forza a que cargue
	//por defecto la vista de login
	
	function index($data_content = '')
	{
		//Se indica que el contenido principal es la vista de login y
		//se carga el sitio con esta
		
		$data['contenido_principal'] = $this->load->view('login_view', $data_content, TRUE);
		$this->load->view('front/site_view', $data);
	}
	
	//Se encarga de llamar a la vista para el formulario de registro de
	//usuarios al sistema
	
	function formulario_registro($data_content = '')
	{
		//Se indica que el contenido principal es la vista de registro
		//de usuario y se carga el sitio con esta
		
		$data['contenido_principal'] = $this->load->view('registro_view', $data_content, TRUE);
		$this->load->view('front/site_view', $data);
	}
	
	//Se encarga de validar los datos ingresados por el usuario enviados
	//desde la vista del login
	
	function validar()
	{
		//Carga de la librería para la validación de formularios
		
		$this->load->library('form_validation');
		
		//Definición de mensajes a mostrar para cada una de las reglas
		//de validación utilizadas
	
		$this->form_validation->set_message('required', 'El campo %s es requerido');
		$this->form_validation->set_message('min_length', 'El tamaño del campo %s debe ser de por lo menos 6 caracteres');
		$this->form_validation->set_message('max_length', 'El tamaño del campo %s no debe ser mmayor a 32 caracteres');
		$this->form_validation->set_message('validar_cedula', 'La %s ingresada no existe en el sistema');
		
		//Definición de las reglas de validación para cada uno de los
		//campos requeridos en el formulario de login
		
		$this->form_validation->set_rules('cedula', 'Usuario o Cédula','trim|required|callback_validar_cedula');
		$this->form_validation->set_rules('clave', 'Contraseña', 'trim|required|min_length[6]|max_length[32]');
		
		//Se comprueba si se rompió alguna de las reglas de validación
		
		if($this->form_validation->run() == FALSE)
		{
			//De no cumplir con alguna de las reglas de validación
			//se indica que el contenido principal a mostrar va a ser
			//nuevamente el formulario de login indicando el error
			
			$this->index();
		}
		else
		{
			//De cumplir con todas las reglas se procede a verificar
			//si los datos ingresados no son correctos para poder hacer
			//inicio de sesión
			
			//Se carga el modelo donde estan definidas las funciones
			//para el manejo de datos relacionados al inicio de sesión
			//y registro  de usuarios
			
			$this->load->model('login_model');
			
			//Se verifica que la cedula ingresada existe resgistrada en el
			//sistema
			
			if(is_Numeric($this->input->post('cedula')))
			{
				if($this->login_model->verificar_cedula($this->input->post('cedula')))
				{
					//Se verifica que la clave dada corresponda con la almacenada
					//en la base de datos
					
					if($this->login_model->verificar_clave($this->input->post('cedula'), '', sha1($this->input->post('clave'))))
					{
						//Si la clave es correcta se obtienen los datos a cargar en la
						//sesión del usuario
						
						$codigo = $this->login_model->obtener_codigo_usuario($this->input->post('cedula'));
						$nombre = $this->login_model->obtener_nombre($codigo->usuario_cod);
						$apellido = $this->login_model->obtener_apellido($codigo->usuario_cod);
						
						//Se genera el arreglo con los datos de la sesión
						
						$data =  array (
									'is_logged_in' => true,
									'nombre' => $nombre->nombre,
									'apellido' => $apellido->apellido,
									'usuario_cod' => $codigo->usuario_cod,
									'cedula' => $this->input->post('cedula'),
									'nacionalidad' => $this->login_model->obtener_nacionalidad($codigo->usuario_cod),
									'alumno_cod' => $this->login_model->obtener_codigo_alumno($codigo->usuario_cod),
									'ente' => $this->login_model->obtener_ente($codigo->usuario_cod)
								);
						
						//Se crea la sesión con los datos 
						
						$this->session->set_userdata($data);
						
						//Se redirecciona al módulo de usuarios
						
						redirect('usuarios/');
					}
					else
					{
						//Si la contraseña es erronea se indica que la vista a cargar
						//es la vista de login y se indica el error
						
						$data_content['error'] = 'La contraseña ingresada es incorrecta';
						$this->index($data_content);
					}
				}
				else
				{
					$data_content['error'] = 'La Cédula ingresada no existe en el sistema';
					$this->index($data_content);
				}
			}
			else
			{
				//Si la cédula ingresada no existe registrada en el sistema
				//se busca si lo que ingreso fue el nombre de usuario
				
				if($this->login_model->verificar_usuario($this->input->post('cedula')))
				{
					//Se verifica que la clave dada corresponda con la almacenada
					//en la base de datos
					
					if($this->login_model->verificar_clave('', $this->input->post('cedula'), sha1($this->input->post('clave'))))
					{
						//Si la clave es correcta se obtienen los datos a cargar en la
						//sesión del usuario
						
						$cedula = $this->login_model->obtener_cedula($this->input->post('cedula'));
						$codigo = $this->login_model->obtener_codigo_usuario($cedula->ci);
						$nombre = $this->login_model->obtener_nombre($codigo->usuario_cod);
						$apellido = $this->login_model->obtener_apellido($codigo->usuario_cod);
						
						//Se genera el arreglo con los datos de la sesión
						
						$data =  array (
									'is_logged_in' => true,
									'nombre' => $nombre->nombre,
									'apellido' => $apellido->apellido,
									'usuario_cod' => $codigo->usuario_cod,
									'cedula' => $cedula->ci,
									'nacionalidad' => $this->login_model->obtener_nacionalidad($codigo->usuario_cod),
									'alumno_cod' => $this->login_model->obtener_codigo_alumno($codigo->usuario_cod),
									'ente' => $this->login_model->obtener_ente($codigo->usuario_cod)
								);
						
						//Se crea la sesión con los datos 
						
						$this->session->set_userdata($data);
						
						//Se redirecciona al módulo de usuarios
						
						redirect('usuarios/');
					}
					else
					{
						//Si la contraseña es erronea se indica que la vista a cargar
						//es la vista de login y se indica el error
						
						$data_content['error'] = 'La contraseña ingresada es incorrecta';
						$this->index($data_content);
					}
				}
				else
				{
					$data_content['error'] = 'El nombre de usuario ingresado no existe en el sistema';
					$this->index($data_content);
				}
			}
		}
	}
	
	//Se encarga de validar los datos ingresados por el usuario enviados
	//desde la vista de registro de usuario; y con estos decidir si se
	//crea o no un usuario.
	
	function registro()
	{
		//Carga de la librería para la validación de formularios
		
		$this->load->library('form_validation');
		
		//Definición de mensajes a mostrar para cada una de las reglas
		//de validación utilizadas
		
		$this->form_validation->set_message('required', 'El campo %s es requerido');
		$this->form_validation->set_message('min_length', 'El tamaño del campo %s debe ser de por lo menos 6 caracteres');
		$this->form_validation->set_message('max_length', 'El tamaño del campo %s no debe ser mmayor a 32 caracteres');
		$this->form_validation->set_message('matches', 'Los campos %s y %s deben coincidir');
		$this->form_validation->set_message('valid_email', 'El campo %s debe ser una dirección válida');
		$this->form_validation->set_message('is_natural', 'El campo %s es requerido');
		
		//Definición de las reglas de validación para cada uno de los
		//campos requeridos en el formulario de login
		
		$this->form_validation->set_rules('cedula', 'Cédula', 'trim|required');
		$this->form_validation->set_rules('usuario', 'Nombre de usuario', 'trim|required|min_length[6]|xss_clean');
		$this->form_validation->set_rules('clave', 'Contraseña', 'trim|required|min_length[6]|max_length[32]');
		$this->form_validation->set_rules('clave2', 'Confirmación de contraseña', 'trim|required|matches[clave]');
		$this->form_validation->set_rules('correo', 'Correo Electrónico', 'trim|required|valid_email');
		$this->form_validation->set_rules('pregunta', 'Pregunta secreta', 'required|is_natural');
		$this->form_validation->set_rules('respuesta', 'Respuesta', 'trim|required');
		$this->form_validation->set_rules('codigo', 'Código', 'trim|required');
		
		//Se comprueba si se rompió alguna de las reglas de validación
		
		if($this->form_validation->run() == FALSE)
		{
			//De no cumplir con alguna de las reglas de validación
			//se indica que el contenido principal a mostrar va a ser
			//nuevamente el formulario de registro indicando el error
			
			$this->formulario_registro();
		}
		else
		{	
			//De cumplir con todas las reglas se procede a verificar
			//si los datos ingresados no son repetidos para poder
			//realizar el registro del usuario
			
			//Se carga el modelo donde estan definidas las funciones
			//para el manejo de datos relacionados al inicio de sesión
			//y registro  de usuarios
			
			$this->load->model('login_model');
			
			//Se verifica si la cédula ingresada existe o no en el sistema
			
			if($this->login_model->verificar_cedula($this->input->post('cedula')))
			{
				//Si existe se cumple el primer requisito para poder registrar
				//al usuario. Ahora se procede a verificar si el nombre de
				//usuario indicado es usado por algun otro usuario
				
				//Se verifica si la cedula ya tiene o no una cuenta activa y si
				//el código de verificación ingresado es válido
				
				$estatus = $this->login_model->obtener_estatus_cuenta($this->input->post('cedula'));
				$codigo_verificacion = $this->login_model->validar_codigo_verificacion();
						
				if($estatus->estatus_cuenta != 1 && $codigo_verificacion)
				{
					if($this->login_model->verificar_usuario($this->input->post('usuario')))
					{
						//Si el nombre ya esta siendo usado no se puede realizar
						//el registro y se indica que el contenido principal
						//será nuevamente el formulario de registro indicadon el
						//error encontrado
						
						$data_content['error'] = "El nombre de usuario ingresado ya existe. Intente con otro";
						$this->formulario_registro($data_content);
					}
					else
					{
						//Si el nombre no esta siendo usado por ningún otro usuario es
						//posible realizar el registro del usuario. Para esto de obtiene
						//el código del usuario con el cual esta regitrado en la base de datos
						//a partir de la cédula suministrada
						
						$usuario = $this->login_model->obtener_codigo_usuario($this->input->post('cedula'));
						
						//Se verifica si el correo electrónico suministrado por el usuario en el
						//formulario de registro ya se encuentra registrado como suyo
						
						if($this->login_model->verificar_email($usuario->usuario_cod))
						{
							//De encontarse registrado ya el correo electrónico de procede
							//a realizar el registro de la cuenta en la base de datos
							
							if($this->login_model->crear_usuario())
							{
								//Si la cuenta fue creada de manera exitosa se envía un correo
								//a la dirección de correo suministrada con la información del
								//registro y con un enlace de activación de la misma
								
								if($this->enviar_email($this->input->post('correo')))
								{
									//Luego de enviar el correo se carga la vista de registro
									//satisfactorio, en esta se indica que el registro fue
									//exitoso y que el usuario dede revisar su correo para
									//poder activar la cuenta
									
									$data['contenido_principal'] = $this->load->view('registro_satisfactorio', '', TRUE);
									$this->load->view('front/site_view', $data);
								}
							}
						}
						else
						{
							//Si el correo suministrado no se encuestra registrado en la base
							//de datos, se procede igual a generar el registro de la cuenta
							// y se almacena dicho correo como uno nuevo
							
							if($this->login_model->crear_usuario())
							{
								//Se almacena el correo nuevo luego de crear la nueva cuenta de usuario
								
								$this->login_model->insertar_email($usuario->usuario_cod, $this->input->post('correo'));
								
								//Se envía un correo a la nueva dirección almacenada
								//suministrada con la información del con la información del
								//registro y con un enlace de activación de la misma
								
								if($this->enviar_email($this->input->post('correo')))
								{
									//Luego de enviar el correo se carga la vista de registro
									//satisfactorio, en esta se indica que el registro fue
									//exitoso y que el usuario dede revisar su correo para
									//poder activar la cuenta
									
									$data['contenido_principal'] = $this->load->view('registro_satisfactorio', '', TRUE);
									$this->load->view('front/site_view', $data);
								}
							}
							
						}
					}
				}
				else
				{
					//Si la cédula ingresada ya posee una cuenta activa se indica que
					//la vista a cargar es nuevamente la de registro de usuario
					//indicando el error
					
					$data_content['error'] = "La Cédula ingresada ya se encuentra registrada en el sistema";
					$this->formulario_registro($data_content);
				}
			}
			else
			{
				//Si la cédula no existe no es posible realizar el registro
				//se vuelve a cargar como contenido principal la vista de 
				//registro indicando el error encontrado
				
				$data_content['error'] = "La Cédula ingresada no existe en el sistema";
				$this->formulario_registro($data_content);
			}
		}
	}
	
	//Se encarga de enviar un correo electrónico a un usuario si el registro
	//es satisfactorio
	
	function enviar_email($email)
	{
		//Se carga el modelo mara el manejo de los datos necesarios para el
		//proceso de inicio de sesión y registro de usuarios
		
		$this->load->model('login_model');
		
		//Se carga la librería que se encarga del envío de correos electrónicos
		
		$this->load->library('email');
		
		//Se realiza la apertura del contenido del correo electrónico a enviar
		
		$this->email->set_newline("\r\n");
		
		//Se indica la cuenta remitente del correo a enviar
		
		$this->email->from('notificaciones.socrates@gmail.com');
		
		//Se indica el destinatario el cual se recibe como parámetro de
		//la función
		
		$this->email->to($email);
		$this->email->bcc('gchemello@gmail.com');
		
		//Se indica el título del correo
		
		$this->email->subject('Confirmación de registro a SOCRATES');	
		
		//Se obtiene el código del usuario en la base de datos a partir
		//de la cédula
		
		$usuario = $this->login_model->obtener_codigo_usuario($this->input->post('cedula'));
		
		//Se obtiene el apellido y el nombre del usuario con el código
		//de usuario obtenido
		
		$nombre = $this->login_model->obtener_apellido_nombre($usuario->usuario_cod);
		
		//Se asigna el apellido y el nombre al arreglo para enviarselo a
		//la vista
		
		$data['usuario'] = $nombre->apellido_nombre;
		
		//Se obtiene el código de activación de la cuenta del usuario
		//por medio de su código de usuario en la base de datos
		
		$codigo = $this->login_model->obtener_codigo_activacion($usuario->usuario_cod);
		
		//Se construye la direccion que se le envía al usuario al correo
		//para la activación de su cuenta
		
		$data['direccion'] = "http://nsce.homeip.net/login/activacion/" . $usuario->usuario_cod . "/" . $codigo->codigo_activacion;
		
		//Se insserta el mensaje a enviar al correo, el cual es una vista
		//con los datos de nombre y apellido, y la dirección a la que
		//debe dirigirse el usuario para la activación de su cuenta.
		//Se envía la vista para que el correo llegue como html
		
		$this->email->message($this->load->view('email_confirmacion', $data, TRUE));
		
		//Se verifica que el correo haya sido enviado correctamente
		if($this->email->send())
			return TRUE;
		else
			return FALSE;
	}
	
	//Se encarga de activar la cuenta del usuario a partir del código de
	//usuario en la base de datos y el código de activación
	
	function activacion($usuario, $codigo)
	{
		//Se carga el modelo mara el manejo de los datos necesarios para el
		//proceso de inicio de sesión y registro de usuarios
		
		$this->load->model('login_model');
		
		//Se obtiene el código de activación del usuario
		
		$codigo_obtenido = $this->login_model->obtener_codigo_activacion($usuario);
		
		//Se compara el código obtenido con el pasado por parámetro a la
		//función
		
		if($codigo_obtenido && $codigo_obtenido->codigo_activacion == $codigo)
		{
			//Si el los códigos son iguales se avtiva la cuenta del usuario
			
			if($this->login_model->activar_cuenta($usuario))
			{
				//Se indica que el contenido principal es la vista de activación
				//satisfactoria y se carga
				
				$data['contenido_principal'] = $this->load->view('activacion_satisfactoria', '', TRUE);
				$this->load->view('front/site_view', $data);
			}
			else
			{
				//Si no se puede activar la cuenta, se indica que el contenido
				//principal es la vista de error de activación y se carga
				
				$data['contenido_principal'] = $this->load->view('error_activacion', '', TRUE);
				$this->load->view('front/site_view', $data);
			}
		}
		else
		{
			//Si los códigos son distintos se indica que el contenido principal
			//es la vista de error de activación y se carga
			
			$data['contenido_principal'] = $this->load->view('error_activacion', '', TRUE);
			$this->load->view('front/site_view', $data);
		}
	}
	
	//Cierra la sesión
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect('front/');
	}
	
	//Devuelve el nombre de un país dado un código
	
	function obtener_pais($codigo)
	{
		$this->load->model('login_model');
		return $this->login_model->obtener_pais($codigo);
	}

}