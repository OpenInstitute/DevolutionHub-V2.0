<style type="text/css">
.billboard {
    background-image: -moz-linear-gradient(top,rgba(0,0,0,.03),rgba(255,255,255,.03));
    background-image: -webkit-linear-gradient(top,rgba(0,0,0,.03),rgba(255,255,255,.03));
    background-image: linear-gradient(top,rgba(0,0,0,.03),rgba(255,255,255,.03));
    -moz-border-radius: 0 0 3px 3px;
    -webkit-border-radius: 0 0 3px 3px;
    border-radius: 0 0 3px 3px;
    border-top: 0;
    -moz-box-shadow: inset 0 0 2px 0 rgba(0,0,0,.01);
    -webkit-box-shadow: inset 0 0 2px 0 rgba(0,0,0,.01);
    box-shadow: inset 0 0 2px 0 rgba(0,0,0,.01);
	margin: 10px auto 18px;    
    padding: 10px 20px;	
}

	.billboard_home_title { font-family: 'Muli',sans-serif; font-size:35px; font-weight:200; }
	.billboard_home_intro { font-family: 'Muli',sans-serif; font-size:20px; font-weight:200; }

</style>

<?php

//echobr($com_active);
//$dispData->siteContent($com_active);
//displayArray(master::$contMain);
if (array_key_exists('intros', master::$contMain) and array_key_exists($com_active, master::$contMain['intros']) and $item == '') 
{
	$contArrIntro = master::$contMain['intros'][$com_active];
	
	//if(count($contArrIntro) > 0)  {}
	$introKey		   = current($contArrIntro); 
	$introArray 		 = master::$contMain['full'][$introKey];

	$intro_title		 = $introArray['title'];
	$intro_title_sub	 = $introArray['title_sub'];
	$intro_page		  = $introArray['link_menu'];
	$intro_article	   = $introArray['article'];
	
	if($my_page_head == $intro_title) { $intro_title = ''; }
	
	if($com_active ==1){
		echo '<div class="txtcenter padd10 padd0_b billboard_home_title">'.$intro_title.'</div>
			<div class="padd5_t padd15_b txtcenter billboard_home_intro">'.$intro_article.'</div>';
	}else {
		echo '<div class="billboard">';
		echo '<h3>'.$intro_title.'</h3>';
		echo '<div class="trunc400" style="display:none">'.$intro_article.' &nbsp;</div>';
		echo '</div>';	
	}
	

}

?>
