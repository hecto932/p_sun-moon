<!doctype html>
<html class="js no-touch svg inlinesvg svgclippaths no-ie8compat">
	<head>
		<base href="http://<?php echo $_SERVER['SERVER_NAME'].'/'; ?>">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Ejemplo de back</title>
		<meta name="description" content="Overlay Studios Website">
		<meta name="author" content="Overlay">
		
		<link rel="shortcut icon" href="assets/front/img/temp/favicon.ico" />
		<link rel="apple-touch-icon" href="assets/front/img/temp/favicon.ico" />

		<!-- GOOGLE FONTS -->
		<link href='http://fonts.googleapis.com/css?family=Magra:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Gudea:400,700' rel='stylesheet' type='text/css'>

		<!-- STANDARD CSS -->
		<link rel="stylesheet" href="assets/back/css/reset.css">
		<link rel="stylesheet" href="assets/back/css/foundation.css">
		<link rel="stylesheet" href="assets/back/css/app.css">
		<link rel="stylesheet" href="assets/back/css/main.css">
		<link rel="stylesheet" href="assets/back/css/responsive-tables.css">
		<link rel="stylesheet" href="assets/back/css/styles.css" />
		<link rel="stylesheet" href="assets/back/css/general_foundicons_ie7.css">
		<link rel="stylesheet" href="assets/back/css/general_foundicons.css">
		<link rel="stylesheet" href="assets/back/css/general_enclosed_foundicons_ie7.css">
		<link rel="stylesheet" href="assets/back/css/general_enclosed_foundicons.css">
		<link rel="stylesheet" href="assets/back/css/foundation-datepicker.css">
		<link rel="stylesheet" href="assets/back/css/jquery-ui.css" />
		<link rel="stylesheet" href="assets/back/css/jquery.fileupload-ui.css">
		<noscript><link rel="stylesheet" href="assets/back/css/jquery.fileupload-ui-noscript.css"></noscript>
		<link rel="stylesheet" href="assets/back/css/prettify.css">
		<link rel="stylesheet" href="assets/back/css/jquery-ui-timepicker-addon.css">
		<link rel="stylesheet" href="assets/back/css/dropdowns-size.css">
		<style>
			.ui-datepicker {
				width: <?php echo lang('datapicker_width')?>;
				z-index:3 important!;
			}
		</style>
		<?php if(isset($eventos_css)): ?>
			<?php echo $eventos_css; ?>
		<?php endif; ?>

		<script src="assets/back/js/jquery.min.js"></script>
		
		<!-- Chosen CSS -->
		<?php if(isset($cargar_chosen) && $cargar_chosen): ?>
			<link href="assets/back/chosen/chosen.css" rel="stylesheet" type="text/css" />
		<?php endif; ?>
		
	</head>

	<body>
		<nav class ="nav_backend top-bar">
			<ul>
				<li class = "name">
					<img src="assets/back/img/template/logo.jpg" />
				</li>
				<li class="toggle-topbar alinear-derecha">
					<span class="etiqueta-menu-principal"><?php echo lang('menu_etiqueta'); ?></span><a href="#"></a>
				</li>
			</ul>
			<section>
				<?php if(isset($menu_principal)): ?>
					<?php echo $menu_principal; ?>
				<?php endif; ?>
				
				<?php //pre($this->session->all_userdata()); ?>
				
				<?php if($this->session->userdata('idioma')): ?>
					
					<?php 
						$idiomas_all 	= modules::run('services/relations/get_all', 'idioma');
						$idioma 		= $this->session->userdata('idioma');
						$idioma_actual	= filtrar($idiomas_all, "idioma=".$idioma);
					?>
					
					<ul class="right">
						<li class="has-dropdown">
							<a href="#"><?php echo ucwords($idioma_actual[0]->nombre); ?></a>
							<ul class="dropdown">
								<?php foreach($idiomas_all as $idiom): ?>
									
									<li>
										<?php echo anchor(base_url().'idioma/idioma/cambiar_idioma/'.$idiom->idioma, $idiom->nombre); ?>
									</li>
									
								<?php endforeach; ?>
							</ul>
						</li>
					</ul>
				<?php endif; ?>
				
				<?php if(isset($usuario)): ?>
					<ul class="right">
						<li class="has-dropdown">
							<a href="#"><?php echo ucwords($usuario['nombre'].' '.$usuario['apellidos']); ?></a>
							<ul class="dropdown">
								<li>
									<?php echo anchor(lang('backend_url').'/'.lang('usuarios_url').'/logout', lang('salir_sistema'), array('title'=> lang('salir_sistema'))); ?>
								</li>
							</ul>
						</li>
					</ul>
				<?php endif; ?>
			</section>
		</nav>

		<header class="info">
			<div class ="row">
				<div class = "twelve columns">
					<?php //die_pre($sub.'_'.$active.'_titulo'); ?>
					<h1><?php echo lang($sub.'_'.$active.'_titulo'); ?></h1>
					<h4><?php echo lang($sub.'_'.$active.'_info'); ?></h4>
				</div>
			</div>
		</header>
		
		