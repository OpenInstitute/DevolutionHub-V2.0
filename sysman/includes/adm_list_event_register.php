<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;"><?php /*?> <a href="banners.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a><?php */?> &nbsp;</div>
<?php


		  $sqList = " SELECT 
      `id`, `date_record` AS `date`, `regnum` as `reg code`, `orgname` AS `organization`, `orgcountry` AS `country`, concat_ws(' ', `contacttitle`, `contactname`) as `contact`, `contactjob` as `job title`, `pay_type` AS `payment`, `participants_num` AS `entries`
   FROM 
      `sac_reg_booking`
   ORDER BY 
      `date` ASC "; //``contactemail` AS `email`, 
		  
		  $sqList = "SELECT
    `dhub_reg_events_booking`.`id`
    , `dhub_reg_events_booking`.`date_record` AS `reg date`
    , `dhub_dt_content`.`title` AS `event`
    , `dhub_reg_events_booking`.`regnum` AS `reg code`
    , `dhub_reg_events_booking`.`orgname` AS `organization`
    , `dhub_reg_countries`.`country`
    , concat_ws(', ',`dhub_reg_events_booking`.`contactname`, `dhub_reg_events_booking`.`contactjob`)  AS `contact`
    , `dhub_reg_events_booking`.`pay_type` AS `pay mode`
    , `dhub_reg_events_booking`.`participants_num` AS `entries`
    , `dhub_reg_events_booking`.`book_booth` AS `booth`
FROM
    `dhub_reg_events_booking`
    INNER JOIN `dhub_dt_content` 
        ON (`dhub_reg_events_booking`.`id_content` = `dhub_dt_content`.`id`)
    INNER JOIN `dhub_reg_countries` 
        ON (`dhub_reg_events_booking`.`country` = `dhub_reg_countries`.`id`)
ORDER BY `reg date` DESC;";		
		  echo $m2_data->getData($sqList,"adm_events_register.php?d=$dir&");
		  

?>
