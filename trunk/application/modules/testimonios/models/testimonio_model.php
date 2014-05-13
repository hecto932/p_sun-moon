<?php

class Testimonio_model extends CI_Model
{
	
	//DEVUELVE LOS TESTIMONIOS ORDENADOS POR EL ATRIBUTO
	function get_testimonios($order_by = 'creado')
	{
		$this->db->where('testimonio.id_estado', 1);
		$this->db->order_by($order_by, 'DESC');
		return $this->db->get('testimonio')->result();
	}
	
	//DEVUELVE EL NUMERO DE TESTIMONIOS
	function num_testimonios($order_by = 'creado')
	{
		$this->db->where('testimonio.id_estado', 1);
		$this->db->order_by($order_by, 'DESC');
		return $this->db->get('testimonio')->num_rows();
	}
	
	//DEVUELVE EL NUMERO DE TESTIMONIOS POR RANGO
	function get_testimonios_perpage($order_by = 'creado', $per_page, $offset)
	{
		$this->db->where('testimonio.id_estado', 1);
		$this->db->order_by($order_by, 'DESC');
		$resultado = $this->db->get('testimonio', $per_page, $offset);
		return $resultado->result();
	}
	
	function insert_testimonio($data)
	{
		if(!empty($data))
		{
			$this->db->insert('testimonio', $data);
			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		}
	}
	
	function count_all($terminos_busqueda=array())
	{
		$this->db->select('count(*) as num_testimonios');
		
		if (!empty($terminos_busqueda))
		{
			foreach($terminos_busqueda as $field => $value)
			{
				if ($field == 'testimonio.id_testimonio' && $value!='')
				{
					$this->db->where($field, $value);
				}
				elseif ($field=='testimonio.rating' && $value != '')
				{
					$this->db->or_like($field, $value);
				}
				elseif ($field=='testimonio.id_estado' && $value != '')
				{
					$this->db->or_like($field, $value);
				}
				elseif ($field=='texto' && $value != '')
				{
					$this->db->or_like('nombre', $value);
					$this->db->or_like('email', $value);
					$this->db->or_like('comentario', $value);
				}
				/*
				else
				{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}*/
			}
		}
		
		$q 		= $this->db->get('testimonio');
		$ret 	= $q->row();
		return $ret->num_testimonios;
	}
	
	function get_page($start = 0, $count = 10, $order_field = 'testimonio.id_testimonio', $order_dir = 'desc', $terminos_busqueda = array())
	{
		switch ($order_field)
		{
			case 'id_testimonio';
				$order_field = 'testimonio.id_testimonio';
			break;
			
			case 'nombre';
				$order_field = 'testimonio.nombre';
			break;
			
			case 'email';
				$order_field = 'testimonio.email';
			break;
			
			case 'comentario';
				$order_field = 'testimonio.comentario';
			break;
			
			case 'rating';
				$order_field = 'testimonio.rating';
			break;
			
			default :
				$order_field = $order_field;
			break;
		}
		
		$this->db->select('testimonio.*, estado.estado',false);
		
		if (!empty($terminos_busqueda))
		{
			foreach($terminos_busqueda as $field => $value)
			{
				if ($field == 'testimonio.id_testimonio' && $value!='')
				{
					$this->db->where($field, $value);
				}
				elseif ($field=='testimonio.rating' && $value != '')
				{
					$this->db->or_like($field, $value);
				}
				elseif ($field=='testimonio.id_estado' && $value != '')
				{
					$this->db->or_like($field, $value);
				}
				elseif ($field=='texto' && $value != '')
				{
					$this->db->or_like('nombre', $value);
					$this->db->or_like('email', $value);
					$this->db->or_like('comentario', $value);
				}
				/*
				else
				{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}*/
			}
		}
		
		$this->db->join('estado', 'estado.id_estado = testimonio.id_estado');
		
		$this->db->group_by('testimonio.id_testimonio');
		$this->db->order_by($order_field, $order_dir);
		$q = $this->db->get('testimonio', $count, $start);

		return $q->result();
	}
	
	function read($id, $id_detalle_testimonio = '', $idioma = '')
	{
		$this->db->select('testimonio.*, estado.estado');
		
		//$idioma = (isset($idioma) && $idioma != '') ? $idioma : $this->idioma->id_idioma;
		//$this->db->where('detalle_usuario.id_idioma', $idioma);
		
		$this->db->join('estado', 'estado.id_estado = testimonio.id_estado');
		
		$this->db->where('testimonio.id_testimonio', $id);
		$this->db->group_by('testimonio.id_testimonio');
		$q = $this->db->get('testimonio');

		if ($q->num_rows()==1)
			return $q->row();
		else
			return $q->result();
	}
	
	function cambiar_estado_testimonio($id, $id_estado = 3)
	{
		$this->db->where('id_testimonio', $id);
		$this->db->set('id_estado', $id_estado);
		$this->db->update('testimonio');
	}
	
}