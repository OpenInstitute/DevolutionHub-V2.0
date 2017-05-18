<?php  
require("../classes/cls.constants.php"); 
//if(!isset($_GET['isec'])) { echo display_PageTitle($my_page_head . '');} 
$com_active  = $_REQUEST['com'];
$page 		= $_REQUEST['page'];

$out['first'] = '';
$out['text'] = '';
$out['href'] = '';
$items_per_page   = 12;
$item_box	     = '';	

$contArr 		  =  @master::$menuToContents[$com_active]; //displayArray($contArr);
$section_pages 	= array_chunk($contArr, $items_per_page, true);
$section_pages_num = count($section_pages);

//$section_items 	= $contArr; 
//$numrows 		  = count($section_items);


	
	
if($page <= ($section_pages_num - 1)) 
{

	$truncFilter 	= "<img>"; //<a>,<br>,
	$contPages 		= $section_pages[$page];
	$loopNum 		= 1;
	
	
	//echo '<div class="page-bits clearfix">';	
	
	foreach ($contPages as $contKey) 						
	{
		$image_disp = '';
		
		$contArray 		  = master::$contMainNew[$contKey];
		$cont_id			= $contArray['id'];
		$cont_parent_id	 = $contArray['id_menu'];
		$cont_title		 = $contArray['title'];
		$cont_title_sub	 = $contArray['title_sub'];
		$cont_page		  = $contArray['link_menu'];
		$cont_date		  = $contArray['modified']; 
		$cont_hits		  = $contArray['hits']; 
		$cont_location	   = $contArray['location'];
		$cont_article	   = $contArray['article'];
		
		$cont_brief_plain   = $cont_article;
		$item_link 		 = '';
		
/*-------------------------------------------------------------------------------------------------------
@CONTENT IMAGE
-------------------------------------------------------------------------------------------------------*/
		
$image_disp = ''; $image_link = '';

if(preg_match('/<img[^>]+\>/i',$cont_article,$regs)) { 
	$image_item = $regs[0];  $pic_small  = autoThumbnail($image_item); 	
	if($pic_small <> '')  { $image_link = '<img src="'.$pic_small.'" alt="'.$cont_title.'" />'; } 
} 
else { $image_link  = getContGalleryPic($cont_id, $cont_title); }

if($image_link == '') { $image_link = '<img src="image/no_image.png" alt="" />'; }
if($image_link <> '') 
{ $image_disp		= '<span class="bitChopaWrap" style="display:none"><span class="carChopa imgStretch">'.$image_link.'</span></span>'; } 

/*-------------------------------------------------------------------------------------------------------
@@ END: CONTENT IMAGE
-------------------------------------------------------------------------------------------------------*/ 
 		
	
		$cont_more 	 = '';
		$headLinkIcon  = ''; 
		
		//$itemViews = '<div><span class="postDate nocaps">Updated: '.$cont_date.'</span> </div>';
		$itemViews = '<div><span class="postDate nocaps">'.$cont_brief_plain.'</span> </div>';
		$itemBreak = 'block equalized normalbreak';
		
		if(isset($_GET['isec'])) { $itemViews = '<br>'; $itemBreak = 'home-bits'; }
		
		/*$item_box .= '<li>
			<div class="'.$itemBreak.'"><div class="padd10">'.$image_disp .'<br><a '.$item_link.' class="'.$headLinkIcon.' txt14 linkCont bold" data-id="'.$cont_id.'">'.$cont_title.'</a><br>
			'.$cont_brief_plain.' &nbsp; &nbsp;</div></div>
		</li>';*/
		
		
		$item_box .= '<li><div class="NormalPlaceholder normalbreak"  id="normalplaceholder'.$cont_id.'"><div class="placeholderwrap"><div class="curvy block PlaceHolderBlock" id="placeholderblock'.$cont_id.'"><div class="padd10">'.$image_disp .'<a '.$item_link.' class="'.$headLinkIcon.' txt14 linkCont bold" data-id="'.$cont_id.'">'.$cont_title.'</a> <div class="OverPlaceholder" style="display: none; "> <div id="masterDiv'.$cont_id.'" class="MasterDiv"> <div id="overplaceholder'.$cont_id.'"> <div class="OverProductsContainer txtgray txt12"> '.$cont_brief_plain.' </div> </div> </div> </div>';
		$item_box .= '</div></div></div></div></li>';
			
		$loopNum += 1;
	
	}
	
	
	
	if($page < ($section_pages_num - 1)) {
		$page_n = $page + 1;
		$out['href'] = '<a class="infinite-more-link" data-href="includes/inc.cont.places.list.php?com='.$com_active.'&page='.$page_n.'">More</a>';
	}
	
	if($page == 0) {
		$out['text'] = '<div class="wrap_gallery"><ul class="column col33 infinite-container waypoint">'.$item_box.'</ul><div class="clear">&nbsp;</div><div class="infinite-loading"></div><div class="infinite-more-wrap">'.$out['href'].'</div></div>';
	}
	else {	
		$out['text'] = $item_box;
	}
	
	





/*?>

<div class="">
	<div class="wrap_gallery"><ul class="column col33 infinite-container waypoint">

<?php echo $item_box; ?>

		</ul>
		
		<?php
		echo '<div class="clear">&nbsp;</div><div class="infinite-loading"></div><div class="infinite-more-wrap"><a class="infinite-more-link" data-href="includes/inc.cont.places.list.php?com='.$com_active.'page='.$page_n.'">More</a></div>';
		?>
	</div>				
</div>
<div class="clear">&nbsp;</div><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>

<?php*/


} 

echo json_encode($out);
?>

