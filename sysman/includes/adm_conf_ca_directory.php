<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;"> <a href="hforms.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a><?php /*?><?php */?> &nbsp;</div>
<?php

if($dir == 'directory entries')
{	

	$sqList = "SELECT
    `dhub_reg_directory`.`id`
    , `dhub_reg_directory`.`ac_organization` AS `name`
    , `dhub_reg_directory`.`ac_country` AS `country`
    , `dhub_reg_directory`.`ac_speciality` AS `speciality`
    , COUNT(`dhub_reg_equipment_supplier`.`id_equipment`) AS `items`
    , CONCAT_WS(' ',`dhub_reg_directory`.`ac_phone`,`dhub_reg_directory`.`ac_contact_phone`) AS `contact`
    , `dhub_reg_directory`.`published` AS `visible`
FROM
    `dhub_reg_directory`
    LEFT JOIN `dhub_reg_equipment_supplier` 
        ON (`dhub_reg_directory`.`id` = `dhub_reg_equipment_supplier`.`id_directory`)

GROUP BY `dhub_reg_directory`.`id`;";	
		//WHERE (`dhub_reg_directory`.`id` >68)
	
	  echo $m2_data->getData($sqList,"hforms.php?d=$dir&");

}
elseif($dir == 'equipment entries')
{	

	$sqList = "SELECT
    `dhub_reg_equipment`.`id_equipment` AS `id`
    , `dhub_reg_equipment`.`eq_title` AS `title`
    , `dhub_dt_menu`.`title` AS `section`
    , `dhub_reg_directory_category`.`title` AS `category`
    , `dhub_reg_equipment`.`eq_handling_class` AS `handling`
    
    , `dhub_reg_equipment`.`published` AS `visible`
FROM
    `dhub_reg_equipment`
    INNER JOIN `dhub_reg_directory_category` 
        ON (`dhub_reg_equipment`.`id_category` = `dhub_reg_directory_category`.`id`)
    LEFT JOIN `dhub_dt_menu` 
        ON (`dhub_reg_directory_category`.`id_menu` = `dhub_dt_menu`.`id`)
	WHERE `dhub_reg_directory_category`.`cat_equipment` = 1 ;";
		//echo $sqList;		
	  echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
	//, `dhub_reg_equipment`.`eq_image` AS `image`
	
	
}
elseif($dir == 'cover crop entries')
{	

	$sqList = "SELECT
    `dhub_reg_equipment`.`id_equipment` AS `id`
    , `dhub_reg_equipment`.`eq_title` AS `title`
	, `dhub_reg_equipment`.`eq_other` AS `botanical_name`
    , `dhub_dt_menu`.`title` AS `section`
    , `dhub_reg_directory_category`.`title` AS `category`
    
    , `dhub_reg_equipment`.`published` AS `visible`
FROM
    `dhub_reg_equipment`
    INNER JOIN `dhub_reg_directory_category` 
        ON (`dhub_reg_equipment`.`id_category` = `dhub_reg_directory_category`.`id`)
    LEFT JOIN `dhub_dt_menu` 
        ON (`dhub_reg_directory_category`.`id_menu` = `dhub_dt_menu`.`id`)
	WHERE `dhub_reg_directory_category`.`cat_crop` = 1;";
	//, `dhub_reg_equipment`.`eq_image` AS `image`			
	  echo $m2_data->getData($sqList,"hforms.php?d=$dir&");

}


?>
