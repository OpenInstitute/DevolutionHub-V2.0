<?php require("../classes/cls.constants.php");
	  
	 $sshow_large = '';
	  $sshow_thumb = '';
		$bImages   = '';

$section_items 	= master::$listGallery['cat']['banner']; 
$section_pages 	= array_chunk($section_items, 10, true);

if(count($section_pages))
{
	$contPages 		= $section_pages[0];
	$loopNum 		  = 1;
	
	foreach ($contPages as $contKey) 						
	{
		$contArray	     = master::$listGallery['full'][$contKey]; //displayArray($contArray);
		
		$id_pic			= $contArray['id'];
		$pic_parent_id	 = $contArray['pic_parent_id'];
		$pic_parent		= $contArray['pic_parent'];
		$pic_parent_title  = '';
		$pic_name		  = $contArray['filename'];
		
		$pic_title		 = $contArray['title'];
		
		$pic_type		  = $contArray['filetype'];
		$pic_desc		  = $contArray['details'];
		$pic_page		  = 'gallery.php';
		
		$sector_id		 = ''; //$contArray['sector_id'];
		$sector			= 'News';
		if($sector <> '') { $sector = '<span class="highbtn">'.$sector.'</span>';}
		
		$item_lebo         = 'item';
		
			if($pic_parent == '_cont') { 				
				$pic_content   = master::$contMain['full'][$pic_parent_id]; 	
				$gall_link	   = display_linkArticle($pic_parent_id, $pic_content['link_seo']);				
			}
			
			
			if($pic_parent == '_link') { 				
				$pic_content   = master::$menusFull[$pic_parent_id]; 	
				$gall_link 	  = display_linkMenu($pic_content['link_menu'], $pic_content['menu_seo_name']);
			}
			
			if($pic_parent == '_project') { 				
				$gall_link 	  = ' href="projects/?pj='.$pic_parent_id.'"';
			}
			
			$pic_parent_title  = $pic_content['title'];
			
			if($pic_type == 'p')
			{
				$pic_type_lebo = '';
				$pic_big 	  = DISP_GALLERY.$pic_name;
				$pic_thmb	 = getThumbName($pic_name);
				if (!file_exists(UPL_GALLERY.$pic_thmb)) { $pic_thmb = $pic_name; }				
				$pic_small     = DISP_GALLERY.$pic_thmb;
			}	
			elseif($pic_type == 'v')
			{
				$pic_type_lebo = ' <em class="txt11">(Video)</em>';
				$vid_link		= $pic_name; 
				$vid_insert	  = strrpos($vid_link , '/')+1;
				$vid_code		= substr($vid_link, $vid_insert);
				
				$pic_big		 = 'http://img.youtube.com/vi/'.$vid_code.'/hqdefault.jpg';
				$pic_small	   = 'http://img.youtube.com/vi/'.$vid_code.'/mqdefault.jpg';
			}	
		
		
			$bIntro		  = smartTruncateNew(strip_tags($pic_desc),100);
		
			//$pic_link		= $pic_page.'?com='.$pic_menu_id.'&'.$item_lebo.'='.$pic_cont_id.'&';
			
			$lnk_gal_beg = '<a '.$gall_link.'>';	// href="'.$pic_link.'" target="_blank"
			$lnk_gal_end = '</a>';
			
			//if(trim(strtolower($pic_content['title'])) <> trim(strtolower($pic_title))) 
			//{ $pic_parent_title = '<h2 class="txt12X txtupper">'.$pic_content['title'].'</h2>'; }
			
			if(trim(strtolower($pic_content['title'])) == trim(strtolower($pic_title))) {
				$pic_title = '';
			}
			
		$bMore 			= $lnk_gal_beg.'&nbsp; <span class="btn_bg_orange padd2 txt10 txtwhite"> Proceed </span></a>'; 
		$pic_title_b	  = '<p> <a '.$gall_link.'>'.$pic_title.'</a></p>'; 
		
		
		
		//style="height:320px"
		/*$bImagesXX		.= '<li>'.$lnk_gal_beg.'
			<img src="'.$pic_big.'" alt="" title="'.$pic_title.'" class="flximg" >'.$lnk_gal_end.'
			<div class="slide-cnt curvy">
			<div class="slide-cnt-pad">
				'.$pic_parent_title .' '.$pic_title_b.' '.$sector.'
			</div>
			</div>
		</li>';*/
		
		$bImages .= '<li>
	<div class="slide-image">
		<img src="'.$pic_big.'" title="'.$pic_title.'" class="img-full" />
	</div>
	<div class="slide-caption padding-all head_width">
		<div class="wrapper">
			<div class="v-center">
				<h5 class="line-bottom">'.$pic_parent_title .'</h5>
				<h2 class="text-space">'.$pic_title.' </h2>
				<br /><a '.$gall_link.' target="_parent" class="btn btn-warning">VIEW MORE</a>
			</div>
		</div>
	</div>
</li>';
			
	}
	
	//echo $bImagesXX;
?>


<section id="site-slider" class="banner_home">
<div class="slider bxflex bxflex-home" style=""> 
<ul class="bxslider">
<?php echo $bImages; ?>
</ul>
</div>

<div class="banner_home_mask"></div>
<div class="banner_home_intro"></div>
</section>

<?php
}
?>