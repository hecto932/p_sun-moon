<?php

class reserva_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('idioma/idioma_model','idioma_model');
		$this->idioma=idioma_model::get_from_code($this->session->userdata('idioma'));
	}
	
	function get_formas_pago()
	{
		return $this->db->get("tipo_forma_pago")->result();
	}
	
	function get_paises()
	{
		return $this->db->get("pais")->result();
	}
	
	function get_forma_pago($id_forma_pago)
	{
		$this->db->select("descripcion");
		$query = $this->db->get_where('tipo_forma_pago', array('id_tipo_forma_pago' => $id_forma_pago));
		return $query->row()->descripcion;
	}
	
	function get_reservas_usuario($id_usuario)
	{
		$this->db->order_by("creado", "desc");
		$query = $this->db->get_where('reservacion', array('id_usuario_front' => $id_usuario));
		return $query->result();
	}
	
	function get_estado_reservacion($id_estado_reservacion)
	{
		$this->db->select("descripcion");
		$query = $this->db->get_where('estado_reservacion', array('id_estado_reservacion' => $id_estado_reservacion));
		return $query->row()->descripcion;
	}
	
	function get_detalle_reservacion($codigo_reserva)
	{
		$query = $this->db->get_where('reservacion', array('codigo_reserva' => $codigo_reserva));
		return $query->row();
	}

	function get_id_reservacion($codigo_reserva)
	{
		$this->db->select("id_reservacion");
		$query = $this->db->get_where('reservacion', array('codigo_reserva' => $codigo_reserva));
		return $query->row()->id_reservacion;
	}
	
	function get_codigo_reservacion($id_reservacion)
	{
		$this->db->select("codigo_reserva");
		$query = $this->db->get_where('reservacion', array('id_reservacion' => $id_reservacion));
		return $query->row()->codigo_reserva;
	}
	
	function insertar_reservacion_tipo_habitacion($data)
	{
		$reservacion_tipo_habitacion = array(	
			'id_reservacion'		=> $data['id_reservacion'],
			'peticion'				=> $data['peticion'],
			'id_tipo_habitacion'	=> $data['id_tipo_habitacion']													
		);
		
		$this->db->insert('reservacion_tipo_habitacion', $reservacion_tipo_habitacion);
	}
	
	function get_id_reservacion_tipo_habitacion($id_reservacion)
	{
		$this->db->select("id_reservacion_tipo_habitacion");
		$query = $this->db->get_where('reservacion_tipo_habitacion', array('id_reservacion' => $id_reservacion));
		return $query->row()->id_reservacion_tipo_habitacion;
	}
	
	function insertar_huesped($data)
	{
		$huesped = array(	
			'tratamiento'						=> $data['tratamiento'],
			'nombre'							=> $data['nombre'],
			'id_reservacion_tipo_habitacion'	=> $data['id_reservacion_tipo_habitacion']
		);
		
		$this->db->insert('huesped', $huesped);
	}
	
	function existe_codigo_reservacion($codigo_reserva)
	{
		$this->db->select("codigo_reserva");
		$query = $this->db->get_where('reservacion', array('codigo_reserva' => $codigo_reserva));
		//return $query->row()->codigo_reserva;
		return $query->row()->codigo_reserva== $codigo_reserva;
	}

	function update_reservacion_tipo_habitacion($data)
	{
		$data_update = array(
			"peticion"	=> $data['peticion']
		);
		$this->db->update('reservacion_tipo_habitacion', $data_update, array('id_reservacion_tipo_habitacion' => $data['id_reservacion_tipo_habitacion']));
	}
	
	function update_huesped($data)
	{
		$data_update = array(
			"nombre"	=>	$data['nombre']
		);
		
		$this->db->update('huesped', $data_update, array('id_huesped' => $data['id_huesped']));
	}
	
	//OJO
	function cancel_reserva($id_reservacion)
	{	
		$data_update = array(
			"id_estado_reservacion"	=>	"1"
		);
		
		$this->db->update('reservacion', $data_update, array('id_reservacion' => $id_reservacion));
	}
	
	//OJO
	function update_reservacion($data)
	{
		$data_update = array(
			"checkin"	=> $data['checkin'],
			"checkout"	=> $data['checkout']
		);
		
		$this->db->update('reservacion', $data_update, array('id_reservacion' => $data['id_reservacion']));
	}
	
	function agregar_pago($data)
	{
		$this->db->insert('pago', $data);
	}
	
	function get_moneda($id_moneda)
	{
		$this->db->select("abreviado");
		$query = $this->db->get_where('moneda', array('id_moneda' => $id_moneda));
		return $query->row()->abreviado;
	}
	
	/*
	function get_disponibles_fecha_deprecado($id_idioma, $id_temporada, $fecha_in, $fecha_out)
	{
		//Fecha in: pasar de dd-mm-aaaa H:i:s a aaaa-mm-aa H:i:s 
		list($d, $m, $anio_hora) 	= explode('-', $fecha_in);
		list($a, $hora)				= explode(' ', $anio_hora);
		$fecha_in					= implode('-', array($a, $m, $d));
		$fecha_in					.= ' ' . $hora;
		
		//Fecha out: pasar de dd-mm-aaaa H:i:s a aaaa-mm-aa H:i:s 
		list($d, $m, $anio_hora) 	= explode('-', $fecha_out);
		list($a, $hora)				= explode(' ', $anio_hora);
		$fecha_out					= implode('-', array($a, $m, $d));
		$fecha_out					.= ' ' . $hora;
		
		$query =
		"
			SELECT t.*, c.valor as costo, m.nombre as moneda
			FROM
			(
				SELECT h.id_habitacion, h.id_tipo_habitacion, h.nombre as nombre_habitacion, h.id_estado as estado_habitacion, r.*,
				d.nombre as tipo_habitacion, d.id_idioma as idioma_tipo, hh.id_idioma as idioma_hab, hh.descripcion_breve
				
				FROM habitacion h
				JOIN detalle_tipo_habitacion d ON h.id_tipo_habitacion = d.id_tipo_habitacion
				JOIN detalle_habitacion hh ON hh.id_habitacion = h.id_habitacion
				
				LEFT JOIN reservacion_habitacion rh ON rh.id_habitacion = h.id_habitacion
				LEFT JOIN reservacion r ON r.id_reservacion = rh.id_reservacion
				
				WHERE h.id_estado = 1 AND
				
				      (EXISTS(SELECT 1 FROM detalle_tipo_habitacion d WHERE d.id_tipo_habitacion = h.id_tipo_habitacion AND d.id_idioma = ".$this->db->escape($id_idioma).")
				      OR EXISTS(SELECT 1 FROM detalle_tipo_habitacion d WHERE d.id_tipo_habitacion = h.id_tipo_habitacion ) ) AND
				
				      (EXISTS(SELECT 1 FROM detalle_habitacion hh WHERE hh.id_habitacion = h.id_habitacion AND hh.id_idioma = ".$this->db->escape($id_idioma).")
				      OR EXISTS(SELECT 1 FROM detalle_habitacion hh WHERE hh.id_habitacion = h.id_habitacion ) )
				 
				GROUP BY d.id_tipo_habitacion
			) t
			
			LEFT JOIN costo c ON c.id_tipo_habitacion = t.id_tipo_habitacion AND c.id_temporada = ".$this->db->escape($id_temporada)."
			LEFT JOIN moneda m ON m.id_moneda = c.id_moneda 
			
			WHERE NOT ( t.checkout < ".$this->db->escape($fecha_in)." OR t.checkin > ".$this->db->escape($fecha_out)." ) OR t.checkin IS NULL
		";
	}*/
	
	function get_temporada_actual()
	{
		$this->db->join('temporada t', 't.id_temporada = tf.id_temporada');
		$query = $this->db->get('temporada_fecha tf')->result();

		$actual = mktime(0, 0, 0, date('m'), date('d'), 0);

		$id_temporada = '';

		foreach($query as $temporada)
		{
			list($a, $m, $d) = explode('-', $temporada->inicio);
			$start = mktime(0, 0, 0, $m, $d, 0);

			list($a, $m, $d) = explode('-', $temporada->fin);
			$end = mktime(0, 0, 0, $m, $d, 0);

			if($actual >= $start && $actual <= $end)
			{
				$id_temporada = $temporada->id_temporada;
			}
		}
		
		if($id_temporada == '') $id_temporada = 1;

		return $id_temporada;
	}
	
	/*
	 * Obtener HABITACIONES disponibles
	 * 
	 * */
	/*
	function get_disponibles_fecha($id_idioma, $id_temporada, $fecha_in, $fecha_out)
	{
		//Fecha in: pasar de dd-mm-aaaa H:i:s a aaaa-mm-aa H:i:s 
		list($d, $m, $anio_hora) 	= explode('-', $fecha_in);
		list($a, $hora)				= explode(' ', $anio_hora);
		$fecha_in					= implode('-', array($a, $m, $d));
		$fecha_in					.= ' ' . $hora;
		
		//Fecha out: pasar de dd-mm-aaaa H:i:s a aaaa-mm-aa H:i:s 
		list($d, $m, $anio_hora) 	= explode('-', $fecha_out);
		list($a, $hora)				= explode(' ', $anio_hora);
		$fecha_out					= implode('-', array($a, $m, $d));
		$fecha_out					.= ' ' . $hora;
		
		$query =
		"
		SELECT h.id_habitacion, h.codigo as codigo, h.id_tipo_habitacion,
		hh.descripcion_breve as habitacion_descrip, hh.id_idioma as hab_idioma,
		tt.nombre as tipo, th.personas, tt.id_idioma as tipo_idioma, c.valor, m.nombre as moneda,
		rr.checkin, rr.checkout, s.descripcion as estado_reservacion, ac.descripcion as activo,
		mul.fichero
		
		FROM habitacion h
		
		LEFT JOIN detalle_habitacion hh ON hh.id_habitacion = h.id_habitacion AND hh.id_idioma = ".$this->db->escape($id_idioma)."
		LEFT JOIN tipo_habitacion th ON th.id_tipo_habitacion = h.id_tipo_habitacion
		LEFT JOIN detalle_tipo_habitacion tt ON tt.id_tipo_habitacion = h.id_tipo_habitacion AND tt.id_idioma = ".$this->db->escape($id_idioma)."
		LEFT JOIN costo c ON c.id_detalle_tipo_habitacion = tt.id_detalle_tipo_habitacion AND c.id_temporada = ".$this->db->escape($id_temporada)."
		LEFT JOIN moneda m ON m.id_moneda = c.id_moneda
		
		LEFT JOIN reservacion_habitacion rh ON rh.id_habitacion = h.id_habitacion
		LEFT JOIN reservacion rr ON rr.id_reservacion = rh.id_reservacion
		LEFT JOIN estado_reservacion s ON s.id_estado_reservacion = rr.id_estado_reservacion
		LEFT JOIN estado_activo ac ON ac.id_estado_activo = rr.id_estado_activo
		
		LEFT JOIN rel_habitacion_multimedia mu ON mu.id_habitacion = h.id_habitacion
		LEFT JOIN multimedia mul ON mul.id_multimedia = mu.id_multimedia AND mul.destacado = 1
		
		WHERE h.id_habitacion NOT IN
		(
		    SELECT h.id_habitacion
		    FROM habitacion h
		    LEFT JOIN reservacion_habitacion rh ON rh.id_habitacion = h.id_habitacion
		    LEFT JOIN reservacion rr ON rr.id_reservacion = rh.id_reservacion
		    WHERE NOT ( rr.checkout < ".$this->db->escape($fecha_in)." OR rr.checkin > ".$this->db->escape($fecha_out)." )
		    AND h.id_estado = 1
		)
		";
		
		return $this->db->query($query)->result();
	}*/
	
	/*
	 * Obtener habitaciones disponibles por tipo de habitacion
	 * 
	 * */
	function get_disponibles_tipo_habitacion_deprecado($id_idioma, $id_temporada, $fecha_in, $fecha_out)
	{
		$query = 
		"
		SELECT th.id_tipo_habitacion, tt.descripcion_breve as tipo_descrip, tt.nombre as tipo, th.personas, tt.id_idioma as tipo_idioma,
		c.valor, m.nombre as moneda, m.abreviado as moneda_abreviado, count(*) as habitaciones
				
		FROM tipo_habitacion th
		
		LEFT JOIN detalle_tipo_habitacion tt ON tt.id_tipo_habitacion = th.id_tipo_habitacion AND tt.id_idioma = ".$this->db->escape($id_idioma)."
		LEFT JOIN habitacion h ON h.id_tipo_habitacion = th.id_tipo_habitacion
		
		LEFT JOIN costo c ON c.id_detalle_tipo_habitacion = tt.id_detalle_tipo_habitacion AND c.id_temporada = ".$this->db->escape($id_temporada)."
		LEFT JOIN moneda m ON m.id_moneda = c.id_moneda
				
		LEFT JOIN reservacion_habitacion rh ON rh.id_habitacion = h.id_habitacion
		LEFT JOIN reservacion rr ON rr.id_reservacion = rh.id_reservacion
		
		WHERE h.id_habitacion NOT IN
		(
		    SELECT h.id_habitacion
			FROM habitacion h
			LEFT JOIN reservacion_habitacion rh ON rh.id_habitacion = h.id_habitacion
			LEFT JOIN reservacion rr ON rr.id_reservacion = rh.id_reservacion
			WHERE (NOT ( rr.checkout < ".$this->db->escape($fecha_in)." OR rr.checkin > ".$this->db->escape($fecha_out)." ))
			AND h.id_estado = 1
		)
		
		GROUP BY th.id_tipo_habitacion
		";
		
		return $this->db->query($query)->result();
	}
	
	/*
	 * Obtener habitaciones disponibles por tipo de habitacion
	 * 
	 * */
	function get_disponibles_tipo_habitacion($id_idioma, $id_temporada, $fecha_in, $fecha_out)
	{
		/*
		$query = 
		"
		SELECT t.*, (t.total_habitaciones - t.reservadas) as habitaciones
		FROM
		(
			SELECT th.*, CASE WHEN tr.reservadas IS NULL THEN 0 ELSE tr.reservadas END as reservadas
			FROM
			(
				SELECT th.id_tipo_habitacion, tt.descripcion_breve as tipo_descrip, tt.nombre as tipo, th.personas, tt.id_idioma as tipo_idioma,
				c.valor, m.nombre as moneda, m.abreviado as moneda_abreviado, count(h.id_habitacion) as total_habitaciones
				
				FROM tipo_habitacion th
				LEFT JOIN detalle_tipo_habitacion tt ON tt.id_tipo_habitacion = th.id_tipo_habitacion AND tt.id_idioma = ".$this->db->escape($id_idioma)."
				LEFT JOIN costo c ON c.id_detalle_tipo_habitacion = tt.id_detalle_tipo_habitacion AND c.id_temporada = ".$this->db->escape($id_temporada)."
				LEFT JOIN moneda m ON m.id_moneda = c.id_moneda
				JOIN habitacion h ON h.id_tipo_habitacion = th.id_tipo_habitacion
				
				WHERE th.id_estado = 1
				GROUP BY th.id_tipo_habitacion
				
			) th
			LEFT JOIN
			(
				SELECT rr.id_tipo_habitacion, count(rr.id_tipo_habitacion) as reservadas
				FROM reservacion r
				LEFT JOIN reservacion_tipo_habitacion rr ON rr.id_reservacion = r.id_reservacion
				
				WHERE r.checkin >= ".$this->db->escape($fecha_in)." AND r.checkout <= ".$this->db->escape($fecha_out)." AND r.id_estado_reservacion IN (2,3,4)
				GROUP BY rr.id_tipo_habitacion
				
			) tr ON tr.id_tipo_habitacion = th.id_tipo_habitacion
		) t
		";*/
		
		$query =
		"
		SELECT t.*, (t.total_habitaciones - t.reservadas) as habitaciones
		FROM
		(
			SELECT th.*, CASE WHEN tr.reservadas IS NULL THEN 0 ELSE tr.reservadas END as reservadas
			FROM
			(
				SELECT th.id_tipo_habitacion, tt.descripcion_breve as tipo_descrip, tt.nombre as tipo, th.personas, tt.id_idioma as tipo_idioma,
				c.valor, m.nombre as moneda, m.abreviado as moneda_abreviado, count(h.id_habitacion) as total_habitaciones
						
				FROM tipo_habitacion th
				LEFT JOIN detalle_tipo_habitacion tt ON tt.id_tipo_habitacion = th.id_tipo_habitacion AND tt.id_idioma = ".$this->db->escape($id_idioma)."
				LEFT JOIN costo c ON c.id_detalle_tipo_habitacion = tt.id_detalle_tipo_habitacion AND c.id_temporada = ".$this->db->escape($id_temporada)."
				LEFT JOIN moneda m ON m.id_moneda = c.id_moneda
				JOIN habitacion h ON h.id_tipo_habitacion = th.id_tipo_habitacion
						
				WHERE th.id_estado = 1
				GROUP BY th.id_tipo_habitacion
						
			) th
			LEFT JOIN
			(
		                SELECT rr.id_tipo_habitacion, count(*) as reservadas 
		                FROM reservacion r 
		                JOIN reservacion_tipo_habitacion rr ON rr.id_reservacion = r.id_reservacion
		                WHERE NOT ( DATE(r.checkout) <= ".$this->db->escape($fecha_in)." OR DATE(r.checkin) >= ".$this->db->escape($fecha_out)." )
		                GROUP BY rr.id_tipo_habitacion
		
			) tr ON tr.id_tipo_habitacion = th.id_tipo_habitacion
		) t		
		";
		
		return $this->db->query($query)->result();
	}
	
	function get_huesped_reserva($id_idioma,$id_reserva,$id_temporada)
	{
		$query = 
		"
		SELECT rth.id_reservacion, h.tratamiento, h.nombre as huesped, dth.descripcion_breve,
		dth.nombre as tipo, m.abreviado as denominacion,c.valor, rth.peticion, th.personas,
		rth.id_reservacion_tipo_habitacion, th.id_tipo_habitacion, h.id_huesped
		FROM reservacion_tipo_habitacion rth
		JOIN huesped h ON rth.id_reservacion_tipo_habitacion = h.id_reservacion_tipo_habitacion
		JOIN tipo_habitacion th ON rth.id_tipo_habitacion = th.id_tipo_habitacion
		JOIN detalle_tipo_habitacion dth ON dth.id_tipo_habitacion = th.id_tipo_habitacion AND dth.id_idioma = ".$this->db->escape($id_idioma)."
		JOIN costo c ON c.id_detalle_tipo_habitacion = dth.id_detalle_tipo_habitacion AND c.id_temporada = ".$this->db->escape($id_temporada)."
		JOIN moneda m ON c.id_moneda = m.id_moneda
		WHERE rth.id_reservacion =".$this->db->escape($id_reserva)." 
		";
		
		return $this->db->query($query)->result();
	}
	
	/*
	SELECT rth.id_reservacion,h.tratamiento,h.nombre,dth.descripcion_breve,dth.nombre,c.valor,c.id_moneda
	FROM reservacion_tipo_habitacion rth
	JOIN huesped h ON rth.id_reservacion_tipo_habitacion = h.id_reservacion_tipo_habitacion
	JOIN tipo_habitacion th ON rth.id_tipo_habitacion = th.id_tipo_habitacion
	JOIN detalle_tipo_habitacion dth ON dth.id_tipo_habitacion = th.id_tipo_habitacion
	JOIN costo c ON c.id_detalle_tipo_habitacion = dth.id_detalle_tipo_habitacion
	JOIN moneda m ON c.id_moneda = m.id_moneda
	WHERE rth.id_reservacion ='59'*/
	
	/*
	 * Obtener huspedes por tipo de habitacion
	 * segun una reservacion especificada
	 * 
	 * Asignacion habitacion backend
	 * 
	 * */
	function get_reservacion_huespedes($id_reservacion, $id_idioma)
	{
		$query =
		"
		SELECT rr.*, tt.nombre as tipo_habitacion, hu.*
		FROM reservacion r
		JOIN reservacion_tipo_habitacion rr ON rr.id_reservacion = r.id_reservacion
		JOIN detalle_tipo_habitacion tt ON tt.id_tipo_habitacion = rr.id_tipo_habitacion
		JOIN idioma i ON i.id_idioma = tt.id_idioma
		JOIN huesped hu ON hu.id_reservacion_tipo_habitacion = rr.id_reservacion_tipo_habitacion
		WHERE r.id_reservacion = ".$this->db->escape($id_reservacion)." AND i.idioma = ".$this->db->escape($id_idioma)."
		";		
		return $this->db->query($query)->result();
	}
	
	/*
	 * Obtener huspedes por tipo de habitacion
	 * segun una reservacion especificada
	 * segun un tipo de habitacion especifica
	 * 
	 * Asignacion de habitacion backend
	 * 
	 * */
	function get_reserva_tipo_habitacion($id_tipo_habitacion, $id_reservacion, $id_idioma)
	{
		$query = 
		"
		SELECT r.*, rr.*, tt.nombre as tipo_habitacion, hu.*
		FROM reservacion r
		JOIN reservacion_tipo_habitacion rr ON rr.id_reservacion = r.id_reservacion
		JOIN detalle_tipo_habitacion tt ON tt.id_tipo_habitacion = rr.id_tipo_habitacion
		JOIN idioma i ON i.id_idioma = tt.id_idioma
		JOIN huesped hu ON hu.id_reservacion_tipo_habitacion = rr.id_reservacion_tipo_habitacion
		WHERE r.id_reservacion = ".$this->db->escape($id_reservacion)." AND i.idioma = ".$this->db->escape($id_idioma)."
		AND rr.id_tipo_habitacion = ".$this->db->escape($id_tipo_habitacion)."
		GROUP BY rr.id_reservacion_tipo_habitacion
		";
		return $this->db->query($query)->result();
	}
	
	/*
	 * Habitaciones disponibles para asignacion de habitacion backend
	 * 
	 * */
	function get_habitaciones_disponibles($id_tipo_habitacion, $checkin, $checkout)
	{
		$query = 
		"
		SELECT * 
		FROM tipo_habitacion th
		JOIN habitacion h ON h.id_tipo_habitacion = th.id_tipo_habitacion
		
		WHERE th.id_estado = 1 AND th.id_tipo_habitacion = ".$this->db->escape($id_tipo_habitacion)." AND h.id_habitacion NOT IN
		(
		   SELECT ha.id_habitacion
		   FROM habitacion ha
		   JOIN asignacion_habitacion a ON a.id_habitacion = ha.id_habitacion
		   JOIN reservacion_tipo_habitacion rr ON rr.id_reservacion_tipo_habitacion = a.id_reservacion_tipo_habitacion
		   JOIN reservacion r ON r.id_reservacion = rr.id_reservacion
		   WHERE (NOT ( DATE(r.checkout) <= ".$this->db->escape($checkin)." OR DATE(r.checkin) >= ".$this->db->escape($checkout)." ))
		)
		";
		return $this->db->query($query)->result();
	}
	
	/*
	 * Para asignacion de habitacion backend
	 * 
	 * */
	function get_habitacion_reservacion($id_reservacion_tipo_habitacion)
	{
		$this->db->where('a.id_reservacion_tipo_habitacion', $id_reservacion_tipo_habitacion);
		$this->db->join('habitacion h', 'h.id_habitacion = a.id_habitacion');
		return $this->db->get('asignacion_habitacion a')->result();
	}
	
	function insertar_asignacion($data_post)
	{
		foreach($data_post as $key => $id_habitacion)
		{
			list($texto, $id_reservacion_tipo_habitacion) = explode('_', $key);
			
			//Verificar si ya tiene una habitacion asignada
			$result = $this->get_habitacion_reservacion($id_reservacion_tipo_habitacion);
			
			//Si ya tiene una habitacion asignada
			if(!empty($result))
			{
				//Eliminar esta asignacion para realizar la nueva
				$this->db->where('id_reservacion_tipo_habitacion', $id_reservacion_tipo_habitacion);
				$this->db->delete('asignacion_habitacion');
			}
			
			$data_insert = array(	'id_habitacion' => $id_habitacion,
									'id_reservacion_tipo_habitacion' => $id_reservacion_tipo_habitacion);
			
			$this->db->insert('asignacion_habitacion', $data_insert);
		}
	}
	
	/*
	 * fecha_in					ckeckin						timestamp dd-mm-aaaa H:i:s
	 * fecha_out				ckeckout					timestamp dd-mm-aaaa H:i:s
	 * 
	 * $id_reservacion_actual	En caso de edicion, pasar el id de la reservacion que se esta editando
	 * 
	 * */
	function ajax_get_disponibles_fecha($fecha_in, $fecha_out, $id_reservacion_actual = '')
	{
		//Fecha in: pasar de dd-mm-aaaa H:i:s a aaaa-mm-aa H:i:s 
		list($d, $m, $anio_hora) 	= explode('-', $fecha_in);
		list($a, $hora)				= explode(' ', $anio_hora);
		$fecha_in					= implode('-', array($a, $m, $d));
		$fecha_in					.= ' ' . $hora;
		
		//Fecha out: pasar de dd-mm-aaaa H:i:s a aaaa-mm-aa H:i:s 
		list($d, $m, $anio_hora) 	= explode('-', $fecha_out);
		list($a, $hora)				= explode(' ', $anio_hora);
		$fecha_out					= implode('-', array($a, $m, $d));
		$fecha_out					.= ' ' . $hora;
		
		$reserva_actual = '';
		if(strlen($id_reservacion_actual) > 0)
		{
			$reserva_actual = "rr.id_reservacion != ".$this->db->escape($id_reservacion_actual)." AND ";
		}
		
		$query =
		"
		SELECT h.id_habitacion, h.codigo as codigo
		FROM habitacion h
		
		WHERE h.id_habitacion NOT IN
		(
		    SELECT h.id_habitacion
		    FROM habitacion h
		    LEFT JOIN reservacion_habitacion rh ON rh.id_habitacion = h.id_habitacion
		    LEFT JOIN reservacion rr ON rr.id_reservacion = rh.id_reservacion
		    WHERE ".$reserva_actual." NOT ( rr.checkout < ".$this->db->escape($fecha_in)." OR rr.checkin > ".$this->db->escape($fecha_out)." )
		    AND h.id_estado = 1
		)
		";
		//OR rr.checkin IS NULL AND (rr.id_estado_reservacion == 1 OR rr.id_estado_reservacion IS NULL)
		
		return $this->db->query($query)->result();
	}
	
	//OJO
	function reservar_habitacion($data)
	{
		$reservar = array(	
							'codigo_reserva'		=> $data['codigo_reserva'],
							'personas'				=> $data['personas'],
							'aerolinea'				=> $data['aerolinea'],
							'checkin' 				=> $data['checkin'],
							'checkout'				=> $data['checkout'],
							'creado'				=> date('Y-m-d H:i:s'),
							'id_estado_reservacion'	=> $data['id_estado_reservacion'],
							'id_estado_activo'		=> $data['id_estado_activo'],
							'id_tipo_forma_pago'	=> $data['id_tipo_forma_pago'],
							'precio'				=> $data['precio'],
							'id_usuario_front'		=> $data['id_usuario_front'],
							'observaciones'			=> $data['observaciones']
							
							
		);
		$this->db->insert('reservacion', $reservar);
	}
	
	/*===================================================== BACKEND ==========================================================*/
	
	function get_page($start = 0, $count = 10, $order_field = 'r.id_reservacion', $order_dir = 'desc', $terminos_busqueda = array())
	{
		switch ($order_field)
		{
			case 'id_reservacion';
				$order_field = 'r.id_reservacion';
			break;
			case 'codigo';
				$order_field = 'h.codigo';
			break;
			case 'creado';
				$order_field = 'r.creado';
			break;
			case 'checkin';
				$order_field = 'r.checkin';
			break;
			case 'checkout';
				$order_field = 'r.checkout';
			break;
			case 'estado_reservacion';
				$order_field = 's.descripcion';
			break;
			case 'activo';
				$order_field = 'ac.descripcion';
			break;
			
			default :
				$order_field = $order_field;
			break;
		}
		
		//$this->db->select('r.*, h.codigo, s.descripcion as estado_reservacion, ac.descripcion as activo');
		$this->db->select('r.*, s.descripcion as estado_reservacion, ac.descripcion as activo, u.nombre as cliente');

		//$this->db->join('reservacion_habitacion rh', 'rh.id_reservacion = r.id_reservacion', 'left');
		//$this->db->join('habitacion h', 'h.id_habitacion = rh.id_habitacion', 'left');
		$this->db->join('estado_reservacion s', 's.id_estado_reservacion = r.id_estado_reservacion', 'left');
		$this->db->join('estado_activo ac', 'ac.id_estado_activo = r.id_estado_activo', 'left');
		$this->db->join('usuario_front u', 'u.id_usuario = r.id_usuario_front', 'left');

		if (!empty($terminos_busqueda))
		{
			foreach($terminos_busqueda as $field=>$value)
			{
				if ($field == 'id_reservacion' && $value != '')
				{
                    $this->db->where('r.id_reservacion', $value, 'both');
				}
				if ($field == 'id_estado_reservacion' && $value != '')
				{
                    $this->db->where('r.id_estado_reservacion', $value);
				}
				if ($field == 'id_estado_activo' && $value != '')
				{
                    $this->db->where('r.id_estado_activo', $value);
				}
				if ($field == 'cliente' && $value != '')
				{
                    $this->db->like('u.nombre', $value, 'both');
				}
				if ($field == 'checkin' && $value != '')
				{
					list($d, $m, $a) = explode('-', $value);
					$fecha1 = implode('-', array($a, $m, $d));
                    $this->db->where('DATE(r.checkin) >=', $fecha1);
				}
				if ($field == 'checkout' && $value != '')
				{
					list($d, $m, $a) = explode('-', $value);
					$fecha2 = implode('-', array($a, $m, $d));
                    $this->db->where('DATE(r.checkout) <=', $fecha2);
				}
			}
		}
		
		//$this->db->group_by('r.id_reservacion');
		
		$this->db->order_by($order_field, $order_dir);
		
		$q = $this->db->get('reservacion r', $count, $start);
		
		return $q->result();
	}
	
	function count_all($terminos_busqueda = array())
	{
		$this->db->select('count(*) as num_reservaciones');

		//$this->db->join('reservacion_habitacion rh', 'rh.id_reservacion = r.id_reservacion', 'left');
		//$this->db->join('habitacion h', 'h.id_habitacion = rh.id_habitacion', 'left');
		$this->db->join('estado_reservacion s', 's.id_estado_reservacion = r.id_estado_reservacion', 'left');
		$this->db->join('estado_activo ac', 'ac.id_estado_activo = r.id_estado_activo', 'left');
		$this->db->join('usuario_front u', 'u.id_usuario = r.id_usuario_front', 'left');
		
		if (!empty($terminos_busqueda))
		{
			foreach($terminos_busqueda as $field=>$value)
			{
				if ($field == 'id_reservacion' && $value != '')
				{
                    $this->db->where('r.id_reservacion', $value, 'both');
				}
				if ($field == 'id_estado_reservacion' && $value != '')
				{
                    $this->db->where('r.id_estado_reservacion', $value);
				}
				if ($field == 'id_estado_activo' && $value != '')
				{
                    $this->db->where('r.id_estado_activo', $value);
				}
				if ($field == 'cliente' && $value != '')
				{
                    $this->db->like('u.nombre', $value, 'both');
				}
				if ($field == 'checkin' && $value != '')
				{
					list($d, $m, $a) = explode('-', $value);
					$fecha1 = implode('-', array($a, $m, $d));
                    $this->db->where('DATE(r.checkin) >=', $fecha1);
				}
				if ($field == 'checkout' && $value != '')
				{
					list($d, $m, $a) = explode('-', $value);
					$fecha2 = implode('-', array($a, $m, $d));
                    $this->db->where('DATE(r.checkout) <=', $fecha2);
				}
			}
		}
		
		//$this->db->group_by('r.id_reservacion');
		$q = $this->db->get('reservacion r');
		$ret = $q->row();
		return $ret->num_reservaciones;
	}
	
	function count_asignaciones($terminos_busqueda = array())
	{
		$this->db->select('count(*) as num_reservaciones');
		$this->db->join('estado_reservacion s', 's.id_estado_reservacion = r.id_estado_reservacion', 'left');
		$this->db->join('estado_activo ac', 'ac.id_estado_activo = r.id_estado_activo', 'left');
		$this->db->join('usuario_front u', 'u.id_usuario = r.id_usuario_front', 'left');
		
		$this->db->where('r.id_estado_reservacion !=', 1);
		$this->db->where('r.id_estado_reservacion !=', 2);
		
		$q = $this->db->get('reservacion r');
		$ret = $q->row();
		return $ret->num_reservaciones;
	}
	
	function get_asignaciones($start = 0, $count = 10, $order_field = 'r.id_reservacion', $order_dir = 'desc', $terminos_busqueda = array())
	{
		switch ($order_field)
		{
			case 'id_reservacion';
				$order_field = 'r.id_reservacion';
			break;
			case 'codigo';
				$order_field = 'h.codigo';
			break;
			case 'creado';
				$order_field = 'r.creado';
			break;
			case 'checkin';
				$order_field = 'r.checkin';
			break;
			case 'checkout';
				$order_field = 'r.checkout';
			break;
			case 'estado_reservacion';
				$order_field = 's.descripcion';
			break;
			case 'activo';
				$order_field = 'ac.descripcion';
			break;
			
			default :
				$order_field = $order_field;
			break;
		}
		
		$this->db->select('r.*, s.descripcion as estado_reservacion, ac.descripcion as activo, u.nombre as cliente');
		$this->db->join('estado_reservacion s', 's.id_estado_reservacion = r.id_estado_reservacion', 'left');
		$this->db->join('estado_activo ac', 'ac.id_estado_activo = r.id_estado_activo', 'left');
		$this->db->join('usuario_front u', 'u.id_usuario = r.id_usuario_front', 'left');
		
		$this->db->where('r.id_estado_reservacion !=', 1);
		$this->db->where('r.id_estado_reservacion !=', 2);
		
		$this->db->order_by($order_field, $order_dir);
		
		$q = $this->db->get('reservacion r', $count, $start);
		
		return $q->result();
	}
	
	function read($id, $id_detalle_reservacion = '', $idioma = '')
	{
		/*
		$this->db->select(' r.*, h.id_habitacion, h.codigo as habitacion, s.descripcion as estado_reservacion, ac.descripcion as activo,
							p.descripcion as forma_pago, ps.descripcion as pais, u.*');*/
		
		//$this->db->join('reservacion_habitacion rh', 'rh.id_reservacion = r.id_reservacion', 'left');
		//$this->db->join('habitacion h', 'h.id_habitacion = rh.id_habitacion', 'left');
		
		$id_temporada = $this->get_temporada_actual();
		
		$this->db->select(' r.*, s.descripcion as estado_reservacion, ac.descripcion as activo,
							p.descripcion as forma_pago, ps.descripcion as pais, u.*,
							group_concat(tt.nombre SEPARATOR ", ") as reservadas, m.abreviado as moneda', FALSE);
		
		$this->db->join('estado_reservacion s', 's.id_estado_reservacion = r.id_estado_reservacion', 'left');
		$this->db->join('estado_activo ac', 'ac.id_estado_activo = r.id_estado_activo', 'left');
		$this->db->join('tipo_forma_pago p', 'p.id_tipo_forma_pago = r.id_tipo_forma_pago', 'left');
		$this->db->join('usuario_front u', 'u.id_usuario = r.id_usuario_front', 'left');
		$this->db->join('pais ps', 'ps.id_pais = u.id_pais', 'left');
		
		$this->db->join('reservacion_tipo_habitacion hh', 'hh.id_reservacion = r.id_reservacion');
		$this->db->join('detalle_tipo_habitacion tt', 'tt.id_tipo_habitacion = hh.id_tipo_habitacion AND tt.id_idioma = 1');
		
		$this->db->join('costo c', 'c.id_detalle_tipo_habitacion = tt.id_detalle_tipo_habitacion AND c.id_temporada = '.$id_temporada);
		$this->db->join('moneda m', 'm.id_moneda = c.id_moneda');
		
		$this->db->group_by('r.id_reservacion');
		
		$this->db->where('r.id_reservacion', $id);
		
		$q = $this->db->get('reservacion r');
		
		return $q->result();
	}
	
	//OJO
	function update($data)
	{
		if (isset($data['id_reservacion']))
		{
			$temp = $this->read($data['id_reservacion']);
		}
		if (!empty($temp))
		{
			$this->db->where('id_reservacion',$data['id_reservacion']);
			$this->db->update('reservacion', $data);
			$id = $data['id_reservacion'];
		}
		else
		{
			/*
			$this->db->insert('reservacion',$data);
			$id = $this->db->insert_id(); */
		}

		return $id;
	}
	
	function update_reserva_habitacion($id_reservacion, $habitaciones)
	{
		if(!empty($habitaciones) && !empty($id_reservacion))
		{
			//Borrar actuales
			$this->db->where('id_reservacion', $id_reservacion);
			$this->db->delete('reservacion_habitacion');
			
			foreach($habitaciones as $id_habitacion)
			{
				$data_insert = array(	'id_reservacion' 	=> $id_reservacion,
										'id_habitacion' 	=> $id_habitacion);
				
				$this->db->insert('reservacion_habitacion', $data_insert);
			}
		}
	}
	
	/*====================================================== RESUMEN =====================================================*/
	
	function count_huespedes_resumen($filtro_fecha = '' )
	{
		$where = '';
		if(!empty($filtro_fecha)) $where = "WHERE r.checkin <= ".$this->db->escape($filtro_fecha)." AND r.checkout >=".$this->db->escape($filtro_fecha);
		
		$query = "
		SELECT r.*, s.descripcion as estado_reservacion, ac.descripcion as activo, p.descripcion as forma_pago, ps.descripcion as pais, u.*,
		group_concat(h.codigo SEPARATOR ', ') as habitaciones
		
		FROM (reservacion r)
		JOIN reservacion_tipo_habitacion rr ON rr.id_reservacion = r.id_reservacion
		JOIN asignacion_habitacion aa ON aa.id_reservacion_tipo_habitacion = rr.id_reservacion_tipo_habitacion
		JOIN habitacion h ON h.id_habitacion = aa.id_habitacion
		LEFT JOIN estado_reservacion s ON s.id_estado_reservacion = r.id_estado_reservacion
		LEFT JOIN estado_activo ac ON ac.id_estado_activo = r.id_estado_activo
		LEFT JOIN tipo_forma_pago p ON p.id_tipo_forma_pago = r.id_tipo_forma_pago
		LEFT JOIN usuario_front u ON u.id_usuario = r.id_usuario_front
		LEFT JOIN pais ps ON ps.id_pais = u.id_pais
		".$where."
		GROUP BY r.id_reservacion ";
		
		return $this->db->query($query)->num_rows();
	}
	
	function get_huespedes_resumen($filtro_fecha = '', $start = 0, $count = 10, $order_field = 'r.checkout', $order_dir = 'asc')
	{
		$where = '';
		if(!empty($filtro_fecha)) $where = "WHERE r.checkin <= ".$this->db->escape($filtro_fecha)." AND r.checkout >=".$this->db->escape($filtro_fecha);
		
		$query = "
		SELECT r.*, s.descripcion as estado_reservacion, ac.descripcion as activo, p.descripcion as forma_pago, ps.descripcion as pais, u.*,
		group_concat(h.codigo SEPARATOR ', ') as habitaciones
		
		FROM (reservacion r)
		JOIN reservacion_tipo_habitacion rr ON rr.id_reservacion = r.id_reservacion
		JOIN asignacion_habitacion aa ON aa.id_reservacion_tipo_habitacion = rr.id_reservacion_tipo_habitacion
		JOIN habitacion h ON h.id_habitacion = aa.id_habitacion
		LEFT JOIN estado_reservacion s ON s.id_estado_reservacion = r.id_estado_reservacion
		LEFT JOIN estado_activo ac ON ac.id_estado_activo = r.id_estado_activo
		LEFT JOIN tipo_forma_pago p ON p.id_tipo_forma_pago = r.id_tipo_forma_pago
		LEFT JOIN usuario_front u ON u.id_usuario = r.id_usuario_front
		LEFT JOIN pais ps ON ps.id_pais = u.id_pais
		".$where."
		GROUP BY r.id_reservacion
		ORDER BY ".$order_field." ".$order_dir."
		LIMIT ".$start.", ".$count;
		
		return $this->db->query($query)->result();
	}
	
	function get_reservaciones_resumen($filtro_fecha = '', $id_estado_reservacion = 3, $start = 0, $count = 10, $order_field = 'r.checkin', $order_dir = 'asc')
	{
		$where = '';
		if(!empty($filtro_fecha))
		{
			$fecha_end 		= date('Y-m-d', strtotime($filtro_fecha . ' + 1 week'));
			$fecha_begin 	= date('Y-m-d', strtotime($filtro_fecha . ' - 1 week'));
			$where_fecha	= " AND ( DATE(r.checkin) BETWEEN ".$this->db->escape($fecha_begin)." AND ".$this->db->escape($fecha_end).") ";
		}
		
		$query = "
		SELECT r.*, s.descripcion as estado_reservacion, ac.descripcion as activo, p.descripcion as forma_pago, ps.descripcion as pais, u.*,
		group_concat(LPAD(tt.nombre, 5, '') SEPARATOR ', ') as habitaciones
		
		FROM reservacion r
		JOIN reservacion_tipo_habitacion rr ON rr.id_reservacion = r.id_reservacion
		JOIN detalle_tipo_habitacion tt ON tt.id_tipo_habitacion = rr.id_tipo_habitacion AND tt.id_idioma = 1
		LEFT OUTER JOIN asignacion_habitacion aa ON aa.id_reservacion_tipo_habitacion = rr.id_reservacion_tipo_habitacion
				
		LEFT JOIN estado_reservacion s ON s.id_estado_reservacion = r.id_estado_reservacion
		LEFT JOIN estado_activo ac ON ac.id_estado_activo = r.id_estado_activo
		LEFT JOIN tipo_forma_pago p ON p.id_tipo_forma_pago = r.id_tipo_forma_pago
		LEFT JOIN usuario_front u ON u.id_usuario = r.id_usuario_front
		LEFT JOIN pais ps ON ps.id_pais = u.id_pais
		
		WHERE r.id_estado_reservacion = ".$this->db->escape($id_estado_reservacion)." AND aa.id_reservacion_tipo_habitacion IS NULL ".$where_fecha."
		GROUP BY r.id_reservacion
		ORDER BY ".$order_field." ".$order_dir."
		LIMIT ".$start.", ".$count;
		
		return $this->db->query($query)->result();
	}
	
	function get_pendiente_resumen($filtro_fecha = '', $id_estado_reservacion = 2, $start = 0, $count = 10, $order_field = 'r.checkout', $order_dir = 'asc')
	{
		$where = '';
		if(!empty($filtro_fecha))
		{
			$fecha_end 		= date('Y-m-d', strtotime($filtro_fecha . ' + 1 week'));
			$fecha_begin 	= date('Y-m-d', strtotime($filtro_fecha . ' - 1 week'));
			$where_fecha	= " AND ( DATE(r.checkin) BETWEEN ".$this->db->escape($fecha_begin)." AND ".$this->db->escape($fecha_end).") ";
		}
		
		$query = "
		SELECT r.*, s.descripcion as estado_reservacion, ac.descripcion as activo, p.descripcion as forma_pago, ps.descripcion as pais, u.*,
		group_concat(LPAD(tt.nombre, 5, '') SEPARATOR ', ') as habitaciones
		
		FROM reservacion r
		JOIN reservacion_tipo_habitacion rr ON rr.id_reservacion = r.id_reservacion
		JOIN detalle_tipo_habitacion tt ON tt.id_tipo_habitacion = rr.id_tipo_habitacion AND tt.id_idioma = 1
		
		LEFT JOIN estado_reservacion s ON s.id_estado_reservacion = r.id_estado_reservacion
		LEFT JOIN estado_activo ac ON ac.id_estado_activo = r.id_estado_activo
		LEFT JOIN tipo_forma_pago p ON p.id_tipo_forma_pago = r.id_tipo_forma_pago
		LEFT JOIN usuario_front u ON u.id_usuario = r.id_usuario_front
		LEFT JOIN pais ps ON ps.id_pais = u.id_pais
		
		WHERE r.id_estado_reservacion = ".$this->db->escape($id_estado_reservacion) . $where_fecha . " 
		GROUP BY r.id_reservacion
		ORDER BY ".$order_field." ".$order_dir."
		LIMIT ".$start.", ".$count;
		
		return $this->db->query($query)->result();
	}
	
	function get_habitaciones_ocupadas($fecha)
	{
		$query = 
		"
		SELECT rr.*, DATE(rr.checkin) as checkin, DATE(rr.checkout) as checkout, h.*, tt.nombre as tipo
		FROM habitacion h
		LEFT JOIN detalle_tipo_habitacion tt ON tt.id_tipo_habitacion = h.id_tipo_habitacion AND tt.id_idioma = 1
		LEFT JOIN (	SELECT r.*, a.*, u.*
        			FROM reservacion r
        			JOIN reservacion_tipo_habitacion t ON t.id_reservacion = r.id_reservacion
        			JOIN asignacion_habitacion a ON a.id_reservacion_tipo_habitacion = t.id_reservacion_tipo_habitacion
        			 JOIN usuario_front u ON u.id_usuario = r.id_usuario_front
       				WHERE DATE(r.checkin) <= ".$this->db->escape($fecha)." AND DATE(r.checkout) >= ".$this->db->escape($fecha).") rr ON rr.id_habitacion = h.id_habitacion
       	ORDER BY h.codigo
		";
		return $this->db->query($query)->result();
	}
	
	function get_proxima_ocupacion($id_habitacion, $fecha)
	{
		$query =
		"
		SELECT *, DATE(r.checkin) as checkin, MIN(r.checkin)
		FROM habitacion h
		JOIN asignacion_habitacion a ON a.id_habitacion = h.id_habitacion
		JOIN reservacion_tipo_habitacion rr ON rr.id_reservacion_tipo_habitacion = a.id_reservacion_tipo_habitacion
		JOIN reservacion r ON r.id_reservacion = rr.id_reservacion
		WHERE h.id_habitacion = ".$this->db->escape($id_habitacion)." AND DATE(r.checkin) >= ".$this->db->escape($fecha)."
		";
		$result = $this->db->query($query)->first_row();
		
		$begin 		= new DateTime($fecha);
		$end 		= new DateTime($result->checkin);
		$end 		= $end->modify('+1 day'); //Se suma un dia para que tome en cuenta la fecha $end dentro del periodo
		
		$interval 	= new DateInterval('P1D');
		$daterange 	= new DatePeriod($begin, $interval ,$end, DatePeriod::EXCLUDE_START_DATE);
		
		$rango 		= array();
		
		foreach($daterange as $date)
		{
		    $rango[$date->format("Y-m-d")] = $date->format("d-m-Y");
		}
		
		return $rango;
	}
	
	/*======================================================= RESERVAR ==========================================================*/
	
	function insert_reserva($data, $tabla)
	{
		//pre($data);
		$this->db->insert($tabla, $data);
		return $this->db->insert_id();
	}

	/*======================================================= PAGOS ==========================================================*/
	
	/*
	 * Pagos
	 * 
	 * */
	function get_listado_pagos($start = 0, $count = 10, $order_field = 'p.id_pago', $order_dir = 'desc')
	{
		switch ($order_field)
		{
			case 'id_pago';
				$order_field = 'p.id_pago';
			break;
			case 'codigo';
				$order_field = 'r.codigo';
			break;
			case 'cliente';
				$order_field = 'u.nombre';
			break;
			case 'fecha_pago';
				$order_field = 'p.fecha_pago';
			break;
			case 'monto';
				$order_field = 'p.monto';
			break;
			case 'total_pagar';
				$order_field = 'r.precio';
			break;
			case 'forma_pago';
				$order_field = 'f.descripcion';
			break;
			case 'confirmado';
				$order_field = 'p.confirmado';
			break;
			case 'referencia';
				$order_field = 'p.numero_referencia';
			break;
			default:
				$order_field = $order_field;
			break;
		}
		
		
		$this->db->select(	'p.*, f.descripcion as forma_pago, r.id_reservacion, r.codigo_reserva,
							r.precio as total_pagar, u.nombre as cliente, m.abreviado as moneda');
							
		$this->db->join('reservacion r', 'r.id_reservacion = p.id_reservacion');
		$this->db->join('usuario_front u', 'u.id_usuario = r.id_usuario_front');
		$this->db->join('tipo_forma_pago f', 'f.id_tipo_forma_pago = p.id_tipo_forma_pago');
		$this->db->join('moneda m', 'm.id_moneda = p.tipo_moneda');
		
		$this->db->order_by($order_field, $order_dir);
		
		$q = $this->db->get('pago p', $count, $start);
		
		return $q->result();
	}
	
	function count_listado_pagos()
	{
		$this->db->select(	'p.*, f.descripcion as forma_pago, r.id_reservacion, r.codigo_reserva,
							r.precio as total_pagar, u.nombre as cliente');
		$this->db->join('reservacion r', 'r.id_reservacion = p.id_reservacion');
		$this->db->join('usuario_front u', 'u.id_usuario = r.id_usuario_front');
		$this->db->join('tipo_forma_pago f', 'f.id_tipo_forma_pago = p.id_tipo_forma_pago');
		$q = $this->db->get('pago p');
		return $q->num_rows();
	}

	function get_pago($id_pago)
	{
		$this->db->select(	'p.*, f.descripcion as forma_pago, r.id_reservacion, r.codigo_reserva,
							r.precio as total_pagar, u.nombre as cliente');
							
		$this->db->join('reservacion r', 'r.id_reservacion = p.id_reservacion');
		$this->db->join('usuario_front u', 'u.id_usuario = r.id_usuario_front');
		$this->db->join('tipo_forma_pago f', 'f.id_tipo_forma_pago = p.id_tipo_forma_pago');
		
		$this->db->where('p.id_pago', $id_pago);
		
		$q = $this->db->get('pago p');
		return $q->result();
	}
	
	function update_estado_pago($id_pago, $confirmado, $id_reservacion, $id_estado_reserva)
	{
		//Update confirmado
		$this->db->where('p.id_pago', $id_pago);
		$this->db->set('p.confirmado', $confirmado);
		$this->db->update('pago p');
		
		//Update estado reservacion
		$this->db->where('r.id_reservacion', $id_reservacion);
		$this->db->set('r.id_estado_reservacion', $id_estado_reserva);
		$this->db->update('reservacion r');
	}
}

?>