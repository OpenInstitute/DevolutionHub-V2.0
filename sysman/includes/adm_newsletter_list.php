<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;"> <a href="adm_newsletters.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a> </div>
<?php


$sqList = " SELECT `id`, `title`, `sent_date` as `date sent`, `sent_copies` as `entries`  FROM `dhub_reg_newsletters` "; 

echo $m2_data->getData($sqList,"adm_newsletters.php?d=$dir&");
		  

?>
