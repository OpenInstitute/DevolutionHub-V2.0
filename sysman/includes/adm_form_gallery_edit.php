<?php
if($id)
{
	
	$sqdata="SELECT
    `dhub_dt_gallery_photos`.`id`
    , `dhub_dt_gallery_photos`.`title`
    , `dhub_dt_gallery_photos`.`description`
    , `dhub_dt_gallery_photos`.`filename`
    , `dhub_dt_gallery_photos`.`published`
    , `dhub_dt_gallery_photos`.`id_gallery_cat`
    , `dhub_dt_gallery_category`.`title` AS `gallery_cat`
    , `dhub_dt_gallery_category`.`gall_path`
    , `dhub_dt_gallery_photos`.`filetype`
	, `dhub_dt_gallery_photos`.`tags`
FROM
    `dhub_dt_gallery_photos`
    LEFT JOIN `dhub_dt_gallery_category` 
        ON (`dhub_dt_gallery_photos`.`id_gallery_cat` = `dhub_dt_gallery_category`.`id`) WHERE  (`dhub_dt_gallery_photos`.`id` = ".quote_smart($id)." )";
	
	//echo $sqdata;
	
	$rsdata=$cndb->dbQuery($sqdata);
	$rsdata_count= $cndb->recordCount($rsdata);
	
	$gallery = '';
		if($rsdata_count>=1)
		{
			while($cndata=$cndb->fetchRow($rsdata))
			{
				$feat_lebo	="";
				$feat_chek	="";
				
				$id_photo			= $cndata[0];
				$id_content		 = $cndata[1];
				
				$id_menu			= $cndata[8]; 
				
				$title				= trim(html_entity_decode(stripslashes($cndata['title'])));
				$description				= trim(html_entity_decode(stripslashes($cndata['description'])));
				$image				= trim(html_entity_decode(stripslashes($cndata['filename'])));
				$image_title		= $image; 
				
				if(trim($cndata['gall_path']) <> '')
				{
				$gallery_path			= DISP_IMAGES.trim($cndata['gall_path']);
				}
				else
				{$gallery_path = DISP_GALLERY; }
				
				//echobr($gallery_path);
				
				$smallpic_insert 	 = strrpos($image , ".");
				$smallpic			= substr_replace($image, '_t.', $smallpic_insert, 1);
				
				//if(!file_exists(UPL_GALLERY.$smallpic)) { $smallpic = $image; }
				
				$ca_tags			= clean_output($cndata['tags']); 
				$ca_tags	        = unserialize($ca_tags);
				//displayArray($ca_tags);
				
				$id_galcat			= $cndata['id_gallery_cat']; 
				$galCategory = $ddSelect->dropper_select("dhub_dt_gallery_category", "id", "title", $id_galcat);
				
				$galtype			= trim($cndata['filetype']);
				
				$published			= $cndata['published']; 
				if($published==1) {$published="checked ";} else {$published="";}
				
				//echobr($id_galcat);
				if($id_galcat == 4 or $id_galcat == 7)
				{ $parent_field = 'id_equipment'; }
				
				
				
	/* ============================================================================================= */
	/* GET -- PARENTS
	/* --------------------------------------------------------------------------------------------- */
	$parent_menus = ''; $parent_conts = ''; $parent_profs = '';
	//`id_link`, `id_content`,`id_equipment`,`id_resource`,`id_partner`
	$sq_pic_parent = "SELECT  * FROM `dhub_dt_gallery_photos_parent` WHERE (`id_photo` = ".quote_smart($id_photo)."); "; 
	$rs_pic_parent = $cndb->dbQuery($sq_pic_parent);
	if( $cndb->recordCount($rs_pic_parent)) 
	{
		while($cn_pic_parent = $cndb->fetchRow($rs_pic_parent, 'assoc'))
		{
			if($cn_pic_parent['id_link'] <> 0) { $parent_menus[] = $cn_pic_parent['id_link']; }
			if($cn_pic_parent['id_content'] <> 0) { $parent_conts['art'][] = $cn_pic_parent['id_content']; }
			if($cn_pic_parent['id_resource'] <> 0) { $parent_conts['doc'][] = $cn_pic_parent['id_resource']; }
			//if($cn_pic_parent['id_equipment'] <> 0) { $parent_conts['eqp'][] = $cn_pic_parent['id_equipment']; }
			
		}
	}	
	//displayArray($parent_conts);
	/* ============================================================================================= */
	
	
	/* ============================================================================================= */
	/* GET -- PROJECT >>> LINKS
	/* --------------------------------------------------------------------------------------------- */	
	//$pLinks = $ddSelect->getProjectLinks('id_gallery', $id_photo); 
	//if(is_array($pLinks)){ $sector_id = $pLinks['sector_id']; $project_id = $pLinks['project_id']; }
	/* ============================================================================================= */
		
				
			if($galtype=='p') 
			{
				$filetype = 'Photo';
				if(strpos($image, '/')) {
					$path1 = $gallery_path.$image; $path2 = $path1;	//DISP_IMAGES
				} else { 
					$path1 = $gallery_path.$image; $path2 = $path1; 	//DISP_GALLERY
				}
				//echo $path1;
				
		 		$image_disp	 = '<a class="vidPop" href="'.$path1.'"  title="'.$title.'" style="display:block;">';
				$image_disp	.= '<img src="'.$path2.'" alt="" title="'.$image_title.'" style="width:100%;" />';
				$image_disp	.= '</a>';
				
			}
			elseif($galtype=='v') 
			{
				$filetype 		= 'Video';
				$v_insert 		= strrpos($image, '/');
				$v_pic			= substr($image, $v_insert);
				$v_code			= substr($image, $v_insert+1);
				
				$image_disp	 = '<a class="vidPop" href="http://www.youtube.com/v/'.$v_code.'?fs=1&amp;autoplay=1"  title="'.$title.'" style="display:block;">';
				$image_disp	.= '<img src="http://img.youtube.com/vi'.$v_pic.'/mqdefault.jpg" alt="" style="width:100%;" />';
				$image_disp	.= '</a>';				
					
			}	
			
			
			
	
	$optionsMenu = '';
	$optionsCont = '';
	$labelMenu   = '';
	$labelCont   = '';
	
	if($id_galcat <> 5)
	{	  	
		$labelMenu   = 'Parent Menu:';		
		$optionsMenu  =  '<select name="id_parent[]" id="id_parent" multiple="multiple" class="multiple" style="width:400px">'.$dispData->build_MenuSelectRage(0, $parent_menus).'</select>';
	
		$labelCont   = 'Parent Content:';
		$optionsCont  = '<select name="id_content['.$id_photo.'][]" id="id_content" multiple="multiple" class="multiple" style="width:400px">'.$dispData->build_MenuArticles(master::$contMain['full'], $id_content, 0 , @$parent_conts['art']).'</select>'; 
	}
	
	
	
	if($id_galcat == 5)
	{
		$labelCont   = 'Parent Resource:';
		$optionsCont = '<select name="id_resource['.$id_photo.'][]" id="id_resource" multiple="multiple" class="form-control multiple" style="width:100% !important" >'.$ddSelect->dropper_select("dhub_dt_downloads", "id", "title", $parent_conts['doc']).'</select>';
	}
			

$ca_section_tags = ''; 
			}
		}
		?>
		<div style="width:100%; max-width:1000px; margin:0 auto; border:0px solid">

		<h2>Edit Gallery Item &raquo;</h2>
		
		<form action="adm_posts.php" method="post" class="rwdform rwdfull">
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="tims">
  <tr>
    
    <td style="width:130px;"> </td>
    <td></td>
	<td style="width:320px;" rowspan="11"><div style="padding:15px 5px;"><?php echo $image_disp; ?></div></td>
  </tr>
  <tr>
    <td><?php echo $labelMenu; ?></td>
    <td><?php echo $optionsMenu; ?></td>
  </tr>
  <tr>
    <td><?php echo $labelCont; ?></td>
    <td><?php echo $optionsCont; ?></td>
  </tr>
  <?php 
/*	===========================================================
	// BEGIN - SECTOR AND PROJECT LINKAGE 
/*  -----------------------------------------------------------  
?>	
<tr><td nowrap="nowrap"><label>Sector / Project Link:</label></td> <td style="">
<table style="margin:0 "> <tr> <td style="padding-left:0"> <select id="sector_id" name="sector_id" onchange="javascript: show_projects(); "> <?php echo $ddSelect->dropper_select("dhub_app_sector", "sector_id", "title", $sector_id, "Select Sector") ?> </select> </td></tr><tr><td style="padding-left:0"> <span id="box_project"><input name="project_id" id="project_id" type="text" readonly placeholder="Select Project" ></span></td> </tr> </table>
</td></tr>
<?php 
/*	-----------------------------------------------------------
	// END - SECTOR AND PROJECT LINKAGE 
/*  ===========================================================  */
?>
  <tr>
    <td> </td>
    <td> </td>
  </tr>
  <tr>
  	<td style="width:150px;"><label>Resource Type:</label> </td>
    <td><label><b style="color:#f00;"> <?php echo $filetype; ?> </b></label></td>
  	</tr>
  <tr>
    <td>Title:</td>
    <td>
		<input type="text" name="caption[<?php echo $id_photo; ?>]" value="<?php echo $title; ?>" />
		<input type="hidden" name="image[<?php echo $id_photo; ?>]" value="<?php echo $image; ?>" />
		<input type="hidden" name="galtype[<?php echo $id_photo; ?>]" value="<?php echo $galtype; ?>"/>
	</td>
  </tr>
  <tr>
    <td nowrap="nowrap"><label>Summary:</label></td>
    <td><textarea name="desc[<?php echo $id_photo; ?>]" ><?php echo $description; ?></textarea></td>
  </tr>
  <tr>
    <td><label>Name / URL:</label></td>
    <td><input type="text" name="video_name" id="video_name" value="<?php echo $image; ?>"> </td>
  </tr>
  <tr>
    <td><label>Category:</label></td>
    <td><select name="id_gallery_cat[<?php echo $id_photo; ?>]" id="id_gallery_cat" class="required">
	<?php echo $galCategory; ?></select></td>
  </tr>
  
  <tr>
    <td>Is Active:</td>
    <td><label><input type="checkbox" name="show[<?php echo $id_photo; ?>]" <?php echo $published; ?> class="radio"/> (Yes / No) </label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><br><input type="submit" value="SAVE CHANGES" name="submit" id="edit_photo_submit" />
	<input type="hidden" name="formname" value="edit_file_single" />
	<input type="hidden" name="redirect" value="home.php?d=<?php echo $dir; //$ref_page; ?>" />
	<input type="hidden" name="id_photo" value="<?php echo $id_photo; ?>" />
	</td>
	<td>&nbsp;</td>
  </tr>
</table>


		</form>
		</div>
<?php		
}

?>