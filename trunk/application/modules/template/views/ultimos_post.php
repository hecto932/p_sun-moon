<div class="sidebar_noticias">
        <img src="../assets/front/img/template/ultnoticias_tit.png" />
         <ul>
        <?php if(isset($noticias_mini)&&$noticias_mini!=NULL) : 
        	  foreach($noticias_mini as $postit) :
			  if(isset($postit->url)&&($postit->url!='')) { $url=$postit->url; }else{ $url=$postit->id_detalle_noticia; } 
        	  if (isset($postit)) { $imagen=json_decode(modules::run('services/relations/get_rel','noticia','imagen',$postit->id_noticia,'true','multimedia.id_multimedia'));
				  
		      $img_url=(isset($imagen) && isset($imagen[0]->fichero) && $imagen[0]->fichero!='' ? '/assets/front/img/thumb/'.$imagen[0]->fichero : $placeholder_min);
			  if(!file_exists(FCPATH.$img_url)) $img_url = $placeholder_min; } ?>
        <li><a href="<?php echo base_url().lang('detalle_url').$url;?>"><img width="40" height="40" src="<?php echo $img_url; ?>" /><strong><?php if(strlen($postit->nombre)>30): echo substr($postit->nombre,0,30).'...'; else: echo $postit->nombre; endif; ?></strong>
        <?php if(strlen($postit->descripcion_breve)>65): echo substr($postit->descripcion_breve,0,60).'...'; else: echo $postit->descripcion_breve; endif; ?></a></li>
        <?php endforeach; 
        	  else : ?>
        	  <li><?php echo lang('blog.vuelve'); ?></li>
       	<?php endif; ?>
        </ul>
</div>