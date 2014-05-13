<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * Modelo para manejar empresas cuyos empleados asisten a eventos
 * @author pwintech
 *
 */
class Empresa_model extends CI_Model
{
	private $tabla = 'evento_empresa';
	
	/**
	 * Retorna todos las empresas registrados
	 * @author Ale
	 */
	public function get_all($start = '', $limit = '', $order_campo = 'id_empresa', $order_orden = 'desc')
	{
		if (strlen($start) && strlen($limit))
			$this->db->limit($limit, $start);
		
		$this->db->order_by($order_campo.' '.$order_orden);
		return $this->db->get($this->tabla)->result();
	}
	
	/**
	 * Retorna total empresas registradas
	 * @author Ale
	 */
	public function count_all()
	{
		return $this->db->count_all($this->tabla);
	}
	
	/**
	 * Agrega empresa a la tabla evento_empresa
	 * @param unknown $datos
	 */
	public function agregar($datos = array())
	{
		foreach ($datos as $field => $value)
			if (empty($value))
				$datos[$field] = NULL;
			
		$this->db->insert($this->tabla, $datos);
		return $this->db->insert_id();
	}
	
	/**
	 * Actualizar información de empresa
	 * @param unknown $datos
	 */
	public function actualizar($id_empresa, $datos = array())
	{
		foreach ($datos as $field => $value)
		if (empty($value))
			$datos[$field] = NULL;
		
		$this->db->where('id_empresa', $id_empresa);
		$this->db->update($this->tabla, $datos);
	}
	
	/**
	 * Verifica si existe una empresa
	 * @author Ale
	 * @param unknown $rif
	 */
	public function existe_rif($rif, $id_empresa = '')
	{
		if ($id_empresa != '')
			$this->db->where('id_empresa !=', $id_empresa);
			
		$this->db->from($this->tabla);
		$this->db->where('rif', $rif);
		return $this->db->count_all_results() > 0;
	}
	
	/**
	 * Verifica si existe una empresa
	 * @author Ale
	 * @param unknown $email
	 */
	public function existe_email($email, $id_empresa = '')
	{
		if ($id_empresa != '')
			$this->db->where('id_empresa !=', $id_empresa);
		
		$this->db->from($this->tabla);
		$this->db->where('email', $email);
		return $this->db->count_all_results() > 0;
	}
	
	/**
	 * Retorna informacion de una empresa particular
	 * @author Ale
	 * @param unknown $id_empresa
	 */
	public function get($id_empresa)
	{
		$this->db->where('id_empresa', $id_empresa);
		return $this->db->get($this->tabla)->first_row();
	}
	
	/**
	 * Retorna informacion de una empresa particular
	 * @author Ale
	 * @param unknown $rif
	 */
	public function get_from_rif($rif)
	{
		$this->db->where('rif', $rif);
		return $this->db->get($this->tabla)->first_row();
	}
	
	/**
     * Retorna todos los usuarios que pertenecen a una empresa
     * @author Ale
	 */
	public function get_usuarios_from_empresa($id_empresa)
	{
		$this->db->where('evento_empresa_usuario.id_empresa', $id_empresa);
		//$this->db->join('evento_empresa', 'evento_empresa.id_empresa = evento_empresa_usuario.id_empresa');
		$this->db->join('usuario_evento', 'usuario_evento.id_usuario = evento_empresa_usuario.id_usuario');
		return $this->db->get('evento_empresa_usuario')->result();
	}
	
	/**
	 * Agrega un usuario a una empresa
	 * @param unknown $id_usuario
	 * @param unknown $id_empresa
	 */
	public function agregar_usuario_empresa($id_usuario, $id_empresa)
	{
		$this->db->where('id_usuario', $id_usuario);
		$this->db->where('id_empresa', $id_empresa);
		$this->db->from('evento_empresa_usuario');
		
		if ($this->db->count_all_results() == 0)
		{
			$this->db->insert('evento_empresa_usuario', array('id_usuario' => $id_usuario, 'id_empresa' => $id_empresa));
		}
	}
	
	/**
	 * Elimina una empresa
	 * @param unknown $id_empresa
	 */
	public function eliminar($id_empresa)
	{
		$this->db->where('id_empresa', $id_empresa);
		$this->db->delete('evento_empresa');
	}
}