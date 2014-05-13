<?php 

class Facebook_control extends MX_Controller {
    
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
        $this->load->library('fbconnect');
		
        $params = array(

       'scope' => 'email', // estos son los permisos a extender de lado del cliente y tiene que coincidir este permiso con el que se extendio en la aplicacion (ver Extender permiso de la aplicacion). 

        'redirect_uri' => 'http://solyluna.dyndns.biz/usuarios/facebook_control/crear_usuario'// aqui redirecciona una vez hecha la peticion al servidor de facebook en este caso esta redireccionada a este controlador a la funcion donde se almacena la informacion obtenida en una variable de sesion para su uso.

        );
                    
        $login = $this->fbconnect->getLoginUrl($params);
        redirect($login);     
    }
    
    public function crear_usuario()
    {
        $this->load->library('fbconnect');
            
 		$user['user_profile'] = $this->fbconnect->api('/'.$this->fbconnect->user_id.'?fields=name,picture.height(200).width(200),email'); //consulta al grafo de facebook de lado del cliente ,aqui se obtiene la informacion que se requiera del usuario 
		
		$data = array(
			"nombre"			=>	$user['user_profile']['name'],
			"email"				=>	$user['user_profile']['email'],
			"login_fb_google"	=>	true
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
		
		
		
        //$this->session->set_userdata($user); //crea la sesion con lo datos de facebook
       	
    }
    
    /*  amigos de facebook que utilizan esta paginas */
    public function amigos_usuarios()
    {
        $this->load->library('fbconnect');

        if($this->fbconnect->user_id)
        {

        //consulta en el fql de lado del cliente muy similar a como se hace en la ventana grafica de facebook
 $fql = 'select name,pic_square from user where uid in (select uid2 from friend where uid1='.$this->fbconnect->user_id.')'.' and is_app_user=1';
                   
            $data['amigos'] = $this->fbconnect->api(array(
                         'method' => 'fql.query',
                          'query' => $fql,                       
          ));
          
            $this->load->view('header');//envio de datos a la vista
            $this->load->view('amigos_fb',$data);
            $this->load->view('footer');    
        }
        else
        {        
            $login = $this->fbconnect->getLoginUrl($params);
            redirect($login);         
        }
    
    }
}

?>