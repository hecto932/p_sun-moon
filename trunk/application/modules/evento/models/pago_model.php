<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * Modelo para manejar pagos de facturas
 * @author Ale
 *
 */
class Pago_model extends CI_Model
{
	private $tabla = 'evento_pago';
	
	/**
	 * Agregar pago
	 * @param unknown $datos
	 */
	public function agregar($datos = array())
	{
		$this->db->insert($this->tabla, $datos);
		return $this->db->insert_id();
	}
	
	/**
	 * Eliminar un pago
	 * @param unknown $id_pago
	 */
	public function eliminar($id_pago)
	{
		$this->db->where('id_pago', $id_pago);
		$this->db->delete($this->tabla);
	}
	
	/**
	 * Retorna todos los pagos asociados a un evento
	 * @param unknown $id_evento
	 * @param string $start
	 * @param string $limit
	 * @param string $order_campo
	 * @param string $order_orden
	 */
	public function get_all_by_evento($id_evento, $start = '', $limit = '', $order_campo = 'timestamp', $order_orden = 'desc')
	{
		if (strlen($start) && strlen($limit))
			$this->db->limit($limit, $start);
		
		$this->db->select('ep.*, tp.descripcion as tipo_pago');
		$this->db->join('evento_factura f', 'f.id_factura = ep.id_factura');
		$this->db->join('evento_inscripcion i', 'i.id_factura = f.id_factura');
		$this->db->join('tipo_pago tp', 'tp.id_tipo_pago = f.id_tipo_pago');
		$this->db->where('i.id_evento', $id_evento);
		$this->db->order_by($order_campo.' '.$order_orden);
		return $this->db->get('evento_pago ep')->result();
	}
	
	/**
	 * Retorna todos los pagos asociados a una factura
	 * @param unknown $id_factura
	 * @param string $start
	 * @param string $limit
	 * @param string $order_campo
	 * @param string $order_orden
	 */
	public function get_all_by_factura($id_factura, $start = '', $limit = '', $order_campo = 'timestamp', $order_orden = 'desc')
	{
		if (strlen($start) && strlen($limit))
			$this->db->limit($limit, $start);
		
		$this->db->select('ep.*, tp.descripcion as tipo_pago');
		$this->db->join('tipo_pago tp', 'tp.id_tipo_pago = ep.id_tipo_pago');
		$this->db->where('ep.id_factura', $id_factura);
		$this->db->order_by($order_campo.' '.$order_orden);
		return $this->db->get('evento_pago ep')->result();
	}
	
	/**
	 * Retorna suma de los pagos realizados a una factura
	 * @param unknown $id_factura
	 */
	public function suma_pagos($id_factura)
	{
		$this->db->select('SUM(p.monto) as total');
		$this->db->where('p.id_factura', $id_factura);
		return $this->db->get('evento_pago p')->first_row()->total;
	}
}
