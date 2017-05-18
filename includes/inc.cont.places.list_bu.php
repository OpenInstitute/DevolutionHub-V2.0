
<?php /*?><a href="rss.php?id=17&amp;mode=category" target="_blank" title="RSS"><img src="images/rss.png" style="vertical-align:middle; " alt="RSS Feed" border="0"></a><span class="subscribe-category"><a href="subscribe.php?id=17&amp;type=cat" title="Subscribe to Category"><img src="images/icon-user.png" style="vertical-align:middle;" alt="Icon Subscriber"> Subscribe</a></span><?php */?>

<?php  if(!isset($_GET['isec'])) {	
echo display_PageTitle($my_page_head . '');
} ?>

<?php
//if($com_active)
$contArr 	=  @master::$menuToContents[$com_active];
$section_items 	= $contArr; 
$numrows 		= count($section_items);

$truncLength   = 250;
$items_per_page = 18;

if(isset($_GET['isec'])) 
{	
	$items_per_page = 3;
	$truncLength   = 160;
}


if($comMenuSection == 12) {
	$truncLength   = 500;
}

$item_box	= '';	
	
if($numrows > 0)
{

/*******************************************************
  @@ PAGINATOR
====================================================== */	
$pages = new Paginator;
$pages->items_total = $numrows;
$pages->mid_range = 7; 
$pages->custom_ipp = $items_per_page;
$pages->paginate();

$pages_head="<div class=\"paginator\" style=\"margin-top:20px;\">".$pages->display_pages()."<span class=\"pagejump\">".$pages->display_jump_menu()."</span></div>";

if(isset($_GET['isec']))  { 
$pages_head= '<div class="padd5_t box-more"><a href="content.php?com='.$com_active.'" class="postDate read_more_right">VIEW MORE </a></div>'; 
}

/* ====================================================== */

$page_to_display = $pages->current_page - 1;

$section_pages 	= array_chunk($section_items, $items_per_page, true);

if(count($section_pages))
{
	$truncFilter 	= "<img>"; //<a>,<br>,
	$contPages 		= $section_pages[$page_to_display];
	$loopNum 		= 1;
	
	
	//echo '<div class="page-bits clearfix">';	
	
	foreach ($contPages as $contKey) 						
	{
		$image_disp = '';
		
		$contArray 		  = master::$contMainNew[$contKey];
		//displayArray($contArray); exit;
		$cont_id			= $contArray['id'];
		$cont_parent_id	 = $contArray['id_menu'];
		$cont_title		 = $contArray['title'];
		$cont_title_sub	 = $contArray['title_sub'];
		$cont_page		  = $contArray['link_menu'];
		$cont_date		  = $contArray['modified']; 
		$cont_hits		  = $contArray['hits']; 
		
		$cont_location	   = $contArray['location'];
		
		$cont_article	   = $contArray['article'];
		
		
		
		$title_sub		= '';
		$title_date		= '';
	
		if(strlen($cont_title_sub)>=5) 	{ $title_sub	= '<div class="page-bit-head-sub">'.$cont_title_sub.'</div>'; }
		if($this_page =="news.php") 	{ $title_date 	= '<div class="postDate">'.$cont_date.'</div>'; }
		
		
		//$item_link		= $cont_page . RDR_REF_BASE . "item=" . $cont_id;	
		

		if($comMenuSection == 12 and $cont_location <> '') {
			//$item_link	  = ' href="'.$cont_location.'" ';
			//$cont_brief_plain 	= '<div class="trunc400" style="display:none">'.strip_tags_clean($cont_article).' &nbsp;</div>'; 
		} else {
			//$item_link		  = display_linkArticle($cont_id, $contArray['link_seo']);
			//$cont_brief_plain 	= smartTruncateNew(strip_tags_clean($cont_article),$truncLength); 
		}
		
		$item_link = '';
		$cont_brief_plain = $cont_article; //strip_tags_clean($cont_article, '<br>');
		//$cont_brief_plain = '<div><span class="txtgray txt13X">'.$cont_article.'</span> </div>';

/*-------------------------------------------------------------------------------------------------------
@CONTENT IMAGE
-------------------------------------------------------------------------------------------------------*/
		
$image_disp = ''; $image_link = '';

if(preg_match('/<img[^>]+\>/i',$cont_article,$regs)) { 
	$image_item = $regs[0];  $pic_small  = autoThumbnail($image_item); 	
	if($pic_small <> '')  { $image_link		= '<img src="'.$pic_small.'" alt="'.$cont_title.'" />'; } 
} 
else { $image_link  = getContGalleryPic($cont_id, $cont_title); }

if($image_link <> '') 
{ $image_disp		= '<span class="bitChopaWrap" style="display:none"><span class="carChopa imgStretch">'.$image_link.'</span></span>'; } 

/*-------------------------------------------------------------------------------------------------------
@@ END: CONTENT IMAGE
-------------------------------------------------------------------------------------------------------*/ 
 		
	
	$cont_more 	 = '';
	if(strlen($cont_brief_plain) > 0) 
	{ 
	$cont_more = ' &nbsp; <a '.$item_link.' class="read_more"><span>+ </span> More info </a><p class="_more"></p>';
	}
		//<p class="_more"></p>
		
					  
	$headLinkIcon = ''; 
	if($image_disp == '') { $headLinkIcon = ' article '; }
	
	//$itemViews = '<div><span class="postDate nocaps">Updated: '.$cont_date.'</span> </div>';
	$itemViews = '<div><span class="postDate nocaps">'.$cont_brief_plain.'</span> </div>';
	$itemBreak = 'block equalized normalbreak';
	
	if(isset($_GET['isec'])) { $itemViews = '<br>'; $itemBreak = 'home-bits'; }
	
	/*$item_box .= '<li>
		<div class="'.$itemBreak.'"><div class="padd10">'.$image_disp .'<br><a '.$item_link.' class="'.$headLinkIcon.' txt14 linkCont bold" data-id="'.$cont_id.'">'.$cont_title.'</a><br>
		'.$cont_brief_plain.' &nbsp; &nbsp;</div></div>
	</li>';*/
	
	
	$item_box .= '<li><div class="NormalPlaceholder normalbreak"  id="normalplaceholder'.$cont_id.'"><div class="placeholderwrap"><div class="curvy block PlaceHolderBlock" id="placeholderblock'.$cont_id.'">'; 
	$item_box .= '<div class="padd10">'.$image_disp .'<a '.$item_link.' class="'.$headLinkIcon.' txt14 linkCont bold" data-id="'.$cont_id.'">'.$cont_title.'</a>';
	$item_box .= '<div class="OverPlaceholder" style="display: none; ">
				<div id="masterDiv'.$cont_id.'" class="MasterDiv">				
					<div id="overplaceholder'.$cont_id.'">
					<div class="OverProductsContainer txtgray">
						'.$cont_brief_plain.'					
					</div>
					</div>
				</div>
			</div>';
	$item_box .= '</div></div></div></div></li>';
		
	$loopNum += 1;
	
	}
	
	//echo '<div class="clear"></div>';
	//echo '</div>';
}









?>

<div class="">
	<div class="wrap_gallery">
		<ul class="column col33">

<?php echo $item_box; ?>

		</ul>
	</div>				
</div>


<?php
/* ======== @@ PAGINATOR @@ ====== */	
if($numrows > $pages->custom_ipp) {
	echo $pages_head;
}/**/
/* =============================== */


} 
?>
<div class="clear">&nbsp;</div>
<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>

<script type="text/javascript">

/*var placeholderID, numPlaceholderZIndex, placeholderHeight;
jQuery(document).ready(function($){
	$(".NormalPlaceholder").hover(
		function(){
			placeholderID = $(this).attr('id');
			placeholderHeight = $(this).height(); 
			placeholderID = placeholderID.replace("normalplaceholder","");			
			$("#masterDiv" + placeholderID).parent().show();
			$("#masterDiv" + placeholderID).show();	
			numPlaceholderZIndex = $(this).css('zIndex');					
			$(this).css('zIndex',1005);
			$(this).addClass("active");
			$(this).height(placeholderHeight);
		},
		function(){
			placeholderID = $(this).attr('id');
			placeholderID = placeholderID.replace("normalplaceholder","");			
			$("#masterDiv" + placeholderID).parent().hide();
			$("#masterDiv" + placeholderID).hide(); 			
			$(this).css('zIndex',numPlaceholderZIndex);
			$(this).removeClass("active");
		}
	);
	
	
});*/

</script>
			