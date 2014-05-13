<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * Modelo para manejar asistencia a eventos
 * @author Ale
 *
 */
class Asistencia_model extends CI_Model
{
	private $tabla = 'evento_asistencia';
	
	/**
	 * Agrega asistente de usuario un dia a un evento
	 * @param unknown $datos
	 */
	public function agregar($datos = array())
	{
		$this->db->insert($this->tabla, $datos);
		return $this->db->insert_id();
	}
	
	/**
	 * Desmarcar asistencia de un usuario a un evento en un dia especifico
	 * @param unknown $id_inscripcion
	 * @param unknown $dia
	 */
	public function eliminar($id_inscripcion, $dia)
	{
		$this->db->where('id_inscripcion', $id_inscripcion);
		$this->db->where('dia', $dia);
		$this->db->delete($this->tabla);
	}
	
	/**
	 * Determina si un usuario asistio a un evento
	 * @param unknown $id_inscripcion
	 * @param unknown $dia
	 */
	public function existe($id_inscripcion, $dia)
	{
		$this->db->where('id_inscripcion', $id_inscripcion);
		$this->db->where('dia', $dia);
		$this->db->from($this->tabla);
		return $this->db->count_all_results() > 0;
	}
	
	/**
	 * Retorna todos los usuarios inscritos para un evento
	 * @author Ale
	 */
	public function get_all_inscripciones($id_evento, $start = '', $limit = '', $order_campo = '', $order_orden = '')
	{
		if (strlen($start) && strlen($limit))
			$this->db->limit($limit, $start);
		
		if (strlen($order_campo) && strlen($order_orden))
			$this->db->order_by($order_campo.' '.$order_orden);
		
		$this->db->select("	i.*, u.cedula, u.rif, u.nombres, u.apellidos, 
							ui.cedula as contacto_cedula, ui.rif as contacto_rif, ui.nombres as contacto_nombres, ui.apellidos as contacto_apellidos,
							group_concat(ea.dia) as dias_asistidos", FALSE);
		$this->db->where('i.id_evento', $id_evento);
		$this->db->where('i.id_estado',1);
		$this->db->join('usuario_evento ui', 'ui.id_usuario = i.id_usuario_contacto');
		$this->db->join('usuario_evento u', 'u.id_usuario = i.id_usuario');
		$this->db->join('evento_asistencia ea', 'ea.id_inscripcion = i.id_inscripcion', 'left');
		$this->db->group_by('i.id_inscripcion');
		return $this->db->get('evento_inscripcion i')->result();
	}
}
