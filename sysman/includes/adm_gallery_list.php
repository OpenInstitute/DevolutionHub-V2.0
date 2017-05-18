<div style="padding:5px; text-align:right; font-size:14px; font-weight:bold;"> <a href="gallery.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a> </div>
<?php


		  $sqList = QRY_GALLERY_LIST . " ORDER BY      `dhub_dt_gallery_photos`.`id_gallery` ASC, `pos.` ASC, `modified` DESC"; 
		
		 echo $m2_data->getData($sqList,"gallery.php?d=$dir&");
		  

?>
