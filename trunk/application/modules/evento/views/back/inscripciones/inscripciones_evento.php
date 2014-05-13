<div class="row">
	<div class="twelve columns">
		<?php echo $breadcrumbs ?>
		
		<?php if ($evento->inscripcion): ?>
			<dl class="tabs">
				<dd class="active"><a href="#lista"><?php echo lang('inscritos.titulo')?></a></dd>
				<dd><a href="#inscribir"><?php echo lang('inscritos.inscribir') ?></a></dd>
				
				<?php if(isset($reporte_inscritos) && !empty($reporte_inscritos)): ?>
				<dd><a href="#reporte"><?php echo lang('inscritos.reporte'); ?></a></dd>
				<?php endif; ?>
				
			</dl>
			<ul class="tabs-content">
				<li class="active" id="listaTab">
					<?php echo $listado_inscritos ?>
				</li>
				<li id="inscribirTab">
					<?php echo $formulario_inscripcion ?>
				</li>
				
				<?php if(isset($reporte_inscritos) && !empty($reporte_inscritos)): ?>
				<li id="reporteTab">
					<?php echo $reporte_inscritos; ?>
				</li>
				<?php endif; ?>
				
			</ul>
		<?php else: ?>
			<div class="alert-box"><?php echo lang('inscritos.inscripciones_no_habilitadas')?></div>
		<?php endif ?>
	</div>
</div>