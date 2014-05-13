<div id="g1-precontent">
    <div class="g1-background">
    </div>
    <header class="entry-header g1-layout-inner">
          <div class="g1-hgroup">
            <h1 class="entry-title hide-for-small"><?php echo lang('front.reservar.titulo'); ?></h1>
            <h1 class="entry-title show-for-small" style="font-size: 26px;"><?php echo lang('front.reservar.titulo'); ?></h1>
          </div>
      </header>
</div>



<div id="g1-content">
    <div class="g1-layout-inner">

        <nav class="g1-nav-breadcrumbs g1-meta">
               <p class="assistive-text"><?php echo lang('front.reservar.breadcrumb1'); ?> </p>
               <ol>
                   <li class="g1-nav-breadcrumbs__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                       <a itemprop="url" href="/"><span itemprop="title"><?php echo lang('front.reservar.breadcrumb2'); ?></span></a>
                   </li>
                   <li class="g1-nav-breadcrumbs__item">
                       <a>
                           <?php echo lang('front.reservar.breadcrumb3'); ?>
                       </a>
                   </li>
               </ol>
           </nav>

        <div id="content" role="main">
            <article id="post-182" class="post-182 page type-page status-publish g1-complete instock">
                   <div id="fechas_reservacion">
                       <form id="form_disponibilidad">
                           <div class="row">
                               <div class="large-12 columns">
                                   <div class="large-4 columns">
                                       <label><?php echo lang('front.reservar.label1'); ?></label>
                                       <input id="datepicker1" name="fecha_llegada" type="text" readonly="readonly" value="<?php if(isset($fecha_llegada)) echo $fecha_llegada; ?>"/>
                                   </div>
                                   <div class="large-4 columns">
                                       <label><?php echo lang('front.reservar.label2'); ?></label>
                                       <input id="datepicker2" name="fecha_salida" type="text" readonly="readonly" value="<?php if(isset($fecha_salida)) echo $fecha_salida; ?>" />
                                   </div>
                                   <div class="large-4 columns">
                                       <a id="g1-button-23" class="g1-button g1-button--medium g1-button--solid g1-button--standard" style="margin-top: 19px; width:100%;">Ver disponibilidad</a>
                                       <a id="g1-button-27" class="g1-button g1-button--medium g1-button--solid g1-button--standard" style="display:none;">Ver disponibilidad</a>
                                   </div>
                               </div>
                           </div>
                    </form>
                   </div>

                   <script src="assets/front/js/jquery/jquery.min.js"></script>
                <script src="assets/front/js/jquery/jquery-1.10.2.js"></script>
                <script type="text/javascript">

                    $(document).ready(function(){

                        if($("input[name='fecha_llegada']").val()!="" && $("input[name='fecha_salida']").val()!="")
                        {
                            $('#mensaje_disponibilidad').slideUp("slow");
                            $('#mensaje2').slideUp("slow");
                            $('#tabla_disponibilidad').slideUp("slow");
                            $('#boton_disponibilidad').slideUp("slow");
                            $('#tabla_disponibilidad').empty();
                            $('#tabla_disponibilidad_responsive').empty();
                            var url = "reserva/reserva_front/ajax_disponibilidad";
                            $.ajax({
                                url:    url,
                                type:     'POST',
                                dataType: 'json',
                                data:     $('#form_disponibilidad').serialize(),
                                success: function(msj)
                                {
                                	//alert(msj.mensaje); alert(msj.vacio);
                                	
                                    if(msj.mensaje=="bien" && msj.vacio==false)
                                    {
                                        $('#form_disponibilidad_habitaciones').find(':input[name="fecha_llegada"]').val($('#form_disponibilidad').find(':input[name="fecha_llegada"]').val());
                                        $('#form_disponibilidad_habitaciones').find(':input[name="fecha_salida"]').val($('#form_disponibilidad').find(':input[name="fecha_salida"]').val());
                                        $('#form_disponibilidad_habitaciones').find(':input[name="noches"]').val(msj.noches);
                                        $('#form_disponibilidad_habitaciones').find(':input[name="temporada"]').val(msj.temporada);
                                        $('#mensaje_disponibilidad').find('#mensaje').html('Disponibilidad de habitaciones para <b> ' + msj.noches + ' </b> noches.');
                                        $('#mensaje_disponibilidad').slideDown("slow");
                                        var contenido = '<div>' +
                                                        '<table>'+
                                                            '<thead>'+
                                                                '<th  >'+'Tipo habitación'+'</th>'+
                                                                '<th  data-hide="phone">'+'Condiciones'+'</th>'+
                                                                '<th  data-hide="phone">'+'Max'+'</th>'+
                                                                '<th  data-hide="phone">'+'Precio por noche'+'</th>'+
                                                                '<th  data-hide="phone">'+'Nº de habitaciones'+'</th>'+
                                                            '</thead>'+
                                                            '<tbody>';

                                        var data = msj.hab_disponibles;
                                        var noches = msj.noches;
                                        var contenido_responsive = "";

                                        jQuery.each( data, function( i, val ) {
                                            if(val.habitaciones>0)
                                            {
                                                contenido+= '<tr>'+
                                                        '<td style="width: 260px;">'+
                                                            '<h5>' + val.tipo + '</h5>' +
                                                            '<img src="assets/front/img/template/reservas/habitaciones/habitacion-classic.jpg" style="width: 260px;"/>'+
                                                            '<p>' + val.tipo_descrip + '</p>'+
                                                        '</td>'+
                                                        '<td style="width: 260px;">'+
                                                            '<ul style="font-size: 12px; text-decoration: bold;">'+
                                                                'La reserva debe ser confirmada en las proximas 48 horas.'+
                                                            '</ul>'+
                                                        '</td>'+
                                                        '<td style="width: 260px;">';

                                                for(j=0;j<val.personas;++j)
                                                {
                                                    contenido+='<i class="icon-user"></i>';
                                                }

                                                contenido+=     '</td>'+
                                                        '<td style="width: 260px;">'+
                                                            '<center>'+
                                                                '<h5>'+
                                                                    val.moneda_abreviado + ' ' + val.valor +
                                                                    '<br />' +
                                                                 '</h5>'+
                                                            '</center>'+
                                                        '</td>'+
                                                        '<td style="width: 260px;">'+
                                                            '<select class="num_habitaciones" name="tip_hab[' + val.id_tipo_habitacion + ']">' +
                                                                '<option value="0">0</option>';

                                                for(j=1;j<=val.habitaciones;++j)
                                                {
                                                    contenido+= '<option value="' + j + '">' + j + ' (' + val.moneda_abreviado +' '+ j*val.valor*noches + ')</option>';
                                                }

                                                contenido+=         '</select>'+
                                                                    '<p>'+
                                                                        '<?php echo lang('front.reserva.habitaciones.calculo'); ?>'+
                                                                    '</p>'+
                                                        '</td>'+
                                                    '</tr>';

                                                //CONSTRUYENDO LA VISTA RESPONSIVE
                                                contenido_responsive +=
                                                    '<div class="habitacion_responsive">' +
                                                        '<div id="mensaje_disponibilidad" class="g1-message g1-message--success habitacion_responsive_cabecera">'+
                                                            '<div id="mensaje" class="g1-inner" style="text-transform: uppercase;">'+
                                                                val.tipo +
                                                            '</div>'+
                                                        '</div>'+
                                                        '<div class="row">' +
                                                            '<div class="large-12 columns">' +
                                                                '<div class="large-4 columns">' +
                                                                    '<figure>' +
                                                                        '<figcaption>' +
                                                                            '<h5>Tipo de habitación: '+ val.tipo + '</h5>' +
                                                                        '</figcaption>' +
                                                                        '<img src="assets/front/img/template/reservas/habitaciones/habitacion-classic.jpg" alt="Imagen habitacion"/>' +
                                                                    '</figure>' +
                                                                '</div>' +
                                                                '<div class="large-8 columns">' +
                                                                    '<div class="datos_descripcion">' +
                                                                           '<i class="icon-minus-sign"></i><strong> Descripcion</strong>' +
                                                                           '<div class="descripcion">' +
                                                                               '<p>' + val.tipo_descrip + '</p>' +
                                                                           '</div>' +
                                                                       '</div>' +
                                                                    '<div class="datos_condiciones">' +
                                                                           '<i class="icon-minus-sign"></i><strong> Condiciones</strong>' +
                                                                           '<div class="condiciones">' +
                                                                               '<ul>' +
                                                                                '<li>La reserva debe ser confirmada en las proximas 48 horas.</li>' +
                                                                            '</ul>' +
                                                                           '</div>' +
                                                                       '</div>' +
                                                                    '<p>' +
                                                                        '<strong>Personas Max.</strong> ';
                                                                        for(j=0;j<val.personas;++j)
                                                                        {
                                                                            contenido_responsive+='<i class="icon-user"></i> ';
                                                                        }

                                                    contenido_responsive+='<br />' +
                                                                        '<strong>Precio (por noche) </strong>' + val.moneda_abreviado + ' ' + val.valor +
                                                                    '</p>'+
                                                                    '<select class="num_habitaciones" name="tip_hab[' + val.id_tipo_habitacion + ']">' +
                                                                        '<option value="0">0</option>';
                                                                        for(j=1;j<=val.habitaciones;++j)
                                                                        {
                                                                            contenido_responsive+= '<option value="' + j + '">' + j + ' (' + val.moneda_abreviado +' '+ j*val.valor*noches + ')</option>';
                                                                        }

                                                                        contenido_responsive+=     '</select>'+
                                                                    '<p style="text-align:center;">'+'<?php echo lang('front.reserva.habitaciones.calculo'); ?>'+'</p>' +
                                                                '</div>' +
                                                            '</div>' +
                                                        '</div>' +
                                                    '</div>';

                                            }

                                        });

                                        contenido+= '</tbody>'+
                                                '</table>'+
                                            '</div>';

                                        $('#tabla_disponibilidad').append
                                        (
                                            contenido
                                        );

                                        $('#tabla_disponibilidad_responsive').append
                                        (
                                            contenido_responsive
                                        );
                                    }
                                    else
                                    {
                                        $('#mensaje2').find('#mensaje').html(msj.error);
                                        $('#mensaje2').slideDown( "slow" );
                                    }

                                    if($('#tabla_disponibilidad').is(':empty'))
                                    {
                                        $('#mensaje').html("Lo sentimos, no hay disponibilidad para la fecha indicada.");
                                        //$('#mensaje').slideDown( "slow" );
                                    }
                                    else
                                    {
                                        $('#boton_disponibilidad').slideDown( "slow" );
                                    }
                                }
                            });
                        }


                        $('#g1-button-23').click(function(){

                            if($("input[name='fecha_llegada']").val()!="" && $("input[name='fecha_salida']").val()!="")
                            {
                                $('#mensaje_disponibilidad').slideUp("slow");
                                $('#mensaje2').slideUp("slow");
                                //$('#tabla_disponibilidad').slideUp("slow");
                                $('#boton_disponibilidad').slideUp("slow");
                                $('#tabla_disponibilidad').empty();
                                $('#tabla_disponibilidad_responsive').empty();
                                var url = "reserva/reserva_front/ajax_disponibilidad";
                                $.ajax({
                                    url:    url,
                                    type:     'POST',
                                    dataType: 'json',
                                    data:     $('#form_disponibilidad').serialize(),
                                    success: function(msj)
                                    {
                                        if(msj.mensaje=="bien" && msj.vacio==false)
                                        {
                                            $('#form_disponibilidad_habitaciones').find(':input[name="fecha_llegada"]').val($('#form_disponibilidad').find(':input[name="fecha_llegada"]').val());
                                            $('#form_disponibilidad_habitaciones').find(':input[name="fecha_salida"]').val($('#form_disponibilidad').find(':input[name="fecha_salida"]').val());
                                            $('#form_disponibilidad_habitaciones').find(':input[name="noches"]').val(msj.noches);
                                            $('#form_disponibilidad_habitaciones').find(':input[name="temporada"]').val(msj.temporada);
                                            $('#mensaje_disponibilidad').find('#mensaje').html('Disponibilidad de habitaciones para <b> ' + msj.noches + ' </b> noches.');
                                            $('#mensaje_disponibilidad').slideDown("slow");
                                                var contenido = '<div>' +
                                                        '<table>'+
                                                            '<thead>'+
                                                                '<th  >'+'Tipo habitación'+'</th>'+
                                                                '<th  data-hide="phone">'+'Condiciones'+'</th>'+
                                                                '<th  data-hide="phone">'+'Max'+'</th>'+
                                                                '<th  data-hide="phone">'+'Precio por noche'+'</th>'+
                                                                '<th  data-hide="phone">'+'Nº de habitaciones'+'</th>'+
                                                            '</thead>'+
                                                            '<tbody>';

                                            var data = msj.hab_disponibles;
                                            var noches = msj.noches;
                                            var contenido_responsive = "";

                                            jQuery.each( data, function( i, val ) {
                                                if(val.habitaciones>0)
                                                {
                                                    //CONSTRUYENDO LA VISTA RESPONSIVE
                                                    contenido_responsive +=
                                                    '<div class="habitacion_responsive">' +
                                                        '<div id="mensaje_disponibilidad" class="g1-message g1-message--success habitacion_responsive_cabecera">'+
                                                            '<div id="mensaje" class="g1-inner" style="text-transform: uppercase;">'+
                                                                val.tipo +
                                                            '</div>'+
                                                        '</div>'+
                                                        '<div class="row">' +
                                                            '<div class="large-12 columns">' +
                                                                '<div class="large-4 columns">' +
                                                                    '<figure>' +
                                                                        '<img src="assets/front/img/template/reservas/habitaciones/habitacion-classic.jpg" alt="Imagen habitacion"/>' +
                                                                    '</figure>' +
                                                                '</div>' +
                                                                '<div class="large-8 columns">' +
                                                                    '<div class="datos_descripcion">' +
                                                                           '<i class="icon-minus-sign"></i><strong> Descripcion</strong>' +
                                                                           '<div class="descripcion">' +
                                                                               '<p>' + val.tipo_descrip + '</p>' +
                                                                           '</div>' +
                                                                       '</div>' +
                                                                    '<div class="datos_condiciones">' +
                                                                           '<i class="icon-minus-sign"></i><strong> Condiciones</strong>' +
                                                                           '<div class="condiciones">' +
                                                                               '<ul>' +
                                                                                '<li>La reserva debe ser confirmada en las proximas 48 horas.</li>' +
                                                                            '</ul>' +
                                                                           '</div>' +
                                                                       '</div>' +
                                                                    '<p>' +
                                                                        '<strong>Personas Max.</strong> ';
                                                                        for(j=0;j<val.personas;++j)
                                                                        {
                                                                            contenido_responsive+='<i class="icon-user"></i> ';
                                                                        }

                                                    contenido_responsive+='<br />' +
                                                                        '<strong>Precio (por noche) </strong>' + val.moneda_abreviado + ' ' + val.valor +
                                                                    '</p>'+
                                                                    '<select class="num_habitaciones" name="tip_hab[' + val.id_tipo_habitacion + ']">' +
                                                                        '<option value="0">0</option>';
                                                                        for(j=1;j<=val.habitaciones;++j)
                                                                        {
                                                                            contenido_responsive+= '<option value="' + j + '">' + j + ' (' + val.moneda_abreviado +' '+ j*val.valor*noches + ')</option>';
                                                                        }

                                                                        contenido_responsive+=     '</select>'+
                                                                    '<p style="text-align:center;">'+'<?php echo lang('front.reserva.habitaciones.calculo'); ?>'+'</p>' +
                                                                '</div>' +
                                                            '</div>' +
                                                        '</div>' +
                                                    '</div>';

                                                }

                                            });

                                            $('#tabla_disponibilidad_responsive').append
                                            (
                                                contenido_responsive
                                            );

                                        }
                                        else
                                        {
                                            $('#mensaje2').find('#mensaje').html(msj.error);
                                            $('#mensaje2').slideDown( "slow" );
                                        }

                                        if($('#tabla_disponibilidad').is(':empty'))
                                        {
                                            $('#mensaje').html("Lo sentimos, no hay disponibilidad para la fecha indicada.");
                                            $('#mensaje').slideDown( "slow" );
                                        }
                                        else
                                        {
                                            $('#boton_disponibilidad').slideDown( "slow" );
                                        }
                                    }
                                });
                            }
                            else
                            {
                                if($("input[name='fecha_llegada']").val()=="" && $("input[name='fecha_salida']").val()=="")
                                {
                                    $('#mensaje_disponibilidad').find('#mensaje').html("Los campos <b>Fecha de llegada</b> y <b>Fecha de salida</b> no pueden estar vacios.");
                                    $('#mensaje_disponibilidad').slideDown( "slow" );
                                }
                                else
                                {
                                    if($("input[name='fecha_llegada']").val()=="" && $("input[name='fecha_salida']").val()!="")
                                    {
                                        $('#mensaje_disponibilidad').find('#mensaje').html("Campo de <b>Fecha de llegada</b> vacio.");
                                        $('#mensaje_disponibilidad').slideDown( "slow" );
                                    }
                                    else
                                    {
                                        $('#mensaje_disponibilidad').find('#mensaje').html("Campo <b>Fecha de salida</b>.");
                                        $('#mensaje_disponibilidad').slideDown( "slow" );
                                    }
                                }
                            }
                        });

                        $('#g1-button-24').click(function(){

                            var band = false;

                            $('.num_habitaciones').each(function(){
                                   if($(this).val()!="0")
                                       band = true;
                            });

                            if(band)
                            {
                                $('#submit').click();

                            }
                            else
                            {
                                alert("Debe seleccionar una habitación para continaur con la reserva.");
                            }
                        });

                        $( document ).ajaxStart(function() {
                            $( "#cargador" ).show();
                            $("#pagar").attr("disabled", "disabled");
                            $('#pagar').css( "background", "none repeat scroll 0% 0% rgb(153, 153, 153)" );
                            $("#g1-button-23").attr("disabled", "disabled");
                            $('#g1-button-23').css( "border-color", "rgb(153, 153, 153)" );
                            $('#g1-button-23').css( "background-color", "rgb(153, 153, 153)" );

                        });

                        $( document ).ajaxStop(function() {
                            $("#cargador").hide();
                            $("#pagar").removeAttr("disabled");
                            $('#pagar').css( "background", "none repeat scroll 0% 0% rgb(31, 180, 218)" );
                            $("#g1-button-23").removeAttr("disabled");
                            $('#g1-button-23').css( "border-color", "rgb(52, 152, 219)" );
                            $('#g1-button-23').css( "background-color", "rgb(52, 152, 219)" );
                        });

                        $('.datos_descripcion').click(function(){
                            if($(this).find('.descripcion').is(':hidden'))
                            {
                                $(this).find('.descripcion').slideDown('slow');
                                $(this).find('i').removeClass('icon-plus-sign').addClass('icon-minus-sign');

                            }
                            else
                            {
                                $(this).find('.descripcion').slideUp('slow');
                                $(this).find('i').removeClass('icon-minus-sign').addClass('icon-plus-sign');
                            }
                        });

                        $('.datos_condiciones').click(function(){
                            if($(this).find('.condiciones').is(':hidden'))
                            {
                                $(this).find('.condiciones').slideDown('slow');
                                $(this).find('i').removeClass('icon-plus-sign').addClass('icon-minus-sign');

                            }
                            else
                            {
                                $(this).find('.condiciones').slideUp('slow');
                                $(this).find('i').removeClass('icon-minus-sign').addClass('icon-plus-sign');
                            }
                        });

                    });
                </script>

                <div id="mensaje2" class="g1-message g1-message--error " style="display: none;">
                    <div id="mensaje" class="g1-inner">
                        Error Desconocido 3
                    </div>
                </div>

                <div id="mensaje_disponibilidad" class="g1-message g1-message--info " style="display: none;">
                    <div id="mensaje" class="g1-inner">
                         Error Desconocido 4
                    </div>
                </div>


                <div id="disponibilidad_habitacion">
                    <div id="cargador" style="top:60%;"></div>
                    <form id="form_disponibilidad_habitaciones" action="<?php echo lang('front.reserva_url').'/'.lang('front.datos_url'); ?>" method="post">
                           <input type="hidden" name="fecha_llegada" value="" />
                           <input type="hidden" name="fecha_salida" value="" />
                           <input type="hidden" name="noches" value="" />
                           <input type="hidden" name="temporada" value="" />
                           <!--
                           <div id="tabla_disponibilidad">

                           </div>
                        -->

                           <div id="tabla_disponibilidad_responsive">
                               <!--
                            <div class="habitacion_responsive">
                                <div class="row">
                                    <div class="large-12 columns">
                                        <div class="large-4 columns">
                                            <figure>
                                                <figcaption>
                                                    <h5>Tipo de habitación: Matrimonial</h5>
                                                </figcaption>
                                                <img src="assets/front/img/template/reservas/habitaciones/habitacion-classic.jpg" alt="Imagen habitacion"/>

                                            </figure>
                                        </div>
                                        <div class="large-8 columns">
                                            <div class="datos_descripcion">
                                                   <i class="icon-plus-sign"></i><strong> Descripcion</strong>
                                                   <div class="descripcion" style="display: none;">
                                                       <p>Hermosa habitación individual Hermosa habitación individual Hermosa habitación individual.</p>
                                                   </div>
                                               </div>
                                            <div class="datos_condiciones">
                                                   <i class="icon-plus-sign"></i><strong> Condiciones</strong>
                                                   <div class="condiciones" style="display: none;">
                                                       <ul>
                                                        <li>La reserva debe ser confirmada en las proximas 48 horas.</li>
                                                        <li>Hola</li>
                                                    </ul>
                                                   </div>
                                               </div>
                                            <p>
                                                <strong>Personas Max.</strong> <i class="icon-user"></i> <i class="icon-user"></i>
                                                <br />
                                                <strong>Precio (por noche) </strong>BsF. 3000,00
                                            </p>
                                            <select class="num_habitaciones" name="tip_hab[16]">
                                                <option value="0">0</option>
                                                <option value="1">1 (Bs 21000)</option>
                                            </select>
                                            <p>El precio mostrado aquí es calculado de la siguiente manera: (Noches x Cantidad habitaciones x precio por noche).</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        -->
                           </div>

                           <div id="boton_disponibilidad" class="form-row" style="display: none;">
                            <center>
                                <a id="g1-button-21" class="g1-button g1-button--medium g1-button--solid g1-button--standard"  href="<?php echo lang('front.inicio_url'); ?>"><i class="icon-remove"></i> <?php echo lang('front.reserva.habitaciones.btn2'); ?></a>
                                <a id="g1-button-24" class="g1-button g1-button--medium g1-button--solid g1-button--standard"><?php echo lang('front.reserva.habitaciones.btn1'); ?></a>
                                <button id="submit" type="submit" class="button" style="display: none;"><?php echo lang('front.reserva.habitaciones.btn1'); ?></button>
                            </center>
                        </div>

                       </form>

                </div>



               </article>
        </div>
    </div>
</div>