<div id="g1-precontent">
    <div class="g1-background">
    </div>
    <header class="entry-header g1-layout-inner">
          <div class="g1-hgroup">
            <h1 class="entry-title"><?php echo lang('front.show_reserva.titulo'); ?></h1>
          </div>
      </header>
</div>



<div id="g1-content">
    <div class="g1-layout-inner">


        <nav class="g1-nav-breadcrumbs g1-meta">
               <p class="assistive-text"><?php echo lang('front.direccion.reserva.breadcrumb1'); ?> </p>
               <ol>
                   <li class="g1-nav-breadcrumbs__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                       <a itemprop="url" href="/"><span itemprop="title"><?php echo lang('front.direccion.reserva.breadcrumb2'); ?></span></a>
                   </li>
                   <li class="g1-nav-breadcrumbs__item">
                       <a href="usuarios/reservas-usuario">
                           <?php echo lang('front.direccion.reserva.breadcrumb3'); ?>
                       </a>
                   </li>
                   <li class="g1-nav-breadcrumbs__item"><?php echo $codigo_reserva; ?></li>
               </ol>
           </nav>

        <h2 style="text-align: center;"><?php echo lang('front.pdf.correo_titulo1'); ?></h2>
        <div id="g1-table-1" class="g1-table g1-table--solid " style="font-size: 12px;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 25%;"><b><?php echo lang('front.pdf.titular_reserva'); ?></b></td>
                    <td style="width: 25%;"><?php echo $titular_reserva; ?></td>
                    <td style="width: 25%;"><b><?php echo lang('front.pdf.codigo_reserva'); ?></b></td>
                    <td style="width: 25%;"><?php echo $codigo_reserva; ?></td>
                </tr>

                <tr>
                    <td style="width: 25%;"><b><?php echo lang('front.pdf.email'); ?></b></td>
                    <td style="width: 25%;"><?php echo $email; ?></td>
                    <td style="width: 25%;"><b><?php echo lang('front.pdf.checkin'); ?></b></td>
                    <td style="width: 25%;"><?php echo $checkin; ?></td>
                </tr>

                <tr>
                    <td style="width: 25%;"><b><?php echo lang('front.pdf.telefono'); ?></b></td>
                    <td style="width: 25%;"><?php echo $telefono; ?></td>
                    <td style="width: 25%;"><b><?php echo lang('front.pdf.checkout'); ?></b></td>
                    <td style="width: 25%;"><?php echo $checkout; ?></td>
                </tr>

                <tr>
                    <td style="width: 25%;"><b><?php echo lang('front.pdf.pais'); ?></b></td>
                    <td style="width: 25%;"><?php echo $pais; ?></td>
                    <td style="width: 25%;"><b><?php echo lang('front.pdf.noches'); ?></b></td>
                    <td style="width: 25%;"><?php echo $noches; ?></td>
                </tr>

                <tr>
                    <td style="width: 25%;"><b><?php echo lang('front.pdf.nacionalidad'); ?></b></td>
                    <td style="width: 25%;"><?php echo $nacionalidad; ?></td>
                    <td style="width: 25%;"><b><?php echo lang('front.pdf.habitaciones'); ?></b></td>
                    <td style="width: 25%;"><?php echo $numero_habitaciones; ?></td>
                </tr>

                <tr>
                    <td style="width: 25%;"><b><?php echo lang('front.pdf.direccion'); ?></b></td>
                    <td style="width: 25%;"><?php echo $direccion; ?></td>
                    <td style="width: 25%;"><b><?php echo lang('front.pdf.personas'); ?></b></td>
                    <td style="width: 25%;"><?php echo $personas; ?></td>
                </tr>

                <tr>
                    <td style="width: 25%;"><b>Precio:</b></td>
                    <td style="width: 25%;"><?php echo $precio_total; ?></td>
                    <td style="width: 25%;"><b><?php echo lang('front.pdf.forma_pago'); ?></b></td>
                    <td style="width: 25%;"><?php echo $tipo_forma_pago; ?></td>
                </tr>
            </table>
        </div>

        <hr />





        <div id="g1-table-1" class="g1-table g1-table--solid " style="font-size: 12px;">
            <table style="width: 100%;" style="text-align: center;">
                <thead>
                    <tr>
                        <th style="width: 5%;"><?php echo lang('front.pdf.item'); ?></th>
                        <th style="width: 15%;"><?php echo lang('front.pdf.titular'); ?></th>
                        <th style="width: 20%;"><?php echo lang('front.pdf.habitacion'); ?></th>
                        <th style="width: 20%;"><?php echo lang('front.pdf.descripcion'); ?></th>
                        <th style="width: 20%;"><?php echo lang('front.pdf.precio'); ?></th>
                        <th style="width: 20%;"><?php echo lang('front.pdf.peticion'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i=0;$i<count($habitaciones);++$i): ?>
                        <tr>
                            <td><?php echo $i+1; ?></td>
                            <td><?php echo $habitaciones[$i]['nombre_titular']; ?></td>
                            <td><?php echo $habitaciones[$i]['tipo']; ?></td>
                            <td><?php echo $habitaciones[$i]['tipo_descrip']; ?></td>
                            <td><?php echo $habitaciones[$i]['moneda_abreviado']." ".$habitaciones[$i]['valor']; ?></td>
                            <?php if($habitaciones[$i]['peticion']): ?>
                                <td><?php echo $habitaciones[$i]['peticion']; ?></td>
                            <?php else: ?>
                                <td>Ninguna.</td>
                            <?php endif;?>
                        </tr>
                    <?php endfor; ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><h3><?php echo lang('front.pdf.total'); ?></h3></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><h3><?php echo $denominacion." ".$precio_total; ?></h3></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <script src="assets/front/js/jquery/jquery.min.js"></script>
        <script src="assets/front/js/jquery/jquery-1.10.2.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                var url = "reserva/reserva_front/iniciar_sesion";

                $('#g1-button-20').click(function(){
                    if($('#panel_pago').is(':hidden'))
                    {
                        $('#panel_pago').slideDown( "slow" );
                        $('#mensaje_pago').slideUp( "slow" );
                        $('#mensaje_error').slideUp( "slow" );
                    }
                    else
                    {
                        $('#panel_pago').slideUp("slow");
                    }
                });

                $('#pagar').click(function(){
                    if($('#datepicker3').val()!='' && $('#referencia').val()!='' && $('#monto').val()!='')
                    {
                        var url = "reserva/reserva_front/ajax_agregar_pago";
                        $.ajax({
                            url:    url,
                            type:     'POST',
                            dataType: 'json',
                            data:     $('#formulario_pago').serialize(),
                            success: function(msj)
                            {
                                if(msj.mensaje == "correcto")
                                {
                                    $('#mensaje_pago').find('#mensaje').html("Pago agregado correctamente.");
                                    $('#mensaje_pago').slideDown( "slow" );
                                    $('#panel_pago').slideUp("slow");

                                    $('#panel_pago').find(':input').each(function(){
                                        this.value="";
                                    });
                                    $("input[name='id_reservacion']").val(msj.id_reservacion);
                                }
                                else
                                {
                                    $('#mensaje_error').find('#mensaje').html("Ha ocurrido un error y el pago no se ha podido realizar correctamente. Intente de nuevo o contactenos.");
                                    $('#mensaje_error').slideDown( "slow" );
                                    $('#panel_pago').slideUp("slow");
                                    $("input[name='id_reservacion']").val(msj.id_reservacion);
                                }
                            }
                        });


                    }
                    else
                    {
                        alert("Algun campo se encuentra vacio. aqui");
                    }
                });

                $( document ).ajaxStart(function() {
                    $( "#cargador" ).show();
                    $("#pagar").attr("disabled", "disabled");
                    $('#pagar').css( "background", "none repeat scroll 0% 0% rgb(153, 153, 153)" );
                    $("#g1-button-20").attr("disabled", "disabled");
                    $('#g1-button-20').css( "border-color", "rgb(153, 153, 153)" );
                    $('#g1-button-20').css( "background-color", "rgb(153, 153, 153)" );

                });

                $( document ).ajaxStop(function() {
                    $( "#cargador" ).hide();
                    $("#pagar").removeAttr("disabled");
                    $('#pagar').css( "background", "none repeat scroll 0% 0% rgb(31, 180, 218)" );
                    $("#g1-button-20").removeAttr("disabled");
                    $('#g1-button-20').css( "border-color", "rgb(251, 68, 0)" );
                    $('#g1-button-20').css( "background-color", "rgb(251, 68, 0)" );
                });
            });
        </script>

        <div id="mensaje_pago" class="g1-message g1-message--success " style="display: none;">
            <div id="mensaje" class="g1-inner">
                Error Desconocido 1
            </div>
        </div>

        <div id="mensaje_error" class="g1-message g1-message--error " style="display: none;">
            <div id="mensaje" class="g1-inner">
                 Error Desconocido 2
            </div>
        </div>


        <div id="panel_pago" class="g1-table" style="display: none;">
            <h2>Agregar un pago</h2>
            <form id="formulario_pago" action="reserva/reserva_front/agregar_pago" method="post">
                <input type="hidden" name="id_reservacion" value="<?php echo $id_reservacion; ?>" />
                <table>
                    <thead>
                        <th>Agregar un pago</th>
                    </thead>
                    <tbody>
                        <tr>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            <label>Fecha de pago</label>
                                            <input id="datepicker3" type="text" value="" readonly="readonly" name="fecha_pago" style="height: 40px;"/>
                                            <small id="pago_fecha" class="error" style="display:none;">Campo requerido</small>
                                        </td>
                                        <td>
                                            <label>Tipo de pago</label>
                                            <select name="id_tipo_forma_pago">
                                                <option value="6">Depósito</option>
                                                <option value="4">Transferencia</option>
                                            </select>
                                        </td>
                                        <td>
                                            <label>Numero de referencia</label>
                                            <input id="referencia" type="number" name="numero_referencia" style="height: 40px;"/>
                                            <small id="pago_referencia" class="error" style="display:none;">Campo requerido</small>
                                        </td>
                                        <td>
                                            <label>Tipo moneda</label>
                                            <select name="tipo_moneda">
                                                <option value="1">BsF</option>
                                                <option value="2">$</option>
                                                <option value="3">€</option>
                                            </select>
                                        </td>
                                        <td>
                                            <label>Monto a Cancelar</label>
                                            <input id="monto" type="text" name="monto" style="height: 40px;"/>
                                            <small id="pago_monto" class="error" style="display:none;">Campo requerido</small>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </tr>
                        <tr>
                            <a id="pagar" class="g1-button g1-button--medium g1-button--solid g1-button--standard">Pagar</a>
                        </tr>
                    </tbody>
                </table>
            </form>
            <div id="cargador"></div>
        </div>
    </div>

    </div>



    <div class="form-row">
        <center>
            <?php if($id_estado_reservacion==2): ?>
                <a id="g1-button-20" class="g1-button g1-button--medium g1-button--solid g1-button--standard"><i class="icon-plus"></i> Agregar pago</a>
            <?php endif; ?>
            <?php if($id_estado_reservacion == 2 || $id_estado_reservacion == 3 ): ?>
                <a id="g1-button-23" class="g1-button g1-button--medium g1-button--solid g1-button--standard" href="<?php echo lang('front.modificar-reserva_url').'/'.$codigo_reserva; ?>" style="color: #ffffff;"><i class="icon-pencil"></i> Modificar o Cancelar reservación</a>
            <?php endif; ?>
            <a id="g1-button-24" class="g1-button g1-button--medium g1-button--solid g1-button--standard" href="<?php echo lang("front.reserva_url").'/reserva_front/download_reserva/'.$codigo_reserva; ?>"><i class="icon-download-alt"></i> Descargar</a>
        </center>
    </div>
</div>