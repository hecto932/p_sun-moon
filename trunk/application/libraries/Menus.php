<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menus {

	public function __construct()
    {
    	$CI =& get_instance();
		$CI->load->helper('html');
		$CI->config->load('menus');
		$CI->config->set_item('language', 'es');
		$CI->lang->load('back');
    }

    public function create_mainmenu($active, $sub)
    {


		$contenido = '';
		$subcontenido = '';
		$CI =& get_instance();
		$CI->config->load('menus');
		$config['opciones_mainmenu'] = $CI->config->item('opciones_mainmenu');
		$sub_opciones = $CI->config->item('opciones_submenu');
		foreach($config['opciones_mainmenu'] as $opcion){
			$gestion = 'gestion_'.$opcion['index'];
			$href_activa = base_url().$CI->lang->line('backend_url').'/'.$opcion['url'].'/';
			$href_activa .= ($opcion['url'] == 'usuarios') ? $CI->lang->line('listado_url') : '';  
			$valor_activo = '<a href=" '.$href_activa.'">'.$CI->lang->line($gestion).'</a>';
			
			if($active == $opcion['url'])
			{
				$contenido .= '<li class = "active has-dropdown">'.$valor_activo.$this->create_submenu($opcion['url'], $sub).'<li>';
			}
			else
			{
				$contenido .= '<li class = "has-dropdown">'.$valor_activo.$this->create_submenu($opcion['url'], $sub).'<li>';
			}
		}
		return '<ul class = "left"><li class="divider"></li>'.$contenido.'</ul>';
    }


	public function create_submenu($menu, $sub)
	{
		$contenido = '';
		$CI =& get_instance();
		$CI->config->load('menus');
		$opciones_submenu = $CI->config->item('opciones_submenu');
		foreach($opciones_submenu[$menu] as $opcion)
		{
			if($menu == $CI->config->item('active') && $opcion == $sub)
			{
				$contenido .= '<li class="active">'.'<a href="'.base_url().lang('backend_url').'/'.$menu.'/'.$opcion['url'].'">'.$opcion['titulo'].'</a></li>';
			}
			else
			{
				$contenido .= '<li>'.'<a href="'.base_url().lang('backend_url').'/'.$menu.'/'.$opcion['url'].'">'.$opcion['titulo'].'</a></li>';
			}

		}
		return '<ul class="dropdown">'.$contenido.'</ul>';
	}

	public function create_breadcrumb($data)
	{
		$contenido = '';
		$cont = count($data);
		$i = 0;
		foreach ($data as $key => $value)
		{
			//if($cont == $i){
			if($cont-1 == $i){
				//$contenido .= '<li><a href="#">'.$value.'</a></li>';
				$contenido .= '<li><a>'.$value.'</a></li>';
			}
			else{
				$contenido .= '<li><a href="'.base_url().$key.'">'.$value.'</a></li>';
			}
			$i++;
		}
		return '<ul class="breadcrumbs">'.$contenido.'</ul>';
	}


	public function set_active($data)
	{
		$CI =& get_instance();
		$CI->config->load('menus');
		$CI->config->set_item('active', $data);
	}

	public function get_active(){
		$CI =& get_instance();
		$CI->config->load('menus');
		return $CI->config->item('active');
	}

	public function set_sub($data)
	{
		$CI =& get_instance();
		$CI->config->load('menus');
		$CI->config->item('sub', $data);
	}

	public function get_sub(){
		$CI =& get_instance();
		$CI->config->load('menus');
		return $CI->config->item('sub');
	}
}

/* End of file Someclass.php */