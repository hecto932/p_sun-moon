<?php
/**
 * User: jonathan
 * Date: Nov 19, 2010
 * Time: 11:31:18 AM
 */
 
function estado_usuario($estado,$tipo_receta='mes'){
    if ($tipo_receta=='usuario')
        return str_replace(array('publicado','guardado'),array('aprobado','pendiente de aprobacion'),$estado);
    else return $estado;
}