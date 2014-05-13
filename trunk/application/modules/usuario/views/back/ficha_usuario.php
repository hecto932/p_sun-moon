<div class="row">
	<div class="twelve columns">
		<?php if(isset($breadcrumbs)): ?>
					<?php echo $breadcrumbs; ?>
			<?php endif; ?>

		<dl class="tabs contained">
				<dd class="active">
					<a href="#tabFicha" title=""> <i class="gen-enclosed foundicon-address-book"></i> <?php echo lang('usuarios_fic_titA'); ?> </a>
				</dd>

		</dl>
		<ul class="tabs-content contained">
				<li class="active" id="tabFicha">
					<h2> <?php echo lang('usuarios_fic_titB'); ?> </h2>

					<div class="ficha_obra"><br />

							<table style="border: 0px; padding: 3px 3px;">
								<?php if ($usuario_info->nombre!='') { ?>
								<tr>
									<td><i class="foundicon-address-book"></i> <?php echo lang('usuarios_nom'); ?>:</td>
									<td><span> <?php echo ucfirst($usuario_info->nombre); ?> </span></td>
								</tr><?php } ?>
								<?php if ($usuario_info->apellidos!='') { ?>
								<tr>
									<td><i class="foundicon-address-book"></i> <?php echo lang('usuarios_ape'); ?>:</td>
									<td><span> <?php echo ucfirst($usuario_info->apellidos); ?> </span></td>
								</tr><?php } ?>
								<?php if ($usuario_info->email!='') { ?>
								<tr>
									<td><i class="foundicon-mail"></i> <?php echo lang('usuarios_ema'); ?>:</td>
									<td><span> <?php echo $usuario_info->email; ?> </span></td>
								</tr><?php } ?>
								<?php if ($usuario_info->id_rol!='') { ?>
								<tr>
									<td><i class="foundicon-settings"></i> <?php echo lang('usuarios_rol'); ?>:</td>
									<td><span> <?php echo ($usuario_info->id_rol=='2') ? lang('editor') : lang('administrador'); ?> </span></td>
								</tr><?php } ?>
							</table>
							
					</div><br />

				<?php echo anchor(lang('backend_url').'/'.lang('usuarios_url').'/'.lang('editar_url').'_'.lang('usuario_url').'/'.$usuario_info->id_usuario, lang('usuarios_fic_eusr') ,array('title'=>lang('usuarios_fic_eusr'), 'class' => 'button radius wtc')); ?>
				</li>
		</ul>
	</div>
</div>