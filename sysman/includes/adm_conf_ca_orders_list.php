<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;"><?php /*?> <a href="banners.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a><?php */?> &nbsp;</div>
<?php
$sqList = "SELECT
    `dhub_log_forms`.`post_id`
    , `dhub_log_forms`.`post_date` AS `dated`
    , `dhub_log_forms`.`post_type` AS `order_type`
    , `dhub_log_forms`.`item_id`
    , `dhub_log_forms`.`item_name` AS `order_item`
    , `dhub_log_forms`.`item_quantity` AS `qtty`
    , `dhub_log_forms`.`supplier_id`
    , `dhub_log_forms`.`supplier_name`
    , `dhub_log_forms`.`contact_name`
	, `dhub_reg_countries`.`country`
    , `dhub_log_forms`.`published` AS `visible`
    
FROM
    `dhub_log_forms`
    LEFT JOIN `afp_conf_person_list` 
        ON (`dhub_log_forms`.`contact_id` = `afp_conf_person_list`.`id`)
    LEFT JOIN `dhub_reg_countries` 
        ON (`afp_conf_person_list`.`country_iso` = `dhub_reg_countries`.`iso_code_2`)
WHERE (`dhub_log_forms`.`post_form` ='place_order') ORDER BY `dated` DESC ;";
				
echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
		  

?>
