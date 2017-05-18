<!-- @b:carousel -->
<?php
//$contKeys 	= @master::$contMain['parent'][$com_active];
$contKeys 	= @master::$contMain['section'][18];
if(count($contKeys))
{
$contItems   = array_intersect_key(master::$contMain['full'],$contKeys); 
array_sort_by_column($contItems, 'seq', SORT_ASC);

$cont_display = '';
$cont_profs = array();

foreach($contItems as $contArr)	
{	
	//$contArr  		= master::$contMain['full'][$contKey];	
	$cont_id 	    = $contArr['id'];
	$cont_title 	 = $contArr['title'];
	$cont_seo 	   = trim($contArr['title']);
	
	
	//$cont_link 	  = display_linkArticle($cont_id, $contArr['link_seo']);
	$cont_link	  = ' data-href="ajforms.php?d=vprofile&item='.$cont_id.'"  rel="modal:open" ';
	
	$cont_extra	 = $contArr['extras'];
	$cont_role	  = (array_key_exists('role',$cont_extra)) ? $cont_extra['role'] : '';
	$cont_avatar	= (array_key_exists('avatar',$cont_extra)) ? $cont_extra['avatar'] : '';
	
	$cont_pic	   = ($cont_avatar == '' or $cont_avatar == 'no_image.png') ? 'avatar_generic.png' : $cont_avatar;
	
	$image_disp	= "<img src=\"".DISP_AVATARS.$cont_pic."\" style=\"max-width:300px; max-height:300px;\" >";
	$cont_pic_disp  = '<span class="carChopa profile_pic"><span class="bitChopaWrap" style="display:">'.$image_disp.'</span></span>';
	
	
	$submenu_display = '<span>'.$cont_role.'</span>';
	
	//$cont_seq 	 = ($contArr['seq'] <> 9 and !array_key_exists($contArr['seq'],$cont_profs)) ? $contArr['seq'] : $cont_id;
	
	//$cont_profs[] = '<li><div class="block equalized"><a '.$cont_link.' class="menu-column-main">'.$cont_pic_disp.' '.$cont_title.'</a><br /><div class="menu-column-subs">'.$submenu_display.'</div></div></li>';
	
	$cont_profs[] = '<li><div class="block equalized"><a '.$cont_link.'><span class="carChopa">'.$cont_pic_disp.'</span><div class="padd0_5"><span class="product-label">'.$cont_title.'</span><span class="product-desc">'.$cont_role.'</span></div></a></div></li>';
	
}
	
	//echo '<div class="wrap_gallery padd20_0"><ul id="" class="column menu-column">';
	//echo implode('',$cont_profs); 
	//echo '</ul></div>';
?>

<div>
<?php echo display_PageTitle('Speakers', '', 'txtgreen '); ?>
	<div class="bxsliderCarousel">
	  <ul class="bxcarousel">
	  <?php echo implode('',$cont_profs); ?>
	  </ul>
	</div>
</div>
<?php } ?>
<!-- @e:carousel -->
