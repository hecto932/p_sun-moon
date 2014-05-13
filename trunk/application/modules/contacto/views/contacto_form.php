<div class="row">
	<div class="twelve columns">
		<div class="tit_bread">
			<h1 class="hide-for-small"><?php echo lang('contacto.tit_seccion'); ?></h1>
			<h2 class="show-for-small"><?php echo lang('contacto.tit_seccion'); ?></h2>

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
	<div class="twelve columns">

		<div class="cuadro_contacto hide-for-small">
			<img src="../../assets/front/img/temp/galeria_wtc/large/contacto01.jpg" />
			<div class="cuadro_contacto_inner">
			<h3><?php echo lang('contacto.inst_tit'); ?></h3>
				<h4><?php echo lang('contacto.inst_correo'); ?> <br/> <?php echo lang('contacto.inst_telf'); ?></h4>
			</div>
		</div>

		<div class="cuadro_contacto hide-for-small">
			<img src="../../assets/front/img/temp/galeria_wtc/large/large3.jpg" />
			<div class="cuadro_contacto_inner">
				<h3><?php echo lang('contacto.aloj_tit'); ?></h3>
				<h4><?php echo lang('contacto.aloj_correo'); ?> <br/>  <?php echo lang('contacto.aloj_telf'); ?></h4>
			</div>
		</div>

		<div class="cuadro_contacto hide-for-small">
			<img src="../../assets/front/img/temp/galeria_wtc/large/contacto03.jpg" />
			<div class="cuadro_contacto_inner">
				<h3><?php echo lang('contacto.even_tit'); ?></h3>
				<h4><?php echo lang('contacto.even_correo'); ?> <br/> <?php echo lang('contacto.even_telf'); ?></h4>
			</div>
		</div>

		<div class="cuadro_contacto hide-for-small">
			<img src="../../assets/front/img/temp/galeria_wtc/large/contacto04.jpg" />
			<div class="cuadro_contacto_inner">
				<h3><?php echo lang('contacto.cong_tit'); ?></h3>
				<h4><?php echo lang('contacto.cong_correo'); ?> <br/> <?php echo lang('contacto.cong_telf'); ?></h4>
			</div>
		</div>



		<div class="cuadro_contacto_mobile show-for-small">
			<img src="../../assets/front/img/temp/galeria_wtc/large/contacto01.jpg" />
			<div class="cuadro_contacto_inner">
			<h3><?php echo lang('contacto.inst_tit'); ?></h3>
				<h4><?php echo lang('contacto.inst_correo'); ?> <br/> <?php echo lang('contacto.inst_telf'); ?> </h4>
			</div>
		</div>

		<div class="cuadro_contacto_mobile show-for-small">
			<img src="../../assets/front/img/temp/galeria_wtc/large/large3.jpg" />

			<div class="cuadro_contacto_inner">
				<h3><?php echo lang('contacto.aloj_tit'); ?></h3>
				<h4><?php echo lang('contacto.aloj_correo'); ?> <br/>	<?php echo lang('contacto.aloj_telf'); ?></h4>
			</div>
		</div>

		<div class="cuadro_contacto_mobile show-for-small">
			<img src="../../assets/front/img/temp/galeria_wtc/large/contacto03.jpg" />
			<div class="cuadro_contacto_inner">
				<h3><?php echo lang('contacto.even_tit'); ?></h3>
				<h4><?php echo lang('contacto.even_correo'); ?> <br/> <?php echo lang('contacto.even_telf'); ?> </h4>
			</div>
		</div>

		<div class="cuadro_contacto_mobile show-for-small">
			<img src="../../assets/front/img/temp/galeria_wtc/large/contacto04.jpg" />
			<div class="cuadro_contacto_inner">
				<h3><?php echo lang('contacto.cong_tit'); ?></h3>
				<h4><?php echo lang('contacto.cong_correo'); ?> <br/> <?php echo lang('contacto.cong_telf'); ?> </h4>
			</div>
		</div>


	</div>
</div>


<div class="row">

	<div class="eight columns">

		<div class="radius_content height_contacto">
			<h1><?php echo lang('contacto.form_tit'); ?></h1>
			<p><?php echo lang('contacto.form_desc'); ?></p>

			

				<label for="dropdown_contacto"><?php echo lang('contacto.form_tema'); ?></label>


				<select name="seccion_contacto" id="dropdown_contacto">
					<option SELECTED><?php echo lang('contacto.form_dir1'); ?></option>
					<option><?php echo lang('contacto.form_dir2'); ?></option>
					<option><?php echo lang('contacto.form_dir3'); ?></option>
					<option><?php echo lang('contacto.form_dir4'); ?></option>
				</select>

	  			<label for="nombre_contacto"><?php echo lang('contacto.nomb_label'); ?></label>
	  			<input type="text" name="nombre_contacto" class="" value=""/>

	  			<label><?php echo lang('contacto.dir_label'); ?></label>
	  			<input type="text" name="direccion_contacto" class="" value="" class="twelve" />

	  			<label><?php echo lang('contacto.corr_label'); ?></label>
	  			<input type="text" name="correo_contacto" value="" class="twelve" />

			  <div class="row">

				<div class="six columns">
			    	<label><?php echo lang('contacto.ciu_label'); ?></label>
			    	<input name="ciudad_contacto" value="" class="" type="text" />
			    </div>

			    <div class="three columns">
					<label><?php echo lang('contacto.est_label'); ?></label>
					<input name="estado_contacto" value="" class="" type="text" />
			    </div>

			    <div class="three columns">
					<label><?php echo lang('contacto.cod_label'); ?></label>
					<input name="postal_contacto" value="" class="" type="text" />
			    </div>

			  </div>

			  <label><?php echo lang('contacto.mens_label'); ?></label>
			  <textarea class="" name="mensaje_contacto"></textarea>

			  <button name="enviar_contacto" class="button medium">ENVIAR FORMULARIO</button>
			
			
			
				


			<div class="correo_enviado hide">
				<img src="../../assets/front/img/temp/enviadoicon.png" />
				<h2>Su mensaje ha sido enviado correctamente</h2>
				<a href="#" class="secondary button small">ENVIAR OTRO MENSAJE</a>
			</div>

			<div class="correo_noenviado hide">
				<img src="../../assets/front/img/temp/noenviadoicon.png" />
				<h2>Su mensaje ha sido enviado correctamente</h2>
				<a href="#" class="secondary button small">INTENTAR NUEVAMENTE</a>
			</div>

		</div>

	</div>

	<div class="four columns">

		<div class="radius_content_naranja height_contacto">
			<h2><?php echo lang('contacto.mapa_tit'); ?></h2>

		<figure>
		    <iframe style="padding-bottom: 20px; " width="425" height="550" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=Valencia,+Carabobo,+Venezuela&amp;aq=2&amp;oq=valen&amp;sll=37.0625,-95.677068&amp;sspn=51.488837,79.541016&amp;ie=UTF8&amp;hq=&amp;hnear=Valencia,+Municipio+Aut%C3%B3nomo+Valencia,+Carabobo,+Venezuela&amp;t=m&amp;z=12&amp;ll=10.174127,-67.999815&amp;output=embed"></iframe>
		</figure>

		<div style="clear:both;"></div>
			<p><?php echo lang('contacto.mapa_dir'); ?></p>
			<p><strong><?php echo lang('contacto.mapa_telft'); ?></strong> <br/> <?php echo lang('contacto.map_telf1'); ?> <br/> <?php echo lang('contacto.map_telf2'); ?> </p>
			<p><strong><?php echo lang('contacto.map_mailt'); ?></strong> <br/> <?php echo lang('contacto.map_mail1'); ?> <br/> <?php echo lang('contacto.map_mail2'); ?> </p>
			<a target="_blank" href="<?php echo lang('contacto.facebook'); ?>"><img src="http://cdn1.iconfinder.com/data/icons/yooicons_set01_socialbookmarks/32/social_facebook_box_white.png" /></a>
			<a target="_blank" href="<?php echo lang('contacto.twitter'); ?>"><img src="http://cdn1.iconfinder.com/data/icons/yooicons_set01_socialbookmarks/32/social_twitter_box_white.png" /></a>
			<!--<a target="_blank" href="#"><img src="http://cdn1.iconfinder.com/data/icons/yooicons_set01_socialbookmarks/32/social_linkedin_box_white.png" /></a>-->
		</div>

		</div>

</div>