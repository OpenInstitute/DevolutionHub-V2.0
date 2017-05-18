<?php

include('../classes/cls.constants.php');

if(isset($_REQUEST['idp'])){
	$id=$_REQUEST['idp'];
	}else { $id=$_REQUEST['id']; }

if($id)
{
	
	$sqdata="SELECT
    `dhub_dt_gallery_photos`.`id`
    , `dhub_dt_gallery_photos_parent`.`id_content`
    , `dhub_dt_gallery_photos`.`filename`
    , `dhub_dt_gallery_photos`.`title`
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
			
				$id_photo			= $cndata[0];
				$id_content			= $cndata[1];
				$title				= trim(html_entity_decode(stripslashes($cndata[3])));
				
				$image				= trim(html_entity_decode(stripslashes($cndata[2])));
				$smallpic_insert 	= strrpos($image , ".");
				$smallpic			= substr_replace($image, '_t.', $smallpic_insert, 1);
				
				//echo file_exists(UPL_GALLERY.$smallpic) . "rage"; exit;
				if (!file_exists(DISP_GALLERY.$smallpic)) { $smallpic = $image; }
				
				$image_title		= ''; //smartTruncateNew($image, 10, "", "...", "no");
				
				$image_disp			= '<img src="'.DISP_GALLERY.$smallpic.'" alt="" /><br>'.$image_title.'';
				
				$gallery 	.= '<li>'.$image_disp.'</li>';
			}
		}
	echo $gallery;
}

//echo $_REQUEST['idp'];
?>
