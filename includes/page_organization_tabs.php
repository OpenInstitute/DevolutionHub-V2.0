<div class="subcolumns clearfix">
	<div class="tabscontainer" style="position:relative;">
			
		<div class="navcontainer">
		<ul>
			<li><a id="tab_resources" class="orgtab active" data-id="sf_resources">Resources</a></li>
			<li><a id="tab_events" class="orgtab" data-id="sf_events">Events</a></li>
		</ul>
		</div>
	
		<div class="tabsloader orgtabloader" style="display:">
				<div class="txtcenter"><img src="image/icons/a-loader.gif" alt="loading..." /></div>			
		</div>
		
		<div class="tabscontent" id="wrap_ftfeeds">
			<div id="feed_sf_resources" class="orgtabcontent padd5">
				<div>
					<?php include("includes/nav_downloads-new.php"); ?>
				</div>
			</div>
			<div id="feed_sf_events" class="orgtabcontent padd5" style="display:none">				
					<?php include("includes/page_organization_events.php"); ?>
			</div>						
		</div>
				
	</div>
	</div>

<script type="text/javascript">
jQuery(document).ready(function($){
	var dhubOrgTab = localStorage.getItem('dhubOrgTab');
	if(dhubOrgTab){ loadActiveOrgTab(dhubOrgTab); }	
	
	jQuery(".orgtab").click(function() {	
		tabElemId = jQuery(this).attr("id"); localStorage.setItem('dhubOrgTab', tabElemId); loadActiveOrgTab(tabElemId);
		/*jQuery(".orgtabloader").show();tabDataId = jQuery(this).attr("data-id"); jQuery(".orgtab").removeClass("active");$(this).addClass("active");		jQuery(".orgtabcontent").css("display","none");jQuery("#feed_"+tabDataId).css("display","block");		jQuery(".orgtabloader").hide();	*/
		return false;
	});

});
	
function loadActiveOrgTab(tabId){
	jQuery(document).ready(function($){
		jQuery(".orgtabloader").show();
		tabDataId = jQuery("#"+tabId).attr("data-id");		
		jQuery(".orgtab").removeClass("active");
		$("#"+tabId).addClass("active");		
		jQuery(".orgtabcontent").css("display","none");
		jQuery("#feed_"+tabDataId).css("display","block");		
		jQuery(".orgtabloader").hide();		
	});
}	

</script>
