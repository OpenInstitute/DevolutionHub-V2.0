<?php require("classes/cls.constants.php"); include("classes/cls.paths.php"); ?>
<?php include("zscript_meta.php"); ?>

<body>
<?php include("includes/wrap_head.php"); ?>



<div>
	
		<div class="page_width">
		<div class="padd15_0">
		
		<div class="subcolumns clearfix">
			
			<?php
				echo display_PageTitle('Organizations / Publishers Directory', '');
				include("includes/nav_organization_filter.php"); 
				include("includes/nav_organization_main.php");
			?>
			
		</div>
		
		<!--
		<div class="subcolumns clearfix" style="overflow:visible;">
			
			<div class="c25l">
				<div class="padd15_r">
				
				<h3></h3>
				<div class="box-cont">
				<div class="box-cont-title">Select Publishers / Organizations</div>
				
				
				<?php 
					include("includes/nav_organization.php");
				?>	


				</div>
			
				</div>
			</div>
		
			<div class="c75r">
				<div class="padd15_l" style="min-height:300px;">
				<div id="wrapper" class="">
				<?php include("includes/nav_downloads-new.php"); ?>
					
				</div>
				</div>
			</div>

		</div>
		-->
		
		</div>
		</div>
	
	
</div>



<?php include("includes/wrap_foot.php"); ?>
<?php include("zscript_vary.php"); ?>

</body>
</html>