<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;">  </div>
<?php

/*SELECT 
      `id`,DATE_FORMAT(`date_record` ,'%b %d, %Y') as `date posted`, `name` as `sender`, `email`, `phone`, `subject`
   FROM  `dhub_dt_feedback` order by `date_record` desc*/
		  $sqList = "SELECT
    `id`
    , DATE_FORMAT(`date_record` ,'%b %d, %Y') as `date posted`
    , `regnum` AS `Register As`
    , `contactname` AS `name`
    , `contactphone` AS `phone`
    , `contactemail` AS `email address`
    , `orgname` AS `organization`
    , `contactjob` AS `job title`
FROM
    `dhub_reg_events_booking`  order by `date_record` desc;"; 
		
		  echo $m2_data->getData($sqList,"adm_registration.php?d=$dir&");
		  

?>
