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
				<div>
					<?php include("includes/form.mailing-sm.php"); ?>
				</div>
			</div>
			<div id="feed_sf_contribute" class="fttabcontent padd5" style="display:none">				
					<?php include("includes/form.contribute.php"); ?>
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
