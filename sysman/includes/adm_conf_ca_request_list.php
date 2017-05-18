<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;"><?php /*?> <a href="banners.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a><?php */?> &nbsp;</div>
<?php
$sqList = "SELECT
    `dhub_reg_directory`.`id`
    , `dhub_reg_directory`.`date_record` AS `dated`
    , `dhub_reg_directory_category`.`title` AS `category`
    , `dhub_reg_directory`.`ac_organization` AS `organization_name`
    , `dhub_reg_directory`.`ac_country` AS `country`
    , `dhub_reg_directory`.`ac_contact_name` AS `contact`
    , `dhub_reg_directory`.`src_reference` AS `reference`
	, `dhub_reg_directory`.`src_public_items` as `item_count`
    , `dhub_reg_directory`.`published` AS `visible` 
FROM
    `dhub_reg_directory`
    INNER JOIN `dhub_reg_directory_category` 
        ON (`dhub_reg_directory`.`id_directory_cat` = `dhub_reg_directory_category`.`id`)
WHERE (`dhub_reg_directory`.`src_public` =1);";
				
echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
		  

?>
