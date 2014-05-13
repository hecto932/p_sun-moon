<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

class Temporada_model extends CI_Model
{
	public function get_all($start = '', $limit = '', $order_campo = 'nombre', $order_orden = 'desc')
	{
		if (strlen($start) && strlen($limit))
			$this->db->limit($limit, $start);
		
		$this->db->join('temporada_fecha', 'temporada_fecha.id_temporada = temporada.id_temporada');
		
		$this->db->order_by($order_campo.' '.$order_orden);
		
		return $this->db->get('temporada')->result();
	}
	
	public function get_temporadas()
	{
		return $this->db->get('temporada')->result();
	}
	
	public function get_temporada($id_temporada_fecha)
	{
		$this->db->join('temporada_fecha', 'temporada_fecha.id_temporada = temporada.id_temporada');
		
		$this->db->where('id_temporada_fecha', $id_temporada_fecha);
		
		return $this->db->get('temporada')->result();
		
	}
	
	public function update_temporada_fecha($data)
	{
		if(!empty($data))
		{
			if(isset($data['id_temporada_fecha']))
			{
				$this->db->where('id_temporada_fecha', $data['id_temporada_fecha']);
				unset($data['id_temporada_fecha']);
				$this->db->update('temporada_fecha', $data);
			}
			else
			{
				$this->db->insert('temporada_fecha', $data);
			}
		}
	}
	
	public function eliminar_temporada($id_temporada_fecha)
	{
		$this->db->where('id_temporada_fecha', $id_temporada_fecha);
		$this->db->delete('temporada_fecha');
	}
	
	public function count_all()
	{
		return $this->db->count_all('temporada');
	}
	
}