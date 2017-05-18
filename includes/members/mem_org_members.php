<?php

if($op == 'list')
{
?>
	<div class="txtright txt14 bold" style="margin-top:-40px;"><a href="profile.php?ptab=<?php echo $ptab; ?>&op=new" style="color:#FF0000" >[ ADD NEW ]</a> </div>
	<div class="padd10"></div>
	<?php
 
  	$sqList = "	SELECT
    `dhub_reg_account`.`account_id` as `id`
    , concat_ws(' ', `dhub_reg_account`.`namefirst`, `dhub_reg_account`.`namelast`) as `name`
    , `dhub_reg_account`.`email`
    , `dhub_reg_account`.`phone`
	, `dhub_reg_groups`.`group_title` as `user level`
    , `dhub_reg_account`.`published` AS `active`
    , `dhub_reg_account`.`organization_id`
    
FROM
    `dhub_reg_account`
    LEFT JOIN `dhub_reg_groups` 
        ON (`dhub_reg_account`.`group_id` = `dhub_reg_groups`.`group_id`)
WHERE (`dhub_reg_account`.`organization_id` = ".q_si($us_org_id).");";
	
 	//echo $sqList;
	echo $m2_data->getData($sqList,"profile.php?ptab=".$ptab."&", 0);	
}
elseif($op == 'edit' or $op == 'view' or $op == 'new')
{
	include("includes/members/mem_org_members_form.php");
}
?>
