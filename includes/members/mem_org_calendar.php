<?php
//echobr($op);


?>

<div class="txtright txt14 bold" style="margin-top:-40px;">
<a href="profile.php?ptab=<?php echo $ptab; ?>&op=list" style="color:#FF0000">List View</a> &nbsp; | &nbsp;
<a href="profile.php?ptab=<?php echo $ptab; ?>&op=cal" style="color:#FF0000">Calendar View</a> &nbsp;  &nbsp;
<a href="profile.php?ptab=<?php echo $ptab; ?>&op=new" style="color:#FF0000">[ ADD NEW ]</a> 
</div>

<?php

if($op == 'list') 
{
		echo '<div class="padd5"></div>';
		echo display_PageTitle('List View', 'h3', 'txtgray'); 
	
		$sq_crit = " WHERE `dhub_dt_content`.`id_owner` = ".q_si($us_id)."  "; /*`dhub_dt_content`.`published` = '1' AND */
		$sq_posted_by = "";
		if($us_org_id <> '' and $us_type_id == 1){ }
			$sq_crit .= " OR `dhub_dt_content`.`organization_id` = ".q_si($us_org_id)."  ";
			$sq_posted_by = ", `dhub_reg_account`.`email` as `post by` ";
		
	

		/*,    UNIX_TIMESTAMP(`dhub_dt_content_dates`.`date`) AS `date`*/
		$sq_events_up = "SELECT `dhub_dt_content_dates`.`id_content` as `id`
		, MIN(`dhub_dt_content_dates`.`date`) AS `date`
		, `dhub_dt_content`.`title`
		,  `dhub_dt_content`.`arr_extras` AS `location`
		,  `dhub_dt_content`.`article`
		".$sq_posted_by."
		, `dhub_dt_content`.`approved` as `approved`
    	, `dhub_dt_content`.`published` AS `active`
		FROM
		`dhub_dt_content_dates`
		INNER JOIN `dhub_dt_content` ON (`dhub_dt_content_dates`.`id_content` = `dhub_dt_content`.`id`)
		 LEFT JOIN `dhub_reg_account` ON (`dhub_dt_content`.`id_owner` = `dhub_reg_account`.`account_id`)
		".$sq_crit."
		GROUP BY `dhub_dt_content`.`title`, `dhub_dt_content_dates`.`id_content`
		ORDER BY `dhub_dt_content_dates`.`date` DESC ;";
	 	//echo $sq_events_up;
	
		echo $m2_data->getData($sq_events_up,"profile.php?ptab=".$ptab."&", 1);	
	
}
elseif($op == 'cal') 
{
	echo '<div class="padd5"></div>';
	echo display_PageTitle('Calendar View', 'h3', 'txtgray'); 
	$GLOBALS['CONTENT_SHOW_CALENDAR'] = true;
?>
	<div id="eventCalendarMember"></div>
<?php
}
elseif($op == 'new' or $op == 'edit' or $op == 'view') 
{
	include("includes/members/mem_calendar_form.php");
}
?>