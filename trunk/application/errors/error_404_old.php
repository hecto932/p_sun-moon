<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />


		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		
		<meta http-equiv="content-script-type" content="text/javascript" />
			
		<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
		<?php if(!isset($main)) $main = '';?>
		<title><?php echo (isset($title) ? $title : lang('inicio.meta.title')) ?></title>

		<base href="<?php echo base_url(); ?>">	
		<link href='http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>	
	
		
		<link rel="stylesheet" href="../assets/front/css/foundation_plus.css" />
		<link rel="stylesheet" href="../assets/front/css/ie.css" />
		<link rel="stylesheet" href="../assets/front/css/app.css" />
		<link rel="stylesheet" href="../assets/front/css/style_global.css" />
		<link href="../assets/front/css/jquery.tweet.css" media="all" rel="stylesheet" type="text/css"/>
		
		     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script> 	
			<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
	</head>
	
<body class="fondo_error">
<div class="row texto_error">
	
		<h1><?php echo lang('error.mensaje.1').lang('error.mensaje.2'); ?></h1>
		
		<a href="<?php echo base_url(); ?>"><?php echo lang('error.mensaje.4'); ?></a>
		<br>
		<span> Copyright &copy; 2012 Media Global Group, LLC. All rights reserved </span>
	


</div>



</div>
</body>
</html>