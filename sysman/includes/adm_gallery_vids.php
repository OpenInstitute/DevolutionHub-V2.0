<div style="padding:5px; text-align:right; font-size:14px; font-weight:bold;"> <a href="adm_gallery_singles.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a> </div>


<?php
	  
	  $sqList = "SELECT
    `dhub_dt_gallery_photos`.`id`
    , `dhub_dt_gallery_photos`.`date_posted` as `posted`
    , `dhub_dt_gallery_photos`.`title`
    , `dhub_dt_gallery_photos`.`filename` AS `video url`
    , `dhub_dt_gallery_category`.`title` AS `category`
    , `dhub_dt_gallery_photos`.`published` AS `active`
FROM
    `dhub_dt_gallery_photos`
    INNER JOIN `dhub_dt_gallery_category` 
        ON (`dhub_dt_gallery_photos`.`id_gallery_cat` = `dhub_dt_gallery_category`.`id`)
WHERE (`dhub_dt_gallery_photos`.`filetype` ='v')
ORDER BY `dhub_dt_gallery_photos`.`date_posted` DESC;";

	  // , `dhub_dt_gallery_photos`.`filetype`
	  //, `dhub_dt_menu`.`title` AS `parent link`
     //  , `dhub_dt_gallery_photos`.`seq` AS `pos.` 
		 echo $m2_data->getData($sqList,"adm_gallery_singles.php?d=$dir&");
		  

?>
