<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;"> <a href="adm_mform?d=<?php echo $dir; ?>&op=new" style="color:#FF0000"></a> </div>
<?php


	$sqList = "SELECT
    `id`
    , `date_record` AS `date`    
    , `form_title` AS `report type`
    , concat_ws(' ',`oc_firstname`, `oc_lastname`) as `contact`
    , `oc_email` AS `email`
	, `oc_phone` AS `phone` 
    , `entry_name` AS `offender`
    
FROM
    `dhub_oforms` WHERE `form_type` = 'Report';"; 
	//, `form_type` AS `category`
	//, `entry_ref` AS `reference`, `entry_industry` AS `industry` , `oc_school_name` AS `school`
    
	echo $m2_data->getData($sqList,'adm_mform.php?d='.$dir.'&');
		  

?>
