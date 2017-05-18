
<div style="padding:2px 2px 10px; text-align:right; font-size:13px; font-weight:bold;"> <a href="adm_articles.php?d=<?php echo $dir; ?>&op=new"  class="btn btn-danger txtwhite">[ Add New ]</a> </div>
<?php


	$sqList = "SELECT `dhub_dt_content`.`id`
	, `dhub_dt_content`.`id_section`
	, `dhub_dt_content`.`date_created` AS `item date`
	, case when (`dhub_dt_content`.`title_sub`<>'') then concat_ws(' | ',`dhub_dt_content`.`title`, `dhub_dt_content`.`title_sub`) else `dhub_dt_content`.`title` end as `title`
	, `dhub_dt_menu`.`title` AS `parent link`
	, `dhub_dd_sections`.`title` AS `section`
	, `dhub_dt_content`.`id_section`	
	
	, `dhub_dt_content`.`seq` as `pos.`	
	, `dhub_dt_content`.`published` as `show`
	FROM (((`dhub_dt_content` LEFT JOIN `dhub_dt_content_parent` ON `dhub_dt_content`.`id`=`dhub_dt_content_parent`.`id_content`) 
	LEFT JOIN `dhub_dt_menu` ON `dhub_dt_content_parent`.`id_parent`=`dhub_dt_menu`.`id`) 
	INNER JOIN `dhub_dd_sections` ON `dhub_dt_content`.`id_section`=`dhub_dd_sections`.`id`) 	
	
 ORDER BY `dhub_dt_content`.`date_created` DESC, `dhub_dt_content`.`title` ";
	//, `dhub_dt_content`.`seq` AS `pos.`, `dhub_dt_content`.`approved` AS `approved`
	//, `dhub_dt_content`.`published` AS `show`
	//, `dhub_dt_content`.`hits` AS `hits` , `dhub_dt_content`.`frontpage`	
	//echo $sqList;
	
	echo $m2_data->getData($sqList,"adm_articles.php?d=$dir&");
		  

?>
