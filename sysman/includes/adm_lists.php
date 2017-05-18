<div style="padding:5px; text-align:right; font-size:14px; font-weight:bold;"> <a href="hforms.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ ADD NEW ]</a> </div>
<?php
//echo $dir;

if($dir == 'menus')
{	  
	 /*$sqList = "SELECT
    `oc_dt_menu`.`menu_id` as `id`
    , `oc_dt_menu`.`menu_title` AS `title`
    , `oc_dt_conf_sections`.`section_title` AS `section`
    , `oc_dt_conf_menu_type`.`menutype` AS `menu_type`
    , `oc_dt_menu`.`menu_href` as `menu_link`
    , `oc_dt_conf_sections`.`section_link`
    , `oc_dt_menu`.`seq` AS `pos.`
    , `oc_dt_menu`.`published` AS `active`
FROM
    `oc_dt_menu`
    LEFT JOIN `oc_dt_conf_sections` 
        ON (`oc_dt_menu`.`id_section` = `oc_dt_conf_sections`.`section_id`)
    LEFT JOIN `oc_dt_conf_menu_type` 
        ON (`oc_dt_menu`.`id_type_menu` = `oc_dt_conf_menu_type`.`menutype_id`)
ORDER BY `oc_dt_menu`.`id_type_menu` ASC, `oc_dt_menu`.`seq` ASC;"; */
	
	 $sqList = "SELECT  `".$pdb_prefix."dt_menu`.`id`, case when trim(`".$pdb_prefix."dt_menu`.`title_alias`) <>'' then concat_ws(' / ', `".$pdb_prefix."dt_menu`.`title`, `".$pdb_prefix."dt_menu`.`title_alias`) else `".$pdb_prefix."dt_menu`.`title` end as `title`, `".$pdb_prefix."dt_menu`.`id_section`, `dhub_dd_menu_type`.`title` as `category type`, `".$pdb_prefix."dt_menu 1`.`title` AS `parent`, case when `".$pdb_prefix."dt_menu`.`link` ='' then `dhub_dd_sections`.`link` else `".$pdb_prefix."dt_menu`.`link` end as `link`,   `dhub_dd_sections`.`title` AS `section`, COUNT(`dhub_dt_content_parent`.`id_content`) AS `items` ,  `".$pdb_prefix."dt_menu`.`seq` as `pos.`,  `".$pdb_prefix."dt_menu`.`published` as `active` , `".$pdb_prefix."dt_menu`.`id_parent1`  FROM    ((((`".$pdb_prefix."dt_menu` LEFT JOIN `dhub_dd_menu_type` ON `".$pdb_prefix."dt_menu`.`id_type_menu`=`dhub_dd_menu_type`.`id`) LEFT JOIN `dhub_dd_sections` ON `".$pdb_prefix."dt_menu`.`id_section`=`dhub_dd_sections`.`id`) LEFT JOIN `dhub_dt_menu_parent` ON `".$pdb_prefix."dt_menu`.`id`=`dhub_dt_menu_parent`.`id_menu` and `dhub_dt_menu_parent`.`id_portal` = `".$pdb_prefix."dt_menu`.`id_portal` ) LEFT JOIN `".$pdb_prefix."dt_menu` `".$pdb_prefix."dt_menu 1` ON `dhub_dt_menu_parent`.`id_parent`=`".$pdb_prefix."dt_menu 1`.`id`)  LEFT JOIN `dhub_dt_content_parent`  ON (`dhub_dt_menu`.`id` = `dhub_dt_content_parent`.`id_parent`) GROUP BY `dhub_dt_menu`.`id`  order by  `dhub_dd_menu_type`.`id`, `".$pdb_prefix."dt_menu`.`seq` ASC , `".$pdb_prefix."dt_menu`.`id_parent1`;";  
	  echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}

elseif($dir == 'articles')
{	  
	/*$sqList = "SELECT
    `oc_dt_content`.`content_id` as `id`
    , `oc_dt_content`.`content_created` AS `item_date`
    , `oc_dt_content`.`content_title` AS `title`
    , `oc_dt_menu`.`menu_title` AS `parent`
    , `oc_dt_conf_sections`.`section_title` AS `section`
    , `oc_dt_content`.`seq` AS `pos.`
    , `oc_dt_content`.`published` AS `active`
FROM
    `oc_dt_content`
    LEFT JOIN `oc_dt_content_parent` 
        ON (`oc_dt_content`.`content_id` = `oc_dt_content_parent`.`content_id`)
    INNER JOIN `oc_dt_conf_sections` 
        ON (`oc_dt_content`.`id_section` = `oc_dt_conf_sections`.`section_id`)
    LEFT JOIN `oc_dt_menu` 
        ON (`oc_dt_content_parent`.`menu_id` = `oc_dt_menu`.`menu_id`)
ORDER BY `item_date` DESC, `title` ASC;";*/
	
	$sqList = "SELECT `dhub_dt_content`.`id`
	, `dhub_dt_content`.`id_section`
	, `dhub_dt_content`.`date_created` AS `item date`
	, case when (`dhub_dt_content`.`title_sub`<>'') then concat_ws(' | ',`dhub_dt_content`.`title`, `dhub_dt_content`.`title_sub`) else `dhub_dt_content`.`title` end as `title`
	, `dhub_dt_menu`.`title` AS `parent link`
	, `dhub_dd_sections`.`title` AS `section`
	, `dhub_dt_content`.`id_section`	
	
	, `dhub_dt_content`.`seq` as `pos.`	
	, `dhub_dt_content`.`published` as `show`
	FROM (((`dhub_dt_content` LEFT JOIN `dhub_dt_content_parent` ON `dhub_dt_content`.`id`=`dhub_dt_content_parent`.`id_content`) 
	LEFT JOIN `dhub_dt_menu` ON `dhub_dt_content_parent`.`id_parent`=`dhub_dt_menu`.`id`) 
	INNER JOIN `dhub_dd_sections` ON `dhub_dt_content`.`id_section`=`dhub_dd_sections`.`id`) 	
	
 ORDER BY `dhub_dt_content`.`date_created` DESC, `dhub_dt_content`.`title` ";
	  
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}

elseif($dir == 'events')
{	  
	 $sqList = "SELECT
    `dhub_dt_content`.`id`
    , MIN(`dhub_dt_content_dates`.`date`) AS `date`
    , `".$pdb_prefix."dt_content`.`title`
	, `".$pdb_prefix."dd_sections`.`title` AS `section`
    , `".$pdb_prefix."dt_content`.`arr_extras` AS `location`
	, case when `".$pdb_prefix."dt_content`.`id_owner` > 0 then concat('USER:: ',`".$pdb_prefix."reg_account`.`email`)
	      else 'ADMIN' end as `posted by`
	, `".$pdb_prefix."dt_content`.`approved`
    , `".$pdb_prefix."dt_content`.`published` AS `active`
FROM
    `dhub_dt_content_dates`
    RIGHT JOIN `".$pdb_prefix."dt_content` ON (`dhub_dt_content_dates`.`id_content` = `".$pdb_prefix."dt_content`.`id` and `dhub_dt_content_dates`.`id_portal` = `".$pdb_prefix."dt_content`.`id_portal`) 
	INNER JOIN `".$pdb_prefix."dd_sections` ON `".$pdb_prefix."dt_content`.`id_section`=`".$pdb_prefix."dd_sections`.`id`
	LEFT JOIN `".$pdb_prefix."reg_account` ON (`".$pdb_prefix."dt_content`.`id_owner` = `".$pdb_prefix."reg_account`.`account_id`)
	
	where `".$pdb_prefix."dt_content`.`id_section` = '6' or `".$pdb_prefix."dt_content`.`id_section` = '7'  		
GROUP BY `dhub_dt_content_dates`.`id_content`, `".$pdb_prefix."dt_content`.`title`, `".$pdb_prefix."dt_content`.`id_portal`  
 HAVING `".$pdb_prefix."dt_content`.`id_portal` = '$adm_portal_id'  
ORDER BY `dhub_dt_content_dates`.`date` DESC ;";
	  
	  
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}

elseif($dir == 'resources')
{	  
	/* $sqList = "SELECT
    `oc_dt_resources`.`resource_id` AS `id`
    , `oc_dt_resources`.`date_created` AS `posted`
    , `oc_dt_resources`.`resource_title` AS `title`
    , `oc_dt_resources`.`resource_file` AS `filename`
    , `oc_dt_menu`.`menu_title` AS `parent`
    , `oc_county`.`county`
    , `oc_dt_resources`.`published` AS `active`
    , `oc_dt_resources`.`resource_type`
FROM
    `oc_dt_resources`
    LEFT JOIN `oc_dt_resources_parent` 
        ON (`oc_dt_resources`.`resource_id` = `oc_dt_resources_parent`.`resource_id`)
    LEFT JOIN `oc_dt_menu` 
        ON (`oc_dt_resources_parent`.`menu_id` = `oc_dt_menu`.`menu_id`)
    LEFT JOIN `oc_county` 
        ON (`oc_dt_resources_parent`.`county_id` = `oc_county`.`county_id`)
ORDER BY `id` DESC;";*/
	  
	  $sqList = "SELECT
    `".$pdb_prefix."dt_downloads`.`resource_id` as `id`
    , `".$pdb_prefix."dt_downloads`.`date_created` AS `posted`
    , `".$pdb_prefix."dt_downloads`.`resource_title` as `title`
    
	, `".$pdb_prefix."dt_downloads`.`county` 	
	, `".$pdb_prefix."dt_downloads`.`content_type` as `category` 	
	, case when `".$pdb_prefix."dt_downloads`.`posted_by` > 0 then concat('USER:: ',`".$pdb_prefix."reg_account`.`email`)
	      else 'ADMIN' end as `posted by`		   
    , `".$pdb_prefix."dt_downloads`.`status` 
   
FROM
    `".$pdb_prefix."dt_downloads`
    LEFT JOIN `".$pdb_prefix."dt_downloads_parent` 
        ON (`".$pdb_prefix."dt_downloads`.`resource_id` = `".$pdb_prefix."dt_downloads_parent`.`resource_id`)
    LEFT JOIN `".$pdb_prefix."dt_menu` 
        ON (`".$pdb_prefix."dt_downloads_parent`.`id_menu` = `".$pdb_prefix."dt_menu`.`id`)
    LEFT JOIN `".$pdb_prefix."dt_content` 
        ON (`".$pdb_prefix."dt_downloads_parent`.`id_content` = `".$pdb_prefix."dt_content`.`id`)
	LEFT JOIN `".$pdb_prefix."reg_account` 
        ON (`".$pdb_prefix."dt_downloads`.`posted_by` = `".$pdb_prefix."reg_account`.`account_id`)
GROUP BY `".$pdb_prefix."dt_downloads`.`resource_id`
ORDER BY `".$pdb_prefix."dt_downloads`.`date_updated` DESC;";
	
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}





elseif($dir == 'gallery')
{	  
	 $sqList = "SELECT
    `dhub_dt_gallery_photos`.`id`
    , `dhub_dt_gallery_photos`.`date_modify` AS `date`
    , `dhub_dt_gallery_photos`.`title`
	, CASE WHEN `dhub_dt_gallery_photos_parent`.`id_link` > 0 THEN CONCAT('[MENU] ',`dhub_dt_menu`.`title`)
	       WHEN `dhub_dt_gallery_photos_parent`.`id_content` > 0 THEN CONCAT('[CONT] ',`dhub_dt_content`.`title`)
		   ELSE NULL END AS `parent item`
	, `dhub_dt_gallery_category`.`gall_path`	   
	, `dhub_dt_gallery_photos`.`filename` 
    , CASE WHEN `dhub_dt_gallery_photos`.`filetype` = 'p' THEN CONCAT(`dhub_dt_gallery_category`.`title`,' (pic)')
		   ELSE CONCAT(`dhub_dt_gallery_category`.`title`,' (vid)')  END AS `category`
    , `dhub_dt_gallery_photos`.`published` AS `active`
	
FROM
    `dhub_dt_gallery_photos`
    LEFT JOIN `dhub_dt_gallery_photos_parent` 
        ON (`dhub_dt_gallery_photos`.`id` = `dhub_dt_gallery_photos_parent`.`id_photo`)
    LEFT JOIN `dhub_dt_gallery_category` 
        ON (`dhub_dt_gallery_photos`.`id_gallery_cat` = `dhub_dt_gallery_category`.`id`)
    LEFT JOIN `dhub_dt_content` 
        ON (`dhub_dt_gallery_photos_parent`.`id_content` = `dhub_dt_content`.`id`)
    LEFT JOIN `dhub_dt_menu` 
        ON (`dhub_dt_menu`.`id` = `dhub_dt_gallery_photos_parent`.`id_link`)
ORDER BY `date` DESC; "; 
	  
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}




elseif($dir == 'contacts directory')
{
$sqList = "SELECT
    `dhub_reg_account`.`account_id` as `id`
	, concat_ws(' ',`dhub_reg_account`.`namefirst`, `dhub_reg_account`.`namelast`) as `contact`
    , `dhub_reg_cats`.`title` AS `category`
    , `dhub_reg_account`.`email`
    , `dhub_reg_account`.`phone`
    , `dhub_reg_account`.`date_record` AS `date`
    , `dhub_reg_account`.`country`
    , `dhub_reg_account`.`published` AS `active`
FROM
    `dhub_reg_account`
    LEFT JOIN `dhub_reg_cats_links` 
        ON (`dhub_reg_account`.`account_id` = `dhub_reg_cats_links`.`account_id`)
    LEFT JOIN `dhub_reg_cats` 
        ON (`dhub_reg_cats_links`.`id_category` = `dhub_reg_cats`.`id_category`)
ORDER BY `date` DESC;";
	
	echo $m2_data->getData($sqList,"hforms.php?d=$dir&");

}



elseif($dir == 'registered accounts' or $dir == 'member accounts')
{
	/*, DATE_FORMAT(`dhub_reg_account`.`date_created`, '%b%e%Y') AS `ev_date`*/
	$sqList = "SELECT
    `dhub_reg_account`.`account_id` as `id`
	, `dhub_reg_account`.`date_record` AS `date`	
	, concat_ws(' ',`dhub_reg_account`.`namefirst`, `dhub_reg_account`.`namelast`) as `name`
    , `dhub_reg_account`.`email` as `email address`
    , `dhub_reg_account`.`phone`    
    , `dhub_reg_account`.`country`
	, `dhub_reg_groups`.`group_title` as `user type`
	, `dhub_conf_organizations`.`organization`
	, `dhub_reg_account`.`uservalid` AS `approved`
    , `dhub_reg_account`.`published` AS `active`
FROM
    `dhub_reg_account`
    LEFT JOIN `dhub_reg_cats_links` ON (`dhub_reg_account`.`account_id` = `dhub_reg_cats_links`.`account_id`)
	LEFT JOIN `dhub_conf_organizations`   ON (`dhub_reg_account`.`organization_id` = `dhub_conf_organizations`.`organization_id`)
	LEFT JOIN `dhub_reg_groups` ON (`dhub_reg_account`.`group_id` = `dhub_reg_groups`.`group_id`) 
	GROUP BY `dhub_reg_account`.`account_id`		
ORDER BY `dhub_reg_account`.`date_record` DESC;"; //WHERE (`dhub_reg_cats_links`.`id_category` =2)
	
	echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}



elseif($dir == 'organizations')
{	  
	 $sqList = "SELECT
    `dhub_conf_organizations`.`organization_id` as `id`
	, `dhub_conf_organizations`.`date_update` as `dated`
    , `dhub_conf_organizations`.`organization` as `title`
    , `dhub_conf_organizations`.`organization_website` as `website`
	, `dhub_conf_organizations`.`organization_phone` as `phone`
	, `dhub_conf_organizations`.`organization_email` as `org_email`
    , concat_ws(' ', `dhub_reg_account`.`namefirst` , `dhub_reg_account`.`namelast`) as `contact`    
    , `dhub_conf_organizations`.`is_partner` as `partner`
    , `dhub_conf_organizations`.`published` as `active`
FROM
    `dhub_conf_organizations`
    LEFT JOIN `dhub_reg_account` ON (`dhub_conf_organizations`.`contact_id` = `dhub_reg_account`.`account_id`)
ORDER BY `dhub_conf_organizations`.`organization_id` DESC;";
	  
	  
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}




elseif($dir == 'feedback posts')
{	  
	 $sqList = " SELECT `id`,DATE_FORMAT(`date_record` ,'%b %d, %Y') as `date posted`, `name` as `sender`, `email`, `phone`, `subject`
   FROM  `dhub_dt_feedback` order by `date_record` desc"; 
	 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}



elseif($dir == 'locations')
{	  
	 $sqList = "SELECT
    `location_id`
    , `name` AS `location_name`
    , `lon` AS `longitude`
    , `lat` AS `latitude`
	, `published` as `visible`
FROM
    `oc_app_location`;"; 
	  
	  
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}



elseif($dir == 'ministries')
{	  
	 $sqList = "SELECT
    `oc_app_ministry`.`ministry_id`
    , `oc_app_ministry`.`name`
    , COUNT(`oc_app_project`.`project_id`) AS `num_projects`
FROM
    `oc_app_ministry`
    LEFT JOIN `oc_app_project` 
        ON (`oc_app_ministry`.`ministry_id` = `oc_app_project`.`ministry_id`)
GROUP BY `oc_app_ministry`.`ministry_id`;"; 
	  
	  
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}



?>
