	<div class="row">
		<div class="twelve columns">

			<?php if(isset($breadcrumbs)): ?>
					<?php echo $breadcrumbs; ?>
			<?php endif; ?>

			<dl class="tabs contained ten-up">
				<dd <?php echo ($sub_activo == 'Ficha') ? 'class="active"' : '' ; ?>>
					<a href="#Ficha">
						<i class="foundicon-idea"></i>
						<span><?php echo lang('habitaciones_ficha_tit'); ?></span>
					</a>
				</dd>
				<dd>
					<a href="#Imagenes">
						<i class="gen-enclosed foundicon-photo"></i>
						<span><?php echo lang('imagenes'); ?></span>
					</a>
				</dd>
				<?php
					$idiomas = json_decode(modules::run('services/relations/get_all','idioma','true'));
					foreach($habitacion_idiomas as $habitacion_idioma):
						$idioma[$habitacion_idioma->id_idioma] = json_decode(modules::run('services/relations/get_from_id','idioma',$habitacion_idioma->id_idioma,'true'));
				?>
				<dd>
					<a href="#Lang<?php echo $habitacion_idioma->id_idioma ?>" title="<?php echo strtolower($idioma[$habitacion_idioma->id_idioma]->nombre); ?>">
						
						<i class="foundicon-globe"></i>
						<span> <?php echo lang(strtolower($idioma[$habitacion_idioma->id_idioma]->idioma)); ?> </span>


					</a>
				</dd>
				<?php endforeach; ?>
				<?php if (count($idiomas) > count($habitacion_idiomas) && ($accion != 'editar')): ?>
					<dd <?php echo ($sub_activo == 'NewLangTab') ? 'class="active"' : '' ; ?>>
						<a href="#NewLang">
							<i class="foundicon-add-doc"></i>
							<span><?php echo lang('idioma_crear'); ?></span>
						</a>
					</dd>
				<?php endif; ?>

				<?php if(isset($accion) && $accion == 'editar'): ?>
					<dd <?php echo ($sub_activo == 'EditLangTab') ? 'class="active"' : '' ; ?>>
						<a href="#EditLang">
							<i class="foundicon-edit"></i> 
							<?php echo lang('idioma_editar'); ?>
						</a>
					</dd>
				<?php endif; ?>
			</dl>

			<ul class="tabs-content contained">
				<li id="FichaTab"  <?php echo ($sub_activo == 'Ficha') ? 'class="active"' : '' ; ?>>
					<?php echo $habitacion_info; ?>
				</li>

				<li id="ImagenesTab"  <?php echo ($sub_activo == 'Imagenes') ? 'class="active"' : '' ; ?>>
					<?php echo $habitacion_imagenes; ?>
				</li>

				<?php echo $idioma_info; ?>

				<li id="NewLangTab" <?php echo ($sub_activo == 'NewLangTab') ? 'class="active"' : '' ; ?>>

					<?php if(isset($idioma_nuevo)): ?>
						<?php echo $idioma_nuevo; ?>
					<?php endif; ?>

				</li>

				<li id="EditLangTab" <?php echo ($sub_activo == 'EditLangTab') ? 'class="active"' : '' ; ?>>

					<?php if(isset($idioma_form)): ?>
						<?php echo $idioma_form; ?>
					<?php endif; ?>

				</li>
			</ul>
	</div>
</div>
