<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;">  &nbsp;</div>
<?php
  
  $sqList = "SELECT
    `dhub_reg_users`.`id`
    , `dhub_reg_users_type`.`title` AS `account type`
    , concat_ws(' ',`dhub_reg_users`.`firstname`, `dhub_reg_users`.`lastname`) as `contact`
	, `dhub_reg_users`.`email`
	, `dhub_reg_countries`.`country`
	, `dhub_reg_users`.`phone`
	, MAX(`dhub_forum_posts`.`post_date`) AS `last contribution`
    , COUNT(`dhub_forum_posts`.`post_by`) AS `items`    
FROM
    `dhub_forum_users`
    INNER JOIN `dhub_reg_users` 
        ON (`dhub_forum_users`.`user_id` = `dhub_reg_users`.`id`)
    INNER JOIN `dhub_reg_users_type` 
        ON (`dhub_reg_users`.`id_user_type` = `dhub_reg_users_type`.`id`)
    INNER JOIN `dhub_reg_countries` 
        ON (`dhub_reg_users`.`country` = `dhub_reg_countries`.`id`)
    INNER JOIN `dhub_forum_posts` 
        ON (`dhub_reg_users`.`id` = `dhub_forum_posts`.`post_by`)
GROUP BY `dhub_reg_users`.`id`
ORDER BY `last contribution` DESC;";	
  echo $m2_data->getDataFormed($sqList,"adm_forum_posts.php?d=$dir&");
		  

?>
