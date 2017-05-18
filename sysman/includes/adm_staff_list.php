<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;"> <a href="staff.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a> </div>
<?php
	  
	  $sqList = "SELECT    `id`, `empcode` as `code`, `empname` as `title`, `empdepartment` as `department`, `empposition` as `position`,`emptype` as `type`,  `email`, `published` as `show` FROM `dhub_k_users_new`   ORDER BY   `department` ASC, `title` ASC "; 
		  	
			
		  echo $m2_data->getData($sqList, "staff.php?d=$dir&", "", "issues");
		 		  

?>
