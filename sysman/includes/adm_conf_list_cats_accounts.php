<div style="padding:5px; text-align:right; font-size:14px; font-weight:bold;"> <a href="hforms.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ ADD NEW ]</a> </div>
<?php


	  
	 $sqList = "SELECT 
      `dhub_reg_cats`.`id_category` as `id`, `dhub_reg_cats`.`title`,  `dhub_reg_cats`.`description`,
	  case when `dhub_reg_cats`.`system_cat` = 1 then 'No' else 'Yes' end as `public access`, Count( `dhub_reg_cats_links`.`account_id`) AS `entries`, `dhub_reg_cats`.`published` AS `active`
   FROM 
      (`dhub_reg_cats` LEFT JOIN `dhub_reg_cats_links` ON `dhub_reg_cats`.`id_category`=`dhub_reg_cats_links`.`id_category`)
   GROUP BY 
      `dhub_reg_cats`.`id_category`, `dhub_reg_cats`.`title`
	   ORDER BY 
		 `entries` DESC, `dhub_reg_cats`.`title` ASC "; 
	  
	  
		 echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
		  

?>
