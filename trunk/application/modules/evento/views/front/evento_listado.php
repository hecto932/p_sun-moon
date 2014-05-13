<div class="row">
	<div class="twelve columns">
			<div class="tit_bread">
				<h1 class="hide-for-small"><?php echo lang('eventos.titulo_secc'); ?></h1>
				<h2 class="show-for-small"><?php echo lang('eventos.titulo_secc'); ?></h2>
				<ul class="breadcrumbs hide-for-touch">
					<?php if(isset($breadcrumbs) && !empty($breadcrumbs)): ?>
						<?php
							$cont = 1;
							$limite = count($breadcrumbs);
							foreach($breadcrumbs as $key => $value):
						?>
							<?php if($cont == $limite): ?>
								<li class="current" ><a href="#"><?php echo $value; ?></a></li>
							<?php else: ?>
								<li><a href="<?php echo base_url().$key; ?>"><?php echo $value; ?></a></li>
							<?php endif; ?>

						<?php
							$cont++;
							endforeach;
						?>
					<?php endif; ?>
				</ul>
			</div>
	</div>
</div>


<div class="row">

	<div class="six columns hide-for-small">
		<dl class="sub-nav">
	  		<dt><?php echo lang('eventos_orden'); ?></dt>
	  		<?php if($order_active!=1 && $order_active!=2) : ?>
	  		<dd class="active"><a href="<?php echo base_url().lang('eventos_url'); ?>"><?php echo lang('eventos_todos'); ?></a></dd>
	  		<?php else: ?>
	  		<dd><a href="<?php echo base_url().lang('eventos_url'); ?>"><?php echo lang('eventos_todos'); ?></a></dd>
	  		<?php endif; ?>
	  		<?php if($order_active==2) : ?>
	  		<dd class="active"><a title="<?php echo lang('eventos_semana_title'); ?>" href="<?php echo base_url().lang('eventos_url').'/'.lang('act_semana_url'); ?>"><?php echo lang('eventos_semana'); ?></a></dd>
	  		<?php else: ?>
	  		<dd><a title="<?php echo lang('eventos_semana_title'); ?>" href="<?php echo base_url().lang('eventos_url').'/'.lang('act_semana_url'); ?>"><?php echo lang('eventos_semana'); ?></a></dd>
	  		<?php endif; ?>
	  		<?php if($order_active==1) : ?>
	  		<dd class="active"><a title="<?php echo lang('eventos_mes_title'); ?>" href="<?php echo base_url().lang('eventos_url').'/'.lang('act_mes_url'); ?>"><?php echo lang('eventos_mes'); ?></a></dd>
	  		<?php else: ?>
	  		<dd><a title="<?php echo lang('eventos_mes_title'); ?>" href="<?php echo base_url().lang('eventos_url').'/'.lang('act_mes_url'); ?>"><?php echo lang('eventos_mes'); ?></a></dd>
	  		<?php endif; ?>
		</dl>
	</div>
	
	<div class="six columns show-for-small" style="float:left">
		<ul class="side-nav">
	  		<li><span style="color: #848484"><?php echo lang('eventos_orden'); ?></span></li>
	  		<li class="divider"></li>
	  		<?php if($order_active!=1 && $order_active!=2) : ?>
	  		<li class="active"><a href="<?php echo base_url().lang('eventos_url'); ?>"><?php echo lang('eventos_todos'); ?></a></li>
	  		<?php else: ?>
	  		<li><a href="<?php echo base_url().lang('eventos_url'); ?>"><?php echo lang('eventos_todos'); ?></a></li>
	  		<?php endif; ?>
	  		<?php if($order_active==2) : ?>
	  		<li class="active"><a title="<?php echo lang('eventos_semana_title'); ?>" href="<?php echo base_url().lang('eventos_url').'/'.lang('act_semana_url'); ?>"><?php echo lang('eventos_semana'); ?></a></li>
	  		<?php else: ?>
	  		<li><a title="<?php echo lang('eventos_semana_title'); ?>" href="<?php echo base_url().lang('eventos_url').'/'.lang('act_semana_url'); ?>"><?php echo lang('eventos_semana'); ?></a></li>
	  		<?php endif; ?>
	  		<?php if($order_active==1) : ?>
	  		<li class="active"><a title="<?php echo lang('eventos_mes_title'); ?>" href="<?php echo base_url().lang('eventos_url').'/'.lang('act_mes_url'); ?>"><?php echo lang('eventos_mes'); ?></a></li>
	  		<?php else: ?>
	  		<li><a title="<?php echo lang('eventos_mes_title'); ?>" href="<?php echo base_url().lang('eventos_url').'/'.lang('act_mes_url'); ?>"><?php echo lang('eventos_mes'); ?></a></li>
	  		<?php endif; ?>
		</ul>
	</div>

</div>

<div id="eventos_todos">

	<div class="row">
		<?php if(isset($eventos) && !empty($eventos)): ?>
			<?php foreach($eventos as $evento): ?>
				<?php if($evento->id_estado != 2 && $evento->id_estado != 3) : ?>
				<div class="four columns">
					<div class="listado_eventos" style="min-height: 355px;">
						<div>
						<?php
							if(is_array($evento->ficheros1) && !empty($evento->ficheros1))
								$fichero = $evento->ficheros1[0];
							else
								$fichero ='';
						 ?>
						<?php
							if (isset($fichero) && $fichero != '' && file_exists(FCPATH.'assets/front/img/med/'.$fichero) && file_exists(FCPATH.'assets/front/img/thumb/'.$fichero))
							{
								$img_thumb = base_url().'assets/front/img/med/'.$fichero;
								$img_large = base_url().'assets/front/img/thumb/'.$fichero;
							}
							else
						    {
								$img_thumb = base_url().'assets/front/img/template/placeholder/placeholder_med.jpg';
								$img_large = base_url().'assets/front/img/template/placeholder/placeholder_med.jpg';
							}
						?>
						<a href="<?php echo base_url().lang('eventos_url').'/'.$evento->url; ?>">
							<img style="min-height: 181px;" src="<?php echo $img_thumb; ?>" />
						</a>

						<div style="clear:both;"></div>

						<?php 
							$base_fecha = strtotime($evento->fecha_evento);
							$dia = lang('dia_'.date('N', $base_fecha));
							$fecha_dia = date('d', $base_fecha);
							$mes = ' '.lang('mes_'.date('n', $base_fecha)).' ';
							$anyo = date(' Y', $base_fecha);
						?>
							<div style="word-wrap: break-word;">
								<h1 class="<?php echo 'evento_'.strtolower(lang('eventos.tipo_'.$evento->id_tipo_evento)); ?>">
									<a href="<?php echo base_url().lang('eventos_url').'/'.$evento->url; ?>"><?php echo character_limiter($evento->nombre, 75); ?></a>
								</h1>
							</div>
						</div>
						<br />
						<div style="text-align: right; color: #6E6E6E; position: absolute; bottom: 60px; right: 30px">
							<!--<hr width="245px" />-->
							<div>
								<small><?php echo $dia.', '.$fecha_dia.$mes.lang('prep_de').$anyo; ?></small>
							</div>
						</div>
						<!--<p><?php echo character_limiter($evento->descripcion_breve, 90); ?>!</p>-->
					</div>



				</div>
				<?php endif; ?>
			<?php endforeach; ?>
			<?php else : ?>
				<div style="margin: 30px 10px; padding: 30px 10px; background: #E6E6E6;">
					<center>
						<h3>
							<strong><?php echo lang('eventos_no_exist').''; ?></strong>
						</h3>
					</center>
				</div>
		<?php endif; ?>
		<hr style="width: 100%;">
	</div>
</div><!--FIN DIV EVENTOS_TODOS-->

	<div class="row">
		<div class="six columns"></div>
		<div class="six columns">
			<?php if(isset($pagination)): ?>
				<?php echo $pagination; ?>
			<?php endif; ?>
		</div>
	</div>