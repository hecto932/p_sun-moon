		<ul id="breadcrumb">
		<?php 
		$i=0;
		$url='';
		foreach($breadcrumbs as $k=>$b){
			$i++;
			
			if ($i<count($breadcrumbs)){
				$url.=$k.'/';
			echo '<li>'.anchor($url,$b,array('title'=>'')).'</li>';
			}else{


	       echo '<li class="last"><span>'.$b.'</span></li>';
} 
}?>
		
        </ul>