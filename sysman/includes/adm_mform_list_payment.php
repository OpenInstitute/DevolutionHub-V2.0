<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;"> <a href="adm_mform.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000"></a> </div>
<?php


	$sqList = "SELECT
    `id`
    , `date_record` AS `date`
    , `form_type` AS `category`
    , `form_title` AS `type`
    , concat_ws(' ',`oc_firstname`, `oc_lastname`) as `contact`
    , `oc_email` AS `email`
    , `entry_ref` AS `reference`
    , `entry_amount` AS `amount`
FROM
    `dhub_oforms` WHERE `form_type` = 'Pay';"; 
	//, `entry_ref` AS `reference`
    
	echo $m2_data->getData($sqList,"adm_mform.php?d=$dir&");
		  

?>
