<?php

class Services extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		// Format: modules::run('module/controller/action', $param1, $param2, .., $paramN);  
		//$var=modules::run('usuarios/is_logged_in');
		//echo (string)$var;
		//if ($var!=true) redirect('usuarios');
		//echo '<pre>'.print_r($this->session->userdata,true).'</pre>';
		//if ($var==true) echo 'logged in';
		//else echo 'not logged in';
		$this->xml='';
		$this->xls=array();
		$this->cat=array();
		$this->last_artista_id=0;
		$this->last_obra_id=0;
		$this->obras=array();
		ini_set('memory_limit','256M');
		$this->load->model('services_model');
		modules::run('usuarios/is_logged_in','admin',uri_string());
		
	}
	
	function index()
	{
		
	}
	function _format_fecha_artista($fecha){
		$f[0]='';
		$f[1]='';
		$fecha=str_replace('–','-',$fecha);
		$fechas=explode('-',$fecha);
		if (isset($fechas[1])){
			$f[0]=trim($fechas[0]);
			$f[1]=trim($fechas[1]);
		}else{
			$fe=preg_replace('/([^0-9]+)/','',$fecha);
			if (strpos($fecha,'falleci')!==false) $f[1]=$fe;
			else $f[0]=$fe;
		}
		//if ($fechas['fallecimiento']!='0000-00-00') $fechas['fallecimiento'].='-01-01';
		//if ($fechas['nacimiento']!='0000-00-00') $fechas['nacimiento'].='-01-01';
		return $f;
	}
	function _format_lugares_artista($lugar){
		$l[0]='';
		$l[1]='';

		$lugares=explode('-',$lugar);
		if (isset($lugares[1])){
			$l[0]=trim($lugares[0]);
			$l[1]=trim($lugares[1]);
		}else{
			if (strpos($lugar,'falleci')!==false) $l[1]=$lugar;
			else $l[0]=$lugar;
		}
		//if ($fechas['fallecimiento']!='0000-00-00') $fechas['fallecimiento'].='-01-01';
		//if ($fechas['nacimiento']!='0000-00-00') $fechas['nacimiento'].='-01-01';
		return $l;
	}
	function _format_nombre_artista($nombre){

		$nombre=explode(',',$nombre);
		$nombre[0]=trim($nombre[0]);
		if (isset($nombre[1]))
			$nombre[1]=trim($nombre[1]);
		else  $nombre[1]='';
		//if ($fechas['fallecimiento']!='0000-00-00') $fechas['fallecimiento'].='-01-01';
		//if ($fechas['nacimiento']!='0000-00-00') $fechas['nacimiento'].='-01-01';
		return $nombre;
	}
	function _format_medidas($medidas){
		$medidas=preg_replace('/([^0-9x, ]+)/','',$medidas);
		$medida=explode('x',$medidas);
		$medida[0]=trim($medida[0]);
		if (isset($medida[1]))
			$medida[1]=trim(substr($medida[1],0,5));
		else  $medida[1]='';
		//if ($fechas['fallecimiento']!='0000-00-00') $fechas['fallecimiento'].='-01-01';
		//if ($fechas['nacimiento']!='0000-00-00') $fechas['nacimiento'].='-01-01';
		return $medida;
	}
	function _format_fecha($fecha){
		$fecha=str_replace('de ','',$fecha);
		$hacia=array('h.','c.','ca.','Hacia');
		$r=false;
		foreach ($hacia as $h){
			if(strpos($fecha,$h)!==false) $r=true;
		}
		if($r){
			$ret['ca']='Ca.';
			if (preg_match('/([0-9]{4})/',$fecha,$f)){
				$ret['ano']=$f[0];
				$ret['mes']=0;
				$ret['dia']=0;
			}
				
		}else{
			$f=explode(' ',$fecha);
			$f=array_reverse($f);
			$ret['ano']=$f[0];
			if (isset($f[1])) $ret['mes']=$f[1];
			else $ret['mes']=0;
			if (isset($f[2])) $ret['dia']=$f[2];
			else $ret['dia']=0;
		}
		//echo '<pre>'.print_r($ret,true).'</pre>';
		return $ret;
	}
	function _parse_artistas_relacionados($item,$str){
		$rel=explode(',',$str);
		foreach($rel as $k=>$r){
			if (preg_match('/[a-zA-Z]+/',$r)){
				$r=preg_replace('/([a-zA-Z]*)/','',$r);
				$r+=$this->last_artista_id;
			}
			$ret[$k]['id_artista']=$item;
			
			$ret[$k]['id_artista_relacionado']=(int)trim($r);
		}
		return $ret;
	}
	function _parse_obras_relacionadas($item,$str){
		$rel=explode(',',$str);
		foreach($rel as $k=>$r){
			if (preg_match('/[a-zA-Z]+/',$r)){
				$r=preg_replace('/([a-zA-Z]+)/','',$r);
				$r=(int)trim($r) + $this->last_obra_id;
			}
			$ret[$k]['id_obra']=$item;
			$ret[$k]['id_obra_relacionada']=(int)trim($r);
		}
		return $ret;
	}
	function _import_artistas($tipo='xml'){
		$artistas=($tipo=='xml') ? $this->xml->Artistas : $this->xls['artistas'];
		$last_id=$this->services_model->get_last_id('artista');
		foreach($artistas as $artista){
			if ($tipo=='xml'){
				list($art['main']['ano_nacimiento'],$art['main']['ano_fallecimiento'])=$this->_format_fecha_artista((string)$artista->Fecha);

				list($art['detalle']['localidad_nacimiento'],$art['detalle']['localidad_fallecimiento'])=$this->_format_lugares_artista((string)$artista->Lugar);
				list($art['main']['apellidos'],$art['main']['nombre'])=$this->_format_nombre_artista((string)$artista->Nombre);
				$art['detalle']['biografia']=(string)$artista->Biografia;
				$art['detalle']['id_artista']=(string)$artista->ID + 1;
				$art['main']['id_artista']=(string)$artista->ID + 1;
				$art['detalle']['id_idioma']= 1;
			}elseif($tipo=='xls'){
				$art['main']['ano_nacimiento']=$artista[5];
				if (isset($artista[6]))
					$art['main']['ano_fallecimiento']=$artista[6];

				
				//$art['main']['lugar_fallecimiento']=$this->_format_lugares_artista((string)$artista->Lugar);
				$art['main']['apellidos']=trim($artista[3]." ".$artista[4]);
				$art['main']['nombre']=$artista[2];
				
				//echo '<pre>'.print_r($last_id,true).'</pre>';
				$id=(int)substr($artista[1],1) + $last_id;
				$this->last_artista_id=$last_id;
				$art['main']['id_artista']=$id;
				$art['detalle']['id_artista']=$id;
				$art['detalle']['biografia']= $artista[7];
				$art['detalle']['localidad_nacimiento']=$artista[8];
				$art['detalle']['id_idioma']= $artista[9];
				$art['detalle']['url']= $artista[10];
				$art['detalle']['titulo_pagina']= $artista[11];
				$art['detalle']['descripcion_pagina']= $artista[12];
				$art_rel[$id]['rel']=$this->_parse_artistas_relacionados($id,$artista[13]);
			}
				
				
				$art['main']['id_estado']=1;
			

			if (!$this->services_model->insert_full_data($art,'artista')){
				throw new Exception("<h2>Los artistas no se han podido importar</h2>");
			}
		}
		if (isset($art_rel) && is_array($art_rel)){
			foreach ($art_rel as $a_rel){
				if (!$this->services_model->insert_rel($a_rel,'artista')){
					throw new Exception("<h2>Los artistas no se han podido relacionar</h2>");
				}
			}
		}
	}
	function _import_tecnicas(){
		foreach($this->xml->Tecnicas as $tecnica){
			//echo '<pre>'.print_r($artista,true).'</pre>';
/*
 *   <Tecnicas>
    <ID>227</ID>
    <Nombre>Tinta china y acuarela sobre papel </Nombre>
    <NombreExtendido />
  </Tecnicas>
  * */		
			$tec['main']['id_tecnica']=(int)$tecnica->ID + 1;
			$tec['main']['id_estado']=1;
			$tec['detalle']['id_tecnica']=(int)$tecnica->ID + 1;
			$tec['detalle']['nombre']=(string)$tecnica->Nombre;
			$tec['detalle']['id_idioma']=1;
			$tec['detalle']['descripcion']=(string)$tecnica->NombreExtendido;

			if (!$this->services_model->insert_full_data($tec,'tecnica')){
				throw new Exception("<h2>Las tecnicas no se han podido importar</h2>");
			}

		}
		
	}
	function _import_categorias(){
		foreach($this->xml->Tipos as $ti){
			$tipo['main']['id_categoria']=$ti->ID + 1;
			$tipo['main']['id_estado']=1;
			$tipo['detalle']['id_categoria']=$ti->ID + 1;
			$tipo['detalle']['id_idioma']=1;
			$tipo['detalle']['nombre']=(string)$ti->Nombre;
			if (!$this->services_model->insert_full_data($tipo,'categoria')){
				throw new Exception("<h2>Las categorias no se han podido importar</h2>");
			}
		}
	}
	function _read_obras(){
		
		
		foreach($this->xml->Obras as $ob){
			//echo '<pre>'.print_r($artista,true).'</pre>';
			$id=(int)$ob->IDcoleccion + 1;
			$obra['main']['id_obra']=(int)$ob->ID + 1;
			$obra['main']['id_artista']=(int)$ob->IDartista + 1;
			
			$obra['rel'][0]['id_coleccion']=$id;
			$obra['rel'][0]['id_obra']=$obra['main']['id_obra'];
			$obra['main']['id_tecnica']=(int)$ob->IDtecnica + 1;
			$obra['main']['id_categoria']=(int)$ob->IDtipo + 1;
			$obra['main']['id_estado']=1;
			$this->cat[$id]=$obra['main']['id_categoria'];
			if((string)$ob->FechaBool=='true'){
				
				if (preg_match('/([0-9]{4})/',(string)$ob->Fecha)){
					$f=$this->_format_fecha((string)$ob->Fecha);
					
			//	}elseif((string)$ob->PublicadoEn != ''){
			//		$f=$this->_format_fecha((string)$ob->PublicadoEn);
					
				}
				$obra['main']['ano']=$f['ano'];
				$obra['main']['mes']=$f['mes'];
				$obra['main']['dia']=$f['dia'];
				if (isset($f['ca'])) $obra['main']['fecha_aprox']=1;
			}
			$obra['main']['numero_inventario']=(int)$ob->NMAP;
			$na=(string)$ob->NuevaAdquisicion;
			if ($na=='false' || $na=='False') $na=0;
			elseif($na=='true' || $na=='True') $na=1;
			$medidas=$this->_format_medidas((string)$ob->Medidas);
			$obra['main']['ancho']=$medidas[0];
			$obra['main']['alto']=$medidas[1];
			$obra['main']['nueva_adquisicion']=$na;
			$obra['detalle']['id_obra']=(int)$ob->ID + 1;
			$obra['detalle']['publicado_en']=(string)$ob->PublicadoEn;
			$obra['detalle']['titulo_y_pie']=(string)$ob->TituloYpie;
			$obra['detalle']['inscripcion']=(string)$ob->Inscripcion;
			$obra['detalle']['titulo']=(string)$ob->Titulo;
			$obra['detalle']['id_idioma']=1;
			$this->obras[]=$obra;
			
			
		}
		
	}
	
	function _import_obras($tipo='xml'){
		if ($tipo=='xml'){
			foreach($this->obras as $obra){
				if (!$this->services_model->insert_full_data($obra,'obra')){
					throw new Exception("<h2>Las obras no se han podido importar</h2>");
				}
				$this->services_model->insert_rel($obra,'obra','coleccion');
			}
		}elseif($tipo=='xls'){
			$obras=$this->xls['obras'];
			$last_id=$this->services_model->get_last_id('obra');
			$this->last_obra_id=$last_id;
			foreach($obras as $ob){
				$obra=array();
				$id=(int)substr($ob[1],1) + $last_id;
				
				$obra['main']['id_obra']=$id;
				if (preg_match('/[a-zA-Z]+/',$ob[19]))
					$id_artista=(int)substr($ob[19],1) + $this->last_artista_id;
				else
					$id_artista=$ob[19];
				$obra['main']['id_artista']=$id_artista;
				//$obra['main']['id_coleccion']=(int)$ob->IDcoleccion ;
				$obra['main']['id_categoria']=(int)$ob[18];
				$obra['main']['id_estado']=1;

				$obra['main']['ano']=(int)$ob[13];
				if (isset($ob[12]))
					$obra['main']['mes']=(int)$ob[12];
				else $obra['main']['mes']='';
				if (isset($ob[11]))
					$obra['main']['dia']=(int)$ob[11];
				else $obra['main']['dia']='';
				//$obra['detalle']['fecha_aprox']=1;
				$obra['main']['numero_inventario']=(int)$ob[10];
				$na=(string)$ob[16];
				if ($na=='Si' || $na=='si') $na=1;
				else $na=0;
				$obra['main']['ancho']=$ob[14];
				$obra['main']['alto']=$ob[15];
				$obra['main']['id_tecnica']=$ob[17];
				$obra['main']['nueva_adquisicion']=$na;
				$obra['detalle']['id_obra']=$id;
				$obra['detalle']['publicado_en']=(string)$ob[8];
				$obra['detalle']['descripcion_breve']=(string)$ob[4];
				$obra['detalle']['descripcion_ampliada']=(string)$ob[5];
				$obra['detalle']['url']=(string)$ob[21];
				$obra['detalle']['titulo_pagina']=(string)$ob[22];
				$obra['detalle']['descripcion_pagina']=(string)$ob[23];
				$obra['detalle']['titulo_y_pie']=(string)$ob[7];
				//$obra['detalle']['inscripcion']=(string)$ob->Inscripcion;
				$obra['detalle']['titulo']=(string)$ob[2];
				$obra['detalle']['id_idioma']=(int)$ob[20];
				
				$parent_id=$id;
				/*
	id_multimedia		 	
	fichero		 	 	 	 	 	 	
	thumbnail		 	 	 	 	 	 	
	id_tipo		 	 	 	 	 	 	
	id_estado
	* */
				
				$obras_rel[$id]['rel']=$this->_parse_obras_relacionadas($id,$ob[24]);
				if (!$this->services_model->insert_full_data($obra,'obra')){
					throw new Exception("<h2>Las obras no se han podido importar</h2>");
				}
				$media['fichero']=(string)$ob[3];
				$media['thumbnail']=(string)$ob[3];
				$media['id_tipo']=1;
				$media['id_estado']=1;
	
				
				$this->services_model->insert_media($parent_id,'obra',$media);
				
			}
			if (isset($obras_rel) && is_array($obras_rel)){
				//echo '<pre>'.print_r($obras_rel,true).'</pre>';
				
				foreach ($obras_rel as $obra_rel){
					
					if (!$this->services_model->insert_rel('obra',$obra_rel)){
						throw new Exception("<h2>Las obras no se han podido relacionar</h2>");
					}
				}
				
			}
		}
	}
	function _import_colecciones(){
		foreach($this->xml->Colecciones as $c){
			$col['main']['id_coleccion']=$c->ID + 1;
			$col['main']['id_estado']=1;
			$col['detalle']['id_coleccion']=$c->ID + 1;
			if (isset($cat[$col['main']['id_coleccion']]))
				$col['main']['id_categoria']=$this->cat[$col['main']['id_coleccion']];
			else
				$col['main']['id_categoria']=1;
			$col['detalle']['id_idioma']=1;
			
			$col['detalle']['nombre']=(string)$c->Nombre;
			if (!$this->services_model->insert_full_data($col,'coleccion')){
				throw new Exception("<h2>Las colecciones no se han podido importar</h2>");
			}
		}
	}
	function _import_xls(){
		$t=time();
		try{
			$this->_import_artistas('xls');
			$t2=time() - $t;
			echo "<h2>Artistas importados en $t2 s</h2>";;
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
		try{
			$this->_import_obras('xls');
			$t2=time() - $t;
			echo "<h2>Obras importadas en $t2 s</h2>";;
		}
		catch(Exception $e){
			echo $e->getMessage();
		}

		
	}
	
	function _import_xml(){
		$t=time();
		try{
			$this->_import_artistas('xml');
			$t2=time() - $t;
			echo "<h2>Artistas importados en $t2 s</h2>";;
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
		try{
			$this->_import_tecnicas('xml');
			$t2=time() - $t;
			$t=time();
			echo "<h2>Tecnicas importadas en $t2 s</h2>";;
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
		try{
			$this->_import_categorias('xml');
			$t2=time() - $t;
			$t=time();
			echo "<h2>Categorias importadas en $t2 s</h2>";;
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
		try{
			$this->_read_obras();
			$t2=time() - $t;
			$t=time();
			echo "<h2>Obras leidas en $t2 s</h2>";;
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
		try{
			$this->_import_colecciones('xml');
			$t2=time() - $t;
			$t=time();
			echo "<h2>Colecciones importadas en $t2 s</h2>";;
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
		
		try{
			$this->_import_obras('xml');
			$t2=time() - $t;
			$t=time();
			echo "<h2>Obras importadas en $t2 s</h2>";;
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
		
	}
	function import($tipo='xml'){
		if ($tipo=='xml'){
			$this->_read_xml();
			$this->_import_xml();
		}else{
			$this->xls['obras']=$this->read_xls_obras();
			$this->xls['artistas']=$this->read_xls_artistas();
			$this->_import_xls();
		}
	}
	function import_all(){
		$this->services_model->reset_tables();
		$this->import('xml');
		$this->import('xls');
		
	}
	function _read_xml($file='./datos.xml'){
		$this->xml=simplexml_load_file($file);

	}
	function read_xls_artistas($file='./artistas.xls'){
		//ini_set('memory_limit','1024M');
		$this->load->library('excel');
		$this->excel->clear();
		//$spreadsheet_art = new Spreadsheet_Excel_Reader();
		//$data->setOutputEncoding('CP1251'); // Set output Encoding.
		$this->excel->read($file); // relative path to .xls that was uploaded earlier
		$data=$this->excel->sheets[0]['cells'];
		$fields=$data[1];
		unset($data[1]);
		$this->excel->clear();
		//echo '<pre>'.print_r($data,true).'</pre>';
		return $data;
	}
	function read_xls_obras($file='./obras.xls'){
		//ini_set('memory_limit','1024M');
		$this->load->library('excel');
		$this->excel->clear();
		//$spreadsheet_art = new Spreadsheet_Excel_Reader();
		//$data->setOutputEncoding('CP1251'); // Set output Encoding.
		$this->excel->read($file); // relative path to .xls that was uploaded earlier
		$data=$this->excel->sheets[0]['cells'];
		$fields=$data[1];
		unset($data[1]);
		//$this->excel->clear();
		//echo '<pre>'.print_r($data,true).'</pre>';
		return $data;
		
	}
	

	/**
	 * 
	 * Elimina un contenido multimedia de la BD
	 */
	public function ajax_eliminar_multimedia($type='producto',$id_multimedia='', $ajax=true) {
		
		$this->load->model('services_model');
		if($this->input->post('id_multimedia')!='') $id_multimedia = $this->input->post('id_multimedia');
		
		if(isset($id_multimedia)&&$id_multimedia!='')
		{
//			echo $id_multimedia;
			//Elimina la relacion existente entre producto y multimedia mas no el elemento multimedia en la BD
			modules::run('services/relations/delete',$type,'multimedia',$id_multimedia);
			modules::run('multimedia/delete_id', $id_multimedia);
			if($ajax) return 'true';
			else return true;
		}
		else
		{
//			return 'false';
			if($ajax) return 'false';
			else return false;
		}
		
	}
	
	public function get_location()
	{
		return $this->services_model->get_location('20075100216');
	}
	
}	



/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
