<?php
if($my_redirect <> 'library.php') 
{
$dispData->siteDocuments();
//displayArray(master::$listResources);

$section_items 	= array_chunk(master::$listResources['full'], 4, true);
$contLatest 	= $section_items[0]; //displayArray($contLatest);
	
$date_spotlite = time()-(60*60*24*10);
$highlite_img   = "";
	$highlite_cls   = ""; 
	$highlite_flash = "";
	$fcontent	   = "";
	
	
	foreach($contLatest as $file_key => $file_arr)
	{
		//$file_arr 	    = master::$listResources['full'][$file_val]; 
		//displayArray($file_arr);
		
		$file_id         = $file_arr['cont_id'];
		$file_title      = $file_arr['cont_title'];
		//$file_type 	   = $file_arr['filetype'];
		$file_name       = $file_arr['cont_name'];
		$file_date       = strtotime($file_arr['cont_date']);			
		$file_desc	   = string_truncate(strip_tags_clean($file_arr['cont_brief']), 150);	
		
		$file_cat        = $file_arr['cont_parent_type'];
		$file_cat_id     = $file_arr['cont_parent_id'];
		$file_seo        = $file_arr['cont_seo'];
		
		
		if($file_cat == '_link') { 
			$parent_name   = @master::$menusFull[$file_cat_id]['title'];				
		}
		
		if($file_cat == '_cont') { 
			$parent_name   = @master::$contMain['full'][$file_cat_id]['title'];				
		}
		
		$item_cat 	  = ' &nbsp;<span class="postDate nocaps txt12">('.$parent_name.')</span>'; 
			
		if($file_date > $date_spotlite) 
		{   //$highlite_img = " <span style=\"background:url(image/icons/icon-newb.png) no-repeat 50% 100%; width:27px;height:16px;display:inline-block;\">&nbsp;</span> "; 
		    //$highlite_cls = ""; 
			//$highlite_flash = " rel=\"flashfg[red]\""; 
		}
		
		$item_protocol = substr($file_name,0,3);
		$item_ext      = strtolower(substr(strrchr($file_name,"."),1));
		
		//EXTERNAL
		if($item_protocol == 'htt' or $item_protocol == 'www' or $item_protocol == 'ftp' or $item_protocol == 'ww2') 
		{ $link = $file_name;  } else 
		{ 
			//$link = CONF_LINK_DOWNLOAD.$com_base."res_id=".$file_id; 
			$link = CONF_LINK_DOWNLOAD."?f=".$file_seo; //"?res_id=".$file_id; 
			$link = 'resource.php?com=resources&id='.$file_id.'';
		}	//"file/$item_name";
		
		$item_link = "<a href=\"$link\" class=\"$item_ext $highlite_cls\" $highlite_flash >".$highlite_img.$file_title.$item_cat."</a>";
				
		$fcontent .=  "<li>".$item_link."</li>";
		
		
	}


	
	
	
	if(count($contLatest) > 0)
	{
	
?>

	<div class="box-cont">
		<div class="box-cont-title">Latest Resources</div>
		
		<ul class="nav_dloads">
		<?php echo $fcontent; ?>
		</ul>
		
	
	</div>
<?php
	}
	
}



?>
