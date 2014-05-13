<?php
class Services_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		modules::run('idioma/set_idioma',$this->session->userdata('idioma'));
		//echo "aaa".$this->session->userdata('idioma');
		$this->id_idioma=modules::run('idioma/get_idioma_id_from_code',$this->session->userdata('idioma'));
		//echo $this->id_idioma;
	}
	function insert_rel($data,$type,$type2=''){
		$ok=true;
		if ($type2=='') $type2=$type;
		if (isset($data['rel']) && is_array($data['rel'])){
			foreach($data['rel'] as $rel){
				//echo '<pre>'.print_r($rel,true).'</pre>';
				if($this->db->insert('rel_'.$type.'_'.$type2,$rel)) $ok=true;
				else $ok=false;
			}
			
		}
		//echo $this->db->last_query();
		return $ok;
	}
	function insert($table,$data){
		$this->db->insert($table,$data);
		//echo $this->db->last_query();
		return $this->db->insert_id();
	}
     function get_categoria_path($id_categoria){
		$this->db->from('categoria');
		$this->db->select('categoria.*,detalle_categoria.*, categoria.id_categoria as id_categoria');
		$this->db->join('detalle_categoria','categoria.id_categoria=detalle_categoria.id_categoria','left');
		$this->db->group_by('categoria.id_categoria');
		$this->db->where('categoria.id_categoria',$id_categoria);
		$q=$this->db->get();
        //echo $this->db->last_query();
		$cats=$q->result_array();
		//echo '<pre>'.print_r($cats,true).'</pre>';
		$ret=array();
		//foreach($cats as $k=>$cat){
		if (isset($cats[0])){
			$ret=$cats[0];

			if ($cats[0]['id_categoria_padre']!=0){
				$ret['parent']=$this->get_categoria_path($cats[0]['id_categoria_padre']);
			}
		}
		return $ret;
	}
	function get_categorias($tipo_cat=0, $id_parent=0,$front=true,$destacado){
		$this->db->from('categoria');
		$this->db->select('categoria.*,detalle_categoria.*, categoria.id_categoria as id_categoria');
		$this->db->join('detalle_categoria','categoria.id_categoria=detalle_categoria.id_categoria','left');
		$this->db->group_by('categoria.id_categoria');
		$this->db->where('id_categoria_padre',$id_parent);
		$this->db->where('id_tipo_cat',$tipo_cat);
		//die('-->' . $tipo_cat);
		$this->db->order_by('detalle_categoria.nombre');
		if(isset($destacado)&&$destacado!='') $this->db->where('destacado',$destacado);
		
        if($front)
		    $this->db->where('id_estado',1);
		$q=$this->db->get();
		$cats=$q->result_array();
		foreach($cats as $k=>$cat){
			$ch=$this->get_categorias($tipo_cat,$cat['id_categoria']);
			if (!empty($ch)) $cats[$k]['child']=$ch;
		}
		//echo $this->db->last_query();
		//echo '<pre>'.print_r($ret,true).'</pre>';
		return $cats;
	}

	function get_nombre_tipo_cat($tipo_id)
	{
		$this->db->from('tipo_categoria');
		$this->db->select('tipo_categoria.nombre');
		$this->db->where('tipo_categoria.id',$tipo_id);
        
		$q=$this->db->get();
		$nombre = $q->result_array();
		return ucwords($nombre[0]['nombre']);
	}

	function get_carrusel($id_parent=0,$front=true){
		$this->db->from('categoria');
		$this->db->select('categoria.*,detalle_categoria.*, categoria.id_categoria as id_categoria');
		$this->db->join('detalle_categoria','categoria.id_categoria=detalle_categoria.id_categoria','left');
		$this->db->group_by('categoria.id_categoria');
		$this->db->where('id_categoria_padre',$id_parent);
        if($front)
		    $this->db->where('id_estado',1);
		$q=$this->db->get();
		$cats=$q->result_array();
		
		foreach($cats as $k=>$cat){
			$ch=$this->get_categorias($cat['id_categoria']);
			
			if (!empty($ch))
			{
				$cats[$k]['child']=$ch;
				foreach($ch as $y=>$subcat){
					$where = array("id_categoria"=>'producto');
					$prods = modules::run('services/relations/get_all_from_categoria_array','producto',false,$subcat['id_categoria'],'true');
					if (!empty($prods))
					{
						$cats[$k]['child'][$y]['child'] = $prods;
						foreach($prods as $x=>$prod){
							$img=(modules::run('services/relations/get_rel','producto','imagen',$prod['id_producto'],false));
							if (!empty($img) && isset($img))
							{
								if(isset($img[0]->fichero) && $img[0]->fichero!='') $imagen = '/assets/img/med/'.$img[0]->fichero;
								else {$imagen = '/assets/img/med/no_disponible.jpg';}
								//$cats[$k]['child'][$x]['url_imagen']=$imagen;
								//$cats[$k]['child'][$x]['url']='/'.$this->lang->line('productos_url').'/'.$cats[$k]['url'].'/'.$cats[$k]['child'][$x]['url'];
							}
						}
					}
				}
			}
			else
			{
				$where = array("id_categoria"=>'producto');
				$prods = modules::run('services/relations/get_all_from_categoria_array','producto',false,$cat['id_categoria'],'true');
				if (!empty($prods))
				{
					$cats[$k]['child']=$prods;
					foreach($prods as $x=>$prod){
							$img=(modules::run('services/relations/get_rel','producto','imagen',$prod['id_producto'],false));
							if (!empty($img) && isset($img))
							{
								if(isset($img[0]->fichero) && $img[0]->fichero!='') $imagen = '/assets/img/med/'.$img[0]->fichero;
								else {$imagen = '/assets/img/med/no_disponible.jpg';}
								$categoria = modules::run('categoria/read',$id_parent,false,'',true);
								$cats[$k]['child'][$x]['url_imagen']=$imagen;
								$cats[$k]['child'][$x]['url']=$this->lang->line('productos_url').'/'.$categoria->url.'/'.$cats[$k]['child'][$x]['url'];
							}
						}
				}
			}
			 
		}
		//echo $this->db->last_query();
		//echo '<pre>'.print_r($ret,true).'</pre>';
		return $cats;
	}
	
    function get_categorias_one_level($id_parent=0,$front=true){
    	
		$this->db->from('categoria');
		$this->db->select('categoria.*,detalle_categoria.*, categoria.id_categoria as id_categoria');
		$this->db->join('detalle_categoria','categoria.id_categoria=detalle_categoria.id_categoria','left');
		$this->db->group_by('categoria.id_categoria');
		$this->db->where('id_categoria_padre',$id_parent);
		// if($front)
		  //  $this->db->where('id_estado',1);
		$q=$this->db->get();
		$cats=$q->result_array();

		//echo $this->db->last_query();
		//echo '<pre>'.print_r($ret,true).'</pre>';
		return $cats;
	}
	function insert_full_data($data,$type){


        $main=$data['main'];
        $detalle=$data['detalle'];
        $main=str_replace("\0","",$main);
        $detalle=str_replace("\0","",$detalle);
		$this->db->insert($type,$main);
		$ret['id']=$this->db->insert_id();
		$this->db->insert('detalle_'.$type,$detalle);
		$ret['id_detalle']=$this->db->insert_id();
		return $ret;
	}

	function insert_multimedia($name,$tipo_id,$tipo_imagen=''){
		$data['fichero']=$name;
		//$data['thumbnail']=$name;
		$data['destacado']=$tipo_imagen;
		$data['id_usuario']=$this->session->userdata('id_usuario');
		$data['id_tipo']=$tipo_id;
		$data['id_estado']=1;
		$this->db->insert('multimedia',$data);
		return $this->db->insert_id();
	}
	function get_detalle_multimedia($data){
		$this->db->where('id_multimedia',$data['id_multimedia']);
		$this->db->where('id_idioma',$data['id_idioma']);
		$q=$this->db->get('detalle_multimedia');
		return $q->row();
	}
	
	function insert_detalle_multimedia($data){
		if ($this->get_detalle_multimedia($data)){
			$this->db->where('id_multimedia',$data['id_multimedia']);
			$this->db->where('id_idioma',$data['id_idioma']);
			$this->db->update('detalle_multimedia',$data);
		}else{
			$this->db->insert('detalle_multimedia',$data);
			$id= $this->db->insert_id();
		}

		return $id;
	}
	function reset_tables(){
		$this->db->truncate('categoria'); 
		$this->db->truncate('producto'); 
		
	}
	function after_import(){
		
	}
	function get_last_id($table){
		$this->db->select('MAX(id_'.$table.') AS last_id');
		$q=$this->db->get($table);
		$r= $q->result();
		return $r[0]->last_id;
	}

	function get_location($ip)
	{
		$this->db->select('location.country as pais, location.region as region, location.city');
		$this->db->join('blocks', 'location.locId = blocks.locId');
		$this->db->where('location.endIpNum >=', $ip);
		$query = $this->db->get('location', 1);
		return $query->result();
	}

	function insert_media($parent_id,$parent_tipo,$media){
		$this->db->insert('multimedia',$media);
		$mid=$this->db->insert_id();
		$data=array('id_'.$parent_tipo => $parent_id, 'id_multimedia' => $mid);
		$this->db->insert('rel_'.$parent_tipo.'_multimedia',$data);
	}

	
	function get_rel($type,$rel_type,$id_type,$id_tipo='',$group=false,$where=false,$front=false){
		if($type==$rel_type) $rt=$rel_type.'_relacionado';
		else $rt=$type;
		
		if ($this->db->table_exists('rel_'.$type.'_'.$rel_type)){
			$link_table='rel_'.$type.'_'.$rel_type;
		}elseif ($this->db->table_exists('rel_'.$rel_type.'_'.$type)){
			$link_table='rel_'.$rel_type.'_'.$type;
		}else{
			return false;
		}
		$this->db->from($link_table);
		
		if ($this->db->table_exists($link_table)){
			$this->db->join($type,$type.'.id_'.$type.'='.$link_table.'.id_'.$rt);
			if($type!=$rel_type) $this->db->join($rel_type,$link_table.'.id_'.$rel_type.'='.$rel_type.'.id_'.$rel_type);
			if ($this->db->table_exists('detalle_'.$rel_type)){
				$this->db->join('detalle_'.$rel_type,'detalle_'.$rel_type.'.id_'.$rel_type.'='.$rel_type.'.id_'.$rel_type);
				if($type==$rel_type)
					$this->db->select($rel_type.'.*,detalle_'.$rel_type.'.*, '.$link_table.'.*, '.$link_table.'.id_'.$rel_type.'_relacionado as id_'.$rel_type);
				else
					$this->db->select($rel_type.'.*,detalle_'.$rel_type.'.*, '.$link_table.'.*');
			}else{
				$this->db->select($rel_type.'.*, '.$link_table.'.*');
			}
			//if ($this->db->field_exists('id_idioma',$rel_type)) $this->db->where($rel_type.'.id_idioma',$this->idioma->id_idioma);
			//if ($this->db->field_exists('id_estado',$rel_type)) $this->db->where($rel_type.'.id_estado','1');
			if ($this->db->field_exists('id_tipo',$rel_type)) $this->db->where($rel_type.'.id_tipo',$id_tipo);
			if($type!=$rel_type) $this->db->where($type.'.id_'.$type,$id_type);
			else $this->db->where('rel_'.$type.'_'.$rel_type.'.id_'.$type, $id_type );
			//else $this->db->where('(rel_'.$type.'_'.$rel_type.'.id_'.$type.'='.$id_type.' OR rel_'.$type.'_'.$rel_type.'.id_'.$type.'_relacionado='.$id_type.')' );
		}
		
		if (is_array($where) && !empty($where)){
			foreach($where as $k=>$w){
				$this->db->where($k,$w);
			}
		}elseif (!empty($where)){
			$this->db->where($where);
		}
		if ($group=='true') $group=$type.'.id_'.$type;
		if ($group) $this->db->group_by($group);

		$q=$this->db->get();
		//echo '<p>'. $this->db->last_query();
		$ret=$q->result();
		
		//echo '<pre>'.print_r($ret,true).'</pre>';
		return $ret;
	}
	function search_rel($type,$idioma='',$str='',$mode=1){
		$this->db->from($type);
		$this->db->select('*');
		if ($this->db->field_exists('tag',$type) && $str!='') $this->db->like($type.'.tag',$str,'after');
		if ($idioma!='') $this->db->where('id_idioma',$idioma);
		$q=$this->db->get();
		//echo $this->db->last_query();
		//$ret=$q->result();
		$ret=null;
		foreach($q->result() as $row){
			$ret[]=$row->tag;
		}
		if ($mode!=1) $ret=$q->result();
		
		//echo '<pre>'.print_r($ret,true).'</pre>';
		return $ret;
	}
	function get_item_rel(){
		
	}
	
	function get_all($type,$categoria='',$where='',$front=false,$order='',$array=false){
		
		
		if ($type=='video'){
			$v='video';
			$type='multimedia';
			$this->db->join('tipo_'.$type,'tipo_multimedia.id_tipo=multimedia.id_tipo');
			$this->db->where('tipo_multimedia.nombre','video');
		}
		if ($type=='catalogo'){
			$v='catalogo';
			$type='multimedia';
			$this->db->join('tipo_'.$type,'tipo_multimedia.id_tipo=multimedia.id_tipo');
			$this->db->where('tipo_multimedia.nombre','catalogo');
			//$this->db->select('detalle_'.$type.'.*, '.$type.'.*, '.$type.'.id_multimedia as id_multimedia');
		}
        if ($type=='imagen'){

			$type='multimedia';
			$this->db->join('tipo_'.$type,'tipo_multimedia.id_tipo=multimedia.id_tipo');
			$this->db->where('tipo_multimedia.nombre','catalogo');
			//$this->db->select('detalle_'.$type.'.*, '.$type.'.*, '.$type.'.id_multimedia as id_multimedia');
		}
        if ($type=='enlace'){
			
			$type='multimedia';
			$this->db->join('tipo_'.$type,'tipo_multimedia.id_tipo=multimedia.id_tipo');
			$this->db->where('tipo_multimedia.nombre','enlace');
			//$this->db->select('detalle_'.$type.'.*, '.$type.'.*, '.$type.'.id_multimedia as id_multimedia');
		}
		
		$this->db->from($type);
		if ($this->db->table_exists('detalle_'.$type)){
			$this->db->select('detalle_'.$type.'.*,'.$type.'.*');
			$this->db->join('detalle_'.$type,$type.'.id_'.$type.'=detalle_'.$type.'.id_'.$type,'left');
			if(isset($order)&&($order!=''))
			{	
				if ($type=='noticia') $this->db->order_by($order,'desc');
				elseif($type=='promocion') $this->db->order_by($order,'desc');
				//elseif ($type=='producto') $this->db->order_by($order,'asc');
				else $this->db->order_by($order);
			}
			else
			{
				if ($type=='noticia') $this->db->order_by($type.'.id_noticia','asc');
				elseif($type=='promocion') $this->db->order_by($type.'.id_promocion','asc');
				elseif($type=='canal') $this->db->order_by($type.'.id_canal','asc');
				elseif($type=='multimedia')$this->db->order_by('detalle_'.$type.'.nombre','asc');
				elseif($type=='usuario')$this->db->order_by('detalle_'.$type.'.apellido_1','asc');
				else $this->db->order_by('detalle_'.$type.'.nombre','asc');
			}
			if (!$front) $this->db->group_by($type.'.id_'.$type);
			
			//$this->db->where('detalle_'.$type.'.id_idioma',$this->idioma->id_idioma);
		}
		if (isset($categoria) && $categoria!=''){
			//$this->db->join('categoria','categoria.id_categoria='.$type.'.id_categoria');
			$this->db->join('detalle_categoria','detalle_categoria.id_categoria='.$type.'.id_categoria');
			$this->db->where('detalle_categoria.id_categoria',$categoria);
			//echo "aqui entro isset categoria";
		}
		if (is_array($where) && !empty($where)){
			foreach($where as $k=>$w){
				$this->db->where($k,$w);
			}
		}elseif (!empty($where)){
			$this->db->where($where);
		}
		//if ($type=='obra'){
		//	$this->db->join('detalle_categoria','detalle_categoria.id_categoria=obra.id_categoria');
		//}
		if ($front!=false){
			//$this->db->join('estado','estado.id_estado='.$type.'.id_estado');
			//$this->db->where('estado','publicado');
			$this->db->where("(detalle_$type.id_idioma ='".$this->id_idioma."' OR $type.id_$type NOT IN (SELECT id_$type FROM detalle_$type WHERE id_idioma='".$this->id_idioma."')) AND $type.id_estado= '1'");
			$this->db->group_by($type.'.id_'.$type);
		}
		
		$q=$this->db->get();
		if($array!=false) $ret=$q->result_array();
		else $ret=$q->result();
		//echo "aqui" .$this->db->last_query();
		//echo '<pre>'.print_r($ret,true).'</pre>';
		return $ret;
		//return $this->db->last_query();
		
	}
	function get_from_id($type,$id,$front=false){
		
		if($type=='video'){
			$v='video';
			$type='multimedia';
			$this->db->join('tipo_'.$type,'tipo_multimedia.id_tipo=multimedia.id_tipo');
			$this->db->where('tipo_multimedia.nombre','video');
		}
		if($type=='catalogo'){
			$v='catalogo';
			$type='multimedia';
			$this->db->join('tipo_'.$type,'tipo_multimedia.id_tipo=multimedia.id_tipo');
			$this->db->where('tipo_multimedia.nombre','catalogo');
		}
		if ($type=='tipo_multimedia')
			$type_w='tipo';
		else
			$type_w=$type;
			
		if ($type!='idioma' && $this->db->table_exists('detalle_'.$type)){
			//if (!$this->id_idioma) $this->id_idioma=modules::run('idioma/get_idioma_id_from_code',$this->session->userdata('idioma'));
			
			$this->db->select("*,$type.id_$type_w as id_$type_w, ABS(detalle_".$type_w.".id_idioma - ".$this->id_idioma.") as r");
		}else{
			$this->db->select("*, $type.id_$type_w as id_$type_w");
		}	
		$this->db->from($type);
		if ($this->db->table_exists('detalle_'.$type)){
			$this->db->join('detalle_'.$type,$type.'.id_'.$type.'=detalle_'.$type.'.id_'.$type,'left');
			if ($type!='idioma' && $front!=false)
				$this->db->order_by('r','ASC');
			///$this->db->where('detalle_'.$type.'.id_idioma',$this->id_idioma);
		}
		$this->db->where($type.'.id_'.$type_w,$id);
		if ($type=='tipo_multimedia')
			$idt='tipo';
		else
			$idt=$type;
		//$this->db->group_by($type.'.id_'.$idt);
		$q=$this->db->get();
		$ret=$q->result();
		//echo $this->db->last_query();
		//echo '<pre>'.print_r($ret,true).'</pre>';die();
		//print_r($this->db->last_query());die();
        if (isset($ret[0]))
		    return $ret[0];
        else return false;
		
	}
	function get_id_from_url($type,$url){
		
		if ($type=='video'){
			$v='video';
			$type='multimedia';
			$this->db->join('tipo_'.$type,'tipo_multimedia.id_tipo=multimedia.id_tipo');
			$this->db->where('tipo_multimedia.nombre','video');
		}
		if ($type=='tipo_multimedia')
			$type_w='tipo';
		else
			$type_w=$type;
		$this->db->from($type);
		if ($this->db->table_exists('detalle_'.$type)){
			$this->db->join('detalle_'.$type,$type.'.id_'.$type.'=detalle_'.$type.'.id_'.$type);
			if($this->db->field_exists('url', 'detalle_'.$type))
				$this->db->where('detalle_'.$type.'.url',$url);
			elseif($this->db->field_exists('titulo', 'detalle_'.$type))
				$this->db->like('detalle_'.$type.'.titulo',$url);
				
			
			//$this->db->where('detalle_'.$type.'.id_idioma',$this->idioma->id_idioma);
		}
		$this->db->select($type.'.id_'.$type.' as id');
		if ($type=='tipo_multimedia')
			$idt='tipo';
		else
			$idt=$type;
		
		$this->db->group_by($type.'.id_'.$idt);
		$q=$this->db->get();
		$ret=$q->row();
		//echo $this->db->last_query();
		//echo '<pre>'.print_r($ret,true).'</pre>';
		if ($ret)
			return $ret->id;
		else return false;
		
	}
	function delete($type,$rel_type,$id_type='',$id_rel_type=''){
		if ($this->db->table_exists('rel_'.$type.'_'.$rel_type)){
			$link_table='rel_'.$type.'_'.$rel_type;
		}else{
			$link_table='rel_'.$rel_type.'_'.$type;
		}
		if ($type==$rel_type) $rt=$rel_type.'_relacionado';
		else $rt=$rel_type;
		if ($id_type!='') $this->db->where('id_'.$type,$id_type);
		if ($id_rel_type!='') $this->db->where('id_'.$rt,$id_rel_type);
		//if ($type==$rel_type)
		$this->db->or_where('id_'.$rt,$id_type);
		return $this->db->delete($link_table);
	}
	
	function get_all_like($type,$categoria='',$like='',$front=false){
		
		if ($type=='video'){
			$v='video';
			$type='multimedia';
			$this->db->join('tipo_'.$type,'tipo_multimedia.id_tipo=multimedia.id_tipo');
			$this->db->where('tipo_multimedia.nombre','video');
		}
		if ($type=='catalogo'){
			$v='catalogo';
			$type='multimedia';
			$this->db->join('tipo_'.$type,'tipo_multimedia.id_tipo=multimedia.id_tipo');
			$this->db->where('tipo_multimedia.nombre','catalogo');
			//$this->db->select('detalle_'.$type.'.*, '.$type.'.*, '.$type.'.id_multimedia as id_multimedia');
		}

		$this->db->from($type);
		if ($this->db->table_exists('detalle_'.$type)){
			$this->db->select('detalle_'.$type.'.*,'.$type.'.*');
			$this->db->join('detalle_'.$type,$type.'.id_'.$type.'=detalle_'.$type.'.id_'.$type,'left');
			if (!$front) $this->db->group_by($type.'.id_'.$type);
			
			//$this->db->where('detalle_'.$type.'.id_idioma',$this->idioma->id_idioma);
		}
		if (isset($categoria) && $categoria!=''){
			//$this->db->join('categoria','categoria.id_categoria='.$type.'.id_categoria');
			$this->db->join('detalle_categoria','detalle_categoria.id_categoria='.$type.'.id_categoria');
			$this->db->where('detalle_categoria.id_categoria',$categoria);
			//echo "aqui entro isset categoria";
		}
		
		if ($front!=false){
			//$this->db->join('estado','estado.id_estado='.$type.'.id_estado');
			//$this->db->where('estado','publicado');
			$this->db->where("(detalle_$type.id_idioma ='".$this->id_idioma."' OR $type.id_$type NOT IN (SELECT id_$type FROM detalle_$type WHERE id_idioma='".$this->id_idioma."')) AND $type.id_estado= '1'");
			//$this->db->group_by($type.'.id_'.$type);
		}
		
		//$q=$this->db->get();
		//$varlike=' AND (';
		if (is_array($like) && !empty($like)){
		$valor = false;
			foreach($like as $k=>$w){
				//$this->db->or_like($k,$w);
				$this->db->like($k,$w);
				//if($valor) { $varlike .= " OR `".$k."` LIKE '%".$w."%'"; }
				//else { $varlike .= "`".$k."` LIKE '%".$w."%' "; $valor = true; }
			}
			//$varlike .= ') ';
			//$this->db->like($varlike);
			//$query = $this->db->last_query().$varlike;
		//	$query .= ' GROUP BY '.$type.'.id_'.$type;
			//$this->db->query($query);
		}elseif (!empty($like)){
			//$this->db->or_like($like);
			$this->db->like($like);
		}
		
		//$q=$this->db->get();
		//$q=$this->db->query(mysql_real_escape_string($query));
		//$q=$this->db->query($query);
		
		$q=$this->db->get();
		$ret=$q->result();
		
		//return $ret;
		return $this->db->last_query();
		
	}
	function ha_votado($ip,$tipo,$id,$id_usuario){
		$this->db->where('ip',$ip);
		$this->db->where('id_usuario',$id_usuario);
		$this->db->where('tipo_contenido',$tipo);
		$this->db->where('id_contenido',$id);
		$this->db->like('timestamp',date('Y-m-d'));
		$q=$this->db->get('votacion');
		if ($q->num_rows() > 0)
			return true;
		else return false;
	}
	function insert_vote($data){
		$this->db->insert('votacion',$data);
	}
	
	
	function votacion($tipo,$id){
		$this->db->select('SUM(puntos) as valoracion, count(*) as num');
		$this->db->where('tipo_contenido',$tipo);
		$this->db->where('id_contenido',$id);
		$this->db->group_by('tipo_contenido,id_contenido');
		$q=$this->db->get('votacion');
		$res=$q->result();
		//echo '<pre>'.print_r($res,true).'</pre>';
		//echo $this->db->last_query();
		if (is_array($res) && !empty($res)){
			return round($res[0]->valoracion / $res[0]->num);
		}else{
			return '0';
		}
		
	}

	function numero_votos($tipo,$id){
		$this->db->select('SUM(puntos) as valoracion, count(*) as num');
		$this->db->where('tipo_contenido',$tipo);
		$this->db->where('id_contenido',$id);
		$this->db->group_by('tipo_contenido,id_contenido');
		$q=$this->db->get('votacion');
		$res=$q->result();
		//echo '<pre>'.print_r($res,true).'</pre>';
		//echo $this->db->last_query();
		if (is_array($res) && !empty($res)){
			return $res[0]->num;
		}else{
			return '0';
		}
		
	}
	
	function update($table,$campo,$valor,$id){
		$data = array(
               $campo => $valor
            );
		$this->db->where('id_'.$table, $id);
		$this->db->update($table, $data); 
	}
	function custom_update($table,$data,$campo,$valor){

		$this->db->where($campo, $valor);
		$this->db->update($table, $data);
	}

 	function get_arbol_categorias2($categoria_from)
	{
		$this->db->where('c.id_categoria_padre', $categoria_from);
		$this->db->where('c.id_estado', '1');
		$this->db->join('detalle_categoria dc', 'dc.id_categoria = c.id_categoria');
		
		$query = $this->db->get('categoria c');
		
		if($query->num_rows() > 0)
			return $query->result();
		else
			return FALSE;
		
	}
	
	public function get_arbol_categorias($categoria_from, $niveles = 4)
	{	
		$this->load->model('services_model');
		$categorias = $this->services_model->get_arbol_categorias2($categoria_from);
		
		
		//echo '<pre>'.print_r($categorias,TRUE).'</pre>';die();
		$subcategorias = '';
		if ($categorias)
		{
            foreach ($categorias as $k => $categoria)
            {
            	if($niveles>=0){
            		$niveles = $niveles - 1;
            		$subcategorias = $this->get_arbol_categorias($categoria->id_categoria,$niveles);
            	}
				$categoria->child = array();
				
				if($subcategorias)
				{
					foreach($subcategorias as $subcategoria)
					{
						$categoria->child[] = $subcategoria;
					}
				}
				
            	//$categoria->child = array($categoria->nombre.);
			}
			//echo 'OK<pre>'.print_r($categorias,TRUE).'</pre>';die();
            return $categorias;
        }
     	else
            return '';
	}
	
	function get_productos($id_cat)
	{
		$this->db->where('p.id_categoria', $id_cat);
		$query = $this->db->get('producto p');
		
		if($query->num_rows() > 0){
			$result = $query->result();
			$this->db->from('detalle_producto');
			$this->db->where('detalle_producto.id_producto', $result[0]->id_producto);
			//$this->db->join('categoria', 'categoria.id_categoria = detalle_categoria.id_categoria');
			$query = $this->db->get();
			
			//$resultado = array($result[0]->nombre, $result[0]->id_categoria, $query->result());
			
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	
	function get_id_categorias_from_padre($categoria_from)
	{
		$this->db->where('c.id_categoria_padre', $categoria_from);
		$this->db->where('c.id_estado', '1');
		
		$query = $this->db->get('categoria c');
		//echo '<pre>'.print_r($query->result(),TRUE).'</pre>';die();
		if($query->num_rows() > 0)
			return $query->result();
		else
			return FALSE;
		
	}
	
	function get_id_name_categoria_from_padre($padre='0')
	{
		$this->db->select('c.id_categoria, dc.nombre');
		$this->db->where('c.id_categoria_padre', $padre);
		$this->db->where('c.id_estado', '1');
		$this->db->join('detalle_categoria dc', 'dc.id_categoria = c.id_categoria');
		$query = $this->db->get('categoria c');
		//echo '<pre>'.print_r($query->result(),TRUE).'</pre>';die();
		if($query->num_rows() > 0)
			return $query->result();
		else
			return FALSE;
	}
	
	function get_id_categoria_url($url)
	{
		$this->db->where('dc.url', $url);
		$query = $this->db->get('detalle_categoria dc');
		$resultado = $query->result();
		
		if($query->num_rows() > 0){
			return $resultado[0]->id_categoria;
		}
		else{
			return FALSE;
		}
		
	}
	
	function get_id_producto_url($url)
	{
		$this->db->where('dp.url', $url);
		$query = $this->db->get('detalle_producto dp');
		$resultado = $query->result();
		
		if($query->num_rows() > 0){
			return $resultado[0]->id_producto;
		}
		else{
			return FALSE;
		}
		
	}
	
	
	function get_id_proyecto_url($url)
	{
		$this->db->where('dp.url', $url);
		$query = $this->db->get('detalle_proyecto dp');
		$resultado = $query->result();
		
		if($query->num_rows() > 0){
			return $resultado[0]->id_proyecto;
		}
		else{
			return FALSE;
		}
		
	}
	
	function get_id_trabajo_url($url)
	{
		$this->db->where('dp.url', $url);
		$query = $this->db->get('detalle_trabajo dp');
		$resultado = $query->result();
		
		if($query->num_rows() > 0){
			return $resultado[0]->id_trabajo;
		}
		else{
			return FALSE;
		}
		
	}
	
	function get_productos_from_categorias_array($array,$relacionados=''){
			//print_r($array);
			
		/*$where = array();
		foreach($array as $a)
		{
			$where[] = $this->db->escape($a);
		}*/
		//print_r($where);die();
		$this->db->select('p.id_producto, p.codigo_coloplas, dp.nombre');
		$this->db->join('detalle_producto dp', 'dp.id_producto=p.id_producto');
		$this->db->where('p.id_estado','1');
		$this->db->where_in('p.id_categoria',$array);
		//Excluir los relacionadas si ya tiene
		if(isset($relacionados)&&$relacionados!='')
		{
			$this->db->where_not_in('p.id_producto', $relacionados);
		}
		
		$query = $this->db->get('producto p');
		//print_r($this->db->last_query());die();
		
		$resultado = $query->result();
		
		if($query->num_rows() > 0){
			return $resultado;
		}
		else{
			return FALSE;
		}
	}
	
	function get_id_noticia_detalle_url($url)
	{
		
		$this->db->where('dp.url', $url);
		$query = $this->db->get('detalle_noticia dp');
		$resultado = $query->result();
		
		if($query->num_rows() > 0){
			return $resultado[0]->id_detalle_noticia;
		}
		else{
			return FALSE;
		}
		
	}
		
	function get_id_noticia_url($url)
	{
		$this->db->join('noticia n','n.id_noticia=dn.id_noticia');
		$this->db->where('dn.url', $url);
		$this->db->where('n.id_estado', 1);
		$query = $this->db->get('detalle_noticia dn');
		$resultado = $query->result();
		
		if($query->num_rows() > 0){
			return $resultado[0]->id_noticia;
		}
		else{
			return FALSE;
		}
		
	}
	

	
}