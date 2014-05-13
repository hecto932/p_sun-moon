<?php

class Relations extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('services_model');
        if ($this->session->userdata('idioma') == '')
            $this->session->set_userdata('idioma', 'es');
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        //echo 'session idioma '.$this->session->userdata('idioma');
        //echo modules::run('idioma/get_idioma_id_from_code',$this->session->userdata('idioma'),'true');
        $this->id_idioma = modules::run('idioma/get_idioma_id_from_code', $this->session->userdata('idioma'));
        $this->lang->load('front');
    }

    function index() {
        
    }

    function str_month_to_num($mes, $ajax = false) {
        //$this->load->lang('calendar');
        if (is_numeric($mes))
            return $mes;
        $meses = array(strtolower(lang('cal_january')) => 1,
            strtolower(lang('cal_february')) => 2,
            strtolower(lang('cal_march')) => 3,
            strtolower(lang('cal_april')) => 4,
            strtolower(lang('cal_mayl')) => 5,
            strtolower(lang('cal_june')) => 6,
            strtolower(lang('cal_july')) => 7,
            strtolower(lang('cal_august')) => 8,
            strtolower(lang('cal_september')) => 9,
            strtolower(lang('cal_october')) => 10,
            strtolower(lang('cal_november')) => 11,
            strtolower(lang('cal_december')) => 12
        );
        //echo '<pre>'.print_r($meses,true).'</pre>';
        if ($ajax)
            echo str_pad($meses[$mes], 2, '0', STR_PAD_LEFT);
        else
            return str_pad($meses[$mes], 2, '0', STR_PAD_LEFT);
    }

    function get_from_categoria($id_categoria, $type, $ajax = false, $front = false, $where = '') {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin');
        //modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
        $ret = $this->services_model->get_all($type, $id_categoria, $where, $front);

        if ($ajax)
            echo json_encode($ret);
        else
            return $ret;
    }
	
	function get_eventos_fecha($fecha1='', $fecha2='')
	{
		$evento_total = array();
		$i=1;		
		while(($fecha1<=$fecha2)&&($i<=5))
		{
			$this->db->join('evento','evento.id_evento=detalle_evento.id_evento');
		    $this->db->where('evento.id_estado', '1');	
			$this->db->like('evento.fecha_evento', $fecha1); 
			$evento = $this->db->get('detalle_evento')->result();
			$evento_total = array_merge($evento_total,$evento);
			$fecha1= $this->operacion_fecha($fecha1, '1');
			if(count($evento)==1)
			$i=$i+1;
		}
	
		//die("<pre>".print_r($evento_total, TRUE). $this->db->last_query() ."</pre>");
		return $evento_total;
	}
	
	function get_noticias_fecha($fecha1='', $fecha2='')
	{
		$noticia_total = array();
		$i=1;		
		while(($fecha1<=$fecha2)&&($i<=5))
		{
			$this->db->join('noticia','noticia.id_noticia=detalle_noticia.id_noticia');
		    $this->db->where('noticia.id_noticia', '1');	
			$this->db->like('detalle_noticia.fecha', $fecha1); 
			$noticia = $this->db->get('detalle_noticia')->result();
			$noticia_total = array_merge($noticia_total,$noticia);
			$fecha1= $this->operacion_fecha($fecha1, '1');
			if(count($evento)==1)
			$i=$i+1;
		}
	
		//die("<pre>".print_r($evento_total, TRUE). $this->db->last_query() ."</pre>");
		return $noticia_total;
	}

    function get_from($type = 'producto', $campo, $valor, $ajax = false) {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin');
        $w = array($campo => $valor);
        $ret = $this->services_model->get_all($type, '', $w);
        if ($ajax)
            echo json_encode($ret);
        else
            return $ret;
    }

    function get_from_id($type, $id, $ajax = false, $front = false) {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin');
        //modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
        $ret = $this->services_model->get_from_id($type, $id, $front);
        if ($ajax) {
            echo json_encode($ret);
        } else {

            // $ret->biografia=str_replace("\0","",$ret->biografia);
            //echo '<pre>'.print_r($ret,true).'</pre>';
            return $ret;
        }
    }

    function get_categorias_raiz($ajax = false) {
        $id_parent = '0';
        //$cats=$this->services_model->get_categorias($id_parent);
        $cats = $this->services_model->get_categorias_one_level(0, $ajax);
        //echo '<pre>'.print_r($cats,true).'</pre>';
        if ($ajax == 'pre')
            echo '<pre>' . print_r($cats, true) . '</pre>';
        elseif ($ajax)
            echo json_encode($cats);

        else
            return $cats;
    }

    /**
     * Obtiene categorías hijas de $id_parent
     *
     * @param	integer	$id_parent
     * @param	boolean	$ajax
     * 
     * @return	mixed
     */
    function get_categorias($tipo_cat='1', $id_parent = 0, $ajax = false, $destacado = '') {

        //if($id_parent=='0') $cats=$this->services_model->get_categorias(0);
        if (isset($destacado) && $destacado != '') {
            $cats = $this->services_model->get_categorias($tipo_cat, $id_parent, $ajax, $destacado);
        } else {
            $cats = $this->services_model->get_categorias($tipo_cat, $id_parent);
        }

        //echo '<pre>'.print_r($cats,true).'</pre>';

        return $ajax ? json_encode($cats) : $cats;

        //if ($ajax=='pre') echo '<pre>'.print_r($cats,true).'</pre>';
        //elseif ($ajax) echo json_encode($cats);
        //else return $cats;
    }

    function get_carrusel($id_parent = 0, $ajax = false) {
        //if($id_parent=='0') $cats=$this->services_model->get_categorias(0);

        $cats = $this->services_model->get_carrusel($id_parent);

        //echo '<pre>'.print_r($cats,true).'</pre>';

        if ($ajax == 'pre') {
            echo '<pre>' . print_r($cats, true) . '</pre>';
        } else if ($ajax) {
            echo json_encode($cats);
        }

        return $cats;
    }

    function get_categoria_path($id_categoria = 0, $ajax = false) {
        $cats = $this->services_model->get_categoria_path($id_categoria);
        if ($ajax == 'pre')
            echo '<pre>' . print_r($cats, true) . '</pre>';
        elseif ($ajax)
            echo json_encode($cats);
        else
            return $cats;
    }

    function concat_cat_names($cat) {
        //echo '<pre>'.print_r($cat,true).'</pre>';
        if (empty($cat))
            return false;
        $tmp[$cat['id_categoria']] = ($cat['nombre'] != '' ? $cat['nombre'] : $cat['id_categoria']);
        if (isset($cat['parent'])) {

            $tmp[$cat['parent']['id_categoria']] = $this->concat_cat_names($cat['parent']);
            //return array_merge($tmp,$tmp2);
        }
        //echo '<pre>'.print_r($tmp,true).'</pre>';
        return $tmp;
    }

    function flatten($a, $f = array()) {
        if (!$a || !is_array($a))
            return '';
        foreach ($a as $k => $v) {
            if (is_array($v))
                $f = $this->flatten($v, $f);
            else
                $f[$k] = $v;
        }
        return $f;
    }

    /*
      function flatten(array $array) {
      //$objTmp = (object) array('aFlat' => array());

      function essai($v, $k){
      $t[$k] = $v[$k];
      return $t;

      }
      array_walk_recursive($array, 'essai');
      //array_walk_recursive($array, create_function('&$v, $k, &$t', '$t->aFlat[$k] = $v;'), $objTmp);


      //function re($a,$k){ $return[$k] = $a;return $return;}
      //$return = array();
      //array_walk_recursive($array, 're');

      ///return $array;



      echo '<pre>'.print_r($array,true).'</pre>';
      return $array;
      }
     * */

    function arbol_categorias($tipo_cat, $current_cat_id = 0, $current_padre_id = 0, $type = 'categoria', $ajax = true, $cats = array(), $niveles = 4) {
        $ret = '';
        $first_run = false;
        if (empty($cats)) {
            $cats = modules::run('services/relations/get_categorias', $tipo_cat, '0');
            $first_run = true;
        }
        if ($type == 'categoria' && empty($cats))
            $ret.='id_categoria';
        if (is_array($cats) && !empty($cats)) {
            $niveles = $niveles - 1;
            foreach ($cats as $cat) {
                //echo '<pre>'.print_r($cat,true).'</pre>';
                $data = array(
                    'name' => 'id_categoria_padre',
                    'id' => 'categoria' . $cat['id_categoria'],
                    'value' => $cat['id_categoria'],
                    'checked' => false,
                    'class' => 'radio'
                );

                if ($type == 'producto') {
                    $data['name'] = 'id_categoria';
                    if ($first_run && $current_cat_id == 0) 
                        $data['disabled'] = 'disabled';
					
                }

                if ($current_cat_id == $cat['id_categoria'] || ($niveles==0 && $type == 'categoria'))
                {
                	$data['name'] = "disabled";
                    $data['disabled'] = "disabled";
				}
			
                if ($current_padre_id == $cat['id_categoria'])
                    $data['checked'] = true;

                //$ret.= $current_padre_id.'=='.$cat['id_categoria'].'<br>';


                $data['checked'] = (set_radio($data['name'], $data['value']) ? set_radio($data['name'], $data['value']) : $data['checked']);
                //echo $data['name'].(string)$data['checked'];
                //echo '<pre>'.print_r($data,true).'</pre>';
                //echo $current_cat_id;
                if($type == 'producto' && $niveles==2)
				$first_run = true;
                if ($first_run == true && $type == 'producto') {
                    //CAMBIA ESTO COMO QUIERAS
                    $ret.='<li id="0" ><a href"#">' . ($cat['nombre'] != '' ? ucwords($cat['nombre']) : $cat['id_categoria']) . '</a>';
                } else {
                	$data['class'] = "jsTree_radio";
                    $ret .= '<li id="' . $cat['id_categoria'] . '">' . form_radio($data) . '<a href="#">' . $cat['nombre'] . '</a>';
                    //$ret.='<li><label class="inputRadio" for="categoria' . $cat['id_categoria'] . '"><span>' . ($cat['nombre'] != '' ? ucwords($cat['nombre']) : $cat['id_categoria']) . '</span>' . form_radio($data) . '</label>';
                }

                if (isset($cat['child']) && $niveles > 0)
                    $ret.=$this->arbol_categorias($tipo_cat,$current_cat_id, $current_padre_id, $type, false, $cat['child'], $niveles);
                $ret.='</ls>';
            }
            if ($type == 'categoria' && $first_run){
				$raiz = modules::run('services/relations/get_nombre_tipo_cat', $tipo_cat);
                $ret = '<li id="0"><input id="categoria0" name="id_categoria_padre" value="0" type="radio" class="jsTree_radio" ' . ($current_padre_id == 0 ? ' checked="checked"' : '') . ' /><a href="#">' . $raiz . '</a><ul>' . $ret . '</ul></li>';
			}
			if ($ajax)
                echo '<ul>' . $ret . '</ul>';
				//echo '<ul' . ($first_run == true ? ' class="' . $class . '"' : '') . '>' . $ret . '</ul>';
            else
                return '<ul>' . $ret . '</ul>';
				//return '<ul' . ($first_run == true ? ' class="' . $class . '"' : '') . '>' . $ret . '</ul>';
        }else {
            if ($ajax)
                echo "false";
            else
                return false;
        }
    }
	function get_nombre_tipo_cat($tipo_id, $ajax = false)
	{
        $nombre = $this->services_model->get_nombre_tipo_cat($tipo_id);
        return $ajax ? json_encode($nombre) : $nombre;

        //if ($ajax=='pre') echo '<pre>'.print_r($cats,true).'</pre>';
        //elseif ($ajax) echo json_encode($cats);
        //else return $cats;
	}

/*function arbol_categorias($current_cat_id = 0, $current_padre_id = 0, $type = 'categoria', $ajax = false, $cats = array(), $niveles = 9999999) {
        $ret = '';
        $first_run = false;
        if (empty($cats)) {
            $cats = modules::run('services/relations/get_categorias', '0');
            $first_run = true;
        }
        if ($type == 'categoria' && empty($cats))
            $ret.='id_categoria';
        if (is_array($cats) && !empty($cats)) {
            $niveles = $niveles - 1;
            foreach ($cats as $cat) {
                //echo '<pre>'.print_r($cat,true).'</pre>';
                $data = array(
                    'name' => 'id_categoria_padre',
                    'id' => 'categoria' . $cat['id_categoria'],
                    'value' => $cat['id_categoria'],
                    'checked' => false,
                    'class' => 'radio'
                );

                if ($type == 'producto') {
                    $data['name'] = 'id_categoria';
                    if ($first_run && $current_cat_id == 0)
                        $data['disabled'] = 'disabled';
                }

                if ($current_cat_id == $cat['id_categoria'])
                    $data['disabled'] = "disabled";
                if ($current_padre_id == $cat['id_categoria'])
                    $data['checked'] = true;

                //$ret.= $current_padre_id.'=='.$cat['id_categoria'].'<br>';


                $data['checked'] = (set_radio($data['name'], $data['value']) ? set_radio($data['name'], $data['value']) : $data['checked']);
                //echo $data['name'].(string)$data['checked'];
                //echo '<pre>'.print_r($data,true).'</pre>';
                //echo $current_cat_id;
                if ($first_run == true && $type == 'producto') {
                    //CAMBIA ESTO COMO QUIERAS
                    $ret.='<li><strong>' . ($cat['nombre'] != '' ? ucwords($cat['nombre']) : $cat['id_categoria']) . '</strong>';
                } else {
                    $ret.='<li><label class="inputRadio" for="categoria' . $cat['id_categoria'] . '"><span>' . ($cat['nombre'] != '' ? ucwords($cat['nombre']) : $cat['id_categoria']) . '</span>' . form_radio($data) . '</label>';
                }

                if (isset($cat['child']) && $niveles > 0)
                    $ret.=$this->arbol_categorias($current_cat_id, $current_padre_id, $type, false, $cat['child'], $niveles);
                $ret.='</li>';
            }
            if ($type == 'categoria' && $first_run)
                $ret = '<li><label for="categoria0" class="inputRadio"><span>Raíz</span><input id="categoria0" name="id_categoria_padre" value="0" type="radio"' . ($current_padre_id == 0 ? ' checked="checked"' : '') . ' /></label><ul>' . $ret . '</ul></li>';
            $class = ($type == 'producto' ? 'cats cats_js' : 'cats');
            if ($ajax)
                echo '<ul' . ($first_run == true ? ' class="' . $class . '"' : '') . '>' . $ret . '</ul>';
            else
                return '<ul' . ($first_run == true ? ' class="' . $class . '"' : '') . '>' . $ret . '</ul>';
        }else {
            if ($ajax)
                echo "false";
            else
                return false;
        }
    }*/

    function get_categorias_optgroup($parent = 0, $ajax = false) {

        $familias = $this->services_model->get_id_name_categoria_from_padre($parent);
        foreach ($familias as $familia) {
            //echo '<pre>'.print_r($familia,true).'</pre>';
            $key = ($familia->nombre != '' ? $familia->nombre : 'Familia ' . $familia->id_categoria);
            $categorias = $this->services_model->get_id_name_categoria_from_padre($familia->id_categoria);
            foreach ($categorias as $categoria) {
                $cats[$key][$categoria->id_categoria] = ($categoria->nombre != '' ? $categoria->nombre : 'Categoria ' . $categoria->id_categoria);
				$aux = $this->services_model->get_id_name_categoria_from_padre($categoria->id_categoria);
				foreach ($aux as $a) {
                	$cats[$key][$a->id_categoria] = ($a->nombre != '' ? $categoria->nombre . " > " . $a->nombre : $categoria->nombre . " > " . 'Categoria ' . $a->id_categoria);
					$aux2 = $this->services_model->get_id_name_categoria_from_padre($a->id_categoria);
					foreach ($aux2 as $a2) {
	                	$cats[$key][$a2->id_categoria] = ($a2->nombre != '' ? $categoria->nombre . " > " . $a->nombre . " > " . $a2->nombre : $categoria->nombre . " > " . $a->nombre . " > " . 'Categoria ' . $a2->id_categoria);
            		}
            	}
            }
            //$cats[$key]=$this->services_model->get_categorias_one_level($familia['id_categoria'],false);
        }
        if ($ajax)
            echo '<pre>' . print_r($cats, true) . '</pre>';
        return $cats;
        //echo '<pre>'.print_r($cats,true).'</pre>';
    }

    function get_productos_optgroup($parent = 0, $ajax = false) {


        $familias = $this->services_model->get_categorias_one_level($parent, false);


        foreach ($familias as $familia) {
            // echo '<pre>'.print_r($familia,true).'</pre>';
            $key = ($familia['nombre'] != '' ? $familia['nombre'] : 'Familia ' . $familia['id_categoria']);

            //$categorias= $this->services_model->get_categorias_one_level($familia['id_categoria'],false);

            $productos = $this->get_from_categoria($familia['id_categoria'], 'producto');
            //echo '<pre>PRODUCTO '.$key.' '.print_r($productos,true).'</pre>';
            foreach ($productos as $producto) {
                $nombre = ($producto->nombre != '' ? $producto->nombre : 'Producto ' . $producto->id_producto);
                $value_producto = '[' . $producto->codigo_coloplas . '] - ' . $nombre;
                $cats[$key][$value_producto] = $nombre;
            }
            //$cats[$key]=$this->services_model->get_categorias_one_level($familia['id_categoria'],false);
        }


        if ($ajax)
            echo '<pre>' . print_r($cats, true) . '</pre>';
        return $cats;
        //echo '<pre>'.print_r($cats,true).'</pre>';
    }

    function create_url($title = '', $ajax = 'true') {
        if ($ajax)
            echo url_title(urldecode($title));
        else
            return url_title(urldecode($title));

        // if ($ajax) echo url_title(urldecode($title),'underscore',true);
        //else return url_title(urldecode($title),'underscore',true);
        /*
          if ($ajax) echo $this->cleanURL($title);
          else return $this->cleanURL($title);
         */
    }

    function cleanURL($toClean) {
        $var['normalizeChars'] = array(
            'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
            'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
            'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
            'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
            'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
            'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
            'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'ƒ' => 'f'
        );
        $toClean = str_replace('&', '-and-', $toClean);
        //$toClean     =    trim(preg_replace('/[^\w\d_ -]/si', '', $toClean));//remove all illegal chars
        $toClean = str_replace(' ', '_', $toClean);
        $toClean = str_replace('--', '-', $toClean);

        return strtolower(strtr($toClean, $var['normalizeChars']));
    }

    function get_categoria_bc($id_categoria = 0, $ajax = false) {
        //if ($id_categoria==0) return 0;
        $ret = array();
        $cats = $this->services_model->get_categoria_path($id_categoria);
        //echo '<pre>'.print_r($cats,true).'</pre>';
        //die();
        $a = $this->concat_cat_names($cats);
        //echo '<pre>'.print_r($a,true).'</pre>';
        //die();
        if ($a) {
            $ret = $this->flatten($a);
            $ret[0] = 'Raíz';
        }
        $ret = array_reverse($ret, true);
        if ($ajax == 'pre')
            echo '<pre>' . print_r($ret, true) . '</pre>';
        elseif ($ajax)
            echo json_encode($ret);
        else
            return $ret;
    }

    function get_id_from_url($type, $url, $ajax = false) {
        //if ($type=='usuarios' || $type=='monitor')
        //modules::run('usuarios/is_logged_in','admin');
        //modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
        if ($ajax)
            echo $this->services_model->get_id_from_url($type, $url);
        else
            return $this->services_model->get_id_from_url($type, $url);
    }

    function get_all($type, $ajax = false, $where = '', $front = false) {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin');
			
        //if ($type=='categoria' && $where=='') $where=array('canal'=>'');

        if ($ajax)
            echo json_encode($this->services_model->get_all($type, false, $where, $front));
        else
            return $this->services_model->get_all($type, false, $where, $front);
    }

    function get_last($type, $ajax = false, $where = '', $front = false) {
//		if ($type=='usuarios' || $type=='monitor')
//			modules::run('usuarios/is_logged_in','admin');
        //if ($type=='categoria' && $where=='') $where=array('canal'=>'');
        $order = $type . '.id_' . $type;
        if ($ajax)
            echo json_encode($this->services_model->get_all($type, false, $where, $front, $order));
        else
            return $this->services_model->get_all($type, false, $where, $front, $order);
    }

    function get_all_orderby($type, $ajax = false, $where = '', $front = false, $order = '') {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin');
        //if ($type=='categoria' && $where=='') $where=array('canal'=>'');

        if ($ajax)
            echo json_encode($this->services_model->get_all($type, false, $where, $front, $order));
        else
            return $this->services_model->get_all($type, false, $where, $front, $order);
    }

    function get_all_from_categoria($type, $ajax = false, $categoria = '', $front = false) {
        //if ($type=='usuarios' || $type=='monitor')
        //	modules::run('usuarios/is_logged_in','admin');
        //if ($type=='categoria' && $where=='') $where=array('canal'=>'');

        $where = array("id_categoria" => $categoria);

        if ($ajax)
            echo json_encode($this->services_model->get_all($type, false, $where, $front));
        else
            return $this->services_model->get_all($type, false, $where, $front);
    }

    function get_all_from_categoria_array($type, $ajax = false, $categoria = '', $front = false) {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin');
        //if ($type=='categoria' && $where=='') $where=array('canal'=>'');

        $where = array("id_categoria" => $categoria);

        if ($ajax)
            echo json_encode($this->services_model->get_all($type, false, $where, $front, '', true));
        else
            return $this->services_model->get_all($type, false, $where, $front, '', true);
    }

    function get_where($type, $where, $ajax = false) {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin');
        //echo $where;
        if (!is_array($where) && !empty($where) && json_decode($where, true))
            $w = json_decode($where, true);
        else
            $w = $where;
        //echo '<pre>'.print_r($w,true).'</pre>';
        if ($ajax)
            echo json_encode($this->services_model->get_all($type, '', $w));
        else
            return $this->services_model->get_all($type, '', $w);
    }

    //modules::run('services/relations/get_rel','detalle_obra','tag',$obra->id_detalle_obra,'true')
    function get_rel($type, $rel_type, $id_type, $ajax = false, $group = false, $where = false) {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin');
        //modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
        $tipo = '';
        if ($rel_type == 'imagen') {
            $rel_type = 'multimedia';
            $tipo = 1;
        }
        if ($rel_type == 'catalogo') {
            $rel_type = 'multimedia';
            $tipo = 3;
        }
        if ($rel_type == 'video') {
            $rel_type = 'multimedia';
            $tipo = 2;
        }
        if ($rel_type == 'pdf') {
            $rel_type = 'multimedia';
            $tipo = 4;
        }
        if ($ajax)
            echo json_encode($this->services_model->get_rel($type, $rel_type, $id_type, $tipo, $group, $where));
        else
            return $this->services_model->get_rel($type, $rel_type, $id_type, $tipo, $group, $where);
    }

    //modules::run('services/relations/get_rel','detalle_obra','tag',$obra->id_detalle_obra,'true')
    function search_rel($type, $idioma, $str, $ajax = false) {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin', $this->uri->uri_string());
        //modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
        if ($ajax)
            echo json_encode($this->services_model->search_rel($type, $idioma, $str));
        else
            return $this->services_model->search_rel($type, $idioma, $str);
    }

    function insert_rel($type, $rel_type, $data, $id_type, $ajax = false) {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin');
        //modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
        if ($rel_type == 'imagen') {
            $rel_type = 'multimedia';
            $tipo = 1;
        }
        if ($rel_type == 'catalogo') {
            $rel_type = 'multimedia';
            $tipo = 3;
        }
        if ($rel_type == 'video') {
            $rel_type = 'multimedia';
            $tipo = 2;
        }
        if ($rel_type == 'enlace') {
            $rel_type = 'multimedia';
            $tipo = 4;
        }


        if ($type == $rel_type)
            $rt = $rel_type . '_relacionado';
        else
            $rt = $rel_type;
        $ok = true;
        if ($this->db->table_exists('rel_' . $type . '_' . $rel_type)) {
            $link_table = 'rel_' . $type . '_' . $rel_type;
        } else {
            $link_table = 'rel_' . $rel_type . '_' . $type;
        }
        foreach ($data as $d) {
            if ($type != $rel_type || $id_type != $d) {
                $ins = array('id_' . $type => $id_type, 'id_' . $rt => $d);
                //if (isset($tipo)) $ins['id_tipo']=$tipo;
                //echo '<pre>'.print_r($ins,true).'</pre>';
                $ok = $this->services_model->insert($link_table, $ins);
                //echo '<pre>'.print_r($ok,true).'</pre>';
                if ($type == $rel_type) {
                    $ins2 = array('id_' . $rt => $id_type, 'id_' . $type => $d);
                    //echo '<pre>'.print_r($ins,true).'</pre>';
                    $ok = $this->services_model->insert($link_table, $ins2);
                }
            }
        }
        //echo 'aaaa';

        return ($ajax ? '[{result:' . ($ok == true ? 'true' : $this->db->last_query() . '<pre>' . print_r($ins, true) . '</pre>' . $ok) . '}]' : $ok);
    }

    function rol_insert_rel($rol, $type, $rel_type, $data, $id_type, $ajax = false) {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'editor');
        elseif ($type == 'receta')
            modules::run('usuarios/is_logged_in_rol', $rol);
        //modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
        if ($rel_type == 'imagen') {
            $rel_type = 'multimedia';
            $tipo = 1;
        }
        if ($rel_type == 'catalogo') {
            $rel_type = 'multimedia';
            $tipo = 3;
        }
        if ($rel_type == 'video') {
            $rel_type = 'multimedia';
            $tipo = 2;
        }
        if ($rel_type == 'enlace') {
            $rel_type = 'multimedia';
            $tipo = 4;
        }

        if ($type == $rel_type)
            $rt = $rel_type . '_relacionado';
        else
            $rt = $rel_type;
        $ok = true;
        if ($this->db->table_exists('rel_' . $type . '_' . $rel_type)) {
            $link_table = 'rel_' . $type . '_' . $rel_type;
        } else {
            $link_table = 'rel_' . $rel_type . '_' . $type;
        }
        foreach ($data as $d) {
            if ($type != $rel_type || $id_type != $d) {
                $ins = array('id_' . $type => $id_type, 'id_' . $rt => $d);
                $ok = $this->services_model->insert($link_table, $ins);
                if ($type == $rel_type) {
                    $ins2 = array('id_' . $rt => $id_type, 'id_' . $type => $d);
                    $ok = $this->services_model->insert($link_table, $ins2);
                }
            }
        }
        return ($ajax ? '[{result:' . ($ok == true ? 'true' : $this->db->last_query() . '<pre>' . print_r($ins, true) . '</pre>' . $ok) . '}]' : $ok);
    }

    function tag_exists($tag, $id_idioma, $ajax = false) {
        $tags = $this->services_model->search_rel('tag', $id_idioma, $tag, 2);
        if ($ajax)
            echo json_encode($tags);
        else
            return $tags;
    }

    function insert_tag($tag_name, $type, $id_detalle, $id_idioma) {
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        if ($tag = $this->tag_exists($tag_name, $id_idioma)) {
            $data['rel'][0] = array('id_tag' => $tag[0]->id_tag, 'id_' . $type => $id_detalle);
            $this->services_model->insert_rel($data, $type, 'tag');
            //echo '<pre>'.print_r($data,true).'</pre>';
        } else {
            $tag_data = array('tag' => $tag_name, 'id_idioma' => $id_idioma, 'id_estado' => '1');
            $id = $this->services_model->insert('tag', $tag_data);
            $data['rel'][0] = array('id_tag' => $id, 'id_' . $type => $id_detalle);
            $this->services_model->insert_rel($data, $type, 'tag');
        }
        //check if tag exist
        //if it does, insert in rel_detalle_obra_tag
        //if not insert_new tag($tag_data);
        //and then insert into rel_detalle_obra_tag
    }

    function rol_insert_tag($rol, $tag_name, $type, $id_detalle, $id_idioma) {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'editor');
        elseif ($type == 'receta')
            modules::run('usuarios/is_logged_in_rol', $rol);

        if ($tag = $this->tag_exists($tag_name, $id_idioma)) {
            $data['rel'][0] = array('id_tag' => $tag[0]->id_tag, 'id_' . $type => $id_detalle);
            $this->services_model->insert_rel($data, $type, 'tag');
        } else {
            $tag_data = array('tag' => $tag_name, 'id_idioma' => $id_idioma, 'id_estado' => '1');
            $id = $this->services_model->insert('tag', $tag_data);
            $data['rel'][0] = array('id_tag' => $id, 'id_' . $type => $id_detalle);
            $this->services_model->insert_rel($data, $type, 'tag');
        }
    }

    function insert_image($name, $id_type, $type = 'producto', $tipo_img = '') {

        modules::run('usuarios/is_logged_in', 'editor');
        $id = $this->services_model->insert_multimedia($name, 1, $tipo_img);
        $data['rel'][0]['id_' . $type] = $id_type;
        $data['rel'][0]['id_multimedia'] = $id;
        //$data['rel'][0]['type']=$tipo_img;
        $this->services_model->insert_rel($data, $type, 'multimedia');
        $detalle['id_multimedia'] = $id;
        $detalle['id_idioma'] = 1;
        $this->services_model->insert('detalle_multimedia', $detalle);
        return $id;
    }

    function insert_detalle_multimedia($data) {
        modules::run('usuarios/is_logged_in', 'editor');
        $res = $this->services_model->insert_detalle_multimedia($data);

        echo $res;
    }

    function convert_to_url($str = '', $ajax = true) {
        if ($str == '')
            return;
        if ($ajax)
            echo url_title($str, 'underscore', TRUE);
        else
            return url_title($str, 'underscore', TRUE);
    }

    function get_all_rel($type, $rel_type, $id_type, $ajax = false, $group = false, $where = '') {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin');
        //modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
        $tipo = '';
        if ($rel_type == 'video') {
            $rel_type = 'multimedia';
            $tipo = 2;
        }
        if ($rel_type == 'imagen') {
            $rel_type = 'multimedia';
            $tipo = 1;
        }
        if ($rel_type == 'catalogo') {
            $rel_type = 'multimedia';
            $tipo = 3;
        }
        if ($rel_type == 'enlace') {
            $rel_type = 'multimedia';
            $tipo = 4;
        }

        $ret = $this->services_model->get_rel($type, $rel_type, $id_type, $tipo, $group, $where);
        if ($ajax)
            echo json_encode($ret);
        else
            return $ret;
    }

    function get_all_rel_front($type, $rel_type, $id_type, $ajax = false, $w = false) {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin');
        //modules::run('usuarios/is_logged_in','editor',$this->uri->uri_string());
        $tipo = '';
        if ($rel_type == 'video') {
            $rel_type = 'multimedia';
            $tipo = 2;
        }
        if ($rel_type == 'imagen') {
            $rel_type = 'multimedia';
            $tipo = 1;
        }
        if ($rel_type == 'catalogo') {
            $rel_type = 'multimedia';
            $tipo = 3;
        }
        if ($rel_type == 'enlace') {
            $rel_type = 'multimedia';
            $tipo = 4;
        }
        $where = "(detalle_$rel_type.id_idioma ='" . $this->id_idioma . "' OR $rel_type.id_$rel_type NOT IN (SELECT id_$rel_type FROM detalle_$rel_type WHERE id_idioma='" . $this->id_idioma . "')) AND $rel_type.id_estado= '1'";
        if ($w)
            $where .=" AND " . $w;

        $ret = $this->services_model->get_rel($type, $rel_type, $id_type, $tipo, false, $where);
        if ($ajax)
            echo json_encode($ret);
        else
            return $ret;
    }

    function relacionados($type, $id_type, $ajax = true) {
        if ($ajax)
            echo json_encode($this->destacados($type, $id_type));
        else
            return $this->destacados($type, $id_type);
    }

    function destacados($type, $id_type, $tipos_relacionados = array('imagen', 'video', 'coleccion', 'obra', 'artista', 'microsite', 'catalogo', 'serie', 'exposicion', 'publicacion', 'enlace')) {

        if ($type == 'coleccion' || $type === 'exposicion')
            unset($tipos_relacionados[array_search('obra', $tipos_relacionados)]);
        foreach ($tipos_relacionados as $tipo_rel) {
            $dest_tipo = array();
            $rel_type = $tipo_rel;
            if ($tipo_rel == 'video') {
                $rel_type = 'multimedia';
                $tipo = 2;
            }
            if ($tipo_rel == 'imagen') {
                $rel_type = 'multimedia';
                $tipo = 1;
            }
            if ($tipo_rel == 'catalogo') {
                $rel_type = 'multimedia';
                $tipo = 3;
            }
            if ($rel_type == 'enlace') {
                $rel_type = 'multimedia';
                $tipo = 4;
            }

            $where = "(detalle_$rel_type.id_idioma ='" . $this->id_idioma . "' OR $rel_type.id_$rel_type NOT IN (SELECT id_$rel_type FROM detalle_$rel_type WHERE id_idioma='" . $this->id_idioma . "')) AND $rel_type.id_estado= '1'";
            $dest_tipo = $this->services_model->get_rel($type, $rel_type, $id_type, $tipo, false, $where);
            if (count($dest_tipo) > 10) {
                shuffle($dest_tipo);
                $data['dest_' . $tipo_rel] = array_slice($dest_tipo, 0, 10);
            } else {
                $data['dest_' . $tipo_rel] = $dest_tipo;
            }
            //$data[$tipo_rel]=$this->get_all_rel($type,$tipo_rel,$id_type,false,false,array($tipo.'.id_estado'=>1));
        }
        //echo '<pre>'.print_r($data,true).'</pre>';
        return $data;
    }

    function update($table, $campo, $valor, $id) {
        if ($table == 'usuarios' || $table == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin');
        else
            modules::run('usuarios/is_logged_in', 'editor');

        return $this->services_model->update($table, $campo, $valor, $id);
    }

    function delete($type, $rel_type, $id_type = '', $id_rel_type = '', $ajax = false) {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin');
        else
            modules::run('usuarios/is_logged_in', 'editor');
        $r = $this->services_model->delete($type, $rel_type, $id_type, $id_rel_type);
        if ($ajax)
            echo '[{result:' . ($r == true ? 'true' : 'false') . '}]';
        else
            return $r;
    }

    function rol_delete($rol, $type, $rel_type, $id_type = '', $id_rel_type = '', $ajax = false) {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin');
        elseif ($type == 'receta' || $type == 'detalle_receta')
            modules::run('usuarios/is_logged_in_rol', $rol);
        else
            modules::run('usuarios/is_logged_in', 'editor');

        $r = $this->services_model->delete($type, $rel_type, $id_type, $id_rel_type);
        if ($ajax)
            echo '[{result:' . ($r == true ? 'true' : 'false') . '}]';
        else
            return $r;
    }

    function delete_one_rel($type, $rel_type, $id_type, $id_rel_type, $ajax = false) {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin');
        else
            modules::run('usuarios/is_logged_in', 'editor');
        $r = $this->services_model->delete($type, $rel_type, $id_type, $id_rel_type);
        if ($ajax)
            echo '[{result:' . ($r == true ? 'true' : 'false') . '}]';
        else
            return $r;
    }

    function format_fecha($dia = '', $mes = '', $ano = '', $aprox = false, $ajax = false) {
        $sep = (is_numeric($mes) ? '/' : ' ');
        $dia = ($dia == 0) ? '' : $dia . $sep;
        $mes = (($mes == 0 && is_numeric($mes)) || $mes == '') ? '' : str_pad($mes, 2, '0', STR_PAD_LEFT) . $sep;
        $fecha = $dia . $mes . $ano;
        if ($aprox == true)
            $fecha = 'Ca. ' . $fecha;
        if ($ajax)
            echo $fecha;
        else
            return $fecha;
    }

    function random($ajax = true) {
        if ($ajax == true)
            echo 4;
        else
            return 4;
        //chosen by fair dice roll, guaranteed to be random
    }

    function get_all_like($type, $ajax = false, $like = '', $front = false) {
        if ($type == 'usuarios' || $type == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin');


        if ($ajax)
            echo json_encode($this->services_model->get_all_like($type, false, $like, $front));
        else
            return $this->services_model->get_all_like($type, false, $like, $front);
    }

    function votar($tipo_contenido = '', $id_contenido = '', $value = '') {
        if ($this->input->post('valoracion') != '') {
            $value = $this->input->post('valoracion');
            $id_contenido = $this->input->post('id_contenido');
            $tipo_contenido = $this->input->post('tipo_contenido');
            $return_url = $this->input->post('return_url');
        }

        $data['id_usuario'] = $this->session->userdata('id_usuario');
        $data['tipo_contenido'] = $tipo_contenido;
        $data['id_contenido'] = $id_contenido;
        $data['puntos'] = $value;
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        $return_url = $this->session->userdata('return_url_voto');

        //echo 'signo las variables';
        /*
          echo("<br><b>session->userdata -></b><pre>");
          print_r($this->session->userdata);
          echo("</font></pre><br>");
          die(); */
        $votados = (is_array($this->session->userdata('votados')) ? $this->session->userdata('votados') : array());

        $votados = array_merge($votados, array($tipo_contenido => $id_contenido));
        $this->session->set_userdata('votados', $votados);
        if ($this->services_model->ha_votado($data['ip'], $tipo_contenido, $id_contenido, $data['id_usuario']) == false && $data['puntos'] <= 5) {
            $this->services_model->insert_vote($data);
            //echo 'inserto el voto';
            if (isset($return_url))
                redirect($return_url);
            else
                echo $this->votacion($tipo_contenido, $id_contenido, true);
        }else {
            if (isset($return_url))
                redirect($return_url);
            else
                echo 'false';
        }



        //redirect($return_url);
    }

    function votacion($tipo_contenido = '', $id_contenido = '', $ajax = false) {
        if ($ajax)
            echo $this->services_model->votacion($tipo_contenido, $id_contenido);
        else
            return $this->services_model->votacion($tipo_contenido, $id_contenido);
    }

    function numero_votacion($tipo_contenido = '', $id_contenido = '', $ajax = false) {
        if ($ajax)
            echo $this->services_model->numero_votos($tipo_contenido, $id_contenido);
        else
            return $this->services_model->numero_votos($tipo_contenido, $id_contenido);
    }

    function crear_multimedia($img = '', $id = '', $tipo = '', $destacado = '', $img_folder = '', $width = '120', $height = '120', $med_w = '400', $med_h = '400', $large_w = '800', $large_h = '800') {
        $img_folder = ($img_folder != '' ? $img_folder : 'assets/front/img/');
        $img_new = $id . rand(5, 99999999) . '_' . $img;

        //insert image into multimedia
        $this->insert_image($img_new, $id, $tipo, $destacado);

        if (is_file(FCPATH . $img_folder . 'temp/' . $img)) {
            if (!is_dir(FCPATH . $img_folder . 'thumb/'))
                mkdir(FCPATH . $img_folder . 'thumb/');
            if (!is_dir(FCPATH . $img_folder . 'med/'))
                mkdir(FCPATH . $img_folder . 'med/');
            if (!is_dir(FCPATH . $img_folder . 'large/'))
                mkdir(FCPATH . $img_folder . 'large/');
            $this->load->library('image_lib');
            $config['image_library'] = 'gd2';
            $config['source_image'] = FCPATH . $img_folder . 'temp/' . $img;


            // Imagen Thumbnail

            $config['new_image'] = FCPATH . $img_folder . 'thumb/' . $img_new;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = $width;
            $config['height'] = $height;
            $this->load->library('image_lib');
            $this->image_lib->initialize($config);
            if (!$this->image_lib->resize()) {
                echo $this->image_lib->display_errors();
            }

            // Imagen Medium

            $config['new_image'] = FCPATH . $img_folder . 'med/' . $img_new;
            $config['width'] = $med_w;
            $config['height'] = $med_h;

            $this->image_lib->initialize($config);
            if (!$this->image_lib->resize()) {
                echo $this->image_lib->display_errors();
            }

            // Imagen Large
            $config['new_image'] = FCPATH . $img_folder . 'large/' . $img_new;
            $config['width'] = $large_w;
            $config['height'] = $large_h;
            $this->image_lib->initialize($config);
            if (!$this->image_lib->resize()) {
                echo $this->image_lib->display_errors();
            }
            if (is_file(FCPATH . $img_folder . 'temp/' . $img))
                unlink(FCPATH . $img_folder . 'temp/' . $img);
        }
    }

    /**
     * 
     * Convierte una fecha del tipo aaaa-mm-dd escrita en letras
     * @param unknown_type $fecha
     */
    public function fecha_to_letras($fecha, $short_version = FALSE) {

        $meses = array('01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre');
		
        $fecha = explode(" ", $fecha);
	
        if (count($fecha) > 1) {
            $resto = $fecha[1];
			
            $fecha = $fecha[0];
        }
        else
            $resto = '';

        $fecha = explode("-", $fecha);

        if ($short_version)
            return (count($fecha) == 3) ? $fecha[2] . ' ' . substr($meses[$fecha[1]], 0, 3) . ' ' . $fecha[0] . ' ' . $resto : FALSE;

        else
            return (count($fecha) == 3) ? $fecha[2] . ' de ' . $meses[$fecha[1]] . ' del ' . $fecha[0] : FALSE;
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
	
	public function get_id_categorias_from_padre($categoria_from, $niveles = 4)
	{	
		$this->load->model('services_model');
		//$categoria['hijos'] = $this->services_model->get_id_categorias_from_padre($categoria_from);
		$categoria['hijos'] = $this->services_model->get_all('categoria', $categoria_from, array('categoria.id_estado'=>'1'));
		//print_r($categoria['hijos']); die();
		
		if (!empty($categoria['hijos']) && $categoria['hijos'] != '')
		{
			foreach ($categoria['hijos'] as $key=>$hijo) {
					// id de categoria hijo
					//print_r($hijo); die();
				$categorias['id_categoria'][] = $hijo->nombre;
				//if($hijo->id_categoria!='')
				$categorias['id_categoria'][] = $this->get_id_categorias_from_padre($hijo->id_categoria);
				//echo '<pre>'.print_r($id,TRUE).'</pre>';die();
			}
			//echo '<pre>'.print_r($id,TRUE).'</pre>';die();
			return $categorias['id_categoria'];
		}else{
			return '';
		}
		
	}
	
	public function get_id_categoria_url($url)
	{
		$this->load->model('services_model');
		$categorias = $this->services_model->get_id_categoria_url($url);

		if ($categorias)
		{
            return $categorias;
        }
     	else
            return '';
	}
	
	function get_productos($table, $campo, $valor, $id) {
        if ($table == 'usuarios' || $table == 'monitor')
            modules::run('usuarios/is_logged_in', 'admin');
        else
            modules::run('usuarios/is_logged_in', 'editor');

        return $this->services_model->update($table, $campo, $valor, $id);
    }
	
	public function get_id_producto_url($url)
	{
		$this->load->model('services_model');
		$producto = $this->services_model->get_id_producto_url($url);

		if ($producto)
		{
            return $producto;
        }
     	else
            return '';
	}
	
	public function get_id_proyecto_url($url)
	{
		$this->load->model('services_model');
		$proyecto = $this->services_model->get_id_proyecto_url($url);

		if ($proyecto)
		{
            return $proyecto;
        }
     	else
            return '';
	}
	
	public function get_id_trabajo_url($url)
	{
		$this->load->model('services_model');
		$trabajo = $this->services_model->get_id_trabajo_url($url);

		if ($trabajo)
		{
            return $trabajo;
        }
     	else
            return '';
	}
	
	public function get_id_noticia_url($url)
	{
		$this->load->model('services_model');
		$noticia = $this->services_model->get_id_noticia_url($url);

		if ($noticia)
		{
            return $noticia;
        }
     	else
            return '';
	}
	
	
	public function get_productos_from_categorias_array($parent, $ajax,$excluir='')
	{
		//print_r($excluir);die();
		$array = array($parent);
		$array = $this->get_categorias_and_subcategorias_array($array, $parent);
		$relacionados = '';
		if($excluir!='')
		{
			$relacionados = explode("_",$excluir);
		}
			 
		
		$productos = $this->services_model->get_productos_from_categorias_array($array,$relacionados);
		if ($ajax)
            echo json_encode($productos);
        else
            return $productos;
	}
	
	public function get_categorias_and_subcategorias_array($array, $parent)
	{
		$this->load->model('services_model');
		$categorias = $this->services_model->get_id_name_categoria_from_padre($parent);
		if(!empty($categorias))
		foreach($categorias as $cat)
		{
			$array[] = $cat->id_categoria;
			$this->get_categorias_and_subcategorias_array($array,$cat->id_categoria);
		}
		return $array;
	}
	
	public function get_categoria_id($id)
	{
		$this->db->where('dp.id_categoria', $id);
		$query = $this->db->get('detalle_categoria dp');
		$resultado = $query->result();
		 
		 return $resultado;
	}
	
	public function get_titulo_pagina($id)
	{
		$this->db->where('dc.id_categoria', $id);
		$query = $this->db->get('detalle_categoria dc');
		$resultado = $query->first_row();
		 return $resultado->titulo_pagina;
	}
	
	public function get_descripcion_pagina($id)
	{
		$this->db->where('dc.id_categoria', $id);
		$query = $this->db->get('detalle_categoria dc');
		$resultado = $query->first_row();
		 return $resultado->descripcion_pagina;
	}
	
	public function get_keywords_pagina($id)
	{
		$this->db->where('dc.id_categoria', $id);
		$query = $this->db->get('detalle_categoria dc');
		$resultado = $query->first_row();
		 return $resultado->keywords;
	}
	
/*---------------------- Zona de Productos---------------------*/

	public function get_titulo_pagina_producto($id)
	{
		$this->db->where('dp.id_producto', $id);
		$query = $this->db->get('detalle_producto dp');
		$resultado = $query->first_row();
		 return $resultado->titulo_pagina;
	}
	
	
	public function get_descripcion_pagina_producto($id)
	{
		$this->db->where('dp.id_producto', $id);
		$query = $this->db->get('detalle_producto dp');
		$resultado = $query->first_row();
		 return $resultado->descripcion_pagina;
	}
	
	public function get_keywords_pagina_producto($id)
	{
		$this->db->where('dp.id_producto', $id);
		$query = $this->db->get('detalle_producto dp');
		$resultado = $query->first_row();
		 return $resultado->keywords;
	}
	
	public function get_id_padre_producto($id)
	{
		$this->db->where('dp.id_producto', $id);
		$query = $this->db->get('producto dp');
		$resultado = $query->first_row();
		 return $resultado->id_categoria;
	}

	public function get_id_padre($id)
	{
		$this->db->where('dp.id_categoria', $id);
		$query = $this->db->get('categoria dp');
		$resultado = $query->first_row();
		 return $resultado->id_categoria_padre;
	}
	
/*---------------------- Zona de Proyectos---------------------*/

	public function get_titulo_pagina_proyecto($id)
	{
		$this->db->where('dp.id_proyecto', $id);
		$query = $this->db->get('detalle_proyecto dp');
		$resultado = $query->first_row();
		 return $resultado->titulo_pagina;
	}
	


	public function get_keywords_pagina_proyecto($id)
	{
		$this->db->where('dp.id_proyecto', $id);
		$query = $this->db->get('detalle_proyecto dp');
		$resultado = $query->first_row();
		 return $resultado->keywords;
	}


	public function get_id_padre_proyecto($id)
	{
		$this->db->where('dp.id_proyecto', $id);
		$query = $this->db->get('proyecto dp');
		$resultado = $query->first_row();
		 return $resultado->id_categoria;
	}
	

	function name_date($fecha='')
	{
 	 //el primer dia de la semana en ingles es el domingo
        $semana=array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
        list($ano,$mes,$dia)=explode("-",$fecha);
        //date("w") devuelve la posicion del dia de la semana
        $posdia=date("w",mktime(0,0,0,$mes,$dia,$ano));
        return $semana[$posdia];
	}
	
	function name_month($fecha='')
	{
 	 //el primer dia de la semana en ingles es el domingo
        $semana=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        list($ano,$mes,$dia)=explode("-",$fecha);
        return $semana[$mes-1].'-'.$ano;
	}
	
	function number_month($mes_letra='')
	{
 	 
        $mes=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		
		for ($i=0; $i <12 ; $i++) 
		{
			 if($mes[$i]==$mes_letra)
			 return $i+1;
		}
		
	}
	
	public function get_titulo_pagina_noticia($id)
	{
		$this->db->where('dp.id_noticia', $id);
		$query = $this->db->get('detalle_noticia dp');
		$resultado = $query->first_row();
		 return $resultado->titulo_pagina;
	}
	
	
	public function get_keywords_pagina_noticia($id)
	{
		$this->db->where('dp.id_noticia', $id);
		$query = $this->db->get('detalle_noticia dp');
		$resultado = $query->first_row();
		 return $resultado->keywords;
	}
	
	
	public function get_blog_fecha($fecha1='', $fecha2='')
	{
		$evento_total = array();
		
		while($fecha1<=$fecha2)
		{
			$this->db->join('noticia','noticia.id_noticia=detalle_noticia.id_noticia');
			$this->db->where('noticia.creado', $fecha1);
			$this->db->where('noticia.id_estado', 1);  
			$evento = $this->db->get('detalle_noticia')->result();
			$evento_total = array_merge($evento_total,$evento);
			$fecha1= $this->operacion_fecha($fecha1, '1');
			if(count($evento)==1);
		}
	
		//die("<pre>".print_r($evento_total, TRUE). $this->db->last_query() ."</pre>");
		
		return $evento_total;
	}
	
	function operacion_fecha($fecha,$dias) 
	{
		$fecha_sin_horas=explode(" ",$fecha); 	
		list ($ano,$mes,$dia)=explode("-",$fecha_sin_horas[0]);
		if (!checkdate($mes,$dia,$ano)){return false;} 
		$dia=$dia+$dias; 
		$fecha=date( "Y-m-d", mktime(0,0,0,$mes,$dia,$ano) );
		$fecha_2=$fecha.' 00:00:00';
		return $fecha; 
	}  
	
	
	public function get_id_noticia_detalle_url($url)
	{
		$this->load->model('services_model');
		$noticia = $this->services_model->get_id_noticia_detalle_url($url);

		if ($noticia)
		{
            return $noticia;
        }
     	else
            return '';
	}
	
	
	function verify_id_noticia($id_noticia=''){

		$this->db->where('dp.id_noticia', $id_noticia);
		$this->db->where('dp.id_estado', 1);
		$query = $this->db->get('noticia dp');
		//$resultado = $query->result();
		//echo $this->db->last_query();die();
		if ($query->num_rows()>0)
		 	return TRUE;
		else {
			return FALSE;
		}
		 
	}

}

/* End of file relations.php */
/* Location: ./system/application/modules/services/controllers/relations.php */
