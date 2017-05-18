<?php 

if($this_page =='county.php') { $comMenuSection = 4;  $my_page_head = $county.' County Resources'; }
if($this_page =='rescat.php') { $comMenuSection = 4;  $my_page_head = 'Resource Category: '.$dir_category; }
if($this_page =='organizations.php') { $comMenuSection = 4;  $my_page_head = 'Publishers / Organizations: '.$organization; }

if(!isset($_GET['isec'])) {	
	echo display_PageTitle($my_page_head . '');
	//include("includes/inc.cont.page.intro.php");
}

function resourceParents($arr){
	return $arr['cont_parent_type'];
}
if($this_page =='county.php') { $comMenuSection = 4; }

//echobr($comMenuSection);
$dispData->siteDocuments();
$jsonResourcesArray = array();
if($comMenuSection == 4)
{
	$jsonResourcesArray  = master::$listResources['full'];

	$arrPar 		= array_map("resourceParents", $jsonResourcesArray);
	$resParents 	= array_combine($arrPar, $arrPar);
	asort($resParents);	
	$resParentsSelect = implode('</option><option>', $resParents);	
}
else
{
	if(array_key_exists($comMenuID,master::$listResources['_link']))
	{
		$jsonResourcesArray  = master::$listResources['_link'][$comMenuID];
	}
}

$fcontent = '';



/* ============================================================================== 
/*	SEARCH BLOCK! 
/* ------------------------------------------------------------------------------ */

$dir_keytext = ''; $dir_keywords  = ""; $dir_county = ""; $dir_language = ""; $dir_year = '';
$dir_type 	  = '<option value="">Filter by category</option>'; 
$dir_result    = "";
//displayArray($jsonResourcesArray); 
//displayArray(current($jsonResourcesArray));
if (isset($_REQUEST['formname']))
{
	$post		 = array_map("filter_data", $_REQUEST);
	//displayArray($post); 
	$dir_keytext  = clean_output($post['keyword']);
	$dir_county   = clean_output($post['county']);
	$dir_category = clean_output($post['dir_type']);
	$dir_year 	  = clean_output($post['dir_year']);
	$dir_org 	  = clean_output(@$post['organization']);
	
	$dir_keywords = clean_output($post['keyword']);// ." ". $dir_county ." ". $dir_category ." ". $dir_year ." ". $dir_org;
	
	
	if($dir_keywords <> '' )
	{ 
		//$dir_type     = '<option>'.$dir_category.'</option>';
		//$terms   		= explode(" ", $dir_keywords);
		$terms['words']  = $dir_keytext; //explode(" ", $dir_keytext);
		$terms['cat'] 	= $dir_category;
		$terms['year'] 	= $dir_year;
		$terms['county'] = $dir_county;
		$terms['organization'] = $dir_org;
		
		//displayArray($terms);
		
		$section_items = array_filter($jsonResourcesArray, function ($x) use ($terms, $dir_category){
			//displayArray($terms);
			foreach($terms as $tcol => $term){
				
				
				if($term <> '')
				{
					$isThere = 0;
					//echobr($tcol .' - '.$term.' - '.$x["cont_title"]);
					//displayArray($terms['words']);
					if($terms['words'] <> '') { 
						//|| $x["cont_title"] == $term
						if (stripos($x["cont_brief"], $term) || stripos($x["cont_title"], $term) ||  stripos($x["cont_type"], $term) || stripos($x["cont_author"], $term)) 
						{ 
							if($terms['county'] <> '') 
							{ 
								if(trim($x["county"]) == $terms['county'])
								{ 
									if($terms['year'] <> '') { 
										if($x["year_published"] == $terms['year'])
										{ //$isThere = 1;  
											if($terms['cat'] <> '') { 
												if($x["cont_type"] == $terms['cat'])
												{ $isThere = 1;  } else { $isThere = 0;  }
											}
										
										} else { $isThere = 0;  }
									}
									else { $isThere = 1;  }
								
								} else { $isThere = 0;  }
							}
							elseif($terms['year'] <> '') { 
										if($x["year_published"] == $terms['year'])
										{ $isThere = 1;  } else { $isThere = 0;  }
							}
							elseif($terms['cat'] <> '') { 
										if(stripos($x["cont_type"], $terms['cat']))
										{ $isThere = 1;  } else { $isThere = 0;  }
							}
							else { $isThere = 1;  }
							
							
							
						}
					}
					
					
					elseif($terms['year'] <> '' and $x["year_published"] == $terms['year']) { $isThere = 1; } //stripos($x["year_published"], $dir_year)
					elseif($terms['county'] <> '' and trim($x["county"]) == $terms['county']) { $isThere = 1;  }
					elseif($terms['cat'] <> '' and $x["cont_type"] == $terms['cat']) { $isThere  = 1; }
					/*elseif($terms['organization'] <> '' and trim($x["cont_author"]) == $terms['organization']) { $isThere = 1;  }*/
					
					
					/*if (stripos($x["cont_brief"], $term) ||
						stripos($x["cont_title"], $term) || 
						stripos($x["cont_type"], $term) || 
						stripos($x["county"], $term) || 
						stripos($x["year_published"], $term))*/
					//echobr($dir_year .' - '. $x["year_published"] .' - '. $isThere);
					if($isThere <> 0)
					{
						return true;
						/*if($dir_category <> '') 
						{ 
							if($x["cont_parent"] == $dir_category)
							{ return true; }
							else
							{ return false; }
						} else {
							return true;
						}*/
					}
				}
			}
			return false;
		});
		
		$dir_result = '<div class="txtcenter bold txtgreen">Results: '.count($section_items).'</div>';
	}
	else
	{
		$section_items  = $jsonResourcesArray;
	}
		
}
else
{
	$section_items  = $jsonResourcesArray;
}

//displayArray($section_items);


$page_recs_count 	  = count($section_items);	

/* =================== @@ beg :: PAGINATOR @@ ====== */

$items_per_page = 10;

$pages = new Paginator;
$pages->items_total = $page_recs_count;
$pages->mid_range = 7; 
$pages->custom_ipp = $items_per_page;	
$pages->paginate();


$page_current 	  = $pages->current_page;
$page_recs_start   = 1;
$page_recs_end     = $page_current * $items_per_page;

if($page_current > 1) { 
	$page_recs_start = (($page_current - 1) * $items_per_page) + 1; }
if($page_recs_end > $page_recs_count) { 
	$page_recs_end = $page_recs_count; }

$dir_result = '<div class="txtright padd10X">Results: '.$page_recs_start.' - '.$page_recs_end.' of '.$page_recs_count.'</div>';


if($page_recs_count == 0) {
	$dir_result = 'No items found!'; //'<div class="note txtcenter padd10">No items found!</div>';
}

$pages_head="<div class='padd10'></div><div class=\"paginator\">".$pages->display_pages()."<span class=\"pagejump\">".$pages->display_jump_menu()."</span></div>";

if(isset($_GET['isec']))  { $pages_head= '<div class="padd5_t box-more"><a href="library.php?com='.$com_active.'" class="postDate read_more_right">VIEW MORE </a></div>'; }

/* =================== @@ end :: PAGINATOR @@ ====== */


/* #Display Form */
if(count($jsonResourcesArray))
{
?>

<div class="subcolumns info" style="display:">

<?php include("includes/nav_downloads-search.php"); ?>

</div>

<?php	
}
/* END#Display Form */




$page_to_display  = $pages->current_page - 1;
$section_pages 	= array_chunk($section_items, $items_per_page, true);

$fcontent 	     = '';

if(count($section_pages))
{
	$contPages 		= $section_pages[$page_to_display];
	$loopNum 		= 1;
	
	//displayArray(current(master::$listResources['full']));
	foreach ($contPages as $contKey => $contVal) 						
	{
		if(is_array($contVal)) { $contArray = $contVal; }
		else { $contArray = master::$listResources['full'][$contVal]; }
		//
		
		
		$item_id			= $contArray['cont_id'];
		$item_title		 = clean_output($contArray['cont_title']);
		$item_brief		 = clean_output($contArray['cont_brief']);
		$item_brief	   = string_truncate(strip_tags_clean($item_brief), 20); //''; //
		$item_author	    = clean_output($contArray['cont_author']);
		$item_lang	      = clean_output($contArray['cont_language']);
		$item_parent_type		  = $contArray['cont_parent_type']; 
		$item_parent_id		  = $contArray['cont_parent_id']; 
		$item_county	      = clean_output($contArray['county']);
		$item_pub_year	      = clean_output($contArray['year_published']);
		
		$item_cover	      = clean_output($contArray['cont_cover']);
		
		if($item_parent_type == '_link') { 
			$parent_name   = master::$menusFull[$item_parent_id]['title'];				
		}
		
		if($item_parent_type == '_cont') { 
			$parent_name   = master::$contMain['full'][$item_parent_id]['title'];				
		}
		$item_parent	      = clean_output($parent_name);
		$item_parent_label = '<span class="txtgreen txt12" title="Section">'. $item_parent . '</span> &nbsp; | &nbsp;';
		
		$item_cat 	  = ' &nbsp;<span class="postDate nocaps txt12">('.$parent_name.')</span> ';
		
		
		$item_date		  = date("Y, M d", strtotime($contArray['cont_date']));
		$item_url		  = $contArray['cont_seo']; 
		
		$item_name		  = $contArray['cont_name']; 
		
		//$item_link 		  = '<a href="lib.php?f='.$item_url.'" target="_blank" class="'.$item_ext.'">'.$item_title.'</a>';
		
		$file_name       = $contArray['cont_name'];
		$item_protocol   = substr($file_name,0,3);
		$item_ext        = strtolower(substr(strrchr($file_name,"."),1));
		
		/* EXTERNAL */
		if($item_protocol == 'htt' or $item_protocol == 'www' or $item_protocol == 'ftp' or $item_protocol == 'ww2') 
		{ $link = ' href="'.$file_name.'" ';  } else 
		{ 
			//$link = ' href="'.CONF_LINK_DOWNLOAD.'?f='.$item_url.'" '; 
			$link = ' data-href="ajforms.php?d=docfetch&vw='.$item_url.'&parent='.$item_title.'" rel="modal:open" ';
			$link = ' href="resource.php?com='.$seo_name.'&id='.$item_id.'" ';
		}	
		
		$highlite_cls = $highlite_img = $file_video = '';
		$item_link = '<a '.$link.' class="'.$item_ext . $highlite_cls.'">'.$highlite_img . $item_title .'</a> '.$file_video;
		
		
		
		if($item_author <> '') 
		{ 
			$author_link = '<a class="txt13 txtorange" href="organizations.php?com=5&formname=tag&dir_type='.$item_author.'&organization='.$item_author.'">'.$item_author.'</a>';
			$item_author = "<span class='txt12 txtorange' title='Publisher'>".$author_link." (".$item_county.")"."</span>"; }
		
		if($item_lang <> '') 
		{ $item_lang = "&nbsp; | &nbsp;<span class='txt12 txtgraylight' title='language'><strong></strong> ".$item_lang."</span>"; }
		
		if($item_pub_year <> '') 
		{ $item_pub_year = "&nbsp; | &nbsp;<span class='txt12 txtgraylight' title='Published'><strong></strong> ".$item_pub_year."</span>"; }
		
		
		$item_desc = "<div class=\"trunc1200X\"><em>".$item_parent_label.$item_author . $item_lang . $item_pub_year ."</em><br>". $item_brief."</div>";
		
		
		//echobr(UPL_COVERS.$item_cover);
			
		$upload_icon_disp = ''; //'<span class="carChopa no-image" style="width:70px; max-height:70px;"></span>';
		$icon_box = '';
		$icon_spacer = '';
		if($item_cover <> '' and (file_exists(UPL_COVERS.$item_cover)))
		{
			$icon_box = ' width:70px;';
			$icon_spacer = 'margin-left:80px;';
			$upload_icon_disp	  = '<span class="carChopa" style="width:70px;max-height:70px;"><img src="'.DISP_COVERS.$item_cover.'" alt="" /></span>';
		}
		
		$fcontent .=  '<li><div class="block equalizedX" style=""><div style="float:left;'.$icon_box.'">'.$upload_icon_disp.'</div>
		<div style="width:auto;'.$icon_spacer.'"><div class="padd5">'.$item_link.'' . $item_desc . ' </div></div></div></li>';
		
	
	}
	
}
	//exit;
	
	
	//echo $dir_result;
$dir_resultb = '';

if (isset($_REQUEST['formname']) and $_REQUEST['formname'] =='fm_dir_search')
{ 
	$sResult = '';
	if($sRequest['keyword'] <> '') { $sResult .= '<b>'.$sRequest['keyword'].'</b> &nbsp; '; }
	if($sRequest['county'] <> '') { $sResult .= '<em>county: </em><b>'.$sRequest['county'].'</b> &nbsp; '; }
	if($sRequest['dir_year'] <> '') { $sResult .= '<em>year: </em><b>'.$sRequest['dir_year'].'</b> &nbsp; '; }
	if($sRequest['dir_type'] <> '') { $sResult .= '<em>Category: </em><b>'.$sRequest['dir_type'].'</b> &nbsp; '; }
	
	$dir_resultb = '<div class="subcolumns note noborder"><div class="col-md-9">Search for: '.$sResult.'</div><div class="col-md-3 txtright">'.$dir_result.'</div></div>';
}
	echo $dir_resultb;
	
	echo '<div><ul id="" class="column column_full cont_dloads">';
	echo $fcontent;
	echo '</ul></div>';
	
	//echo $pages_head;
/* ======== @@ PAGINATOR @@ ====== */	
if($page_recs_count > $pages->custom_ipp) {
	echo $pages_head;
}
/* =============================== */

	echo '<!--<div class="padd10"></div><div class="note">Didnt find what you were looking for? Click here</div>-->';
	
?>



