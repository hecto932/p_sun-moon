<!DOCTYPE html>
<html lang="es">
<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title><?php echo $title; ?></title>
		<meta name="description" content="<?php echo $meta_descripcion; ?>" />
		<meta name="keywords" content="<?php echo $meta_keywords; ?>" />
		<meta name="author" content="Wintech" />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/front/img/temp/wtc_favicon.ico" />
		<link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/front/img/temp/wtc_favicon.ico" />

		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/app.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/foundation.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/estilos.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/jquery.fancybox.css" />
		<?php if (isset($banner_css)) :?>
			<?php echo '<style type="text/css" rel="stylesheet">'.$banner_css.'</style>'; ?>
		<?php else : ?>
			<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/banner/style_alt.css" />
		<?php endif; ?>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/buttons.20a85a6a6705" />

		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/foundation.min.js"></script>
		<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/css/banner/style_ie.css" />
		<![endif]-->

		<link href='http://fonts.googleapis.com/css?family=Quattrocento+Sans:400,400italic,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,400italic' rel='stylesheet' type='text/css'>

</head>

	<body>

  <div id="fb-root"></div>



  <?php if($this->agent->is_browser('Internet Explorer') && $this->agent->version() < '9.0' ): ?>
	  	<div class="100width fondobotonera_ie">
			<div class="row">
				<div class="four columns">
					<img class="logo_ie" src="<?php echo base_url(); ?>assets/front/img/temp/wtclogo.png" />
				</div>

				<div class="eight columns">
					<ul class="right botonera_ie">
				        <li class="expand_button"><a href="<?php echo base_url().lang('wtc_url'); ?>"><?php echo lang('menu.wtc'); ?></a></li>
				        <li class="expand_button"><a href="<?php echo base_url().lang('complejo_wtc_url'); ?>"><?php echo lang('menu.wtc_complejo'); ?></a></li>
				        <li class="expand_button"><a href="<?php echo base_url().lang('servicios_wtc_url'); ?>"><?php echo lang('menu.servicios'); ?></a></li>
				        <li class="expand_button"><a href="<?php echo base_url().lang('membresias_wtc_url'); ?></a></li>
				        <li class="expand_button"><a href="<?php echo base_url().lang('eventos_url'); ?>"><?php echo lang('menu.eventos'); ?></a></li>
				        <li class="expand_button"><a href="<?php echo base_url().lang('noticias_url'); ?>"><?php echo lang('menu.noticias'); ?></a></li>
				        <li class="expand_button"><a href="<?php echo base_url()?>"><?php echo lang('menu.contacto'); ?></a></li>
			        </ul>
				</div>

			</div>
		</div>
  <?php else: ?>

	  	<div class="row">
			  <div class="twelve columns">
			  	<div class="fixed contain-to-grid">
				    <nav class="top-bar">
				      <ul>
				        <li class="name">
				          <h1 class="hide-for-small">
				            <a href="<?php echo base_url(); ?>">
				              <img src="<?php echo base_url(); ?>assets/front/img/temp/wtclogo.png" />
				            </a>
				          </h1>

				          <h1 class="show-for-small">
				            <a href="<?php echo base_url(); ?>">
				              <img class="logo_movil" src="<?php echo base_url(); ?>assets/front/img/temp/wtclogo.png" />
				            </a>
				          </h1>
				        </li>
				        <li class="toggle-topbar" id="expand_button" ><a href="#"></a></li>
				      </ul>

				      <section>
				      	<ul class="right">
					        <li class="expand_button"><a href="<?php echo base_url().lang('wtc_url'); ?>"><?php echo lang('menu.wtc'); ?></a></li>
					        <li class="expand_button"><a href="<?php echo base_url().lang('complejo_wtc_url'); ?>"><?php echo lang('menu.wtc_complejo'); ?></a></li>
					        <li class="expand_button"><a href="<?php echo base_url().lang('servicios_wtc_url'); ?>"><?php echo lang('menu.servicios'); ?></a></li>
					        <li class="expand_button"><a href="<?php echo base_url().lang('membresias_wtc_url'); ?>"><?php echo lang('menu.membresias'); ?></a></li>
					        <li class="expand_button"><a href="<?php echo base_url().lang('eventos_url'); ?>"><?php echo lang('menu.eventos'); ?></a></li>
					        <li class="expand_button"><a href="<?php echo base_url().lang('noticias_url'); ?>"><?php echo lang('menu.noticias'); ?></a></li>
					        <li class="expand_button"><a href="<?php echo base_url().lang('contacto_url'); ?>"><?php echo lang('menu.contacto'); ?></a></li>
				        </ul>
				      </section>
				    </nav>
			    </div>
			  </div>
		</div>

	<?php endif; ?>

