<script>
	accounting.settings = {
		currency: {
			symbol: "Bs.F",
			format: "%v",
			decimal: ",",
			thousand: ".",
			precision: "2"
		},
		number: {
			precision : 0,  // default precision on numbers is 0
			thousand: ".",
			decimal : ","
		}
	}


	$(document).ready(function(){
		$('#fecha').change(function(){
			$('#fecha_evento').attr('value', $('#fecha_evento').text());
		});

		//$('#precio').inputmask("non-negative-decimal",{radixPoint: ",", digits: 2});

		$('#precio').change(function(){
			$('#precio').val(accounting.formatMoney($('#precio').val()));
		});

		<?php if(isset($tipo_pagos)): ?>
			<?php foreach($tipo_pagos as $pago): ?>
				$('label[for="<?php echo $pago->nombre_pago; ?>"] > span').click(function(){
					if($('label[for="<?php echo $pago->nombre_pago; ?>"] > span').hasClass('checked')){
						$('label[for="<?php echo $pago->nombre_pago; ?>"] > span').removeClass('checked');
					}
					else{
						$('label[for="<?php echo $pago->nombre_pago; ?>"] > span').addClass('checked');
					}
				});
			<?php endforeach; ?>
		<?endif; ?>

		$('#boton_subir').click(function(event){
			var control = document.getElementById("pdf_file");
			event.preventDefault();
			//if(typeof control.files[0] != 'undefined' && control.files[0].type == "application/pdf" ) {
				$('#subir_pdf').submit();
			/*}else{
				$('#archivoVacioModal').reveal();
			}*/
		});

		$('#boton_bajar').click(function(event){
			event.preventDefault();
			$('#eliminar_pdf').submit();
		});

		$('#boton_idioma').click(function(event){
			event.preventDefault();
			$('#form_idioma').submit();
		});

		$('#pdf_file').change(function(){
			$('.sin_archivos').remove();
			$('.archivos_evento tr.new').remove();
			$('.archivos_evento tbody').append('<tr class="new"><td><i class="foundicon-page" style="margin-right:5px;"></i>'+$(this).val()+'</td></tr>');
			var color = $('archivos_evento tr.new:last').css('background');
			$('.archivos_evento tr.new:last').animate({'background-color':'#A9D0F5'}, 500, function(){$(this).animate({'background-color':'#FFFFFF'}, 2000)});
		});
	});

	$(window).load(function(){
		$('#pdf_file').css({'width' : ($('span[name=pdf_upload]').innerWidth())+'px'});
	});

	$(window).resize(function(){
		$('#pdf_file').css('width', ($('span[name=pdf_upload]').width()) + 'px');
	});

	$(function(){
		$('#fecha').datepicker({
			dateFormat: "<?php echo lang('datapicker_formato_fecha');?>",
			dayNamesMin: ["<?php echo lang('datapicker_dia_domingo_abr');?>", "<?php echo lang('datapicker_dia_lunes_abr');?>", "<?php echo lang('datapicker_dia_martes_abr');?>", "<?php echo lang('datapicker_dia_miercoles_abr');?>",  "<?php echo lang('datapicker_dia_jueves_abr');?>", "<?php echo lang('datapicker_dia_viernes_abr');?>", "<?php echo lang('datapicker_dia_sabado_abr');?>"],
			monthNames: ["<?php echo lang('datapicker_mes_enero');?>","<?php echo lang('datapicker_mes_febrero');?>","<?php echo lang('datapicker_mes_marzo');?>","<?php echo lang('datapicker_mes_abril');?>","<?php echo lang('datapicker_mes_mayo');?>","<?php echo lang('datapicker_mes_junio');?>","<?php echo lang('datapicker_mes_julio');?>","<?php echo lang('datapicker_mes_agosto');?>","<?php echo lang('datapicker_mes_septiembre');?>","<?php echo lang('datapicker_mes_octubre');?>","<?php echo lang('datapicker_mes_noviembre');?>","<?php echo lang('datapicker_mes_diciembre');?>"]
		});
	});

	$('#hora').timepicker({
		currentText: "<?php echo lang('timepicker_hora_actual');?>",
		closeText: "<?php echo lang('timepicker_boton_cerrar');?>",
		timeOnlyTitle: "<?php echo lang('timepicker_titulo');?>",
		timeText: "<?php echo lang('timepicker_seleccion');?>",
		hourText: "<?php echo lang('timepicker_hora');?>",
		minuteText: "<?php echo lang('timepicker_minuto');?>"
	});

    $('#cerrarTipoArchivoInvalidoModal').click(function(e){
    	$('#tipoArchivoInvalidoModal').trigger('reveal:close');
    });

    $('#cerrarArchivoVacioModal').click(function(e){
    	$('#archivoVacioModal').trigger('reveal:close');
    });
</script>

<style>
span[name=pdf_upload] { text-align: center; border: 1px dashed #bbb; padding: 17px 0; display: block; font-weight: bold; }
</style>