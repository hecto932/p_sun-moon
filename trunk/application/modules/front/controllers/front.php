<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Front extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata("reservacion_temp"))
			$this->session->unset_userdata('reservacion_temp');
		
		if ($this->session->userdata('idioma'))
		{
			modules::run('idioma/idioma/set_idioma', $this->session->userdata('idioma'));	
		} 
		else
		{
			modules::run('idioma/idioma/set_idioma', 'es');
		}
		
		$this->lang->load('front');
		$this->load->model('front_model');
	}
	
	
	function index()
	{
		if($this->session->userdata('nombre') == TRUE)
		{
			//OBTENGO LOS SERVICIOS POR EL IDIOMA PRINCIPAL
			$data['servicios']					= modules::run('servicio/servicio_front/get_services',$this->session->userdata('idioma'));
			
			//OBTENGO EL NUMERO DE SERVICIOS POR EL IDIOMA PRINCIPAL
			$data['numero_servicios']			= modules::run('servicio/servicio_front/num_services',$this->session->userdata('idioma'));
			
			//NUMERO DE SERVICIOS A MOSTRAR
			$data['numero_servicios_random']	= 3;
			
			//OBTENGO LOS BANNERS DE LA PAGINA 
			$data['banners'] 					= $this->get_banners();
			
			//TITULO DE PAGINA
			$data['title']						= lang('front_title.inicio');
			
			//ACTIVE DE LA PAGINA PARA MARCAR QUE ESTOY EN ESTA EN EL MENU
			$data['active'] 					= lang('front_menu.inicio');
			
			//RANDOM DE LOS SERCVICIOS	
			$data['random']						= $this->servicios_random($data['numero_servicios_random'],$data['numero_servicios']);
			
			//CARGO EL CONTENIDO PRINCIPAL EN LA PAGINA 
			$data['contenido_principal'] 	= $this->load->view('home',$data,true);
			
			//CARGO EL CONTENIDO PRINCIPAL CON LA AYUDA DEL TEMPLATE
			$this->load->view('front/template',$data);
		}
		else
		{
			//OBTENGO LOS SERVICIOS POR EL IDIOMA PRINCIPAL
			$data['servicios']					= modules::run('servicio/servicio_front/get_services',$this->session->userdata('idioma'));
			
			//OBTENGO EL NUMERO DE SERVICIOS POR EL IDIOMA PRINCIPAL
			$data['numero_servicios']			= modules::run('servicio/servicio_front/num_services',$this->session->userdata('idioma'));
			
			//NUMERO DE SERVICIOS A MOSTRAR
			$data['numero_servicios_random']	= 2;
			
			//OBTENGO LOS BANNERS DE LA PAGINA 
			$data['banners'] 					= $this->get_banners();
			
			//TITULO DE PAGINA
			$data['title']						= lang('front_title.inicio');
			
			//ACTIVE DE LA PAGINA PARA MARCAR QUE ESTOY EN ESTA EN EL MENU
			$data['active'] 					= lang('front_menu.inicio');
			
			//RANDOM DE LOS SERCVICIOS	
			$data['random']						= $this->servicios_random($data['numero_servicios_random'],$data['numero_servicios']);
			
			//CARGO EL CONTENIDO PRINCIPAL EN LA PAGINA 
			$data['contenido_principal'] 	= $this->load->view('home',$data,true);
			
			//CARGO EL CONTENIDO PRINCIPAL CON LA AYUDA DEL TEMPLATE
			$this->load->view('front/template',$data);
		}
		
	}

	function get_banners()
	{
		return $this->front_model->get_banners();
	}
	
	//ESTA FUNCION BUSCA UN NUMERO EN EL VECTOR
	function buscar_servicio($array,$numero)
	{
		//ASUMO QUE NO LO HE ENCONTRADO
		$encontrado = false;
		
		//SI EL VECTOR NO ES VACIO 
		if(!empty($array))
		{
			//POR CADA POSICION DEL VECTOR 
			for($i = 0; $i < count($array) && !$encontrado ;++$i)
				if($array[$i] == $numero)//SI LO ENCUENTRO 
					$encontrado = true;//CAMBIO EL ESTADO A ENCONTRADO
		}	
		return $encontrado;//RETORNO EL RESULTADO DE LAB BUSQUEDA
	}
	
	//GENERO EL VECTOR DE ENTEROS PARA LOS SERVICIOS RANDOMS
	function servicios_random($numeros, $numero_servicios)
	{
		
		$array = array();
		
		//CONTADOR QUE ME VA A INDICAR CUANTOS NUMEROS RANDOMS SIN REPETIR TENGO EN EL VECTOR
		$i = 0;
		//MIENTRAS NO TENGA TODOS LOS NUMEROS QUE NECESITO
		while($i < $numeros)
		{
			//GENERO UN NUMERO X ALEATORIO
			$x = rand(0,$numero_servicios - 1);
			//SI EL NUEVO NUMERO NO ESTA EN EL VECTOR ENTONCES
			if(!$this->buscar_servicio($array, $x))
			{
				//LO AGREGO Y CUENTO UNO
				$array[$i] = $x;
				$i++;
			}
		}
		
		return $array;
	}
	
	
}