<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * Modelo de inscripciones en eventos
 * @author Ale
 */
class Inscripcion_model extends CI_Model
{
	private $tabla = 'evento_inscripcion';
	
	/**
	 * Constructor del modelo
	 * @author Ale
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	function delete($id)
	{
		$data['id_estado'] = 3;
		$this->db->where('id_inscripcion',$id);
		return $this->db->update('evento_inscripcion',$data);
	}
	
	/**
	 * Cuenta cantidad de inscritos en un evento
	 * @author Ale
	 * @param $id_evento
	 */
	public function count_all($id_evento)
	{
		$this->db->where('id_evento', $id_evento);
		$this->db->from($this->tabla);
		return $this->db->count_all_results();
	}
	
	/**
	 * Retorna todos los usuarios inscritos para un evento
	 * @author Ale
	 */
	public function get_all($id_evento, $start = '', $limit = '', $order_campo = '', $order_orden = '', $estado = 1)
	{
		if (strlen($start) && strlen($limit))
			$this->db->limit($limit, $start);
		
		if (strlen($order_campo) && strlen($order_orden))
			$this->db->order_by($order_campo.' '.$order_orden);
		
		$this->db->select('	i.*, u.cedula, u.rif, u.nombres, u.apellidos, u.email, u.telefono1, u.telefono2, u.direccion,
							ui.cedula as contacto_cedula, ui.rif as contacto_rif, ui.nombres as contacto_nombres, ui.apellidos as contacto_apellidos, ui.email as contacto_email, ui.telefono1 as contacto_telefono1, ui.telefono2 as contacto_telefono2');
		$this->db->where('i.id_estado', $estado);
		$this->db->where('i.id_evento', $id_evento);
		$this->db->join('usuario_evento ui', 'ui.id_usuario = i.id_usuario_contacto');
		$this->db->join('usuario_evento u', 'u.id_usuario = i.id_usuario');
		return $this->db->get('evento_inscripcion i')->result();
	}
	
	/**
	 * Retorna todos los usuarios que desean hospedarse ademas de la inscripcion
	 * @author Ale
	 * @param $id_evento
	 */
	public function buscar_desean_hospedaje($id_evento, $con_sin_hospedaje = '')
	{
		if ($con_sin_hospedaje == 'sin_hospedaje')
		{
			$this->db->where('id_hospedaje', NULL);
		}
		else if ($con_sin_hospedaje = 'con_hospedaje')
		{
			$this->db->where('id_hospedaje !=', NULL);
		}
		
		$this->db->where('id_evento', $id_evento);
		$this->db->where('id_tipo_hospedaje', $id_tipo_hospedaje);
		$this->db->where('desea_hospedaje', 1);
		$this->db->from($this->tabla);
		return $this->db->count_all_results() > 0;
	}
	
	/**
	 * Verifica si un usuario está inscrito en un evento
	 * @author Ale
	 * @param $id_evento
	 * @param $id_usuario
	 */
	public function existe($id_evento, $id_usuario)
	{
		$this->db->where('id_evento', $id_evento);
		$this->db->where('id_usuario', $id_usuario);
		$this->db->from($this->tabla);
		return $this->db->count_all_results() > 0;
	}
	
	/**
	 * Verifica si un usuario está inscrito en un evento
	 * @param unknown $id_evento
	 * @param unknown $valores
	 */
	public function existe_por_datos_usuario($id_evento, $valores = array())
	{
		if (array_key_exists('cedula', $valores) && ! empty($valores['cedula']))
			$this->db->where('usuario_evento.cedula', $valores['cedula']);
		else if (array_key_exists('rif', $valores) && ! empty($valores['rif']))
			$this->db->where('usuario_evento.rif', $valores['rif']);
		else if (array_key_exists('email', $valores) && ! empty($valores['email']))
			$this->db->where('usuario_evento.email', $valores['email']);
		else
			return FALSE;
		
		$this->db->where('id_evento', $id_evento);
		$this->db->join('usuario_evento', 'usuario_evento.id_usuario = evento_inscripcion.id_usuario');
		$this->db->from($this->tabla);
		return $this->db->count_all_results() > 0;
	}
	
	/**
	 * Almacena datos de inscripción
	 * @param unknown $data
	 */
	public function agregar_inscripcion($data = array())
	{
		$evento = $this->eventos->read($data['id_evento']);
		
		$id_usuario = NULL;
		$inscripciones = array();
		
		//Persona contacto
		if (array_key_exists('id_usuario', $data))
		{
			$usuario_contacto = $this->usuarios->get($data['id_usuario']);
			$id_usuario = $usuario_contacto->id_usuario;
			
			//Actualizar datos de usuario
			$update = array();
			
			if ($data['contacto_email'] != $usuario_contacto->email && $data['contacto_email'] != '')
				$update['email'] = $data['contacto_email'];
			if ($data['contacto_nombres'] != $usuario_contacto->nombres && $data['contacto_nombres'] != '')
				$update['nombres'] = $data['contacto_nombres'];
			if ($data['contacto_apellidos'] != $usuario_contacto->apellidos && $data['contacto_apellidos'] != '')
				$update['apellidos'] = $data['contacto_apellidos'];
			if ($data['contacto_telefono1'] != $usuario_contacto->telefono1 && $data['contacto_telefono1'] != '')
				$update['telefono1'] = $data['contacto_telefono1'];
			if ($data['contacto_telefono2'] != $usuario_contacto->telefono2 && $data['contacto_telefono2'] != '')
				$update['telefono2'] = $data['contacto_telefono2'];
			if ($data['contacto_direccion'] != $usuario_contacto->direccion && $data['contacto_direccion'] != '')
				$update['direccion'] = $data['contacto_direccion'];
			
			if (count($update))
			{
				$this->usuarios->actualizar($id_usuario, $update);
			}
		}
		else
		{
			//Insertar nuevo usuario en la bd
			$id_usuario = $this->usuarios->agregar(array(	'cedula' => ! empty($data['contacto_cedula']) ? $data['contacto_cedula'] : NULL,
															'rif' => ! empty($data['contacto_rif']) ? $data['contacto_rif'] : NULL,
															'email' => ! empty($data['contacto_email']) ? $data['contacto_email'] : NULL,
															'nombres' => $data['contacto_nombres'],
															'apellidos' => $data['contacto_apellidos'],
															'telefono1' => $data['contacto_telefono1'],
															'telefono2' => $data['contacto_telefono2'],
															'direccion' => $data['contacto_direccion']
															));
		}
		
		if ($data['contacto_asiste'] == 'true')
		{
			$inscripciones[] = array(	'id_usuario' => $id_usuario,
										'id_usuario_contacto' => $id_usuario,
										'id_evento' => $evento->id_evento,
										'desea_hospedaje' => $data['contacto_desea_hospedaje'] == 'true',
										'id_hospedaje' => 	$data['contacto_desea_hospedaje'] == 'true' && 
															$data['contacto_id_hospedaje'] != '' && 
															$data['contacto_id_hospedaje'] > 0 ? $data['contacto_id_hospedaje'] : NULL );
		}
		
		//Revisar cada usuario asistente
		$usuarios_asistentes = array();
		for ($i = 1; $i <= $data['total_asistentes']; $i++)
		{
			$usuario_asistente = NULL;
			$id_usuario_asistente = NULL;
			
			//Buscar si el usuario ya existe en la bd
			if ($data['cedula_'.$i] != '')
				$usuario_asistente = $this->usuarios->get_from_cedula($data['cedula_'.$i]);
			else if ($data['rif_'.$i] != '')
				$usuario_asistente = $this->usuarios->get_from_rif($data['rif_'.$i]);
			else
				$usuario_asistente = $this->usuarios->get_from_email($data['email_'.$i]);
			
			//Actualizar datos
			if ( ! empty($usuario_asistente))
			{
				$id_usuario_asistente = $usuario_asistente->id_usuario;
				
				$update = array();
				
				if ($data['email_'.$i] != $usuario_asistente->email && $data['email_'.$i] != '')
					$update['email'] = $data['email_'.$i];
				if ($data['nombres_'.$i] != $usuario_asistente->nombres && $data['nombres_'.$i] != '')
					$update['nombres'] = $data['nombres_'.$i];
				if ($data['apellidos_'.$i] != $usuario_asistente->apellidos && $data['apellidos_'.$i] != '')
					$update['apellidos'] = $data['apellidos_'.$i];
				if ($data['telefono1_'.$i] != $usuario_asistente->telefono1 && $data['telefono1_'.$i] != '')
					$update['telefono1'] = $data['telefono1_'.$i];
				if ($data['telefono2_'.$i] != $usuario_asistente->telefono2 && $data['telefono2_'.$i] != '')
					$update['telefono2'] = $data['telefono2_'.$i];
				if ($data['direccion_'.$i] != $usuario_asistente->direccion && $data['direccion_'.$i] != '')
					$update['direccion'] = $data['direccion_'.$i];
				
				if (count($update))
				{
					$this->usuarios->actualizar($id_usuario_asistente, $update);
				}
			}
			
			//Agregar nuevo usuario
			else
			{
				$id_usuario_asistente = $this->usuarios->agregar(array(	'cedula' => ! empty($data['cedula_'.$i]) ? $data['cedula_'.$i] : NULL,
																		'rif' => ! empty($data['rif_'.$i]) ? $data['rif_'.$i] : NULL,
																		'email' =>  ! empty($data['email_'.$i]) ? $data['email_'.$i] : NULL,
																		'nombres' => $data['nombres_'.$i],
																		'apellidos' => $data['apellidos_'.$i],
																		'telefono1' => $data['telefono1_'.$i],
																		'telefono2' => $data['telefono2_'.$i],
																		'direccion' => $data['direccion_'.$i]
				));
			}
			
			$usuarios_asistentes[] = $id_usuario_asistente;
			$inscripciones[] = array(	'id_evento' => $evento->id_evento,
										'id_usuario' => $id_usuario_asistente,
										'id_usuario_contacto' => $id_usuario,
										'desea_hospedaje' => $data['desea_hospedaje_'.$i] == 'true',
										'id_hospedaje' => 	$data['desea_hospedaje_'.$i] == 'true' &&
															$data['id_hospedaje_'.$i] != '' &&
															$data['id_hospedaje_'.$i] > 0 ? $data['id_hospedaje_'.$i] : NULL	);
		}
		
		//Datos de facturacion
		$modo_factura = $data['modo_factura'];
		$nombre_factura = $data['nombre_factura'];
		
		switch($modo_factura)
		{
			//Una sola factura
			default: case 1:
				
				$id_factura = NULL;
				$monto = $evento->precio_evento*(count($usuarios_asistentes)+($data['contacto_asiste'] == 'true' ? 1 : 0));
				
				switch($nombre_factura)
				{
					//A nombre de empresa
					default: case 1:
						$id_empresa = $this->get_empresa($data);
						$id_factura = $this->facturacion->agregar(array(	'id_empresa' => $id_empresa,
																			'monto' => $monto	));
						
						//Asociar a todos los usuarios con esta empresa
						foreach ($inscripciones as $datos)
						{
							$this->empresas->agregar_usuario_empresa($datos['id_usuario'], $id_empresa);
						}
						if ($data['contacto_asiste'] == 'false')
						{
							$this->empresas->agregar_usuario_empresa($id_usuario, $id_empresa);
						}
						
						break;
					
					//A nombre de persona contacto
					case 2:
						$id_factura = $this->facturacion->agregar(array(	'id_usuario' => $id_usuario,
																			'monto' => $monto	));
				}
				
				//Agregar factura a todas las inscripciones
				foreach ($inscripciones as $index => $datos)
				{
					$inscripciones[$index]['id_factura'] = $id_factura;
				}
				
				break;
				
			//Facturas individuales
			case 2:
				switch ($nombre_factura)
				{
					//A nombre de empresa
					default: case 1:
						$id_empresa = $this->get_empresa($data);
						
						foreach ($inscripciones as $index => $datos)
						{
							$id_factura = $this->facturacion->agregar(array(	'id_empresa' => $id_empresa,
																				'monto' => $evento->precio_evento	));
							$inscripciones[$index]['id_factura'] = $id_factura;
							
							//Asociar esta empresa con todos los usuarios
							$this->empresas->agregar_usuario_empresa($datos['id_usuario'], $id_empresa);
							if ($data['contacto_asiste'] == 'false')
							{
								$this->empresas->agregar_usuario_empresa($id_usuario, $id_empresa);
							}
						}
						
						break;
						
					//A nombre de persona contacto
					case 2:
						foreach ($inscripciones as $index => $datos)
						{
							$id_factura = $this->facturacion->agregar(array(	'id_usuario' => $id_usuario,
																				'monto' => $evento->precio_evento ));
							$inscripciones[$index]['id_factura'] = $id_factura;
						}
						
						break;
						
					//A nombre de cada asistente
					case 3:
						foreach ($inscripciones as $index => $datos)
						{
							$id_factura = $this->facturacion->agregar(array(	'id_usuario' => $inscripciones[$index]['id_usuario'],
																				'monto' => $evento->precio_evento	));
							$inscripciones[$index]['id_factura'] = $id_factura;
						}
				}
		}
		
		//Agregar inscripciones
		foreach ($inscripciones as $datos)
		{
			$this->agregar($datos);
		}
	}
	
	/**
	 * Retorna id de empresa existente o crea empresa nueva
	 * @param unknown $data
	 */
	private function get_empresa($data)
	{
		if ($data['id_empresa'] > 0)
		{
			$id_empresa = $data['id_empresa'];
		}
		else
		{
			$empresa = $this->empresas->get_from_rif($data['empresa_rif']);
			
			if (empty($empresa))
			{
				$id_empresa = $this->empresas->agregar(array(	'rif' => strtoupper($data['empresa_rif']),
																'razon_social' => $data['empresa_razon_social'],
																'email' => $data['empresa_email'],
																'telefono1' => $data['empresa_telefono1'],
																'telefono2' => $data['empresa_telefono2'],
																'direccion' => $data['empresa_direccion']	));
			}
			else
			{
				$id_empresa = $empresa->id_empresa;
			}
		}
		
		return $id_empresa;
	}
	
	/**
	 * Agrega una inscripción en bd
	 * @param unknown $datos
	 */
	public function agregar($datos = array())
	{
		$this->db->insert('evento_inscripcion', $datos);
		return $this->db->insert_id();
	}
}

