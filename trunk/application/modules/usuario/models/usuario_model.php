<?php

class Usuario_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('idioma/idioma_model','idioma_model');
		$this->idioma=idioma_model::get_from_code($this->session->userdata('idioma'));
	}
	function create($data)
	{
		$this->db->insert('usuario',$data);
		return $this->db->insert_id();
	}
	function read($id,$id_detalle_usuario='',$idioma='')
	{
		$this->db->select('usuario.*,usuario.id_usuario as id_usuario');
		//$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		//$this->db->where('detalle_usuario.id_idioma',$idioma);
		$this->db->where('usuario.id_usuario',$id);
		$this->db->group_by('usuario.id_usuario');
		$q=$this->db->get('usuario');
		//echo $this->db->last_query();
		if ($q->num_rows()==1)
			return $q->row();
		else
			return $q->result();
	}
	function get($tabla,$id=''){
		if ($id!='') $this->db->where('id_'.$tabla,$id);
		$q=$this->db->get($tabla);
		if ($q->num_rows()==1)
			return $q->row();
		else
			return $q->result();
	}

	
	function get_all($idioma=''){
		$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;

		$q=$this->db->get('usuario');
		return $q->result();
	}
	function get_page($start=0,$count=10,$order_field='usuario.id_usuario',$order_dir='desc',$terminos_busqueda=array()){
		switch ($order_field) {
			case 'id_usuario';
				$order_field='usuario.id_usuario';
			break;
			case 'nombre';
				$order_field='CONCAT(usuario.apellidos,usuario.nombre)';
			break;
			case 'email';
				$order_field='email';
			break;
			case 'id_rol';
				$order_field='id_rol';
			break;
			default :
				$order_field=$order_field;
			break;
		}
		
		
		$this->db->select('usuario.*,usuario.id_usuario as id_usuario, est.estado_usuario',false);
		
		//JOIN ESTADO USUARIO
		$this->db->join('estado_usuario est', 'est.id_estado_usuario = usuario.id_estado_usuario');
		
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='fecha_desde' && $value!=''){
					$this->db->where("concat(ano,'-',mes,'-',dia) >=",$value);
				}elseif ($field=='fecha_hasta' && $value!=''){
					$this->db->where("concat(ano,'-',mes,'-',dia) <=",$value);
				}elseif ($field=='usuario.id_categoria' && $value!=''){
					$this->db->where($field,$value);
				}elseif ($field=='tag' && $value!=''){
					$this->db->like($field,$value);
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		$this->db->group_by('usuario.id_usuario');
		$this->db->order_by($order_field,$order_dir);
		$q=$this->db->get('usuario',$count,$start);
		//echo $this->db->last_query();
		return $q->result();
	}
	function comprobaremail($email){
		$this->db->select('id_usuario');
		$this->db->where('email',$email);	
		$q=$this->db->get('usuario');
		return $q->num_rows();

	}
	function count_all($terminos_busqueda=array()){
		$this->db->select('count(*) as num_usuarios');
		
		//TO-DO : Anadir where para terminos de busqueda
		if (!empty($terminos_busqueda)){
			foreach($terminos_busqueda as $field=>$value){
				if ($field=='usuario.id_usuario' && $value!=''){
					$this->db->where($field,$value);
				}elseif ($field=='usuario.nombre' && $value!=''){
					$this->db->like($field,$value);					
				}elseif ($field=='usuario.descripcion' && $value!=''){
					$this->db->like($field,$value);
				}elseif ($field=='usuario.id_estado' && $value!=''){
					$this->db->like($field,$value);
				}else{
					if ($value!='' && !is_array($value))
						$this->db->like($field,$value);
				}
			}
		}
		//$this->db->group_by('usuario.id_usuario');
		$q=$this->db->get('usuario');
		$ret=$q->row();
		return $ret->num_usuarios;
	}
	function update($data)
	{

		//echo '<pre>'.print_r($data,true).'</pre>';die();
		if (isset($data['id_usuario']) && $data['id_usuario']!='')
			$usuario=$this->read($data['id_usuario']);
		else $usuario=array();
		//echo '<pre>Usuario update'.print_r($usuario,true).'</pre>';
		if (!empty($usuario)){
			$this->db->where('id_usuario',$data['id_usuario']);
			$this->db->update('usuario',$data);
			$id=$data['id_usuario'];
		}else{
			$this->db->insert('usuario',$data);
			$id=$this->db->insert_id();
		}
		
		return $id;
	}
	function update_idioma($data)
	{
		//echo '<pre>'.print_r($data,true).'</pre>';
		//$d=array('id_idioma'=>$data['id_idioma'],'id_usuario'=>$data['id_usuario']);
		
		$d=array('id_usuario'=>$data['id_usuario']);
		if (isset($data['id_detalle_usuario']) || $ob=$this->exists('detalle_usuario',$d)){
			if (isset($data['id_detalle_usuario'])){
				$this->db->where('id_detalle_usuario',$data['id_detalle_usuario']);
				$id=$data['id_detalle_usuario'];
			}else{
				$this->db->where($d);
				$id=$ob->id_detalle_usuario;
			}
			$this->db->update('detalle_usuario',$data);
			
		}else{
			$this->db->insert('detalle_usuario',$data);
			$id=$this->db->insert_id();
		}
		return $id;
	}
	//Eliminar un usuario de la base de datos
	function delete($id){

		if ($this->db->delete('usuario', array('id_usuario' => $id)))
			return true;
		else return false;
	}
	//Cambia el estado de un usuario a inactivo
	function delete_user($id){
		
		$data = array('id_estado_usuario' => 1);
		$this->db->where('id_usuario', $id);
	
		if ($this->db->update('usuario', $data))
			return true;
		else return false;
	}
	function eliminar_idioma($id){
		if ($this->db->delete('detalle_usuario', array('id_detalle_usuario' => $id)))
			return true;
		else return false;
	}
	function exists($table,$key=array()){
		
		$this->db->where($key);
		$q=$this->db->get($table);
		if ($q->num_rows()>=1) return $q->row();
		else return false;
	}
}

