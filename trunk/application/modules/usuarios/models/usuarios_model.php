<?php

class Usuarios_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('idioma/idioma_model','idioma_model');
		$this->idioma=idioma_model::get_from_code($this->session->userdata('idioma'));
	}
	
	function get_pais($id_pais)
	{
		$this->db->select("descripcion");
		$query = $this->db->get_where('pais', array('id_pais' => $id_pais));
		return $query->row()->descripcion;
	}
	
	//DATOS DE LA TABLA PAIS
	function obtener_paises()
	{
		$query = $this->db->get('pais')->result();
		return $query;
	}
	
	//REGISTRA UN USUARIO EN LA BASE DE DATOS
	function registrar_usuario($data)
	{
		$this->db->insert('usuario_front',$data);
	}
	
	//VERIFICA SI EL EMAIL EXISTE
	function verificar_email($email)
	{
		$this->db->select('email');
		$this->db->where('email',$email);
		$query = $this->db->get('usuario_front');
		//echo '<pre>'.print_r($query->result(),true).'</pre>';
		return $query->num_rows()==1;
	}
	
	//VERIFICA SI EL EMAIL EXISTE
	function verificar_email_duplicado($email)
	{
		$this->db->select("email");
		$query = $this->db->get_where('usuario_front', array('email' => $email));
		return $query->row()->email == $email;
	}
	
	function verificar_sesion()
	{
		$data = array(
			"email"		=> 	$this->input->post("email"),
			"password" 	=>	sha1($this->input->post("password"))
		);
		
		$query = $this->db->get_where('usuario_front', $data);	
		return $query->num_rows() == 1;
	}
	
	function verificar_restablecimiento($data)
	{
		$query = $this->db->get_where('usuario_front', $data);	
		return $query->num_rows() == 1;
	}
	
	function getData($email)
	{
		$query = $this->db->get_where('usuario_front', array('email' => $email));
		return $query->result();
	}
	
	function get_datos_usuario($id_usuario)
	{
		$data = array(
			"id_usuario"	=>	$id_usuario
		);
		
		$query = $this->db->get_where('usuario_front', $data);
		return $query->row();
	}
	
	function actualizar($data)
	{
		$this->db->where('email', $data['email']);
		$this->db->update('usuario_front', $data); 
	}
	
	
	function update_informacion_usuario($id_usuario,$data_update)
	{
		$this->db->where('id_usuario', $id_usuario);
		$this->db->update('usuario_front', $data_update); 
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function validate()
	{
		$this->db->where('email', $this->input->post('email'));
		$this->db->where('password', sha1($this->input->post('password')));
		//poner sha1
		$query = $this->db->get('usuario');

		if($query->num_rows == 1)
		{
			$row=$query->result();
			//echo '<pre>'.print_r($row,true).'</pre>';
			return $row[0];
		}else{
			return false;
		}
//adding comment
	}
	function read($id,$id_detalle_usuario='',$idioma='')
	{
		$this->db->select('usuario.*,detalle_usuario.*,usuario.id_usuario as id_usuario');
		//$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		if ($id_detalle_usuario!='') $this->db->where('detalle_usuario.id_detalle_usuario',$id_detalle_usuario);
		$this->db->join('detalle_usuario','usuario.id_usuario=detalle_usuario.id_usuario','left');
		
		//$idioma=(isset($idioma) && $idioma!='') ? $idioma : $this->idioma->id_idioma;
		
		//$this->db->where('detalle_usuario.id_usuario',$id);
		$this->db->where('usuario.id_usuario',$id);
		$this->db->group_by('usuario.id_usuario');
		$q=$this->db->get('usuario');
		//echo $this->db->last_query();
		if ($q->num_rows()==1)
			return $q->row();
		else
			return $q->result();
	}
	
	function get_user($id='')
	{
		if ($id==''){
			$this->db->where('id_usuario', $this->session->userdata('id_usuario'));
		}else{
			//modules::run('usuarios/is_logged_in','admin','');
			$this->db->where('id_usuario', $id);
		}
		$query = $this->db->get('usuario');

		if($query->num_rows == 1)
		{
			$row=$query->result();
			//echo '<pre>'.print_r($row[0],true).'</pre>';
			//die();
			return $row[0];
		}else{
			return false;
		}

	}
	function get_username($id='')
	{
		if ($id==''){
			$this->db->where('id_usuario', $this->session->userdata('id_usuario'));
		}else{
			//modules::run('usuarios/is_logged_in','admin','');
			$this->db->where('id_usuario', $id);
		}
		$query = $this->db->get('usuario');

		if($query->num_rows == 1)
		{
			$row=$query->result();
			//echo '<pre>'.print_r($row[0],true).'</pre>';
			//die();
			return $row[0]->nombre_usuario;
		}else{
			return false;
		}

	}
	
	function get_key($clave='')
	{
		
		$this->db->where('verificacion', $clave);
		$query = $this->db->get('usuario');
		//return $query->num_rows;
		if($query->num_rows >= 1)
		{
			$row=$query->result();
			return $query->row_array();
		}else{
			//return 'Esto es una prueba false';
			return false;
		}

	}

	function get_email($email='')
	{
		
		$this->db->where('email', $email);
		$query = $this->db->get('usuario');
		//return $query->num_rows;
		if($query->num_rows >= 1)
		{
			$row=$query->result();
			return $query->row_array();
		}else{
			//return 'Esto es una prueba false';
			return false;
		}

	}
	function create_user()
	{
		$new_member_insert_data = array(
			'nombre' => $this->input->post('nombre'),
			'apellidos' => $this->input->post('apellidos'),
			'email' => $this->input->post('email'),
			'id_rol' => $this->input->post('id_rol'),
			'password' => sha1($this->input->post('password'))
		);

		$insert = $this->db->insert('usuario', $new_member_insert_data);
		return $insert;
	}
	
	function findActiveByEmail($email)
	{
		$this->db->where('email', $email);
		//$this->db->where('password', sha1($this->input->post('password')));
		//poner sha1
		$query = $this->db->get('usuario');

		if($query->num_rows == 1)
		{
			$row=$query->result();
			return $query->row_array();
			//return $row[0];
		}else{
			
			return false;
		}

	}
	function findActiveByEmailPassword($email,$password)
	{
		$this->db->where('email', $email);
		$this->db->where('password', sha1($password));
		//poner sha1
		$query = $this->db->get('usuario');

		if($query->num_rows == 1)
		{
			$row=$query->result();
			return $query->row_array();
			//return $row[0];
		}else{
			return false;
		}

	}
	
	function findEmail($email)
	{
		$this->db->where('email', $email);
		$this->db->where('id_rol', 3);
		//$this->db->where('password', sha1($this->input->post('password')));
		//poner sha1
		$query = $this->db->get('usuario');

		if($query->num_rows() >= 1)
		{
			return TRUE;
		}else{
			
			return FALSE;
		}
	}
	function findUsuario($user)
	{
		$this->db->where('nombre_usuario', $user);
		//$this->db->where('nombre', $user);
		//$this->db->where('password', sha1($this->input->post('password')));
		//poner sha1
		$query = $this->db->get('usuario');

		if($query->num_rows() > 0)
		{
			return TRUE;
		}else{
			
			return FALSE;
		}
	}

	function _gen_pass($size=8){


		$str[0] = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $str[1]="abcdefghijklmnopqrstuvwxyz";
        $str[2]="1234567890";
        $str[3]="_+()*?-@!$%#";
		$password = '';
        $used=array();
		for($i=0 ; $i<$size ; $i++) {

            $a=$i;
            
            if (!in_array($a,$used))
                $used[]=$a;
            if (count($used)>4)
                $a= rand(0,3);

            $pos=rand(0,strlen($str[$a])-1);
            //echo 'Pos : '.$pos.' Key : '.$a.' Str : '. $str[$a].'<br>';
			$password .= $str[$a][$pos];

		}

		return $password;

    }
}
