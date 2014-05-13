<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * Modelo para manejar tipos de hospedaje
 * @author Ale
 *
 */
class Tipo_hospedaje_model extends CI_Model
{
	//Nombre de la tabla en la bd
	private $tabla = 'tipo_hospedaje';
	
	/**
	 * Retorna todos los tipos de hospedaje
	 * @author Ale
	 */
	public function get_all()
	{
		return $this->db->get($this->tabla)->result();
	}
	
	/**
	 * Retorna todos los tipos de hospdeaje en modo dropdown
	 * @author Ale
	 */
	public function get_all_dropdown()
	{
		$tipos_hospedaje = $this->db->get($this->tabla)->result();
		$return = array();
		
		foreach ($tipos_hospedaje as $tipo_hospedaje)
		{
			$return[$tipo_hospedaje->id_tipo_hospedaje] = $tipo_hospedaje->descripcion;
		}
		
		return $return;
	}
	
	/**
	 * Agrega un nuevo tipo de hospedaje
	 * @author Ale
	 */
	public function agregar($descripcion)
	{
		$this->db->insert($this->tabla,	array('descripcion' => $descripcion));
		return $this->db->insert_id();
	}
	
	/**
	 * Edita datos de un tipo de hospedaje
	 * @author Ale
	 * @param unknown $descripcion
	 */
	public function editar($id_tipo_hospedaje, $descripcion)
	{
		$this->db->where('id_tipo_hospedaje', $id_tipo_hospedaje);
		$this->db->set('descripcion', $descripcion);
		$this->db->update($this->tabla);
	}
	
	/**
	 * Elimina un tipo de hospedaje de la bd
	 * @param $id_tipo_hospedaje
	 */
	public function eliminar($id_tipo_hospedaje)
	{
		$this->db->where('id_tipo_hospedaje', $id_tipo_hospedaje);
		$this->db->delete($this->tabla);
	}
}

