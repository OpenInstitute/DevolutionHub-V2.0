<div style="padding:2px 2px 10px; text-align:right; font-size:13px; font-weight:bold;"> <a href="adm_menus.php?d=<?php echo $dir; ?>&op=new"  class="btn btn-danger txtwhite">[ Add New ]</a> </div>
<?php

//displayArray($admin_portal);
//where `".$pdb_prefix."dt_menu`.`id_portal`='$adm_portal_id'

		  $sqList = "SELECT  `".$pdb_prefix."dt_menu`.`id`, case when trim(`".$pdb_prefix."dt_menu`.`title_alias`) <>'' then concat_ws(' / ', `".$pdb_prefix."dt_menu`.`title`, `".$pdb_prefix."dt_menu`.`title_alias`) else `".$pdb_prefix."dt_menu`.`title` end as `title`, `".$pdb_prefix."dt_menu`.`id_section`, `dhub_dd_menu_type`.`title` as `category type`, `".$pdb_prefix."dt_menu 1`.`title` AS `parent`, case when `".$pdb_prefix."dt_menu`.`link` ='' then `dhub_dd_sections`.`link` else `".$pdb_prefix."dt_menu`.`link` end as `link`,   `dhub_dd_sections`.`title` AS `section`, COUNT(`dhub_dt_content_parent`.`id_content`) AS `items` ,  `".$pdb_prefix."dt_menu`.`seq` as `pos.`,  `".$pdb_prefix."dt_menu`.`published` as `active` , `".$pdb_prefix."dt_menu`.`id_parent1`  FROM    ((((`".$pdb_prefix."dt_menu` LEFT JOIN `dhub_dd_menu_type` ON `".$pdb_prefix."dt_menu`.`id_type_menu`=`dhub_dd_menu_type`.`id`) LEFT JOIN `dhub_dd_sections` ON `".$pdb_prefix."dt_menu`.`id_section`=`dhub_dd_sections`.`id`) LEFT JOIN `dhub_dt_menu_parent` ON `".$pdb_prefix."dt_menu`.`id`=`dhub_dt_menu_parent`.`id_menu` and `dhub_dt_menu_parent`.`id_portal` = `".$pdb_prefix."dt_menu`.`id_portal` ) LEFT JOIN `".$pdb_prefix."dt_menu` `".$pdb_prefix."dt_menu 1` ON `dhub_dt_menu_parent`.`id_parent`=`".$pdb_prefix."dt_menu 1`.`id`)  LEFT JOIN `dhub_dt_content_parent`  ON (`dhub_dt_menu`.`id` = `dhub_dt_content_parent`.`id_parent`) GROUP BY `dhub_dt_menu`.`id`  order by  `dhub_dd_menu_type`.`id`, `".$pdb_prefix."dt_menu`.`seq` ASC , `".$pdb_prefix."dt_menu`.`id_parent1`;";  
		  //echo $sqList;	
		  echo $m2_data->getData($sqList,"adm_menus.php?d=$dir&");
		  

?>
