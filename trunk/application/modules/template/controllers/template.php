<?php

class Template extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->lang->load('back');
		$operadoras = array('listado' => lang('backend_url').'/'.lang('operadoras_url'),
									'buscar' => lang('backend_url').'/'.lang('operadoras_url').'/'.lang('buscar_url'),
									'crear'	=> lang('backend_url').'/'.lang('operadoras_url').'/'.lang('crear_url')
									);
	}

	function ultimos_post(){

		$noticias_panel			 = modules::run('services/relations/get_all_orderby','noticia',false,'',true,'noticia.id_noticia');
		$data['noticias_mini']	 = array_slice($noticias_panel, 0, 3);
		$data['placeholder_min'] = 'http://dummyimage.com/40x40/000/fff';

		$this->load->view('ultimos_post',$data);

	}
	
	function access_denied()
	{
		$data['title'] = lang('meta.titulo').' - '.lang('listado');
		$data['sub'] = 'listado';
		$data['active'] = 'noticias';
		$data['menu_principal'] = $this->menus->create_mainmenu(lang('noticias_url'), 'listado');
		$data['usuario'] = array(
										'nombre' => $this->session->userdata('nombre'),
										'apellidos' => $this->session->userdata('apellidos')
									);
		$data['contenido_principal'] = $this->load->view('access_error', $data, true);
		$this->load->view('back/template_new', $data);
	}

	function breadcrumbs($breadcrumbs){
		/*
		$nav=array(
					'obras'=>array('Obras',array('listado'=>'Listado','crear'=>'Crear','buscar'=>'Buscar',
					'artistas'=>
					'colecciones'=>
					'categorias'=>
					'usuarios'=>
					);
					* */
		$data['breadcrumbs']=$breadcrumbs;

		$this->load->view('breadcrumb',$data);

	}

	function breadcrumbs2($breadcrumbs){
		/*
		$nav=array(
					'obras'=>array('Obras',array('listado'=>'Listado','crear'=>'Crear','buscar'=>'Buscar',
					'artistas'=>
					'colecciones'=>
					'categorias'=>
					'usuarios'=>
					);
					* */
		$data['breadcrumbs']=$breadcrumbs;

		$this->load->view('breadcrumb2',$data);

	}

	function facebook($url,$title=''){

		$data['url']='http://'.$_SERVER['SERVER_NAME'].'/'.$url;
		$data['title']=$title;
		$this->load->view('facebook',$data);
	}

	function credito($url,$title='') {

		$url = ((isset($url)&&$url!='') ? $url : '#');
		?>
		<div class="widget_newsletter_ad">
			<span class="message">Solicite su<br>credito</span>
			<span class="line"></span>
			<a href="<?php echo $url ?>" title="Solicite su Credito" class="button red_button"><?php echo lang('credito'); ?></a>
		</div>

		<?php
	}

	function googlemaps($url,$title=''){
		$url = ((isset($url)&&$url!='') ? $url : '#');
		?>
		<div class="widget_gmap_small_ad">
			<a href="<?php echo $url ?>" title="Ubicanos en GoogleMap">
				<img src="assets/front/img/template/gmap-small.jpg" alt="Ubicanos en GoogleMap"/>
			</a>
		</div>

		<?php

	}

	function redes_sociales(){
		?>
		<div class="widget_share fright">
			<!-- AddThis Button -->
			<br>
				<div class="addthis_toolbox addthis_default_style share">
					<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
					<a class="addthis_button_tweet"></a>
					<a class="addthis_button_email"></a>
					<a class="addthis_button_print"></a>
			</div>
											<!-- END - AddThis Button -->
		</div>
		<?php
	}

	function addthis($url,$title=''){

		$data['url']='http://'.$_SERVER['SERVER_NAME'].'/'.$url;
		$data['title']=$title;
		$this->load->view('addthis',$data);
	}

	function votar_receta($id_contenido,$value) {
		if((modules::run('usuarios/is_logged_in_rol','usuario',$this->uri->uri_string()) != false))
		{
			$tipo_contenido = 'receta';
			modules::run('services/relations/votar',$tipo_contenido,$id_contenido,$value);
		}
		else redirect('/');
	}

	function votacion($id,$title='',$url=''){
		//modules::run('template/votar','usuario',$this->uri->uri_string())
		$data['url']='http://'.$_SERVER['SERVER_NAME'].'/'.$url;
		$data['title']=$title;
		$data['num_votos']=modules::run('services/relations/numero_votacion','receta',$id) ;
		$data['votos']=modules::run('services/relations/votacion','receta',$id) ;
		if(isset($data['votos'])) $data['percent'] = $data['votos']*20;
		else  $data['percent'] = 0;
		$data['num_votos'] = ($data['num_votos'] != '' ? $data['num_votos'] : '0');
		$data['id_receta']= $id;
		$this->load->view('front/votacion',$data);
	}

	function votacion_view($id,$title='',$url=''){

		$data['url']='http://'.$_SERVER['SERVER_NAME'].'/'.$url;
		$data['title']=$title;
		$data['num_votos']=modules::run('services/relations/numero_votacion','receta',$id) ;
		$data['votos']=modules::run('services/relations/votacion','receta',$id) ;
		if(isset($data['votos'])) $data['percent'] = $data['votos']*20;
		else $data['percent'] = 0;
		$data['num_votos'] = ($data['num_votos'] != '' ? $data['num_votos'] : '0');
		$data['id_receta']= $id;
		$this->load->view('front/votacion_view',$data);
	}

	function mainmenu($active="participantes")
	{
		?>
		<ul id="mainmenu">
			<!--
			<li class="first"><?php echo ($active=="home") ? '<span class="active">Gestión de <span>home</span></span>' : anchor("backend/home",'Gestión de <span>home</span>',array('title'=>'gestionar la home'))?></li>
			-->
			<li class="first">
				<?php
					$valor_activo = ($this->session->userdata('idioma') == 'es') ? lang('gestion')." <span>".lang('participantes')."</span>" : lang('participante')."'s"." <span>".lang('gestion')."</span>" ;
	            	if ($active == "participantes") {
						echo "<span class = 'active'>".$valor_activo."</span>";
					} else {
						echo anchor(lang('backend_url').'/'.lang('participantes_url'), $valor_activo, array('title' => lang('mainmenu_participantes')));
					}
				?>
            </li>
            <li>
            	<?php
					$valor_activo = ($this->session->userdata('idioma') == 'es') ? lang('gestion')." <span>".lang('premios')."</span>" : lang('premio')."'s"." <span>".lang('gestion')."</span>" ;
	            	if ($active == "premios") {
						echo "<span class = 'active'>".$valor_activo."</span>";
					} else {
						echo anchor(lang('backend_url').'/'.lang('premios_url'), $valor_activo, array('title' => lang('mainmenu_premios')));
					}
				?>
            </li>
            <?php //<li> ?>
				<?php
					/*$valor_activo = ($this->session->userdata('idioma') == 'es') ? lang('gestion')." <span>".lang('operadoras')."</span>" : lang('operadora')."'s"." <span>".lang('gestion')."</span>" ;
	            	if ($active == "operadoras") {
						echo "<span class = 'active'>".$valor_activo."</span>";
					} else {
						echo anchor(lang('backend_url').'/'.lang('operadoras_url'), $valor_activo, array('title' => lang('mainmenu_operadoras')));
					}*/
				?>
            <?php //</li> ?>
            <?php //<li> ?>
				<?php
					/*$valor_activo = ($this->session->userdata('idioma') == 'es') ? lang('gestion')." <span>".lang('canales')."</span>" : lang('canal')."'s"." <span>".lang('gestion')."</span>" ;
	            	if ($active == "canales")
	            	{
						echo "<span class = 'active'>".$valor_activo."</span>";
					}
					else
					{
						echo anchor(lang('backend_url').'/'.lang('canales_url'), $valor_activo, array('title' => lang('mainmenu_canales')));
					}*/
				?>
            <?php //</li> ?>
            <?php //<li> ?>
				<?php
					/*$valor_activo = ($this->session->userdata('idioma') == 'es') ? lang('gestion')." <span>".lang('digital_media')."</span>" : lang('digital_media')."<span>".lang('gestion')."</span>" ;
	            	if ($active == "digital_media")
	            	{
						echo "<span class = 'active'>".$valor_activo."</span>";
					}
					else
					{
						echo anchor(lang('backend_url').'/'.lang('digital_media_url'), $valor_activo, array('title' => lang('mainmenu_digital_media')));
					}*/
				?>
            <?php //</li> ?>
             <?php //<li> ?>
				<?php
					/*$valor_activo = ($this->session->userdata('idioma') == 'es') ? lang('gestion')." <span>".lang('mupis')."</span>" : lang('mupis')."<span>".lang('gestion')."</span>" ;
	            	if ($active == "mupis")
	            	{
						echo "<span class = 'active'>".$valor_activo."</span>";
					}
					else
					{
						echo anchor(lang('backend_url').'/'.lang('mupis_url'), $valor_activo, array('title' => lang('mainmenu_mupis')));
					}*/
				?>
            <?php //</li> ?>
			<?php //<li> ?>
				<?php
					/*$valor_activo = ($this->session->userdata('idioma') == 'es') ? lang('gestion')." <span>".lang('noticias')."</span>" : lang('noticia')."'s"." <span>".lang('gestion')."</span>" ;
	            	if ($active == "noticia") {
						echo "<span class = 'active'>".$valor_activo."</span>";
					} else {
						echo anchor(lang('backend_url').'/'.lang('noticias_url'), $valor_activo, array('title' => lang('mainmenu_noticia')));
					}*/
				?>
            <?php //</li> ?>
            <?php //<li> ?>
				<?php
					/*$valor_activo = ($this->session->userdata('idioma') == 'es') ? lang('gestion')." <span>".lang('noticias')."</span>" : lang('trabajo')."'s"." <span>".lang('gestion')."</span>" ;
	            	if ($active == "trabajo") {
						echo "<span class = 'active'>".$valor_activo."</span>";
					} else {
						echo anchor(lang('backend_url').'/'.lang('trabajos_url'), $valor_activo, array('title' => lang('mainmenu_trabajo')));
					}*/
				?>
            <?php //</li> ?>
            <?php if (modules::run('usuarios/is_logged_in','admin','','true')=='true'){ ?>

            	<?php
				/*<li>
					<?php
						$valor_activo = ($this->session->userdata('idioma') == 'es') ? lang('gestion')." <span>".lang('categorias')."</span>" : lang('categoria')."'s"." <span>".lang('gestion')."</span>" ;
		            	if ($active == "categoria") {
							echo "<span class = 'active'>".$valor_activo."</span>";
						} else {
							echo anchor(lang('backend_url').'/'.lang('categorias_url'), $valor_activo, array('title' => lang('mainmenu_categoria')));
						}
					?>
	            </li>*/
	            ?>
				<li>
					<?php
						$valor_activo = ($this->session->userdata('idioma') == 'es') ? lang('gestion')." <span>".lang('usuarios')."</span>" : lang('usuario')."'s"." <span>".lang('gestion')."</span>" ;
		            	if ($active == "usuario") {
							echo "<span class = 'active'>".$valor_activo."</span>";
						} else {
							echo anchor(lang('backend_url').'/'.lang('usuarios_url'), $valor_activo, array('title' => lang('mainmenu_usuario')));
						}
					?>
	            </li>
	            <?php //<li> ?>
	            	<?php
						/*$valor_activo = ($this->session->userdata('idioma') == 'es') ? lang('gestion')." <span>".lang('contacto')."</span>" : lang('contacto')."'s"." <span>".lang('gestion')."</span>" ;
		            	if ($active == "contacto") {
							echo "<span class = 'active'>".$valor_activo."</span>";
						} else {
							echo anchor(lang('backend_url').'/'.lang('contactos_url'), $valor_activo, array('title' => lang('mainmenu_contacto')));
						}*/
					?>
	            <?php //</li> ?>
	            <li>
	            	<?php
						$valor_activo = ($this->session->userdata('idioma') == 'es') ? lang('gestion')." <span>".lang('monitorizacion')."</span>" : lang('monitorizacion')."'s"." <span>".lang('gestion')."</span>" ;
		            	if ($active == "monitor") {
							echo "<span class = 'active'>".$valor_activo."</span>";
						} else {
							echo anchor(lang('backend_url').'/'.lang('monitor_url'), $valor_activo, array('title' => lang('mainmenu_monitor')));
						}
					?>
	            </li>
           <?php } ?>
        </ul>
		<?php

	}
	function submenu($active = "participante",$sub='listado'){
		//refactor to remove the "case"
		switch ($active) {
			case 'home';
			?>
		<ul id="submenu">
			<li><?php echo ($sub=="izquierda") ? '<span class="active">Caja izquierda</span>' : anchor("backend/home/ver/izquierda",'Caja izquierda',array('title'=>'Caja izquierda'))?></li>
			<li><?php echo ($sub=="central") ? '<span class="active">Caja central</span>' : anchor("backend/home/ver/izquierda",'Caja central',array('title'=>'Caja central'))?></li>
			<li><?php echo ($sub=="derecha") ? '<span class="active">Caja derecha</span>' : anchor("backend/home/ver/izquierda",'Caja derecha',array('title'=>'Caja derecha'))?></li>

		</ul>
		<?php
			break;
			case 'operadoras';
				$operadoras = array('listado' => lang('backend_url').'/'.lang('operadoras_url'),
									'buscar' => lang('backend_url').'/'.lang('operadoras_url').'/'.lang('buscar_url'),
									'crear'	=> lang('backend_url').'/'.lang('operadoras_url').'/'.lang('crear_url')
									);
		?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor($operadoras['listado'], lang('listado'),  array('title'=> lang('listado_tit_ope')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor($operadoras['buscar'], lang('buscar'), array('title'=> lang('buscar_tit_ope')))?></li>
			<li><?php echo ($sub=="crear") ? '<span class="active">'.lang('crear').'</span>' : anchor($operadoras['crear'], lang('crear'), array('title'=>lang('crear_tit_ope')))?></li>
		</ul>
		<?php
			break;
			case 'mupis';
				$mupis = array('listado' => lang('backend_url').'/'.lang('mupis_url'),
							   'buscar' => lang('backend_url').'/'.lang('mupis_url').'/'.lang('buscar_url'),
							   'crear'	=> lang('backend_url').'/'.lang('mupis_url').'/'.lang('crear_url')
							  );
		?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor($mupis['listado'], lang('listado'),  array('title'=> lang('listado_tit_ope')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor($mupis['buscar'], lang('buscar'), array('title'=> lang('buscar_tit_ope')))?></li>
			<li><?php echo ($sub=="crear") ? '<span class="active">'.lang('crear').'</span>' : anchor($mupis['crear'], lang('crear'), array('title'=>lang('crear_tit_ope')))?></li>
		</ul>
		<?php
			break;
			case 'canales';
		?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor(lang('backend_url').'/'.lang('canales_url'), lang('listado_url'),  array('title'=> lang('listado_tit_canal')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor(lang('backend_url').'/'.lang('canales_url').'/'.lang('buscar_url'), lang('buscar'), array('title'=> lang('buscar_tit_canal')))?></li>
			<li><?php echo ($sub=="crear") ? '<span class="active">'.lang('crear').'</span>' : anchor(lang('backend_url').'/'.lang('canales_url').'/'.lang('crear_url'),lang('crear'), array('title'=>lang('crear_tit_canal')))?></li>
		</ul>
		<?php
			break;
			case 'digital_media';
		?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor(lang('backend_url').'/'.lang('digital_media_url'), lang('listado_url'),  array('title'=> lang('listado_tit_dgm')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor(lang('backend_url').'/'.lang('digital_media_url').'/'.lang('buscar_url'), lang('buscar'), array('title'=> lang('buscar_tit_dgm')))?></li>
			<li><?php echo ($sub=="crear") ? '<span class="active">'.lang('crear').'</span>' : anchor(lang('backend_url').'/'.lang('digital_media_url').'/'.lang('crear_url'),lang('crear'), array('title'=>lang('crear_tit_dgm')))?></li>
		</ul>
		<?php
			break;
			case 'producto';
		?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor("backend/productos", lang('listado'), array('title'=> lang('listado_tit_prod')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor("backend/buscar_productos",lang('buscar'),array('title'=> lang('buscar_tit_prod')))?></li>
			<li><?php echo ($sub=="crear") ? '<span class="active">'.lang('crear').'</span>' : anchor("backend/crear_producto",lang('crear'),array('title'=>lang('crear_tit_prod')))?></li>
		</ul>
		<?php
			break;
			case 'premios';
				$premios = array(
										'listado' => lang('backend_url').'/'.lang('premios_url'),
										'buscar' => lang('backend_url').'/'.lang('premios_url').'/'.lang('buscar_url'),
										'crear'	=> lang('backend_url').'/'.lang('premios_url').'/'.lang('crear_url')
									);
		?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor($premios['listado'], lang('listado'),  array('title'=> lang('listado_tit_pre')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor($premios['buscar'], lang('buscar'), array('title'=> lang('buscar_tit_pre')))?></li>
			<li><?php echo ($sub=="crear") ? '<span class="active">'.lang('crear').'</span>' : anchor($premios['crear'], lang('crear'), array('title'=>lang('crear_tit_pre')))?></li>
		</ul>
		<?php
			break;
			case 'participantes';
			$participantes = array(
										'listado' => lang('backend_url').'/'.lang('participantes_url'),
							  			'buscar'  => lang('backend_url').'/'.lang('participantes_url').'/'.lang('buscar_url')
							 	  );
		?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor($participantes['listado'], lang('listado'), array('title'=>lang('listado_tit_par')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor($participantes['buscar'], lang('buscar'), array('title'=>lang('buscar_tit_par')))?></li>
		</ul>

		<?php
			break;
			case 'proyecto';
		?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor("backend/proyecto", lang('listado'), array('title'=> lang('listado_tit_proy')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor("backend/buscar_proyectos",lang('buscar'),array('title'=> lang('buscar_tit_proy')))?></li>
			<li><?php echo ($sub=="crear") ? '<span class="active">'.lang('crear').'</span>' : anchor("backend/crear_proyecto",lang('crear'),array('title'=>lang('crear_tit_proy')))?></li>
		</ul>
		<?php
			break;
			case 'noticia';
			$noticias = array('listado' => lang('backend_url').'/'.lang('noticias_url'),
							  'buscar'  => lang('backend_url').'/'.lang('noticias_url').'/'.lang('buscar_url'),
							  'crear'   => lang('backend_url').'/'.lang('noticias_url').'/'.lang('crear_url')
							 );

		?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor("backend/noticias",lang('listado'),array('title'=>lang('listado_tit_not')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor("backend/buscar_noticias",lang('buscar'),array('title'=>lang('buscar_tit_not')))?></li>
			<li><?php echo ($sub=="crear") ? '<span class="active">'.lang('crear').'</span>' : anchor("backend/crear_noticia",lang('crear'),array('title'=>lang('crear_tit_not')))?></li>
		</ul>
		<?php
			break;
			case 'trabajo';
			$trabajos = array('listado'=> lang('backend_url').'/'.lang('trabajos_url'),
							  'buscar' => lang('backend_url').'/'.lang('trabajos_url').'/'.lang('buscar_url'),
							  'crear'  => lang('backend_url').'/'.lang('trabajos_url').'/'.lang('crear_url')
									);
		?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor($trabajos['listado'], lang('listado'), array('title'=>lang('listado_tit_trjb')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor($trabajos['buscar'], lang('buscar'), array('title'=>lang('buscar_tit_trjb')))?></li>
			<li><?php echo ($sub=="crear") ? '<span class="active">'.lang('crear').'</span>' : anchor($trabajos['crear'], lang('crear'),array('title'=>lang('crear_tit_trbj')))?></li>
		</ul>
		<?php
			break;
			case 'banner';
			?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor("backend/banners",lang('listado'),array('title'=>lang('listado_tit_bnn')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor("backend/buscar_banners",lang('buscar'),array('title'=>lang('buscar_tit_bnn')))?></li>
			<li><?php echo ($sub=="crear") ? '<span class="active">'.lang('crear').'</span>' : anchor("backend/crear_banner",lang('crear'),array('title'=>lang('crear_tit_bnn')))?></li>
		</ul>
		<?php
			break;
			case 'promocion';
			?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor("backend/promociones",lang('listado'),array('title'=>lang('listado_tit_prom')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor("backend/buscar_promociones",lang('buscar'),array('title'=>lang('buscar_tit_prom')))?></li>
			<li><?php echo ($sub=="crear") ? '<span class="active">'.lang('crear').'</span>' : anchor("backend/crear_promocion",lang('crear'),array('title'=>lang('crear_tit_prom')))?></li>
		</ul>
		<?php
			break;
			case 'faq';
			?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor("backend/faqs",lang('listado'),array('title'=> lang('listado_tit_faq')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor("backend/buscar_faqs",lang('buscar'),array('title'=> lang('buscar_tit_faq')))?></li>
			<li><?php echo ($sub=="crear") ? '<span class="active">'.lang('crear').'</span>' : anchor("backend/crear_faq",lang('crear'),array('title'=> lang('crear_tit_faq')))?></li>
		</ul>
		<?php
			break;
			case 'categoria';
		?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor("backend/categorias",lang('listado'),array('title'=> lang('listado_tit_cat')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor("backend/buscar_categorias",lang('buscar'),array('title'=> lang('buscar_tit_cat')))?></li>
			<li><?php echo ($sub=="crear") ? '<span class="active">'.lang('crear').'</span>' : anchor("backend/crear_categoria",lang('crear'),array('title'=> lang('crear_tit_cat')))?></li>

		</ul>
		<?php
			break;
			case 'contacto';
			$contactos = array(
									'listado'	=> lang('backend_url').'/'.lang('contactos_url'),
							  		'descarga'  => lang('backend_url').'/'.lang('contactos_url').'/'.lang('descarga_url')
							  );
		?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor($contactos['listado'], lang('listado'), array('title'=>lang('listado_tit_cnc')))?></li>
			<li><?php echo ($sub=="descarga") ? '<span class="active">'.lang('descarga').'</span>' : anchor($contactos['descarga'], lang('descarga'), array('title'=>lang('desc_tit_trbj')))?></li>
		</ul>
		<?php
			break;
			case 'usuario':
			$usuarios = array('listado' => lang('backend_url').'/'.lang('usuarios_url'),
							  'buscar'  => lang('backend_url').'/'.lang('usuarios_url').'/'.lang('buscar_url'),
							  'crear'   => lang('backend_url').'/'.lang('usuarios_url').'/'.lang('crear_url')
							 );
		?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor($usuarios['listado'], lang('listado'), array('title'=>lang('listado_tit_usrs')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor($usuarios['buscar'], lang('buscar'), array('title'=> lang('buscar_tit_usrs')))?></li>
			<li><?php echo ($sub=="crear") ? '<span class="active">'.lang('crear').'</span>' : anchor($usuarios['crear'], lang('crear'), array('title'=>lang('crear_tit_usrs')))?></li>
		</ul>

		<?php
			break;
			case 'multimedia':
		?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor("backend/multimedia",lang('listado'),array('title'=>lang('listado_tit_mult')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor("backend/buscar_multimedia",lang('buscar'),array('title'=>lang('buscar_tit_mult')))?></li>
			<li><?php echo ($sub=="crear") ? '<span class="active">'.lang('crear').'</span>' : anchor("backend/crear_multimedia",lang('crear'),array('title'=>lang('crear_tit_mult')))?></li>
		</ul>
		<?php
			break;
			case 'monitor':
		?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor("backend/monitor", lang('listado') ,array('title'=>lang('listado_tit_mon')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor("backend/buscar_monitor",lang('buscar'),array('title'=>lang('buscar_tit_mon')))?></li>

		</ul>
<?php
			break;
			default:
		?>
		<ul id="submenu">
			<li><?php echo ($sub=="listado") ? '<span class="active">'.lang('listado').'</span>' : anchor("backend/productos",lang('listado'),array('title'=> lang('listado_tit_prod')))?></li>
			<li><?php echo ($sub=="buscar") ? '<span class="active">'.lang('buscar').'</span>' : anchor("backend/buscar_productos",lang('buscar'),array('title'=> lang('buscar_tit_prod')))?></li>
			<li><?php echo ($sub=="crear") ? '<span class="active">'.lang('crear').'</span>' : anchor("backend/crear_producto",lang('crear'),array('title'=>lang('crear_tit_prod')))?></li>
		</ul>
<?php
			break;
		}
	}

	function crear_idioma_form($id,$type = 'canal'){
		$data['id_'.$type]=$id;
		$data[$type]='';
		$data['nuevo'] = true;
		if($type == 'trabajo')
		{
			$this->load->model('trabajo_model');
			$data['lugar_trabajo'] = $this->trabajo_model->get_rel_trabajo_lugar($id);
		}
		if ($type != 'multimedia')
			$data['imagen']=modules::run('services/relations/get_rel',$type,'imagen',$id,'true');
		$this->load->view('crear_idioma_form_'.$type,$data);
	}

	function crear_idioma_form2($id,$type='canal')
	{
		$data['id_'.$type]=$id;
		$data[$type]='';
		$data['nuevo'] = true;
		$this->load->view('crear_idioma_form_'.$type,$data);
	}

	function editar_idioma_form($id,$id_detalle,$type='canales',$ajax=false)
	{
		$data['active'] = $type;
		$data['sub'] = 'editar';
		$data[$type] = json_decode(modules::run($type.'/read',$id,'true',$id_detalle));
		if($type == "trabajo")
		{
			$this->load->model('trabajo_model');
			$id_lugar_trabajo = $this->trabajo_model->get_lugar_trabajo_id($id);
			$data['lugar_trabajo'] = $this->trabajo_model->get_lugar_trabajo($id_lugar_trabajo->id_lugar_trabajo);
		}
		if ($type=='coleccion'){
			$coleccion_obras=json_decode(modules::run('services/relations/get_all_rel','coleccion','obra',$id,'true','obra.id_obra'));
			foreach ($coleccion_obras as $co){
				if ($co->destacado==1){
					$obra_destacada=modules::run('obra/read',$co->id_obra);
				}
			}
			$data['imagen'] = modules::run('services/relations/get_rel','producto','imagen',$obra_destacada->id_obra,'true');


		}
		else{
			if($type == 'canales')
				$data['imagen'] = modules::run('services/relations/get_rel', 'canal', 'imagen',$id,'true');
			else
				$data['imagen'] = modules::run('services/relations/get_rel',$type,'imagen',$id,'true');
		}

		$data['nuevo'] = FALSE;
		$idioma = json_decode(modules::run('services/relations/get_from_id','idioma',$data[$type]->id_idioma, 'true' ));


		$tit_map = array('canales' =>'nombre',
						 'producto'=>'nombre',
						 'proyecto'=>'nombre',
						 'categoria'=>'nombre',
						 'receta'=>'nombre',
						 'multimedia'=>'nombre_multimedia',
						 'noticia'=>'nombre',
						 'promocion'=>'nombre',
						 'banner'=>'nombre',
						 'trabajo' => 'nombre',
						 'digital_media' => 'nombre',
						 'mupis' => 'nombre',
						 'usuario' => 'nombre',
						 'premio' => 'nombre'
						 );

		$tp['breadcrumbs']=array($type=>ucwords($type.'s'),
								lang('editar_url').'_'.lang('idioma_url').'/'.$id=>'Editar idioma '.$type,
								''=>$data[$type]->$tit_map[$type],
								$id.'/'.$id_detalle=>lang($idioma->nombre));

		$tp['main_content'] = $this->load->view('crear_idioma_form_'.$type, $data, true);
		if ($ajax){
			echo $tp['main_content'];
		}else{

			$tp['title'] = 'Editar idioma para '.$data[$type]->$tit_map[$type];
			$this->load->view('back/template',$tp);
		}
	}

		function editar_idioma_form2($id,$id_detalle,$type= 'canales',$ajax=false){
		$data['active'] = $type;
		$data['sub'] = 'editar';
		$data['nuevo'] = false;
		$data[$type] = json_decode(modules::run($type.'/read',$id,'true',$id_detalle));

		if($type == 'canales'){
			$data['imagen'] = modules::run('services/relations/get_rel','canal','imagen',$id,'true');
		}
		else{
			$data['imagen'] = modules::run('services/relations/get_rel',$type,'imagen',$id,'true');
		}

		$idioma = json_decode(modules::run('services/relations/get_from_id','idioma',$data[$type]->id_idioma,'true'));
		$tit_map = array('producto'=>'nombre','categoria'=>'nombre','artista'=>'apellidos','tecnica'=>'nombre','exposicion'=>'nombre','publicacion'=>'nombre', 'canales' => 'nombre'); // TODO : anadir para artistas y categorias, si necesario
		$tp['breadcrumbs'] = array($type=>ucwords($type.'s'),
								   'editar_idioma'=>'Editar una '.$type,
								   $id=>$data[$type]->$tit_map[$type],$id.'/'.$id_detalle => $idioma->nombre);
		$tp['main_content'] = $this->load->view('crear_idioma_form_'.$type,$data,true);
		if ($ajax){
			echo $tp['main_content'];
		}else{

			$tp['title']='Editar idioma para '.$data[$type]->$tit_map[$type];
			$this->load->view('back/template',$tp);
		}
	}

	function upload_form($tipo_multimedia = 'imagen',$multimedia=''){
		if ($multimedia==''){

		}
		if ($tipo_multimedia=='imagen'){ ?>

					<input type="hidden" name="imagenActual" value="<?php echo(isset($multimedia->fichero) ? $multimedia->fichero : '')?>" />
					<?php if (isset($multimedia->fichero)){ ?>
						<img src="/assets/img/med/<?php echo $multimedia->fichero?>" alt="<?php echo (isset($multimedia->nombre_multimedia) ? $multimedia->nombre_multimedia : 'Multimedia sin titulo')?>" />
					<?php } ?>
						<label for="imagen">
							 <span id="uploadImage">Subir imagen</span>
							 <span>Imagen</span>
							<input id="imagen" name="imagen" type="file" />
							<input id="imagenName" name="imagenName" type="hidden" />
						</label>

					<?php }elseif($tipo_multimedia=='catalogo'){ ?>

						<input type="hidden" name="fileActual" value="<?php  echo(isset($multimedia->fichero) ? $multimedia->fichero : '')?>" />
						<?php if (isset($multimedia->fichero)){ ?>
						<a href="/assets/pdf/<?php echo $multimedia->fichero?>"><?php echo (isset($multimedia->nombre_multimedia) ? $multimedia->nombre_multimedia : 'Multimedia sin titulo')?></a>
						<?php } ?>
						<label for="filecatalogo">
							 <span>Fichero</span>
							<input id="filecatalogo" name="filecatalogo" type="file" />

						</label>

					<?php }elseif($tipo_multimedia=='video'){
							if (isset($multimedia->fichero) && $multimedia->fichero!=''){
					preg_match('/([0-9]+)/',$multimedia->fichero,$vi);
					$video_id=$vi[1];
					//echo $video_id;
					?>


					<object width="400" height="300"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=<?php echo $video_id?>&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=<?php echo $video_id?>&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="400" height="300"></embed></object>

					<?php } ?>


						<label for="videourl">
							 <span>URL</span>
							<input id="videourl" name="videourl" type="text" value="<?php  echo(isset($multimedia->fichero) ? $multimedia->fichero : '')?>"  />
						</label>

					<?php }

	}



}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
