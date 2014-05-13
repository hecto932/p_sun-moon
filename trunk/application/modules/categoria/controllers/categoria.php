<?php

class Categoria extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('categoria_model');
        modules::run('categorias/is_logged_in', 'admin', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        $this->lang->load('back');
        $this->load->helper('multimedia');
    }

    function index() {
        $this->listado();
    }

    function listado($order_field = 'id_categoria', $order_dir = 'desc', $start = 0, $ajax = false) {

        if ($start == 0 && empty($_POST) && $order_field == 'id_categoria')
            $this->session->unset_userdata('terminos_busqueda');
        $terminos_busqueda = array();
        $terminos_busqueda = $this->session->userdata('terminos_busqueda');
        if (isset($_POST['nombre'])) {
            $terminos_busqueda['detalle_categoria.nombre'] = $_POST['nombre'];
        }
        if (isset($_POST['descripcion'])) {
            $terminos_busqueda['detalle_categoria.descripcion'] = $_POST['descripcion'];  // Descripcion BREVE
        }
        if (isset($_POST['estado'])) {
            $terminos_busqueda['estado'] = $this->input->post('estado');
        }
        if (isset($_POST) && !empty($_POST)) {
            $terminos_busqueda = array_filter($terminos_busqueda);
            $this->session->set_userdata('terminos_busqueda', $terminos_busqueda);
        }



        //echo '<pre> TB'.print_r($terminos_busqueda,true).'</pre>';
        $limit = 10;
        $order_string = '';
        $order_string.= ($order_field == "") ? '' : $order_field;
        $order_string.= ($order_dir == "") ? '' : ' ' . $order_dir;

        //echo '<pre> ORDER S'.print_r($order_string,true).'</pre>';

        $od = ($order_dir == 'asc') ? 'desc' : 'asc';
        $data_content['order_field'] = $order_field;
        $data_content['order_dir'] = $order_dir;
        $data_content['order_by_new'] = (($order_field == '') ? 'id_categoria' : $order_field) . "/" . $od;
        $data_content['url'] = 'backend/categorias/listado';
        $config['base_url'] = '/backend/categorias/listado/' . $order_field . '/' . $order_dir;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 6;
        $data_content['num_categorias'] = $this->categoria_model->count_all($terminos_busqueda);
        $config['total_rows'] = $data_content['num_categorias'];
        if ($config['total_rows'] == 0)
            redirect('categoria/buscar/ningun_resultado');
        $data_content['categorias'] = $this->categoria_model->get_page($start, $limit, $order_field, $order_dir, $terminos_busqueda);

        if ($ajax) {
            echo json_encode($data_content['categorias']);
        } else {
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $data_content['pagination'] = $this->pagination->create_links();
            $data_content['offset'] = $start;
            $data_content['order_field'] = $order_field;
            $data_content['order_direction'] = $order_dir;

            //echo '<pre> ORDER F'.print_r($order_field,true).'</pre>';
            $data['main_content'] = $this->load->view('listado_categoria', $data_content, true);
            $data['active'] = 'categoria';
            if (!empty($terminos_busqueda))
                $data['sub'] = 'buscar';
            else
                $data['sub'] = 'listado';
            $data['title'] = lang('categorias');
            if (!empty($terminos_busqueda)) {
                $lbc = reset($terminos_busqueda);
                $lbt = key($terminos_busqueda);
                //	if ($lbt=='categoria.id_categoria'){
                if ($lbt == 'id_categoria') {
                    $bcc = modules::run('services/relations/get_from_id', 'categoria', $lbc);
                    $lbc = $bcc->nombre;
                }
                $data['breadcrumbs'] = array('categoria' => lang('categorias'), 'buscar' => lang('busqueda'), 'titulo' => $lbc);
            } else {
                $data['breadcrumbs'] = array('categoria' => lang('categorias'), 'listado' => lang('listado'));
            }
            $this->load->view('back/template', $data);
        }
    }

    function buscar($mensaje = '') {
        $data['active'] = 'categoria';
        $data['sub'] = 'buscar';
        $data['title'] = lang('buscar_tit_cat');
        $data['breadcrumbs'] = array('categoria' => lang('categorias'), 'buscar' => lang('buscar_tit_cat'));
        //$data['relations'] = $this->load->view('relations','',true);

        $dc['mensaje'] = $mensaje;
        $data['main_content'] = $this->load->view('buscar_categoria', $dc, true);
        $this->load->view('back/template', $data);
    }

    function crear() {
        $data['active'] = 'categoria';
        $data['sub'] = 'crear';
		$data['title'] = lang('categoria_cre_tit');
        $data['breadcrumbs'] = array('categoria' => lang('categorias'), 'crear' => lang('crear_tit_cat'));
        //$data_content['categorias']=modules::run('services/relations/get_categorias','0','true');
        $data_content['arbol_categorias'] = modules::run('services/relations/arbol_categorias', 1, '0', '0');

        //$data_content['arbol_categorias']=$this->_arbol_categorias($data_content['categorias']);
        //	echo '<pre>'.print_r($data_content['categorias'],true).'</pre>';
        $data_content['estados'] = modules::run('services/relations/get_all', 'estado', 'true');
		$data_content['tipos_cat'] = modules::run('services/relations/get_all', 'tipo_categoria', 'true');
        //$data_content['tecnicas']=modules::run('services/relations/get_all','tecnica','true');
        //$data_content['videos']=modules::run('services/relations/get_all','video','true');
        //$data_content['catalogoss']=modules::run('services/relations/get_all','catalogo','true');
        //$data_content['microsites']=modules::run('services/relations/get_all','microsite','true');


        $data['main_content'] = $this->load->view('crear_categoria', $data_content, true);
        $this->load->view('back/template', $data);
    }

    function create($id = '') {
        $img_folder = 'assets/front/img/';
        if ($id != '')
            modules::run('services/monitor/add', 'categoria', $id, $this->session->userdata('id_usuario'), 'editar');
        else
            modules::run('services/monitor/add', 'categoria', '', $this->session->userdata('id_usuario'), 'crear');
        modules::run('usuarios/is_logged_in', 'editor', $this->uri->uri_string());
        modules::run('idioma/set_idioma', $this->session->userdata('idioma'));
        $data_content['estados'] = modules::run('services/relations/get_all', 'estado', 'true');

        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));

        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        $this->form_validation->set_rules('id_estado', 'id_estado', 'required');



        if ($this->form_validation->run($this) == FALSE) {
            if ($id != '') {
                $data_content['categoria'] = $this->categoria_model->read($id);
            }

            $data['active'] = 'categoria';
            $data['sub'] = 'crear';
            $data['title'] = lang('crear_tit_cat');
            if ($id != '') {
                $data['breadcrumbs']['categoria'] = lang('categorias');
                $data['breadcrumbs']['edit'] = lang('listado');
                $data['breadcrumbs'][$id] = $data_content['categoria']->nombre;
            } else {
                $data['breadcrumbs'] = array('categoria' => lang('categorias'), 'crear' => lang('crear_tit_cat'));
            }
            $data['main_content'] = $this->load->view('crear_categoria', $data_content, true);


            $this->load->view('back/template', $data);
        } else {
            $form_data = $_POST;
			if (!isset($form_data['id_categoria_padre']))
                $form_data['id_categoria_padre'] = 0;
            if (!isset($form_data['destacado']))
                $form_data['destacado'] = 0;

            $form_data['id_usuario'] = $this->session->userdata('id_usuario');
            
            $img = $form_data['imagenName'];
            if ($form_data['imagenName'] == '') {
                if (isset($form_data['imagenActual']))
                    $img = $form_data['imagenActual'];
            }
            
            
            $img = $form_data['imagenName'];

            if ($form_data['imagenName'] != '') {
                if (isset($form_data['imagenActual']) && $form_data['imagenActual'] != '') {
                    foreach ($form_data['imagenActual'] as $k => $im_id) {
                        modules::run('services/relations/delete', 'categoria', 'multimedia', $im_id);
                        modules::run('multimedia/delete_id', $im_id);
                    }
                }
            }
            
            

            unset($form_data['imagenActual']);
            unset($form_data['imagenName']);
            unset($form_data['imagen']);

            $form_data['creado'] = date('Y-m-d h:i:s');
			//die('2');
            $id = $this->categoria_model->update($form_data);
            //echo '<pre>' . $id . '</pre>';
            //die();
            //modules::run('services/relations/delete', 'categoria', 'multimedia', $id);

            //modules::run('services/relations/delete','producto','producto',$id);
            //modules::run('services/relations/delete','producto','coleccion',$id);
            //modules::run('services/relations/delete','producto','microsite',$id);
            if (isset($rel) && !empty($rel) && is_array($rel)) {
                //die('DIE 1');
                foreach ($rel as $t => $r) {
                    modules::run('services/relations/insert_rel', 'categoria', $t, $r, $id);
                }
            }
            if (isset($img) && $img != '') {
                //print_r($img);
                //die('IMAGE');
                $this->crear_multimedia($img, $id, 'categoria', '1', '', '200', '120', '500', '300', '500', '300');
            }
            //echo '<pre>'.print_r($_POST,true).'</pre>';
            //echo "true";
            //die();
            redirect('backend/ficha_categoria/' . $id, 'location');
        }
    }

    function crear_multimedia($img = '', $id = '', $tipo = '', $destacado = '', $img_folder = '', $width = '120', $height = '120', $med_w = '400', $med_h = '400', $large_w = '800', $large_h = '800') {
        $img_folder = ($img_folder != '' ? $img_folder : 'assets/front/img/');
        $img_new = $id . rand(5, 99999999) . '_' . $img;

        //insert image into multimedia
        modules::run('services/relations/insert_image', $img_new, $id, $tipo, $destacado);
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

    function edit($id = '', $ajax = false) {
        $data['active'] = 'categoria';
        $data['sub'] = 'editar';
        if ($id == '')
            redirect('backend/categoria');
        //$data['relations'] = $this->load->view('relations','',true);

        $data_content['categoria'] = $this->categoria_model->read($id);
        $data_content['estados'] = modules::run('services/relations/get_all', 'estado', 'true');
		$data_content['tipos_cat'] = modules::run('services/relations/get_all', 'tipo_categoria', 'true');
		$data_content['arbol_categorias'] = modules::run('services/relations/arbol_categorias', $data_content['categoria']->id_tipo_cat, $id, $data_content['categoria']->id_categoria_padre);
        //$data_content['arbol_categorias'] = modules::run('services/relations/arbol_categorias', $id, $data_content['categoria']->id_categoria_padre);
        $data['breadcrumbs'] = array('categoria' => lang('categorias'), 'backend/editar_categoria' => lang('categoria_edi_tit'), $id => $data_content['categoria']->nombre);
        $data['title'] = lang('editar').' '.$data_content['categoria']->nombre;
        $data['main_content'] = $this->load->view('crear_categoria', $data_content, true);
        //$data['main_content']=json_encode($data_content['categoria']);
        //echo json_encode($data_content['categoria']);
        //die();
        if ($ajax)
            echo $data['main_content'];
        else
            $this->load->view('back/template', $data);

        //return json_encode($this->categoria_model->read($id));
    }

    function ficha($id = '') {

        if ($id == '')
            redirect('backend/categorias');
        $data['active'] = 'categoria';
        $data['sub'] = 'editar';
        $data['title'] = lang('ficha_categoria');
        //$data['relations'] = $this->load->view('relations','',true);
        if (!$data_content['categoria'] = $this->categoria_model->read($id))
            redirect('backend/categorias');
        if (($data_content['categoria']->id_categoria) == '') {
            $data_content['categoria']->id_categoria = $id;
        }
        //$data_content['categoria_padre']=$this->read($data_content['categoria']->id_categoria_padre);

        $data['breadcrumbs'] = array('categoria' => lang('categorias'), 'ficha' => lang('listado'), $id => (isset($data_content['categoria']->nombre) ? lang('ficha_titulo').' '. $data_content['categoria']->nombre : lang('categoria_sinnombre')));
        $data['nombre'] = (isset($data_content['categoria']->nombre) ? lang('ficha_titulo').' ' . $data_content['categoria']->nombre : lang('categoria_sinnombre'));
        $data_content['categoria_idiomas'] = $this->categoria_model->detalles($id);
        $data_content['cat_path'] = modules::run('services/relations/get_categoria_bc', $id);
        //echo '<pre>'.print_r($data_content['cat_path'],true).'</pre>';
        $data['main_content'] = $this->load->view('ficha_categoria', $data_content, true);
        $this->load->view('back/template', $data);
        //return json_encode($this->categoria_model->read($id));
    }

    function editar_idioma($id_categoria, $id_detalle_categoria = '') {
        if ($id_detalle_categoria == '')
            redirect('backend/ficha_categoria/' . $id_categoria);
        echo modules::run('template/editar_idioma_form', $id_categoria, $id_detalle_categoria, 'categoria');
    }

    function guardar_idioma() {
        //echo '<pre>'.print_r($_POST,true).'</pre>';
        $data_content = $_POST;
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        $this->load->helper(array('form', 'url'));
        $this->form_validation->set_rules('id_idioma', 'Idioma', 'required');
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|min_length[3]');
        //$this->form_validation->set_rules('descripcion_breve', 'Descripcion', 'required|min_length[10]|max_length[360]');
        $this->form_validation->set_rules('descripcion_ampliada', 'Descripcion', 'min_length[10]|max_length[999920]');
        $this->form_validation->set_rules('url', 'URL', 'required|min_length[3]');
        $this->form_validation->set_rules('titulo_pagina', 'Titulo Pagina', 'required');
        $this->form_validation->set_rules('descripcion_imagen', 'Descripcion Imagen', '');
        $this->form_validation->set_rules('descripcion_pagina', 'Descripcion Pagina', 'required|min_length[10]|max_length[9999150]');
        $this->form_validation->set_rules('keywords', 'Palabras clave', 'required');
        if ($this->form_validation->run($this) == FALSE) {
            $data['active'] = 'categoria';
            $data['sub'] = 'crear';
            $data['title'] = 'Editar idioma categoria';
            if ($data_content['id_categoria'] != '') {
                $data_content['categoria'] = modules::run('categoria/read', $data_content['id_categoria']);
                $data_content['id_idioma'] = $this->input->post('id_idioma');
                $data_content['imagen'] = modules::run('services/relations/get_rel', 'categoria', 'imagen', $data_content['id_categoria'], 'true');
                $data['breadcrumbs']['categoria'] = lang('categorias');
                $data['breadcrumbs']['edit'] = lang('idioma_edt_cat');
                $data['breadcrumbs'][$data_content['id_categoria']] = $data_content['nombre'];
                //$data_content['imagen']=modules::run('services/relations/get_rel','categoria','imagen',$data_content['id_categoria'],'true');
            } else {
                $data['breadcrumbs'] = array('categoria' => lang('categorias'), 'crear' => lang('crear_tit_cat'));
            }
            $data_content['nuevo'] = true;
            $data['main_content'] = $this->load->view('template/crear_idioma_form_categoria', $data_content, true);
            $this->load->view('back/template', $data);
        } else {

            if (isset($data_content['descripcion_imagen'])) {
                $img['descripcion_multimedia'] = $data_content['descripcion_imagen'];
                $img['id_idioma'] = $data_content['id_idioma'];
                $img['id_multimedia'] = $data_content['descripcion_imagen_id'];
                modules::run('services/relations/insert_detalle_multimedia', $img);
                unset($data_content['descripcion_imagen']);
                unset($data_content['descripcion_imagen_id']);
                unset($data_content['id_detalle_multimedia']);
                ///echo "aaa";
            }
            $id = $this->categoria_model->update_idioma($data_content);
            modules::run('services/monitor/add', 'detalle_obra', $id, $this->session->userdata('id_usuario'), 'editar_idioma');
            redirect('backend/ficha_categoria/' . $data_content['id_categoria']);
        }

        //modules::run('services/monitor/add','detalle_categoria',$id,$this->session->userdata('id_usuario'),'editar_idioma');
        //redirect('backend/ficha_categoria/'.$data['id_categoria']);
    }

    /*
      function guardar_idioma(){
      //echo '<pre>'.print_r($_POST,true).'</pre>';
      $data_content=$_POST;
      $this->load->library('form_validation');
      $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
      $this->load->helper(array('form', 'url'));
      $this->form_validation->set_rules('id_idioma', 'Idioma', 'required');
      $this->form_validation->set_rules('nombre', 'Nombre', 'required|min_length[5]');
      //$this->form_validation->set_rules('descripcion_breve', 'Descripcion Breve', 'required|min_length[10]');
      $this->form_validation->set_rules('descripcion_ampliada', 'Descripcion Ampliada', 'min_length[50]');
      $this->form_validation->set_rules('url', 'URL', 'required|min_length[5]');
      $this->form_validation->set_rules('titulo_pagina', 'Titulo Pagina', '');
      $this->form_validation->set_rules('descripcion_imagen', 'Descripcion Imagen', '');
      $this->form_validation->set_rules('descripcion_pagina', 'Descripcion Pagina', '');
      if ($this->form_validation->run($this) == FALSE)
      {
      $data['active']='categoria';
      $data['sub']='crear';
      $data['title']='Editar idioma categoria';
      if ($data_content['id_categoria']!=''){
      $data_content['categoria']=modules::run('categoria/read',$data_content['id_categoria']);
      $data_content['imagen']=modules::run('services/relations/get_rel','categoria','imagen',$data_content['id_categoria'],'true');
      $data['breadcrumbs']['categoria']='Categorias';
      $data['breadcrumbs']['edit']='Editar idioma de una categoria';
      $data['breadcrumbs'][$data_content['id_categoria']]=$data_content['nombre'];
      //$data_content['imagen']=modules::run('services/relations/get_rel','categoria','imagen',$data_content['id_categoria'],'true');
      }else{
      $data['breadcrumbs']=array('categoria'=>'Categorias','crear'=>'Crear una categoria');
      }
      $data_content['nuevo']=true;
      $data['main_content'] = $this->load->view('template/crear_idioma_form_categoria',$data_content,true);
      $this->load->view('back/template',$data);

      }else{

      if(isset($data_content['descripcion_imagen'])){
      $img['descripcion_multimedia']=$data_content['descripcion_imagen'];
      $img['id_idioma']=$data_content['id_idioma'];
      $img['id_multimedia']=$data_content['descripcion_imagen_id'];
      modules::run('services/relations/insert_detalle_multimedia',$img);
      unset($data_content['descripcion_imagen']);
      unset($data_content['descripcion_imagen_id']);
      unset($data_content['id_detalle_multimedia']);
      ///echo "aaa";
      }
      $id=$this->categoria_model->update_idioma($data_content);
      modules::run('services/monitor/add','detalle_obra',$id,$this->session->userdata('id_usuario'),'editar_idioma');
      redirect('backend/ficha_categoria/'.$data_content['id_obra']);
      }

      //modules::run('services/monitor/add','detalle_categoria',$id,$this->session->userdata('id_usuario'),'editar_idioma');
      //redirect('backend/ficha_categoria/'.$data['id_categoria']);
      }
     */

    function eliminar_idioma($id, $ajax = false) {
        $detalle = $this->detalle($id);
        $ret = $this->categoria_model->eliminar_idioma($id);
        modules::run('services/monitor/add', 'detalle_categoria', $id, $this->session->userdata('id_usuario'), 'eliminar_idioma');
        $str = ($ret == true) ? 'true' : 'false';
        if ($ajax)
            echo '[{result:' . $str . '}]';
        else
            redirect('backend/ficha_categoria/' . $detalle->id_categoria);
    }

    function delete($id, $ajax = false) {
        $ret = $this->categoria_model->delete($id);
        $str = ($ret == true) ? 'true' : 'false';
        if ($ajax)
            echo '[{result:' . $str . '}]';
        else
            return $ret;
    }

    function read($id, $ajax = false, $detalle_id = '') {
        $ret = $this->categoria_model->read($id, $detalle_id);
        if ($ajax)
            echo json_encode($ret);
        else
            return $ret;
    }

    function detalle($id, $ajax = false) {
        $ret = $this->categoria_model->get('detalle_categoria', $id);
        if ($ajax)
            echo json_encode($ret);
        else
            return $ret;
    }

    function categorias_categoria($id_categoria, $ajax = 1) {
        if ($ajax == 1)
            echo modules::run('services/relations/get_from_categoria', $id_categoria, 'categoria', $ajax);
        else
            return modules::run('services/relations/get_from_categoria', $id_categoria, 'categoria', $ajax);
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
