<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;"> <a href="adm_users_mailing.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a><?php /*?><?php */?> &nbsp;</div>
<?php
  
  
  $sqList = "SELECT `dhub_reg_users`.`id` , `dhub_reg_users`.`date_record` as `date` , concat_ws(' ',`dhub_reg_users`.`firstname`, `dhub_reg_users`.`lastname`) as `contact` , `dhub_reg_users`.`email` , `dhub_reg_countries`.`country` , `dhub_reg_users`.`organization` as `org.`, `dhub_reg_users`.`phone`    , `dhub_reg_users`.`published` as `active` FROM
    `dhub_reg_users`
    LEFT JOIN `dhub_reg_countries` 
        ON (`dhub_reg_users`.`country` = `dhub_reg_countries`.`id`)  where `dhub_reg_users`.`newsletter` = 1 or `dhub_reg_users`.`ac_type` = 'mail';";
		
  echo $m2_data->getDataFormed($sqList,"adm_users_mailing.php?d=$dir&");
		  

?>
