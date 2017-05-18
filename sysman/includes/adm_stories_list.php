<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;"><?php /*?> <a href="banners.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a><?php */?> &nbsp;</div>
<?php
$sqList = "SELECT
    `dhub_reg_storyshare`.`id`
    , `dhub_reg_storyshare`.`date_record` AS `date`
    , `dhub_reg_storyshare`.`story_title` AS `title`
    , `dhub_reg_storyshare`.`user_name` as `posted by`
    , `dhub_reg_countries`.`country`
    , `dhub_reg_storyshare`.`confirmed` as `cnfmd`
    , `dhub_reg_storyshare`.`approved`
    , `dhub_reg_storyshare`.`approved_by`
    , `dhub_reg_storyshare`.`published` as `visible`
FROM
    `dhub_reg_storyshare`
    LEFT JOIN `dhub_reg_countries` 
        ON (`dhub_reg_storyshare`.`user_country` = `dhub_reg_countries`.`id`)
	ORDER BY `date` DESC;";
				
echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
		  

?>
