<div class="row">
	<div class="twelve columns">
		<div class="tit_bread">
			<h1 class="hide-for-small"><?php echo lang('wtc.titulo_secc'); ?></h1>
			<h2 class="show-for-small"><?php echo lang('wtc.titulo_secc'); ?></h2>
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
	<div class="three columns">
		<img src="<?php echo base_url(); ?>assets/front/img/template/torre_empresarial/imagen_principal.jpg">
	</div>
	
	<div class="nine columns">
        <h3><span>Torre Empresarial y área comercial anexa.</span><br>
        </h3>
        <p><br></p>
        <div>
          <p>La Torre Empresarial tiene un área total de construcción de 29.088,06 m² y   contempla veintisiete (27) locales comerciales y ciento ocho (108)   oficinas, distribuidas en 12 pisos. Importantes firmas de asesoría   legal, gerencial, sedes corporativas transnacionales, entidades   bancarias y otras empresas clave de la región, tienen sede ya en la   Torre Empresarial WTC. Asimismo, destacadas empresas de servicio y   comercio se han instalado en la zona comercial anexa, por tanto todo el   área se proyecta como el referente empresarial y comercial.</p>
        </div>
	</div>
</div>





