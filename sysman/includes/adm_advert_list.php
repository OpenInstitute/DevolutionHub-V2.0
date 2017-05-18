<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;"> <a href="adm_adverts.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a> </div>
<?php


	$sqList = "SELECT
    `dhub_dt_adv_items`.`id`
    , `dhub_dt_adv_items`.`title`
    , `dhub_dt_adv_items`.`client_name` as `client name`
    , `dhub_dt_adv_items`.`filename` AS `image`
    , `dhub_dt_adv_cats`.`title` AS `category`
    , `dhub_dt_adv_items`.`date_end` AS `expiry`
    , `dhub_dt_adv_items`.`published` AS `active`
    , `dhub_dt_adv_items`.`hits`
FROM
    `dhub_dt_adv_items`
    INNER JOIN `dhub_dt_adv_cats` 
        ON (`dhub_dt_adv_items`.`id_adv_cat` = `dhub_dt_adv_cats`.`id`);"; 
	//echo $sqList; //`subject` AS `category`, 
	
	echo $m2_data->getData($sqList,"adm_adverts.php?d=$dir&");
		  

?>
