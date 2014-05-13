<style>

	<?php if($tipo_pagos): ?>
		<?php foreach($tipo_pagos as $pago): ?>
			.<?php echo $pago->nombre_pago; ?>{
				width: 80px;
				height: 26px;
				background: #00B2BF;
				margin: 0px auto 10px auto;

				-webkit-border-radius: 50px;
				-moz-border-radius: 50px;
				border-radius: 50px;
				position: relative;

				-webkit-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
				-moz-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
				box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
			}

			.<?php echo $pago->nombre_pago; ?>:after{
				content: '<?php echo lang('resp_no'); ?>';
				font: 12px/26px Arial, sans-serif;
				color: #FFF;
				position: absolute;
				right: 10px;
				z-index: 0;
				font-weight: bold;
				text-shadow: 1px 1px 0px rgba(255,255,255,.15);
			}

			.<?php echo $pago->nombre_pago; ?>:before{
				content: '<?php echo lang('resp_si'); ?>';
				font: 12px/26px Arial, sans-serif;
				color: #FFF;
				position: absolute;
				left: 10px;
				z-index: 0;
				font-weight: bold;
			}

			.<?php echo $pago->nombre_pago; ?> div.etiqueta{
				display: block !important;
				width: 34px !important;
				height: 20px !important;

				-webkit-border-radius: 50px !important;
				-moz-border-radius: 50px !important;
				border-radius: 50px !important;

				-webkit-transition: all .4s ease !important;
				-moz-transition: all .4s ease !important;
				-o-transition: all .4s ease !important;
				-ms-transition: all .4s ease !important;
				transition: all .4s ease !important;
				cursor: pointer !important;
				position: absolute !important;
				top: 3px !important;
				left: 3px !important;
				z-index: 1 !important;

				-webkit-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3) !important;
				-moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3) !important;
				box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3) !important;
				background: #fcfff4 !important;

				background: -webkit-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%) !important;
				background: -moz-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%) !important;
				background: -o-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%) !important;
				background: -ms-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%) !important;
				background: linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%) !important;
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfff4', endColorstr='#b3bead',GradientType=0 ) !important;
			}

			.<?php echo $pago->nombre_pago; ?> input[type=checkbox]:checked + span + div {
				left: 43px !important;
			}

			.<?php echo $pago->nombre_pago; ?> input[type=checkbox] + span{
				display:none;
			}

		<?php endforeach; ?>
	<?php endif; ?>

</style>
