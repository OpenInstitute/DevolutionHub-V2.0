
<div style="padding:2px 2px 10px; text-align:right; font-size:13px; font-weight:bold;"> <a href="adm_events.php?d=<?php echo $dir; ?>&op=new"  class="btn btn-danger txtwhite">[ Add New ]</a> </div>
<?php


	
	$sqList = "SELECT
    `dhub_dt_content`.`id`
    , MIN(`dhub_dt_content_dates`.`date`) AS `date`
    , `".$pdb_prefix."dt_content`.`title`
	, `".$pdb_prefix."dd_sections`.`title` AS `section`
    , `".$pdb_prefix."dt_content`.`arr_extras` AS `location`
	, case when `".$pdb_prefix."dt_content`.`id_owner` > 0 then concat('USER:: ',`".$pdb_prefix."reg_account`.`email`)
	      else 'ADMIN' end as `posted by`
	, `".$pdb_prefix."dt_content`.`approved`
    , `".$pdb_prefix."dt_content`.`published` AS `active`
FROM
    `dhub_dt_content_dates`
    RIGHT JOIN `".$pdb_prefix."dt_content` ON (`dhub_dt_content_dates`.`id_content` = `".$pdb_prefix."dt_content`.`id` and `dhub_dt_content_dates`.`id_portal` = `".$pdb_prefix."dt_content`.`id_portal`) 
	INNER JOIN `".$pdb_prefix."dd_sections` ON `".$pdb_prefix."dt_content`.`id_section`=`".$pdb_prefix."dd_sections`.`id`
	LEFT JOIN `".$pdb_prefix."reg_account` ON (`".$pdb_prefix."dt_content`.`id_owner` = `".$pdb_prefix."reg_account`.`account_id`)
	
	where `".$pdb_prefix."dt_content`.`id_section` = '6' or `".$pdb_prefix."dt_content`.`id_section` = '7'  		
GROUP BY `dhub_dt_content_dates`.`id_content`, `".$pdb_prefix."dt_content`.`title`, `".$pdb_prefix."dt_content`.`id_portal`  
 HAVING `".$pdb_prefix."dt_content`.`id_portal` = '$adm_portal_id'  
ORDER BY `dhub_dt_content_dates`.`date` DESC ;";
	
	//, `".$pdb_prefix."dt_content`.`arr_extras` AS `has booking`
	//echo $sqList;
	
	echo $m2_data->getData($sqList,"adm_events.php?d=$dir&");
		  

?>
