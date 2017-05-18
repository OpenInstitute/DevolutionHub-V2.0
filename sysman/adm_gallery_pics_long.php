<?php

include('../classes/cls.constants.php');

 $id=$_REQUEST['id']; 

if($id)
{
	$sqdata="SELECT `id`, `id_content`, `filename`, `title`, `description`, `published`, `id_gallery_cat`, `filetype` FROM `dhub_dt_gallery_photos` WHERE  (`id_content` = $id)";
	
	$sqdata="SELECT
    `dhub_dt_gallery_photos`.`id`
    , `dhub_dt_gallery_photos_parent`.`id_content`
    , `dhub_dt_gallery_photos`.`filename`
    , `dhub_dt_gallery_photos`.`title`
	, `dhub_dt_gallery_photos`.`description`
	, `dhub_dt_gallery_photos`.`published`
	, `dhub_dt_gallery_photos`.`id_gallery_cat`
	, `dhub_dt_gallery_photos`.`filetype`
FROM
    `dhub_dt_gallery_photos`
    INNER JOIN `dhub_dt_gallery_photos_parent` 
        ON (`dhub_dt_gallery_photos`.`id` = `dhub_dt_gallery_photos_parent`.`id_photo`)
WHERE (`dhub_dt_gallery_photos_parent`.`id_content` = $id);";
	//echo $sqdata;
	
	$rsdata=$cndb->dbQuery($sqdata);
	$rsdata_count= $cndb->recordCount($rsdata);
	
	$gallery = '';
		if($rsdata_count>=1)
		{
			while($cndata= $cndb->fetchRow($rsdata))
			{
				$feat_lebo	="";
				$feat_chek	="";
				
				$id_photo			= $cndata[0];
				$id_content			= $cndata[1];
				$title				= trim(html_entity_decode(stripslashes($cndata[3])));
				$description				= trim(html_entity_decode(stripslashes($cndata[4])));
				$image				= trim(html_entity_decode(stripslashes($cndata[2])));
				$image_title		= $image; 
				//echo file_exists("".DISP_GALLERY.$image."");
				
				
				$smallpic_insert 	 = strrpos($image , ".");
				$smallpic			= substr_replace($image, '_t.', $smallpic_insert, 1);
				
				if(!file_exists(UPL_GALLERY.$smallpic)) { $smallpic = $image; }
				
				
				
				$id_galcat			= $cndata[6]; 
				$galCategory = $ddSelect->dropper_select("dhub_dt_gallery_category", "id", "title", $id_galcat);
				
				$galtype			= trim($cndata[7]);
				
				$published			= $cndata[5]; 
				if($published==1) {$published="checked ";} else {$published="";}
				
				
				
			if($galtype=='p') 
			{
				$filetype = 'Photo';
				if(strpos($image, '/')) {
					$path1 = DISP_IMAGES.$image; $path2 = $path1;
				} else { 
					$path1 = DISP_GALLERY.$image; $path2 = DISP_GALLERY.$smallpic;  }
				
		 		$image_disp	 = '<a class="vidPop" rel="gal_group" href="'.$path1.'"  title="'.$title.' -- '.$description.'">';
				$image_disp	.= '<img src="'.$path2.'" alt="" title="'.$image_title.'" />';
				$image_disp	.= '</a>';
				
			}
			elseif($galtype=='v') 
			{
				$filetype 		= 'Video';
				$v_insert 		= strrpos($image, '/');
				$v_pic			= substr($image, $v_insert);
				$v_code			= substr($image, $v_insert+1);
				
				$image_disp	 = '<a class="vidPop" href="http://www.youtube.com/v/'.$v_code.'?fs=1&amp;autoplay=1"  title="'.$title.'">';
				$image_disp	.= '<img src="http://img.youtube.com/vi'.$v_pic.'/mqdefault.jpg" alt="" />';
				$image_disp	.= '</a>';
				
					
			}	
			
			
				$gallery 	.= '<li><table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td rowspan="4">'.$image_disp.'
	<div style="margin-top:10px;"><em style="color:#f00;">('.$filetype.' - '.$id_photo.') </em><br><label>Active: <input type="checkbox" name="show['.$id_photo.']" '.$published.' class="radio"/> </label></div> 
	</td>
    <td>Caption:</td>
    <td>
	<input type="text" name="caption['.$id_photo.']" value="'.$title.'" style="width:230px" />
	<input type="hidden" name="image['.$id_photo.']" value="'.$image.'"/>
	<input type="hidden" name="galtype['.$id_photo.']" value="'.$galtype.'"/>
	
	</td>
  </tr>
  <tr>
    <td>Details:</td>
    <td><textarea name="desc['.$id_photo.']"  style="width:230px; height:40px"> '.$description.'</textarea></td>
  </tr>
  <tr>
    <td>Category:</td>
    <td><select name="id_gallery_cat['.$id_photo.']" style="width:236px;">'.$galCategory.'</select></td>
  </tr>
  <tr>
    <td>Name:</td>
    <td> '.$image.'</td>
  </tr>

</table></li>';
			/*<!--<label>Active: <input type="checkbox" name="show['.$id_photo.']" '.$published.' class="radio"/> </label> &nbsp;
	<label>Delete: <input type="checkbox" name="delete['.$id_photo.']" class="radio"/> </label>-->*/	
			}
		}
		else
		{
			$gallery = '<li> No Items </li>';
		}
	echo $gallery;
}
//echo $_REQUEST['idp'];
?>

