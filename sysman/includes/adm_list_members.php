<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;">  &nbsp;</div>
<?php
  
  $sqList = "SELECT `dhub_reg_users`.`id`, `dhub_reg_users`.`date_record` as `date` , `dhub_reg_users_type`.`title` AS `type` , concat_ws(' ',`dhub_reg_users`.`firstname`, `dhub_reg_users`.`lastname`) as `contact`  , `dhub_reg_countries`.`country` ,  `dhub_reg_users`.`email` ,  `dhub_reg_users`.`phone` ,`dhub_reg_users`.`confirm` as `cnfmd`, `dhub_reg_users`.`published` as `active` FROM
    `dhub_reg_users`
	LEFT JOIN `dhub_reg_users_type` 
        ON (`dhub_reg_users`.`id_user_type` = `dhub_reg_users_type`.`id`)
    INNER JOIN `dhub_reg_countries` 
        ON (`dhub_reg_users`.`country` = `dhub_reg_countries`.`id`)  where `dhub_reg_users`.`password` <> '' or `dhub_reg_users`.`ac_type` = 'm';";


  echo $m2_data->getDataFormed($sqList,"adm_users_reg.php?d=$dir&");
		  

?>
