<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;">  </div>
<?php


		  $sqList = " SELECT 
      `id`,DATE_FORMAT(`date_record` ,'%b %d, %Y') as `date posted`, `name` as `sender`, `email`, `phone`, `subject`
   FROM  `dhub_dt_feedback` order by `date_record` desc"; 
		
		  echo $m2_data->getData($sqList,"adm_feedback.php?d=$dir&");
		  

?>
