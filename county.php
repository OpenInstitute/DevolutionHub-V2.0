<?php require("classes/cls.constants.php"); include("classes/cls.paths.php"); ?>
<?php include("zscript_meta.php"); ?>

<body>
<?php include("includes/wrap_head.php"); ?>



<div>
	
		<div class="page_width">
		<div class="padd15_0">
		<div class="subcolumns clearfix" style="overflow:visible;">
			
			<div class="c25l">
				<div class="padd15_r">
				
				<h3></h3>
				<div class="box-cont">
				<div class="box-cont-title">Featured Categories</div>
				
				<ul class="nav_side">
				<?php 
				$sq_d = "SELECT `content_type`, count(*) as `tdocs` FROM `dhub_dt_downloads`  WHERE `county` like ".q_si($county)." GROUP BY `content_type`;"; 
				$rs_d = $cndb->dbQueryFetch($sq_d);
				foreach($rs_d as $c => $carr){
				echo '<li><a href="county.php?com=5&formname=tag&county='.$county.'&dir_type='.$carr['content_type'].'" >'.$carr['content_type'].' <span class="txtwhite">['.$carr['tdocs'].']</span></a> </li> ';
				}	
				?>	
				</ul>


				</div>
			
				</div>
			</div>
		
			<div class="c75r">
				<div class="padd15_l" style="min-height:300px;">
				<div id="wrapper" class="">
				<?php
					//displayArray($_SESSION['sess_dhub_member']);
				?>
					<!--<h2>County Resources</h2>-->
					<?php //include("includes/nav_downloads-main.php"); ?>
					<?php include("includes/nav_downloads-new.php"); ?>
					
				</div>
				</div>
			</div>

		

		</div>
		</div>
		</div>
	
	
</div>



<?php include("includes/wrap_foot.php"); ?>
<?php include("zscript_vary.php"); ?>

</body>
</html>