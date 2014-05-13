<?php

class Contacto extends MX_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->model('contacto_model');
		modules::run('idioma/set_idioma', 'en');
		$this->lang->load('back');
		$this->load->helper('multimedia');
		$this->load->model('idioma/idioma_model');
		$idiomas = $this->idioma_model->get_all();
	}
	
	/* 
	 * Funcciones del admin, con control de aceso */
	function index()
	{
			$this->listado();
	}
	
	function listado($order_field = 'newsletter.id_newsletter', $order_dir = 'desc', $start = 0, $ajax = false){
		modules::run('usuarios/is_logged_in','editor', $this->uri->uri_string());
		modules::run('idioma/set_idioma', 'en');	
		if ($start==0 && empty($_POST) && $order_field == 'newsletter.id_newsletter'){
			$this->session->unset_userdata('terminos_busqueda');
		} 
		$terminos_busqueda = array();
		$terminos_busqueda = $this->session->userdata('terminos_busqueda');
		if(isset($_POST['correo'])) 
		{
			$terminos_busqueda['detalle_contacto.correo'] = $this->input->post('correo');
		}
		if(isset($_POST['creacion']))
		{
			$terminos_busqueda['contacto.creacion'] = $this->input->post('creacion');
		}

		
		if (isset($_POST) && !empty($_POST)){
			$terminos_busqueda = array_filter($terminos_busqueda);
			$this->session->set_userdata('terminos_busqueda',$terminos_busqueda);
		}
		
		$limit = 10;
		$order_string = '';
		$order_string .= ($order_field == "") ? '' : $order_field;
		$order_string .= ($order_dir == "") ? '' : ' '.$order_dir;				
		
		$od = ($order_dir == 'asc') ? 'desc' : 'asc';	
		$data_content['order_field'] = $order_field;
		$data_content['order_dir'] = $order_dir;
		$data_content['order_by_new'] = (($order_field=='') ? 'id_newsletter' : $order_field) . "/". $od;
		$data_content['url'] = lang('backend_url').'/'.lang('contactos_url').'/'.lang('listado_url');
		$config['base_url'] = '/'.lang('backend_url').'/'.lang('contactos_url').'/'.lang('listado_url').'/'.$order_field.'/'.$order_dir;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 6;
		$data_content['num_contactos'] = $this->contacto_model->count_all($terminos_busqueda);
		$config['total_rows'] = $data_content['num_contactos'];
		if ($config['total_rows'] == 0)
		{
			redirect(lang('backend_url').'/'.lang('contactos_url').'/'.lang('buscar_url').'/'.lang('ningun_resultado'));
		}
		 
		$data_content['contactos'] = $this->contacto_model->get_page($start, $limit, $order_field, $order_dir, $terminos_busqueda);
		
		if ($ajax)
		{
			echo json_encode($data_content['contactos']);
		}
		else
		{
			$this->load->library('pagination');
			$this->pagination->initialize($config); 
			$data_content['pagination'] = $this->pagination->create_links();
			$data_content['offset'] = $start;
			$data_content['order_field'] = $order_field;
			$data_content['order_direction'] = $order_dir;
			$data['main_content'] = $this->load->view('back/listado_contacto', $data_content, true);
			$data['active'] = 'contacto';
			if (!empty($terminos_busqueda))
			{
				$data['sub'] = 'buscar';
			}
			else
			{
				$data['sub'] = 'listado';
			}
			$data['title'] = lang('contactos');
			if (!empty($terminos_busqueda))
			{
				$lbc = reset($terminos_busqueda);
				$lbt = key($terminos_busqueda);
				if ($lbt == 'destacado')
				{	
					$lbc='Destacado';
				}
				if ($lbt == 'contacto.id_estado')
				{
					$bcc = modules::run('services/relations/get_from_id','estado',$lbc);
					$lbc = ucwords($bcc->estado);
				}
				$data['breadcrumbs'] = array(lang('backend_url') => lang('backend'), 
											 lang('contactos_url') => lang('contactos'), 
											 lang('contactos_url').'/'.lang('buscar') => lang('busqueda'),'titulo'=>$lbc);
			}
			else
			{
				$data['breadcrumbs'] = array(lang('backend_url') => lang('backend'),
											 lang('contactos_url') => lang('contactos'), 
											 lang('contactos_url').'/'.lang('listado') =>lang('listado')
											 );
			}
			$this->load->view('back/template',$data);
		}
	}
	
	
	function buscar($mensaje=''){
		modules::run('usuarios/is_logged_in','editor', $this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		$data['active'] = 'contacto';
		$data['sub'] = 'buscar';
		$data['title']= lang('buscar_tit_contacto');
		$data['breadcrumbs'] = array(lang('backend_url') => lang('backend'), 
									 lang('contactos_url') => lang('contactos'), 
									 lang('buscar_url') => lang('buscar_tit_ope')
									 );
		$dc['mensaje'] = $mensaje;
		$data['main_content'] = $this->load->view('buscar_contactos', $dc, true);
		$this->load->view('back/template',$data);
	}


	function ficha($id=''){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		if ($id == '')
		{
			redirect(lang('backend_url').'/'.lang('contacto_url'));
		} 
		$data['active'] = 'contacto';
		$data_content['contacto'] = $this->contacto_model->read($id);
		$data['breadcrumbs'] = array(
									 lang('backend_url') => lang('backend'), 
									 lang('contactos_url') => lang('contactos'),''=> lang('ficha'), 
									 $id=> $data_content['contacto']->correo
									);
		$data['title'] = $data_content['contacto']->correo; 
		$data['main_content'] = $this->load->view('back/ficha_contacto', $data_content, true);
		$this->load->view('back/template',$data);
	}
	
	function delete($id, $ajax=false){
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        $ret = $this->contacto_model->delete($id);
        $str = ($ret == true) ? 'true' : 'false';
        if ($ajax)
            echo '[{result:' . $str . '}]';
        else
            return $ret;
	}
	
	function descarga(){
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		modules::run('idioma/set_idioma',$this->session->userdata('idioma')); 
		$data['active'] = 'contacto';
		$data['breadcrumbs'] = array(
									 lang('backend_url') => lang('backend'), 
									 lang('contactos_url') => lang('contactos'),''=> lang('descarga'), 
									);
		$data['title'] = lang('descarga'); 
		$data['main_content'] = $this->load->view('back/descarga_lista', $data, true);
		$this->load->view('back/template', $data);
	}
	
	function descargar_xls()
	{
		$this->load->library("pxl");
		$styleArray = array(
								'font' => array(
												'bold' => true,
												'size' => 14,
												)
							);
		$styleArrayfill = array(
								'fill' => array(
								                    'type'  => PHPExcel_Style_Fill::FILL_SOLID,
								                    'color' => array('rgb'=>'F0F0F0'),
						               	 	   ),
							  );
		$objPHPExcel = new PHPExcel();
		$titulo = lang('titulo_excel').'_'.date('HisdmY');
		$objPHPExcel->getProperties()->setTitle($titulo)->setDescription("descripcion");
		$objPHPExcel->setActiveSheetIndex(0);
		$sheet = $objPHPExcel->setActiveSheetIndex(0);
		$datos = $this->contacto_model->get_emails();
			
		$cell = 'A';
		$row  = '1';
				
		$sheet->setCellValue(('A') . ($row), 'Emails');
		$sheet->setCellValue(('B') . ($row), "Subscription's Date");
				
		$resultados = $datos->result();
				
		foreach ($resultados as $correo)
		{
			$sheet->setCellValue(('A').(++$row), $correo->correo);
			$sheet->setCellValue(('B').($row), $correo->creacion);	
		}
				
		$sheet->getColumnDimension("A")->setAutoSize(true);
		$sheet->getColumnDimension("B")->setAutoSize(true);
		
		$nombre_archivo = 'newsletter_list_'.date('HisdmY');
				
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"{$nombre_archivo}.xls\"");
		header("Cache-Control: max-age=0");
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
		$objWriter->save("php://output");
		exit;
	}
	
	/*
	 * Fin funcciones del admin */
	
	
	/*
	 * Funciones generales, accesibles sin autentificacion */
	
	function read($id,$ajax=false,$detalle_id=''){
		$ret=$this->contacto_model->read($id, $detalle_id);
		if ($ajax) echo json_encode($ret);
		else return $ret;
	}
	
}

/* End of file contacto.php */
