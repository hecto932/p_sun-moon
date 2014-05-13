<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prueba extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		echo "Prueba de CI / ".$this->uri->uri_string();
		$this->load->view('prueba_message');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */