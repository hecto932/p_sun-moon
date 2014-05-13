<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * Modelo para manejo de facturas de eventos
 * @author Ale
 *
 */
class Factura_model extends CI_Model
{
	private $tabla = 'evento_factura';
	
	/**
	 * Retorna todos las facturas
	 * @author Ale
	 */
	public function get_all($start = '', $limit = '', $order_campo = '', $order_orden = '')
	{
		if (strlen($start) && strlen($limit))
			$this->db->limit($limit, $start);
		
		if (strlen($order_campo) && strlen($order_orden))
			$this->db->order_by($order_campo.' '.$order_orden);
		
		$this->db->select("	f.*, u.nombres, u.apellidos, u.rif as rif_usuario, u.cedula, u.email, e.razon_social, e.rif as rif_empresa,
							case when e.id_empresa is null then concat(u.nombres,' ',u.apellidos) else e.razon_social end as nombre,
							SUM((case when h.id_hospedaje is null then 0 else h.precio end)+ev.precio_evento) as monto", FALSE);
		$this->db->join('evento_empresa e', 'e.id_empresa = f.id_empresa', 'left');
		$this->db->join('usuario_evento u', 'u.id_usuario = f.id_usuario' ,'left');
		$this->db->join('evento_inscripcion i', 'i.id_factura = f.id_factura');
		$this->db->join('evento ev', 'i.id_evento = ev.id_evento');
		$this->db->join('evento_disponibilidad_hospedaje h', 'h.id_hospedaje = i.id_hospedaje', 'left');
		$this->db->group_by('f.id_factura');
		return $this->db->get('evento_factura f')->result();
	}
	
	/**
	 * Retorna total de facturas guardadas
	 * @author Ale
	 */
	public function count_all()
	{
		return $this->db->count_all('evento_factura');
	}
	
	/**
	 * Retorna datos de factura individual
	 * @param unknown $id_factura
	 */
	public function get($id_factura)
	{
		$this->db->where('f.id_factura', $id_factura);
		$this->db->select("	f.*, u.nombres, u.apellidos, u.rif as rif_usuario, u.cedula, u.email, e.razon_social, e.rif as rif_empresa,
							case when e.id_empresa is null then concat(u.nombres,' ',u.apellidos) else e.razon_social end as nombre,
							SUM((case when h.id_hospedaje is null then 0 else h.precio end)+ev.precio_evento) as monto", FALSE);
		$this->db->join('evento_empresa e', 'e.id_empresa = f.id_empresa', 'left');
		$this->db->join('usuario_evento u', 'u.id_usuario = f.id_usuario', 'left');
		$this->db->join('evento_inscripcion i', 'i.id_factura = f.id_factura');
		$this->db->join('evento ev', 'i.id_evento = ev.id_evento');
		$this->db->join('evento_disponibilidad_hospedaje h', 'h.id_hospedaje = i.id_hospedaje', 'left');
		$this->db->group_by('f.id_factura');
		return $this->db->get('evento_factura f')->first_row();
	}
	
	/**
	 * Agrega una nueva factura en bd
	 * @param unknown $datos
	 */
	public function agregar($datos = array())
	{
		if(isset($datos['monto']) && !empty($datos['monto']))
			unset($datos['monto']);
		
		$this->db->insert('evento_factura', $datos);
		return $this->db->insert_id();
	}
	
	
	
	/**
	 * Actualizar información de factura
	 * @param unknown $id_factura
	 * @param unknown $datos
	 */
	public function actualizar($id_factura, $datos = array())
	{
		$this->db->where('id_factura', $id_factura);
		$this->db->update($this->tabla, $datos);
	}
	
	/**
	 * Retorna todos los modos de facturación
	 * @author Ale
	 */
	public function get_modos_factura()
	{
		return array('1' => 'Factura general', '2' => 'Factura individual');
	}
	
	/**
	 * Retorna las opciones de nombre de factura
	 * @author Ale
	 */
	public function get_nombres_factura($modo = 1)
	{
		switch($modo)
		{
			default: case 1:
				return array('1' => 'Empresa', '2' => 'Persona contacto');
			case 2:
				return array('1' => 'Empresa', '2' => 'Persona contacto', '3' => 'Asistente individual');
		}
	}
	
	/**
	 * Retorna todos los items asociados a una factura
	 * @param unknown $id_factura
	 */
	public function get_inscripciones($id_factura)
	{
		$this->db->where('f.id_factura', $id_factura);
		$this->db->where('d.id_idioma', 1);	//Ojo con esto, se forza el idioma español
		$this->db->select("	e.id_evento, e.precio_evento, d.nombre as evento_nombre, u.nombres, u.apellidos, u.rif, u.email, u.cedula,
							ui.nombres as contacto_nombres, ui.apellidos as contacto_apellidos, ui.rif as contacto_rif, 
							ui.cedula as contacto_cedula, ui.email as contacto_email,
							h.precio as precio_hospedaje, th.descripcion as tipo_hospedaje, (case when h.id_hospedaje is null then 0 else h.precio end)+e.precio_evento as total");
		$this->db->join('evento_inscripcion i', 'i.id_factura = f.id_factura');
		$this->db->join('usuario_evento u', 'u.id_usuario = i.id_usuario');
		$this->db->join('usuario_evento ui', 'ui.id_usuario = i.id_usuario_contacto');
		$this->db->join('evento e', 'e.id_evento = i.id_evento');
		$this->db->join('detalle_evento d', 'd.id_evento = e.id_evento');
		$this->db->join('evento_disponibilidad_hospedaje h', 'h.id_hospedaje = i.id_hospedaje', 'left');
		$this->db->join('tipo_hospedaje th', 'th.id_tipo_hospedaje = h.id_tipo_hospedaje', 'left');
		return $this->db->get('evento_factura f')->result();
	}
	
	/**
	 * Calcular monto total de la factura
	 * @param unknown $id_factura
	 */
	public function monto_factura($id_factura)
	{
		$this->db->where('f.id_factura', $id_factura);
		$this->db->select("SUM(e.precio_evento+(case when h.id_hospedaje is null then 0 else h.precio end)) as monto");
		$this->db->join('evento_inscripcion i', 'i.id_factura = f.id_factura');
		$this->db->join('evento e', 'e.id_evento = i.id_evento');
		$this->db->join('evento_disponibilidad_hospedaje h', 'h.id_hospedaje = i.id_hospedaje', 'left');
		return $this->db->get('evento_factura f')->first_row()->monto;
	}
}