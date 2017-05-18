<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;"> <a href="adm_admins.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a> </div>
<?php


		  $sqList = "SELECT 
      `dhub_admin_accounts`.`admin_id` AS `id`, `dhub_admin_accounts`.`admin_fname` AS `name`, `dhub_admin_accounts`.`admin_uname` AS `username`, `dhub_admin_types`.`title` AS `type`, `dhub_admin_accounts`.`published` AS `active`
   FROM 
      (`dhub_admin_accounts` INNER JOIN `dhub_admin_types` ON `dhub_admin_accounts`.`admintype_id`=`dhub_admin_types`.`admintype_id`) where `dhub_admin_accounts`.`admin_id` <> 1 "; 
		
		  echo $m2_data->getData($sqList,"adm_admins.php?d=$dir&");
		  

?>
