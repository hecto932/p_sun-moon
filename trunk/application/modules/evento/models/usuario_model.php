<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * Modelo para manejar usuarios que asisten a eventos
 * @author Ale
 *
 */
class Usuario_model extends CI_Model
{
	private $tabla = 'usuario_evento';
	
	/**
	 * Retorna todos los usuarios registrados
	 * @author Ale
	 */
	public function get_all($start = '', $limit = '', $order_campo = 'id_usuario', $order_orden = 'desc')
	{
		if (strlen($start) && strlen($limit))
			$this->db->limit($limit, $start);
		
		$this->db->order_by($order_campo.' '.$order_orden);
		return $this->db->get($this->tabla)->result();
	}
	
	/**
	 * Retorna número de registros en la tabla
	 * @author Ale
	 * @return integer
	 */
	public function count_all()
	{
		return $this->db->count_all($this->tabla);
	}
	
	/**
	 * Agrega usuario a la tabla usuario_evento
	 * @param unknown $datos
	 */
	public function agregar($datos = array())
	{
		foreach ($datos as $field => $value)
			if (strlen($value) == 0)
				$datos[$field] = NULL;
		
		$this->db->insert($this->tabla, $datos);
		return $this->db->insert_id();
	}
	
	/**
	 * Actualiza datos de usuario
	 * @param unknown $datos
	 */
	public function actualizar($id_usuario, $datos = array())
	{		
		foreach ($datos as $field => $value)
			if (strlen($value) == 0)
				$datos[$field] = NULL;
		
		$this->db->where('id_usuario', $id_usuario);
		$this->db->update($this->tabla, $datos);
	}
	
	/**
	 * Verifica si existe un usuario
	 * @author Ale
	 * @param unknown $id_usuario
	 */
	public function existe_cedula($cedula, $id_usuario = '')
	{
		if ($id_usuario != '')
			$this->db->where('id_usuario !=', $id_usuario);
			
		$this->db->from($this->tabla);
		$this->db->where('cedula', $cedula);
		return $this->db->count_all_results() > 0;
	}
	
	/**
	 * Verifica si existe un usuario
	 * @author Ale
	 * @param unknown $id_usuario
	 */
	public function existe_rif($rif, $id_usuario = '')
	{
		if ($id_usuario != '')
			$this->db->where('id_usuario !=', $id_usuario);
		
		$this->db->from($this->tabla);
		$this->db->where('rif', $rif);
		return $this->db->count_all_results() > 0;
	}
	
	/**
	 * Verifica si existe un usuario
	 * @author Ale
	 * @param unknown $id_usuario
	 */
	public function existe_email($email, $id_usuario = '')
	{
		if ($id_usuario != '')
			$this->db->where('id_usuario !=', $id_usuario);
		
		$this->db->from($this->tabla);
		$this->db->where('email', $email);
		return $this->db->count_all_results() > 0;
	}
	
	/**
	 * Retorna informacion de un usuario particular
	 * @author Ale
	 * @param unknown $id_usuario
	 */
	public function get($id_usuario)
	{
		$this->db->where('u.id_usuario', $id_usuario);
		return $this->db->get('usuario_evento u')->first_row();
	}
	
	/**
	 * Retorna datos de usuario de una cedula particular
	 * @author Ale
	 * @param unknown $cedula
	 */
	public function get_from_cedula($cedula)
	{
		$this->db->where('u.cedula', $cedula);
		return $this->db->get('usuario_evento u')->first_row();
	}
	
	/**
	 * Retorna datos de usuario de un rif particular
	 * @author Ale
	 * @param $rif
	 */
	public function get_from_rif($rif)
	{
		$this->db->where('u.rif', $rif);
		return $this->db->get('usuario_evento u')->first_row();
	}
	
	/**
	 * Retorna datos de usuario de un email particular
	 * @author Ale
	 * @param $email
	 */
	public function get_from_email($email)
	{
		$this->db->where('u.email', $email);
		return $this->db->get('usuario_evento u')->first_row();
	}
	
	/**
	 * Retorna empresas a las que pertenece un usuario
	 * @author Ale
	 * @param unknown $id_usuario
	 */
	public function get_empresas_from_usuario($id_usuario)
	{
		$this->db->where('evento_empresa_usuario.id_usuario', $id_usuario);
		$this->db->join('evento_empresa', 'evento_empresa.id_empresa = evento_empresa_usuario.id_empresa');
		return $this->db->get('evento_empresa_usuario')->result();
	}
	
	/**
	 * Verifica si un número de teléfono es válido
	 * @param unknown $telefono
	 */
	public function telefono_valido($telefono)
	{
		return ! strlen($telefono) || preg_match("/^0(2|4)[0-9]{2}\-?[0-9]{7}$/", $telefono) == 1;
	}
	
	/**
	 * Eliminar un usuario
	 * @param unknown $id_usuario
	 */
	public function eliminar($id_usuario)
	{
		$this->db->where('id_usuario', $id_usuario);
		$this->db->delete('usuario_evento');
	}
}
