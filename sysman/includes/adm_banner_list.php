<div style="padding:5px; text-align:right; font-size:14px; font-weight:bold;"> <a href="adm_banners.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a> </div>
<?php
	  
	  $sqList = "SELECT 
      `dhub_dt_gallery_photos`.`id`, `dhub_dt_menu`.`title` AS `parent`, `dhub_dt_gallery_photos`.`title`, `dhub_dt_gallery_photos`.`filename` AS `image`, `dhub_dt_gallery_photos`.`date_modify` AS `modified`, `dhub_dt_gallery_photos`.`published` AS `show`, `dhub_dt_gallery_photos`.`seq` AS `pos.`
   FROM 
      (`dhub_dt_gallery_photos` INNER JOIN `dhub_dt_menu` ON `dhub_dt_gallery_photos`.`id_link`=`dhub_dt_menu`.`id`) 
   ORDER BY 
      `dhub_dt_gallery_photos`.`date_modify` DESC";
	  
	  
		 echo $m2_data->getData($sqList,"adm_banners.php?d=$dir&");
		  

?>
