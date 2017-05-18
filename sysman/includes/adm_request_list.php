<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;">  </div>
<?php


  $sqList = " SELECT 
`id`, DATE_FORMAT(`date_record` ,'%b %d, %Y') as `date posted`, concat_ws(' ',`qf_firstname`, `qf_lastname`) as `sender`, `qf_enquiry_topic` as `title`, `qf_organization` as `organization`, `qf_email` as `email`
FROM 
`dhub_dt_service_request` "; 
		
		  echo $m2_data->getData($sqList,"adm_requests.php?d=$dir&");
		  

?>
