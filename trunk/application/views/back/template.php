<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ES-es" lang="ES-es">
<?php 
$baseurl = 'assets/back';
?>
<head>

	<title><?php echo (isset($title) ? $title.' - ' : '')?><?php echo lang('nombre_principal');?></title>
    <link rel="shortcut icon" href="<?php echo $baseurl;?>/assets/img/template/favicon.ico" type="image/x-icon" />
    <base href="http://<?php echo $_SERVER['SERVER_NAME']?>/" />

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

	<meta http-equiv="content-language" content="es" />
    <meta http-equiv="content-style-type" content="text/css" />

    <link href="<?php echo $baseurl;?>/assets/css/css_main.css" type="text/css" rel="stylesheet" media="all" />
    <link href="<?php echo $baseurl;?>/assets/css/uploadify.css" type="text/css" rel="stylesheet" media="all" />
    <link href="<?php echo $baseurl;?>/assets/css/css_safari.css" type="text/css" rel="stylesheet" media="all" />
    <link href="<?php echo $baseurl;?>/assets/css/start/jquery-ui-1.8.14.custom.css" type="text/css" rel="stylesheet" media="all" />							
<!--[if lt IE 8]>
    <link href="<?php echo $baseurl;?>/assets/css/css_ie7.css" type="text/css" rel="stylesheet" media="all" />
<![endif]-->


   <!--  <link href="<?php echo $baseurl;?>/assets/css/css_print.css" type="text/css" rel="stylesheet" media="print" />  -->



	<script type="text/javascript" src="<?php echo $baseurl;?>/assets/js/jquery-1.5.1.min.js"></script>
	
	<script type="text/javascript" src="<?php echo $baseurl;?>/assets/js/jquery-ui-1.8.14.custom.min.js"></script>
	
	<script type="text/javascript" src="<?php echo $baseurl;?>/assets/js/swfobject.js"></script>
	<script type="text/javascript" src="<?php echo $baseurl;?>/assets/js/tags.js"></script>
	<script type="text/javascript" src="<?php echo $baseurl;?>/assets/js/uploadify.js"></script>
	<script type="text/javascript" src="<?php echo $baseurl;?>/assets/js/jquery.textareaCounter.plugin.js"></script>
	<script type="text/javascript" src="<?php echo $baseurl;?>/assets/js/autoresize.jquery.min.js"></script>	
        
	<!-- markItUp! -->
	<script type="text/javascript" src="<?php echo $baseurl;?>/assets/js/jquery.markitup.js"></script>
	<!-- markItUp! toolbar settings -->
	<script type="text/javascript" src="<?php echo $baseurl;?>/assets/js/markitup.config.js"></script>
	<!-- markItUp! skin -->
	<link rel="stylesheet" type="text/css" href="<?php echo $baseurl;?>/assets/css/markitup.skin.css" />
	<!--  markItUp! toolbar skin -->
	<link rel="stylesheet" type="text/css" href="<?php echo $baseurl;?>/assets/css/markitup.toolbar.skin.css" />
	
	<!-- jsTree -->
    <script type="text/javascript" src="<?php echo $baseurl;?>/assets/js/jquery.jstree.js"></script>
	<script type="text/javascript" src="<?php echo $baseurl;?>/assets/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="<?php echo $baseurl;?>/assets/js/jquery.hotkeys.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseurl;?>/assets/css/jsTree.style.css" />
<?php

$active=(isset($active) ? $active : 'producto');
$sub=(isset($sub) ? $sub : 'listado');
if ($active=='noticia' && $sub=='crear'){
?>
    <script type="text/javascript" src="<?php echo $baseurl; ?>/assets/js/input_mask.js"></script>
<?php
}
?>
	

	<script type="text/javascript" src="<?php echo $baseurl; ?>/assets/js/actions.js"></script>


</head>

<body <?php echo (isset($login) && $login==true ? ' class="login"' : "")?>>
<div id="wrapper">
<?php if (!isset($login) || $login!=true){ ?>
	<!-- Cabecera -->
	<div id="header">

		<!-- Saltar navegación -->
		<ul class="oculto">
			<li><a title="saltar a la información principal de la página" href="#container">Enlace a la información principal de la página</a></li>
			<li><a title="saltar al menú de navegación principal de la página" href="#mainmenu">Enlace al menú de navegación principal de la página</a></li>
		</ul>
		<!-- Saltar navegación cierre -->


		<?php echo modules::run('usuarios/cp');?>

		<!-- Menú Principal -->
		<strong class="oculto"> <?php echo lang('menu_nav_prin'); ?> </strong>
		<?php 

		echo modules::run('template/mainmenu',$active);?>
		<!-- Menú Principal cierre -->

		<!-- Submenú -->
		<?php 

		echo modules::run('template/submenu',$active,$sub);?>
		
		<!-- Submenú cierre -->

	</div>
	<!-- Cabecera cierre -->

	<hr />
<?php } ?>
	<!-- Bajo Cabecera -->
	<div id="subheader">
		<h1><?php echo lang('nombre_principal'); ?></h1>

		<strong class="oculto"><?php echo $this->lang->line('usted_esta'); ?></strong>
		<?php 
		if (!isset($login) || $login!=true) echo modules::run('template/breadcrumbs',$breadcrumbs);
		?>
	</div>
	
	<!-- Bajo Cabecera cierre -->

<?php 
/*
$idiomas=json_decode(modules::run('idioma/get_all'));
//Poner aqui un select de idiomas
echo $this->config->item('language')."<br>";
//$this->session->set_userdata('back',$this->uri->uri_string());

echo '<pre>'.print_r($idiomas,true).'</pre>';
/*
//echo (isset($relations)) ? $relations : ''; */?>

	<!-- Contenedor -->
	<div id="container">
		<!-- Formulario Cambio Idioma Inicio -->
<?php 
		

		/* echo form_open('backend/idioma_post','id="idiom_form"')?>
			<fieldset>
				<legend> <?php echo lang('idioma_cambio'); ?> </legend>
				<p>
					<label for="idioma">
						<span> <?php echo lang('idioma_titulo'); ?> :</span>
						<select name="idioma" id="idioma">
						<?php
						foreach($idiomas as $idioma){
							$tr=($this->config->item('language')==$idioma->idioma) ? ' selected="selected"' : '';
							echo '<option value="'.$idioma->idioma.'"'.$tr.'>'.$idioma->nombre.'</option>';
						}
						?>
						</select>
					</label>
				</p>
				<strong class="boton"><button type="submit"> <?php echo lang('idioma_cambio'); ?> </button></strong>
			</fieldset>
 				* <!-- Formulario Cambio Idioma cierre -->
		</form>*/
		
		?>
<?php echo $main_content ?>

	</div>
	<!-- Contenedor cierre -->

</div>

</body>
</html>
