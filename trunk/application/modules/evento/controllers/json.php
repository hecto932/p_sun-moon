<?php defined('BASEPATH') OR exit('No se permite el acceso directo.');

/**
 * Controlador para llamadas JSON de eventos e inscripciones
 * @author Ale
 *
 */
class Json extends MX_Controller
{
	/**
	 * Constructor de constrolador JSON
	 * @author Ale
	 */
	public function __construct()
	{
		parent::__construct();
		
		modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
		
		$this->load->model('usuario_model', 'usuarios');
		$this->load->model('factura_model', 'facturacion');
		$this->load->model('empresa_model', 'empresas');
		$this->load->model('disponibilidad_hospedaje_model', 'hospedaje');
	}
	
	/**
	 * Retorna información de usuario por JSON
	 * Recibe cedula o rif por POST
	 * @author Ale
	 */
	public function get_usuario()
	{
		$cedula = $this->input->post('cedula');
		$rif = $this->input->post('rif');
		$email = $this->input->post('email');
		$id_usuario = $this->input->post('id_usuario');
		
		//Obtener datos del usuario (si existe)
		if ( ! empty($cedula))
		{
			$datos = $this->usuarios->get_from_cedula($cedula);
		}
		else if ( ! empty($rif))
		{
			$datos = $this->usuarios->get_from_rif($rif);
		}
		else if ( ! empty($email))
		{
			$datos = $this->usuarios->get_from_email($email);
		}
		else if ( ! empty($id_usuario))
		{
			$datos = $this->usuarios->get($id_usuario);
		}
		else
		{
			$datos = array();
		}
		
		echo json_encode($datos);
	}
	
	/**
	 * Retorna información de empresa por JSON
	 * Recibe RIF por POST
	 * @author Ale
	 */
	public function get_empresa()
	{
		$rif = $this->input->post('rif');
		$id_empresa = $this->input->post('id_empresa');
		
		if ( ! empty($rif))
		{
			$datos = $this->empresas->get_from_rif($rif);
		}
		else if ( ! empty($id_empresa))
		{
			$datos = $this->empresas->get($id_empresa);
		}
		else
		{
			$datos = array();
		}
		
		echo json_encode($datos);
	}
	
	/**
	 * Retorna opciones de nombre de factura
	 * Recibe un modo de facturación por POST
	 * @author Ale
	 */
	public function get_nombre_factura()
	{
		$modo = $this->input->post('modo');
		echo json_encode($this->facturacion->get_nombres_factura($modo));
	}
	
	/**
	 * Retorna las empresas a las que pertenece un usuario
	 * Recibe id_usuario desde POST
	 * @author Ale
	 */
	public function get_empresas_from_usuario()
	{
		$id_usuario = $this->input->post('id_usuario');
		echo json_encode($this->usuarios->get_empresas_from_usuario($id_usuario));
	}
	
	/**
	 * Retorna hospedaje disponible para un evento
	 * Recibe id_evento por POST
	 * @author Ale
	 */
	public function get_hospedaje_disponible()
	{
		$id_evento = $this->input->post('id_evento');
		echo json_encode($this->hospedaje->get_disponible($id_evento));
	}
}