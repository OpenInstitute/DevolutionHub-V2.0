<div style="padding:10px 2px; text-align:right; font-size:14px; font-weight:bold;">
<?php /*?><a href="adm_downloads_multi.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ ADD NEW - Multiple Files ]</a> &nbsp; &nbsp; &nbsp;<?php */?>
<a href="adm_downloads.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ ADD NEW <!--- Single File--> ]</a> </div>
<?php

/*, case when `".$pdb_prefix."dt_downloads_parent`.`id_menu` > 0 then concat('MENU:: ',`".$pdb_prefix."dt_menu`.`title`)
	       when `".$pdb_prefix."dt_downloads_parent`.`id_content` > 0 then concat('CONT.:: ',`".$pdb_prefix."dt_content`.`title`)
	       else NULL end as `parent item`	
, `".$pdb_prefix."dt_downloads`.`resource_file` as `filename`		   
*/
$sqList = "SELECT
    `".$pdb_prefix."dt_downloads`.`resource_id` as `id`
    , `".$pdb_prefix."dt_downloads`.`date_created` AS `posted`
    , `".$pdb_prefix."dt_downloads`.`resource_title` as `title`
    
	, `".$pdb_prefix."dt_downloads`.`county` 	
	, `".$pdb_prefix."dt_downloads`.`content_type` as `category` 	
	, case when `".$pdb_prefix."dt_downloads`.`posted_by` > 0 then concat('USER:: ',`".$pdb_prefix."reg_account`.`email`)
	      else 'ADMIN' end as `posted by`		   
    , `".$pdb_prefix."dt_downloads`.`status` 
   
FROM
    `".$pdb_prefix."dt_downloads`
    LEFT JOIN `".$pdb_prefix."dt_downloads_parent` 
        ON (`".$pdb_prefix."dt_downloads`.`resource_id` = `".$pdb_prefix."dt_downloads_parent`.`resource_id`)
    LEFT JOIN `".$pdb_prefix."dt_menu` 
        ON (`".$pdb_prefix."dt_downloads_parent`.`id_menu` = `".$pdb_prefix."dt_menu`.`id`)
    LEFT JOIN `".$pdb_prefix."dt_content` 
        ON (`".$pdb_prefix."dt_downloads_parent`.`id_content` = `".$pdb_prefix."dt_content`.`id`)
	LEFT JOIN `".$pdb_prefix."reg_account` 
        ON (`".$pdb_prefix."dt_downloads`.`posted_by` = `".$pdb_prefix."reg_account`.`account_id`)
GROUP BY `".$pdb_prefix."dt_downloads`.`resource_id`
ORDER BY `".$pdb_prefix."dt_downloads`.`date_updated` DESC;";

//, `".$pdb_prefix."dt_downloads`.`featured` 

//, , `".$pdb_prefix."dt_downloads`.`id_access` as `access`	   
//, case when `".$pdb_prefix."dt_downloads`.`id_access` = '1' then 'Public' else 'Private'  end as `access`


  echo $m2_data->getData($sqList,"adm_downloads.php?d=$dir&");
		  

?>
