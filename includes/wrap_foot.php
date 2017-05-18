
<?php if($this_page<> 'profile.php'){ ?>


<div class="page_width">
<div class="padd15_t">
<div class="subcolumns clearfix">
	
	
	<div class="col-md-4 padd0_l">
		<?php echo display_PageTitle('Get in Touch', 'h3', 'txtgray linegray '); ?>
		<div class="padd10_b">
			Kaya I/O,<br>Statehouse Road <br>Hillcrest Building, Next to Philippines Embassy<br> P.O. Box 76203 – 00508 Nairobi, Kenya			
		</div>
		
		<div>
		
			<div class="padd5_b col-md-6"><a href="https://www.twitter.com/DevolutionHub" title="Twitter" class=""><i class="fa fa-twitter btn tw_icon social_icon"></i> @DevolutionHub</a></div>
			<div class="padd5_b col-md-6"><a href="https://github.com/OpenInstitute" title="Github" class=""><i class="fa fa-github btn github_icon social_icon" style="background:#ccc;"></i> Open Institute Github </a></div>
			<div class="padd5_b col-md-6"><a href="https://www.youtube.com/channel/UC2xe-UTLYNS5AqTuFtat-Bg" title="YouTube" class=""><i class="fa fa-youtube-play btn yt_icon social_icon"></i> Devolution Hub</a></div>
			<div class="padd5_b col-md-6"><a href="mailto:info@devolutionhub.or.ke" title="Email" class=""><i class="fa fa-envelope btn mail_icon social_icon"></i> info@devolutionhub.or.ke</a></div>
		</div>
	</div>
	
	
	
	<div class="col-md-4 padd0_l">
		<?php
		/*if($my_redirect == 'index.php'){ include("includes/nav_quicklinks.php"); }
		else {  }*/
		include("includes/nav_social_feeds_tabs.php");
		?>
	</div>
	
	
	<div class="col-md-4 nopadd pull-right">
		<?php //echo display_PageTitle('Contribute A Resource', 'h3', 'txtgray linegray '); ?>
		<div class="subcolumns clearfix">
			<?php include("includes/wrap_foot_tabs.php"); ?>
		</div>
	</div>
</div>
</div>
</div>
<?php } ?>



<div class="clearfix">
	
	<div class="head_width" style="background:#4A4949;">
	<div class="">
		
		<div class="subcolumns txt95 padd10_t">
			
			<div class="c38lX col-md-7">		
				<div class="padd10_t padd15_b txtwhite">
					<?php if($GLOBALS['SOCIAL_CONNECT'] == true) {  ?>      
					<p>
						<a rel="license" href="http://creativecommons.org/licenses/by/4.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by/4.0/80x15.png" /></a><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title"> Devolution Hub</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://openinstitute.com" property="cc:attributionName" rel="cc:attributionURL">Open Institute</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/4.0/">Creative Commons Attribution 4.0 International License</a>
					  </p>
					  
					<?php } ?>
				  </div>
			</div>
			
			<div class="c62rX col-md-5">
			<div>
				<div class="nav_foot_sml padd10">
				<ul id="nav_foot"> 
				<?php echo $dispData->buildMenu_Main($com_active, 5, 0, 'nav_foot'); //$nav_FootLinks; ?> 
				</ul>				
				</div>	
			</div>
			</div>
			
			
			
		</div>
		
		
		
		
		
	</div>
	</div>
</div>

<!-- @end:: page-container -->
</div>



<!-- off-canvas -->
<div id="offcanvas" class="uk-offcanvas">
	<div class="uk-offcanvas-bar">
		<div class="canvas-menu">
			<div class="canvas-search padd10_5"></div>
			<?php echo '<ul class="uk-nav-offcanvas">'.$nav_head_main.$nav_head_side.'</ul>'; ?>
		</div>			
	</div>
</div>