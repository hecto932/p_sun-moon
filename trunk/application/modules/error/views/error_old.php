<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>No puede ser mostrada</title>
<link href="<?php echo base_url(); ?>/assets/front/css/960/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>/assets/front/css/960/960.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>/assets/front/css/960/text.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>/assets/front/css/style.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Kreon:300,400,700' rel='stylesheet' type='text/css'>

</head>

<?php $numero = rand(1,5); ?>
<body id="bodyerror<?php echo $numero;?>">
<div class="container_16 errorcontent">
<div class="ribbonerror">
<h1><?php echo lang('error.mensaje.1'); ?><br />
<?php echo lang('error.mensaje.2'); ?></h1>

<p><?php echo lang('error.mensaje.3'); ?></p>

<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>/assets/front/img/template/homeverde.png" /></a>



</div>

<span><?php echo lang('footer_wintech'); ?> <a target="_blank"href="http://www.wintech.com.ve/"><img src="<?php echo base_url(); ?>/assets/front/img/template/wintechlogo.png" /></a></span>

</div>
</body>
</html>