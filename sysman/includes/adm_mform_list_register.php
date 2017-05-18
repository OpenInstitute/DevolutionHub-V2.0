<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;"> <a href="adm_mform?d=<?php echo $dir; ?>&op=new" style="color:#FF0000"></a> </div>
<?php


	$sqList__CLEAN = "SELECT
    `id`
    , `date_record` AS `date`
    , `form_title` AS `registration type`
    , concat_ws(' ',`oc_firstname`, `oc_lastname`) as `contact`
    , `oc_email` AS `email`    
	, `oc_phone` AS `phone`  
    , `entry_industry` AS `industry`	 
    , case when `form_title` = 'Professional' then `oc_organization` else concat_ws(' ',`entry_ref`, `oc_school_name`) end as `reference`
FROM
    `dhub_oforms` WHERE `form_type` = 'Register_As' ORDER BY `date_record` DESC;"; 
	//, `form_type` AS `category`
	//, `entry_ref` AS `reference`
	//, `entry_name` AS `ref name`
	//, `oc_school_name` AS `school`
    //, concat_ws(' ',`entry_ref`, `oc_school_name`) as `reference`
	
	
	
	$sqList = "SELECT
    `id`
    , `date_record` AS `date`
    , `form_title` AS `registration type`
    , concat_ws(' ',`oc_firstname`, `oc_lastname`) as `contact`
    , `oc_email` AS `email`    
	, `oc_phone` AS `phone`   
    , case when `form_title` = 'Professional' then `oc_organization` else concat_ws(' ',`entry_ref`, `oc_school_name`) end as `reference`
FROM
    `dhub_oforms` WHERE `form_type` = 'Register_As' ORDER BY `date_record` DESC;";	// limit 0, 10
	
	echo $m2_data->getDataFormed($sqList,"adm_mform.php?d=$dir&");
		  

?>
<?php //echo count($_SESSION['report_values']); ?>