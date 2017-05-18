<div style="padding:5px; text-align:right; font-size:14px; font-weight:bold;"> <a href="hforms.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ ADD NEW ]</a> </div>
<?php
//echo $dir;

if($dir == 'projects')
{	  
	 $sqList = "SELECT
    `dhub_app_project`.`project_id` AS `id`
    , `dhub_app_project`.`pname` AS `name`
	, `dhub_app_pillar`.`title` AS `pillar`    
    , `dhub_app_sector`.`title` AS `sector`
    , `dhub_app_ministry`.`name` AS `ministry`
    , `dhub_app_project`.`implementing_status` AS `status`
	, COUNT(`dhub_app_project_component`.`component_id`) AS `num_components`
    , `dhub_app_project`.`published` AS `visible`
FROM
    `dhub_app_project`
    LEFT JOIN `dhub_app_sector` 
        ON (`dhub_app_project`.`sector_id` = `dhub_app_sector`.`sector_id`)
    LEFT JOIN `dhub_app_ministry` 
        ON (`dhub_app_project`.`ministry_id` = `dhub_app_ministry`.`ministry_id`)
    LEFT JOIN `dhub_app_pillar` 
        ON (`dhub_app_project`.`pillar_id` = `dhub_app_pillar`.`pillar_id`)
	LEFT JOIN `dhub_app_project_component` 
        ON (`dhub_app_project`.`project_id` = `dhub_app_project_component`.`project_id`)
	GROUP BY `dhub_app_project`.`project_id`;"; 
	  
	  
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}

elseif($dir == 'project_components')
{	  
	 $sqList = "SELECT
    `dhub_app_project_component`.`component_id`
    , `dhub_app_project_component`.`cname` AS `name`
    , `dhub_app_project`.`pname` AS `project_name`
    , `dhub_app_project_component`.`a_name` AS `agency`
    , `dhub_app_project_component`.`implementing_status` AS `status`
    , `dhub_app_project_component`.`published` AS `visible`
FROM
    `dhub_app_project_component`
    LEFT JOIN `dhub_app_project` 
        ON (`dhub_app_project_component`.`project_id` = `dhub_app_project`.`project_id`);"; 
	  
	  
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}

elseif($dir == 'pillars')
{	  
	 $sqList = "SELECT
    `dhub_app_pillar`.`pillar_id` AS `id`
    , `dhub_app_pillar`.`title`
    , `dhub_app_pillar`.`description`
    , COUNT(DISTINCT `dhub_app_project`.`sector_id`) AS `num_sectors`
	, COUNT(DISTINCT `dhub_app_project`.`project_id`) AS `num_projects`
FROM
    `dhub_app_pillar`
    INNER JOIN `dhub_app_project` 
        ON (`dhub_app_pillar`.`pillar_id` = `dhub_app_project`.`pillar_id`)
GROUP BY `id`;"; 
	  
	  
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}


elseif($dir == 'sectors')
{	  
	 $sqList = "SELECT
    `dhub_app_sector`.`sector_id`
    , `dhub_app_sector`.`title`
	, `dhub_app_sector`.`description`
    , COUNT(DISTINCT `dhub_app_project`.`project_id`) AS `num_projects`
	, `dhub_app_sector`.`published` as `visible`
FROM
    `dhub_app_sector`
    LEFT JOIN `dhub_app_project` 
        ON (`dhub_app_sector`.`sector_id` = `dhub_app_project`.`sector_id`)
GROUP BY `dhub_app_sector`.`sector_id`
ORDER BY `dhub_app_sector`.`seq`, `dhub_app_sector`.`title` ASC;"; 
	  
	  
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
    `dhub_app_location`;"; 
	  
	  
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}



elseif($dir == 'ministries')
{	  
	 $sqList = "SELECT
    `dhub_app_ministry`.`ministry_id`
    , `dhub_app_ministry`.`name`
    , COUNT(`dhub_app_project`.`project_id`) AS `num_projects`
FROM
    `dhub_app_ministry`
    LEFT JOIN `dhub_app_project` 
        ON (`dhub_app_ministry`.`ministry_id` = `dhub_app_project`.`ministry_id`)
GROUP BY `dhub_app_ministry`.`ministry_id`;"; 
	  
	  
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
}



?>
