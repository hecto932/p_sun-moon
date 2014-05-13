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

<div class="row asociacion_wtc">
	<div class="six columns">
		<img class="wtc_asociacion" alt="Fachada WTC Valencia" src="<?php echo base_url(); ?>assets/front/img/template/wtcvalencia_fachada.jpg">
	</div>
	
	<div class="six columns">
		<h3>
			<span style="color: rgb(178, 178, 178);">Asociación WTC</span>
		</h3>
		
        <p><br></p>
        
        <p>
        	<span style="color: rgb(79, 79, 79);">World Trade Center Association (WTCA) fue fundada en 1970 y cuenta con más de 300 centros que representan prácticamente todas las regiones comerciales del mundo. La mayoría de los WTC han hecho sus propios grupos creando un universo con más de 1.000.000 de empresas afiliadas a la asociación.</span>
        </p>
        
        <p>
        	<span style="color: rgb(79, 79, 79);">WTCA a través de su familia esparcida en 120 países, fomenta un intercambio global, que promueve la <strong>prosperidad a través del comercio y la inversión</strong>. En paralelo, construye un sistema de pensamiento y una organización de aprendizaje. Toda una red interconectada donde es prioridad la asistencia mutua a través de una política de reciprocidad entre los WTC.</span>
       	</p>
       	
        <p>
        	<span style="color: rgb(79, 79, 79);">Desde sus oficinas principales en la ciudad de Nueva York, WTCA ha desarrollado una variedad de programas para reunir a sus afiliados alrededor de actividades de crecimiento, fortalecimiento e interacción; al tiempo que los mantiene continuamente informados a través de seminarios, boletines electrónicos, entre otros.</span>
        </p>
	</div>
</div>