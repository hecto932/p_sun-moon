<?php

class Usuarios extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		modules::run('idioma/set_idioma', 'es');
		//$this->is_logged_in();
		$this->load->library('form_validation');
		$this->lang->load('back');
	}

	function index()
	{
		if (modules::run('usuarios/is_logged_in') == 'true'){
			$this->profile();
		}else{
			$this->login_form();
		}
	}

	function login_form()
	{
		$this->load->model('idioma/idioma_model');
		$data['idiomas'] = $this->idioma_model->get_all();
		$data['title'] = "Login";
		$data['login'] = true;
		$data['active'] = 'usuarios';
		$data['sub'] = 'listado';
		$data['breadcrumbs'] = array();

		$data['contenido_principal'] = $this->load->view('login_form', $data ,true);

		$this->load->view('back/template_new', $data);

	}
	function profile($ajax=false)
	{
		if ($ajax==false)
		{
			$userdata['userdata'] = $this->session->userdata;
			$data['main_content'] = $this->load->view('user_profile', $userdata,true);
			$this->load->view('back/template_new', $data);
		}
		else
		{
			echo json_encode($this->session->userdata);
		}
	}
	function detalle($id,$ajax = false)
	{
		$userdata['userdata']=$this->session->userdata;
		$data['main_content'] = $this->load->view('user_profile', $userdata,true);
		$this->load->view('back/template', $data);
	}

	function login($ajax = false)
	{
		$this->load->model('usuarios_model');
		$usuario = $this->usuarios_model->validate();
		
		$data['title'] = "Login";
		if($usuario!== false && $usuario->id_estado_usuario == 2) // if the user's credentials validated...
		{
			//$this->user_data();
			$data = (array)$usuario;
			$data['is_logged_in'] = true;
			$data['idioma'] = 'es';
			$this->lang->load('back', $data['idioma']);
			$this->session->set_userdata($data);
			if ($ajax!= false){
				echo json_encode($this->user);
			}
			else
			{
				$r = ($this->session->userdata('return_url') == '') ? 'backend' : $this->session->userdata('return_url');
				redirect($r);
			}
		}
		else // incorrect username or password
		{
			if ($ajax != false)
			{
				echo "[{'result':false}]";
			}
			else
			{
				$data['login'] = true;
				$data['active'] = 'usuarios';
				$data['sub'] = 'listado';
				$data['breadcrumbs'] = array();
				$data['contenido_principal'] = $this->load->view('login_form', $data, true);
				$this->load->view('back/template_new', $data);
			}
		}
	}

	function is_logged_in($rol='',$url='',$ajax=false)
	{
		$this->session->set_userdata('return_url',$url);
		$is_logged_in = $this->session->userdata('is_logged_in');
		$user_role_id = $this->session->userdata('id_rol');
		$ro=modules::run('services/relations/get_all','rol');
		foreach($ro as $r){
			$roles[$r->id_rol]=$r->nombre;
		}
		//echo $rol;
		//echo '<pre>'.print_r($roles,true).'</pre>';
		$max_role_id=0;
		$max_role_id=array_search($rol,$roles);
		//echo "$user_role_id >= $max_role_id";
		if(isset($is_logged_in) && $is_logged_in == true && $user_role_id <= $max_role_id)
		{
			if ($ajax)
				echo 'true';
			else
				return true;
		}else{
			if ($ajax)
				echo 'false';
			else
				redirect(lang('backend_url').'/usuarios/login');

		}
		//echo '<pre>'.print_r($this->session->userdata,true).'</pre>';

	}

	function is_logged_in_rol($rol='',$url='',$ajax=false)
	{
		$this->session->set_userdata('return_url',$url);
		$is_logged_in = $this->session->userdata('is_logged_in');
		$user_role_id = $this->session->userdata('id_rol');
		//$ro=modules::run('services/relations/get_all','rol');
		$ro=modules::run('services/relations/get_from','rol','nombre',$rol);
		$rol1 = array('0'=>$rol);
		foreach($ro as $r){
			$roles[$r->id_rol]=$r->nombre;
		}

		$max_role_id=0;
		$max_role_id= array_search($rol,$roles);
		//echo "$user_role_id >= $max_role_id [". array_search($rol,$roles)."]";


				//echo $rol;
		//echo '<pre> ROLES'.print_r($roles,true).'</pre>';
		//echo '<pre> ROL'.print_r($roles,true).'</pre>';
		//echo '<pre> $$is_logged_in->'.$is_logged_in;
		//echo ' $$user_role_id->'.$user_role_id;
		//echo ' $$max_role_id->'.$max_role_id.'</pre>';


		if((isset($is_logged_in) && $is_logged_in == true) && ($user_role_id == $max_role_id))
		{
			//echo 'ENTRO EN TRUE';
			if ($ajax)
				echo 'true';
			else
				return true;
		}
		else{
			//echo 'ENTRO EN FALSE';
			if ($ajax)
				echo 'false';
			else
				return false;
				//redirect('usuarios/login_form');

		}

	}

	function user_data($id='',$ajax=false)
	{
		$this->load->model('usuarios_model');
		$this->user=$this->usuarios_model->get_user($id);
		if ($ajax)
			echo json_encode($this->user);
		else
			return $this->user;
	}
	function signup()
	{
		$data['main_content'] = $this->load->view('signup_form', '', true);
		$this->load->view('back/template', $data);
	}
	function create_user()
	{
		$this->load->library('form_validation');
		// field name, error message, validation rules
		$this->form_validation->set_rules('first_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');


		if($this->form_validation->run() == FALSE)
		{
			$data['main_content'] = $this->load->view('signup_form','',true);
		}
		else
		{
			$this->load->model('usuarios_model');
			if($query = $this->usuarios_model->create_user())
			{
				$data['message'] = $this->lang->line('signup_successful');
				$data['content'] = $this->load->view('signup_form','',true);
			}
			else
			{
				$data['content'] = $this->load->view('signup_form','',true);
			}
		}
		$this->load->view('back/template', $data);

	}

	function cp()
	{
		if( $this->session->userdata('email') )
		{
			// load the model for this controller
			$this->load->model('usuarios_model');
			// Get User Details from Database
			if( !$this->session->userdata('id_usuario'))
			{
				// No user found
				return false;
			}
			else
			{
				// display our widget
				$data['userdata']= $this->session->userdata;
				$this->load->view('user_widget',$data);
			}
		}
		else
		{
			// There is no session so we return nothing
			return false;
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('backend');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
