<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;"> <a href="banners.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a> </div>
<?php


		  $sqList = " SELECT `id`, `title`, `description`, `image`,  `seq` as `pos.`, `published` as `show` FROM `dhub_dt_banner` "; //`description`,
		  		
		  echo $m2_data->getData($sqList,"banners.php?d=$dir&");
		  

?>
