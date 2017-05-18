<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;">  &nbsp;</div>
<?php
  
  $sqList = "SELECT
    `dhub_reg_users`.`id`
    , concat_ws(' ',`dhub_reg_users`.`firstname`, `dhub_reg_users`.`lastname`) as `contact`
	, `dhub_reg_users`.`email`
	, `dhub_reg_countries`.`country`
	 , `dhub_reg_users`.`phone`
	, MAX(`dhub_oforms_involvment`.`date_record`) AS `last petition`
    , COUNT(`dhub_oforms_involvment`.`id_user`) AS `items`    
FROM
    `dhub_oforms_involvment`
    INNER JOIN `dhub_reg_users` 
        ON (`dhub_oforms_involvment`.`id_user` = `dhub_reg_users`.`id`)
    INNER JOIN `dhub_reg_users_type` 
        ON (`dhub_reg_users`.`id_user_type` = `dhub_reg_users_type`.`id`)
    INNER JOIN `dhub_reg_countries` 
        ON (`dhub_reg_users`.`country` = `dhub_reg_countries`.`id`)
GROUP BY `dhub_reg_users`.`id`
ORDER BY `last petition` DESC;";	
  echo $m2_data->getDataFormed($sqList,"adm_forum_posts.php?d=$dir&");
		  

?>
