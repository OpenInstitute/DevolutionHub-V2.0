<?php
//echobr($us_id);
if($op == 'list')
{
?>
	<?php if($us_type_id <> 2){ ?>
	<div class="txtright txt14 bold" style="margin-top:-40px;">
	<a href="profile.php?ptab=<?php echo $ptab; ?>&op=new" style="color:#FF0000" >[ ADD NEW ]</a> 
	</div>
	<?php } ?>
	
	
	<div class="padd10"></div>
	<?php
 
 	$sq_crit = " WHERE `dhub_dt_downloads`.`posted_by` = ".q_si($us_id)."  "; /*`dhub_dt_content`.`published` = '1' AND */
	$sq_posted_by = "";
	if($us_org_id <> '' and $us_type_id == 1){
		$sq_crit .= " OR `dhub_dt_downloads`.`organization_id` = ".q_si($us_org_id)."  ";
		$sq_posted_by = ", `dhub_reg_account`.`email` as `post by` ";
	}
 
 /*`resource_file` as `filename`,*/
 
	$sqList = "SELECT `dhub_dt_downloads`.`resource_id` as `id`, `dhub_dt_downloads`.`date_created` as `date`, `dhub_dt_downloads`.`resource_title` as `title`, `dhub_dt_downloads`.`resource_description` as `description` ".$sq_posted_by.",  `dhub_dt_downloads`.`status` FROM `dhub_dt_downloads` LEFT JOIN `dhub_reg_account` ON (`dhub_dt_downloads`.`posted_by` = `dhub_reg_account`.`account_id`) ".$sq_crit." order by  `dhub_dt_downloads`.`date_updated` desc; ";
 
 	$sqList = "SELECT
    `dhub_dt_downloads`.`resource_id`
    , `dhub_dt_downloads`.`date_created` AS `date`
    , `dhub_dt_downloads`.`resource_title` AS `title`
    , `dhub_dt_downloads`.`resource_description` as `description`
	, concat_ws(' ', `dhub_reg_account`.`namefirst`, `dhub_reg_account`.`namelast`) as `posted by`
    , `dhub_dt_downloads`.`status`
	, `dhub_dt_downloads`.`access_id` as `access`
    , `dhub_dt_downloads_parent`.`organization_id`	
    
FROM
    `dhub_dt_downloads`
    INNER JOIN `dhub_dt_downloads_parent` 
        ON (`dhub_dt_downloads`.`resource_id` = `dhub_dt_downloads_parent`.`resource_id`)
    LEFT JOIN `dhub_reg_account` 
        ON (`dhub_dt_downloads`.`posted_by` = `dhub_reg_account`.`account_id`)
WHERE (`dhub_dt_downloads_parent`.`organization_id` = ".q_si($us_org_id).");";
 
 	/*, case when (`dhub_dt_downloads`.`access_id` = 1) then 'Public' else 'Private' end as `access_id`*/
	echo $m2_data->getData($sqList,"profile.php?ptab=".$ptab."&", 1);	
}
elseif($op == 'edit' or $op == 'view' or $op == 'new')
{
	include("includes/members/mem_resources_form.php");
}
?>
