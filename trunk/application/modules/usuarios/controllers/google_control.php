<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Google_control extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('idioma'))
		{
			modules::run('idioma/idioma/set_idioma', $this->session->userdata('idioma'));	
		} 
		else
		{
			modules::run('idioma/idioma/set_idioma', 'es');
		}
		$this->load->model('usuarios_model');
		
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->lang->load('front', 'es');
	}

    public function login()
    {
   	 $this->load->library('googleconnect');
   	 
   	
   	 $token=$this->googleconnect->user_api->getAccessToken();
   	 if ($token)
   	 {
		//solicitud de informacion del usuario de aqui para obtener el correo
		// que no se obtiene de la solicitud de google plus
   		 $info=$this->googleconnect->informacion->userinfo->get();
		//solicitud de informacion del perfil de google plus
   	     	  $perfil =$this->googleconnect->user_gplus->people->get('me');
     		 
     	$data = array(
   		 	'email' 			=> 	$info['email'],
   		 	'nombre' 			=>	$perfil['displayName'],
   		 	'imagen'			=>	$perfil['image']['url'],
   			'login_fb_google'	=>	true
   		 );
   		 
   		   		 
   		if($this->usuarios_model->verificar_email($data['email']))
		{
			$datos_usuario = $this->usuarios_model->getData($data['email']);
			$this->session->set_userdata($datos_usuario[0]);
			redirect('/','location');
		}
		else
		{
			//OBTENGO EL VECTOR DE TODOS LOS PAISES
			$query_paises 					=	$this->usuarios_model->obtener_paises();
			//OBTENGO EL VECTOR DE STRINGS DE LOS PAISES
			$data['opt_paises'] 			= 	dropdown($query_paises, 'id_pais', 'descripcion');
			
			//TITULO DE PAGINA
			$data['title']					= 	lang('front_title.inicio');
			
			//CARGO EL CONTENIDO PRINCIPAL EN LA PAGINA 
			$data['contenido_principal'] 	= 	$this->load->view('usuarios/front/registro_usuario',$data,true);
			
			//CARGO EL CONTENIDO PRINCIPAL CON LA AYUDA DEL TEMPLATE
			$this->load->view('front/template',$data);
		}
   	 } 
   	 else
   	 {

		//en caso de no estar logeado el usuario redirecciona al link de google login
		 $googleUrl = $this->googleconnect->user_api->createAuthUrl();
   		 redirect($googleUrl);
     	
   	 }
    }  
}

?>
