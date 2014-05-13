<?php

/**********************************************************************
 * Modelo para el manejo de datos
 * 
 * Se manejan los datos para el proceso de login y registro de usuarios
 */

class Login_model extends CI_Model {
	
	function __construc()
	{
		parent::__construc();
	}

	//Obtiene las preguntas secretas de la tablas de preguntas
	
	function obtener_preguntas()
	{
		$query = $this->db->get('pregunta_secreta');
		
		if($query->num_rows != 0)
			return $query->result();
	}
	
	//Verifica si una cédula dada se encuentra registrada en la base de
	//datos
	
	function verificar_cedula($cedula)
	{
		$this->db->where('ci',$cedula);
		$query = $this->db->get('usuario');
		
		if($query->num_rows() == 1)
			return TRUE;
		else
			return FALSE;
	}
	
	//Verifica si un nombre de usuario dado se encuentra registrado en
	//la base de datos
	
	function verificar_usuario($nombre)
	{
		$this->db->where('login',$nombre);
		$query = $this->db->get('usuario');
		
		if($query->num_rows() == 1)
			return TRUE;
		else
			return FALSE;
	}
	
	//Verifica si un correo electrónico dado se encuentra registrado en
	//la base de datos
	
	function verificar_email($usuario)
	{
		$this->db->where('usuario_cod', $usuario);
		$query = $this->db->get('email');
		
		if($query->num_rows() != 0)
			return TRUE;
		else
			return FALSE;
	}
	
	//Verifica si una contraseña de un usuario dado es coorrecta
	
	function verificar_clave($cedula='', $usuario='', $clave)
	{
		$this->db->select('password');
		
		//Verifica si se recibió como parámetro la cédula o el nombre de usuario
		//para saber bajo que criterio se hara la busqueda
		
		if($cedula != '')
			$this->db->where('ci',$cedula);
		else
			$this->db->where('login',$usuario);
		
		$query = $this->db->get('usuario');
		
		if($query->num_rows() != 0)
		{
			$clave_obtenida = $query->row();
			
			//Verifica si la clave dada es igual a la almacenada en la
			//base de datos
			
			if($clave == $clave_obtenida->password)
				return TRUE;
			else
				return FALSE;
		}
		else
			return FALSE;
	}
	
	//Obtiene el código de un usuario en la base de datos a partir de la
	//cédula
	
	function obtener_codigo_usuario($cedula)
	{
		$this->db->select('usuario_cod');
		$this->db->where('ci', $cedula);
		$query = $this->db->get('usuario');
		
		if($query->num_rows() != 0)
			return $query->row();
		else
			return FALSE;
	}
	
	//verifica si el código de verificación de un usuario dado es válido
	
	function validar_codigo_verificacion()
	{
		$this->db->select('codigo_verificacion');
		$this->db->where('ci',$this->input->post('cedula'));
		$query = $this->db->get('usuario');
		
		if($query->num_rows() != 0)
		{
			$result = $query->row();
			
			if($result->codigo_verificacion == $this->input->post('codigo'))
				return TRUE;
			else
				return FALSE;
		}
		else
			return FALSE;
	}
	
	//Ingresa en la tabla usuario los valores de la cuenta correspondiente
	//al registro de un nuevo usuario a al sistema
	
	function crear_usuario()
	{
		//Genera el arreglo con los valores a insertar
		
		$update_data = array (
							'login' => $this->input->post('usuario'),
							'password' => sha1($this->input->post('clave')),
							'respuesta_secreta' => $this->input->post('respuesta'),
							'pregunta_secreta_cod' => $this->input->post('pregunta'),
							'codigo_activacion' => sha1($this->generar_codigo())
						);
		
		//Indica la cédula a buscar correspondiente al usuario que se
		//registra
		
		$this->db->where('ci',$this->input->post('cedula'));
		
		//Ingresa los nuevos valores
		
		return $this->db->update('usuario', $update_data);
	}
	
	//Ingresa una dirección de correo electrónico dada a la tabla email
	
	function insertar_email($usuario, $email)
	{
		//Se obtiene la fecha del momento en que se realiza el registro
		
		$fecha = date('Y-m-d');
		
		//Se genera el arreglo con los datos a insertar
		
		$insert_data = array (
							'usuario_cod' => $usuario,
							'direccion' => $email,
							'fecha_registro' => $fecha
						);
		
		//Se insertan los nuevos valores
		
		return $this->db->insert('email', $insert_data);
	}
	
	//Obtiene el código de un alumno a partir de su código de usuario
	
	function obtener_codigo_alumno($codigo)
	{
		$this->db->select('alumno_cod');
		$this->db->where('usuario_cod', $codigo);
		$query = $this->db->get('alumno');
		
		if($query->num_rows() != 0)
		{
			$result = $query->row();
			
			return $result->alumno_cod;
		}
		else
			return FALSE;
	}
	
	//Genera un código aleatorea para ser asignado a un usuario como
	//código de activación
	
	function generar_codigo()
	{
		//Se insertan en el arreglo todos los posibles caracteres que puede
		//contener el código a generar
		
		$str[0] = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $str[1]="abcdefghijklmnopqrstuvwxyz";
        $str[2]="1234567890";
        $str[3]="_+()*?-@!$%#";
		
        //Se inicializa el código y el arreglo que indica si un caracter
        //fue usado
        
        $codigo = '';
        $used=array();
        
        //Se inicia un ciclo de 10 repeticiones para la generación del código
        
		for($i=0 ; $i<10 ; $i++)
		{
			$a=$i;
            
            if (!in_array($a,$used))
                $used[]=$a;
            if (count($used)>4)
                $a= rand(0,3);

            //Se genera un numero aleatorio
            
            $pos=rand(0,strlen($str[$a])-1);
   			
            //Se agrega al código un caracter del arreglo de caracteres
            
			$codigo .= $str[$a][$pos];
		}

		return $codigo;
    }
    
    //Obtiene el apellido y el nombre de un usuario dado
    
    function obtener_apellido_nombre($usuario)
    {
    	$this->db->select('apellido_nombre');
		$this->db->where('usuario_cod', $usuario);
		$query = $this->db->get('usuario');
		
		if($query->num_rows() != 0)
			return $query->row();
		else
			return FALSE;
    }
    
    //Obtiene el nombre de un usuario dado
    
    function obtener_nombre($usuario)
    {
    	$this->db->select('nombre');
    	$this->db->where('usuario_cod', $usuario);
    	$query = $this->db->get('usuario');
    	
    	if($query->num_rows() != 0)
    		return $query->row();
    	else
    		return FALSE;
    }
    
    //Obtienne el apelido de un usuario dado
    
    function obtener_apellido($usuario)
    {
    	$this->db->select('apellido');
    	$this->db->where('usuario_cod', $usuario);
    	$query = $this->db->get('usuario');
    	
    	if($query->num_rows() != 0)
    		return $query->row();
    	else
    	return FALSE;
    }
    
    //Obtiene el o los ente a los cual pertenece un usuario dado
    
    function obtener_ente($usuario)
    {
    	$this->db->select('ente.tipo_ente_cod, tipo_ente.descripcion');
    	$this->db->join('tipo_ente','ente.tipo_ente_cod=tipo_ente.tipo_ente_cod','left');
    	$this->db->where('usuario_cod', $usuario);
    	$query = $this->db->get('ente');
    	
    	if($query->num_rows() != 0)
    	{
    		$result = $query->result();
    		
    		foreach($result as $ente)
    		{
    			$tipo_ente[$ente->tipo_ente_cod] = $ente->descripcion;
    		}
    		
    		return $tipo_ente;
    	}
    	else
    		return FALSE;
    }

    
    //Obtiene el código de activación de un usuario dado
    
	function obtener_codigo_activacion($usuario)
    {
    	$this->db->select('codigo_activacion');
		$this->db->where('usuario_cod', $usuario);
		$query = $this->db->get('usuario');
		
		if($query->num_rows() != 0)
			return $query->row();
		else
			return FALSE;
    }
    
    //Activa la cuenta de un usuario dado, para dicha activación se coloca
    //el código de activación en nulo y el estatus de la cuenta en 1 (activo)
    
    function activar_cuenta($usuario)
    {
    	//Se genera el arreglo con los nuevos valores
    	
    	$update_data = array(
    					'codigo_activacion' => NULL,
    					'codigo_verificacion' => NULL,
    					'estatus_cuenta' => 1
    				);
    	
    	//Se define el usuario al cual se le va a activar la cuenta
    	
    	$this->db->where('usuario_cod', $usuario);
    	
    	return $this->db->update('usuario', $update_data);
    }
    
    //Obtiene el estatus de una cuenta a partir de una cédula dada
    
    function obtener_estatus_cuenta($cedula)
    {
    	$this->db->select('estatus_cuenta');
    	$this->db->where('ci', $cedula);
    	$query = $this->db->get('usuario');
    	
    	if($query->num_rows != 0)
    		return $query->row();
    	else
    		return FALSE;
    }
	

    //Obtiene la cédula de un usuario dado un nombre de usuario
    
    function obtener_cedula($nombre)
    {
    	$this->db->select('ci');
    	$this->db->where('login', $nombre);
    	$query = $this->db->get('usuario');
    	
    	if($query->num_rows() != 0)
    		return $query->row();
    	else
    		return FALSE;
    }
    
    //Obtiene la nacionalidad de un usuario
    
    function obtener_nacionalidad($codigo)
    {
    	$this->db->select('ci_nacionalidad');
    	$this->db->where('usuario_cod',$codigo);
    	$query = $this->db->get('usuario');
    	
    	if($query->num_rows() != 0)
    	{
    		$result = $query->row();
    		return $result->ci_nacionalidad;
    	}
    	else
    		return FALSE;
    }
    
    //Obtiene el nombre de un país dado su código
    
    function obtener_pais($codigo)
    {
    	$this->db->select('nombre');
    	$this->db->where('pais_cod', $codigo);
    	$query = $this->db->get('pais');
    	
    	if($query->num_rows() != 0)
    	{
    		$result = $query->row();
    		
    		return $result->nombre;
    	}
    	else
    		return false;
    }
}


?>