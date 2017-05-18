<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;"><?php /*?> <a href="banners.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a><?php */?> &nbsp;</div>
<?php
$sqList = "SELECT
    `dhub_pub_adverts`.`id_product` as `id`
    , `dhub_conf_types_data`.`conf_data_title` AS `category`
    , `dhub_pub_adverts`.`product_name` as `name`
    , `dhub_pub_adverts`.`date_record` AS `dated`
    , `dhub_pub_adverts`.`date_start` AS `start_date`
    , `dhub_pub_adverts`.`product_days` AS `days`
    , concat_ws(' ',`dhub_pub_adverts`.`contact_name_first`, `dhub_pub_adverts`.`contact_name_last`) as `contact`
    , `dhub_reg_countries`.`country`
    , `dhub_pub_adverts`.`expired` 
    , `dhub_pub_adverts`.`published` as `visible`
FROM
    `dhub_pub_adverts`
    INNER JOIN `dhub_conf_types_data` 
        ON (`dhub_pub_adverts`.`id_category` = `dhub_conf_types_data`.`conf_data_id`)
    LEFT JOIN `dhub_reg_countries` 
        ON (`dhub_pub_adverts`.`country` = `dhub_reg_countries`.`iso_code_2`)
ORDER BY `dated` DESC;";
				
echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
		  

?>
