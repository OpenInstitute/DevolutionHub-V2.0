
<div style="padding:2px 2px 10px; text-align:right; font-size:13px; font-weight:bold;"> <a href="adm_users_mailing.php?d=<?php echo $dir; ?>&op=new"  class="btn btn-danger txtwhite">[ New Contact ]</a> </div>
<?php
  
if($dir == 'contacts directory')
{
$sqList = "SELECT
    `dhub_reg_account`.`account_id` as `id`
	, concat_ws(' ',`dhub_reg_account`.`namefirst`, `dhub_reg_account`.`namelast`) as `contact`
    , `dhub_reg_cats`.`title` AS `category`
    , `dhub_reg_account`.`email`
    , `dhub_reg_account`.`phone`
    , `dhub_reg_account`.`date_record` AS `date`
    , `dhub_reg_account`.`country`
    , `dhub_reg_account`.`published` AS `active`
FROM
    `dhub_reg_account`
    LEFT JOIN `dhub_reg_cats_links` 
        ON (`dhub_reg_account`.`account_id` = `dhub_reg_cats_links`.`account_id`)
    LEFT JOIN `dhub_reg_cats` 
        ON (`dhub_reg_cats_links`.`id_category` = `dhub_reg_cats`.`id_category`)
ORDER BY `date` DESC;";

}
elseif($dir == 'registered accounts' or $dir == 'accounts')
{
	/*, DATE_FORMAT(`dhub_reg_account`.`date_created`, '%b%e%Y') AS `ev_date`*/
	$sqList = "SELECT
    `dhub_reg_account`.`account_id` as `id`
	, `dhub_reg_account`.`date_record` AS `date`	
	, concat_ws(' ',`dhub_reg_account`.`namefirst`, `dhub_reg_account`.`namelast`) as `name`
    , `dhub_reg_account`.`email`
    , `dhub_reg_account`.`phone`    
    , `dhub_reg_account`.`country`
	, `dhub_reg_groups`.`group_title` as `user type`
	, `dhub_conf_organizations`.`organization`
	, `dhub_reg_account`.`uservalid` AS `approved`
    , `dhub_reg_account`.`published` AS `active`
FROM
    `dhub_reg_account`
    LEFT JOIN `dhub_reg_cats_links` ON (`dhub_reg_account`.`account_id` = `dhub_reg_cats_links`.`account_id`)
	LEFT JOIN `dhub_conf_organizations`   ON (`dhub_reg_account`.`organization_id` = `dhub_conf_organizations`.`organization_id`)
	LEFT JOIN `dhub_reg_groups` ON (`dhub_reg_account`.`group_id` = `dhub_reg_groups`.`group_id`) 
	GROUP BY `dhub_reg_account`.`account_id`		
ORDER BY `dhub_reg_account`.`date_record` DESC;"; //WHERE (`dhub_reg_cats_links`.`id_category` =2)
}
		//echobr($sqList);	
  
 echo $m2_data->getData($sqList,"#"); /*adm_users_mailing.php?d=$dir&*/
		  
		  

?>
