<?php

//librerias de google
include(APPPATH.'libraries/Google/Google_Client.php');
include(APPPATH.'libraries/Google/Google_PlusService.php');
include(APPPATH.'libraries/Google/Google_Oauth2Service.php');
    
class GoogleConnect
{
     public $user_api = NULL;
     public $user_gplus = NULL;
     public $informacion = NULL;
    
    function __construct()
    {
   	 $ci =& get_instance();
   	 $ci->load->helper('url');
   	 
   	 session_start();

   	 //configuraciones del nuevo cliente  
   	 $client = new Google_Client(); 
   	 $client->setApplicationName('Login_google+');
   	 
//id que nos proporciona la aplicacion cuando la creamos
   	 $client->setClientId('982223314814-7ir7596jb0o3faig6kl193akjegb6qdv.apps.googleusercontent.com');

//secret o clave de acceso que nos proporciona la aplicacion cuando la creamos
   	 $client->setClientSecret('7xR2QzRhJzC1Kb_U1lOYCE-a');

//direccion de redireccionamiento  que nos coincida  con la que fue colocada en las configuraciones de la aplicacion
   	 $client->setRedirectUri(base_url()."usuarios/google_control/login");

//llave como desarrollador que nos proporciona la aplicacion cuando la creamos
   	 $client->setDeveloperKey('AIzaSyBqCuXKOy3l_OVsimXfDIPR46h08aLlVBk');

//permisos para extender la solicitud de informacion
   	 $client->setScopes(array('https://www.googleapis.com/auth/plus.login',
   	 'https://www.googleapis.com/auth/userinfo.email',
    	'https://www.googleapis.com/auth/plus.me'));
   	 
//cliente de google plus
   	 $plus = new Google_PlusService($client);
   	 
   	 $this->informacion = new Google_Oauth2Service($client);
    
   	 $this->user_api=$client;
   	 $this->user_gplus= $plus;

// todo esto verifica si ya se hizo la peticion de informacion ,es decir si ya se tiene el token con la informacion del usuario
   	 if (isset($_GET['code']))
   	 {
			 $client->authenticate($_GET['code']);
     		 $_SESSION['access_token'] = $client->getAccessToken();
 
   	 }
   	 
     	 if (isset($_SESSION['access_token']))
   	 {
     		 $client->setAccessToken($_SESSION['access_token']);
   	 }
   	 
   	 if ($client->getAccessToken())
   	 {
     		 $_SESSION['token'] = $client->getAccessToken();
   	 }
   	 
    }
}

?>
