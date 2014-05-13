<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * Modelo para manejar disponibilidad de hospedaje en un evento
 * @author Ale
 *
 */
class Disponibilidad_hospedaje_model extends CI_Model
{
	public $tabla = 'evento_disponibilidad_hospedaje';
	
	/**
	 * Retorna tipos de hospedaje disponibles para un evento especifico
	 * @author Ale
	 */
	public function get_all($id_evento, $start = '', $limit = '', $order_campo = 'id_hospedaje', $order_orden = 'desc')
	{
		if (strlen($start) && strlen($limit))
			$this->db->limit($limit, $start);
		
		if (strlen($order_campo) && strlen($order_orden))
			$this->db->order_by($order_campo.' '.$order_orden);
		
		$this->db->select('edh.*, th.*, count(i.id_inscripcion) as asignados, edh.cantidad-(count(i.id_inscripcion)) as disponible');
		$this->db->where('edh.id_evento', $id_evento);
		$this->db->join('tipo_hospedaje th', 'th.id_tipo_hospedaje = edh.id_tipo_hospedaje');
		$this->db->join('evento_inscripcion i', 'i.id_hospedaje = edh.id_hospedaje', 'left');
		$this->db->group_by('edh.id_hospedaje');
		return $this->db->get('evento_disponibilidad_hospedaje edh')->result();
	}
	
	/**
	 * Total opciones de hospedaje para un evento
	 * @param unknown $id_evento
	 */
	public function count_all($id_evento)
	{
		$this->db->where('id_evento', $id_evento);
		$this->db->from($this->tabla);
		return $this->db->count_all_results();
	}
	
	/**
	 * Agregar nuevo tipo hospedaje a un evento específico
	 * @author Ale
	 * @param $valores
	 */
	public function agregar($datos = array())
	{
		$this->db->insert($this->tabla, $datos);
		return $this->db->insert_id();
	}
	
	/**
	 * Actualizar datos de hospedaje
	 * @param unknown $id_hospedaje
	 * @param unknown $datos
	 */
	public function actualizar($id_hospedaje, $datos = array())
	{
		$this->db->where('id_hospedaje', $id_hospedaje);
		$this->db->update($this->tabla, $datos);
	}
	
	/**
	 * Agregar nuevo hospedaje, realizar chequeos
	 * @param unknown $data
	 */
	public function nuevo_hospedaje($data = array())
	{
		$hospedaje = $this->get($data['id_evento'], $data['id_tipo_hospedaje']);
		
		if (empty($hospedaje))
		{
			$this->agregar(array(	'id_evento' => $data['id_evento'],
									'id_tipo_hospedaje' => $data['id_tipo_hospedaje'],
									'cantidad' => $data['cantidad'],
									'precio' => $data['precio']
			));
		}
		else
		{
			$this->actualizar($hospedaje->id_hospedaje, array(	'cantidad' => $data['cantidad'],
																'precio' => $data['precio']		));
		}
	}
	
	/**
	 * Verifica si un evento específico tiene un tipo de hospedaje específico
	 * ya asociado
	 * @author Ale
	 * @param $id_evento
	 * @param $id_tipo_hospedaje
	 */
	public function existe(	$id_evento,
							$id_tipo_hospedaje)
	{
		$this->db->where('id_evento', $id_evento);
		$this->db->where('id_tipo_hospedaje', $id_tipo_hospedaje);
		$this->db->from($this->tabla);
		return $this->db->count_all_results() > 0;
	}

	/**
	 * Retorna disponibilidad de tipo hospedaje para un evento
	 * @author Ale
	 */
	public function get($id_evento,
						$id_tipo_hospedaje)
	{
		$this->db->where('id_evento', $id_evento);
		$this->db->where('id_tipo_hospedaje', $id_tipo_hospedaje);
		return $this->db->get($this->tabla)->first_row();
	}
	
	/**
	 * Retorna hospedaje disponible para un evento
	 * @author Ale
	 */
	public function get_disponible($id_evento)
	{
		$this->db->select("$this->tabla.id_hospedaje, $this->tabla.precio, tipo_hospedaje.*, $this->tabla.cantidad-count(evento_inscripcion.id_inscripcion) as disponible");
		$this->db->where("$this->tabla.id_evento", $id_evento);
		$this->db->having("disponible >", "0", FALSE);
		$this->db->join("tipo_hospedaje", "tipo_hospedaje.id_tipo_hospedaje = $this->tabla.id_tipo_hospedaje");
		$this->db->join("evento_inscripcion", "evento_inscripcion.id_hospedaje = $this->tabla.id_hospedaje", "left");
		$this->db->group_by("$this->tabla.id_hospedaje");
		$result = $this->db->get($this->tabla)->result();
		
		foreach ($result as $i => $value)
		{
			$result[$i]->precio = number_format($result[$i]->precio, 2, ',', '.');
		}
		
		return $result;
	}
	
	/**
	 * Eliminar una opción de hospedaje
	 * @param unknown $id_hospedaje
	 */
	public function eliminar($id_hospedaje)
	{
		$this->db->where('id_hospedaje', $id_hospedaje);
		$this->db->delete($this->tabla);
	}
	
	/**
	 * Retorna numero de asignados a un hospedaje
	 * @param unknown $id_hospedaje
	 */
	public function count_asignados($id_hospedaje)
	{
		$this->db->where('id_hospedaje', $id_hospedaje);
		$this->db->from('evento_inscripcion');
		return $this->db->count_all_results();
	}
}
