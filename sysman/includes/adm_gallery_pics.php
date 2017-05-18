

<div style="padding:5px; text-align:right; font-size:14px; font-weight:bold;"> <a href="adm_gallery_singles.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a> </div>

<?php

		
	
	 $sqList = "SELECT
    `dhub_dt_gallery_photos`.`id`
    , `dhub_dt_gallery_photos`.`date_modify` AS `date`
    , `dhub_dt_gallery_photos`.`title`
	, CASE WHEN `dhub_dt_gallery_photos_parent`.`id_link` > 0 THEN CONCAT('[MENU] ',`dhub_dt_menu`.`title`)
	       WHEN `dhub_dt_gallery_photos_parent`.`id_content` > 0 THEN CONCAT('[CONT] ',`dhub_dt_content`.`title`)
		   ELSE NULL END AS `parent item`
	, `dhub_dt_gallery_category`.`gall_path`	   
	, `dhub_dt_gallery_photos`.`filename` 
    , CASE WHEN `dhub_dt_gallery_photos`.`filetype` = 'p' THEN CONCAT(`dhub_dt_gallery_category`.`title`,' (pic)')
		   ELSE CONCAT(`dhub_dt_gallery_category`.`title`,' (vid)')  END AS `category`
    , `dhub_dt_gallery_photos`.`published` AS `active`
	
FROM
    `dhub_dt_gallery_photos`
    LEFT JOIN `dhub_dt_gallery_photos_parent` 
        ON (`dhub_dt_gallery_photos`.`id` = `dhub_dt_gallery_photos_parent`.`id_photo`)
    LEFT JOIN `dhub_dt_gallery_category` 
        ON (`dhub_dt_gallery_photos`.`id_gallery_cat` = `dhub_dt_gallery_category`.`id`)
    LEFT JOIN `dhub_dt_content` 
        ON (`dhub_dt_gallery_photos_parent`.`id_content` = `dhub_dt_content`.`id`)
    LEFT JOIN `dhub_dt_menu` 
        ON (`dhub_dt_menu`.`id` = `dhub_dt_gallery_photos_parent`.`id_link`)
ORDER BY `date` DESC; "; 

		 echo $m2_data->getData($sqList,"adm_gallery_singles.php?d=$dir&");
		  

?>
