<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>Deco-Art</title>
        <meta name="description" content="" />
        <meta name="author" content="disenowintech" />

        <meta name="viewport" content="width=device-width; initial-scale=1.0" />

        <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="apple-touch-icon" href="/apple-touch-icon.png" />



    </head>

    <body style="font-family:Arial; font-size:12px;">

        <table width="100%">

            <tr>
            	<td colspan="3"><img style="width: 120px" src="<?php echo base_url(); ?>assets/front/img/template/asociaciones/fullscreen/congressus_1.png" /></td>
            	<td colspan="2"></td>
                <td colspan="3"><img src="<?php echo base_url(); ?>assets/front/img/temp/wtclogo.png" /><br /><br /><br /></td>
                <td colspan="2"><br /><br /></td>
            </tr>
			
            <!--<tr>
                <td colspan="2"><strong style="color:#0B2161;">Grupo GTM <br />RIF: J123245678-0</strong></td>
                <td><strong style="color:#0B2161;">PRESUPUESTO N</strong> <strong style="color:red;">V-1256</strong></td>
            </tr>-->
			<tr><td colspan="3"><br /></td></tr>
            <tr>
                <td colspan="3">
                	<h2 style="color:#0B2161;"><u><?php echo strtoupper(lang('evnt.planilla_tit')); ?></u></h2><br />
                </td>
            </tr>
            
            <tr>
                <td colspan="3"><br /></td>
            </tr>
<!-------------------------------- DATOS DEL EVENTO -------------------------------->
            <tr>
                <td colspan="3">
                	<h3 style="color:#0B2161; text-align: center;"><u><?php echo strtoupper(lang('evnt.planilla_info')); ?></u></h3>
                </td>
            </tr>

            <tr>
                <td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.planilla_nomb_evnt').': '; ?></strong> <?php echo ucfirst($detalle_evento->nombre); ?></td>
            </tr>
            <tr>
                <td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.planilla_fecha').': '; ?></strong> <?php echo $detalle_evento->fecha_eventof; ?></td>
            </tr>
            <tr>
                <td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.planilla_duracion').': '; ?></strong> <?php echo $detalle_evento->dias.' días'; ?></td>
            </tr>
            <tr>
                <td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.planilla_inversion').': '; ?></strong> <?php echo $detalle_evento->precio_evento; ?></td>
            </tr>
<!-------------------------------- /DATOS DEL EVENTO -------------------------------->

<!-------------------------------- DATOS DE CONTACTO -------------------------------->
            <tr>
                <td colspan="3"><br /></td>
            </tr>
            <tr>
                <td colspan="3">
                	<h3 style="color:#0B2161;"><u><?php echo strtoupper(lang('evnt.planilla_contact')); ?></u></h3>
                </td>
            </tr>
            <tr>
                <td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.planilla_ced').': '; ?></strong> <?php echo $nacionalidad.' - '.$cedula; ?></td>
            </tr>
            <tr>
                <td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.insc_rif_pers').': '; ?></strong> <?php echo $rif; ?></td>
            </tr>
            <tr>
                <td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.planilla_nombre').' ó '.lang('evnt.insc_razon_soc').': '; ?></strong> <?php echo ucwords($nombre1.' '.$nombre2.' '.$apellido1.' '.$apellido2); ?></td>
            </tr>
            <tr>
                <td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.planilla_email').': '; ?></strong> <?php echo $email; ?></td>
            </tr>
            <tr>
                <td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.planilla_tlfn').': '; ?></strong> <?php echo $tlfn; ?></td>
            </tr>
            <tr>
                <td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.direccion').': '; ?></strong> <?php echo $dir_fiscal; ?></td>
            </tr>
            <tr>
                <td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.planilla_hosp').': '; ?></strong> <?php echo $contacto_asiste; ?></td>
            </tr>
            <tr><td colspan="3"><br /></td></tr>
        </table>
<!-------------------------------- /DATOS DE CONTACTO -------------------------------->

<!-------------------------------- DATOS DE LOS ASISTENTES AL EVENTO -------------------------------->
		<table width="100%" style="margin-top: 20px;">
			<tr>
                <td colspan="3">
                	<h3 style="color:#0B2161;"><u><?php echo strtoupper(lang('evnt.planilla_asistent')); ?></u></h3>
                </td>
            </tr>
            <!--<tr><td colspan="3"><br /></td></tr>-->
            <?php $x = 1 ; ?>
			<?php foreach($users as $user ) : ?>
				<?php if($x%2!=0) : ?>
					<tr>
				<?php endif;  ?>
						<td>
							<table>
					            <tr>
					                <td colspan="3"><strong style="color:#0B2161;"><u><?php echo lang('evnt.planilla_asist_num').' '.$x; ?></u></strong></td>
					            </tr>
					            <tr>
					                <td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.planilla_ced').': '; ?></strong> <?php echo $user['cedula']; ?></td>
					            </tr>
					            <tr>
					                <td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.planilla_nombre').': '; ?></strong> <?php echo $user['nombre1'].' '.$user['nombre2'].' '.$user['apellido1'].' '.$user['apellido2']; ?></td>
					            </tr>
					            <tr>
					                <td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.planilla_tlfn').': '; ?></strong> <?php echo $user['tlfn']; ?></td>
					            </tr>
					            <tr>
					                <td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.insc_email').': '; ?></strong> <?php echo $user['email']; ?></td>
					            </tr>
					            <tr>
					                <td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.planilla_hosp').': '; ?></strong> <?php echo $user['hospedaje']; ?></td>
					            </tr>
							</table>
						</td>
				<?php if($x%2!=0) : ?>
					</tr>
				<?php endif;  ?>
				<?php $x++ ; ?>
			<?php endforeach;  ?>
			<tr><td colspan="3"><br /></td></tr>
		</table>
<!-------------------------------- /DATOS DE LOS ASISTENTES AL EVENTO -------------------------------->

<!-------------------------------- DATOS BANCARIOS -------------------------------->
	<table width="100%" style="margin-top: 20px;">
		<tr><td colspan="3"><h3 style="color:#0B2161;"><u><?php echo strtoupper(lang('evnt.insc_inf_bancaria')); ?></u></h3></td></tr>
		<tr><td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.insc_dirigido'); ?></strong> <?php echo lang('evnt.insc_a_nombre_de'); ?></td></tr>
		<tr><td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.insc_rif').': '; ?></strong> <?php echo lang('evnt.insc_rif_cc'); ?></td></tr>
		<tr><td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.insc_banco'); ?></strong> <?php echo lang('evnt.insc_banesco'); ?></td></tr>
		<tr><td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.insc_numero_cta'); ?></strong> <?php echo lang('evnt.insc_cuenta_num'); ?></td></tr>
		<tr><td colspan="3"><strong style="color:#0B2161;"><?php echo lang('evnt.forma_pago'); ?></strong> (<small><?php echo lang('evnt.add_comprobante'); ?></small>)</td></tr>
		<tr><td><input type="checkbox" /> <?php echo lang('evnt.tipo_pago_1'); ?> </td></tr>
		<tr><td><input type="checkbox" /> <?php echo lang('evnt.tipo_pago_2'); ?> </td></tr>
		<tr><td><input type="checkbox" /> <?php echo lang('evnt.tipo_pago_3'); ?> </td></tr>
		<tr><td></td></tr>
	</table>
<!-------------------------------- /DATOS BANCARIOS -------------------------------->

<!-------------------------------- FOOTER -------------------------------->
	<footer>
		<small>
			<br /><h4 style="color:#0B2161;font-size: 10px;"><u><?php echo strtoupper(lang('evnt.insc_condicion_TIT')); ?></u></h4>
			<ul>
				<li style="font-size: 10px;"><?php echo lang('evnt.insc_condicion_1'); ?></li>
				<li style="font-size: 10px;"><?php echo lang('evnt.insc_condicion_2'); ?></li>
				<li style="font-size: 10px;"><?php echo lang('evnt.insc_condicion_3'); ?></li>
			</ul>
		</small>
	</footer><br /><br />
	<table width="100%" style="margin-top: 20px;">
		<tr><td colspan="3"></td></tr>
		<tr><td colspan="3"><center><span style="color:#000;font-size: 11px;font-weight: bold"><?php echo lang('evnt.firma'); ?></span></center></td></tr>
		<tr><td colspan="3"></td></tr>
	</table><br /><br />
	<table width="100%" style="margin-top: 20px;">
		<tr><td colspan="3"></td></tr>
		<tr><td colspan="3"><center><span style="color:#0B2161;font-size: 9px"><?php echo lang('evnt.footer_dir'); ?></span></center></td></tr>
		<tr><td colspan="3"></td></tr>
	</table>
<!-------------------------------- /FOOTER -------------------------------->
    </body>
</html>