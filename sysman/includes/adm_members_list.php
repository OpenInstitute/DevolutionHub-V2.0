<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;"> <a href="members.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a> </div>
<?php


		  $sqList = QRY_ADMIN_CONTENTLIST . " ORDER BY `dhub_dt_menu`.`title`, `dhub_dt_content`.`title`, `dhub_dt_content`.`date_modified` DESC "; 
		
		  echo $m2_data->getData($sqList,"articles.php?d=$dir&");
		  

?>
