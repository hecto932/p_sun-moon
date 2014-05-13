<?php

class Contacto_model extends CI_Model {

	function findEmail_contacto($email)
	{
		$this->db->where('correo', $email);
		//$this->db->where('id_rol', 3);
		//$this->db->where('password', sha1($this->input->post('password')));
		//poner sha1
		$query = $this->db->get('contacto');

		if($query->num_rows() >= 1)
		{
			return TRUE;
		}else{
			
			return FALSE;
		}
	}
	
	function save_email($data)
	{
		$this->db->insert('newsletter', $data);
	}
	
	function does_exist_email($data)
	{
		$this->db->select('newsletter.correo');
		$this->db->where('newsletter.correo', $data);
		$query = $this->db->get('newsletter');
		if($query->num_rows() == 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_emails()
	{
		$this->db->select('newsletter.correo, newsletter.creacion');
		$query = $this->db->get('newsletter');
		return $query;
	}
	
	function get_page($start = 0, $count = 10, $order_field = 'contacto.id_contacto', $order_dir = 'desc', $terminos_busqueda = array()){
		switch ($order_field) {
			case 'id_contacto';
				$order_field = 'newsletter.id_newsletter';
			break;
			default :
				$order_field = $order_field;
			break;
		}
		
		
		$this->db->select('newsletter.creacion as creacion, newsletter.correo as correo, newsletter.id_newsletter as id_contacto');		
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field => $value){
				if ($field == 'fecha_desde' && $value != '')
				{
					$this->db->where("concat(ano,'-',mes,'-',dia) >=",$value);
				}
				elseif ($field=='fecha_hasta' && $value!='')
				{
					$this->db->where("concat(ano,'-',mes,'-',dia) <=",$value);
				}
				else
				{
					if ($value != '' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		$this->db->group_by('newsletter.id_newsletter');
		$this->db->order_by($order_field, $order_dir);
		$q=$this->db->get('newsletter', $count,$start);
		
		return $q->result();
	}
	
	function count_all($terminos_busqueda = array()){
		$this->db->select('count(*) as num_contactos');
		
		//TO-DO : Anadir where para terminos de busqueda
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='fecha_desde')
				{
					$this->db->where("concat(ano,'-',mes,'-',dia) >=",$value);
				}
				elseif ($field == 'fecha_hasta'){
					$this->db->where("concat(ano,'-',mes,'-',dia) <=",$value);
				}
				elseif ($field == 'operadora.id_estado' && $value!=''){
					$this->db->where($field,$value);
				}
				else
				{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		$q=$this->db->get('newsletter');
		$ret=$q->row();
		return $ret->num_contactos;
	}
	
	function read($id)
	{
		$this->db->select('newsletter.id_newsletter as id_contacto, newsletter.correo as correo, newsletter.creacion');
		$this->db->where('newsletter.id_newsletter', $id);
		$this->db->group_by('newsletter.id_newsletter');
		$q=$this->db->get('newsletter');
		if ($q->num_rows()==1)
		{
			return $q->row();
		}
		else
		{
			return $q->result();
		}
	}

	function update($data)
	{
			$this->db->insert('contacto',$data);
			$id=$this->db->insert_id();
		//echo '<pre>'.print_r($data,true).'</pre>';
	/*	if (isset($data['id_contacto']) && $data['id_contacto']!='')
			$usuario=$this->read($data['id_usuario']);
		else $usuario=array();
		//echo '<pre>'.print_r($usuario,true).'</pre>';
		if (!empty($usuario)){
			$this->db->where('id_contacto',$data['id_contacto']);
			$this->db->update('contacto',$data);
			$id=$data['id_usuario'];
		}else{
			$this->db->insert('contacto',$data);
			$id=$this->db->insert_id();
		}*/
		
		return $id;
	}
}