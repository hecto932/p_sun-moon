<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends MX_Controller {

	function __construct()
	{
		
		parent::__construct();
		// Format: modules::run('module/controller/action', $param1, $param2, .., $paramN);  
		modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
		if ($this->session->userdata('idioma')){
			modules::run('idioma/set_idioma', $this->session->userdata('idioma'));	
		} else {
			modules::run('idioma/set_idioma', 'es');
		}
		$this->lang->load('back');
		
	}
	
	function index()
	{
		//echo "Esto es el index";
		//$this->categorias('listado');
		redirect(lang('backend_url').'/'.lang('servicios_url'));
	}
	
	function home($function='',$id='')
	{

		if ($function=='' && $id==""){

			//modules::run('services/monitor/add','home','',$this->session->userdata('id_usuario'),'listado');
			echo modules::run('home/ficha');
		}else{
			//modules::run('services/monitor/add','home','',$this->session->userdata('id_usuario'),'listado');
			echo modules::run('home/'.$function,$id);			
		}
		
	}
	
	function usuarios($res='listado',$order_field='id_usuario',$order_dir='desc',$start=0,$ajax=false)
	{
		modules::run('services/monitor/add','usuario','',$this->session->userdata('id_usuario'),'listado');
		echo modules::run('usuario/'.$res,$order_field,$order_dir,$start,$ajax);
	}
	
	function buscar_usuarios()
	{
		echo modules::run('usuario/buscar');
	}
	
	function crear_usuario()
	{
		echo modules::run('usuario/create');
	}
	
	function borrar_usuario($id='',$ajax=false)
	{
		if ($id=='') redirect('backend/usuarios');
		//$res=modules::run('usuario/delete',$id,$ajax);
		$res=modules::run('usuario/delete_user',$id,$ajax);
		modules::run('services/monitor/add','usuario',$id,$this->session->userdata('id_usuario'),'borrar');
		redirect('backend/usuarios');
	}
	function ficha_usuario($id='')
	{
		if ($id==''){
			redirect('backend/usuarios');
		}else{
			modules::run('services/monitor/add','usuario',$id,$this->session->userdata('id_usuario'),'ficha');
			echo modules::run('usuario/ficha',$id);
		}
	}
	function editar_usuario($id='')
	{
		if ($id=='') redirect('backend/crear_usuario');
		echo modules::run('usuario/edit',$id);
	}
	
	
	/************************* GESTION DE CANALES *********************************/
	
	function canales($res='listado',$order_field = 'id_canal', $order_dir='desc', $start=0, $ajax=false){
		modules::run('services/monitor/add','canales','',$this->session->userdata('id_usuario'), 'listado');
		echo modules::run('canales/'.$res, $order_field, $order_dir, $start, $ajax);
	}
	
	function buscar_canales(){
		modules::run('services/monitor/add','canales','',$this->session->userdata('id_usuario'),'buscar');
		echo modules::run('canales/buscar');
	}
	
	function crear_canal(){
		echo modules::run('canales/crear');
	}
	
	function borrar_canal($id='',$ajax=false){
		if ($id=='') redirect('backend/canales');
		$res=modules::run('canales/delete',$id,$ajax);
		modules::run('services/monitor/add','canales', $id, $this->session->userdata('id_usuario'),'borrar');
		redirect('backend/canales');
	}
	
	function ficha_canal($id=''){
		if ($id==''){
			redirect('backend/canales');
		}else{
			modules::run('services/monitor/add','canales',$id,$this->session->userdata('id_usuario'),'ficha');
			echo modules::run('canales/ficha',$id);
		}
	}

	function editar_canal($id=''){
		if ($id=='') redirect('backend/crear_canal');
		echo modules::run('canales/edit',$id);
	}

	/************************* FIN GESTION DE CANALES *******************************/
	
	/************************* GESTION DE CATEGORIAS *******************************/
	
		
	function categorias($res='listado',$order_field='id_categoria',$order_dir='desc',$start=0,$ajax=false)
	{
		modules::run('services/monitor/add','categoria','',$this->session->userdata('id_usuario'),'listado');
		echo modules::run('categoria/'.$res,$order_field,$order_dir,$start,$ajax);
	}
	
	function buscar_categorias()
	{
		echo modules::run('categoria/buscar');
	}
	
	function crear_categoria()
	{
		echo modules::run('categoria/crear');
	}
	function borrar_categoria($id='',$ajax=false)
	{
		if ($id=='') redirect('backend/categorias');
		$res=modules::run('categoria/delete',$id,$ajax);
		modules::run('services/monitor/add','categoria',$id,$this->session->userdata('id_usuario'),'borrar');
		redirect('backend/categorias');
	}
	function ficha_categoria($id='')
	{
		if ($id==''){
		redirect('backend/categorias');
		}else{
			modules::run('services/monitor/add','categoria',$id,$this->session->userdata('id_usuario'),'ficha');
			echo modules::run('categoria/ficha',$id);
		}
	}
	function editar_categoria($id='')
	{
		if ($id=='') redirect('backend/crear_categoria');
		echo modules::run('categoria/edit',$id);
	}
	
	
		
	function faqs($res='listado',$order_field='id_faq',$order_dir='desc',$start=0,$ajax=false)
	{
		modules::run('services/monitor/add','faq','',$this->session->userdata('id_usuario'),'listado');
		echo modules::run('faq/'.$res,$order_field,$order_dir,$start,$ajax);
	}
	
	function buscar_faqs()
	{
		echo modules::run('faq/buscar');
	}
	
	function crear_faq()
	{
		echo modules::run('faq/crear');
	}
	function borrar_faq($id='',$ajax=false)
	{
		if ($id=='') redirect('backend/faqs');
		$res=modules::run('faq/delete',$id,$ajax);
		modules::run('services/monitor/add','faq',$id,$this->session->userdata('id_usuario'),'borrar');
		redirect('backend/faqs');
	}
	function ficha_faq($id='')
	{
		if ($id==''){
		redirect('backend/faqs');
		}else{
			modules::run('services/monitor/add','faq',$id,$this->session->userdata('id_usuario'),'ficha');
			echo modules::run('faq/ficha',$id);
		}
	}
	function editar_faq($id='')
	{
		if ($id=='') redirect('backend/crear_faq');
		echo modules::run('faq/edit',$id);
	}
	
	/************************* GESTION DE NOTICIAS *********************************/
	
	function noticias($res='listado',$order_field='noticia.id_noticia',$order_dir='desc',$start=0,$ajax=false)
	{
		modules::run('services/monitor/add','noticias','',$this->session->userdata('id_usuario'),'listado');
		echo modules::run('noticia/'.$res,$order_field,$order_dir,$start,$ajax);
	}
	
	function buscar_noticias()
	{
		echo modules::run('noticia/buscar');
	}
	
	function crear_noticia()
	{
		echo modules::run('noticia/crear');
	}
	function borrar_noticia($id='',$ajax=false)
	{
		if ($id=='') redirect('backend/noticias');
		$res=modules::run('noticia/delete',$id,$ajax);
		modules::run('services/monitor/add','noticias',$id,$this->session->userdata('id_usuario'),'borrar');
		redirect('backend/noticias');
	}
	function ficha_noticia($id='')
	{
		if ($id==''){
		redirect('backend/noticias');
		}else{
			modules::run('services/monitor/add','noticia',$id,$this->session->userdata('id_usuario'),'ficha');
			echo modules::run('noticia/ficha',$id);
		}
	}
	function editar_noticia($id='')
	{
		if ($id=='') redirect('backend/crear_noticia');
		echo modules::run('noticia/edit',$id);
	}
	/************************* FIN GESTION DE NOTICIAS *********************************/
	function borrar_membresia($id='',$ajax=false)
	{
		if ($id=='') redirect('backend/membresias');
		$res=modules::run('membresias/delete',$id,$ajax);
		modules::run('services/monitor/add','membresias',$id,$this->session->userdata('id_usuario'),'borrar');
		redirect('backend/membresias');
	}
	
	function borrar_inscripcion($id='',$id_evento='',$ajax=false)
	{
		if ($id=='') redirect('backend/eventos');
		if ($id_evento=='') redirect('backend/eventos');
		$res=modules::run('evento/delete_insc',$id,$ajax);
		modules::run('services/monitor/add','evento',$id,$this->session->userdata('id_usuario'),'borrar');
		redirect('backend/eventos/inscripciones/'.$id_evento);
	}
	/************************* GESTION DE SERVICIOS *********************************/
	
	function servicio($res='listado',$order_field='servicio.id_servicio',$order_dir='desc',$start=0,$ajax=false)
	{
		modules::run('services/monitor/add','servicios','',$this->session->userdata('id_usuario'),'listado');
		echo modules::run('servicio/'.$res,$order_field,$order_dir,$start,$ajax);
	}
	
	function buscar_servicios()
	{
		echo modules::run('servicio/buscar');
	}
	
	function crear_servicio()
	{
		echo modules::run('servicio/crear');
	}
	function borrar_servicio($id='',$ajax=false)
	{
		if ($id=='') redirect('backend/servicios');
		$res=modules::run('servicio/delete',$id,$ajax);
		modules::run('services/monitor/add','servicios',$id,$this->session->userdata('id_usuario'),'borrar');
		redirect('backend/servicios');
	}
	function ficha_servicio($id='')
	{
		if ($id==''){
		redirect('backend/servicios');
		}else{
			modules::run('services/monitor/add','servicio',$id,$this->session->userdata('id_usuario'),'ficha');
			echo modules::run('servicio/ficha',$id);
		}
	}
	function editar_servicio($id='')
	{
		if ($id=='') redirect('backend/crear_servicio');
		echo modules::run('servicio/edit',$id);
	}
	/************************* FIN GESTION DE SERVICIOS *********************************/
	
	/************************* GESTION DE OPERADORAS *********************************/
	
	function operadoras($res= 'listado' ,$order_field = 'id_operadora', $order_dir = 'desc', $start = 0, $ajax = false)
	{
		modules::run('services/monitor/add','operadora','',$this->session->userdata('id_usuario'),'listado');
		echo modules::run('operadora/'.$res, $order_field, $order_dir, $start, $ajax);
	}

	function operadora($res = 'listado', $order_field = 'id_operadora', $order_dir = 'desc', $start = 0, $ajax = false)
	{
		modules::run('services/monitor/add','operadora','',$this->session->userdata('id_usuario'),'listado');
		echo modules::run('operadora/'.$res,$order_field,$order_dir,$start,$ajax);
	}
	
	function buscar_operadoras()
	{
		modules::run('services/monitor/add','operadora','',$this->session->userdata('id_usuario'),'buscar');
		echo modules::run('operadora/buscar');
	}
	
	function crear_operadoras()
	{
		echo modules::run('operadora/crear');
	}
	
	function borrar_operadora($id='',$ajax=false)
	{
		if ($id=='') redirect('backend/operadora');
		$res=modules::run('operadora/delete',$id,$ajax);
		modules::run('services/monitor/add','operadora', $id, $this->session->userdata('id_usuario'), 'borrar');
		redirect('backend/operadora');
	}

	function ficha_operadora($id='')
	{
		if ($id=='')
		{
			redirect('backend/operadoras');
		}
		else
		{
			modules::run('services/monitor/add','operadora',$id,$this->session->userdata('id_usuario'),'ficha');
			echo modules::run('operadora/ficha',$id);
		}
	}
	function editar_operadora($id='')
	{
		if ($id=='') redirect('backend/crear_operadoras');
		echo modules::run('operadora/edit',$id);
	}
	
	
	/************************* FIN GESTION DE NOTICIAS *********************************/

	/************************* GESTION DE PROMOCIONES *********************************/
	
	function promociones($res='listado',$order_field='promocion.id_promocion',$order_dir='desc',$start=0,$ajax=false)
	{
		modules::run('services/monitor/add','promociones','',$this->session->userdata('id_usuario'),'listado');
		echo modules::run('promocion/'.$res,$order_field,$order_dir,$start,$ajax);
	}
	
	function buscar_promociones()
	{
		echo modules::run('promocion/buscar');
	}
	
	function crear_promocion()
	{
		echo modules::run('promocion/crear');
	}
	function borrar_promocion($id='',$ajax=false)
	{
		if ($id=='') redirect('backend/promociones');
		$res=modules::run('promocion/delete',$id,$ajax);
		modules::run('services/monitor/add','promociones',$id,$this->session->userdata('id_usuario'),'borrar');
		redirect('backend/promociones');
	}
	function ficha_promocion($id='')
	{
		if ($id==''){
		redirect('backend/promociones');
		}else{
			modules::run('services/monitor/add','promocion',$id,$this->session->userdata('id_usuario'),'ficha');
			echo modules::run('promocion/ficha',$id);
		}
	}
	function editar_promocion($id='')
	{
		if ($id=='') redirect('backend/crear_promocion');
		echo modules::run('promocion/edit',$id);
	}
	/************************* FIN GESTION DE PROMOCIONES *********************************/
	
	/****************************** GESTION DE PRODUCTOS *********************************/
		
	function productos($res='listado',$order_field='id_producto',$order_dir='desc',$start=0,$ajax=false)
	{
		modules::run('services/monitor/add','producto','',$this->session->userdata('id_usuario'),'listado');
		echo modules::run('producto/'.$res,$order_field,$order_dir,$start,$ajax);
	}
	
	function buscar_productos()
	{
		modules::run('services/monitor/add','producto','',$this->session->userdata('id_usuario'),'buscar');
		echo modules::run('producto/buscar');
	}
	
	function crear_producto()
	{
		echo modules::run('producto/crear');
	}
	function borrar_producto($id='',$ajax=false)
	{
		if ($id=='') redirect('backend/producto');
		$res=modules::run('producto/delete',$id,$ajax);
		modules::run('services/monitor/add','producto',$id,$this->session->userdata('id_usuario'),'borrar');
		redirect('backend/productos');
	}
	function ficha_producto($id='')
	{
		if ($id==''){
		redirect('backend/productos');
		}else{
			modules::run('services/monitor/add','producto',$id,$this->session->userdata('id_usuario'),'ficha');
			echo modules::run('producto/ficha',$id);
		}
	}
	function editar_producto($id='')
	{
		if ($id=='') redirect('backend/crear_producto');
		echo modules::run('producto/edit',$id);
	}
	/************************* FIN GESTION DE PRODUCTOS **********************************/
	

	
	function monitor($res='listado',$order_field='id_monitor',$order_dir='desc',$start=0,$ajax=false)
	{
		//
		echo modules::run('monitor/'.$res,$order_field,$order_dir,$start,$ajax);
		modules::run('services/monitor/add','monitor','',$this->session->userdata('id_usuario'),'listado');
	}
	
	function buscar_monitor()
	{
		
		echo modules::run('monitor/buscar');
		modules::run('services/monitor/add','monitor','',$this->session->userdata('id_usuario'),'buscar');
	}
	
	
	
	/***************************** GESTION DE MULTIMEDIA *********************************/
	
	function multimedia($res='listado',$order_field='multimedia.id_multimedia',$order_dir='desc',$start=0,$ajax=false)
	{
		modules::run('services/monitor/add','multimedia','',$this->session->userdata('id_usuario'),'listado');
		echo modules::run('multimedia/'.$res,$order_field,$order_dir,$start,$ajax);
	}
	
	function buscar_multimedia()
	{
		modules::run('services/monitor/add','multimedia','',$this->session->userdata('id_usuario'),'buscar');
		echo modules::run('multimedia/buscar');
	}
	
	function crear_multimedia()
	{
		echo modules::run('multimedia/crear');
	}
	function borrar_multimedia($id='',$ajax=false)
	{
		if ($id=='') redirect('backend/multimedia');
		modules::run('services/monitor/add','multimedia',$id,$this->session->userdata('id_usuario'),'borrar');
		$res=modules::run('multimedia/delete',$id,$ajax);
		if ($ajax){
			echo $res;
		}else{
			$r=($this->session->userdata('back')!='' ? $this->session->userdata('back') : 'backend/multimedia');
			redirect($r);
			
		}
	}
	function ficha_multimedia($id='')
	{
		if ($id=='') redirect('backend/multimedia');
		modules::run('services/monitor/add','multimedia',$id,$this->session->userdata('id_usuario'),'ficha');
		echo modules::run('multimedia/ficha',$id);
	}
	function editar_multimedia($id='')
	{
		if ($id=='') redirect('backend/crear_multimedia');

		echo modules::run('multimedia/edit',$id);
	}
	
	/***************************** FIN GESTION DE MULTIMEDIA *********************************/

	
		/****************************** GESTION DE BANNERS *********************************/
		
	function banners($res='listado',$order_field='id_banner',$order_dir='desc',$start=0,$ajax=false)
	{
		modules::run('services/monitor/add','banner','',$this->session->userdata('id_usuario'),'listado');
		echo modules::run('banner/'.$res,$order_field,$order_dir,$start,$ajax);
	}
	
	function buscar_banners()
	{
		modules::run('services/monitor/add','banner','',$this->session->userdata('id_usuario'),'buscar');
		echo modules::run('banner/buscar');
	}
	
	function crear_banner()
	{
		echo modules::run('banner/crear');
	}
	function borrar_banner($id='',$ajax=false)
	{
		if ($id=='') redirect('backend/banner');
		$res=modules::run('banner/delete',$id,$ajax);
		modules::run('services/monitor/add','banner',$id,$this->session->userdata('id_usuario'),'borrar');
		redirect('backend/banners');
	}
	function ficha_banner($id='')
	{
		if ($id==''){
		redirect('backend/banners');
		}else{
			modules::run('services/monitor/add','banner',$id,$this->session->userdata('id_usuario'),'ficha');
			echo modules::run('banner/ficha',$id);
		}
	}
	function editar_banner($id='')
	{
		if ($id=='') redirect('backend/crear_banner');
		echo modules::run('banner/edit',$id);
	}
	/************************* FIN GESTION DE BANNERS **********************************/
	
	/****************************** GESTION DE PROYECTOS *********************************/
		
	function proyectos($res='listado',$order_field='id_proyecto',$order_dir='desc',$start=0,$ajax=false)
	{
		modules::run('services/monitor/add','proyecto','',$this->session->userdata('id_usuario'),'listado');
		echo modules::run('proyecto/'.$res,$order_field,$order_dir,$start,$ajax);
	}

	function proyecto($res='listado',$order_field='id_proyecto',$order_dir='desc',$start=0,$ajax=false)
	{
		modules::run('services/monitor/add','proyecto','',$this->session->userdata('id_usuario'),'listado');
		echo modules::run('proyecto/'.$res,$order_field,$order_dir,$start,$ajax);
	}
	
	function buscar_proyectos()
	{
		modules::run('services/monitor/add','proyecto','',$this->session->userdata('id_usuario'),'buscar');
		echo modules::run('proyecto/buscar');
	}
	
	function crear_proyecto()
	{
		echo modules::run('proyecto/crear');
	}
	
	function borrar_proyecto($id='',$ajax=false)
	{
		if ($id=='') redirect('backend/proyecto');
		$res=modules::run('proyecto/delete',$id,$ajax);
		modules::run('services/monitor/add','proyecto',$id,$this->session->userdata('id_usuario'),'borrar');
		redirect('backend/proyecto');
	}

	function ficha_proyecto($id='')
	{
		if ($id==''){
		redirect('backend/proyectos');
		}else{
			modules::run('services/monitor/add','proyecto',$id,$this->session->userdata('id_usuario'),'ficha');
			echo modules::run('proyecto/ficha',$id);
		}
	}
	function editar_proyecto($id='')
	{
		if ($id=='') redirect('backend/crear_proyecto');
		echo modules::run('proyecto/edit',$id);
	}
	
	/************************* FIN GESTION DE PROYECTOS **********************************/
	
	/****************************** GESTION DE TRABAJOS *********************************/
	
	
	function trabajos($res='listado',$order_field='id_trabajo',$order_dir='desc',$start=0,$ajax=false)
	{
		modules::run('services/monitor/add','trabajo','',$this->session->userdata('id_usuario'),'listado');
		echo modules::run('trabajo/'.$res,$order_field,$order_dir,$start,$ajax);
	}

	function trabajo($res='listado',$order_field='id_trabajo',$order_dir='desc',$start=0,$ajax=false)
	{
		modules::run('services/monitor/add','trabajo','',$this->session->userdata('id_usuario'),'listado');
		echo modules::run('trabajo/'.$res,$order_field,$order_dir,$start,$ajax);
	}
	
	function buscar_trabajos()
	{
		modules::run('services/monitor/add','trabajo','',$this->session->userdata('id_usuario'),'buscar');
		echo modules::run('trabajo/buscar');
	}
	
	function crear_trabajos()
	{
		echo modules::run('trabajo/crear');
	}
	
	function borrar_trabajo($id='',$ajax=false)
	{
		if ($id=='') redirect('backend/trabajo');
		$res=modules::run('trabajo/delete',$id,$ajax);
		modules::run('services/monitor/add','trabajo',$id,$this->session->userdata('id_usuario'),'borrar');
		redirect('backend/trabajo');
	}

	function ficha_trabajo($id='')
	{
		if ($id==''){
		redirect('backend/trabajos');
		}else{
			modules::run('services/monitor/add','trabajo',$id,$this->session->userdata('id_usuario'),'ficha');
			echo modules::run('trabajo/ficha',$id);
		}
	}
	function editar_trabajo($id='')
	{
		if ($id=='') redirect('backend/crear_trabajo');
		echo modules::run('trabajo/edit',$id);
	}
	
	
	/************************* FIN GESTION DE TRABAJOS **********************************/
	function idioma_post(){
		$result=modules::run('idioma/cambiar_post');
	}
	function cambiar_idioma($code){
		$result=modules::run('idioma/cambiar',$code);
	}
	

	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
