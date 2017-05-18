<style type="text/css">
	.logo_box img{max-width: 80%; max-height: 60px;}
</style>

<!-- @beg:: page-container -->
<div class="page_margins<?php if($my_redirect == 'index.php') { echo " home"; } else { echo " pg-inside";} ?>">


<div style="position:relative" class="clearfixX">
<!-- @beg:: alert -->	
<?php if($this_page <> 'result.php') {  include("includes/wrap_alert.box.php"); } ?>
<!-- @end :: alert -->

	<div class="wrap_headX" style="background:#252525">
	<div class="head_width" >
			
		
		<div class="subcolumns clearfix showall" style="height:70px;">
			
				<div class="c33l">
					
					<div class="logo_wrap">
						<a href="./?tk=<?php echo time(); ?>" title="<?php echo SITE_TITLE_LONG; ?>">
						<div class="logo_box" style="height:70px; overflow:hidden ">
						<img src="<?php echo SITE_LOGO; ?>" alt="<?php echo SITE_TITLE_LONG; ?>" id="logo-img"  />
						</div>
						</a>
						<!--<div class="logo_b"></div>-->
					</div>
					
				</div>
			
			
				<div class="c66r" style="">
				
					<?php //include("includes/nav_head.php"); ?>
				</div>
			
		</div>
		
			
	</div>
	</div>
	
	
	<div class="clearfix">
	<div class="" style="background:#333333;border-bottom:0px solid #ddd; ">
	<div class="head_width" >
			
		
		<div class="subcolumns clearfix showall" style="height:42px;">
			
				<div class="col-md-7">				
					<div style="position:relative;">						
						<?php include("includes/nav_head_mega.php"); ?>
						<a href="#offcanvas" id="at-navbar" class="uk-navbar-toggle float-right"></a>
					</div>
				</div>
			
			
				<div class="col-md-5">
					<?php include("includes/nav_head.php"); ?>
				</div>
				
		</div>
		
			
	</div>
	</div>
	</div>


</div>

<?php //include("includes/nav_crumbs.php"); ?>







