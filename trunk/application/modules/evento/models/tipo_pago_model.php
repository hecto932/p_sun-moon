<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * Modelo para manejar tipos de pago
 * @author Ale
 *
 */
class Tipo_pago_model extends CI_Model
{
	private $tabla = 'tipo_pago';
	
	/**
	 * Retorna todos los tipos de pago disponibles
	 * @author Ale
	 */
	public function get_all()
	{
		return $this->db->get($this->tabla)->result();
	}
	
	/**
	 * Dropdown de opciones de pago
	 * @author Ale
	 */
	public function dropdown_all()
	{
		$result = $this->get_all();
		$opciones = array();
		
		foreach ($result as $tipo_pago)
			$opciones[$tipo_pago->id_tipo_pago] = $tipo_pago->descripcion;
		
		return $opciones;
	}
	
	/**
	 * Retorna todos los tipos de pago asociados a un evento
	 * @param unknown $id_evento
	 */
	public function get_all_by_evento($id_evento)
	{
		$this->db->where('ep.id_evento', $id_evento);
		$this->db->join('tipo_pago tp', 'tp.id_tipo_pago = ep.id_tipo_pago');
		return $this->db->get('rel_evento_pago ep')->result();
	}
	
	/**
	 * Dropdown de opciones de tipos de pago disponibles para un evento
	 * @param unknown $id_evento
	 */
	public function dropdown_all_by_evento($id_evento)
	{
		$result = $this->get_all_by_evento($id_evento);
		$opciones = array();

		foreach ($result as $tipo_pago)
			$opciones[$tipo_pago->id_tipo_pago] = $tipo_pago->descripcion;
		
		return $opciones;
	}
}
