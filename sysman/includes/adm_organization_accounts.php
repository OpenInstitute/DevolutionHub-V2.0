<?php /*
<div class="subcolumns clearfix">
	<div class="tabscontainer" style="position:relative;">
			
		<div class="navcontainer">
		<ul>
			<li><a id="tab_mailing" class="fttab active" data-id="sf_mailing">Subscribe for Updates</a></li>
			<li><a id="tab_contribute" class="fttab" data-id="sf_contribute">Contribute A Resource</a></li>
		</ul>
		</div>
	
		<div class="tabsloader fttabloader" style="display:">
				<div class="txtcenter"><img src="image/icons/a-loader.gif" alt="loading..." /></div>			
		</div>
		
		<div class="tabscontent" id="wrap_ftfeeds">
			<div id="feed_sf_mailing" class="fttabcontent padd5">
				<div> mailing</div>
			</div>
			<div id="feed_sf_contribute" class="fttabcontent padd5" style="display:none">	
				contribute
			</div>						
		</div>
				
	</div>
	</div>

<script type="text/javascript">
jQuery(document).ready(function($){
	
	jQuery(".fttab").click(function()
	{	
		jQuery(".fttabloader").show();
		tabId = jQuery(this).attr("data-id");		
		jQuery(".fttab").removeClass("active");
		$(this).addClass("active");		
		jQuery(".fttabcontent").css("display","none");
		jQuery("#feed_"+tabId).css("display","block");		
		jQuery(".fttabloader").hide();	
		return false;
	});

});

</script>
*/
	?>

<div class="padd10_t">
	<div class="clearfix padd10_0">
	
	<div class="col-md-8">
		<h4>Organization Members</h4>
	</div>
	<div class="col-md-4">
		<div class="padd10_t txtright bold">
			<a href="hforms.php?d=member accounts&op=new&org_id=<?=$id?>" style="color:#FF0000" target="_blank">[ ADD NEW ]</a> 
		</div>	
 	</div>	
 	</div>
<?php

$sqList = "SELECT
    `dhub_reg_account`.`account_id` as `id`
    , concat_ws(' ',`dhub_reg_account`.`namefirst`, `dhub_reg_account`.`namelast`) as `name`
    , `dhub_reg_account`.`email` as `email address`
    , `dhub_reg_groups`.`group_title` as `user type`
    , `dhub_reg_account`.`published` AS `active`
FROM
    `dhub_reg_account`
    INNER JOIN `dhub_reg_groups` 
        ON (`dhub_reg_account`.`group_id` = `dhub_reg_groups`.`group_id`)
WHERE (`dhub_reg_account`.`organization_id` = ".quote_smart($id).")
ORDER BY `dhub_reg_groups`.`group_title` ASC;";

			   //getData($disp_query, $redirect, $disp_front = 0, $title_trunc = 80, $id_label = "id", $blank=0) 
	echo $m2_data->getData($sqList,"hforms.php?d=member accounts&", 0, 80, 'id', 1);

?>


</div>




<div class="padd10_t">
	<!--<div class="padd10_0"><h4>Organization Events</h4></div>-->

<?php

$sqListEvents = "SELECT
    `dhub_reg_account`.`account_id` as `id`
    , concat_ws(' ',`dhub_reg_account`.`namefirst`, `dhub_reg_account`.`namelast`) as `name`
    , `dhub_reg_account`.`email` as `email address`
    , `dhub_reg_groups`.`group_title` as `user type`
    , `dhub_reg_account`.`published` AS `active`
FROM
    `dhub_reg_account`
    INNER JOIN `dhub_reg_groups` 
        ON (`dhub_reg_account`.`group_id` = `dhub_reg_groups`.`group_id`)
WHERE (`dhub_reg_account`.`organization_id` = ".quote_smart($id).")
ORDER BY `dhub_reg_groups`.`group_title` ASC;";

	//echo $m2_data->getData($sqListEvents,"hforms.php?d=member accounts&");

?>


</div>