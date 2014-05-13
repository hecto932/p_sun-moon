<?php

include(APPPATH.'libraries/Facebook/Facebook.php');  //carga de la libreria facebook

class Fbconnect extends Facebook //se extiende la libreria 
{
    public $user = NULL;
    public $user_id = NULL;
    
    function __construct()
    {
       
        $ci =& get_instance();            //creacion de instacion de nuestra libreria
        $ci->config->load('Facebook',TRUE);
        $config = $ci->config->item('Facebook'); //se cargan las configuraciones del config
        parent::__construct($config);

        parse_str($_SERVER['QUERY_STRING'],$_REQUEST);//almacena el string de la comunicacion con facebook que es donde esta la informacion solicitada
        
        $this->user_id = $this->getUser(); //verifica si el usuario esta logeado 0(caso negativo) y n en caso contrario
        
        if ($this->user_id)
        {    
            try
            {

            }
            catch (FacebookApiException $e) //en caso de error en la comunicacion aqui se refleja el error
       {
       $result = $e->getResult();
        die("<pre>die_pre:<br />".print_r($result,TRUE)."<br />/die_pre</pre>");
            $user = null;
            }
        }
        
    }
}

?>