<div style="padding:5px; text-align:right; font-size:14px; font-weight:bold;"> <a href="adm_gallery_albums.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000"></a> </div>
<?php

	  
	  $sqList = "SELECT 
      `dhub_dt_content`.`id`, DATE_FORMAT(`dhub_dt_content`.`date_created`,'%b %d, %Y') AS `date posted`, `dhub_dt_content`.`title`, `dhub_dt_menu`.`title` AS `parent`, Count(`dhub_dt_gallery_photos_parent`.`id_photo`) AS `pics`, `dhub_dt_content`.`published` AS `visible`
   FROM 
      (((`dhub_dt_content` INNER JOIN `dhub_dt_content_parent` ON `dhub_dt_content`.`id`=`dhub_dt_content_parent`.`id_content`) LEFT JOIN `dhub_dt_gallery_photos_parent` ON `dhub_dt_content`.`id`=`dhub_dt_gallery_photos_parent`.`id_content`) INNER JOIN `dhub_dt_menu` ON `dhub_dt_menu`.`id`=`dhub_dt_content_parent`.`id_parent`) 
   GROUP BY 
      `dhub_dt_content`.`id`, `dhub_dt_content`.`date_created`, `dhub_dt_content`.`title`, `dhub_dt_content`.`published`, `dhub_dt_content`.`yn_gallery`, `dhub_dt_content`.`id_portal`
   HAVING 
      (`dhub_dt_content`.`yn_gallery` =1)  or Count(`dhub_dt_gallery_photos_parent`.`id_photo`) > 0 
   ORDER BY 
      `dhub_dt_content`.`date_created` DESC";
	  
	  
		 echo $m2_data->getData($sqList,"adm_gallery_albums.php?d=$dir&");
		  

?>
